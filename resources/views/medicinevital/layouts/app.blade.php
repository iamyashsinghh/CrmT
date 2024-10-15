<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    @yield('header-css')
    @yield('header-script')
</head>
<style>
    .table-responsive {
        overflow-x: visible !important;
    }

    .table-responsive #serverTable thead {
        position: sticky !important;
        top: 0;
    }

    .vendor-list {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<body class="sidebar-mini layout-fixed">
    @include('includes.preloader')
    @include('medicinevital.layouts.navbar')
    @include('medicinevital.layouts.sidebar')

    <div class="wrapper">
        @section('main')
        @show
        @include('includes.footer')
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/common.js') }}"></script>

    @php
        if (session()->has('status')) {
            $type = session('status');
            $alert_type = $type['alert_type'];
            $msg = $type['message'];
    @endphp

    <script>
        toastr["{{ $alert_type }}"](`{{ $msg }}`);
    </script>

    @php
        }
    @endphp

    @yield('footer-script')
</body>

</html>
