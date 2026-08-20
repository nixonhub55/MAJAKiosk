@if(isset($param['mode'])) 

    @if($param['mode']==1) <!-- REPORT RE-ENTER PASSWORD -->
    
    <input type="hidden" name="txtCode" value="<?=$param['code']?>">


    <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Enter your password</h5> 
      </div>

      <div class="modal-body"> 
        <div class="input-group">
            <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Enter password" onkeyup="return HideText(this.id)" >
            <!-- <span class="input-group-text">
                <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
            </span> -->
            <div style="color:red" id="divMsg"></div> 
        </div>
      </div>

      <div class="modal-footer">
        <button name="btnCancel" class="btn btn-danger" >Cancel</button>
        <button name="btnSubmitPass" class="btn btn-success" onclick="return EnterPassword('txtPass','divMsg')">Submit</button>
      </div> 


      <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
      // Toggle the input type
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);

      // Toggle the icon
      this.classList.toggle("bi-eye");
      this.classList.toggle("bi-eye-slash");
    });
  </script>
 
    @endif
@endif
 