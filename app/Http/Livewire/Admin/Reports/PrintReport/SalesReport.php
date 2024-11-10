<?php
namespace App\Http\Livewire\Admin\Reports\PrintReport;
use Livewire\Component;
class SalesReport extends Component
{
    public $from_date,$to_date,$orders;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.print-report.sales-report')
        ->extends('layouts.print-layout')
        ->section('content');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->where('status',3)->latest()->get();
    }
}