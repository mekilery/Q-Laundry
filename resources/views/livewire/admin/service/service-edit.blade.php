<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['edit_service'] ?? 'Edit Service' }}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.service_list') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-arrow-left me-2"></i> {{ $lang->data['back'] ?? 'Back' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form>
                    <div class="card-body p-3 mb-1 mt-2">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label
                                    class="form-label">{{ $lang->data['service_name'] ?? 'Service Name' }}</label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_service_name'] ?? 'Enter Service Name' }}"
                                    wire:model="service_name">
                                @error('service_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    {{ $lang->data['select_icon'] ?? 'Select Icon' }}
                                </button>
                                @error('icon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 text-center ">
                                <div class="avatar avatar-xl">
                                    @if ($imageicon)
                                        <img src="{{ asset('assets/img/service-icons/' . $imageicon['path']) }}"
                                            class="rounded bg-light p-2">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-xs opacity-7 ps-3">
                                            {{ $lang->data['service_type'] ?? 'Service Type' }}</th>
                                        <th class="text-uppercase text-secondary text-xs opacity-7 ps-3">
                                            {{ $lang->data['service_price'] ?? 'Service Price' }}</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inputs as $key => $value)
                                        <tr>
                                            <td>
                                                <p class="text-sm px-3 mb-0">{{ $loop->index + 1 }}</p>
                                            </td>
                                            <td>
                                                <select class="form-select"
                                                    wire:model="servicetypes.{{ $value }}">
                                                    <option value="">
                                                        {{ $lang->data['select_service_type'] ?? 'Select A Service Type' }}
                                                    </option>
                                                    @foreach ($service_types as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->service_type_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('servicetypes.' . $value)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="align-middle text-center">
                                                <input type="text" class="form-control"
                                                    placeholder="Search Service Type" value="100" style="width: 150px;"
                                                    wire:model="prices.{{ $value }}">
                                                @error('prices.' . $value)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="align-middle">
                                                <a href="#" class="text-danger fw-600"
                                                    wire:click.prevent="remove({{ $key }},{{ $value }})">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="footer-button px-5">
                                <a href="#" wire:click="add({{ $inputi }})"
                                    class="badge badge-xs badge-success fw-600 text-xs">
                                    {{ $lang->data['add_service_type'] ?? 'Add Service Type' }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @error('inputerror')
                        <span class="text-danger mx-3">{{ $message }}</span>
                    @enderror
                    <hr>
                    <div class="card-footer p-2 mx-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="employee" checked
                                    wire:model="is_active">
                                <label class="form-check-label"
                                    for="employee">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                            </div>
                            <div>
                                <a href="{{ route('admin.service_list') }}"> <button type="button"
                                        class="btn btn-secondary">{{ $lang->data['cancel'] ?? 'Cancel' }}</button></a>
                                <button type="submit" class="btn btn-primary ms-4"
                                    wire:click.prevent="save">{{ $lang->data['submit'] ?? 'Submit' }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $lang->data['select_icon'] ?? 'Select Icon' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" x-data="">
                    <div class="row">
                        @foreach ($files as $key => $value)
                            <div class="col-1 m-2  customwidth customhover1" wire:click="selectIcon({{ $key }})">
                                <img src="{{ asset('assets/img/service-icons/' . $value['path']) }}"
                                    class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>