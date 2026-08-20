

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

      $data = $identityid['rows'][0];  

      //echo json_encode($kiosklocked['rows']);

      $empID = $data->identityid; 
      $center = $data->costName;
      $department = $data->departmentName;
      $fullname = $data->lastName." ".$data->firstName." ".$data->middleName;


      $osAppNo="N/A";
      $OffsetDateFrom="";
      $OffsetDateTo="";
     /*  $OffsetDateFrom=date('Y-m-d');
      $OffsetDateTo=date('Y-m-d'); */
      $Reference="";
      $location="";
      $TimeFrom="00:00";
      $TimeTo="00:00";
      $Reason="";
      $osStatus="";
      $r_srcDb="";

      foreach ($app_details['rows'] as $row){
            $osAppNo = $row->osAppNo;
            $r_srcDb = $row->r_srcDb;
            $OffsetDateFrom = $row->osDateFrom;
            $OffsetDateTo = $row->osDateTo;
            $Reference = $row->osReference;
            $location = $row->location;
            $TimeFrom =substr($row->osTimeFrom, 0, 5);
            $TimeTo = substr($row->osTimeTo, 0, 5); 
            $Reason = $row->osReason;
            $osStatus=$row->osStatus;
      }


?>

<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-md-4">
                              <label for="appNumber" class="form-label">Application No.</label>
                              <input type="text" class="form-control" id="appNumber" value="<?=$osAppNo?>" readonly>
                        </div>
                        <div class="col-md-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="2024-11-25" readonly>
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
                              <label id="lbl_offset_from_date" for="offset_from_date" class="form-label">Offset Date From</label>
                              <input type="text" class="form-control" id="offset_from_date" value="<?=$OffsetDateFrom?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () {
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>; 
                                          $('#offset_from_date').datepicker({
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
                              <label id="lbl_offset_to_date" for="offset_to_date" class="form-label">Offset Date To</label>
                              <input type="text" class="form-control" id="offset_to_date" value="<?=$OffsetDateTo?>" autocomplete="off"> 
                              <script>
                                    $(document).ready(function () { 
                                          var disabledArr = <?=json_encode($kiosklocked['rows'])?>; 
                                          $('#offset_to_date').datepicker({
                                                dateFormat: "yy-mm-dd",
                                                beforeShowDay: function (date) {

                                                      minDate = GetMinDate('offset_from_date');
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

                        <div class="col-md-4">
                              <label id="lbl_appLocation" for="appLocation" class="form-label">Location</label>
                              <select id="appLocation" class="form-select">
                                    @foreach($locations['rows'] as $loc)
                                    <option value="{{ $loc->locationCode  }}" <?=($location==$loc->locationCode ? "selected" : "") ?> >{{ $loc->locationName }}</option>
                                    @endforeach
                              </select>
                        </div> 

                  </div> 
            </div> 

            <div class="col-12">
                  <div class="row">

                        <div class="col-md-3">
                              <label id="lbl_osTimeFrom" for="osTimeFrom" class="form-label">To From</label>
                              <div class="input-group">
                                    <select id="osTimeFrom" name="osTimeFrom" class="time form-control" ></select>
                                    <span class="input-group-text">
                                          <i class="bi bi-clock"></i>
                                    </span>
                              </div>
                        </div>

                        <div class="col-md-3">
                              <label id="lbl_osTimeTo" for="osTimeTo" class="form-label">To Time</label>
                              <div class="input-group">
                                    <select id="osTimeTo" name="osTimeTo" class="time form-control"></select>
                                    <span class="input-group-text">
                                          <i class="bi bi-clock"></i>
                                    </span>
                              </div>
                        </div>

                        <div class="col-md-6">
                              <label id="lbl_txtRemarks" for="txtRemarks" class="form-label">Remarks</label>
                              <input type="text" id="txtRemarks" class="form-control" value="<?=$Reason?>" maxlength="200" placeholder="include the date to be offset. Please use YYY-MM-DD format.">
                              <div class="counter">
                              <span id="current">0</span> / 200
                              </div>
                        </div> 
                        <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
                  </div>
            </div>

            <div class="col-12">
                  <div class="row"> 
                        <div class="col-12"> 
                              <label id="lbl_txtRefNo" for="txtRefNo" class="form-label">Reference</label>
                              <div class="input-group" onclick="ShowList('btnSearch')" >
                                    <input type="text" class="form-control" id="txtRefNo" placeholder="Reference DTR" value="<?=$Reference?>"  readonly>
                                    <span class="input-group-text" id="btnSearch">
                                    <i class="bi bi-search"></i>
                                    </span>
                              </div>
                        </div>   
                        <div  class="col-12" id="divList"></div>
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
       
       populateTimeDropdown("osTimeFrom","<?=$TimeFrom?>");
       populateTimeDropdown("osTimeTo","<?=$TimeTo?>");
       
       var CurrentInnerHtml;
      
      function HTMLObjLoading(num,obj_id){ 
           if (num==1){
            this.CurrentInnerHtml = document.getElementById(obj_id).innerHTML; 
            document.getElementById(obj_id).innerHTML = "<i class='fa fa-spinner fa-spin'></i>&nbsp;";
           }else{ 
            document.getElementById(obj_id).innerHTML = CurrentInnerHtml;
           }
      }

       function ShowList(id){ 

            HTMLObjLoading(1,id); 
            var formData = new FormData();   

            var divList = new bootstrap.Modal(document.getElementById('divList'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $('#divList').html('');
            $.ajax({
                  url: '{{url("/offset_ref_list")}}',  
                  type: 'POST', 
                  data: formData,    
                  processData: false,  
                  contentType: false,
                  headers: {
                  'X-CSRF-TOKEN': csrfToken 
                  },             
                  success: function(response) {  
                        $('#divList').html(response);   
                        HTMLObjLoading(0,id); 
                  },
                  error: function(msg) {  
                  //alert(JSON.parse(msg.responseText).error.msg.msg);
                  console.log('Error:'+JSON.stringify(msg));
                  } 
                 
            }); 
       }


      var formData = new FormData(); 
      formData.append('switch',4);
      formData.append('appNo','<?=$osAppNo?>');
      LoadPage('{{url("/wizard")}}','divWizard',formData); 
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
   
      var textarea = document.getElementById('txtRemarks');
      var current = document.getElementById('current');
      var maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', () => {
      current.textContent = textarea.value.length;
      });


      ForApprovalStatus('<?=$osStatus?>');
      loadAttachmentsAssets(1,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
</script>