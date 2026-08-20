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
            <form  method="POST" action="{{ route('bir_form_2316') }}">
            @csrf
            <div class="col-12">
                <div class="row">
                        <div class="col-6">
                              <label for="txtTaxYear" class="form-label">Tax Year</label>
                              <input type="number" class="form-control" id="txtTaxYear" name="txtTaxYear">  
                        </div> 
                        <div class="col-6">
                              <label for="sigDDL" class="form-label">Select Signatory</label>
                              <select id="sigDDL" name="sigDDL" class="form-select">
                              <option value="" selected>Choose...</option>
                              @foreach($signatories['rows'] as $rows)
                              <option value="{{$rows->signatoriesCode}}">{{$rows->signatoriesName}}</option>
                              @endforeach
                              </select>
                        </div> 
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6"> 
                         <!--    <input type="submit" class="btn btn-primary" value="Submit"> -->
                             <br>
                         <button name="btn1" id="btn1" class="btn btn-primary" onclick="return View2316Report()">Submit</button>
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

      function View2316Report(){
            var TaxYear = document.getElementById('txtTaxYear').value;
            var sigDDL = document.getElementById('sigDDL').value;

            if(TaxYear==""){
                  divMsg.innerHTML = "<div class='alert alert-danger'>Please enter Tax Year</div>";
                  return false;
            }

            /* if(sigDDL==""){
                  divMsg.innerHTML = "<div class='alert alert-danger'>Please select signatory</div>";
                  return false;
            } */
      }
</script>
@endsection