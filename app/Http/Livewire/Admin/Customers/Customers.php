<?php
namespace App\Http\Livewire\Admin\Customers;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Auth;
class Customers extends Component
{
    public $customers,
        $name,
        $email,
        $tax_number,
        $is_active = 1,
        $phone,
        $address,
        $search,
        $lang;
    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;
    /* rule settings*/
    protected $rules = [
        'name' => 'required',
        'email' => 'nullable|email|unique:users',
        'phone' => 'required',
    ];
    /* called before render */
    public function mount()
    {
        $this->customers = new EloquentCollection();

        $this->loadCustomers();

        if (session()->has('selected_language')) {
            /* if session has selected laugage*/
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        }
    }
    /* render the page */
    public function render()
    {
        return view('livewire.admin.customers.customers', [
            'customers' => $this->customers,
        ]);
    }
    /* reset input file */
    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->tax_number = '';
        $this->is_active = 1;
        $this->address = '';
        $this->editMode = false;
        $this->resetErrorBag();
    }
    /* store customer data */
    public function store()
    {
        /* if edit mode is false */
        $this->validate();
        $customer = new Customer();
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->email = $this->email;
        $customer->tax_number = $this->tax_number;
        $customer->address = $this->address;
        $customer->created_by = Auth::user()->id;
        $customer->is_active = $this->is_active ? '1' : '0';
        $customer->save();
        $this->customers = Customer::latest()->get();
        $this->resetInputFields();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Customer  has been created!']);
    }
    /* process while update */
    public function updated($name, $value)
    {
        if ($name == 'search' && $value != '') {
            $this->customers = Customer::where('name', 'like', '%' . $value)
                ->orWhere('id', 'like', '%' . $value)
                ->orWhere('phone', 'like', '%' . $value)
                ->latest()
                ->get();
            $this->reloadCustomers();
        } elseif ($name == 'search' && $value == '') {
            $this->customers = new EloquentCollection();
            $this->reloadCustomers();
        }
        /*if the updated element is address */
        if ($name == 'address' && $value != '') {
            $this->address = $value;
        }
    }
    /* view customer details to update */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->tax_number = $customer->tax_number;
        $this->is_active = $customer->is_active;
        $this->address = $customer->address;
        $this->editMode = true;
    }
    /* update customer details */
    public function update()
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customerId);
        $customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'tax_number' => $this->tax_number,
            'is_active' => $this->is_active,
            'address' => $this->address,
        ]);

        $this->resetInputFields();
        $this->loadCustomers();
    }
    /* refresh the page */
    public function refresh()
    {
        /* if search query or order filter is empty */
        if ($this->search == '') {
            $this->customers = $this->customers->fresh();
        }
    }
    public function loadCustomers()
    {
        $query = Customer::query();

        if ($this->search) {
            $query
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        }

        $customers = $query->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
        $this->customers->push(...$customers->items());

        if ($this->hasMorePages = $customers->hasMorePages()) {
            $this->nextCursor = $customers->nextCursor()->encode();
        }

        $this->currentCursor = $customers->cursor();
    }
    public function filterdata()
    {
        if ($this->search || $this->search != '') {
            $customers = \App\Models\Customer::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%') // Add this line to search by ID
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $customers;
        } else {
            $customers = \App\Models\Customer::latest()->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $customers;
        }
    }
    public function reloadCustomers()
    {
        $this->customers = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $customers = $this->filterdata();
        $this->customers->push(...$customers->items());
        if ($this->hasMorePages = $customers->hasMorePages()) {
            $this->nextCursor = $customers->nextCursor()->encode();
        }
        $this->currentCursor = $customers->cursor();
    }

    public function viewOrders($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $orders = $customer->orders()->whereNull('deleted_at')->get(); // Exclude soft-deleted orders

        return view('livewire.admin.customers.view-orders', compact('customer', 'orders'));
    }
}
