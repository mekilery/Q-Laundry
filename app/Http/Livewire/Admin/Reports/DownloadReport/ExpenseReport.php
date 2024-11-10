<?php
namespace App\Http\Livewire\Admin\Reports\DownloadReport;
use Livewire\Component;
class ExpenseReport extends Component
{
    public $expenses, $from_date, $to_date;
    /* render the page*/
    public function render()
    {
        return view('livewire.admin.reports.download-report.expense-report')        
        ->extends('layouts.print-layout')
        ->section('content');
    }
}