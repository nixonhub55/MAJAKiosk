<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class OfficialBusinessModel extends Model
{

	protected $authentication; 
    public function __construct() {
        $this->authentication = new Authentication(); 
    }

    public function delete_all_ob_approver($id){
        $query = DB::table('officialbusinessform_approver')->where('approverId', $id)->delete();
        return $query;
    }

    public function insert_all_ob_approver($id){

        $this->delete_all_ob_approver($id);

        $query = " 
        INSERT INTO officialbusinessform_approver
		SELECT
		officialbusinessform.*,
		dep.`departmentName`,
		cost.`costName`,
		approval.templateCode,
		approval.templateLineId,
		payrollperioddetails.payrollPeriodApproverLocked,
		'$id'

		FROM approvaltemplateoriginator

		LEFT JOIN approval ON
		approvaltemplateoriginator.id = approval.id

		LEFT JOIN approvaltemplatestages ON
		approvaltemplatestages.code = approval.templateCode AND
		approvaltemplatestages.lineId = approval.templateLineId AND
		approvaltemplateoriginator.code = approvaltemplatestages.code

		LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode

		LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code

		LEFT JOIN officialbusinessform ON
		officialbusinessform.obAppNo = approval.appNo

		LEFT JOIN department dep ON
		dep.`departmentCode` = officialbusinessform.`department`
		
		LEFT JOIN costcenter cost ON
		cost.`costCode` = officialbusinessform.`obCosCenter`

		LEFT JOIN identity ON
		approval.id = identity.identityId

		LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode

		LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

		LEFT JOIN payrollperiod ON
		identity.paymentFrequency = 
		(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
		WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
		WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)
		AND YEAR(officialbusinessform.obDateFrom) = payrollperiod.`payrollPeriodYear`

		LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code AND

		payrollperioddetails.payrollPeriodFrom <= officialbusinessform.obDateFrom AND
		payrollperioddetails.payrollPeriodTo >= officialbusinessform.obDateTo

		WHERE 

		approval.document = 'officialbusiness' AND
		approvalstagedetails.id = '$id' AND approval.decision = 'F' 
		AND identity.`payrollPeriodID` = payrollperiod.`payrollPeriodID`
		
		GROUP BY officialbusinessform.obAppNo";

        $result =  DB::statement($query);
    
        if ($result){
            return true;
        }else{
            return false;
        }

    }

    public function get_all_ob_approver($id){
        $query = "
            SELECT * FROM officialbusinessform_approver WHERE approverId = '$id'
        ";
        $result =  DB::statement($query);
        return (array)$result;
    }

	public function sp_ob_application_get_officialbusinesslist($spParams){  
        $str = $this->exec_store_proc('sp_ob_application_get_officialbusinesslist', $spParams);   
        return $str;
	}  
 
	public function sp_ob_application_submit_request($spParams,$pintMode,$appNo){  
        $str = $this->exec_store_proc('sp_ob_application_submit_request', $spParams);   
        
        $start  = microtime(true);
        $activity = "Official Business -> ".(($appNo>0) ? "Update Request" : "Send Request"); 
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
            $approver1 = $this->authentication->sp_approval_get_authorizer([0, 1, $identityId,3,0]);
            $sendTo = array_column($approver1['rows'], 'emailAddress');  
            
            $email['subject']="Kiosk Update Official Business Request Pending Approval";
            $currentUrl = session()->get('currentUrl');
            
            $email['sendTo']=$sendTo;
            $email['CcTo']=[]; 
            $email['header']=["Hi Ma'am/Sir"]; 
            $email['content']=["
                                You have received a <b>Official Business</b> request submitted by ".$fullname.", which is now pending your review and approval.
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
	
	public function sp_ob_application_cancel($spParams){  
        $data = $this->exec_store_proc('sp_ob_application_cancel', $spParams);  
        $start  = microtime(true);
        if ($data['num']==1){
            $this->authentication->sp_userAuditTrails(1,'Official Business -> Cancel Request','Failed',$data['msg'],$start); 
        }else{
            $this->authentication->sp_userAuditTrails(1,'Official Business -> Cancel Request','Success',$data['msg'],$start); 
        }  

        return $data;
	}  
	
	public function sp_ob_application_get_all_request($spParams){  
        $str = $this->exec_store_proc('sp_ob_application_get_all_request', $spParams);   
        return $str;
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
