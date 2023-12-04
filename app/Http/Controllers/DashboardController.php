<?php

namespace App\Http\Controllers;

use App\Models\Warehouse\Tenants\Order\TenantOrders;
use App\Models\Warehouse\Tenants\TenantCustomer;
use App\Models\Warehouse\Tenants\TenantInventory;
use App\Models\Warehouse\Tenants\TenantVendor;
use App\Services\TenantService;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
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

        // if (! $this->warehouse) {
        //     // handle the case where there's no associated warehouse
        //     return redirect()->back()->with('error', 'No associated warehouse found.');
        // }

        try {
            $this->tenantService->setConnection($this->warehouse);
            // Fetch all the orders, customers, vendors, inventory items
            $customers = TenantCustomer::on('tenant')->paginate(5);
            $vendors = TenantVendor::on('tenant')->get();
            $inventoryItems = TenantInventory::on('tenant')->get();
            $orders = TenantOrders::on('tenant')
                ->paginate(5); // 15 is the number of items per page


            return view('dashboard', [
                'warehouse' => $this->warehouse,
                'user' => $this->user,
                'customers' => $customers,
                'vendors' => $vendors,
                'orders' => $orders,
                'inventoryItems' => $inventoryItems]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to access warehouse.')->withInput();
        }
    }

    public function test()
    {
        return view('test', ['warehouse' => $this->warehouse]);
    }


}
