<?php

namespace App\Http\Controllers; 
use App\Models\HRISApprovalModel;
use App\Models\MyProfileModel;
use App\Models\AuthorityToDeductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Authentication;
use App\Models\CompanyPassword;
use Illuminate\Support\Facades\Session;
use App\Models\OvertimeModel;
use App\Models\Report_PaysilpModel;
use App\Models\store_proc_model;
use App\Models\LeaveModel;
use App\Models\TimeAdjustmentModel;
use App\Models\OfficialBusinessModel;
use App\Models\OffsetModel;
use App\Models\EmplyeeYtdModel;
use App\Models\DashboardModel;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\PasswordModel;
use App\Models\ThMonthPayModel;
use App\Models\TimeEntryModel;
use App\Models\CalendaModel;
use App\Models\hrdCertModel;   
//use App\Http\Controllers\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\PFMail;
use Illuminate\Support\Facades\File; 
use App\Models\ClearanceModel;
use Jenssegers\Agent\Agent;
use App\Helpers\NetworkHelper;
use Illuminate\Support\Facades\Http;

class Traffic extends Controller
{

    protected $authentication;
    protected $company_password;
    protected $overtime_model;
    protected $report_paysilp_model;
    protected $th_month_pay_model;
    protected $store_proc_model;
    protected $leave_model;
    protected $tim_adjustment_model;
    protected $ob_application_model;
    protected $offset_model;
    protected $employee_ytd_model;
    protected $dashboard_model;
    protected $password_model; 
    protected $time_entry_model; 
    protected $calendar_model; 
    protected $hrd_certificate;   
    protected $clearance_model;
    protected $authority_to_deduct_model;
    protected $customization_model; 
    
    protected $my_profile_model;
    protected $HRIS_Approval_model;


    //constructor method to initialize the models
    public function __construct()
    {
        
        $this->authentication = new Authentication();
        $this->company_password = new CompanyPassword();
        $this->overtime_model = new OvertimeModel();
        $this->report_paysilp_model = new Report_PaysilpModel();
        $this->store_proc_model = new store_proc_model();
        $this->leave_model = new LeaveModel();
        $this->tim_adjustment_model = new TimeAdjustmentModel();
        $this->ob_application_model = new OfficialBusinessModel();
        $this->offset_model = new OffsetModel();
        $this->employee_ytd_model = new EmplyeeYtdModel();
        $this->dashboard_model = new DashboardModel();
        $this->password_model = new PasswordModel(); 
        $this->th_month_pay_model = new ThMonthPayModel(); 
        $this->time_entry_model = new TimeEntryModel(); 
        $this->calendar_model = new CalendaModel(); 
        $this->hrd_certificate = new hrdCertModel();   
        $this->clearance_model = new ClearanceModel();          
        $this->authority_to_deduct_model = new AuthorityToDeductModel();          
        $this->my_profile_model = new MyProfileModel();          
        $this->HRIS_Approval_model = new HRISApprovalModel();        
    } 

    public function show($param)
    {
        session()->put('modal', 'true');
        $param = json_decode($param, true);
        return view('layouts.partials.modal', ['param' => $param]);
    }

    //Enter Pasword
    public function reenter_password()
    {
        return view('layouts.tabs.Reports.password');
    }

    //SEARCH

    public function show_helper($param)
    {
        $data['result'] = $param;
        return view('layouts.helps', $data);
    }

    public function ShowSearchPage($param)
    {
        $data['result'] = $param;
        return view('layouts.partials.SearchResult', $data);
    }

    public function show_help_overtime()
    {
        return view('layouts.helps.help_overtime');
    }

    public function show_help_dashboard()
    {
        return view('layouts.helps.dashboard');
    }

    public function show_help_payslip_record()
    {
        return view('layouts.helps.payslip_record');
    }


    public function show_help_thry_month_pay()
    {
        return view('layouts.helps.thry_month_pay');
    }


    public function show_help_twenty3_report()
    {
        return view('layouts.helps.twenty3_report');
    }
    
    public function show_dtr(){
        $identityId = session()->get('identityId');
        $data['dropdown_fill'] = $this->authentication->sp_dropdown_fill([6, 0]);  
        //$data['list'] = $this->authentication->sp_application_info([1,0,0,$identityId,'F','1991-01-01','']);
        $num = 0;
        foreach ($data['dropdown_fill']['rows'] as $rows) {
            $enc_id = $rows->val; 
            $data['dropdown_fill']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId); 
            $num++;
        }

        return view('layouts.partials.dashboard.add_dtr',$data);
    }
    

    public function show_assets($param){ 
       // return view('layouts.partials.dashboard.emp_bio_logs',$data);
       //return "Asset ID: " . $param;
       return fullcalendar($param);
    }

    public function show_emp_bio_logs(){
        $identityId = session()->get('identityId'); 
        $df = $_POST['df'];
        $dt = $_POST['dt']; 
        $data['biolist']=$this->dashboard_model->sp_employee_bio_logs([0,$identityId,$df,$dt]); 
        return view('layouts.partials.dashboard.emp_bio_logs',$data);
    }

    public function show_sc_pending(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $id = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
         
        $data['sched_details']=$this->authentication->sp_application_info([0,6,$id,0,'P','1991-01-01','']);
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['schedules'] = $this->calendar_model->sp_load_schedules([0, 'Shifting']);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$id,'schedulechange','']);  
        return view('layouts.tabs.request.request_form.schedule_pending',$data); 

    }
    
    public function show_change_sched(){
        $identityId = session()->get('identityId');
        $id = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $status  = $_POST['status'];
        $data['sched_details']=$this->calendar_model->sp_load_sched_day([0,$identityId,$id,$status]); 
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['schedules'] = $this->calendar_model->sp_load_schedules([0, 'Shifting']);
        $data['access_rights'] = session()->get('access_rights');
 
        if(empty($data['sched_details']['rows'])){

            $note = "<center>
                            <i class='fa-solid fa-triangle-exclamation' style='font-size:40px; color:orange'></i>
                            <p>Schedule Change for this schedule type is not available</p>
                      </center>";
            return $note;
        } 
        $data['appNo'] = $data['sched_details']['rows'][0]->AppNo; //$this->authentication->f_endecrypt('0', 'e', $identityId);
        //echo $id; 
        return view('layouts.tabs.request.request_form.schedule',$data);

    }

    public function show_schedule(){ 

        if ($_POST['num']==1){

            $identityId = session()->get('identityId'); 
            $events = $this->calendar_model->load_sched_advanced(0,$identityId,'',''); 
            session()->put('currentEvents',$events); 
        }
 
        $data=[];
        return view('layouts.partials.dashboard.schedule',$data);
    }

    public function shoNewAnnouncement()
    {  
        return view('layouts.partials.dashboard.announcement');
    }

    public function getRecipients()
    {  
        $dep = $_POST['dep'];
        $data['departments'] = $this->authentication->sp_dropdown_fill([5, 0]);
        $data['users'] = $this->authentication->sp_get_user_per_department([0,$dep]);
        $data['dep'] = $dep;
        $data['SelectedID'] = $_POST['SelectedID'];
        return view('layouts.partials.dashboard.announcement_rec',$data);
    }
    

    public function AnnouncementDetails()
    {  
        $identityId = session()->get('identityId'); 
        $num = $_GET['num'];
        $data['num'] = $num;
        $data['content'] = $this->authentication->sp_portal_announcement([1,$num,"","","","",$identityId]);
        return view('layouts.partials.dashboard.announcement_details',$data);
         
    }


    public function show_help_bir_form()
    {
        return view('layouts.helps.bir_form');
    }

    public function show_help_reports()
    {
        return view('layouts.helps.reports');
    }

    public function show_help_offset()
    {
        return view('layouts.helps.offset');
    }

    public function show_help_leave()
    {
        return view('layouts.helps.leave');
    }

    public function show_help_time_adjustment()
    {
        return view('layouts.helps.time_adjustment');
    }

    public function show_help_off_bus()
    {
        return view('layouts.helps.off_bus');
    }

    public function show_help_appr_form()
    {
        return view('layouts.helps.appr_form');
    }

    public function show_help_auth_deduct()
    {
        return view('layouts.helps.auth_deduct');
    }

    public function show_help_clrnce_from()
    {
        return view('layouts.helps.clrnce_from');
    }

    public function show_help_system_access()
    {
        return view('layouts.helps.system_access');
    }

    public function show_no_result_fround($str)
    {
        $data['str'] = $str;
        return view('layouts.partials.no_result_fround', $data);
    }


    public function changePass(){ 
        $start  = microtime(true);
        if (empty(session()->get('database'))){
            session()->put('database', $_POST['db']); 
        } 

        $data['hostName'] = env('DB_OWNER');
        
        DB::purge('mysql');
        config(['database.connections.mysql.database' =>session()->get('database')]);
        DB::reconnect('mysql');

        //if (session()->get('companyPasswordSettings') == null){ 
            $companyPasswordSettings = $this->company_password->get_company_password_details();
            $companyPasswordSettings['password'] = $this->authentication->f_endecrypt($companyPasswordSettings['password'], 'd', 'ftsi');
            session()->put('companyPasswordSettings', value: $companyPasswordSettings); 
       //}
        
       
        $pint_mode=$_POST['num'];
        $email="";
        $OTP="";
        $pass1="";
        $pass2="";
        $userPassword="";
 

        if($pint_mode==1){ 
            $this->authentication->sp_userAuditTrails(1,'Forgot Password','Info','',$start);  
            session()->put('email',""); 
        }

        if($pint_mode==2){
            $email=$_POST['email'];
            session()->put('email',$email); 
        }

        if($pint_mode==3){
            $OTP=$_POST['otp'];
        }

        if($pint_mode==4){
            $pass1=$_POST['pass1'];
            session()->put('pass1',$pass1); 
        }

        if($pint_mode==5){
            $pass1=session()->get('pass1');
            $pass2=$_POST['pass2'];
        }

        if (!empty(session()->get('identityId'))){ 
            $identityId=session()->get('identityId');  
            $userPassword=$this->authentication->f_endecrypt(session()->get('pass1'), 'e', $identityId); 
        }

        $data['num'] = $pint_mode;
        $data['result'] = $this->password_model->sp_portal_forgot_password_validation([$pint_mode,session()->get('email'),$OTP,$pass1,$pass2,$userPassword]);
        $data['errNum'] = $data['result']['num'];
        $data['errMsg'] = $data['result']['msg'];
        $data['RefNo'] = "";
 
        if ($pint_mode>=2){ // verification success 
            $stage = "Password Verification"; 
            $status =  ($data['errNum']==1) ? "Warning" : "Success"; 
            $msg = ($data['errNum']==0) ? "" : $data['errMsg'];
            if($pint_mode==2){ $stage="Forgot Password -> Email Verification";  }
            if($pint_mode==3){ $stage="Forgot Password -> OTP Verification";  }
            if($pint_mode==4){ $stage="Forgot Password -> Passord Verification";  }  
            $this->authentication->sp_userAuditTrails(1,$stage,$status,$data['errMsg'],$start);  
        }
 
        if (!empty(session()->get('RefNo'))){ 
            $data['RefNo'] = session()->get('RefNo');
        } 

        if ($pint_mode==2 && $data['errNum']==0){
           
           $fullname = $data['errMsg'];
           $NewOTP = $this->authentication->generateOTP(6); 
           session()->put('RefNo',$NewOTP['RefNo']); 
           $data['RefNo'] = $NewOTP['RefNo'];
           $data['email'] = $email;

           $Newemail['subject']="Pay Factor OTP"; 
           $Newemail['sendTo']=$email; 
           $Newemail['CcTo']=[]; 
           $Newemail['header']=["Dear ".$fullname]; 
           $Newemail['content']=["Please use this OTP <b><u>".$NewOTP['OTP']."</u></b> for changes password verefication. 
                                </br> Reference No.".$NewOTP['RefNo']."</br>
                                </br>Please don't share this</br>
                                "]; 
           $Newemail['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
           
           $IsEmailSuccess = $this->authentication->sendEmail(new Request($Newemail));   
           
           if ($IsEmailSuccess==0){
                $msg =  "Sending Email Failed. please contact administrator </br></br>   <center> <a href='/'>Back to login</a></center></br></br>";
                echo $msg;
                $this->authentication->sp_userAuditTrails(1,'Forgot Password -> Send Email','Failed',$msg,$start); 
                return;
           }else{
            $this->authentication->sp_userAuditTrails(1,'Forgot Password -> Send Email','Success','Reference#:'.session()->get('RefNo'),$start); 
            $this->authentication->sp_portal_otp([0,session()->get('email'),session()->get('RefNo'),$NewOTP['OTP']]); 
           }

         
        } 
        
        if ($pint_mode==4 && $data['errNum']==0){
            session()->put('identityId',$data['errMsg']); 
        }

        return view('layouts.tabs.forgot_password',$data);
    }


    public function show_tester(){ 
        return view('layouts.embed.captcha');
    } 


    public function tester(){
       
            return response()->stream(function () {

            for ($i = 1; $i <= 5; $i++) {

                echo json_encode([
                    'isUpdate' => true,
                    'id'       => 'test',
                    'msg'      => 'Message ' . $i . ' - ' . date('H:i:s')
                ]) . "\n";

                if (ob_get_level() > 0) {
                    ob_flush();
                }

                flush();

                sleep(2);
            }

        }, 200, [
            'Content-Type'      => 'application/x-ndjson; charset=utf-8',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'X-Accel-Buffering' => 'no',
        ]);

    }
 
                  
     public function start(){
        Cache::put('traffic_progress', 0, now()->addHour());

        $total = 4;

        for ($i = 1; $i <= $total; $i++) {

            $stage = $i;
            $status = 'Processing';

            $data = [
                'errMsg' => ''
            ];

            $start = microtime(true);

            $this->authentication->sp_userAuditTrails(
                1,
                $stage,
                $status,
                $data['errMsg'],
                $start
            );

            // Wait 3 seconds
            sleep(1);

            // Update progress
            $progress = round(($i / $total) * 100);

            Cache::put(
                'traffic_progress',
                $progress,
                now()->addHour()
            );
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function progress(){
        return response()->json([
            'progress' => Cache::get('traffic_progress', 0)
        ]);
    }
 /*        
    public function start(){
        Cache::put('traffic_progress', 0, now()->addHour());

        $total = 4;

        for ($i = 1; $i <= $total; $i++) {

            $stage = $i;
            $status = 'Processing';

            $data = [
                'errMsg' => ''
            ];

            $start = microtime(true);

            $this->authentication->sp_userAuditTrails(
                1,
                $stage,
                $status,
                $data['errMsg'],
                $start
            );

            // Wait 3 seconds
            sleep(1);

            // Update progress
            $progress = round(($i / $total) * 100);

            Cache::put(
                'traffic_progress',
                $progress,
                now()->addHour()
            );
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function progress(){
        return response()->json([
            'progress' => Cache::get('traffic_progress', 0)
        ]);
    }
 */

    public function testPHP(){ 
         
         /*    $stage = 0;
            $status = 'Processing';

            $data = [
                'errMsg' => ''
            ];

            $start = microtime(true);

           $audit = $this->authentication->sp_userAuditTrails(
                1,
                $stage,
                $status,
                $data['errMsg'],
                $start
            );

            return $audit;
 */
        // test mailer 
        /* $email['subject']="Testing only Time Entry";
        $currentUrl = session()->get('currentUrl');
            
        $email['sendTo']="onnix2559@gmail.com";
        $email['CcTo']=[]; 
        $email['header']=["Hi Ma'am/Sir"]; 
        $email['content']=["<b>Time Entry"]; 
        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

        $emailResult = $this->authentication->sendEmail(new Request($email)); 
        echo json_encode($emailResult);
        return; */


        return view('layouts.embed.test');
    } 

    public function compensationAndBenefits(){

        $data['test'] = 123; 
        return view('layouts.cnb.index',$data);
    }

    

    //CALENDAR
    public function show_calendar_sched(){
 
        $yearSched = session()->get('yearSched');
        $identityId=session()->get('identityId');  
        
        $start = isset($_GET['start']) ? $_GET['start'] : null;
        $end = isset($_GET['end']) ? $_GET['end'] : null;
        $switch = isset($_GET['switch']) ? $_GET['switch'] : 0;
        
        $start = date('Y-m-d', $start);
        $endDate = date('Y-m-d', $end);


       /*  $year =  date('Y', $start);
        $minYear = ($yearSched-3); */
 
        if (session()->get('currentEvents') === null) { 
            $events = $this->calendar_model->load_sched_advanced(0,$identityId,'',''); 
            session()->put('currentEvents',$events);
        }

        $events = session()->get('currentEvents');
        $num = 0;
        foreach ($events['rows'] as $rows) {
            $enc_id = $rows->appNo; 
            $events['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId); 
            $num++;
        } 

        $filtered = array_filter($events['rows'], fn($row) => 
            $row->switch == $switch &&
            $row->appDateFrom >= $start &&
            $row->appDateFrom <= $endDate
        );
        
 
        $data_events = array();
        foreach($filtered as $r) {  
            $data_events[] = array(
				"title" => $r->appDoc." ".$r->appStatus,
				"end" => $r->appDateFrom,
				"start" => $r->appDateFrom,
				"color" => $r->appColor,
				"url" => "javascript:showDetails('".json_encode(["appNo" => $r->appNo, "ID" => $switch, "enc_id" => $r->enc_id, "appDoc" => $r->appDoc, "appStatus" => $r->appStatus])."');",  
			); 
		}    
 

		echo json_encode(array("events" => $data_events));
        exit();  
    } 

    public function getSecretKey(){
        return "aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d";
    }

 
    public function deleteDevice(Request $request){ 
        $id = $request->input('id'); 
        $path = public_path('storage/devicelist.json'); 
        if (!file_exists($path)) {
            return false;
        }
 
        $devices = json_decode(file_get_contents($path), true); 
        $devices = array_filter($devices, function ($device) use ($id) {
            return $device['ip'] !== $id;
        }); 
        $devices = array_values($devices); 
        file_put_contents($path, json_encode($devices, JSON_PRETTY_PRINT)); 
        return redirect()->route('devicelist'); 
    }

    public function devicelist(){

        $path = public_path('storage/devicelist.json'); 
        $content = json_decode(File::get($path)); 
        
        if(count($content)==0){
            echo "No device found!";
        }
        else {
            $items = "";

            foreach ($content as $device) {
                $items .= "<tr>
                                <td>" . htmlspecialchars($device->id) . "</td>
                                <td>" . htmlspecialchars($device->ip) . "</td>
                                <td>" . htmlspecialchars($device->device) . "</td>
                                <td>" . htmlspecialchars($device->browser) . "</td>
                                <td>" . htmlspecialchars($device->host) . "</td>
                                <td><button id=".htmlspecialchars($device->id)." onclick=\"window.location.href='/kiosk/deleteDevice?id=".htmlspecialchars($device->ip)."'\">Remove</button></td>
                        </tr>";
            } 
                echo "
                <table border='1'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User IP</th>
                            <th>Device</th>
                            <th>Browser</th>
                            <th>Host</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>".$items."</tbody>
                </table>
                ";

        }
         
    }

    public function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Can contain multiple IPs (client, proxy1, proxy2)
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }


    public function saveSystemErrors() { 

        if (isset($_POST['errorLogs'])) { 
            $path = public_path('storage/errorlogs.json'); 

            // Load existing logs
            $data = File::exists($path)
                ? json_decode(File::get($path), true)
                : [];

            // Decode incoming logs
            $incoming = json_decode($_POST['errorLogs'], true);

            if (!$incoming) {
                return "Invalid JSON data";
            }

            // Get last logId
            $lastId = !empty($data) ? max(array_column($data, 'logId')) : 0;

            // If MULTIPLE logs
            if (isset($incoming[0])) {
                foreach ($incoming as $log) {
                    $lastId++;
                    $log['logId'] = $lastId;
                    $data[] = $log;
                }
            } 
            // If SINGLE log
            else {
                $incoming['logId'] = $lastId + 1;
                $data[] = $incoming;
            }

            // Save clean array
            File::put($path, json_encode(array_values($data), JSON_PRETTY_PRINT));

            return "Error details successfully saved!";
        }
    }

    public function saveSystemErrorList()  {
         $path = public_path('storage/errorlogs.json'); 
         $content = json_decode(File::get($path)); 
         if (count($content)==0){
            echo "No error logs here!";
         }else{

                $items = "";

                foreach ($content as $logs) {
                    $items .= "<tr>
                                    <td>" . htmlspecialchars($logs->logId) . "</td>
                                    <td>" . htmlspecialchars($logs->identityId) . "</td>
                                    <td>" . htmlspecialchars(json_encode($logs->formData)) . "</td>
                                    <td>" . htmlspecialchars($logs->time) . "</td>
                                    <td>" .htmlspecialchars((strlen($logs->errorMsg)>200) ? substr($logs->errorMsg, 0, 200)." ....." : $logs->errorMsg) . "</td> 
                            </tr>";
                } 
                    echo "
                    <table border='1'>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Username</th> 
                                <th>Request</th>
                                <th>Time</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody>".$items."</tbody>
                    </table>
                    ";
         }
    }

    public function testChangeawdwadzzzz(){
        echo 123;
    }


    public function showLoginForm(Request $request){    
        $data['version'] = config('version.version'); 
        if(session()->get('is_authenticated')){    return redirect()->route('dash_cust');   }  
        //$data['databases'] = $this->authentication->get_database();  
        $data['databases'] = $this->authentication->sp_get_company_settings_name_by_db([0,env('DB_OWNER')])['rows'];  
        $data['mode'] = "login"; 
        //echo json_encode($data['databases']);
        return view('layouts.login', $data); 
    }

     

    public function showDashboard(){
         
        $data['companyName'] = Session::get('companyName');
        $data['fullname'] = Session::get('fullname'); 
        $identityId = session()->get('identityId');

        //for approval count notif
        $overtime_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(0, $identityId);
        $leave_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(1, $identityId);
        $timeadjustment_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(2, $identityId);
        $officialbusiness_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(3, $identityId);
        $offset_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(4, $identityId); 
        $timeentry_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(5, $identityId);
        $schedulechange_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(6, $identityId);
        $hrdCert_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(7, $identityId);
        
 
        //Pending request count notif
        $overtime_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(0, $identityId);
        $leave_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(1, $identityId);
        $timeadjustment_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(2, $identityId);
        $officialbusiness_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(3, $identityId);
        $offset_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(4, $identityId);
        $timeentry_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(5, $identityId);
        $schedulechange_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(6, $identityId);
        $hrdCert_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(7, $identityId);
        

        $data['leaveBalance'] = $this->dashboard_model->sp_get_current_leave_balances('0', $identityId);
        $data['posted_dtr_dates'] = $this->dashboard_model->sp_portal_get_posted_dtr_dates($identityId);
        
        //CHARTS
        $data['overtimeChart'] = $this->dashboard_model->sp_portal_get_all_approvals('0', $identityId);
        $data['leaveChart'] = $this->dashboard_model->sp_portal_get_all_approvals('1', $identityId);
        $data['timeAdjustmentChart'] = $this->dashboard_model->sp_portal_get_all_approvals('2', $identityId);
        $data['obChart'] = $this->dashboard_model->sp_portal_get_all_approvals('3', $identityId);
        $data['offsetChart'] = $this->dashboard_model->sp_portal_get_all_approvals('4', $identityId); 


        $data['approvalCount'] = $this->dashboard_model->sp_portal_get_all_approvals_count('1', $identityId);
  
        $data['approvals'] = [

            ['title' => 'Overtime / Under Time', 'count' => $overtime_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-clock', 'link' => route('overtime_approval')],
            ['title' => 'Leave', 'count' => $leave_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-calendar2-x', 'link' => route('leave_approval')],
            ['title' => 'Offset', 'count' => $offset_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-file-check', 'link' => route('offset_approval')],
            ['title' => 'Time Adjustment', 'count' => $timeadjustment_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-clock-history', 'link' => route('time_adjust_approval')],
            ['title' => 'Official Business', 'count' => $officialbusiness_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-buildings-fill', 'link' => route('ob_approval')],
            ['title' => 'Time Entry', 'count' => $timeentry_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-business-time', 'link' => route('ob_approval')],
            ['title' => 'Schedule Change', 'count' => $schedulechange_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-calendar-days', 'link' => route('ob_approval')],
            ['title' => 'HRD Certificate', 'count' => $hrdCert_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-certificate', 'link' => route('hrd_approval')],
            
        ];
        
        $data['applications'] = [
            ['title' => 'Overtime / Under Time', 'count' => $overtime_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-clock', 'link' => route('overtime_application')],
            ['title' => 'Leave', 'count' => $leave_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-calendar2-x', 'link' => route('leave_application')],
            ['title' => 'Offset', 'count' => $offset_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-file-check', 'link' => route('offset_application')],
            ['title' => 'Time Adjustment', 'count' => $timeadjustment_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-clock-history', 'link' => route('time_adj_application')],
            ['title' => 'Official Business', 'count' => $officialbusiness_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-buildings-fill', 'link' => route('ob_application')],
            ['title' => 'Time Entry', 'count' => $timeentry_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-business-time', 'link' => route('ob_application')],
            ['title' => 'Schedule Change', 'count' => $schedulechange_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-calendar-days', 'link' => route('ob_application')],
            ['title' => 'HRD Certificate', 'count' => $hrdCert_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-calendar-days', 'link' => route('hrd_application')],
            ];

        
        $data['emp_ytd_tax_years'] = $this->employee_ytd_model->sp_emp_ytd_tax_years([0]);
 
        $data['announcement'] = $this->authentication->sp_portal_announcement([1,0,"","","",$identityId,""]);

 
        return view('layouts.partials.dashboard', $data);
    }

    public function gotoDashboardCustomization(){ 

     

        $data['mode'] = session()->get('dash_edit_mode'); 
        $data['companyName'] = "Company Name";
        $data['fullname'] = "You fullname"; 
        $identityId = session()->get('identityId');
        $database = session()->get('database'); 
        
        $overtime_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(0, $identityId);
        $leave_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(1, $identityId);
        $timeadjustment_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(2, $identityId);
        $officialbusiness_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(3, $identityId);
        $offset_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(4, $identityId); 
        $timeentry_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(5, $identityId);
        $schedulechange_forApproval = $this->dashboard_model->sp_for_approval_get_all_count(6, $identityId);
        $hrdCert_forApproval =  $this->dashboard_model->sp_for_approval_get_all_count(7, $identityId);
        
 
        $overtime_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(0, $identityId);
        $leave_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(1, $identityId);
        $timeadjustment_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(2, $identityId);
        $officialbusiness_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(3, $identityId);
        $offset_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(4, $identityId);
        $timeentry_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(5, $identityId);
        $schedulechange_pending_request = $this->dashboard_model->sp_portal_get_all_pending_applications(6, $identityId);
        $hrdCert_pending_request =  $this->dashboard_model->sp_portal_get_all_pending_applications(7, $identityId); 

        $data['leaveBalance'] = $this->dashboard_model->sp_get_current_leave_balances('0', $identityId);
        $data['posted_dtr_dates'] = $this->dashboard_model->sp_portal_get_posted_dtr_dates($identityId);
        $data['lms_license'] = $this->dashboard_model->sp_get_lms_license([0,$database]);
        $data['rbp_license'] = $this->dashboard_model->sp_get_rbp_license([0,$database]);
           
 
        //CHARTS 
        $data['overtimeChart'] = $this->dashboard_model->sp_portal_get_all_approvals('0', $identityId);
        $data['leaveChart'] = $this->dashboard_model->sp_portal_get_all_approvals('1', $identityId);
        $data['timeAdjustmentChart'] = $this->dashboard_model->sp_portal_get_all_approvals('2', $identityId);
        $data['obChart'] = $this->dashboard_model->sp_portal_get_all_approvals('3', $identityId);
        $data['offsetChart'] = $this->dashboard_model->sp_portal_get_all_approvals('4', $identityId); 
        $data['timeentryChart'] = $this->dashboard_model->sp_portal_get_all_approvals('5', $identityId); 
        $data['ScheduleChangeChart'] = $this->dashboard_model->sp_portal_get_all_approvals('6', $identityId); 
        $data['HRDCertificateChart'] = $this->dashboard_model->sp_portal_get_all_approvals('7', $identityId); 
        
        $data['approvalCount'] = $this->dashboard_model->sp_portal_get_all_approvals_count('1', $identityId); 
  
        $data['approvals'] = [

            ['title' => 'Overtime / Under Time', 'count' => $overtime_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-clock', 'link' => route('overtime_approval')],
            ['title' => 'Leave', 'count' => $leave_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-calendar2-x', 'link' => route('leave_approval')],
            ['title' => 'Offset', 'count' => $offset_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-file-check', 'link' => route('offset_approval')],
            ['title' => 'Time Adjustment', 'count' => $timeadjustment_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-clock-history', 'link' => route('time_adjust_approval')],
            ['title' => 'Official Business', 'count' => $officialbusiness_forApproval, 'color' => 'bg-custom', 'icon' => 'bi-buildings-fill', 'link' => route('ob_approval')],
            ['title' => 'Time Entry', 'count' => $timeentry_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-business-time', 'link' => route('timeentry_approval')],
            ['title' => 'Schedule Change', 'count' => $schedulechange_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-calendar-days', 'link' => route('sc_approval')],
            ['title' => 'HRD Certificate', 'count' => $hrdCert_forApproval, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-certificate', 'link' => route('hrd_approval')],
            
        ];
        
        $data['applications'] = [
            ['title' => 'Overtime / Under Time', 'count' => $overtime_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-clock', 'link' => route('overtime_application')],
            ['title' => 'Leave', 'count' => $leave_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-calendar2-x', 'link' => route('leave_application')],
            ['title' => 'Offset', 'count' => $offset_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-file-check', 'link' => route('offset_application')],
            ['title' => 'Time Adjustment', 'count' => $timeadjustment_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-clock-history', 'link' => route('time_adj_application')],
            ['title' => 'Official Business', 'count' => $officialbusiness_pending_request, 'color' => 'bg-custom', 'icon' => 'bi-buildings-fill', 'link' => route('ob_application')],
            ['title' => 'Time Entry', 'count' => $timeentry_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-business-time', 'link' => route('te_application')],
            ['title' => 'Schedule Change', 'count' => $schedulechange_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-calendar-days', 'link' => route('sc_application')],
            ['title' => 'HRD Certificate', 'count' => $hrdCert_pending_request, 'color' => 'bg-custom', 'icon' => 'fa-solid fa-certificate', 'link' => route('hrd_application')],
            ];

         
        $data['user_dashboard'] =  $this->dashboard_model->sp_user_dashboard_settings([0,$identityId,"[]"]); 
        $data['emp_ytd_tax_years'] = $this->employee_ytd_model->sp_emp_ytd_tax_years([0]);
        $data['employeeloans'] = $this->dashboard_model->sp_loan_overview([0,$identityId,'','']);
        $data['company_customization'] = $this->authentication->sp_kiosk_costumization([0,$database]); 
        $data['database'] = $database;

        return view('layouts.partials.dashboard.dashboardCust', $data);
    }

    public function campanyLogo(){
        return response()->file(public_path('images/logo.jpg'));
    }

   
    	public function get_leaveapplication_approver($id, $laAppNo){
		
		$database = $_SESSION['database'];
		$this->db->db_select($database);
		$count = 0;
		
		$query = "
		
		SELECT 

		leaveapplicationform.*,
		lv.*,
		approval.templateCode,
		approval.templateLineId,
		pp.payrollPeriodApproverLocked,
		approval.decision

		FROM (
		"; foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT * FROM ".$db['name'].".approvaltemplateoriginator
					UNION ALL ";
			}else{
				$query .= "SELECT * FROM ".$db['name'].".approvaltemplateoriginator";
			}
		}
		$count = 0;
		$query .= ") approvaltemplateoriginator

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT * FROM ".$db['name'].".approval
				UNION ALL ";
			}else{
				$query .= "SELECT * FROM ".$db['name'].".approval";
			}
		}
		$count = 0;
		$query .= ") approval ON
		approvaltemplateoriginator.id = approval.id

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "	SELECT * FROM ".$db['name'].".approvaltemplatestages
				UNION ALL ";
			}else{
				$query .= "	SELECT * FROM ".$db['name'].".approvaltemplatestages ";
			}
		}
		$count = 0;
		$query .= ") approvaltemplatestages ON
		approvaltemplatestages.code = approval.templateCode AND
		approvaltemplatestages.lineId = approval.templateLineId AND
		approvaltemplateoriginator.code = approvaltemplatestages.code

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "	SELECT * FROM ".$db['name'].".approvalstages
				UNION ALL ";
			}else{
				$query .= "	SELECT * FROM ".$db['name'].".approvalstages ";
			}
		}
		$count = 0;
		$query .= ") approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT * FROM ".$db['name'].".approvalstagedetails
				UNION ALL ";
			}else{
				$query .= "SELECT * FROM ".$db['name'].".approvalstagedetails ";
			}
		}
		$count = 0;
		$query .= ") approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT * FROM ".$db['name'].".leaveapplicationform
				UNION ALL ";
			}else{
				$query .= "SELECT * FROM ".$db['name'].".leaveapplicationform ";
			}
		}
		$count = 0;
		$query .= ") leaveapplicationform ON
		leaveapplicationform.laAppNo = approval.appNo

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT identityId, batchId FROM ".$db['name'].".identity
				UNION ALL ";
			}else{
				$query .= "SELECT identityId, batchId FROM ".$db['name'].".identity ";
			}
		}
		$count = 0;
		$query .= ") identity ON
		approval.id = identity.identityId

		LEFT JOIN (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT * FROM ".$db['name'].".`leave`
				UNION ALL ";
			}else{
				$query .= "SELECT * FROM ".$db['name'].".`leave` ";
			}
		}
		$count = 0;
		$query .= ") lv ON
		lv.leaveCode = leaveapplicationform.laType

		LEFT JOIN

		( SELECT 
		identity.identityId,
		payrollperioddetails.payrollPeriodApproverLocked,
		payrollperioddetails.payrollPeriodFrom,
		payrollperioddetails.payrollPeriodTo

		FROM (";
		foreach($_SESSION["databases"] as $db){
			$count += 1;
			if($count != count($_SESSION["databases"])){
				$query .= "SELECT identityId, batchId FROM ".$db['name'].".identity
				UNION ALL ";
			}else{
				$query .= "SELECT identityId, batchId FROM ".$db['name'].".identity ";
			}
		}
		$count = 0;
		$query .= ") identity 

		LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode

		LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

		LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
		WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
		WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

		LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code ) pp ON pp.identityId = approval.id

		WHERE 

		approval.document = 'leave' AND
		approvalstagedetails.id = '".$id."' AND approval.decision = 'F' AND
		leaveapplicationform.laAppNo = '".$laAppNo."'

		GROUP BY leaveapplicationform.laAppNo
		
		";
		
		$isolation = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;";
		$commit = "COMMIT;";
		//$result1 = $this->db->query($isolation);
		$result = $this->db->query($query);
		//$result2 = $this->db->query($commit);
		return $result->row_array(); 
	}

    public function show_dtr_logs(){
        $identityId = session()->get('identityId');

        $this->dashboard_model->sp_portal_process_dtr_logs('0', $identityId);
        $data['dtrLogs'] = $this->dashboard_model->sp_portal_get_dtr_logs('1', $identityId);

        return view('layouts.partials.dashboard.dtr_logs', $data);
    }


    public function show_emp_ytd(){
        $identityId = session()->get('identityId');
        $year = $_POST['year'];
        $data['year'] = $year;
        $data['emp_ytd_details'] = $this->employee_ytd_model->sp_emp_ytd_get_details([0, $identityId, $year]);
        $data['emp_ytd_summary'] = $this->employee_ytd_model->sp_emp_ytd_get_summary([0, $identityId, $year]);
 
        return view('layouts.partials.emp_ytd', $data);
    }

    public function LoadAnnounce(){
        $identityId = session()->get('identityId');
        //$data['announcement'] = $this->authentication->sp_portal_announcement([1,0,"","","",$identityId,""]);
        $data['announcement'] = $this->authentication->sp_portal_announcement([1,0,0,0,0,0,$identityId]); 
        return view('layouts.partials.dashboard.announcement_list',$data);
    }

    public function show_loans(){   
         
         $identityId = session()->get('identityId');  
         $df = $_POST['df']; 
         $dt = $_POST['dt']; 
         $data['loans'] = $this->dashboard_model->sp_loan_overview([0,$identityId, $df,$dt]);  
         return view('layouts.partials.dashboard.employeeLoans',$data);


    }

    public function ShowLeaveBal(){
        $identityId = session()->get('identityId');
        $data['leaveBalance'] = $this->dashboard_model->sp_get_current_leave_balances('0', $identityId);
        return view('layouts.partials.dashboard.leaveBal',$data);
    }

    public function empSchedule(){
        $identityId = session()->get('identityId'); 

        $start = $_POST['startDate'];
        $endDate = $_POST['endDate']; 
        $data['startDate']=$start;
        $data['endDate']=$endDate; 

        $data['schedules'] = $this->dashboard_model->sp_get_employee_schedules(['0', $identityId,$start,$endDate]);
        return view('layouts.partials.dashboard.empSched',$data);
    }

    


    //////////////////////////approvals////////////////////////

    public function exec_this_stored_proc($spName, $spParams){
        $result = $this->store_proc_model->exec_store_proc($spName, $spParams);
        return $result;
    }

    public function show_test_show_reg(){
        return view('layouts.tabs.forApproval.sub_pages.register');
    }

    public function show_ajax_php()
    {
        return view('layouts.tabs.forApproval.ajaxphp');
    }

    public function show_sc_approval(){ 
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $data['list'] = $this->authentication->sp_application_info([1,6,0,$identityId,'F','1991-01-01','']);
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->scAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $num++;
        }
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = [];
        return view('layouts.tabs.forApproval.schedule',$data);
    }

    public function show_sc_application(){
        $this->DisconnectDB(); 
        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->scheduleChange!==1){
                return view('layouts.partials.unauthorized');
            }
           }
        
        $identityId = session()->get('identityId');
        $data['pending_list'] = $this->authentication->sp_application_info([0,6,0,$identityId,'P','','']); 
        $data['request_history'] = []; 
        
        $num=0;
        foreach ($data['pending_list']['rows'] as $rows) {
            $enc_id = $rows->scAppNo; 
            $data['pending_list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId); 
            $num++;
        } 
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        return view('layouts.tabs.request.schedule',$data);
    }

    public function showOvertimeApproval(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $data['list'] = $this->authentication->sp_application_info([1,0,0,$identityId,'F','1991-01-01','']);
        
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->otAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $num++;
        }
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);

        return view('layouts.tabs.forApproval.overtime', $data);
    }


    public function overtimeExt_approval(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $data['list'] = $this->authentication->sp_application_info([1,1000,0,$identityId,'F','1991-01-01','']);
        
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->otAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $num++;
        }
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]); 
        return view('layouts.tabs.forApproval.overtimeExt', $data); 
    }

    public function show_ot_request_detail() { 
        $identityId = session()->get('identityId'); 
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId); 
        $mode = $_POST['mode'] ?? 0;
        $data['details'] =$this->authentication->sp_application_info([0,$mode,$data['id'],$identityId,'F','1991-01-01','']);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'overtime','']); 
        return view('layouts.tabs.forApproval.detailed_form.overtime', $data);
    }
 
    public function showOffSetApproval(){ 
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $data['list'] =$this->authentication->sp_application_info([1,4,0,$identityId,'F','1991-01-01','']); 
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->osAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $num++;
        }


        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = $this->authentication->sp_request_get_history([4, $identityId, 0, 0, '', '', '']);

        return view('layouts.tabs.forApproval.offset', $data);
    }

    public function show_os_request_detail() {  
        $identityId = session()->get('identityId');
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['details'] = $this->authentication->sp_application_info([0,4,$data['id'],0,'F','1991-01-01','']); 
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'offset','']); 
        return view('layouts.tabs.forApproval.detailed_form.offset', $data);
    }

    public function LeaveSetApproval(){  
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');
        $data['list'] = $this->authentication->sp_application_info([1,1,0,$identityId,'F','1991-01-01','']);  
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->laAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $num++;
        }    
        $data['request_history'] = $this->authentication->sp_request_get_history([1, $identityId, 0, 0, '', '', '']);
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);

        return view('layouts.tabs.forApproval.leave', $data);
    }
 
    public function show_Time_Entry_Details(){
        $identityId = session()->get('identityId'); 
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['details'] =  $this->authentication->sp_application_info([0,5,$data['id'],$identityId,'F','','']);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'timeentry','']); 
        return view('layouts.tabs.forApproval.detailed_form.time_entry', $data);
    }

    public function show_Time_Entry_approval(){ 
       /*  $this->DisconnectDB(); 
        $identityId = session()->get('identityId'); 
        $data['list'] =  $this->authentication->sp_application_info([1,5,0,$identityId,'F','','']);
        return view('layouts.tabs.forApproval.time_entry', $data); */

        $this->DisconnectDB(); 
        $identityId = session()->get('identityId'); 
        $data['list'] =$this->authentication->sp_application_info([1,5, 0, $identityId ,'F','1991-01-01','']); 
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->teAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $num++;
        }


        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = [];  
        return view('layouts.tabs.forApproval.time_entry', $data);
         
    }

    public function show_leave_request_detail()
    {  
        $identityId = session()->get('identityId'); 
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['details'] =  $this->authentication->sp_application_info([0,1, $data['id'],0,'F','1991-01-01','']); 
        $data['sched_list'] = $this->leave_model->sp_leave_get_request_list([0, $data['id']]);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'leave','']);  
        return view('layouts.tabs.forApproval.detailed_form.leave', $data);
    }

    public function TimeAdjustmentSetApproval(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId'); 
        $data['list'] =$this->authentication->sp_application_info([1,2, 0, $identityId ,'F','1991-01-01','']); 
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->taAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $num++;
        }


        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = [];

        return view('layouts.tabs.forApproval.time_adjustment', $data);
    }

    public function show_sc_request_detail(){
       
        $identityId = session()->get('identityId');
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['details'] = $this->authentication->sp_application_info([0,6, $data['id'],0,'F','1991-01-01','']);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'schedulechange','']); 
        return view('layouts.tabs.forApproval.detailed_form.schedule', $data);
    }

    public function show_ta_request_detail(){
       
        $identityId = session()->get('identityId');
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['details'] = $this->authentication->sp_application_info([0,2, $data['id'],0,'F','1991-01-01','']);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'timeadjustment','']); 
        return view('layouts.tabs.forApproval.detailed_form.time_adjustment', $data);
    }

    public function OBSetApproval(){ 
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId'); 
        $data['list'] = $this->authentication->sp_application_info([1,3, 0,$identityId,'F','1991-01-01','']);  
        $num = 0;
        foreach ($data['list']['rows'] as $rows) {
            $enc_id = $rows->obAppNo;
            $enc_pay = $rows->approverLocked;
            $data['list']['rows'][$num]->enc_pay = $this->authentication->f_endecrypt($enc_pay, 'e', $identityId);
            $data['list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId);
            $num++;
        }

        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = $this->authentication->sp_request_get_history([3, $identityId, 0, 0, '', '', '']);

        return view('layouts.tabs.forApproval.ob', $data);
    }

    public function show_ob_request_detail(){
 
        $identityId = session()->get('identityId');
        $data['id'] = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
        $data['enc_pay'] = $this->authentication->f_endecrypt($_POST['enc_pay'], 'd', $identityId);
        $data['officialbusinesslist'] = $this->ob_application_model->sp_ob_application_get_officialbusinesslist([0, $data['id']]);
        $data['details'] = $this->authentication->sp_application_info([0,3, $data['id'] ,0,'F','1991-01-01','']); 
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$data['id'],'officialbusiness','']);
        return view('layouts.tabs.forApproval.detailed_form.ob', $data);


    }

    public function show_wizard(){
        $identityId = session()->get('identityId'); 
        $switch = $_POST['switch'];
        $appNo = $_POST['appNo']; 
        $data['wizard'] = $this->authentication->sp_get_approval([0,$switch,$appNo]);
        return view('layouts.tabs.request.request_form.wizard',$data);
    }

    public function submit_filter_request(){

        $identityId = session()->get('identityId');
        $pint_mode = $_POST['pint_mode'];
        $id = $_POST['id'];
        $df = $_POST['df'];
        $dt = $_POST['dt'];
        $status = $_POST['status'];

        $data['id'] = $id;

        //echo "<script>alert('".json_encode( $data['id'])."')</script>";
        //$data['request_history'] = $this->authentication->sp_request_get_history([$id, $identityId, 0, 0, $df, $dt, $status]);
        $data['request_history'] =$this->authentication->sp_application_info([$pint_mode,$id,0,$identityId,$status,$df,$dt]);
       
        $data['num'] = $this->authentication->f_endecrypt("2", 'e', $identityId); 
        $appNo = ["otAppNo", "laAppNo", "taAppNo", "obAppNo", "osAppNo","teAppNo","scAppNo","appNo"];
        $ency_hist_appNo = $this->authentication->f_encrypt_column_in_result($data['request_history']['rows'], 'rows', $appNo[$id], 'enc_id', 'e', $identityId);
        $data['request_history']['rows'] = $ency_hist_appNo;
        return view('layouts.tabs.forApproval.detailed_form.filter_result', $data); 
    }  

    public function submit_filter_request2() {

        $identityId = session()->get('identityId');
        $pint_mode = $_POST['pint_mode'];

        $switch = $_POST['id'];

        $id = ($_POST['id']==1000) ? 0 : $_POST['id']; 
        $df =  $_POST['df'];
        $dt = $_POST['dt'];
        $status = $_POST['status'];

 
        
        $data['id'] = $id;
        $data['switch'] = $switch;
        $data['request_history'] = $this->authentication->sp_application_info([$pint_mode,$switch,0,$identityId,$status,$df,$dt]);
         
        $appNo = ["otAppNo", "laAppNo", "taAppNo", "obAppNo", "osAppNo","teAppNo","scAppNo","appNo"];
        $ency_hist_appNo = $this->authentication->f_encrypt_column_in_result($data['request_history']['rows'], 'rows', $appNo[$id], 'enc_id', 'e', $identityId);
        $data['request_history']['rows'] = $ency_hist_appNo;  
        $data['num'] = $this->authentication->f_endecrypt("2", 'e', $identityId);  
        return view('layouts.tabs.forApproval.detailed_form.filter_result', $data); 
    }

 
    public function show_hist_details_form()  {
         
        $identityId = session()->get('identityId');

        $num = $_POST['num'];
        $id = $this->authentication->f_endecrypt($_POST['appNo'], 'd', $identityId);
        $data['num'] = $num;
 

        if ($num == 1) { //LEAVE  
            $data['holidays'] = $this->authentication->sp_get_holidaysholiday([0]);
            $data['sched_list'] = $this->leave_model->sp_leave_get_request_list([0, $id]); 
        }
        if ($num == 3) { //OFFICIAL BUSINESS 
            $data['days_sced'] = $this->ob_application_model->sp_ob_application_get_officialbusinesslist([0, $id]);

        }

        $data['app_details'] =  $this->authentication->sp_application_info([0,$num,$id,0,'F','','']);

        $app_type = ""; 
        if ($num == 0) { $app_type = "overtime";}
        if ($num == 1) { $app_type = "leave";}
        if ($num == 2) { $app_type = "timeadjustment";}
        if ($num == 3) { $app_type = "officialbusiness";}
        if ($num == 4) { $app_type = "offset";}
        if ($num == 5) { $app_type = "timeentry";}
        if ($num == 6) { $app_type = "schedulechange";}
 
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$id,$app_type,'']); 

        return view('layouts.tabs.hist_details', $data);
     
    }

    public function test_mailer(Request $request){
        if(empty($_GET['email'])){
            return "Email missing";
        }else{
            $data['email'] = $_GET['email'];


            session()->put('database', $_GET['database']);

            DB::purge('mysql');
            config(['database.connections.mysql.database' => $_GET['database']]);
            DB::reconnect('mysql');
            
            $companyPasswordSettings = $this->company_password->get_company_password_details();
            $companyPasswordSettings['password'] = $this->authentication->f_endecrypt($companyPasswordSettings['password'], 'd', 'ftsi');
             
            session()->put('companyPasswordSettings', value: $companyPasswordSettings);

             $this->authentication->app_mailer([$data]); 
        }
    }
 
     public function pf_structure(Request $request){
        if(empty($_GET['database'])){
            return "database missing";
        }
        session()->put('database', $_GET['database']);

        DB::purge('mysql');
        config(['database.connections.mysql.database' => $_GET['database']]);
        DB::reconnect('mysql');

        $companySettings = $this->company_password->get_company_password_details();
        $lms_license = $this->dashboard_model->sp_get_lms_license([0,$_GET['database']]);
        $rbp_license= $this->dashboard_model->sp_get_rbp_license([0,$_GET['database']]);

        /* echo json_encode($lms_license['num']);
        return; */
        
        $data['email'] = $companySettings['kioskEmail'];
        $data['lms_active'] = $lms_license['num'];
        $data['rbp_active'] = $rbp_license['num'];
        

        echo json_encode($data);
    }


    public function kiosk_values(Request $request){
        $companyPasswordSettings = session()->get('companyPasswordSettings'); 
        $data['email'] =$companyPasswordSettings['kioskEmail'];
        echo json_encode($data);
    }

    public function updateProgress($data)
    {
        echo json_encode($data) . "\n";

        if (ob_get_level() > 0) {
            ob_flush();
        }

        flush();
    }

    public function attachedFilesAssets(){
         $data['TEST'] = 1; 
         return view('layouts.tabs.request.request_form.attachsments', $data);
    }

    /*AJAX VALIDATIONS*/
    public function validate_request(){

        $identityId = session()->get('identityId');
        $mode = $_POST['mode']; 
        
        if ($mode == 1) {  /*submit overtime application*/
            $otAppNo = $_POST['otAppNo'];
            if ($otAppNo !== "0") {
                $otAppNo = $this->authentication->f_endecrypt($otAppNo, 'd', $identityId);
            }
            $empID = $identityId;
            $otReason = $_POST['Remarks'];
            $pint_mode = $_POST['pint_mode'];
            $ot_type = $_POST['ot_type'];
            $ot_location = $_POST['ot_location'];
            $ot_date = $_POST['ot_date'];
            $ot_from = $_POST['ot_from'];
            $ot_to = $_POST['ot_to'];
            $ot_tot_break = $_POST['ot_tot_break'];
            $ot_time_from = $_POST['ot_time_from'];
            $ot_time_to = $_POST['ot_time_to'];
            $time_tot = $_POST['time_tot'];
            $otExtAllowance = $_POST['otExtAllowance'];
            $otExtAllowanceDetals = $_POST['otExtAllowanceDetals'] ?? '';
            $r_attachedFiles = $_POST['r_attachedFiles'];
           
            $ot_list = $this->authentication->sp_dropdown_fill([0, 0]);
            $ot_valid = $this->authentication->if_val_is_valid($ot_list['rows'], 'val', $ot_type);

             
            $isNegative = substr($time_tot, 0, 1);
            if ($isNegative == "-") {
                return json_encode($this->authentication->return_error("lbl_appTotalTime", "Invalid OT Total Hours"));
            }


            if ($ot_valid == 0) {
                return json_encode($this->authentication->return_error("appOvertimeType", "Invalid [OT Type]"));
            }


            $loc_list = $this->authentication->get_locations([0]);
            $loc_valid = $this->authentication->if_val_is_valid($loc_list['rows'], 'locationCode', $ot_location);

            if ($loc_valid == 0) {
                return json_encode($this->authentication->return_error("appLocation", "Invalid [Location]"));
            }


            $spParams = [$pint_mode, $otAppNo, $empID, $otReason, $ot_type, $ot_location, $ot_date, $ot_from, $ot_to, $ot_tot_break, $ot_time_from, $ot_time_to, $time_tot,$otExtAllowance,$otExtAllowanceDetals,$r_attachedFiles];
            return $this->overtime_model->sp_overtime_submit_request($spParams, $pint_mode, $otAppNo);
        }

        if ($mode == 2) {  /*delete overtime application*/
            $otAppNo = $_POST['otAppNo'];
            if ($otAppNo !== "0") {
                $otAppNo = $this->authentication->f_endecrypt($otAppNo, 'd', $identityId);
            }
            $str = $this->overtime_model->sp_overtime_delete([0, $otAppNo]);
            return $str;
        }

        if ($mode == 3) {  /*submit leave application*/


            $id = $_POST['id'];
            if ($id !== "0") {
                $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
            }
            $pint_mode = $_POST['pint_mode'];
            $laType = $_POST['laType'];
            $laBalace = $_POST['laBalace'];
            $location = $_POST['location'];
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $reason = $_POST['reason'];
            $schedules = $_POST['schedules'];
            $r_attachedFiles = $_POST['r_attachedFiles'];


            $leave_list = $this->leave_model->sp_get_user_leave_type([0, $identityId]);
            $leave_valid = $this->authentication->if_val_is_valid($leave_list['rows'], 'leaveCode', $laType);

            if ($leave_valid == 0) {
                return json_encode($this->authentication->return_error("appOvertimeType", "Invalid [Leave Type]"));
            }

            $loc_list = $this->authentication->get_locations([0]);
            $loc_valid = $this->authentication->if_val_is_valid($loc_list['rows'], 'locationCode', $location);

            if ($loc_valid == 0) {
                return json_encode($this->authentication->return_error("appLocation", "Invalid [Location]"));
            }


            $ot_list = $this->authentication->sp_dropdown_fill([1, 0]);
            $data = json_decode($schedules, true);
            $vals = array_column($data, 'val');

            

            foreach ($vals as $val) {
                $val_is_valid = $this->authentication->if_val_is_valid($ot_list['rows'], 'val', $val);
                if ($val_is_valid == 0) {
                    return json_encode($this->authentication->return_error("la_to_date", "Process denied, Something Wrong in your application"));
                }
            }


            return $this->leave_model->sp_leave_submit_application([$pint_mode, $id, $identityId, $laType, $laBalace, $location, $from_date, $to_date, $reason, $schedules,$r_attachedFiles], $pint_mode, $id);

        }

        if ($mode == 4) {  /*check leave balances*/

            $val = $_POST['val'];
            return $this->authentication->sp_leave_get_balance([0, $identityId, $val]);
            /* $val = $_POST['val'];  
            $str=$this->authentication->sp_leave_get_balance([0,$id,$identityId,$val]);   
            echo "<script>alert(123)</script>";
            return $str; */
        }

        if ($mode == 5) {  /*cancel leave request*/
            $val = $_POST['leave_id'];
            $id = $this->authentication->f_endecrypt($val, 'd', $identityId);
            return $this->leave_model->sp_overtime_delete([0, $id]);
        }

        if ($mode == 6) {  /*submit time adjustment request*/
            //pint_mode,r_id,r_date,r_location,r_type,r_time,r_reason 

            $num = $_POST['pint_mode'];
            $r_id = $_POST['r_id'];

            if ($r_id !== "0") {
                $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
            }
            $r_date = $_POST['r_date'];
            $r_location = $_POST['r_location'];
            $r_type = $_POST['r_type'];
            $r_time = $_POST['r_time'];
            $r_reason = $_POST['r_reason'];



            $type_list = $this->authentication->sp_dropdown_fill([2, 0]);
            $type_valid = $this->authentication->if_val_is_valid($type_list['rows'], 'val', $r_type);
            if ($type_valid == 0) {
                return json_encode($this->authentication->return_error("ddl_type", "Invalid [Adjustment Type]"));
            }


            $loc_list = $this->authentication->get_locations([0]);
            $loc_valid = $this->authentication->if_val_is_valid($loc_list['rows'], 'locationCode', $r_location);

            if ($loc_valid == 0) {
                return json_encode($this->authentication->return_error("appLocation", "Invalid [Location]"));
            }

            return $this->tim_adjustment_model->sp_time_adj_get_submit_request([$num, $identityId, $r_id, $r_date, $r_location, $r_type, $r_time, $r_reason], $num, $r_id);
        }

        if ($mode == 7) {  /*cancel time adjustment request*/

            $r_id = $this->authentication->f_endecrypt($_POST['r_id'], 'd', $identityId);
            return $this->tim_adjustment_model->sp_time_adj_cancel_request([0, $r_id]);
        }

        if ($mode == 8) {  /*submit official business request*/

            $pint_mode = $_POST['pint_mode'];
            $r_id = $_POST['r_id'];
            $r_type = $_POST['r_type'];
            $r_reason = $_POST['r_reason'];

            $r_inout_date = $_POST['r_inout_date'];
            $r_inout_time = $_POST['r_inout_time'];
            $r_inout_location = $_POST['r_inout_location'];

            $r_days_df = $_POST['r_days_df'];
            $r_days_dt = $_POST['r_days_dt'];
            $json_schedules = $_POST['json_schedules'];
            $r_attachedFiles = $_POST['r_attachedFiles'];


            $type_list = $this->authentication->sp_dropdown_fill([3, 0]);
            $type_valid = $this->authentication->if_val_is_valid($type_list['rows'], 'val', $r_type);
            if ($type_valid == 0) {
                return json_encode($this->authentication->return_error("ob_ddl", "Invalid [OB Type]"));
            }


            if ($r_id !== "0") {
                $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
            }

            return $this->ob_application_model->sp_ob_application_submit_request([$pint_mode, $identityId, $r_id, $r_type, $r_reason, $r_inout_date, $r_inout_time, $r_inout_location, $r_days_df, $r_days_dt, $json_schedules,$r_attachedFiles], $pint_mode, $r_id);
        }

        if ($mode == 9) {  /*submit offset request*/

            $pint_mode = $_POST['pint_mode'];
            $r_id = $_POST['r_osAppNo'];
            $r_osTimeFrom = $_POST['r_osTimeFrom'];
            $r_osTimeTo = $_POST['r_osTimeTo'];
            $r_osDateFrom = $_POST['r_osDateFrom'];
            $r_osDateTo = $_POST['r_osDateTo'];
            $r_osReason = $_POST['r_osReason'];
            $r_Reference = $_POST['r_Reference'];
            $r_location = $_POST['r_location'];
            $r_attachedFiles = $_POST['r_attachedFiles'];

            if ($r_id !== "0") {
                $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
            }


            $loc_list = $this->authentication->get_locations([0]);
            $loc_valid = $this->authentication->if_val_is_valid($loc_list['rows'], 'locationCode', $r_location);

            if ($loc_valid == 0) {
                return json_encode($this->authentication->return_error("appLocation", "Invalid [Location]"));
            }


            return $this->offset_model->sp_offset_submit_request([$pint_mode, $r_id, $identityId, $r_osTimeFrom, $r_osTimeTo, $r_osDateFrom, $r_osDateTo, $r_osReason, $r_Reference, $r_location, $r_attachedFiles], $pint_mode, $r_id);
        }

        if ($mode == 10) {  /*For Approval Notifiations*/

           
            $ot_rows = $this->authentication->sp_application_info([1,0,0,$identityId,'F','1991-01-01','']);
            $leave_rows = $this->authentication->sp_application_info([1,1,0,$identityId,'F','1991-01-01','']);
            $ta_rows = $this->authentication->sp_application_info([1,2,0,$identityId,'F','1991-01-01','']);
            $ob_rows = $this->authentication->sp_application_info([1,3,0,$identityId,'F','1991-01-01','']);
            $os_rows = $this->authentication->sp_application_info([1,4,0,$identityId,'F','1991-01-01','']);
            $te_rows = $this->authentication->sp_application_info([1,5,0,$identityId,'F','1991-01-01','']);
            $sc_rows = $this->authentication->sp_application_info([1,6,0,$identityId,'F','1991-01-01','']);
            $hrd_rows = $this->authentication->sp_application_info([1,7,0,$identityId,'F','1991-01-01','']);
            $otExt_rows = $this->authentication->sp_application_info([1,1000,0,$identityId,'F','1991-01-01','']);

            
            session()->put('ot_aprroval_count', value: count($ot_rows['rows']));
            session()->put('leave_aprroval_count', value: count($leave_rows['rows']));
            session()->put('ta_aprroval_count', value: count($ta_rows['rows']));
            session()->put('ob_aprroval_count', value: count($ob_rows['rows']));
            session()->put('os_aprroval_count', value: count($os_rows['rows']));
            session()->put('te_aprroval_count', value: count($te_rows['rows']));
            session()->put('sc_aprroval_count', value: count($sc_rows['rows']));
            session()->put('hrd_aprroval_count', value: count($hrd_rows['rows']));
            session()->put('otExt_aprroval_count', value: count($otExt_rows['rows']));
            session()->put('app_time_interval', value: 10000);

            $data['ot_rows'] = session()->get('ot_aprroval_count');
            $data['leave_rows'] = session()->get('leave_aprroval_count');
            $data['ta_rows'] = session()->get('ta_aprroval_count');
            $data['ob_rows'] = session()->get('ob_aprroval_count');
            $data['os_rows'] = session()->get('os_aprroval_count');
            $data['te_rows'] = session()->get('te_aprroval_count');
            $data['sc_rows'] = session()->get('sc_aprroval_count');
            $data['hrd_rows'] = session()->get('hrd_aprroval_count');
            $data['otExt_rows'] = session()->get('otExt_aprroval_count');
            $data['app_int'] = session()->get('app_time_interval');
            $data['num'] = 0;
            $data['msg'] = 'success';

            return $data;
        }

        if ($mode == 11) {  /*For Approval response*/

            $id = $this->authentication->f_endecrypt($_POST['id'], 'd', $identityId);
            $switch = $_POST['switch'];


            $pint_mode = $_POST['pint_mode'];
            $val = $_POST['val'];
            $txtReject = $_POST['txtReject']; 
            $decision = ($val=="1") ? "<b style='color:green'>Approved</b>" : "<b style='color:red'>Rejected</b>";
           
            // APPROVE=1  REJECT=0

            $submit_response = $this->authentication->sp_for_approval_response([$pint_mode, $switch, $id, $identityId, $val, $txtReject]);
 
        
            if ($pint_mode==1){
 
                $secondAppover = $this->authentication->sp_get_next_authorizer([0,$switch,$id]);
                $formVal = $this->authentication->sp_get_document_info([0,$switch]);
                $app_user = $this->authentication->sp_app_user_info([0,$id,$switch]);
                $appName = $formVal['rows'][0]->formVal; 
                $appDate = $app_user['rows'][0]->appDate; 
                  
                
                if (!empty($secondAppover['rows']) && $val=="1") { 
                    
                    $fullname=session()->get('fullname');  
                    $sendTo = array_column($app_user['rows'], 'emailAddress');      
                    $approverName = array_column($secondAppover['rows'], 'authorizer');     
                    $ccTo = array_column($app_user['rows'], 'emailAddress');
                    $email['sendTo']=$sendTo; 
                    $email['CcTo']=$ccTo; 
                    
                    
                    $email['subject']="Kiosk Update: Your ".$appName." Request # [".$id."]";
                    $currentUrl = session()->get('currentUrl');
                        
                    $email['sendTo']=$sendTo;
                    $email['CcTo']=[]; 
                    $email['header']=["Hi Ma'am/Sir"]; 
                    $email['content']=["
                                        Your ".$appName." request, submitted on ".$appDate.", has been ".$decision." by ".session()->get('fullname').". 
                                        </br></br>
                                        The request has been forwarded to ".implode(", ", $approverName)." for review at the ".$secondAppover['rows'][0]->stageName.".
                                        </br></br>
                                        To review and take action on this request, please click the link below:<br>
                                        <i style='color:blue'><u>".$currentUrl."</u></i>
                                        "]; 
                    $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

                    $this->authentication->sendEmail(new Request($email)); 
 

                    $fullname=$app_user['rows'][0]->fullName;  
                    $sendTo = array_column($secondAppover['rows'], 'emailAddress');      
                    
                     
                    $email['subject']="Kiosk Update ".$appName." Request Pending Approval";
                    $currentUrl = session()->get('currentUrl');
                        
                    $email['sendTo']=$sendTo;
                    $email['CcTo']=[]; 
                    $email['header']=["Hi Ma'am/Sir"]; 
                    $email['content']=["
                                        You have received a ".$appName." request submitted by ".$fullname.", which is now pending your review and approval. 
                                        </br></br>
                                        Application #:".$id.".
                                        </br></br>
                                        To review and take action on this request, please click the link below:<br>
                                        <i style='color:blue'><u>".$currentUrl."</u></i>
                                        "]; 
                    $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"];  
                    $this->authentication->sendEmail(new Request($email)); 

                } else{


                    if($val=="1"){

                        $fullname=$app_user['rows'][0]->fullName; 
                        $sendTo = array_column($app_user['rows'], 'emailAddress');    
                        $email['sendTo']=$sendTo; 
                        $email['CcTo']=[]; 
                        $email['header']=["Dear ".$fullname]; 
                        $email['content']=["We want to <b style='color:green'>congratulate</b> you about your request for ".$appName." with application#:".$id." has been now <b style='color:green'>approved</b> by <b>".session()->get('fullname')."</b>. </br>kindly check this into our portal."]; 
                        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
                        $this->authentication->sendEmail(new Request($email)); 

                    }else{
                        
                        $fullname=$app_user['rows'][0]->fullName; 
                        $sendTo = array_column($app_user['rows'], 'emailAddress');    
                         
                        $email['subject']="Kiosk Update: Your ".$appName." Request # [".$id."]";
                        $currentUrl = session()->get('currentUrl');
                        
                        $email['sendTo']=$sendTo;
                        $email['CcTo']=[]; 
                        $email['header']=["Hi Ma'am/Sir"]; 
                        $email['content']=["
                                            Your ".$appName." request, submitted on ".$appDate.", has been ".$decision." by ".session()->get('fullname').". 
                                             
                                            </br></br>
                                            To review and take action on this request, please click the link below:<br>
                                            <i style='color:blue'><u>".$currentUrl."</u></i>
                                            "]; 
                        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

                        $this->authentication->sendEmail(new Request($email)); 

                    } 

                }  

            }

       
            return  $submit_response; 

            
        }

        if ($mode == 12) {  /*cancel ob request*/

            $r_obAppNo = $this->authentication->f_endecrypt($_POST['r_obAppNo'], 'd', $identityId);
            return $this->ob_application_model->sp_ob_application_cancel([0, $r_obAppNo]);
        }

        if ($mode == 13) {  /*cancel  request global*/

            $switchNo = $_POST['switchNo'];
            $_appNo = $this->authentication->f_endecrypt($_POST['appNo'], 'd', $identityId);
            return $this->authentication->sp_delete_application_form([0, $switchNo, $_appNo]);
        }

        
 
        if ($mode == 14) {  ///multi approve

            header('Content-Type: text/html; charset=utf-8');
            header('Cache-Control: no-cache');
            header('X-Accel-Buffering: no');

            $switch = $_POST['switch'];
            $pint_mode = $_POST['pint_mode']; 
            $r_code = $_POST['r_code'];
            $items = json_decode($_POST['items'],true);
                
            $approvedValues = ['1', 'A'];   
            $num1 = 0;
            foreach($items as $item){
                $items[$num1]['AppNo'] = $this->authentication->f_endecrypt($item['id'], 'd', $identityId);  
            $num1+=1;
            }
 
            $submitResponse = $this->authentication->sp_selected_items_response([$pint_mode, $identityId, $switch, $r_code, json_encode($items)]);


            
            $total = count($items);
            $num = 0;
            foreach($items as $item){

                $items[$num]['AppNo'] = $this->authentication->f_endecrypt($item['id'], 'd', $identityId); 
                
                $id = $items[$num]['AppNo'];
                $progData['num'] = 0; $progData['isUpdate'] = 1; $progData['msg'] = "Done"; $progData['id'] = $id; $this->updateProgress($progData);
                $secondAppover = $this->authentication->sp_get_next_authorizer([0,$switch,$id]);
                $formVal = $this->authentication->sp_get_document_info([0,$switch]);
                $app_user = $this->authentication->sp_app_user_info([0,$id,$switch]);
                $appName = $formVal['rows'][0]->formVal; 
                $appDate = $app_user['rows'][0]->appDate; 
                $approverName = array_column($secondAppover['rows'], 'authorizer'); 
                $decision =   ($r_code=="A") ? "<b style='color:green'>Approved</b>" : "<b style='color:red'>Rejected</b>";
                
                if (!empty($secondAppover['rows']) && $r_code=="A") {   

                    $fullname=session()->get('fullname'); 
                    $sendTo = array_column($app_user['rows'], 'emailAddress');      
                    $ccTo = array_column($app_user['rows'], 'emailAddress');    
                    $email['sendTo']=$sendTo; 
                    $email['CcTo']=$ccTo; 

                    
                    
                    $email['subject']="Kiosk Update: Your ".$appName." Request # [".$id."]";
                    $currentUrl = session()->get('currentUrl');
                    
                   

                    $email['sendTo']=$sendTo;
                    $email['CcTo']=[]; 
                    $email['header']=["Hi Ma'am/Sir"]; 
                    $email['content']=["
                                        Your ".$appName." request, submitted on ".$appDate.", has been ".$decision." by ".session()->get('fullname').". 
                                        </br></br>
                                        The request has been forwarded to ".implode(", ", $approverName)." for review at the ".$secondAppover['rows'][0]->stageName.".
                                        </br></br>
                                        To review and take action on this request, please click the link below:<br>
                                        <i style='color:blue'><u>".$currentUrl."</u></i>
                                        "]; 
                    $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

                    
                    $this->authentication->sendEmail(new Request($email));
                    

                    $fullname=$app_user['rows'][0]->fullName; 
                    $sendTo = array_column($secondAppover['rows'], 'emailAddress');
                     

                    $email['subject']="Kiosk Update ".$appName." Request Pending Approval";
                    $currentUrl = session()->get('currentUrl');
                        
                    $email['sendTo']=$sendTo; 
                    $email['CcTo']=[];  
                    $email['header']=["Hi Ma'am/Sir"]; 
                    $email['content']=["
                                        You have received a ".$appName." request submitted by ".$fullname.", which is now pending your review and approval. 
                                        </br></br>
                                        Application #:".$id.".
                                        </br></br>
                                        To review and take action on this request, please click the link below:<br>
                                        <i style='color:blue'><u>".$currentUrl."</u></i>
                                        "]; 
                    $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"];
                    
                    $this->authentication->sendEmail(new Request($email)); 

                }else{

                    //if($r_code=="1"){
                    if (in_array($r_code, $approvedValues)) {  
                        
                        $fullname=$app_user['rows'][0]->fullName; 
                        $sendTo = array_column($app_user['rows'], 'emailAddress');    
                         
                        $email['subject']="Kiosk Update: Your ".$appName." Request # [".$id."]";
                        $currentUrl = session()->get('currentUrl');
                        
                        $email['sendTo']=$sendTo;
                        $email['CcTo']=[]; 
                        $email['header']=["Hi Ma'am/Sir"]; 
                        $email['content']=["We are pleased to inform you that your ".$appName." request, submitted on ".$appDate.", has been fully ".$decision.". 
                                             </br>The request has successfully completed all required approval stages.
                                            </br></br>
                                            You may log in to the kiosk portal to view the final status and details of your request:<br>
                                            <i style='color:blue'><u>".$currentUrl."</u></i>
                                            "]; 
                        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

                        $this->authentication->sendEmail(new Request($email)); 

                    }else{
                        
                        

                        $fullname=$app_user['rows'][0]->fullName; 
                        $sendTo = array_column($app_user['rows'], 'emailAddress');    
                         
                        $email['subject']="Kiosk Update: Your ".$appName." Request # [".$id."]";
                        $currentUrl = session()->get('currentUrl');
                        
                        $email['sendTo']=$sendTo;
                        $email['CcTo']=[]; 
                        $email['header']=["Hi Ma'am/Sir"]; 
                        $email['content']=["
                                            Your ".$appName." request, submitted on ".$appDate.", has been ".$decision." by ".session()->get('fullname').". 
                                             
                                            </br></br>
                                            To review and take action on this request, please click the link below:<br>
                                            <i style='color:blue'><u>".$currentUrl."</u></i>
                                            "]; 
                        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 

                        $this->authentication->sendEmail(new Request($email)); 

                    } 

                }  
                    
                $num++;
            } 
       
            return $submitResponse; 
        }  

        if ($mode == 15) { /*post announcement*/ 
            $pint_mode = $_POST['pint_mode'];
            $pId = $_POST['pId'];
            $p_subject = $_POST['p_subject'];
            //$p_style = $_POST['p_style'];
            $p_style = '';
            $p_content = $_POST['p_content'];
            $p_recipients = $_POST['p_recipients'];
            
            return $this->authentication->sp_portal_announcement([$pint_mode,$pId,$p_style,$p_subject,$p_content,$p_recipients,$identityId]);
        }
 
        if ($mode == 16) { /*Open 2307 Report*/ 


          
            
            $data['num'] = 1;
            $data['msg'] = "";
            $data['rows'] = []; 
           // return  $data;
        
        }

        if ($mode == 17) { /*submit time entry request*/ 
            //$identityId  
            $pint_mode = $_POST['pint_mode'];
            $r_id = $_POST['r_teAppNo'];

            if ($r_id !== "0") {
                $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
            }

            $r_teDate = $_POST['r_teDate'];
            $r_teType = $_POST['r_teType'];
            $r_teTime = $_POST['r_teTime'];
            $r_location = $_POST['r_location'];
            $r_teReason = $_POST['r_teReason'];  
            $r_attachedFiles = $_POST['r_attachedFiles'];  
            return $this->time_entry_model->sp_timeentry_submit_request([$pint_mode, $r_id, $identityId, $r_teDate, $r_teType, $r_teTime, $r_location, $r_teReason,$r_attachedFiles],$pint_mode,$r_id);
        }

        if ($mode == 18) {  /*cancel time entry request*/

            $r_id = $this->authentication->f_endecrypt($_POST['r_id'], 'd', $identityId);
            return $this->time_entry_model->sp_timeentry_delete_request([0, $r_id]);
        }
        
        if ($mode == 19) {  /*submit DTR*/ 
            $pint_mode = $_POST['pint_mode'];
            $geo = $_POST['geo'];
            $dtrType = $this->authentication->f_endecrypt($_POST['dtrType'], 'd', $identityId);
            return $this->dashboard_model->sp_dtr_logs_insert([$pint_mode,$dtrType,$identityId,$geo]); 
        }

        if ($mode == 20) {  /*submit Schedule*/ 
            
            $pint_mode = $_POST['pint_mode']; 
            $appNo = $this->authentication->f_endecrypt($_POST['appNo'], 'd', $identityId);
            // $appNo = ($appNo==false ? 0 : $appNo);  
            $r_Day = $_POST['r_Day'];
            $r_scSchedule = $_POST['r_scSchedule'];
            $r_scReason = $_POST['r_scReason']; 
            $r_attachedFiles = $_POST['r_attachedFiles']; 

            $data['kiosklocked'] = 0;
            $schedArray = $this->calendar_model->sp_get_employee_schedule([0, $identityId,$r_Day]);
            if(count($schedArray['rows'])>0){
                $data['schedule'] = $schedArray['rows'][0]; 
            }
            $data['checkPeriod'] = $this->authentication->sp_get_payrollperiod_kiosk([0,$identityId]);

            if(!empty($data['schedule'])){ 
				foreach($data['checkPeriod']['rows'] as $b) { 
					if($data['schedule']->payrollPeriodFrom >= $b->from && $data['schedule']->payrollPeriodTo <= $b->to) {
						$data['kiosklocked'] = 0;
					} else {
						$data['kiosklocked'] = 1;
					}
				}
			}
 
            return $this->calendar_model->sp_schedule_change([$pint_mode,$appNo,$identityId,$r_Day,$r_scSchedule,$r_scReason,$r_attachedFiles],$pint_mode,$appNo); 
             
        }


        if ($mode == 21) { /*NEW PASSWORD*/

            $identity = $_POST['identity'];
            $nPass = $this->authentication->f_endecrypt($_POST['nPass'], 'e', $identity);
            $cPass = $this->authentication->f_endecrypt($_POST['cPass'], 'e', $identity); 

            if ($_POST['nPass']==""){
               // return json_encode($this->authentication->return_error("lbl_Payroll", "Please enter new password!"));
               $data['num'] = 1;
               $data['msg'] = "Please enter new password!";  
               return $data;
            }

            if ($_POST['cPass']==""){
               // return json_encode($this->authentication->return_error("lbl_Payroll", "Please confirm new password!"));
               $data['num'] = 1;
               $data['msg'] = "Please confirm new password!";  
               return $data;
            }

            return $this->password_model->sp_portal_new_password_validation([0,$identity,$_POST['nPass'],"$nPass","$cPass"]); 
           
            
          
        }

        if ($mode == 22) { /*SUBMIT HRD Certificate */
            
            $pint_mode = $_POST['pint_mode'];
            $id = $_POST['r_id'];
            $r_dateNeeded = $_POST['r_dateNeeded'];
            $r_certOfemp = $_POST['r_certOfemp'];
            $r_creditCardApp = ($_POST['r_creditCardApp']=="true" ? 1 : 0);
            $r_creditCardAppBank = $_POST['r_creditCardAppBank']; 
            $r_visaApp = ($_POST['r_visaApp']=="true" ? 1 : 0);
            $r_visaAppCtry = $_POST['r_visaAppCtry'];
            $r_visaAppForWhose = $_POST['r_visaAppForWhose'];
            $r_visaAppForWhoseOtherDetail = $_POST['r_visaAppForWhoseOtherDetail'];
            $r_visaAppKind = $_POST['r_visaAppKind'];
            $r_visaAppKindOtherDetail = $_POST['r_visaAppKindOtherDetail'];
            $r_loanApp = ($_POST['r_loanApp']=="true" ? 1 : 0);
            $r_loanAppInstitution = $_POST['r_loanAppInstitution'];
            $r_idApp = ($_POST['r_idApp']=="true" ? 1 : 0);
            $r_idAppHospital = $_POST['r_idAppHospital'];
            $r_idAppHospRecipient = $_POST['r_idAppHospRecipient'];
            $r_otherPurpose = ($_POST['r_otherPurpose']=="true" ? 1 : 0);
            $r_otherPurposeDetail = $_POST['r_otherPurposeDetail']; 
            $r_hdmf = ($_POST['r_hdmf']=="true" ? 1 : 0);
            $r_clearanceCert = ($_POST['r_clearanceCert']=="true" ? 1 : 0);
            $r_otherCert = ($_POST['r_otherCert']=="true" ? 1 : 0);
            $r_otherCertDetail = $_POST['r_otherCertDetail'];
 
            return $this->hrd_certificate->sp_hrd_cert_submit([$pint_mode,$id,$identityId,$r_dateNeeded,$r_certOfemp,$r_creditCardApp,$r_creditCardAppBank,$r_visaApp,$r_visaAppCtry,$r_visaAppForWhose,$r_visaAppForWhoseOtherDetail,$r_visaAppKind
            ,$r_visaAppKindOtherDetail,$r_loanApp,$r_loanAppInstitution,$r_idApp,$r_idAppHospital,$r_idAppHospRecipient,$r_otherPurpose,$r_otherPurposeDetail
            ,$r_hdmf,$r_clearanceCert,$r_otherCert,$r_otherCertDetail],$pint_mode,$id); 

        }


        if ($mode == 23) { /*HRD APPROVER RESPONSE*/
             
            
            //$certFile  = $_FILES['certFile'];
            $filename = "";
            $target_file = "";
            $pint_mode = $_POST['pint_mode'];
            $appNo = $_POST['appNo']; 
            $decide = $_POST['decide']; 
            $remarks = $_POST['remarks']; 


            $attachments = [];
            try {
                if (isset($_FILES['certFile']) && $decide==1) {  

                    //$target_dir = "../storage/app/public/hrdCert/"; 
                    $target_dir = public_path("storage/hrdCert/");

                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);  
                    }
                     
                    $filename = basename($_FILES['certFile']['name']);
                    $target_file = $target_dir . $filename;


                if ($_FILES['certFile']['error'] !== UPLOAD_ERR_OK) {
                    $msg = "Upload failed with error code: " . $_FILES['certFile']['error'];
                    $data['num'] = 1;
                    $data['msg'] = json_encode(["id" => "lblfileCert","msg" => $msg]); 
                    return $data;
                }
                     
                    
                    if (move_uploaded_file($_FILES['certFile']['tmp_name'], $target_file)) {
                        chmod($target_file, 0644);
                        exec("icacls " . escapeshellarg($target_file) . " /grant Everyone:F"); 

                        $attachments = [
                            [
                                'tmp_name' =>$target_file,
                                'name' => $_FILES['certFile']['name'],
                                'type' => $_FILES['certFile']['type'] // optional
                            ]
                        ];

                    } else {
                        $data['num'] = 1;
                        $data['msg'] = json_encode(["id" => "lblfileCert","msg" =>  "Upload Failed!"]); 
                        return $data;
                    } 
 
                }
            } catch (Exception $e) { 
                http_response_code(400); // optional 
                $data['num'] = 1;
                $data['msg'] = json_encode(["id" => "lblfileCert","msg" =>  $e->getMessage()]); 
                return $data;
            } 
             
             return  $this->hrd_certificate->sp_hrd_cert_approval([$pint_mode,$identityId,$appNo,$filename,$decide,$remarks],$appNo,$attachments); 
        }


        if ($mode == 24) { /*SAVE DASHBOARD*/ 
            session()->put('dash_edit_mode',0); 
            $pint_mode = $_POST['pint_mode'];
            $json_data = $_POST['json_data']; 
            return  $this->dashboard_model->sp_user_dashboard_settings([$pint_mode,$identityId,$json_data]); 
        }

        if ($mode == 25) { /*RESET DASHBOARD*/ 
            session()->put('dash_edit_mode',0);  
            return  $this->dashboard_model->sp_user_dashboard_settings([1,$identityId,"[]"]); 
        }


        if ($mode == 26) { /*FACE*/  
            $database = session()->get('database'); 
            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);
            DB::reconnect('mysql'); 
            return $this->authentication->sp_faceDetails([$_POST['pint_mode'], session()->get('username'),$_POST['faceData']]);
        }

        if ($mode == 27) { /*Cancel Approved Reqeust*/   
            return  $this->leave_model->sp_approved_request_cancel([$_POST['pint_mode'],$_POST['switch'],$_POST['rAppNo'],$_POST['rRemarks'],$identityId]); 
        }

        if ($mode == 28) { /*Leave Approved Day*/   
            return  $this->leave_model->sp_approved_leave_date([$_POST['pint_mode'],$_POST['rAppNo'],$_POST['rId']]); 
        }


    }

    public function faceRecognize(){  

        $database = session()->get('database'); 
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $database]);
        DB::reconnect('mysql');   
        return $this->authentication->sp_faceDetails([$_POST['mode'], session()->get('username'),$_POST['faceData']]); 
        
    }

    public function directLogin(){ 

            $start  = microtime(true);
           
            $database = $_POST['database'];
            $username = $_POST['username'];
            
            session()->put('database', $database);

            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);
            DB::reconnect('mysql');

           session()->put('sub_applications', value: $this->authentication->sp_pf_common_sub_app_license([0,'',$database]));
            
           $companyPasswordSettings = $this->company_password->get_company_password_details(); 


           $companyPasswordSettings['password'] = $this->authentication->f_endecrypt($companyPasswordSettings['password'], 'd', 'ftsi');
            $default_mailer = $this->authentication->sp_get_default_mailer([0]);

            session()->put('companyPasswordSettings', value: $companyPasswordSettings);
            
            $default_mailer['rows'][0]->smtp_pass = $this->authentication->f_endecrypt($default_mailer['rows'][0]->smtp_pass, 'd', 'ftsi');
            session()->put('default_mailer', value: $default_mailer['rows'][0]);

            
            $data['authenticate'] = $this->authentication->authenticate_account_per_user($username);

            if (empty($data['authenticate']['pStatus'])) { 
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','Unkown user',$start); 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Unkown user']);
            }
                
            if ($data['authenticate']['pStatus'] == 'T') { 
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','Account Inactive',$start); 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Account Inactive.']);
            }

            
                
            if ($data['authenticate']['usertype'] == "user") { 

                if(empty($this->authentication->get_identity($data['authenticate']['identityid']))){
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','Successfully login but no identity created!',$start); 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Successfully login but no identity created! please contact HR.']);
                }

                $data['identity'] = $this->authentication->get_identity($data['authenticate']['identityid']);
                session()->put('identityId', value: $data['identity']['identityId']);

                session()->put('te_aprroval_count', value: 0);
                session()->put('ot_aprroval_count', value: 0);
                session()->put('leave_aprroval_count', value: 0);
                session()->put('ta_aprroval_count', value: 0);
                session()->put('ob_aprroval_count', value: 0);
                session()->put('os_aprroval_count', value: 0);
                session()->put('sc_aprroval_count', value: 0);
                session()->put('hrd_aprroval_count', value: 0);
                session()->put('app_time_interval', value: 1000); 
                session()->put('companyName', value:  $companyPasswordSettings['companyName']); 

                session()->put('emailHost', value: $companyPasswordSettings['smtpHost']);
                session()->put('emailPort', value: $companyPasswordSettings['smtpPort']);
                session()->put('emailFrom', value: $companyPasswordSettings['defaultSenderName']);

                session()->put('fullname', value: $data['identity']['firstName'] . " " . $data['identity']['lastName']);
                session()->put('batchId', value: $data['identity']['batchId']);

                $password = $data['authenticate']['password']; 
                session()->put('password', value: $password);
                session()->put('encrypted_password', value: $this->authentication->f_endecrypt($password, 'e', $username));
                 
                

                
                 
                $pStatus = $data['authenticate']['pStatus'];
                $changeOnInit = $this->password_model->sp_portal_get_passwordChangeInitLogon();
                $changeOnInitString = $changeOnInit['rows'][0]->passwordChangeInitLogon;
                
                
                if ($pStatus == 'D' && $changeOnInitString == 1) {
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','New user / Password need to update',$start); 
                    session()->put('passwordStatus', 'new');
                    session()->put('username', $username);
                    return redirect()->route('new_password');
                }

                session()->put('access_rights', value: $this->authentication->sp_approver_get_priviledge()); 

                $user_details = $this->authentication->get_identity_sp([0, $username]);

                session()->put('if_approver', $user_details['rows'][0]->if_approver);
                session()->put('faceDetails', $user_details['rows'][0]->faceDetails);

                $deleteFaieldLogin = $this->password_model->sp_portal_update_user_attempt($username);
                $events = $this->calendar_model->load_sched_advanced(0,$username,'','');  
                
                if (!empty($deleteFaieldLogin) && isset($deleteFaieldLogin['num']) && $deleteFaieldLogin['num'] == 0) {
                    
                    session()->put('yearSched', date("Y"));  
                    session()->put('currentEvents',$events);  
                    session()->put('dash_edit_mode',0);  
                    session()->put('currentUrl',$this->getBaseUrl());  
                    session()->put('username', $username);
                    
                    $this->authentication->sp_userAuditTrails(1,'Login','Success','',$start); 
                    return $this->goto_Dashboard();       
                }


            }
             else {
                $this->authentication->sp_userAuditTrails(1,'Login','Warning','User need to login in admin side',$start); 
                return redirect()->route('login')->withErrors(provider: ['password' => 'Use admin login.']);
                // return back()->withErrors(['password' => 'Use admin login.']);
            }
 
    }


    public function open_lms(){   
        //USING COOKEI
        
        
        $path = public_path('storage/config.json'); 
        $content = File::get($path); 
        session()->put('config', value:json_decode($content, true));
        $learningcenter = session()->get('config')['learningcenter'];
        $subdomain = session()->get('config')['subdomain'];

        setcookie("current_user", session()->get('identityId'), time() + 3600, "/", $subdomain);
        setcookie("database", Session::get('database'), time() + 3600, "/", $subdomain);
        setcookie("mode", 0, time() + 3600, "/", $subdomain); 
        setcookie("hostName",  env('DB_OWNER'), time() + 3600, "/", $subdomain);  
        return redirect()->away($learningcenter); 
        
    }

    public function open_rbp(){   
        //USING COOKEI
        $path = public_path('storage/config.json'); 
        $content = File::get($path); 
        session()->put('config', value:json_decode($content, true));
        $recruiment = session()->get('config')['recruiment'];
        $subdomain = session()->get('config')['subdomain'];

        setcookie("current_user", session()->get('identityId'), time() + 3600, "/", $subdomain);
        setcookie("database", Session::get('database'), time() + 3600, "/", $subdomain); setcookie("mode", 0, time() + 3600, "/", $subdomain); 
        setcookie("hostName",  env('DB_OWNER'), time() + 3600, "/", $subdomain);  
        return redirect()->away($recruiment); 
        
    }

    public function validate_new_password(){
        $identity = $_POST['identity'];
        $nPass = $this->authentication->f_endecrypt($_POST['nPass'], 'e', $identity);
        $cPass = $this->authentication->f_endecrypt($_POST['cPass'], 'e', $identity); 

        if ($_POST['nPass']==""){ 
           $data['num'] = 1;
           $data['msg'] = "Please enter new password!";  
           return $data;
        }

        if ($_POST['cPass']==""){ 
           $data['num'] = 1;
           $data['msg'] = "Please confirm new password!";  
           return $data;
        }

        

        $pass_validation  = $this->password_model->sp_portal_new_password_validation([1,$identity,$_POST['nPass'],"$nPass","$cPass"]); 
        return $pass_validation; 
    }

    public function OpenReport(){

        echo  $_POST['url'];


        // return $data;
        /*   echo "<script>
        window.open('https://chatgpt.com/', '_blank');
        </script>";
        return; */

        // echo "window.open('".$_POST['url']."', '_blank')";

    }

    //////////////////////////applications////////////////////////
    
    public function hrd_application(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');  
        $data['pending_list'] = $this->authentication->sp_application_info([0,7,0,$identityId,'P','','']);  
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['num'] = $this->authentication->f_endecrypt("1", 'e', $identityId); 
        return view('layouts.tabs.request.hrdcert_application', $data);
         
    }
 

    public function hrd_application_dtls(){ 
        $identityId = session()->get('identityId'); 
        $zero = $this->authentication->f_endecrypt("0", 'e', $identityId);
        $data['appNo'] = ((empty($_POST['appNo'])) ? $zero : $_POST['appNo']);  
        $data['appNo'] = $this->authentication->f_endecrypt($data['appNo'], 'd', $identityId);  
        $data['mode'] = $this->authentication->f_endecrypt($_POST['mode'], 'd', $identityId);  
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['appNoInfo'] = $this->authentication->sp_application_info([0,7,$data['appNo'],0,'H','','']);  
        return view('layouts.tabs.request.request_form.hrdcert_application', $data);
 
    }

    
    public function HRDApproval(){
        $this->DisconnectDB(); 
        $identityId = session()->get('identityId');  
        $data['num'] = $this->authentication->f_endecrypt("0", 'e', $identityId); 
        $data['list'] = $this->authentication->sp_application_info([1,7,0,$identityId,'F','1991-01-01','']);
        return view('layouts.tabs.forapproval.hrdcert_approval', $data); 
    }

    public function show_Time_Entry(){ 
        $this->DisconnectDB(); 
       foreach(session()->get('access_rights')['rows'] as $rows){
        if($rows->timeEntry!==1){
            return view('layouts.partials.unauthorized');
        }
       }
       
        $identityId = session()->get('identityId'); 
        $data['pending_list'] = $this->authentication->sp_application_info([0,5,0,$identityId,'P','','']);  
        $data['history'] = $this->authentication->sp_application_info([0,5,0,$identityId,'H','','']);  
        $num = 0;
        foreach ($data['pending_list']['rows'] as $rows) {
            $enc_id = $rows->teAppNo; 
            $data['pending_list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($enc_id, 'e', $identityId); 
            $num++;
        } 
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        return view('layouts.tabs.request.time_entry_application', $data);
    }


    public function show_Time_Entry_Form(){
        $identityId = session()->get('identityId');

        $id = $_POST['app_id'];
        if ($id !== "0") {
            $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
        }
         
        $data['selected_row'] = $this->authentication->sp_application_info([0,5,$id,0,'F','','']);  
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['locations'] = $this->authentication->exec_store_proc('sp_get_locations', [0]);
        $data['in_out'] = $this->authentication->sp_dropdown_fill([2,0]);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$id,'timeentry','']);  
        return view('layouts.tabs.request.request_form.time_entry_application', $data);
    }

 
    public function overtime_application() {
        $this->DisconnectDB(); 

        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->overtime!==1){
                return view('layouts.partials.unauthorized');
            }
        }
 
        $identityId = session()->get('identityId');  
        $data['ot_list'] = $this->authentication->sp_application_info([0,0,0,$identityId,'P','','']); 
        $data['request_history'] = []; 

        $new_data = $data['ot_list'];
        foreach ($new_data['rows'] as &$row) { /*ENCTYPT APP#*/
            $row->enc_id = $this->authentication->f_endecrypt($row->otAppNo, 'e', $identityId);
        }
 
        $new_data['num'] = $data['ot_list']['num'];
        $new_data['msg'] = $data['ot_list']['msg'];

        $new_data2['ot_list'] = $new_data;
        $new_data2['request_history'] = $data['request_history'];
        $new_data2['status'] = $this->authentication->sp_dropdown_fill([4, 0]); 
        return view('layouts.tabs.request.overtime_application', $new_data2);
    }

    public function show_overtime_form(){
        $identityId = session()->get('identityId');
        $id = $_POST['id'];
        if ($id !== "0") {
            $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
        }
        
        $params = [0];
        $rows = $this->authentication->exec_store_proc('sp_get_locations', $params); 
        $data['overtime'] =  $this->authentication->sp_application_info([0,0,$id,0,'P','','']);  
        $data['ot_types'] = $this->overtime_model->sp_dropdown_fill([0, 0]);
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['locations'] = $rows; 
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$id,'overtime','']);  
        return view('layouts.tabs.request.request_form.overtime_application_form', $data);
    }
    
    public function overtimeExt_application() {
       
        $this->DisconnectDB(); 

        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->overtime!==1){
                return view('layouts.partials.unauthorized');
            }
        }
 
        $identityId = session()->get('identityId');  
        $data['ot_list'] = $this->authentication->sp_application_info([0,1000,0,$identityId,'P','','']); 
        $data['request_history'] = []; 
        //echo json_encode($data['ot_list']); return;
        
        $new_data = $data['ot_list'];
        foreach ($new_data['rows'] as &$row) {  
            $row->enc_id = $this->authentication->f_endecrypt($row->otAppNo, 'e', $identityId);
        }
 
        $new_data['num'] = $data['ot_list']['num'];
        $new_data['msg'] = $data['ot_list']['msg'];

        $new_data2['ot_list'] = $new_data;
        
        $new_data2['request_history'] = $data['request_history'];
        $new_data2['status'] = $this->authentication->sp_dropdown_fill([4, 0]); 

        return view('layouts.tabs.request.overtimeExt_application', $new_data2);
    }

    

    public function show_overtimeExt_form(){
        $identityId = session()->get('identityId');
        $id = $_POST['id'];
        if ($id !== "0") {
            $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
        }
        
        $params = [0];
        $rows = $this->authentication->exec_store_proc('sp_get_locations', $params); 
        $data['overtime'] =  $this->authentication->sp_application_info([0,1000,$id,0,'P','','']);  
        $data['ot_types'] = $this->overtime_model->sp_dropdown_fill([0, 0]);
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['locations'] = $rows; 
        return view('layouts.tabs.request.request_form.overtimeExt_application_form', $data);
    }

    public function overtimeExtMapping(){ 
       $mode = $_POST['mode'];
       $details = json_encode($_POST['details']); 
       return $this->overtime_model->sp_portal_overtime_ext_allo_mapping([$mode, $details]);
    }

    public function show_sp_get_users()
    {
        $this->overtime_model->sp_get_users();
    }

    public function DisconnectDB(){
        $url = url()->previous(); 
        $path = parse_url($url, PHP_URL_PATH);  
        $lastSegment = last(explode('/', trim($path, '/')));  

        $page_list = ["dashboard"];


        if (in_array($lastSegment, $page_list)) {
            \DB::disconnect();
        }

        // echo $lastSegment;
    }

    public function offset_application(){ 
        $this->DisconnectDB(); 

        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->offsetTime!==1){
                return view('layouts.partials.unauthorized');
            }
        }
  
        $identityId = session()->get('identityId');
        $data['app_list'] =$this->authentication->sp_application_info([0,4,0,$identityId,'P','','']); 
        $num = 0;
        foreach ($data['app_list']['rows'] as $row) {
            $data['app_list']['rows'][$num]->enc_id = $this->authentication->f_endecrypt($row->osAppNo, 'e', $identityId);
            $num += 1;
        }

        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] =[];

        return view('layouts.tabs.request.offset_application', $data);
    }

    public function show_offset_form(){
        $identityId = session()->get('identityId'); 
        $r_id = $_POST['app_id']; 
        if ($r_id !== "0") {
            $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
        }
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['app_details'] = $this->authentication->sp_application_info([0,4,$r_id,0,'P','','']);
        $data['identityid'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['locations'] = $this->authentication->get_locations([1]); 
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$r_id,'offset','']);  
        return view('layouts.tabs.request.request_form.offset_application', $data);
    }

    public function show_offset_ref_list(){
        $identityId = session()->get('identityId');
        $data['ref_list'] = $this->offset_model->sp_offset_get_ref_list([0, $identityId]);
        return view('layouts.tabs.request.request_form.offset_ref_list', $data);
    }

    public function leave_application(){ 
        $this->DisconnectDB(); 
        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->leave!==1){
                return view('layouts.partials.unauthorized');
            }
        }

        $identityId = session()->get('identityId');
        $str['sched_list'] = $this->authentication->sp_dropdown_fill([1, 0]);
        $str['holidays'] = $this->authentication->sp_get_holidaysholiday([0]);
        $str['pending_list'] = $this->leave_model->sp_get_all_leave([0, 0, $identityId]);
        $num = 0;
        foreach ($str['pending_list']['rows'] as $rows) {
            $enc_id = $this->authentication->f_endecrypt($rows->laAppNo, 'e', $identityId);
            $str['pending_list']['rows'][$num]->enc_id = $enc_id;
            $num += 1;
        }
        $str['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $str['request_history'] = $this->authentication->sp_request_get_history([1, 0, $identityId, 0, '', '', '']); 
        
        return view('layouts.tabs.request.leave_application', $str);
    }

    public function show_leave_form(){
        $identityId = session()->get('identityId');
        $id = $_POST['id'];
        if ($id !== "0") {
            $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
        }
       
        $rows = $this->authentication->exec_store_proc('sp_get_locations', [0]); 
        $data['holidays'] = $this->authentication->sp_get_holidaysholiday([0]);
        $data['item_detail'] = $this->leave_model->sp_get_all_leave([1, $id, $identityId]);
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['leave_type'] = $this->leave_model->sp_get_user_leave_type([0, $identityId]);
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['locations'] = $rows;
        $data['sched_list'] = $this->leave_model->sp_leave_get_request_list([0, $id]);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$id,'leave','']);  
        return view('layouts.tabs.request.request_form.leave_application', $data);
    }

    public function time_adj_application(){
        $this->DisconnectDB(); 
        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->timeAdjustment!==1){
                return view('layouts.partials.unauthorized');
            }
        }

           
        $identityId = session()->get('identityId');
        $data =$this->authentication->sp_application_info([0,2,0,$identityId,'P','','']); 
        $num = 0;
        foreach ($data['rows'] as $rows) {
            $data['rows'][$num]->enc_id = $this->authentication->f_endecrypt($data['rows'][$num]->taAppNo, 'e', $identityId);
            $num += 1;
        } 
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] = []; 
        return view('layouts.tabs.request.time_adj_application', $data);
    }

    public function show_time_adjustment_form(){

        $identityId = session()->get('identityId');
        $id = $_POST['app_id'];
        if ($id !== "0") {
            $id = $this->authentication->f_endecrypt($id, 'd', $identityId);
        }
        $data['disabled_array'] = $this->authentication->sp_time_adj_get_disabled_array([0, $identityId]);
        $data['in_out'] = $this->authentication->sp_dropdown_fill([2, 0]);
        $data['locations'] = $this->authentication->exec_store_proc('sp_get_locations', [0]);
        $data['id'] = $id;
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['selected_row'] = $this->authentication->sp_application_info([0,2,$id,$identityId,'P','','']);
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);

        return view('layouts.tabs.request.request_form.time_adj_application', $data);
    }

    public function ob_application(){
        $this->DisconnectDB();  
        foreach(session()->get('access_rights')['rows'] as $rows){
            if($rows->officialBusiness!==1){
                return view('layouts.partials.unauthorized');
            }
           }

        $identityId = session()->get('identityId');
        $data = $this->authentication->sp_application_info([0,3,0,$identityId,'P','','']);
        $num = 0;
        foreach ($data['rows'] as $rows) {
            $data['rows'][$num]->enc_id = $this->authentication->f_endecrypt($data['rows'][$num]->obAppNo, 'e', $identityId);
            $num += 1;
        }  
        $data['status'] = $this->authentication->sp_dropdown_fill([4, 0]);
        $data['request_history'] =[];

        return view('layouts.tabs.request.ob_application', $data);
    }
 
    public function show_ob_app_form(){
        $identityId = session()->get('identityId');

        $r_id = $_POST['app_id'];
        if ($r_id !== "0") {
            $r_id = $this->authentication->f_endecrypt($r_id, 'd', $identityId);
        }
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);
        $data['selected_row'] = $this->authentication->sp_application_info([0,3,$r_id,0,'P','','']);
        $data['officialbusinesslist'] = $this->ob_application_model->sp_ob_application_get_officialbusinesslist([0, $r_id]);
        $data['kiosklocked'] = $this->authentication->sp_get_payrollperiod_kiosk([0, $identityId]);
        $data['in_out'] = $this->authentication->sp_dropdown_fill([3, 0]);
        $data['id'] = $r_id; 
        $data['locations'] = $this->authentication->get_locations([2]);
        $data['attachedFiles'] = $this->authentication->sp_requestattachments([0,$r_id,'officialbusiness','']);  
        return view('layouts.tabs.request.request_form.ob_application', $data);
    }

    public function show_ob_days_location() {
        $data['locations'] = $this->authentication->get_locations([2]);
        return view('layouts.tabs.request.request_form.ob_application_days',$data);
    }

    public function auth_deduct_application()
    { 
        return view('layouts.tabs.request.auth_deduct_application');
    }

    public function app_form_application()
    {
        return view('layouts.tabs.request.app_form_application');
    }

    public function dynamic_delete()
    {
        return view('layouts.tabs.request.request_form.dynamic_delete');
    }


    //////////////////////////Reports////////////////////////  

    public function show_payslip_report($id)
    {

        $report_url = $this->authentication->sp_portal_url_maping([1])['rows'][0]->url;
        return view($report_url.$id);
    }

    public function view_report_data(){
        $pint_mode = $_POST['pint_mode'];
        $df = $_POST['df'];
        $dt = $_POST['dt'];
        $identityid = Session::get('identityId'); 

        if ($pint_mode==0){
            $data['report_record'] = $this->authentication->sp_rpt_get_payslip_record([0,$identityid,$df,$dt]); 
        }else{
            $data['report_record'] = $this->authentication->sp_rpt_get_employee_nthmonth([0,$identityid,$df,$dt]); 
        }

        $data['pint_mode']=$pint_mode;
        
        
        return view('layouts.tabs.Reports.reportData',$data);
    }

    public function payslip_record()
    {
        DB::purge('mysql');
        config(['database.connections.mysql.database' => Session::get('database')]);
        DB::reconnect('mysql');
        $identityid = Session::get('identityId');
        //$data['emp_payslip_record'] = $this->report_paysilp_model->get_employee_payslip($identityid);
        $data['emp_payslip_record'] = $this->authentication->sp_rpt_get_payslip_record([0,$identityid,'1990-01-01','']);

        //echo json_encode($data['emp_payslip_record']);

        if (isset($_POST['btnCancel'])) {
            session()->put('modal', 'false');
        }

        if (isset($_POST['btnSubmitPass'])) {


            $code = $_POST['txtCode'];
            $password = $_POST['txtPass'];
            $ex_password = session()->get('password');

            if ($password !== $ex_password) {

                session()->put('modal', 'true');
                session()->put('code', $code);
                return view('layouts.tabs.Reports.payslip_record', $data);

            }

            $id = $identityid;

            $timestamp = microtime(true);
            $username = $id;
            $forencrypt = $timestamp . "" . $username;
            $id2 = $this->authentication->f_endecrypt($forencrypt, 'e', $id);
            $finalid = str_replace("=", "", $id2);
            $database = Session::get('database');

            $param = $this->authentication->payslip_param_based_on_payslip_code($code);
            $Department = "";
            $CostCenterCode = ""; 
            $stringParams = "reportSource=~/Reports/Payslip.rpt&PSPayDate=" . $param['PSPayDate'] . "&EmployeeId=" . $id . "&Department=" . $Department . "&CostCenterCode=" . $CostCenterCode . "&PayrollGrp=" . $param['batchId'] . "&database=" . $database . "&UserName=" . $param['username'];
             
           /*  echo "<script>
                        alert('PSPayDate:".$param['PSPayDate']."');
                        alert('EmployeeId:".$id."');
                        alert('Department:".$Department."');
                        alert('CostCenterCode:".$CostCenterCode."');
                        alert('PayrollGrp:".$param['batchId']."'); 
                        </script>"; */
            if ($this->authentication->add_link($finalid, $stringParams)) {
                $report_url = $this->authentication->get_report_url();
                echo "<script>
                        window.open('" . $report_url . $finalid . "', '_blank');
                        </script>";

            } else {
                echo "Unauthorized user now allowed";
                return;
            }


        }

        session()->put('modal', 'false');
        return view('layouts.tabs.Reports.payslip_record', $data);
    }

    public function th_month_apy()
    {

        DB::purge('mysql');
        config(['database.connections.mysql.database' => Session::get('database')]);
        DB::reconnect('mysql');
        $identityid = Session::get('identityId');
        //$data['emp_payslip_record'] = $this->report_paysilp_model->get_employee_payslip($identityid);
        //$data['th_month_pay'] = $this->th_month_pay_model->sp_get_employee_nthmonth([0,$identityid]); 
        $data['th_month_pay'] = $this->authentication->sp_rpt_get_employee_nthmonth([0,$identityid,'','']); 


        if (isset($_POST['btnCancel'])) {
            session()->put('modal', 'false');
        }

        if (isset($_POST['btnSubmitPass'])) {


            $code = $_POST['txtCode'];
            $password = $_POST['txtPass'];
            $ex_password = session()->get('password');

            if ($password !== $ex_password) {

                session()->put('modal', 'true');
                session()->put('code', $code);
                return view('layouts.tabs.Reports.th_month_apy', $data);

            }

            $id = $identityid;

            $timestamp = microtime(true); 
            $forencrypt = $timestamp . "" . $id;
            $id2 = $this->authentication->f_endecrypt($forencrypt, 'e', $id);
            $finalid = str_replace("=", "", $id2);
            

            $param = $this->th_month_pay_model->sp_get_employee_nthmonth([1,$code]); 
            $database = Session::get('database');
            
       

            $payoutDate = $param['rows'][0]->payoutdate;
            $id = $param['rows'][0]->identityId;
            $payrollGroup = $param['rows'][0]->payrollGroup;
            $UserName = $param['rows'][0]->identityId; 
            
         /*    echo "<script>
            alert('".$payoutDate."');
            alert('".$id."');
            alert('".$payrollGroup."');
            alert('".$UserName."');
            </script>";
 */

            //$stringParams = "reportSource=~/Reports/Payslip.rpt&PSPayDate=" . $param['PSPayDate'] . "&EmployeeId=" . $id . "&Department=" . $Department . "&CostCenterCode=" . $CostCenterCode . "&PayrollGrp=" . $param['batchId'] . "&database=" . $database . "&UserName=" . $param['username'];
            // $stringParams = "reportSource=~/Reports/13thMonthPayslip.rpt&PayDate13th=".$payoutDate."&EmployeeId=".$id."&PayrollGrp=".$payrollGroup."&database=".$database."&UserName=".$UserName;					
           
            $stringParams = "reportSource=~/Reports/13thMonthPayslip.rpt&PayDate=".$payoutDate."&EmployeeId=".$id."&PayrollGrp=".$payrollGroup."&database=".$database."&UserName=".$UserName;					
           
            if ($this->authentication->add_link($finalid, $stringParams)) {
                $report_url = $this->authentication->get_report_url();
                echo "<script>
                        window.open('" . $report_url . $finalid . "', '_blank');
                        </script>";

            } else {
                echo "Unauthorized user now allowed";
                return;
            }


        }

        session()->put('modal', 'false');
        return view('layouts.tabs.Reports.th_month_apy', $data);
         
       // return view('layouts.tabs.Reports.th_month_apy');
    }

    public function twenty_report()
    { 
        $data['signatories'] = $this->authentication->sp_get_signatories([0]);  

        if(isset($_POST['btn1'])){

            $database = Session::get('database');
            $id = Session::get('identityId');

            $params = $this->authentication->sp_get_payslip_param([$id]);

            $from = $_POST['dateFrom'];
            $to = $_POST['dateTo'];
            $signatories = $_POST['sigDDL'];
            $PayrollGrp = $params['rows'][0]->batchId;
            $UserName = $params['rows'][0]->username;

            //echo json_encode($params['rows']); 
            
            $stringParams = "reportSource=~/Reports/BIR2307.rpt&DateFrom=".$from."&DateTo=".$to."&EmployeeId=".$id."&PayrollGrp=".$PayrollGrp."&Signatory1=".$signatories."&UserName=".$UserName."&database=".$database; 
            $timestamp = microtime(true); 
            $forencrypt = $timestamp . "" . $id;
            $id2 = $this->authentication->f_endecrypt($forencrypt, 'e', $id);
            $finalid = str_replace("=", "", $id2);

            if ($this->authentication->add_link($finalid, $stringParams)) {
                $report_url = $this->authentication->get_report_url();
                echo "<script>
                        window.open('" . $report_url . $finalid . "', '_blank');
                        </script>";

            } else {
                echo "Unauthorized user now allowed";
                return;
            }
            // return;
        }

        return view('layouts.tabs.Reports.twenty_report',$data);
    }

    public function bir_form_2316()
    {

        $data['signatories'] = $this->authentication->sp_get_signatories([0]);  

          /*   $param = $this->Authentication->payslip_param($id);
            $stringParams = "reportSource=~/Reports/BIR2316FinalTax.rpt&YYYY=".$taxyear."&EmployeeId=".$id."&PayrollGrp=".$PayrollGrp."&Signatory1=".$signatories."&UserName=".$param['username']."&database=".$_SESSION['database']; 
            */
        if(isset($_POST['btn1'])){
            $database = Session::get('database');
            $id = Session::get('identityId');

            $params = $this->authentication->sp_get_payslip_param([$id]);
            $PayrollGrp = $params['rows'][0]->batchId;
            $taxyear = $_POST['txtTaxYear'];
            $signatories = $_POST['sigDDL'];
            $UserName = $params['rows'][0]->username;
            
            $stringParams = "reportSource=~/Reports/BIR2316FinalTax.rpt&YYYY=".$taxyear."&EmployeeId=".$id."&PayrollGrp=".$PayrollGrp."&Signatory1=".$signatories."&UserName=".$UserName."&database=".$database; 

            //echo "<script>alert('".json_encode($param)."')</script>";    
            $timestamp = microtime(true); 
            $forencrypt = $timestamp . "" . $id;
            $id2 = $this->authentication->f_endecrypt($forencrypt, 'e', $id);
            $finalid = str_replace("=", "", $id2);

            if ($this->authentication->add_link($finalid, $stringParams)) {
                $report_url = $this->authentication->get_report_url();
                echo "<script>
                        window.open('" . $report_url . $finalid . "', '_blank');
                        </script>";

            } else {
                echo "Unauthorized user now allowed";
                return;
            }
        }

        return view('layouts.tabs.Reports.bir_form_2316',$data);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //logout
    public function logout() { 
        $start  = microtime(true);
        $this->authentication->sp_userAuditTrails(1,'Logout','Success','User manually logout',$start); 
        
        if(!empty(session()->get('database'))){
                $this->DisconnectDB();  
                Session::flush();
                session::regenerate();
        }   
        return redirect()->route('login');

    }

    public function setSession(){
        $this->DisconnectDB();  
        $session_name = $_POST['sessionName'];
        $val = $_POST['val'];
        session()->put($session_name , value: $val);
    }
    

    public function selectDB(){
        $start  = microtime(true);
        $database = $_POST['db'];  
        session()->put('database', $database); 
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $database]);
        DB::reconnect('mysql');
        
        $companyPasswordSettings = $this->company_password->get_company_password_details(); 
        
        if ($companyPasswordSettings['enableCaptcha']==1){ 

            $num = Session::get('captcha_attemp') ?? 0;  
            date_default_timezone_set('Asia/Manila');
            $wait_until = Session::get('wait_until'); 
            $time_now = time(); 
            //echo $wait_until." vs ".$time_now;
            if ($num>=5 &&  $wait_until>$time_now){
                 $msg =  "<p style='color:red;'>Unable to generte captcha. Too many CAPTCHA requests. Please try again after: <b>".date("h:i:s A", $wait_until)."</b></p>";
                 $this->authentication->sp_userAuditTrails(1,'Login -> Captcha','Warning',$msg,$start);   
                 return $msg; 
            }else{ 
                $this->authentication->sp_userAuditTrails(1,'Login -> Captcha','Success','',$start);   
                return view('layouts.embed.captcha');
            } 
            
        }else{
            $this->authentication->sp_userAuditTrails(1,'Login -> Captcha','Info','Captcha is disabled',$start);   
            return false;
        }

       //$this->generate_captcha();
        
    }


    public function login_submit(){
        return 123;
    }


    public function verifyMFA(){ 
        $start  = microtime(true);
        $username = $_POST['username'];
        $otp = $_POST['otp'];
        $database = session()->get('database'); 
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $database]);
        DB::reconnect('mysql'); 
        $data['otpResult'] = $this->password_model->sp_portal_mfa([2,"otp",$otp,$username]);  
        $num = $data['otpResult']['num'];
        $msg = $data['otpResult']['msg'];
        if($num==1){
             $this->authentication->sp_userAuditTrails(1,'MFA -> Verification','Warning',$msg,$start); 
        }else{
             $this->authentication->sp_userAuditTrails(1,'MFA -> Verification','Success','',$start); 
        }
        return $data;
    }

    /* public function send_mfa(){
        $username = session()->get('username');  
        $database = session()->get('database'); 

        $user_agent = $this->password_model->get_userDevice(); 
        $newOTP = $this->authentication->generateOTP(6);
        $isMafActive = ($this->authentication->sp_portal_mfa_activation([0,$username])['rows'][0]->IsActive); 
        $user_details = $this->authentication->get_identity_sp([0, $username]); 
        $emailAddress = $user_details['rows'][0]->emailAddress;

        $OTP =  $newOTP['OTP'];
        $RefNo =  $newOTP['RefNo'];
        session()->put('otp', $OTP);
        session()->put('refno', $RefNo); 
        
        
        $data['mode'] = "maf";
        $data['refno'] = $RefNo;
        $data['otp'] = $OTP;
        $data['emailAddress'] = $emailAddress;
        $data['username'] = $username;
        $this->password_model->sp_portal_mfa([1,'otp',$OTP,$username]);

        return view('layouts.login', $data); 
    } */


    public function send_mfa(){
        $start  = microtime(true);
        $username = session()->get('username');  
        $database = session()->get('database'); 

        $user_agent = $this->password_model->get_userDevice(); 
        $newOTP = $this->authentication->generateOTP(6);
        
        $user_details = $this->authentication->get_identity_sp([0, $username]); 
        $emailAddress = $user_details['rows'][0]->emailAddress;

        $OTP =  $newOTP['OTP'];
        $RefNo =  $newOTP['RefNo'];
        session()->put('otp', $OTP);
        session()->put('refno', $RefNo); 
        
        
        $data['mode'] = "maf";
        $data['refno'] = $RefNo;
        $data['otp'] = $OTP;
        $data['emailAddress'] = $emailAddress;
        $data['username'] = $username;
        

        $Newemail['subject']="Pay Factor OTP"; 
        $Newemail['sendTo']=$emailAddress; 
        $Newemail['CcTo']=[]; 
        $Newemail['header']=["Dear User"]; 
        $Newemail['content']=["Please use this OTP <b><u>".$OTP."</u></b> for user password verefication. 
                            </br> Reference No.".$RefNo."</br>
                            </br>Please don't share this</br>
                            "]; 
        $Newemail['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
        
        $IsEmailSuccess = $this->authentication->sendEmail(new Request($Newemail));   
        
        if ($IsEmailSuccess==0){
            $msg = "Sending Email Failed for OTP. please contact administrator </br></br>   <center> <a href='/'>Back to login</a></center></br></br>";
            $this->authentication->sp_userAuditTrails(1,'MFA','Failed',$msg,$start); 
            return;
        }else{
            $this->password_model->sp_portal_mfa([1,'otp',$OTP,$username]);
            $this->authentication->sp_userAuditTrails(1,'MFA -> Send Email','Success','OTP Verification',$start); 
            return view('layouts.login', $data);  
        }  

        //return view('layouts.login', $data); 
    }

    public function addAuditTrails(Request $request){
        $start = microtime(true);
        $details = $request->input('details'); 
        $type = $request->input('type'); 
        $module = $request->input('module'); 
        $this->authentication->sp_userAuditTrails(1, $module, $type, $details, $start); 
        return 1; 
    }
  
    //login post
    public function login(Request $request){  
 
  
            $start  = microtime(true);
           
            if(session()->get('is_authenticated')){
                return redirect()->route('dash_cust'); 
            }
            
            $_SESSION["detailsApproverHistory"] = 0;
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'database' => 'required',
            ]);


            $username = $request->input('username');
            $password = $request->input('password');
            $database = $request->input('database');


            $setupIncomplete = $this->authentication->sp_kiosk_lookups([0]);  
            if(!empty($setupIncomplete['rows'][0]->error_msg)){  
                echo '<div style="background-color: #FA555A; padding:20px; color:white;width:500px">
                    <h1>Dear, Pay Factor Team</h1>

                    <div>The system cannot continue because the following errors were detected due to incomplete patching of SQL in production server:</div>
                
                    <div style="background-color:#4A3738; font-size:13px; padding:10px; margin-top:10px;margin-bottom:10px">'.$setupIncomplete['rows'][0]->error_msg.'</div>
                Please review and resolve these issues before attempting to proceed.
                </div>'; 
                return;
            } 
            
            session()->put('database', $database);

            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);
            DB::reconnect('mysql');

            //if password not encrypted or new registered using bulk upload
            $userdetails = $this->authentication->authenticate_account_per_user($username);
 
            if(count($userdetails)!==0){
                $isPassEncrypted =($this->authentication->f_endecrypt($userdetails['password'], 'd', $username));
                if($isPassEncrypted=="" || $userdetails['pStatus']=="D"){ 
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','New user / Password need to update',$start); 
                    session()->put('passwordStatus', 'new');
                    session()->put('username', $username);
                    return redirect()->route('new_password');
                }
            }


            $companyPasswordSettings = $this->company_password->get_company_password_details();
            $captchaCode = $request->input('captcha_code') ?? null;

    
            if (isset($companyPasswordSettings['enableCaptcha']) && $captchaCode==null) {
                $this->authentication->sp_userAuditTrails(1,'Login','Warning','Captha Required',$start); 
                return redirect()->route('login')->withErrors(provider: ['password' => 'Captch is required']);  
            }
            
            if ($captchaCode) {
                $correctCaptcha = Session::get('captcha') ?? null;
                if ($captchaCode != $correctCaptcha) {  
                    $this->authentication->setCaptchaAttempt(1);
                    $num = session()->get('captcha_attemp'); 
                    $wait_until = session()->get('wait_until'); 
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','Incorrect Captha',$start); 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Incorrect captcha. '.$num.' attempt(s)']); 
                }else{
                    session()->put('multi', value : null);
                    $this->authentication->setCaptchaAttempt(0);
                }
            }  
             

            $e_username = $this->authentication->f_endecrypt($username, 'e', $username);
            $e_password = $this->authentication->f_endecrypt($password, 'e', $username);
            

            $iAddress = $this->authentication->getIPAddress();
            
            $companyPasswordSettings['password'] = $this->authentication->f_endecrypt($companyPasswordSettings['password'], 'd', 'ftsi');
            $default_mailer = $this->authentication->sp_get_default_mailer([0]);

            session()->put('companyPasswordSettings', value: $companyPasswordSettings);
            
            $default_mailer['rows'][0]->smtp_pass = $this->authentication->f_endecrypt($default_mailer['rows'][0]->smtp_pass, 'd', 'ftsi');
            session()->put('default_mailer', value: $default_mailer['rows'][0]);
            
            
            $data['authenticate'] = $this->authentication->authenticate_account($username, $e_password);
            $data['user_exists'] = $this->authentication->check_if_username_exists($username);
            session()->put('username', $username);
            
            if(empty($data['user_exists'])){
             $this->authentication->sp_userAuditTrails(1,'Login','Warning','Invalid Username:'.$username.' or Password ???',$start); 
             return redirect()->route('login')->withErrors(provider: ['password' => 'Invalid Username or Password!']); 
            }
    
         
            // ***************************** lockout feature ******************* 
            $attempt = $this->password_model->sp_portal_get_lock_attempt($username);  
            $attempt = $attempt['rows'][0]->attempts;
            
            
            $lockoutType = $this->password_model->sp_portal_get_lockedOutRecoveryType();
            $lockoutType = $lockoutType['rows'][0]->lockedOutRecoveryType;

            $is_already_locked = $this->password_model->get_employee_lockout_auto_status($username);
  
            
            if($is_already_locked){  // if access already locked 
                $this->authentication->sp_userAuditTrails(1,'Login','Warning',"Account Locked with attempt count -> ".($attempt+1),$start);
                if ($lockoutType == 'auto') { 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Account Locked Please Try Again Later.']);
                }else{ 
                   return redirect()->route('login')->withErrors(provider: ['password' => 'Your account has been locked out. Contact your system admin.']);
                } 
            } 
             

            if (!empty($data['authenticate'])) {

                $is_already_locked = $this->password_model->get_employee_lockout_auto_status($username); 
                if($is_already_locked){  // if access already locked 
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning',"Account Locked with attempt count -> ".($attempt+1),$start);
                    if ($lockoutType == 'auto') { 
                        return redirect()->route('login')->withErrors(provider: ['password' => 'Account Locked Please Try Again Later.']);
                    }else{ 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Your account has been locked out. Contact your system admin.']);
                    } 
                } 


                $passwordReuseCount = $this->password_model->sp_portal_get_user_password_logs($username, $e_password);

                $passwordReuseCountString = $passwordReuseCount['rows'][0]->passwordCount;

                if ($passwordReuseCountString == 0 || $passwordReuseCountString == null) {
                    $this->password_model->sp_portal_insert_password_logs($username, $e_password);

                }
                 
                $isExpired = $this->password_model->isPasswordExpired($username);
                if ($isExpired) {
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','Password Expired',$start); 
                    session()->put('username', $username);
                    session()->put('passwordStatus', 'expired');
                    return redirect()->route('new_password');
                }
                
                 
                if ($data['authenticate']['pStatus'] == 'T') { 
                     $this->authentication->sp_userAuditTrails(1,'Login','Warning','Account Inactive',$start); 
                     return redirect()->route('login')->withErrors(provider: ['password' => 'Account Inactive.']);
                }
                
                if ($data['authenticate']['usertype'] == "user") {

                    
                    session()->put('sub_applications', value: $this->authentication->sp_pf_common_sub_app_license([0,'',$database]));

                    if(empty($this->authentication->get_identity($data['authenticate']['identityid']))){
                       $this->authentication->sp_userAuditTrails(1,'Login','Warning','Successfully login but no identity created!',$start); 
                       return redirect()->route('login')->withErrors(provider: ['password' => 'Successfully login but no identity created! please contact HR.']);
                    }
                
                    $data['identity'] = $this->authentication->get_identity($data['authenticate']['identityid']);
                    session()->put('identityId', value: $data['identity']['identityId']);

                    session()->put('te_aprroval_count', value: 0);
                    session()->put('ot_aprroval_count', value: 0);
                    session()->put('leave_aprroval_count', value: 0);
                    session()->put('ta_aprroval_count', value: 0);
                    session()->put('ob_aprroval_count', value: 0);
                    session()->put('os_aprroval_count', value: 0);
                    session()->put('sc_aprroval_count', value: 0);
                    session()->put('hrd_aprroval_count', value: 0);
                    session()->put('otExt_aprroval_count', value: 0);
                    session()->put('app_time_interval', value: 1000); 
                    session()->put('companyName', value:  $companyPasswordSettings['companyName']); 

                    session()->put('emailHost', value: $companyPasswordSettings['smtpHost']);
                    session()->put('emailPort', value: $companyPasswordSettings['smtpPort']);
                    session()->put('emailFrom', value: $companyPasswordSettings['defaultSenderName']);

                    session()->put('fullname', value: $data['identity']['firstName'] . " " . $data['identity']['lastName']);
                    session()->put('batchId', value: $data['identity']['batchId']);
                    session()->put('password', value: $password);
                    session()->put('encrypted_password', value: $e_password);

                    //check On init
                    //if change on init s required and user is first time login
                    $pStatus = $data['authenticate']['pStatus'];
                    $changeOnInit = $this->password_model->sp_portal_get_passwordChangeInitLogon();
                    $changeOnInitString = $changeOnInit['rows'][0]->passwordChangeInitLogon;
                    
                    
                    if ($pStatus == 'D' && $changeOnInitString == 1) {
                        $this->authentication->sp_userAuditTrails(1,'Login','Warning','New user / Password need to update',$start); 
                        session()->put('passwordStatus', 'new');
                        session()->put('username', $username);
                        return redirect()->route('new_password');
                    }

                    //session()->put('approver1', value: $this->authentication->sp_approval_get_authorizer([0, 1, $username]));
                    session()->put('access_rights', value: $this->authentication->sp_approver_get_priviledge());
    
                    $user_details = $this->authentication->get_identity_sp([0, $username]);
 
                    session()->put('if_approver', $user_details['rows'][0]->if_approver);
                    session()->put('faceDetails', $user_details['rows'][0]->faceDetails);

                    // return redirect()->route('new_password');
                    $deleteFaieldLogin = $this->password_model->sp_portal_update_user_attempt($username);
                    $events = $this->calendar_model->load_sched_advanced(0,$username,'','');  
                    
                    if (!empty($deleteFaieldLogin) && isset($deleteFaieldLogin['num']) && $deleteFaieldLogin['num'] == 0) {
                     
                        session()->put('yearSched', date("Y"));  
                        session()->put('currentEvents',$events);  
                        session()->put('dash_edit_mode',0);  
                        session()->put('currentUrl',$this->getBaseUrl());  
                        session()->put('username', $username);

                        $isMafActive = ($this->authentication->sp_portal_mfa_activation([0,$username])['rows'][0]->IsActive); 
                        if($isMafActive){
                            $this->authentication->sp_userAuditTrails(1,'Login','info','MFA Activated',$start); 
                            return $this->send_mfa();
                        }else{

                        //HRIS APPROVAL START
                            $hrisApproval = $this->HRIS_Approval_model->sp_portal_get_hris_approval_template([1, $username]);
                            $rows = $hrisApproval['rows'] ?? [];
                    
                            $hriaApprovalValue = 0;
                            $mergedDetails = [];
                    
                            foreach ($rows as $row) {
                                // OR the top-level approval flag across all rows
                                if (!empty($row->HRISApproval)) {
                                    $hriaApprovalValue = 1;
                                }
                    
                                if (!empty($row->HRISApprovalDetails)) {
                                    $decoded = json_decode($row->HRISApprovalDetails, true);
                                    if (is_array($decoded)) {
                                        $mergedDetails = empty($mergedDetails)
                                            ? $decoded
                                            : $this->mergeHrisDetails($mergedDetails, $decoded);
                                    }
                                }
                            }
                    
                            $HRISApprovalDetailsValue = !empty($mergedDetails) ? json_encode($mergedDetails) : 0;
                    
                            session()->put('have_hris', $hriaApprovalValue);
                            session()->put('have_hris_details', $HRISApprovalDetailsValue);
                        //HRIS APPROVAL END


                           $this->authentication->sp_userAuditTrails(1,'Login','Success','',$start); 
                           return $this->goto_Dashboard();
                        } 
                        //return redirect()->route('dash_cust');         
                    }


                } else {
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning','User need to login in admin side',$start); 
                    return redirect()->route('login')->withErrors(provider: ['password' => 'Use admin login.']);
                    // return back()->withErrors(['password' => 'Use admin login.']);
                }

            } else {

                //password failed login
                //insert pf-common user failed login table
                $failedLogin = $this->password_model->sp_portal_insert_failed_login($username, $e_password, $database, $attempt + 1, $iAddress);

                // //update users table
                $this->password_model->sp_portal_update_user_attempt_lock($username, $attempt + 1);

                if (!empty($failedLogin) && isset($failedLogin['num']) && $failedLogin['num'] == 0) {
                    $logAttempts =$companyPasswordSettings['logAttempts'];
                    $logs = $this->password_model->sp_portal_get_failed_login($username);
                    $attempt_count = $logs['rows'][0]->attempts;  
                    $lockMsg = ($attempt_count>=$logAttempts) ? "Your account has been locked for manny log attemps" : 'Incorrect username or password. attempt(s) count '.$attempt_count."/".$logAttempts;
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning',$lockMsg,$start); 
                    return redirect()->route('login')->withErrors(['password' =>$lockMsg]);
                    
                } else {
                    $this->authentication->sp_userAuditTrails(1,'Login','Warning',"Unkwon System Error",$start); 
                    return redirect()->route('login')->withErrors(['password' => 'Error occured.']); 
                }


            }
       
    }

    public function mergeHrisDetails(array $a, array $b): array
    {
        foreach ($b as $key => $value) {
            if (!array_key_exists($key, $a)) {
                $a[$key] = $value;
                continue;
            }
 
            if (is_array($value) && is_array($a[$key])) {
                $a[$key] = $this->mergeHrisDetails($a[$key], $value);
            } elseif (is_bool($value) && is_bool($a[$key])) {
                $a[$key] = $a[$key] || $value; // true beats false/null
            } else {
                $a[$key] = $value ?: $a[$key];
            }
        }
 
        return $a;
    }

    public function gotoFaceRecognizer(){
      
        $data['mode'] = $_POST['mode'];

        if(empty(session()->get('database'))){  
            if(empty($_POST['database'])){
                echo "<script>alert('No database selected!');</script>"; 
                //echo "<div class='db_alert'>No database selected!</div>";
                return;
            }
            session()->put('database', $_POST['database']);
        } 
        if(empty(session()->get('username'))){ 
            session()->put('username',"n/a");  
        }  
        return view('layouts.faceRecognize.index',$data);
    }

    public function goto_Dashboard(){
        session()->put('is_authenticated', true);
        return redirect()->route('dash_cust');
    }

    public function getBaseUrl() { 
        return env('APP_URL');
    }
 
    public function generate_captcha()
    {

        // Rate Limiting Settings
        $max_requests = 5; // Maximum allowed requests within the time frame
        $request_window = 60; // Time frame in seconds
        $wait_time = 60;

        // Initialize session variables if not set
        if (!Session::has('captcha_requests')) {
            Session::put('captcha_requests', 0);
            Session::put('captcha_available', true);
        }

        if (!Session::has('last_captcha_time')) {
            Session::put('last_captcha_time', time());
        }

        // Check if the time window has expired
        if (time() - Session::get('last_captcha_time') > $request_window) {
            // Reset the request count
            Session::put('captcha_requests', 0);
            Session::put('last_captcha_time', time());
        }

        // Check if the user has exceeded the maximum number of requests
        if (Session::get('captcha_requests') >= $max_requests) {
            Session::put('captcha_available', false);
            Session::put('wait_until', time() + $wait_time);

            return response()->json(['code' => 0], 429); // Too Many Requests
        }

        // Increment request count
        Session::increment('captcha_requests');

        // Generate random text for CAPTCHA
        $captcha_text = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz'), 0, 6);
        Session::put('captcha', $captcha_text);

        // Create the image
        $image_width = 150;
        $image_height = 50;
        $image = imagecreate($image_width, $image_height);

        // Define colors
        $bg_color = imagecolorallocate($image, 255, 255, 255); // white background
        $text_color = imagecolorallocate($image, 0, 0, 0);     // black text
        $noise_color = imagecolorallocate($image, 100, 100, 100); // gray noise
        $line_color = imagecolorallocate($image, 50, 50, 50); // darker gray for lines

        // Add background noise
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand(0, $image_width), rand(0, $image_height), $noise_color);
        }

        // Add random lines
        for ($i = 0; $i < 5; $i++) {
            imageline($image, rand(0, $image_width), rand(0, $image_height), rand(0, $image_width), rand(0, $image_height), $line_color);
        }

        $font_path = resource_path('asset/Roboto-Italic.ttf');

        $font_size = 20; // Adjust the font size accordingly
        $x = 10; // Starting x position for the text
        $y = 30; // Base y position for the text


        // Add the text with TTF font
        for ($i = 0; $i < strlen($captcha_text); $i++) {
            $char = $captcha_text[$i];
            $y_offset = rand(-5, 5); // Random vertical offset for distortion
            imagettftext($image, $font_size, 0, $x, $y + $y_offset, $text_color, $font_path, $char);
            $x += 25; // Adjust spacing between characters
        }

        ///////////////////////////////////////////////////////////////////////

        // Output the image
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
 
   
    public function change_password(Request $request) 
    {
        $identityId = session()->get('identityId'); 
        $data['user_details'] = $this->authentication->get_identity_sp([0, $identityId]);  
        $start  = microtime(true);

        if ($request->isMethod('post')) { 
            $encryptedPassword = session()->get('encrypted_password');
            $enableComplexity = $this->password_model->sp_portal_get_passwordComplexity();
            $isEnabledComplexity = $enableComplexity['rows'][0]->passwordComplexEnabled;


            $passwordLength = $this->password_model->sp_portal_get_passwordLength();
            $passwordLengthString = $passwordLength['rows'][0]->passwordLength ?? 10; // Default to 10 if not set
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => ['required', "min:$passwordLengthString"],
                'newPassword2' => 'required|same:newPassword',
            ]);
            $e_currentPassword = $this->authentication->f_endecrypt($request->currentPassword, 'e', $identityId);
            $e_password = $this->authentication->f_endecrypt($request->newPassword, 'e', $identityId);


            if ($encryptedPassword != $e_currentPassword) {
                $this->authentication->sp_userAuditTrails(1,'Change Password','Failed','Incorrect current password',$start);  
                return back()->withErrors(['currentPassword' => 'Incorrect current password']); 
            }

            if ($encryptedPassword == $e_password) {
                $this->authentication->sp_userAuditTrails(1,'Change Password','Failed','New password must be different from the old one',$start);  
                return back()->withErrors(['newPassword' => 'New password must be different from the old one.']);
            }


            if ($isEnabledComplexity) {
                $passwordComplexity = $this->password_model->password_complexity($request->newPassword);
                if (!$passwordComplexity) {
                    $this->authentication->sp_userAuditTrails(1,'Change Password','Failed','Password does not meet complexity requirements. It must have at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least ' . $passwordLengthString . ' characters long.',$start);  
                    return back()->withErrors(['newPassword' => 'Password does not meet complexity requirements. It must have at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least ' . $passwordLengthString . ' characters long.']);
                }
            }
            // echo $passwordComplexity;
            // return ;
            $passwordReuseCount = $this->password_model->sp_portal_get_user_password_logs($identityId, $e_password);
            $passwordReuseCountString = $passwordReuseCount['rows'][0]->passwordCount;

            $passwordReuseRestriction = $this->password_model->sp_portal_get_passwordReuseRestriction();
            $passwordReuseRestrictionString = $passwordReuseRestriction['rows'][0]->passwordReuseRestriction;



            if ($passwordReuseCountString > $passwordReuseRestrictionString) {
                $this->authentication->sp_userAuditTrails(1,'Change Password','Failed','Password has been reused too frequently. Please choose a new password.',$start);  
                return back()->withErrors(['newPassword' => 'Password has been reused too frequently. Please choose a new password.']);
            } else {
                $this->password_model->sp_portal_insert_password_logs($identityId, $e_password);
                $updatePassword = $this->password_model->sp_portal_update_user_password($identityId, $e_password);

                // print_r(  $updatePassword);
                // return;
                // $updatePasswordString = $updatePassword['rows'][0]->
                if (!empty($updatePassword) && isset($updatePassword['num']) && $updatePassword['num'] == 0) {
                    session()->put('encrypted_password', value: $e_password);
                    $this->authentication->sp_userAuditTrails(1,'Change Password','Success','Password updated successfully',$start);  
                    return back()->with('success', 'Password updated successfully');
                } else {
                    $this->authentication->sp_userAuditTrails(1,'Change Password','Warning','Error while updating password.',$start);  
                    return back()->withErrors(['newPassword' => 'Error while updating password.']);
                }

            }
            
        }

        return view('layouts.tabs.change_password',$data);
    }
 

    public function new_password(Request $request)
    {  
        $data['username'] = session()->get('username');
        
        return view('layouts.tabs.new_password', $data);
    }
 

     /*******    START OF HRIS APPROVAL - RAY       **************/

    private function transformNewData($res00)
    {
        $requestNo = [];
        $personalInfo = [];

        foreach ($res00 as $key => $val) {

            unset($val->dateCreated, $val->dateUpdated, $val->createdBy, $val->updatedBy);

            foreach ($val as $col => $value) {
                if ($value === 'match') {
                    unset($val->$col);
                }
            }

            $arr = (array) $val;
            $val->arrCount = count($arr);

            if (count($arr) >= 6 && isset($val->Request_No)) {
                $personalInfo[$key] = $val;
            }
        }

        $personalInfo = array_filter($personalInfo);

        return !empty($personalInfo) ? $personalInfo : null;
    }
    private function transformOldData($res01)
    {
        foreach ($res01 as $key => $val) {

            unset(
                $val->dateCreated,
                $val->dateUpdated,
                $val->createdBy,
                $val->updatedBy,
                $val->Employee_Code,
                $val->Employee_Id
            );

            foreach ($val as $col => $value) {
                if ($value === 'match') {
                    unset($val->$col);
                }
            }

            $arr = (array) $val;

            if (count($arr) == 2) {
                unset($val->Employee_Code);
                unset($val->Employee_Id);
            }
        }

        $personalInfo2 = array_filter($res01);

        return !empty($personalInfo2) ? $personalInfo2 : null;
    }

    public function show_hris_approval_personalinformation()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $personalInformationChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([1, $identityId]);
        $data['personalInformation'] = $personalInformationChangelogs['rows'] ?? NULL;

        //  $personalInformationHistory = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([1,$identityId]);
        // $data['personalInformationHistory'] = $personalInformationHistory['rows'] ?? NULL;

        // return $data['personalInformation'];
        return view('layouts.tabs.hrisApproval.personal_information.personal_information_hris_approval', $data);
    }

    public function hris_approval_personalinformation_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        // Get pending changes (new data)
        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([1, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        // Get history (old data)
        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([1, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];

        // Transform NEW data (Changelogs)
        $personalInformationNew = $this->transformNewData($res00);

        // Transform OLD data (History)
        $personalInformationOld = $this->transformOldData($res01);
        // return [$personalInformationOld , $personalInformationNew];

        return view('layouts.tabs.hrisApproval.personal_information.personal_information_hris_approval_view', [
            'personalInformationNew' => $personalInformationNew,
            'personalInformationOld' => $personalInformationOld,
            'identityId' => $identityId
        ]);
    }

    public function submit_hris_approval_personalinformation(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];

        try {
            // Determine which method to call based on action
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    1,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);
                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                return $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    1,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                return;

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]); // 200 status by default
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]); // 200 status
                }
            }

            // If we reach here, something failed
            return response()->json([
                'success' => false,
                'message' => 'Failed to process request'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request'
            ], 500);
        }
    }

    public function submit_hris_approval_personalinformation_bulk(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.request_no' => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action = $validated['action'];
        $items = $validated['items'];

        $successCount = 0;
        $errors = [];

        foreach ($items as $item) {
            $requestNo = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        1,
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        1,
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no' => $requestNo,
                        'employee_id' => $employeeId,
                        'message' => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Approval Error: ' . $e->getMessage(), [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'action' => $action
                ]);

                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success' => $allSucceeded,
            'message' => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count' => $totalCount,
            'errors' => $errors
        ]);
    }

    public function show_hris_approval_dependent()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $dependentChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([2, $identityId]);
        $data['dependent'] = $dependentChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.dependent.dependent_hris_approval', $data);
    }
    public function hris_approval_dependent_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([2, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([2, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];

        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.dependent.dependent_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_depedent(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];

        try {
            // Determine which method to call based on action
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    2,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]); // 200 status by default
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]); // 200 status - let frontend handle the success: false
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    2,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]); // 200 status by default
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]); // 200 status
                }
            }

            // If we reach here, action was invalid
            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]); // 200 status

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]); // 200 status - errors handled in success callback
        }
    }

    public function submit_hris_approval_dependent_bulk(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.request_no' => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action = $validated['action'];
        $items = $validated['items'];

        $successCount = 0;
        $errors = [];

        foreach ($items as $item) {
            $requestNo = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        2,         // <-- dependent type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        2,         // <-- dependent type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no' => $requestNo,
                        'employee_id' => $employeeId,
                        'message' => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Dependent Approval Error: ' . $e->getMessage(), [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'action' => $action
                ]);

                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success' => $allSucceeded,
            'message' => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count' => $totalCount,
            'errors' => $errors
        ]);
    }

    public function show_hris_approval_contacts()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $contactsChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([3, $identityId]);
        $data['contacts'] = $contactsChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.contacts.contacts_hris_approval', $data);
    }
    public function hris_approval_contacts_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([3, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([3, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];

        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.contacts.contacts_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_contacts(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];

        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    3,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    3,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }
    public function submit_hris_approval_contacts_bulk(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.request_no' => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action = $validated['action'];
        $items = $validated['items'];

        $successCount = 0;
        $errors = [];

        foreach ($items as $item) {
            $requestNo = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        3,  // <-- contacts type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        3,  // <-- contacts type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no' => $requestNo,
                        'employee_id' => $employeeId,
                        'message' => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Contacts Approval Error: ' . $e->getMessage(), [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'action' => $action
                ]);

                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success' => $allSucceeded,
            'message' => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count' => $totalCount,
            'errors' => $errors
        ]);
    }

    public function show_hris_approval_education()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $educationChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([4, $identityId]);
        $data['education'] = $educationChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.education.education_hris_approval', $data);
    }
    public function hris_approval_education_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([4, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([4, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];

        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.education.education_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_education(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    4,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    4,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_education_bulk(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.request_no' => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action = $validated['action'];
        $items = $validated['items'];

        $successCount = 0;
        $errors = [];

        foreach ($items as $item) {
            $requestNo = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        4,  // <-- education type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        4,  // <-- education type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no' => $requestNo,
                        'employee_id' => $employeeId,
                        'message' => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Education Approval Error: ' . $e->getMessage(), [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'action' => $action
                ]);

                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success' => $allSucceeded,
            'message' => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count' => $totalCount,
            'errors' => $errors
        ]);
    }

    public function show_hris_approval_employmenthistory()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $employmenthistoryChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([5, $identityId]);
        $data['employmenthistory'] = $employmenthistoryChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.employmenthistory.employmenthistory_hris_approval', $data);
    }
    public function hris_approval_employmenthistory_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([5, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([5, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];

        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.employmenthistory.employmenthistory_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_employmenthistory(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    5,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    5,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_employmenthistory_bulk(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.request_no' => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action = $validated['action'];
        $items = $validated['items'];

        $successCount = 0;
        $errors = [];

        foreach ($items as $item) {
            $requestNo = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        5,  // <-- employment history type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        5,  // <-- employment history type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no' => $requestNo,
                        'employee_id' => $employeeId,
                        'message' => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Employment History Approval Error: ' . $e->getMessage(), [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'action' => $action
                ]);

                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success' => $allSucceeded,
            'message' => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count' => $totalCount,
            'errors' => $errors
        ]);
    }

    public function show_hris_approval_leavecredit()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $leavecreditChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([6, $identityId]);
        $data['leavecredit'] = $leavecreditChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.leavecredit.leavecredit_hris_approval', $data);
    }
    public function hris_approval_leavecredit_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([6, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([6, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.leavecredit.leavecredit_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_leavecredit(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    6,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    6,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_leavecredit_bulk(Request $request)
{
    $validated = $request->validate([
        'items' => 'required|array|min:1',
        'items.*.request_no' => 'required|string',
        'items.*.employee_id' => 'required|string',
        'action' => 'required|in:approve,disapprove'
    ]);

    $identityId = session()->get('identityId');
    $action = $validated['action'];
    $items = $validated['items'];

    $successCount = 0;
    $errors = [];

    foreach ($items as $item) {
        $requestNo = $item['request_no'];
        $employeeId = $item['employee_id'];

        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    6,  // <-- leave credit type ID
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);
            } else {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    6,  // <-- leave credit type ID
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);
            }

            if ($result) {
                $successCount++;
            } else {
                $errors[] = [
                    'request_no' => $requestNo,
                    'employee_id' => $employeeId,
                    'message' => 'Failed to process request'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Bulk Leave Credit Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            $errors[] = [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'message' => 'An error occurred while processing this request'
            ];
        }
    }

    $totalCount = count($items);
    $allSucceeded = $successCount === $totalCount;

    return response()->json([
        'success' => $allSucceeded,
        'message' => $allSucceeded
            ? "Successfully processed all {$totalCount} request(s)."
            : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
        'success_count' => $successCount,
        'total_count' => $totalCount,
        'errors' => $errors
    ]);
}

    public function show_hris_approval_earnings()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $earningsChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([7, $identityId]);
        $data['earnings'] = $earningsChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.earnings.earnings_hris_approval', $data);
    }
    public function hris_approval_earnings_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([7, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([7, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.earnings.earnings_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_earnings(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    7,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    7,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }
    public function submit_hris_approval_earnings_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        7,          // <-- earnings type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        7,          // <-- earnings type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Earnings Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_deductions()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $deductionsChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([8, $identityId]);
        $data['deductions'] = $deductionsChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.deductions.deductions_hris_approval', $data);
    }
    public function hris_approval_deductions_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([8, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([8, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.deductions.deductions_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_deductions(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    8,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    8,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_deductions_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        8,          // <-- deductions type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        8,          // <-- deductions type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Deductions Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_bankaccounts()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $bankaccountsChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([9, $identityId]);
        $data['bankaccounts'] = $bankaccountsChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.bankaccounts.bankaccounts_hris_approval', $data);
    }
    public function hris_approval_bankaccounts_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([9, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([9, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.bankaccounts.bankaccounts_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_bankaccounts(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    9,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    9,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_bankaccounts_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        9,          // <-- bank accounts type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        9,          // <-- bank accounts type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Bank Accounts Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_accountability()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $accountabilityChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([10, $identityId]);
        $data['accountability'] = $accountabilityChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.accountability.accountability_hris_approval', $data);
    }
    public function hris_approval_accountability_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([10, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([10, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.accountability.accountability_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_accountability(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    10,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    10,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_accountability_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        10,         // <-- accountability type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        10,         // <-- accountability type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Accountability Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_medicalrecords()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $medicalrecordsChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([11, $identityId]);
        $data['medicalrecords'] = $medicalrecordsChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.medicalrecords.medicalrecords_hris_approval', $data);
    }
    public function hris_approval_medicalrecords_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([11, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([11, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $historyResult;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.medicalrecords.medicalrecords_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_medicalrecords(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    11,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    11,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }
    public function submit_hris_approval_medicalrecords_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        11,         // <-- medical records type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        11,         // <-- medical records type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Medical Records Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_seminarattended()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $seminarattendedChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([12, $identityId]);
        $data['seminarattended'] = $seminarattendedChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.seminarattended.seminarattended_hris_approval', $data);
    }
    public function hris_approval_seminarattended_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([12, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([12, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $historyResult;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.seminarattended.seminarattended_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_seminarattended(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    12,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    12,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_seminarattended_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        12,         // <-- seminar attended type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        12,         // <-- seminar attended type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Seminar Attended Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_biometricsinfo()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $biometricsinfoChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([13, $identityId]);
        $data['biometricsinfo'] = $biometricsinfoChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.biometricsinfo.biometricsinfo_hris_approval', $data);
    }
    public function hris_approval_biometricsinfo_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([13, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([13, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.biometricsinfo.biometricsinfo_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_biometricsinfo(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    13,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    13,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_biometricsinfo_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId   = session()->get('identityId');
        $action       = $validated['action'];
        $items        = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        13,         // <-- biometrics info type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        13,         // <-- biometrics info type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Biometrics Info Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }

    public function show_hris_approval_employeemovement()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $employeemovementChangelogs = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_list([14, $identityId]);
        $data['employeemovement'] = $employeemovementChangelogs['rows'] ?? NULL;

        return view('layouts.tabs.hrisApproval.employeemovement.employeemovement_hris_approval', $data);
    }
    public function hris_approval_employeemovement_view(Request $request)
    {
        $identityId = session()->get('identityId');
        $requestNo = $request->formNo;
        $employeeId = $request->identityId;

        $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_view([14, $identityId, $requestNo, $employeeId]);
        $res00 = $result['rows'] ?? [];

        $historyResult = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_history([14, $identityId, $requestNo, $employeeId]);
        $res01 = $historyResult['rows'] ?? [];
        // return $result;
        $new = $this->transformNewData($res00);
        $old = $this->transformOldData($res01);
        return view('layouts.tabs.hrisApproval.employeemovement.employeemovement_hris_approval_view', [
            'new' => $new,
            'old' => $old,
            'identityId' => $identityId
        ]);
    }
    public function submit_hris_approval_employeemovement(Request $request)
    {
        $validated = $request->validate([
            'request_no' => 'required|string',
            'employee_id' => 'required|string',
            'action' => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $requestNo = $validated['request_no'];
        $employeeId = $validated['employee_id'];
        $action = $validated['action'];
        try {
            if ($action === 'approve') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                    14,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                // return $result;
                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully approved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to approve request. Please try again.'
                    ]);
                }
            } elseif ($action === 'disapprove') {
                $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                    14,
                    $requestNo,
                    $identityId,
                    $employeeId
                ]);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Request successfully disapproved!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to disapprove request. Please try again.'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid action specified'
            ]);

        } catch (\Exception $e) {
            \Log::error('Approval Error: ' . $e->getMessage(), [
                'request_no' => $requestNo,
                'employee_id' => $employeeId,
                'action' => $action
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage()
            ]);
        }
    }

    public function submit_hris_approval_employeemovement_bulk(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.request_no'  => 'required|string',
            'items.*.employee_id' => 'required|string',
            'action'              => 'required|in:approve,disapprove'
        ]);

        $identityId = session()->get('identityId');
        $action     = $validated['action'];
        $items      = $validated['items'];

        $successCount = 0;
        $errors       = [];

        foreach ($items as $item) {
            $requestNo  = $item['request_no'];
            $employeeId = $item['employee_id'];

            try {
                if ($action === 'approve') {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_approve([
                        14,         // <-- employee movement type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                } else {
                    $result = $this->HRIS_Approval_model->sp_portal_get_hris_for_approval_disapprove([
                        14,         // <-- employee movement type ID
                        $requestNo,
                        $identityId,
                        $employeeId
                    ]);
                }

                if ($result) {
                    $successCount++;
                } else {
                    $errors[] = [
                        'request_no'  => $requestNo,
                        'employee_id' => $employeeId,
                        'message'     => 'Failed to process request'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Bulk Employee Movement Approval Error: ' . $e->getMessage(), [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'action'      => $action
                ]);

                $errors[] = [
                    'request_no'  => $requestNo,
                    'employee_id' => $employeeId,
                    'message'     => 'An error occurred while processing this request'
                ];
            }
        }

        $totalCount   = count($items);
        $allSucceeded = $successCount === $totalCount;

        return response()->json([
            'success'       => $allSucceeded,
            'message'       => $allSucceeded
                ? "Successfully processed all {$totalCount} request(s)."
                : "Processed {$successCount} of {$totalCount} request(s). " . count($errors) . ' failed.',
            'success_count' => $successCount,
            'total_count'   => $totalCount,
            'errors'        => $errors
        ]);
    }






    /*******    END OF HRIS APPROVAL - RAY       **************/



    /*******    START OF CLEARANCE - RAY       **************/

    public function show_clearance_form()
    {
        $identityId = session()->get('identityId');
        $result = $this->clearance_model->sp_clearance_get_form([0]);
        $data['headers'] = $result['rows'];
        $resultListHeader = $this->clearance_model->sp_clearance_get_header_info([1, $identityId]);
        $data['headerData'] = $resultListHeader['rows'];
        $resultList = $this->clearance_model->sp_clearance_get_form_list([1, $identityId]);
        $data['list'] = $resultList['rows'];

        $resultList = $this->clearance_model->sp_clearance_get_form_list([4, $identityId]);
        $grouped = [];
        foreach ($resultList['rows'] as $row) {
            $grouped[$row->cfDeptCode][] = $row;
        }

        $data['list2'] = $grouped;

        $resultList2 = $this->clearance_model->sp_clearance_get_form_list([5, $identityId]);
        $grouped2 = [];
        foreach ($resultList2['rows'] as $row) {
            $grouped2[$row->cfDeptCode][] = $row;
        }

        $data['list3'] = $grouped2;
        // $data['list2'] = $resultList['rows']; 

        $resultListAck = $this->clearance_model->sp_clearance_get_form_list([2, $identityId]);
        $data['isAcknowledge'] = $resultListAck['rows'][0]->cfAcknowledgeTag;


        // return $resultListHeader;
        $tin = $this->clearance_model->sp_clearance_get_tin([0, $identityId]);
        $data['tin'] = $tin['rows'];


        return view('layouts.tabs.request.request_form.clearance_form', $data);
    }

    public function show_clearance_approval()
    {
        $identityId = session()->get('identityId');

        $clearanceList = $this->clearance_model->sp_get_clearance_for_approval([1, $identityId]);
        $data['clearanceList'] = $clearanceList['rows'];
        $clearanceListHistory = $this->clearance_model->sp_get_clearance_for_approvalHistory([1, $identityId]);
        $data['clearanceListHistory'] = $clearanceListHistory['rows'];
        $clearanceListHR = $this->clearance_model->sp_get_clearance_for_hr([1]);
        $data['clearanceListHR'] = $clearanceListHR['rows'];
        return view('layouts.tabs.forApproval.clearance', $data);

    }

    public function show_clearance_approval_hr(Request $request)
    {
        $identityId = session()->get('identityId');

        $appno = $request->appno;
        $cfID = $request->cfid;


        $identityId = session()->get('identityId');


        $result = $this->clearance_model->sp_clearance_get_form([0]);
        $data['headers'] = $result['rows'];

        $resultList = $this->clearance_model->sp_clearance_get_form_list([1, $cfID]);
        $data['list'] = $resultList['rows'];


        $resultListHeader = $this->clearance_model->sp_clearance_get_header_info([1, $cfID]);
        $data['headerData'] = $resultListHeader['rows'];
        $tin = $this->clearance_model->sp_clearance_get_tin([0, $cfID]);
        $data['tin'] = $tin['rows'];
        return view('layouts.tabs.forApproval.detailed_form.clearance_approval_view', $data);
    }

    public function show_clearance_hr_view()
    {
        $identityId = session()->get('identityId');

        $clearanceListHR = $this->clearance_model->sp_get_clearance_for_hr([1]);
        $data['clearanceListHR'] = $clearanceListHR['rows'];
        return view('layouts.tabs.forApproval.clearance_hr', $data);

    }
    public function show_clearance_approval_details(Request $request)
    {

        $identityId = session()->get('identityId');
        $appno = $request->appno;
        $cfid = $request->cfid;
        $data['identityId'] = $identityId;
        $data['id'] = $cfid;
        $data['cfAppNo'] = $appno;
        $clearance_approval_details = $this->clearance_model->sp_get_clearance_for_approval_details([1, $appno, $cfid]);
        $data['clearance_approval_details'] = $clearance_approval_details['rows'];

        return view('layouts.tabs.forApproval.detailed_form.clearance_details', $data);
    }

    public function clearance_acknowledge(Request $request)
    {

        $identityId = session()->get('identityId');
        $result = $this->clearance_model->sp_acknowledge_clearance([1, $identityId]);
        if ($result['num'] == 0) {

            return response()->json([
                'status' => 0,
                'message' => $result['msg']
            ]);

        } else {

            return response()->json([
                'status' => 1,
                'message' => $result['msg']
            ]);

        }

        // return view('layouts.tabs.forApproval.detailed_form.clearance_details',$data);
    }

    public function update_clearance_approval_details(Request $request)
    {

        $identityId = session()->get('identityId');
        $appno = $request->appNo;
        $cfid = $request->cfId;
        $clearance = $request->clearance;

        foreach ($clearance as $row) {

            $remarks = $row['remarks'];
            $status = $row['status'];

            $result = $this->clearance_model->sp_insert_clearance_status([
                1,
                $appno,
                $identityId,
                $cfid,
                $status,
                $remarks
            ]);

        }

        if ($result['num'] == 0) {

            return response()->json([
                'status' => 0,
                'message' => $result['msg']
            ]);

        } else {

            return response()->json([
                'status' => 1,
                'message' => $result['msg']
            ]);

        }
    }

    /*******       END OF CLEARANCE - RAY       **************/


    /*******    START OF AUTHORITY TO DEDUCT - RAY       **************/

    public function show_authority_to_deduct()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $atd = $this->authority_to_deduct_model->sp_authority_to_deduct_get_list([1, $identityId]);
        $data['authorityToDeduct'] = $atd['rows'];
        $atdHistory = $this->authority_to_deduct_model->sp_authority_to_deduct_get_list_history([1, $identityId]);
        $data['authorityToDeductHistory'] = $atdHistory['rows'];

        return view('layouts.tabs.request.authority_to_deduct', $data);
    }

    public function show_authority_to_deduct_details(Request $request)
    {
        $identityId = session()->get('identityId');
        $formNo = $request->formNo;
        // $data['atdDetails'] =$formNo;
        $atdDetails = $this->authority_to_deduct_model->sp_authority_to_deduct_get_details([1, $identityId, $formNo]);
        $data['atdDetails'] = $atdDetails['rows'];
        $companyName = $this->authority_to_deduct_model->sp_authority_to_deduct_get_details([2, '', '']);
        $data['companyName'] = $companyName['rows'];
        return view('layouts.tabs.request.request_form.authority_to_deduct_details', $data);
    }
    public function update_authority_to_deduct_decline(Request $request)
    {
        $formNo = $request->input('formNo');
        $identityId = $request->input('identityId');

        $result = $this->authority_to_deduct_model->sp_authority_to_deduct_decline([1, $identityId, $formNo]);

        if ($result) {
            return response()->json([
                'status' => 0,
                'message' => 'ATD form successfully declined.'
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'Error occurred.'
            ]);
        }
    }

    public function update_authority_to_deduct_acknowledge(Request $request)
    {
        $formNo = $request->input('formNo');
        $identityId = $request->input('identityId');

        $result = $this->authority_to_deduct_model->sp_authority_to_deduct_acknowledge([1, $identityId, $formNo]);

        if ($result) {
            return response()->json([
                'status' => 0,
                'message' => 'ATD form successfully acknowledged.'
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'Error occurred.'
            ]);
        }
    }
    public function add_employee_deduction(Request $request)
    {
        $appNo = $request->input('appNo');
        $identityId = $request->input('identityId');

        $resultInsert = $this->authority_to_deduct_model->sp_authority_to_deduct_add_employee_deduction([1, $identityId, $appNo]);
        if ($resultInsert) {
            return response()->json([
                'status' => 0,
                'message' => 'ATD form successfully declined.'
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'Error occurred.'
            ]);
        }
    }

    /*******    END OF AUTHORITY TO DEDUCT - RAY       **************/


    /*******    START OF MY PROFILE - RAY       **************/

    public function myProfile()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        return view('layouts.tabs.myProfile.my_profile', $data);
    }

    public function show_myProfile_Details()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $my_profile_information = $this->my_profile_model->sp_myprofile_get_information([1, $identityId]);
        $data['my_profile_information'] = $my_profile_information['rows'];

        $emergencycontacts = $this->my_profile_model->sp_myprofile_get_emergencycontact([1, $identityId]);
        $data['emergencycontacts'] = $emergencycontacts['rows'];

        $education = $this->my_profile_model->sp_myprofile_get_education([2, $identityId]);
        $data['education'] = $education['rows'];

        $employment = $this->my_profile_model->sp_myprofile_get_education([3, $identityId]);
        $data['employment'] = $employment['rows'];

        $training = $this->my_profile_model->sp_myprofile_get_education([4, $identityId]);
        $data['training'] = $training['rows'];

        $hmo = $this->my_profile_model->sp_myprofile_get_education([5, $identityId]);
        $data['hmo'] = $hmo['rows'];

        $payrollgroup = $this->my_profile_model->sp_myprofile_get_education([6, $identityId]);
        $data['payrollgroup'] = $payrollgroup['rows'];

        $hmoRange = $this->my_profile_model->sp_myprofile_get_education([7, $identityId]);
        $data['hmoRange'] = $hmoRange['rows'];


        return view('layouts.tabs.myProfile.my_profile_details', $data);
    }

    public function edit_myProfile_contact(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $contacts = $request->input('contacts', []);
        $deletedRows = $request->input('deletedRows', []);

        $saveContact = $this->my_profile_model->sp_myprofile_save_contact([1]);

        try {

            // =========================
            // 1. SAVE / UPDATE ROWS
            // =========================
            foreach ($contacts as $c) {

                $params = [
                    1,
                    $identityId,
                    $c['code'] ?? null,
                    $c['lineId'] ?? null,
                    $c['name'] ?? null,
                    $c['relationship'] ?? null,
                    $c['mobileNo'] ?? null,
                    $c['alt_mobileNo'] ?? null,
                    $c['email'] ?? null
                ];

                $saveContact = $this->my_profile_model->sp_myprofile_save_contact($params);
                if ($saveContact['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $saveContact['msg'] ?? 'Error'
                    ]);
                }

            }

            // =========================
            // 2. DELETE ROWS
            // =========================
            foreach ($deletedRows as $d) {

                $deleteContact = $this->my_profile_model->sp_myprofile_save_contact([
                    2, // mode delete
                    $identityId,
                    $d['code'] ?? null,
                    $d['lineId'] ?? null,
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);
                if ($deleteContact['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $deleteContact['msg'] ?? 'Error'
                    ]);
                }
            }

            return response()->json([
                'status' => 0,
                'message' => 'Saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit_myProfile_education(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $educations = $request->input('educations', []);
        $deletedRows = $request->input('deletedRows', []);

        $saveEducation = $this->my_profile_model->sp_myprofile_save_education([1]);

        try {

            // =========================
            // 1. SAVE / UPDATE ROWS
            // =========================
            foreach ($educations as $e) {

                $params = [
                    1, // mode save/update
                    $identityId,
                    $e['code'] ?? null,
                    $e['lineId'] ?? null,
                    $e['school'] ?? null,
                    $e['degree'] ?? null,
                    $e['major'] ?? null,
                    $e['yearFrom'] ?? null,
                    $e['yearTo'] ?? null
                ];

                $saveEducation = $this->my_profile_model->sp_myprofile_save_education($params);
                if ($saveEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $saveEducation['msg'] ?? 'Error'
                    ]);
                }

            }

            // =========================
            // 2. DELETE ROWS
            // =========================
            foreach ($deletedRows as $d) {

                $deleteEducation = $this->my_profile_model->sp_myprofile_save_education([
                    2, // mode delete
                    $identityId,
                    $d['code'] ?? null,
                    $d['lineId'] ?? null,
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);
                if ($deleteEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $deleteEducation['msg'] ?? 'Error'
                    ]);
                }
            }

            return response()->json([
                'status' => 0,
                'message' => 'Saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function edit_myProfile_employment(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $educations = $request->input('employments', []);
        $deletedRows = $request->input('deletedRows', []);

        $saveEducation = $this->my_profile_model->sp_myprofile_save_employement([1]);

        try {
            // =========================
            // 1. SAVE / UPDATE ROWS
            // =========================
            foreach ($educations as $e) {

                $params = [
                    1, // mode save/update
                    $identityId,
                    $e['code'] ?? null,
                    $e['lineId'] ?? null,
                    $e['tin'] ?? null,
                    $e['employerName'] ?? null,
                    $e['dateFrom'] ?? null,
                    $e['dateTo'] ?? null
                ];

                $saveEducation = $this->my_profile_model->sp_myprofile_save_employement($params);
                if ($saveEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $saveEducation['msg'] ?? 'Error'
                    ]);
                }

            }

            // =========================
            // 2. DELETE ROWS
            // =========================
            foreach ($deletedRows as $d) {

                $deleteEducation = $this->my_profile_model->sp_myprofile_save_employement([
                    2, // mode delete
                    $identityId,
                    $d['code'] ?? null,
                    $d['lineId'] ?? null,
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);
                if ($deleteEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $deleteEducation['msg'] ?? 'Error'
                    ]);
                }
            }

            return response()->json([
                'status' => 0,
                'message' => 'Saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function edit_myProfile_training(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $trainings = $request->input('trainings', []);
        $deletedRows = $request->input('deletedRows', []);

        $saveEducation = $this->my_profile_model->sp_myprofile_save_training([1]);

        try {
            // =========================
            // 1. SAVE / UPDATE ROWS
            // =========================
            foreach ($trainings as $e) {

                $params = [
                    1, // mode save/update
                    $identityId,
                    $e['code'] ?? null,
                    $e['lineId'] ?? null,
                    $e['description'] ?? null,
                    $e['dateFrom'] ?? null,
                    $e['dateTo'] ?? null,
                    $e['location'] ?? null
                ];

                $saveEducation = $this->my_profile_model->sp_myprofile_save_training($params);
                if ($saveEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $saveEducation['msg'] ?? 'Error'
                    ]);
                }

            }

            // =========================
            // 2. DELETE ROWS
            // =========================
            foreach ($deletedRows as $d) {

                $deleteEducation = $this->my_profile_model->sp_myprofile_save_training([
                    2, // mode delete
                    $identityId,
                    $d['code'] ?? null,
                    $d['lineId'] ?? null,
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);
                if ($deleteEducation['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $deleteEducation['msg'] ?? 'Error'
                    ]);
                }
            }

            return response()->json([
                'status' => 0,
                'message' => 'Saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit_myProfile_hmo_dependent(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $hmos = $request->input('hmos', []);
        $deletedRows = $request->input('deletedRows', []);

        $saveHMO = $this->my_profile_model->sp_myprofile_save_hmo_dependent([1]);

        try {
            // =========================
            // 1. SAVE / UPDATE ROWS
            // =========================
            foreach ($hmos as $h) {

                $params = [
                    1, // mode save/update
                    $identityId,
                    $h['code'] ?? null,
                    $h['lineId'] ?? null,
                    $h['firstName'] ?? null,
                    $h['middleName'] ?? null,
                    $h['lastName'] ?? null,
                    $h['birthDate'] ?? null,
                    $h['relationship'] ?? null,
                    $h['civilStatus'] ?? null,
                    $h['gender'] ?? null,
                    $h['hmoDependent'] ?? null,
                    $h['hmoId'] ?? null,
                    $h['startDate'] ?? null,
                    $h['renewalDate'] ?? null
                ];

                $saveHMO = $this->my_profile_model->sp_myprofile_save_hmo_dependent($params);
                if ($saveHMO['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $saveHMO['msg'] ?? 'Error'
                    ]);
                }
            }

            // =========================
            // 2. DELETE ROWS
            // =========================
            foreach ($deletedRows as $d) {

                $deleteHMO = $this->my_profile_model->sp_myprofile_save_hmo_dependent([
                    2, // mode delete
                    $identityId,
                    $d['code'] ?? null,
                    $d['lineId'] ?? null,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                ]);
                if ($deleteHMO['num'] != 0) {
                    return response()->json([
                        'status' => 1,
                        'message' => $deleteHMO['msg'] ?? 'Error'
                    ]);
                }
            }

            return response()->json([
                'status' => 0,
                'message' => 'Saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }







    public function edit_myProfile_Details(Request $request)
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;
        function nullIfNA($value)
        {
            return ($value === 'N/A' || $value === 'N/AA' || $value === '' || is_null($value)) ? null : $value;
        }

        $identityId2 = nullIfNA($request->input('identityId'));
        $firstName = nullIfNA($request->input('firstName'));
        $middleName = nullIfNA($request->input('middleName'));
        $lastName = nullIfNA($request->input('lastName'));
        $suffix = nullIfNA($request->input('suffix'));
        $birthPlace = nullIfNA($request->input('birthPlace'));
        $birthdate = nullIfNA($request->input('birthdate'));
        $age = nullIfNA($request->input('age'));
        $address = nullIfNA($request->input('address'));
        $address2 = nullIfNA($request->input('address2'));
        $address3 = nullIfNA($request->input('address3'));
        $citizenship = nullIfNA($request->input('citizenship'));
        $religion = nullIfNA($request->input('religion'));
        $gender = nullIfNA($request->input('gender'));
        $civilStatus = nullIfNA($request->input('civilStatus'));
        $contactNo = nullIfNA($request->input('contactNo'));
        $emailAddress = nullIfNA($request->input('emailAddress'));
        $batchId = nullIfNA($request->input('batchId'));
        $paymentType = nullIfNA($request->input('paymentType'));
        $tinNo = nullIfNA($request->input('tinNo'));
        $BankAccountNo = nullIfNA($request->input('BankAccountNo'));
        $sssNo = nullIfNA($request->input('sssNo'));
        $pagibigNo = nullIfNA($request->input('pagibigNo'));
        $hmoNo = nullIfNA($request->input('hmoNo'));
        $prcNo = nullIfNA($request->input('prcNo'));
        $dateIssued = nullIfNA($request->input('dateIssued'));
        $dateExpired = nullIfNA($request->input('dateExpired'));




        $params = [
            1,
            $identityId2,
            $firstName,
            $middleName,
            $lastName,
            $suffix,
            $birthdate,
            $age,
            $address,
            $address2,
            $address3,
            $citizenship,
            $religion,
            $gender,
            $civilStatus,
            $contactNo,
            $emailAddress,
            $tinNo,
            $sssNo,
            $pagibigNo,
            $hmoNo,
            $prcNo,
            $dateIssued,
            $dateExpired,
            $identityId2,
            date('Y-m-d H:i:s'),
            $batchId,
            $birthPlace,
            $paymentType
        ];
        // $resultInsert = $this->my_profile_model->sp_myprofile_edit_information([$params]);
        $checkPending = $this->my_profile_model->sp_myprofile_check_pending([1, $identityId2]);

        // if ($checkPending['num'] == 0) {
        $resultInsert = $this->my_profile_model->sp_myprofile_edit_information($params);

        if ($resultInsert['num'] == 0) {
            return response()->json([
                'status' => 0,
                'message' => $resultInsert['msg'] ?? 'Success'
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => $resultInsert['msg'] ?? 'Failed'
            ]);
        }
        /*
    } else {
        return response()->json([
            'status' => 0,
            'message' => $checkPending['msg'] ?? 'You have a pending change request'
        ]);
    }
  */
        // $data['my_profile_information'] = $my_profile_information['rows'];
        // return view('layouts.tabs.myProfile.my_profile_details',$data);
    }


    public function myProfilePayroll()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $my_profile_payroll = $this->my_profile_model->sp_myprofile_get_payroll([1, $identityId]);
        $data['my_profile_payroll'] = $my_profile_payroll['rows'];

        $my_profile_payroll_previous = $this->my_profile_model->sp_myprofile_get_payroll([2, $identityId]);
        $data['my_profile_payroll_previous'] = $my_profile_payroll_previous['rows'];

        $my_profile_payroll_accoutability = $this->my_profile_model->sp_myprofile_get_payroll_accountability([3, $identityId]);
        $data['my_profile_payroll_accoutability'] = $my_profile_payroll_accoutability['rows'];

        $my_profile_payroll_loan = $this->my_profile_model->sp_myprofile_get_payroll_accountability([4, $identityId]);
        $data['my_profile_payroll_loan'] = $my_profile_payroll_loan['rows'];

        $my_profile_payroll_leave = $this->my_profile_model->sp_myprofile_get_payroll_leaveBalance([5, $identityId]);
        $data['my_profile_payroll_leave'] = $my_profile_payroll_leave['rows'];

        $data['emp_ytd_tax_years'] = $this->employee_ytd_model->sp_emp_ytd_tax_years([0]);

        return view('layouts.tabs.myProfile.my_profile_payroll', $data);
    }
    /*******       END OF MY PROFILE - RAY       **************/

    /*******    START OF APPRAISAL FORM - RAY    **************/

    public function show_appraisal_application_list()
    {

        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $appraisalFormList = $this->appraisal_model->sp_portal_appraisal_get_application([2, $identityId, '']);
        $data['appraisalFormList'] = $appraisalFormList['rows'];



        // return $appraisalFormList;
        return view('layouts.tabs.appraisal.application.appraisal_application_list', $data);

    }

    public function show_appraisal_supervisor_approval()
    {

        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $appraisalForm = $this->appraisal_model->sp_portal_appraisal_get([1, $identityId, '']);
        $data['appraisalForm'] = $appraisalForm['rows'];


        $jobCategory = $this->appraisal_model->sp_portal_appraisal_get([4, $identityId, '']);
        $data['jobCategory'] = $jobCategory['rows'];

        $position = $this->appraisal_model->sp_portal_appraisal_get([5, $identityId, '']);
        $data['position'] = $position['rows'];
        return view('layouts.tabs.appraisal.approval.appraisal_supervisor_approver', $data);

    }

    public function show_appraisal_form_approval()
    {

        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;

        $appraisalForm = $this->appraisal_model->sp_portal_appraisal_get([2, $identityId, '']);
        $data['appraisalForm'] = $appraisalForm['rows'];
        $appraisalForm = $this->appraisal_model->sp_portal_appraisal_get_history([1, $identityId, '']);
        $data['appraisalFormHistory'] = $appraisalForm['rows'];


        return view('layouts.tabs.appraisal.approval.appraisal_for_approval', $data);

    }

    public function appraisal_form_approval_details(Request $request)
    {
        $afAppNo = $request->input('afAppNo');
        // $afAppNo = $request->afAppNo;
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;
        $appraisalForm = $this->appraisal_model->sp_portal_appraisal_get([3, '', $afAppNo]);
        $data['appraisalForm'] = $appraisalForm['rows'][0];

        $appraisalform_core_competency = $this->appraisal_model->sp_portal_appraisal_table_link_get([1, '', $afAppNo]);
        $appraisalform_job_competency = $this->appraisal_model->sp_portal_appraisal_table_link_get([2, '', $afAppNo]);
        $appraisalform_goal = $this->appraisal_model->sp_portal_appraisal_table_link_get([3, '', $afAppNo]);
        $appraisalform_goal_year = $this->appraisal_model->sp_portal_appraisal_table_link_get([4, '', $afAppNo]);
        $individual_plan = $this->appraisal_model->sp_portal_appraisal_table_link_get([5, '', $afAppNo]);
        $jobCategory = $this->appraisal_model->sp_portal_appraisal_get([4, $identityId, '']);
        $data['jobCategory'] = $jobCategory['rows'];

        $position = $this->appraisal_model->sp_portal_appraisal_get([5, $identityId, '']);
        $data['position'] = $position['rows'];
        $coreTable = [];
        if (!empty($appraisalform_core_competency['rows'])) {
            foreach ($appraisalform_core_competency['rows'] as $row) {
                // $coreTable[$row['afLineId']] = $row;
                $coreTable[$row->afLineId] = $row;
            }
        }

        $jobCompetency = [];
        if (!empty($appraisalform_job_competency['rows'])) {
            foreach ($appraisalform_job_competency['rows'] as $rows) {
                // $coreTable[$row['afLineId']] = $row;
                $jobCompetency[$rows->afLineId] = $rows;
            }
        }
        $goalTable = [];
        if (!empty($appraisalform_goal['rows'])) {
            foreach ($appraisalform_goal['rows'] as $row3) {
                // $coreTable[$row['afLineId']] = $row;
                $goalTable[$row3->afLineId] = $row3;
            }
        }
        $goalYearTable = [];
        if (!empty($appraisalform_goal_year['rows'])) {
            foreach ($appraisalform_goal_year['rows'] as $row4) {
                // $coreTable[$row['afLineId']] = $row;
                $goalYearTable[$row4->afLineId] = $row4;
            }
        }
        $individualPlanTable = [];
        if (!empty($individual_plan['rows'])) {
            foreach ($individual_plan['rows'] as $row5) {
                // $coreTable[$row['afLineId']] = $row;
                $individualPlanTable[$row5->afLineId] = $row5;
            }
        }

        // Pass to view
        $data['coreTable'] = $coreTable;
        $data['jobCompetency'] = $jobCompetency;
        $data['goalTable'] = $goalTable;
        $data['goalYearTable'] = $goalYearTable;
        $data['individualPlanTable'] = $individualPlanTable;
        // return  $appraisalform_job_competency;
        return view('layouts.tabs.appraisal.approval.appraisal_supervisor_approver', $data);

    }


    public function appraisal_form_approval_submit(Request $request)
    {
        //    $appraisalForm = $this->appraisal_model->sp_portal_appraisal_insert_approver([1,'','']);

        try {
            $identityId = $request->input('identityId');
            $afAppNo = $request->input('afAppNo');
            $identityIdApprover = session()->get('identityId');
            // Decode all arrays
            $competencyTable = json_decode($request->input('competencyTable'), true);
            $competencyGoalTable = json_decode($request->input('competencyGoalTable'), true);
            $goalsTable = json_decode($request->input('goalsTable'), true);
            $goalsYearTable = json_decode($request->input('goalsYearTable'), true);
            $individualPlan = json_decode($request->input('individualPlan'), true);
            $otherData = json_decode($request->input('otherData'), true);

            // Call stored procedure for each table insert
            // Mode 1: Job Specific Competency
            $result1 = $this->appraisal_model->sp_portal_appraisal_insert_approver([1, $identityId, $afAppNo, $identityIdApprover, json_encode($competencyTable)]);
            $result2 = $this->appraisal_model->sp_portal_appraisal_insert_approver([2, $identityId, $afAppNo, $identityIdApprover, json_encode($competencyGoalTable)]);
            $result3 = $this->appraisal_model->sp_portal_appraisal_insert_approver([3, $identityId, $afAppNo, $identityIdApprover, json_encode($goalsTable)]);
            $result4 = $this->appraisal_model->sp_portal_appraisal_insert_approver([4, $identityId, $afAppNo, $identityIdApprover, json_encode($goalsYearTable)]);
            $result5 = $this->appraisal_model->sp_portal_appraisal_insert_approver([5, $identityId, $afAppNo, $identityIdApprover, json_encode($individualPlan)]);
            $result6 = $this->appraisal_model->sp_portal_appraisal_insert_approver([6, $identityId, $afAppNo, $identityIdApprover, json_encode($otherData)]);
            // return response()->json([
            //         'status' => 0,
            //         'message' => $result6['msg'] ?? 'Success'
            //     ]);

            if ($result6['num'] == 0) {
                return response()->json([
                    'status' => 0,
                    'message' => $result6['msg'] ?? 'Success'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'message' => $result6['msg'] ?? 'Failed'
                ]);
            }

            // Mode 2: Goals
            // $result2 = $this->appraisal_model->sp_portal_appraisal_insert_approver([2, $identityId, $afAppNo, $competencyGoalTable]);

            // // Mode 3: Goals Year
            // $result3 = $this->appraisal_model->sp_portal_appraisal_insert_approver(
            //     3, $identityId, $afAppNo, $goalsYear
            // );

            // // Mode 4: Core Competency
            // $result4 = $this->appraisal_model->sp_portal_appraisal_insert_approver(
            //     4, $identityId, $afAppNo, $coreCompetency
            // );

            // // Mode 5: Individual Plan
            // $result5 = $this->appraisal_model->sp_portal_appraisal_insert_approver(
            //     5, $identityId, $afAppNo, $individualPlan
            // );

            // Mode 6: Update Main Appraisal Form
            // $result6 = $this->appraisal_model->sp_portal_appraisal_insert_approver(
            //     6, $identityId, $afAppNo, $otherData
            // );

            return response()->json([
                'status' => 0,
                'message' => 'Appraisal form submitted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }







    public function show_appraisal_form_supervisor()
    {
        $identityId = session()->get('identityId');
        $data['identityId'] = $identityId;


        return view('layouts.tabs.appraisal.appraisal_rank_file', $data);
    }

     

     
    
}
