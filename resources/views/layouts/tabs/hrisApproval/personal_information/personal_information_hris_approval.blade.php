@extends('layouts.admin')

@section('content')

      <style>
            .btn-add {
                  background: #28a745;
                  color: #fff;
                  font-size: 14px;
                  border-radius: 20px;
                  padding: 8px 20px;
                  text-decoration: none;
            }

            .btn-export {
                  background: #6c757d;
                  color: #fff;
                  font-size: 14px;
                  border-radius: 20px;
                  padding: 8px 20px;
                  text-decoration: none;
            }

            .modal-body {
                  padding: 2em;
            }

            .bg-primary {
                  background-color: black;
            }

            .bulk-action-bar {
                  display: none;
                  align-items: center;
                  gap: 10px;
                  margin-bottom: 10px;
                  padding: 10px 15px;
                  background: #f1f3f5;
                  border-radius: 8px;
            }

            .bulk-action-bar.show {
                  display: flex;
            }

            .btn-bulk-approve {
                  background: #28a745;
                  color: #fff;
                  font-size: 14px;
                  border-radius: 20px;
                  padding: 6px 18px;
                  border: none;
            }

            .btn-bulk-disapprove {
                  background: #dc3545;
                  color: #fff;
                  font-size: 14px;
                  border-radius: 20px;
                  padding: 6px 18px;
                  border: none;
            }

            .row-checkbox, #checkAllPending {
                  width: 16px;
                  height: 16px;
                  cursor: pointer;
            }
      </style>

      <?php  
                        $df = date('Y-m-d', strtotime("-1 Month"));
      $dt = date('Y-m-d');
      //           echo json_encode($authorityToDeduct);
      //     return;
                  ?>

      <div class="container-fluid mt-4 card-container">
            <!-- <h1>Overtime Approval</h1> -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5>Personal Information</h5>
                  <h5></h5>

            </div>
            
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab"
                              aria-controls="pending" aria-selected="true">Pending</a>
                  </li>
                  <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab"
                              aria-controls="history" aria-selected="false">History</a>
                  </li> -->
            </ul>

            <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">

                        

                        <div class="table-container">
                              <table class="table data-table" id="datatablesPending">
                                    <thead>
                                          <tr>
                                                <th><input type="checkbox" id="checkAllPending"></th>
                                                <th>#</th>
                                                <th>IdentityId</th>
                                                <th>Employee Name</th>
                                                <th>Request No.</th>
                                                <th>Change Type</th>
                                                <th>Requested By</th>
                                                <th>Date Requested</th>
                                                <!-- <th>View</th> -->

                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                                $count = 1; 
                                                 ?>
                                          @foreach($personalInformation as $list)
                                                <tr data-formno="{{ $list->Request_No }}" data-identityid="{{ $list->Employee_Id }}">
                                                      <td>
                                                            <input type="checkbox" class="row-checkbox"
                                                                  data-formno="{{ $list->Request_No }}"
                                                                  data-identityid="{{ $list->Employee_Id }}">
                                                      </td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $count }}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->Employee_Id }}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->Employee_Name}}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->Request_No }}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->crud }}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->Requested_By }}</td>
                                                      <td class="open-atd" style="cursor:pointer;">{{ $list->Request_Date }}</td>
                                                      <div class="btn-container"> 
                                                            
                                                      </div>
                                                </tr>
                                                <?php      $count++; ?>
                                          @endforeach
                                    </tbody>
                              </table>
                              <div class="modal fade" id="atdModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                          <div class="modal-content" id="atdModalContent">
                                          </div>
                                    </div>
                              </div>
                              <!-- Bulk action bar, shows up once at least one row is checked -->
                        <div class="bulk-action-bar" id="bulkActionBar">
                              <span id="selectedCount">0 selected</span>
                              <button type="button" class="btn-bulk-approve" id="btnBulkApprove">Approve Selected</button>
                              <button type="button" class="btn-bulk-disapprove" id="btnBulkDisapprove">Disapprove Selected</button>
                        </div>
                        </div>
                  </div>
             
            </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

      <script>
            
            window.addEventListener('DOMContentLoaded', event => {

                  const datatablesPending = document.getElementById('datatablesPending');
                  if (datatablesPending) {
                       new simpleDatatables.DataTable(datatablesPending, {
                              columns: [
                                    { select: 0, sortable: false } // 👈 checkbox column
                              ]
                        });

                  }

                  const datatablesHistory = document.getElementById('datatablesHistory');
                  if (datatablesHistory) {
                        new simpleDatatables.DataTable(datatablesHistory);
                  }
            });

            $(document).ready(function () {
                  Filter_HistoryRequester(0, 0, 3);
            });




      </script>

            <script>
            $(document).on('click', '.open-atd', function () {

                  let row = $(this).closest('tr');
                  let formNo = row.data('formno');
                  let identityId = row.data('identityid');

                  $.ajax({
                        url: "{{ route('hris_approval_personalinformation_view') }}",
                        type: "POST",
                        data: {
                              formNo :formNo,
                              identityId: identityId,
                              _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                              $('#atdModalContent').html(response);
                              $('#atdModal').modal('show');
                        }
                  });

            });
      </script>

      <script>
            // ----- Bulk select / approve / disapprove logic -----
            $(document).ready(function () {
                  // prevent sorting when clicking the "select all" checkbox

                  function updateBulkBar() {
                        const checkedCount = $('.row-checkbox:checked').length;
                        $('#selectedCount').text(checkedCount + ' selected');
                        $('#bulkActionBar').toggleClass('show', checkedCount > 0);

                        // keep "select all" checkbox in sync (checked / indeterminate / unchecked)
                        const totalCount = $('.row-checkbox').length;
                        const checkAll = $('#checkAllPending')[0];
                        if (checkAll) {
                              checkAll.checked = checkedCount > 0 && checkedCount === totalCount;
                              checkAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
                        }
                  }

                  // header "select all" checkbox
                  $('#checkAllPending').on('change', function () {
                        
                        $('.row-checkbox').prop('checked', $(this).is(':checked'));
                        updateBulkBar();
                  });

                  // individual row checkboxes
                  $(document).on('change', '.row-checkbox', function () {
                        updateBulkBar();
                  });

                  // prevent row click (open-atd) from firing when clicking the checkbox cell
                  $(document).on('click', '.row-checkbox', function (e) {
                        e.stopPropagation();
                  });

                  function getSelectedItems() {
                        const items = [];
                        $('.row-checkbox:checked').each(function () {
                              items.push({
                                    request_no: $(this).data('formno'),
                                    employee_id: $(this).data('identityid')
                              });
                        });
                        return items;
                  }

                  function bulkSubmit(action) {
                        const items = getSelectedItems();

                        if (items.length === 0) {
                              return;
                        }

                        const verb = action === 'approve' ? 'approve' : 'disapprove';
                        if (!confirm('Are you sure you want to ' + verb + ' ' + items.length + ' request(s)?')) {
                              return;
                        }

                        const $approveBtn = $('#btnBulkApprove');
                        const $disapproveBtn = $('#btnBulkDisapprove');
                        $approveBtn.prop('disabled', true);
                        $disapproveBtn.prop('disabled', true);

                        $.ajax({
                              url: "{{ route('hris_approval_personalinformation_bulk_submit') }}",
                              type: "POST",
                              data: {
                                    items: items,
                                    action: action,
                                    _token: "{{ csrf_token() }}"
                              },
                              success: function (response) {
                                    if (response.success) {
                                          alert(response.message || 'Processed successfully.');
                                          location.reload();
                                    } else {
                                          let msg = response.message || 'Some requests failed to process.';
                                          if (response.errors && response.errors.length) {
                                                msg += "\n\n" + response.errors.map(function (e) {
                                                      return 'Request ' + e.request_no + ': ' + e.message;
                                                }).join("\n");
                                          }
                                          alert(msg);
                                          location.reload();
                                    }
                              },
                              error: function (xhr) {
                                    alert('An error occurred while processing the request(s).');
                              },
                              complete: function () {
                                    $approveBtn.prop('disabled', false);
                                    $disapproveBtn.prop('disabled', false);
                              }
                        });
                  }

                  $('#btnBulkApprove').on('click', function () {
                        bulkSubmit('approve');
                  });

                  $('#btnBulkDisapprove').on('click', function () {
                        bulkSubmit('disapprove');
                  });

            });
      </script>

@endsection