
    <aside class="@if(isRTL() == true) sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret @else  sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps ps--active-y @endif" id="sidenav-main" data-color="primary">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{route('admin.dashboard')}}">
                <img src="{{asset(getSiteLogo())}}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-2 h6 font-weight-bold text-uppercase">{{getApplicationName()}}
                </span>
            </a>
        </div>
        <hr class="horizontal mt-0">
        <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                @if(Auth::user()->user_type==1)
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-shop text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['dashboard'] ?? 'Dashboard'}}</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/pos') ? 'active' : '' }}" href="{{ route('admin.pos') }}">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-tag text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['pos'] ?? 'Pos'}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}" href="{{route('admin.view_orders')}}">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-basket text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['orders'] ?? 'Orders'}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Request::is('admin/order-status*') ? 'active' : '' }}" href="{{route('admin.status_screen_order')}}">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['order_status_screen'] ?? 'Order Status Screen'}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/customers*') ? 'active' : '' }}" href="{{route('admin.customers')}}">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-pink text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['customers'] ?? 'Customers'}}</span>
                    </a>
                </li>
                @if(Auth::user()->user_type==1)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#expense" class="nav-link {{ Request::is('admin/expense*') ? 'active' : '' }}" aria-controls="settings" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['expense'] ?? 'Expense'}}</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/expense*') ? 'show' : '' }}" id="expense">
                        <ul class="nav ms-4">
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/expense') ? 'active' : '' }} " href="{{route('admin.expenses')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> E </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['expense_list'] ?? 'Expense List'}}</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/expense/categories') ? 'active' : '' }}" href="{{route('admin.expense_categories')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> E </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['expense_category'] ?? 'Expense Category'}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#services" class="nav-link  {{ Request::is('admin/service*') ? 'active' : '' }}" aria-controls="settings" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['services'] ?? 'Services'}}</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/service*') ? 'show' : '' }}" id="services">
                        <ul class="nav ms-4">
                            <li class="nav-item {{ Request::is('admin/service') ? 'active' : '' }}">
                                <a class="nav-link " href="{{route('admin.service_list')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> S </span>
                                    <span class="sidenav-normal side-bar-inner">{{$lang->data['service_list'] ?? 'Service List'}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/service/type') ? 'active' : '' }}">
                                <a class="nav-link " href="{{route('admin.service_type')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> S </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['service_type'] ?? 'Service Type'}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/service/addons') ? 'active' : '' }}" href="{{route('admin.service_addons')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> A </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['addons'] ?? 'Addons'}} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tasks" class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}" aria-controls="tasks" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-chart-bar-32 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['reports'] ?? 'Reports'}}</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/reports*') ? 'show' : '' }}" id="tasks">
                        <ul class="nav ms-4">
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/reports/daily') ? 'active' : '' }}" href="{{route('admin.daily_report')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> D </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['daily_report'] ?? 'Daily Report'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/reports/order') ? 'active' : '' }}" href="{{route('admin.order_report')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> O </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['order_report'] ?? 'Order Report'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/reports/sales') ? 'active' : '' }}" href="{{route('admin.sales_report')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> S </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['sales_report'] ?? 'Sales Report'}}</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/reports/expense') ? 'active' : '' }}" href="{{route('admin.expense_report')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> E </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['expense_report'] ?? 'Expense Report'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/reports/tax') ? 'active' : '' }}" href="{{route('admin.tax_report')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> T </span>
                                    <span class="sidenav-normal side-bar-inner">{{$lang->data['tax_report'] ?? 'Tax Report'}} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#settings" class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" aria-controls="settings" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings-gear-65 text-orange text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['tools'] ?? 'Tools'}}</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/settings*') ? 'show' : '' }}" id="settings">
                        <ul class="nav ms-4">
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/financial-year') ? 'active' : '' }}" href="{{route('admin.financial_year_settings')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> F </span>
                                    <span class="sidenav-normal side-bar-inner">{{$lang->data['financial_year'] ?? 'Financial Year'}} </span>
                                </a>
                            </li>
                            <li class="nav-item "> <a class="nav-link {{ Request::is('admin/settings/payment-types') ? 'active' : '' }}" href="{{ route('admin.payment_types_settings') }}">
                                <span class="sidenav-mini-icon side-bar-inner"> P </span> 
                                <span class="sidenav-normal side-bar-inner">{{ $lang->data['payment_types'] ?? 'Payment Types' }} </span> </a> </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/translations') ? 'active' : '' }}" href="{{route('admin.translations')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> T </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['translations'] ?? 'Translations'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/mail') ? 'active' : '' }}" href="{{route('admin.mail_settings')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> T </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['mail_settings'] ?? 'Mail Settings'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/master') ? 'active' : '' }}" href="{{route('admin.master_settings')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> M </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['master_settings'] ?? 'Master Settings'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/file-tools') ? 'active' : '' }}" href="{{route('admin.filetools')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> F </span>
                                    <span class="sidenav-normal side-bar-inner"> {{$lang->data['file_tools'] ?? 'File Tools'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/sms') ? 'active' : '' }}" href="{{route('admin.sms')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> S </span>
                                    <span class="sidenav-normal side-bar-inner">{{$lang->data['sms_settings'] ?? 'SMS Settings'}} </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link  {{ Request::is('admin/settings/staff') ? 'active' : '' }}" href="{{route('admin.staff')}}">
                                    <span class="sidenav-mini-icon side-bar-inner"> S </span>
                                    <span class="sidenav-normal side-bar-inner">{{$lang->data['staff'] ?? 'Staff'}} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" wire:click.prevent="logout" href="#">
                        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-button-power text-secondary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{$lang->data['logout'] ?? 'Logout'}}</span>
                    </a>
                </li>
            </ul>
        </div>
    <hr class="horizontal dark mt-2">
</aside>