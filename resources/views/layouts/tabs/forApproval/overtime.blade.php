@extends('layouts.admin') 
@section('content')   
<?php 
      $df = date('Y-m-d', strtotime("-1 Month")); 
      $dt = date('Y-m-d'); 
?> 
<div class="container-fluid mt-4 card-container"> 
      <div class="d-flex justify-content-between align-items-center mb-3"> 
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

      <div class="modal fade" id="overtimeModal" tabindex="-1" aria-labelledby="overtimeModalLabel"  aria-hidden="true"><!-- modal -->
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="overtimeModalLabel">Overtime / Under Time Application Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div> 
                        <div id="btns" class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-success" id="btn1" onclick="AppoverResponse(0,1,this.id)">Approve</button>
                              <button type="button" class="btn btn-danger" id="btn2" onclick="AppoverResponse(0,0,this.id)">Reject</button>
                        </div>
                  </div>
            </div>
      </div>
 
      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                  <div class="table-container" style="overflow: scroll;">
                        <table class="table data-table" id="datatablesPending">
                              <thead>
                                    <tr>
                                          <th id="th_checkbox"><input class="form-check-input" type="checkbox" id="selectAll" onclick="return SetAll(this.id,'datatablesPending')"></th>
                                          <th>App #</th> 
                                          <th>Emp#</th>
                                          <th>Employee Name</th>
                                          <th>App Date</th>
                                          <th>Type</th>
                                          <th>Work Date</th> 
                                          <th>From</th>
                                          <th>To</th>
                                          <th>Time</th>
                                          <th>Total Hours</th>
                                          <th>Reason</th>  
                                          <th id="hdr_rjct">Rejection Remarks</th>  
                                          <th>Action</th>
                                    </tr>
                              </thead>
                              <tbody>
                              <?php $num=0?>
                              @foreach ($list['rows'] as $rows) 
                              <tr>
                                    <td>
                                          @if($rows->approverLocked==1)
                                          <center><i class="fas fa-lock" title="Payroll Locked"></i></center>
                                          @else
                                           <center>
                                           <input class="form-check-input" id="chkbox{{$num}}" type="checkbox" value="{{$rows->enc_id}}" data-database="{{$rows->r_srcDb}}" name="{{$rows->otAppNo}}" onclick="return CheckMe(1,this.id,'selectAll','datatablesPending')">
                                           </center>
                                          @endif
                                          
                                    </td>
                                    <td>{{$rows->otAppNo}}</td>
                                    <td>{{$rows->otID}}</td>
                                    <td>{{$rows->otName}}</td>
                                    <td>{{$rows->otAppDate}}</td>
                                    <td>{{$rows->otType}}</td>
                                    <td>{{$rows->otDate}}</td>
                                    <td>{{$rows->otTimeFrom}}</td>
                                    <td>{{$rows->otTimeTo}}</td>
                                    <td>{{$rows->otTimeTo}}</td>
                                    <td>{{$rows->otTotHours}}</td>
                                    <td>{{$rows->otReason}}</td> 

                                    <td id="td{{$rows->otAppNo}}"> 
                                          <label class="fixed_lbl" id="lbl{{$rows->otAppNo}}" for="txt{{$rows->otAppNo}}"></label>
                                          <input type="text" id="txt{{$rows->otAppNo}}" class="form-control" maxlength="200"> 
                                    </td> 

                                    <td>
                                          <div class="btn-container"> 
                                                <button id="{{$rows->otAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="view_overtime_details('{{$rows->enc_id}}',this.id,'{{$rows->enc_pay}}','{{$rows->r_srcDb}}')"><i
                                                            class="fas fa-eye"></i></button>
                                          </div>
                                    </td>
                              </tr>
                              <?php  $num+=(($rows->approverLocked)==1 ? 0 : 1); ?>
                              @endforeach 
                              </tbody> 
                        </table> 
                        <div id="div_pagination" class="pagination">
                              <div>
                                    <button id="datatablesPending-prevPage">Prev</button>
                                    <button id="datatablesPending-nextPage">Next</button>
                              </div>
                        </div>
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
                                    <button class="btn btn-primary" id="btnFilter" onclick="Filter_History(1,this.id,0)">
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

      var selectedID,this_mode,selectedDB;
      var chkbox_list = [];
      var chkbox_list_org = [];
      var approveBtnShow = 0; 
      var original_btns =  document.getElementById("btns").innerHTML;
      
      window.addEventListener('DOMContentLoaded', event => {  

            initializePagination("datatablesPending"); 

            const datatablesHistory = document.getElementById('datatablesHistory');
            if (datatablesHistory) {
                  new simpleDatatables.DataTable(datatablesHistory);
            }
      }); 

      function view_overtime_details(id,objID,enc_pay,r_srcDb){ 
            GlovalHTMLObjLoading(1,objID);
            this.selectedDB = r_srcDb;
            this.selectedID = id;
            this.this_mode = 0;
            var formData = new FormData();
            formData.append('id', id);  
            formData.append('enc_pay', enc_pay);  
            formData.append('r_opt',JSON.stringify({"srcDB":selectedDB})); 
             
            var myModal = new bootstrap.Modal(document.getElementById('overtimeModal'));   
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/ot_detail")}}',  
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
            formData.append('mode', '11');  
            formData.append('database', selectedDB)  
            formData.append('pint_mode', pint_mode); 
            formData.append('switch', 0); 
            formData.append('id', selectedID);  
            formData.append('val', this_val);  
            formData.append('txtReject', document.getElementById('txtReject').value.trim());  
             
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  
            
            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
            
            if (pint_mode==0){
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                               console.log(id);
                              /* var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert;
                              document.getElementById(id).focus(); */
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; 
                        }
                  }else{ 
                  confirm_submit("Are you sure, you want to submit this response?");
                  } 
            }else{
                  /* console.clear();
                  console.log(response); */
                  window.location.href='{{url("/overtime_approval")}}';
            }
            GlovalHTMLObjLoading(0,objID);  
            FadeOut();
      }

      function confirm_submit(msg){
            window.scrollTo(0, 0);
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmResponse()'); 
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
                        //FilterTbl(txtId);  

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
                        var checkbox = document.getElementById(chkbox_list[i])
                        var database = checkbox.getAttribute('data-database');
                        console.log(database);
                        var id = checkbox.value; 
                        var remarks = document.getElementById('txt'+document.getElementById(chkbox_list[i]).name).value;
                        items.push({"id":id,"remarks":remarks,"_srcDb":database});   
                  }
            } 

            var formData = new FormData();
            formData.append('mode', '14');    
            formData.append('pint_mode', 0); 
            formData.append('switch', 0); 
            formData.append('r_code', r_code); 
            formData.append('r_remarks', ''); 
            formData.append('items',  JSON.stringify(items));   
             
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);
            
            if (response.num!==0){
                  GlovalHTMLObjLoading(0,objID);
                 // alert(response.msg);
            }
           else{
            window.location.href='{{url("/overtime_approval")}}'; 
           }
 
      }
 
      $(document).ready(function() {
            Filter_History(1,0, 0); 
            RemoveClassInCheckBox('#th_checkbox');
            get_original_checkbox_list('datatablesPending'); 
      });

      

</script>
@endsection