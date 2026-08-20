 
<style>
    canvas {
      border: 1px solid #ccc;
      display: block;
      margin-bottom: 10px;
    } 
    #result {
      font-weight: bold;
    }

    #btnRefresh{
        cursor: pointer;
        margin-top:20px;
    }
</style> 

<center>

<div class="conatiner">
    <div class="row">
        <div class="col">  
            <canvas id="captchaCanvas" name="captchaCanvas" height="50"></canvas>
        </div>
        <div class="col"> 
        <i class="fa-solid fa-arrows-rotate" id="btnRefresh"  onclick="generateCaptcha()" title="Refresh captcha"></i>
        </div>
    </div>

    <div class="row input-group mb-3">
        <!-- <input type="text" id="captchaInput" class="form-control form-control-lg bg-light fs-6" placeholder="Type the code above" maxlength="6"> -->
        <input type="text" 
                class="form-control form-control-lg bg-light fs-6" 
                placeholder="Type the code above" 
                maxlength="6"
                name="captcha_code"
                id="captcha_code" 
                autocomplete="off"
                required
                >
        
    </div>
  </div>
</center>



  
 