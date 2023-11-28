<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantInventory;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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
        // Fetch Address
        // Fetch Contact Information
        //    $addresses = Address::where('warehouse_id', $this->warehouse->id)->latest()->get();
        //     $contactInformation = Contact::where('warehouse_id', $this->warehouse->id)->latest()->get();
        //     $InventoryItemInformation = InventoryItem::where('warehouse_id', $this->warehouse->id)->latest()->get();

        // $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        // $contactOptions = $contactInformation->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();
        // $InventoryItemOptions = $InventoryItemInformation->mapWithKeys(fn ($InventoryItem) => [$InventoryItem->id => $InventoryItem->formatted()])->toArray();

        return view("warehouse.tenants.inventory.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the inventoryitem details which are always required
        $InventoryItemData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'vendor_name' => 'required|string|max:255',
            // 'item_description' => 'required|string',
            'cost' => 'required|numeric',
            'is_active' => 'required|boolean'
        ]);

        // Validate and possibly create/fetch address and contact based on the request


        // Merging additional data
        $data = array_merge($InventoryItemData, [
            'sub_item_id' => null,
            'vendor_id' => null,
            'warehouse_id' => $this->warehouse->id,
        ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $InventoryItem = TenantInventory::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Inventory Item \'' . $InventoryItem->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.index')->with('success', "Successfully created a new Inventory Item");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Inventory Item. Error: ' . $e->getMessage())->withInput();
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
            // Find the InventoryItem in the current schema
            $inventoryitem = TenantInventory::on('tenant')->find($id);

            if (! $inventoryitem) {
                return redirect()->back()->with('error', 'Failed to remove Inventory Item. Error: That does not exist in this warehouse.');
            }


            // Additional logging to check if the InventoryItem instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Inventory Item \'' . $inventoryitem->name . '\'', $this->user->id, $this->warehouse));
            $inventoryitem->delete();

            Log::info("InventoryItem deleted: " . $inventoryitem->id);


            // $InventoryItem->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.index')->with('success', "Successfully removed the InventoryItem from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Inventory Item. Error: ' . $e->getMessage())->withInput();
        }
    }
}
