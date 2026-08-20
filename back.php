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

      .cardTitle{ 
      margin-top:50px;
    }

    .chkboxView{
      position: absolute; 
      margin-top:-10px;
      z-index: 2; 
    }
</style>

<?php
 

      $annonucement[] = [
        'title' => 'annonucement',
        'icon' => '',
        'count' => 2
      ];

      $calendar[] = [
        'title' => 'calendar',
        'icon' => '',
        'count' => 2
      ];

      $TotalEmployeeAppReceivedPerCutOff[]  = [
      'title' => 'TotalEmployeeAppReceivedPerCutOff',
      'icon' => '',
      'count' => 2
      ];

      $dtrViewPerCutOff[]  = [
      'title' => 'dtrViewPerCutOff',
      'icon' => '',
      'count' => 2
      ];

      $EmployeeBiometricsLogs[]  = [
      'title' => 'Employee Biometrics Logs ',
      'icon' => '',
      'count' => 2
      ];

      $yearToDate[]  = [
      'title' => 'Year To Date',
      'icon' => '',
      'count' => 2
      ];






      $otherRows = [
        ['title' => 'Approval Request', 'icon' => 'bi-check-circle'],
        ['title' => 'Budgeting', 'icon' => 'bi-calculator'],
        ['title' => 'Compliance', 'icon' => 'bi-shield-lock'],
        ['title' => 'Performance Review', 'icon' => 'bi-bar-chart']
      ];



      $approvalsData = [];
      foreach ($approvals as $approval) {
      $approvalsData[] = [
          'title' => $approval['title'],
          'icon' => $approval['icon'],
          'count' => 2
      ];
      }

      $applicationData = [];
      foreach ($applications as $app) {
      $applicationData[] = [
          'title' => $app['title'],
          'icon' => $app['icon'],
          'count' => 2
      ];
      }

      $applicationMonitoringData = [];
      foreach ($applications as $app) {
      $applicationMonitoringData[] = [
          'title' => $app['title'],
          'icon' => $app['icon'],
          'count' => 2
      ];
      }


      $bioAndLeave = [
      ["title" => " Biometrics Data", "icon" => "bi-clock-history"],
      ["title" => " Leave Balances ", "icon" => "bi-clock-history"],
      ];

      $bioAndLeaveData = [];
      foreach ($bioAndLeave as $row) {
      $bioAndLeaveData[] = [
          'title' => $row['title'],
          'icon' => $row['icon'],
          'count' => 2
      ];
      }


      $otherRowsData = [];
      foreach ($otherRows as $row) {
      $otherRowsData[] = [
          'title' => $row['title'],
          'icon' => $row['icon'],
          'count' => 2
      ];
      }


      /* echo json_encode($mode); */

     /*  echo json_encode($leaveChart['rows']); */
?>

<div class="container-fluid mt-4 card-container" id="cardContainer"></div>


<script> 

  var new_value;

  const announcement = <?= json_encode($annonucement) ?>;
  const calendar = <?= json_encode($calendar) ?>;
  const approvals = <?= json_encode($approvalsData) ?>;
  const application = <?= json_encode($applicationData) ?>;
  const otherRows = <?= json_encode($otherRowsData) ?>; 
  const applicationMonitor = <?= json_encode($applicationMonitoringData) ?>;
  const TotalEmployeeAppReceivedPerCutOff = <?= json_encode($TotalEmployeeAppReceivedPerCutOff) ?>;
  const dtrViewPerCutOff = <?= json_encode($dtrViewPerCutOff) ?>;
  const bioAndLeaveData = <?= json_encode($bioAndLeaveData) ?>;
  const EmployeeBiometricsLogs = <?= json_encode($EmployeeBiometricsLogs) ?>;
  const yearToDate = <?= json_encode($yearToDate) ?>;
  
  

  const container = document.getElementById('cardContainer');
 
  let draggedCard = null;
  let draggedRow = null;
  var mode = "<?=$mode?>"; 
  var IsDragabble = (mode=="1" ? `draggable="true"` : "");
 
  function GenerateAppCard(title, icon, count) { 
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)">` : "");
    return `
          <div id="`+_newTitle+`" class="col-md-6 col-lg-3 mb-4" `+IsDragabble+` >`+showCheckBox+`
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-content">
                        <div text-white square">
                            <i class="bi bg-custom `+icon+`"></i>
                        </div>
                        <div class="ml-3">
                            <h5 class="card-title">`+title+`</h5> 
                            <p class="card-count">3</p>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <a href="#">Get More details...</a>
                </div>
            </div>
        </div>
    `;
  }

  function GenerateAnnounceCard() {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
    return `
    <div id="`+_newTitle+`" `+IsDragabble+` >`+showCheckBox+`
      <div class="schedlue-section">
                <div class="announcement-header"> 
                <a class="aFocus" href="" id="announcelbl"></a> 
                    <div><h2>📢 Announcements</h2></div> 
                </div>
                <div class="announcement-list">  
                    <p>No announcements at the moment. Check back later!</p>
                </div>
            </div>
        </div>
      </div>
    `;
  }

  function GenerateCalendarCard() {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
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
                    <div id="divSchedule"></div>
                </div>
            </div>
             </div>
    `;
  }

  function GenerateChartCard(thisTitle) {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
    let newID = 'myPieChart'+thisTitle.replace(/\s+/g, ''); 

    return `  
            <div id="`+_newTitle+`" class="col-lg-6" `+IsDragabble+` >`+showCheckBox+`
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        `+thisTitle+`
                    </div>
                    <a class="aFocus" href="" id="appCutofflbl"></a> 
                    <div class="card-body"><canvas id="`+newID+`" width="100%" height="50"></canvas></div>
                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                </div>
            </div>
    `;
  }

  function GeneratetotalEmpAppRecPerCutOff() {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
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

  function GeneratedtrViewPerCutOff() {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
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
                              </select>
                      </label>
                  </div>
              </div>
              <div class="card-body" id="divDtrView"></div>
          </div>
      </div>
        `;
  }


  function GeneratebioAndLeaveData(thisTitle) {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
    return `
      <div id="`+_newTitle+`" class="col-xl-6" `+IsDragabble+` >`+showCheckBox+`
            <div class="card mb-4 shadow-sm border-0">
                
                <div class="card-header">
                    <i class="fa-solid fa-fingerprint me-1"></i> 
                    `+thisTitle+`
                    <div class="float-end"></div> 
                </div>

                <a class="aFocus" href="" id="biolbl"></a> 
                <div id="dtrLogs" class="card-body"> 
                </div>
            </div>
        </div>
    `;
  }


  function GenerateEmployeeBiometricsLogs(thisTitle) {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
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
                <div class="card-body" id="divEmployeeLogs"> </div> 
            </div>
        </div>
    `;
  }

  function GenerateyearToDate(thisTitle) {
    var showCheckBox = (mode=="1" ? `<input type="checkbox" value="`+new_value+`" class="chkboxView" onchange="return GetClosetdiv(this)" >` : "");
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
                            </select>
                        </label>
                    </div>
                </div> 
                <a href="" id="ytdlbl"></a>
                <div class="card-body" id="divYTD"> </div>

            </div>
        </div>
    `;
  }
 
  function createRow(headerTitle,headerIcon,data, thisClassName = "") { 
   
    const row = document.createElement('div');
    row.className = `row ${thisClassName}`; 
    row.setAttribute('draggable', true); 

     

    if(headerTitle!==""){ 
      const newElement = document.createElement('div');
      newElement.classList.add('cardTitle');
      var newTitle = `<h4><i class="`+headerIcon+`"></i>`+headerTitle+`</h4>`;
      newElement.innerHTML = newTitle;  
      row.appendChild(newElement);
    }

   


    data.forEach((approval) => { 


      var rowID  = approval.title.replace(/\s+/g, ''); 
      var rowHDR  = headerTitle.replace(/\s+/g, ''); 
      this.new_value = rowID+'_For_'+rowHDR;
      /* row.id = rowID; */

      this._newTitle  = new_value;   

      const cardWrapper = document.createElement('div');
      cardWrapper.id = new_value;
    
      if(approval.title=="annonucement"){
        cardWrapper.innerHTML = GenerateAnnounceCard();  
      }else if(approval.title=="calendar"){
        cardWrapper.innerHTML = GenerateCalendarCard(); 
      }else if(thisClassName=="applicationMonitor-row"){
        cardWrapper.innerHTML = GenerateChartCard(approval.title); 
      }else if(thisClassName=="totalEmpAppRecPerCutOff-row"){
        cardWrapper.innerHTML = GeneratetotalEmpAppRecPerCutOff(); 
      }else if(thisClassName=="dtrViewPerCutOff-row"){
        cardWrapper.innerHTML = GeneratedtrViewPerCutOff(); 
      }else if(thisClassName=="bioAndLeaveData-row"){
        cardWrapper.innerHTML = GeneratebioAndLeaveData(approval.title); 
      }else if(thisClassName=="EmployeeBiometricsLogs-row"){
        cardWrapper.innerHTML = GenerateEmployeeBiometricsLogs(approval.title); 
      }else if(thisClassName=="yearToDate-row"){
        cardWrapper.innerHTML = GenerateyearToDate(approval.title); 
      }  else{
        cardWrapper.innerHTML = GenerateAppCard(
          approval.title,
          approval.icon,
          approval.count
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
        if (draggedCardRow === targetCardRow) {
          if (draggedCard !== card) {
            const draggedCardHTML = draggedCard.innerHTML;
            draggedCard.innerHTML = card.innerHTML;
            card.innerHTML = draggedCardHTML;
          }
        }
      });

  /* card.addEventListener('drop', () => {
  card.classList.remove('drag-over');

  const parent = card.parentNode;
  const draggedParent = draggedCard.parentNode;

  if (parent === draggedParent && draggedCard !== card) {
    const cardIndex = Array.from(parent.children).indexOf(card);
    const draggedIndex = Array.from(parent.children).indexOf(draggedCard);

    if (draggedIndex < cardIndex) {
      parent.insertBefore(draggedCard, card.nextSibling);
    } else {
      parent.insertBefore(draggedCard, card);
    }
  }
}); */


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
 const dtrViewPerCutOffRow = createRow("","",dtrViewPerCutOff, "dtrViewPerCutOff-row");
 const bioAndLeaveDataRow = createRow("","",bioAndLeaveData, "bioAndLeaveData-row");
 const EmployeeBiometricsLogsRow = createRow("","",EmployeeBiometricsLogs, "EmployeeBiometricsLogs-row");
 const yearToDateRow = createRow("","",yearToDate, "yearToDate-row");
 
 
 

  container.appendChild(announcementRow);
  container.appendChild(calendarRow);
  container.appendChild(approvalRow);
  container.appendChild(applicationRow);
  container.appendChild(applicationMonitorRow);
  container.appendChild(TotalEmployeeAppReceivedPerCutOffRow);
  container.appendChild(dtrViewPerCutOffRow);
  container.appendChild(bioAndLeaveDataRow);
  container.appendChild(EmployeeBiometricsLogsRow);
  container.appendChild(yearToDateRow);


/*   otherRows.forEach((rowData) => {
  container.appendChild(createRow([rowData], "other-row"));
  }); */


  function GetClosetdiv(this_value){ 
  }

</script>

<script>
  var leaveChartData = @json($leaveChart['rows']);
  var overtimeChartData = @json($overtimeChart['rows']);
  var timeAdjustmentChartData = @json($timeAdjustmentChart['rows']);
  var obChartData = @json($obChart['rows']); 
  var offsetChartData = @json($offsetChart['rows']); 
</script>
 
@endsection