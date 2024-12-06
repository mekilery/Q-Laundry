<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['add_order'] ?? 'Add Order' }}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.view_orders') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-arrow-left me-2"></i> {{ $lang->data['back'] ?? 'Back' }}
            </a>
        </div>
    </div>
    <div class="row match-height">
        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}"
                                wire:model="search_query">
                        </div>
                    </div>
                </div>
                <div class="pos-card-wrapper-scroll-y my-custom-scrollbar-pos-card  mb-3">
                    <div class="row align-items-center g-3 px-4 ">
                        @foreach ($services as $item)
                            <div class="col-lg-3 col-6 text-center">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-1">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#servicetype"
                                        wire:click="selectService({{ $item->id }})">
                                        <div class="avatar avatar-xl mb-3">
                                            <img src="{{ asset('assets/img/service-icons/' . $item->icon) }}"
                                                class="rounded p-2">
                                        </div>
                                        <p class="text-xs font-weight-bold">{{ $item->service_name }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-9 mb-3">
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
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal"
                                data-bs-target="#addcustomer">
                                <i class="fa fa-plus me-2"></i> {{ $lang->data['add'] ?? 'Add' }}
                            </button>
                        </div>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" readonly value="{{ $order_id }}">
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" wire:model="date">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-3">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-5">
                                        {{ $lang->data['service'] ?? 'Service' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-5">
                                        {{ $lang->data['color'] ?? 'Color' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['rate'] ?? 'Rate' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['qty'] ?? 'QTY' }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="order-list-wrapper-scroll-y my-custom-scrollbar-order-list">
                        <div class="row align-items-center g-3 px-4 ">
                            @foreach ($selservices as $key => $item)
                                <div class="col-lg-12 col-12">
                                    <div class="row ms-2 align-items-center">
                                        <div class="col-4">
                                            <h6 class="text-xs h6 mb-0">
                                                @php
                                                    $serviceinline = null;
                                                    if (isset($item['service'])) {
                                                        $serviceinline = \App\Models\Service::where(
                                                            'id',
                                                            $item['service'],
                                                        )->first();
                                                    }
                                                    if (isset($item['service_type'])) {
                                                        $servicetypeinline = \App\Models\ServiceType::where(
                                                            'id',
                                                            $item['service_type'],
                                                        )->first();
                                                    }
                                                @endphp
                                                {{ $serviceinline->service_name }}
                                            </h6>
                                            <span
                                                class="text-xxs fw-600 text-primary">[{{ $servicetypeinline->service_type_name }}]</span>
                                        </div>
                                        <div class="col-2">
                                            <input class="form-control" type="color"
                                                pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"
                                                wire:model="colors.{{ $key }}"
                                                wire:change="changeColor({{ $key }})">
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control form-control-sm text-center"
                                                wire:model="prices.{{ $key }}" value="10000">
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group align-items-center">
                                                <div class="badge bg-secondary text-xxs text-center p-66" type="button"
                                                    wire:click="decrease({{ $key }})"><i
                                                        class="fa fa-minus"></i></div>
                                                <input type="number" class="form-control form-control-sm text-center"
                                                    wire:model="quantity.{{ $key }}">
                                                <div class="badge bg-primary text-xxs text-center p-66" type="button"
                                                    wire:click="increase({{ $key }})"><i
                                                        class="fa fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center px-4 mb-3">
                    <div class="col">
                        <p class="text-sm mb-0 fw-500">{{ $lang->data['gross_total'] ?? 'Gross Total' }}</p>
                        <p class="text-sm text-success fw-600 mb-0">{{ getCurrency() }}
                            {{ number_format($sub_total, 3) }}</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" wire:click="clearAll"
                            class="btn btn-danger me-2 mb-0">{{ $lang->data['clear_all'] ?? 'Clear All' }}</button>
                        <button type="submit" class="btn btn-primary mb-0" data-bs-toggle="modal"
                            data-bs-target="#payment">{{ $lang->data['save_continue'] ?? 'Save and Continue' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="servicetype" tabindex="-1" role="dialog" aria-labelledby="servicetype"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="servicetype">
                        {{ $lang->data['select_service_type'] ?? 'Select Service Type' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addItem">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center" x-data="{ servtypes: @entangle('service_types'), seltype: null }">
                            <div class="row row-cols-2 row-cols-md-4 g-2">
                                <template x-for="item in servtypes">
                                    <div class="col">
                                        <button type="button"
                                            class="btn btn-block w-100 text-center py-3 fs-6 rounded-3"
                                            style="aspect-ratio: 1 / 1;"
                                            :class="seltype === item.id ? 'btn-primary' : 'btn-outline-secondary'"
                                            @click="seltype = item.id; $wire.addItem(item.id)"
                                            x-text="item.service_type_name">
                                        </button>
                                    </div>
                                </template>
                            </div>
                            @error('service_error')
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <div class="modal fade " id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="addcustomer"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addcustomer">
                        {{ $lang->data['add_customer'] ?? 'Add Customer' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['customer_name'] ?? 'Customer Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_customer_name'] ?? 'Enter Customer Name' }}"
                                    wire:model="customer_name">
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}"
                                    wire:model="customer_phone">
                                @error('customer_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}"
                                    wire:model="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['tax_number'] ?? 'Tax Number' }}</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ $lang->data['enter_tax_number'] ?? 'Enter Tax Number' }}"
                                    wire:model="tax_no">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">{{ $lang->data['address'] ?? 'Address' }}</label>
                                <textarea type="text" class="form-control" placeholder="{{ $lang->data['enter_address'] ?? 'Enter Address' }}"
                                    wire:model="address"></textarea>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="employee" checked
                                        wire:model="is_active">
                                    <label class="form-check-label"
                                        for="employee">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="button" class="btn btn-primary"
                            wire:click.prevent="createCustomer()">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="payment" tabindex="-1" role="dialog" aria-labelledby="payment"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="payment">
                        {{ $lang->data['payment_details'] ?? 'Payment Details' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            @foreach ($addons as $row)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="addon"
                                            id="addon{{ $row->id }}"
                                            wire:model="selected_addons.{{ $row->id }}">
                                        <label class="custom-control-label"
                                            for="addon{{ $row->id }}">{{ $row->addon_name }}</label>
                                    </div>
                                </div>
                            @endforeach
                            <div class=" col-12">
                                @if ($addons)
                                    @if (count($addons) > 0)
                                        <hr>
                                    @endif
                                @endif
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-1">
                                        <label
                                            class="form-label">{{ $lang->data['delivery_date'] ?? 'Delivery Date' }}</label>
                                        <input type="date" class="form-control" wire:model="delivery_date">
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">{{ $lang->data['discount'] ?? 'Discount' }}</label>
                                        <input type="number" class="form-control"
                                            placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                            wire:model="discount">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-50 align-items-center">
                                    <div class="col text-sm fw-500">{{ $lang->data['sub_total'] ?? 'Sub Total' }}:
                                    </div>
                                    <div class="col-auto  text-sm fw-500">{{ getCurrency() }}
                                        {{ number_format($sub_total, 3) }}</div>
                                </div>
                                <div class="row mb-50 align-items-center">
                                    <div class="col text-sm fw-500">{{ $lang->data['addon'] ?? 'Addon' }}:</div>
                                    <div class="col-auto text-sm fw-500">{{ getCurrency() }}
                                        {{ number_format($addon_total, 3) }}</div>
                                </div>
                                <div class="row mb-50 align-items-center">
                                    <div class="col text-sm fw-500">{{ $lang->data['discount'] ?? 'Discount' }}:</div>
                                    <div class="col-auto  text-sm fw-500">{{ getCurrency() }}
                                        {{ number_format($discount, 3) }}</div>
                                </div>
                                <div class="row mb-50 align-items-center">
                                    <div class="col text-sm fw-500">{{ $lang->data['tax'] ?? 'Tax' }}
                                        ({{ getTaxPercentage() }}%):</div>
                                    <div class="col-auto text-sm fw-500">{{ getCurrency() }}
                                        {{ number_format($tax, 3) }}</div>
                                </div>
                                <hr>
                                <div class="row align-items-center">
                                    <div class="col text-sm fw-600">{{ $lang->data['gross_total'] ?? 'Gross Total' }}:
                                    </div>
                                    <div class="col-auto text-sm fw-600">{{ getCurrency() }}
                                        {{ number_format($total, 3) }}</div>
                                </div>
                                <hr>
                                <div class="row ">
                                    <div class="col-md-4 mb-1 pr-0">
                                        <label
                                            class="form-label">{{ $lang->data['paid_amount'] ?? 'Paid Amount' }}</label>
                                        <input type="number" class="form-control"
                                            placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                            wire:model="paid_amount">
                                    </div>
                                    <div class="col-md-1 m-0 p-0">
                                        <label for="" class="form-label"> &nbsp; </label>
                                        <button class="btn btn-icon btn-2 btn-primary " type="button"
                                            wire:click="magicFill">
                                            <span class="btn-inner--icon px-0 mx-0"><i
                                                    class="fa fa-magic m-0 p-0"></i></span>
                                        </button>
                                    </div>

                                    <div class="col-6 mx-2 mb-1">
                                        <label
                                            class="form-label">{{ $lang->data['payment_type'] ?? 'Payment Type' }}</label>
                                        <select class="form-select" wire:model="payment_type">
                                            <option value="">
                                                {{ $lang->data['choose_payment_mode'] ?? 'Choose Payment Mode' }}
                                            </option>
                                            @foreach ($paymentTypes as $paymentType)
                                                <option class="select-box" value="{{ $paymentType->id }}">
                                                    {{ $paymentType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('paid_amount')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('payment_type')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <hr>
                                <div class="row align-items-center">
                                    <div class="col text-sm fw-600">{{ $lang->data['balance'] ?? 'Balance' }}:</div>
                                    <div class="col-auto text-sm fw-600">{{ getCurrency() }}
                                        {{ number_format($balance, 3) }}</div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <label
                                        class="form-label">{{ $lang->data['notes_remarks'] ?? 'Notes / Remarks' }}</label>
                                    <textarea class="form-control" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                        wire:model="payment_notes"></textarea>
                                </div>
                                @error('error')
                                    <div class="col-12 mt-2">
                                        <div class="alert alert-danger" role="alert">
                                            <strong class="text-white">
                                                <span class="mx-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-alert-triangle">
                                                        <path
                                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                                        <line x1="12" y1="9" x2="12"
                                                            y2="13" />
                                                        <line x1="12" y1="17" x2="12.01"
                                                            y2="17" />
                                                    </svg>
                                                </span>
                                                {{ $message }}
                                            </strong>
                                        </div>

                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="save">{{ $lang->data['save_print'] ?? 'Save & Print' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    Livewire.on('printPage', orderId => {
        var $id = orderId;
        window.open(
            '{{ url('admin/orders/print-order/') }}' + '/' + $id,
            '_blank'
        );
        window.onfocus = function() {
            setTimeout(function() {
                window.location.reload();
            }, 100);
        }
    })
</script>
<script>
    document.addEventListener('livewire:load', function() {
        window.addEventListener('close-modal', event => {
            var modalElement = document.getElementById('servicetype');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    });
</script>
