<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantRecipes;
use App\Models\Warehouse\Tenants\TenantVendor;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class TenantRecipesController extends Controller
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

        $recipes = TenantRecipes::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.inventory.recipes.index', ['recipes' => $recipes]);
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
        //     $VendorInformation = Vendor::where('warehouse_id', $this->warehouse->id)->latest()->get();

        // $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        // $contactOptions = $contactInformation->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();
        // $VendorOptions = $VendorInformation->mapWithKeys(fn ($Vendor) => [$Vendor->id => $Vendor->formatted()])->toArray();

        return view("warehouse.vendor.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the vendor details which are always required
        $VendorData = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'payment_terms' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ]);

        // Validate and possibly create/fetch address and contact based on the request
        // $address = $this->validateAndCreateOrFetchAddress($request);
        // $contactInformation = $this->validateAndCreateOrFetchContact($request);
        // $parentVendor = $this->validateAndFetchParentVendor($request);


        // Merging additional data
        $data = array_merge($VendorData, [
            'is_active' => 1,
            // 'parent_Vendor_id' => $parentVendor ? $parentVendor->id : null,
            // 'Vendor_address_id' => $address ? $address->id : null,
            // 'Vendor_contact_id' => $contactInformation ? $contactInformation->id : null,
            'warehouse_id' => $this->warehouse->id,
        ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $Vendor = TenantVendor::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Vendor \'' . $Vendor->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.vendor.index')->with('success', "Successfully created a new Vendor");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Vendor. Error: ' . $e->getMessage())->withInput();
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
            // Find the Vendor in the current schema
            $vendor = TenantVendor::on('tenant')->find($id);

            if (! $vendor) {
                return redirect()->back()->with('error', 'Failed to remove Vendor. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the Vendor instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Vendor \'' . $vendor->name . '\'', $this->user->id, $this->warehouse));
            $vendor->delete();

            Log::info("Vendor deleted: " . $vendor->id);


            // $Vendor->delete();

            DB::commit();
            return redirect()->route('warehouse.vendor.index')->with('success', "Successfully removed the Vendor from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Vendor. Error: ' . $e->getMessage())->withInput();
        }
    }
}
