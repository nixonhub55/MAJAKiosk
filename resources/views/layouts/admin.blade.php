<script>
    var identityId = '<?= session()->get('identityId') ?>'; 
  
    
    /* async function getErrorsNow() {
        return new Promise((resolve, reject) => {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "{{url('/saveSystemErrors')}}", true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);  
            xhr.onload = function () {
                resolve(JSON.parse(xhr.responseText)); 
                };  
            xhr.send(errorLogs); 
        }); 
    } */


</script>

 


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

    
    <!-- <script src="{{ asset('admin/js/scripts.js')}}"></script>
    <script src="{{ asset('admin/js/search.js')}}"></script>
    
    <script src="{{ asset('admin/js/confirm.js')}}"></script>
    <script src="{{ asset('admin/js/toast.js')}}"></script>
    <script src="{{ asset('admin/js/face-api.min.js')}}"></script> -->

    <script src="{{ asset('admin/js/scripts.js') }}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    <script src="{{ asset('admin/js/search.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    
    <script src="{{ asset('admin/js/confirm.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    <script src="{{ asset('admin/js/toast.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    <script src="{{ asset('admin/js/face-api.min.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    
    <script>window.attachedFilesAssetsUrl = "{{ url('/attachedFilesAssets') }}";</script>
    <link href="{{asset('admin/css/confirm.css')}}" rel="stylesheet" /> 
</head>

<body class="sb-nav-fixed">
    @include('layouts.partials.navbar') 
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">@include('layouts.partials.sidebar')</div> 
        <div id="layoutSidenav_content">
            <main>
                <?php
                    $SESSION_COOKIE = env('SESSION_COOKIE'); 
                    foreach ($_COOKIE as $name => $value) { // Temporary Solution for across session
                        if ((strpos($name, 'pf_session') !== false) && $name!==$SESSION_COOKIE) { 
                            setcookie($name, '', time() - 3600, '/');
                        }
                    }
                ?>
                <div id="divContent"> 
                    <div id="netSpan"> 
                    </div>
                    <div class="container-fluid">
                        <div class="page-title2">
                            <h5 class="text-info mb-0 me-3" style="margin:10px;">
                                @include('layouts.partials.pagetitle')
                            </h5> 
                        </div>
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

<script>
    

    async function checkConnection() {
        try {
            const start = performance.now();

            await fetch('https://www.google.com', {
            method: 'HEAD', // no body download
            cache: 'no-store',
            mode: 'no-cors' // avoids CORS issues
            });

            const latency = performance.now() - start;

            //console.log(`Latency: ${latency.toFixed(0)} ms`);
            var netSpan = document.getElementById('netSpan');
            netSpan.innerHTML = "";
            if (latency > 2000) { // 2000 dapat
                saveErrorLogs({
                    logId: 1,
                    identityId: identityId,
                    formData: {},
                    time: new Date(),
                    errorMsg: `Slow internet connection | Latency: ${latency.toFixed(0)} ms`
                });
                //alert(`Slow internet connection | Latency: ${latency.toFixed(0)} ms`); 
                netSpan.innerHTML = `<div class="alert alert-warning">
                                        <i class="fas fa-wifi text-danger"></i> Slow internet connection | Latency: ${latency.toFixed(0)} ms
                                    </div> `; 
            } 

        } catch (err) {
            //console.error('Connection failed:', err); 
            saveErrorLogs({
            logId: 1,
            identityId: identityId,
            formData: {},
            time: new Date(),
            errorMsg: 'No internet connection'
            });
        }

        setTimeout(checkConnection, 5000);
    } 
    checkConnection();

    window.addEventListener('offline', () => { 
        saveErrorLogs({
            logId: 1,
            identityId: identityId,
            formData: {},
            time: new Date(),
            errorMsg: 'Internet disconnected'
        });
    }); 

    window.addEventListener("beforeunload", function () {
        navigator.sendBeacon("/clear-session");
    });

</script>

</html>

 