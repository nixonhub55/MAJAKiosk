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
      </style>
      <?php  
                                                            $df = date('Y-m-d', strtotime("-1 Month"));
      $dt = date('Y-m-d');
      //           echo json_encode($clearanceList);
      //     return;
                                                      ?>



      <div class="container-fluid mt-4 card-container">
            <!-- <h1>Overtime Approval</h1> -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                  <!-- <h4>Overtime List For Approval</h4> -->
                  <h5></h5>

            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">

                  <?php //  if(session()->get('departmentCode') == "HR"){?>
                  <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="clearance-tab" data-bs-toggle="tab" href="#clearance" role="tab"
                              aria-controls="clearance" aria-selected="false">Clearance</a>
                  </li>
                  <?php //  } ?>
            </ul>
            <div class="tab-content" id="myTabContent">
                  <!-- HR VIEW -->
                  <?php // if (session()->get('departmentCode') == "HR") {?>
                  <div class="tab-pane fade show active" id="clearance" role="tabpanel" aria-labelledby="hr-tab">
                        <div class="table-container">
                              <table class="table data-table" id="datatablesHR">
                                    <thead>
                                          <tr>
                                                <th>Application Number</th>
                                                <th>Employee Name</th>
                                                <th>Employee ID</th>
                                                <th>Date Created</th>
                                                <th>Approved Date</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($clearanceListHR as $list)
                                                <tr class="open-clearance-hr" data-appnohistory="{{ $list->cfAppNo }}"
                                                      data-cfid="{{ $list->cfID }}" style="cursor:pointer;">
                                                      <td>{{ $list->cfAppNo }}</td>
                                                      <td>{{ $list->Name }}</td>
                                                      <td>{{ $list->cfID }}</td>
                                                      <td>{{ $list->cfDateCreated }}</td>
                                                      <td>{{ $list->cfApprovedDateTime ?? 'N/A' }}</td>
                                                      <td>{{ $list->cfRemarks ?? 'N/A' }}</td>
                                                      <td>
                                                            @if($list->cfStatus == 'A')
                                                                  <span style="color:green;">Approved</span>
                                                            @elseif($list->cfStatus == 'D')
                                                                  <span style="color:gray;">Declined</span>
                                                            @else
                                                                  <span style="color:red;">Pending</span>
                                                            @endif
                                                      </td>

                                                </tr>

                                          @endforeach
                                    </tbody>
                              </table>
                              <div class="modal fade" id="clearanceModalHR" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                          <div class="modal-content" id="clearanceModalContentHR">
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <?php // } ?>
            </div>
      </div>


      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

      <script>
            window.addEventListener('DOMContentLoaded', event => {

                  const datatablesPending = document.getElementById('datatablesPending');
                  if (datatablesPending) {
                        new simpleDatatables.DataTable(datatablesPending);

                  }

                  const datatablesHistory = document.getElementById('datatablesHistory');
                  if (datatablesHistory) {
                        new simpleDatatables.DataTable(datatablesHistory);
                  }

                  const datatablesHR = document.getElementById('datatablesHR');
                  if (datatablesHR) {
                        new simpleDatatables.DataTable(datatablesHR);
                  }
            });

            $(document).ready(function () {
                  Filter_HistoryRequester(0, 0, 3);
            });




      </script>

      <!-- HR -->
      <script>
            $(document).on('click', '.open-clearance-hr', function () {

                  let appnohr = $(this).data('appnohr');
                  let cfid = $(this).data('cfid');
                  $.ajax({
                        url: "{{ route('clearance_approval_hr') }}",
                        type: "POST",
                        data: {
                              appno: appnohr,
                              cfid: cfid,
                              _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                              $('#clearanceModalContentHR').html(response);
                              $('#clearanceModalHR').modal('show');
                        }
                  });

            });
      </script>
@endsection