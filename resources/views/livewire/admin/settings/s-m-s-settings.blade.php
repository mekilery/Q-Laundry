<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['sms_settings'] ?? 'SMS Settings' }}</h5>
        </div>
    </div>
    <div class="row" x-data="initz()" x-init="start()">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3 align-items-center">
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['twilio_sms_settings'] ?? 'Twilio SMS Settings' }}</span>
                        </div>
                        <hr>
                        <div class="col-md-4">
                            <label
                                class="form-label">{{ $lang->data['account_sid'] ?? 'Account SID' }}<span
                                    class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control"
                                wire:model="accountsid">
                                @error('accountsid') <span class="text-danger">{{$message}}</span>  @enderror
                        </div>
                        <div class="col-md-4">
                            <label
                                class="form-label">{{ $lang->data['auth_token'] ?? 'Auth Token' }}<span
                                    class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control"
                                wire:model="auth_token">
                                @error('auth_token') <span class="text-danger">{{$message}}</span>  @enderror
                        </div>
                        <div class="col-md-4">
                            <label
                                class="form-label">{{ $lang->data['twilio_number'] ?? 'Twilio Number' }}<span
                                    class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control"
                                wire:model="twilio_number">
                                @error('twilio_number') <span class="text-danger">{{$message}}</span>  @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="employee" checked
                                    wire:model="enabled">
                                <label class="form-check-label"
                                    for="employee">{{ $lang->data['sms_enabled'] ?? 'SMS Enabled' }}</label>
                            </div>
                        </div>
                        <div class="mt-5"><span
                            class="text-sm text-uppercase ">{{ $lang->data['SMS Format'] ?? 'SMS Format' }}</span>
                        </div>
                        <hr>
                        <div class="row mt-2 mb-2" >
                            <div class="col-12 col-md-12 col-lg-8 col-sm-12">
                                <label for="">{{$lang->data['create_order']??'Create Order'}}</label>
                                <textarea name="text" class="form-control" id="" cols="30" x-ref="create" rows="12" x-model="myCreateSMS"> </textarea>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 col-md-12">
                                <div class="row">
                                    <template x-for="(replace,index) in replacers">
                                        <div class="col-12 col-lg-6 col-md-12 mt-2">
                                            <button class="btn-sm btn btn-secondary w-100 h-100 "  x-text="replace" type="button" @click="addText(index,1)"></button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-12 col-md-12 col-lg-8 col-sm-12">
                                <label for="">{{$lang->data['status_change']??'Status Change'}}</label>
                                <textarea name="text" class="form-control" id="" cols="30" x-ref="status" rows="12" x-model="myStatusChange"> </textarea>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 col-md-12">
                                <div class="row">
                                    <template x-for="(replace,index) in replacers">
                                        <div class="col-12 col-lg-6 col-md-12 mt-2">
                                            <button class="btn-sm btn btn-secondary w-100 h-100 " x-text="replace" type="button" @click="addText(index,2)"></button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary ms-4"
                                    wire:click.prevent="save()">{{ $lang->data['save'] ?? 'Save' }}</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
        function initz()
        {

            return {
                replacers : @entangle('replacer'),
                myCreateSMS : '',
                myStatusChange : '',
                start()
                {
                    let myloadData = @js(trim( preg_replace( '/\s+/', ' ', $create_order ) ));
                    let smyloadData = @js(trim( preg_replace( '/\s+/', ' ', $status_change ) ));
                    this.myCreateSMS = myloadData;
                    this.myStatusChange = smyloadData;
                    this.$watch('myCreateSMS', value => @this.create_order = value);
                    this.$watch('myStatusChange', value => @this.status_change = value);
                },
                addText(replace,index)
                {

                    if(index == 1)
                    {
                        var cursorPos = this.$refs.create.selectionStart;
                        v = this.myCreateSMS;
                        var textBefore = v.substring(0,  cursorPos);
                        var textAfter  = v.substring(cursorPos, v.length);
                        this.myCreateSMS = textBefore + replace + textAfter;
                        this.$refs.create.focus()
                    }
                    if(index == 2)
                    {
                        var cursorPos = this.$refs.status.selectionStart;
                        v = this.myStatusChange;
                        var textBefore = v.substring(0,  cursorPos);
                        var textAfter  = v.substring(cursorPos, v.length);
                        this.myStatusChange = textBefore + replace + textAfter;
                        this.$refs.status.focus()
                    }
                    @this.addTextToItem(replace,index)
                },
            }

        }
    </script>
    @endpush
   
</div>