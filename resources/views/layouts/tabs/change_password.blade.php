@extends('layouts.admin') <!-- main layout file -->

@section('content') 
<style>
      .bg-custom {
            background-color: #003f5c;
            color: #ffffff;
      }

      .mt-4 {
            padding: 20px;
      }

      .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
            background-color: #ffffff;
            overflow: hidden;
      }

      /* .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    } */

      .card-header {
            font-weight: bold;
            font-size: 1.5rem;
            background-color: #007bff;
            color: white;
            padding: 15px;
      }

      .card-body {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            padding: 20px;

      }

      .get-details {
            text-align: left;
            text-decoration: none;
            color: #003f5c;
      }

      .get-details:hover {
            text-decoration: underline;
      }

      .divider {
            width: 100%;
            height: 1px;
            background-color: #ddd;
            margin: 15px 0;
      }


      .card-container {
            margin-top: 20px;
            justify-content: space-around;
            flex-wrap: wrap;
      }

      .card-content {
            display: flex;
            align-items: center;
            /* justify-content: space-between; */
            padding: 10px 15px;
            background: #fff;
            position: relative;
      }

      .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 75px;
            height: 75px;
            border-radius: 5px;
            font-size: 35px;
            margin-right: 15px;
      }

      .card-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
      }

      .card-title {
            font-size: 1.2rem;
            margin: 0;
            color: #333;
            font-weight: bold;
      }

      .details-link {
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
            margin-top: 4px;
      }

      .details-link:hover {
            text-decoration: underline;
      }

      .card-count {
            font-size: 2.5rem;
            font-weight: bold;
            color: #666;
            margin: 0;
            text-align: right;
            color: red;
      }

      .card-count-zero {
            font-size: 2.5rem;
            font-weight: bold;
            color: #666;
            margin: 0;
            text-align: right;

      }

      h4 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.75rem;
            font-weight: bold;
            display: flex;
            align-items: center;
      }

      h4 i {
            margin-right: 10px;
            color: black;
      }

      @media (max-width: 768px) {
            .card-content {
                  flex-direction: row;

                  flex-wrap: wrap;
                  align-items: center;
            }

            .icon {
                  margin-bottom: 0;
            }

            .card-info {
                  flex: 1 1 auto;
            }

            .card-count {
                  flex: 0 0 auto;
                  margin-left: auto;
            }

            .ml-3 {
                  margin-left: auto;
                  margin-top: 0;
            }
      }

      .card-header {
            background-color: #003f5c;
            color: #fff;
            font-weight: bold;
      }

      .icon.bg-custom {
            background-color: #003f5c !important;
            /* Yellow background */
      }

      .btn-group .btn {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
      }






      @keyframes fadeIn {
            0% {
                  opacity: 0;
                  transform: translateY(20px);
            }

            100% {
                  opacity: 1;
                  transform: translateY(0);
            }
      }

      /* Mobile responsiveness */
      @media (max-width: 768px) {
            .card-container {
                  flex-direction: column;
                  align-items: center;
            }

            .greeting-widget {
                  padding: 20px;
                  max-width: 100%;
            }
      }
 
      .btn-primary {
            background-color: #007bff;
            border-radius: 4px;
            border: none;
      }

      .btn-success {
            margin: 0px;
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
            margin-top: 20px;
      }

      .input-group-text {
            background-color: #f8f9fa;
      }

      .form-control {
            border-radius: 4px;
            width: 500px;

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

            .form-control {
                  border-radius: 4px;
                  width: auto;

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
 
      .dz-message {
            text-align: center;
            font-size: 20px;
      }

      .dropzone .dz-init {
            background: transparent !important;
            border: none !important;
      }

      .dz-details {
            z-index: 0;
      }

      .dz-preview .dz-remove.dz-remove {
            z-index: 100;
      }

      button.mbtn {
            padding: 0.6em 2em;
            border-radius: 25px;
            color: #fff;
            background-color: #1976d2;
            font-size: 1.1em;
            border: 0;
            cursor: pointer;
            margin: 1em;
      }

      button.mbtn.black {
            background-color: #000000;
      }

      .form-text {
            margin-left: 30px;
      }

      .form-text {
            display: block;
            margin-left: 30px;
            margin-right: 30px;
            font-style: italic;
            font-size: 90%;
      }

      .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
      }

      .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
      }

      .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
      }

      .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
      }

      input:checked + .slider {
      background-color: #2196F3;
      }

      input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
      }

      input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
      border-radius: 34px;
      }

      .slider.round:before {
      border-radius: 50%;
      }

      .modalCamera{
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99999; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */ 
            background-color: rgba(0,0,0,0.2); /* Black w/ opacity */
      }

      .modalCamera-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
      }
      
</style> 
<?php

      $user_details = $user_details['rows'][0]; 
      $faceDetails =  $user_details->faceDetails;
      $if_approver=session()->get('if_approver');  

?>

<div  class="container-fluid mt-4 card-container">
      <div  class="row">
            <div  class="col-md-12 col-lg-12 mb-4">
                  <div  class="card shadow-sm"> 
                         <div  class="card-body" style="overflow: scroll;">
                              <h4>Basic Information</h4>
                              <table class="table table-striped">
                                    <thead  class="bg-dark text-white">
                                          <tr>
                                               <th>Date Hired</th>
                                               <th>Identity Id</th>
                                               <th>First name</th>
                                               <th>Middle name</th>
                                               <th>Last name</th>
                                               <th>Suffix</th> 
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <tr>
                                                <td>{{$user_details->dateHired}}</td>
                                                <td>{{$user_details->identityid}}</td>
                                                <td>{{$user_details->firstName}}</td>
                                                <td>{{$user_details->middleName}}</td>
                                                <td>{{$user_details->lastName}}</td>
                                                <td>{{$user_details->suffix}}</td>
                                          </tr>
                                    </tbody>
                              </table>

                              <hr> 

                              <h4>Contact/Address</h4>
                              <table class="table table-striped">
                                    <thead  class="bg-dark text-white">
                                          <tr>
                                               <th>Contact No.</th>
                                               <th>Email Address</th>
                                               <th>Barangay</th>
                                               <th>Street</th>
                                               <th>City/Province</th> 
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <tr>
                                                <td>{{$user_details->contactNo}}</td>
                                                <td>{{$user_details->emailAddress}}</td>
                                                <td>{{$user_details->barangay}}</td>
                                                <td>{{$user_details->street}}</td>
                                                <td>{{$user_details->city}}  {{$user_details->province}}</td>
                                          </tr>
                                    </tbody>
                              </table>
                        </div>
                  </div>
            </div>
      </div>
</div> 

<div class="container-fluid mt-4 card-container">
      <div class="row">
            <div class="col-md-12 col-lg-12 mb-4">
                  <div class="card shadow-sm">
                        <div class="card-body">
                        @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                          <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                          </ul>
                                    </div>
                                    @endif 
                              <h2>Change password</h2>
                              <div class="card-content">
                                    
                              
                                   
                                    <form method="POST" action="">
                                          @csrf
                                          <div class="mb-3">
                                               <!--  <label for="currentPassword" class="form-label">Current Password</label>
                                                <input type="password" class="form-control" id="currentPassword"
                                                      name="currentPassword" value="" autocomplete="off"> -->
                                                   
                                                <label for="password1" class="form-label">Current Password</label>
                                                <div class="input-group">
                                                      <input type="password" class="form-control password-field" id="currentPassword"  name="currentPassword" value="" autocomplete="off">
                                                      <button class="btn btn-outline-secondary toggle-password" type="button">Show</button>
                                                </div>
                                                

                                          </div>
                                          <div class="mb-3">
                                               <!--  <label for="newPassword" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="newPassword"
                                                      name="newPassword" value="" autocomplete="off"> -->

                                                <label for="password1" class="form-label">New Password</label>
                                                <div class="input-group">
                                                      <input type="password" class="form-control password-field"  id="newPassword"
                                                      name="newPassword" value="" autocomplete="off">
                                                      <button class="btn btn-outline-secondary toggle-password" type="button">Show</button>
                                                </div>
                                                 
                                          </div>
                                          <div class="mb-3">
                                                <!-- <label for="newPassword2" class="form-label">Re-type New
                                                      Password</label>
                                                <input type="password" class="form-control" id="newPassword2"
                                                      name="newPassword2" value="" autocomplete="off"> -->

                                                      <label for="password1" class="form-label">Re-type New Password</label>
                                                <div class="input-group">
                                                      <input type="password" class="form-control password-field"  id="newPassword2"
                                                      name="newPassword2" value="" autocomplete="off">
                                                      <button class="btn btn-outline-secondary toggle-password" type="button">Show</button>
                                                </div>
                                        
                                          </div>
                                          <div class="mb-3">
                                                <br>
                                          </div>
                                          <button type="submit" class="btn btn-success" style="float:right;">Save changes</button>
                                    </form>
                                   
                              </div>  
                        </div>
                  </div>
            </div>
      </div>
</div>


<div class="container-fluid card-container">
      <div class="row">
            <div class="col-md-12 mb-4">
                  <div class="card shadow-sm">
                        <div class="card-body">
                                    @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                          <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                          </ul>
                                    </div>
                                    @endif 
                              <h2>Face Recognizer</h2>
                              <div class="card-content">
                                    
                              
                                   
                                    <form method="POST" action="">
                                          @csrf 
                                          @if($faceDetails=="")
                                                <div class="alert alert-warning" role="alert">
                                                      Your face is not registered yet. Please register . <a id="zzxxx" href="#" onclick="return loadFaceRecognizer(this.id,0)">Here</a>
                                                </div>
                                          @else
                                                <div class="alert alert-info" role="alert">
                                                      Update face Recognition <a id="zzxxx" href="#" onclick="return loadFaceRecognizer(this.id,0)">Here</a>
                                                </div>
                                          @endif
                                          <div class="modalCamera" id="divScanner">
                                               <!--  <div class="modalCamera-content">xxxxxxxxxxx</div> -->
                                          </div>
                                    </form>
                                   
                              </div>  
                        </div>
                  </div>
            </div>
      </div>
</div>  

<script>
  
  var divScanner = document.getElementById('divScanner');

  // Reusable toggle function
  document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function () {
      const input = this.previousElementSibling;
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.textContent = type === 'password' ? 'Show' : 'Hide';
    });
  });

  async function loadFaceRecognizer(id,mode) {  
      divScanner.style.display = "block";
      var formData = new FormData(); 
      formData.append('mode', mode);     
      //  GlovalHTMLObjLoading(1, 'divEmployeeLogs');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/gotoFaceRecognizer")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#divScanner').html(`<center>`+response+`</center>`);
            },
            error: function (msg) {
                  //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }

        });

  }

 // loadFaceRecognizer(1);

</script>

@endsection