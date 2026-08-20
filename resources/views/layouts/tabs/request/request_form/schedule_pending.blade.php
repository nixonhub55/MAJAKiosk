 
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
</style>   

<?php
      
      $r_srcDb="";

      foreach ($sched_details['rows'] as $rows) {
            $scAppNo=$rows->scAppNo;
            $r_srcDb=$rows->r_srcDb;
            $scID=$rows->scID;
            $scName=$rows->scName; 
            $scAppDate=$rows->scAppDate;
            $location=$rows->location; 
            $center=$rows->center;
            $department=$rows->department;
            $scStatus=$rows->scStatus;
            

            $scSchedule=$rows->scSchedule;
            $scPreviousSched=$rows->scPreviousSched;
            $scPayrollPeriod=$rows->scPayrollPeriod;
            $scReason=$rows->scReason; 
      }  
?>
<div id="div_validation"></div>
<div class="container custom-container">
      <form class="row g-3">
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appNumber" class="form-label">Application Number</label>
                              <input type="text" class="form-control" id="appNumber"  value="<?=$scAppNo?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appDate" class="form-label">Application Date</label>
                              <input type="text" class="form-control" id="appDate" value="<?=$scAppDate?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appCostCenter" class="form-label">Cost Center</label>
                              <input type="text" class="form-control" id="appCostCenter" value="<?=$center?>" readonly>
                        </div>
                  </div>
            </div>   
            <div class="col-12">
                  <div class="row">
                        <div class="col-4">
                              <label for="appEmployeeId" class="form-label">Employee ID</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$scID?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Employee Name</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$scName?>"
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
                              <label for="appEmployeeId" class="form-label">Payroll Period</label>
                              <input type="text" class="form-control" id="appEmployeeId" value="<?=$scPayrollPeriod?>" readonly>
                        </div>
                        <div class="col-4">
                              <label for="appEmployeeName" class="form-label">Previous Schedule</label>
                              <input type="text" class="form-control" id="appEmployeeName" value="<?=$scPreviousSched?>"
                                    readonly>
                        </div>
                        <div class="col-4">
                              <label id="lbl_ddlSchedule" for="ddlSchedule" class="form-label">Requested Schedule</label> 
                                    <select class="form-select" id="ddlSchedule">
                                          <option value="0">Select Schedule name</option>
                                          @foreach($schedules['rows'] as $rows)
                                          <option value="{{$rows->scheduleCode}}" <?=($scSchedule==$rows->scheduleCode ? "selected" : "") ?>  >{{$rows->scheduleName}}</option>
                                          @endforeach
                                    </select>
                        </div>
                  </div>
            </div>


              

            <div class="col-md-12">
                  <label id="lbl_txtRemarks" for="txtReason" class="form-label">Remarks</label> 
                  <textarea id="txtReason" class="form-control"><?=$scReason?></textarea> 
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
 
      var formData = new FormData(); 
      formData.append('switch',6);
      formData.append('appNo','<?=$scAppNo?>');
      formData.append('r_opt',JSON.stringify({"srcDB":'<?= $r_srcDb ?>'}));  
      LoadPage('{{url("/wizard")}}','divWizard',formData); 
   
      
      ForApprovalStatus('<?=$scStatus?>');
      loadAttachmentsAssets(1,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');
 
</script>