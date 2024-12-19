<?php
namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ViewCustomerOrder extends Component
{
    public $order, $orderdetails, $orderaddons, $lang, $balance, $total, $customer, $payments, $sitename, $address, $phone, $paid_amount, $payment_type, $zipcode, $tax_number, $store_email;

    public function mount($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->orders = $this->customer->orders()->whereNull('deleted_at')->get(); // Exclude soft-deleted orders

        if (session()->has('selected_language')) {
            /* if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        }
    }

    public function render()
    {
        return view('livewire.admin.customers.view-orders', [
            'customer' => $this->customer,
            'orders' => $this->orders,
        ]);
    }
}
