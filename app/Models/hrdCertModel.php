<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\Authentication;
use Illuminate\Http\Request;

class hrdCertModel extends Model
{

	protected $authentication; 
    public function __construct() {
        $this->authentication = new Authentication(); 
    }
 
 
	public function sp_hrd_cert_submit($spParams,$pintMode,$appNo){   
        $str = $this->exec_store_proc('sp_hrd_cert_submit', $spParams);  
        
        $start  = microtime(true);
        $activity = "HRD Certificate -> ".(($appNo>0) ? "Update Request" : "Send Request"); 
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

        if ($pintMode==1 && $str['num']==0){
            $fullname=session()->get('fullname');
            $identityId = session()->get('identityId');
            $approver1 = $this->authentication->sp_approval_get_authorizer([0, 1, $identityId,7,0]);
            $sendTo = array_column($approver1['rows'], 'emailAddress');  

            $email['subject']="Kiosk HRD Certificate Request Pending Approval";
            $currentUrl = session()->get('currentUrl');
            
            $email['sendTo']=$sendTo;
            $email['CcTo']=[]; 
            $email['header']=["Hi Ma'am/Sir"]; 
            $email['content']=["
                                You have received a <b>HRD Certificate</b> request submitted by ".$fullname.", which is now pending your review and approval.
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
	}  

    public function sp_hrd_cert_approval($spParams,$appNo,$attachments = NULL){  
        
        $decision = ($spParams[4]==1 ? "<b style='color:green'>approved</b>" : "<b style='color:red'>rejected</b>"); 
        $data  = $this->exec_store_proc('sp_hrd_cert_approval', $spParams);  

        $pintMode = $spParams[0];
        $start  = microtime(true);
        $activity = "HRD Certificate -> Approval"; 
        $msg = (json_decode($data['msg'],true)['msg']) ?? '';
        $dec =  ($spParams[4]==1 ? "approved" : "rejected"); 
        if ($pintMode==1 && $data['num']==1){
            $this->authentication->sp_userAuditTrails(1,$activity,'Failed',$msg,$start); 
        }else{
            if($pintMode==1  && $data['num']==0){
                $this->authentication->sp_userAuditTrails(1,$activity,'Success',"application No.".$appNo." has been successfully ".$dec,$start); 
            }else{
                $msg = ($msg=="") ? "Yes/No confirmation" : $msg;
                $this->authentication->sp_userAuditTrails(1,$activity,'info','Validation -> '.$msg,$start); 
            } 
        }

       if ($pintMode==1 && $data['num']==0){ 
            $formVal = $this->authentication->sp_get_document_info([0,7]); 
            $app_user = $this->authentication->sp_app_user_info([0,$appNo,7]);
            $appName = $formVal['rows'][0]->formVal; 
            
            $fullname=$app_user['rows'][0]->fullName; 
            $sendTo = array_column($app_user['rows'], 'emailAddress');   
            $email['sendTo']=$sendTo; 
            $email['CcTo']=[]; 
            $email['header']=["Hi Ma'am/Sir"]; 
            $email['subject']="Kiosk Update HRD Certificate Request Approval Response";
            $email['content']=["<b style='color:blue'>".$fullname."</b> your request about ".$appName." application#:".$appNo." has been ".$decision." by <b>".session()->get('fullname')."</b>. </br>kindly check this into our portal."]; 
            $email['footer']=["<b style='color:red'>Note</b>:<i>We cannot recieve your reply here. Thank you!</i>"]; 
            $email['attachments']=$attachments;
    
    
            $this->authentication->sendEmail(new Request($email)); 
       }

       return $data;  

      /*  $data['num'] = 1;
       $data['msg'] = json_encode(["id" => "lblfileCert","msg" => json_encode($decision)]); 
       return $data; */ 
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
                //$param_count=substr($param_count, 0, -1); 
                $results = DB::select(
                    'CALL '.$spName.'('.$param_count.' @num, @msg)', $spParams
                );

                $output = DB::select('SELECT @num AS num, @msg AS msg'); 
                $num = $output[0]->num;
                $msg = $output[0]->msg;

                $final_result = ["rows" =>$results, "num" => $num, "msg"=>$msg];

                return (array)$final_result;

        } catch (\Throwable $e) {
            
            $final_result_catch = ["rows" =>[], "num" => 1, "msg"=>$e->getMessage()];
            return $final_result_catch;
        }
  
    }
}
