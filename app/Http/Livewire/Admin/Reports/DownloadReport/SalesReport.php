<?php
namespace App\Http\Livewire\Admin\Reports\DownloadReport;
use Livewire\Component;
class SalesReport extends Component
{   /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.download-report.sales-report')
        ->extends('layouts.print-layout')
        ->section('content');
    }
}