@extends('layouts.admin') <!-- main layout file -->

@section('content')   


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>



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
        

      .modal {
      /* display: flex; */
      align-items: center;
      justify-content: center; 
      position: fixed;
      top: 0;
      left: 0; 
      width: 100vw;
      height: 100vh; 
      background-color: rgba(0, 0, 0, 0.5); /* optional backdrop */
      z-index: 9999;
      }

      .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 100%;
      max-width: 400px; /* adjust as needed */
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      }
            
</style> 
  
 
 
<?php 
      $mode = session()->get('modal')
?>

<form method="POST" action="{{ route('payslip_record') }}">
    @csrf
    <div id="modal_enterpass" class="modal">
        <div class="modal-content" id="modal-content"></div>
    </div>
</form>

 
<div class="container custom-container mt-5">
      <div class="row g-3"> 
           

            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="text" class="form-control" id="dateFrom" onchange="return SelectDate(0)">    
                    </div>
                    <script>
                            $(document).ready(function () {
                                var disabledArr = [];

                                $('#dateFrom').datepicker({
                                        dateFormat: "yy-mm-dd",
                                        beforeShowDay: function (date) {
                                            for (var i = 0; i < disabledArr.length; i++) {

                                                    var From = disabledArr[i].from.split("/");
                                                    var To = disabledArr[i].to.split("/");
                                                    var FromDate = new Date(From[2], From[1] - 1, From[0]);
                                                    var ToDate = new Date(To[2], To[1] - 1, To[0]);


                                                    if (date >= FromDate && date <= ToDate) {
                                                        return [false, "red"];
                                                    }
                                            }
                                            return [true, ""];
                                        },
                                });
                            });
                    </script>

                    <div class="col-6">
                            <label for="dateTo" class="form-label">Date To</label>
                            <input type="text" class="form-control" id="dateTo"  onchange="return SelectDate(0)">  
                    </div>
                    <script>
                            $(document).ready(function () {
                                var disabledArr = [];

                                $('#dateTo').datepicker({
                                        dateFormat: "yy-mm-dd",
                                        beforeShowDay: function (date) {
                                            for (var i = 0; i < disabledArr.length; i++) {

                                                    var From = disabledArr[i].from.split("/");
                                                    var To = disabledArr[i].to.split("/");
                                                    var FromDate = new Date(From[2], From[1] - 1, From[0]);
                                                    var ToDate = new Date(To[2], To[1] - 1, To[0]);


                                                    if (date >= FromDate && date <= ToDate) {
                                                        return [false, "red"];
                                                    }
                                            }
                                            return [true, ""];
                                        },
                                });
                            });
                    </script>
                </div>
            </div>
        </div>
      </div> 


    <!-- ================ -->
     <!-- Overtime approval content here -->
<!-- <?=json_encode($emp_payslip_record)?> -->
<div class="container-fluid mt-4 card-container">  
      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                  <div class="table-container">
                        <table class="table data-table" id="datatablesPending">
                              <thead>
                                    <tr> 
                                          <th>#</th> 
                                          <th>From</th> 
                                          <th>To</th>
                                          <th>Payroll Date</th> 
                                    </tr>
                              </thead> 
                              <tbody id="tbdRpt">
                              @foreach($emp_payslip_record['rows'] as $row)   
                               <tr   onclick="return EnterPass_Modal('30%','{{$row->code}}')">      
                                    <td>{{$row->code}}</td>
                                    <td>{{$row->payrollPeriodFrom}}</td>
                                    <td>{{$row->payrollPeriodTo}}</td>
                                    <td>{{$row->payrollPeriodPayDate}}</td>
                              </tr>
                              @endforeach
                              </tbody>
                        </table>
                  </div>
            </div>
            
      </div>
</div>
 

<script>
      var this_code;
      var div = document.querySelector('.modal-content');  
     
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

      function ReEnterPassword(php_page,thisDiv){    
             LoadPageIntoDiv(php_page,thisDiv);
      } 
       
      
      function ShowThisModal(code){  
            var jsonData = {
                  mode: '1',
                  code: code
                  };
            ShowModal('modalContent','myModal','Enter password',jsonData);
      }
      

function ShowModal(modalContent,myModal,ModalTitle,jsonData){  
      $.ajax({
      url: '{{ route("modal.show", ["param" => "__PARAM__"]) }}'.replace("__PARAM__", encodeURIComponent(JSON.stringify(jsonData))),
      type: 'GET',
      success: function(response) { 
            $('#'+modalContent+'').html(response); 
            $('#'+myModal+'').modal('show');
            document.getElementById('myModalLabel').innerHTML=ModalTitle; 
      }
      });
}
 

function LoadThisPage(php_page,thisDiv){ 
      var xhr = new XMLHttpRequest();
      xhr.open('GET', php_page, true);
      xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(thisDiv).innerHTML = xhr.responseText;   
      }
      };
      xhr.send();
}
 
function EnterPass_Modal(this_width,code){ 
  
      this.this_code = code;
      var modal = document.getElementById("modal_enterpass");
      div.style.maxWidth = this_width; 
      var jsonData = {
                  mode: '1',
                  code: code
                  };  
      LoadThisPage('{{ route("modal.show", ["param" => "__PARAM__"]) }}'.replace("__PARAM__", encodeURIComponent(JSON.stringify(jsonData))),'modal-content');   
      //modal.style.display = "block"; 
      modal.style.display = "flex";  
} 
  
      var this_modal = '<?php echo session()->get('modal')?>'; 
        
      if(this_modal=="true"){   
            this.this_code  = '<?php echo session()->get('code')?>';
            var modal = document.getElementById("modal_enterpass"); 
            var jsonData = {
                        mode: '1',
                        code: this_code
                        };  
            LoadThisPage('{{ route("modal.show", ["param" => "__PARAM__"]) }}'.replace("__PARAM__", encodeURIComponent(JSON.stringify(jsonData))),'modal-content');   
            //modal.style.display = "block"; 
            modal.style.display = "flex"; 
   } 
</script>
@endsection