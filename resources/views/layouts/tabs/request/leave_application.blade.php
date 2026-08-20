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
      $sched_ddl=$sched_list['rows'];
      $holidays=$holidays['rows'];
      $df = date('Y-m-d', strtotime("-1 Month")); 
      $dt = date('Y-m-d');  
      
     // echo json_encode($pending_list);
?>
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
                                          <th>Date From</th>
                                          <th>Date To</th>
                                          <th>Leave Type</th>
                                          <th>Total Leave Days</th> 
                                          <th>Leave Reason</th> 
                                          <th>Status</th> 
                                          <th>Actions</th>
                                    </tr>
                              </thead>  
                              <tbody>
                              @foreach($pending_list['rows'] as $rows)
                                    <tr>
                                          <td>{{$rows->laAppNo}}</td>
                                          <td>{{$rows->laAppDate}}</td> 
                                          <td>{{$rows->laName}}</td>
                                          <td>{{$rows->laDateFrom}}</td>
                                          <td>{{$rows->laDateTo}}</td>
                                          <td>{{$rows->laType}}</td> 
                                          <td>{{$rows->laTotalDays}}</td> 
                                          <td>{{$rows->laReason}}</td>
                                          <td>{{$rows->statusVal}}</td>
                                          <td>
                                                <div class="btn-container"> 
                                                      <button class="btn btn-action btn-edit" title="Edit" onclick="EditLeave('{{$rows->enc_id}}','{{$rows->r_srcDb}}')"><i
                                                                  class="fas fa-edit"></i></button> 
                                                      <button class="btn btn-action btn-delete" title="Delete" onclick="DeleteRequest('{{$rows->laAppNo}}','{{$rows->enc_id}}')"><i
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
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,1)">
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
      var schedules = [];
      var holidays = <?=json_encode($holidays)?>;  
 

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

            if (schedules==""){
                  var alert = '<div id="myAlert" class="alert alert-danger" role="alert">Invalid leave schedule!</div>';
                  document.getElementById('div_validation').innerHTML = alert;
                  document.getElementById('div_validation').focus();
                  GlovalHTMLObjLoading(0,objID); 
                  return false;
            }

            var lnth = schedules.length;
            var df = schedules[0].date;
            var dt = schedules[lnth-1].date; 

            
            document.getElementById('div_validation').innerHTML="";
            var formData = new FormData();
            formData.append('mode', '3');    
            formData.append('pint_mode', pint_mode);    
            formData.append('id', selectedID);    
            formData.append('laType',document.getElementById('appOvertimeType').value);  
            formData.append('laBalace',document.getElementById('txtLaBalance').value);   
            formData.append('location',document.getElementById('appLocation').value); 
            formData.append('from_date',df); 
            formData.append('to_date',dt);  
            formData.append('reason',document.getElementById('la_reason').value); 
            formData.append('schedules',JSON.stringify(schedules));  
            formData.append('r_attachedFiles',JSON.stringify(attachedFiles)); 
            
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
                             /*  var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; */
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
                  }else{  
                  confirm_submit("Are you sure, you want to submit this?");
                  } 
                  GlovalHTMLObjLoading(0,objID); 
            }else{ 
                 //console.log(response);  
                  window.location.href='{{url("/leave_application")}}'; 
            }
             
      }
 

      function confirm_submit(msg){  
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      }
      
      function ConfirmApplication(){ 
            SubmitRequest(1,'btn1');
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

            if (isValid) {
                  inputField.style.backgroundColor = "";
            } else {
                  inputField.style.backgroundColor = "#fba";
            }

            return isValid;
      }


      function show_leave_form(id){   
            schedules = []; 
            this.selectedID=id;
            var formData = new FormData();
            formData.append('id', id);   
            formData.append('r_opt',JSON.stringify({"srcDB":selectedDB}));  
            
            var myModal = new bootstrap.Modal(document.getElementById('leaveModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/open_leave_form")}}',  
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

      $(document).ready(function(){ 
            $('#btnAdd').click(function(){   
                  show_leave_form(0);
            });
      });

      function EditLeave(num,r_srcDb){ 
            this.selectedDB=r_srcDb;
            show_leave_form(num);
      } 
      
      async function CancelConfirmttion(){ 
            var formData = new FormData();
            formData.append('mode', '13');  
            formData.append('switchNo',1);      
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
                        //fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', "window.location.href='{{url("/leave_application")}}'");   
                        fbconfirm(JsonMessges.sucess_hdr, JsonMessges.app_delete, 'OK','', 'window.location.href="{{url('/leave_application')}}"');  
                  } 
      }

      function SelectDateRange(sched_list){ 
             
            var frmDate = document.getElementById('la_from_date').value;
            var ToDate = document.getElementById('la_to_date').value; 
            Load_Schedules(frmDate,ToDate,sched_list); 
      }

      function Load_Schedules(frmDate,ToDate,sched_list){  
            document.getElementById('divSchedDetails').innerHTML = ""; 
            sched_list.forEach(function(item) {  
                  var val = parseFloat(item.laSched).toFixed(2);
                  generate_this_row(item.laLstDate,item.laLstID,val); 
            });  
      }


      function isWeekend(date) {
      const day = date.getDay();
      return day === 0 || day === 6; // 0 is Sunday, 6 is Saturday
      }

      function generate_this_row(laLstDate,num,val,exists){

            const date = new Date(laLstDate); 
            const isHoliday = holidays.some(holiday => holiday.holidayDate === laLstDate);
            const holidayName = holidays.find(holiday => holiday.holidayDate === laLstDate)?.holidayName;
       
            let currentDate = new Date(laLstDate);
            let dayOfWeek = currentDate.toLocaleString('en-us', { weekday: 'long' });  
 
            if(!exists){
                  schedules.push({"num":num,"date": currentDate.toLocaleDateString('en-CA'), "val": val});
            }
            
            var lbl_date = document.createElement('label'); 
            lbl_date.classList.add('row', 'tdDate');  
            lbl_date.innerHTML = laLstDate;

            var lbl_date2 = document.createElement('label'); 
            lbl_date2.classList.add('row', 'tdDate2');  
            lbl_date2.innerHTML = dayOfWeek;  

            var div_clm_box = document.createElement('div'); 
            div_clm_box.classList.add('col-4');  
            div_clm_box.appendChild(lbl_date); 
            div_clm_box.appendChild(lbl_date2); 

            var lbl_sched = document.createElement('label'); 
            lbl_sched.classList.add('row', 'tdDate2');  
            lbl_sched.innerHTML = "Schedule";  

            var ddl_sched = document.createElement('select'); 
            ddl_sched.classList.add('form-select', 'row'); 

            const options = <?=json_encode($sched_ddl)?>;  
            
            options.forEach(function(item) { 
                 
                  const option = document.createElement("option");

                  /* option.value = item.val;
                  option.textContent = item.txt;  */

                  option.value = item.val;
                  option.textContent = (isHoliday ? "Holiday "+item.txt.slice(-5) :  (isWeekend(date) ? "Rest Day "+item.txt.slice(-5) : item.txt) ); 


                  option.selected = (item.val==val); 
                  ddl_sched.appendChild(option);  
            }); 

            ddl_sched.addEventListener('change', function() { 
            update_laSched(num,ddl_sched.value);
            });

 
            var div_clm_box2 = document.createElement('div'); 
            div_clm_box2.classList.add('col-8');  
            div_clm_box2.appendChild(lbl_sched); 
            div_clm_box2.appendChild(ddl_sched); 

            const removeBtn = document.createElement('span');
            removeBtn.classList.add('rmvBtn'); 
            removeBtn.textContent = 'x'; 


            removeBtn.addEventListener('click', function() {
                  remove_sched(num);
                  div_row.remove();   
            }); 

            var div_row = document.createElement('div'); 
            div_row.classList.add('row', 'm-4', 'border', 'border-dark', 'p-3', 'rounded', 'bg-secondary');  
            div_row.style.position = 'relative'; 
            div_row.appendChild(div_clm_box);
            div_row.appendChild(div_clm_box2); 
            div_row.appendChild(removeBtn);

            var div_holiday = document.createElement('div'); 
            div_holiday.innerHTML = `<div>`+laLstDate+` (`+holidayName+`) <i class="fas fa-info-circle fs-3 text-info" title="You dont need to file a leave on this holiday date"></i></div>`;
            div_holiday.classList.add('row', 'm-4', 'border', 'border-dark', 'p-3', 'rounded', 'bg-white','text-danger');  

          
            /* document.getElementById('divSchedDetails').classList.add('container', 'form-control'); 
            document.getElementById('divSchedDetails').appendChild(div_row);   */

            document.getElementById('divSchedDetails').classList.add('container', 'form-control'); 
            if(!exists){
                  document.getElementById('divSchedDetails').appendChild(div_row); 
            }else{
                  document.getElementById('divSchedDetails').appendChild(div_holiday); 
            }

      }


      function generate_new_row(currentDate, dayOfWeek,num,val) {

                  //schedules.push({"num":num,"date": currentDate.toLocaleDateString('en-CA'), "day": dayOfWeek});
                  schedules.push({"num":num,"date": currentDate.toLocaleDateString('en-CA'), "day": dayOfWeek});
 
                  var lbl_date = document.createElement('label'); 
                  lbl_date.classList.add('row', 'tdDate');  
                  lbl_date.innerHTML = currentDate;

                  var lbl_date2 = document.createElement('label'); 
                  lbl_date2.classList.add('row', 'tdDate2');  
                  lbl_date2.innerHTML = dayOfWeek;  

                  var div_clm_box = document.createElement('div'); 
                  div_clm_box.classList.add('col-4');  
                  div_clm_box.appendChild(lbl_date); 
                  div_clm_box.appendChild(lbl_date2); 

                  var lbl_sched = document.createElement('label'); 
                  lbl_sched.classList.add('row', 'tdDate2');  
                  lbl_sched.innerHTML = "Schedule";  

                  var ddl_sched = document.createElement('select'); 
                  ddl_sched.classList.add('form-select', 'row'); 

                  const options = <?=json_encode($sched_ddl)?>; 
                  var num2 = 0;
                  options.forEach(function(item) {
                  if (num2==0){ schedules[num].laSched = item.val;  }
                  const option = document.createElement("option");
                        option.value = item.val;
                        option.textContent = item.txt;
                        ddl_sched.appendChild(option); 
                        num2+=1;
                  }); 

                  ddl_sched.addEventListener('change', function() { 
                  update_laSched(num,ddl_sched.value);
                  });

                  var div_clm_box2 = document.createElement('div'); 
                  div_clm_box2.classList.add('col-8');  
                  div_clm_box2.appendChild(lbl_sched); 
                  div_clm_box2.appendChild(ddl_sched); 
 
                  const removeBtn = document.createElement('span');
                  removeBtn.classList.add('rmvBtn'); 
                  removeBtn.textContent = 'x'; 

                  
                  removeBtn.addEventListener('click', function() {
                        remove_sched(num);
                        div_row.remove();   
                  }); 


                  var div_row = document.createElement('div'); 
                  div_row.classList.add('row', 'm-4', 'border', 'border-dark', 'p-3', 'rounded', 'bg-secondary');  
                  div_row.style.position = 'relative'; 
                  div_row.appendChild(div_clm_box);
                  div_row.appendChild(div_clm_box2); 
                  div_row.appendChild(removeBtn); 
 
                  document.getElementById('divSchedDetails').classList.add('container', 'form-control'); 
                  document.getElementById('divSchedDetails').appendChild(div_row); 
      } 

      function remove_sched(num){
            schedules.splice((num-1), 1);  
      }

      function update_laSched(num,value){
            schedules[num-1].val = value;
      }

      function DeleteRequest(txt,id){ 
            this.selectedID = id;
            window.scrollTo(0, 0);
            fbconfirm('Delete Confirmation', 'Are you sure, you want to cancel this request ID:'+txt, 'Yes','Cancel', 'CancelConfirmttion()'); 
           
      }

      async  function get_leave_balance(val){ 
            var formData = new FormData();
            formData.append('mode', '4');        
            formData.append('val', val);    
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   
            document.getElementById('txtLaBalance').value = response.rows[0].balance;   
      } 
 
      $(document).ready(function() {
            Filter_HistoryRequester(0,0, 1);
     });


</script>

@endsection