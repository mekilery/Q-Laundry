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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order List</h3>
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
                                <a href="{{ route('admin.view_single_order', $order->id) }}"
                                    class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
