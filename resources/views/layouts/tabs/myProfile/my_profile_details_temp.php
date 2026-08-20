<div class="row" style=" padding: 20px;">
    <div class="col-md-12 col-lg-3 mb-4">
        <div class="row">
            <!-- EMERGENCY CONTACTS -->
            <div class="col-xl-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-custom">
                        <!-- CARD HEADER WITH EDIT BUTTON -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-calendar me-1"></i>
                                Emergency Contact
                            </div>

                            <button class="btn btn-sm btn-light" id="editTableBtn">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body">
                            <table id="trainingTable" class="table table-bordered">
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
                                            <button type="button" id="addTableRowBtn" class="btn btn-sm btn-primary"
                                                disabled>
                                                +
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="noDataRow">
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                            <div id="editSection" style="display:none; margin-top:15px;">

                                <div class="mb-2">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" id="editReason" rows="2"></textarea>
                                </div>



                                <!-- <div class="d-flex justify-content-between"> -->
                                <!-- <button class="btn btn-primary btn-sm" id="addEditRowBtn" style="display:none;">
                                                                                            <i class="fa-solid fa-plus"></i> Add Row
                                                                                        </button> -->
                                <div class="text-end">
                                    <button class="btn btn-success btn-sm" id="saveTableBtn" style=" margin-top:15px;">
                                        <i class="fa-solid fa-save"></i> Save
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EDUCATION -->
            <div class="col-xl-6">

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-custom">
                        <!-- CARD HEADER WITH EDIT BUTTON -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-calendar me-1"></i>
                                Education
                            </div>

                            <button class="btn btn-sm btn-light" id="editTableBtn">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body">
                            <table id="trainingTable" class="table table-bordered">
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
                                            <button type="button" id="addTableRowBtn" class="btn btn-sm btn-primary"
                                                disabled>
                                                +
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="noDataRow">
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                            <div id="editSection" style="display:none; margin-top:15px;">

                                <div class="mb-2">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" id="editReason" rows="2"></textarea>
                                </div>



                                <!-- <div class="d-flex justify-content-between"> -->
                                <!-- <button class="btn btn-primary btn-sm" id="addEditRowBtn" style="display:none;">
                                                                                            <i class="fa-solid fa-plus"></i> Add Row
                                                                                        </button> -->
                                <div class="text-end">
                                    <button class="btn btn-success btn-sm" id="saveTableBtn" style=" margin-top:15px;">
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


    <div class="col-md-12 col-lg-3 mb-4">
        <div class="row">
            <!-- Employment History -->
            <div class="col-xl-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-custom">
                        <!-- CARD HEADER WITH EDIT BUTTON -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-calendar me-1"></i>
                                Employment History
                            </div>

                            <button class="btn btn-sm btn-light" id="editTableBtn">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body">
                            <table id="trainingTable" class="table table-bordered">
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
                                            <button type="button" id="addTableRowBtn" class="btn btn-sm btn-primary"
                                                disabled>
                                                +
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="noDataRow">
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                            <div id="editSection" style="display:none; margin-top:15px;">

                                <div class="mb-2">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" id="editReason" rows="2"></textarea>
                                </div>



                                <!-- <div class="d-flex justify-content-between"> -->
                                <!-- <button class="btn btn-primary btn-sm" id="addEditRowBtn" style="display:none;">
                                                                                            <i class="fa-solid fa-plus"></i> Add Row
                                                                                        </button> -->
                                <div class="text-end">
                                    <button class="btn btn-success btn-sm" id="saveTableBtn" style=" margin-top:15px;">
                                        <i class="fa-solid fa-save"></i> Save
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Training and Seminar -->
            <div class="col-xl-6">

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-custom">
                        <!-- CARD HEADER WITH EDIT BUTTON -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-calendar me-1"></i>
                                Training and Seminar
                            </div>

                            <button class="btn btn-sm btn-light" id="editTableBtn">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body">
                            <table id="trainingTable" class="table table-bordered">
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
                                            <button type="button" id="addTableRowBtn" class="btn btn-sm btn-primary"
                                                disabled>
                                                +
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="noDataRow">
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                            <div id="editSection" style="display:none; margin-top:15px;">

                                <div class="mb-2">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" id="editReason" rows="2"></textarea>
                                </div>



                                <!-- <div class="d-flex justify-content-between"> -->
                                <!-- <button class="btn btn-primary btn-sm" id="addEditRowBtn" style="display:none;">
                                                                                            <i class="fa-solid fa-plus"></i> Add Row
                                                                                        </button> -->
                                <div class="text-end">
                                    <button class="btn btn-success btn-sm" id="saveTableBtn" style=" margin-top:15px;">
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
    <!--HMO / DEPENDENT -->
    <div class="col-md-12 col-lg-3 mb-4">
        <div class="col-xl-12">

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-custom">
                    <!-- CARD HEADER WITH EDIT BUTTON -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa-solid fa-calendar me-1"></i>
                            HMO / Dependent
                        </div>

                        <button class="btn btn-sm btn-light" id="editTableBtn">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>

                    <!-- CARD BODY -->
                    <div class="card-body">
                        <table id="trainingTable" class="table table-bordered">
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
                                        <button type="button" id="addTableRowBtn" class="btn btn-sm btn-primary"
                                            disabled>
                                            +
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr id="noDataRow">
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- EXTRA ACTION SECTION (HIDDEN BY DEFAULT) -->
                        <div id="editSection" style="display:none; margin-top:15px;">

                            <div class="mb-2">
                                <label class="form-label">Reason</label>
                                <textarea class="form-control" id="editReason" rows="2"></textarea>
                            </div>



                            <!-- <div class="d-flex justify-content-between"> -->
                            <!-- <button class="btn btn-primary btn-sm" id="addEditRowBtn" style="display:none;">
                                                                                            <i class="fa-solid fa-plus"></i> Add Row
                                                                                        </button> -->
                            <div class="text-end">
                                <button class="btn btn-success btn-sm" id="saveTableBtn" style=" margin-top:15px;">
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


<script>
    $(document).ready(function () {
        let rowIndex = 0;

        // Toggle edit section and enable table + button
        $('#editTableBtn').on('click', function () {
            $('#editSection').slideToggle(function () {
                // This runs after the toggle animation
                let isVisible = $('#editSection').is(':visible');
                $('#addTableRowBtn').prop('disabled', !isVisible);
            });
        });

        // Add row function
        function addNewRow() {
            // Remove "No data available" row if exists
            $('#noDataRow').remove();

            rowIndex++;
            let newRow = `
                                                <tr>
                                                    <td class="row-number">${rowIndex}</td>
                                                    <td><input type="text" class="form-control form-control-sm description" required></td>
                                                    <td><input type="date" class="form-control form-control-sm date-from" required></td>
                                                    <td><input type="date" class="form-control form-control-sm date-to" required></td>
                                                    <td><input type="text" class="form-control form-control-sm location" required></td>
                                                    <td><input type="file" class="form-control form-control-sm attachment"></td>
                                                    <td><button type="button" class="btn btn-sm btn-danger deleteRowBtn">X</button></td>
                                                </tr>
                                            `;
            $('#trainingTable tbody').append(newRow);
        }

        // Bind add row buttons
        $('#addTableRowBtn').on('click', addNewRow);
        // $('#addEditRowBtn').on('click', addNewRow);

        // Delete row
        $(document).on('click', '.deleteRowBtn', function () {
            $(this).closest('tr').remove();
            reNumberRows();
            checkEmptyTable();
        });

        // Re-number rows
        function reNumberRows() {
            rowIndex = 0;
            $('#trainingTable tbody tr').each(function () {
                rowIndex++;
                $(this).find('.row-number').text(rowIndex);
            });
        }

        // Show "No data available" if table empty
        function checkEmptyTable() {
            if ($('#trainingTable tbody tr').length === 0) {
                $('#trainingTable tbody').html('<tr id="noDataRow"><td colspan="7" class="text-center">No data available</td></tr>');
            }
        }

        // Initial check
        checkEmptyTable();

        // Save table
        $('#saveTableBtn').on('click', function () {
            if ($('#trainingTable tbody tr').length === 0 || $('#trainingTable tbody tr').attr('id') === 'noDataRow') {
                alert("Please add at least one training record.");
                return;
            }

            let formData = new FormData();
            let tableData = [];
            let isValid = true;

            $('#trainingTable tbody tr').each(function (index) {
                let description = $(this).find('.description').val()?.trim();
                let dateFrom = $(this).find('.date-from').val();
                let dateTo = $(this).find('.date-to').val();
                let location = $(this).find('.location').val()?.trim();
                let fileInput = $(this).find('.attachment')[0];
                let file = fileInput?.files[0];

                if (!description || !dateFrom || !dateTo || !location) {
                    alert("Please complete all required fields.");
                    isValid = false;
                    return false;
                }

                if (dateFrom > dateTo) {
                    alert("Date-From cannot be later than Date-To.");
                    isValid = false;
                    return false;
                }

                tableData.push({
                    description: description,
                    date_from: dateFrom,
                    date_to: dateTo,
                    location: location
                });

                if (file) {
                    formData.append('file_' + index, file);
                }
            });

            if (!isValid) return;

            let reason = $('#editReason').val()?.trim();
            if (!reason) {
                alert("Please enter a reason.");
                return;
            }

            formData.append('reason', reason);
            formData.append('tableData', JSON.stringify(tableData));

            console.log("Final Data:", tableData);
            console.log("Reason:", reason);

            // AJAX submission (uncomment when ready)
            /*
            $.ajax({
                url: '/your-save-url',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert("Saved successfully!");
                    location.reload();
                },
                error: function () {
                    alert("Something went wrong.");
                }
            });
            */
        });
    });
</script>

<!-- PROFILE CARD -->
<!-- <div class="col-md-6">
                                                                <div class="card-custom">
                                                                    <form method="POST" action="#" enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="image-container">
                                                                            <img id="profilePreview" src="{{ asset('images/default-avatar.png') }}"
                                                                                alt="Profile">

                                                                            <label for="photo-upload" class="edit-overlay">
                                                                                <span> Change Photo</span>
                                                                            </label>

                                                                            <input type="file" id="photo-upload" name="photo" hidden
                                                                                accept="image/*">
                                                                        </div>

                                                                        <div class="text-center mt-2">
                                                                            <button type="submit" class="btn btn-success btn-sm d-none"
                                                                                id="savePhotoBtn">
                                                                                Save Photo
                                                                            </button>
                                                                        </div>
                                                                    </form>

                                                                    <div class="text-center mt-2">
                                                                        <h5 class="mb-1">Profile Picture</h5>
                                                                    </div>
                                                                </div>
                                                            </div> -->

<!-- SIGNATURE CARD -->
<!-- <div class="col-md-6">
                                                                <div class="card-custom">

                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <strong>Signature</strong>
                                                                        <button type="button" class="btn btn-sm btn-light" id="editSignatureBtn">
                                                                            <i class="fas fa-pen-to-square"></i>
                                                                        </button>
                                                                    </div>

                                                                    <form method="POST" action="#" enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="signature-display">
                                                                            <img id="signaturePreview" src=""
                                                                                style="max-height:80px; display:none;">

                                                                            <div class="signature-placeholder" id="signaturePlaceholder">
                                                                                No signature uploaded
                                                                            </div>

                                                                            <input type="file" id="signatureInput" name="signature" hidden
                                                                                accept="image/*">
                                                                        </div>

                                                                        <div class="text-end mt-2">
                                                                            <button type="submit" class="btn btn-success btn-sm d-none"
                                                                                id="saveSignatureBtn">
                                                                                Save Signature
                                                                            </button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div> -->