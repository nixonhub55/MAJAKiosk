
@extends('layouts.admin') <!-- main layout file -->

@section('content')  
<style>
      .btn-add {
            background: #28a745;
            color: #fff;
            font-size: 14px;
            border-radius: 20px;
            padding: 8px 20px;
            text-decoration: none;
      }

      .btn-export {
            background: #6c757d;
            color: #fff;
            font-size: 14px;
            border-radius: 20px;
            padding: 8px 20px;
            text-decoration: none;
      }
      .modal-body {
            padding: 2em;
      }

      .bg-primary {
            background-color: black;
      }
</style> 

<?php 
      $df = date('Y-m-d', strtotime("-1 Month")); 
      $dt = date('Y-m-d'); 
?>

<div class="container-fluid mt-4 card-container"> 

      <div class="d-flex justify-content-between align-items-center mb-3"> 
            <h5>Your Applications</h5>
            <div>
                    <button  class="btn btn-add" id="btnAdd">+ Add Application</button>
            </div>  
            <div class="modal fade" id="overtimeModal" tabindex="-1" aria-labelledby="overtimeModalLabel" aria-hidden="true"><!-- modal -->
                  <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="overtimeModalLabel">Overtime / Under Time Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                              </div>
                              <div class="modal-body" id="modal_body"></div> 
                              <div class="modal-footer" id="btns">
                                    <button type="button" class="btn btn-secondary"
                                          data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" id="saveOvertimeButton" onclick="return SubmitRequest(0,this.id)">Save changes</button>
                              </div>
                        </div>
                  </div>
            </div> 
      </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab"
                        aria-controls="pending" aria-selected="true">Pending</a>
            </li>
            <li class="nav-item" role="presentation">
                  <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab"
                        aria-controls="history" aria-selected="false">History</a>
            </li>
      </ul>

      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                  <div class="table-container">
                        <table class="table data-table" id="datatablesPending">
                              <thead>
                                    <tr>

                                          <th>App #</th>
                                          <th>App Date</th>
                                          <th>Work Date</th>
                                          <th>Name</th>
                                          <th>Cost Center</th>
                                          <th>Department</th>
                                          <th>Type</th>
                                          <th>Time</th>
                                          <th>Reason</th>
                                          <th>Status</th>
                                          <th>Actions</th>
                                    </tr>
                              </thead>
                              <tbody>
                                   @foreach($ot_list['rows'] as $list)
                                   <tr>
                                   <td>{{$list->otAppNo}}</td>
                                   <td>{{$list->otAppDate}}</td>
                                   <td>{{$list->otDate}}</td>
                                   <td>{{$list->otName}}</td>
                                   <td>{{$list->otCosCenter}}</td>
                                   <td>{{$list->department}}</td>
                                   <td>{{$list->otType}}</td>
                                   <td>{{$list->otTimeFrom." - ".$list->otTimeTo}}</td>
                                   <td>{{$list->otReason}}</td> 
                                   <td>{{$list->r_status}}</td> 
                                   <td>
                                    <div class="btn-container">
                                          <button class="btn btn-action btn-edit" title="Edit" onclick="EditOT('{{$list->enc_id}}')"><i
                                                      class="fas fa-edit"></i></button>
                                          <button class="btn btn-action btn-delete" title="Delete"  onclick="DeleteOT('{{$list->enc_id}}','{{$list->otAppNo}}')"><i
                                                      class="fas fa-trash"></i></button> 
                                    </div> 
                                    </td>
                                   </tr>
                                   @endforeach 
                              </tbody>
                        </table>
                  </div>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"> 
                  <div class="table-container">  
                        <div class="container">
                              <div class="row bg-light rounded p-2"> 
                                    <div class="col-md-2 col-lg-2">
                                          <b>Application Date From</b>
                                          <input type="date" id="txtdf" class="form-control" value="<?=$df?>">
                                    </div> 

                                    <div class="col-md-2 col-lg-2">
                                          <b>Application Date To</b>
                                          <input type="date" id="txtdt" class="form-control" value="<?=$dt?>">
                                    </div>  

                                    <div class="col-md-2 col-lg-2">
                                    <b>Status</b>
                                          <select id="ddlStatus" class="form-select">
                                                @foreach($status['rows'] as $rows)
                                                <option value="{{$rows->val}}">{{$rows->txt}}</option>
                                                @endforeach
                                          </select>
                                    </div> 
                                    <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,0)">
                                          <i class="fas fa-filter"></i><b> Filter</b></button>
                                    </div> 
                              </div> 
                        </div> 
                        <br> 
                        <div id="divTbl"></div> 
                  </div>
            </div>
      
      </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>

      var this_mode = 0;
      var selectedID="";

      window.addEventListener('DOMContentLoaded', event => { 

            const datatablesPending = document.getElementById('datatablesPending');
            if (datatablesPending) {
                  new simpleDatatables.DataTable(datatablesPending);

            }

            const datatablesHistory = document.getElementById('datatablesHistory');
            if (datatablesHistory) {
                  new simpleDatatables.DataTable(datatablesHistory);
            }
      });

      
      
      async function SubmitRequest(pint_mode,objID) {   
            GlovalHTMLObjLoading(1,objID); 
            document.getElementById('div_validation').innerHTML="";
            var formData = new FormData();
            formData.append('mode', '1');    
            formData.append('pint_mode', pint_mode);  
            formData.append('otAppNo',selectedID);  
            formData.append('otAppNo',selectedID);  
            formData.append('ot_type',document.getElementById('appOvertimeType').value);   
            formData.append('ot_location',document.getElementById('appLocation').value); 
            formData.append('ot_date',document.getElementById('ot_date').value); 
            formData.append('ot_from',document.getElementById('ot_from_date').value); 
            formData.append('ot_to',document.getElementById('ot_to_date').value); 
            formData.append('ot_tot_break',document.getElementById('tot_break').value); 
            formData.append('ot_time_from',document.getElementById('otTimeFrom').value); 
            formData.append('ot_time_to',document.getElementById('otTimeTo').value); 
            formData.append('time_tot',document.getElementById('appTotalTime').value);   
            formData.append('Remarks',document.getElementById('txtRemarks').value);      
            formData.append('otExtAllowance',document.getElementById('checkboxTtExtAllowance').checked);  

            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  
 
            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);  
 
            var vfbox = this_should_be_verified('verification_checkbox');   
                   
            if (pint_mode==0){
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                              console.log(id); 
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; 
                        }
                  }
                  else if (vfbox.num==1){ 
                        GlovalHTMLObjLoading(0,objID);   
                        show_error_message(vfbox.id+'_lbl',vfbox.msg);  
                        return false;
                  } 
                  else{ 
                  confirm_submit("Are you sure, you want to submit this?");
                  } 
                  GlovalHTMLObjLoading(0,objID); 
            }else{
                  /* 
                        console.clear();  console.log(response);
                        GlovalHTMLObjLoading(1,objID);  
                  */
                  window.location.href='{{url("/overtime_application")}}'; 
            }
      } 

      
      async function OpenModal(id){  
            var myModal = new bootstrap.Modal(document.getElementById('overtimeModal'));  
            var formData = new FormData();
            formData.append('req_id', id);
            const response = await exec_XMLHttpRequest(formData,'{{url("/open_form")}}');  
            document.getElementById('modal_body').innerHTML =  response;   
            myModal.show();
      }  

      function confirm_submit(msg){  
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      }
      
      function ConfirmApplication(){
            this.this_mode=1;
            SubmitRequest(1,'saveOvertimeButton');
      } 
 

      function populateTimeDropdown(selectId, selectedTime = null) {
            const selectElement = document.getElementById(selectId); 
            for (let hour = 0; hour < 24; hour++) {
            for (let minute = 0; minute < 60; minute += 15) { 
                  const formattedTime = `${hour.toString().padStart(2, "0")}:${minute.toString().padStart(2, "0")}`; 
                  const option = document.createElement("option");
                  option.value = formattedTime;
                  option.textContent = formattedTime; 
                  if (formattedTime === selectedTime) {
                  option.selected = true;
                  }
      
                  selectElement.appendChild(option);
                  }
            }
      }


      function validateHhMm(inputField) {
            const isValid = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(inputField.value); 
            /* if (isValid) {
                  inputField.style.backgroundColor = "";
            } else {
                  inputField.style.backgroundColor = "#fba";
            } */
            inputField.style.backgroundColor = "";
            return isValid;
      }


      function show_ovrtime_form(id){   
            this.selectedID = id;
            this.this_mode = 0;
            var formData = new FormData();
            formData.append('id', id);  // Add other form fields here if needed  
            var myModal = new bootstrap.Modal(document.getElementById('overtimeModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/open_form")}}',  
                  type: 'POST', 
                  data: formData,    // Send the formData
                  processData: false,  // Don't let jQuery process the data
                  contentType: false,
                  headers: {
                  'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                  },             
                  success: function(response) {  
                        $('#modal_body').html(response);  

                        $('#otTimeFrom').change(function(){
                              validateHhMm(this);
                        });

                        $('#otTimeTo').change(function(){
                              validateHhMm(this);
                        }); 
                                    
                        myModal.show();
                  },
                  error: function(msg) {
                  //alert(JSON.parse(msg.responseText).error.msg.msg);
                  console.log('Error:'+JSON.stringify(msg));
                  } 
                 
            });

            ResetModalButtons();
      }

      $(document).ready(function(){ 
            $('#btnAdd').click(function(){   
                  show_ovrtime_form(0);
            });
      });

      function EditOT(num){ 
            show_ovrtime_form(num);
      } 

      function DeleteOT(num,txt){
            this.selectedID = num
            window.scrollTo(0, 0);
            fbconfirm('Delete Confirmation', 'Are you sure, you want to cancel this request ID:'+txt, 'Yes','Cancel', 'CancelConfirmttion()'); 
      } 
      

      async function CancelConfirmttion(){  
            var formData = new FormData();
            formData.append('mode', '2');    
            formData.append('otAppNo',selectedID);   
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 

            if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                              console.log(id);
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert;
                              document.getElementById(id).focus();
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; 
                        }
                  }else{   
                        window.scrollTo(0, 0);
                        //fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', "window.location.href='{{url("/overtime_application")}}'");   
                        fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', 'window.location.href="{{url('/overtime_application')}}"');   
                  } 
      }
      
      $(document).ready(function() {
            Filter_HistoryRequester(0,0, 0);
      });
 

</script> 
@endsection