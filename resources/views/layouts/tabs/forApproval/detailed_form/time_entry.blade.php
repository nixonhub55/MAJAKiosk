 
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
 
      $teAppNo=$details['rows'][0]->teAppNo; 
      $teID=$details['rows'][0]->teID; 
      $teAppDate=$details['rows'][0]->teAppDate; 
      $teDate=$details['rows'][0]->teDate; 
      $teName=$details['rows'][0]->teName; 
      $teCosCenter=$details['rows'][0]->teCosCenter; 
      $department=$details['rows'][0]->department; 
      $teType=$details['rows'][0]->teType; 
      $teTime=$details['rows'][0]->teTime; 
      $teReason=$details['rows'][0]->teReason; 


 ?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-md-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$teAppNo?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$teAppDate?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$teCosCenter?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-md-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$teID?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$teName?>"
                                    readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDepartment" class="form-label">Department</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$department?>" readonly>
                        </div>
                  </div>
            </div>


            <div class="col-md-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appEmployeeId" class="form-label">Date Adjustment</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$teDate?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appEmployeeName" class="form-label">Adjustment Type</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$teType?>"
                                    readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDepartment" class="form-label">Adjustment Time</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$teTime?>" readonly>
                        </div>
                  </div>
            </div>


            <div class="col-md-12">
                  <div class="row">
                        <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label">Adjustment Reason</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$teReason?>" readonly>
                        </div> 
                  </div> 
            </div>

            <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>

            <div class="col-md-12">
                  <div class="row">
                        <div class="col-md-12">
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
      
      loadAttachmentsAssets(0,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });
</script>