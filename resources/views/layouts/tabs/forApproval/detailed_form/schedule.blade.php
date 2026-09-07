<!-- [{"scAppNo":7,"scID":"0601200128","scName":"Willard Legleitner Calkin","scAppDate":"2025-04-05","scCosCenter":"MHCPSILU_Terminal Operation","scReqDate":"2013-00-01","scPreviousSched":"19:00-07:00+2","scSchedule":"13:00-01:00+3","scPayrollPeriod":"5-23","scDay":"2024-12-04","scReason":"testing la ay","scStatus":"P","department":"Operations","location":null,"locationName":null,"center":"MHCPSILU_Terminal Operation","appDate":"2025-04-05","fullName":"Willard Legleitner Calkin","approverLocked":null,"departmentName":null,"costName":null,"enc_id":"RitHZm5rQUJvK2dSSjhBSnpFZE9uUT09","enc_pay":"eUlNYzRjR3V5ZEgvQ0VnWkovSjVmQT09"}] -->
 
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
 
      $scAppNo=$details['rows'][0]->scAppNo; 
      $scID=$details['rows'][0]->scID; 
      $scAppDate=$details['rows'][0]->scAppDate;  
      $scName=$details['rows'][0]->scName; 
      $scCosCenter=$details['rows'][0]->scCosCenter; 
      $department=$details['rows'][0]->department;   
      $scReason=$details['rows'][0]->scReason; 
      $scPreviousSched=$details['rows'][0]->scPreviousSched; 
      $scSchedule=$details['rows'][0]->scSchedule;   
      $scPayrollPeriod=$details['rows'][0]->scPayrollPeriod; 
      $payrollDateRange=$details['rows'][0]->payrollDateRange ?? ""; 
      $scReqDate=$details['rows'][0]->scReqDate; 


      


 ?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$scAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$scAppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$scCosCenter?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$scID?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$scName?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Department</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$department?>" readonly>
                        </div>
                  </div>
            </div>


            <div class="col-12"> 
                  <div class="row mb-3">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Previous Schedule</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$scPreviousSched?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Requested Schedule</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$scSchedule?>"
                                    readonly>
                        </div> 
                   
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Schedule Request Date</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$scReqDate?>"
                                    readonly>
                        </div> 

                        <div class="col-6" hidden>
                              <label for="appDepartment" class="form-label">SC Payroll Period</label> 
                              <div class="form-control"><?=$scPayrollPeriod?> <drange style="color:green; font-size:10px">(<?= $payrollDateRange ?>)</drange></div>
                              <!-- <input type="text" class="form-control" id="appDepartment" value="<?=$scPayrollPeriod?> (<?= $payrollDateRange ?>)" readonly> -->
                        </div> 
            </div> 

            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label for="appEmployeeId" class="form-label">Request Reason</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$scReason?>" readonly>
                        </div> 
                  </div> 
            </div>

            <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>


            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label id="lbltxtReject" for="txtReject" class="form-label">Rejection Remarks</label> 
                              <textarea id="txtReject" class="form-control" maxlength="200"></textarea>
                              <div class="counter">
                                    <span id="current">0</span> / 200
                              </div>
                        </div> 
                  </div> 
            </div>
      </form>
</div> 
<script> 
      function check_if_payroll_locked(){ 
            var enc_pay = '<?=$enc_pay?>';
            if (enc_pay==1){
                  document.getElementById("btns").innerHTML = lockApproverMessage;
            }else{
                  document.getElementById("btns").innerHTML = original_btns;
            }
      } 
      check_if_payroll_locked();
      
      var textarea = document.getElementById('txtReject');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });

      loadAttachmentsAssets(0,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
</script>