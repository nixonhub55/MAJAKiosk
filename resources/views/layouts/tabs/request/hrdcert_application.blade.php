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

      .tdDate{  
            font-weight:bold;
            font-size:25px;
            color:white;
      }

      .tdDate2{
            color:white;
      }

      .divLeft{
            vertical-align:top;
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
 
</style>


<?php 
    $routeName = Route::currentRouteName(); 
    session()->put('routeName', value: $routeName); 
?>
<div class="container-fluid mt-4 card-container">
      <!-- <h1>Overtime Approval</h1> -->
      <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- <h4>Overtime List For Approval</h4> -->
            <h5>Your Applications</h5>
            <div>
                  <button  class="btn btn-add" id="btnAdd" onclick="return EditCert('0','{{$num}}')">+ Add Application</button> 
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
      <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="LeaveModalLabel"   aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="LeaveModalLabel">Leave Application</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div> 
                        <div class="modal-footer" id="btns">
                              <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                              <button type="button" id="btn1" class="btn btn-success" onclick="return SubmitRequest(0,this.id)">Save changes</button>
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
                                          <th>App Date</th> 
                                          <th>Employee Name</th>  
                                          <th>Center</th>
                                          <th>Department</th> 
                                          <th>Date Needed</th> 
                                          <th>Status</th> 
                                          <th>Actions</th>
                                    </tr>
                              </thead>  
                              <tbody>
                              @foreach($pending_list['rows'] as $rows)
                                    <tr>
                                          <td>{{$rows->appNo}}</td>
                                          <td>{{$rows->requestDate}}</td> 
                                          <td>{{$rows->name}}</td>
                                          <td>{{$rows->costCenter}}</td>
                                          <td>{{$rows->department}}</td>
                                          <td>{{$rows->dateNeeded}}</td>  
                                          <td>{{$rows->r_status}}</td> 
                                          <td>
                                                <div class="btn-container"> 
                                                      <button class="btn btn-action btn-edit" title="Edit" onclick="EditCert('{{$rows->enc_id}}','{{$num}}')"><i
                                                                  class="fas fa-edit"></i></button> 
                                                      <button class="btn btn-action btn-delete" title="Delete" onclick="DeleteRequest('{{$rows->appNo}}','{{$rows->enc_id}}')"><i
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
                                          <input type="date" id="txtdf" class="form-control">
                                    </div> 

                                    <div class="col-md-2 col-lg-2">
                                          <b>Application Date To</b>
                                          <input type="date" id="txtdt" class="form-control">
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
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,7)">
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
  
      $(document).ready(function() {
      Filter_HistoryRequester(0,0, 7);
      });


      function DeleteRequest(txt,id){ 
            this.selectedID = id;
            window.scrollTo(0, 0);
            fbconfirm('Delete Confirmation', 'Are you sure, you want to cancel this request ID:'+txt, 'Yes','Cancel', 'CancelConfirmttion()'); 
           
      }


      async function CancelConfirmttion(){ 
            var formData = new FormData();
            formData.append('mode', '13');  
            formData.append('switchNo',7);      
            formData.append('appNo',selectedID);      
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
                        //fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', "window.location.href='{{url("/hrd_application")}}'");   
                        fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', 'window.location.href="{{url('/hrd_application')}}"');  
                
                  } 
      }

</script>

@endsection