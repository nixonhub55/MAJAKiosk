 
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

      $this_id = "N/A";
      $taAppDate = date('Y-m-d');
      
      $data = $user_details['rows'][0];  
      $empID = $data->identityid; 
      $center = $data->costName;
      $department = $data->departmentName;
      $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;

      $taDate = ""; 
      $InOut="";
      $location=""; 
      $time="00:00"; 
      $reason=""; 
      $taStatus = "";
      $r_srcDb="";


      if ($id>0){
            $InOut = $selected_row['rows'][0]->taType;
            $r_srcDb = $selected_row['rows'][0]->r_srcDb;
            $location = $selected_row['rows'][0]->location;
            $this_id=$id; 
            $taAppDate= $selected_row['rows'][0]->taAppDate;
            $taDate=$selected_row['rows'][0]->taDate;
            $time=$selected_row['rows'][0]->taTime;
            $reason=$selected_row['rows'][0]->taReason;
            $taStatus= $selected_row['rows'][0]->taStatus;
      } 
?>
<div id="div_validation"></div>
<div class="container custom-container mt-5">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application No.</label>
                              <input type="text" class="form-control" id="appNumber" value="<?=$this_id?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$taAppDate?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$empID?>" readonly>
                        </div>
                  </div>
            </div>
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$center?>" readonly>
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
                              <label id="lbl_ta_date" for="ta_date" class="form-label">Adjustment Date</label>
                              <input type="text" class="form-control" id="ta_date" value="<?=$taDate?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function (){
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>;  
                                          $('#ta_date').datepicker({
                                                dateFormat: "yy-mm-dd",
                                                beforeShowDay: function (date) {
                                                      for (var i = 0; i < disabledArr.length; i++) {

                                                            var From = disabledArr[i].from.split("/");
                                                            var To = disabledArr[i].to.split("/");
                                                            var FromDate = new Date(From[2], From[1] - 1, From[0]);
                                                            var ToDate = new Date(To[2], To[1] - 1, To[0]);


                                                            if (date >= FromDate && date <= ToDate) {
                                                                  return [true, ""];
                                                            }
                                                      }
                                                      return [false, "red"];
                                                },
                                          });
                                    });
                              </script>
                        </div>
                        <div class="col-md-4">
                              <label id="lbl_ddl_type" for="ddl_type" class="form-label">Adjustment Type</label>
                              <select id="ddl_type" class="form-select">
                                    @foreach($in_out['rows'] as $types)
                                    <option  value="{{ $types->val  }}" <?=($InOut==$types->val ? "selected" : "") ?>>{{ $types->val }}</option>
                                    @endforeach 
                              </select>
                        </div> 
                        <div class="col-md-4">
                              <label id="lbl_appLocation" for="appLocation" class="form-label">Location</label>
                              <select id="appLocation" class="form-select">
                                    @foreach($locations['rows'] as $loc)
                                    <option value="{{ $loc->locationCode  }}" <?=($location==$loc->locationCode ? "selected" : "") ?> >{{ $loc->locationName }}</option>
                                    @endforeach
                              </select>
                        </div>  
                  </div>
                  <div class="col-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label id="lbl_txtTime" for="txtTime" class="form-label">Time</label>
                                    <div class="input-group">
                                          <select id="txtTime" name="txtTime" class="time form-control"></select>
                                          <span class="input-group-text">
                                                <i class="bi bi-clock"></i>
                                          </span>
                                    </div>
                              </div> 
                              <div class="col-8">
                                    <label id="lbl_txtReason" for="txtReason" class="form-label">Reason</label>
                                    <input type="text" id="txtReason" class="form-control" value="<?=$reason?>" max="200">
                                    <div class="counter">
                                    <span id="current">0</span> / 200
                                    </div>
                              </div> 
                        </div>
                  </div>
            </div> 

            <div class="col-md-12" id="divWizard"></div>


            <div class="col-12">
                  <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="verification_checkbox">
                        <label id="verification_checkbox_lbl" class="form-check-label" for="verification_checkbox">
                              I verify that all the information above is correct.
                        </label>
                  </div>
            </div>
      </form>
</div> 
<script>  
      populateTimeDropdown("txtTime","<?=$time?>");


      var formData = new FormData(); 
      formData.append('switch',2);
      formData.append('appNo','<?=$this_id?>');
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
      LoadPage('{{url("/wizard")}}','divWizard',formData); 
 

      ForApprovalStatus('<?=$taStatus?>');


      var textarea = document.getElementById('txtReason');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });
</script>