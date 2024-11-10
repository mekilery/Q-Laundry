<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['translations']??'Translations'}}</h5>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.add_translations') }}" class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{$lang->data['add_translations']??'Add New Translation'}}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="{{$lang->data['search_here'] ?? 'Search Here'}}"
                                wire:model="search_query">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['translation_name'] ?? 'Translation Name'}}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">{{$lang->data['status'] ?? 'Status'}}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['actions'] ?? 'Actions'}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($translations as $item)
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $item->name }} </p>
                                        </td>
                                        <td>
                                            <p class="text-sm  mb-0">
                                                @if ($item->is_active)
                                                    <span class="badge badge-success">{{$lang->data['active'] ?? 'Active'}}</span>
                                                @endif
                                                @if ($item->default)
                                                    <span class="badge badge-primary">{{$lang->data['default'] ?? 'Default'}}</span>
                                                @endif
                                                @if ($item->is_rtl)
                                                    <span class="badge badge-secondary">{{$lang->data['rtl'] ?? 'RTL'}}</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit_translations', $item->id) }}" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs">
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
</div>