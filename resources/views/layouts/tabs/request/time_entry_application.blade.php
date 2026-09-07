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
      $btnId = 0; 
 
?>
<div id="divExec"></div>
<div class="container-fluid mt-4 card-container"> 
      <div class="d-flex justify-content-between align-items-center mb-3"> 
            <h5>Your Applications</h5>
            <div>
                  <button  class="btn btn-add" id="btnAdd">+ Add Application</button> 
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

       <!-- Modal Structure --> 
       <div class="modal fade" id="teModal" tabindex="-1" aria-labelledby="LeaveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="LeaveModalLabel">Certificate of Attendance Application</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div> 
                        <div class="modal-footer" id="btns">
                              <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-success" id="btn1" onclick="return SubmitRequest(0,this.id)">Save changes</button>
                        </div>
                  </div>
            </div>
      </div> 
      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                  <div class="table-container">
                        <table class="table data-table" id="datatablesPending">
                              <thead>
                                    <tr> 
                                          <th>App #</th>
                                          <th>ID</th>    
                                          <th>Application Date</th> 
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Type</th>
                                          <th>Location</th>
                                          <th>Remarks</th>
                                          <th>Status</th>
                                          <th>Actions</th>
                                    </tr>
                              </thead>
                              <tbody> 
                                @foreach($pending_list['rows'] as $list)
                                <tr>
                                    <td>{{$list->r_appNo}}</td>
                                    <td>{{$list->r_id}}</td>
                                    <td>{{$list->teAppDate}}</td>
                                    <td>{{$list->teDate}}</td>
                                    <td>{{$list->teTime}}</td>
                                    <td>{{$list->teType}}</td>
                                    <td>{{$list->locationName}}</td>
                                    <td>{{$list->teReason}}</td>
                                    <td>{{$list->r_status}}</td>
                                    <td>
                                          <div class="btn-container">
                                                <button class="btn btn-action btn-edit" title="Edit" id="btn1{{$btnId}}" onclick="Edit_TE('{{$list->enc_id}}')"><i
                                                            class="fas fa-edit"></i></button>
                                                <button class="btn btn-action btn-delete" title="Delete"  onclick="Delete_TE('{{$list->enc_id}}','{{$list->teAppNo}}')"><i
                                                            class="fas fa-trash"></i>
                                                </button> 
                                          </div> 
                                    </td>
                                </tr>
                                <?php  $btnId+=1;?>
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
                                          <input type="date" id="txtdf" class="form-control" value="">
                                    </div> 

                                    <div class="col-md-2 col-lg-2">
                                          <b>Application Date To</b>
                                          <input type="date" id="txtdt" class="form-control" value="">
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
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,5)">
                                          <i class="fas fa-filter"></i><b> Filter</b></button>
                                    </div> 
                              </div> 
                        </div> 
                        <br> 
                        <div id="divTbl"></div> 
                  </div>
            </div>
      </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>


      var this_mode = 0;
      var selectedID=0; 

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

      $(document).ready(function(){ 
            $('#btnAdd').click(function(){   
                  show_time_entry_form(0);
            });
      }); 

      function Edit_TE(num){ 
            show_time_entry_form(num);  
      }

      function Delete_TE(num,txt){
            this.selectedID = num;
            window.scrollTo(0, 0);
            fbconfirm('Cancel Confirmation','Are you sure you want to cancel application #:'+txt+'?', 'Yes','Cancel', 'CancelApplication()'); 
      }

      async function SubmitRequest(pint_mode,objID) {   
            GlovalHTMLObjLoading(1,objID); 
            document.getElementById('div_validation').innerHTML=""; 
            var formData = new FormData();
            formData.append('mode', '17');    
            formData.append('pint_mode', pint_mode);  
            formData.append('r_teAppNo',selectedID);    
            formData.append('r_teType',document.getElementById('ddlType').value);  
            formData.append('r_teDate',document.getElementById('teDate').value);       
            formData.append('r_teTime',document.getElementById('txtTime').value);     
            formData.append('r_location',document.getElementById('appLocation').value);         
            formData.append('r_teReason',document.getElementById('txtReason').value);       
            formData.append('r_attachedFiles',JSON.stringify(attachedFiles)); 
            
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   
            
            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
            
            var vfbox = this_should_be_verified('verification_checkbox');  

            if (pint_mode==0){

                  if (response.num==2){
                        var id = JSON.parse(response.msg).id;
                        GlovalHTMLObjLoading(0,objID);  
                        show_error_message(id,JSON.parse(response.msg).msg);    
                        return false;
                  }

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
                  } else if (vfbox.num==1){ 
                        console.log(vfbox.id); 
                        GlovalHTMLObjLoading(0,objID);   
                        show_error_message(vfbox.id+'_lbl',vfbox.msg);  
                        return false;
                  }else{ 
                  confirm_submit("Are you sure, you want to submit this?");
                  }
                  GlovalHTMLObjLoading(0,objID);  
            }else{ 
                  //console.log(response);
                 window.location.href='{{url("/te_application")}}';
            }
           
      }

      function confirm_submit(msg){  
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      }

      
      function ConfirmApplication(){ 
            SubmitRequest(1,'btn1');
      } 

      function show_time_entry_form(id){  
            this.selectedID=id; 
            var formData = new FormData();
            formData.append('app_id', id);   
            var myModal = new bootstrap.Modal(document.getElementById('teModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/time_entry_form")}}',  
                  type: 'POST', 
                  data: formData,    
                  processData: false,  
                  contentType: false,
                  headers: {
                  'X-CSRF-TOKEN': csrfToken 
                  },             
                  success: function(response) {  
                        $('#modal_body').html(response);   
                        myModal.show();
                  },
                  error: function(msg) {  
                  //alert(JSON.parse(msg.responseText).error.msg.msg);
                  console.log('Error:'+JSON.stringify(msg));
                  } 
                 
            });  
            ResetModalButtons();
      }

      async function CancelApplication(){ 
            document.getElementById('divExec').innerHTML="";
            var formData = new FormData();
            formData.append('mode', '18');  
            formData.append('r_id', selectedID);    
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   

            if (response.num!==0){
                  document.getElementById('divExec').innerHTML = response; 
            }else{  
                  window.scrollTo(0, 0);
                  //fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', "window.location.href='{{url("/te_application")}}'");   
                  fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', 'window.location.href="{{url('/te_application')}}"'); 
          
            } 

      }

      $(document).ready(function() {
            Filter_HistoryRequester(0,0, 5);
     });

</script>
@endsection