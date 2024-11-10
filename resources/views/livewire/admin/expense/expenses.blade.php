<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['expense'] ?? 'Expense' }}</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addexpense" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{ $lang->data['add_new_expense'] ?? 'Add New Expense' }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model="search">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['date'] ?? 'Date' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['amount'] ?? 'Amount' }}</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">
                                        {{ $lang->data['towards'] ?? 'Towards' }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['tax_included'] ?? 'Tax Included' }}?</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['payment_mode'] ?? 'Payment Mode' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                            {{ $lang->data['created_by'] ?? 'Created By' }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $row)
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">
                                                {{ date('d/m/Y', strtotime($row->expense_date)) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $row->expense_amount }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm px-3 mb-0">
                                                {{ $row->expenseCategory->expense_category_name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="badge badge-sm bg-dark text-uppercase">
                                                @if ($row->tax_included)
                                                    {{ $lang->data['yes'] ?? 'YES' }}
                                                @else
                                                    {{ $lang->data['no'] ?? 'No' }}
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0 text-uppercase">
                                                {{ getpaymentMode($row->payment_mode) }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0 text-uppercase">
                                                {{ $row->user->name ?? "" }}</p>
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#editexpense"
                                                wire:click="edit({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs">
                                                {{ $lang->data['edit'] ?? 'Edit' }}
                                            </a>
                                            <a href="#" type="button" wire:click="delete({{ $row->id }})"
                                                class="ms-2 badge badge-xs badge-danger text-xs fw-600">
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
    <div class="modal fade" wire:ignore.self id="addexpense" tabindex="-1" role="dialog"
        aria-labelledby="addexpense" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ $lang->data['add_expense'] ?? 'Add Expense' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['date'] ?? 'Date' }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" required class="form-control" wire:model="expense_date">
                                @error('expense_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label
                                    class="form-label">{{ $lang->data['expense_category'] ?? 'Expense Category' }}<span
                                        class="text-danger">*</span></label>
                                @php
                                    $inline_categories = App\Models\ExpenseCategory::latest()->get();
                                @endphp
                                <select class="form-control" wire:model="expense_category_id">
                                    <option value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    @foreach ($inline_categories as $row)
                                        <option value={{ $row->id }}>{{ $row->expense_category_name }}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="error text-danger">{{ 'Expense Category Required' }}</span>
                                @enderror
                                </select>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['expense_amount'] ?? 'Expense Amount' }}
                                    <span class="text-danger">*</span></label>
                                <input type="number" required class="form-control"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="expense_amount">
                                @error('expense_amount')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label
                                    class="form-label">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }}</label>
                                <select class="form-select" wire:model="payment_mode">
                                    <option value="">{{ $lang->data['choose_payment_mode'] ?? 'Choose Payment Mode' }}
                                    </option>
                                    <option class="select-box" value="1">{{ $lang->data['cash'] ?? 'Cash' }}
                                    </option>
                                    <option class="select-box" value="2">{{ $lang->data['upi'] ?? 'UPI' }}</option>
                                    <option class="select-box" value="3">{{ $lang->data['card'] ?? 'Card' }}
                                    </option>
                                    <option class="select-box" value="4">{{ $lang->data['cheque'] ?? 'Cheque' }}
                                    </option>
                                    <option class="select-box" value="5">
                                        {{ $lang->data['bank_transfer'] ?? 'Bank Transfer' }}</option>
                                </select>
                                @error('payment_mode')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="form-label">{{ $lang->data['tax_included'] ?? 'Tax Included' }}
                                        ?</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" id="no" name="tax"
                                            wire:model="tax_included" value="0">
                                        <label class="form-check-label"
                                            for="no">{{ $lang->data['no'] ?? 'No' }}</label>
                                    </div>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="radio" id="yes" name="tax"
                                            wire:model="tax_included" value="1">
                                        <label class="form-check-label"
                                            for="yes">{{ $lang->data['yes'] ?? 'Yes' }}</label>
                                    </div>
                                    @if ($tax_included == 1)
                                        <div class="ms-4">
                                            <input type="number" wire:model="tax_percentage" class="form-control"
                                                placeholder="{{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }}"
                                                style="width: 150px;">
                                            @error('tax_percentage')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="inputAddress"
                                    class="form-label">{{ $lang->data['notes'] ?? 'Notes' }}</label>
                                <textarea class="form-control"
                                    placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                    wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" wire:click.prevent="store()"
                            class="btn btn-primary">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self id="editexpense" tabindex="-1" role="dialog"
        aria-labelledby="editexpense" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ $lang->data['edit_expense'] ?? 'Edit Expense' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['date'] ?? 'Date' }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" required class="form-control" wire:model="expense_date">
                                @error('expense_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <label
                                    class="form-label">{{ $lang->data['expense_category'] ?? 'Expense Category' }}<span
                                        class="text-danger">*</span></label>
                                @php
                                    $inline_categories = App\Models\ExpenseCategory::latest()->get();
                                @endphp
                                <select class="form-control" wire:model="expense_category_id">
                                    <option value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    @foreach ($inline_categories as $row)
                                        <option value={{ $row->id }}>{{ $row->expense_category_name }}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="error text-danger">{{ 'Expense Category Required' }}</span>
                                @enderror
                                </select>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label">{{ $lang->data['expense_amount'] ?? 'Expense Amount' }}
                                    <span class="text-danger">*</span></label>
                                <input type="number" required class="form-control"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="expense_amount">
                                @error('expense_amount')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label
                                    class="form-label">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }}</label>
                                <select class="form-select" wire:model="payment_mode">
                                    <option value="">{{ $lang->data['choose_payment_mode'] ?? 'Choose Payment Mode' }}
                                    </option>
                                    <option class="select-box" value="1">{{ $lang->data['cash'] ?? 'Cash' }}
                                    </option>
                                    <option class="select-box" value="2">{{ $lang->data['upi'] ?? 'UPI' }}
                                    </option>
                                    <option class="select-box" value="3">{{ $lang->data['card'] ?? 'Card' }}
                                    </option>
                                    <option class="select-box" value="4">{{ $lang->data['cheque'] ?? 'Cheque' }}
                                    </option>
                                    <option class="select-box" value="5">
                                        {{ $lang->data['bank_transfer'] ?? 'Bank Transfer' }}</option>
                                </select>
                                @error('payment_mode')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="form-label">{{ $lang->data['tax_included'] ?? 'Tax Included' }}
                                        ?</label>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="radio" id="no" name="tax"
                                            wire:model="tax_included" value="0">
                                        <label class="form-check-label"
                                            for="no">{{ $lang->data['no'] ?? 'No' }}</label>
                                    </div>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="radio" id="yes" name="tax"
                                            wire:model="tax_included" value="1">
                                        <label class="form-check-label"
                                            for="yes">{{ $lang->data['yes'] ?? 'Yes' }}</label>
                                    </div>
                                    @if ($tax_included == 1)
                                        <div class="ms-4">
                                            <input type="number" wire:model="tax_percentage" class="form-control"
                                                placeholder="{{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }}"
                                                style="width: 150px;">
                                            @error('tax_percentage')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="inputAddress"
                                    class="form-label">{{ $lang->data['note'] ?? 'Note' }}</label>
                                <textarea class="form-control"
                                    placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                    wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" wire:click.prevent="update()" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>