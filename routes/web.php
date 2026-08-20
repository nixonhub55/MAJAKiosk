<?php

use App\Http\Controllers\Traffic;
use App\Http\Controllers\TenancyController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\CheckSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\DashboardController;
// Route::get('/', function () {
//     return view('welcome');
// });

// routes/web.php


// Route to display the login form
Route::match(['get', 'post'], '/', [Traffic::class, 'showLoginForm'])->name('login'); 

Route::get('/test-url', function () {
    return [
        'app_url' => config('app.url'),
        'login_url' => route('login'),
        'url' => url('/'),
        'asset_url' => config('app.asset_url'),
    ];
});

Route::match(['get', 'post'], 'saveSystemErrors', [Traffic::class, 'saveSystemErrors'])->name('saveSystemErrors');  
Route::match(['get', 'post'], 'saveSystemErrorList', [Traffic::class, 'saveSystemErrorList'])->name('saveSystemErrorList'); 

Route::match(['get', 'post'], 'deleteDevice', [Traffic::class, 'deleteDevice'])->name('deleteDevice'); 
Route::match(['get', 'post'], 'devicelist', [Traffic::class, 'devicelist'])->name('devicelist'); 
 
Route::match(['get', 'post'], '/getSecretKey', [Traffic::class, 'getSecretKey'])->name('getSecretKey');
Route::match(['get', 'post'], '/login', [Traffic::class, 'showLoginForm'])->name('login');
Route::match(['get', 'post'], '/login-submit', [Traffic::class, 'login'])->name('login.submit');
Route::match(['get', 'post'], '/login_submit', [Traffic::class, 'login_submit'])->name('login_submit');
Route::match(['get', 'post'], '/change_pass', [Traffic::class, 'changePass'])->name('change_pass');
Route::match(['get', 'post'], '/new_password', [Traffic::class, 'new_password'])->name('new_password');
Route::match(['get', 'post'], '/new_pass', [Traffic::class, 'validate_new_password'])->name('new_pass');
Route::match(['get', 'post'], '/select_db', [Traffic::class, 'selectDB'])->name('select_db');
Route::match(['get', 'post'], '/set_session', [Traffic::class, 'setSession'])->name('set_session'); 
Route::get('/pf_email', [MailController::class, 'PFMailer']);
Route::match(['get', 'post'], '/pf_structure', [Traffic::class, 'pf_structure'])->name('pf_structure'); 
Route::match(['get', 'post'], '/test_mailer', [Traffic::class, 'test_mailer'])->name('test_mailer');
Route::match(['get', 'post'], '/verifyMFA', [Traffic::class, 'verifyMFA'])->name('verifyMFA');
Route::match(['get', 'post'], '/send_mfa', [Traffic::class, 'send_mfa'])->name('send_mfa'); 
Route::match(['get', 'post'], '/goto_Dashboard', [Traffic::class, 'goto_Dashboard'])->name('Dashboard');
Route::match(['get', 'post'], '/gotoFaceRecognizer', [Traffic::class, 'gotoFaceRecognizer'])->name('faceRecognizer');
Route::match(['get', 'post'], '/faceRecognize', [Traffic::class, 'faceRecognize'])->name('faceRecognize');
Route::match(['get', 'post'], '/directLogin', [Traffic::class, 'directLogin'])->name('directLogin');

Route::match(['get', 'post'], '/tester', [Traffic::class, 'tester'])->name('tester');

Route::get('/traffic', [Traffic::class, 'index'])
    ->name('traffic');

Route::post('/traffic/start', [Traffic::class, 'start'])
    ->name('traffic.start');

Route::get('/progress', [Traffic::class, 'progress'])
    ->name('progress');

Route::get('/server-error', function () { return view('server-error');});
Route::get('/test-internet', function () {return response()->json(['success' => 'Internet is working']);});
Route::post('/clear-session', function () { session()->flush(); return response()->noContent();});

// Protected Routes (Require Login)
Route::middleware('isAuthenticated')->group(function () {
  // Route::group(['middleware' => 'auth'], function () {
  Route::match(['get', 'post'], '/dashboard', [Traffic::class, 'showDashboard'])->name('Dashboard');
  Route::match(['get', 'post'], '/dash_cust', [Traffic::class, 'gotoDashboardCustomization'])->name('dash_cust'); 
  Route::match(['get', 'post'], '/new_announcement', [Traffic::class, 'shoNewAnnouncement'])->name('new_announcement');
  Route::match(['get', 'post'], '/announcement_details', [Traffic::class, 'AnnouncementDetails'])->name('announcement_details');
  Route::match(['get', 'post'], '/get_recipients', [Traffic::class, 'getRecipients'])->name('get_recipients');
  Route::match(['get', 'post'], '/dtr', [Traffic::class, 'show_dtr'])->name('dtr');
  Route::match(['get', 'post'], '/emp_bio_logs', [Traffic::class, 'show_emp_bio_logs'])->name('emp_bio_logs');
  Route::match(['get', 'post'], '/schedule', [Traffic::class, 'show_schedule'])->name('schedule');
  Route::match(['get', 'post'], '/dtr_logs', [Traffic::class, 'show_dtr_logs'])->name('dtr_logs'); 
  Route::match(['get', 'post'], '/load_announce', [Traffic::class, 'LoadAnnounce'])->name('load_announce');
  Route::match(['get', 'post'], '/leave_bal', [Traffic::class, 'ShowLeaveBal'])->name('leave_bal');
  Route::match(['get', 'post'], '/empSchedule', [Traffic::class, 'empSchedule'])->name('empSchedule');
  Route::match(['get', 'post'], '/assets/{param}', [Traffic::class, 'show_assets'])->name('assets'); 
  Route::match(['get', 'post'], '/testphp', [Traffic::class, 'testPHP'])->name(name: 'testphp');

 
 
 
  

  // routes for user password manager

  //Search
  Route::match(['get', 'post'], '/web_helper/{param}', [Traffic::class, 'show_helper'])->name('web_helper');
  Route::match(['get', 'post'], '/no_result_fround/{str}', [Traffic::class, 'show_no_result_fround'])->name('no_result_fround');
  Route::match(['get', 'post'], '/search/{param}', [Traffic::class, 'ShowSearchPage'])->name('search');

  //Approval Views
  Route::match(['get', 'post'], '/overtime_approval', [Traffic::class, 'showOvertimeApproval'])->name('overtime_approval');
  Route::match(['get', 'post'], '/offset_approval', [Traffic::class, 'showOffSetApproval'])->name('offset_approval');
  Route::match(['get', 'post'], '/leave_approval', [Traffic::class, 'LeaveSetApproval'])->name('leave_approval');
  Route::match(['get', 'post'], '/time_adjust_approval', [Traffic::class, 'TimeAdjustmentSetApproval'])->name('time_adjust_approval');
  Route::match(['get', 'post'], '/ob_approval', [Traffic::class, 'OBSetApproval'])->name('ob_approval');
  Route::match(['get', 'post'], '/hrd_approval', [Traffic::class, 'HRDApproval'])->name('hrd_approval');
  Route::match(['get', 'post'], '/ajax_php', [Traffic::class, 'show_ajax_php'])->name('ajax_php');


  Route::match(['get', 'post'], '/overtimeExt_approval', [Traffic::class, 'overtimeExt_approval'])->name('overtimeExt_approval');
  

  //sub pages
  Route::match(['get', 'post'], '/test_show_reg', [Traffic::class, 'show_test_show_reg'])->name('test_show_reg');
  Route::match(['get', 'post'], '/stored_proc/{spName}/{spParams}', [Traffic::class, 'exec_this_stored_proc'])->name('stored_proc');


  //AJAX VALIDATIONS
  Route::match(['get', 'post'], '/call_ajax', [Traffic::class, 'validate_request'])->name('call_ajax');
  //Route::match(['get', 'post'], '/test_mailer', [Traffic::class, 'test_mailer'])->name('test_mailer');
  Route::match(['get', 'post'], '/kiosk_values', [Traffic::class, 'kiosk_values'])->name('kiosk_values');

  //NOTIFICATIONS
  Route::match(['get', 'post'], '/get_for_approvals', [Traffic::class, 'get_count_for_approvals'])->name('get_for_approvals');
 

  //FILTERS
  Route::match(['get', 'post'], '/filter_request', [Traffic::class, 'submit_filter_request'])->name('filter_request');
  Route::match(['get', 'post'], '/filter_requestRequester', [Traffic::class, 'submit_filter_request2'])->name('filter_requestRequester');
  Route::match(['get', 'post'], '/emp_ytd', [Traffic::class, 'show_emp_ytd'])->name('emp_ytd');
  Route::match(['get', 'post'], '/dtr_view_process', [DashboardController::class, 'show_dtr_view'])->name('dtr_view_process');
  Route::match(['get', 'post'], '/view_loan', [Traffic::class, 'show_loans'])->name('view_loan');
  


//Applications - OVERTIME
//Route::match(['get', 'post'],'/sp_get_users/{data}', [Traffic::class, 'show_sp_get_users'])->name('sp_get_users');
  Route::match(['get', 'post'], '/sp_get_users', [Traffic::class, 'show_sp_get_users'])->name('sp_get_users');
  Route::match(['get', 'post'], '/open_form', [Traffic::class, 'show_overtime_form'])->name('open_form');
  Route::match(['get', 'post'], '/ot_detail', [Traffic::class, 'show_ot_request_detail'])->name('ot_detail');
  Route::match(['get', 'post'], '/overtime_application', [Traffic::class, 'overtime_application'])->name('overtime_application');

//Applications - OVERTIME EXTENSION ALLOWANCE
  Route::match(['get', 'post'], '/openExt_form', [Traffic::class, 'show_overtimeExt_form'])->name('openExt_form');
  Route::match(['get', 'post'], '/overtimeExt_application', [Traffic::class, 'overtimeExt_application'])->name('overtimeExt_application');
  Route::match(['get', 'post'], '/overtimeExtMapping', [Traffic::class, 'overtimeExtMapping'])->name('overtimeExtMapping');


  //CALENDARS
Route::match(['get', 'post'], '/calendar_sched', [Traffic::class, 'show_calendar_sched'])->name('calendar_sched');
Route::match(['get', 'post'], '/tester', [Traffic::class, 'show_tester'])->name('tester');
  

  //Applications - LEAVE
  Route::match(['get', 'post'], '/leave_application', [Traffic::class, 'leave_application'])->name('leave_application');
  Route::match(['get', 'post'], '/open_leave_form', [Traffic::class, 'show_leave_form'])->name('open_leave_form');
  Route::match(['get', 'post'], '/leave_detail', [Traffic::class, 'show_leave_request_detail'])->name('leave_detail');

//TIME ENTRY

Route::match(['get', 'post'], '/te_application', [Traffic::class, 'show_Time_Entry'])->name('te_application');
Route::match(['get', 'post'], '/te_detail', [Traffic::class, 'show_Time_Entry_Details'])->name('te_detail');
Route::match(['get', 'post'], '/time_entry_form', [Traffic::class, 'show_Time_Entry_Form'])->name('time_entry_form');
Route::match(['get', 'post'], '/timeentry_approval', [Traffic::class, 'show_Time_Entry_approval'])->name('timeentry_approval');

  //TIME ADJUSTMENT 
  Route::match(['get', 'post'], '/time_adj_application', [Traffic::class, 'time_adj_application'])->name('time_adj_application');
  Route::match(['get', 'post'], '/time_adjustment_form', [Traffic::class, 'show_time_adjustment_form'])->name('time_adjustment_form');
  Route::match(['get', 'post'], '/ta_detail', [Traffic::class, 'show_ta_request_detail'])->name('ta_detail');


  //OB APPLICATION 
  Route::match(['get', 'post'], '/ob_application', [Traffic::class, 'ob_application'])->name('ob_application');
  Route::match(['get', 'post'], '/ob_app_form', [Traffic::class, 'show_ob_app_form'])->name('ob_app_form');
  Route::match(['get', 'post'], '/ob_days_location', [Traffic::class, 'show_ob_days_location'])->name('ob_days_location');
  Route::match(['get', 'post'], '/ob_detail', [Traffic::class, 'show_ob_request_detail'])->name('ob_detail');

  //SCHEDULE
  Route::match(['get', 'post'], '/change_sched', [Traffic::class, 'show_change_sched'])->name('change_sched');
  Route::match(['get', 'post'], '/sc_approval', [Traffic::class, 'show_sc_approval'])->name('sc_approval');
  Route::match(['get', 'post'], '/sc_detail', [Traffic::class, 'show_sc_request_detail'])->name('sc_detail');
  Route::match(['get', 'post'], '/sc_application', [Traffic::class, 'show_sc_application'])->name('sc_application');
  Route::match(['get', 'post'], '/sc_pending', [Traffic::class, 'show_sc_pending'])->name('sc_pending');
  

  //OFFSET APPLICATION
  Route::match(['get', 'post'], '/offset_application', [Traffic::class, 'offset_application'])->name('offset_application');
  Route::match(['get', 'post'], '/offset_form', [Traffic::class, 'show_offset_form'])->name('offset_form');
  Route::match(['get', 'post'], '/offset_ref_list', [Traffic::class, 'show_offset_ref_list'])->name('offset_ref_list');
  Route::match(['get', 'post'], '/os_detail', [Traffic::class, 'show_os_request_detail'])->name('ot_os_detaildetail');

 //HRD CERTIFICATE APPLICATION
 Route::match(['get', 'post'], '/hrd_application', [Traffic::class, 'hrd_application'])->name('hrd_application');
 Route::match(['get', 'post'], '/hrd_application_dtls', [Traffic::class, 'hrd_application_dtls'])->name('hrd_application_dtls'); 
  

  //Applications - OTHERS
  Route::match(['get', 'post'], '/app_form_application', [Traffic::class, 'app_form_application'])->name('app_form_application');
  Route::match(['get', 'post'], '/auth_deduct_application', [Traffic::class, 'auth_deduct_application'])->name('auth_deduct_application');
  Route::match(['get', 'post'], '/dynamic_delete', [Traffic::class, 'dynamic_delete'])->name('dynamic_delete');
  Route::match(['get', 'post'], '/hist_details_form', [Traffic::class, 'show_hist_details_form'])->name('hist_details_form');
  Route::match(['get', 'post'], '/wizard', [Traffic::class, 'show_wizard'])->name('wizard');

  //Audit Trails
  Route::match(['get', 'post'], '/addAuditTrails', [Traffic::class, 'addAuditTrails'])->name('addAuditTrails');

  //HRIS Approval
  Route::match(['get', 'post'], '/hris_approval_personalinformation', [Traffic::class, 'show_hris_approval_personalinformation'])->name('hris_approval_personalinformation');
  Route::match(['get', 'post'], '/hris_approval_personalinformation_view', [Traffic::class, 'hris_approval_personalinformation_view'])->name('hris_approval_personalinformation_view');
  Route::match(['get', 'post'], '/hris_approval_personalinformation_submit', [Traffic::class, 'submit_hris_approval_personalinformation'])->name('hris_approval_personalinformation_submit');
  Route::match(['get', 'post'], '/hris_approval_personalinformation_bulk_submit', [Traffic::class, 'submit_hris_approval_personalinformation_bulk'])->name('hris_approval_personalinformation_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_dependent', [Traffic::class, 'show_hris_approval_dependent'])->name('hris_approval_dependent');
  Route::match(['get', 'post'], '/hris_approval_dependent_view', [Traffic::class, 'hris_approval_dependent_view'])->name('hris_approval_dependent_view');
  Route::match(['get', 'post'], '/hris_approval_dependent_submit', [Traffic::class, 'submit_hris_approval_depedent'])->name('hris_approval_dependent_submit');
  Route::match(['get', 'post'], '/hris_approval_dependent_bulk_submit', [Traffic::class, 'submit_hris_approval_dependent_bulk'])->name('hris_approval_dependent_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_contacts', [Traffic::class, 'show_hris_approval_contacts'])->name('hris_approval_contacts');
  Route::match(['get', 'post'], '/hris_approval_contacts_view', [Traffic::class, 'hris_approval_contacts_view'])->name('hris_approval_contacts_view');
  Route::match(['get', 'post'], '/hris_approval_contacts_submit', [Traffic::class, 'submit_hris_approval_contacts'])->name('hris_approval_contacts_submit');
  Route::match(['get', 'post'], '/hris_approval_contacts_bulk_submit', [Traffic::class, 'submit_hris_approval_contacts_bulk'])->name('hris_approval_contacts_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_education', [Traffic::class, 'show_hris_approval_education'])->name('hris_approval_education');
  Route::match(['get', 'post'], '/hris_approval_education_view', [Traffic::class, 'hris_approval_education_view'])->name('hris_approval_education_view');
  Route::match(['get', 'post'], '/hris_approval_education_submit', [Traffic::class, 'submit_hris_approval_education'])->name('hris_approval_education_submit');
  Route::match(['get', 'post'], '/hris_approval_education_bulk_submit', [Traffic::class, 'submit_hris_approval_education_bulk'])->name('hris_approval_education_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_employmenthistory', [Traffic::class, 'show_hris_approval_employmenthistory'])->name('hris_approval_employmenthistory');
  Route::match(['get', 'post'], '/hris_approval_employmenthistory_view', [Traffic::class, 'hris_approval_employmenthistory_view'])->name('hris_approval_employmenthistory_view');
  Route::match(['get', 'post'], '/hris_approval_employmenthistory_submit', [Traffic::class, 'submit_hris_approval_employmenthistory'])->name('hris_approval_employmenthistory_submit');
  Route::match(['get', 'post'], '/hris_approval_employmenthistory_bulk_submit', [Traffic::class, 'submit_hris_approval_employmenthistory_bulk'])->name('hris_approval_employmenthistory_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_leavecredit', [Traffic::class, 'show_hris_approval_leavecredit'])->name('hris_approval_leavecredit');
  Route::match(['get', 'post'], '/hris_approval_leavecredit_view', [Traffic::class, 'hris_approval_leavecredit_view'])->name('hris_approval_leavecredit_view');
  Route::match(['get', 'post'], '/hris_approval_leavecredit_submit', [Traffic::class, 'submit_hris_approval_leavecredit'])->name('hris_approval_leavecredit_submit');
  Route::match(['get', 'post'], '/hris_approval_leavecredit_bulk_submit', [Traffic::class, 'submit_hris_approval_leavecredit_bulk'])->name('hris_approval_leavecredit_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_earnings', [Traffic::class, 'show_hris_approval_earnings'])->name('hris_approval_earnings');
  Route::match(['get', 'post'], '/hris_approval_earnings_view', [Traffic::class, 'hris_approval_earnings_view'])->name('hris_approval_earnings_view');
  Route::match(['get', 'post'], '/hris_approval_earnings_submit', [Traffic::class, 'submit_hris_approval_earnings'])->name('hris_approval_earnings_submit');
  Route::match(['get', 'post'], '/hris_approval_earnings_bulk_submit', [Traffic::class, 'submit_hris_approval_earnings_bulk'])->name('hris_approval_earnings_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_deductions', [Traffic::class, 'show_hris_approval_deductions'])->name('hris_approval_deductions');
  Route::match(['get', 'post'], '/hris_approval_deductions_view', [Traffic::class, 'hris_approval_deductions_view'])->name('hris_approval_deductions_view');
  Route::match(['get', 'post'], '/hris_approval_deductions_submit', [Traffic::class, 'submit_hris_approval_deductions'])->name('hris_approval_deductions_submit');
  Route::match(['get', 'post'], '/hris_approval_deductions_bulk_submit', [Traffic::class, 'submit_hris_approval_deductions_bulk'])->name('hris_approval_deductions_bulk_submit');

  Route::match(['get', 'post'], '/hris_approval_bankaccounts', [Traffic::class, 'show_hris_approval_bankaccounts'])->name('hris_approval_bankaccounts');
  Route::match(['get', 'post'], '/hris_approval_bankaccounts_view', [Traffic::class, 'hris_approval_bankaccounts_view'])->name('hris_approval_bankaccounts_view');
  Route::match(['get', 'post'], '/hris_approval_bankaccounts_submit', [Traffic::class, 'submit_hris_approval_bankaccounts'])->name('hris_approval_bankaccounts_submit');  
  Route::match(['get', 'post'], '/hris_approval_bankaccounts_bulk_submit', [Traffic::class, 'submit_hris_approval_bankaccounts_bulk'])->name('hris_approval_bankaccounts_bulk_submit');  

  Route::match(['get', 'post'], '/hris_approval_accountability', [Traffic::class, 'show_hris_approval_accountability'])->name('hris_approval_accountability');
  Route::match(['get', 'post'], '/hris_approval_accountability_view', [Traffic::class, 'hris_approval_accountability_view'])->name('hris_approval_accountability_view');
  Route::match(['get', 'post'], '/hris_approval_accountability_submit', [Traffic::class, 'submit_hris_approval_accountability'])->name('hris_approval_accountability_submit');
  Route::match(['get', 'post'], '/hris_approval_accountability_bulk_submit', [Traffic::class, 'submit_hris_approval_accountability_bulk'])->name('hris_approval_accountability_bulk_submit');
  
  Route::match(['get', 'post'], '/hris_approval_medicalrecords', [Traffic::class, 'show_hris_approval_medicalrecords'])->name('hris_approval_medicalrecords');
  Route::match(['get', 'post'], '/hris_approval_medicalrecords_view', [Traffic::class, 'hris_approval_medicalrecords_view'])->name('hris_approval_medicalrecords_view');
  Route::match(['get', 'post'], '/hris_approval_medicalrecords_submit', [Traffic::class, 'submit_hris_approval_medicalrecords'])->name('hris_approval_medicalrecords_submit');  
  Route::match(['get', 'post'], '/hris_approval_medicalrecords_bulk_submit', [Traffic::class, 'submit_hris_approval_medicalrecords_bulk'])->name('hris_approval_medicalrecords_bulk_submit');  

  Route::match(['get', 'post'], '/hris_approval_seminarattended', [Traffic::class, 'show_hris_approval_seminarattended'])->name('hris_approval_seminarattended');
  Route::match(['get', 'post'], '/hris_approval_seminarattended_view', [Traffic::class, 'hris_approval_seminarattended_view'])->name('hris_approval_seminarattended_view');
  Route::match(['get', 'post'], '/hris_approval_seminarattended_submit', [Traffic::class, 'submit_hris_approval_seminarattended'])->name('hris_approval_seminarattended_submit');  
  Route::match(['get', 'post'], '/hris_approval_seminarattended_bulk_submit', [Traffic::class, 'submit_hris_approval_seminarattended_bulk'])->name('hris_approval_seminarattended_bulk_submit');  

  Route::match(['get', 'post'], '/hris_approval_biometricsinfo', [Traffic::class, 'show_hris_approval_biometricsinfo'])->name('hris_approval_biometricsinfo');
  Route::match(['get', 'post'], '/hris_approval_biometricsinfo_view', [Traffic::class, 'hris_approval_biometricsinfo_view'])->name('hris_approval_biometricsinfo_view');
  Route::match(['get', 'post'], '/hris_approval_biometricsinfo_submit', [Traffic::class, 'submit_hris_approval_biometricsinfo'])->name('hris_approval_biometricsinfo_submit');
  Route::match(['get', 'post'], '/hris_approval_biometricsinfo_bulk_submit', [Traffic::class, 'submit_hris_approval_biometricsinfo_bulk'])->name('hris_approval_biometricsinfo_bulk_submit');
  
  Route::match(['get', 'post'], '/hris_approval_employeemovement', [Traffic::class, 'show_hris_approval_employeemovement'])->name('hris_approval_employeemovement');
  Route::match(['get', 'post'], '/hris_approval_employeemovement_view', [Traffic::class, 'hris_approval_employeemovement_view'])->name('hris_approval_employeemovement_view');
  Route::match(['get', 'post'], '/hris_approval_employeemovement_submit', [Traffic::class, 'submit_hris_approval_employeemovement'])->name('hris_approval_employeemovement_submit');
  Route::match(['get', 'post'], '/hris_approval_employeemovement_bulk_submit', [Traffic::class, 'submit_hris_approval_employeemovement_bulk'])->name('hris_approval_employeemovement_bulk_submit');

  //CLEARANCE - ray 11/11/2025
  Route::match(['get', 'post'], '/clearance', [Traffic::class, 'show_clearance_form'])->name('clearance');
  Route::match(['get', 'post'], '/clearance_approval', [Traffic::class, 'show_clearance_approval'])->name('clearance_approval');
  Route::match(['get', 'post'], '/clearance_approval_details', [Traffic::class, 'show_clearance_approval_details'])->name('clearance_approval_details');
  Route::match(['get', 'post'], '/update_clearance_approval_details', [Traffic::class, 'update_clearance_approval_details'])->name('update_clearance_approval_details');
  Route::match(['get', 'post'], '/clearance_approval_hr', [Traffic::class, 'show_clearance_approval_hr'])->name('clearance_approval_hr');
  Route::match(['get', 'post'], '/clearance_hr_view', [Traffic::class, 'show_clearance_hr_view'])->name('clearance_hr_view');
  Route::match(['get', 'post'], '/clearance_acknowledge', [Traffic::class, 'clearance_acknowledge'])->name('clearance_acknowledge');

  //Authority to Deduct
  Route::match(['get', 'post'], '/authority_to_deduct', [Traffic::class, 'show_authority_to_deduct'])->name('authority_to_deduct');
  Route::match(['get', 'post'], '/open_atd_details', [Traffic::class, 'show_authority_to_deduct_details'])->name('open_atd_details');
  Route::match(['get', 'post'], '/update_atd_decline', [Traffic::class, 'update_authority_to_deduct_decline'])->name('update_atd_decline');
  Route::match(['get', 'post'], '/update_atd_acknowledge', [Traffic::class, 'update_authority_to_deduct_acknowledge'])->name('update_atd_acknowledge');
  Route::match(['get', 'post'], '/add_employee_deduction', [Traffic::class, 'add_employee_deduction'])->name('add_employee_deduction');
  
  //My Profile Details
  Route::match(['get', 'post'], '/my_profile_details', [Traffic::class, 'show_myProfile_Details'])->name('my_profile_details');
  Route::match(['get', 'post'], '/my_profile_details_edit', [Traffic::class, 'edit_myProfile_Details'])->name('my_profile_details_edit');
  Route::match(['get', 'post'], '/my_profile_details_contact_edit', [Traffic::class, 'edit_myProfile_contact'])->name('my_profile_details_contact_edit');
  Route::match(['get', 'post'], '/my_profile_details_education_edit', [Traffic::class, 'edit_myProfile_education'])->name('my_profile_details_education_edit');
  Route::match(['get', 'post'], '/my_profile_details_employment_edit', [Traffic::class, 'edit_myProfile_employment'])->name('my_profile_details_employment_edit');
  Route::match(['get', 'post'], '/my_profile_details_training_edit', [Traffic::class, 'edit_myProfile_training'])->name('my_profile_details_training_edit');
  Route::match(['get', 'post'], '/my_profile_details_hmmo_dependent_edit', [Traffic::class, 'edit_myProfile_hmo_dependent'])->name('my_profile_details_hmmo_dependent_edit');

  Route::match(['get', 'post'], '/my_profile_payroll', [Traffic::class, 'myProfilePayroll'])->name('my_profile_payroll');

  //Appraisal Form
  Route::match(['get', 'post'], '/appraisal_form_view_supervisor', [Traffic::class, 'show_appraisal_form_supervisor'])->name('appraisal_form_view_supervisor');
  Route::match(['get', 'post'], '/appraisal_supervisor_approver', [Traffic::class, 'show_appraisal_supervisor_approval'])->name('appraisal_supervisor_approver');
  Route::match(['get', 'post'], '/appraisal_form_application_list', [Traffic::class, 'show_appraisal_application_list'])->name('appraisal_form_application_list');

  Route::match(['get', 'post'], '/appraisal_form_approval', [Traffic::class, 'show_appraisal_form_approval'])->name('appraisal_form_approval');
  Route::match(['get', 'post'], '/appraisal_form_approval_details', [Traffic::class, 'appraisal_form_approval_details'])->name('appraisal_form_approval_details');
  Route::match(['get', 'post'], '/appraisal_form_approval_submit', [Traffic::class, 'appraisal_form_approval_submit'])->name('appraisal_form_approval_submit');

  //reports routes
  Route::match(['get', 'post'], '/payslip_record', [Traffic::class, 'payslip_record'])->name('payslip_record');
  Route::match(['get', 'post'], '/th_month_apy', [Traffic::class, 'th_month_apy'])->name('th_month_apy');
  Route::match(['get', 'post'], '/twenty_report', [Traffic::class, 'twenty_report'])->name('twenty_report');
  Route::match(['get', 'post'], '/bir_form_2316', [Traffic::class, 'bir_form_2316'])->name('bir_form_2316');
  Route::match(['get', 'post'], '/open_report', [Traffic::class, 'OpenReport'])->name('open_report');
  Route::match(['get', 'post'], '/view_report_data', [Traffic::class, 'view_report_data'])->name('view_report_data'); 
  Route::get('/open_lms', [Traffic::class, 'open_lms'])->name('open_lms'); 
  Route::get('/open_rbp', [Traffic::class, 'open_rbp'])->name('open_rbp');



  Route::match(['get', 'post'], '/payslip_report/{id}', [Traffic::class, 'show_payslip_report'])->name('payslip_report');

  //Proccess
  Route::match(['get', 'post'], '/generate-captcha', [Traffic::class, 'generate_captcha'])->name('generate_captcha');

  Route::match(['get', 'post'], '/logout', [Traffic::class, 'logout'])->name('logout');


  //modal
  Route::match(['get', 'post'], '/enter_pass', [Traffic::class, 'reenter_password'])->name('enter_pass');
  Route::match(['get', 'post'], '/attachedFilesAssets', [Traffic::class, 'attachedFilesAssets'])->name('attachedFilesAssets');
  //Route::get('/show-modal', [Traffic::class, 'show'])->name('modal.show');
  Route::match(['get', 'post'], '/modal.show/{param}', [Traffic::class, 'show'])->name('modal.show');

  Route::match(['get', 'post'], '/change_password', [Traffic::class, 'change_password'])->name('change_password');

});
// require __DIR__ . 