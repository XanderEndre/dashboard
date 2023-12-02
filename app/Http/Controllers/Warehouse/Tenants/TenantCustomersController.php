<?php

namespace App\Http\Controllers\Warehouse\Tenants;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse\Tenants\TenantCustomer;
use App\Models\Warehouse\Tenants\TenantAddressable;
use App\Models\Warehouse\Tenants\TenantAddressType;
use App\Models\Warehouse\Tenants\TenantContactable;
use App\Models\Warehouse\Tenants\TenantContactType;
use App\Services\TenantService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TenantCustomersController extends Controller
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

        // Eager load related data (e.g., 'contacts', 'addresses') and implement pagination
        $customers = TenantCustomer::on('tenant')
            // ->with(['contacts', 'addresses']) // assuming these are the relations
            ->latest()
            ->paginate(10); // 15 is the number of items per page

        return view('warehouse.tenants.customer.index', ['customers' => $customers, 'warehouse' => $this->warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("warehouse.tenants.customer.create", ['warehouse' => $this->warehouse]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Start by validating the customer details which are always required
        $customerData = $request->validate([
            'name' => 'required|string|max:255',
            'payment_terms' => 'required|string|max:255'
        ]);

        // Validate and possibly create/fetch address and contact based on the request
        // $address = $this->validateAndCreateOrFetchAddress($request);
        // $contactInformation = $this->validateAndCreateOrFetchContact($request);
        // $parentCustomer = $this->validateAndFetchParentCustomer($request);


        // Merging additional data
        $data = array_merge($customerData, [
            'is_active' => 1,
            // 'parent_customer_id' => $parentCustomer ? $parentCustomer->id : null,
            // 'customer_address_id' => $address ? $address->id : null,
            // 'customer_contact_id' => $contactInformation ? $contactInformation->id : null,
            'warehouse_id' => $this->warehouse->id,
        ]);

        DB::beginTransaction();

        try {

            // Set the connection to the tenant's schema
            $this->tenantService->setConnection($this->warehouse);

            $customer = TenantCustomer::on('tenant')->create($data);

            dispatch(new WriteAuditLogJob('created', 'Created Customer \'' . $customer->name . '\'', $this->user->id, $this->warehouse));

            DB::commit();
            return redirect()->route('warehouse.tenants.customer.index')->with('success', "Successfully created a new customer");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create customer. Error: ' . $e->getMessage())->withInput();
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
            // Find the customer in the current schema
            $customer = TenantCustomer::on('tenant')->find($id);

            if (! $customer) {
                return redirect()->back()->with('error', 'Failed to remove customer. Error: They do not exist in this warehouse.');
            }


            // Additional logging to check if the customer instance is correct
            Log::info("Deleting customer: " . $customer->id);

            $customer->delete();

            Log::info("Customer deleted: " . $customer->id);


            dispatch(new WriteAuditLogJob('deleted', 'Removed Customer \'' . $customer->name . '\'', $this->user->id, $this->warehouse));
            // $customer->delete();

            DB::commit();
            return redirect()->route('warehouse.tenants.customer.index')->with('success', "Successfully removed the customer from this warehouse.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove customer. Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Request $request, string $id)
    {
        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Find the Customer in the current schema
        $customer = TenantCustomer::on('tenant')->find($id);

        if (! $customer) {
            return redirect()->back()->with('error', 'The requested customer does not exist in this warehouse.');
        }

        $addresses = TenantAddressType::on('tenant')->latest()->get();
        $contacts = TenantContactType::on('tenant')->latest()->get();

        $addressOptions = $addresses->mapWithKeys(fn ($address) => [$address->id => $address->formatted()])->toArray();
        $contactOptions = $contacts->mapWithKeys(fn ($contact) => [$contact->id => $contact->formatted()])->toArray();


        // If the customer exists and belongs to the warehouse, show the customer
        return view('warehouse.tenants.customer.show', ['customer' => $customer, 'addressOptions' => $addressOptions, 'contactOptions' => $contactOptions]);
    }


    public function updateNote(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'customer_notes' => 'required|string',
        ]);

        $customerNote = $validatedData['customer_notes'];

        // Set the connection to the tenant's schema
        $this->tenantService->setConnection($this->warehouse);

        // Find the Customer in the current schema
        $customer = TenantCustomer::on('tenant')->find($id);

        if (! $customer) {
            return redirect()->back()->with('error', 'The requested customer does not exist in this warehouse.');
        }

        DB::beginTransaction();

        try {
            // update the customers stfuff
            $customer->update(['notes' => $customerNote]);
            DB::commit();
            return redirect()->back()->with('success', "Successfully updated note!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update note. Error: ' . $e->getMessage())->withInput();
        }

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
        // Fetch the customer
        $this->tenantService->setConnection($this->warehouse);

        $customer = TenantCustomer::on('tenant')->find($id);
        if (! $customer) {
            throw new \Exception("Customer not found.");
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

                // Take the address id, customer id, and the type and merge it into the TenantAddressable table

                $addressData = array_merge([
                    'addressable_id' => $customer->id,
                    'addressable_type' => get_class($customer),
                    'address_id' => $address->id
                ]);

                // Create the new address
                TenantAddressable::on('tenant')->create($addressData);

                // $customer->addresses()->attach($address->id, ['addressable_type' => get_class($customer)]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create address. Error: ' . $e->getMessage())->withInput();
            }

            return $address;

        } elseif ($addressChoice === 'select') {
            $selectedAddressId = $request->input('selected_address_id');
            $address = TenantAddressType::on('tenant')->findOrFail($selectedAddressId); // This will throw an exception if the address is not found

            // Check if the customer has already this address attached to avoid duplication
            if (! $customer->addresses->contains($address->id)) {
                $customer->addresses()->attach($address->id);
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


            // Get the current customer
            $selectedAddressId = $request->input('address_id');

            // Ensure the address belongs to the warehouse and customer
            $address = TenantAddressable::on('tenant')->find($selectedAddressId);
            if (! $address) {
                throw new \Exception("Customer not found.");
            }

            // Grabt hge customer and deattach

            $customer = TenantCustomer::on('tenant')->find($id);
            if (! $customer) {
                throw new \Exception("Customer not found.");
            }
            // Use the address ID to detach the address
            $customer->addresses()->detach($address->id);

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
        // Fetch the customer
        $this->tenantService->setConnection($this->warehouse);

        $customer = TenantCustomer::on('tenant')->find($id);
        if (! $customer) {
            throw new \Exception("Customer not found.");
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

                // Take the address id, customer id, and the type and merge it into the TenantAddressable table

                $contactData = array_merge([
                    'contactable_id' => $customer->id,
                    'contactable_type' => get_class($customer),
                    'contact_id' => $contact->id
                ]);

                // Create the new address
                TenantContactable::on('tenant')->create($contactData);

                // $customer->addresses()->attach($address->id, ['addressable_type' => get_class($customer)]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create contact. Error: ' . $e->getMessage())->withInput();
            }

            return $contact;

        } elseif ($contactChoice === 'select') {
            $selectedContactId = $request->input('selected_contact_id');
            $contact = TenantContactType::on('tenant')->findOrFail($selectedContactId); // This will throw an exception if the address is not found

            // Check if the customer has already this address attached to avoid duplication
            if (! $customer->addresses->contains($contact->id)) {
                $customer->contacts()->attach($contact->id);
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


            // Get the current customer
            $selectedContactId = $request->input('contact_id');

            // Ensure the address belongs to the warehouse and customer
            $contact = TenantContactable::on('tenant')->find($selectedContactId);
            if (! $contact) {
                throw new \Exception("Customer not found.");
            }

            // Grabt hge customer and deattach

            $customer = TenantCustomer::on('tenant')->find($id);
            if (! $customer) {
                throw new \Exception("Customer not found.");
            }
            // Use the address ID to detach the address
            $customer->contacts()->detach($contact->id);

            DB::commit();

            return redirect()->back()->with('success', "Successfully removed contact");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove contact. Error: ' . $e->getMessage())->withInput();
        }
    }


}
