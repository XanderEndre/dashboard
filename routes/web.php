<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Warehouse\Tenants\TenantCustomersController;
use App\Http\Controllers\Warehouse\Tenants\TenantInventoryController;
use App\Http\Controllers\Warehouse\Tenants\TenantRecipesController;
use App\Http\Controllers\Warehouse\Tenants\TenantVendorsController;
use App\Http\Controllers\Warehouse\WarehouseController;
use App\Http\Controllers\Warehouse\Users\WarehouseUsersController;
use App\Models\Warehouse\Tenants\TenantInventory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Ensure that the user is authenticated for any of these routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile Modification
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/color', [ProfileController::class, 'updateThemeColor'])->name('profile.update.color');


    // Color Modification
    Route::post('/profile/color', [ProfileController::class, 'updateThemeColor'])->name('profile.update.color');

    // Warehouse Selection (Allow them to view their warehouses, create, or store one)
    Route::resource('warehouse', WarehouseController::class)->only(['index', 'create', 'store']);

    Route::middleware('checkUserWarehouses')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('warehouse')->name('warehouse.')->group(function () {
            Route::get('edit', [WarehouseController::class, 'edit'])->name('edit');
            Route::patch('edit', [WarehouseController::class, 'update'])->name('update');

        });

        Route::prefix('warehouse')->name('warehouse.tenants.')->group(function () {
            Route::prefix('inventory')->name('inventory.')->group(function () {
                Route::get('/', [TenantInventoryController::class, 'index'])->name('index');
                Route::get('create', [TenantInventoryController::class, 'create'])->name('create');
                Route::post('create', [TenantInventoryController::class, 'store'])->name('store');
                Route::delete('{id}', [TenantInventoryController::class, 'destroy'])->name('delete');

                Route::prefix('recipes')->name('recipes.')->group(function () {
                    Route::get('/', [TenantRecipesController::class, 'index'])->name('index');
                    Route::get('create', [TenantRecipesController::class, 'create'])->name('create');
                    Route::post('create', [TenantRecipesController::class, 'store'])->name('store');
                    Route::delete('{id}', [TenantRecipesController::class, 'destroy'])->name('delete');

                    Route::prefix('packaging')->name('packaging.')->group(function () {
                        Route::get('/', [TenantInventoryController::class, 'index'])->name('index');
                        Route::get('create', [TenantInventoryController::class, 'create'])->name('create');
                        Route::post('create', [TenantInventoryController::class, 'store'])->name('store');
                        Route::delete('{id}', [TenantInventoryController::class, 'destroy'])->name('delete');

                        Route::prefix('types')->name('types.')->group(function () {
                            Route::get('/', [TenantInventoryController::class, 'index'])->name('index');
                            Route::get('create', [TenantInventoryController::class, 'create'])->name('create');
                            Route::post('create', [TenantInventoryController::class, 'store'])->name('store');
                            Route::delete('{id}', [TenantInventoryController::class, 'destroy'])->name('delete');
                        });

                        Route::prefix('decorations')->name('decorations.')->group(function () {
                            Route::get('/', [TenantInventoryController::class, 'index'])->name('index');
                            Route::get('create', [TenantInventoryController::class, 'create'])->name('create');
                            Route::post('create', [TenantInventoryController::class, 'store'])->name('store');
                            Route::delete('{id}', [TenantInventoryController::class, 'destroy'])->name('delete');
                        });
                    });
                });
            });
        });

        Route::prefix('warehouse/vendors')->name('warehouse.vendor.')->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
        });

        Route::prefix('warehouse/categories')->name('warehouse.inventory.categories.')->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
        });
        Route::prefix('warehouse/products')->name('warehouse.inventory.products.')->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
        });
        Route::prefix('warehouse/items')->name('warehouse.inventory.items.')->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
        });
        Route::prefix('warehouse/customer')->name('warehouse.customer.')->group(function () {
            Route::get('/', [TenantCustomersController::class, 'index'])->name('index');
            Route::get('create', [TenantCustomersController::class, 'create'])->name('create');
            Route::post('create', [TenantCustomersController::class, 'store'])->name('store');
            Route::delete('{id}', [TenantCustomersController::class, 'destroy'])->name('delete');
        });

        Route::prefix('warehouse/vendor')->name('warehouse.vendor.')->group(function () {
            Route::get('/', [TenantVendorsController::class, 'index'])->name('index');
            Route::get('create', [TenantVendorsController::class, 'create'])->name('create');
            Route::post('create', [TenantVendorsController::class, 'store'])->name('store');
            Route::delete('{id}', [TenantVendorsController::class, 'destroy'])->name('delete');
        });



        Route::middleware('checkWarehouseOwner')->group(function () {

            Route::prefix('warehouse/employee')->name('warehouse.employee.')->group(function () {
                Route::get('index', [WarehouseUsersController::class, 'index'])->name('index');
                Route::get('create', [WarehouseUsersController::class, 'create'])->name('create');
                Route::post('create', [WarehouseUsersController::class, 'store'])->name('store');
                Route::delete('{user}', [WarehouseUsersController::class, 'removeWarehouseUser'])->name('delete');
            });

            Route::prefix('warehouse/logs')->name('warehouse.tenants.logs.')->group(function () {
                Route::get('/', [WarehouseController::class, 'indexAuditLogs'])->name('index');

            });

            Route::prefix('warehouse')->name('warehouse.')->group(function () {
                Route::delete('{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
            });


            Route::prefix('warehouse/invitation')->name('warehouse.invitation.')->group(function () {
                Route::delete('remove/{token}', [WarehouseUsersController::class, 'cancelInvitation'])->name('cancel.token');
            });
        });



    });


    Route::prefix('warehouse/invitation')->name('warehouse.invitation.')->group(function () {
        Route::get('accept/{token}', [WarehouseUsersController::class, 'acceptInvitation'])->name('accept.token');
        Route::get('decline/{token}', [WarehouseUsersController::class, 'declineInvitation'])->name('decline.token');
    });


    Route::prefix('warehouse')->name('warehouse.')->group(function () {
        Route::patch('{warehouse}/activate', [WarehouseController::class, 'activate'])->name('activate');
    });

});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/auth.php';
