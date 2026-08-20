

<style>
      .btn-primary {
            background-color: #007bff;
            border-radius: 4px;
            border: none;
      }

      .btn-success {
            background-color: #28a745;
            border-radius: 4px;
            border: none;
            transition: background-color 0.3s ease;
      }

      .btn-success:hover {
            background-color: #218838;
      }

      .form-label {
            font-weight: bold;
      }

      .input-group-text {
            background-color: #f8f9fa;
      }

      .form-control {
            border-radius: 4px;
      }

      .red a {
            color: red !important;
            pointer-events: none;
            /* Disable clicking */
      }



      @media (max-width: 767px) {
            .custom-container {
                  width: 100%;
                  margin-top: 20px;
            }
      }

      .input-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
      }

      .form-check-label {
            font-size: 0.9rem;
      }

      .modal-footer .btn {
            padding: 0.5rem 2rem;
      }

      /* Custom Datepicker Style */
      .ui-datepicker-calendar {
            border-radius: 4px;
      }
</style>

 

<?php

      
    $data = $user_details['rows'][0];  
    $empID = $data->identityid; 
    $center = $data->costName;
    $department = $data->departmentName;
    $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;
    $AppDate=date('Y-m-d');
      

    foreach($sched_details['rows'] as $rows){
        $AppNo = $rows->AppNo;
        $AppDate = $rows->AppDate;
        $day = $rows->day;
        $payrollPeriod = $rows->payrollPeriodFrom." To ".$rows->payrollPeriodTo;
        $scheduleName = $rows->scheduleName;
        $scRemarks = $rows->scRemarks;
        $prevSchedule = $rows->prevSchedule;
        $appStatus = $rows->appStatus;
    }
    
?>

<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application No.</label>
                              <input type="text" class="form-control" id="appNumber" value="<?=$AppNo?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$AppDate?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$center?>" readonly>
                        </div>
                  </div>
            </div>
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$empID?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$fullname?>"
                                    readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDepartment" class="form-label">Department</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$department?>" readonly>
                        </div>
                  </div>
            </div> 
    
            <div class="col-12">
                  <div class="row">
                         
                        <div class="col-md-4">
                              <label for="appDepartment" class="form-label">Schedule Change Date</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$day?>" readonly>
                        </div>

                        <div class="col-md-4">
                              <label for="txtPayroll" id="lbl_Payroll" class="form-label">Payroll Period</label>
                              <input type="text" class="form-control" id="txtPayroll" value="<?=$payrollPeriod?>" readonly>
                        </div>

                        <div class="col-md-4">
                              <label for="appDepartment" class="form-label">Previous Schedule</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$prevSchedule?>" readonly>
                        </div> 

                  </div> 
            </div> 

            <div class="col-12">
                  <div class="row">
                  
                        <div class="col-md-4">
                              <label id="lbl_ddlSchedule" for="ddlSchedule" class="form-label"><?=($appStatus=="P" ? "Requested Schedule" : "Current Schedule")?></label>
                              <select class="form-select" id="ddlSchedule">
                                <option value="0" disabled>Select Schedule name</option>
                                @foreach($schedules['rows'] as $rows)
                                <option value="{{$rows->scheduleCode}}" <?=($scheduleName==$rows->scheduleCode ? "selected" : "") ?>  >{{$rows->scheduleName}}</option>
                                @endforeach
                              </select>
                        </div>
 

                        <div class="col-md-8">
                              <label id="lbl_txtRemarks" for="txtRemarks" class="form-label">Remarks</label>
                              <input type="text" id="txtRemarks" class="form-control" maxlength="200" value="<?=$scRemarks?>" placeholder="Enter your reason here">
                              <div class="counter">
                              <span id="current">0</span> / 200
                              </div>
                        </div> 

                  </div>
            </div>

             
            
            <div class="col-md-12" id="divWizard"></div>

            
            
            @if($access_rights['rows'][0]->scheduleChange==1)

            <div class="col-12">
                  <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="verification_checkbox">
                        <label id="verification_checkbox_lbl" class="form-check-label" for="verification_checkbox">
                              I verify that all the information above is correct.
                        </label>
                  </div>
            </div> 

            <div class="modal-footer" id="btns">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btn1" class="btn btn-success" onclick="return SubmitRequest (0,this.id)">Save changes</button>
            </div>
            @else
                  <center>
                        <hr>
                        <center>
                            <i class='fa-solid fa-triangle-exclamation' style='font-size:40px; color:orange'></i>
                            <p>Your account does not have permission to change schedule.</p>
                      </center>
                        
                  </center>
            @endif
            
      </form>
</div> 


  

 <script>
      
      async function SubmitRequest (pint_mode,objID) { 
            GlovalHTMLObjLoading(1,objID);  
            document.getElementById('div_validation').innerHTML="";
            var formData = new FormData();
            formData.append('mode', '20');    
            formData.append('pint_mode', pint_mode);    
            formData.append('appNo', '<?=$appNo?>');     
            formData.append('r_Day','<?=$day?>');   
            formData.append('r_scSchedule',document.getElementById('ddlSchedule').value); 
            formData.append('r_scReason',document.getElementById('txtRemarks').value);  
            console.log(formData);

            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            var vfbox = this_should_be_verified('verification_checkbox');  
            
            if (pint_mode==0){
                if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                            console.log(id); 
                            show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                            var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                            document.getElementById('div_validation').innerHTML = alert;   
                        }
                }
                else if (vfbox.num==1){ 
                        GlovalHTMLObjLoading(0,objID);  
                        show_error_message(vfbox.id+'_lbl',vfbox.msg); 
                        return false;
                }else{  
                confirm_submit("Are you sure, you want to submit this?");
                } 
                GlovalHTMLObjLoading(0,objID); 
            }else{ 
                 //console.log(response);
               window.location.href='{{url("/sc_application")}}'; 
            }
      }

      function ConfirmApplication(){
         SubmitRequest (1,"btn1"); 
      }

      function confirm_submit(msg){   
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      } 

      var textarea = document.getElementById('txtRemarks');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });
      
</script>