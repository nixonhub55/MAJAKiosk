@extends('layouts.admin')

@section('content')
    <style>
        .profile-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card-custom {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
            border: 1px solid black;
        }

        /* Image Styling */
        .image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #f8fafc;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hover Upload Effect */
        .edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-container:hover .edit-overlay {
            opacity: 1;
        }

        /* Signature Styling */
        .signature-display {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fdfdfd;
            margin-top: 10px;
            position: relative;
        }

        .signature-placeholder {
            color: #94a3b8;
            font-size: 0.85rem;
            font-style: italic;
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
    <?php
    // echo json_encode($my_profile_information);
    // return;
                                                                                                                    ?>


    <div class="container-fluid mt-4 card-container" style="margin-bottom: 80px;">
        <div class="row">
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
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- LEFT SIDE -->
                            <div class="col-md-6 mb-4">
                                <div class="row">


                                </div>
                            </div>
                        </div>
                        <!-- RIGHT SIDE -->
                        <div class="col-md-12 col-lg-9">
                            <div class="card-custom position-relative">

                                <button type="button" class="btn btn-sm btn-light position-absolute edit-btn"
                                    style="top:15px; right:15px;">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>

                                <h5 class="mb-3">My Information</h5>
                                <hr>

                                <form method="POST" action="#">
                                    @csrf

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Employee ID</strong></label>
                                            <input type="text" class="form-control" id="identity" name="identity"
                                                value="{{ $my_profile_information[0]->identityId}}" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>First Name</strong></label>
                                            <input type="text" class="form-control edit-field" id="firstName"
                                                name="firstName" value="{{ $my_profile_information[0]->firstName ?? "N/A"}}"
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Middle Name</strong></label>
                                            <input type="text" class="form-control edit-field" id="middleName"
                                                name="middleName"
                                                value="{{ $my_profile_information[0]->middleName ?? "N/AA"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Last Name</strong></label>
                                            <input type="text" class="form-control edit-field" id="lastName" name="lastName"
                                                value="{{ $my_profile_information[0]->lastName ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Suffix</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_information[0]->suffix ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label><strong>Place of Birth</strong></label>
                                            <input type="text" class="form-control  edit-field" id="birthPlace"
                                                name="birthPlace"
                                                value="{{ $my_profile_information[0]->birthPlace ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label><strong>Birth Date</strong></label>
                                            <input type="text" class="form-control" id="birthdate"
                                                name="birthdate" value="{{ $my_profile_information[0]->birthdate ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Age</strong></label>
                                            <input type="text" class="form-control edit-field" id="age" name="age"
                                                value="{{ $my_profile_information[0]->age ?? "N/A"}}" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label><strong>Present Address</strong></label>
                                            <input type="text" class="form-control edit-field" id="address" name="address"
                                                value="{{ $my_profile_information[0]->address ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label><strong>Registered Address</strong></label>
                                            <input type="text" class="form-control edit-field" id="address2" name="address2"
                                                value="{{ $my_profile_information[0]->address2 ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label><strong>Provincial Address</strong></label>
                                            <input type="text" class="form-control edit-field" id="address3" name="address3"
                                                value="{{ $my_profile_information[0]->address3 ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Citizenship</strong></label>
                                            <input type="email" class="form-control edit-field" id="citizenship"
                                                name="citizenship"
                                                value="{{ $my_profile_information[0]->citizenship ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Religion</strong></label>
                                            <input type="text" class="form-control edit-field" id="religion" name="religion"
                                                value="{{ $my_profile_information[0]->religion ?? "N/A"}}" 
                                                oninput="capitalizeWords(this)" disabled>
                                        </div>
                                       <div class="col-md-3">
                                        <label><strong>Gender</strong></label>
                                        <select class="form-control edit-field" id="gender" name="gender" disabled>
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ $my_profile_information[0]->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $my_profile_information[0]->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ $my_profile_information[0]->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                            <option value="N/A" {{ !isset($my_profile_information[0]->gender) ? 'selected' : '' }}>N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label><strong>Civil Status</strong></label>
                                        <select class="form-control edit-field" id="civilStatus" name="civilStatus" disabled>
                                            <option value="">Select Civil Status</option>
                                            <option value="Single" {{ $my_profile_information[0]->civilStatus === 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ $my_profile_information[0]->civilStatus === 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Divorced" {{ $my_profile_information[0]->civilStatus === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="Widowed" {{ $my_profile_information[0]->civilStatus === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="N/A" {{ !isset($my_profile_information[0]->civilStatus) ? 'selected' : '' }}>N/A</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label><strong>Contact Number</strong></label>
                                            <input type="text" class="form-control edit-field" id="contactNo"
                                                name="contactNo" value="{{ $my_profile_information[0]->contactNo ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Email Address</strong></label>
                                            <input type="text" class="form-control edit-field" id="emailAddress"
                                                name="emailAddress"
                                                value="{{ $my_profile_information[0]->emailAddress ?? "N/A"}}" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <!-- <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Payroll Group</strong></label>
                                            <input type="text" class="form-control edit-field" id="batchId" name="batchId"
                                                value="{{ $my_profile_information[0]->batchId ?? "N/A"}}" disabled>
                                        </div> -->

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Payroll Group</strong></label>

                                            <select class="form-control"
                                                    id="batchId"
                                                    name="batchId"
                                                    disabled>

                                                <option value="">Select Payroll Group</option>

                                                @foreach($payrollgroup as $pg)
                                                    <option value="{{ $pg->payrollGroupCode }}"
                                                        {{ ($my_profile_information[0]->batchId ?? '') == $pg->payrollGroupCode ? 'selected' : '' }}>
                                                        
                                                        {{ $pg->payrollGroupName }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                   
                                    <div class="col-md-3">
                                        <label><strong>Payment Type</strong></label>
                                        <select class="form-control" id="paymentType" name="paymentType" disabled>
                                            <option value="">Select Payment Type</option>
                                            <option value="Cash" {{ $my_profile_information[0]->paymentType === 'CASH' ? 'selected' : '' }}>CASH</option>
                                            <option value="ATM" {{ $my_profile_information[0]->paymentType === 'ATM' ? 'selected' : '' }}>ATM</option>
                                            <option value="Check" {{ $my_profile_information[0]->paymentType === 'CHECK' ? 'selected' : '' }}>CHECK</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>TIN</strong></label>
                                            <input type="text" class="form-control" id="tinNo" name="tinNo"
                                                value="{{ $my_profile_information[0]->tinNo ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Bank Account</strong></label>
                                            <input type="text" class="form-control" id="BankAccountNo"
                                                name="BankAccountNo"
                                                value="{{ $my_profile_information[0]->BankAccountNo ?? "N/A"}}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>SSS No.</strong></label>
                                            <input type="text" class="form-control" id="sssNo" name="sssNo"
                                                value="{{ $my_profile_information[0]->sssNo ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Pagibig No.</strong></label>
                                            <input type="text" class="form-control" id="pagibigNo"
                                                name="pagibigNo" value="{{ $my_profile_information[0]->pagibigNo ?? "N/A"}}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>HMO No.</strong></label>
                                            <input type="text" class="form-control edit-field" id="hmoNo" name="hmoNo"
                                                value="{{ $my_profile_information[0]->hmoNo ?? "N/A"}}" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>PRC No.</strong></label>
                                            <input type="text" class="form-control edit-field" id="prcNo" name="prcNo"
                                                value="{{ $my_profile_information[0]->prcNo ?? "N/A"}}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Date Issued</strong></label>
                                            <input type="text" class="form-control edit-field" id="dateIssued"
                                                name="dateIssued"
                                                value="{{ $my_profile_information[0]->dateIssued ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Date Expired</strong></label>
                                            <input type="text" class="form-control edit-field" id="dateExpired"
                                                name="dateExpired"
                                                value="{{ $my_profile_information[0]->dateExpired ?? "N/A"}}" disabled>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-success save-btn d-none"
                                            onclick="confirm_submit_information()">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 25px;">
                            <div class="col-md-12 col-lg-3 mb-4">
                                <div class="row">
                                    <!-- EMERGENCY CONTACTS -->
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border-0">
                                            <div class="card-custom">
                                                <!-- CARD HEADER WITH EDIT BUTTON -->
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fa-solid fa-calendar me-1"></i>
                                                        Emergency Contact
                                                    </div>

                                                    <button class="btn btn-sm btn-light" id="editTableBtnContact">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </div>

                                                <!-- CARD BODY -->
                                                <div class="card-body">
                                                    <table id="contactTable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>Name</th>
                                                                <th>Relationship</th>
                                                                <th>Mobile No.</th>
                                                                <th>Alt Mobile No</th>
                                                                <th>Email</th>
                                                                <th>View/Attach File</th>
                                                                <th width="5%">
                                                                    <button type="button" id="addTableRowBtnContact"
                                                                        class="btn btn-sm btn-primary" disabled>
                                                                        +
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr id="noDataRowContact">
                                                                <td colspan="8" class="text-center">No data available</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                                                    <div id="editSectionContact" style="display:none; margin-top:15px;">

                                                        <div class="mb-2">
                                                            <label class="form-label">Reason</label>
                                                            <textarea class="form-control" id="editReason"
                                                                rows="2"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button class="btn btn-success btn-sm d-none"
                                                                id="saveTableBtnContact" style=" margin-top:15px;"
                                                                onclick="confirm_submit_contact()">
                                                                <i class="fa-solid fa-save"></i> Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDUCATION TABLE (Updated) -->
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border-0">
                                            <div class="card-custom">
                                                <!-- CARD HEADER WITH EDIT BUTTON -->
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fa-solid fa-graduation-cap me-1"></i>
                                                        Education
                                                    </div>

                                                    <button class="btn btn-sm btn-light" id="editTableBtnEducation">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </div>

                                                <!-- CARD BODY -->
                                                <div class="card-body">
                                                    <table id="educationTable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>School/University</th>
                                                                <th>Degree</th>
                                                                <th>Major</th>
                                                                <th>Year From</th>
                                                                <th>Year To</th>
                                                                <th>View/Attach File</th>
                                                                <th width="5%">
                                                                    <button type="button" id="addTableRowBtnEducation"
                                                                        class="btn btn-sm btn-primary" disabled>
                                                                        +
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="noDataRowEducation">
                                                                <td colspan="8" class="text-center">No data available</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                                                    <div id="editSectionEducation" style="display:none; margin-top:15px;">

                                                        <div class="mb-2">
                                                            <label class="form-label">Reason</label>
                                                            <textarea class="form-control" id="editReasonEducation"
                                                                rows="2"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button class="btn btn-success btn-sm d-none"
                                                                id="saveTableBtnEducation" style="margin-top:15px;"
                                                                onclick="confirm_submit_Education()">
                                                                <i class="fa-solid fa-save"></i> Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- EMPLOYMENT HISTORY (Updated) -->
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border-0">
                                            <div class="card-custom">
                                                <!-- CARD HEADER WITH EDIT BUTTON -->
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fa-solid fa-briefcase me-1"></i>
                                                        Employment History
                                                    </div>

                                                    <button class="btn btn-sm btn-light" id="editTableBtnEmployment">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </div>

                                                <!-- CARD BODY -->
                                                <div class="card-body">
                                                    <table id="employmentTable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>TIN</th>
                                                                <th>Employer's Name</th>
                                                                <th>From</th>
                                                                <th>To</th>
                                                                <th>View/Attach File</th>
                                                                <th width="5%">
                                                                    <button type="button" id="addTableRowBtnEmployment"
                                                                        class="btn btn-sm btn-primary" disabled>
                                                                        +
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="noDataRowEmployment">
                                                                <td colspan="7" class="text-center">No data available</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                                                    <div id="editSectionEmployment" style="display:none; margin-top:15px;">

                                                        <div class="mb-2">
                                                            <label class="form-label">Reason</label>
                                                            <textarea class="form-control" id="editReasonEmployment"
                                                                rows="2"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button class="btn btn-success btn-sm d-none"
                                                                id="saveTableBtnEmployment" style="margin-top:15px;"
                                                                onclick="confirm_submit_Employment()">
                                                                <i class="fa-solid fa-save"></i> Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TRAINING AND SEMINAR (Updated with full functionality) -->
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border-0">
                                            <div class="card-custom">
                                                <!-- CARD HEADER WITH EDIT BUTTON -->
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fa-solid fa-briefcase me-1"></i>
                                                        Training and Seminar
                                                    </div>

                                                    <!-- <button class="btn btn-sm btn-light" id="editTableBtnTraining">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button> -->
                                                </div>

                                                <!-- CARD BODY -->
                                                <div class="card-body">
                                                    <table id="trainingTable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>Description</th>
                                                                <th>Date From</th>
                                                                <th>Date To</th>
                                                                <th>Location</th>
                                                                <th>View/Attach File</th>
                                                                <th width="5%">
                                                                    <button type="button" id="addTableRowBtnTraining"
                                                                        class="btn btn-sm btn-primary" disabled>
                                                                        +
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="noDataRowTraining">
                                                                <td colspan="7" class="text-center">No data available</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                                                    <div id="editSectionTraining" style="display:none; margin-top:15px;">

                                                        <div class="mb-2">
                                                            <label class="form-label">Reason</label>
                                                            <textarea class="form-control" id="editReasonTraining"
                                                                rows="2"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button class="btn btn-success btn-sm d-none"
                                                                id="saveTableBtnTraining" style="margin-top:15px;"
                                                                onclick="confirm_submit_Training()">
                                                                <i class="fa-solid fa-save"></i> Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- HMO / DEPENDENT (Updated with full functionality) -->
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border-0">
                                            <div class="card-custom">
                                                <!-- CARD HEADER WITH EDIT BUTTON -->
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fa-solid fa-briefcase me-1"></i>
                                                        HMO / Dependent
                                                    </div>
                                                <?php
                                                    $showHmoEdit = false;

                                                    if (!empty($hmoRange) && isset($hmoRange[0])) {
                                                        $dateFrom = strtotime($hmoRange[0]->hmo_dateFrom);
                                                        $dateTo   = strtotime($hmoRange[0]->hmo_dateTo);
                                                        $today    = strtotime(date('Y-m-d'));

                                                        $showHmoEdit = ($today >= $dateFrom && $today <= $dateTo);

                                                        // Debug
                                                        // echo $showHmoEdit ? 'TRUE' : 'FALSE';
                                                    }
                                                    ?>

                                                    <?php if ($showHmoEdit): ?>
                                                        <button class="btn btn-sm btn-light" id="editTableBtnHMO">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                <?php endif; ?>

                                                <!-- CARD BODY -->
                                                <div class="card-body">
                                                    <table id="hmoTable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>First Name</th>
                                                                <th>Middle Name</th>
                                                                <th>Last Name</th>
                                                                <th>Birth Date</th>
                                                                <th>Relationship</th>
                                                                <th>Civil Status</th>
                                                                <th>Gender</th>
                                                                <th>HMO dependent?</th>
                                                                <th>HMO Id</th>
                                                                <th>Start Date</th>
                                                                <th>Renewal Date</th>
                                                                <th>View/Attach File</th>
                                                                <th width="5%">
                                                                    <button type="button" id="addTableRowBtnHMO"
                                                                        class="btn btn-sm btn-primary" disabled>
                                                                        +
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="noDataRowHMO">
                                                                <td colspan="12" class="text-center">No data available</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                                                    <div id="editSectionHMO" style="display:none; margin-top:15px;">

                                                        <div class="mb-2">
                                                            <label class="form-label">Reason</label>
                                                            <textarea class="form-control" id="editReasonHMO"
                                                                rows="2"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button class="btn btn-success btn-sm d-none"
                                                                id="saveTableBtnHMO" style="margin-top:15px;"
                                                                onclick="confirm_submit_HMO()">
                                                                <i class="fa-solid fa-save"></i> Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function capitalizeWords(el) {
        el.value = el.value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
    </script>

    <script>
        var identityId = document.getElementById("identityId");
        var firstName = document.getElementById("firstName");
        var middleName = document.getElementById("middleName");
        var lastName = document.getElementById("lastName");
        var suffix = document.getElementById("suffix");
        var birthPlace = document.getElementById("birthPlace");
        var birthdate = document.getElementById("birthdate");
        var age = document.getElementById("age");
        var address = document.getElementById("address");
        var citizenship = document.getElementById("citizenship");
        var religion = document.getElementById("religion");
        var gender = document.getElementById("gender");
        var civilStatus = document.getElementById("civilStatus");
        var contactNo = document.getElementById("contactNo");
        var emailAddress = document.getElementById("emailAddress");
        var batchId = document.getElementById("batchId");
        var paymentType = document.getElementById("paymentType");
        var tinNo = document.getElementById("tinNo");
        var BankAccountNo = document.getElementById("BankAccountNo");
        var sssNo = document.getElementById("sssNo");
        var pagibigNo = document.getElementById("pagibigNo");
        var hmoNo = document.getElementById("hmoNo");
        var prcNo = document.getElementById("prcNo");
        var dateIssued = document.getElementById("dateIssued");
        var dateExpired = document.getElementById("dateExpired");
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profilePreview = document.getElementById("profilePreview");
            document.querySelectorAll(".edit-btn").forEach(function (button) {
                button.addEventListener("click", function () {
                    let card = button.closest(".card-custom");
                    let inputs = card.querySelectorAll(".edit-field");
                    let saveBtn = card.querySelector(".save-btn");

                    const isEditing = !inputs[0].disabled;

                    if (!isEditing) {
                        inputs.forEach(function (input) {
                            input.dataset.original = input.value;
                            input.disabled = false;
                        });
                        inputs.forEach(function (input) {
                            input.addEventListener("input", function checkDirty() {
                                const anyChanged = Array.from(inputs).some(
                                    i => i.value !== i.dataset.original
                                );
                                saveBtn.classList.toggle("d-none", !anyChanged);
                            });
                        });

                    } else {
                        inputs.forEach(function (input) {
                            input.value = input.dataset.original;
                            input.disabled = true;
                            const clone = input.cloneNode(true);
                            input.parentNode.replaceChild(clone, input);
                        });
                        saveBtn.classList.add("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        function confirm_submit_information() {
            window.scrollTo(0, 0);
            fbconfirm('Confirm Submit', 'Do you want to continue submitting this form?', 'Yes', 'Cancel', 'submit_information()');
        }

        function submit_information() {
            $.ajax({
                url: '{{ route('my_profile_details_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    identityId: $('#identity').val(),
                    firstName: $('#firstName').val(),
                    middleName: $('#middleName').val(),
                    lastName: $('#lastName').val(),
                    suffix: $('#suffix').val(),
                    birthPlace: $('#birthPlace').val(),
                    birthdate: $('#birthdate').val(),
                    age: $('#age').val(),
                    address: $('#address').val(),
                    address2: $('#address2').val(),
                    address3: $('#address3').val(),
                    citizenship: $('#citizenship').val(),
                    religion: $('#religion').val(),
                    gender: $('#gender').val(),
                    civilStatus: $('#civilStatus').val(),
                    contactNo: $('#contactNo').val(),
                    emailAddress: $('#emailAddress').val(),
                    batchId: $('#batchId').val(),
                    paymentType: $('#paymentType').val(),
                    tinNo: $('#tinNo').val(),
                    BankAccountNo: $('#BankAccountNo').val(),
                    sssNo: $('#sssNo').val(),
                    pagibigNo: $('#pagibigNo').val(),
                    hmoNo: $('#hmoNo').val(),
                    prcNo: $('#prcNo').val(),
                    dateIssued: $('#dateIssued').val(),
                    dateExpired: $('#dateExpired').val(),
                },
                success: function (data) {

                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);

                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        function closeSuccessMessage() {
            $('#success_message').hide();
            setTimeout(function () {
                location.href = '{{ route('my_profile_details') }}';
            }, 500);
        }

        function closeErrorMessage() {
            $('#error_message').hide();
        }
    </script>


    <!-- emeregency contact -->
    <script>
        let emergencyContacts = <?= json_encode($emergencycontacts ?? []) ?>;
        let education = <?= json_encode($education ?? []) ?>;

        let selectedRow = null;
        let deletedRows = [];

        let rowIndex = 0;
        let isEditing = false;



        function confirm_submit_contact() {
            // window.scrollTo(0, 0);
            fbconfirm('Confirm Submit', 'Do you want to continue submitting this changes?', 'Yes', 'Cancel', 'submit_contact()');
        }

        function submit_contact() {
            let contacts = [];

            $('#contactTable tbody tr').each(function () {

                contacts.push({
                    code: $(this).data('code') || null,
                    lineId: $(this).data('lineid') || null,
                    name: $(this).find('.name').val(),
                    relationship: $(this).find('.relationship').val(),
                    mobileNo: $(this).find('.mobileNo').val(),
                    alt_mobileNo: $(this).find('.alt_mobileNo').val(),
                    email: $(this).find('.email').val()
                });

            });
            $.ajax({
                url: '{{ route('my_profile_details_contact_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    contacts: contacts,
                    deletedRows: deletedRows
                },

                success: function (data) {

                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);

                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        // =========================
        // SAVE BUTTON VISIBILITY
        // =========================
        function toggleSaveButton() {

            let hasChanges = false;

            $('#contactTable tbody tr').each(function () {

                const dirty = $(this).data('dirty');

                if (dirty === true) {
                    hasChanges = true;
                    return false;
                }
            });

            if (deletedRows.length > 0) {
                hasChanges = true;
            }

            $('#saveTableBtnContact').toggleClass('d-none', !hasChanges);
        }

        // =========================
        // RENUMBER ROWS
        // =========================
        function reNumberRows() {

            rowIndex = 0;

            $('#contactTable tbody tr').each(function () {
                rowIndex++;
                $(this).find('.row-number').text(rowIndex);
            });
        }

        // =========================
        // DELETE CONFIRMED ACTION
        // =========================
        function submit_delete_contact() {

            if (!selectedRow) return;

            let lineId = selectedRow.data('lineid');
            let code = selectedRow.data('code');

            if (lineId) {
                deletedRows.push({
                    lineId: lineId,
                    code: code,
                    action: 'delete'
                });
            }

            selectedRow.remove();
            selectedRow = null;

            reNumberRows();
            toggleSaveButton();

            console.log('Deleted Rows:', deletedRows);
        }

        // =========================
        // DOCUMENT READY
        // =========================
        $(document).ready(function () {

            // =========================
            // LOAD DATA
            // =========================
            function loadEmergencyContacts(data) {

                $('#contactTable tbody').empty();

                if (!data || data.length === 0) {
                    $('#contactTable tbody').html(`
                                                                        <tr id="noDataRowContact">
                                                                            <td colspan="8" class="text-center">No data available</td>
                                                                        </tr>
                                                                    `);
                    return;
                }

                rowIndex = 0;

                data.forEach(item => {
                    rowIndex++;

                    let row = $(`
                                                                        <tr data-lineid="${item.lineId}" data-code="${item.code}">
                                                                            <td class="row-number">${rowIndex}</td>
                                                                            <td><input type="text" class="form-control form-control-sm name" value="${item.name ?? ''}"  oninput="capitalizeWords(this)" disabled></td>
                                                                            <td><select class="form-control form-control-sm relationship" disabled>
                                                                                <option value=""></option>
                                                                                <option value="Spouse" ${item.relationship === 'Spouse' ? 'selected' : ''}>Spouse</option>
                                                                                <option value="Parent" ${item.relationship === 'Parent' ? 'selected' : ''}>Parent</option>
                                                                                <option value="Father" ${item.relationship === 'Father' ? 'selected' : ''}>Father</option>
                                                                                <option value="Mother" ${item.relationship === 'Mother' ? 'selected' : ''}>Mother</option>
                                                                                <option value="Sibling" ${item.relationship === 'Sibling' ? 'selected' : ''}>Sibling</option>
                                                                                <option value="Brother" ${item.relationship === 'Brother' ? 'selected' : ''}>Brother</option>
                                                                                <option value="Sister" ${item.relationship === 'Sister' ? 'selected' : ''}>Sister</option>
                                                                                <option value="Child" ${item.relationship === 'Child' ? 'selected' : ''}>Child</option>
                                                                                <option value="Son" ${item.relationship === 'Son' ? 'selected' : ''}>Son</option>
                                                                                <option value="Daughter" ${item.relationship === 'Daughter' ? 'selected' : ''}>Daughter</option>
                                                                                <option value="Relative" ${item.relationship === 'Relative' ? 'selected' : ''}>Relative</option>
                                                                                <option value="Guardian" ${item.relationship === 'Guardian' ? 'selected' : ''}>Guardian</option>
                                                                                <option value="Friend" ${item.relationship === 'Friend' ? 'selected' : ''}>Friend</option>
                                                                                <option value="Partner" ${item.relationship === 'Partner' ? 'selected' : ''}>Partner</option>
                                                                                <option value="Colleague" ${item.relationship === 'Colleague' ? 'selected' : ''}>Colleague</option>
                                                                                <option value="Other" ${item.relationship === 'Other' ? 'selected' : ''}>Other</option>
                                                                            </select></td>
                                                                            <td><input type="number" class="form-control form-control-sm mobileNo" value="${item.mobileNo ?? ''}" disabled></td>
                                                                            <td><input type="number" class="form-control form-control-sm alt_mobileNo" value="${item.alt_mobileNo ?? ''}" disabled></td>
                                                                            <td><input type="email" class="form-control form-control-sm email" value="${item.email ?? ''}" disabled></td>
                                                                            <td>
                                                                                ${item.attachment ? `<a href="${item.attachment}" target="_blank">View</a>` : ''}
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-sm btn-danger deleteRowBtn d-none">X</button>
                                                                            </td>
                                                                        </tr>
                                                                    `);

                    row.data('original', {
                        name: item.name ?? '',
                        relationship: item.relationship ?? '',
                        mobileNo: item.mobileNo ?? '',
                        alt_mobileNo: item.alt_mobileNo ?? '',
                        email: item.email ?? ''
                    });

                    row.data('dirty', false);

                    $('#contactTable tbody').append(row);
                });
            }

            loadEmergencyContacts(emergencyContacts);

            // =========================
            // DELETE CLICK (CONFIRM)
            // =========================
            $(document).on('click', '.deleteRowBtn', function () {

                selectedRow = $(this).closest('tr');

                fbconfirm(
                    'Confirm Delete',
                    'Do you want to continue deleting this row?',
                    'Yes',
                    'Cancel',
                    'submit_delete_contact()'
                );
            });

            // =========================
            // EDIT TOGGLE
            // =========================
            $('#editTableBtnContact').on('click', function () {

                isEditing = !isEditing;

                $('#editSectionContact').toggle(isEditing);
                $('#addTableRowBtnContact').prop('disabled', !isEditing);
                $('#contactTable input, #contactTable select').prop('disabled', !isEditing);

                $('.deleteRowBtn').toggleClass('d-none', !isEditing);

                // if (!isEditing) {

                //     $('#contactTable tbody tr').each(function () {
                //         let original = $(this).data('original');

                //         if (original) {
                //             $(this).find('.name').val(original.name);
                //             $(this).find('.relationship').val(original.relationship);
                //             $(this).find('.mobileNo').val(original.mobileNo);
                //             $(this).find('.alt_mobileNo').val(original.alt_mobileNo);
                //             $(this).find('.email').val(original.email);
                //         }

                //         $(this).data('dirty', false);
                //     });

                //     $('#saveTableBtnContact').addClass('d-none');
                // }
                if (!isEditing) {

                    $('#contactTable tbody tr').each(function () {

                        let original = $(this).data('original');

                        // REMOVE NEW ROWS
                        if (!original) {
                            $(this).remove();
                            return;
                        }

                        // RESTORE ORIGINAL VALUES
                        $(this).find('.name').val(original.name);
                        $(this).find('.relationship').val(original.relationship);
                        $(this).find('.mobileNo').val(original.mobileNo);
                        $(this).find('.alt_mobileNo').val(original.alt_mobileNo);
                        $(this).find('.email').val(original.email);

                        $(this).data('dirty', false);
                    });

                    reNumberRows();

                    if ($('#contactTable tbody tr').length === 0) {
                        $('#contactTable tbody').html(`
                                                                <tr id="noDataRowContact">
                                                                    <td colspan="8" class="text-center">No data available</td>
                                                                </tr>
                                                            `);
                    }

                    deletedRows = [];

                    $('#saveTableBtnContact').addClass('d-none');
                }
            });

            // =========================
            // ADD ROW
            // =========================
            $('#addTableRowBtnContact').on('click', function () {

                $('#noDataRowContact').remove();

                rowIndex++;

                let row = $(`
                            <tr>
                                <td class="row-number">${rowIndex}</td>
                                <td><input type="text" class="form-control form-control-sm name" oninput="capitalizeWords(this)"></td>
                                <td><select class="form-control form-control-sm relationship">
                                    <option value=""></option>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Sibling">Sibling</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Child">Child</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Relative">Relative</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Friend">Friend</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Colleague">Colleague</option>
                                    <option value="Other">Other</option>
                                </select></td>
                                <td><input type="number" class="form-control form-control-sm mobileNo"></td>
                                <td><input type="number" class="form-control form-control-sm alt_mobileNo"></td>
                                <td><input type="email" class="form-control form-control-sm email"></td>
                                <td><input type="file" class="form-control form-control-sm attachment"></td>
                                <td><button type="button" class="btn btn-sm btn-danger deleteRowBtn">X</button></td>
                            </tr>
                        `);

                row.data('lineid', null);
                row.data('code', null);
                row.data('dirty', true);

                $('#contactTable tbody').append(row);

                toggleSaveButton();
            });

            // =========================
            // TRACK CHANGES
            // =========================
            $(document).on('input change', '#contactTable input, #contactTable select', function () {

                let row = $(this).closest('tr');
                let original = row.data('original');

                if (!original) {
                    row.data('dirty', true);
                    toggleSaveButton();
                    return;
                }

                let current = {
                    name: row.find('.name').val(),
                    relationship: row.find('.relationship').val(),
                    mobileNo: row.find('.mobileNo').val(),
                    alt_mobileNo: row.find('.alt_mobileNo').val(),
                    email: row.find('.email').val()
                };

                row.data('dirty',
                    JSON.stringify(original) !== JSON.stringify(current)
                );

                toggleSaveButton();
            });

        });
    </script>

    <!-- education table -->
    <script>
        let educationRecords = <?= json_encode($education ?? []) ?>;

        let selectedRowEducation = null;
        let deletedRowsEducation = [];
        let rowIndexEducation = 0;
        let isEditingEducation = false;

        function confirm_submit_Education() {
            fbconfirm('Confirm Submit', 'Do you want to continue submitting these changes?', 'Yes', 'Cancel', 'submit_Education()');
        }

        function submit_Education() {
            let educations = [];

            $('#educationTable tbody tr').each(function () {
                educations.push({
                    code: $(this).data('code') || null,
                    lineId: $(this).data('lineid') || null,
                    school: $(this).find('.school').val(),
                    degree: $(this).find('.degree').val(),
                    major: $(this).find('.major').val(),
                    yearFrom: $(this).find('.yearFrom').val(),
                    yearTo: $(this).find('.yearTo').val()
                });
            });

            $.ajax({
                url: '{{ route('my_profile_details_education_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    educations: educations,
                    deletedRows: deletedRowsEducation
                },
                success: function (data) {
                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                        // Reset after successful submission
                        deletedRowsEducation = [];
                        isEditingEducation = false;
                        $('#editTableBtnEducation').click();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        // =========================
        // SAVE BUTTON VISIBILITY
        // =========================
        function toggleSaveButtonEducation() {
            let hasChanges = false;

            $('#educationTable tbody tr').each(function () {
                const dirty = $(this).data('dirty');

                if (dirty === true) {
                    hasChanges = true;
                    return false;
                }
            });

            if (deletedRowsEducation.length > 0) {
                hasChanges = true;
            }

            $('#saveTableBtnEducation').toggleClass('d-none', !hasChanges);
        }

        // =========================
        // RENUMBER ROWS
        // =========================
        function reNumberRowsEducation() {
            rowIndexEducation = 0;

            $('#educationTable tbody tr').each(function () {
                rowIndexEducation++;
                $(this).find('.row-number').text(rowIndexEducation);
            });
        }

        // =========================
        // DELETE CONFIRMED ACTION
        // =========================
        function submit_delete_education() {
            if (!selectedRowEducation) return;

            let lineId = selectedRowEducation.data('lineid');
            let code = selectedRowEducation.data('code');

            if (lineId) {
                deletedRowsEducation.push({
                    lineId: lineId,
                    code: code,
                    action: 'delete'
                });
            }

            selectedRowEducation.remove();
            selectedRowEducation = null;

            reNumberRowsEducation();
            toggleSaveButtonEducation();

            console.log('Deleted Rows:', deletedRowsEducation);
        }

        // =========================
        // DOCUMENT READY
        // =========================
        $(document).ready(function () {

            // =========================
            // LOAD DATA
            // =========================
            function loadEducationRecords(data) {
                $('#educationTable tbody').empty();

                if (!data || data.length === 0) {
                    $('#educationTable tbody').html(`
                                                                <tr id="noDataRowEducation">
                                                                    <td colspan="8" class="text-center">No data available</td>
                                                                </tr>
                                                            `);
                    return;
                }

                rowIndexEducation = 0;

                data.forEach(item => {
                    rowIndexEducation++;

                    let row = $(`
                                                                <tr data-lineid="${item.lineId}" data-code="${item.code}">
                                                                    <td class="row-number">${rowIndexEducation}</td>
                                                                    <td><input type="text" class="form-control form-control-sm school" value="${item.school ?? ''}" disabled></td>
                                                                    <td><input type="text" class="form-control form-control-sm degree" value="${item.degree ?? ''}" disabled></td>
                                                                    <td><input type="text" class="form-control form-control-sm major" value="${item.major ?? ''}" disabled></td>
                                                                    <td><input type="number" class="form-control form-control-sm yearFrom" value="${item.from ?? ''}" disabled></td>
                                                                    <td><input type="number" class="form-control form-control-sm yearTo" value="${item.to ?? ''}" disabled></td>
                                                                    <td>
                                                                        ${item.attachment ? `<a href="${item.attachment}" target="_blank">View</a>` : ''}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-danger deleteRowBtnEducation d-none">X</button>
                                                                    </td>
                                                                </tr>
                                                            `);

                    row.data('original', {
                        school: item.school ?? '',
                        degree: item.degree ?? '',
                        major: item.major ?? '',
                        yearFrom: item.from ?? '',
                        yearTo: item.to ?? ''
                    });

                    row.data('dirty', false);

                    $('#educationTable tbody').append(row);
                });
            }

            loadEducationRecords(education);

            // =========================
            // DELETE CLICK (CONFIRM)
            // =========================
            $(document).on('click', '.deleteRowBtnEducation', function () {
                selectedRowEducation = $(this).closest('tr');

                fbconfirm(
                    'Confirm Delete',
                    'Do you want to continue deleting this row?',
                    'Yes',
                    'Cancel',
                    'submit_delete_education()'
                );
            });

            // =========================
            // EDIT TOGGLE
            // =========================
            $('#editTableBtnEducation').on('click', function () {
                isEditingEducation = !isEditingEducation;

                $('#editSectionEducation').toggle(isEditingEducation);
                $('#addTableRowBtnEducation').prop('disabled', !isEditingEducation);
                $('#educationTable input, #educationTable select').prop('disabled', !isEditingEducation);

                $('.deleteRowBtnEducation').toggleClass('d-none', !isEditingEducation);

                // if (!isEditingEducation) {
                //     $('#educationTable tbody tr').each(function () {
                //         let original = $(this).data('original');

                //         if (original) {
                //             $(this).find('.school').val(original.school);
                //             $(this).find('.degree').val(original.degree);
                //             $(this).find('.major').val(original.major);
                //             $(this).find('.yearFrom').val(original.yearFrom);
                //             $(this).find('.yearTo').val(original.yearTo);
                //         }

                //         $(this).data('dirty', false);
                //     });

                //     deletedRowsEducation = [];
                //     $('#saveTableBtnEducation').addClass('d-none');
                // }

                if (!isEditingEducation) {

                    $('#educationTable tbody tr').each(function () {

                        let original = $(this).data('original');

                        // REMOVE newly added rows
                        if (!original) {
                            $(this).remove();
                            return;
                        }

                        // RESET existing rows
                        $(this).find('.school').val(original.school);
                        $(this).find('.degree').val(original.degree);
                        $(this).find('.major').val(original.major);
                        $(this).find('.yearFrom').val(original.yearFrom);
                        $(this).find('.yearTo').val(original.yearTo);

                        $(this).data('dirty', false);
                    });

                    // restore numbering
                    reNumberRowsEducation();

                    // restore no data row if needed
                    if ($('#educationTable tbody tr').length === 0) {
                        $('#educationTable tbody').html(`
                                                                <tr id="noDataRowEducation">
                                                                    <td colspan="8" class="text-center">No data available</td>
                                                                </tr>
                                                            `);
                    }

                    deletedRowsEducation = [];

                    $('#saveTableBtnEducation').addClass('d-none');
                }
            });

            // =========================
            // ADD ROW
            // =========================
            $('#addTableRowBtnEducation').on('click', function () {
                $('#noDataRowEducation').remove();

                rowIndexEducation++;

                let row = $(`
                                                            <tr>
                                                                <td class="row-number">${rowIndexEducation}</td>
                                                                <td><input type="text" class="form-control form-control-sm school" placeholder="School/University"></td>
                                                                <td><input type="text" class="form-control form-control-sm degree" placeholder="e.g., Bachelor"></td>
                                                                <td><input type="text" class="form-control form-control-sm major" placeholder="e.g., Computer Science"></td>
                                                                <td><input type="number" class="form-control form-control-sm yearFrom" placeholder="YYYY"></td>
                                                                <td><input type="number" class="form-control form-control-sm yearTo" placeholder="YYYY"></td>
                                                                <td><input type="file" class="form-control form-control-sm attachment"></td>
                                                                <td><button type="button" class="btn btn-sm btn-danger deleteRowBtnEducation">X</button></td>
                                                            </tr>
                                                        `);

                row.data('lineid', null);
                row.data('code', null);
                row.data('dirty', true);

                $('#educationTable tbody').append(row);

                toggleSaveButtonEducation();
            });

            // =========================
            // TRACK CHANGES
            // =========================
            $(document).on('input change', '#educationTable input, #educationTable select', function () {
                let row = $(this).closest('tr');
                let original = row.data('original');

                if (!original) {
                    row.data('dirty', true);
                    toggleSaveButtonEducation();
                    return;
                }

                let current = {
                    school: row.find('.school').val(),
                    degree: row.find('.degree').val(),
                    major: row.find('.major').val(),
                    yearFrom: row.find('.yearFrom').val(),
                    yearTo: row.find('.yearTo').val()
                };

                row.data('dirty', JSON.stringify(original) !== JSON.stringify(current));

                toggleSaveButtonEducation();
            });

        });
    </script>


    <!-- employment history table -->
    <script>
        let employmentRecords = <?= json_encode($employment ?? []) ?>;

        let selectedRowEmployment = null;
        let deletedRowsEmployment = [];
        let rowIndexEmployment = 0;
        let isEditingEmployment = false;

        function confirm_submit_Employment() {
            fbconfirm('Confirm Submit', 'Do you want to continue submitting these changes?', 'Yes', 'Cancel', 'submit_Employment()');
        }

        function submit_Employment() {
            let employments = [];

            $('#employmentTable tbody tr').each(function () {
                employments.push({
                    code: $(this).data('code') || null,
                    lineId: $(this).data('lineid') || null,
                    tin: $(this).find('.tin').val(),
                    employerName: $(this).find('.employerName').val(),
                    dateFrom: $(this).find('.dateFrom').val(),
                    dateTo: $(this).find('.dateTo').val()
                });
            });

            $.ajax({
                url: '{{ route('my_profile_details_employment_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    employments: employments,
                    deletedRows: deletedRowsEmployment
                },
                success: function (data) {
                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                        // Reset after successful submission
                        deletedRowsEmployment = [];
                        isEditingEmployment = false;
                        $('#editTableBtnEmployment').click();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        // =========================
        // SAVE BUTTON VISIBILITY
        // =========================
        function toggleSaveButtonEmployment() {
            let hasChanges = false;

            $('#employmentTable tbody tr').each(function () {
                const dirty = $(this).data('dirty');

                if (dirty === true) {
                    hasChanges = true;
                    return false;
                }
            });

            if (deletedRowsEmployment.length > 0) {
                hasChanges = true;
            }

            $('#saveTableBtnEmployment').toggleClass('d-none', !hasChanges);
        }

        // =========================
        // RENUMBER ROWS
        // =========================
        function reNumberRowsEmployment() {
            rowIndexEmployment = 0;

            $('#employmentTable tbody tr').each(function () {
                rowIndexEmployment++;
                $(this).find('.row-number').text(rowIndexEmployment);
            });
        }

        // =========================
        // DELETE CONFIRMED ACTION
        // =========================
        function submit_delete_employment() {
            if (!selectedRowEmployment) return;

            let lineId = selectedRowEmployment.data('lineid');
            let code = selectedRowEmployment.data('code');

            if (lineId) {
                deletedRowsEmployment.push({
                    lineId: lineId,
                    code: code,
                    action: 'delete'
                });
            }

            selectedRowEmployment.remove();
            selectedRowEmployment = null;

            reNumberRowsEmployment();
            toggleSaveButtonEmployment();

            console.log('Deleted Rows:', deletedRowsEmployment);
        }

        // =========================
        // DOCUMENT READY
        // =========================
        $(document).ready(function () {

            // =========================
            // LOAD DATA
            // =========================
            function loadEmploymentRecords(data) {
                $('#employmentTable tbody').empty();

                if (!data || data.length === 0) {
                    $('#employmentTable tbody').html(`
                                                        <tr id="noDataRowEmployment">
                                                            <td colspan="7" class="text-center">No data available</td>
                                                        </tr>
                                                    `);
                    return;
                }

                rowIndexEmployment = 0;

                data.forEach(item => {
                    rowIndexEmployment++;

                    let row = $(`
                                                        <tr data-lineid="${item.lineId}" data-code="${item.code}">
                                                            <td class="row-number">${rowIndexEmployment}</td>
                                                            <td><input type="text" class="form-control form-control-sm tin" value="${item.tin ?? ''}" disabled></td>
                                                            <td><input type="text" class="form-control form-control-sm employerName" value="${item.company ?? ''}" disabled></td>
                                                            <td><input type="date" class="form-control form-control-sm dateFrom" value="${item.from ?? ''}" disabled></td>
                                                            <td><input type="date" class="form-control form-control-sm dateTo" value="${item.to ?? ''}" disabled></td>
                                                            <td>
                                                                ${item.attachment ? `<a href="${item.attachment}" target="_blank">View</a>` : ''}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-danger deleteRowBtnEmployment d-none">X</button>
                                                            </td>
                                                        </tr>
                                                    `);

                    row.data('original', {
                        tin: item.tin ?? '',
                        employerName: item.employerName ?? '',
                        dateFrom: item.dateFrom ?? '',
                        dateTo: item.dateTo ?? ''
                    });

                    row.data('dirty', false);

                    $('#employmentTable tbody').append(row);
                });
            }

            loadEmploymentRecords(employmentRecords);

            // =========================
            // DELETE CLICK (CONFIRM)
            // =========================
            $(document).on('click', '.deleteRowBtnEmployment', function () {
                selectedRowEmployment = $(this).closest('tr');

                fbconfirm(
                    'Confirm Delete',
                    'Do you want to continue deleting this row?',
                    'Yes',
                    'Cancel',
                    'submit_delete_employment()'
                );
            });

            // =========================
            // EDIT TOGGLE
            // =========================
            $('#editTableBtnEmployment').on('click', function () {
                isEditingEmployment = !isEditingEmployment;

                $('#editSectionEmployment').toggle(isEditingEmployment);
                $('#addTableRowBtnEmployment').prop('disabled', !isEditingEmployment);
                $('#employmentTable input, #employmentTable select').prop('disabled', !isEditingEmployment);

                $('.deleteRowBtnEmployment').toggleClass('d-none', !isEditingEmployment);

                if (!isEditingEmployment) {

                    $('#employmentTable tbody tr').each(function () {

                        let original = $(this).data('original');

                        // REMOVE newly added rows
                        if (!original) {
                            $(this).remove();
                            return;
                        }

                        // RESET existing rows
                        $(this).find('.tin').val(original.tin);
                        $(this).find('.employerName').val(original.employerName);
                        $(this).find('.dateFrom').val(original.dateFrom);
                        $(this).find('.dateTo').val(original.dateTo);

                        $(this).data('dirty', false);
                    });

                    // restore numbering
                    reNumberRowsEmployment();

                    // restore no data row if needed
                    if ($('#employmentTable tbody tr').length === 0) {
                        $('#employmentTable tbody').html(`
                                                        <tr id="noDataRowEmployment">
                                                            <td colspan="7" class="text-center">No data available</td>
                                                        </tr>
                                                    `);
                    }

                    deletedRowsEmployment = [];

                    $('#saveTableBtnEmployment').addClass('d-none');
                }
            });

            // =========================
            // ADD ROW
            // =========================
            $('#addTableRowBtnEmployment').on('click', function () {
                $('#noDataRowEmployment').remove();

                rowIndexEmployment++;

                let row = $(`
                                                    <tr>
                                                        <td class="row-number">${rowIndexEmployment}</td>
                                                        <td><input type="text" class="form-control form-control-sm tin" placeholder="TIN"></td>
                                                        <td><input type="text" class="form-control form-control-sm employerName" placeholder="Employer's Name"></td>
                                                        <td><input type="date" class="form-control form-control-sm dateFrom"></td>
                                                        <td><input type="date" class="form-control form-control-sm dateTo"></td>
                                                        <td><input type="file" class="form-control form-control-sm attachment"></td>
                                                        <td><button type="button" class="btn btn-sm btn-danger deleteRowBtnEmployment">X</button></td>
                                                    </tr>
                                                `);

                row.data('lineid', null);
                row.data('code', null);
                row.data('dirty', true);

                $('#employmentTable tbody').append(row);

                toggleSaveButtonEmployment();
            });

            // =========================
            // TRACK CHANGES
            // =========================
            $(document).on('input change', '#employmentTable input, #employmentTable select', function () {
                let row = $(this).closest('tr');
                let original = row.data('original');

                if (!original) {
                    row.data('dirty', true);
                    toggleSaveButtonEmployment();
                    return;
                }

                let current = {
                    tin: row.find('.tin').val(),
                    employerName: row.find('.employerName').val(),
                    dateFrom: row.find('.dateFrom').val(),
                    dateTo: row.find('.dateTo').val()
                };

                row.data('dirty', JSON.stringify(original) !== JSON.stringify(current));

                toggleSaveButtonEmployment();
            });

        });
    </script>
    <!-- training and seminar table -->
    <script>
        let trainingRecords = <?= json_encode($training ?? []) ?>;

        let selectedRowTraining = null;
        let deletedRowsTraining = [];
        let rowIndexTraining = 0;
        let isEditingTraining = false;

        function confirm_submit_Training() {
            fbconfirm('Confirm Submit', 'Do you want to continue submitting these changes?', 'Yes', 'Cancel', 'submit_Training()');
        }

        function submit_Training() {
            let trainings = [];

            $('#trainingTable tbody tr').each(function () {
                trainings.push({
                    code: $(this).data('code') || null,
                    lineId: $(this).data('lineid') || null,
                    description: $(this).find('.description').val(),
                    dateFrom: $(this).find('.dateFrom').val(),
                    dateTo: $(this).find('.dateTo').val(),
                    location: $(this).find('.location').val()
                });
            });

            $.ajax({
                url: '{{ route('my_profile_details_training_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    trainings: trainings,
                    deletedRows: deletedRowsTraining
                },
                success: function (data) {
                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                        // Reset after successful submission
                        deletedRowsTraining = [];
                        isEditingTraining = false;
                        $('#editTableBtnTraining').click();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        // =========================
        // SAVE BUTTON VISIBILITY
        // =========================
        function toggleSaveButtonTraining() {
            let hasChanges = false;

            $('#trainingTable tbody tr').each(function () {
                const dirty = $(this).data('dirty');

                if (dirty === true) {
                    hasChanges = true;
                    return false;
                }
            });

            if (deletedRowsTraining.length > 0) {
                hasChanges = true;
            }

            $('#saveTableBtnTraining').toggleClass('d-none', !hasChanges);
        }

        // =========================
        // RENUMBER ROWS
        // =========================
        function reNumberRowsTraining() {
            rowIndexTraining = 0;

            $('#trainingTable tbody tr').each(function () {
                rowIndexTraining++;
                $(this).find('.row-number').text(rowIndexTraining);
            });
        }

        // =========================
        // DELETE CONFIRMED ACTION
        // =========================
        function submit_delete_training() {
            if (!selectedRowTraining) return;

            let lineId = selectedRowTraining.data('lineid');
            let code = selectedRowTraining.data('code');

            if (lineId) {
                deletedRowsTraining.push({
                    lineId: lineId,
                    code: code,
                    action: 'delete'
                });
            }

            selectedRowTraining.remove();
            selectedRowTraining = null;

            reNumberRowsTraining();
            toggleSaveButtonTraining();

            console.log('Deleted Rows:', deletedRowsTraining);
        }

        // =========================
        // DOCUMENT READY
        // =========================
        $(document).ready(function () {

            // =========================
            // LOAD DATA
            // =========================
            function loadTrainingRecords(data) {
                $('#trainingTable tbody').empty();

                if (!data || data.length === 0) {
                    $('#trainingTable tbody').html(`
                                                    <tr id="noDataRowTraining">
                                                        <td colspan="7" class="text-center">No data available</td>
                                                    </tr>
                                                `);
                    return;
                }

                rowIndexTraining = 0;

                data.forEach(item => {
                    rowIndexTraining++;

                    let row = $(`
                                                    <tr data-lineid="${item.lineId}" data-code="${item.code}">
                                                        <td class="row-number">${rowIndexTraining}</td>
                                                        <td><input type="text" class="form-control form-control-sm description" value="${item.description ?? ''}" disabled></td>
                                                        <td><input type="date" class="form-control form-control-sm dateFrom" value="${item.from ?? ''}" disabled></td>
                                                        <td><input type="date" class="form-control form-control-sm dateTo" value="${item.to ?? ''}" disabled></td>
                                                        <td><input type="text" class="form-control form-control-sm location" value="${item.places ?? ''}" disabled></td>
                                                        <td>
                                                            ${item.attachment ? `<a href="${item.attachment}" target="_blank">View</a>` : ''}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-danger deleteRowBtnTraining d-none">X</button>
                                                        </td>
                                                    </tr>
                                                `);

                    row.data('original', {
                        description: item.description ?? '',
                        dateFrom: item.dateFrom ?? '',
                        dateTo: item.dateTo ?? '',
                        location: item.location ?? ''
                    });

                    row.data('dirty', false);

                    $('#trainingTable tbody').append(row);
                });
            }

            loadTrainingRecords(trainingRecords);

            // =========================
            // DELETE CLICK (CONFIRM)
            // =========================
            $(document).on('click', '.deleteRowBtnTraining', function () {
                selectedRowTraining = $(this).closest('tr');

                fbconfirm(
                    'Confirm Delete',
                    'Do you want to continue deleting this row?',
                    'Yes',
                    'Cancel',
                    'submit_delete_training()'
                );
            });

            // =========================
            // EDIT TOGGLE
            // =========================
            $('#editTableBtnTraining').on('click', function () {
                isEditingTraining = !isEditingTraining;

                $('#editSectionTraining').toggle(isEditingTraining);
                $('#addTableRowBtnTraining').prop('disabled', !isEditingTraining);
                $('#trainingTable input, #trainingTable select').prop('disabled', !isEditingTraining);

                $('.deleteRowBtnTraining').toggleClass('d-none', !isEditingTraining);

                if (!isEditingTraining) {

                    $('#trainingTable tbody tr').each(function () {

                        let original = $(this).data('original');

                        // REMOVE newly added rows
                        if (!original) {
                            $(this).remove();
                            return;
                        }

                        // RESET existing rows
                        $(this).find('.description').val(original.description);
                        $(this).find('.dateFrom').val(original.dateFrom);
                        $(this).find('.dateTo').val(original.dateTo);
                        $(this).find('.location').val(original.location);

                        $(this).data('dirty', false);
                    });

                    // restore numbering
                    reNumberRowsTraining();

                    // restore no data row if needed
                    if ($('#trainingTable tbody tr').length === 0) {
                        $('#trainingTable tbody').html(`
                                                    <tr id="noDataRowTraining">
                                                        <td colspan="7" class="text-center">No data available</td>
                                                    </tr>
                                                `);
                    }

                    deletedRowsTraining = [];

                    $('#saveTableBtnTraining').addClass('d-none');
                }
            });

            // =========================
            // ADD ROW
            // =========================
            $('#addTableRowBtnTraining').on('click', function () {
                $('#noDataRowTraining').remove();

                rowIndexTraining++;

                let row = $(`
                                                <tr>
                                                    <td class="row-number">${rowIndexTraining}</td>
                                                    <td><input type="text" class="form-control form-control-sm description" placeholder="Description"></td>
                                                    <td><input type="date" class="form-control form-control-sm dateFrom"></td>
                                                    <td><input type="date" class="form-control form-control-sm dateTo"></td>
                                                    <td><input type="text" class="form-control form-control-sm location" placeholder="Location"></td>
                                                    <td><input type="file" class="form-control form-control-sm attachment"></td>
                                                    <td><button type="button" class="btn btn-sm btn-danger deleteRowBtnTraining">X</button></td>
                                                </tr>
                                            `);

                row.data('lineid', null);
                row.data('code', null);
                row.data('dirty', true);

                $('#trainingTable tbody').append(row);

                toggleSaveButtonTraining();
            });

            // =========================
            // TRACK CHANGES
            // =========================
            $(document).on('input change', '#trainingTable input, #trainingTable select', function () {
                let row = $(this).closest('tr');
                let original = row.data('original');

                if (!original) {
                    row.data('dirty', true);
                    toggleSaveButtonTraining();
                    return;
                }

                let current = {
                    description: row.find('.description').val(),
                    dateFrom: row.find('.dateFrom').val(),
                    dateTo: row.find('.dateTo').val(),
                    location: row.find('.location').val()
                };

                row.data('dirty', JSON.stringify(original) !== JSON.stringify(current));

                toggleSaveButtonTraining();
            });

        });
    </script>

    <!-- HMO / Dependent table -->
    <script>
        let hmoRecords = <?= json_encode($hmo ?? []) ?>;

        let selectedRowHMO = null;
        let deletedRowsHMO = [];
        let rowIndexHMO = 0;
        let isEditingHMO = false;

        function confirm_submit_HMO() {
            fbconfirm('Confirm Submit', 'Do you want to continue submitting these changes?', 'Yes', 'Cancel', 'submit_HMO()');
        }

        function submit_HMO() {
            let hmos = [];

            $('#hmoTable tbody tr').each(function () {
                hmos.push({
                    code: $(this).data('code') || null,
                    lineId: $(this).data('lineid') || null,
                    firstName: $(this).find('.firstName').val(),
                    middleName: $(this).find('.middleName').val(),
                    lastName: $(this).find('.lastName').val(),
                    birthDate: $(this).find('.birthDate').val(),
                    relationship: $(this).find('.relationship').val(),
                    civilStatus: $(this).find('.civilStatus').val(),
                    gender: $(this).find('.gender').val(),
                    hmoDependent: $(this).find('.hmoDependent').val(),
                    hmoId: $(this).find('.hmoId').val(),
                    startDate: $(this).find('.startDate').val(),
                    renewalDate: $(this).find('.renewalDate').val()
                });
            });

            $.ajax({
                url: '{{ route('my_profile_details_hmmo_dependent_edit') }}',
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    hmos: hmos,
                    deletedRows: deletedRowsHMO
                },
                success: function (data) {
                    if (data.status == 0) {
                        $('#success_message_text').text(data.message);
                        $('#success_message').show();
                        // Reset after successful submission
                        deletedRowsHMO = [];
                        isEditingHMO = false;
                        $('#editTableBtnHMO').click();
                    } else {
                        $('#error_message_text').text(data.message);
                        $('#error_message').show();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#error_message_text').text("Server Error occurred");
                    $('#error_message').show();
                }
            });
        }

        // =========================
        // SAVE BUTTON VISIBILITY
        // =========================
        function toggleSaveButtonHMO() {
            let hasChanges = false;

            $('#hmoTable tbody tr').each(function () {
                const dirty = $(this).data('dirty');

                if (dirty === true) {
                    hasChanges = true;
                    return false;
                }
            });

            if (deletedRowsHMO.length > 0) {
                hasChanges = true;
            }

            $('#saveTableBtnHMO').toggleClass('d-none', !hasChanges);
        }

        // =========================
        // RENUMBER ROWS
        // =========================
        function reNumberRowsHMO() {
            rowIndexHMO = 0;

            $('#hmoTable tbody tr').each(function () {
                rowIndexHMO++;
                $(this).find('.row-number').text(rowIndexHMO);
            });
        }

        // =========================
        // DELETE CONFIRMED ACTION
        // =========================
        function submit_delete_hmo() {
            if (!selectedRowHMO) return;

            let lineId = selectedRowHMO.data('lineid');
            let code = selectedRowHMO.data('code');

            if (lineId) {
                deletedRowsHMO.push({
                    lineId: lineId,
                    code: code,
                    action: 'delete'
                });
            }

            selectedRowHMO.remove();
            selectedRowHMO = null;

            reNumberRowsHMO();
            toggleSaveButtonHMO();

            console.log('Deleted Rows:', deletedRowsHMO);
        }

        // =========================
        // DOCUMENT READY
        // =========================
        $(document).ready(function () {

            // =========================
            // LOAD DATA
            // =========================
            function loadHMORecords(data) {
                $('#hmoTable tbody').empty();

                if (
                        !data ||
                        data.length === 0 ||
                        data.every(item =>
                            !item.firstName &&
                            !item.middleName &&
                            !item.lastName &&
                            !item.birthDate &&
                            !item.relationship &&
                            !item.civilStatus &&
                            !item.gender &&
                            !item.hmoId
                        )
                    ) {
                    $('#hmoTable tbody').html(`
                        <tr id="noDataRowHMO">
                            <td colspan="14" class="text-center">No data available</td>
                        </tr>
                    `);
                    return;
                }

                rowIndexHMO = 0;

                data.forEach(item => {
                    rowIndexHMO++;

                    let row = $(`
                        <tr data-lineid="${item.lineId}" data-code="${item.code}">
                            <td class="row-number">${rowIndexHMO}</td>
                            <td><input type="text" class="form-control form-control-sm firstName" value="${item.firstName ?? ''}" oninput="capitalizeWords(this)" disabled></td>
                            <td><input type="text" class="form-control form-control-sm middleName" value="${item.middleName ?? ''}" oninput="capitalizeWords(this)" disabled></td>
                            <td><input type="text" class="form-control form-control-sm lastName" value="${item.lastName ?? ''}" oninput="capitalizeWords(this)" disabled></td>
                            <td><input type="date" class="form-control form-control-sm birthDate" value="${item.birthDate ?? ''}" disabled></td>
                            <td>
                                <select class="form-control form-control-sm relationship" disabled>
                                    <option value=""></option>
                                    <option value="Spouse" ${item.relationship === 'Spouse' ? 'selected' : ''}>Spouse</option>
                                    <option value="Parent" ${item.relationship === 'Parent' ? 'selected' : ''}>Parent</option>
                                    <option value="Father" ${item.relationship === 'Father' ? 'selected' : ''}>Father</option>
                                    <option value="Mother" ${item.relationship === 'Mother' ? 'selected' : ''}>Mother</option>
                                    <option value="Sibling" ${item.relationship === 'Sibling' ? 'selected' : ''}>Sibling</option>
                                    <option value="Brother" ${item.relationship === 'Brother' ? 'selected' : ''}>Brother</option>
                                    <option value="Sister" ${item.relationship === 'Sister' ? 'selected' : ''}>Sister</option>
                                    <option value="Child" ${item.relationship === 'Child' ? 'selected' : ''}>Child</option>
                                    <option value="Son" ${item.relationship === 'Son' ? 'selected' : ''}>Son</option>
                                    <option value="Daughter" ${item.relationship === 'Daughter' ? 'selected' : ''}>Daughter</option>
                                    <option value="Relative" ${item.relationship === 'Relative' ? 'selected' : ''}>Relative</option>
                                    <option value="Guardian" ${item.relationship === 'Guardian' ? 'selected' : ''}>Guardian</option>
                                    <option value="Friend" ${item.relationship === 'Friend' ? 'selected' : ''}>Friend</option>
                                    <option value="Partner" ${item.relationship === 'Partner' ? 'selected' : ''}>Partner</option>
                                    <option value="Colleague" ${item.relationship === 'Colleague' ? 'selected' : ''}>Colleague</option>
                                    <option value="Other" ${item.relationship === 'Other' ? 'selected' : ''}>Other</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control form-control-sm civilStatus" disabled>
                                    <option value="">Select Civil Status</option>
                                    <option value="Single" ${item.civilStatus === 'Single' ? 'selected' : ''}>Single</option>
                                    <option value="Married" ${item.civilStatus === 'Married' ? 'selected' : ''}>Married</option>
                                    <option value="Divorced" ${item.civilStatus === 'Divorced' ? 'selected' : ''}>Divorced</option>
                                    <option value="Widowed" ${item.civilStatus === 'Widowed' ? 'selected' : ''}>Widowed</option>
                                    <option value="N/A" ${item.civilStatus === 'N/A' ? 'selected' : ''}>N/A</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control form-control-sm gender" disabled>
                                    <option value="">Select Gender</option>
                                    <option value="Male" ${item.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${item.gender === 'Female' ? 'selected' : ''}>Female</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control form-control-sm hmoDependent" disabled>
                                    <option value="">Select</option>
                                    <option value="1" ${item.hmoDependent == '1' ? 'selected' : ''}>Yes</option>
                                    <option value="0" ${item.hmoDependent == '0' ? 'selected' : ''}>No</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm hmoId" value="${item.hmoId ?? ''}" disabled></td>
                            <td><input type="date" class="form-control form-control-sm startDate" value="${item.startDate ?? ''}" disabled></td>
                            <td><input type="date" class="form-control form-control-sm renewalDate" value="${item.renewalDate ?? ''}" disabled></td>
                            <td>
                                ${item.attachment ? `<a href="${item.attachment}" target="_blank">View</a>` : ''}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger deleteRowBtnHMO d-none">X</button>
                            </td>
                        </tr>
                    `);

                    row.data('original', {
                        firstName: item.firstName ?? '',
                        middleName: item.middleName ?? '',
                        lastName: item.lastName ?? '',
                        birthDate: item.birthDate ?? '',
                        relationship: item.relationship ?? '',
                        civilStatus: item.civilStatus ?? '',
                        gender: item.gender ?? '',
                        hmoDependent: item.hmoDependent ?? '',
                        hmoId: item.hmoId ?? '',
                        startDate: item.startDate ?? '',
                        renewalDate: item.renewalDate ?? ''
                    });

                    row.data('dirty', false);

                    $('#hmoTable tbody').append(row);
                });
            }

            loadHMORecords(hmoRecords);

            // =========================
            // DELETE CLICK (CONFIRM)
            // =========================
            $(document).on('click', '.deleteRowBtnHMO', function () {
                selectedRowHMO = $(this).closest('tr');

                fbconfirm(
                    'Confirm Delete',
                    'Do you want to continue deleting this row?',
                    'Yes',
                    'Cancel',
                    'submit_delete_hmo()'
                );
            });

            // =========================
            // EDIT TOGGLE
            // =========================
            $('#editTableBtnHMO').on('click', function () {
                isEditingHMO = !isEditingHMO;

                $('#editSectionHMO').toggle(isEditingHMO);
                $('#addTableRowBtnHMO').prop('disabled', !isEditingHMO);
                $('#hmoTable input, #hmoTable select').prop('disabled', !isEditingHMO);

                $('.deleteRowBtnHMO').toggleClass('d-none', !isEditingHMO);

                if (!isEditingHMO) {

                    $('#hmoTable tbody tr').each(function () {

                        let original = $(this).data('original');

                        // REMOVE newly added rows
                        if (!original) {
                            $(this).remove();
                            return;
                        }

                        // RESET existing rows
                        $(this).find('.firstName').val(original.firstName);
                        $(this).find('.middleName').val(original.middleName);
                        $(this).find('.lastName').val(original.lastName);
                        $(this).find('.birthDate').val(original.birthDate);
                        $(this).find('.relationship').val(original.relationship);
                        $(this).find('.civilStatus').val(original.civilStatus);
                        $(this).find('.gender').val(original.gender);
                        $(this).find('.hmoDependent').val(original.hmoDependent);
                        $(this).find('.hmoId').val(original.hmoId);
                        $(this).find('.startDate').val(original.startDate);
                        $(this).find('.renewalDate').val(original.renewalDate);

                        $(this).data('dirty', false);
                    });

                    // restore numbering
                    reNumberRowsHMO();

                    // restore no data row if needed
                    if ($('#hmoTable tbody tr').length === 0) {
                        $('#hmoTable tbody').html(`
                            <tr id="noDataRowHMO">
                                <td colspan="14" class="text-center">No data available</td>
                            </tr>
                        `);
                    }

                    deletedRowsHMO = [];

                    $('#saveTableBtnHMO').addClass('d-none');
                }
            });

            // =========================
            // ADD ROW
            // =========================
            $('#addTableRowBtnHMO').on('click', function () {
                $('#noDataRowHMO').remove();

                rowIndexHMO++;

                let row = $(`
                    <tr>
                        <td class="row-number">${rowIndexHMO}</td>
                        <td><input type="text" class="form-control form-control-sm firstName" placeholder="First Name" oninput="capitalizeWords(this)"></td>
                        <td><input type="text" class="form-control form-control-sm middleName" placeholder="Middle Name" oninput="capitalizeWords(this)"></td>
                        <td><input type="text" class="form-control form-control-sm lastName" placeholder="Last Name" oninput="capitalizeWords(this)"></td>
                        <td><input type="date" class="form-control form-control-sm birthDate"></td>
                        <td>
                            <select class="form-control form-control-sm relationship">
                                <option value=""></option>
                                <option value="Spouse">Spouse</option>
                                <option value="Parent">Parent</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Child">Child</option>
                                <option value="Son">Son</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Relative">Relative</option>
                                <option value="Guardian">Guardian</option>
                                <option value="Friend">Friend</option>
                                <option value="Partner">Partner</option>
                                <option value="Colleague">Colleague</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm civilStatus">
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm hmoDependent">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm hmoId" placeholder="HMO Id"></td>
                        <td><input type="date" class="form-control form-control-sm startDate"></td>
                        <td><input type="date" class="form-control form-control-sm renewalDate"></td>
                        <td><input type="file" class="form-control form-control-sm attachment"></td>
                        <td><button type="button" class="btn btn-sm btn-danger deleteRowBtnHMO">X</button></td>
                    </tr>
                `);

                row.data('lineid', null);
                row.data('code', null);
                row.data('dirty', true);

                $('#hmoTable tbody').append(row);

                toggleSaveButtonHMO();
            });

            // =========================
            // TRACK CHANGES
            // =========================
            $(document).on('input change', '#hmoTable input, #hmoTable select', function () {
                let row = $(this).closest('tr');
                let original = row.data('original');

                if (!original) {
                    row.data('dirty', true);
                    toggleSaveButtonHMO();
                    return;
                }

                let current = {
                    firstName: row.find('.firstName').val(),
                    middleName: row.find('.middleName').val(),
                    lastName: row.find('.lastName').val(),
                    birthDate: row.find('.birthDate').val(),
                    relationship: row.find('.relationship').val(),
                    civilStatus: row.find('.civilStatus').val(),
                    gender: row.find('.gender').val(),
                    hmoDependent: row.find('.hmoDependent').val(),
                    hmoId: row.find('.hmoId').val(),
                    startDate: row.find('.startDate').val(),
                    renewalDate: row.find('.renewalDate').val()
                };

                row.data('dirty', JSON.stringify(original) !== JSON.stringify(current));

                toggleSaveButtonHMO();
            });

        });
    </script>
@endsection