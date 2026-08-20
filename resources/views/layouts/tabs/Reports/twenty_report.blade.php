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
       
</style>

<div class="container custom-container mt-5">
     <div id="divMsg"></div>
    
      <form  method="POST" action="{{ route('twenty_report') }}">
      @csrf
     <!--  <form  method="POST" action="{{ route('twenty_report') }}"class="row g-3"> -->
     <!-- <form id="form3"  class="row g-3"  action="{{ route('twenty_report') }}"> -->
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="text" class="form-control" name="dateFrom" id="dateFrom">  
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
                            <input type="text" class="form-control" name="dateTo" id="dateTo">  
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
            <div class="col-12">
                <div class="row">
                        <div class="col-6">
                                <label for="sigDDL" class="form-label">Select Signatory</label>
                                <select id="sigDDL" name="sigDDL" class="form-select"> 
                                    <option value="" selected>Choose...</option>
                                    @foreach($signatories['rows'] as $rows)
                                    <option value="{{$rows->signatoriesCode}}">{{$rows->signatoriesName}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-6">
                        <br>   
                             <!--  <input type="submit" name="btn1" id="btn1" class="btn btn-primary" onclick="return View2307Report()" value="Submit"> -->
                               <button name="btn1" id="btn1" class="btn btn-primary" onclick="return View2307Report()">Submit</button>
                        </div> 
                </div>
            </div>
        </form>
    </div>

 

<script>

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

        function View2307Report(){
           var dateFrom = document.getElementById('dateFrom').value;
           var dateTo = document.getElementById('dateTo').value;
           var sigDDL = document.getElementById('sigDDL').value;
           var divMsg = document.getElementById('divMsg');

           if (dateFrom==""){
            divMsg.innerHTML = "<div class='alert alert-danger'>Please enter date from</div>";
            return false;
           }


           if (dateTo==""){
            divMsg.innerHTML = "<div class='alert alert-danger'>Please enter date to</div>";
            return false;
           }

          /*  if (sigDDL==""){
            divMsg.innerHTML = "<div class='alert alert-danger'>Please select Segnatory</div>";
            return false;
           } */
       
      }


      function OpenNewTab(this_url, id) {    
      
    var formData = new FormData();
    formData.append('id', id);  // Append the 'id' passed to the function
    formData.append('url', this_url);  // Append the 'id' passed to the function
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    $.ajax({
        url: this_url,  
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {  
            console.log(response);
            //eval(response);
           /*  var newTab = window.open(this_url, '_blank');
            if (newTab) { 
                console.log("New tab opened successfully.");
            } */
        },
        error: function(xhr, status, error) { 
            console.error('Error:', error);
        }
    });
}


</script>
@endsection