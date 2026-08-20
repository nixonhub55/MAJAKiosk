 
 
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
 

<style>
        .dz-message{
                  text-align: center;
                  font-size: 20px;
            }
            .dropzone .dz-init {
                  background: transparent !important;
                  border: none !important;
            }  
            .dz-details {
                  z-index: 0;
            }
            .dz-preview .dz-remove.dz-remove {
                  z-index: 100;
            }
            button.mbtn {
                  padding:0.6em 2em;
                  border-radius: 25px;
                  color:#fff;
                  background-color:#1976d2;
                  font-size:1.1em;
                  border:0;
                  cursor:pointer;
                  margin:1em;
            }

            button.mbtn.black{
                  background-color:#000000;
            }        
            
            .form-text{
                  margin-left: 30px;
            }

            .form-text{
                  display: block; 
                  margin-left: 30px;
                  margin-right: 30px;    
                  font-style: italic;
                  font-size: 90%;
            }

            .uploadedFile{
                  display: inline-block;
                  font-family: Arial, sans-serif;
                  font-size: 14px;
                  color: #333;
                  background-color: #e9e9e9;
                  padding: 10px;
                  margin: 20px;
                  border: 1px solid #ddd;
                  border-radius: 20px;
                  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                  text-align: center;
            }
            .uploadedFile p{
                  display: inline-block;
                  background-color: #efefef;
            }            
</style>   

<?php 
      $data = $user_details['rows'][0];  
      $empID = $data->identityid; 
      $center = $data->costName;
      $department = $data->departmentName;
      $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;

      $opAppNo="N/A";     
      $laType=""; 
      $laBalance=""; 
      $location="";
      $laDateFrom="";
      $laDateTo=""; 
      $otAppDate=date('Y-m-d');
      $laReason= "";
      $laStatus= "";
      $r_srcDb="";
      $sched_list = $sched_list['rows'];

      foreach ( $item_detail['rows'] as $rows ) {
            $opAppNo=$rows->laAppNo;
            $r_srcDb=$rows->r_srcDb;
            $laType = $rows->laType;
            $laBalance = $rows->laBalance;
            $otAppDate = $rows->laAppDate;
            $location = $rows->location;
            $laDateFrom = $rows->laDateFrom;
            $laDateTo = $rows->laDateTo;
            $laReason= $rows->laReason; 
            $laStatus= $rows->laStatus; 
       }  

      //echo json_encode($holidays);
      //echo "<script>alert('".$laReason."')</script>";
      
?> 
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$opAppNo?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$otAppDate?>" readonly>
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
                        <div class="col-8">
                              <label id="lblappOvertimeType" for="appOvertimeType" class="form-label">Leave Type</label>
                              <select id="appOvertimeType" class="form-select" onchange="get_leave_balance(this.value)">  
                                    @foreach($leave_type['rows'] as $types)
                                    <option  value="{{ $types->leaveCode  }}" <?=($laType==$types->leaveCode ? "selected" : "") ?>>{{ $types->leaveName }}</option>
                                    @endforeach
                              </select>
                        </div>  
                        <div class="col-md-4">
                              <label id="lbl_leave_bal" for="txtLaBalance" class="form-label">Leave Balance</label>
                              <input type="text" class="form-control" id="txtLaBalance" value="<?=$laBalance?>" readonly> 
                        </div>
                        
                  </div>
            </div>



            <div class="col-12">
                  <div class="row">

                        <div class="col-md-4">
                              <label id="lblLocation" for="appLocation" class="form-label">Location</label>
                              <select id="appLocation" class="form-select"> 
                               @foreach($locations['rows'] as $loc)
                               <option value="{{ $loc->locationCode  }}" <?=($location==$loc->locationCode ? "selected" : "") ?> >{{ $loc->locationName }}</option>
                               @endforeach
                              </select>
                        </div>

                        <div class="col-md-4">
                              <label id="lbl_laFromdate" for="la_from_date" class="form-label">From Date</label>
                              <input type="text" class="form-control" id="la_from_date"  onchange="SelectDateRange2()" value="<?=$laDateFrom?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () {
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>;  
                                          $('#la_from_date').datepicker({
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
                                                      return [false, ""];
                                                },
                                          });
                                    });
                              </script>
                        </div>

                        <div class="col-md-4">
                              <label id="lbl_latodate" for="la_to_date" class="form-label">To Date</label>
                              <input type="text" class="form-control" id="la_to_date" onchange="SelectDateRange2()" value="<?=$laDateTo?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function (){
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>;  
                                          $('#la_to_date').datepicker({
                                                dateFormat: "yy-mm-dd",
                                                beforeShowDay: function (date) {

                                                      minDate = GetMinDate('la_from_date');
                                                      if (date < minDate) {  return [false, "red"]; } 

                                                      for (var i = 0; i < disabledArr.length; i++) {

                                                            var From = disabledArr[i].from.split("/");
                                                            var To = disabledArr[i].to.split("/");
                                                            var FromDate = new Date(From[2], From[1] - 1, From[0]);
                                                            var ToDate = new Date(To[2], To[1] - 1, To[0]);


                                                            if (date >= FromDate && date <= ToDate) {
                                                                  return [true, ""];
                                                            }
                                                      }
                                                      return [false, ""];
                                                },
                                          });
                                    });
                              </script>
                        </div> 
                  </div>
            </div>
            <div class="col-12">
                 <div id="divSchedDetails"></div>
            </div>

            <div class="col-12">
                  <label id="lblReason" for="la_reason" class="form-label">Leave Reason</label>
                  <textarea class="form-control" id="la_reason" rows="3" maxlength="200"><?=$laReason?></textarea>
                  <div class="counter">
                        <span id="current">0</span> / 200
                  </div>
            </div>
            
            <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>

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

      SelectDateRange(<?=json_encode($sched_list)?>);
 

      function time_validator(){
            var break_tot = document.getElementById('tot_break').value;
            var time_from = document.getElementById('otTimeFrom').value;
            var time_to = document.getElementById('otTimeTo').value; 

            var startMinutes = timeToMinutes(time_from);
            var endMinutes = timeToMinutes(time_to);
            var breakMinutes = timeToMinutes(break_tot);

            var totalMinutes = (endMinutes - startMinutes) - breakMinutes; 
            var time_tot = minutesToTime(totalMinutes); 
            document.getElementById('appTotalTime').value = time_tot; 

      } 

      function timeToMinutes(time) {
            var parts = time.split(":");
            return parseInt(parts[0]) * 60 + parseInt(parts[1]);
      }
 
      function minutesToTime(minutes) {
            var hours = Math.floor(minutes / 60);
            var mins = minutes % 60;
            return (hours < 10 ? '0' : '') + hours + ":" + (mins < 10 ? '0' : '') + mins;
      } 


      function SelectDateRange2(){
            document.getElementById('divSchedDetails').innerHTML = ""; 
            schedules = [];   
            var df = document.getElementById('la_from_date').value;
            var dt = document.getElementById('la_to_date').value; 
            let startDate = new Date(df); // Starting date
            let endDate = new Date(dt);   // Ending date  
            const holidays = <?= json_encode($holidays['rows']) ?>;
            console.log(holidays);
            //2025-08-12
            var num = 1;
            while (startDate <= endDate) { 
                  const formatted = startDate.toISOString().split("T")[0];
                  
                  const exists = holidays.some(item => item.holidayDate === formatted); 

                  generate_this_row(startDate.toLocaleDateString('en-CA'),num,'1.00',exists); 
                  startDate.setDate(startDate.getDate() + 1);
                  num+=1; 
            }
      }

      var formData = new FormData(); 
      formData.append('switch',1);
      formData.append('appNo','<?=$opAppNo?>');
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
      LoadPage('{{url("/wizard")}}','divWizard',formData); 
   
      
      ForApprovalStatus('<?=$laStatus?>');
     
      var textarea = document.getElementById('la_reason');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });

      loadAttachmentsAssets(1,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
      
</script>