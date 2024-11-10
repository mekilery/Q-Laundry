<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['master_settings'] ?? 'Master Settings' }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3 align-items-center">
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['application_details'] ?? 'Application Details' }}</span>
                        </div>
                        <hr>
                        <div class="col-md-4">
                            <label
                                class="form-label">{{ $lang->data['application_name'] ?? 'Application Name' }}<span
                                    class="text-danger">*</span></label>
                            <input type="text" required autofocus class="form-control"
                                wire:model="default_application_name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ $lang->data['app_logo'] ?? 'App Logo' }}</label>
                            <input type="file" class="form-control" wire:model="default_logo">
                        </div>
                        <div class="col-md-4">  
                            <label class="form-label">{{ $lang->data['favicon'] ?? 'Favicon' }}</label>
                            <input type="file" class="form-control" wire:model="default_favicon">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" required class="form-control"
                                placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}"
                                wire:model="default_phone_number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ $lang->data['email'] ?? 'Email' }} <span
                                    class="text-danger">*</span></label>
                            <input type="email" required class="form-control"
                                placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ $lang->data['password'] ?? 'Password' }}<span
                                    class="text-danger">*</span></label>
                            <input type="password" required class="form-control"
                                placeholder="{{ $lang->data['password'] ?? 'Password' }}" wire:model="password">
                        </div>
                        <hr>
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['finance_settings'] ?? 'Finance Settings' }}</span>
                        </div>
                        <hr>
                        <div class="col-md-3">
                            <label
                                class="form-label">{{ $lang->data['currency_symbol'] ?? 'Currency Symbol' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="default_currency">
                        </div>
                        <div class="col-md-3">
                            <label
                                class="form-label">{{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }}</label>
                            <input type="text" class="form-control" placeholder=""
                                wire:model="default_tax_percentage">
                        </div>
                        <div class="col-md-6">
                            <label for="">{{ $lang->data['select_financial_year'] ?? 'Financial Year' }}</label>
                            @php
                                $inline_financial_year = App\Models\FinancialYear::latest()->get();
                            @endphp
                            <select name="financial_year" class="form-select" wire:model="default_financial_year">
                                <option value="">{{$lang->data['select_financial_year'] ?? 'Select A Financial Year'}}</option>
                                @foreach ($inline_financial_year as $row)
                                    <option value="{{ $row->id }}">{{ $row->year }} @if ($row->starting_date)
                                            [ {{ \Carbon\Carbon::parse($row->starting_date)->format('d/m/Y') }} to
                                            {{ \Carbon\Carbon::parse($row->ending_date)->format('d/m/Y') }} ]
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['firm_address'] ?? 'Firm Address' }}</span>
                        </div>
                        <hr>
                        @php
                            $inline_countries = App\Models\Country::latest()->get();
                        @endphp
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['country'] ?? 'Country' }}</label>
                            <select class="form-select" wire:model="default_country">
                                @foreach ($inline_countries as $row)
                                    <option value="{{ $row->country_code }}">{{ $row->country_name }}
                                        [{{ $row->country_code }}]</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['state'] ?? 'State' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="default_state">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['city'] ?? 'City' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="default_city">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['district'] ?? 'District' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="default_district">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['zip_code'] ?? 'Zip Code' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="default_zip_code">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['store_email'] ?? 'Store Email' }}</label>
                            <input type="email" class="form-control" placeholder="" wire:model="store_email">
                        </div>
                        <div class="col-md-3">
                            <label
                                class="form-label">{{ $lang->data['store_tax_number'] ?? 'VAT ID' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="store_tax">
                        </div>
                        <div class="col-md-3">
                            <label
                                class="form-label">{{ $lang->data['iban_number'] ?? 'IBAN Number' }}</label>
                            <input type="text" class="form-control" placeholder="" wire:model="iban_number">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="inputAddress"
                                class="form-label">{{ $lang->data['address'] ?? 'Address' }}</label>
                            <textarea class="form-control" placeholder="" wire:model="default_address"></textarea>
                        </div>
                        <hr>
                        <div><span
                                class="text-sm text-uppercase">{{ $lang->data['other_settings'] ?? 'Other Settings' }}</span>
                        </div>
                        <hr>
                        <div class="col-md-3">
                            <label class="form-label">{{ $lang->data['printer_pos'] ?? 'Printer POS' }}</label>
                            <select class="form-select" wire:model="default_printer">
                                <option value="1">  {{ $lang->data['a4'] ?? 'A4' }} </option>
                                <option value="2"> {{ $lang->data['thermal'] ?? 'Thermal' }} </option>
                            </select>
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