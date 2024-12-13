<?php
namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;
use PDF;
use App\Models\Translation;
use App\models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FinancialYear;
use App\Models\Order;
use App\Models\payment;

class CustomerReport extends Component
{
    public $from_date,
        $to_date,
        $orders,
        $status = -1,
        $lang,
        $customers,
        $customer_query,
        $defaultDate,
        $selected_customer;

    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.customer-report');
    }
    /* processed before render */
    public function mount()
    {
        $this->from_date = \Carbon\Carbon::today()->toDateString();
        $this->to_date = \Carbon\Carbon::today()->toDateString();
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->report();
    }

    public function updated($name, $value)
    {
        /* if updated value is empty set the value as null */
        if ($value == '') {
            data_set($this, $name, null);
        }
        /* if the updated value is customer_query */
        if ($name == 'customer_query' && $value != '') {
            $this->customers = Customer::where(function ($query) use ($value) {
                $query
                    ->where('id', 'like', '%' . $value . '%')
                    ->orWhere('name', 'like', '%' . $value . '%')
                    ->orWhere('phone', 'like', '%' . $value . '%');
            })
                ->latest()
                ->limit(5)
                ->get();
        } elseif ($name == 'customer_query' && $value == '') {
            $this->customers = collect();
        }
        $this->report();
    }
    /* select customer */
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('id', $id)->first();
        $this->customer_query = '';
        $this->customers = collect();
        $this->report(); // Call report() after selecting a customer
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
        return view('date-selection', ['defaultDate' => $financialYearStart->toDateString()]);
    }
    /*processed on update of the element */

    public function report()
    {
        $query = \App\Models\Order::withoutTrashed()
            ->whereDate('order_date', '>=', $this->from_date)
            ->whereDate('order_date', '<=', $this->to_date);

        if ($this->status != -1) {
            $query->where('status', $this->status);
        }

        if ($this->selected_customer) {
            $query->where('customer_id', $this->selected_customer->id);
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
}
