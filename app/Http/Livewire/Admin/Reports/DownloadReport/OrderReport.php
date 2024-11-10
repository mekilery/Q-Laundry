<?php
namespace App\Http\Livewire\Admin\Reports\DownloadReport;
use Livewire\Component;
class OrderReport extends Component
{  /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.download-report.order-report')      
        ->extends('layouts.print-layout')
        ->section('content');
    }
}