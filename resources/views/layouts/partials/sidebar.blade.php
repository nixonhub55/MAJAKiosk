 
<?php
$hrisDetails = json_decode(session()->get('have_hris_details'), true);  
$raw = $hrisDetails['Hris']['PersonalInformation'] ?? [];
 
/**
 * RESULT MENU (FLAT)
 * - Take Identity children only
 * - Remove Identity itself
 * - EmployeeMovement only if true, no children
 */
$hrisMenu = [];
// print_r( $hrisDetails);
 
/* -----------------------------------
   1. TAKE IDENTITY CHILDREN ONLY
------------------------------------*/
$excludedKeys = ['leaveledger', 'identitycustomfields', 'payrollinformation', 'uploadpictureesig', 'benefits'];
 
if (isset($raw['Identity']) && is_array($raw['Identity'])) {
 
    foreach ($raw['Identity'] as $key => $value) {
 
        if ($key === 'show') continue;
 
        // skip excluded keys
        if (in_array(strtolower($key), $excludedKeys)) continue;
 
        // only show if true
        if (is_array($value) && isset($value['show']) && $value['show'] == true) {
 
            $hrisMenu[$key] = [
                'show' => true
            ];
        }
    }
}
 
/* -----------------------------------
   2. EMPLOYEE MOVEMENT (ONLY ITSELF)
   - NO CHILDREN
   - ONLY IF TRUE
------------------------------------*/
if (
    isset($raw['Identity']['EmployeeMovement']) &&
    is_array($raw['Identity']['EmployeeMovement']) &&
    !empty($raw['Identity']['EmployeeMovement']['show'])
) {
    $hrisMenu['EmployeeMovement'] = [
        'show' => true
    ];
}
 
/* -----------------------------------
   RENDER FUNCTION (FLAT ONLY)
------------------------------------*/
function formatLabel($text)
{
    // insert space before capital letters
    $text = preg_replace('/(?<!^)([A-Z])/', ' $1', $text);
 
    return ucwords(trim($text));
}
function renderHRISApprovalMenu($items)
{
    $html = '';
 
    foreach ($items as $key => $item) {
 
        if ($key === 'show') continue;
        if (!is_array($item)) continue;
 
        if (isset($item['show']) && $item['show'] == false) {
            continue;
        }
 
        $urlKey = strtolower($key);
        $url = url('/hris_approval_' . $urlKey);
 
        $active = request()->is('hris_approval_' . $urlKey);
 
        $icon = ($key === 'EmployeeMovement')
            ? 'fa-pen-fancy'
            : 'fa-pen-fancy';
 
      //   $label = ucwords(str_replace('_', ' ', $key));
      $label = formatLabel($key);
 
        $html .= '
            <a class="nav-link '.($active ? 'active-tab' : '').'"
               href="'.$url.'">
 
                <div class="sb-nav-link-icon">
                    <i class="fa-solid '.$icon.'"></i>
                </div>
 
                '.$label.'
            </a>
        ';
    }
 
    return $html;
}

?>
<style>
      .elevated-nav {
            background-color: white !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
      }

      /* Styles for active tab */
      .nav-link.active-tab {
            background-color: #003f5c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            color: #ffffff !important;
            /* Set font color to white for better contrast */
      }

      .nav-link {
            transition: all 0.3s ease-in-out;
            pointer-events: auto;
            color: #003f5c !important;
            /* Default font color for sidebar links */
      }

      .nav-link:hover {
            background-color: #003f5c;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #ffffff !important;
            /* Font color on hover */
      }

      .sb-sidenav-footer {
            color: #666;
            /* Font color for footer text */
      }
</style>
<?php
$compySettings = session()->get('companyPasswordSettings');
$compyLogo = $compySettings['companyLogoBlob']; 
$leave = 0;
$timeEntry = 0;
$scheduleChange = 0;
$overtime = 0;
$offsetTime = 0;
$timeAdjustment = 0;
$officialBusiness = 0;
$percentageallocation = 0;
$hrdCert = 0;
$clearance = 0;
$hris = session()->get('have_hris'); 
 
 

$leave_count = 0;
$timeEntry_count = 0;
$scheduleChange_count = 0;
$overtime_count = 0;
$offsetTime_count = 0;
$timeAdjustment_count = 0;
$officialBusiness_count = 0;
$percentageallocation_count = 0;
$hrdCert_count = 0;

$access_rights = session()->get('access_rights');

if (session()->get('have_clearance') != 0){
      $clearance = 1;
}


foreach ($access_rights['rows'] as $rows) {
      $leave = $rows->leave;
      $timeEntry = $rows->timeEntry;
      $scheduleChange = $rows->scheduleChange;
      $overtime = $rows->overtime;
      $offsetTime = $rows->offsetTime;
      $timeAdjustment = $rows->timeAdjustment;
      $officialBusiness = $rows->officialBusiness;
      $percentageallocation = $rows->percentageallocation;
      $hrdCert = $rows->hrdCert;
      $scheduleChange = $rows->scheduleChange;
      $hrdCert = $rows->hrdCert;
} 

 
?>

<nav class="sb-sidenav accordion sb-sidenav-white elevated-nav" id="">

      <div id="search2">
            @include('layouts.partials.searchbox')
      </div>

      <div class="sb-sidenav-menu">
            <div class="nav">
                  <div class="sb-sidenav-menu-heading">Core</div>
                  <a class="nav-link {{ request()->is('dash_cust') ? 'active-tab' : '' }}"
                        onclick="return setNotEditMode()">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                  </a> 

                  @php
                        $isMyProfileActive = request()->is('my_profile_details')
                              || request()->is('my_profile_payroll');
                  @endphp

                  <a class="nav-link collapsed {{ $isMyProfileActive ? 'active-tab' : '' }}" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapseMyProfile"
                        aria-expanded="{{ $isMyProfileActive ? 'true' : 'false' }}" aria-controls="collapseMyProfile">

                        <div class="sb-nav-link-icon">
                              <i class="fas fa-user"></i>
                        </div>

                        My Profile

                        <div class="sb-sidenav-collapse-arrow">
                              <i class="fas fa-angle-down"></i>
                        </div>
                  </a>

                  <div class="collapse {{ $isMyProfileActive ? 'show' : '' }}" id="collapseMyProfile"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                              <a class="nav-link {{ request()->is('my_profile_details') ? 'active-tab' : '' }}"
                                    href="{{ url('/my_profile_details') }}">
                                    <div class="sb-nav-link-icon">
                                          <i class="fa-solid fa-circle-info"></i>
                                    </div>
                                    Details
                              </a>

                              <a class="nav-link {{ request()->is('my_profile_payroll') ? 'active-tab' : '' }}"
                                    href="{{ url('/my_profile_payroll') }}">
                                    <div class="sb-nav-link-icon">
                                          <i class="fa-solid fa-money-bill"></i>
                                    </div>
                                    Payroll
                              </a>

                        </nav>
                  </div>


                  <div class="sb-sidenav-menu-heading">Interface</div>
  

                  <?php
                        $isHRISApprovalActive =
                        request()->is('hris_approval_personalinformation') ||
                        request()->is('hris_approval_dependent') ||
                        request()->is('hris_approval_identity') ||
                        request()->is('hris_approval_employeemovement');
                  ?>
                  @if ($hris == 1)

                        

                        <a class="nav-link collapsed {{ $isHRISApprovalActive ? 'active-tab' : '' }}"
                        href="#"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseHRISApproval"
                        aria-expanded="{{ $isHRISApprovalActive ? 'true' : 'false' }}"
                        aria-controls="collapseHRISApproval">

                        <div class="sb-nav-link-icon">
                              <i class="fa-solid fa-pen-fancy"></i>
                        </div>

                        HRIS Approval

                        <div class="sb-sidenav-collapse-arrow">
                              <i class="fas fa-angle-down"></i>
                        </div>
                        </a>

                        <div class="collapse {{ $isHRISApprovalActive ? 'show' : '' }}"
                        id="collapseHRISApproval"
                        data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">

                              {!! renderHRISApprovalMenu($hrisMenu) !!}

                        </nav>

                        </div>

                  @endif

                  
                  @if(session()->get('if_approver') == 1)
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                              aria-expanded="false" aria-controls="collapseLayouts">
                              <div class="sb-nav-link-icon"><i class="bi bi-hand-thumbs-up-fill"></i> </div>
                              For Approval
                              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                              data-bs-parent="#sidenavAccordion">
                              <nav class="sb-sidenav-menu-nested nav">


                                    <a class="nav-link {{ request()->is(patterns: 'timeentry_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/timeentry_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="fa-solid fa-business-time"></i></div>Time
                                          Entry
                                          <div id="temientry_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'overtime_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/overtime_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-clock-fill"></i></div>Overtime / Under time
                                          <div id="overtime_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'offset_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/offset_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-file-check-fill"></i></div>Offset
                                          <div id="offset_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'leave_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/leave_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-x-square-fill"></i></div> Leave
                                          <div id="leave_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'time_adjust_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/time_adjust_approval")}}'>
                                          <div class="sb-nav-link-icon"><i class="bi bi-stopwatch-fill"></i></div> Time
                                          Adjustment
                                          <div id="ta_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'ob_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/ob_approval")}}'>
                                          <div class="sb-nav-link-icon"><i class="bi bi-car-front-fill"></i></div> Official
                                          Business
                                          <div id="ob_not_div"></div>
                                    </a>



                                    <a class="nav-link {{ request()->is(patterns: 'sc_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/sc_approval")}}'>
                                          <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                                          Schedule Change
                                          <div id="sc_not_div"></div>
                                    </a>

                                    <a class="nav-link {{ request()->is(patterns: 'hrd_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/hrd_approval")}}'>
                                          <div class="sb-nav-link-icon"><i class="fa-solid fa-certificate"></i></div>HRD
                                          Certificate
                                          <div id="hrd_not_div"></div>
                                    </a>
<!-- 
                                    <a class="nav-link {{ request()->is(patterns: 'clearance_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/clearance_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="fa-solid fa-check-to-slot"></i></div>Clearance Form
                                          <div id="clearance_not_div"></div>
                                    </a> -->

          
                                    <a class="nav-link {{ request()->is(patterns: 'overtimeExt_approval') ? 'active-tab' : '' }}"
                                          href='{{url("/overtimeExt_approval")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-clock-fill"></i></div>Extension Allowance
                                          <div id="overtimeExt_not_div"></div>
                                    </a>

                              </nav>
                        </div>
                  @endif


                  <!-- Applications -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                        aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="bi bi-gear-fill"></i></div>
                        Applications
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                              @if($timeEntry == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'te_application') ? 'active-tab' : '' }}"
                                          href='{{url("/te_application")}}'>
                                          <div class="sb-nav-link-icon"><i class="fa-solid fa-business-time"></i></div>Time
                                          Entry
                                    </a>
                              @endif


                              @if($overtime == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'overtime_application') ? 'active-tab' : '' }}"
                                          href='{{url("/overtime_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-clock-fill"></i></div>Overtime / Under time
                                    </a>
                              @endif


                              @if($offsetTime == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'offset_application') ? 'active-tab' : '' }}"
                                          href='{{url("/offset_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-file-check-fill"></i></div>Offset
                                    </a>
                              @endif

                              @if($leave == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'leave_application') ? 'active-tab' : '' }}"
                                          href='{{url("/leave_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-x-square-fill"></i></div>Leave
                                    </a>
                              @endif

                              @if($timeAdjustment == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'time_adj_application') ? 'active-tab' : '' }}"
                                          href='{{url("/time_adj_application")}}'>
                                          <div class="sb-nav-link-icon"><i class="bi bi-stopwatch-fill"></i></div>Time
                                          Adjustment
                                    </a>
                              @endif

                              @if($officialBusiness == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'ob_application') ? 'active-tab' : '' }}"
                                          href='{{url("/ob_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-car-front-fill"></i></div>Official
                                          Business
                                    </a>
                              @endif

                              @if($scheduleChange == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'sc_application') ? 'active-tab' : '' }}"
                                          href='{{url("/sc_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="fa-solid fa-calendar-days"></i></div>
                                          Schedule Change
                                    </a>
                              @endif


                              @if($hrdCert == 1)
                                    <a class="nav-link {{ request()->is(patterns: 'hrd_application') ? 'active-tab' : '' }}"
                                          href='{{url("/hrd_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="fa-solid fa-certificate"></i></div>HRD
                                          Certificate
                                    </a>
                              @endif
                              
                              @if($clearance == 1)
                                 <!--    <a class="nav-link {{ request()->is(patterns: 'clearance') ? 'active-tab' : '' }}"
                                          href='{{url("/clearance")}}'>
                                          <div class="sb-nav-link-icon">  <i class="fa-solid fa-check-to-slot"></i></div>
                                          Clearance Form
                                    </a> -->
                              @endif

                              @if($overtime == 1 && session()->get('batchId')=="OFR")
                                    <a class="nav-link {{ request()->is(patterns: 'overtimeExt_application') ? 'active-tab' : '' }}"
                                          href='{{url("/overtimeExt_application")}}'>
                                          <div class="sb-nav-link-icon"> <i class="bi bi-clock-fill"></i></div>Extension Allowance  
                                    </a>
                              @endif


                              <a class="nav-link {{ request()->is(patterns: 'authority_to_deduct') ? 'active-tab' : '' }}"
                                    href='{{url("/authority_to_deduct")}}'>
                                    <div class="sb-nav-link-icon"> <i class="fa-solid fa-money-bill"></i></div>
                                    Authority to Deduct
                              </a>
                             


                        </nav>
                  </div> 
                  <!-- 
                  <a class="nav-link {{ request()->is(patterns: 'clearance_hr_view') ? 'active-tab' : '' }}"
                        href='{{url("/clearance_hr_view")}}'>
                        <div class="sb-nav-link-icon"> <i class="fa-solid fa-check-to-slot"></i></div>
                        Clearance Form HR
                  </a>  -->

                  
                   <?php // if (session()->get('departmentCode') == "HR") {?>
                     <!--    <a class="nav-link {{ request()->is(patterns: 'appraisal_form_view_supervisor') ? 'active-tab' : '' }}"
                              href='{{url("/appraisal_form_view_supervisor")}}'>
                              <div class="sb-nav-link-icon"> <i class="fa-solid fa-check-to-slot"></i></div>
                              Appraisal Form
                        </a> -->
                  <?php // } ?>

                  <?php // if (session()->get('departmentCode') == "HR") {?>
                       <!--  <a class="nav-link {{ request()->is(patterns: 'appraisal_supervisor_approver') ? 'active-tab' : '' }}"
                              href='{{url("/appraisal_supervisor_approver")}}'>
                              <div class="sb-nav-link-icon"> <i class="fa-solid fa-check-to-slot"></i></div>
                              Appraisal Form 2
                        </a> -->
                  <?php // } ?>

                  <!-- Reports -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages2"
                        aria-expanded="false" aria-controls="collapsePages2">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapsePages2" aria-labelledby="headingThree"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                              <a class="nav-link {{ request()->is(patterns: 'payslip_record') ? 'active-tab' : '' }}"
                                    href='{{url("/payslip_record")}}'>
                                    <div class="sb-nav-link-icon"><i class="bi bi-paypal"></i></div>Payslip Record
                              </a>
                              <a class="nav-link {{ request()->is(patterns: 'th_month_apy') ? 'active-tab' : '' }}"
                                    href='{{url("/th_month_apy")}}'>
                                    <div class="sb-nav-link-icon"><i class="bi bi-calendar2-plus"></i></div>13th Month
                                    Payslip
                              </a>
                              <a class="nav-link {{ request()->is(patterns: 'twenty_report') ? 'active-tab' : '' }}"
                                    href='{{url("/twenty_report")}}'>
                                    <div class="sb-nav-link-icon"><i class="bi bi-flag-fill"></i></div>2307 Report
                              </a>
                              <a class="nav-link {{ request()->is(patterns: 'bir_form_2316') ? 'active-tab' : '' }}"
                                    href='{{url("/bir_form_2316")}}'>
                                    <div class="sb-nav-link-icon"><i class="bi bi-file-post"></i></div>BIR Form 2316
                              </a>

                        </nav>
                  </div>

            </div>
      </div>
      <div class="sb-sidenav-footer">
            <div class="small">Login as:</div>
            <div> <?=session()->get('fullname')?></div>
      </div>
</nav>
<script>

      var is_approver = <?=session()->get('if_approver')?>;
      var this_int = <?=session()->get('app_time_interval')?>;

      var ot_count = <?=session()->get('ot_aprroval_count')?>;
      var leave_count = <?=session()->get('leave_aprroval_count')?>;
      var ta_count = <?=session()->get('ta_aprroval_count')?>;
      var ob_count = <?=session()->get('ob_aprroval_count')?>;
      var os_count = <?=session()->get('os_aprroval_count')?>;
      var te_count = <?=session()->get('te_aprroval_count')?>;
      var sc_count = <?=session()->get('sc_aprroval_count')?>;
      var hrd_count = <?=session()->get('hrd_aprroval_count')?>;
      var otExt_count = <?=session()->get('otExt_aprroval_count')?>;


      document.addEventListener('DOMContentLoaded', function () {
            const currentUrl = window.location.pathname;
            const activeLink = document.querySelector('.nav-link.active-tab');
            if (activeLink) {
                  const parentAccordion = activeLink.closest('.collapse');
                  if (parentAccordion) {
                        parentAccordion.classList.add('show');
                  }
            }
      });


      function ShowApproval_Notification() {

            var formData = new FormData();
            formData.append('mode', 10);

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                  url: '{{url("/call_ajax")}}',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  headers: {
                        'X-CSRF-TOKEN': csrfToken
                  },
                  success: function (response) {

                        GetNotificationNow(response.app_int);
                        //console.log(response.ta_rows);
                        SetNotificationCount(response.ot_rows
                              , response.leave_rows
                              , response.ta_rows
                              , response.ob_rows
                              , response.os_rows
                              , response.te_rows
                              , response.sc_rows
                              , response.hrd_rows
                              , response.otExt_rows);


                  },
                  error: function (msg) {
                        //alert(JSON.parse(msg.responseText).error.msg.msg);
                        console.log('Error:' + JSON.stringify(msg));
                  }
            });

      }


      function GetNotificationNow(this_time) {
            if (is_approver == 1) {
                  setTimeout(ShowApproval_Notification, this_time);
            }
      }

      function SetDivSpan(objID, count) {

            var thisDiv = document.getElementById(objID);

            if (thisDiv !== null) {
                  if (count > 0) {
                        thisDiv.innerHTML = "&nbsp;<span class='badge bg-danger'>" + count + "</span>";
                  } else {
                        thisDiv.innerHTML = "";
                  }
            }

      }

      function SetNotificationCount(ot, leave, ta, ob, os, te, sc, hrd, otExt) {

            SetDivSpan('overtime_not_div', ot);
            SetDivSpan('leave_not_div', leave);
            SetDivSpan('ta_not_div', ta);
            SetDivSpan('ob_not_div', ob);
            SetDivSpan('offset_not_div', os);
            SetDivSpan('temientry_not_div', te);
            SetDivSpan('sc_not_div', sc);
            SetDivSpan('hrd_not_div', hrd);
            SetDivSpan('overtimeExt_not_div', otExt);

      }


      async function setNotEditMode() {
            await SetSession("dash_edit_mode", 0);
            window.location.href = '{{url("/dash_cust")}}';
      }


      //GetNotificationNow(2000);
      SetNotificationCount(ot_count, leave_count, ta_count, ob_count, os_count, te_count, sc_count, hrd_count,otExt_count);
      ShowApproval_Notification();

</script>