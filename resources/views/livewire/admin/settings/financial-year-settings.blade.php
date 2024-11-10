<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['financial_year'] ?? 'Financial Year'}}</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" wire:click="resetFields()" data-bs-target="#addfyear" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{$lang->data['add_new_financial_year'] ?? 'Add New Financial Year'}}
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
                                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['year'] ?? 'Year'}}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['start_date'] ?? 'Start Date'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['end_date'] ?? 'End Date'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['actions'] ?? 'Actions'}}</th>          
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($years as $item)
                               <tr>
                                   <td> <p class="text-sm px-3 mb-0">{{$item->year}} </p></td>
                                   <td><p class="text-sm px-3 mb-0">{{\Carbon\Carbon::parse($item->starting_date)->format('d/m/Y')}} </p></td>
                                   <td><p class="text-sm px-3 mb-0">{{\Carbon\Carbon::parse($item->ending_date)->format('d/m/Y')}} </p></td>
                                   <td>
                                    <a data-bs-toggle="modal" data-bs-target="#editfyear" wire:click="edit({{$item->id}})" type="button" class="badge badge-xs badge-warning fw-600 text-xs">
                                        {{$lang->data['edit'] ?? 'Edit'}}
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
    <div class="modal fade" wire:ignore.self id="addfyear" tabindex="-1" role="dialog" aria-labelledby="addfyear" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600"> {{$lang->data['add_financial_year'] ?? 'Add Financial Year'}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                      <div class="form-row">
                        <div class="col-12 mb-2">
                            <label for=""> {{$lang->data['year'] ?? 'Year'}}</label>
                            <input type="number" name="" class="form-control" id="" wire:model="year">
                            @error('year') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                          <div class="col-12 mb-2">
                              <label for=""> {{$lang->data['start_date'] ?? 'Start Date'}}</label>
                              <input type="date" name="" class="form-control" id="" wire:model="start_date">
                          </div>
                          <div class="col-12 mb-2">
                            <label for=""> {{$lang->data['end_date'] ?? 'End Date'}}</label>
                            <input type="date" name="" class="form-control" id="" wire:model="end_date">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{$lang->data['cancel'] ?? 'Cancel'}}</button>
                        <button type="submit" wire:click.prevent="create" class="btn btn-primary">{{$lang->data['save'] ?? 'Save'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self id="editfyear" tabindex="-1" role="dialog" aria-labelledby="editfyear" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{$lang->data['edit_financial_year'] ?? 'Edit Financial Year'}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-row">
                          <div class="col-12 mb-2">
                              <label for=""> {{$lang->data['year'] ?? 'Year'}}</label>
                              <input type="number" name="" class="form-control" id="" wire:model="year">
                              @error('year') <span class="text-danger">{{$message}}</span> @enderror
                          </div>
                            <div class="col-12 mb-2">
                                <label for=""> {{$lang->data['start_date'] ?? 'Start Date'}}</label>
                                <input type="date" name="" class="form-control" id="" wire:model="start_date">
                            </div>
                            <div class="col-12 mb-2">
                              <label for=""> {{$lang->data['end_date'] ?? 'End Date'}}</label>
                              <input type="date" name="" class="form-control" id="" wire:model="end_date">
                          </div>
                        </div>
                      </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['cancel'] ?? 'Cancel'}}</button>
                        <button type="submit" wire:click.prevent="update" class="btn btn-primary">{{$lang->data['save'] ?? 'Save'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>