<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['payment_types'] ?? 'Payment Types Settings'}}</h5>
        </div>
        <div class="col-auto">
            <a wire:click="resetFields" data-bs-toggle="modal" data-bs-target="#addpaymenttype" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{$lang->data['add_payment_type'] ?? 'Add Payment Type'}}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                  {{--  <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="{{$lang->data['search_here'] ?? 'Search Here'}}" wire:model="search_query">
                        </div>
                    </div> --}}
                </div>    
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['id'] ?? '#'}}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['name'] ?? 'Name'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['status'] ?? 'Status'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['actions'] ?? 'Actions'}}</th>          
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentTypes as $item)
                                <tr>
                                    <td> <p class="text-sm px-3 mb-0">{{$item->id}} </p></td>
                                    <td><p class="text-sm px-3 mb-0">{{$item->name}} </p></td>
                                    <td class="">
                                        <div class="form-check form-switch" wire:click="toggle({{$item->id}})">
                                            <input class="form-check-input" type="checkbox" id="active" @if($item->is_active == 1) checked @endif>
                                            <label class="form-check-label" for="active">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" wire:click="view({{$item->id}})" data-bs-target="#editpaymenttype" type="button" class="badge badge-xs badge-warning fw-600 text-xs bg-warning text-dark">
                                            {{ $lang->data['edit'] ?? 'Edit' }}
                                        </a>
                                        <a href="#" onclick="confirmDelete({{ $item->id }})" type="button" class="ms-2 badge badge-xs badge-danger text-xs fw-600">
                                            {{ $lang->data['delete'] ?? 'Delete' }}
                                        </a>
                                        <script>
                                            function confirmDelete(id) {
                                                if (confirm('Are you sure you want to delete this item?')) {
                                                    @this.call('delete', id);
                                                }
                                            }
                                        </script>
                                                                               
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

    <div class="modal fade " id="addpaymenttype" tabindex="-1" role="dialog"
            aria-labelledby="addpaymenttype" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addpaymenttype">{{ $lang->data['add_paymenttype'] ?? 'Add Payment Types' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['payment_type_name'] ?? 'Payment Type Name' }}
                                <span class="text-danger">*</span>
                                </label>
                                <input type="text" required class="form-control"
                                        placeholder="{{ $lang->data['enter_payment_type_name'] ?? 'Enter Payment Type Name' }}"
                                        wire:model="name">
                                @error('name')
                                        <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['is_active'] ?? 'Status' }} <span class="text-danger">*</span></label>
                                <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="is_active" wire:model="is_active">
                                        <label class="form-check-label" for="is_active">{{ $lang->data['is_active'] ?? 'Status' }}</label>
                                </div>
                                @error('is_active')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>   
                        </div>
                    </div>                         
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary"
                                wire:click.prevent="save()">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    
             
        <!-- Edit Modal -->
    <div class="modal fade" id="editpaymenttype" tabindex="-1" role="dialog" aria-labelledby="editpaymenttype" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editpaymenttype">Edit Payment Type</h6>
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{$lang->data['payment_type_name'] ?? 'payment Type'}}<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="{{$lang->data['enter_payment_type'] ??'Enter Payment Type'}}" wire:model="name">
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" checked wire:model="is_active"> 
                                <label class="form-check-label">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
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
    