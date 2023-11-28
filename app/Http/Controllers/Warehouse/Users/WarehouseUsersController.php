<?php

namespace App\Http\Controllers\Warehouse\Users;

use App\Models\User;
use App\Models\Warehouse\Tenants\TenantAuditLog;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\WarehouseUsers;
use App\Models\Warehouse\Users\WarehouseUserInvitations;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WarehouseUsersController extends Controller
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



    public function create()
    {
        return view('warehouse.employee.create', ['warehouse' => $this->warehouse]);
    }


    public function index()
    {
        // Fetch pending invitations for the current warehouse
        $warehouseUserInvitations = WarehouseUserInvitations::where('warehouse_id', $this->warehouse->id)->where('status', 'pending')->get();

        return view('warehouse.employee.index', ['warehouse' => $this->warehouse, 'warehouseUserInvitations' => $warehouseUserInvitations]);
    }

    /**
     * Store a newly created warehouse warehouseUser.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,manager,warehouseUser',
        ]);

        $softDeletedwarehouseUser = $this->findSoftDeletedwarehouseUser($validateData['email']);

        if ($softDeletedwarehouseUser) {
            $this->restoreAndReinvitewarehouseUser($softDeletedwarehouseUser);
            return redirect()->route('warehouse.employee.index')->with('success', 'warehouseUser re-invited');
        }

        if ($this->iswarehouseUserExistingOrInvited($validateData['email'])) {
            return redirect()->back()->with('error', 'User is already in this warehouse or has already been invited.');
        }

        $this->sendInvitation($validateData);
        return redirect()->route('warehouse.employee.index')->with('success', 'warehouseUser invited');
    }

    /**
     * Check for soft deleted warehouseUsers.
     */
    protected function findSoftDeletedwarehouseUser(string $email) : ?WarehouseUserInvitations
    {
        return WarehouseUserInvitations::onlyTrashed()
            ->where('warehouse_id', $this->warehouse->id)
            ->where('email', $email)
            ->first();
    }

    /**
     * Restore and re-invite a soft deleted warehouseUser.
     */
    protected function restoreAndReinvitewarehouseUser(WarehouseUserInvitations $warehouseUser) : void
    {
        $warehouseUser->restore();
        $warehouseUser->inviter_id = $this->user->id;
        $warehouseUser->invitation_token = Str::random(40);
        $warehouseUser->expires_at = now()->addDays(2);
        $warehouseUser->status = 'pending';
        $warehouseUser->save();

        // Mail::to($warehouseUser->email)->send(new InvitationMail($warehouseUser));
    }

    /**
     * Check if the user is already an warehouseUser or has been invited.
     */
    protected function iswarehouseUserExistingOrInvited(string $email) : bool
    {
        $existingwarehouseUser = WarehouseUsers::where('warehouse_id', $this->warehouse->id)
            ->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            })->first();

        $existingInvitation = WarehouseUserInvitations::where('warehouse_id', $this->warehouse->id)
            ->where('email', $email)
            ->whereIn('status', ['pending'])
            ->first();

        return $existingwarehouseUser || $existingInvitation;
    }

    /**
     * Send invitation to the user.
     */
    protected function sendInvitation(array $data) : void
    {
        DB::beginTransaction();
        try {
            $invitation = WarehouseUserInvitations::create([
                'warehouse_id' => $this->warehouse->id,
                'email' => $data['email'],
                'inviter_id' => $this->user->id,
                'invitation_token' => Str::random(40),
                'expires_at' => now()->addDays(2),
                'status' => 'pending',
            ]);

            // Mail::to($data['email'])->send(new InvitationMail($invitation));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Failed to send the invitation: " . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {

        if (! $warehouse) {
            return redirect()->back()->with('error', 'No associated warehouse found.');
        }

        return view('warehouse.employee.index', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Warehouse $warehouse, User $user)
    {
        $this->user->update(['active_schema' => $warehouse->id]);
        return redirect()->back()->with('success', 'Active warehouse updated successfully!');
    }

    public function acceptInvitation($token)
    {
        // Retrieve the invitation using the token.
        $warehouseUserInvitations = WarehouseUserInvitations::where('invitation_token', $token)->first();

        if (! $warehouseUserInvitations) {
            return redirect()->back()->with('error', 'Invalid invitation token.');
        }

        // Check if there's a soft-deleted warehouseUser with matching details
        $softDeletewarehouseUser = WarehouseUsers::onlyTrashed()
            ->where('warehouse_id', $warehouseUserInvitations->warehouse_id)
            ->whereHas('user', fn ($query) => $query->where('email', $warehouseUserInvitations->email))
            ->first();



        // If there's a matching soft-deleted warehouseUser, restore it and update the invitation status
        if ($softDeletewarehouseUser) {
            $softDeletewarehouseUser->restore();
            $warehouseUserInvitations->update(['status' => 'accepted']);
            $this->user->update(['active_schema' => $warehouseUserInvitations->warehouse_id]);
            $warehouseName = $warehouseUserInvitations->warehouse->name;
            return redirect()->route('dashboard.index')->with('success', "Successfully rejoined the warehouse {$warehouseName}.");
        }
        // ensure that the warehouseUser does not already exist in the warehouse
        $existingwarehouseUser = WarehouseUsers::where('warehouse_id', $warehouseUserInvitations->warehouse_id)
            ->whereHas('user', fn ($query) => $query->where('email', $this->user->email))
            ->first();


        if ($existingwarehouseUser) {
            return redirect()->back()->with('error', 'You are already a part of this warehouse');
        }

        // Process the invitation acceptance
        DB::beginTransaction();

        try {
            WarehouseUsers::create([
                'user_id' => $this->user->id,
                'warehouse_id' => $warehouseUserInvitations->warehouse_id,
                'is_active' => 1,
                'role_id' => null
            ]);

            // SET AS THE ACTIVE WAREHOUSE on the user
            $this->user->update(['active_schema' => $warehouseUserInvitations->warehouse_id]);

            // redirect them to the dashboard

            $warehouseUserInvitations->update(['status' => 'accepted']);
            $warehouseUserInvitations->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to accept the invitation. Error: ' . $e->getMessage());
        }

        $warehouseName = $warehouseUserInvitations->warehouse->name;
        return redirect()->route('dashboard.index')->with('success', "Successfully joined the warehouse {$warehouseName}");
    }
    public function declineInvitation($token)
    {
        $warehouseUserInvitations = WarehouseUserInvitations::where('invitation_token', $token)->first();

        if (! $warehouseUserInvitations) {
            return redirect()->back()->with('error', 'Invalid invitation token.');
        }

        // Check if the user is already an warehouseUser in the warehouse
        $existingwarehouseUser = WarehouseUsers::where('warehouse_id', $warehouseUserInvitations->warehouse_id)
            ->whereHas('user', fn ($query) => $query->where('email', $this->user->email))
            ->first();

        if ($existingwarehouseUser) {
            return redirect()->back()->with('error', 'You have already responded to this invitation');
        }

        DB::beginTransaction();

        try {
            $warehouseUserInvitations->update(['status' => 'declined']);
            $warehouseUserInvitations->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to decline the invitation. Error: ' . $e->getMessage());
        }

        $warehouseName = $warehouseUserInvitations->warehouse->name;
        return redirect()->back()->with('success', "Successfully declined the warehouse {$warehouseName}");
    }

    public function removeWarehouseUser(User $user)
    {
        // Ensure the authenticated user owns the warehouse
        if ($this->warehouse->warehouse_owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Prevent the owner from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot remove yourself.');
        }

        $warehouseUser = WarehouseUsers::where('warehouse_id', $this->warehouse->id)
            ->where('user_id', $user->id)
            ->first();

        if (! $warehouseUser) {
            return redirect()->route('warehouse.employee.index')->with('error', 'warehouseUser not found in this warehouse.');
        }

        $existingInvitation = WarehouseUserInvitations::where('warehouse_id', $this->warehouse->id)
            ->where('email', $user->email)
            ->first();

        DB::beginTransaction();

        try {
            // Detach the user from the active warehouse
            $warehouseUser->user->update(['active_schema' => null]);

            // Soft delete the warehouse warehouseUser
            $warehouseUser->delete();

            // Delete any existing invitation for the user
            if ($existingInvitation) {
                $existingInvitation->delete();
            }

            DB::commit();
            return redirect()->route('warehouse.employee.index')->with('success', 'warehouseUser removed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('warehouse.employee.index')->with('error', 'Failed to remove the warehouseUser. ' . $e->getMessage());
        }
    }


    public function cancelInvitation($token)
    {
        // Ensure the authenticated user owns the warehouse
        if ($this->warehouse->warehouse_owner_id !== $this->user->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Retrieve the existing invitation
        $existingInvitation = WarehouseUserInvitations::where('warehouse_id', $this->warehouse->id)
            ->where('invitation_token', $token)
            ->first();

        if (! $existingInvitation) {
            return redirect()->route('warehouse.employee.index')->with('error', 'Unable to find invitation.');
        }

        DB::beginTransaction();

        try {
            // Soft delete the invitation
            $existingInvitation->delete();

            DB::commit();
            return redirect()->route('warehouse.employee.index')->with('success', 'Invitation cancelled successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('warehouse.employee.index')->with('error', 'Failed to remove the invitation. ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }




}
