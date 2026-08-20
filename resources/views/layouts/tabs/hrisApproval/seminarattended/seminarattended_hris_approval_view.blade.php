<div class="modal-header border-bottom">
    <h5 class="modal-title">Training / Seminar Changes</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body modal-large">

    @if(!empty($new))

    

        @php
            $identityNew = $new;
            $identityOld = $old ?? [];
            $firstRecord = $identityNew[0] ?? reset($identityNew);

            function normalizeKey($key)
            {
                return strtolower(str_replace('_', ' ', $key));
            }

            function findValue($arr, $targetKey)
            {
                foreach ($arr as $k => $v) {
                    if (normalizeKey($k) === normalizeKey($targetKey)) {
                        return $v;
                    }
                }
                return '-';
            }
        @endphp

        <!-- HEADER -->
        <div class="mb-4 fs-5">
            <div><strong>Request No.:</strong> {{ $firstRecord->Request_No ?? '-' }}</div>
            <div><strong>Employee Id:</strong> {{ $firstRecord->identityId ?? '-' }}</div>
             <div>
                <strong>Employee Name:</strong>
                {{ $firstRecord->Employee_Name ?? '-' }}
            </div>
            <div><strong>Requested By:</strong> {{ $firstRecord->Requested_By ?? '-' }}</div>
            <div><strong>Request Date:</strong> {{ $firstRecord->Request_Date ?? '-' }}</div>
        </div>

        @foreach($identityNew as $idx => $newRecord)

           @php
                $oldRecord = $identityOld[$idx] ?? [];
                $newArr = (array) $newRecord;
                $oldArr = (array) $oldRecord;

                $excludeKeys = [
                    'Employee_Code',
                    'Employee_Id',
                    'Request_No',
                    'Requested_By',
                    'Request_Date',
                    'Employee Code',
                    'Employee Id',
                    'arrCount',
                    'Employee_Name',
                    'identityId',
                    'Line_Id'
                ];

                // Merge keys from BOTH old and new data
                $displayKeys = [];
                $allKeys = array_merge(array_keys($oldArr), array_keys($newArr));
                $allKeys = array_unique($allKeys); // Remove duplicates

                foreach ($allKeys as $key) {
                    if (!in_array($key, $excludeKeys)) {
                        $displayKeys[] = $key;
                    }
                }

                $requestKey = $newRecord->Request_No ?? $idx;
            @endphp

            <div class="scrollable table-wrapper">

                <table class="table table-bordered table-lg">

                    <thead>
                        <tr class="table-head">
                            <th style="width:140px;"></th>

                            @foreach($displayKeys as $colKey)
                                <th>{{ $colKey }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        <!-- OLD DATA (RED) -->
                        <tr class="old-text">
                            <td><b>Old Data</b></td>

                            @foreach($displayKeys as $colKey)
                                <td class="old-text">
                                    {{ findValue($oldArr, $colKey) }}
                                </td>
                            @endforeach
                        </tr>

                        <!-- NEW DATA -->
                        <tr>
                            <td><b>New Data</b></td>

                            @foreach($displayKeys as $colKey)
                                <td>
                                    {{ findValue($newArr, $colKey) }}
                                </td>
                            @endforeach
                        </tr>

                    </tbody>

                </table>
            </div>

            <!-- BUTTONS -->
            <div class="mb-4">
                <button class="btn btn-primary btn-approve" data-request-no="{{ $requestKey }}"
                    data-employee-id="{{ $newRecord->identityId ?? '' }}"
                    onclick="confirm_approve('{{ $requestKey }}', '{{ $newRecord->identityId ?? '' }}')">
                    <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                    Approve
                </button>

                <button class="btn btn-danger btn-disapprove" data-request-no="{{ $requestKey }}"
                    data-employee-id="{{ $newRecord->identityId ?? '' }}"
                    onclick="confirm_disapprove('{{ $requestKey }}', '{{ $newRecord->identityId ?? '' }}')">
                    <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                    Disapprove
                </button>
            </div>

        @endforeach

    @else
        <div class="alert alert-info">No pending changes</div>
    @endif

    <!-- ERROR MESSAGE -->
    <div id="error_message" style="display:none;" class="alert alert-danger mt-3">
        <span id="error_message_text"></span>
    </div>

    <!-- SUCCESS MESSAGE -->
    <div id="success_message" style="display:none;" class="alert alert-success mt-3">
        <span id="success_message_text"></span>
    </div>

</div>

<style>
    .modal-dialog {
        max-width: 80%;
    }

    .modal-large {
        min-height: 50vh;
    }

    .table-lg td,
    .table-lg th {
        padding: 14px;
        font-size: 15px;
    }

    .table-head th {
        background: #f1f1f1;
    }

    .old-text {
        color: #dc3545;
        font-weight: 500;
    }

    .table-wrapper {
        overflow-x: auto;
    }
</style>

<script>
    let submitData = {};

    function confirm_approve(requestNo, employeeId) {
        confirm_submit('approve', requestNo, employeeId);
    }

    function confirm_disapprove(requestNo, employeeId) {
        confirm_submit('disapprove', requestNo, employeeId);
    }

    function confirm_submit(action, requestNo, employeeId) {
        // Validation
        if (!requestNo || !employeeId) {
            $('#error_message_text').text("Missing required data (Request No or Employee ID)");
            $('#error_message').show();
            return false;
        }

        // Store data globally
        submitData = {
            action: action,
            request_no: requestNo,
            employee_id: employeeId
        };

        // Back to top
        window.scrollTo(0, 0);

        // Call confirmation dialog
        const actionText = action.charAt(0).toUpperCase() + action.slice(1);
        fbconfirm('Confirm ' + actionText, `Do you want to ${action} this request? `, 'Yes', 'Cancel', 'submit_approval()');
    }

    function submit_approval() {
        $('#error_message').hide();
        $('#success_message').hide();

        $.ajax({
            url: '{{ route('hris_approval_seminarattended_submit') }}',
            type: "POST",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}',
                request_no: submitData.request_no,
                employee_id: submitData.employee_id,
                action: submitData.action
            },
            success: function (response) {
                if (response.success) {
                    $('#success_message_text').text(response.message);
                    $('#success_message').show();
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    $('#error_message_text').text(response.message);
                    $('#error_message').show();
                }
            },
            error: function (xhr) {
                // Only network/validation errors reach here now
                const errorMsg = xhr.responseJSON?.message || 'Network error occurred';
                $('#error_message_text').text(errorMsg);
                $('#error_message').show();
            }
        });
    }
</script>