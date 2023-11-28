<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWarehouseOwner
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
        $activeWarehouse = $user->activeWarehouse;

        // Check if there's no active warehouse
        if (! $activeWarehouse) {
            return redirect()
                ->route('warehouse.index')
                ->with('error', 'Please select an active warehouse first.');
        }

        // Check if the user is not the owner of the active warehouse
        if ($user->id !== $activeWarehouse->warehouseOwner->id) {
            return redirect()
                ->route('warehouse.index')
                ->with('error', 'Unauthorized: You are not the owner of this warehouse.');
        }


        return $next($request);
    }
}
