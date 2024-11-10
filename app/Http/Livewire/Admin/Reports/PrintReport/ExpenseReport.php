<?php
namespace App\Http\Livewire\Admin\Reports\PrintReport;
use Livewire\Component;
class ExpenseReport extends Component
{
    public $expenses, $from_date, $to_date;
    /* render the page*/
    public function render()
    {
        return view('livewire.admin.reports.print-report.expense-report')
        ->extends('layouts.print-layout')
        ->section('content');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->expenses = \App\Models\Expense::whereDate('expense_date','>=',$this->from_date)->whereDate('expense_date','<=',$this->to_date)->latest()->get();
    }
}