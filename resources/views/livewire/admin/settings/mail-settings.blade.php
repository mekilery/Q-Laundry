<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['mail_settings'] ?? 'Mail Settings' }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3 align-items-center">
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['mail_settings'] ?? 'Mail Settings' }}</span>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <label
                                class="form-label">MAIL HOST<span
                                    class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_host">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAIL PORT<span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_port">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAIL USERNAME<span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_username">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAIL PASSWORD<span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAIL FROM ADDRESS<span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_from_address">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAIL FROM NAME<span class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control" wire:model="mail_from_name">
                        </div>
                        <div class="form-group mx-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="active" wire:model="enable_forget">
                                        <label class="form-check-label" for="active">Enable Password Recovery (Forget Password Section)</label>
                                    </div>
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
</div>