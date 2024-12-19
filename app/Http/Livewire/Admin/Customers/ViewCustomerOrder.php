<?php
namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Translation;
use App\Models\MasterSettings;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ViewCustomerOrder extends Component
{
    public $order, $orderdetails, $orderaddons, $lang, $balance, $total, $customer, $payments, $sitename, $address, $phone, $paid_amount, $payment_type, $zipcode, $tax_number, $store_email;

    public function mount($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->orders = $this->customer->orders()->whereNull('deleted_at')->get(); // Exclude soft-deleted orders
        $settings = new MasterSettings();
        $site = $settings->siteData();
        if (isset($site['default_application_name'])) {
            /* if site  has default application name */
            $sitename = $site['default_application_name'] && $site['default_application_name'] != '' ? $site['default_application_name'] : 'Laundry Box';
            $this->sitename = $sitename;
        }
        if (isset($site['default_phone_number'])) {
            /* if site has default phone number */
            $phone = $site['default_phone_number'] && $site['default_phone_number'] != '' ? $site['default_phone_number'] : '123456789';
            $this->phone = $phone;
        }
        if (isset($site['default_address'])) {
            /* if site has default address */
            $address = $site['default_address'] && $site['default_address'] != '' ? $site['default_address'] : 'Address';
            $this->address = $address;
        }
        if (isset($site['default_zip_code'])) {
            /* if site has default zip code */
            $zipcode = $site['default_zip_code'] && $site['default_zip_code'] != '' ? $site['default_zip_code'] : 'ZipCode';
            $this->zipcode = $zipcode;
        }
        if (isset($site['store_tax_number'])) {
            /* if site has store tax number */
            $tax_number = $site['store_tax_number'] && $site['store_tax_number'] != '' ? $site['store_tax_number'] : 'Tax Number';
            $this->tax_number = $tax_number;
        }
        if (isset($site['store_email'])) {
            /* if site has store email */
            $store_email = $site['store_email'] && $site['store_email'] != '' ? $site['store_email'] : 'store@store.com';
            $this->store_email = $store_email;
        }
        //$this->balance = $this->order->total - Payment::where('order_id', $this->order->id)->sum('received_amount');
        //$this->paid_amount = $this->balance;
        if (session()->has('selected_language')) {
            /* session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
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
