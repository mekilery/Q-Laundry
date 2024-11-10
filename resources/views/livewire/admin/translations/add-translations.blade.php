<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['create_translations'] ?? 'Create Translations'}}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3 align-items-center">
                        <div><span class="text-sm text-uppercase">{{$lang->data['add_translations'] ?? 'Add Translations'}} </span></div>
                        <hr>
                        <div class="col-md-4">
                            <label class="form-label">{{$lang->data['language_name']??"Language Name"}} <span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" placeholder="{{$lang->data['enter_language_name']??'Enter Language Name'}}" wire:model="name">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        
                        @foreach(config('global.translation.section') as $value)
                        <div class="col-12">
                        <hr>
                        <div><span class=" text-lg mx-2 text-uppercase mb-2">{{$value['name']}}</span></div>

                                @foreach($value['values'] as $key => $default)
                                    <div class="form-group mx-2">
                                        <label class="form-contr    ol-label " for="example3cols1Input">{{ucwords(str_replace('_', ' ', $key))}}</label>
                                        <input type="text" class="form-control" id="example3cols1Input" wire:model="data.{{$key}}" >
                                    </div>
                                @endforeach
                        </div>
                        @endforeach
                        <hr>
                        <div class="form-group mx-2">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="active" wire:model="is_active">
                                        <label class="form-check-label" for="active">{{$lang->data['is_active']??'Is Active'}}</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="default" wire:model="default">
                                        <label class="form-check-label" for="default">{{$lang->data['default']??'Default'}}</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rtl" wire:model="is_rtl">
                                        <label class="form-check-label" for="rtl">{{$lang->data['rtl']??'RTL'}}</label>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <div>
                                <button type="button" class="btn btn-primary ms-4" wire:click.prevent="save">{{$lang->data['save']??'Save'}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>