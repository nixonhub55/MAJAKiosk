<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Authentication;

class CalendaModel extends Model
{

    protected $authentication; 
    public function __construct() {
        $this->authentication = new Authentication(); 
    }
    
    public function exec_store_proc($spName,$spParams){  

        try {
            
                $database = Session::get('database');
                DB::purge('mysql');
                config(['database.connections.mysql.database' => $database]); 

                $param_count = "";
                foreach ($spParams as $param) {
                    $param_count = $param_count."?,";
                } 

                $results = DB::select(
                    'CALL '.$spName.'('.$param_count.' @num, @msg)', $spParams
                );

                $output = DB::select('SELECT @num AS num, @msg AS msg'); 
                $num = $output[0]->num;
                $msg = $output[0]->msg;

                $final_result = ["rows" =>$results, "num" => $num, "msg"=>$msg];

                return $final_result;

        } catch (\Throwable $e) {
            
            $final_result_catch = ["rows" =>[], "num" => 1, "msg"=>$e->getMessage()];
            return $final_result_catch;
        }
    
    }
    

    public function sp_get_employee_schedule($spParams){
        return $this->exec_store_proc('sp_get_employee_schedule', $spParams);
    }

    public function load_sched_advanced($mode,$identityId,$start,$end){ 
         
      
        $start = ($start=='' ? null : $start);
        $end = ($end=='' ? null : $end);
       
        $start_format = date('Y-m-d', $start);
        $end_format = date('Y-m-d', $end);

        return  $this->sp_load_calendar_sched_advanced([$mode,$identityId,$start_format,$end_format]);  

    }

    public function sp_load_calendar_sched_advanced($spParams){
        return $this->exec_store_proc('sp_load_calendar_sched_advanced', $spParams);
    }
        
    public function sp_load_calendar_sched($spParams){
        return $this->exec_store_proc('sp_load_calendar_sched', $spParams);
    }

    public function sp_load_sched_day($spParams){
        return $this->exec_store_proc('sp_load_sched_day', $spParams);
    }

    public function sp_load_schedules($spParams){
        return $this->exec_store_proc('sp_load_schedules', $spParams);
    }

    public function sp_schedule_change($spParams,$pintMode,$appNo){

        $str = $this->exec_store_proc('sp_schedule_change',$spParams);
        $start  = microtime(true);
        $activity = "Schedule Change -> ".(($appNo>0) ? "Update Request" : "Send Request"); 
        if ($pintMode==1 && $str['num']==1){
            $this->authentication->sp_userAuditTrails(1,$activity,'Failed',$str['msg'],$start); 
        }else{
            if($pintMode==1  && $str['num']==0){
                $this->authentication->sp_userAuditTrails(1,$activity,'Success',$activity." with application No.".$str['msg']." has been successfully submitted for approval",$start); 
            }else{
                $msg = ($str['msg']=="") ? "Yes/No confirmation" : $str['msg'];
                $this->authentication->sp_userAuditTrails(1,$activity,'info','Validation -> '.$msg,$start); 
            } 
        }
        
        $appNo = ($appNo==false ? 0 : $appNo);

        if ($pintMode==1 && $str['num']==0){
             $fullname=session()->get('fullname');
             $identityId = session()->get('identityId');
             $approver1 = $this->authentication->sp_approval_get_authorizer([0, 1, $identityId,6,0]);
             $sendTo = array_column($approver1['rows'], 'emailAddress');  
             
            $email['subject']="Kiosk Schedule Change Request Pending Approval";
            $currentUrl = session()->get('currentUrl');
            
            $email['sendTo']=$sendTo;
            $email['CcTo']=[]; 
            $email['header']=["Hi Ma'am/Sir"]; 
            $email['content']=["
                                You have received a <b>Schedule Change</b> request submitted by ".$fullname.", which is now pending your review and approval.
                                </br></br>
                                Application #:".$str['msg']."
                                </br></br>
                                To review and take action on this request, please click the link below:<br>
                                <i style='color:blue'><u>".$currentUrl."</u></i>
                                "]; 
            $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
             $this->authentication->sendEmail(new Request($email));
         } 
 
         return $str;

       
        //return $this->exec_store_proc('sp_schedule_change', $spParams);
    }
         
}
