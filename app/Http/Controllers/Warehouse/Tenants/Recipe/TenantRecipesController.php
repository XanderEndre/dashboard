<?php

namespace App\Http\Controllers\Warehouse\Tenants\Recipe;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipeBoxPackaging;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipeItemPackagings;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipeItems;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipes;
use App\Models\Warehouse\Tenants\TenantCustomer;
use App\Models\Warehouse\Tenants\TenantInventory;
use App\Models\Warehouse\Tenants\TenantVendor;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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


        return view('warehouse.tenants.inventory.recipes.index', ['recipes' => $recipes, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Process to create a new recipe:
        // Prompt the user to select a customer
        // Prompt the user to select a box type
        // based on the box type selected create X amount of table fillable items
        // Ask for ounce, item name (pull from DB), item packaging (pull from DB)
        // create conmnectsion based on it (array?)

        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Grab all the customers from the database
        $customers = TenantCustomer::on('tenant')
            ->latest()
            ->get(); // ideally we would like eager load this data

        // Load all the box packaging types
        $boxPackagings = TenantRecipeBoxPackaging::on('tenant')
            ->latest()
            ->get()
            ->mapWithKeys(function ($packaging) {
                return [
                    $packaging->id => [
                        'name' => $packaging->name,
                        'maxItems' => $packaging->quantity // Assuming 'max_items' is the field name
                    ]
                ];
            })
            ->toArray();

        // Load all the item packaging types
        $itemPackagings = TenantRecipeItemPackagings::on('tenant')
            ->latest()
            ->get()
            ->mapWithKeys(function ($packaging) {
                return [$packaging->id => $packaging->name];
            })
            ->toArray();

        // Load all the inventory items
        $inventoryItems = TenantInventory::on('tenant')
            ->latest()
            ->get()
            ->mapWithKeys(function ($customer) {
                return [$customer->id => $customer->name];
            })
            ->toArray();


        return view("warehouse.tenants.inventory.recipes.create",
            ['warehouse' => $this->warehouse,
                'customers' => $customers,
                'boxPackagings' => $boxPackagings,
                'itemPackagings' => $itemPackagings,
                'inventoryItems' => $inventoryItems]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);


        // iteratre over each array item
        // validate each one adn create the connection?

        DB::beginTransaction();

        try {


            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            // Start by validating the vendor details which are always required
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'box_packaging' => 'required|exists:tenant.tenant_recipe_box_packagings,id', // Corrected table name
                'items.*.ounces' => 'required|numeric',
                'items.*.item' => 'required|exists:tenant.tenant_inventories,id',
                'items.*.packaging' => 'required|exists:tenant.tenant_recipe_item_packagings,id',
                // 'items.*.decoration' => 'required|exists:decorations,id',
            ]);

            // dd($validatedData);
            // Step 1. Create Recipe
            $recipe = TenantRecipes::on('tenant')->create([
                'name' => $validatedData['name'],
                'box_id' => $validatedData['box_packaging'],
                'customer_id' => null
            ]);

            // Step 2. Find the matching values and create theh connection
            foreach ($validatedData['items'] as $item) {
                TenantRecipeItems::on('tenant')->create([
                    'recipe_id' => $recipe->id,
                    'ounces' => $item['ounces'],
                    'item_id' => $item['item'],
                    'packaging_id' => $item['packaging'],
                    'decoration_id' => null
                ]);
            }


            dispatch(new WriteAuditLogJob('created', 'Created recipe \'' . $recipe->name . '\'', $this->user->id, $this->warehouse));


            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.recipes.index')->with('success', "Successfully created a new Vendor");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create Recipe: ' . $e->getMessage()); // Log the error
            return redirect()->back()->with('error', 'Failed to create Recipe. Error: ' . $e->getMessage())->withInput();
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
            $recipe = TenantRecipes::on('tenant')->find($id);

            if (! $recipe) {
                return redirect()->back()->with('error', 'Failed to remove Recipe. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the Vendor instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Recipe \'' . $recipe->name . '\'', $this->user->id, $this->warehouse));
            $recipe->delete();

            Log::info("Recipe deleted: " . $recipe->id);


            // $Vendor->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.inventory.recipes.index')->with('success', "Successfully removed the Vendor from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Vendor. Error: ' . $e->getMessage())->withInput();
        }
    }
}
