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
            /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); */
            overflow: hidden;
            padding: 20px;
            /* border: 1px solid black; */
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
    </style>
    <?php
    // echo json_encode($my_profile_payroll);
    // return;
                                ?>

    <div class="container-fluid mt-4 card-container" style="margin-bottom: 80px;">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- <div class="row"> -->
                        <!-- LEFT SIDE -->
                        <!-- <div class="col-md-6 mb-4"> -->
                        <!-- <div class="row"> -->


                        <!-- </div> -->
                        <!-- </div> -->
                        <!-- </div> -->
                        <!-- RIGHT SIDE -->
                        <div class="col-md-12 col-lg-9">
                            <div class="card-custom position-relative">

                                <!-- <button type="button" class="btn btn-sm btn-light position-absolute edit-btn"
                                    style="top:15px; right:15px;">
                                    <i class="fas fa-pen-to-square"></i>
                                </button> -->

                                <h5 class="mb-3">Employment Information</h5>
                                <hr>

                                <form method="POST" action="#">
                                    @csrf

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>PREVIOUS INFO</strong></label>
                                 
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Department</strong></label>
                                            <input type="email" class="form-control edit-field" id="firstName"
                                                name="firstName"
                                                value="{{ $my_profile_payroll_previous[0]->DepartmentName ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Division</strong></label>
                                            <input type="email" class="form-control edit-field" id="firstName"
                                                name="firstName"
                                                value="{{ $my_profile_payroll_previous[0]->DivisionName ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Position</strong></label>
                                            <input type="text" class="form-control edit-field" id="middleName"
                                                name="middleName"
                                                value="{{ $my_profile_payroll_previous[0]->PositionName ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Employment Status</strong></label>
                                            <input type="text" class="form-control edit-field" id="lastName" name="lastName"
                                                value="{{ $my_profile_payroll_previous[0]->LaborName ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Rate</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_payroll_previous[0]->rate ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Rate Type</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ 
                                                            match ($my_profile_payroll_previous[0]->rateType ?? '') {
            'M' => 'Monthly',
            'SM' => 'Semi-Monthly',
            'W' => 'Weekly',
            default => 'N/A'
        }
                                                        }}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>From</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_payroll_previous[0]->dateEffective ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>To</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_payroll_previous[0]->dateEnd ?? "N/A"}}" disabled>
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>CURRENT INFO</strong></label>
                                        
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label><strong>Department</strong></label>
                                            <input type="email" class="form-control edit-field" id="firstName"
                                                name="firstName"
                                                value="{{ $my_profile_payroll[0]->DepartmentName ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Division</strong></label>
                                            <input type="email" class="form-control edit-field" id="firstName"
                                                name="firstName" value="{{ $my_profile_payroll[0]->DivisionName ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Position</strong></label>
                                            <input type="text" class="form-control edit-field" id="middleName"
                                                name="middleName" value="{{ $my_profile_payroll[0]->PositionName ?? "N/A"}}"
                                                disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Employment Status</strong></label>
                                            <input type="text" class="form-control edit-field" id="lastName" name="lastName"
                                                value="{{ $my_profile_payroll[0]->LaborName ?? "N/A"}}" disabled>
                                        </div>
                                       <div class="col-md-3" hidden>
                                            <label><strong>Rate</strong></label>

                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control edit-field"
                                                    id="rateField"
                                                    value="{{ $my_profile_payroll[0]->rate ?? 'N/A' }}"
                                                    readonly>

                                                <button class="btn btn-outline-secondary" type="button" onclick="toggleVisibility('rateField')">
                                                    <i class="fa fa-eye" id="rateIcon"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-3" hidden>
                                            <label><strong>Allowance</strong></label>

                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control edit-field"
                                                    id="allowanceField"
                                                    value="{{ $my_profile_payroll[0]->allowance ?? 'N/A' }}"
                                                    readonly>

                                                <button class="btn btn-outline-secondary" type="button" onclick="toggleVisibility('allowanceField')">
                                                    <i class="fa fa-eye" id="allowanceIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <script>
                                        function toggleVisibility(fieldId) {
                                            const field = document.getElementById(fieldId);
                                            const icon = document.querySelector(`#${fieldId.replace('Field','Icon')}`);

                                            if (field.type === "password") {
                                                field.type = "text";
                                                icon.classList.remove("fa-eye");
                                                icon.classList.add("fa-eye-slash");
                                            } else {
                                                field.type = "password";
                                                icon.classList.remove("fa-eye-slash");
                                                icon.classList.add("fa-eye");
                                            }
                                        }
                                        </script>
                                        <div class="col-md-3">
                                            <label><strong>Rate Type</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ 
                                                            match ($my_profile_payroll[0]->rateType ?? '') {
            'M' => 'Monthly',
            'SM' => 'Semi-Monthly',
            'W' => 'Weekly',
            default => 'N/A'
        }
                                                        }}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>From</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_payroll[0]->dateEffective ?? "N/A"}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>To</strong></label>
                                            <input type="text" class="form-control edit-field" id="suffix" name="suffix"
                                                value="{{ $my_profile_payroll[0]->dateEnd ?? "N/A"}}" disabled>
                                        </div>
                                    </div>


                                </form>


                                <div class="row" style="margin-top: 50px">


                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border">
                                            <!-- <div class="card-custom"> -->
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fa-solid fa-box-open me-1"></i>
                                                    Accountability Items
                                                </div>
                                                <!-- <button class="btn btn-sm btn-light" id="editTableBtn">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button> -->
                                            </div>

                                            <div class="card-body">
                                                <table id="accountabilityTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th>Item</th>
                                                            <th>Description</th>
                                                            <th>Status</th>
                                                            <th>Remarks</th>
                                                            <th>Penalty</th>
                                                            <th>Attachment</th>
                                                            <th></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($my_profile_payroll_accoutability as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->item_name ?? 'N/A' }}</td>
                                                                <td>{{ $item->itemDescription ?? 'N/A' }}</td>
                                                                <td>{{ $item->status ?? 'N/A' }}</td>
                                                                <td>{{ $item->remarks ?? 'N/A' }}</td>
                                                                <td>{{ $item->penaltyAmount ?? 'N/A' }}</td>
                                                                <td>{{ $item->docFile ?? 'N/A' }}</td>
                                                                <td>VIEW FILE</td>


                                                            </tr>
                                                        @empty
                                                            <tr id="noDataRow">
                                                                <td colspan="8" class="text-center">No accountability items
                                                                    found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border">
                                            <!-- <div class="card-custom"> -->
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fa-solid fa-box-open me-1"></i>
                                                    Loan Overview
                                                </div>
                                                <!-- <button class="btn btn-sm btn-light" id="editTableBtn">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button> -->
                                            </div>

                                            <div class="card-body">
                                                <table id="accountabilityTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th>Loan Description</th>
                                                            <th>Loan Date</th>
                                                            <th>Loan Amount</th>
                                                            <th>Interest</th>
                                                            <th>Amortization</th>
                                                            <th>Date Effective</th>
                                                            <th>Date End</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($my_profile_payroll_loan as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->deductionName ?? 'N/A' }}</td>
                                                                <td>{{ $item->loanDate ?? 'N/A' }}</td>
                                                                <td>{{ $item->loanAmount ?? 'N/A' }}</td>
                                                                <td>{{ $item->interest ?? 'N/A' }}</td>
                                                                <td>{{ $item->amount ?? 'N/A' }}</td>
                                                                <td>{{ $item->dateEffective ?? 'N/A' }}</td>
                                                                <td>{{ $item->dateEnd ?? 'N/A' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr id="noDataRow">
                                                                <td colspan="8" class="text-center">No Loans
                                                                    found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="card mb-4 shadow-sm border">
                                            <!-- <div class="card-custom"> -->
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fa-solid fa-box-open me-1"></i>
                                                    Leave Type
                                                </div>
                                                <!-- <button class="btn btn-sm btn-light" id="editTableBtn">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button> -->
                                            </div>

                                            <div class="card-body">
                                                <table id="accountabilityTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th>Leave Type</th>
                                                            <th>Balance</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($my_profile_payroll_leave as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->leaveName ?? 'N/A' }}</td>
                                                                <td>{{ $item->leaveBalance ?? 'N/A' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr id="noDataRow">
                                                                <td colspan="3" class="text-center">No Leaves
                                                                    found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                    <div class="card mb-4 shadow-sm border">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa-solid fa-calendar me-1"></i>
                                                Year To Date
                                            </div>
                                            <div>
                                                <label class="me-1"><strong>Select Tax Year:</strong></label>
                                                <select id="ddl_tax_years" class="form-select d-inline w-auto" onchange="show_emp_ytd()">
                                                    <option value=""></option>
                                                    @foreach($emp_ytd_tax_years['rows'] as $row)
                                                        <option value="{{ $row->taxYear }}">{{ $row->taxYear }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <a href="" class="aFocus" id="ytdlbl"></a>
                                        <div class="card-body" id="divYTD">
                                            <p class="text-muted">Please select a tax year to load YTD data.</p>
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
    function show_emp_ytd() {
        var taxYear = document.getElementById('ddl_tax_years').value;

        var formData = new FormData();
        formData.append('year', taxYear);

        GlovalHTMLObjLoading(1, 'divYTD');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{ url("/emp_ytd") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#divYTD').html(response);
            },
            error: function (msg) {
                alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }
        });
    }
</script>
@endsection