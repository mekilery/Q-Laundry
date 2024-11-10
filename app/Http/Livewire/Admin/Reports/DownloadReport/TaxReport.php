<?php
namespace App\Http\Livewire\Admin\Reports\DownloadReport;
use Livewire\Component;
class TaxReport extends Component
{   /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.download-report.tax-report')      
        ->extends('layouts.print-layout')
        ->section('content');
    }
}