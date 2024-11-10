<!DOCTYPE html>
<html lang="en" @if(isRTL() == true) dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset(getFavIcon())}}">
    <title>
        {{ getApplicationName() }}
    </title>
    <link href="{{asset('assets/css/poppinsfont.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.min28b5.css?v=2.0.0')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/js/plugins/toastr.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
    @livewireScripts
    @livewireStyles
    <script src="{{ asset('js/app.js') }}" defer></script>
    @include('livewire.admin.translations.languageStyles')
</head>
<body class="g-sidenav-show @if(isRTL() == true) rtl @endif">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @livewire('components.side-bar')
    <main class="main-content position-relative border-radius-lg ">
    @livewire('components.header')
    <div class="container-fluid py-2">
    {{$slot}}
    </div>
    </main>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/dragula/dragula.min.js')}}"></script>
    <script src="{{asset('assets/js/argon-dashboard.min.js')}}"></script>
    <script>
        "use strict";
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
    "use strict"
     Livewire.on('closemodal',() => {
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').removeAttr('style');
        })
    </script>
    <script>
        "use strict";
        Livewire.on('reloadpage',() => {
        window.location.reload();
        })
    </script>
    <script>
        "use strict";
        window.addEventListener('alert', event => { 
            toastr[event.detail.type](event.detail.message, event.detail.title ?? '');
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        });
        @if(Session::has('message'))
        toastr.info("{{ Session::get('message') }}");
        @endif
    </script>
    <script>
        "use strict";
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
@stack('js')
</body>
</html>