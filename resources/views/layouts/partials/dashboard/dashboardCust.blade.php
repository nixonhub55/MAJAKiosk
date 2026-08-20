@extends('layouts.admin') 
@section('content')
  

  
<style>
          .bg-custom {
            background-color: #003f5c;
            color: #ffffff;
            padding:20px;
            border-radius:4px;
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
            /* background: linear-gradient(135deg, #ff7e5f, #feb47b); */
            background: linear-gradient(135deg, #a7a7a7,rgb(202, 201, 200));
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
           /*  font-size: 1.2rem; */
           font-size: 13px;
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

          .cardTitle{ 
          margin-top:50px;
          }

          .chkboxView{
          position: fixed; 
          margin-top:-50px;
          z-index: 2; 
          }

          
          .dashtxt{
            font-size: 13px;
            padding: 5px;
          }

          input[type=checkbox] {
          appearance: none;
          -webkit-appearance: none;
          width: 24px;
          height: 24px;
          border: 2px solid green;
          border-radius: 50%; 
          background-color: white;
          cursor: pointer;
          position: relative;
          }

          input[type=checkbox]:checked::after {
          content: '✔';
          color: white;
          font-size: 16px;
          position: absolute;
          top: 0;
          left: 4px;
          }

          input[type=checkbox]:checked {
          background-color: green;
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

<div id="set_session"></div>

<?php 
 
       
      $addDtrButton = 1;
      foreach ($company_customization['rows'] as $row) {
          if($row->_name=="dtr" && $row->val==0){
          $addDtrButton = 0;
         }
      }
     

      $sub_applications = session()->get('sub_applications');

      //dd(config('session.lifetime'), config('session.expire_on_close'));
 
      $user_dashboard = $user_dashboard['rows'];  // GET SETTINGS
      $uniqueRowNames = array_values(array_unique(array_column($user_dashboard, 'rowName')));  //GET ROWS

      //echo json_encode($user_dashboard);
      //GET GROUPED WIDGET
      $forApprovalSettings = array_values(array_map(fn($item) => ['titleName' => $item->titleName, 'visibility' => $item->visibility,'lineId' => $item->lineId], array_filter($user_dashboard, fn($item) => $item->headerName === 'ForApproval')));
      $applicationSettings = array_values(array_map(fn($item) => ['titleName' => $item->titleName, 'visibility' => $item->visibility,'lineId' => $item->lineId], array_filter($user_dashboard, fn($item) => $item->headerName === 'Application')));
      $appMonitorSettings = array_values(array_map(fn($item) => ['titleName' => $item->titleName, 'visibility' => $item->visibility,'lineId' => $item->lineId], array_filter($user_dashboard, fn($item) => $item->headerName === 'ApplicationMonitoringperCut-Off')));
      $othersSettings = array_values(array_map(fn($item) => ['titleName' => $item->titleName, 'visibility' => $item->visibility,'lineId' => $item->lineId], array_filter($user_dashboard, fn($item) => $item->headerName === 'others')));
        
      
       //GET SIGNLE WIDGET
      $announce_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'annonucement')));
      $calendar_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'calendar')));
      $totalEmpAppRecPerCutrOff_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'TotalEmployeeAppReceivedPerCutOff')));
      $loanOverView_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'loanOverView')));
      $dtrViewPerCutOff_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'dtrViewPerCutOff')));
      $EmployeeBiometricsLogs_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'EmployeeBiometricsLogs')));
      $YearToDate_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'YearToDate')));
      $EmployeeSchedule_visibility = array_values(array_map(fn($item) =>  $item->visibility, array_filter($user_dashboard, fn($item) => $item->rowName === 'EmployeeSchedule')));
      
       
      
      
      //echo json_encode($approvals);
      //echo json_encode($announce_visibility[0] ?? 0);

      $if_approver = session()->get('if_approver');
      $annonucement=[];
      $calendar=[];
      $TotalEmployeeAppReceivedPerCutOff=[];
      $loanOverView=[];
      $dtrViewPerCutOff=[];
      $EmployeeBiometricsLogs=[];
      $yearToDate=[];
      $approvalsData=[];
      $applicationData=[];
      $applicationMonitoringData=[];
      $bioAndLeave=[];
      $EmployeeSchedule=[];
      $loans=[];
        
      

      $annonucement[] = [
        'title' => 'annonucement',
        'icon' => '',
        'count' => 2
        ,'visibility' =>$announce_visibility[0] ?? 0
        ,'link' => ''
      ];  

      $calendar[] = [
        'title' => 'calendar',
        'icon' => '',
        'count' => 2
        ,'visibility' => $calendar_visibility[0] ?? 0
        ,'link' => ''
      ];

      
      if ($if_approver==1){
          $TotalEmployeeAppReceivedPerCutOff[]  = [
            'title' => 'TotalEmployeeAppReceivedPerCutOff',
            'icon' => '',
            'count' => 2
            ,'visibility' => $totalEmpAppRecPerCutrOff_visibility[0] ?? 0
            ,'link' => ''
          ];
      }
       
      $loanOverView[]  = [
        'title' => 'loanOverView',
        'icon' => '',
        'count' => 2
        ,'visibility' => $loanOverView_visibility[0] ?? 0 ?? 0
        ,'link' => ''
      ];

      
      $dtrViewPerCutOff[]  = [
        'title' => 'dtrViewPerCutOff',
        'icon' => '',
        'count' => 2
        ,'visibility' => $dtrViewPerCutOff_visibility[0] ?? 0
        ,'link' => ''
      ];
       
      
      if ($if_approver==1){ //EmployeeBiometricsLogs
          $EmployeeBiometricsLogs[]  = [
          'title' => 'Employee Biometrics Logs ',
          'icon' => '',
          'count' => 2
          ,'visibility' => $EmployeeBiometricsLogs_visibility[0] ?? 0
          ,'link' => ''
          ];
      } 

      if ($if_approver==1){ //Employee Schedule
          $EmployeeSchedule[]  = [
            'title' => 'Employee Schedule',
            'icon' => '',
            'count' => 2
            ,'visibility' => $EmployeeSchedule_visibility[0] ?? 0
            ,'link' => ''
          ];
      } 
       

      $yearToDate[]  = [
        'title' => 'Year To Date',
        'icon' => '',
        'count' => 2
        ,'visibility' => $YearToDate_visibility[0] ?? 0
        ,'link' => ''
      ];
 

      $otherRows = [
        ['title' => 'Approval Request', 'icon' => 'bi-check-circle'],
        ['title' => 'Budgeting', 'icon' => 'bi-calculator'],
        ['title' => 'Compliance', 'icon' => 'bi-shield-lock'],
        ['title' => 'Performance Review', 'icon' => 'bi-bar-chart']
      ];
 
      $approvalsData = [];
      if ($if_approver==1){ // approvalsData 
        foreach ($approvals as $approval) {
          $approvalsData[] = [
              'title' => $approval['title'],
              'icon' => $approval['icon'],
              'count' => $approval['count']
              ,'visibility' => 1
              ,'link' => $approval['link']
          ];
        }
      } 

      $approvalsData = DashboardApplySettings($approvalsData,$forApprovalSettings);
      
     
      $applicationData = [];
      foreach ($applications as $app) {
        $applicationData[] = [
            'title' => $app['title'],
            'icon' => $app['icon'],
            'count' => $app['count']
            ,'visibility' => 1
            ,'link' => $app['link']
        ];
      }
      $applicationData = DashboardApplySettings($applicationData,$applicationSettings);
     
      if ($if_approver==1){
        $applicationMonitoringData = [];
        foreach ($approvals as $app) {
              $applicationMonitoringData[] = [
                  'title' => $app['title'],
                  'icon' => $app['icon'],
                  'count' => $app['count']
                  ,'visibility' => 1
                  ,'link' => ''
              ];
        }
      }
      $applicationMonitoringData = DashboardApplySettings($applicationMonitoringData,$appMonitorSettings);
 

      $bioAndLeave = [
          ["title" => " Biometrics Data", "icon" => "bi-clock-history",'visibility' => 1,'link' => ''],
          ["title" => " Leave Balances ", "icon" => "bi-clock-history",'visibility' => 1,'link' => ''],
      ];  
      $bioAndLeaveData = [];
        foreach ($bioAndLeave as $row) {
          $bioAndLeaveData[] = [
              'title' => $row['title'],
              'icon' => $row['icon'],
              'count' => 2
              ,'visibility' => 1
          ];
      } 
      $bioAndLeaveData = DashboardApplySettings($bioAndLeaveData,$othersSettings);
      

      $otherRowsData = [];
      foreach ($otherRows as $row) {
            $otherRowsData[] = [
                'title' => $row['title'],
                'icon' => $row['icon'],
                'count' => 2
                ,'visibility' => 1
                ,'link' => ''
            ];
      }



    function DashboardApplySettings($oldDataSet,$settings){
              $num = 0;
              foreach($oldDataSet as $rows){
                $oldDataSet[$num]['newTitle'] = str_replace(' ', '', $oldDataSet[$num]['title']);
                $num+=1;
              } 

              $settingsLookup = [];
              foreach ($settings as $setting) {
                  $settingsLookup[$setting['titleName']] = $setting;
              }


              foreach ($oldDataSet as &$item) {
                $newTitle = $item['newTitle'];
                if (isset($settingsLookup[$newTitle])) {
                    $item['visibility'] = $settingsLookup[$newTitle]['visibility'];
                    $item['sortKey'] = $settingsLookup[$newTitle]['lineId'];  
                } else {
                    $item['sortKey'] = PHP_INT_MAX;  
                }
            } 
              unset($item);  
        
              usort($oldDataSet, function($a, $b) {
                  return $a['sortKey'] <=> $b['sortKey'];
              });
        
              foreach ($oldDataSet as &$item) {
                  unset($item['sortKey']);
              }

              return $oldDataSet;
    }
 
    $btnText = ($mode==1) ? "Save changes" : "Customize widgets";

    $lms_license_num = 0;
    foreach($lms_license['rows'] as $lmsRow){
        $lms_license_num = $lmsRow->num;
    } 

    //echo json_encode($employeeloans);
?>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
 
<script>  

  var leaveChartData = @json($leaveChart['rows'][0]);
  var overtimeChartData = @json($overtimeChart['rows'][0]);
  var timeAdjustmentChartData = @json($timeAdjustmentChart['rows'][0]);
  var obChartData = @json($obChart['rows'][0]); 
  var offsetChartData = @json($offsetChart['rows'][0]);
  var timeentryChartData = @json($timeentryChart['rows'][0]);
  var ScheduleChangeChartData = @json($ScheduleChangeChart['rows'][0]);
  var HRDCertificateChartData = @json($HRDCertificateChart['rows'][0]); 
  var approvalsBarData = @json($approvalCount['rows'][0]); 


  function view_announcement(num){ 
       window.location.href='{{url("/announcement_details?num=")}}'+num;
    } 
</script> 

<div class="container-fluid">
    <div class="row"> 
        <div class="col-lg-12">
            <div class="greeting-widget shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Hi, <?=session()->get('fullname')?></h5>
                    <p class="card-text">Welcome back to your dashboard. Let's make today awesome!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
&nbsp;&nbsp;&nbsp;
<button id="btn9999" class="btn btn-primary" onclick="return SaveUserDashboard(this.id)"><?=$btnText?></button>
 
 @foreach($sub_applications['rows'] as $row) 
     <a href="{{ url('/' . $row->route) }}" target="_blank" class="btn btn-success">
        <i class="{{ $row->icon }}"></i> {{ $row->appName }}
    </a>
 @endforeach 

<?php if($mode==1){?>
  <button id="btn9910" class="btn btn-success"  onclick="return ResetDashboard(this.id)">Reset Widgets</button> 
<?php }?>

<div class="container-fluid mt-4 card-container" id="cardContainer"></div>

<script>  /* LOAD WIDGETS */

          var new_value;
          var if_approver = "<?=$if_approver?>";
          var userDashJson = [];
          var ytd_years = <?=json_encode($emp_ytd_tax_years['rows'])?>; 
          var dtr_dates = <?=json_encode($posted_dtr_dates['rows'])?>; 

          var ytdOpt = "<option></option>"; 
          var dtrOpt = "<option></option>"; 

          dtr_dates.forEach(function(row, index) { 
           dtrOpt+=`<option value="`+row.payrollPeriod+`">`+row.date_range+`</option>`;
          });

          ytd_years.forEach(function(row, index) { 
           ytdOpt+=`<option value="`+row.taxYear+`">`+row.taxYear+`</option>`;
          });
          
          //console.log(dtrOpt);
          //console.log(testLang); payrollPeriod date_range

          const announcement = <?= json_encode($annonucement) ?>;
          const calendar = <?= json_encode($calendar) ?>;
          const approvals = <?= json_encode($approvalsData) ?>;
          const application = <?= json_encode($applicationData) ?>;
          const otherRows = <?= json_encode($otherRowsData) ?>; 
          const applicationMonitor = <?= json_encode($applicationMonitoringData) ?>;
          const TotalEmployeeAppReceivedPerCutOff = <?= json_encode($TotalEmployeeAppReceivedPerCutOff) ?>;
          const loanOverView = <?= json_encode($loanOverView) ?>;
          const dtrViewPerCutOff = <?= json_encode($dtrViewPerCutOff) ?>;
          const bioAndLeaveData = <?= json_encode($bioAndLeaveData) ?>;
          const EmployeeBiometricsLogs = <?= json_encode($EmployeeBiometricsLogs) ?>;
          const EmployeeSchedule = <?= json_encode($EmployeeSchedule) ?>;
          const yearToDate = <?= json_encode($yearToDate) ?>;

          
      
          const container = document.getElementById('cardContainer');
        
          let draggedCard = null;
          let draggedRow = null;
          var mode = "<?=$mode?>"; 
          var IsDragabble = (mode=="1" ? `draggable="true"` : "");
        
          function GenerateAppCard(title, icon, count,visibility,link) {  
            var newTitle  = new_value.replace(/\s+/g, '').split("_For_")[1]; 
            var aFucos = (newTitle=="ForApproval") ? `<a class="aFocus" href="" id="forApprovallbl"></a>` : `<a class="aFocus" href="" id="applicationllbl"></a> `;
            var isDisabled = (visibility==2) ? "disabled" : "";
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)" `+isDisabled+`>` : "");
           /*  alert(newTitle+' '+visibility); */
            if (mode==0 && visibility!==1){
              return `<div></div>`;
            }else{
            return `
                  <div id="`+new_value+`" class="col-md-4 col-lg-3 mb-4" `+IsDragabble+` >`+showCheckBox+`
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="card-content">
                                <div text-white square">
                                    <i class="bi bg-custom `+icon+`"></i>
                                </div>
                                <div class="ml-3">
                                    <h5 class="card-title">`+title+`</h5> 
                                    <p class="card-count">`+count+`</p>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <a href="`+link+`">Get More details...</a>
                        </div>
                    </div>
                    `+aFucos+`
                </div>
                
            `;
            }
          }

          function GenerateAnnounceCard(visibility) {
            var if_approver = <?=$if_approver?>;
            var addBtn = (if_approver==1) ? "<div class='floatR'><a class='btn btn-primary' href='new_announcement'>+ Create</a></div>" : "";
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
            return `
            <div id="`+_newTitle+`" `+IsDragabble+` >`+showCheckBox+`
              <div class="schedlue-section">
                        <div class="announcement-header"> 
                        <a class="aFocus" href="" id="announcelbl"></a> 
                            <div><h2>📢 Announcements</h2></div> 
                             `+addBtn+`
                        </div>
                        <div class="announcement-list" id="announce_list"> 
                        Please wait....  
                        </div>
                    </div>
                </div>
              </div>
            `;
            }
          }

          function GenerateCalendarCard(visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
            <div id="`+_newTitle+`" `+IsDragabble+` >`+showCheckBox+`
                <div class="schedlue-section" >
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
                            <div id="divSchedule">Please wait....</div>
                        </div>
                    </div>
                    </div>
            `;
            }
          }

          function GenerateChartCard(thisTitle,visibility) { 
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            let newID = 'myPieChart'+thisTitle.replace(/\s+/g, ''); 
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
            return `  
                    <div id="`+_newTitle+`" class="col-lg-6" `+IsDragabble+` >`+showCheckBox+`
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                `+thisTitle+`
                            </div>
                            <a class="aFocus" href="" id="appCutofflbl"></a> 
                            <div class="card-body"><canvas id="`+newID+`" width="100%" height="50"></canvas></div> 
                        </div>
                    </div>
            `;
            }
           
          }

          function GeneratetotalEmpAppRecPerCutOff(visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
                    <div id="`+_newTitle+`" class="container-fluid mt-4" `+IsDragabble+` >`+showCheckBox+`
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
            `;
            }
          }

          
          function GenerateloanOverView(visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
                  <div id="`+_newTitle+`" class="container-fluid mt-4" `+IsDragabble+` >`+showCheckBox+`
                  <div class="card mb-4">
                      <div class="card-header">
                          <i class="fa-solid fa-money-bill"></i>
                          Loan Overview 
                          <div class="float-end">
                              <a class="aFocus" href="" id="loanlbl"></a>
                              <l class="fs-6">Date Effective From:</l><label for=""><input type="date" id="loanDateFrom" class="dashtxt" onchange="return getLoans()"/></label>

                              <l class="fs-6">&nbsp;&nbsp; To:</l><label for=""><input type="date" id="loanDateTo" class="dashtxt"  onchange="return getLoans()"/></label>
                          </div>
                      </div>
                      <div class="card-body" id="divLoanView">Please wait....</div>
                  </div>
              </div>
                `;
            }
          }

          function GeneratedtrViewPerCutOff(visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
                  <div id="`+_newTitle+`" class="container-fluid mt-4" `+IsDragabble+` >`+showCheckBox+`
                  <div class="card mb-4">
                      <div class="card-header">
                          <i class="fas fa-table me-1"></i>
                          DTR VIEW PER CUT - OFF 
                          <div class="float-end">
                              <l class="fs-6">Payroll period date:</l>
                              <a class="aFocus" href="" id="dtrlbl"></a> 
                              <label for="">
                                  <select id="payrollPeriodId" name="payrollPeriodId" class="form-select d-inline" onchange="show_dtr_view_per_cutoff()">
                                  `+dtrOpt+`
                                  </select>
                              </label>
                          </div>
                      </div>
                      <div class="card-body" id="divDtrView">Please wait....</div>
                  </div>
              </div>
                `;
            }
          }


          function GeneratebioAndLeaveData(thisTitle,visibility) {
            
            var dtrBtn = ((<?= $addDtrButton ?>)==1 ? `<button id="btnDTR" class="btn btn-primary" onclick="return AddDTR(this.id)">+ Add DTR</button>` : ``); 
            var newID  = thisTitle.replace(/\s+/g, ''); 
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            var addBtn = (newID=="BiometricsData") ? dtrBtn : "" ;
            var aFucos = (newID=="BiometricsData") ? `<a class="aFocus" href="" id="biolbl"></a> ` : `<a class="aFocus" href="" id="leaveBallbl"></a> ` ;

            
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
              <div id="`+new_value+`" class="col-xl-6" `+IsDragabble+` >`+showCheckBox+`
                    <div class="card mb-4 shadow-sm border-0">
                        
                        <div class="card-header">
                            <i class="fa-solid fa-fingerprint me-1"></i> 
                            `+thisTitle+`
                            <div class="float-end">`+addBtn+`</div> 
                        </div> 
                        `+aFucos+`
                        <div id="`+newID+`" class="card-body"> 
                          Please wait....
                        </div>
                    </div>
                </div>
            `;
            }
          }


          function GenerateEmployeeBiometricsLogs(thisTitle,visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
              <div id="`+_newTitle+`" class="col-xl-12" `+IsDragabble+` >`+showCheckBox+`
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header">
                            <i class="fa-solid fa-fingerprint me-1"></i> 
                            `+thisTitle+`
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
                        <div class="card-body" id="divEmployeeLogs">Please wait....</div> 
                    </div>
                </div>
            `;
            }
          }

          function GenerateyearToDate(thisTitle,visibility) {
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
              <div id="`+_newTitle+`" class="col-xl-12" `+IsDragabble+` >`+showCheckBox+`
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header">
                            <i class="fa-solid fa-calendar me-1"></i>
                            `+thisTitle+`
                            <div class="float-end">
                                <l class="fs-6">Select Year-Tax:</l>
                                <label for="">
                                    <select id="ddl_tax_years" class="form-select d-inline" onchange="show_emp_ytd()"> 
                                    `+ytdOpt+`
                                    </select>
                                </label>
                            </div>
                        </div> 
                        <a href="" class="aFocus" id="ytdlbl"></a>
                        <div class="card-body" id="divYTD">Please wait....</div> 
                    </div>
                </div>
            `;
            }
          }

          function GenerateEmployeeSchedule(thisTitle,visibility){
            var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" `+((visibility==1) ? "checked" : "")+` onchange="return GetClosetdiv(this)">` : "");
            if (mode==0 && visibility==0){
              return `<div></div>`;
            }else{
              return `
              <div id="`+_newTitle+`" class="col-xl-12" `+IsDragabble+` >`+showCheckBox+`
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header">
                            <i class="fa-solid fa-calendar me-1"></i>
                            `+thisTitle+`
                            <div class="float-end">
                                <l class="fs-6">Start From:</l>
                                <label for=""> 
                                    <input type="date" class="form-control d-inline" id="txtStartDate">  
                                </label>
                                <l class="fs-6">To:</l>
                                <label for=""> 
                                    <input type="date" class="form-control d-inline" id="txtEndDate">  
                                </label>
                                 <label for=""> 
                                    <button id="btnxx2" class="btn btn-primary" onclick="return show_EmpSchedule(this.id)"> Filter</button>
                                </label>
                            </div>
                        </div> 
                        <a href="" class="aFocus" id="EmpSchedlbl"></a>
                        <div class="card-body" id="divEmpSched">Please wait....</div> 
                    </div>
                </div>
            `;
            }
          }
        
          function createRow(headerTitle,headerIcon,data, thisClassName = "") { 
          
            const row = document.createElement('div');
            row.className = `row ${thisClassName}`; 
            row.setAttribute('draggable', true); 
            

            if ((thisClassName=="approval-row" || thisClassName=="applicationMonitor-row") && if_approver=="0"){
                
            }else{
                if(headerTitle!=="" && headerTitle!=="others"){  
                  const newElement = document.createElement('div');
                  newElement.classList.add('cardTitle');
                  var newTitle = `<h4><i class="`+headerIcon+`"></i>`+headerTitle+`</h4>`;
                  newElement.innerHTML = newTitle;  
                  row.appendChild(newElement);
                }
            }
            
 


            data.forEach((approval) => {  
              var visibility = approval.visibility;
              var rowID  = approval.title.replace(/\s+/g, ''); 
              var rowHDR  = headerTitle.replace(/\s+/g, ''); 
              this.new_value = rowID+'_For_'+rowHDR;
              /* row.id = rowID; */

               
              this._newTitle  = new_value;   

              const cardWrapper = document.createElement('div');
              cardWrapper.id = new_value;
            
              if(approval.title=="annonucement"){
                cardWrapper.innerHTML = GenerateAnnounceCard(visibility);  

              }else if(approval.title=="calendar"){
                cardWrapper.innerHTML = GenerateCalendarCard(visibility); 

              }else if(thisClassName=="applicationMonitor-row"){
                cardWrapper.innerHTML = GenerateChartCard(approval.title,visibility); 

              }else if(thisClassName=="totalEmpAppRecPerCutOff-row"){
                cardWrapper.innerHTML = GeneratetotalEmpAppRecPerCutOff(visibility); 
 
              }else if(thisClassName=="loanOverView-row"){ 
                cardWrapper.innerHTML = GenerateloanOverView(visibility); 

              }else if(thisClassName=="dtrViewPerCutOff-row"){ 
                cardWrapper.innerHTML = GeneratedtrViewPerCutOff(visibility); 

              }else if(thisClassName=="others-row"){ 
                cardWrapper.innerHTML = GeneratebioAndLeaveData(approval.title,visibility); 

              }else if(thisClassName=="EmployeeBiometricsLogs-row"){
                cardWrapper.innerHTML = GenerateEmployeeBiometricsLogs(approval.title,visibility); 
              }else if(thisClassName=="EmployeeSchedule-row"){
                cardWrapper.innerHTML = GenerateEmployeeSchedule(approval.title,visibility); 

              }else if(thisClassName=="yearToDate-row"){
                cardWrapper.innerHTML = GenerateyearToDate(approval.title,visibility); 
              }  else{
                cardWrapper.innerHTML = GenerateAppCard(
                  approval.title,
                  approval.icon,
                  approval.count,
                  approval.visibility,
                  approval.link
                ); 
              } 
              

              const card = cardWrapper.firstElementChild;


          
              card.addEventListener('dragstart', () => {
                draggedCard = card;
              });

              card.addEventListener('dragover', (e) => {
                e.preventDefault();
                if (card !== draggedCard) {
                  card.classList.add('drag-over');
                }
              });

              card.addEventListener('dragleave', () => {
                card.classList.remove('drag-over');
              }); 


                  card.addEventListener('drop', () => {
                    card.classList.remove('drag-over');

                    const draggedCardRow = draggedCard.closest('.row');
                    const targetCardRow = card.closest('.row');

                    if (draggedCardRow === targetCardRow && draggedCard !== card) {
                      // Store references to original children
                      const draggedChildren = Array.from(draggedCard.childNodes);
                      const targetChildren = Array.from(card.childNodes);

                      // Clear both cards
                      draggedCard.innerHTML = '';
                      card.innerHTML = '';

                      // Append swapped content
                      targetChildren.forEach(child => draggedCard.appendChild(child));
                      draggedChildren.forEach(child => card.appendChild(child));
                    }
                  });

   
        
              card.addEventListener('dragend', () => {
                document.querySelectorAll('.card').forEach(c => c.classList.remove('drag-over'));
              });

        
              row.appendChild(card);


            
            }); 

            

            row.addEventListener('dragstart', () => { 
              if (mode=="1"){
                draggedRow = row;
              }
            });

            row.addEventListener('dragover', (e) => {
              e.preventDefault();
              row.classList.add('drag-over');
            });

            row.addEventListener('dragleave', () => {
              row.classList.remove('drag-over');
            });

            row.addEventListener('drop', (e) => {
              e.preventDefault();
              row.classList.remove('drag-over');
              if (draggedRow !== row) {
                const rows = Array.from(container.children);
                const draggedRowIndex = rows.indexOf(draggedRow);
                const targetRowIndex = rows.indexOf(row);
                if (targetRowIndex > draggedRowIndex) {
                  container.insertBefore(draggedRow, row.nextSibling);
                } else {
                  container.insertBefore(draggedRow, row);
                }
              }
            });

            return row;
          }

          
        const announcementRow= createRow("","",announcement, "announcement-row");
        const calendarRow= createRow("","",calendar, "calendar-row");
        const approvalRow = createRow("For Approval","bi bi-hand-thumbs-up-fill",approvals, "approval-row");
        const applicationRow = createRow("Application","bi bi-gear-fill",application, "application-row");
        const applicationMonitorRow = createRow("Application Monitoring per Cut - Off","bi bi-tv-fill",applicationMonitor, "applicationMonitor-row");
        const TotalEmployeeAppReceivedPerCutOffRow = createRow("","",TotalEmployeeAppReceivedPerCutOff, "totalEmpAppRecPerCutOff-row");
        const loanOverViewRow = createRow("","",loanOverView, "loanOverView-row");
        const dtrViewPerCutOffRow = createRow("","",dtrViewPerCutOff, "dtrViewPerCutOff-row");
        const bioAndLeaveDataRow = createRow("others","",bioAndLeaveData, "others-row");
        const EmployeeBiometricsLogsRow = createRow("","",EmployeeBiometricsLogs, "EmployeeBiometricsLogs-row");
        const yearToDateRow = createRow("","",yearToDate, "yearToDate-row");
        const EmployeeScheduleRow = createRow("","",EmployeeSchedule, "EmployeeSchedule-row");
       
        var userDashboarWidgetsOrderBy = <?=json_encode($uniqueRowNames)?>;

        for(var i = 0; i < userDashboarWidgetsOrderBy.length; i++){
              const newRow = userDashboarWidgetsOrderBy[i];
              
              if (newRow=="calendar"){
                container.appendChild(calendarRow);
              }

               if (newRow=="annonucement"){
                container.appendChild(announcementRow);
              }

               if (newRow=="ForApproval"){
                container.appendChild(approvalRow);
              } 

               if (newRow=="Application"){
                 container.appendChild(applicationRow);
              }

               if (newRow=="ApplicationMonitoringperCut-Off"){
                 container.appendChild(applicationMonitorRow);
              }
 
              if (newRow=="TotalEmployeeAppReceivedPerCutOff"){
                container.appendChild(TotalEmployeeAppReceivedPerCutOffRow);
              }

              
              if (newRow=="loanOverView"){
                container.appendChild(loanOverViewRow);
              }

              if (newRow=="dtrViewPerCutOff"){
                container.appendChild(dtrViewPerCutOffRow);
              }

               if (newRow=="others"){ 
                container.appendChild(bioAndLeaveDataRow);
              }

              if (newRow=="EmployeeBiometricsLogs"){
                container.appendChild(EmployeeBiometricsLogsRow);
              }

              if (newRow=="EmployeeSchedule"){
                  container.appendChild(EmployeeScheduleRow);
              }

              if (newRow=="YearToDate"){
                 container.appendChild(yearToDateRow);
              }  
        }
 


      function GetClosetdiv(this_value){   
          if (this_value.checked){
            this_value.setAttribute("checked", "checked");
          } else{
            this_value.removeAttribute("checked"); 
          }  
      }

      function GetUserDashboardUpdate(){

          const thisContainer = document.getElementById("cardContainer");
          const rowDiv = thisContainer.children;
          var orderNum = 1;
          for (var i = 0; i < rowDiv.length; i++) {
              var div = rowDiv[i];  
              var rows = div.children; 
              var lineId = 0;
              for (var s = 0; s < rows.length; s++){ 
                  var header = rows[s].id; 
                  var child = rows[s].children; 
                    
                    for (var a = 0; a < child.length; a++) {
                      if (child[a].type === "checkbox") {
                        var checkbox = child[a]; 
                        var IsVisible = (checkbox.checked) ? 1 : 0;
                        var wedgetName = checkbox.value; 
                        var NewJson = {"wedgetName":wedgetName,"IsVisible": IsVisible,"orderNum":orderNum,"lineId":(lineId==0) ? 1 : lineId}; 
                        userDashJson = userDashJson.filter(card => card.wedgetName !== wedgetName);
                        userDashJson.push(NewJson);
                        
                      } 
                    } 
                    lineId+=1;
              } 
              
              orderNum+=1;
          }
      }

      async function SaveUserDashboard(objID){  
            GlovalHTMLObjLoading(1,objID);  
            var mode = "<?=$mode?>"; 
            if (mode==0){
                  var callPage = await SetSession("dash_edit_mode",1);  
                  window.location.href='{{url("/dash_cust")}}'; 
            }else{ 
                  GetUserDashboardUpdate();   
                  var callPage = await SetSession("dash_edit_mode",0);  
                  GlovalHTMLObjLoading(1,objID); 
                  var formData = new FormData();
                  formData.append('mode', '24');    
                  formData.append('pint_mode', 2);  
                  formData.append('json_data',JSON.stringify(userDashJson));     
                  const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  
                  GlovalHTMLObjLoading(0,objID);    
                  window.location.href='{{url("/dash_cust")}}';  
            } 
      }

      async function ResetDashboard(objID) {
        GlovalHTMLObjLoading(1,objID);  
        var callPage = await SetSession("dash_edit_mode",0);  
        var formData = new FormData();
        formData.append('mode', '25');  
        const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');   
        window.location.href='{{url("/dash_cust")}}'; 

      }

</script>

<script> 
              
    function show_announcement(){
         
        var formData = new FormData();
        formData.append('mode', 1);   
        GlovalHTMLObjLoading(1, 'announce_list'); 
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/load_announce")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#announce_list').html(response);
            },
            error: function (msg) {
              
                console.log('Error:' + JSON.stringify(msg));
            }

        }); 

    }
     
    function show_leaveBalances(){ 
 
        var formData = new FormData();
        formData.append('mode', 1);   
        GlovalHTMLObjLoading(1, 'LeaveBalances'); 
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/leave_bal")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#LeaveBalances').html(response);
            },
            error: function (msg) {
              
                console.log('Error:' + JSON.stringify(msg));
            }

        }); 

    }

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
              
                console.log('Error:' + JSON.stringify(msg));
            }

        });

    }

    function getLoans(){
      
          var df = document.getElementById('loanDateFrom').value;
          var dt = document.getElementById('loanDateTo').value;
           
          var formData = new FormData();
          formData.append('df', df); 
          formData.append('dt', dt); 
          
          GlovalHTMLObjLoading(1, 'divLoanView'); 
          var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          $.ajax({
              url: '{{url("/view_loan")}}',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                  'X-CSRF-TOKEN': csrfToken
              },
              success: function (response) {
                  $('#divLoanView').html(response);
              },
              error: function (msg) {
                
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
              
                console.log('Error:' + JSON.stringify(msg));
            }

        });  
    }

    function show_EmpSchedule(objID) {

      var startDate = document.getElementById('txtStartDate').value; 
      var endDate = document.getElementById('txtEndDate').value; 
        
        var formData = new FormData();
        formData.append('startDate', startDate);
        formData.append('endDate', endDate);  
        GlovalHTMLObjLoading(1, objID);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/empSchedule")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
              GlovalHTMLObjLoading(0, objID);
                $('#divEmpSched').html(response);
            },
            error: function (msg) {
              
                console.log('Error:' + JSON.stringify(msg));
            }

        });
 
  
        /* var formData = new FormData();
        formData.append('mode', 1);    
        formData.append('startDate', document.getElementById('txtStartDate').value);  
        formData.append('endDate', document.getElementById('txtEndDate').value);  
        GlovalHTMLObjLoading(1, 'divEmpSched'); 
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{url("/empSchedule")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#divEmpSched').html(response);
            },
            error: function (msg) {
                console.log('Error:' + JSON.stringify(msg));
            }

        });   */
    } 
    
    function show_dtrLogs(num){ 
        var formData = new FormData();
        formData.append('mode', 1);  
        formData.append('num', num); 
        GlovalHTMLObjLoading(1, 'BiometricsData'); 
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
                $('#BiometricsData').html(response);
            },
            error: function (msg) {
              
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
        var thisUrl = (appStatus=="" ? '{{url("/change_sched")}}' : '{{url("/sc_pending")}}');
        //alert(thisUrl);
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
                    
                console.log('Error:'+JSON.stringify(msg));
                } 
                
        });

    }
     
   
   
    async function AddDTR(objID){ 
        GlovalHTMLObjLoading(1,objID); 
        var title =document.getElementById('dashboardModalLabel');
        title.innerHTML="Online DTR";

        var formData = new FormData();
        formData.append('id', 0);  // Add other form fields here if needed  
        var myModal = new bootstrap.Modal(document.getElementById('dashboardModal'));   
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
                //url: '{{url("/dtr")}}', 
                url: baseUrl+'/dtr',  
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
                
                console.log('Error:'+JSON.stringify(msg));
                } 
                
        });

    } 
    
    
    const functions = [ 
    () => show_announcement(),
    () => show_schedule(0),
     () => getLoans(),
    () => show_dtr_view_per_cutoff(),
    () => show_dtrLogs(0),
     () => show_leaveBalances(),
    () => show_emp_bio_logs(),
    () => show_emp_ytd(),
    () => show_EmpSchedule()
    ];

    functions.forEach((fn, index) => {
    setTimeout(fn, (index + 1) * 5000);  
    });
   
    
  
  
   
     /*  const functions = [ 
      () => show_schedule(0)
      ];

      functions.forEach((fn, index) => {
      setTimeout(fn, (index + 1) * 5000);  
      }); */
 
    
</script>
 

<script>
    var newURL = new URL(window.location.href); 
    var id = newURL.searchParams.get('id'); 
    var inputElement = document.getElementById(id);  
     
    window.onload = function() { 
       if(inputElement) inputElement.focus();
    };
      
</script>


<script src="{{ asset('admin/js/chart-bar.js')}}"></script> 
<script src="{{ asset('admin/js/chart-pie.js')}}"></script>

@endsection