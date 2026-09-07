 
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

      .inv{
            display:none
      }

      .rmvBtn{
            position: absolute;
            top:-10px;
            right:-10px;
            font-size:20px;
            color:#fff;
            cursor:pointer;
            background-color: #e18956;
            width:32px; 
            border-radius:50%;
            border-top:1px solid black;
            border-right:1px solid black
      } 

      .reltv{
            position: relative; 
      }
</style>


<?php
      $data = $user_details['rows'][0];  

      $obAppNo = "N/A";
      $obType = "";
      $obAppDate = date('Y-m-d');
      $obDateFrom = "";
      $obDateTo = "";
      $obReason = "";
      $time = "00:00";
      

      $empID = $data->identityid; 
      $center = $data->costName;
      $department = $data->departmentName;
      $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;
      $location = $data->location; 
      $obStatus="";
      $obLocation="";
      $r_srcDb="";
      $obTime = "";

      if ($id>0){
            $obAppNo = $selected_row['rows'][0]->obAppNo;
            $r_srcDb = $selected_row['rows'][0]->r_srcDb;
            $obType = $selected_row['rows'][0]->obType; 
            $obAppDate = $selected_row['rows'][0]->obAppDate; 
            $obDateFrom = $selected_row['rows'][0]->obDateFrom; 
            $obDateTo = $selected_row['rows'][0]->obDateTo; 
            $obReason = $selected_row['rows'][0]->obReason; 
            $obStatus = $selected_row['rows'][0]->obStatus; 
            $obLocation = $selected_row['rows'][0]->obLocation; 
            $obTime = $selected_row['rows'][0]->obTime ?? ''; 
      } 

      $ddlOBLoc = ""; 
      $locationCodes = array_column($locations['rows'], 'locationCode');
 

      if (in_array($obLocation, $locationCodes)) {
            $ddlOBLoc = $obLocation;
      }elseif(!empty($obLocation)){
            $ddlOBLoc = "Others";
      } 
      
      //echo json_encode($selected_row['rows'][0]);
 
?>
<div id="div_validation"></div>

<div class="container custom-container">
      
      <form class="row g-3">

            <div class="col-12">
                  <div class="row">

                        <div class="col-md-4">
                        <label for="appNumber" class="form-label">Application No.</label>
                        <input type="text" class="form-control" id="appNumber" value="<?=$obAppNo?>" readonly>
                        </div>

                        <div class="col-md-4">
                        <label for="appDate" class="form-label">Application Date</label>
                        <input type="text" class="form-control" id="appDate" value="<?=$obAppDate?>" readonly>
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
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$fullname?>"
                              readonly>
                        </div>

                        <div class="col-md-4">
                        <label for="appCostCenter" class="form-label">Cost Center</label>
                        <input type="text" class="form-control" id="appCostCenter" value="<?=$center?>" readonly>
                        </div> 

                        <div class="col-md-4">
                        <label for="appDepartment" class="form-label">Department</label>
                        <input type="text" class="form-control" id="appDepartment" value="<?=$department?>" readonly>
                        </div> 
                  </div> 
            </div>

 
            <div class="col-12">
                  <label id="lbl_ob_ddl" for="ob_ddl" class="form-label">OB Type</label>
                  <select class="form-select" id="ob_ddl" onchange="SelectType(this.value)"> 
                        @foreach($in_out['rows'] as $types)
                        <option  value="{{ $types->val  }}" <?=($obType==$types->val ? "selected" : "") ?>>{{ $types->txt }}</option>
                        @endforeach  
                  </select>
            </div>   
 
 
            <div class="col-12 inv" id="divDays"><!-- Day Details -->
                  <div class="row">

                        <div class="col-6"><!-- App. Date From -->
                              <label id="lbl_ob_from_date" for="ob_from_date" class="form-label">App. Date From</label>
                              <input type="text" class="form-control" id="ob_from_date" onchange="return PickDate()" value="<?=$obDateFrom?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () {
                                          var disabledArr=<?=json_encode($kiosklocked['rows'])?>; 
                                          $('#ob_from_date').datepicker({
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

                        <div class="col-6"><!-- App. Date To -->
                              <label id="lbl_ob_to_date" for="ob_to_date" class="form-label">App. Date To</label>
                              <input type="text" class="form-control" id="ob_to_date"  onchange="return PickDate()"   value="<?=$obDateTo?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () {
                                          var disabledArr=<?=json_encode($kiosklocked['rows'])?>; 
                                          $('#ob_to_date').datepicker({
                                          dateFormat: "yy-mm-dd",
                                          beforeShowDay: function (date) {

                                                minDate = GetMinDate('ob_from_date');
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
                  <br>
                  <div class="row"> <!-- Days Details -->
                        <div class="col-12" id="divDaysDetails">  
                              
                              <div class="row reltv">  
                                    <div class="col-12"> 
                                          <table id="tbl1" class="table table-striped"> 
                                                <thead  class="table-dark">
                                                      <tr>  
                                                            <th>#</th>
                                                            <th><center>Date <i class="far fa-calendar-alt"></i></center></th>
                                                            <th><center>Location <i class="fas fa-map-marker-alt"></i></center></th>
                                                            <th><center>From <i class="fas fa-sign-in-alt"></i></center></th>
                                                            <th><center>To <i class="fas fa-sign-out-alt"></i></center></th>
                                                            <th><center>Total</center></th>
                                                            <th><center>Action</center></th>
                                                      </tr> 
                                                </thead>
                                                <tbody id="tb1_tbody"> 
                                                </tbody>
                                          </table>
                                    </div> 
                              </div>

                        </div>
                  </div> 
            </div> 
            
            <div class="col-12 <?=(in_array($obType, ["In", "Out"]) ? "" : "inv")?>" id="divTime"> <!-- Time Details --> 
                  <div class="row"> 
                              
                        <div class="col-md-4"><!-- Date -->
                              <label id="lbl_txtDate" for="txtDate" class="form-label">Date</label>
                              <input type="text" class="form-control" id="txtDate" value="<?=$obDateFrom?>" autocomplete="off"> 
                              <script>
                              $(document).ready(function () {
                              var disabledArr = [
                              { from: "25/11/2024", to: "30/11/2024" }, // Example Only! of disabled date ranges
                              { from: "05/12/2024", to: "10/12/2024" },
                              ];

                              $('#txtDate').datepicker({
                              dateFormat: "yy-mm-dd",
                              beforeShowDay: function (date) {
                              for (var i = 0; i < disabledArr.length; i++) {

                              var From = disabledArr[i].from.split("/");
                              var To = disabledArr[i].to.split("/");
                              var FromDate = new Date(From[2], From[1] - 1, From[0]);
                              var ToDate = new Date(To[2], To[1] - 1, To[0]);


                              if (date >= FromDate && date <= ToDate) {
                              return [false, "red"];
                              }
                              }
                              return [true, ""];
                              },
                              });
                              });
                              </script>
                        </div> 

                        <div class="col-md-4"><!-- Location --> 
                              <label id="lbl_txtlocation" for="txtlocation" class="form-label">Location</label> 
                               <select id="txtlocation" class="form-select" onchange="return setLocation(this.id)">
                                    @foreach($locations['rows'] as $rows)
                                    <option value="{{$rows->locationCode}}" <?=($ddlOBLoc==$rows->locationCode ? "selected" : "") ?> >{{$rows->locationName}}</option>
                                    @endforeach
                               </select>
                               <input type="text" id="hiddentxtlocation" class="form-control <?=($ddlOBLoc=="Others" ? "" : "hide_tr") ?>" value="<?=$obLocation?>" placeholder="Specify others">
                        </div> 

                        <div class="col-md-4"><!-- Time -->
                              <label id="lbl_txtTime" for="txtTime" class="form-label">Time</label>
                              <div class="input-group">
                                    <select id="txtTime" class="time form-control"></select>
                                    <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                    </span>
                              </div>
                        </div> 

                  </div>  
            </div>   
             
            <div class="col-12">
                  <div class="row">   
                        <div class="col-12">
                        <label id="lbl_txtReason" for="txtReason" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="txtReason"  value="<?=$obReason?>" maxlength="200">
                        <div class="counter">
                        <span id="current">0</span> / 200
                        </div>
                        </div> 
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
   
      populateTimeDropdown('txtTime',"<?=$obTime?>");
 
      day_list = <?=json_encode($officialbusinesslist['rows'])?>;
      var obType = "<?=$obType?>";
      
      async function get_officialbusiness_days() {
            var ob_ddl = document.getElementById('ob_ddl').value; 
            if (obType === "Days" || ob_ddl=== "Days") {  
                  //console.log(day_list);
                  var divDays = document.getElementById('divDays');
                  var tb1_tbody = document.getElementById('tb1_tbody'); 

                  var formData = new FormData(); 

                  var num = 1;
                  for (let obj of day_list) { 
                        var time_id1 = "time_id1"+num;
                        var time_id2 = "time_id2"+num;
                        var NewDate = new Date(obj.obLstDate);
                        var Day =  NewDate.toLocaleString('en-us', { weekday: 'long' }); 
 
                        formData.append('obLstAppNo', obj.obLstAppNo);    
                        formData.append('obLstDate', obj.obLstDate);  
                        formData.append('Day',Day);    
                        formData.append('obLstTimeFrom', obj.obLstTimeFrom);    
                        formData.append('obLstTimeTo', obj.obLstTimeTo); 
                        formData.append('obLstTotHours', obj.obLstTotHours);    
                        formData.append('obLocation', obj.obLocation);    
                        formData.append('location', obj.location);    
                        formData.append('locationName', obj.locationName);
                        formData.append('time_id1', time_id1);
                        formData.append('time_id2', time_id2);
                        formData.append('trID',  obj.obLstID);

                        try { 
                        const response = await call_page_into_div(formData, '{{url("/ob_days_location")}}'); 
                        tb1_tbody.insertAdjacentHTML('beforeend', response);
                        } catch (error) {
                        console.error("Error during the request:", error);
                        }

                        num+=1;
                        populateTimeDropdown(time_id1,obj.obLstTimeFrom);
                        populateTimeDropdown(time_id2,obj.obLstTimeTo);
                  }
            
                  divDays.style.display = "block";
            }
      }  
 
      function PickDate() {  
            var df = document.getElementById('ob_from_date').value;
            var dt = document.getElementById('ob_to_date').value;

            let startDate = new Date(df);
            let endDate = new Date(dt); 
 
            const dfExists = day_list.some(item => item.obLstDate === startDate.toLocaleDateString('en-CA'));
            const dtExists = day_list.some(item => item.obLstDate === endDate.toLocaleDateString('en-CA'));
            
            if(!dfExists && !dtExists){
                  day_list=[];
            }
            
            /* 
                  if (day_list.length !== 0) {  
                        if (confirm('All existing schedules will be deleted, are you sure?')) {
                              this.obDateFrom = df;
                              this.obDateTo = dt;
                              LoopConfirmation(startDate, endDate, df, dt);
                        }
                        else {  
                              document.getElementById('ob_from_date').value = obDateFrom;
                              document.getElementById('ob_to_date').value = obDateTo;
                        }
                  } else {
                        LoopConfirmation(startDate, endDate, df, dt);
                  } 
            */

           LoopConfirmation(startDate, endDate, df, dt);

      }


      function LoopConfirmation(startDate, endDate, df, dt) {
            if (startDate <= endDate) {
                  //day_list = [];
                  var tb1_tbody = document.getElementById('tb1_tbody');
                  tb1_tbody.innerHTML = '';
            } 
            var num = 1;
            while (startDate <= endDate) {
                  var id = document.getElementById('appEmployeeId').value;
                  var obLstDate = startDate.toLocaleDateString('en-CA');
                  var Day = startDate.toLocaleString('en-us', { weekday: 'long' });
                  const exists = day_list.some(item => item.obLstDate === obLstDate);
                  if(!exists){
                        day_list.push(
                              {
                                    "id": id,
                                    "obLstAppNo": 0,
                                    "obLstDate": obLstDate,
                                    "obLstTimeFrom": "00:00",
                                    "obLstTimeTo": "00:00",
                                    "obLstTotHours": "00:00",
                                    "obLstID": num,
                                    "obLocation": "",
                                    "location": "",
                                    "locationName": ""
                              });
                  }
                  startDate.setDate(startDate.getDate() + 1);
                  num += 1;
            }

            //Re-ordeer num by date
            this.day_list.sort((a, b) => new Date(a.obLstDate) - new Date(b.obLstDate)); 
            day_list.forEach((a, index) => { a.obLstID = index + 1; }); 

            if (df <= dt) {
                  get_officialbusiness_days();

            }

      
      }

      function SelectLocation(thisID,txtId,num){
            var selectedLoc = document.getElementById(thisID).value;
            var txt_id = document.getElementById(txtId); 
            txt_id.style.display = (selectedLoc=="Others" ? "block" : "none");
            
            UpdateArray('obLocation',num,selectedLoc)
      }

      function setLocation(thisID){
           var loc1 = document.getElementById(thisID);
           var loc2 = document.getElementById('hidden'+thisID);  
           var loc2ClassName = loc2.className;
 
            
           if (loc1.value == "Others" && loc2ClassName.includes("hide_tr")){

                  loc2.classList.remove('hide_tr');
                  loc2.classList.add('show_tr');
                 

           } else{

                  loc2.classList.remove('show_tr');
                  loc2.classList.add('hide_tr');
           } 

      }

      get_officialbusiness_days();  

      var formData = new FormData(); 
      formData.append('switch',3);
      formData.append('appNo','<?=$obAppNo?>');
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
      LoadPage('{{url("/wizard")}}','divWizard',formData); 

 

      var textarea = document.getElementById('txtReason');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });

      ForApprovalStatus('<?=$obStatus?>');

      loadAttachmentsAssets(1,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');

</script>