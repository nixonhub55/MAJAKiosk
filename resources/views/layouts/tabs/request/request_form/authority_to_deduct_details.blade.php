<?php
        //   echo json_encode($companyName);
    // return;
?>
<script src="{{ asset('admin/js/confirm.js')}}"></script>
    <style>
        .containers {
            max-width: 100%;
            /* margin-top: 100px; */
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            max-width: 100px;
        }

        .form-info {
            text-align: center;
            margin: 0px;
        }

        .employee-info,
        .deduction-details {
            margin-top: 0px;
        }

        .no-padding {
            padding: 0px;
            margin: 0px;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }

        .employee-info p,
        .deduction-details p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        strong {
            font-weight: bold;
        }

        button.mbtn {
            padding: 0.6em 2em;
            border-radius: 1px;
            color: #000000;
            background-color: #1976d2;
            font-size: 1.1em;
            border: 0;
            cursor: pointer;
            margin: 1em;
        }


        button.mbtn.black {
            background-color: white;
            border: 1px solid #003F5C;
        }

        button.mbtn.black:hover {
            background-color: #003F5C;
            color: white;
        }
    </style>

    <style>
        /* input[type="file"] {
      display: none;
    } */
        .round_box {
            border-radius: 25px;
            border: 2px solid #D6D6D6;
            padding: 20px;
        }

        .selectWrapper {
            border-radius: 36px;
            display: block;
            overflow: hidden;
            /*background:#cccccc;*/
            border: 2px solid #D6D6D6;
        }

        .dz-message {
            text-align: center;
            font-size: 20px;
        }

        .dropzone .dz-init {
            background: transparent !important;
            border: none !important;
            margin: 50px;
            /* height: 100px; */
        }

        .dz-details {
            z-index: 0;
        }

        .dz-preview .dz-remove.dz-remove {
            z-index: 100;
        }

        /* #yourBtn {
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
                } */

        .error {
            background-color: red;
            /* color: white; */
        }

/* MODAL CONTAINER */
.modal-container {
    position: fixed;
    inset: 0; /* Shorthand for top, left, bottom, right: 0 */
    z-index: 1050;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

/* BACKDROP - Added a slight blur for a modern feel */
.modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.6); /* Deeper, more modern blue-grey */
    backdrop-filter: blur(4px);
    z-index: 1040;
}

/* MODAL BOX */
.modal-box {
    position: relative;
    z-index: 1060;
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 16px; /* Rounder corners */
    width: 100%;
    max-width: 380px;
    text-align: center;
    /* Soft, layered shadow for depth */
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Typography Enhancements */
.modal-box h4 {
    font-family: 'Inter', sans-serif; /* Recommended font */
    color: #1e293b;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.5;
    margin: 0;
}

/* ICON STYLING */
.icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 24px;
}

.success-icon {
    background-color: #ecfdf5;
    color: #10b981;
}

.error-icon {
    background-color: #fef2f2;
    color: #ef4444;
}

/* BUTTONS */
.modal-btn {
    margin-top: 32px;
    width: 100%; /* Full width looks better on mobile-ish modals */
    padding: 12px 24px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

/* Success Button */
#success_message .modal-btn {
    background-color: #10b981;
    color: white;
}

/* Error Button */
#error_message .modal-btn {
    background-color: #ef4444;
    color: white;
}

.modal-btn:hover {
    filter: brightness(0.9);
    transform: translateY(-1px);
}

/* ANIMATION - A "pop" instead of a slide */
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
    </style>
    </head>
    <div class="containers">
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
        <header>
            <table style="margin-bottom:0px">
                <tr>
                    <td>
                        <img class="htlogo" src="{{ asset('admin/images/htlogo.png') }}" alt="Company Name">
                    </td>
                    <td style="text-align:center">
                        <h1>Authority to Deduct</h1>
                    </td>
                    <td class="no-padding">
                        <table style="margin-bottom: 0px; padding: 0px">
                            <tr>
                               <td><b>Form No:</b> {{ $atdDetails[0]->formNo }}</td>
                            </tr>
                            <tr>
                                <td><b>Version No:</b>  {{ $atdDetails[0]->versionNo }} </td>
                            </tr>
                            <tr>
                                <td><b>For Internal Use Only</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </header>
        <section class="employee-info">
            <div class="col-xs-12 no-padding">
                <div class="col-xs-6 no-padding">
                    <table>
                        <tr>
                            <td><strong>ID #:</strong></td>
                            <td><?= $atdDetails[0]->identityId?></td>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td><?= $atdDetails[0]->lastName?>, <?= $atdDetails[0]->firstName?> <?= $atdDetails[0]->middleName?></td>
                        </tr>
                        <tr>
                            <td><strong>Date Hired:</strong></td>
                            <td><?= $atdDetails[0]->dateHired?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-6 no-padding">
                    <table>
                        <tr>
                            <td><strong>Position:</strong></td>
                            <td><?= $atdDetails[0]->positionName?></td>
                        </tr>
                        <tr>
                        <td><strong>Date Prepared:</strong></td>
                            <?php
                            $date = $atdDetails[0]->dateCreated; 
                            $dateObject = new DateTime($date); 
                            $timestring = $dateObject->format('Y-m-d'); 
                            ?>
                            <td><?= $timestring ?></td>

                        </tr>
                        <tr>
                            <td><strong>Effectivity Date:</strong></td>
                            <?php
                            $dates = $atdDetails[0]->effectiveDate; 
                            $dateObjects = new DateTime($date); 
                            $timestrings = $dateObjects->format('Y-m-d'); 
                            ?>
                            <td><?= $timestrings ?></td>
                         
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <section class="deduction-details">
            <p>This is to authorize <strong> {{ $companyName[0]->companyName }}</strong> to make the following salary deduction from my payroll:</p>
            <table>
                <tr>
                    <th style="background-color: #003F5C; color: white;">Category</th>
                    <th style="background-color: #003F5C; color: white;">Details</th>
                </tr>
                <tr>
                    <td>Purpose for Deduction</td>
                    <td><?= $atdDetails[0]->purpose?></td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td><?= $atdDetails[0]->departmentName?></td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <?php 
                    $totalAmountNumber = $atdDetails[0]->totalAmount;
                    $totalAmount = "Php " . number_format($totalAmountNumber, 2, '.', ',');
                    $contractType = ' ('.$atdDetails[0]->contractType.')';
                    ?>
                    <td><?= $totalAmount . $contractType ?></td>

                </tr>
                <tr>
                    <td>Amount to be deducted per month</td>
                 
                    <?php
                        $number = $atdDetails[0]->amountDeductedPerMonth;
                        $formattedNumber = "Php " . number_format($number, 2, '.', ',');
                        // echo "The price is " . $formattedNumber;
                    ?>

                   
                    <td><?=$formattedNumber;?></td>
                </tr>
                <tr>
                    <td>Amount to be deducted per payroll</td>
                    <?php 
                    $perPayroll = $atdDetails[0]->amountDeductedPerPayroll;
                    $payrollAmount = "Php " . number_format($perPayroll, 2, '.', ',');
                    ?>
                    <!-- <td>Php 1,250.00 every 15<sup>th</sup> payroll and<br>Php 1,250.00 every 30<sup>th</sup>/31<sup>st</sup> payroll</td> -->
                    <td><?=$payrollAmount?></td>
                </tr>
                <tr>
                    <td>Start Date of Deduction</td>
                    <?php 

                    $startDate = $atdDetails[0]->effectiveDate; 
                    $startDateObj = new DateTime($startDate); 
                    $startDateString = $startDateObj->format('Y-m-d'); 
                    ?>
                    <td><?= $startDateString ?></td>
                  
                   
                </tr>
                <tr>
                    <td>Last Date of Deduction</td>
                    <?php 
                    $lastDate = $atdDetails[0]->lastDateofDeduction; 
                    $lastDateObj = new DateTime($lastDate); 
                    $lastDateString = $lastDateObj->format('Y-m-d'); 
                    ?>
                    <td><?= $lastDateString ?></td>
                </tr>
                <tr>
                    <td>Important Agreement/Instruction</td>
                    <td>
                        

                        <p><?= $atdDetails[0]->agreement ?></p>

                        
                    </td>
                </tr>
            </table>
        </section>

        <?php if ($atdDetails[0]->isAcknowledge == null){  ?>
            
        <div class="input-group">
            <span class="input-group-addon">
                <input type="checkbox" aria-label="..." value="I Acknowledged" id="acknowledge">  I Acknowledged</input>
            </span>
        </div>

        <button  type="button"class="mbtn black" style="padding: 10px 50px;" onclick="confirm_submit(); return false;">Confirm</button>
        <button  type="button"class="mbtn black" style="padding: 10px 50px;" onclick="confirm_decline(); return false;">Decline</button>
    
            
        <?php }?>

    </div>


<script>
var formNo = '{{ $atdDetails[0]->formNo }}';
var identityId = '{{ $atdDetails[0]->identityId }}';
var appNo = '{{ $atdDetails[0]->appNo }}';

function confirm_decline(){
    window.scrollTo(0, 0);
    fbconfirm('Confirm Decline', 'Do you want to decline the ATD form?', 'Yes', 'Cancel', 'decline()');
}

function decline(){
    $.ajax({
        url: '{{ route('update_atd_decline') }}', 
        type: "POST",
        cache: false,
        data: {
            _token: '{{ csrf_token() }}',
            formNo: formNo,
            identityId: identityId
        },
        success: function(data) {                
            $('#btn_submit').prop('disabled', true);
            $('#success_message_text').text("ATD Form successfully declined");
            $('#success_message').show();
        },
        error: function(ts) {                
            $('#btn_submit').prop('disabled', true);
            $('#error_message_text').text("Error occurred");
            $('#error_message').show();
        }
    });  
}

function closeSuccessMessage(){
    $('#success_message').hide();
    setTimeout(function() {
        location.href = '{{ route('authority_to_deduct') }}';
    }, 500);
}

function closeErrorMessage() {
    $('#error_message').hide();
}
</script>

<script>
    function confirm_submit(){
            //validation
            if (!document.getElementById('acknowledge').checked) {
                $('#btn_submit').prop('disabled', true);
                $('#error_message_text').text("Please Acknowledge the form");
                $('#error_message').show();

                // Change the modal box to error style
                $('#message_box').removeClass('success').addClass('error');
                
                // Remove the icon
                // $('#message_icon').hide();

                return false;
            }


            //back to top
            window.scrollTo(0, 0);
            fbconfirm('Confirm Submit', 'Do you want to continue submitting this form? ', 'Yes', 'Cancel', 'submit()');
        }

    function submit(){
    $.ajax({
        url: '{{ route('update_atd_acknowledge') }}',
        type: "POST",
        cache: false,
        data: {
              _token: '{{ csrf_token() }}',
            formNo: formNo,
            identityId: identityId
        },
        success: function(data){

            $.ajax({
                url: '{{ route('add_employee_deduction') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    appNo: appNo,
                    identityId: identityId
                },
                success: function(data){
                    $('#btn_submit').prop('disabled', true);
                    $('#success_message_text').text("ATD Form successfully Acknowledged");
                    $('#success_message').show();
                },
                error: function(){
                    $('#btn_submit').prop('disabled', true);
                    $('#error_message_text').text("Error occurred in employee deduction insert");
                    $('#error_message').show();
                }
            });

        },
        error: function(){
            $('#btn_submit').prop('disabled', true);
            $('#error_message_text').text("Error occurred in acknowledge");
            $('#error_message').show();
        }
    });
}
</script>