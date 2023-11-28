<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserWarehouses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        // Get the authenticated user
        $user = auth()->user();

        // This part is redundant but to ensure people do not get past authentication
        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in.');
        }

        // Check that the user as AT LEAST ONE warehouse connection.
        if (! $user->warehouseEmployeeOf()->exists()) {
            // redirect them back to the index page to prompt them to register/join a warehouse
            return redirect()->route('warehouse.index')
                ->with('error', 'You are currently not apart of any warehouses. Please create a warehouse or join one today!');
        }

        // Check that the user has an 'active_schema'
        if (! $user->activeWarehouse) {
            // redirect them and prompt them to select a warehouse
            return redirect()->route('warehouse.index')
                ->with('error', 'You must select an active warehouse');
        }

        // Lastly, check that the user is apart of this warehouse and the warehouse exists
        // if (! $user->warehouses || ! $user->warehouseEmployeeOf->contains($user->activeWarehouse->id)) {
        //     return redirect()->route('warehouse.index')
        //         ->with('error', 'You are not a member of this warehouse');
        // }

        return $next($request);
    }
}
