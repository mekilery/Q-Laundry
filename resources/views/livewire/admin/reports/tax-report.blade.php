<div>
<div class="row align-items-center justify-content-between mb-4">
    <div class="col">
        <h5 class="fw-500 text-white">{{$lang->data['tax_report'] ?? 'Tax Report'}}</h5>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-md-4">
                        <label>{{$lang->data['start_date'] ?? 'Start Date'}}</label>
                        <input type="date" class="form-control" wire:model="from_date">
                    </div>
                    <div class="col-md-4">
                        <label>{{$lang->data['end_date'] ?? 'End Date'}}</label>
                        <input type="date" class="form-control" wire:model="to_date">
                    </div>
                    <div class="col-md-4">
                        <label>{{$lang->data['filter'] ?? 'Filter'}}</label>
                        <select class="form-select" wire:model="category">
                            <option class="select-box" value="1">{{$lang->data['sales'] ?? 'Sales'}}</option>
                            <option class="select-box" value="2">{{$lang->data['expense'] ?? 'Expense'}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                <th style="width: 15%" class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['date'] ?? 'Date'}}</th>
                                <th style="width: 20%" class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['particulars'] ?? 'Particulars'}} #</th>
                                <th style="width: 20%" class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['before_tax'] ?? 'Before Tax'}}</th>
                                <th style="width: 20%" class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                                <th style="width: 20%" class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['total_amount'] ?? 'Total Amount'}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive mb-4 table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered align-items-center mb-0 ">
                        <tbody>
                            @php
                            $tax_amount_total_expense = 0;
                            $tax_amount_total_sales = 0;
                            $tax_amount_sales =0;
                            $tax_amount_expense = 0;
                            $i=1;
                            @endphp
                            @foreach($reports as $row)
                            <tr>
                                <td style="width: 5%" >
                                    <p class="text-xs px-3  mb-0">
                                        {{$i++}}
                                    </p>
                                </td>
                                <td style="width: 15%" >
                                    <p class="text-xs px-3  mb-0">
                                        {{-- sales --}}
                                        @if($category ==1 )
                                        {{\Carbon\Carbon::parse($row->order_date)->format('d/m/Y')}}
                                        @endif
                                        {{-- expense --}}
                                        @if($category == 2) 
                                        {{\Carbon\Carbon::parse($row->expense_date)->format('d/m/Y')}}
                                        @endif
                                    </p>
                                </td>
                                {{-- sales --}}
                                @if($category==1)
                                @php
                                $tax_amount_sales = $row->total * ($row->tax_percentage/100); 
                                $tax_amount_total_sales +=$tax_amount_sales;
                                @endphp

                                @endif
                                {{-- expense --}}
                                @if($category==2)
                                @php
                                $tax_amount_expense = $row->expense_amount * ($row->tax_percentage/100); 
                                $tax_amount_total_expense +=$tax_amount_expense;
                               @endphp
                               @endif
                                <td style="width: 20%" >
                                    <p class="text-xs px-3 mb-0">
                                        <span class="font-weight-bold">
                                            {{-- sales --}}
                                            @if($category ==1 )
                                               {{$row->order_number}}
                                            @endif
                                            {{-- expense --}}
                                            @if($category == 2) 
                                               {{$row->expenseCategory->expense_category_name ?? ""}}
                                            @endif
                                        </span>
                                    </p>
                                </td>
                                <td style="width: 20%" >
                                    <p class="text-xs px-3 font-weight-bold mb-0">
                                        {{-- sales --}}
                                        @if($category ==1 )
                                        {{getCurrency()}} {{number_format($row->total-$tax_amount_sales,2)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getCurrency()}}{{number_format($row->expense_amount-$tax_amount_expense,2)}}
                                     @endif
                                </td>
                                <td style="width: 20%" >
                                    <p class="text-xs px-3 font-weight-bold mb-0">
                                        {{-- sales --}}
                                        @if($category ==1 )
                                        {{getCurrency()}} {{number_format($tax_amount_sales,2)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getCurrency()}} {{number_format($tax_amount_expense,2)}}
                                     @endif
                                    </p>
                                </td>
                                <td style="width: 20%" >
                                    <p class="text-xs px-3 font-weight-bold mb-0">
                                        {{-- sales --}}
                                        @if($category ==1 )
                                        {{getCurrency()}}{{number_format($row->total,2)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getCurrency()}}{{number_format($row->expense_amount,2)}}
                                     @endif
                                    </p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center px-4 mb-3">
                    <div class="col">
                        <span class="text-sm mb-0 fw-500">{{$lang->data['total_amount'] ?? 'Total Amount'}}:</span>
                        <span class="text-sm text-dark ms-2 fw-600 mb-0">
                            {{-- sales --}}
                         @if($category ==1 )
                            {{getCurrency()}}{{number_format($reports->sum('total'),2)}}
                         @endif
                         {{-- expense --}}
                         @if($category == 2) 
                         {{getCurrency()}}{{number_format($reports->sum('expense_amount'),2)}}
                         @endif
                        </span>
                    </div>
                    <div class="col">
                        <span class="text-sm mb-0 fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                        <span class="text-sm text-dark ms-2 fw-600 mb-0">
                            {{-- sales --}}
                        @if($category ==1 )
                        {{getCurrency()}} {{number_format($tax_amount_total_sales,2)}}
                         @endif
                         {{-- expense --}}
                         @if($category == 2) 
                         {{getCurrency()}} {{number_format($tax_amount_total_expense,2)}}
                         @endif
                        </span>
                    </div>
                    <div class="col-auto">
                        <button type="button" wire:click="downloadFile()" class="btn btn-success me-2 mb-0">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                        <a href="{{url('admin/reports/print-report/tax/'.$from_date.'/'.$to_date.'/'.$category)}}" target="_blank">
                            <button type="submit" class="btn btn-warning mb-0">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>