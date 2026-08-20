@extends('layouts.admin') <!-- main layout file -->

@section('content')   
<div class="container-fluid mt-4 card-container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab"
                        aria-controls="pending" aria-selected="true">Details</a>
            </li>
            <li class="nav-item" role="presentation">
                  <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab"
                        aria-controls="history" aria-selected="false">Payroll</a>
            </li>
      </ul>

      <!-- <div class="tab-content" id="myTabContent">
            test
      </div> -->

 </div>
@endsection


