<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['service_addons'] ?? 'Service Addons' }}</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addaddon" class="btn btn-icon btn-3 btn-white text-primary mb-0" wire:click="resetFields">
                <i class="fa fa-plus me-2"></i> {{ $lang->data['add_new_addon'] ?? 'Add New Addon' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['addon'] ?? 'Addon' }}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['price'] ?? 'Price' }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['status'] ?? 'Status' }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addons as $item)
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $loop->index + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $item->addon_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold px-3 mb-0">{{getCurrency()}} {{ $item->addon_price }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($item->is_active == 1)
                                                <a type="button"
                                                    class="badge badge-sm bg-success">{{ $lang->data['active'] ?? 'Active' }}</a>
                                            @else
                                                <a type="button"
                                                    class="badge badge-sm bg-danger">{{ $lang->data['inactive'] ?? 'Inactive' }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#editaddon"
                                                wire:click="edit({{ $item->id }})" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs">
                                                {{ $lang->data['edit'] ?? 'Edit' }}
                                            </a>
                                            <a href="#" wire:click="delete({{ $item->id }})" type="button"
                                                class="ms-2 badge badge-xs badge-danger text-xs fw-600">
                                                {{ $lang->data['delete'] ?? 'Delete' }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="addaddon" tabindex="-1" role="dialog" aria-labelledby="addaddon" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addaddon">{{ $lang->data['add_addon'] ?? 'Add Addon' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['addon_name'] ?? 'Addon Name' }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_addon_name'] ?? 'Enter Addon Name' }}"
                                    wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['addon_price'] ?? 'Addon Price' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" required class="form-control"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="price">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="create">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="editaddon" tabindex="-1" role="dialog" aria-labelledby="editaddon"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editaddon">
                        {{ $lang->data['edit_service_type'] ?? 'Edit Service Type' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['addon_name'] ?? 'Addon Name' }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_addon_name'] ?? 'Enter Addon Name' }}"
                                    wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['addon_price'] ?? 'Addon Price' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" required class="form-control"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="price">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="update">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>