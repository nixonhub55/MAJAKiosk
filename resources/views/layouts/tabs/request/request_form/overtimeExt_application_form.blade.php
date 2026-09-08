 
 
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
            /* padding: 20px; */
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
      
      .attachmentCont{
            border: 1px dotted #b5b4c0;
            display: inline-flex;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
             gap: 8px;
      }

      .remove-attachment {
            cursor: pointer;
            color: #666;
            font-size: 18px;
            font-weight: bold;
      }

      .remove-attachment:hover {
            color: #e00;
      }
 
</style>   


<?php
        
      $data = $user_details['rows'][0];  
      $empID = $data->identityid; 
      $center = $data->costName;
      $department = $data->departmentName;
      $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;

      $otAppNo="N/A";     
      $otType="";     
      $otAppDate=date('Y-m-d');
      $location="";
      $otDate="";
      $otFrDate="";
      $otToDate="";
      $otTimeFrom="";
      $otTimeTo="";
      $otRemarks="";
      $otBreak="00:00";
      $otTotHours="00:00";
      $otStatus=""; 
      $otExtAllowance=0; 
      $otExtAllowDetails = "{}";
      $r_srcDb="";
      $reason="";


      foreach ($overtime['rows'] as $rows) {
            $otAppNo=$rows->otAppNo;
            $r_srcDb=$rows->r_srcDb;
            $otType=$rows->otType;
            $otAppDate=$rows->otAppDate;
            $location=$rows->location;
            $otDate=$rows->otDate;
            $otFrDate=$rows->otFrDate;
            $otToDate=$rows->otToDate;
            $otTimeFrom=$rows->otTimeFrom;
            $otTimeTo=$rows->otTimeTo;
            $otBreak=$rows->otBreak;
            $otTotHours=$rows->otTotHours;
            $otRemarks=$rows->otReason;
            $otStatus=$rows->otStatus;
            $otExtAllowance=$rows->otExtAllowance;
            $otExtAllowDetails=json_decode($rows->otExtAllowDetails,true) ?? "{}";
      }  
      //regSched, actTimeIn, actTimeOut, totalAllowance, attachmentFileName, attachmentContent
      //echo json_encode($otExtAllowDetails);
      //echo json_encode($otExtAllowDetails['regSched']); 
?>

<script>

      var regSched = '<?= $otExtAllowDetails['regSched'] ?? '' ?>';
      var dtrIn = '<?= $otExtAllowDetails['actTimeIn'] ?? '' ?>';
      var dtrOut = '<?= $otExtAllowDetails['actTimeOut'] ?? '' ?>';
      var totalTime= '<?= $otExtAllowDetails['otTotal'] ?? '' ?>';
      var otTotal = '<?= $otExtAllowDetails['totalAllowance'] ?? '' ?>'; 
      var allHrs = '<?= $otExtAllowDetails['totalTime'] ?? '' ?>';
      var attachmentFileName = '<?= $otExtAllowDetails['attachmentFileName'] ?? '' ?>';
      var attachmentContent = '<?= $otExtAllowDetails['attachmentContent'] ?? '' ?>';
      var attachmentFilType = '<?= $otExtAllowDetails['attachmentFilType'] ?? '' ?>';
      
</script>

<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12"> 
                  <div class="row"> 
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$otAppNo?>" readonly>
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

                        
                        <div class="col-md-4">
                              <label id="lbl_appLocation" for="appLocation" class="form-label">Location</label>
                              <select id="appLocation" class="form-select"> 
                               @foreach($locations['rows'] as $loc)
                               <option value="{{ $loc->locationCode  }}" <?=($location==$loc->locationCode ? "selected" : "") ?> >{{ $loc->locationName }}</option>
                               @endforeach
                              </select>
                        </div>

                        <div class="col-md-4">
                              <label id="lbl_from_date" for="ot_from_date" class="form-label">From Date</label>
                              <input type="text" class="form-control" id="ot_from_date" value="<?=$otFrDate?>" onchange="getRegularSched()" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () {
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>; 
                                          $('#ot_from_date').datepicker({
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
                              <label id="lbl_to_date" for="ot_to_date" class="form-label">To Date</label>
                              <input type="text" class="form-control" id="ot_to_date" value="<?=$otToDate?>"  onchange="getRegularSched()" autocomplete="off"> 
                              <script>
                              $(document).ready(function (){
                              var disabledArr = <?=json_encode($kiosklocked['rows'])?>;  
                              $('#ot_to_date').datepicker({
                                    dateFormat: "yy-mm-dd",
                                    beforeShowDay: function (date) {
                                     
                                   
                                    minDate = GetMinDate('ot_from_date');
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
                                    return [false, "red"];
                                   
                                    
                                    },
                              });
                              });
                              </script>

                        </div>  
                  </div>
            </div>

  
            <div class="col-12" id="divExtensionAllowanceDetails"></div>
            <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>


            <div class="col-12">
                  <label id="lbl_txtRemarks" for="txtRemarks" class="form-label">Reason</label>
                  <input type="text" id="txtRemarks" class="form-control" value="<?=$reason?>" maxlength="200">
                  <div class="counter">
                  <span id="current">0</span> / 200
                  </div>
            </div>  
 
             

            <div class="col-md-12" id="divWizard"></div>

            <div class="col-12"> 
                  <div>
                        <input class="form-check-input" type="checkbox" id="verification_checkbox">
                        <label id="verification_checkbox_lbl" class="form-check-label" for="verification_checkbox">
                              I verify that all the information above is correct.
                        </label>
                  </div>  
            </div>
      </form>
</div>
<script>
  

       
      var totalAllowance = 0;

      function time_converter(num){
            var time = document.getElementById('tot_break').value;
            let hours = time;
            let formattedTime = String(hours).padStart(2, '0') + ":00";
            document.getElementById('tot_break').value = formattedTime;
            return formattedTime;
      }
 

      function time_validator() {

            //const date_from = document.getElementById('otWorkDate').value;
           // const date_to = document.getElementById('otWorkDate').value;
            const date_from = document.getElementById('ot_from_date').value; 
            const date_to = document.getElementById('ot_to_date').value;

            const time_in = document.getElementById('otTimeFrom').value;
            const time_out = document.getElementById('otTimeTo').value;

            let break_time = document.getElementById('tot_break').value;

            break_time = formatToTime(break_time);
            document.getElementById('tot_break').value = break_time;


            const start = new Date(`${date_from}T${time_in}:00`);
            const end = new Date(`${date_to}T${time_out}:00`);
 
            let totalMinutes = (end - start) / (1000 * 60);

            let breakMinutes = timeToMinutes(break_time);

            if (isNaN(breakMinutes)) {
                  breakMinutes = 0;
            }


            let netMinutes = totalMinutes - breakMinutes; 
            let totalTime = minutesToTime(netMinutes); 
            if (!totalTime || totalTime.includes("NaN") || netMinutes <= 0) {
                  totalTime = "00:00";
            } 
            document.getElementById('appTotalTime').value = totalTime; 
            getEstimatedAllowance(totalTime);
      }

      async function  getEstimatedAllowance(val) {
 
            var username = '<?= session()->get('username') ?>';
            var details = {
                  "username" : username,
                  "totalTime" : val,
            } 
            var formData = new FormData();
            formData.append('mode', 2);   
            formData.append('details', JSON.stringify(details));   

            const response = await exec_XMLHttpRequest(formData,'{{url("/overtimeExtMapping")}}');  

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec); 

            if (response.num!==0){
               document.getElementById('txtTotalAllowance').value = 0; 
               this.totalAllowance = 0;
            }else{
               const rslt = response.rows[0];
               const total = rslt.total;
               this.totalAllowance = total;
               document.getElementById('txtTotalAllowance').value = '₱'+total;

            }
      }

      async function  getRegularSched() { 

            var details = {
                  "appNo" : 0,
                  "username" : '<?= session()->get('identityId') ?>',
                  "df" : document.getElementById('ot_from_date').value,
                  "dt" : document.getElementById('ot_to_date').value,
            }  
            var container = document.getElementById('divExtensionAllowanceDetails');
            var formData = new FormData();   
            formData.append('mode',0);    
            formData.append('details',JSON.stringify(details));       
            GlovalHTMLObjLoading(1,'divExtensionAllowanceDetails');
            var response = await call_page_into_div(formData,'{{url("/overtimeExtMapping")}}',container);  
      }
 
 
      function fillReqSechedDetails(regSched,dtrIn,dtrOut,totalTime,otTotal,allHrs){ 
            document.getElementById('regSched').value = regSched;
            document.getElementById('actTimeIn').value = dtrIn;
            document.getElementById('actTimeOut').value = dtrOut;
            document.getElementById('appTotalTime').value = totalTime;
            document.getElementById('txtTotalAllowance').value = otTotal;
            document.getElementById('appAllHrs').value = allHrs;
            
      }


      function formatToTime(input) {
            const timeRegex = /^([01]?\d|2[0-3]):([0-5]\d)$/;

            // Valid HH:MM format, return as-is
            if (typeof input === 'string' && timeRegex.test(input)) {
                  return input;
            }

            // Convert numeric input to time
            let num = parseInt(input, 10);
            if (!isNaN(num)) {
                  let numStr = String(num);

                  let hours = 0;
                  let minutes = 0;

                  if (numStr.length <= 2) {
                        // Treat as hours only
                        hours = parseInt(numStr, 10);
                        minutes = 0;
                  } else {
                        // Last 2 digits = minutes, the rest = hours
                        minutes = parseInt(numStr.slice(-2), 10);
                        hours = parseInt(numStr.slice(0, -2), 10);
                  }

                  if (hours > 23 || minutes > 59) return "00:00";

                  return (
                        String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0')
                  );
            }

            return "00:00";
      }
 

      function timeToMinutes(timeStr) {
            const [hours, minutes] = timeStr.split(':').map(Number);
            return hours * 60 + minutes;
      }

      function minutesToTime(minutes) {
            const hrs = Math.floor(minutes / 60).toString().padStart(2, '0');
            const mins = (minutes % 60).toString().padStart(2, '0');
            return `${hrs}:${mins}`;
      }
       
   
      var formData = new FormData(); 
      formData.append('switch',1000);
      formData.append('appNo','<?=$otAppNo?>'); 
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
      LoadPage('{{url("/wizard")}}','divWizard',formData); 
   
      
      ForApprovalStatus('<?=$otStatus?>');


      var textarea = document.getElementById('txtRemarks');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
            current.textContent = textarea.value.length;
      });

      getRegularSched();

      loadAttachmentsAssets(1,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');

</script>