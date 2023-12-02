<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantAddressable;
use App\Models\Warehouse\Tenants\TenantAddressType;
use App\Models\Warehouse\Tenants\TenantContactable;
use App\Models\Warehouse\Tenants\TenantContactType;
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

class TenantVendorsController extends Controller
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

        $vendors = TenantVendor::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page


        return view('warehouse.tenants.vendor.index', ['vendors' => $vendors, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("warehouse.tenants.vendor.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the vendor details which are always required
        $VendorData = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'payment_terms' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ]);

        // Validate and possibly create/fetch address and contact based on the request
        // $address = $this->validateAndCreateOrFetchAddress($request);
        // $contactInformation = $this->validateAndCreateOrFetchContact($request);
        // $parentVendor = $this->validateAndFetchParentVendor($request);


        // Merging additional data
        $data = array_merge($VendorData, [
            'is_active' => 1,
            // 'parent_Vendor_id' => $parentVendor ? $parentVendor->id : null,
            // 'Vendor_address_id' => $address ? $address->id : null,
            // 'Vendor_contact_id' => $contactInformation ? $contactInformation->id : null,
        ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $Vendor = TenantVendor::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Vendor \'' . $Vendor->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.vendor.index')->with('success', "Successfully created a new Vendor");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Vendor. Error: ' . $e->getMessage())->withInput();
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
            $vendor = TenantVendor::on('tenant')->find($id);

            if (! $vendor) {
                return redirect()->back()->with('error', 'Failed to remove Vendor. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the Vendor instance is correct

            dispatch(new WriteAuditLogJob('deleted', 'Removed Vendor \'' . $vendor->name . '\'', $this->user->id, $this->warehouse));
            $vendor->delete();

            Log::info("Vendor deleted: " . $vendor->id);


            // $Vendor->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.vendor.index')->with('success', "Successfully removed the Vendor from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove Vendor. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Find the Vendor in the current schema
        $vendor = TenantVendor::on('tenant')->find($id);

        if (! $vendor) {
            return redirect()->back()->with('error', 'The requested vendor does not exist in this warehouse.');
        }

        $addresses = TenantAddressType::on('tenant')->latest()->get();
        $contacts = TenantContactType::on('tenant')->latest()->get();

        $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        $contactOptions = $contacts->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();


        // If the vendor exists and belongs to the warehouse, show the vendor
        return view('warehouse.tenants.vendor.show', ['vendor' => $vendor, 'warehouse' => $this->warehouse, 'addressOptions' => $addressOptions, 'contactOptions' => $contactOptions]);
    }



    public function storeAddress(Request $request, string $id)
    {
        try {
            $address = $this->validateAndCreateOrFetchAddress($request, $id);

            if ($address) {
                return redirect()->back()->with('success', "Successfully added new address");
            } else {
                // Handle the scenario where no address was created or found
                return redirect()->back()->with('error', 'Failed to add address.');
            }
        } catch (\Exception $e) {
            // Handle exceptions thrown from the private method
            return redirect()->back()->with('error', 'Failed to add address. Error: ' . $e->getMessage())->withInput();
        }
    }

    private function validateAndCreateOrFetchAddress($request, string $id)
    {
        // Fetch the vendor
        $this->tenantService->setConnection($this->warehouse);

        $vendor = TenantVendor::on('tenant')->find($id);
        if (! $vendor) {
            throw new \Exception("Vendor not found.");
        }

        $addressChoice = $request->input('address_choice');

        if ($addressChoice === 'create') {
            $validatedData = $request->validate([
                'address_type' => ['required', Rule::in(TenantAddressType::$addressType)],
                'address' => 'required|string|max:255',
                'address_two' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zipcode' => 'required|string|max:10',
                'phone_number' => 'required|string',
                'email' => 'required|string'
            ]);

            DB::beginTransaction();

            try {

                // Create a new address
                $address = TenantAddressType::on('tenant')->create($validatedData);

                // Take the address id, vendor id, and the type and merge it into the TenantAddressable table

                $addressData = array_merge([
                    'addressable_id' => $vendor->id,
                    'addressable_type' => get_class($vendor),
                    'address_id' => $address->id
                ]);

                // Create the new address
                TenantAddressable::on('tenant')->create($addressData);

                // $vendor->addresses()->attach($address->id, ['addressable_type' => get_class($vendor)]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create address. Error: ' . $e->getMessage())->withInput();
            }

            return $address;

        } elseif ($addressChoice === 'select') {
            $selectedAddressId = $request->input('selected_address_id');
            $address = TenantAddressType::on('tenant')->findOrFail($selectedAddressId); // This will throw an exception if the address is not found

            // Check if the vendor has already this address attached to avoid duplication
            if (! $vendor->addresses->contains($address->id)) {
                $vendor->addresses()->attach($address->id);
            }

            return $address;
        }

        return null; // If no address choice is made, or fields are not filled
    }

    public function removeAddress(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $this->tenantService->setConnection($this->warehouse);


            // Get the current vendor
            $selectedAddressId = $request->input('address_id');

            // Ensure the address belongs to the warehouse and vendor
            $address = TenantAddressable::on('tenant')->find($selectedAddressId);
            if (! $address) {
                throw new \Exception("Vendor not found.");
            }

            // Grabt hge vendor and deattach

            $vendor = TenantVendor::on('tenant')->find($id);
            if (! $vendor) {
                throw new \Exception("Vendor not found.");
            }
            // Use the address ID to detach the address
            $vendor->addresses()->detach($address->id);

            DB::commit();

            return redirect()->back()->with('success', "Successfully removed address");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove address. Error: ' . $e->getMessage())->withInput();
        }
    }

    public function storeContact(Request $request, string $id)
    {
        try {
            $contact = $this->validateAndCreateOrFetchContact($request, $id);

            if ($contact) {
                return redirect()->back()->with('success', "Successfully added new contact");
            } else {
                // Handle the scenario where no contact was created or found
                return redirect()->back()->with('error', 'Failed to add contact.');
            }
        } catch (\Exception $e) {
            // Handle exceptions thrown from the private method
            return redirect()->back()->with('error', 'Failed to add contact. Error: ' . $e->getMessage())->withInput();
        }
    }


    private function validateAndCreateOrFetchContact($request, string $id)
    {
        // Fetch the vendor
        $this->tenantService->setConnection($this->warehouse);

        $vendor = TenantVendor::on('tenant')->find($id);
        if (! $vendor) {
            throw new \Exception("Vendor not found.");
        }

        $contactChoice = $request->input('contact_choice');

        if ($contactChoice === 'create') {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'phone_number' => 'required|string',
                'extension' => 'nullable|string|max:10',
            ]);

            DB::beginTransaction();

            try {

                // Create a new address
                $contact = TenantContactType::on('tenant')->create(array_merge($validatedData, [
                    'is_active' => '1'
                ]));

                // Take the address id, vendor id, and the type and merge it into the TenantAddressable table

                $contactData = array_merge([
                    'contactable_id' => $vendor->id,
                    'contactable_type' => get_class($vendor),
                    'contact_id' => $contact->id
                ]);

                // Create the new address
                TenantContactable::on('tenant')->create($contactData);

                // $vendor->addresses()->attach($address->id, ['addressable_type' => get_class($vendor)]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create contact. Error: ' . $e->getMessage())->withInput();
            }

            return $contact;

        } elseif ($contactChoice === 'select') {
            $selectedContactId = $request->input('selected_contact_id');
            $contact = TenantContactType::on('tenant')->findOrFail($selectedContactId); // This will throw an exception if the address is not found

            // Check if the vendor has already this address attached to avoid duplication
            if (! $vendor->addresses->contains($contact->id)) {
                $vendor->contacts()->attach($contact->id);
            }

            return $contact;
        }

        return null; // If no address choice is made, or fields are not filled
    }


    public function removeContact(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $this->tenantService->setConnection($this->warehouse);


            // Get the current vendor
            $selectedContactId = $request->input('contact_id');

            // Ensure the address belongs to the warehouse and vendor
            $contact = TenantContactable::on('tenant')->find($selectedContactId);
            if (! $contact) {
                throw new \Exception("Vendor not found.");
            }

            // Grabt hge vendor and deattach

            $vendor = TenantVendor::on('tenant')->find($id);
            if (! $vendor) {
                throw new \Exception("Vendor not found.");
            }
            // Use the address ID to detach the address
            $vendor->contacts()->detach($contact->id);

            DB::commit();

            return redirect()->back()->with('success', "Successfully removed contact");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove contact. Error: ' . $e->getMessage())->withInput();
        }
    }



}
