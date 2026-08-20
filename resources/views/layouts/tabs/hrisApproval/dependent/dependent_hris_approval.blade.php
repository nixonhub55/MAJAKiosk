@extends('layouts.admin')

@section('content')

<style>
    .modal-body { padding: 2em; }
    .bg-primary { background-color: black; }

    .bulk-action-bar {
        display: none;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 10px 15px;
        background: #f1f3f5;
        border-radius: 8px;
    }
    .bulk-action-bar.show { display: flex; }

    .btn-bulk-approve {
        background: #28a745; color: #fff;
        font-size: 14px; border-radius: 20px;
        padding: 6px 18px; border: none;
    }
    .btn-bulk-disapprove {
        background: #dc3545; color: #fff;
        font-size: 14px; border-radius: 20px;
        padding: 6px 18px; border: none;
    }
    .row-checkbox, #checkAllPending {
        width: 16px; height: 16px; cursor: pointer;
    }
    th:first-child { text-align: center; }
</style>

<div class="container-fluid mt-4 card-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Dependent</h5>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending"
               role="tab" aria-controls="pending" aria-selected="true">Pending</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">

            <!-- Bulk action bar -->
          

            <div class="table-container">
                <table class="table data-table" id="datatablesPending">
                    <thead>
                        <tr>
                          <th style="text-align: center"><input type="checkbox" id="checkAllPending"></th>
                            <th>#</th>
                            <th>IdentityId</th>
                            <th>Employee Name</th>
                            <th>Request No.</th>
                            <th>Change Type</th>
                            <th>Requested By</th>
                            <th>Date Requested</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach($dependent as $list)
                        <tr data-formno="{{ $list->Request_No }}" data-identityid="{{ $list->Employee_Id }}">
                            <td>
                                <input type="checkbox" class="row-checkbox"
                                    data-formno="{{ $list->Request_No }}"
                                    data-identityid="{{ $list->Employee_Id }}">
                            </td>
                            <td class="open-atd" style="cursor:pointer;">{{ $count }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->Employee_Id }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->Employee_Name }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->Request_No }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->crud }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->Requested_By }}</td>
                            <td class="open-atd" style="cursor:pointer;">{{ $list->Request_Date }}</td>
                        </tr>
                        <?php $count++; ?>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="atdModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="atdModalContent"></div>
                    </div>
                </div>
            </div>
              <div class="bulk-action-bar" id="bulkActionBar">
                <span id="selectedCount">0 selected</span>
                <button type="button" class="btn-bulk-approve" id="btnBulkApprove">Approve Selected</button>
                <button type="button" class="btn-bulk-disapprove" id="btnBulkDisapprove">Disapprove Selected</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const datatablesPending = document.getElementById('datatablesPending');
    if (datatablesPending) {
        new simpleDatatables.DataTable(datatablesPending, {
            columns: [{ select: 0, sortable: false }]
        });
    }
});

$(document).ready(function () {

    // ── Row click → open modal ──────────────────────────────────────
    $(document).on('click', '.open-atd', function () {
        let row = $(this).closest('tr');
        $.ajax({
            url: "{{ route('hris_approval_dependent_view') }}",
            type: "POST",
            data: {
                formNo: row.data('formno'),
                identityId: row.data('identityid'),
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                $('#atdModalContent').html(response);
                $('#atdModal').modal('show');
            },
            error: function () {
                alert('Error loading dependent details');
            }
        });
    });

    // ── Bulk select logic ───────────────────────────────────────────
    function updateBulkBar() {
        const checkedCount = $('.row-checkbox:checked').length;
        const totalCount   = $('.row-checkbox').length;
        $('#selectedCount').text(checkedCount + ' selected');
        $('#bulkActionBar').toggleClass('show', checkedCount > 0);

        const checkAll = $('#checkAllPending')[0];
        if (checkAll) {
            checkAll.checked       = checkedCount > 0 && checkedCount === totalCount;
            checkAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    }

    $('#checkAllPending').on('change', function () {
        $('.row-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkBar();
    });

    $(document).on('change', '.row-checkbox', updateBulkBar);

    // Stop checkbox click from bubbling up to the row's open-atd handler
    $(document).on('click', '.row-checkbox', function (e) { e.stopPropagation(); });

    // ── Bulk submit ─────────────────────────────────────────────────
    function getSelectedItems() {
        return $('.row-checkbox:checked').map(function () {
            return { request_no: $(this).data('formno'), employee_id: $(this).data('identityid') };
        }).get();
    }

    function bulkSubmit(action) {
        const items = getSelectedItems();
        if (!items.length) return;

        const verb = action === 'approve' ? 'approve' : 'disapprove';
        if (!confirm('Are you sure you want to ' + verb + ' ' + items.length + ' request(s)?')) return;

        $('#btnBulkApprove, #btnBulkDisapprove').prop('disabled', true);

        $.ajax({
            url: "{{ route('hris_approval_dependent_bulk_submit') }}",  // 👈 add this route
            type: "POST",
            data: { items, action, _token: "{{ csrf_token() }}" },
            success: function (response) {
                let msg = response.message || (response.success ? 'Processed successfully.' : 'Some requests failed.');
                if (!response.success && response.errors?.length) {
                    msg += "\n\n" + response.errors.map(e => 'Request ' + e.request_no + ': ' + e.message).join("\n");
                }
                alert(msg);
                location.reload();
            },
            error: function () {
                alert('An error occurred while processing the request(s).');
            },
            complete: function () {
                $('#btnBulkApprove, #btnBulkDisapprove').prop('disabled', false);
            }
        });
    }

    $('#btnBulkApprove').on('click',    () => bulkSubmit('approve'));
    $('#btnBulkDisapprove').on('click', () => bulkSubmit('disapprove'));
});
</script>

@endsection