 

<?php 
$mode = 0;  
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    $code = $_GET['code'];
    $paydate = $_GET['paydate'];
}
?>
 
@if($mode == 1)
    <input type="hidden" name="txtCode" value={{$code}}>
    <input type="hidden" name="txtpaydate" value={{$paydate}}>
@endif
 
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="overtimeModalLabel">Please Re-Enter you password</h5> 
</div>
<div class="modal-body">
    <div class="container">
        <div class="row">
                <div class="col-8">
                     
                        <div class="input-group">
                            <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Enter password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="ShowHidePassword('txtPass')">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                           
                        </div>
                        <div style="color:red" id="divMsg"></div>
                </div>
        </div>
    </div>
</div>
<div class="modal-footer"> 
    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
     <button name="btnSubmitPass" class="btn btn-success" onclick="return EnterPassword('txtPass','divMsg')">Submit</button>
</div>