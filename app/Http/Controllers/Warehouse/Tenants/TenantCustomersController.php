<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantCustomer;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class TenantCustomersController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Eager load related data (e.g., 'contacts', 'addresses') and implement pagination
        $customers = TenantCustomer::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page

        return view('warehouse.customer.index', ['customers' => $customers, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch Address
        // Fetch Contact Information
        //    $addresses = Address::where('warehouse_id', $this->warehouse->id)->latest()->get();
        //     $contactInformation = Contact::where('warehouse_id', $this->warehouse->id)->latest()->get();
        //     $customerInformation = TenantCustomer::where('warehouse_id', $this->warehouse->id)->latest()->get();

        // $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        // $contactOptions = $contactInformation->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();
        // $customerOptions = $customerInformation->mapWithKeys(fn ($customer) => [$customer->id => $customer->formatted()])->toArray();

        return view("warehouse.customer.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the vendor details which are always required
        $customerData = $request->validate([
            'name' => 'required|string|max:255',
            'payment_terms' => 'required|string|max:255'
        ]);

        // Validate and possibly create/fetch address and contact based on the request
        // $address = $this->validateAndCreateOrFetchAddress($request);
        // $contactInformation = $this->validateAndCreateOrFetchContact($request);
        // $parentCustomer = $this->validateAndFetchParentCustomer($request);


        // Merging additional data
        $data = array_merge($customerData, [
            'is_active' => 1,
            // 'parent_customer_id' => $parentCustomer ? $parentCustomer->id : null,
            // 'customer_address_id' => $address ? $address->id : null,
            // 'customer_contact_id' => $contactInformation ? $contactInformation->id : null,
            'warehouse_id' => $this->warehouse->id,
        ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $customer = TenantCustomer::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Customer \'' . $customer->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.customer.index')->with('success', "Successfully created a new customer");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create customer. Error: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // dd("hi");
        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            // dd($id);
            // Find the customer in the current schema
            $customer = TenantCustomer::on('tenant')->find($id);

            if (! $customer) {
                return redirect()->back()->with('error', 'Failed to remove customer. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the customer instance is correct
            Log::info("Deleting customer: " . $customer->id);

            $customer->delete();

            Log::info("Customer deleted: " . $customer->id);


            dispatch(new WriteAuditLogJob('deleted', 'Removed Customer \'' . $customer->name . '\'', $this->user->id, $this->warehouse));
            // $customer->delete();

            DB::commit();
            return redirect()->route('warehouse.customer.index')->with('success', "Successfully removed the customer from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove customer. Error: ' . $e->getMessage())->withInput();
        }
    }
}
