<?php

namespace App\Http\Controllers\Warehouse\Tenants\Order;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\Order\TenantOrderDetails;
use App\Models\Warehouse\Tenants\Order\TenantOrders;
use App\Models\Warehouse\Tenants\Recipe\TenantRecipes;
use App\Models\Warehouse\Tenants\TenantAddressType;
use App\Models\Warehouse\Tenants\TenantCustomer;
use App\Models\Warehouse\Tenants\TenantInventory;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class TenantOrdersController extends Controller
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

        $orders = TenantOrders::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.tenants.order.index', ['orders' => $orders, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // We want to fetch ca list of customers
        $customers = TenantCustomer::on('tenant')
            ->latest()
            ->get()
            ->mapWithKeys(function ($customer) {
                return [$customer->id => $customer->name];
            })
            ->toArray();

        // We want to fetch ca list of customers
        $recipes = TenantRecipes::on('tenant')
            ->latest()
            ->get()
            ->mapWithKeys(function ($recipe) {
                return [$recipe->id => $recipe->name];
            })
            ->toArray();

        // 
        $addresses = TenantAddressType::on('tenant')->latest()->get();
        $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();



        return view("warehouse.tenants.order.create", ['warehouse' => $this->warehouse, 'customers' => $customers, 'recipes' => $recipes, 'addresses' => $addressOptions]);
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


            // Start by validating the orders details which are always required
            $validatedData = $request->validate([
                'customer_id' => 'required|string|max:255',
                'po_number' => 'required|string|max:255',
                'expected_delivery_date' => 'required|date',

                'items.*.quantity' => 'required|numeric',
                'items.*.item' => 'required|exists:tenant.tenant_recipes,id',
            ]);



            $order = TenantOrders::on('tenant')->create([
                'customer_id' => $validatedData['customer_id'],
                'po_number' => $validatedData['po_number'],
                'expected_delivery_date' => $validatedData['expected_delivery_date'],
                'order_state' => 'Review',
                'total_cost' => 0,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $totalCost = 0;

            foreach ($validatedData['items'] as $item) {
                $totalOrderDetailCost = 0;
                // Calculate the total cost by grabbing the item, tis cost

                $recipeCost = TenantRecipes::on('tenant')
                    ->where('id', $item['item'])
                    ->value('total_cost') ?? 0;

                // mutliply by the quantity
                $totalOrderDetailCost = $recipeCost * $item['quantity'];


                TenantOrderDetails::on('tenant')->create([
                    'order_id' => $order->id,
                    'recipe_id' => $item['item'],
                    'quantity' => $item['quantity'],
                    'total_cost' => $totalOrderDetailCost
                ]);

                $totalCost += $totalOrderDetailCost;
            }


            $order->update(['total_cost' => $totalCost]);

            dispatch(new WriteAuditLogJob('created', 'Created Orders \'' . $order->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.order.index')->with('success', "Successfully created a new Orders");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Orders. Error: ' . $e->getMessage())->withInput();
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
            // Find the Orders in the current schema
            $orders = TenantOrders::on('tenant')->find($id);

            if (! $orders) {
                return redirect()->back()->with('error', 'Failed to remove Orders. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the Orders instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Orders \'' . $orders->name . '\'', $this->user->id, $this->warehouse));
            $orders->delete();

            Log::info("Orders deleted: " . $orders->id);


            // $Orders->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.order.index')->with('success', "Successfully removed the Orders from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Orders. Error: ' . $e->getMessage())->withInput();
        }
    }


    public function show(Request $request, string $id)
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Find the Customer in the current schema
        $order = TenantOrders::on('tenant')
            ->find($id);

        if (! $order) {
            return redirect()->back()->with('error', 'The requested order does not exist in this warehouse.');
        }

        // $addresses = TenantAddressType::on('tenant')->latest()->get();
        // $contacts = TenantContactType::on('tenant')->latest()->get();

        // $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        // $contactOptions = $contacts->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();


        // If the customer exists and belongs to the warehouse, show the customer
        return view('warehouse.tenants.order.show', ['order' => $order]);
    }

}
