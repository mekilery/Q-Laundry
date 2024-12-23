<?php
namespace App\Http\Livewire\Admin\Reports;
use App\Models\Translation;
use Livewire\Component;
use app\models\PaymentType;
use app\models\Payment;
class DailyReport extends Component
{
    public $today, $new_order, $delivered_orders, $total_payment, $total_expense, $total_sales, $delivered_orders_amount, $lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.daily-report');
    }
    /* processed before render */
    public function mount()
    {
        $this->today = \Carbon\Carbon::today()->toDateString();
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->report();
    }
    /*processed on update of the element */
    public function updated($name, $value)
    {
        /* any updated on $today model */
        if (($name = 'today') && $value != '') {
            $this->today = $value;
        }
        $this->report();
    }
    public function report()
    {
        $this->new_order = \App\Models\Order::whereDate('order_date', $this->today)->count();
        $this->delivered_orders = \App\Models\Order::whereDate('delivered_on', $this->today)
            ->count();

        $this->total_sales = \App\Models\Order::whereDate('order_date', $this->today)->sum('total');

        $this->delivered_orders_amount = \App\Models\Order::whereDate('delivered_on', $this->today)
            ->where('status', 3)
            ->sum('total');

        // Total payment by payment type
        $this->total_payment_by_type = \App\Models\Payment::whereDate('payment_date', $this->today)
            ->with('paymentType')
            ->select('payment_type', \DB::raw('SUM(received_amount) as total_amount'))
            ->groupBy('payment_type')
            ->get();

        // Total expense by payment type
        $this->total_expense_by_type = \App\Models\Expense::whereDate('expense_date', $this->today)
            ->with('paymentType')
            ->select('payment_type', \DB::raw('SUM(expense_amount) as total_amount'))
            ->groupBy('payment_type')
            ->get();
        // Overall totals
        $this->total_payment = $this->total_payment_by_type->sum('total_amount');
        $this->total_expense = $this->total_expense_by_type->sum('total_amount');
        $this->overall_balance = $this->total_payment - $this->total_expense;
    }
}
