@extends('layouts.admin')

@section('content')
<style>


      .card-container {
            background-color: #fff; 
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 90px;
      }

      .header {
            text-align: center;
            margin-bottom: 20px;
      }

      .logo {
            width: 350px;
            height: auto;
            margin-bottom: 10px;
      }

      h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
      }

      table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
      }

      th,
      td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
      }

      .info-table td {
            border: 1px solid #999;
            height: 28px;
      }

      .certify {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
            background-color: #eef2f6;
            padding: 8px;
      }

      .signatory-table th {
            background-color: #444;
            color: #fff;
            text-align: center;
      }

      .signatory-table td {
            height: 32px;
      }
      .modal-header {
            background: #f8f9fa;
      }

      .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1055;
      }

      .modal-backdrop {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
      }

      .modal-box {
            position: relative;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            width: 350px;
            z-index: 1060;
      }

      .error-box {
            border-top: 5px solid red;
      }

      .success-icon {
            color: green;
            font-size: 30px;
      }

      .error-icon {
            color: red;
            font-size: 30px;
      }

      .modal-btn {
            margin-top: 15px;
      }
</style>

<!-- SUCCESS MODAL -->
      <div id="success_message" class="modal-container" style="display: none;">
            <div class="modal-backdrop"></div>
            <div class="modal-box">
                  <div class="icon success-icon">
                        <span class="glyphicon glyphicon-ok"></span>
                  </div>
                  <h4 id="success_message_text">SYSTEM MESSAGE WILL PASS HERE.</h4>
                  <button type="button" class="btn modal-btn" onclick="closeSuccessMessage()">Ok</button>
            </div>
      </div>

      <!-- ERROR MODAL -->
      <div id="error_message" class="modal-container" style="display: none;">
            <div class="modal-backdrop"></div>
            <div class="modal-box error-box" id="message_box">
                  <div class="icon error-icon">
                        <span class="glyphicon glyphicon-remove" id="message_icon_span"></span>
                  </div>
                  <h4 id="error_message_text">SYSTEM MESSAGE WILL PASS HERE.</h4>
                  <button type="button" class="btn modal-btn" onclick="closeErrorMessage()">Ok</button>
            </div>
      </div>
<?php

    $compySettings = session()->get('companyPasswordSettings');
    $compyLogo = $compySettings['companyLogoBlob'];
    $compyName = $compySettings['companyName'];

//     echo json_encode($tin);
//     return;


?>

                    <?php

             
                  //   $allAcknowledged = true; 

                  //   foreach ($clearanceF_request as $request) {
                  //       if ($request['cfAcknowledgeTag'] != 'YES') {
                  //           $allAcknowledged = false;
                  //           break; 
                  //       }
                  //   }


                  
if ($isAcknowledge) {
                      
                  
                    ?>

<div class="container-fluid mt-4 card-container">
      <div class="header">
            <img src="<?=$compyLogo?>" alt="Company Logo" class="logo">
            <h2><b>EMPLOYEE CLEARANCE FORM</b></h2>
      </div>
        <h2><b>TIN: <?php echo $tin[0]->tinNo ?> </b></h2>
      <table class="info-table">

            @php 
            $count = 0; 
            $headerValues = $headerData[0] ?? null; // get the first object
            @endphp

            @if($headerValues)
            <tr>
            @foreach($headers as $header)
                  @php 
                        $key = strtoupper($header->itemName ?? ''); 
                        $value = $headerValues->$key ?? ''; 
                  @endphp
                  <td>
                        <strong>{{ $key }}:</strong> {{ $value }}
                  </td>

                  @php $count++; @endphp
                  @if($count % 3 == 0)
                        </tr><tr>
                  @endif
            @endforeach
            </tr>
            @endif



      </table>


      <div class="certify">
            This is to certify that the above mentioned employee has been cleared of all the accountabilities
            with <?=$compyName?>, Inc. as of the date the clearance was signed by all signatories.
      </div>

      <table class="signatory-table">
            <thead>
                  <tr>
                        <th>DIVISION/DEPARTMENT</th>
                        <th>NAME</th>
                        <th>SIGNATURE</th>
                        <th>DATE SIGNED</th>
                        <th>REMARKS</th>
                        <th>ITEMS</th>
                  </tr>
            </thead>
            <tbody>
                 @foreach($list as $item)
            <tr>
                  <td >{{ $item->departmentName ?? '' }}</td>
                  <td >{{ $item->cfApproverName ?? '' }}</td>
                  <td style="text-align:center;">
                        @if($item->cfStatus == 'A')
                              <span style="color:green;">Approved</span>
                        @elseif($item->cfStatus == 'D')
                              <span style="color:gray;">Declined</span>
                        @else
                              <span style="color:red;">Pending</span>
                        @endif
                  </td>                  
                  <td style="text-align:center;">{{ $item->cfApprovedDateTime ?? '' }}</td>
                  <td style="text-align:center;">{{ $item->cfRemarks ?? '' }}</td>
                  <td style="text-align:center;">{{ $item->cfClearanceItems ?? '' }}</td>
            </tr>
        @endforeach
            </tbody>
      </table>
</div>

<?php

} else {
        // Not all rows are acknowledged
      ?>
      <div class="container mt-5 mb-5">

      <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                  <h4 class="mb-0">Employee Clearance Acknowledgement</h4>
            </div>

            <div class="card-body p-4">

                  <p class="text-justify" style="line-height:1.8;">
                  I hereby acknowledged that my final pay and other benefits that may be due me for the
                  services which I have rendered shall only be computed after all the Departments have
                  cleared me for any accountability, I may have in relation to my Employment with
                  <strong>{{ session()->get('companyName') }}</strong>.
                  </p>

                  <p style="line-height:1.8;">
                  It is noted from my end that a thirty (30) days preparation from the date of clearance
                  completion must be observed in order for HR to process and release my final pay.
                  </p>

                  <p style="line-height:1.8;">
                  A copy of payslip with final pay breakdown shall be provided by HR and I shall only
                  receive my final pay upon submission of duly notarized and signed
                  <strong>Waiver, Release & Quit Claim</strong> along with two (2) valid Government issued IDs.
                  </p>

                  <p style="line-height:1.8;">
                  It is understood that I must acknowledge the receipt of final pay electronically which
                  will be made thru bank crediting. After which, I shall receive the digital/printed copies
                  of my <strong>Certificate of Employment</strong> and
                  <strong>BIR Form 2316 (Certificate of Compensation Payment/Tax Withheld)</strong>.
                  </p>

                  <hr>

                  <div class="text-center mt-4">
                        <div class="form-check d-inline-flex align-items-center">
                              <input class="form-check-input me-2" type="checkbox" value="YES" id="acknowledge">
                              <label class="form-check-label fw-bold mb-0" for="acknowledge">
                                    I Acknowledge
                              </label>
                        </div>
                  </div>

                  <div class="text-center mt-4">
                  <button id="submit" class="btn btn-success px-4" onclick="submit()">
                        Submit
                  </button>
                  </div>

            </div>

      </div>

      </div>

            <?php } ?>



      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

      <script>

            function submit() {
                  if(!$('#acknowledge').is(':checked')){
                        $('#error_message_text').text("Please check 'I Acknowledge' before submitting.");
                        $('#error_message').fadeIn();
                        return;
                  }
                  $.ajax({
                        url: '{{ route('clearance_acknowledge') }}',
                        type: "POST",
                        cache: false,
                        data: {
                              _token: '{{ csrf_token() }}',
                        },
                        success: function (data) {

                              $('#submit').prop('disabled', true);

                              $('#success_message_text')
                              .text("Clearance form successfully acknowledged");

                              $('#success_message').show();

                        },
                        error: function () {

                              $('#submit').prop('disabled', true);

                              $('#error_message_text')
                              .text("Error occurred");

                              $('#error_message').show();

                        }
                  });

            }





            function closeSuccessMessage() {
                  $('#success_message').hide();
                  setTimeout(function () {
                        location.href = '{{ route('clearance') }}';
                  }, 500);
            }

            function closeErrorMessage() {
                  $('#error_message').hide();
            }
      </script>

      
@endsection

