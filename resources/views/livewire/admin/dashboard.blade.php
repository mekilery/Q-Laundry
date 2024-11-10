<div>
<div class="row" wire:poll>
    <div class="col-lg-12">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row align-items-center px-2">
                            <div class="col-8">
                                <div class="numbers py-2">
                                    <p class="text-sm mb-3 text-uppercase">{{$lang->data['pending_order'] ?? 'Pending Orders'}}</p>
                                    <h5 class="font-weight-bolder">
                                        {{$pending_count}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-secondary text-center rounded-circle">
                                    <i class="ni ni-basket text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row align-items-center px-2">
                            <div class="col-8">
                                <div class="numbers py-2">
                                    <p class="text-sm mb-3 text-uppercase">{{$lang->data['processing_order'] ?? 'Processing Order'}}</p>
                                    <h5 class="font-weight-bolder">
                                        {{$processing_count}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-warning text-center rounded-circle">
                                    <i class="ni ni-atom text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row align-items-center px-2">
                            <div class="col-8">
                                <div class="numbers py-2">
                                    <p class="text-sm mb-3 text-uppercase">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}</p>
                                    <h5 class="font-weight-bolder">
                                        {{$ready_count}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-success text-center rounded-circle">
                                    <i class="ni ni-like-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row align-items-center px-2">
                            <div class="col-8">
                                <div class="numbers py-2">
                                    <p class="text-sm mb-3 text-uppercase">{{$lang->data['delivered_orders'] ?? 'Delivered Orders'}}</p>
                                    <h5 class="font-weight-bolder">
                                        {{$delivered_count}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-primary text-center rounded-circle">
                                    <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header pb-4 pt-3">
                <div class="row g-2 align-items-center">
                    <div class="col-4">
                        <h5 class="pb-0 fw-500">{{$lang->data['todays_delivery'] ?? "Today's Delivery"}}</h5>
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" placeholder="{{$lang->data['search_here'] ?? 'Search Here...'}}" wire:model="search_query">
                    </div>
                    <div class="col-3">
                        <select class="form-select" wire:model="order_filter">
                            <option class="select-box" value="">{{$lang->data['all_orders'] ?? 'All Orders'}}</option>
                            <option class="select-box" value="0">{{$lang->data['pending'] ?? 'Pending'}}</option>
                            <option class="select-box" value="1">{{$lang->data['processing'] ?? 'Processing'}}</option>
                            <option class="select-box" value="2">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}</option>
                            <option class="select-box" value="3">{{$lang->data['delivered'] ?? 'Delivered'}}</option>
                            <option class="select-box" value="4">{{$lang->data['returned'] ?? 'Returned'}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 align-items-center">
                    @foreach ($orders as $item)
                    <div class="col-lg-4 col-12">
                        <div class="{{getOrderStatusWithColor($item->status)}}">
                            <div class="d-flex justify-content-between mb-2">
                                <a href="{{route('admin.view_single_order',$item->id)}}" type="button">
                                    <span class="fw-600 ms-2 text-dark text-xs mb-0">{{$item->customer_name?? $lang->data['walk_in_customer'] ?? 'Walk In Customer'}}</span>
                                </a>
                                <a href="{{route('admin.view_single_order',$item->id)}}" type="button">
                                    <span class="fw-600 text-dark text-xs me-2">{{$item->order_number}}</span>
                                </a>
                            </div>
                            @php
                                $services = \App\Models\OrderDetails::where('order_id',$item->id)->limit(4)->get();
                            @endphp
                            <div class="pt-1 mb-0">
                                @foreach ($services as $row)
                                    @php
                                        $service = \App\Models\Service::where('id',$row->service_id)->first();
                                    @endphp
                                <a class="avatar avatar-sm ms-2 p-1 bg-light">
                                    <img src="{{asset('assets/img/service-icons/'.$service->icon)}}">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4" >
        <div class="card">
            <div class="card-header pb-0">
                <h5 class="pb-4 fw-500">{{$lang->data['overview'] ?? 'Overview'}}</h5>
            </div>
            <div class="card-body pt-0 pb-2">
                <div class="row">
                    <div class="col-12 text-start mb-4" wire:ignore>
                        <div class="chart">
                            <canvas id="doughnut-chart" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-md badge-dot ms-4 text-start">
                                <i class="bg-secondary"></i>
                                <span class="text-dark text-xs">{{$lang->data['pending'] ?? 'Pending'}}</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4 text-start">
                                <i class="bg-warning"></i>
                                <span class="text-dark text-xs">{{$lang->data['processing'] ?? 'Processing'}}</span>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-md badge-dot ms-4 text-start">
                                <i class="bg-success"></i>
                                <span class="text-dark text-xs">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4 text-start">
                                <i class="bg-primary"></i>
                                <span class="text-dark text-xs">{{$lang->data['delivered'] ?? 'Delivered'}}</span>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-md badge-dot ms-4 text-start">
                                <i class="bg-danger"></i>
                                <span class="text-dark text-xs">{{$lang->data['returned'] ?? 'Returned'}}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="chartdata" value="{{$array}}">
@push('js')
<script>
    "use strict";
    var ctx3 = document.getElementById("doughnut-chart").getContext("2d");
    var chartdata = document.getElementById("chartdata").value;
    new Chart(ctx3, {
        type: "doughnut",
        data: {
            datasets: [{
                label: "Projects",
                weight: 9,
                cutout: 60,
                tension: 0.9,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: ['#8392ab', '#faae42', '#2dce89', '#0083ff', '#f5365c'],
                data: JSON.parse(chartdata),
                fill: false
            }],
            labels: ['Pending', 'Processing', 'Ready to Deliver', 'Delivered', 'Returned'],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: true,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    ticks: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    ticks: {
                        display: false,
                    }
                },
            },
        },
    });
</script>
@endpush
</div>