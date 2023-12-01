<?php

namespace App\Http\Controllers\Warehouse;


use App\Http\Controllers\Controller;
use App\Jobs\AddWarehouseUser;
use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantAuditLog;
use App\Models\Warehouse\Users\WarehouseUserInvitations;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\WarehouseUsers;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class WarehouseController extends Controller
{

    // Property to store the authenticated user and warehouse
    protected $user;
    protected $warehouse;
    protected $tenantService;


    // // Constructor to set up middleware and cache the authenticated user and warehouse
    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
        $this->middleware(function ($request, $next) {
            // Cache the authenticated user for reuse in other methods
            $this->user = auth()->user();
            $this->warehouse = $this->user->activeWarehouse;
            return $next($request);
        });
    }



    /**
     * Display a listing of warehouses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch warehouses owned by the authenticated user
        $warehouses = Warehouse::where('warehouse_owner_id', $this->user->id)->latest()->get();

        // Fetch warehouses where the authenticated user is an employee
        $warehouseEmployeeOf = $this->getEmployeeWarehouses();


        // // Fetch pending warehouse invitations for the authenticated user
        $warehouseUserInvitations = warehouseUserInvitations::where('email', $this->user->email)
            ->where('status', 'pending')
            ->get();



        return view('warehouse.index', ['warehouse' => $warehouses, 'warehouseEmployeeOf' => $warehouseEmployeeOf, 'user' => $this->user, 'warehouseUserInvitations' => $warehouseUserInvitations]);
    }

    /**
     * Helper method to fetch warehouses where the authenticated user is an employee.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getEmployeeWarehouses()
    {
        return Warehouse::with(['warehouseUsers' => function ($query) {
            $query->where('user_id', $this->user->id)->with('role');
        }])->whereHas('warehouseUsers', function ($query) {
            $query->where('user_id', $this->user->id);
        })->get();
    }



    /**
     * Show the form for creating a new warehouse.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('warehouse.create');
    }


    /**
     * Update an existing warehouse.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate incoming request data
        $validated = $this->validateWarehouseData($request);

        // Fetch the user's active warehouse
        $warehouse = $this->user->activeWarehouse;
        $oldWarehouseName = $warehouse->name;
        if (! $warehouse) {
            return redirect()->back()->with('error', 'No associated warehouse found.');
        }

        // Update the warehouse details
        if (! $warehouse->update($validated)) {
            return redirect()->back()->with('error', 'Failed to update the warehouse.');
        }

        $result = WriteAuditLogJob::dispatch('updated', 'Updated warehouse name from \'' . $oldWarehouseName . '\' to \'' . $warehouse->name . '\'', $this->user->id, $warehouse->schema_name);

        // \dd($result);
        return redirect()->route('warehouse.edit')->with('success', 'The changes you made to this warehouse have been saved!');
    }



    /**
     * Show the form for editing a warehouse.
     *
     * @param  \App\Models\Warehouse\Warehouse $warehouse
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Warehouse $warehouse)
    {
        $warehouse = $this->user->activeWarehouse;

        // if (! $warehouse) {
        //     return redirect()->back()->with('error', 'No associated warehouse found.');
        // }

        // // Fetch pending invitations for the current warehouse
        $warehouseUserInvitations = WarehouseUserInvitations::where('warehouse_id', $warehouse->id)->where('status', 'pending')->get();

        return view('warehouse.edit', ['warehouse' => $warehouse, 'warehouseUserInvitations' => $warehouseUserInvitations]);
    }


    /**
     * Store a newly created wa1rehouse in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validateData = $this->validateWarehouseData($request);

        // Delegate this out to a job/queue

        //  \App\Jobs\CreateWarehouseJob::dispatch($validateData);

        Log::info("CreateWarehouseJob // started for the user id {$this->user->id}");
        DB::beginTransaction();

        try {

            // Assume 'tenantData' contains necessary information like 'name', 'schema', etc.
            $warehouseName = $validateData['name'];
            // Generate a UUID for the schema name
            $schemaName = Str::uuid()->toString();

            // Create the warehouse record
            $warehouse = Warehouse::create([
                'name' => $warehouseName,
                'schema_name' => $schemaName, // Use the generated UUID
                'subdomain' => null,
                'primary_email' => 'null',
                'warehouse_owner_id' => $this->user->id
            ]);

            // Set the connection to the tenant's schema
            $schemaNameQuoted = '"' . $schemaName . '"';
            DB::connection('tenant')->statement('CREATE SCHEMA IF NOT EXISTS ' . $schemaNameQuoted);

            Config::set('database.connections.tenant.search_path', $schemaNameQuoted);

            // Refresh the connection with new settings
            DB::purge('tenant');
            // Config::set('database.connections.tenant.schema', $schemaName);
            DB::reconnect('tenant');


            // Run the migrations for the tenant's database
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenants',
            ]);


            WarehouseUsers::create([
                'user_id' => $this->user->id,
                'warehouse_id' => $warehouse->id,
                'role_id' => null, // You need to determine how to set this
                'is_active' => true,
            ]);

            // Set the user's active schema to the new warehouse's schema
            $this->user->active_schema = $warehouse->id;
            $this->user->save();

            // dispatch(new WriteAuditLogJob('created', 'Added user \'' . $this->user->name . '\' to the warehouse \'' . $warehouse->name . '\'', $this->user->id, $warehouse->schema_name));

            // dispatch(new AddWarehouseUser($this->user, $warehouse, null));
            // dispatch(new WriteAuditLogJob('created', 'Created Warehouse \'' . $warehouse->name . '\'', $this->user->id, $warehouse->schema_name));

            // Maybe dispatch an event after completion
            // event(new CreateWarehouseEvent($this->tenantData));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            DB::connection('tenant')->statement('DROP SCHEMA IF EXISTS ' . $schemaNameQuoted . ' CASCADE');

            Log::error('CreateWarehouseJob // Error in CreateWarehouseJob: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.index')->with('success', 'You have created a new warehouse!');
    }



    /**
     * Helper method to validate incoming warehouse data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function validateWarehouseData(Request $request)
    {
        return $request->validate([
            'name' => 'required|min:3|max:255',
            'primary_email' => 'email',
            'description' => 'max:255',
        ]);
    }


    /**
     * Activate a specific warehouse for the authenticated user.
     *
     * @param  \App\Models\Warehouse\Warehouse  $warehouse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Warehouse $warehouse)
    {
        // Update the user's active warehouse
        $this->user->update(['active_schema' => $warehouse->id]);

        return redirect()->back()->with('success', 'Your active warehouse has been updated to ' . $warehouse->name . '!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // BAD PRACTICE LOL
        Log::info("Warehouse delete initiated by user id {$this->user->id} for warehouse {$warehouse->name}");
        DB::beginTransaction();

        try {
            // Retrieve associated users
            $warehouseUsers = $warehouse->warehouseUsers; // Assuming a users() relationship exists

            // Delete or update associated users
            foreach ($warehouseUsers as $user) {
                // check if the users current schema is equal to the one being deleted
                if ($warehouse->schema_name == $user->active_schema) {
                    $user->update(['active_schema' => null]);
                }


                // Soft delete the warehouse warehouseUser
                $user->delete();
                // Delete the user or remove the warehouse association based on your application logic
                // $user->delete(); or $user->update(['warehouse_id' => null]);
            }


            // Set the connection to the warehouse's schema
            $this->tenantService->setConnection($warehouse->schema_name);

            // Delete the warehouse record

            // Drop the schema safely
            // $schemaName = DB::connection('tenant')->getPdo()->quote($warehouse->schema_name);
            $schemaNameQuoted = '"' . $warehouse->schema_name . '"';

            DB::connection('tenant')->statement("DROP SCHEMA IF EXISTS {$schemaNameQuoted} CASCADE");

            $warehouse->delete();


            // Clear the user's active schema
            // $this->user->active_schema = null;
            $this->user->save();

            // dispatch(new WriteAuditLogJob('deleted', 'Deleted Warehouse \'' . $warehouse->name . '\'', $this->user->id, $warehouse->schema_name));

            DB::commit();
            $successMessage = 'The warehouse has been deleted successfully.';
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in warehouse deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete warehouse. Error: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('dashboard.index')->with('success', $successMessage);

        // @TODO: 
        // Check that the user of this warehouse is the owner

        // queue the warehouse to be deleted in 30 minutes

        // return and notify that will be deleted in 30 mins. provide option to cancel deletion
    }



    public function indexAuditLogs()
    {


        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Eager load related data (e.g., 'contacts', 'addresses') and implement pagination
        $auditLogs = TenantAuditLog::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.tenants.logs.index', ['logs' => $auditLogs]);
    }

}
