<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">

            <h5 class="fw-500 text-white">{{ $lang->data['orders_of'] ?? 'Orders of' }} {{ $customer->name }}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.customers') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-arrow-left me-2"></i> {{ $lang->data['back'] ?? 'Back' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="text-uppercase fw-500">{{ $sitename }}</h4>
                            <p class="text-sm mb-0">{{ $store_email }}</p>
                            <p class="text-sm mb-3">{{ $address }} - {{ $zipcode }}</p>
                            <p class="text-sm mb-0">Phone: {{ $phone }}</p>
                            <p class="text-sm mb-0 text-uppercase">
                                {{ $lang->data['tax'] ?? 'VAT' }}:{{ $tax_number }}</p>
                        </div>
                        <div class="col-auto">
                            <h5 class="text-dark text-uppercase fw-500">
                                {{ $this->customer->name }}-{{ $this->customer->id }}</h5>
                            <p class="text-dark text-uppercase fw-500">{{ $this->customer->address }}</p>
                            <p class="text-dark text-uppercase fw-500">{{ $this->customer->phone }}</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->delivery_date }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->status }}</td>
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
</div>
