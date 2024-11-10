<div>
<div class="row align-items-center justify-content-between mb-4">
    <div class="col">
        <h5 class="fw-500 text-white">{{$lang->data['daily_report'] ?? 'Daily Report'}}</h5>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-md-4">
                        <label>{{$lang->data['date'] ?? 'Date'}}</label>
                        <input type="date" class="form-control" wire:model="today">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['particulars'] ?? 'Particulars'}}</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['value'] ?? 'Value'}}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$lang->data['orders'] ?? 'Orders'}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold text-warning mb-0">{{$new_order}}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$lang->data['no_of_orders_delivered'] ?? 'No. of Orders Delivered'}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold text-primary mb-0">{{$delivered_orders}}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$lang->data['total_sales'] ?? 'Total Sales'}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold text-success mb-0">{{getCurrency()}}{{number_format($total_sales,2)}}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$lang->data['total_payment'] ?? 'Total Payment'}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold text-info mb-0">{{getCurrency()}}{{number_format($total_payment,2)}}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$lang->data['total_expense'] ?? 'Total Expense'}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold text-danger mb-0">{{getCurrency()}}{{number_format($total_expense,2)}}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>