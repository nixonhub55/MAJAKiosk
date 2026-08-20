<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('admin/css/style-login.css')}}">
    <script src="{{ asset('admin/js/scripts.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payfactor Web Portal</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.setTimeout(function () {
            $("#alert-danger").fadeTo(2500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2500);
    </script>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
       <!--  <form id="newPasswordForm" action="" method="POST" class="row border rounded-5 p-3 bg-white shadow box-area"> -->
        <div  class="row border rounded-5 p-3 bg-white shadow box-area">
            @csrf
            <!-- left box -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="{{ asset('admin/images/PAYFACTOR.jpg') }}" class="img-fluid" style="width: 400px;"
                        alt="COMPANY LOGO">
                </div>
                <small class="text-black text-wrap text-center"
                    style="width: 17rem;font-family: 'Courier New', Courier, monospace;">
                    Powered by Payfactor
                </small>
            </div>

            <!-- right box -->
            <div class="col-md-6 right-box">

                <div class="row align-items-center">

                    <div class="header-text mb-3">
                        <h2>Hello, Again</h2>
                        <hr> 
                        <div id="divMsg" class="alert alert-warning">The user must change their password before first login.</div>

                     
                    </div>

                    <div id="divInputs">
                        <div class="input-group mb-3">
                            <input type="text" id="newPassword" name="newPassword" class="form-control form-control-lg bg-light fs-6"
                                placeholder="New password"  onkeyup="return HideText(this.id)" required autocomplete="off" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" id="confirmPassword" name="confirmPassword" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Confirm Password" onkeyup="return HideText(this.id)" required autocomplete="off" required>
                        </div>

                        <div class="input-group mb-3">
                            <button type="submit" id="btn123" class="btn btn-lg btn-primary w-100 fs-6" onclick="return VerifyNewPassword(this.id)">Change Password</button>
                           
                        </div>
                        <br> 
                            <center><a href='{{url("/")}}'>Login other account<a/></center>
                        <br> 
                    </div>

                    <div class="row">
                        <small>
                            <center>&copy; <?=date('Y')?> OGIS Philippines Inc.</center>
                        </small>
                    </div>
                </div>
            </div>
            </div>
       <!--  </form> -->
    </div> 
</body>
 
<script>
 


    async function VerifyNewPassword(objID){
       
       var newPass = document.getElementById('newPassword').value;
       var confirmPassword = document.getElementById('confirmPassword').value;
       var identity = "<?=session()->get('username')?>"; 
       console.log(identity);
       var divMsg = document.getElementById('divMsg');
        
       var formData = new FormData(); 
       formData.append('mode', 21);
       formData.append('nPass', newPass);  
       formData.append('cPass', confirmPassword);  
       formData.append('identity', identity);  

 
       const response = await exec_XMLHttpRequest(formData,'{{url("/new_pass")}}');   
        
       if (response.num !== 0){
           divMsg.innerHTML = (response.msg);
       }else{ 
           divMsg.innerHTML = (response.msg);
           document.getElementById('divInputs').innerHTML = "<center><a href='{{url("/")}}'>Back to login<a/></center><br><br>";
           
       }


   }

</script>