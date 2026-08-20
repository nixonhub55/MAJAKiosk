@extends('layouts.admin') <!-- main layout file -->

@section('content')  
<style>
      .pallete{ 
       /*  padding: 50px; */
        text-align: center;
        box-shadow: 4px 4px 10px rgba(80, 80, 80, 0.3);
        border-radius: 5px;
        color: #fff; 
      }

      .pallete pallete_name{
        /* font-weight: bold; */ 
        font-size: 15px;
      }



      .pallete pallete_amount{
        font-size: 30px;
      }
 

      
      .c1{  background-color: #284d77; }
      .c2{  background-color: #2d7a70; }
      .c3{  background-color: #5e0329; }
      .c4{  background-color: #635d0d; }
      .c5{  background-color: #06106e; }
</style>
<?php 
      $df = date('Y-m-d', strtotime("-1 Month")); 
      $dt = date('Y-m-d');  
?>
 <div id="divExec"></div>
  
<div class="container-fluid mt-4 card-container"> 
     <div class="row">
        <h5>My Compensation & Benefits</h5>
     </div> 

     <div class="row mb-3"> 

        <div class="col-md-4 ">
            <div class="c1 text-white p-5 pallete">
                <pallete_name>Total Monthly Compensation</pallete_name> <br>
                <pallete_amount>1,000.00</pallete_amount>
            </div>
        </div> 

        <div class="col-md-4 ">
            <div class="c2 text-white p-5 pallete">
                <pallete_name>Allowance (Monthly)</pallete_name> <br>
                <pallete_amount>1,000.00</pallete_amount>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="c3 text-white p-5 pallete">
                <pallete_name>Active Benefits</pallete_name> <br>
                <pallete_amount>1,000.00</pallete_amount>
            </div>
        </div>  
        
     </div>

     <div class="row mb-3"> 

        <div class="col-md-4 ">
            <div class="c1 text-white p-5 pallete">
                <pallete_name>Total Monthly Compensation</pallete_name> <br>
                <pallete_amount>1,000.00</pallete_amount>
            </div>
        </div> 

        <div class="col-md-4 ">
            <div class="c5 text-white p-5 pallete">
                <pallete_name>Loan Outstanding</pallete_name> <br>
                <pallete_amount>1,000.00</pallete_amount>
            </div>
        </div> 
        
     </div>
  
     <!-- <div class="col-md-4 pallete c1">
            <pallete_name>Total Monthly Compensation</pallete_name> <br>
            <pallete_amount>1,000.00</pallete_amount>
        </div>

        <div class="col-md-4 pallete c1">
            <pallete_name>Total Monthly Compensation</pallete_name> <br>
            <pallete_amount>1,000.00</pallete_amount>
        </div> -->

    <!-- 
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

        
        <div class="modal fade" id="taModal" tabindex="-1" aria-labelledby="LeaveModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="LeaveModalLabel">Time Adjustment Application</h5>
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
                                            <th>App Date</th>    
                                            <th>Time Adjustment Date</th> 
                                            <th>Time Adjustment</th>
                                            <th>Type</th>
                                            <th>Reason</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody> 
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
                                        </div> 
                                        <div class="col-md-4 d-flex justify-content-end align-items-center"> 
                                        <button class="btn btn-primary" id="btnFilter" onclick="Filter_HistoryRequester(0,this.id,2)">
                                            <i class="fas fa-filter"></i><b> Filter</b></button>
                                        </div> 
                                </div> 
                            </div> 
                            <br> 
                            <div id="divTbl"></div> 
                    </div>
                </div>
                
        </div>
     -->

</div>

 
@endsection