<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">

            <h5 class="fw-500 text-white">{{ $lang->data['orders_of'] ?? 'Orders of' }} {{ $customer->name ?? '' }}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.customers') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-arrow-left me-2"></i> {{ $lang->data['back'] ?? 'Back' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <div class="card mb-0">
                <div class="card-header p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="text-uppercase fw-500">{{ $sitename ?? '' }}</h4>
                            <p class="text-sm mb-0">{{ $store_email ?? '' }}</p>
                            <p class="text-sm mb-3">{{ $address ?? '' }} - {{ $zipcode ?? '' }}</p>
                            <p class="text-sm mb-0">Phone: {{ $phone ?? '' }}</p>
                            <p class="text-sm mb-0 text-uppercase">
                                {{ $lang->data['tax'] ?? 'VAT' }}:{{ $tax_number ?? '' }}</p>
                        </div>
                        <div class="col-auto text-end mt-4">
                            <h5 class="text-dark text-uppercase fw-500">CUST ID:
                                #{{ str_pad($this->customer->id ?? '', 4, '0', STR_PAD_LEFT) }}</h5>
                            <p class="text-dark fw-500">Cust Name : {{ $this->customer->name ?? '' }}</p>
                            <div class="d-flex justify-content-between mb-1">
                                <label class="me-2">{{ $lang->data['from_date'] ?? 'From Date :' }}</label>
                                <input type="date" class="form-control form-control-sm" wire:model="from_date"
                                    style="height: 30px; width: 150px;">
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <label class="me-2">{{ $lang->data['to_date'] ?? 'To Date     :' }}</label>
                                <input type="date" class="form-control form-control-sm" wire:model="to_date"
                                    value="{{ now()->format('Y-m-d') }}" style="height: 30px; width: 150px;">
                            </div>
                            <div class="d-flex justify-content-between mb-1 align-items-center">
                                <label class="me-2">{{ $lang->data['status'] ?? 'Status    :' }}</label>
                                <select class="form-select form-control-sm py-1" wire:model="status"
                                    style="height: 30px; width: 150px; font-size: 12px;">
                                    <option class="select-box" value="-1">
                                        {{ $lang->data['all_orders'] ?? 'All Orders' }}</option>
                                    <option class="select-box" value="0">{{ $lang->data['pending'] ?? 'Pending' }}
                                    </option>
                                    <option class="select-box" value="1">
                                        {{ $lang->data['processing'] ?? 'Processing' }}</option>
                                    <option class="select-box" value="2">
                                        {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</option>
                                    <option class="select-box" value="3">
                                        {{ $lang->data['delivered'] ?? 'Delivered' }}
                                    </option>
                                    <option class="select-box" value="4">
                                        {{ $lang->data['returned'] ?? 'Returned' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body p-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Order Date</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Order Number</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Delivery Date</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Total</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Paid</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Balance</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-y') }}
                                        </p>
                                    </td>

                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $order->order_number }}
                                        </p>
                                    </td>

                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ $order->status }}

                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-y') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ number_format($order->total, 3) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ number_format($order->payments->sum('total_paid'), 3) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm px-3 mb-0">
                                            {{ number_format($order->total - $order->payments->sum('total_paid'), 3) }}
                                        </p>
                                    </td>


                                    <td>
                                        <a href="{{ route('admin.view_single_order', $order->id) }}" type="button"
                                            class="badge badge-xs badge-primary fw-600 text-xs">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-2">



        </div>
    </div>
</div>
