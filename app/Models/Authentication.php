<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloMail; 
use App\Mail\PFMail; 

/* use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail; */

class Authentication extends Model
{
 

    public function get_company_password_details()
      { 
            $passwordSettings = DB::table('companysetting')
                  ->select('passwordChangeInitLogon', 'passwordReuseRestriction', 'passwordLength', 'passwordComplexEnabled', 'lockedOutDuration', 'lockedOutRecoveryType', 'passwordExpiredDays', 'enableCaptcha', 'logAttempts','protocol','smtpHost','smtpPort','defaultSenderName','password','companyName')
                  ->first();
 
            return $passwordSettings ? (array) $passwordSettings : [];
      }

    public function get_report_url()
    { 
        $report_url = $this->sp_portal_url_maping([1])['rows'][0]->url;
        return $report_url; 
    }

    
    public function add_link($id2, $stringParams)
    {

        $database = 'pf-common';
        DB::purge('mysql');  // Purge the existing connection
        config(['database.connections.mysql.database' => $database]);

        $data = [
            'id' => $id2,
            'stringParams' => $stringParams
        ];

        $insertSuccess = DB::table('reportparameters')->insert($data);

        if ($insertSuccess) {
            return true;
        }
        return false;

    }


    public function payslip_param_based_on_payslip_code($code)
    {

        $database = Session::get('database');
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $database]);

        $result = DB::table('employeepayslip as ep')
            ->join('v_payrollperiod as vpp', 'ep.payrollPeriod', '=', 'vpp.payrollPeriod')
            ->join('groupauthorization as ga', 'ep.batchId', '=', 'ga.payrollGroup')
            ->select(
                'ep.batchId as batchId',
                'vpp.payrollPeriodPayDate as payDate',
                DB::raw("CONCAT(vpp.payrollPeriodPayDate, '|', vpp.payrollPeriodId) as PSPayDate"),
                'ga.username as username'
            )
            ->where('ep.code', $code)
            ->whereColumn('ga.payrollGroup', 'ep.batchId')
            ->first();

        return (array) $result;


    }



    //
    public function f_endecrypt($string, $action, $id)
    { 
        $database = Session::get('database');
        $secret_key = $id;
        $secret_iv = 'p@yf@ct0rt34m2018';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } elseif ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    //authenticate the account
    public function check_if_username_exists($username)
    {
        $database = Session::get('database'); 
        $user = DB::table('users')
            ->select('userid', 'username', 'password', 'usertype', 'identityid', 'pStatus')
            ->where('username', $username) 
            ->first();

        return (array) $user;
    }

    //authenticate the account
    public function authenticate_account_per_user($username)
    {
        $database = Session::get('database');
        // DB::purge('mysql');

        $user = DB::table('users')
            ->select('userid', 'username', 'password', 'usertype', 'identityid', 'pStatus')
            ->where('username', $username) 
            ->first();

        return (array) $user;
    }

    //authenticate the account
    public function authenticate_account($username, $password)
    {
        $database = Session::get('database');
        // DB::purge('mysql');

        $user = DB::table('users')
            ->select('userid', 'username', 'password', 'usertype', 'identityid', 'pStatus')
            ->where('username', $username)
            ->where('password', $password)
            ->first();

        return (array) $user;
    }


    //get the databases
    public function get_database()
    {

        /* return DB::table('db_profile as a')
            ->select('a.db_name', DB::raw("
                CASE 
                    WHEN UPPER(a.db_name) LIKE '%PROD%' THEN CONCAT(a.db_description, '(PROD)') 
                    WHEN UPPER(a.db_name) LIKE '%TEST%' THEN CONCAT(a.db_description, '(TEST)') 
                    ELSE a.db_description 
                END AS db_description
            "), 'a.isvisible')
            ->where('a.isvisible', 1)
            ->orderBy('db_description')
            ->get()
            ->toArray(); */


        return  $databases = DB::table('v_kiosk_database_host as t1')
        ->leftJoin('db_profile as t2', 't1.name', '=', 't2.db_name')
        ->select('t2.*', 't1.hostName')
        ->where('t1.hostName', env('DB_OWNER'))
        ->get()
        ->toArray();
    }


    public function sp_for_approval_insert($spParams)
    {
        return $this->exec_store_proc('sp_for_approval_insert', $spParams);
    }

    public function sp_kiosk_costumization($spParams){  
        return $this->exec_store_proc('sp_kiosk_costumization', $spParams);    
	}  


    public function get_locations($spParams)
    {
        return $this->exec_store_proc('sp_get_locations', $spParams);
    }

    public function sp_dropdown_fill($spParams)
    {
        $str = $this->exec_store_proc('sp_dropdown_fill', $spParams);
        return $str;
    }


    public function sp_get_company_settings_name_by_db($spParams)
    {
        return $this->pf_common_exec_store_proc('sp_get_company_settings_name_by_db',$spParams);
    }

    public function exec_store_proc($spName, $spParams){

        try {

            $database = Session::get('database');
            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);

            $param_count = "";
            foreach ($spParams as $param) {
                $param_count = $param_count . "?,";
            }

            $results = DB::select(
                'CALL ' . $spName . '(' . $param_count . ' @num, @msg)',
                $spParams
            );

            $output = DB::select('SELECT @num AS num, @msg AS msg');
            $num = $output[0]->num;
            $msg = $output[0]->msg;

            $final_result = ["rows" => $results, "num" => $num, "msg" => $msg];

            return $final_result;

        } catch (\Throwable $e) {

            $final_result_catch = ["rows" => [], "num" => 1, "msg" => $e->getMessage()];
            return $final_result_catch;
        }

    }

    public function pf_common_exec_store_proc($spName, $spParams){
 
        try {

            $database = 'pf-common';
            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);

            $param_count = "";
            foreach ($spParams as $param) {
                $param_count = $param_count . "?,";
            }

            $results = DB::select(
                'CALL ' . $spName . '(' . $param_count . ' @num, @msg)',
                $spParams
            );

            $output = DB::select('SELECT @num AS num, @msg AS msg');
            $num = $output[0]->num;
            $msg = $output[0]->msg;

            $final_result = ["rows" => $results, "num" => $num, "msg" => $msg];

            return $final_result;

        } catch (\Throwable $e) {

            $final_result_catch = ["rows" => [], "num" => 1, "msg" => $e->getMessage()];
            return $final_result_catch;
        }

    }

    public function get_identity($identityId) {

        $database = session()->get('database');
        DB::purge('mysql');

        $identity = DB::table('identity')
            ->select('code', 'identityId', 'firstName', 'middleName', 'lastName', 'birthdate', 'batchId', 'emailAddress')
            ->where('identityId', $identityId)
            ->first();

        return (array) $identity;

    }
    
    public function sp_kiosk_lookups($params){
        return $this->exec_store_proc('sp_kiosk_lookups', $params);
    }
    
    public function sp_pf_common_sub_app_license($params){
        return $this->exec_store_proc('sp_pf_common_sub_app_license', $params);
    }

    public function sp_leave_get_balance($params){
        return $this->exec_store_proc('sp_leave_get_balance', $params);
    }

    public function sp_time_adj_get_disabled_array($spParams){
        return $this->exec_store_proc('sp_time_adj_get_disabled_array', $spParams);
    }

    public function sp_approver_get_priviledge(){
        $identityId = session()->get('identityId');
        return $this->exec_store_proc('sp_approver_get_priviledge', [0, $identityId]);
    }

    public function sp_for_approval_get_all($num){
        $identityId = session()->get('identityId');
        $num = $_POST['num'];
        return $this->exec_store_proc('sp_for_approval_get_all', [$num, $identityId]);
    }
    
    public function sp_get_approval($spParams){
        $str = $this->exec_store_proc('sp_get_approval', $spParams);
        return $str;
    }
    
    public function sp_for_approval_get_all_detail($spParams) {
        $str = $this->exec_store_proc('sp_for_approval_get_all_detail', $spParams);
        return $str;
    }

    public function sp_portal_url_maping($spParams){
        return $this->exec_store_proc('sp_portal_url_maping', $spParams);
    }

    public function sp_application_movement($spParams){
        return $this->exec_store_proc('sp_application_movement', $spParams);
    }
 

    public function sp_for_approval_response($spParams){
       // return $this->exec_store_proc('sp_for_approval_response', $spParams);
       $data = $this->exec_store_proc('sp_for_approval_response', $spParams);

       $start  = microtime(true);
       $pintMode = $spParams[0];
       $sitchNo = $spParams[1];
       $activity = "Unkown";
       $msg = (json_decode($data['msg'],true)['msg']) ?? '';

       if ($sitchNo==0){$activity = "Overtime -> Approval";}
       if ($sitchNo==1){$activity = "Leave -> Approval";}
       if ($sitchNo==2){$activity = "Time Adjustment -> Approval";}
       if ($sitchNo==3){$activity = "Official Business -> Approval";}
       if ($sitchNo==5){$activity = "Time Entry -> Approval";}
       if ($sitchNo==4){$activity = "Offset -> Approval";}
       if ($sitchNo==6){$activity = "Schedule Change -> Approval";}

        if ($pintMode==1 && $data['num']==1){
                $this->sp_userAuditTrails(1,$activity,'Failed',$msg,$start); 
        }else{
            if($pintMode==1  && $data['num']==0){
                $this->sp_userAuditTrails(1,$activity,'Success',$msg,$start); 
               // $num = 3;
            }else{
                $msg = ($msg=="") ? "Yes/No confirmation" : $msg;
                $this->sp_userAuditTrails(1,$activity,'info','Validation -> '.$msg,$start); 
            } 
        }  
        return $data;

    }
    
    public function sp_get_payrollperiod_kiosk($spParams){
        return $this->exec_store_proc('sp_get_payrollperiod_kiosk', $spParams);
    }

    public function sp_rpt_get_employee_nthmonth($spParams){
        return $this->exec_store_proc('sp_rpt_get_employee_nthmonth', $spParams);
    }

    public function sp_portal_mfa_activation($spParams){
        return $this->exec_store_proc('sp_portal_mfa_activation', $spParams);
    }

    public function get_userDevice(){ 
        $data['user_device'] = [];
        array_push($data['user_device'],[ "browser" => $_SERVER['HTTP_USER_AGENT'], "ip" => $_SERVER['REMOTE_ADDR'], "date" => date('Y-m-d H:i:s')]);
        return $data;
    }

    public function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $script_name = $_SERVER['SCRIPT_NAME']; 
        $base_url = $protocol . "://$host" . dirname($script_name);
        return $base_url;
    }

    public function testing(){
        $data['rows']= []; $data['num'] = 0; $data['msg'] = 'OKS';
        return  $data;
    }

    public function sp_userAuditTrails($mode,$activity,$status,$details,$start){ 
        $end = microtime(true); 
        //$seconds = $end-$start;
        $identityId = (session()->get('username')) ?? "unkwon";
        $machainDetails = json_encode($this->get_userDevice()['user_device']); 
        $facilityDetails = json_encode(["url" => $this->getBaseUrl(), "seconds" => $end]);
        $spParams = [$mode,$identityId,$activity,$status,$details,$machainDetails,$facilityDetails]; 
       //return $this->exec_store_proc('sp_userAuditTrails', $spParams); 
        
 
       // JSON file location
        $file = storage_path('app/audit_trails.json');

        // Get existing data
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $data = json_decode($json, true) ?? [];
        } else {
            $data = [];
        }

        // Add new audit record
        $data[] = [
            'mode' => $mode,
            'identity_id' => $identityId,
            'activity' => $activity,
            'status' => $status,
            'details' => $details,
            'machine_details' => $machainDetails,
            'facility_details' => $facilityDetails,
            'created_at' => now()->toDateTimeString()
        ];

        // Save JSON
        file_put_contents(
            $file,
            json_encode($data, JSON_PRETTY_PRINT),
            LOCK_EX
        ); 
           
    }
    
    public function sp_rpt_get_payslip_record($spParams){
        return $this->exec_store_proc('sp_rpt_get_payslip_record', $spParams);
    }

    public function sp_delete_application_form($spParams){
        
        $data = $this->exec_store_proc('sp_delete_application_form', $spParams);
 
        $sitchNo = $spParams[1]; 
        $facility = "unknown";

        if($sitchNo==1){ $facility="Leave"; }
        if($sitchNo==4){ $facility="Offset"; }
        if($sitchNo==6){ $facility="Schedule Chage"; }
        if($sitchNo==7){ $facility="HRD Certificate"; }


        $start  = microtime(true);  
        if ($data['num']==1){
            $this->sp_userAuditTrails(1,$facility.' -> Cancel Request','Failed',$data['msg'],$start); 
        }else{
            $this->sp_userAuditTrails(1,$facility.' -> Cancel Request','Success',$data['msg'],$start); 
        } 
        return $data;

       // return $this->exec_store_proc('sp_delete_application_form', $spParams);
    }

    public function sp_request_get_history($spParams){
        return $this->exec_store_proc('sp_request_get_history', $spParams);
    }

    public function sp_approval_get_authorizer($spParams){
        return $this->exec_store_proc('sp_approval_get_authorizer', $spParams);
    }

    public function sp_get_next_authorizer($spParams){
        return $this->exec_store_proc('sp_get_next_authorizer', $spParams);
    }

    public function sp_get_document_info($spParams)
    {
        return $this->exec_store_proc('sp_get_document_info', $spParams);
    }

    public function sp_app_user_info($spParams)
    {
        return $this->exec_store_proc('sp_app_user_info', $spParams);
    }


    public function sp_portal_otp($spParams) {
        return $this->exec_store_proc('sp_portal_otp', $spParams);
    }

    public function sp_check_payroll_period_status($spParams) {
        $data = $this->exec_store_proc('sp_check_payroll_period_status', $spParams);
        return $data['rows'][0];
    }

    public function sp_get_payslip_param($spParams)
    {
        return $this->exec_store_proc('sp_get_payslip_param', $spParams);
    }

    public function sp_portal_announcement($spParams)
    {
       // return $this->exec_store_proc('sp_portal_announcement', $spParams);
        $data = $this->exec_store_proc('sp_portal_announcement', $spParams);

        $pintMode = $spParams[0];
        $pId = $spParams[1];
        $start  = microtime(true);
        $activity = ($pId>0) ? "Announcement -> View" : (($data['msg']=="") ? "Announcement -> Load list" : "Announcement -> Post") ;
        if($data['num']==1){
            $this->sp_userAuditTrails(1,$activity,'Failed',$data['msg'],$start); 
        }else{
            $this->sp_userAuditTrails(1,$activity,'Success',$data['msg'],$start); 
        }
        
        /* $activity = "Announcement -> Post"; 
        if ($pintMode==1 && $data['num']==1){
            $this->sp_userAuditTrails(1,$activity,'Failed',$data['msg'],$start); 
        }else{
            if($pintMode==1  && $data['num']==0){
                $this->sp_userAuditTrails(1,$activity,'Success',$activity,$data['msg'],$start); 
            }else{
                $msg = ($data['msg']=="") ? "Yes/No confirmation" : $data['msg'];
                $this->sp_userAuditTrails(1,$activity,'info','Validation -> '.$msg,$start); 
            } 
        } */
        return $data;

    }
    
    public function sp_get_signatories($spParams)
    {
        return $this->exec_store_proc('sp_get_signatories', $spParams);
    }

    public function sp_approval_appNo_details($spParams)
    {
        return $this->exec_store_proc('sp_approval_appNo_details', $spParams);
    }

    public function sp_requestattachments($spParams)
    {
        return $this->exec_store_proc('sp_requestattachments', $spParams);
    }


    public function sp_selected_items_response($spParams)
    {
        //return $this->exec_store_proc('sp_selected_items_response', $spParams);
        //return ["rows" => [], "num" => 0, "msg" => "oks"];
        $data =  $this->exec_store_proc('sp_selected_items_response', $spParams);


        $start  = microtime(true);
        $pintMode = $spParams[0];
        $sitchNo = $spParams[2];
        //$items = json_encode($spParams[4]);
        //$items = $spParams[4];

        $activity = "Unknown -> multi approval";
        if ($sitchNo==0){$activity = "Overtime -> Multi Approval";}
        if ($sitchNo==1){$activity = "Leave -> Multi Approval";}
        if ($sitchNo==2){$activity = "Time Adjustment -> Multi Approval";}
        if ($sitchNo==3){$activity = "Official Business -> Multi Approval";}
        if ($sitchNo==5){$activity = "Time Entry -> Multi Approval";}
        if ($sitchNo==4){$activity = "Offset -> Multi Approval";}
        if ($sitchNo==6){$activity = "Schedule Change -> Multi Approval";}

        $status = ($data['num']==1) ? "Failed" : "Success";
        $dec = ($spParams[3]==1) ? "approved" : "rejected";
        $this->sp_userAuditTrails(1,$activity,$status,$data['msg'],$start);  
        return $data;
    }

    public function sp_lms_url($spParams){
        return $this->exec_store_proc('sp_lms_url', $spParams);
    }
     
    public function setCaptchaAttempt($thisNum){

        if ($thisNum==0){
            session()->put('captcha_attemp', value : null);
        }
 

        if (session()->get('multi')== null){
            session()->put('multi', value : 1);
        }

        if (session()->get('captcha_attemp')== null){
              session()->put('captcha_attemp', value : 0);
        }
        
        $multi = session()->get('multi'); 
        $num = session()->get('captcha_attemp'); 
        $num+=$thisNum;

        
        /* if ($num==5){ //increase multiplier
            session()->put('multi', value : $multi+=1);
        } */

        session()->put('captcha_attemp', value : $num);
 
        date_default_timezone_set('Asia/Manila'); 
        Session::put('wait_until',(time() * $multi)+ 60); 

        return  session()->get('captcha_attemp');
  }

    
  
    public function sp_application_info($spParams)
    {
        $identityId = session()->get('identityId');
        $data = $this->exec_store_proc('sp_application_info', $spParams);  
        $num = 0;
        foreach ($data['rows'] as $rows) {
            $enc_id = $rows->r_appNo;
            $enc_pay = $rows->approverLocked;
            $data['rows'][$num]->enc_id = $this->f_endecrypt($enc_id, 'e', $identityId);
            $data['rows'][$num]->enc_pay = $this->f_endecrypt($enc_pay, 'e', $identityId); 
            $num++;
        }

        return $data;
    }

    public function get_identity_sp($spParams)
    {
        return $this->exec_store_proc('sp_get_user_details', $spParams);
    }

    public function sp_get_user_per_department($spParams)
    {
        return $this->exec_store_proc('sp_get_user_per_department', $spParams);
    }

    public function sp_faceDetails($spParams)
    {
        return $this->exec_store_proc('sp_faceDetails', $spParams);
    }

    public function return_error($id, $msg)
    {
        $rows = [
            "rows" => [],
            "num" => 1,
            "msg" => json_encode(array("id" => $id, "msg" => $msg))
        ];
        return $rows;
    }

    public function if_val_is_valid($list, $column, $val)
    {
        $count = 0;
        $values = array_column($list, $column);
        if (in_array($val, $values)) {
            $count = 1;
        }
        return $count;
    }
    public function generateOTP($length = 6) {
        $otp = "";
        for ($i = 0; $i < $length; $i++) {
            $otp .= rand(0, 9); // Generate a random digit between 0 and 9
        }
        $newOTP['OTP'] = $otp;
        $newOTP['RefNo'] = date('YmdHis');

        return $newOTP;
    }

     public function app_mailer($data){
            
        $cmd['num'] = 0; 
        $email['sendTo']=$data[0]['email']; 
        $email['CcTo']=[]; 
        $email['header']=[$email['sendTo']]; 
        $email['content']=["Payfactor mailer working successfully"]; 
        $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
        if($this->sendEmail(new Request($email))){ 
           $cmd['msg'] = "Email successfully sent into ".$email['sendTo'].". kindly check it now!";
        }else{ 
            $cmd['msg'] = "Email failed to send!";
        } 
        
        echo json_encode($cmd);
    }

    public function sp_get_holidaysholiday($spParams){
        return $this->exec_store_proc('sp_get_holidaysholiday', $spParams);
    }


    public function sp_email_hist($spParams){
        return $this->exec_store_proc('sp_email_hist', $spParams);
    }

    public function sp_get_default_mailer($spParams){
        return $this->exec_store_proc('sp_get_default_mailer', $spParams);
    }
 


   public function sendEmail(Request $data_request){
    
         $start  = microtime(true);
         $num = 0;
         $status = "Failed";
         $errorMessage = "";
        
         // Email Notification Management
        $mailNotLocked = "1";  
        $app = "";  
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Overtime'))) ? "Overtime" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>time adjustment'))) ? "Time Adjustment" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Time Entry'))) ? "Time Entry" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Leave'))) ? "Leave" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Official Business'))) ? "Official Business" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Offset'))) ? "Offset" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>HRD Certificate'))) ? "HRD Certificate" : $app;
        $app = ((strpos(json_encode($data_request->input('content')), '<b>Change of Schedule'))) ? "Change of Schedule" : $app;

 
        $company_customization = $this->sp_kiosk_costumization([0,session()->get('database')]);
         foreach ($company_customization['rows'] as $row) {
            if($row->_name=="email" && $app!==""){ 
                $rows=json_decode($row->val,true);
                $mailNotLocked=$rows[$app];
            }
        }  
        //$data['num'] = 1; $data['msg'] = "hahahah6"; $data['rows'] = [];  return $data; 
         

        $companyPasswordSettings = session()->get('companyPasswordSettings'); 
         
        try { 
  
           
            \Config::set('mail.mailers.smtp', [
                'transport' => $companyPasswordSettings['protocol'],
                'host' => $companyPasswordSettings['smtpHost'],
                'port' => $companyPasswordSettings['smtpPort'],
                'encryption' => $companyPasswordSettings['authType'],
                'username' => $companyPasswordSettings['kioskEmail'],
                'password' => $companyPasswordSettings['password'],
            ]);

            \Config::set('mail.default',$companyPasswordSettings['protocol']);
            \Config::set('mail.from.address', $companyPasswordSettings['kioskEmail']);
            \Config::set('mail.from.name',$companyPasswordSettings['defaultSenderName']);

          

             
            $data = [
                'header' => $data_request->input('header'),
                'sendTo' => $data_request->input('sendTo'),
                'ccTo' => $data_request->input('ccTo'),
                'content' => $data_request->input('content'),
                'footer' => $data_request->input('footer'),
                'attachments' => $data_request->input('attachments'),
                'subject' => $data_request->input('subject') ?? 'P F Mail',
            ]; 

            
            try {
                if($mailNotLocked=="1"){
                    \Mail::to($data['sendTo'])
                    ->cc($data['ccTo'])
                    ->send(new PFMail($data));

                    $num = 1;
                    $status = "Success";
                }else{
                    $num = 0;
                    $status = "Failed";
                    $errorMessage = $app." Email notification locked by the admin";
                    $data['subject'] = $data['subject']. ". Failed Info: ".$app." Email notification locked by the admin";
                }

            } catch (\Throwable $th) {
                 $num = 0;
                 $status = "Failed";
                 $errorMessage = $th->getMessage();
            }
   

                   

        } catch (\Throwable $th) { 
            $status = "Failed";
            $errorMessage = $th->getMessage();
            $num = 0;
        }

        $sendTo = $data_request->input('sendTo')[0] ?? ""; 
        $header = $data_request->input('header')[0] ?? ""; 
        $content = $data_request->input('content')[0] ?? ""; 
        $this->sp_email_hist([0,$companyPasswordSettings['kioskEmail'],$sendTo,$header,$content,$companyPasswordSettings['protocol'],$companyPasswordSettings['smtpHost'],$status,substr($errorMessage, 0, 500)]);         
        $this->sp_userAuditTrails(1,'Send Email',$status,$data['subject'],$start); 
        return $errorMessage;
        return $num; 
   }
   
   function sendEmailUsingDefaultMailer(Request $data_request){
            echo "sendEmailUsingDefaultMailer<br><br>";
            $default_mailer = session()->get('default_mailer')['rows'][0];


            \Config::set('mail.mailers.smtp', [
                'transport' => $default_mailer->protocol,
                'host' => $default_mailer->smtp_host,
                'port' => $default_mailer->smtp_port,
                'encryption' => $default_mailer->authType,
                'username' => $default_mailer->smtp_user,
                'password' => $default_mailer->smtp_pass,
            ]);

            \Config::set('mail.default',$default_mailer->protocol);
            \Config::set('mail.from.address', $default_mailer->smtp_user);
            \Config::set('mail.from.name',"no-replyPF@gmail.com");


            $data = [
                    'header' => $data_request->input('header'),
                    'sendTo' => $data_request->input('sendTo'),
                    'ccTo' => $data_request->input('ccTo'),
                    'content' => $data_request->input('content'),
                    'footer' => $data_request->input('footer'),
                    'attachments' => $data_request->input('attachments')
                ]; 
            $thisReturn=[];
            try {
                    \Mail::to($data['sendTo'])
                    ->cc($data['ccTo'])
                    ->send(new PFMail($data));  
                    $thisReturn =["num" => 1,"status" =>"Success","msg" => "Success"];
                } catch (\Throwable $th) { 
                    $thisReturn =["num" => 0,"status" =>"Failed","msg" =>$th->getMessage()];

                } 
            return $thisReturn;
   }
 

    function updateEnvValue($key, $value){
        $envFile = base_path('.env'); // Path to the .env file

        if (file_exists($envFile)) {
            $envContents = file_get_contents($envFile);

            // Check if the key exists in the .env file
            if (strpos($envContents, $key) !== false) {
                // Update the existing key value
                $envContents = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContents);
            } else {
                // If the key does not exist, append it
                $envContents .= PHP_EOL . "{$key}={$value}";
            }

            // Write the modified contents back to the .env file
            file_put_contents($envFile, $envContents);
        }
    }


    function f_encrypt_column_in_result($result, $obj, $traget_obj, $new_obj, $mode, $identityId){

        $num = 0;
        foreach ($result as $rows) {
            $result[$num]->$new_obj = $this->f_endecrypt($rows->$traget_obj, $mode, $identityId);
            $num++;
        }

        return $result;
    }

    public function getIPAddress()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = 'UNKNOWN';

        return $ip;
    }


    // public function getIp(){
    //     foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
    //         if (array_key_exists($key, $_SERVER) === true){
    //             foreach (explode(',', $_SERVER[$key]) as $ip){
    //                 $ip = trim($ip); // just to be safe
    //                 if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
    //                     return $ip . " hi";
    //                 }
    //             }
    //         }
    //     }
    //     return request()->ip();
    // }
}
