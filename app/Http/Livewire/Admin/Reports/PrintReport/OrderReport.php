<?php
namespace App\Http\Livewire\Admin\Reports\PrintReport;
use Livewire\Component;
class OrderReport extends Component
{
    public $from_date,$to_date,$orders,$status=-1;
    /* render the content */
    public function render()
    {
        return view('livewire.admin.reports.print-report.order-report')
        ->extends('layouts.print-layout')
        ->section('content');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null, $status = null) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->status = $status;
        if($this->status == -1) {
            $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->latest()->get();
       } else {
            $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->where('status',$this->status)->latest()->get();
       }
    }
}