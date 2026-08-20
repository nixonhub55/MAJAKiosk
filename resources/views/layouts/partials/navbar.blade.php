<style>
    .sb-topnav .input-group {
    max-width: 300px;
    }

    .sb-topnav .ms-auto {
    display: flex;
    align-items: center;
    gap: 1rem;
    }
    #search-results {
    position: absolute;
    top: 100%; 
    left: 0;
    z-index: 1000; 
    width: 100%; 
    max-height: 500px; 
    overflow-y: auto; 
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 4px; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    }

    .navbar-nav{
    margin-right: 32px;  
    } 

    .comp_logo{
   /*  height: 50%; */ /* scale logo height relative to banner */
    max-height: 50px; /* limit size to prevent overflow */
    width: auto;
    }

 
</style>
<?php

    $compySettings = session()->get('companyPasswordSettings');
    $compyLogo = $compySettings['companyLogoBlob'];
    //$compyLogoimageFile =session()->get('companyBaseUrl').$compySettings['ImageFile'];
    $compyLogoimageFile = str_replace("/MAJAKiosk","",str_replace("/kiosk","",env('APP_URL'))).$compySettings['ImageFile'];
    $hostName = env('DB_OWNER');
?>

<script> 
       /*  alert('<?=$compyLogoimageFile?>');  */
      /*   alert("{{ env('APP_URL') }}");  */ 
</script>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a id="desktopLogo" class="navbar-brand ps-3" href="{{ url('/dash_cust') }}">
        <!-- <img src="<?=$compyLogo?>" class="comp_logo" alt="<?=session()->get('companyName');?>">    -->
        <img src="<?=$compyLogoimageFile?>" class="comp_logo" alt="<?=session()->get('companyName');?>">
      </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
      
    <div class="page-title">
        <h5 class="text-white mb-0 me-3">
            @include('layouts.partials.pagetitle')
        </h5> 
    </div>
    
    <div class="ms-auto d-flex align-items-center">
        
        <div id="search1">
            @include('layouts.partials.searchbox') 
        </div>
        
        
        <!-- Dropdown -->
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"    style="color:white"></i>
                </a>
                <!-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"   style="color:red"> -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('change_password') }}">Settings</a></li> 
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form action="{{ route('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="border: none; background: none;">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
 
</nav>
