<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['daily_report'] ?? 'Daily Report' }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{ $lang->data['date'] ?? 'Date' }}</label>
                            <input type="date" class="form-control" wire:model="today">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['particulars'] ?? 'Particulars' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['value'] ?? 'Details' }}</th>

                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['value'] ?? 'Amount' }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">{{ $lang->data['orders'] ?? 'Orders' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Nos : {{ $new_order }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ getCurrency() }} {{ number_format($total_sales, 3) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $lang->data['no_of_orders_delivered'] ?? 'No. of Orders Delivered' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold text-primary mb-0">Nos. :
                                            {{ $delivered_orders }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ getCurrency() }} {{ number_format($delivered_orders_amount, 3) }}</p>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $lang->data['total_receipts'] ?? 'Total Receipts' }}
                                        </p>
                                    </td>
                                    <td>
                                        @foreach ($total_payment_by_type as $payment)
                                            <div
                                                class="text-sm font-weight-bold mb-0 d-flex flex-row justify-content-around">
                                                <span>{{ $payment->paymentType->name }} </span>:<span>
                                                    {{ getCurrency() }}
                                                    {{ number_format($payment->total_amount, 3) }}</span>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="text-sm font-weight-bold mb-0 d-flex align-items-end">
                                            {{ getCurrency() }} {{ number_format($total_payment, 3) }}
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $lang->data['total_expense'] ?? 'Total Expense' }}</p>
                                    </td>
                                    <td>
                                        @foreach ($total_expense_by_type as $payment)
                                            <h5 class="text-sm fw-bold mb-0 d-flex justify-content-around">
                                                <span>{{ $payment->paymentType->name }}</span>:<span>
                                                    {{ getCurrency() }}
                                                    {{ number_format($payment->total_amount, 3) }}</span>
                                            </h5>
                                        @endforeach

                                    </td>
                                    <td>
                                        <h5 class="text-sm font-weight-bold mb-0 text-danger d-flex align-items-end">
                                            {{ getCurrency() }} {{ number_format($total_expense, 3) }}</h5>

                                    </td>

                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $lang->data['overall_balance'] ?? 'Overall Balance' }}</p>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <h5 class="text-sm font-weight-bold mb-0 d-flex align-items-end">
                                            {{ getCurrency() }} {{ number_format($overall_balance, 3) }}</h5>

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
