<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantInventory;
use App\Models\Warehouse\Tenants\TenantVendor;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TenantInventoryController extends Controller
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

        $inventory = TenantInventory::on('tenant')
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.tenants.inventory.index', ['inventoryItems' => $inventory, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // fetch a list of all vendors
        $vendorOptions = TenantVendor::on('tenant')->latest()->get();
        $itemOptions = TenantInventory::on('tenant')->latest()->get();

        $vendors = $vendorOptions->mapWithKeys(fn ($vendor) => [$vendor->id => $vendor->formatted()])->toArray();
        $items = $itemOptions->mapWithKeys(fn ($item) => [$item->id => $item->formatted()])->toArray();

        // fetch a list of all inventory items 
        // $TenantInventory = TenantInventory::on('tenant')->create($data);

        return view("warehouse.tenants.inventory.create", ['warehouse' => $this->warehouse, 'vendors' => $vendors, 'items' => $items]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'vendor_item_name' => 'required|string|max:255',
                'cost' => 'required|numeric',
                'item_type' => ['required', Rule::in(TenantInventory::$itemType)],
                'item_dirty_level' => ['required', Rule::in(TenantInventory::$itemDirtyLevel)],
                'item_trk_option' => ['required', Rule::in(TenantInventory::$itemTrkOption)],
                'item_valuation_method' => ['required', Rule::in(TenantInventory::$itemValuationMethod)],
                'item_unit_of_measure' => ['required', Rule::in(TenantInventory::$itemUnitOfMeasure)],
                'item_purchase_tax_option' => ['required', Rule::in(TenantInventory::$itemPurchaseTaxOptions)],
                // 'sub_item_id' => 'exists:tenant.tenant_inventories,id',
                // 'vendor_id' => 'exists:tenant.tenant_vendor,id',
                'is_active' => 'required|boolean'
            ]);

            // dd($request);
            $subItemId = $this->validateAndFetchSubtituteItem($request);
            $vendorId = $this->validateAndFetchVendor($request);

            $data = array_merge($validatedData, [
                'sub_item_id' => $subItemId ? $subItemId->id : null,
                'vendor_id' => $vendorId ? $vendorId->id : null,
            ]);
            // dd($data);

            $TenantInventory = TenantInventory::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Inventory Item \'' . $TenantInventory->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.index')->with('success', "Successfully created a new Inventory Item");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Inventory Item. Error: ' . $e->getMessage())->withInput();
        }
    }

    private function validateAndFetchSubtituteItem($request)
    {
        // Determine the contact choice
        $parentItemChoice = $request->input('parent_item_choice');

        // Handle creation of a new contact
        if ($parentItemChoice === 'select') {
            $selectedParentItemId = $request->input('sub_item_id');
            if ($selectedParentItemId) {
                $item = TenantInventory::on('tenant')->find($selectedParentItemId);
                if (! $item) {
                    throw new \Exception('Selected substitute item not found.');
                }
                return $item;
            }
        }
        return null;
    }

    private function validateAndFetchVendor($request)
    {

        // Determine the contact choice
        $vendorChoice = $request->input('vendor_choice');

        // Handle creation of a new contact
        if ($vendorChoice === 'select') {

            $selectedVendorId = $request->input('selected_vendor_id');
            if ($selectedVendorId) {

                $vendor = TenantVendor::on('tenant')->find($selectedVendorId);
                // dd($selectedVendorId, $vendor);
                // dd($selectedVendorId);
                if (! $vendor) {
                    throw new \Exception('Selected vendor is not found.');
                }
                return $vendor;
            }
        }
        return null;
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
            // Find the TenantInventory in the current schema
            $tenantinventory = TenantInventory::on('tenant')->find($id);

            if (! $tenantinventory) {
                return redirect()->back()->with('error', 'Failed to remove Inventory Item. Error: That does not exist in this warehouse.');
            }

            // Additional logging to check if the TenantInventory instance is correct
            dispatch(new WriteAuditLogJob('deleted', 'Removed Inventory Item \'' . $tenantinventory->name . '\'', $this->user->id, $this->warehouse));
            $tenantinventory->delete();

            Log::info("TenantInventory deleted: " . $tenantinventory->id);

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.index')->with('success', "Successfully removed the TenantInventory from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Inventory Item. Error: ' . $e->getMessage())->withInput();
        }
    }
}
