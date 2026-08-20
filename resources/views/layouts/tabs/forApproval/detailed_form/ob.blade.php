 
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
 
        $obAppNo=$details['rows'][0]->obAppNo;
        $obAppDate=$details['rows'][0]->obAppDate;
        $obID=$details['rows'][0]->obID;
        $obName=$details['rows'][0]->obName;
        $obCosCenter=$details['rows'][0]->obCosCenter;
        $department=$details['rows'][0]->department;  
        $obType=$details['rows'][0]->obType;  
        $obReason=$details['rows'][0]->obReason;   

        $obDateFrom=$details['rows'][0]->obDateFrom;
        $obDateTo=$details['rows'][0]->obDateTo;
        $locationName=$details['rows'][0]->locationName;
        $obTime=$details['rows'][0]->obTime;

        if($obType=="In"){
            $obType = "From Time";
        }
        elseif($obType=="Out"){
            $obType = "To Time";
        } 
        
        //echo json_encode($details['rows'][0]);
 ?>
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$obAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$obAppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$obCosCenter?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$obID?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$obName?>"
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
                        <div class="col-12">
                              <label for="appDepartment" class="form-label">OB Type</label>
                              <input type="text" class="form-control" id="appDepartment" value="<?=$obType?>" readonly>
                        </div>
                  </div>
            </div>

            @if($obType == "Days") 
                  <table class="table table-striped">
                        <thead   class="table-dark">
                              <tr>
                                    <th><center>Date <i class="far fa-calendar-alt"></i></center></th>
                                    <th><center>Location <i class="fas fa-map-marker-alt"></i></center></th>
                                    <th><center>From <i class="fas fa-sign-in-alt"></i></center></th>
                                    <th><center>To <i class="fas fa-sign-out-alt"></i></center></th>
                                    <th><center>Total</center></th> 
                              </tr> 
                        </thead>
                        <tbody>
                              @foreach($officialbusinesslist['rows'] as $rows)
                                    <tr>
                                          <td>{{$rows->obLstDate}}</td>
                                          <td>{{$rows->locationName}}</td>
                                          <td>{{$rows->obLstTimeFrom}}</td>
                                          <td>{{$rows->obLstTimeTo}}</td>
                                          <td>{{$rows->obLstTotHours}}</td>
                                    </tr>
                              @endforeach
                        </tbody>
                  </table> 
            @else
                  <div class="col-12">
                        <div class="row">
                              <div class="col-3">
                                    <label for="appEmployeeId" class="form-label">Date From</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$obDateFrom?>" readonly>
                              </div>
                              <div class="col-3">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$obName?>" 
                                          readonly>
                              </div>
                              <div class="col-3">
                                    <label for="appDepartment" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$locationName?>" readonly>
                              </div>
                              <div class="col-3">
                                    <label for="appDepartment" class="form-label">OB Time</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$obTime?>" readonly>
                              </div>
                        </div>
                  </div> 
            @endif


            <div class="col-12">
                  <div class="row">
                        <div class="col-12">
                              <label for="appEmployeeId" class="form-label">Reason</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$obReason?>" readonly>
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

    /*   day_list = <?=json_encode($officialbusinesslist['rows'])?>;
      var obType = "<?=$obType?>";
 */

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