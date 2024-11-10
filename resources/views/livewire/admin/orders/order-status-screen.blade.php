<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['order_status_screen'] ?? 'Order Status Screen' }}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.create_orders') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{ $lang->data['add_new_order'] ?? 'Add New Order' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="scrum-board-container">
                    <div class="flex">
                        <div class="scrum-board pending">
                            <h5 class="text-uppercase text-secondary">{{ $lang->data['pending'] ?? 'Pending' }}</h5>
                            <div class="scrum-board-column" id="pending">
                                @foreach ($pending_orders as $item)
                                    <div class="{{ getOrderStatusWithColorKan($item->status) }} overflow"
                                        id="{{ $item->id }}">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <span
                                                    class="fw-600 ms-2 text-sm text-dark">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                                <div class="ms-2 mb-0">
                                                    <span
                                                        class="text-xs">{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:</span>
                                                    <span
                                                        class="text-xs fw-600 ms-2">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div><span
                                                    class="fw-600 text-dark text-sm me-2">{{ $item->order_number }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $services = \App\Models\OrderDetails::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                        <div class="pt-1 mb-0">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                                <a class="avatar avatar-sm ms-2 p-1 bg-light">
                                                    <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="scrum-board-processing processing">
                            <h5 class="text-uppercase text-warning">{{ $lang->data['processing'] ?? 'Processing' }}
                            </h5>
                            <div class="scrum-board-column" id="processing">
                                @foreach ($processing_orders as $item)
                                    <div class="{{ getOrderStatusWithColorKan($item->status) }} overflow"
                                        id="{{ $item->id }}">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <span
                                                    class="fw-600 text-sm ms-2 text-dark">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                                <div class="ms-2 mb-0">
                                                    <span
                                                        class="text-xs">{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:</span>
                                                    <span
                                                        class="text-xs fw-600 ms-2">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div><span
                                                    class="fw-600 text-sm text-dark me-2">{{ $item->order_number }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $services = \App\Models\OrderDetails::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                        <div class="pt-1 mb-0">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                                <a class="avatar avatar-sm ms-2 p-1 bg-light">
                                                    <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}">
                                                </a>
                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="scrum-board ready">
                            <h5 class="text-uppercase text-success">
                                {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</h5>
                            <div class="scrum-board-column" id="ready">
                                @foreach ($ready_orders as $item)
                                    <div class="{{ getOrderStatusWithColorKan($item->status) }} overflow"
                                        id="{{ $item->id }}">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <span
                                                    class="fw-600 ms-2 text-sm text-dark">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                                <div class="ms-2 mb-0">
                                                    <span
                                                        class="text-xs">{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:</span>
                                                    <span
                                                        class="text-xs fw-600 ms-2">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div><span
                                                    class="fw-600 text-sm text-dark me-2">{{ $item->order_number }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $services = \App\Models\OrderDetails::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                        <div class="pt-1 mb-0">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                                <a class="avatar avatar-sm ms-2 p-1 bg-light">
                                                    <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}">
                                                </a>
                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
             "use strict";
            var drake = dragula([document.querySelector('#ready'), document.querySelector('#processing'), document
                .querySelector('#pending')
            ]);
            drake.on("drop", function(el, target, source, sibling) {

                @this.changestatus(el.id, target.id);
            });
        </script>
    @endpush
</div>