<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
         <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       
         <!-- Favicon -->
        <link href="{{ asset('assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
        <!-- Icons -->
         <link href="{{ asset('assets/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/css/argon.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/clockpicker.css') }}" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('assets/css/argon.css?v=1.0.0')}}" rel="stylesheet">
        <link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet">
      
        <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- new -->

        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    </head>
    <body class="{{ $class ?? '' }}">
        
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layout.navbars.sidebar')
            @endauth      
        <div class="main-content">
            @include('layout.navbars.navbar')
            @yield('content')
        </div>
        @guest()
            @include('layout.footers.guest')
        @endguest
        <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/clockpicker.js')}}"></script>
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('assets/js/argon.js?v=1.0.0')}}"></script>

         <!--  new js library -->
     <!--   <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
       <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

       <script src="{{ url('/') }}/build/js/custom.min.js"></script>
        <script src="{{ url('/') }}/js/jquery-confirm.min.js"></script>
        <script src="{{ url('/') }}/js/bootstrap-datetimepicker.js"></script>
        <script src="{{ url('/') }}/js/jquery.common.js"></script>

        <script type="text/javascript" src="{{ asset('js/tableExport/tableExport.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/tableExport/jquery.base64.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/tableExport/jspdf/libs/sprintf.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/tableExport/jspdf/jspdf.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/tableExport/jspdf/libs/base64.js') }}"></script>

        <script src="{{ url('/') }}/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
         <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'Done'
        });
    </script>
    </body>
</html>