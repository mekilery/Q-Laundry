<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Models\Translation;
use Livewire\Component;
use PDF;

class ExpenseReport extends Component
{
    public $from_date, $to_date, $expenses, $lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.expense-report');
    }
    /* processed before render */
    public function mount()
    {
        $this->from_date = \Carbon\Carbon::today()->toDateString();
        $this->to_date = \Carbon\Carbon::today()->toDateString();
        $this->report();
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
    /*processed on update of the element */
    public function updated($name, $value)
    {
        $this->report();
    }
    /* report section */
    public function report()
    {
        $this->expenses = \App\Models\Expense::whereDate('expense_date', '>=', $this->from_date)->whereDate('expense_date', '<=', $this->to_date)->latest()->get();
    }
    /* download pdf file */
    public function downloadFile()
{
    $from_date = $this->from_date;
    $to_date = $this->to_date;
    $pdfContent = PDF::loadView('livewire.admin.reports.download-report.expense-report', compact('from_date', 'to_date'))->output();
    return response()->streamDownload(function () use ($pdfContent) {
        echo $pdfContent;
    }, "ExpenseReport_from_{$from_date}_to_{$to_date}.pdf");
}

}