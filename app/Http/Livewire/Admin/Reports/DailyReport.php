<?php
namespace App\Http\Livewire\Admin\Reports;
use App\Models\Translation;
use Livewire\Component;
class DailyReport extends Component
{
    public $today, $new_order, $delivered_orders, $total_payment, $total_expense, $total_sales,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.daily-report');
    }
    /* processed before render */
    public function mount() {
        $this->today =\Carbon\Carbon::today()->toDateString();
        if(session()->has('selected_language'))
        {
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->report();
    }
    /*processed on update of the element */
    public function updated($name,$value) {
        /* any updated on $today model */
        if(($name="today") && ($value!=""))
         {
             $this->today = $value;
        }
        $this->report();
    }
    /* report section */ 
    public function report(){
             $this->new_order = \App\Models\Order::whereDate('order_date',$this->today)->count();
             $this->delivered_orders = \App\Models\Order::whereDate('order_date',$this->today)->where('status',3)->count();
             $this->total_payment = \App\Models\Payment::whereDate('payment_date',$this->today)->sum('received_amount');
             $this->total_expense = \App\Models\Expense::whereDate('expense_date',$this->today)->sum('expense_amount');
             $this->total_sales = \App\Models\Order::whereDate('order_date',$this->today)->where('status',3)->sum('total');
    }
}