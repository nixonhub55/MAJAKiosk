<!DOCTYPE html>
<html>
<head>
    <title>Server Error</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f5f5f5;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 4px 15px rgba(0,0,0,.1);
            text-align:center;
            max-width:700px;
        }

        h1{
            color:#dc3545;
            font-size:60px;
            margin-bottom:10px;
        }

        h2{
            margin-top:0;
        }

        p{
            color:#666;
        }

        a{
            display:inline-block;
            margin-top:20px;
            background:#007bff;
            color:white;
            padding:10px 20px;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>
<body>

<div class="card">   
    <p>
        We're unable to complete your request at the moment.  Please refresh the page and try again. 
    </p>
    <p>
      If the problem continues after refreshing, contact your HR or IT Support for assistance.
    </p>

    <!-- <a href="{{ url('/') }}">Refresh Page</a> -->
    <a href="{{ url()->current() }}" class="btn btn-primary">
       Refresh Page
    </a>
    
</div>

</body>
</html>