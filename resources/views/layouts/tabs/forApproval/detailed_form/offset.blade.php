 
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
 
        $osAppNo=$details['rows'][0]->osAppNo;
        $osAppDate=$details['rows'][0]->osAppDate;
        $osDate=$details['rows'][0]->osDate;
        $osCosCenter=$details['rows'][0]->osCosCenter;
        $osID=$details['rows'][0]->osID;
        $osName=$details['rows'][0]->osName;
        $department=$details['rows'][0]->department;
        $osType=$details['rows'][0]->osType;
        $osReason=$details['rows'][0]->osReason;
        $osDateFrom=$details['rows'][0]->osDateFrom;
        $osDateTo=$details['rows'][0]->osDateTo;

        $location=$details['rows'][0]->locationName;
        $osTimeFrom=$details['rows'][0]->osTimeFrom;
        $osTimeTo=$details['rows'][0]->osTimeTo;
        $osReference=$details['rows'][0]->osReference;

       
 ?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$osAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$osAppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$osCosCenter?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$osID?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$osName?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Department</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$department?>" readonly>
                        </div>
                  </div>
            </div>

            
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Offset Date From</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$osDateFrom?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Offset Date To</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$osDateTo?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Location</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$location?>" readonly>
                        </div>
                  </div>
            </div>


            <!--  ,$osTimeFrom,$osTimeTo,$osReference  -->
             
            <div class="col-12">
                  <div class="row">
                        <div class="col-3">
                              <label for="appEmployeeId" class="form-label">To From</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$osTimeFrom?>" readonly>
                        </div>
                        <div class="col-3">
                              <label for="appEmployeeName" class="form-label">To Time</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$osTimeTo?>"
                                    readonly>
                        </div>
                        <div class="col-6">
                              <label for="appDepartment" class="form-label">Remarks</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$osReason?>" readonly>
                        </div>
                  </div>
            </div>


            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label for="appEmployeeId" class="form-label">Reference</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$osReference?>" readonly>
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