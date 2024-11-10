<div>
    <nav class="navbar navbar-main navbar-expand-lg  px-0 mx-4 shadow-none border-radius-xl z-index-sticky "
        id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
                <a href="javascript:;" class="nav-link p-0">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                    </div>
                </a>
            </div>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <ul class="ms-md-auto  navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center me-2">
                        <a href="{{ route('admin.create_orders') }}" class="nav-link text-white font-weight-bold px-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{ $lang->data['add_new_order'] ?? 'Add New Order' }}" data-container="body"
                            data-animation="true">
                            <i class="fa fa-plus-circle me-sm-1"></i>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center me-2">
                        <a href="{{ route('admin.service_list') }}" class="nav-link text-white font-weight-bold px-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{ $lang->data['manage_services'] ?? 'Manage Services' }}" data-container="body"
                            data-animation="true">
                            <i class="fa fa-tag me-sm-1"></i>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center me-2">
                        <a href="{{ route('admin.customers') }}" class="nav-link text-white font-weight-bold px-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{ $lang->data['manage_customers'] ?? 'Manage Customers' }}" data-container="body"
                            data-animation="true">
                            <i class="fa fa-user me-2"></i>
                        </a>
                    </li>
                    @if(count($languages) > 0)
                    <li class="nav-item d-flex align-items-center">
                        <div class="dropdown mx-2">
                            <button class="btn btn-xs bg-white dropdown-toggle mb-0 text-primary" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $lang->name ?? 'Choose Language'}}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="top:0rem!important;">
                                @foreach ($languages as $key => $item)
                                    <li><a class="dropdown-item text-xs"
                                            wire:click.prevent="changeLanguage({{ $key }})">{{ $item }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>