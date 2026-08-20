<style>
      .clearance-table th {
            font-size: 14px;
            background: #f8f9fa;
      }

      .clearance-table td {
            font-size: 14px;
            vertical-align: middle;
      }

      .clearance-table textarea {
            resize: vertical;
            min-height: 60px;
      }

      .status-select {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
      }

      .approved-text {
            color: green;
            font-weight: 500;
      }

      .denied-text {
            color: red;
            font-weight: 500;
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


<div class="modal-header">
      <h5 class="modal-title">
            Clearance Form ({{ $id }}) Decision
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
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
      <table class="table table-bordered clearance-table">
            <thead>
                  <tr>
                        <th>Department / Division</th>
                        <th>Item(s) for Clearing</th>
                        <th>Comments</th>
                        <th width="140">Status</th>
                        <th>Cleared By / Date</th>
                  </tr>
            </thead>

            <tbody>

                  @foreach($clearance_approval_details as $row)

                        <tr>

                              <td>{{ $row->departmentName }}</td>

                              <td>{{ $row->cfClearanceItems }}</td>

                              <td>
                                    <textarea maxlength="100"
                                    class="form-control cfRemarks"
                                    {{ ($row->cfApprovedDateTime || $row->cfDateModified) ? 'readonly' : '' }}>
                                    {{ $row->cfRemarks }}
                                    </textarea>
                              </td>

                              <td>
                                    <select class="form-control cfStatus"
                                    {{ ($row->cfApprovedDateTime || $row->cfDateModified) ? 'disabled' : '' }}>

                                    <option value="">Select option</option>

                                    <option value="A" {{ $row->cfStatus == 'A' ? 'selected' : '' }}>
                                    Approved
                                    </option>

                                    <option value="D" {{ $row->cfStatus == 'D' ? 'selected' : '' }}>
                                    Denied
                                    </option>

                                    </select>
                              </td>

                              <td>
                                    @if($row->cfDateModified)
                                          {{ $row->cfApproverName }} / {{ $row->cfApprovedDateTime }}
                                    @else
                                          N/A
                                    @endif
                              </td>

                        </tr>

                  @endforeach
            </tbody>
      </table>

</div>
@php
$locked = false;

foreach($clearance_approval_details as $row){
    if($row->cfApprovedDateTime || $row->cfDateModified){
        $locked = true;
        break;
    }
}
@endphp
<div class="modal-footer">

      <!-- <input type="hidden" id="cfID" value="{{ $id }}">
      <input type="hidden" id="cfAppNo" value="{{ $cfAppNo }}"> -->

             @if(!collect($clearance_approval_details)->contains(function($row){
                  return $row->cfApprovedDateTime || $row->cfDateModified;
            }))
            <button type="button" class="btn btn-primary" id="submit" onclick="submit()">
            Save
            </button>
            @endif

      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
      </button>

</div>


<script>
      var cfId = "{{ $id }}";
      var identityId = "{{ $identityId }}";
      var appNo = "{{ $cfAppNo }}";

     

      // function confirm_submit() {
      //       window.scrollTo(0, 0);
      //       fbconfirm('Confirm Decline', 'Do you want to decline the ATD form?', 'Yes', 'Cancel', 'submit()');
      // }

      function submit() {

            let data = [];

            $('.clearance-table tbody tr').each(function () {

                  let remarks = $(this).find('.cfRemarks').val();
                  let status = $(this).find('.cfStatus').val();

                  data.push({
                        remarks: remarks,
                        status: status
                  });

            });

            $.ajax({
                  url: '{{ route('update_clearance_approval_details') }}',
                  type: "POST",
                  cache: false,
                  data: {
                        _token: '{{ csrf_token() }}',
                        cfId: cfId,
                        identityId: identityId,
                        appNo: appNo,
                        clearance: data
                  },
                  success: function (data) {

                        $('#submit').prop('disabled', true);

                        $('#success_message_text')
                        .text("Clearance form successfully submitted");

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
                  location.href = '{{ route('clearance_approval') }}';
            }, 500);
      }

      function closeErrorMessage() {
            $('#error_message').hide();
      }

</script>