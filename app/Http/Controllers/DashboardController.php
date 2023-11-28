<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Property to store the authenticated user and warehouse
    protected $user;
    protected $warehouse;

    // Constructor to set up middleware and cache the authenticated user and warehouse
    public function __construct()
    {
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

        if (! $this->warehouse) {
            // handle the case where there's no associated warehouse
            return redirect()->back()->with('error', 'No associated warehouse found.');
        }

        return view('dashboard', ['warehouse' => $this->warehouse, 'user' => $this->user]);
    }


}
