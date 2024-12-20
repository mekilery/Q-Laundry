<?php
namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Translation;
use App\Models\MasterSettings;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialYear;
use Carbon\Carbon;

class ViewCustomerOrder extends Component
{
    public $order,
        $from_date,
        $to_date,
        $defaultDate,
        $orderaddons,
        $lang,
        $balance,
        $total,
        $customer,
        $payments,
        $sitename,
        $address,
        $phone,
        $paid_amount,
        $payment_type,
        $zipcode,
        $tax_number,
        $store_email,
        $status = -1,
        $orders = [];

    public function mount($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->orders = $this->customer->orders()->whereNull('deleted_at')->get(); // Exclude soft-deleted orders
        $this->order = $this->orders->first(); // Initialize the order property
        $this->from_date = \Carbon\Carbon::today()->toDateString();
        $this->to_date = \Carbon\Carbon::today()->toDateString();
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
        $this->balance = $this->order->total - Payment::where('order_id', $this->order->id)->sum('received_amount');
        $this->paid_amount = $this->balance;
        if (session()->has('selected_language')) {
            /* session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
    public function DateSelection()
    {
        // Get the financial year based on the financial_year_id
        $financialYear = FinancialYear::find(1); // Replace 1 with the actual financial_year_id
        if ($financialYear) {
            $financialYearStart = Carbon::parse($financialYear->starting_date);
        } else {
            // Default to the current year's April 1st if financial year not found
            $currentYear = Carbon::now()->year;
            $financialYearStart = Carbon::create($currentYear, 4, 1);
        }
        $this->defaultDate = $financialYearStart->toDateString();
    }
    public function report()
    {
        $query = \App\Models\Order::query()
            ->whereDate('order_date', '>=', $this->from_date)
            ->whereDate('order_date', '<=', $this->to_date);

        if ($this->status != -1) {
            $query->where('status', $this->status);
        }

        if ($this->customer) {
            $query->where('customer_id', $this->customer->id);
        }

        $this->orders = $query
            ->with([
                'payments' => function ($query) {
                    $query->select('order_id', \DB::raw('SUM(received_amount) as total_paid'))->groupBy('order_id');
                },
            ])
            ->latest()
            ->get();

        $this->totalOrderAmount = $this->orders->sum('total');
        $this->totalPaidAmount = $this->orders->sum(function ($order) {
            return $order->payments->sum('total_paid');
        });
        $this->totalBalanceAmount = $this->totalOrderAmount - $this->totalPaidAmount;
    }
    public function updated($name, $value)
    {
        /* if the updated value is from_date or to_date */
        if ($name == 'from_date' || $name == 'to_date') {
            $this->report();
        }

        /* if the updated value is status */
        if ($name == 'status') {
            $this->report();
        }
    }

    public function render()
    {
        $this->report(); // Ensure the report method is called to load orders initially
        return view('livewire.admin.customers.view-orders', [
            'customer' => $this->customer,
            'orders' => $this->orders,
        ]);
    }
}
