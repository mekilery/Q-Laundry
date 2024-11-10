<div>
<div class="row align-items-center justify-content-between mb-4">
    <div class="col">
        <h5 class="fw-500 text-white">{{$lang->data['service_type'] ?? 'Service Type'}}</h5>
    </div>
    <div class="col-auto">
        <a data-bs-toggle="modal" data-bs-target="#addtype" class="btn btn-icon btn-3 btn-white text-primary mb-0" wire:click="resetInputFields">
            <i class="fa fa-plus me-2"></i> {{$lang->data['add_new_service_type'] ?? 'Add New Service Type'}}
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="{{$lang->data['search_here'] ?? 'Search Here'}}" wire:model="search_query">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['service_type'] ?? 'Service Type'}}</th>
                                <th class="text-center text-uppercase text-secondary text-xs opacity-7">{{$lang->data['status'] ?? 'Status'}}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service_types as $item)
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$loop->index +1}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$item->service_type_name}}</p>
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->is_active == 1)  <a type="button" class="badge badge-sm  bg-success">{{$lang->data['active'] ?? 'Active'}}</a>@else <a type="button" class="badge badge-sm  bg-dark">{{$lang->data['inactive'] ?? 'InActive'}}</a>   @endif
                                </td>
                                <td class="align-middle">
                                    <a wire:click="edit({{$item->id}})" data-bs-toggle="modal" data-bs-target="#edittype"  type="button" class="badge badge-xs badge-warning fw-600 text-xs">
                                        {{$lang->data['edit'] ?? 'Edit'}}
                                    </a>
                                    <a href="#"  wire:click="delete({{$item->id}})" type="button" class="ms-2 badge badge-xs badge-danger text-xs fw-600">
                                        {{$lang->data['delete'] ?? 'Delete'}}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($hasMorePages)
                    <div
                        x-data="{
                            init () {
                                let observer = new IntersectionObserver((entries) => {
                                    entries.forEach(entry => {
                                        if (entry.isIntersecting) {
                                            @this.call('loadServiceTypes')
                                        }
                                    })
                                }, {
                                    root: null
                                });
                                observer.observe(this.$el);
                            }
                        }"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4"
                    >
                       <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                           Loading...
                           <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="addtype" tabindex="-1" role="dialog" aria-labelledby="addtype" aria-hidden="true" wire:ignore.self> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-600" id="addtype">{{$lang->data['add_service_type'] ?? 'Add Service Type'}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-12">
                            <label class="form-label">{{$lang->data['service_type_name'] ?? 'Service Type Name'}}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" placeholder="{{$lang->data['enter_service_type_name'] ?? 'Enter Service Type Name'}}" wire:model="name">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="employee" checked wire:model="is_active">  
                                <label class="form-check-label" for="employee" >{{$lang->data['is_active'] ?? 'Is Active'}} ?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['cancel'] ?? 'Cancel'}}</button>
                    <button type="submit" class="btn btn-primary" wire:click.prevent="create">{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade " id="edittype" tabindex="-1" role="dialog" aria-labelledby="edittype" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-600" id="edittype">{{$lang->data['edit_service_type'] ?? 'Edit Service Type'}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-12">
                            <label class="form-label">{{$lang->data['service_type_name'] ?? 'Service Type Name'}}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" placeholder="{{$lang->data['enter_service_type_name'] ?? 'Enter Service Type Name'}}" wire:model="name">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="employee" checked wire:model="is_active">  
                                <label class="form-check-label" for="employee" >{{$lang->data['is_active'] ?? 'Is Active'}} ?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['cancel'] ?? 'Cancel'}}</button>
                    <button type="submit" class="btn btn-primary" wire:click.prevent="update">{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>