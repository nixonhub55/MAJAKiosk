 
 
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
     
      $otAppNo = $details['rows'][0]->otAppNo;
      $emp_id = $details['rows'][0]->otID;
      $otName = $details['rows'][0]->otName;
      $AppDate = $details['rows'][0]->otAppDate;
      $otCosCenter = $details['rows'][0]->otCosCenter;
      $department = $details['rows'][0]->department; 
      $otDate = $details['rows'][0]->otDate;
      $Time = $details['rows'][0]->otTimeFrom." -- ".$details['rows'][0]->otTimeTo;
      $otTotHours = $details['rows'][0]->otTotHours; 
      $otReason = $details['rows'][0]->otReason; 
      $otExtAllowance = $details['rows'][0]->otExtAllowance;  
      $otExtAllowDetails = json_decode($details['rows'][0]->otExtAllowDetails,true) ?? []; 
      //return;
      //echo json_encode($otExtAllowDetails);
 
 ?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        @if($otExtAllowance==1)
                              <div class="col-12 mb-3">
                                    <div class="alert alert-warning" role="alert">
                                          <i class="fas fa-exclamation-triangle"></i> This application requesting for <b>Extension Allowance</b>
                                    </div>
                              </div>
                        @endif
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$otAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$AppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$otCosCenter?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$emp_id?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$otName?>"
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
                              <label for="appEmployeeId" class="form-label">Work Date</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$otDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Time</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$Time?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Work Tot. Hours</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$otTotHours?>" readonly>
                        </div>
                  </div>
            </div>
            
            @if($otExtAllowance==1)
                  @if($otExtAllowDetails)
                        <div class="col-12">
                              <div class="row">
                                    <div class="col-3">
                                          <label for="appEmployeeId" class="form-label">Regular Schedule</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$otExtAllowDetails['regSched']?>" readonly>
                                    </div>

                                    <div class="col-3">
                                          <label for="appEmployeeId" class="form-label">DTR In</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$otExtAllowDetails['actTimeIn']?>" readonly>
                                    </div>

                                    <div class="col-3">
                                          <label for="appEmployeeId" class="form-label">DTR Out</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$otExtAllowDetails['actTimeOut']?>" readonly>
                                    </div>

                                    <div class="col-3">
                                          <label for="appEmployeeId" class="form-label">Total Allowance</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$otExtAllowDetails['totalAllowance']?>" readonly>
                                    </div>

                                    @if($otExtAllowDetails['isImage']!=="")
                                          <div class="col-12 mt-3 mb-3">
                                                Attached file. <br>
                                                @if($otExtAllowDetails['isImage']==1)
                                                      <img src="{{ $otExtAllowDetails['attachmentContent'] }}" alt="Image">
                                                @else 
                                                <a href="{{ $otExtAllowDetails['attachmentContent']}}" target="_blank" rel="noopener noreferrer">
                                                      <i class="fa-regular fa-file-pdf text-danger fs-1"></i> <br> {{ $otExtAllowDetails['attachmentFileName'] }}
                                                </a> 
                                                @endif 
                                          </div>
                                    @endif
                                    
                        </div>
                  @else
                        <div>
                              <i class="fas fa-exclamation-triangle text-warning"> </i> Extension allowance details not found!
                        </div>
                  @endif
            @endif


            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label for="appEmployeeId" class="form-label">Reason</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$otReason?>" readonly>
                        </div> 
                  </div> 
            </div>

            @if($otExtAllowance==0)
                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
            @endif

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
      
</script>

@if($otExtAllowance==0)
<script>
      loadAttachmentsAssets(0,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
</script>
@endif