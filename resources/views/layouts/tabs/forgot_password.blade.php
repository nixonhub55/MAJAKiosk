 
<style>
    .msg_alert{
        color:red
    } 

.hidden-text {
        font-family: monospace;
        letter-spacing: 2px;
        font-size:20px;
    }
</style> 
 

        <h2>Forgot Password</h2>  
        <?php
            $num = ($num-$errNum);
            $num2 = $num+1; 

         
            

            if($errNum!==0){ 
               echo "<div style='background-color:#f88d6d; color:white' class='form-control'><i class='fa-solid fa-triangle-exclamation'></i> ".$errMsg."</div></br>";
            }
        ?>
 
        @if($num==1) 
            <p>Step 1:</p>
            <p>  - Simply enter your email address below to get OTP.</p> 
            <div class="input-group mb-3">
                <input type="email" id="txtEmail" class="form-control form-control-lg bg-light fs-6"
                    placeholder="Enter your Email address" value="" required>   
            </div> 
        @endif
        
        @if($num==2) 
        <p>Step 2:</p>
        <p> - Enter OTP from your email for verefication with reference No.:<i style='color:red'>{{$RefNo}}</i></p> 
            <div class="input-group mb-3"> 
                <input type="text" id="txtOTP" class="form-control form-control-lg bg-light fs-6"
                    placeholder="Enter OTP" value="" required>   
            </div> 
        @endif
         
        @if($num==3) 
        <p>Step 3:</p>
        <p> - Enter your new password</p> 
            <div class="input-group mb-3">
               <!--  <input type="text" id="txtPass" class="form-control form-control-lg bg-light fs-6"
                    placeholder="password" value=""  required>    -->
                <input type="text" id="txtPass" class="form-control form-control-lg bg-light fs-6"
                placeholder="Enter password" value="" onkeyup="return HideText(this.id)" required autocomplete="off"> 
           
            </div> 
        @endif 

        @if($num==4) 
        <p>Step 4:</p>
        <p> - Re-Enter your new password</p> 
            <div class="input-group mb-3">    
           <!--      <input type="text" id="txtPass2" class="form-control form-control-lg bg-light fs-6"
                placeholder="Re-Enter password" value="" onkeyup="return HideText(this.id)"  required> -->
                <input type="text" id="txtPass2" class="form-control form-control-lg bg-light fs-6"
                placeholder="Re-Enter password" value="" onkeyup="return HideText(this.id)"  required> 
            </div> 
        @endif

        @if($num==5) 
            <br>

            <h5 style='color:green'><i class="fa-solid fa-circle-check"></i> Congratulation, your password has been successfully retrieved</h5><br><br>
        @endif
        
        
         
        @if($num<5) 
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="btn1" class="btn btn-lg btn-primary w-100 fs-6" onclick="return password_verefication(1,{{$num}},this.id)">Prev</div>
                </div>
                <div class="col-12 col-md-6">
                    <div id="btn2" class="btn btn-lg btn-primary w-100 fs-6" onclick="return password_verefication(0,{{$num2}},this.id)">Next</div>
                </div>
            </div>
        </div>
        @endif

        <br><br>
       <center> <a href="{{ url('/') }}">Go to Login</a></center>
        <br><br>

 
 