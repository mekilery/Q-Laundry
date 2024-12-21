<div>
    @php
        $printer_type = getPrinterType();
    @endphp
    @if ($printer_type == 1)
        <!DOCTYPE html
            PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>{{ $lang->data['print_invoice'] ?? 'Print Invoice' }}</title>
            <link href="https://fonts.googleapis.com/css?family=Calibri:400,700,400italic,700italic">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
                rel="stylesheet">
            <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" crossorigin="anonymous"></script>
            <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" crossorigin="anonymous"></script>
            <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
            <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
            <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
            <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.min28b5.css?v=2.0.0') }}"
                rel="stylesheet" />
            <link id="pagestyle" href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
        </head>

        <body onload="printAndClose();">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-header p-4">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="text-uppercase fw-500">{{ $sitename }}</h5>
                                    <p class="text-sm mb-0">{{ $phone }}</p>
                                    <p class="text-sm mb-0">{{ $store_email }}</p>
                                    <p class="text-sm mb-3">{{ $address }} - {{ $zipcode }}</p>
                                    <p class="text-sm mb-0 text-uppercase"> {{ $lang->data['tax'] ?? 'TAX' }}:
                                        {{ $tax_number }}</p>
                                </div>
                                <div class="col-4 mt-4">
                                    <h6 class="text-uppercase fw-500">
                                        <span> {{ $lang->data['order_id'] ?? 'Order ID' }}:</span>
                                        <span class="ms-2 fw-600">#{{ $order->order_number }}</span>
                                    </h6>
                                    <p class="text-sm mb-1">
                                        <span> {{ $lang->data['order_date'] ?? 'Order Date' }}:</span>
                                        <span
                                            class="fw-600 ms-2">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                    </p>
                                    <p class="text-sm mb-3">
                                        <span> {{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:
                                            <span
                                                class="fw-600 ms-2">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span></span>
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div><span class="text-sm">
                                                {{ $lang->data['order_status'] ?? 'Order Status' }}:</span></div>
                                        <div class="dropdown ms-2">
                                            <button class="btn btn-xs bg-secondary  mb-0 text-white" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ getOrderStatus($order->status) }}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click.prevent="changeStatus(1)">{{ $lang->data['processing'] ?? 'Processing' }}</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click.prevent="changeStatus(2)">{{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click.prevent="changeStatus(3)">{{ $lang->data['delivered'] ?? 'Delivered' }}</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click.prevent="changeStatus(4)">{{ $lang->data['returned'] ?? 'Returned' }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th class="text-uppercase text-white text-xs ">#</th>
                                            <th class="text-uppercase text-white text-xs ">
                                                {{ $lang->data['service_name'] ?? 'Service Name' }}</th>
                                            <th class="text-uppercase text-white text-xs ">
                                                {{ $lang->data['rate'] ?? 'Rate' }}</th>
                                            <th class="text-center text-uppercase text-white text-xs ">
                                                {{ $lang->data['qty'] ?? 'QTY' }}</th>
                                            <th class="text-uppercase text-white text-xs ">
                                                {{ $lang->data['total'] ?? 'Total' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderdetails as $item)
                                            @php
                                                $service = \App\Models\Service::where('id', $item->service_id)->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p class="text-sm px-3 mb-0">{{ $loop->index + 1 }}</p>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div>
                                                            <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}"
                                                                class="avatar avatar-sm me-3">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-1 text-sm">{{ $service->service_name }}
                                                            </h6>
                                                            <span
                                                                class="text-xs fw-600 text-primary">[{{ $item->service_name }}]</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <p class="text-sm px-3 mb-0">{{ getCurrency() }}
                                                        {{ number_format($item->service_price, 3) }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-sm px-3 mb-0">{{ $item->service_quantity }}</p>
                                                </td>
                                                <td class="">
                                                    <p class="text-sm px-3 mb-0">{{ getCurrency() }}
                                                        {{ number_format($item->service_detail_total, 3) }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="mb-0 mt-0 bg-secondary">
                        <div class="card-footer px-4">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <h6 class="mb-2 fw-500">{{ $lang->data['addons'] ?? 'Addons' }}:</h6>
                                    @foreach ($orderaddons as $item)
                                        <p class="text-sm mb-1">{{ $item->addon_name ?? '' }} : <b>
                                                {{ getCurrency() }}{{ $item->addon_price }} </b></p>
                                    @endforeach
                                </div>
                                <div class="col-4 mb-3">
                                    <h6 class="mb-2 fw-500">{{ $lang->data['invoice_to'] ?? 'Invoice To' }}:</h6>
                                    <h6 class="mb-1 fw-500 text-sm">{{ $customer->name ?? 'Walk-In Customer' }}</h6>
                                    <p class="text-sm mb-0">{{ $customer->phone ?? '' }}</p>
                                    <p class="text-sm mb-0">{{ $customer->email ?? '' }}</p>
                                    <p class="text-sm mb-3">{{ $customer->address ?? '' }}</p>
                                    @if ($customer)
                                        <p class="text-sm mb-0">{{ $lang->data['vat'] ?? '' }}:
                                            {{ $customer->tax_number ?? '' }}</p>
                                    @endif
                                </div>
                                <div class="col-4 mb-3">
                                    <h6 class="fw-500 mb-2">
                                        {{ $lang->data['payment_details'] ?? 'Payment Details' }}:</h6>
                                    <div class="">
                                        <div class="row mb-50 align-items-center">
                                            <div class="col text-sm">{{ $lang->data['sub_total'] ?? 'Sub Total' }}:
                                            </div>
                                            <div class="col-auto text-sm">{{ getCurrency() }}
                                                {{ number_format($order->sub_total, 3) }}</div>
                                        </div>
                                        <div class="row mb-50 align-items-center">
                                            <div class="col text-sm">{{ $lang->data['addon'] ?? 'Addon' }}:</div>
                                            <div class="col-auto text-sm">{{ getCurrency() }}
                                                {{ number_format($order->addon_total, 3) }}</div>
                                        </div>
                                        <div class="row mb-50 align-items-center">
                                            <div class="col text-sm">{{ $lang->data['discount'] ?? 'Discount' }}:
                                            </div>
                                            <div class="col-auto text-sm">{{ getCurrency() }}
                                                {{ number_format($order->discount, 3) }}</div>
                                        </div>
                                        <div class="row mb-3 align-items-center">
                                            <div class="col text-sm">{{ $lang->data['tax'] ?? 'Tax' }}
                                                ({{ $order->tax_percentage }}%):</div>
                                            <div class="col-auto text-sm">{{ getCurrency() }}
                                                {{ number_format($order->tax_amount, 3) }}</div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col text-sm fw-600">
                                                {{ $lang->data['gross_total'] ?? 'Gross Total' }}:</div>
                                            <div class="col-auto text-sm text-dark fw-600">{{ getCurrency() }}
                                                {{ number_format($order->total, 3) }}</div>
                                        </div>

                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="col-md-1">
                                    <h6 class="mb-2 text-sm fw-500">{{ $lang->data['notes'] ?? 'Notes' }}:</h6>
                                </div>
                                <div class="col-md-11">
                                    <p class="text-sm mb-0">{{ $order->note }}</p>
                                </div>
                                <div class="mt-4 position-relative text-center">
                                    <p
                                        class="text-sm fw-500 mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                        {{ $lang->data['powered_by'] ?? 'Powered by' }} <a href="{{ url('/') }}"
                                            class="text-dark fw-600" target="_blank">{{ getApplicationName() }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        </html>
    @endif
    @if ($printer_type == 2)
        <!DOCTYPE html
            PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="image/png"; charset="utf-8" />
            <title>{{ $lang->data['print_invoice'] ?? 'Print Invoice' }}</title>
            <link href="https://fonts.googleapis.com/css?family=Calibri:400,700,400italic,700italic">
            <style>
                @page {
                    size: auto;
                    margin: 0mm 5mm;
                }

                body {

                    margin: 0px;
                    font-family: Calibri;
                }

                @media print {
                    .pagebreak {
                        clear: both;
                        page-break-after: always;
                    }
                }

                @media screen {

                    .header,
                    .footer {
                        display: none;
                    }
                }
            </style>
            <style>
                .mb-0 {
                    margin-bottom: 0;
                }

                .my-50 {
                    margin-top: 50px;
                    margin-bottom: 50px;
                }

                .my-0 {
                    margin-top: 0;
                    margin-bottom: 0;
                }

                .my-5 {
                    margin-top: 5px;
                    margin-bottom: 5px;
                }

                .mt-10 {
                    margin-top: 10px;
                }

                .mb-15 {
                    margin-bottom: 15px;
                }

                .mr-18 {
                    margin-right: 18px;
                }

                .mr-25 {
                    margin-right: 25px;
                }

                .mb-25 {
                    margin-bottom: 25px;
                }

                .h4,
                .h5,
                .h6,
                h4,
                h5,
                h6 {
                    margin-top: 10px;
                    margin-bottom: 10px;
                }

                .login-wrapper {
                    background-size: 100% 100%;
                    height: 100vh;
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }

                .login-wrapper:before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    display: block;
                    background: rgba(0, 0, 0, 0.5);
                }

                .login_box {
                    text-align: center;
                    position: relative;
                    width: 400px;
                    background: #343434;
                    padding: 40px 30px;
                    border-radius: 10px;
                }

                .login_box .form-control {
                    height: 60px;
                    margin-bottom: 25px;
                    padding: 12px 25px;
                }

                .btn-login {
                    color: #fff;
                    background-color: #45C203;
                    border-color: #45C203;
                    width: 100%;
                    line-height: 45px;
                    font-size: 17px;
                }

                .btn-login:hover,
                .btn-login:focus {
                    color: #fff;
                    background-color: transparent;
                    border-color: #fff;
                }

                .invoice-card {
                    display: flex;
                    flex-direction: column;
                    width: 80mm;
                    background-color: #fff;
                    border-radius: 5px;

                    margin: 35px auto;
                }

                .invoice-head,
                .invoice-card .invoice-title {
                    display: -webkit-flex;
                    display: -moz-flex;
                    display: -ms-flex;
                    display: -o-flex;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .invoice-title {
                    background-color: #000000 !important;
                    color: #ffffff !important;
                    padding: 10px;
                    -webkit-print-color-adjust: exact;
                }

                .invoice-head {
                    flex-direction: column;
                    margin-bottom: 4px;
                }

                .invoice-card .invoice-title {
                    margin: 15px 0;
                }

                .invoice-details {
                    border-top: 0.5px dashed #747272;
                    border-bottom: 0.5px dashed #747272;
                }

                .invoice-list {
                    width: 100%;
                    border-collapse: collapse;
                    border-bottom: 1px dashed #858080;
                }

                .invoice-list .row-data {
                    border-bottom: 1px dashed #858080;
                }

                .invoice-list .row-data:last-child {
                    border-bottom: 0;
                    margin-bottom: 0;
                }

                .invoice-list .heading {
                    font-size: 16px;
                    font-weight: 600;
                    margin: 0;
                }

                .invoice-list .heading1 {
                    font-size: 14px;
                    font-weight: 500;
                    margin: 0;
                }

                .invoice-list thead tr td {
                    font-size: 15px;
                    font-weight: 600;
                    padding: 5px 0;
                }

                .invoice-list tbody tr td {
                    line-height: 25px;
                }

                .row-data {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    width: 100%;
                }

                .middle-data {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .item-info {
                    max-width: 200px;
                }

                .item-info-small {
                    width: 40%;
                    margin-top: 5px;
                    margin-bottom: 5px;
                }

                .item-info-big {
                    width: 60%;
                    margin-top: 5px;
                    margin-bottom: 5px;
                }

                .item-title {
                    font-size: 14px;
                    margin: 0;
                    line-height: 19px;
                    font-weight: 500;
                }

                .item-size {
                    line-height: 19px;
                }

                .item-size,
                .item-number {
                    margin: 5px 0;
                }

                .invoice-footer {
                    margin-top: 20px;
                }

                .gap_right {
                    border-right: 1px solid #ddd;
                    padding-right: 15px;
                    margin-right: 15px;
                }

                .b_top {
                    border-top: 1px solid #ddd;
                    padding-top: 12px;
                }

                .food_item {
                    display: -webkit-flex;
                    display: -moz-flex;
                    display: -ms-flex;
                    display: -o-flex;
                    display: flex;
                    align-items: center;
                    border: 1px solid #ddd;
                    border-top: 5px solid #1DB20B;
                    padding: 15px;
                    margin-bottom: 25px;
                    transition-duration: 0.4s;
                }

                .bhojon_title {
                    margin-top: 6px;
                    margin-bottom: 6px;
                    font-size: 14px;
                }

                .food_item .img_wrapper {
                    padding: 15px 5px;
                    background-color: #ececec;
                    border-radius: 6px;
                    position: relative;
                    transition-duration: 0.4s;
                }

                .food_item .table_info {
                    font-size: 11px;
                    background: #1db20b;
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 4px 8px;
                    color: #fff;
                    border-radius: 15px;
                    text-align: center;
                }

                .food_item:focus,
                .food_item:hover {
                    background-color: #383838;
                }

                .food_item:focus .bhojon_title,
                .food_item:hover .bhojon_title {
                    color: #fff;
                }

                .food_item:hover .img_wrapper,
                .food_item:focus .img_wrapper {
                    background-color: #383838;
                }

                .btn-4 {
                    border-radius: 0;
                    padding: 15px 22px;
                    font-size: 16px;
                    font-weight: 500;
                    color: #fff;
                    min-width: 130px;
                }

                .btn-4.btn-green {
                    background-color: #1DB20B;
                }

                .btn-4.btn-green:focus,
                .btn-4.btn-green:hover {
                    background-color: #3aa02d;
                    color: #fff;
                }

                .btn-4.btn-blue {
                    background-color: #115fc9;
                }

                .btn-4.btn-blue:focus,
                .btn-4.btn-blue:hover {
                    background-color: #305992;
                    color: #fff;
                }

                .btn-4.btn-sky {
                    background-color: #1ba392;
                }

                .btn-4.btn-sky:focus,
                .btn-4.btn-sky:hover {
                    background-color: #0dceb6;
                    color: #fff;
                }

                .btn-4.btn-paste {
                    background-color: #0b6240;
                }

                .btn-4.btn-paste:hover,
                .btn-4.btn-paste:focus {
                    background-color: #209c6c;
                    color: #fff;
                }

                .btn-4.btn-red {
                    background-color: #eb0202;
                }

                .btn-4.btn-red:focus,
                .btn-4.btn-red:hover {
                    background-color: #ff3b3b;
                    color: #fff;
                }

                .text-center {
                    text-align: center;
                }

                .border-top {
                    border-top: 2px dashed #858080;
                    background: #ececec;
                }

                .text-bold {
                    font-weight: bold !important;
                }
            </style>

        </head>

        <body onload="printAndClose();">
            <div class="page-wrapper" style="padding:0px; border-top:-10px;">
                <div class="invoice-card">
                    <div class="invoice-head">
                        <img src="{{ asset(getSiteLogo()) }}"style="max-width:150px; height: auto; padding: top -20px;"
                            alt="main_logo">
                        <p class="my-0">{{ $address }} - {{ $zipcode }}</p>
                        <p class="my-0">{{ $phone }}</p><br>
                        <b>{{ $store_email }}</b>
                    </div>
                    <div class="invoice-details" style="border-top:none;">
                        <div class="invoice-list">
                            <div class="invoice-title">
                                <h4 class="heading">{{ $lang->data['customer_id'] ?? 'Customer ID' }}:</h4>
                                <h4 class="heading" style="align: right; font-weight: bold; font-size: 24px;">
                                    {{ str_pad($customer->id ?? '', 4, '0', STR_PAD_LEFT) }}</h4>
                                <h4 class="heading heading-child"></h4>
                            </div>
                            <div class="row-data">
                                <h5 class="item-info-small">{{ $lang->data['customer_name'] ?? 'Customer Name' }}
                                    :<br />
                                    {{ $lang->data['customer_phone'] ?? 'Contact Number' }} :<br />
                                    {{ $lang->data['customer_address'] ?? 'Address' }} :</h5>
                                <h5 class="item-info-big">
                                    {{ $customer->name ?? ($lang->data['walk_in_customer'] ?? 'Walk-In Customer') }}<br />
                                    {{ $customer->phone ?? '' }}<br />
                                    {{ $customer->address ?? '' }}<br />
                                    @if ($customer)
                                        {{ $lang->data['vat'] ?? 'VAT' }}: {{ $customer->tax_number ?? 'TAX' }}
                                    @endif
                                </h5>
                            </div>
                            <div class="row-data" style="border:none; margin-bottom: 1px">
                                <div class="item-info">
                                    <h5 class="item-title"><b>{{ $lang->data['order_no'] ?? 'Order No' }}</b></h5>
                                </div>
                                <h5 class="my-5"><b>{{ $order->order_number }}</b></h5>
                            </div>
                            <div class="row-data" style="border:none;">
                                <div class="item-info">
                                    <h5 class="item-title"><b>{{ $lang->data['order_date'] ?? 'Order Date' }}</b></h5>
                                </div>
                                <h5 class="my-5">
                                    <b>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</b>
                                </h5>
                            </div>
                            <div class="row-data" style="border:none;">
                                <div class="item-info">
                                    <h5 class="item-title">
                                        <b>{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}</b>
                                    </h5>
                                </div>
                                <h5 class="my-5">
                                    <b>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</b>
                                    <b>( {{ getOrderStatus($order->status, 1) }} )</b>
                                </h5>
                            </div>
                            <div class="invoice-title" style="text-align: right">
                                <h6 class="heading1">{{ $lang->data['service_name'] ?? 'Service Name' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['rate'] ?? 'Rate' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['qty'] ?? 'QTY' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['total'] ?? 'Total' }}</h6>
                            </div>
                            @php
                                $qty = 0;
                            @endphp
                            @foreach ($orderdetails as $item)
                                @php
                                    $service = \App\Models\Service::where('id', $item->service_id)->first();
                                @endphp
                                <div class="row-data"
                                    style="text-align: center;margin-top: 5px; padding-bottom: 8px; align-items: center">
                                    <div class="item-info" style="width: 82px;text-align: initial;">

                                        <h5 class="item-title"><b>{{ $service->service_name }}</b></h5>
                                        <h5 class="item-title"><b>[{{ $item->service_name }}]</b></h5>
                                    </div>
                                    {{-- <h5 class="my-5"><b><img src="{{asset('assets/img/service-icons/'.$service->icon)}}" class="avatar avatar-sm me-3 d-flex px-3 py-1" height="25" width="35"></b></h5> --}}
                                    <h5 class="my-5"><b>{{ getCurrency() }}
                                            {{ number_format($item->service_price, 3) }}</b></h5>
                                    <h5 class="my-5"><b>{{ $item->service_quantity }}</b></h5>
                                    <h5 class="my-5"><b>{{ getCurrency() }}
                                            {{ number_format($item->service_detail_total, 3) }}</b></h5>
                                </div>
                            @endforeach
                            @php
                                $addons = \App\Models\OrderAddonDetail::where('order_id', $order->id)->get();
                            @endphp
                            @if ($addons)
                                @if (count($addons) > 0)
                                    <h4 style="padding-top: 5px;">{{ $lang->data['addons'] ?? 'Addons' }}</h4>
                                    @foreach ($addons as $row)
                                        <div class="row-data"
                                            style="text-align: center;margin-top: 5px; padding-bottom: 8px;">
                                            <h5 class="my-5" style="   text-align: initial; width: 82px;">
                                                <b>{{ $row->addon_name }}</b>
                                            </h5>
                                            <h5 class="my-5 "><b>-</b></h5>
                                            <h5 class="my-5"><b>-</b></h5>
                                            <h5 class="my-5"><b>{{ getCurrency() }}
                                                    {{ number_format($row->addon_price, 3) }}</b></h5>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div class="invoice-footer mb-15">
                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['sub_total'] ?? 'Sub Total' }}:</h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }}
                                    {{ number_format($order->sub_total, 3) }}</h5>
                            </div>
                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['addon'] ?? 'Addon' }}:</h5>
                                </div>
                                <h5 class="my-5">
                                    {{ getCurrency() }} {{ number_format($order->addon_total, 3) }}
                                </h5>
                            </div>
                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['discount'] ?? 'Discount' }}:</h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }}
                                    {{ number_format($order->discount, 3) }}</h5>
                            </div>
                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['tax'] ?? 'Tax' }}
                                        ({{ $order->tax_percentage }}%):</h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }}
                                    {{ number_format($order->tax_amount, 3) }}</h5>
                            </div>
                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['gross_total'] ?? 'Gross Total' }}:
                                    </h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }} {{ number_format($order->total, 3) }}
                                </h5>
                            </div>
                            <div class="row-data">
                                @php
                                    $totalPaymentMade = DB::table('payments')
                                        ->where('order_id', $order->id)
                                        ->sum('received_amount');
                                    $balanceAmount = $order->total - $totalPaymentMade;
                                    $totalQuantity = DB::table('order_details')
                                        ->where('order_id', $order->id)
                                        ->sum('service_quantity');
                                @endphp
                                <div class="item-info">
                                    <h5 class="item-title">
                                        {{ $lang->data['payment_received'] ?? 'Received Amount' }}:
                                    </h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }} {{ number_format($totalPaymentMade, 3) }}
                                </h5>
                            </div>
                            <div class="invoice-title" style="justify-content: space-between;">
                                <div class="item-info" style="width: 50%; align-items:left;">
                                    <h4 class="heading">{{ $lang->data['quantity'] ?? 'Total Pieces' }}:</h4>
                                    <h2 class="my-5">{{ $totalQuantity }} {{ $lang->data['pieces'] ?? 'Nos' }}
                                    </h2>
                                </div>
                                <div class="item-info" style="text-align: right;">
                                    <h4 class="heading">{{ $lang->data['balance_amount'] ?? 'Balance' }}:</h4>
                                    <h2 class="my-5" style="text-align: right;">{{ getCurrency() }}
                                        :{{ number_format($balanceAmount, 3) }}</h2>
                                    <h5 class="heading heading-child" style="width:100%;"></h5>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    @if ($balanceAmount > 0)
                        <div class="qr" style="width:100%; text-align: Center">
                            <h3 class="my-5">Scan to Pay With - <strong> BENIFIT PAY</strong></h3>
                            <div class="my-5">

                                @php
                                    require_once base_path('phpqrcode/qrlib.php');
                                    $balanceAmount = number_format($balanceAmount, 3);
                                    $iban_no = DB::table('master_settings')
                                        ->where('master_title', 'iban_number')
                                        ->value('master_value');
                                    $qrData = json_encode(['iban' => $iban_number, 'amount' => $balanceAmount]);
                                    $size = 4;
                                    QRcode::png($qrData, 'qrcode.png', QR_ECLEVEL_L, $size, 1);
                                    $timestamp = time(); // Generate a unique timestamp
                                    echo '<img src="/public/qrcode.png?' .
                                        $timestamp .
                                        '" style="width: 60%; height: auto;">';
                                @endphp
                            </div>
                        </div>
                    @endif
                    <div class="invoice_address">
                        <div class="text-center">
                            </p>
                            <p>Received By : {{ $order->user->name }}</p>

                            <h3 class="mt-10">
                                {{ isset($site['default_thanks_message']) && !empty($site['default_thanks_message']) ? $site['default_thanks_message'] : '' }}
                            </h3>
                            <p class="b_top">{{ $lang->data['powered_by'] ?? 'Thank You For Choosing' }}
                                <b>{{ getApplicationName() }}</b>


                        </div>
                    </div>
                </div>

            </div>

            <!--pagebreak after customer copy -->

            <div style="break-after:page"></div>

            <!--office copy -->
            <div class="page-wrapper" style="padding:0px; border-top:-10px;">
                <div class="invoice-card">
                    <div class="invoice-details" style="border-top:none;">
                        <div class="invoice-list">
                            <div class="invoice-title">
                                <h4 class="heading"style="text-align: right;">
                                    {{ $lang->data['customer_id'] ?? 'Customer ID' }}:</h4>
                                <h4 class="heading" style="text-align: right; font-weight: bold; font-size: 24px;">
                                    {{ str_pad($customer->id ?? '', 4, '0', STR_PAD_LEFT) }}</h4>
                                <h4 class="heading heading-child"></h4>
                            </div>
                            <div class="row-data">
                                <h5 class="item-info-small">{{ $lang->data['customer_name'] ?? 'Customer Name' }}
                                    :<br />
                                    {{ $lang->data['customer_phone'] ?? 'Contact Number' }} :<br />
                                    {{ $lang->data['customer_address'] ?? 'Address' }} :</h5>
                                <h5 class="item-info-big">
                                    {{ $customer->name ?? ($lang->data['walk_in_customer'] ?? 'Walk-In Customer') }}<br />
                                    {{ $customer->phone ?? '' }}<br />
                                    {{ $customer->address ?? '' }}<br />
                                    @if ($customer)
                                        {{ $lang->data['vat'] ?? 'VAT' }}: {{ $customer->tax_number ?? 'TAX' }}
                                    @endif
                                </h5>
                            </div>
                            <div class="row-data" style="border:none; margin-bottom: 1px">
                                <div class="item-info">
                                    <h5 class="item-title"><b>{{ $lang->data['order_no'] ?? 'Order No' }}</b></h5>
                                </div>
                                <h5 class="my-5"><b>{{ $order->order_number }}</b></h5>
                            </div>
                            <div class="row-data" style="border:none;">
                                <div class="item-info">
                                    <h5 class="item-title"><b>{{ $lang->data['order_date'] ?? 'Order Date' }}</b>
                                    </h5>
                                </div>
                                <h5 class="my-5">
                                    <b>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</b>
                                </h5>
                            </div>
                            <div class="row-data" style="border:none;">
                                <div class="item-info">
                                    <h5 class="item-title">
                                        <b>{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}</b>
                                    </h5>
                                </div>
                                <h5 class="my-5">
                                    <b>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</b>
                                    <b>( {{ getOrderStatus($order->status, 1) }} )</b>
                                </h5>
                            </div>
                            <div class="invoice-title" style="text-align: right">
                                <h6 class="heading1">{{ $lang->data['service_name'] ?? 'Service Name' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['rate'] ?? 'Rate' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['qty'] ?? 'QTY' }}</h6>
                                <h6 class="heading1 heading-child">{{ $lang->data['total'] ?? 'Total' }}</h6>
                            </div>
                            @php
                                $qty = 0;
                            @endphp
                            @foreach ($orderdetails as $item)
                                @php
                                    $service = \App\Models\Service::where('id', $item->service_id)->first();
                                @endphp
                                <div class="row-data"
                                    style="text-align: center;margin-top: 5px; padding-bottom: 8px; align-items: center">
                                    <div class="item-info" style="width: 82px;text-align: initial;">

                                        <h5 class="item-title"><b>{{ $service->service_name }}</b></h5>
                                        <h5 class="item-title"><b>[{{ $item->service_name }}]</b></h5>
                                    </div>
                                    {{-- <h5 class="my-5"><b><img src="{{asset('assets/img/service-icons/'.$service->icon)}}" class="avatar avatar-sm me-3 d-flex px-3 py-1" height="25" width="35"></b></h5> --}}
                                    <h5 class="my-5"><b>{{ getCurrency() }}
                                            {{ number_format($item->service_price, 3) }}</b></h5>
                                    <h5 class="my-5"><b>{{ $item->service_quantity }}</b></h5>
                                    <h5 class="my-5"><b>{{ getCurrency() }}
                                            {{ number_format($item->service_detail_total, 3) }}</b></h5>
                                </div>
                            @endforeach
                            @php
                                $addons = \App\Models\OrderAddonDetail::where('order_id', $order->id)->get();
                            @endphp
                            @if ($addons)
                                @if (count($addons) > 0)
                                    <h4 style="padding-top: 5px;">{{ $lang->data['addons'] ?? 'Addons' }}</h4>
                                    @foreach ($addons as $row)
                                        <div class="row-data"
                                            style="text-align: center;margin-top: 5px; padding-bottom: 8px;">
                                            <h5 class="my-5" style="   text-align: initial; width: 82px;">
                                                <b>{{ $row->addon_name }}</b>
                                            </h5>
                                            <h5 class="my-5 "><b>-</b></h5>
                                            <h5 class="my-5"><b>-</b></h5>
                                            <h5 class="my-5"><b>{{ getCurrency() }}
                                                    {{ number_format($row->addon_price, 3) }}</b></h5>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div class="invoice-footer mb-15">

                            <div class="row-data">
                                <div class="item-info">
                                    <h5 class="item-title">{{ $lang->data['gross_total'] ?? 'Gross Total' }}:
                                    </h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }} {{ number_format($order->total, 3) }}
                                </h5>
                            </div>
                            <div class="row-data">
                                @php
                                    $totalPaymentMade = DB::table('payments')
                                        ->where('order_id', $order->id)
                                        ->sum('received_amount');
                                    $balanceAmount = $order->total - $totalPaymentMade;
                                    $totalQuantity = DB::table('order_details')
                                        ->where('order_id', $order->id)
                                        ->sum('service_quantity');
                                @endphp
                                <div class="item-info">
                                    <h5 class="item-title">
                                        {{ $lang->data['payment_received'] ?? 'Received Amount' }}:
                                    </h5>
                                </div>
                                <h5 class="my-5">{{ getCurrency() }} {{ number_format($totalPaymentMade, 3) }}
                                </h5>
                            </div>
                            <div class="invoice-title" style="justify-content: space-between;">
                                <div class="item-info" style="width: 50%; align-items:left;">
                                    <h4 class="heading">{{ $lang->data['quantity'] ?? 'Total Pieces' }}:</h4>
                                    <h2 class="my-5">{{ $totalQuantity }} {{ $lang->data['pieces'] ?? 'Nos' }}
                                    </h2>
                                </div>
                                <div class="item-info" style="text-align: right;">
                                    <h4 class="heading">{{ $lang->data['balance_amount'] ?? 'Balance' }}:</h4>
                                    <h2 class="my-5" style="text-align: right;">{{ getCurrency() }}
                                        :{{ number_format($balanceAmount, 3) }}</h2>
                                    <h5 class="heading heading-child" style="width:100%;"></h5>

                                </div>
                            </div>
                            <hr>
                            <p style="text-align: center;"> Office Copy</p>
                        </div>
                    </div>

                </div>

            </div>




        </body>

        </html>
    @endif
    <div style="break-after:page"></div>
</div>

<script type="text/javascript">
    "use strict";

    function printAndClose() {
        window.print();
        setTimeout(function() {
            window.close();
        }, 1000); // Adjust the delay as needed
    }
</script>
