@extends('layouts.admin')

@section('content')

<style>
    .bg-custom {
        background-color: #003f5c;
        color: #ffffff;
    }

    .mt-4 {
        padding: 20px;
    }

    .card {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease;
        background-color: #ffffff;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-weight: bold;
        font-size: 1.5rem;
        background-color: #007bff;
        color: white;
        padding: 15px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding: 20px;

    }

    .get-details {
        text-align: left;
        text-decoration: none;
        color: #003f5c;
    }

    .get-details:hover {
        text-decoration: underline;
    }

    .divider {
        width: 100%;
        height: 1px;
        background-color: #ddd;
        margin: 15px 0;
    }


    .card-container {
        margin-top: 20px;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .card-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 15px;
        background: #fff;
        position: relative;
    }

    .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 75px;
        border-radius: 5px;
        font-size: 35px;
        margin-right: 15px;
    }

    .card-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }

    .card-title {
        font-size: 1.2rem;
        margin: 0;
        color: #333;
        font-weight: bold;
    }

    .details-link {
        font-size: 0.9rem;
        color: #007bff;
        text-decoration: none;
        margin-top: 4px;
    }

    .details-link:hover {
        text-decoration: underline;
    }

    .card-count {
        font-size: 2.5rem;
        font-weight: bold;
        color: #666;
        margin: 0;
        text-align: right;
        color: red;
    }

    .card-count-zero {
        font-size: 2.5rem;
        font-weight: bold;
        color: #666;
        margin: 0;
        text-align: right;

    }

    h4 {
        color: #333;
        margin-bottom: 20px;
        font-size: 1.75rem;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    h4 i {
        margin-right: 10px;
        color: black;
    }

    @media (max-width: 768px) {
        .card-content {
            flex-direction: row;

            flex-wrap: wrap;
            align-items: center;
        }

        .icon {
            margin-bottom: 0;
        }

        .card-info {
            flex: 1 1 auto;
        }

        .card-count {
            flex: 0 0 auto;
            margin-left: auto;
        }

        .ml-3 {
            margin-left: auto;
            margin-top: 0;
        }
    }

    .card-header {
        background-color: #003f5c;
        color: #fff;
        font-weight: bold;
    }

    .icon.bg-custom {
        background-color: #003f5c !important;
        /* Yellow background */
    }

    .btn-group .btn {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }





    .greeting-widget {
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
        border-radius: 12px;
        color: #fff;
        padding: 30px;
        margin: 10px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        width: 100%;
        /* Full width for responsiveness */
        /* max-width: 600px; */
    }

    .greeting-widget .card-body {
        padding: 20px;
    }

    .greeting-widget .card-title {
        font-size: 2rem;
        font-weight: bold;
        animation: fadeIn 1s ease-in-out;
        margin-bottom: 10px;
    }

    .greeting-widget .card-text {
        font-size: 1.2rem;
        color: #fff;
        opacity: 0.85;
        animation: fadeIn 1.5s ease-in-out;
        margin-bottom: 15px;
    }

    .greeting-widget .card-subtext {
        font-size: 1rem;
        color: #d1d9e6;
        margin-bottom: 15px;
    }

    .greeting-widget .current-date {
        font-size: 1.1rem;
        color: #e6efff;
        margin-bottom: 20px;
    }

    .greeting-widget blockquote {
        font-size: 1rem;
        font-style: italic;
        color: #f0f4f8;
        border-left: 4px solid #fff;
        padding-left: 15px;
        margin-top: 20px;
        opacity: 0.85;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .card-container {
            flex-direction: column;
            align-items: center;
        }

        .greeting-widget {
            padding: 20px;
            max-width: 100%;
        }
    }

    .aFocus{
        width: 0;
        height: 0;
        opacity: 0;
        outline: none;
    }
 
    .announcement-section {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease;
        background-color: #ffffff;
        overflow: hidden;
        overflow-y: auto;
        padding: 20px;
        margin-top: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding-right: 10px;
        max-height: 300px;
        position: relative;
    }
    .schedlue-section {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease;
        background-color: #ffffff; 
        padding: 20px;
        margin-top: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding-right: 10px;
        /* max-height: 500px;  */
        height:auto;
        position: relative;
    }


    .announcement{
        display:inline-block;
      /*   float:right;
        top:0; */
    }
 

    .announcement-footer {
        font-size: 0.70rem;
        color: #888;
        text-align: right;
        margin-top: 10px;
        border-top: 1px solid #e0e0e0;
        padding-top: 5px;
    }

    .announcement-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .announcement-header {
        border-bottom: 2px solid #003f5c;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .announcement-header h2 {
        font-size: 1.5rem;
        color: #333;
        margin: 0;
        font-weight: bold;
    }
    .announcement-header div {
       display:inline-block
    }
 
    .announcement-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .announcement-item {
        background-color: #ffffff;
        border-left: 4px solid #4caf50;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.05);
        cursor:pointer
    }

    .announcement-item h4 {
        margin: 0;
        font-size: .85rem;
        color: #444;
    }

    .announcement-item p {
        margin: 5px 0 0 0;
        font-size: 0.85rem; 
        color: #666;
    }


    .no-announcements {
        text-align: center;
        font-size: 1rem;
        color: #888;
        margin-top: 15px;
        padding: 10px;
        background-color: #ffffff;
        border: 1px dashed #ddd;
        border-radius: 8px;
    }

    .announcement-list::-webkit-scrollbar {
        width: 8px;
    }

    .announcement-list::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }

    .announcement-list::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
    }


    .text-start {
        text-align: left !important;
    }

    .floatR{
        float:right;
        margin-top:-5px
    }

    .modal-body {
            padding: 2em;
      }

      .hrntl{
        display:inline-block;
        width: 100px;
      }

      .btn{
        cursor:pointer; 
      }
</style>


<div class="modal fade" id="dashboardModal" tabindex="-1" aria-labelledby="dashboardModalLabel" aria-hidden="true"><!-- modal -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="dashboardModalLabel"></h5>
                </div>
                <div class="modal-body" id="modal_body"></div>   
            </div>
            <div class="modal-footer" id="btns"></div>
        </div>
</div> 

<div class="container-fluid mt-4 ">
    <div class="row"> 
        <div class="col-lg-12">
            <div class="greeting-widget shadow-lg">
                <div class="card-body">
                    <h4 class="card-title">Hi, <?=session()->get('fullname')?></h4>
                    <p class="card-text">Welcome back to your dashboard. Let's make today awesome!</p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid mt-4 ">
    <div class="row">

<?php
    $if_approver=session()->get('if_approver');

 
?>
        
    <div class="col-lg-12"> <!-- ANNOUNCEMENT -->
            <div class="schedlue-section">
                <div class="announcement-header"> 
                <a class="aFocus" href="" id="announcelbl"></a> 
                    <div><h2>📢 Announcements</h2></div>
                    @if($if_approver!==0)
                        <div class='floatR'><a class='btn btn-primary' href="new_announcement">+ Create</a></div>
                    @endif 
                </div>
                <div class="announcement-list">
                     <?php $num=0;?>
                    @foreach($announcement['rows'] as $row)  
                        <div class="announcement-item" onclick="view_announcement({{$row->id}})"> 
                            <p>{{$row->fullname}} posted announcement about <b>{{$row->pSubject}}</b> please click this to see details</p>
                            <div class="announcement-footer">Published: {{ \Carbon\Carbon::parse($row->datePosted)->format('F j, Y, g:i A') }}</div>
                        </div>
                        <?php $num+=1;?>
                    @endforeach
                     
                    @if($num==0)
                        <div class="no-announcements" id="noAnnouncements" style="display: block;">
                            <p>No announcements at the moment. Check back later!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div> 
    <div class="col-lg-12"> <!-- SCHEDULE -->
            <div class="schedlue-section">
                <div class="announcement-header"> 
                    <div style="width:100%">
                      <h2 class="float-start">
                      <i class="fa-solid fa-calendar-days"></i> Schedule</h2> 
                      <div class="float-end text-success btn" onclick="show_schedule(1)">
                            <i class="fa-solid fa-arrows-rotate" title="Refresh schedule" style="font-size:20px"></i> 
                      </div>
                    </div> 
                    <a class="aFocus" href="" id="calendarlbl"></a> 
                </div>
                <div class="announcement-list"> 
                    <div id="divSchedule"></div>
                </div>
            </div>
        </div>

    </div>

    </div>
</div>
 

@if(session()->get('if_approver') == 1)
    <!-- FOR APPROVAL -->
    <div class="container-fluid mt-4 card-container">
        <h4><i class="bi bi-hand-thumbs-up-fill"></i> For Approval</h4>
        <div class="row">
            @foreach($approvals as $forApproval)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="card-content">
                                <div class="icon {{ $forApproval['color'] }} text-white square">
                                    <i class="bi {{$forApproval['icon']}}"></i>
                                </div>
                                <div class="ml-3">
                                    <h5 class="card-title">{{ $forApproval['title'] }}</h5> 
                                    @if($forApproval['count'] == 0)
                                        <p class="card-count-zero">{{ $forApproval['count'] }}</p>
                                    @else
                                        <p class="card-count">{{ $forApproval['count'] }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="divider"></div>
                            <a href="{{ $forApproval['link'] }}" class="btn btn-link get-details">Get More details...</a>
                        </div>
                    </div>
                </div>
            @endforeach 
        <a class="aFocus" href="" id="forApprovallbl"></a> 
        </div>
    </div>
@endif

<!-- APPLICATION / REQUESTER -->
<div class="container-fluid mt-4 card-container">
    <h4><i class="bi bi-gear-fill"></i> Applications</h4>
    <div class="row">
        @foreach($applications as $application)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card-content">
                            <div class="icon {{ $application['color'] }} text-white square">
                                <i class="bi {{$application['icon']}}"></i>
                            </div>
                            <div class="ml-3">
                                <h5 class="card-title">{{ $application['title'] }}</h5>
                                @if($application['count'] == 0)
                                    <p class="card-count-zero">{{ $application['count'] }}</p>
                                @else
                                    <p class="card-count">{{ $application['count'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="divider"></div>
                        <a href="{{ $application['link'] }}" class="btn btn-link get-details">Get More details...</a>
                    </div>
                </div>
            </div>
        @endforeach
        <a class="aFocus" href="" id="applicationllbl"></a> 
    </div>
</div>


@if(session()->get('if_approver') == 1) 
    <div class="container-fluid mt-4 card-container">
        <h4><i class="bi bi-tv-fill"></i> Application Monitoring per Cut - Off</h4>
        <div class="row">

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Leave
                    </div>
                    <a class="aFocus" href="" id="appCutofflbl"></a> 
                    <div class="card-body"><canvas id="myPieChartLeave" width="100%" height="50"></canvas></div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Overtime
                    </div>
                    <div class="card-body"><canvas id="myPieChartOvertime" width="100%" height="50"></canvas></div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Offset Days and Hours
                    </div>
                    <div class="card-body"><canvas id="myPieChartOffset" width="100%" height="50"></canvas></div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Official Business
                    </div>
                    <div class="card-body"><canvas id="myPieChartOfficialBusiness" width="100%" height="50"></canvas>
                    </div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Time Adjustment
                    </div>
                    <div class="card-body"><canvas id="myPieChartTimeAdjustment" width="100%" height="50"></canvas>
                    </div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>
        </div>
    </div>

@endif   

@if(session()->get('if_approver') == 1)
    <div class="container-fluid mt-4">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header ">
                <i class="fas fa-chart-bar me-1"></i>
                Total Employee Application Received Per Cut - Off
            </div>
            <div class="card-body">
                <canvas id="myBarChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div> 
@endif

<div class="container-fluid mt-4"> <!-- DTR -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DTR VIEW PER CUT - OFF 
            <div class="float-end">
                <l class="fs-6">Payroll period date:</l>
                <a class="aFocus" href="" id="dtrlbl"></a> 
                <label for="">
                    <select id="payrollPeriodId" name="payrollPeriodId" class="form-select d-inline" onchange="show_dtr_view_per_cutoff()">
                        @foreach($posted_dtr_dates['rows'] as $rows)
                            <option value="{{$rows->payrollPeriod}}">{{$rows->date_range}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="card-body" id="divDtrView"></div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">

        <div class="col-xl-6"> <!-- BIOMETRICS -->

            <div class="card mb-4 shadow-sm border-0">
                
                <div class="card-header">
                    <i class="fa-solid fa-fingerprint me-1"></i> 
                    Biometrics Data 
                    <div class="float-end"> 
                        <button id="btnDTR" class="btn btn-primary" onclick="return AddDTR(this.id)">+ Add DTR</button>
                    </div> 
                </div>

                <a class="aFocus" href="" id="biolbl"></a> 
                <div id="dtrLogs" class="card-body"> 
                </div>
            </div>
        </div>

        <div class="col-xl-6"> <!-- LEAVE BALANCES -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header">
                    <i class="fa-solid fa-calendar me-1"></i>
                    Leave Balances
                </div>  
                <a class="aFocus" href="" id="leaveBallbl"></a> 
                <div class="card-body">  
                    <table id="datatablesSimpleLeave" class="table table-striped">
                        <thead class="table-header">
                            <tr>
                                <th>#</th>
                                <th>Leave Type</th>
                                <th>Balance Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                           
                            if (!empty($leaveBalance)): ?>
                            <?php    $index = 0; ?>
                            @foreach($leaveBalance['rows'] as $rows)
                                <?php        $index += 1; ?>
                                <tr>
                                    <td><?= $index ?></td>
                                    <td class="text-start"><?= htmlspecialchars($rows->leaveName); ?></td>
                                    <td class="text-start"><?= htmlspecialchars($rows->currentBalance); ?></td>
                                </tr>
                            @endforeach
                            <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No leave balances found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        
        @if(session()->get('if_approver') == 1)
        <div class="col-xl-12"> <!-- BIOMETRICS EMPLOYEE -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header">
                    <i class="fa-solid fa-fingerprint me-1"></i> 
                    Employee Biometrics Logs 
                    <div class="float-end">
                        <a class="aFocus" href="" id="empbiolbl"></a> 
                        <l class="fs-6">Biometric Date From:</l>
                        <label for=""> 
                            <input type="date" class="form-control d-inline" id="dtrFrom"">  
                        </label>
                        <l class="fs-6"> To:</l>
                        <label for=""> 
                            <input type="date" class="form-control d-inline" id="dtrTo" onchange="show_emp_bio_logs()">  
                        </label>
                    </div> 
                </div> 
                <a href="" id="emplueeLogsTbl"></a>
                <div class="card-body" id="divEmployeeLogs"> </div> 
            </div>
        </div>
        @endif                       

        <div class="col-xl-12"> <!-- YTD -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header">
                    <i class="fa-solid fa-calendar me-1"></i>
                    Year To Date 
                    <div class="float-end">
                        <l class="fs-6">Select Year-Tax:</l>
                        <label for="">
                            <select id="ddl_tax_years" class="form-select d-inline" onchange="show_emp_ytd()">
                                @foreach($emp_ytd_tax_years['rows'] as $rows)
                                    <option value="{{$rows->taxYear}}">{{$rows->taxYear}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div> 
                <a href="" id="ytdlbl"></a>
                <div class="card-body" id="divYTD"> </div>

            </div>
        </div>

    </div>

    <script>
        const url = new URL(window.location.href); 
        const id = url.searchParams.get('id'); 
        const inputElement = document.getElementById(id); 
        window.onload = function() { 
            inputElement.focus();
        };   
    </script>
</div>

@endsection

<script>
                 

    function show_emp_ytd() {

        var taxYear = document.getElementById('ddl_tax_years').value;

        var formData = new FormData();
        formData.append('year', taxYear);


        GlovalHTMLObjLoading(1, 'divYTD');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/emp_ytd")}}',
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
                //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }

        });

    }

    function show_emp_bio_logs() {
      
        var formData = new FormData();
        var df =  document.getElementById('dtrFrom').value;
        var dt =  document.getElementById('dtrTo').value; 
        formData.append('mode', 1); 
        formData.append('df', df);
        formData.append('dt',  dt);

        GlovalHTMLObjLoading(1, 'divEmployeeLogs');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/emp_bio_logs")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#divEmployeeLogs').html(response);
            },
            error: function (msg) {
                //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }

        });

    }

    function show_dtr_view_per_cutoff() {

            var payrollPeriodId = document.getElementById('payrollPeriodId').value;
            var formData = new FormData();
            formData.append('payrollPeriodId', payrollPeriodId);
            // var formData = new FormData();
            // formData.append('year', taxYear); 
            
            GlovalHTMLObjLoading(1, 'divDtrView'); 
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: '{{url("/dtr_view_process")}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (response) {
                    $('#divDtrView').html(response);
                },
                error: function (msg) {
                    //alert(JSON.parse(msg.responseText).error.msg.msg);
                    console.log('Error:' + JSON.stringify(msg));
                }

            });  
    }

    function show_schedule(num) {
 
        var formData = new FormData();
        formData.append('mode', 1);  
        formData.append('num', num); 
        GlovalHTMLObjLoading(1, 'divSchedule'); 
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/schedule")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#divSchedule').html(response);
            },
            error: function (msg) {
                //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }

        });  
    }


    function show_dtrLogs(num){ 
        var formData = new FormData();
        formData.append('mode', 1);  
        formData.append('num', num); 
        GlovalHTMLObjLoading(1, 'dtrLogs'); 
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/dtr_logs")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#dtrLogs').html(response);
            },
            error: function (msg) {
                //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:' + JSON.stringify(msg));
            }

        }); 
    }
    
   async function showDetails(params){ 
        const parsedObject = JSON.parse(params);
        const ID = parsedObject.ID;
        const appNo = parsedObject.appNo; 
        const enc_id = parsedObject.enc_id; 
        const appDoc = parsedObject.appDoc; 
        const appStatus = parsedObject.appStatus; 
        
        var modalTitle = document.getElementById('dashboardModalLabel').innerHTML = appDoc+' Application Details';
        
        if (ID==6){
            ChangeSchedule(enc_id,appStatus);
            return false;
        }
    

        if (ID<100){ 
            show_hist_details(ID,enc_id);
        }
       
    }
    

    async function ChangeSchedule(id,appStatus){   
       
        var btns = document.getElementById('btns');
        var title = document.getElementById('dashboardModalLabel');
        title.innerHTML="Schedule Change Requests"; 
        var thisUrl = (appStatus=="" ? "/change_sched" : "/sc_pending");
        
        var formData = new FormData();
        formData.append('id', id);   
        formData.append('status', appStatus);   
        var myModal = new bootstrap.Modal(document.getElementById('dashboardModal'));   
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
                url: thisUrl,  
                type: 'POST', 
                data: formData,    // Send the formData
                processData: false,  // Don't let jQuery process the data
                contentType: false,
                headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                },             
                success: function(response) {  
                    $('#modal_body').html(response);        
                    myModal.show();  
                },
                error: function(msg) { 
                //alert(JSON.parse(msg.responseText).error.msg.msg); 
                console.log('Error:'+JSON.stringify(msg));
                } 
                
        });

    }
     
   
    async function AddDTR(objID){ 
        GlovalHTMLObjLoading(1,objID); 
        var title =document.getElementById('dashboardModalLabel');
        title.innerHTML="Online DTR";

        var formData = new FormData();
        formData.append('id', id);  // Add other form fields here if needed  
        var myModal = new bootstrap.Modal(document.getElementById('dashboardModal'));   
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
                url: '{{url("/dtr")}}',  
                type: 'POST', 
                data: formData,    // Send the formData
                processData: false,  // Don't let jQuery process the data
                contentType: false,
                headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                },             
                success: function(response) {  
                    $('#modal_body').html(response);        
                    myModal.show(); 
                    GlovalHTMLObjLoading(0,objID); 
                },
                error: function(msg) {  
                //alert(JSON.parse(msg.responseText).error.msg.msg);
                console.log('Error:'+JSON.stringify(msg));
                } 
                
        });

    }

   /*  document.addEventListener('DOMContentLoaded', function () { 
        show_dtrLogs(0);
        show_schedule(0);
        show_emp_ytd();
        show_dtr_view_per_cutoff();
        show_emp_bio_logs();  
         
    }); */

    /* const functions = [
    () => console.log("Function 1"),
    () => console.log("Function 2"),
    () => console.log("Function 3"),
    () => console.log("Function 4"),
    () => console.log("Function 5")
    ];

    functions.forEach((fn, index) => {
    setTimeout(fn, (index + 1) * 5000); // starts after 5s, then every 5s
    }); */


    const functions = [
    () => show_schedule(0),
    () => show_dtr_view_per_cutoff(),
    () => show_dtrLogs(0),
    () => show_emp_bio_logs(),
    () => show_emp_ytd()
    ];

    functions.forEach((fn, index) => {
    setTimeout(fn, (index + 1) * 5000);  
    });

   


</script>
 
<script>
    var leaveChartData = @json($leaveChart['rows'][0]);
    var overtimeChartData = @json($overtimeChart['rows'][0]);
    var timeAdjustmentChartData = @json($timeAdjustmentChart['rows'][0]);
    var obChartData = @json($obChart['rows'][0]);
    var offsetChartData = @json($offsetChart['rows'][0]);  
    var approvalsBarData = @json($approvalCount['rows'][0]); 
    function view_announcement(num){ 
       window.location.href='{{url("/announcement_details?num=")}}'+num;
    }
</script>
 
