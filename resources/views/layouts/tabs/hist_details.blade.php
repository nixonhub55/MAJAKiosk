 
<div class="container custom-container">
      <?php

      use PhpParser\Node\Stmt\Echo_;

            $appNo = 0;
            $appStatus = 0;
            $hostName = env('DB_OWNER');
      ?>
      
      @if($num==0 || $num==1000) <!-- OVERTIME -->

            <?php 
                  $app_detail = $app_details['rows'][0]; 
                  $appNo = $app_detail->otAppNo;
                  $appStatus = $app_detail->r_decision;
                  $otExtAllowance = $app_detail->otExtAllowance ?? 0;
                  $otExtAllowDetails=json_decode($app_detail->otExtAllowDetails,true) ?? "{}";
            ?>
            <form class="row g-3">
                        <div class="col-md-12">
                              <div class="row">
                                    @if($otExtAllowance==1)
                                          <div class="col-12 mb-3">
                                                <div class="alert alert-success" role="alert">
                                                      <i class="fas fa-exclamation-triangle"></i> This application requesting for <b>Extension Allowance</b>
                                                </div>
                                          </div>
                                    @endif
                                    <div class="col-md-4">
                                          <label for="appNumber" class="form-label">Application Number</label>
                                          <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->otAppNo?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appDate" class="form-label">Application Date</label>
                                          <input type="text" class="form-control" id="appDate" value="<?=$app_detail->otAppDate?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appCostCenter" class="form-label">Cost Center</label>
                                          <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->otCosCenter?>" readonly>
                                    </div>
                              </div>
                        </div>   
                        <div class="col-md-12">
                              <div class="row">
                                    <div class="col-md-4">
                                          <label for="appEmployeeId" class="form-label">Employee ID</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->otID?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appEmployeeName" class="form-label">Employee Name</label>
                                          <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->otName?>"
                                                readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appDepartment" class="form-label">Department</label>
                                          <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->department?>" readonly>
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-12">
                              <div class="row">
                                    <div class="col-md-4">
                                          <label for="appEmployeeId" class="form-label">Work Date</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->otDate?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appEmployeeName" class="form-label">Time</label>
                                          <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->otTimeFrom?> To <?=$app_detail->otTimeTo?>"
                                                readonly>
                                    </div>
                                    <div class="col-md-4">
                                          <label for="appDepartment" class="form-label">Work Tot. Hours</label>
                                          <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->otTotHours?>" readonly>
                                    </div>
                              </div>
                        </div>

                        @if($otExtAllowance==1)
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
                              </div>
                        @endif
      
                        <div class="col-md-12">
                              <div class="row">
                                    <div class="col-md-12">
                                          <label for="appEmployeeId" class="form-label">Reason</label>
                                          <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->otReason?>" readonly>
                                    </div> 
                              </div> 
                        </div>  

                        @if($otExtAllowance==0)
                              <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div> 
                        @endif
                        <div class="col-md-12" id="divWizard"></div>

                        <div class="modal-footer">
                              @if($app_detail->r_decision=="D")  
                              <div class="col-md-12">
                              <div class="row"> 
                                          <div class="col-md-12">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                                          <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                                          </div> 
                              </div> 
                              </div>
                              @endif 
                              
                              <div class="col-md-12"> 
                              <div class="row">
                                          <div class="col-md-6">
                                          <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                                          </div> 
                                          <div class="col-md-6"> 
                                          <div class="float-end">
                                                <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                                <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                          </div> 
                                          </div> 
                              </div>  
                              </div> 

                        </div>

                  </form>
      @endif

      @if($num==1) <!-- LEAVE -->
            <?php 
                  $app_detail = $app_details['rows'][0]; 
                  $appNo = $app_detail->laAppNo;
                  $appStatus = $app_detail->r_decision;
                  $holidays = $holidays['rows'];
                  //echo json_encode($holidays);
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->laAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->laAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->costName?>" readonly>
                              </div>
                        </div>
                  </div>    

                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->laID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->laName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->departmentName?>" readonly>
                              </div>
                        </div>
                  </div> 
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Leave Type</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->laType?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Balance</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->laBalance?>"
                                          readonly>
                                    <!-- <input type="text" class="form-control" id="appEmployeeName" value="<?=($app_detail->laTotalDays+$app_detail->laBalance)?>"
                                          readonly> -->
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->locationName?>" readonly>
                              </div>
                        </div>
                  </div>
      
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label">Date From</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->laDateFrom?>" readonly>
                              </div>
                              <div class="col-md-6">
                                    <label for="appEmployeeName" class="form-label">Date To</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->laDateTo?>"
                                          readonly>
                              </div> 
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <?php
                                          $leaveCount = 0;
                                          //$dateToday = "2024-08-12";
                                          $dateToday = date("Y-m-d");
                                          $leave_startDate = "";
                                          $leave_endDate = ""; 
                                    ?>
                                    <a href="#" id="lblTbl"></a>
                                    <table class="table table-striped">
                                          <thead class="table-dark">
                                                <tr>
                                                <th>#</th>
                                                <th><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;Date</th>
                                                <th><i class="fas fa-history"></i>&nbsp;&nbsp;Day part</th>
                                                <th>Action</th>
                                                </tr>
                                          </thead>  
                                          <tbody> 
                                          @foreach($sched_list['rows'] as $rows) 
                                                <?php  
                                                      $disabled = 1;
                                                      $dateToCheck = $rows->laLstDate;
                                                      $isHoliday = !empty(array_filter($holidays, function ($holiday) use ($dateToCheck) {
                                                                  return $holiday->holidayDate === $dateToCheck;
                                                                  }));
                                                ?>
                                                <tr>
                                                      <td>{{$rows->laLstID}}</td>
                                                      <td>{{$rows->laLstDate}} - {{$rows->laLstDateDesc}}</td>
                                                      <td>{{$rows->laSchedDesc}}</td>
                                                      <td> 
                                                      
                                                      @if($dateToday<=$rows->laLstDate) 
                                                      @endif    
                                                      @if(($isHoliday || $dateToday<=$rows->laLstDate) && $hostName=="msipf")
                                                            <i class="bi bi-x-circle-fill text-danger" onclick="return deleteLeave('{{$appNo}}','{{$rows->laLstID}}','{{$rows->laLstDate}}')"></i></button>
                                                      @endif 
                                                      </td>
                                                </tr> 
                                                <?php
                                                      $leaveCount++; 
                                                      if($leaveCount==1){
                                                            $leave_startDate = $rows->laLstDate;
                                                      }else{
                                                            $leave_endDate= $rows->laLstDate;
                                                      }
                                                ?>
                                          @endforeach 
                                          </tbody>
                                    </table> 
                                    <script>
                                          async function deleteLeave(appNo,laLstID,laLstDate) {
                                                if(confirm(`This will effect permanently in our database. Are you sure do you want to delete leave date:`+laLstDate+`?`)){
                                                      
                                                      var formData = new FormData();
                                                      formData.append('mode', '28');   
                                                      formData.append('pint_mode', 0);  
                                                      formData.append('rAppNo', appNo); 
                                                      formData.append('rId', laLstID);  
                                                      const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   
                                                
                                                      if(response.num!==0){
                                                            //alert(response.msg);
                                                            console.log(response.msg);
                                                            var id = JSON.parse(response.msg).id;
                                                            var msg = JSON.parse(response.msg).msg;
                                                            show_error_message(id,msg);  
                                                      }else{
                                                            window.location.href='{{url("/leave_application")}}';
                                                      }
                                                }
                                          }
                                    </script> 
                                    
                                    @if ($dateToday < $leave_startDate && $app_detail->r_decision=="A" && $hostName=="msipf") 
                                          <div class="container form-control">
                                                <div class="row">
                                                      <label for="txtCancelRemarks" id="lbltxtCancelRemarks"></label>
                                                      <div class="col-md-10">
                                                            <textarea class="form-control" id="txtCancelRemarks" placeholder="Cancel Remarks"></textarea>
                                                      </div>
                                                      <div class="col-md-2">
                                                            <a href="#" id="btnLeaveCancel"  class="btn btn-danger"  onclick="return cancelApprovedRequest(0,this.id,'<?=$app_detail->laAppNo?>')"><i class="fas fa-trash"></i> Cancel Leave</a> 
                                                      </div>
                                                </div>
                                          </div>
                                    @endif
                              </div> 
                        </div>
                  </div>

                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Leave Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->laReason?>" readonly>
                              </div> 
                        </div> 
                  </div>

                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div> 
                  <div class="col-md-12" id="divWizard"></div>

                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif

                  
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>

            </form>
      @endif
      
      @if($num==2) <!-- TIME ADJUSTMENT -->
            <?php 
                  $taAppNo="";
                  $app_detail = $app_details['rows'][0];
                  $appNo = $app_detail->taAppNo;
                  $appStatus = $app_detail->r_decision;
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->taAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->taAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->costName?>" readonly>
                              </div>
                        </div>
                  </div>   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->taID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->taName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->departmentName?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Date Adjustment</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->taDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Adjustment Type</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->taType?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Adjustment Time</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->taTime?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Adjustment Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->taReason?>" readonly>
                              </div> 
                        </div> 
                  </div>

                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div> 
                  <div class="col-md-12" id="divWizard"></div>
                  
                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>
                  
            </form>
      @endif

      @if($num==3) <!-- OFFICIAL BUSINESS -->
            <?php
                  $obAppNo="";
                  $app_detail = $app_details['rows'][0];
                  $appNo = $app_detail->obAppNo;
                  $appStatus = $app_detail->r_decision;
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->obAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->obAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->costName?>" readonly>
                              </div>
                        </div>
                  </div>   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->obID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->obName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->departmentName?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                                    <label for="appDepartment" class="form-label">OB Type</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->obType?>" readonly>
                              </div>
                        </div>
                  </div>

                  
                  @if($app_detail->obType=="Days")   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="ob_from_date" class="form-label">App. Date From</label>
                                    <input type="text" class="form-control" id="ob_from_date" value="<?=$app_detail->obDateFrom?>" readonly>
                              </div> 

                              <div class="col-md-6">
                                    <label for="ob_from_date" class="form-label">App. Date To</label>
                                    <input type="text" class="form-control" id="ob_from_date" value="<?=$app_detail->obDateTo?>" readonly>
                              </div>
                        </div> 
                  </div>


                  <div class="col-md-12">
                        <div class="row"> <!-- Days Details -->
                              <div class="col-md-12" id="divDaysDetails">  
                                    
                                    <div class="row reltv">  
                                          <div class="col-md-12"> 
                                          <table id="tbl1" class="table table-striped"> 
                                                <thead  class="table-dark">
                                                      <tr>
                                                            <th><center>Date <i class="far fa-calendar-alt"></i></center></th>
                                                            <th><center>Location <i class="fas fa-map-marker-alt"></i></center></th>
                                                            <th><center>From <i class="fas fa-sign-in-alt"></i></center></th>
                                                            <th><center>To <i class="fas fa-sign-out-alt"></i></center></th>
                                                            <th><center>Total</center></th> 
                                                      </tr> 
                                                </thead>
                                                <tbody id="tb1_tbody"> 
                                                      @foreach($days_sced['rows'] as $rows)
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
                                          </div> 
                                    </div>

                              </div>
                        </div>
                  </div> 
                  @else
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->obDateFrom?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->obLocation?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Time</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->obTime?>" readonly>
                              </div>
                        </div>
                  </div>
                  @endif
                  

                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->obReason?>" readonly>
                              </div> 
                        </div> 
                  </div>

                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
                  <div class="col-md-12" id="divWizard"></div>

                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>
                  
            </form>
      @endif

      @if($num==4) <!-- OFFSET -->
            <?php
            
                  $osAppNo="";
                  $app_detail = $app_details['rows'][0];
                  $appNo = $app_detail->osAppNo;
                  $appStatus = $app_detail->r_decision;
                  
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->osAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->osAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->osCosCenter?>" readonly>
                              </div>
                        </div>
                  </div>   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->osID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->osName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->department?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Offset Type</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->osType?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Offset Date From</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->osDateFrom?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Offset Date To</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->osDateTo?>"
                                          readonly>
                              </div>
                        </div>
                  </div>

                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->locationName?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Offset Time From</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->osTimeFrom?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Offset Time To</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->osTimeTo?>"
                                          readonly>
                              </div>
                        </div>
                  </div>
      
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->osReason?>" readonly>
                              </div> 
                        </div> 
                  </div>
                  
                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
                  <div class="col-md-12" id="divWizard"></div>

                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>  
            </form>
      @endif 

      @if($num==5) <!-- TIME ENTRY -->
            <?php 
                  $teAppNo="";
                  $app_detail = $app_details['rows'][0];
                  $appNo = $app_detail->teAppNo;
                  $appStatus = $app_detail->r_decision;
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->teAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->teAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->costName?>" readonly>
                              </div>
                        </div>
                  </div>   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->teID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->teName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->departmentName?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Date Adjustment</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->teDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Adjustment Type</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->teType?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Adjustment Time</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->teTime?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Adjustment Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->teReason?>" readonly>
                              </div> 
                        </div> 
                  </div>
                  
                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
                  <div class="col-md-12" id="divWizard"></div>
                  
                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>
                  
            </form>
      @endif


      @if($num==6) <!-- SCHEDULE -->
            <?php 
                  $scAppNo="";
                  $app_detail = $app_details['rows'][0];
                  $appNo = $app_detail->scAppNo;
                  $appStatus = $app_detail->r_decision;
            ?>
            <form class="row g-3">
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appNumber" class="form-label">Application Number</label>
                                    <input type="text" class="form-control" id="appNumber"  value="<?=$app_detail->scAppNo?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDate" class="form-label">Application Date</label>
                                    <input type="text" class="form-control" id="appDate" value="<?=$app_detail->scAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appCostCenter" class="form-label">Cost Center</label>
                                    <input type="text" class="form-control" id="appCostCenter" value="<?=$app_detail->costName?>" readonly>
                              </div>
                        </div>
                  </div>   
                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->scID?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->scName?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->departmentName?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-4">
                                    <label for="appEmployeeId" class="form-label">Date Request</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->scAppDate?>" readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appEmployeeName" class="form-label">Previous Schedule</label>
                                    <input type="text" class="form-control" id="appEmployeeName" value="<?=$app_detail->scPreviousSched?>"
                                          readonly>
                              </div>
                              <div class="col-md-4">
                                    <label for="appDepartment" class="form-label">Requested Schedule</label>
                                    <input type="text" class="form-control" id="appDepartment" value="<?=$app_detail->scSchedule?>" readonly>
                              </div>
                        </div>
                  </div>


                  <div class="col-md-12">
                        <div class="row">
                              <div class="col-md-12">
                                    <label for="appEmployeeId" class="form-label">Adjustment Reason</label>
                                    <input type="text" class="form-control" id="appEmployeeId" value="<?=$app_detail->scReason?>" readonly>
                              </div> 
                        </div> 
                  </div>
                  
                  <div class="col-12 mt-3" id="divFormsAttachmentsFiles"></div>
                  <div class="col-md-12" id="divWizard"></div>
                  
                  <div class="modal-footer">
                  @if($app_detail->r_decision=="D")  
                  <div class="col-md-12">
                        <div class="row"> 
                              <div class="col-md-12">
                              <label for="appEmployeeId" class="form-label fw-bold">Checker Remarks</label> 
                              <div class="alert alert-danger"><?=$app_detail->r_remarks?></div>
                              </div> 
                        </div> 
                  </div>
                  @endif
                  <div class="col-md-12"> 
                        <div class="row">
                              <div class="col-md-6">
                                    <label for="appEmployeeId" class="form-label fw-bold">Last Checked By:</label> 
                                    <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approverName?></label> 
                              </div> 
                              <div class="col-md-6"> 
                                    <div class="float-end">
                                          <label for="appEmployeeId" class="form-label fw-bold">Checked Date:</label> 
                                          <label for="appEmployeeId" class="form-label"><?=$app_detail->r_approvedDate?></label>
                                    </div> 
                              </div> 
                        </div>  
                  </div>
                  </div>
                  
            </form>
      @endif
     
 </div>

 <script>
      
      var thisBtn,thisAppNo;

      var formData = new FormData(); 
      formData.append('switch',<?=$num?>);
      formData.append('appNo',<?=$appNo?>);
      LoadPage('{{url("/wizard")}}','divWizard',formData); 



      async function cancelApprovedRequest(pint_mode,objID,appNo) {
            thisBtn = objID;
            GlovalHTMLObjLoading(1,objID);  
            var formData = new FormData();
            formData.append('mode', '27');    
            formData.append('pint_mode', pint_mode);  
            formData.append('switch', '<?= $num ?>');  
            formData.append('rAppNo',appNo);   
            formData.append('rRemarks',document.getElementById('txtCancelRemarks').value);   
            
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
            
            
            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            if (pint_mode==0){
                  /* console.log(response);
                  GlovalHTMLObjLoading(0,objID);   */ 
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        show_error_message(id,JSON.parse(response.msg).msg);  
                        GlovalHTMLObjLoading(0,objID);
                  }else{
                        if(confirm('Are you sure you want to cancel this request?')){
                              cancelApprovedRequest(1,objID,appNo); 
                        }else{
                              GlovalHTMLObjLoading(0,objID);
                        }
                  }

            }else{
                 //console.log(response);
                  window.location.href='{{url("/leave_application")}}'; 
            }
      }
 
      ForApprovalStatus('<?=$appStatus?>');
      loadAttachmentsAssets(0,'<?= json_encode($attachedFiles['rows'][0]->files ?? []) ?>');

 </script>