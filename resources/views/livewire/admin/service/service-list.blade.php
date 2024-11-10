<div>
<div class="row align-items-center justify-content-between mb-4">
    <div class="col">
        <h5 class="fw-500 text-white">{{$lang->data['services'] ?? 'Services'}}</h5>
    </div>
    <div class="col-auto">
        <a href="{{route('admin.service_create')}}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
            <i class="fa fa-plus me-2"></i> {{$lang->data['add_new_service'] ?? 'Add New Service'}}
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
                                <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['service_name'] ?? 'Service Name'}}</th>
                                <th class="text-center text-uppercase text-secondary text-xs opacity-7">{{$lang->data['service_types'] ?? 'Service Types'}}</th>
                                <th class="text-center text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['status'] ?? 'Status'}}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($services as $item)
                            <tr>
                                <td>
                                    <p class="text-sm px-3 mb-0">{{$loop->index+1}}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            <img src="{{asset('assets/img/service-icons/'.$item->icon)}}" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$item->service_name}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $details = \App\Models\ServiceDetail::where('service_id',$item->id)->get();
                                    @endphp
                                    @if($details)
                                    @foreach ($details as $row)
                                        @php
                                            $type = \App\Models\ServiceType::where('id',$row->service_type_id)->first();
                                        @endphp
                                    <span class="badge badge-sm bg-dark rounded-pill fw-500">{{$type->service_type_name}}</span>
                                    @endforeach
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->is_active == 1)
                                    <a type="button" class="badge badge-sm bg-success">{{$lang->data['active'] ?? 'Active'}}</a>
                                    @else 
                                    <a type="button" class="badge badge-sm bg-danger">{{$lang->data['inactive'] ?? 'InActive'}}</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.service_edit',$item->id)}}"  type="button" class="badge badge-xs badge-warning fw-600 text-xs">
                                        {{$lang->data['edit'] ?? 'Edit'}}
                                    </a>
                                    <a href="#" wire:click="delete({{$item->id}})"  type="button" class="ms-2 badge badge-xs badge-danger text-xs fw-600">
                                        {{$lang->data['delete'] ?? 'Delete'}}
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