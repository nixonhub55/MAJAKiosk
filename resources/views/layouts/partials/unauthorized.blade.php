@extends('layouts.admin') <!-- main layout file -->

@section('content')   

  <br><br><br>
<div class="container">
    <center>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="restricted-message">
          <h1><i class="fas fa-lock lock-icon"></i></h1>
          <h3>User Access Restricted</h3>
          <p>Your account does not have permission to use this module.</p>
        </div>
      </div>
    </div>
    </center>
  </div>

@endsection