<?php

namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;
use PDF;
use App\Models\Translation;

class SalesReport extends Component
{
    public $from_date, $to_date, $orders, $lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.sales-report');
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
    /*processed on update of the element */
    public function updated($name, $value)
    {
        $this->report();
    }
    /* report section */
    public function report()
    {
        $this->orders = \App\Models\Order::whereDate('order_date', '>=', $this->from_date)->whereDate('order_date', '<=', $this->to_date)->where('status', 3)->latest()->get();
    }
    /* download pdf file */
    public function downloadFile()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $pdfContent = PDF::loadView('livewire.admin.reports.download-report.sales-report', compact('from_date', 'to_date'))->output();
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, "SalesReport_from_{$from_date}_to_{$to_date}.pdf");
    }
    
}