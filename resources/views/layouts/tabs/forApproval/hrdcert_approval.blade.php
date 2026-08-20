@extends('layouts.admin') <!-- main layout file --> 
@section('content')  
<?php 
      $df = date('Y-m-d', strtotime("-1 Month")); 
      $dt = date('Y-m-d');  

      $routeName = Route::currentRouteName(); 
      session()->put('routeName', value: $routeName); 

?>    



<div class="container-fluid mt-4 card-container">
      <!-- <h1>Overtime Approval</h1> -->
  
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


      <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="overtimeModalLabel"  aria-hidden="true"><!-- modal -->
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="overtimeModalLabel">Leave Application Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div> 
                        <div class="modal-footer" id="btns">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-success" id="btn1" onclick="AppoverResponse(0,1,this.id)">Approve</button>
                              <button type="button" class="btn btn-danger" id="btn2" onclick="AppoverResponse(0,0,this.id)">Reject</button>
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
                                          <th>Request Date</th> 
                                          <th>Employee Name</th> 
                                          <th>Cost Center</th>
                                          <th>Department</th>
                                          <th>Date Needed</th>  
                                          <th>Actions</th>
                                    </tr>
                              </thead>
                              <tbody> 
                              @foreach ($list['rows'] as $rows)
                              <tr>
                                    
                                    <td>{{$rows->appNo}}</td>
                                    <td>{{$rows->requestDate}}</td>
                                    <td>{{$rows->fullName}}</td>
                                    <td>{{$rows->costName}}</td>
                                    <td>{{$rows->departmentName}}</td>
                                    <td>{{$rows->dateNeeded}}</td>  
                                    <td>
                                          <div class="btn-container"> 
                        <!-- <button id="{{$rows->appNo}}" class="btn btn-action btn-view" title="More Details" onclick="view_leave_details('{{$rows->enc_id}}',this.id,'{{$rows->enc_pay}}')"><i
                        class="fas fa-eye"></i></button> -->
                                                <button id="{{$rows->appNo}}" class="btn btn-action btn-view" title="More Details" onclick="return EditCert('{{$rows->enc_id}}','{{$num}}')" ><i  class="fas fa-eye"></i></button>
                                          </div>
                                    </td>
                              </tr> 
                              @endforeach 
                              </tbody>
                        </table>
                        <!-- <div id="div_pagination" class="pagination">
                              <div>
                                    <button id="datatablesPending-prevPage">Prev</button>
                                    <button id="datatablesPending-nextPage">Next</button>
                              </div>
                        </div> -->
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
                                              
                                          </select>
                                    </div> 
                                    <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_History(1,this.id,7)">
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

<script>

var selectedID,this_mode;
      var chkbox_list = [];
      var chkbox_list_org = [];
      var approveBtnShow = 0;
      var original_btns =  document.getElementById("btns").innerHTML;

     /*   
      window.addEventListener('DOMContentLoaded', event => {  

                  initializePagination("datatablesPending"); 

                  const datatablesHistory = document.getElementById('datatablesHistory');
                  if (datatablesHistory) {
                        new simpleDatatables.DataTable(datatablesHistory);
                  }
            }); 
      */


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


      function view_leave_details(id,objID,enc_pay){
            GlovalHTMLObjLoading(1,objID);
            this.selectedID = id; 
            this.this_mode = 0;
            var formData = new FormData();
            formData.append('id', id); 
            formData.append('enc_pay', enc_pay);      
              
            var myModal = new bootstrap.Modal(document.getElementById('leaveModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/leave_detail")}}',  
                  type: 'POST', 
                  data: formData,    // Send the formData
                  processData: false,  // Don't let jQuery process the data
                  contentType: false,
                  headers: {
                  'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                  },             
                  success: function(response) {  
                        $('#modal_body').html(response);    
                        myModal.show();
                        GlovalHTMLObjLoading(0,objID);
                  },
                  error: function(msg) { 
                  //alert(JSON.parse(msg.responseText).error.msg.msg);
                  console.log('Error:'+JSON.stringify(msg));
                  } 
                 
            });
      } 

      async function AppoverResponse(pint_mode,val,objID) {
            GlovalHTMLObjLoading(1,objID);  
            this.this_val = val;
            var formData = new FormData();
            formData.append('mode', '22');    
            formData.append('pint_mode', pint_mode); 
            formData.append('switch', 1); 
            formData.append('id', selectedID);  
            formData.append('val', this_val);  
            formData.append('txtReject', document.getElementById('txtReject').value.trim());  
             
           /*  const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   
            
            if (pint_mode==0){
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                              //console.log(id); 
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; 
                        }
                  }else{ 
                        console.log(123); 
                  confirm_submit("Are you sure, you want to submit this response?");
                  }
                  GlovalHTMLObjLoading(0,objID); 
            }else{ 
                  //console.log(response);  
                  window.location.href='{{url("/hrd_approval")}}';
            }
            GlovalHTMLObjLoading(0,objID);  
            FadeOut(); */
      }

      function confirm_submit(msg){
            /* window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmResponse()');  */
      }

      function ConfirmResponse(){ 
            AppoverResponse(1,this_val,(this_val=='1' ? 'btn1':'btn2'));
      } 

      function approveItems(thisId){ 
           window.scrollTo(0, 0);
           fbconfirm('Submit Confirmation','Are you sure, you want to approve selected item(s)?', 'Yes','Cancel', 'ConfirmResponseAll("A","'+thisId+'")'); 
      }

      function rejectItems(thisId){ 
            var num = chkbox_list.length - 1; 
            for (let i = 0; i <= num; i++) {
                  var id =  document.getElementById(chkbox_list[i]);
                  var lbl =  document.getElementById('lbl'+id.name).id;   
                  var rj_rmrks =  document.getElementById('txt'+id.name);   
 
                  if (rj_rmrks.value==""){  


                        var trNum = id.closest("tr").rowIndex;   
                        
                        while (trNum < (rowsPerPage*currentPage) && currentPage>1) { 
                              let btnPrev = document.getElementById('datatablesPending-prevPage'); 
                              btnPrev.click(); 
                        } 

                        while (trNum>(currentPage*rowsPerPage)) { 
                              let btnNext = document.getElementById('datatablesPending-nextPage'); 
                              btnNext.click(); 
                        } 
                          
                        const txtId = (rj_rmrks.closest("table").id)+'txt'; 
                        var searchTxt = document.getElementById(txtId);
                        searchTxt.value = "";
                        FilterTbl(txtId);  

                        show_error_message(lbl,'Ops, Rejection remarks required!');  
                        return false; 
                  }  
            }

             window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation','Are you sure, you want to reject selected item(s)?', 'Yes','Cancel', 'ConfirmResponseAll("D","'+thisId+'")'); 
            
 
      }

      async  function ConfirmResponseAll(r_code,objID){ 

            GlovalHTMLObjLoading(1,objID);
            var items=[];
            var num = chkbox_list.length - 1; 
            for (let i = 0; i <= num; i++) { 
                  if(document.getElementById(chkbox_list[i])){
                        var id = document.getElementById(chkbox_list[i]).value;
                        var remarks = document.getElementById('txt'+document.getElementById(chkbox_list[i]).name).value;
                        items.push({"id":id,"remarks":remarks});  
                  }
            } 

            var formData = new FormData();
            formData.append('mode', '14');    
            formData.append('pint_mode', 0); 
            formData.append('switch', 1); 
            formData.append('r_code', r_code); 
            formData.append('r_remarks', ''); 
            formData.append('items',  JSON.stringify(items));   
             
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
            
            if (response.num!==0){
                  alert(response.msg);
                  GlovalHTMLObjLoading(0,objID); 
            }
           else{
            window.location.href='{{url("/leave_approval")}}'; 
           }
 
      }

      $(document).ready(function() {
            Filter_History(1,0, 7);
            RemoveClassInCheckBox('#th_checkbox');
            get_original_checkbox_list('datatablesPending'); 
      });
</script>
@endsection