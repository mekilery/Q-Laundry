<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{ $lang->data['expense_category'] ?? 'Expense Category' }}</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addcategory" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> {{ $lang->data['add_new_category'] ?? 'Add New Category' }}
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
                                placeholder="{{ $lang->data['search_here'] ?? 'Search here' }}" wire:model="search">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        {{ $lang->data['expense_category'] ?? 'Expense Category' }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xs opacity-7">
                                        {{ $lang->data['status'] ?? 'Status' }}</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                            {{ $lang->data['created_by'] ?? 'Created By' }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    
                                    $i = 1;
                                @endphp
                                @foreach ($categories as $row)
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $i++ }} </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $row->expense_category_name }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button"
                                                class="badge badge-sm bg-dark text-uppercase">{{ getExpenseCategoryType($row->expense_category_type) }}</a>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0 text-uppercase">
                                                {{ $row->user->name ?? "" }}</p>
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" wire:click="edit({{ $row->id }})"
                                                data-bs-target="#editcategory" type="button"
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
    <div wire:ignore.self class="modal fade" class="modal fade " id="addcategory" tabindex="-1" role="dialog"
        aria-labelledby="addcategory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">
                        {{ $lang->data['add_Expense_category'] ?? 'Add Expense Category' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['category_name'] ?? 'Category Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}"
                                    wire:model="expense_category_name">
                                @error('expense_category_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label
                                    class="form-label">{{ $lang->data['category_type'] ?? 'Category Type' }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" wire:model="expense_category_type"
                                    wire:change="changeCategoryType">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    <option class="select-box" value="1">{{ $lang->data['asset'] ?? 'Asset' }}
                                    </option>
                                    <option class="select-box" value="2">
                                        {{ $lang->data['liability'] ?? 'Liability' }}</option>
                                </select>
                                @error('expense_category_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="store()">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" class="modal fade " id="editcategory" tabindex="-1" role="dialog"
        aria-labelledby="editcategory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">
                        {{ $lang->data['edit_expense_category'] ?? 'Edit Expense Category' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang->data['category_name'] ?? 'Category Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}"
                                    wire:model="expense_category_name">
                                @error('expense_category_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label
                                    class="form-label">{{ $lang->data['category_type'] ?? 'Category Type' }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" wire:model="expense_category_type"
                                    wire:change="changeCategoryType">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    <option class="select-box" value="1">{{ $lang->data['asset'] ?? 'Asset' }}
                                    </option>
                                    <option class="select-box" value="2">
                                        {{ $lang->data['liability'] ?? 'Liability' }}</option>
                                </select>
                                @error('expense_category_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['cancel'] ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="update()">{{ $lang->data['save'] ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>