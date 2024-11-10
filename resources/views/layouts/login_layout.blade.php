<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" href="{{getFavIcon()}}">
        <title>
            {{ getApplicationName() }}
        </title>
        <link href="{{asset('assets/css/poppinsfont.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
        <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.min28b5.css?v=2.0.0')}}" rel="stylesheet" />
        <link id="pagestyle" href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
        @livewireScripts
        @livewireStyles
        <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="g-sidenav-show">
    @yield('content')
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/dragula/dragula.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/jkanban/jkanban.js')}}"></script>
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
    <script src="{{asset('assets/js/argon-dashboard.min.js')}}"></script>
</body>
</html>