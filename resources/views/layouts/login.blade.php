<?php

use PhpParser\Node\Stmt\Echo_;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
?> 



<style>
    .otp-container {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 50px;
    }
    .otp-input {
    width: 40px;
    height: 40px;
    font-size: 24px;
    text-align: center;
    }

    .modalCamera{
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 99999; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */ 
        background-color: rgba(0,0,0,0.2); /* Black w/ opacity */
    }

    .modalCamera-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }
    
    .db_alert{
        background-color: #c06b6bff;
        display: inline;
        padding: 20px;
        color: #fff;
    }

    .txtPass{
        width: 85%;
        outline: none;
        border: none;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" /> 
    <link rel="stylesheet" href="{{ asset('admin/css/style-login.css')}}">
    <title>Payfactor Web Portal</title>

    <script src="{{ asset('admin/js/face-api.min.js')}}?v={{ filemtime(public_path('admin/js/face-api.min.js')) }}"></script>
    <script src="{{ asset('admin/js/scripts.js')}}?v={{ filemtime(public_path('admin/js/scripts.js')) }}"></script>
    <script src="{{ asset('admin/js/jquery-3.6.0.min.js')}}?v={{ filemtime(public_path('admin/js/jquery-3.6.0.min.js')) }}"></script>
    <script src="{{ asset('admin/js/all.js')}}?v={{ filemtime(public_path('admin/js/all.js')) }}"></script>

 

    <script>
        window.setTimeout(function () {
            $("#alert-danger").fadeTo(2500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2500);
    </script>
</head>
    <?php    

     $targetTime = "2025-02-26 10:03:18";   
     $targetTimestamp = strtotime($targetTime);  
     $companyLogoBlob = str_replace("MAJAKiosk","",str_replace("/kiosk","",env('APP_URL'))."assets/img/".env('DEFAULT_LOGO'));  
    ?>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100"> 
        
        <form id="loginForm" action="{{ route('login.submit') }}" method="POST" 
            class="row border rounded-5 bg-white shadow box-area"> 
            @if (session('captcha') ==1)
                <div class="alert alert-danger text-center" id="alert-danger">Invalid Captcha Code.</div>
            @endif 
            @csrf
            <!-- left box -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <!-- <img src="{{ asset('admin/images/PAYFACTOR.jpg') }}" class="img-fluid" style="width: 400px;"
                        alt="COMPANY LOGO"> -->
                    <center><img id="companyLogo" src="{{$companyLogoBlob}}" class="img-fluid" style="max-width:400px;min-width:250px;"
                        alt="COMPANY LOGO"></center>
                </div>
                 <!-- <img src="{{ asset('admin/images/PAYFACTOR.jpg') }}" class="img-fluid" style="width: 200px;"  alt="COMPANY LOGO"> -->
                    <center class="mt-5"><img id="pfLogo"  src="{{ asset('admin/images/PAYFACTOR.png') }}" class="img-fluid" style="width: 120px;"  alt="Powered By Payfactor"></center>
                <!-- <small class="text-black text-wrap text-center"
                    style="width: 17rem;font-family: 'Courier New', Courier, monospace;">
                    Powered by Payfactor
                </small> -->
            </div>

            <!-- right box -->
            <div class="col-md-6 right-box">

                <div class="row align-items-center">

                    <div class="header-text mb-4">

                        <div id="div_cont">
                            @if($mode=="login")
                                <h2>Hello, Again</h2> 
                                <p>We are happy to have you back.</p> 
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                        </ul>
                                    </div>
                                @endif 

                                <div class="input-group mb-3">
                                    <input type="text" name="username" class="form-control form-control-lg bg-light fs-6"
                                        placeholder="Username" required>
                                </div> 
                                <div class="input-group mb-3 form-control" style="display:flex; justify-content:flex-start;">
                                    <input type="password" class="txtPass" name="password" onkeyup="return showToggleEye(this.value)" onchange="return showToggleEye(this.value)">
                                    <i class="fa-solid fa-eye m-2" style="cursor:pointer;display:none; float:right" id="togglePassword" onclick="return showPass(this)"></i> 
                                </div>
                            


                                <label for="database" class="form-label">Database:</label>
                                <div class="input-group mb-5">
                                    <select id="database" name="database" class="form-select" onchange="return SelectDB(this.value)" required>
                                        <option value="" disabled selected>Select a Database</option>
                                        @if(isset($databases) && count($databases) > 0)
                                            @foreach ($databases as $database)
                                                <option value="{{ $database->db_name }}">{{ $database->db_description }}</option>
                                            @endforeach
                                        @else
                                            <option value="">No databases available</option>
                                        @endif
                                    </select>
                                </div> 
                                
                                <div  class="input-group mb-3" id="divCaptcha"></div> 
                                <div  class="modalCamera" id="divScanner"></div>

                                <div class="input-group mb-3">
                                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                                </div> 
                                <div style="overflow: hidden;">
                                    <div style="float: left;"><a href="#" style="text-decoration: none; color: inherit;" onclick="forgotPassword()">Forgot password?</a></div>
                                    <!-- <div style="float: right;"><a id="1asdd" href="#" onclick="return loadFaceRecognizer(this.id,1)">Face Recognition</a></div> -->
                                </div>
                                <br><br>
                            @else
                            
                             <h5 class="text-info">OTP Verification</h5>
                             Please enter the OTP(One-Time Password) sent to your registered <u>{{$emailAddress}}</u> email to complete your verification
                             with reference no.: <i style="font-size: 12px; color:red">{{$refno}}</i>
                            <!-- <br> {{$otp}} -->
                                
                           
                            <div class="otp-container" id="divOtp">
                                <input type="text" id="otp1" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                                <input type="text" id="otp2" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                                <input type="text" id="otp3" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                                <input type="text" id="otp4" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                                <input type="text" id="otp5" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                                <input type="text" id="otp6" maxlength="1" class="otp-input" onkeyup="checkOTP(this.id)" />
                            </div>
                            <center>
                                Remaining time: <b id="timer">--:--s</b> <br>
                                 <div id="otpmsg"></div>
                            </center>
                            <br><br> 
                            Didn't get the code? <b><a href='{{url("/send_mfa")}}'>Resend</a></b>
                            <br><br>

                            <script>
                                    const inputs = document.querySelectorAll('.otp-input'); 
                                    inputs.forEach((input, index) => {
                                        input.addEventListener('input', (e) => {
                                        const value = e.target.value;

                                        if (value.length > 1) {
                                            // If more than 1 char entered (e.g., paste), split and fill all
                                            handlePaste(value);
                                            return;
                                        }

                                        if (value && index < inputs.length - 1) {
                                            inputs[index + 1].focus();
                                        }
                                        });

                                        input.addEventListener('keydown', (e) => {
                                        if (e.key === 'Backspace' && !input.value && index > 0) {
                                            inputs[index - 1].focus();
                                        }
                                        });

                                        input.addEventListener('paste', (e) => {
                                        e.preventDefault();
                                        const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                                        handlePaste(pasteData);
                                        });
 
                                    });

                                    function handlePaste(pasteString) {
                                        const digits = pasteString.replace(/\D/g, '').slice(0, 6).split('');
                                        inputs.forEach((input, i) => {
                                        input.value = digits[i] || '';
                                        }); 
                                        const firstEmpty = Array.from(inputs).find(input => input.value === '');
                                        if (firstEmpty) firstEmpty.focus();
                                        checkOTP(1);
                                    }

                                    async function checkOTP(id){
                                         const inputs = document.querySelectorAll('.otp-input');
                                         var otpText = "";
                                         inputs.forEach(element => {
                                            otpText+=document.getElementById(element.id).value;
                                         }); 
  
                                         if(otpText.length == 6){   
                                            GlovalHTMLObjLoading(1,'otpmsg'); 
                                            var formData = new FormData(); 
                                            formData.append('username', '<?=$username?>');   
                                            formData.append('otp', otpText);   
                                            var rslt = await call_page_into_div(formData,'{{url("/verifyMFA")}}'); 
                                            //console.log(rslt);
                                            var code = JSON.parse(rslt).otpResult.num; 
                                            var result = JSON.parse(rslt).otpResult.msg; 
                                            if(code==1){ 
                                                document.getElementById('otpmsg').innerHTML = result;
                                            }else{ 
                                                window.location.href = '{{url("/goto_Dashboard")}}';
                                            } 
              
                                         } 
                                    }

                                    function countDown(){
                                        let seconds = 59;
                                        const timerDisplay = document.getElementById('timer');
                                        const countdown = setInterval(() =>{
                                             timerDisplay.textContent = seconds + 's';
                                             seconds--;

                                             if(seconds<0){
                                                clearInterval(countdown);
                                                timerDisplay.textContent = 0;
                                             }  
                                        },1000);
                                    }

                                    countDown();
                            </script>
                            @endif 

                        </div>

                        <div class="row">
                            <small>
                                <center>&copy; <?=date('Y')?> OGIS Philippines Inc. {{$version}}</center>
                            </small> 
                        </div>

                    </div>

                </div> 

            </div>
            
        </form>

    </div>
<script>

        var thisDB,email,otp,pass1,pass2;
        var divScanner = document.getElementById('divScanner');
        // Function to load CAPTCHA
        function loadCaptcha() {
            var captchaImage = document.getElementById('captcha');
            var captchaContainer = document.getElementById('captcha-container');
            var captchaError = document.getElementById('captcha-error');

            captchaImage.src = "{{ route('generate_captcha') }}";

            captchaImage.onload = function () {
                captchaImage.style.display = 'block';
                captchaError.style.display = 'none';
            };


            captchaImage.onerror = function () {
                console.error('CAPTCHA generation failed: Image could not be loaded');
                captchaContainer.style.display = 'none';
                captchaError.style.display = 'block';
            };
        }
 
        async function SelectDB(db){
           document.getElementById("divCaptcha").innerHTML = "Checking if captcha is active. . . ."; 
           var formData = new FormData(); 
           formData.append('db', db);   
 
            try {
                var rslt = await call_page_into_div(formData,'{{url("/select_db")}}');  
                document.getElementById("divCaptcha").innerHTML = rslt; 
            } catch (error) {
                document.getElementById("divCaptcha").innerHTML = ""; 
            } 
 
          window.onload = generateCaptcha("divCaptcha"); 
           
        }

        function forgotPassword(){
            var db = document.getElementById('database').value;
            if (db==""){
                alert('Please select database first');
            }else{ 
                thisDB = db;  
                password_verefication(0,1,"div_cont");
            }
        }
        
        async function password_verefication(mode,num,objID){ 

            var thisNum = parseInt(num-mode);
            GlovalHTMLObjLoading(1,objID);
            var divMsg = document.getElementById("divMsg");
            var formData = new FormData(); 
            formData.append('num', thisNum);   

            /*
                1 - Goto Forgot Password
                2 - Enter Email
                3 - Verify OTP
                4 - Verify New Password
            */   

            if (thisNum==0){
                GlovalHTMLObjLoading(0,objID);   
                return false;
            }

            if (thisNum==1){ 
                formData.append('db', thisDB);   
            }
             
            if (thisNum==2){  
                if (document.getElementById('txtEmail') !== null){
                    this.email = document.getElementById('txtEmail').value;
                }
                formData.append('email', this.email);  
            }

            if (thisNum==3){  
                if (document.getElementById('txtOTP') !== null){
                    this.otp = document.getElementById('txtOTP').value;
                }
                formData.append('otp', this.otp);  
            }
            
            if (thisNum==4){  
                if (document.getElementById('txtPass') !== null){
                    this.pass1 = document.getElementById('txtPass').value;
                }
                formData.append('pass1', this.pass1);  
            }

            if (thisNum==5){  
                if (document.getElementById('txtPass2') !== null){
                    this.pass2 = document.getElementById('txtPass2').value;
                }
                formData.append('pass2', this.pass2);  
            }
 
            
            var rslt = await call_page_into_div(formData,"change_pass"); 

            if(isCompleted){
                GlovalHTMLObjLoading(0,objID);   
            }

            document.getElementById("div_cont").innerHTML = rslt; 
           
        }

        function errorMsg(msg){
            var new_msg = "<div style='background-color:#f88d6d; color:white' class='form-control'><i class='fa-solid fa-triangle-exclamation'></i>   "+msg+"</div>";
            return new_msg;
        }

        function isValidEmail(email) {
            const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return regex.test(email);
        }

        async function get_forgot_validation(num,objID) {  

            GlovalHTMLObjLoading(1,objID);  
            var formData = new FormData();
            formData.append('mode', '16');    
            formData.append('pint_mode', pint_mode);   

            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
             
        }
        
        async function loadFaceRecognizer(id,mode) {  

            alert('Sorry, this facility is under maintinance for now!');
            return false;

            divScanner.style.display = "block";
            var formData = new FormData(); 
            formData.append('mode', mode);    
            formData.append('database', document.getElementById('database').value);  
            
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: '{{url("/gotoFaceRecognizer")}}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        $('#divScanner').html(`<center>`+response+`</center>`);
                    },
                    error: function (msg) {
                        //alert(JSON.parse(msg.responseText).error.msg.msg);
                        console.log('Error:' + JSON.stringify(msg));
                    }

                });
            
        }

        async function showToggleEye(val) {
            var togglePassword = document.getElementById('togglePassword');
            togglePassword.style.display = (val!=="") ? "block" : "none"; 
        }

        async function showPass(toggleBtn) {
            var password = document.getElementsByName('password')[0]; 
            var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            toggleBtn.classList.toggle('fa-eye');
            toggleBtn.classList.toggle('fa-eye-slash');
        }

        //window.onload = loadCaptcha;
        
</script> 
<script src="{{ asset('admin/js/captcha.js')}}"></script> 


<script>
    const errorLogs = localStorage.getItem("errorLogs");
    // const errorLogs = localStorage.getItem("errorLogs");
    if (errorLogs){
       // fetch("{{url('/saveSystemErrors')}}", {
        $.ajax({
            url: "{{ route('saveSystemErrors') }}",
            type: "POST",
            data: {
                errorLogs: errorLogs, 
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                //console.log(response);
                localStorage.removeItem("errorLogs");
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
    
</script>


</body>


 