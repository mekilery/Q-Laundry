<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['customer_report'] ?? 'Customer Report' }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{ $lang->data['Customer'] ?? 'Customer Name' }}</label>
                            <input type="text" wire:model="customer_query" class="form-control"
                                placeholder="@if (!$selected_customer) {{ $lang->data['select_a_customer'] ?? 'Select A Customer' }} @else {{ $selected_customer->name }} @endif">
                            @if ($customers && count($customers) > 0)
                                <ul class="list-group customhover">
                                    @foreach ($customers as $row)
                                        <li class="list-group-item customhover2"
                                            wire:click="selectCustomer({{ $row->id }})">
                                            {{ str_pad($row->id, 4, '0', STR_PAD_LEFT) }}-{{ $row->name }} -
                                            {{ $row->phone }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <label>{{ $lang->data['from_date'] ?? 'From Date' }}</label>
                            <input type="date" class="form-control" wire:model="from_date"
                                value="{{ $defaultDate }}">
                        </div>
                        <div class="col-md-2">
                            <label>{{ $lang->data['end_date'] ?? 'Till Date' }}</label>
                            <input type="date" class="form-control" wire:model="to_date">
                        </div>
                        <div class="col-md-4">
                            <label>{{ $lang->data['status'] ?? 'Status' }}</label>
                            <select class="form-select" wire:model="status">
                                <option class="select-box" value="-1">
                                    {{ $lang->data['all_orders'] ?? 'All Orders' }}</option>
                                <option class="select-box" value="0">{{ $lang->data['pending'] ?? 'Pending' }}
                                </option>
                                <option class="select-box" value="1">
                                    {{ $lang->data['processing'] ?? 'Processing' }}</option>
                                <option class="select-box" value="2">
                                    {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</option>
                                <option class="select-box" value="3">{{ $lang->data['delivered'] ?? 'Delivered' }}
                                </option>
                                <option class="select-box" value="4">{{ $lang->data['returned'] ?? 'Returned' }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 15%" class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['date'] ?? 'Date' }}</th>
                                    <th style="width: 15%" class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['order_number'] ?? 'Order Number' }}</th>
                                    <th style="width: 20%" class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['status'] ?? 'Status' }}</th>
                                    <th style="width: 20%" class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['order_amount'] ?? 'Order Amount' }}</th>
                                    <th style="width: 20%" class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['paid_amount'] ?? 'Paid Amount' }}</th>
                                    <th style="width: 20%" class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['Balance_amount'] ?? 'Balance Amount' }}</th>
                                    <th style="width: 30%" class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['Payment_Status'] ?? 'Status' }}</th>

                                </tr>
                            </thead>
                        </table>
                        <div class="table-responsive mb-4 table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-bordered align-items-center mb-0 ">
                                <tbody>
                                    @foreach ($orders as $row)
                                        <tr>
                                            <td style="width: 15%">
                                                <p class="text-xs px-3 mb-0">
                                                    {{ \Carbon\Carbon::parse($row->order_date)->format('d/m/Y') }}
                                                </p>
                                            </td>
                                            <td style="width: 15%">
                                                <p class="text-xs px-3 mb-0">
                                                    <span class="font-weight-bold">{{ $row->order_number }}</span>
                                                </p>
                                            </td>
                                            <td style="width: 20%">
                                                <a type="button"
                                                    class="badge badge-sm bg-secondary text-uppercase">{{ getOrderStatus($row->status) }}</a>
                                            </td>
                                            <td style="width: 20%">
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{ getCurrency() }} {{ number_format($row->total, 3) }}
                                                </p>
                                            </td>
                                            <td style="width: 20%">
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{ getCurrency() }}
                                                    {{ number_format($row->payments->sum('total_paid'), 3) }}
                                                </p>
                                            </td>
                                            <td style="width: 20%">
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{ getCurrency() }}
                                                    {{ number_format($row->total - $row->payments->sum('total_paid'), 3) }}
                                                </p>
                                            </td>
                                            <td style="width: 30%">
                                                @if ($row->total - $row->payments->sum('total_paid') > 0)
                                                    <span
                                                        class="badge bg-danger">{{ $lang->data['unpaid'] ?? 'unPaid' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-success">{{ $lang->data['paid'] ?? 'Paid' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end">
                                            <strong>{{ $lang->data['total'] ?? 'Total' }}:</strong>
                                        </td>
                                        <td style="width: 20%">
                                            <p class="text-md px-3 font-weight-bold mb-0">
                                                {{ getCurrency() }} {{ number_format($totalOrderAmount, 3) }}
                                            </p>
                                        </td>
                                        <td style="width: 20%">
                                            <p class="text-md px-3 font-weight-bold text-success mb-0">
                                                {{ getCurrency() }} {{ number_format($totalPaidAmount, 3) }}
                                            </p>
                                        </td>
                                        <td style="width: 20%">
                                            <p class="text-lg px-3 font-weight-bold text-danger mb-0">
                                                {{ getCurrency() }} {{ number_format($totalBalanceAmount, 3) }}
                                            </p>
                                        </td>
                                        <td style="width: 30%"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
