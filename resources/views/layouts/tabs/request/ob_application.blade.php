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
      //echo json_encode($rows);
?>

<div id="divExec"></div>
<div class="container-fluid mt-4 card-container">
      <!-- <h1>Overtime Approval</h1> -->
      <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- <h4>Overtime List For Approval</h4> -->
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
      <div class="modal fade" id="obModal" tabindex="-1" aria-labelledby="LeaveModalLabel"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="LeaveModalLabel">Official Business Application</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div> 
                        <div class="modal-footer"  id="btns">
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
                                          <th>App Date</th>    
                                          <th>Official Business Type</th> 
                                          <th>Official Business Date</th> 
                                          <th>Status</th> 
                                          <th>Actions</th>
                                    </tr>
                              </thead>
                              <tbody>
                              @foreach($rows as $list)
                                   <tr>
                                   <td>{{$list->obAppNo}}</td> 
                                   <td>{{$list->obAppDate}}</td> 
                                   <td>{{$list->obType}}</td>   
                                   <td>{{$list->obDateFrom}} to {{$list->obDateTo}}</td>   
                                   <td>{{$list->r_status}}</td>   
                                   <td>
                                    <div class="btn-container">
                                          <button class="btn btn-action btn-edit" title="Edit" onclick="Edit_TA('{{$list->enc_id}}','{{$list->r_srcDb}}')"><i
                                                      class="fas fa-edit"></i></button>
                                          <button class="btn btn-action btn-delete" title="Delete"  onclick="Delete_TA('{{$list->enc_id}}','{{$list->obAppNo}}')"><i
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
                                                <option value="{{$rows->val}}" >{{$rows->txt}}</option>
                                                @endforeach
                                          </select>
                                    </div> 
                                    <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,3)">
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
      var selectedID="",selectedDB = ""; 
      var day_list = []; 

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
                  day_list.length = 0;
                  show_ob_form(0);
            });
      }); 

      function Edit_TA(num,r_srcDb){
            this.selectedDB=r_srcDb;
            show_ob_form(num);
      }

      function Delete_TA(num,txt){
            this.selectedID = num;
            window.scrollTo(0, 0);
            fbconfirm('Cancel Confirmation','Are you sure you want to cancel application #:'+txt+'?', 'Yes','Cancel', 'CancelApplication()'); 
      }

      async function SubmitRequest(pint_mode,objID) {  

            var ddlLoc =  document.getElementById('txtlocation');
            var txtLoc =  document.getElementById('hiddentxtlocation');
            var loc = (txtLoc.className.includes("show_tr") ? txtLoc.value : ddlLoc.value); 
           
            GlovalHTMLObjLoading(1,objID); 
            document.getElementById('div_validation').innerHTML=""; 
            var formData = new FormData();
            formData.append('mode', '8');    
            formData.append('pint_mode', pint_mode);  
            formData.append('r_id',selectedID);          
            formData.append('r_type',document.getElementById('ob_ddl').value);  
            formData.append('r_reason',document.getElementById('txtReason').value);   

            formData.append('r_inout_date',document.getElementById('txtDate').value);  
            formData.append('r_inout_time',document.getElementById('txtTime').value);  
            /* formData.append('r_inout_location',document.getElementById('txtlocation').value);   */ 
            formData.append('r_inout_location',loc);  
            
            formData.append('r_days_df',document.getElementById('ob_from_date').value);  
            formData.append('r_days_dt',document.getElementById('ob_to_date').value);  
            formData.append('json_schedules',JSON.stringify(day_list)); 
            formData.append('r_attachedFiles',JSON.stringify(attachedFiles));  
              
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  
            
            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
             
            /* GlovalHTMLObjLoading(0,objID); 
            console.log(response);
            return; */
            
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
                  } else if (vfbox.num==1){ 
                              GlovalHTMLObjLoading(0,objID);   
                              show_error_message(vfbox.id+'_lbl',vfbox.msg);  
                              return false;
                  }else{ 
                  confirm_submit("Are you sure, you want to submit this?");
                  } 
                  GlovalHTMLObjLoading(0,objID); 
            }else{ 
                 window.location.href='{{url("/ob_application")}}';
               /*  console.log(response);
                GlovalHTMLObjLoading(0,objID);  */
            }
           
      }

      function confirm_submit(msg){  
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      }

      
      function ConfirmApplication(){ 
            SubmitRequest(1,'btn1');
      } 

      function show_ob_form(id){   
            this.selectedID=id;
            day_list = [];  
            var formData = new FormData();
            formData.append('app_id', id); 
            formData.append('r_opt',JSON.stringify({"srcDB":selectedDB}));
              
            var myModal = new bootstrap.Modal(document.getElementById('obModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/ob_app_form")}}',  
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
            formData.append('mode', '12');  
            formData.append('r_obAppNo', selectedID);    
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   

            if (response.num!==0){
                  document.getElementById('divExec').innerHTML = response; 
            }else{ 
                  window.scrollTo(0, 0);
                  //fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', "window.location.href='{{url("/ob_application")}}'");   
                  fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', 'window.location.href="{{url('/ob_application')}}"');  
            } 

      }
    
      function SelectType(val){
           var divTime = document.getElementById('divTime');
           var divDays = document.getElementById('divDays');

           if (val==""){
            divTime.style.display = "none";
            divDays.style.display = "none";
           }else{
            divDays.style.display = (val=="Days" ? "block" : "none");
            divTime.style.display = ((val=="In" || val=="Out") ? "block" : "none");
           } 
           
      }


      function remove_row(thisId){ 
            var row = document.getElementById(thisId); 
            // console.clear();  console.log('before:'+JSON.stringify(day_list));
            this.day_list = day_list.splice((thisId-1), 1); 
            console.log(day_list);
            row.style.display = "none"; 
      }

      function UpdateArray(Jobj,num,val){ 
            //alert('Jobj:'+Jobj+' num:'+num+' val:'+val);
            day_list[num-1][Jobj] = val; 
            if (['obLstTimeFrom', 'obLstTimeTo'].includes(Jobj)){
                  updateTotal(num);
            }
      }

      function updateTotal(num){ 
            var tf = day_list[num-1]['obLstTimeFrom'];
            var tt = day_list[num-1]['obLstTimeTo']; 
            let start = new Date("2024-12-28T" + tf + ":00");
            let end = new Date("2024-12-28T" + tt + ":00"); 
            let diffInMilliseconds = end - start; 
            let diffInMinutes = diffInMilliseconds / (1000 * 60); 
            let hours = Math.floor(diffInMinutes / 60);
            let minutes = diffInMinutes % 60; 
            let total = String(hours).padStart(2, '0') + ":" + String(minutes).padStart(2, '0'); 
            day_list[num-1]['obLstTotHours'] = total;  
            document.getElementById('tot'+num).innerHTML = "<b style='color:green'>"+total+"</b>";
  
      } 

      $(document).ready(function() {
            Filter_HistoryRequester(0,0, 3);
      });

</script>
@endsection