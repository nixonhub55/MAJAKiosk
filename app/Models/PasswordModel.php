<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateTimeZone;
class PasswordModel extends Model
{
    
    public function exec_store_proc($spName, $spParams)
    {

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

    // 0. Select password complexity
    // 1. Select captcha
    // 2. Select password length
    // 3. Select password reuse
    // 4. Select changeinit
    // 5. Select password expired days 
    // 6. Select lockouttype
    // 7. Select lockout duration
    // 8. Select logattempt

    /** COMPANY SETTINGS  FUNCTIONS **/
    
     

    public function get_userDevice(){ 
        $data['user_device'] = [];
        array_push($data['user_device'],[ "user_agent" => $_SERVER['HTTP_USER_AGENT'], "ip_address" => $_SERVER['REMOTE_ADDR']]);
        return $data;
    }

    
    public function sp_portal_mfa($spParam)
    {
         return $this->exec_store_proc('sp_portal_mfa',$spParam); 
    }

    public function sp_portal_get_passwordComplexity()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['0']);
        return $result;
    }

    public function sp_portal_get_enableCaptcha()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['1']);
        return $result;
    }

    public function sp_portal_get_passwordLength()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['2']);
        return $result;
    }

    public function sp_portal_get_passwordReuseRestriction()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['3']);
        return $result;
    }

    public function sp_portal_get_passwordChangeInitLogon()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['4']);
        return $result;
    }

    public function sp_portal_get_passwordExpiredDays()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['5']);
        return $result;
    }

    public function sp_portal_get_lockedOutRecoveryType()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['6']);
        return $result;
    }

    public function sp_portal_get_lockedOutDuration()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['7']);
        return $result;
    }

    public function sp_portal_get_logAttempts()
    {
        $result = $this->exec_store_proc('sp_portal_get_security_settings', ['8']);
        return $result;
    }




    public function sp_portal_get_failed_login($identityId)
    {
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [0, $identityId, "", "", 0, "", 0]);
        return $result;
    }



    /** LOCKOUT  FUNCTIONS **/

    public function sp_portal_new_password_validation($spParams)
    {
        return $this->exec_store_proc('sp_portal_new_password_validation',$spParams); 
    }

    public function sp_portal_insert_failed_login($identityId, $password, $database, $attempt, $ipAddress)
    {
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [1, $identityId, $password, $database, $attempt, $ipAddress, 0]);
        return $result;
    }

    public function sp_portal_get_lock_attempt($identityId)
    {
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [2, $identityId, "", "", 0, "", 0]);
        return $result;
    }

    public function sp_portal_update_user_attempt_lock($identityId, $attempt)
    {
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [3, $identityId, "", "", $attempt, "", NULL]);
        return $result;
    }

    public function sp_portal_get_last_login_attempt($identityId)
    {
        $ip = $this->getIPAddress();
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [4, $identityId, "", "", 0, $ip, 0]);
        return $result;
    }

    public function sp_portal_forgot_password_validation($spParams)
    {

        /* session()->put('database', "mdb_demo_v4");  */
        return $this->exec_store_proc('sp_portal_forgot_password_validation', $spParams);
    }


    public function sp_portal_update_user_attempt($identityId)
    {
        $ip = $this->getIPAddress();
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [5, $identityId, "", "", 0, $ip, 0]);
        return $result;
    }
    public function sp_portal_update_accesslocked($identityId, $logAttempts){
        $result = $this->exec_store_proc('sp_portal_get_failed_login', [3, $identityId, "", "", $logAttempts, "", 1]);
        return $result;
    }
    public function get_employee_lockout_auto_status($identityId)
    {
        
        $lastAttempt = $this->sp_portal_get_last_login_attempt($identityId);
        $lastAttemptString = $lastAttempt['rows'][0]->attempted_at ?? null;
        $userLogAttempt = $lastAttempt['rows'][0]->logAttempts ?? 0;

         
        // echo "<script>alert('".json_encode($userLogAttempt)."')</script>";
        // return;

        if ($userLogAttempt) { 
            //$lastAttemptString = $lastAttempt['rows'][0]->attempted_at ?? null;
           // $userLogAttempt = $lastAttempt['rows'][0]->logAttempts ?? 0;
            // return $lastAttempt;
            $settingsLogAttempts = $this->sp_portal_get_logAttempts();
            $settingsLogAttempts = $settingsLogAttempts['rows'][0]->logAttempts;
 

            $lockoutDuration = $this->sp_portal_get_lockedOutDuration();
            $lockoutDuration = $lockoutDuration['rows'][0]->lockedOutDuration;

            if ($settingsLogAttempts == 0 || $settingsLogAttempts == null) {
                $settingsLogAttempts = 6;
            }
 

            $timeNow = new DateTime("now", new DateTimeZone('Asia/Manila'));

            if ($lastAttemptString) {
 
                $userAttemptDate = new DateTime($lastAttemptString, new DateTimeZone('Asia/Manila'));
                $interval = $timeNow->diff($userAttemptDate);
                $minutesDifference = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                //if ($userLogAttempt > $settingsLogAttempts && $minutesDifference <= $lockoutDuration) {
                //if (($userLogAttempt >= $settingsLogAttempts) && ($minutesDifference <= $lockoutDuration)) { 
                
                //if ((($userLogAttempt+1) >= $settingsLogAttempts) && ($minutesDifference <= $lockoutDuration)) { 
                if ((($userLogAttempt) >= $settingsLogAttempts) && ($minutesDifference <= $lockoutDuration)) { 
                    $this->sp_portal_update_accesslocked($identityId, $userLogAttempt);
                    //true as lock 
                    echo json_encode($userLogAttempt);

                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }


        } else {
            return false;
        }





    }

    public function get_employee_lockout_manual_status($identityId)
    {



        $lastAttempt = $this->sp_portal_get_last_login_attempt($identityId);
        $lastAttemptString = $lastAttempt['rows'][0]->attempted_at ?? null;
        $userLogAttempt = $lastAttempt['rows'][0]->logAttempts ?? 0;

        if ($userLogAttempt) {

            $settingsLogAttempts = $this->sp_portal_get_logAttempts();
            $settingsLogAttempts = $settingsLogAttempts['rows'][0]->logAttempts ?? null;

         

            if ($settingsLogAttempts == 0 || $settingsLogAttempts == null) {
                $settingsLogAttempts = 6;
            }

            //if ($userLogAttempt > $settingsLogAttempts) {
            if ($userLogAttempt >= $settingsLogAttempts) {
                $this->sp_portal_update_accesslocked($identityId,$userLogAttempt);
                $isAccessLocked = $this->sp_portal_get_lock_attempt($identityId);
                $isAccessLocked = $isAccessLocked['rows'][0]->access_locked ?? null;
                if ($isAccessLocked == 1) {
                    //true as lock
                    return true;
                }


            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    /** Password Expire FUNCTIONS **/

    public function sp_portal_get_user_password_logs($identityId, $password)
    {
        $result = $this->exec_store_proc('sp_portal_get_user_password_logs', [0, $identityId, $password]);
        return $result;
    }

    public function sp_portal_get_latest_password_logs($identityId)
    {
        $result = $this->exec_store_proc('sp_portal_get_user_password_logs', [1, $identityId, ""]);
        return $result;
    }

    public function sp_portal_insert_password_logs($identityId, $password)
    {
        $result = $this->exec_store_proc('sp_portal_insert_user_password_logs', [0, $identityId, $password]);
        return $result;
    }

    public function sp_portal_update_user_status($identityId)
    {
        $result = $this->exec_store_proc('sp_portal_insert_user_password_logs', [1, $identityId, '']);
        return $result;
    }

    function isPasswordExpired($username)
    {
        $latestPasswordLog = $this->sp_portal_get_latest_password_logs($username);

        if (empty($latestPasswordLog['rows'])) {
            return true; // If no password log exists, consider it expired
        }

        $passwordCreatedDate = new DateTime($latestPasswordLog['rows'][0]->dateCreated);
        $currentDate = new DateTime();
        $expiryDays = 90;

        return $passwordCreatedDate->diff($currentDate)->days >= $expiryDays;
    }






    /** GENERAL FUNCTIONS **/



    public function sp_portal_update_user_password($identityId, $password)
    {
        $result = $this->exec_store_proc('sp_portal_update_user_password', [0, $identityId, $password]);
        return $result;
    }





    public function password_complexity($password)
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/';
        return preg_match($pattern, $password);
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
}
