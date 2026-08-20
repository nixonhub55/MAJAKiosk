 
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
  
       
      
      foreach($details['rows'] as $rows){
            $laAppNo = $rows->laAppNo;
            $laAppDate = $rows->laAppDate;
            $laID = $rows->laID;
            $laName = $rows->laName;
            $costName = $rows->costName;
            $departmentName = $rows->departmentName;
            $laType = $rows->laType;
            $locationName = $rows->locationName;
            $laBalance = $rows->laBalance;
            $laDateFrom = $rows->laDateFrom;
            $laDateTo = $rows->laDateTo;
            $laReason = $rows->laReason; 
      }
 ?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$laAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$laAppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$costName?>" readonly>
                        </div>
                  </div>
            </div>    

            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$laID?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$laName?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Department</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$departmentName?>" readonly>
                        </div>
                  </div>
            </div> 
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Leave Type</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$laType?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Balance</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$laBalance?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDepartment" class="form-label">Location</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$locationName?>" readonly>
                        </div>
                  </div>
            </div>
 
            <div class="col-12">
                  <div class="row">
                        <div class="col-6">
                              <label for="appEmployeeId" class="form-label">Date From</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$laDateFrom?>" readonly>
                        </div>
                        <div class="col-6">
                              <label for="appEmployeeName" class="form-label">Date To</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$laDateTo?>"
                                    readonly>
                        </div> 
                  </div>
            </div>


            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <table class="table table-striped">
                              <thead class="table-dark">
                                    <tr>
                                    <th>#</th>
                                    <th><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;Date</th>
                                    <th><i class="fas fa-history"></i>&nbsp;&nbsp;Day part</th>
                                    <th>Days Count</th>
                                    </tr>
                              </thead>  
                              <tbody>

                              @foreach($sched_list['rows'] as $rows)
                                    <tr>
                                          <td>{{$rows->laLstID}}</td>
                                          <td>{{$rows->laLstDate}} - {{$rows->laLstDateDesc}}</td>
                                          <td>{{$rows->laSchedDesc}}</td>
                                          <td>{{round($rows->laSched,2)}}</td>
                                    </tr> 
                              @endforeach 
                              </tbody>
                              </table>
                        </div> 
                  </div>
            </div>

            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label for="appEmployeeId" class="form-label">Leave Reason</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$laReason?>" readonly>
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