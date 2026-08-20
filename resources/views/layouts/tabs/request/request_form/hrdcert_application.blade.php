@extends('layouts.admin') <!-- main layout file -->

@section('content')  
    <style>
        .btn-add {
                background: #28a745;
                color: #fff;
                font-size: 14px;
                border-radius: 20px;
                padding: 8px 20px;
                text-decoration: none;
        }

        .btn-export {
                background: #6c757d;
                color: #fff;
                font-size: 14px;
                border-radius: 20px;
                padding: 8px 20px;
                text-decoration: none;
        }
        .modal-body {
                padding: 2em;
        }

        .bg-primary {
                background-color: black;
        }

        .tdDate{  
                font-weight:bold;
                font-size:25px;
                color:white;
        }

        .tdDate2{
                color:white;
        }

        .divLeft{
                vertical-align:top;
        }
        .rmvBtn{
                position: absolute;
                top:-10px;
                right:-10px;
                font-size:20px;
                color:#fff;
                cursor:pointer;
                background-color: #e18956;
                width:32px; 
                border-radius:50%;
                border-top:1px solid black;
                border-right:1px solid black
        }  

        .lblH3{
            font-weight: bold;
            font-size:20px;
            margin-bottom:20px;
        }

        .lblH4{
            font-weight: bold;
            font-size:20px;
        }

        .tab1{ 
            margin-left:20px;
        }
        .tab2{ 
            margin-left:40px;
        }
        .tab3{ 
            margin-left:60px;
        }

        .txtLine{
            outline:none;
            border:none;
            border-bottom:1px solid black;
            min-width: 300px;
        }
    
    </style> 
    
    <?php
        $appNo=0;
        $user_details = $user_details['rows'][0];   
        $requestDate = date('Y-m-d');
        $dateNeeded = "";
        $creditCardApp = "";
        $visaApp = "";
        $visaAppCtry = "";
        $visaAppForWhose="";
        $visaAppForWhoseOtherDetail="";
        $visaAppKind="";
        $visaAppKindOtherDetail="";
        $loanApp="";
        $loanAppInstitution="";
        $idApp="";
        $idAppHospital="";
        $idAppHospRecipient="";
        $otherPurpose="";
        $otherPurposeDetail="";
        $hdmf="";
        $clearanceCert="";
        $otherCert="";
        $otherCertDetail="";
        
 
        
        $certOfemp = "";
        $selectedhearID = "";
        $creditCardAppBank="";
 

        foreach ($appNoInfo['rows'] as $rows){
            $appNo = $rows->r_appNo;
            $certOfemp = $rows->certOfemp;
            $requestDate = $rows->requestDate;
            $dateNeeded = $rows->dateNeeded;
            $creditCardApp = $rows->creditCardApp;
            $creditCardAppBank = $rows->creditCardAppBank;
            $visaApp = $rows->visaApp;
            $visaAppCtry = $rows->visaAppCtry;
            $visaAppForWhose = $rows->visaAppForWhose;
            $visaAppForWhoseOtherDetail = $rows->visaAppForWhoseOtherDetail;
            $visaAppKind = $rows->visaAppKind;
            $visaAppKindOtherDetail = $rows->visaAppKindOtherDetail;
            $loanApp = $rows->loanApp;
            $loanAppInstitution = $rows->loanAppInstitution;
            $idApp = $rows->idApp;
            $idAppHospital = $rows->idAppHospital;
            $idAppHospRecipient = $rows->idAppHospRecipient;
            $otherPurpose = $rows->otherPurpose;
            $otherPurposeDetail = $rows->otherPurposeDetail;
            $hdmf = $rows->hdmf;
            $clearanceCert = $rows->clearanceCert;
            $otherCert = $rows->otherCert;
            $otherCertDetail = $rows->otherCertDetail; 
            $selectedhearID = ($certOfemp=="COEwithCompensation" ? "checkEWC" : "checkEWNC");
        }
         
        $routeName = ""; 
        if(!empty(session()->get('routeName'))){
            $routeName = "/".session()->get('routeName');
        } 
    ?>

        <div class="container-fluid mt-4 card-container">
           <div class="row g-3 m-2 bg-white rounded p-2 mb-5">

                <div  class="col-md-12"> 
                    <div class="form-control">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="appNumber" class="form-label">Application Number</label>
                                <input type="text" class="form-control" id="appNumber" value="<?=$appNo?>"  readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="appNumber" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="appNumber"  value="<?=$user_details->identityid?>"  readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="appNumber" class="form-label">Employee Name</label>
                                <input type="text" class="form-control" id="appNumber"  value="<?=$user_details->firstName." ".$user_details->lastName." ".$user_details->middleName?>"  readonly>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <label for="appNumber" class="form-label">Center</label>
                                <input type="text" class="form-control" id="appNumber" value="<?=$user_details->costName?>"  readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="appNumber" class="form-label">Department</label>
                                <input type="text" class="form-control" id="appNumber"  value="<?=$user_details->departmentName?>"  readonly>
                            </div>
                            <div class="col-md-2"> 
                                <label for="appNumber" class="form-label">Date Request</label>
                                <input type="text" class="form-control" id="appNumber"  value="<?=$requestDate?>"  readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="txtDateNeeded" id="lblDateNeeded" class="form-label">Date Needed</label>
                                <input type="date" class="form-control" id="txtDateNeeded"  value="<?=$dateNeeded?>" >
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-control">  
                        <input type="checkbox" id="checkEWC" onchange="return SelectCompensation(this.id)" <?=($certOfemp=="COEwithCompensation" ? "checked" : "") ?>>
                        <label class="lblH3" id="lblEWC" for="checkEWC">COEC (Employment w/ Compensation)</label>
                        &nbsp;&nbsp;
                        <input type="checkbox" id="checkEWNC" onchange="return SelectCompensation(this.id)" <?=($certOfemp=="COEnoCompensation" ? "checked" : "") ?>>
                        <label class="lblH3" id="lblEWNC" for="checkEWNC">Certificate of Employment (Date Hired w/o Compensation)</label>
                        <br>
                        <i class="tab1">Please check purpose and provide corresponding information</i>
                        <br><br>

                        <input class="tab1" type="checkbox" id="checkCCA"  onchange="return SelectApplication(this.id)" <?=($creditCardApp==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblCCA" for="checkCCA">Credit card application</label>
                        <br>
                        <i class="tab2">Name of bank or credit card company:</i><input class="txtLine" id="txtCCA" type="text" value="<?=$creditCardAppBank?>" <?=($creditCardApp==1 ? "" : "disabled") ?>> 
                        <br><br>
                        
                        <input class="tab1" type="checkbox" id="checkVA" onchange="return SelectApplication(this.id)" <?=($visaApp==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblVA" for="checkVA">Visa Application</label>
                        <br>
                        <i class="tab2">Specify country:</i><input class="txtLine" id="txtVA" type="text"  value="<?=$visaAppCtry?>" <?=($visaApp==1 ? "" : "disabled") ?>>
                        <br><br>
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="tab2">For whose application:</i>
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkEmp" onchange="return ForWhosApp(this.id)" <?=($visaAppForWhose=="fwaEmployee" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>> 
                                    <label  for="checkEmp">Employee</label>
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkSP" onchange="return ForWhosApp(this.id)" <?=($visaAppForWhose=="fwaSpouse" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>>
                                    <label  for="checkSP">Spouse</label>
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkSPE" onchange="return ForWhosApp(this.id)" <?=($visaAppForWhose=="fwaOthers" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>>
                                    <label  for="checkSPE">Others (pls. specify)</label><input id="txtSPE" class="txtLine" type="text" value="<?=$visaAppForWhoseOtherDetail?>" <?=($visaAppForWhose=="fwaOthers" ? "" : "disabled") ?>>
                                </div>
                                <div class="col-md-6">
                                    <i class="tab2">Kind of Visa:</i>  
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkTR" onchange="return SelectVisa(this.id)" <?=($visaAppKind=="kovTourist" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>> 
                                    <label  for="checkTR">Tourist</label> 
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkIM" onchange="return SelectVisa(this.id)" <?=($visaAppKind=="kovImmigrant" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>>
                                    <label  for="checkIM">Immigrant</label>
                                    <br><br> 
                                    <input class="tab2" type="checkbox" id="checkSPE2" onchange="return SelectVisa(this.id)" <?=($visaAppKind=="kovOthers" ? "checked" : "") ?> <?=($visaApp==1 ? "" : "disabled") ?>>
                                    <label  for="checkSPE2">Others (pls. specify)</label><input id="txtSPE2" class="txtLine" type="text" value="<?=$visaAppKindOtherDetail?>" <?=($visaAppKind=="kovOthers" ? "" : "disabled") ?>>
                                </div>
                            </div>
                        </div>
                        
                        <br><br> 
                        <input class="tab1" type="checkbox" id="checkLA" onchange="return SelectApplication(this.id)" <?=($loanApp==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblkLA" for="checkLA">Loan Application</label>
                        <br> 
                        <i class="tab2">Name of financing institution:</i><input id="txtLA" class="txtLine" type="text" value="<?=$loanAppInstitution?>" <?=($loanApp==1 ? "" : "disabled") ?>>

                        <br><br> 
                        <input class="tab1" type="checkbox" id="checkIDAWHO" onchange="return SelectApplication(this.id)" <?=($idApp==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblIDAWHO" for="checkIDAWHO">ID Application with Hospital/Outlet</label>
                        <br> 
                        <i class="tab2">Hospital:</i><input id="txtIDAWHO" class="txtLine" type="text" value="<?=$idAppHospital?>" <?=($idApp==1 ? "" : "disabled") ?>>
                        <br>
                        <i class="tab2">To whom letter should be addressed:</i><input  id="txtTWSA" class="txtLine" type="text" value="<?=$idAppHospRecipient?>" <?=($idApp==1 ? "" : "disabled") ?>>

                        <br><br> 
                        <input class="tab1" type="checkbox" id="checkOP" onchange="return SelectApplication(this.id)" <?=($otherPurpose==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblOP" for="checkOP">Other Purpose</label> 
                        <br>
                        <i class="tab2">Please specify:</i><input id="txtOP" class="txtLine" type="text" value="<?=$otherPurposeDetail?>" <?=($otherPurpose==1 ? "" : "disabled") ?>>
                        
                        <br><br><br>
                        <input type="checkbox" id="checkHDMF" <?=($hdmf==1 ? "checked" : "") ?>>  
                        <label class="lblH3" for="checkHDMF">HDMF Certificate of Compensation</label>
                        <br>
                        <input type="checkbox" id="checkCC" <?=($clearanceCert==1 ? "checked" : "") ?>>
                        <label class="lblH3" for="checkCC">Clearance Certificate</label>
                        <br>
                        <input type="checkbox" id="checkOC" onchange="return SelectOherCert(this.id)" <?=($otherCert==1 ? "checked" : "") ?>>
                        <label class="lblH4" id="lblOC" for="checkOC">Other Certificate</label> <br> 
                        <i class="tab1">Please specify:</i><input id="txtOC" class="txtLine" type="text" value="<?=$otherCertDetail?>" <?=($otherCert==1 ? "" : "disabled") ?>>
                    </div>

                </div> 
                <div class="row mb-5">
                    <div class="col-md-12"> 
                    <br>


                    @if($mode==0) 
                        <br>
                        <label id="lblfileCert" for="fileCert">Upload Certificate</label>
                        <input type="file" id="fileCert" class="form-control" accept="application/pdf,.pdf" required>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label id="lbldllStatus" for="dllStatus">Status</label>
                                <select id="dllStatus" class="form-select">
                                    <option value="0"></option>
                                    <option value="1">Proceed</option>
                                    <option value="2">Denied</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label id="lblremarks" for="remarks">Remarks</label>
                                <input type="text" id="remarks" class="form-control" maxlength="200">
                                <div class="counter">
                                <span id="current">0</span> / 200
                                </div>
                            </div>
                        </div>
                        <br>
                        <center>
                        <button id="btn11233" class="btn btn-primary" onclick="return ApproverResponse(0,this.id)" >Submit Response</button>
                        <button class="btn btn-danger" onclick="window.location.href='{{url("/hrd_approval")}}'">Exit</button>
                        </center>

                    @endif
                    
                    @if($mode==1)
                        <center>
                        <button id="btn112" class="btn btn-primary" onclick="return SubmitRequest(0,this.id)">Submit</button>
                        <button class="btn btn-danger" onclick="return DiscardChanges()"> Exit </button>
                        </center>
                    @endif


                    @if($mode==2)
                        <center>
                            <button class="btn btn-danger" onclick="window.location.href='{{$routeName}}'">Exit</button>
                        </center>
                    @endif

                    </div>
                </div>
           </div>
        </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        
        var selectedhearID = "<?=$selectedhearID?>";
        var selectedForWhose = "";
        var selectedVisa = "";
        var id = "<?=$appNo?>";

        var hearID = ["checkEWC","checkEWNC"];
        var app = ["checkCCA","checkVA","checkLA","checkIDAWHO","checkOP"];
        var appTXT = ["txtCCA","txtVA","txtSPE","txtSPE2","txtIDAWHO","txtOP","txtOC"];
        var visa = ["checkEmp","checkSP","checkSPE","checkTR","checkIM","checkSPE2"]; 
        var visaTXT = ["txtSPE","txtSPE2"]; 
        var forWhose = ["checkEmp","checkSP","checkSPE"];
        var forVisa = ["checkTR","checkIM","checkSPE2"];

        function SelectCompensation(id){
            
            if (selectedhearID==id){ 
                selectedhearID = "";
            }

            for (var i = 0; i < hearID.length; i++) { 
                var hdrCheckBox = document.getElementById(hearID[i]);
                if (id!==hearID[i] && (hdrCheckBox.checked)){ 
                    hdrCheckBox.checked = false;
                }else{
                    if (hdrCheckBox.checked){
                        selectedhearID = id;
                    }
                }
            }


           if (selectedhearID==""){
            CleanApplications();
            CleanVisa();
           }
        }

        function CleanApplications(){
            for (var i = 0; i < app.length; i++) { 
                var appCheckBox = document.getElementById(app[i]);
                appCheckBox.checked = false;
            }

            for (var i = 0; i < txtSPE2.length; i++) { 
                var apptxtbox = document.getElementById(txtSPE2[i]);
                apptxtbox.disabled = true;
                apptxtbox.value="";
            }
        }

        function CleanVisa(){
            for (var i = 0; i < visa.length; i++) { 
                var appCheckBox = document.getElementById(visa[i]);
                appCheckBox.checked = false;
            }

            for (var i = 0; i < appTXT.length; i++) { 
                var apptxtbox = document.getElementById(appTXT[i]);
                apptxtbox.disabled = true;
                apptxtbox.value="";
            }
        }

        function SelectApplication(id){  
            var hdrCheckBox = document.getElementById(id);
            var txtBox = document.getElementById(id.replace("check", "txt"));

            if(txtBox){
                txtBox.disabled = true;
                txtBox.value = "";
            } 

            if (selectedhearID==""){
                hdrCheckBox.checked = false;
            }else{ 
                if (hdrCheckBox.checked){ 
                    txtBox.disabled = false;
                } 
            } 
            SepecialBOX(id); 
            if(id=="checkVA"){
                SelectVisaApplication(hdrCheckBox.checked);
            }
        } 

        function SelectVisaApplication(bool){ 
           for (var i = 0; i < visa.length; i++) { 
               var checbox = document.getElementById(visa[i]);
               if(!bool){
                checbox.checked = false;
               }
               checbox.disabled = (!bool);
           }
        } 

        function SepecialBOX(id){ 
            var appCheckBox = document.getElementById(id);
            if (id=="checkIDAWHO"){
                var txtBox = document.getElementById('txtTWSA'); 
                txtBox.disabled = true;
                txtBox.value = ""; 
                txtBox.disabled = (!appCheckBox.checked); 
            } 
            
        }

        function ForWhosApp(id){

            if (selectedForWhose==id){ 
                selectedForWhose = "";
            }

            var txtBox = document.getElementById("txtSPE");
            if(txtBox){
                txtBox.disabled = true;
                txtBox.value = "";
            } 
            for (var i = 0; i < forWhose.length; i++) { 
                var CheckBox = document.getElementById(forWhose[i]); 
                if (id!==forWhose[i] && (CheckBox.checked)){ 
                    CheckBox.checked = false;
                }else{
                    if (CheckBox.checked){
                        selectedForWhose = id;
                        
                        if(id=="checkSPE"){
                            txtBox.disabled = false;
                        }
                    }
                }
            }
        }

        function SelectVisa(id){

            if (selectedVisa==id){ 
                selectedVisa = "";
            }

            var txtBox = document.getElementById("txtSPE2");
            if(txtBox){
                txtBox.disabled = true;
                txtBox.value = "";
            } 
            for (var i = 0; i < forVisa.length; i++) { 
                var CheckBox = document.getElementById(forVisa[i]); 
                if (id!==forVisa[i] && (CheckBox.checked)){ 
                    CheckBox.checked = false;
                }else{
                    if (CheckBox.checked){
                        selectedVisa = id;
                        
                        if(id=="checkSPE2"){
                            txtBox.disabled = false;
                        }
                    }
                }
            }
        }

        function SelectOherCert(id){
                //txtOC

            var checkbox = document.getElementById(id);
            var txtbox = document.getElementById('txtOC');
            txtbox.value = "";
            txtbox.disabled = (!checkbox.checked); 
 
            
        }

        async function SubmitRequest(pint_mode,objID){  
            //console.log(pint_mode);
            GlovalHTMLObjLoading(1,objID);  
            var formData = new FormData();
            formData.append('mode', 22);   
            formData.append('pint_mode', pint_mode); 
            formData.append('r_id', this.id); 
            formData.append('r_dateNeeded',  document.getElementById('txtDateNeeded').value);  
            formData.append('r_certOfemp',  selectedhearID);  
            formData.append('r_creditCardApp',  document.getElementById('checkCCA').checked);  
            formData.append('r_creditCardAppBank',  document.getElementById('txtCCA').value);  
            formData.append('r_visaApp',  document.getElementById('checkVA').checked);  
            formData.append('r_visaAppCtry',  document.getElementById('txtVA').value);  
            formData.append('r_visaAppForWhose',  selectedForWhose);  
            formData.append('r_visaAppForWhoseOtherDetail',  document.getElementById('txtSPE').value);  
            formData.append('r_visaAppKind',  selectedVisa);  
            formData.append('r_visaAppKindOtherDetail',  document.getElementById('txtSPE2').value);  
            formData.append('r_loanApp',  document.getElementById('checkLA').checked);  
            formData.append('r_loanAppInstitution',  document.getElementById('txtLA').value);  
            formData.append('r_idApp',  document.getElementById('checkIDAWHO').checked); 
            formData.append('r_idAppHospital',  document.getElementById('txtIDAWHO').value);  
            formData.append('r_idAppHospRecipient',  document.getElementById('txtTWSA').value);   
            formData.append('r_otherPurpose',  document.getElementById('checkOP').checked); 
            formData.append('r_otherPurposeDetail',  document.getElementById('txtOP').value);     
            formData.append('r_hdmf',  document.getElementById('txtOP').checked);       
            formData.append('r_clearanceCert',  document.getElementById('checkCC').checked);   
            formData.append('r_otherCert',  document.getElementById('checkOC').checked);  
            formData.append('r_otherCertDetail',  document.getElementById('txtOC').value);   

            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            if (pint_mode==0){
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){   
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert;   
                        }
                  } else{  
                    fbconfirm('Submit Confirmation', 'Are you sure, you want to submit this?', 'Yes','Cancel', 'ConfirmApplication()'); 
                  } 
                  GlovalHTMLObjLoading(0,objID); 
            }else{ 
                  window.location.href='{{url("/hrd_application")}}'; 
                  //console.log(response);
            }
        }
       
        function ConfirmApplication(){
            SubmitRequest(1,'btn112');  
        }

        function DiscardChanges(){
            //fbconfirm('Cancel Confirmation', 'Are you sure, you want to discard changes?', 'Yes','Cancel', 'window.location.href='{{url("/hrd_application")}}''); 
            fbconfirm('Cancel Confirmation', 'Are you sure, you want to discard changes?', 'Yes','Cancel', 'window.location.href="{{url('/hrd_application')}}"'); 
              
        }

  
        async function ApproverResponse(pint_mode,objID){
            GlovalHTMLObjLoading(1,objID);
            var fileInput = document.getElementById('fileCert');
            
            var formData = new FormData();
            formData.append('mode', 23);  
            formData.append('pint_mode', pint_mode);  
            formData.append('appNo', "<?=$appNo?>");  
            //formData.append('certFile', document.getElementById('fileCert').value);  
            formData.append('certFile', fileInput.files[0]); 
            formData.append('decide', document.getElementById('dllStatus').value);   
            formData.append('remarks', document.getElementById('remarks').value);   
            
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            
            if (pint_mode==0){
                if (response.num!==0){
                    var id = JSON.parse(response.msg).id;
                    if (id!== undefined){   
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert;   
                        }
                }else{ 
                    confirm_submit("Are you sure, you want to submit this response?");
                  }
                  GlovalHTMLObjLoading(0,objID); 
            }else{
                window.location.href='{{url("/hrd_approval")}}';
            }
            //console.log(response);
        }

      function confirm_submit(msg){
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmResponse()'); 
      }
      
      function ConfirmResponse(){ 
        ApproverResponse(1,'btn11233');
      } 



      var textarea = document.getElementById('remarks');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });

        
    </script>

@endsection