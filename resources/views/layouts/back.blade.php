<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Payfactor</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('admin/css/styles.css')}}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('admin/js/scripts.js')}}"></script>
    <script src="{{ asset('admin/js/confirm.js')}}"></script>
    <script src="{{ asset('admin/js/toast.js')}}"></script>
    <script src="{{ asset('admin/js/face-api.min.js')}}"></script>
    <link href="{{asset('admin/css/confirm.css')}}" rel="stylesheet" /> 
</head>

<body class="sb-nav-fixed">
    @include('layouts.partials.navbar') 
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">@include('layouts.partials.sidebar')</div> 
        <div id="layoutSidenav_content">
            <main>
                <div id="divContent">
                    <div class="container-fluid px-4">
                        @yield('content')
                    </div>
                </div>
            </main>
            @include('layouts.partials.footer')
        </div>
    </div>
</body>

 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script> 
<script src="{{asset('admin/js/scripts.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.2.1/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

<script src="{{ asset('admin/js/datatables-simple.js')}}"></script>

 

<!-- <script src="{{asset('admin/js/chart-bar.js')}}"></script>
<script src="{{ asset('admin/js/chart-pie.js')}}"></script> -->

</html>