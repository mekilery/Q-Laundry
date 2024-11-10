<div>
    
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['staff']??'Staff'}}</h5>
        </div>
        <div class="col-auto">
            <a wire:click="resetFields" data-bs-toggle="modal" data-bs-target="#addstaff" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{$lang->data['add_staff']??'Add New Staff'}}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model="search">
                        </div>
                        {{-- <div class="col-md-3">
                            <select class="form-select">
                                <option class="select-box" value="">All Staffs</option>
                                <option class="select-box" value="">Billing</option>
                                <option class="select-box" value="">Manager</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['staff_name'] ?? 'Staff Name'}}</th>
                                    <th class="text-center text-uppercase text-secondary text-xs opacity-7">{{$lang->data['role'] ?? 'Role'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['contact'] ?? 'Contact'}}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['status'] ?? 'Status'}}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $item)
                                <tr>
                                    <td>
                                        <p class="text-sm px-3 mb-0">{{$loop->index+1}}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$item->name}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a type="button" class="badge badge-sm rounded-pill bg-dark text-uppercase">{{$lang->data['billing'] ?? 'Billing'}}</a>
                                    </td>
                                    <td>
                                        <p class="text-sm px-3 mb-0">{{$item->phone}}</p>
                                        <p class="text-sm px-3 mb-0">{{$item->email}}</p>
                                    </td>
                                    <td class="">
                                        <div class="form-check form-switch" wire:click="toggle({{$item->id}})">
                                            <input class="form-check-input" type="checkbox" id="active" @if($item->is_active == 1) checked @endif>
                                            <label class="form-check-label" for="active">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" wire:click="view({{$item->id}})" data-bs-target="#editstaff" type="button" class="badge badge-xs badge-warning fw-600 text-xs">
                                            {{ $lang->data['edit'] ?? 'Edit' }}
                                        </a>
                                        <a href="#" wire:click="delete({{$item->id}})" type="button" class="ms-2 badge badge-xs badge-danger text-xs fw-600">
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
    
    <div class="modal fade " id="addstaff" tabindex="-1" role="dialog" aria-labelledby="addstaff" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addstaff">{{$lang->data['add_staff']??'Add New Staff'}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{$lang->data['staff_name'] ?? 'Staff Name'}}<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="{{$lang->data['enter_staff_name'] ??'Enter Staff Name'}}" wire:model="name">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }} <span class="text-danger">*</span></label>
                                <input type="number" required class="form-control" placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}" wire:model="phone">
                                @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}<span class="text-danger">*</span></label>
                                <input type="email" required class="form-control" placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{$lang->data['password']??'Password'}} <span class="text-danger">*</span></label>
                                <input type="password" required class="form-control" placeholder="{{$lang->data['enter_a_password']??'Enter a Password'}}" wire:model="password">
                                @error('password') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="employee" checked wire:model="is_active"> 
                                    <label class="form-check-label" for="employee">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="save">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade " id="editstaff" tabindex="-1" role="dialog" aria-labelledby="editstaff" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editstaff">{{$lang->data['edit_staff']??'Edit Staff'}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{$lang->data['staff_name'] ?? 'Staff Name'}}<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="{{$lang->data['enter_staff_name'] ??'Enter Staff Name'}}" wire:model="name">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }} <span class="text-danger">*</span></label>
                                <input type="number" required class="form-control" placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}" wire:model="phone">
                                @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}<span class="text-danger">*</span></label>
                                <input type="email" required class="form-control" placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{$lang->data['password']??'Password'}} <span class="text-danger">*</span></label>
                                <input type="password" required class="form-control" placeholder="{{$lang->data['enter_a_password']??'Enter a Password'}}" wire:model="password">
                                @error('password') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="employee" checked wire:model="is_active"> 
                                    <label class="form-check-label" for="employee">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="update">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    </div>
    