<?php

namespace App\Http\Controllers\Warehouse\Tenants\Recipe;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipeBoxPackaging;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantRecipeBoxPackagingController extends Controller
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

        $packagings = TenantRecipeBoxPackaging::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.tenants.inventory.recipes.box.index', ['packagings' => $packagings, 'warehouse' => $this->warehouse]);
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
        //     $PackagingInformation = Packaging::where('warehouse_id', $this->warehouse->id)->latest()->get();

        // $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        // $contactOptions = $contactInformation->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();
        // $PackagingOptions = $PackagingInformation->mapWithKeys(fn ($Packaging) => [$Packaging->id => $Packaging->formatted()])->toArray();

        return view("warehouse.tenants.inventory.recipes.box.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the packaging details which are always required
        $packaging = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric'
        ]);


        // // Merging additional data
        // $data = array_merge($PackagingData, [
        //     // 'is_active' => 1,

        //     'warehouse_id' => $this->warehouse->id,
        // ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $packaging = TenantRecipeBoxPackaging::on('tenant')->create($packaging);

            dispatch(new WriteAuditLogJob('created', 'Created Packaging \'' . $packaging->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.recipes.box.index')->with('success', "Successfully created a new Packaging");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Packaging. Error: ' . $e->getMessage())->withInput();
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
            // Find the Packaging in the current schema
            $packaging = TenantRecipeBoxPackaging::on('tenant')->find($id);

            if (! $packaging) {
                return redirect()->back()->with('error', 'Failed to remove Packaging. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the Packaging instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Packaging \'' . $packaging->name . '\'', $this->user->id, $this->warehouse));
            $packaging->delete();

            Log::info("Packaging deleted: " . $packaging->id);


            // $Packaging->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.recipes.box.index')->with('success', "Successfully removed the Packaging from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Packaging. Error: ' . $e->getMessage())->withInput();
        }
    }
}
