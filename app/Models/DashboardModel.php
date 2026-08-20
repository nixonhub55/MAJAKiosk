<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Authentication;

use Illuminate\Support\Facades\Mail;
class DashboardModel extends Model
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
   
        public function sp_for_approval_get_all_count($num, $identityId) {
            //$result = $this->exec_store_proc('sp_for_approval_get_all', [$num, $identityId]);
            //$result = $this->exec_store_proc('sp_for_approval_get_all_detail', [$num, $identityId]);
            //sp_application_info
            $result = $this->exec_store_proc('sp_application_info', [1,$num,0,$identityId,'F','1991-01-01','',$_POST['r_opt'] ?? '']);
             
            if (isset($result['rows']) && is_array($result['rows'])) {
                return count($result['rows']);
            }
            return 0;
        }
        
        
        public function sp_get_current_leave_balances($num,$id){
            $result = $this->exec_store_proc('sp_portal_get_leave_balance', [$num, $id]);

            return $result;
        }

        public function sp_user_dashboard_settings($spParams){
            return $this->exec_store_proc('sp_user_dashboard_settings', $spParams);
        }
        
        public function sp_employee_bio_logs($spParams){
            return $this->exec_store_proc('sp_employee_bio_logs', $spParams);
        }

        public function sp_get_employee_schedules($spParams){
            return $this->exec_store_proc('sp_get_employee_schedules', $spParams);
        }

        public function sp_loan_overview($spParams){
            return $this->exec_store_proc('sp_loan_overview', $spParams);
        }
        

        public function sp_dtr_logs_insert($spParams){
            //return $this->exec_store_proc('sp_dtr_logs_insert', $spParams); 
            $data = $this->exec_store_proc('sp_dtr_logs_insert', $spParams); 
            $start  = microtime(true);
            $pintMode = $spParams[0];
            $dtrType =  $spParams[1];
            $activity = "DTR -> ".$dtrType;
            if($pintMode==1 && $data['num']==1){
                $this->authentication->sp_userAuditTrails(1,$activity,'Failed',$data['msg'],$start); 
            }else{
                if($pintMode==1  && $data['num']==0){
                    $this->authentication->sp_userAuditTrails(1,$activity,'Success',$data['msg'],$start); 
                }else{
                    $msg = ($data['msg']=="") ? "Yes/No confirmation" : $data['msg'];
                    $this->authentication->sp_userAuditTrails(1,$activity,'info','Validation -> '.$msg,$start); 
                }   
            }  
            return $data;

        }
        
        public function sp_portal_process_dtr_logs($num,$id){
            $this->sp_portal_get_dtr_logs('0',$id);
            $result =  $this->exec_store_proc('sp_portal_process_dtr_logs', [$num, $id]); 
            return $result;
        }

        public function sp_get_lms_license($spParams){
            return $this->exec_store_proc('sp_get_lms_license', $spParams);
        }

        public function sp_get_rbp_license($spParams){
            return $this->exec_store_proc('sp_get_rbp_license', $spParams);
        }

        public function sp_portal_get_dtr_logs($num, $id){
            $result =  $this->exec_store_proc('sp_portal_get_dtr_logs', [$num, $id]);
            return $result;
        }

        public function sp_portal_dtr_vew_per_cutoff_process($identityId, $payrollperiodId){
            $result = $this->exec_store_proc('sp_portal_dtr_vew_per_cutoff_process', [$payrollperiodId,$identityId]);
            return $result;
        }


        public function sp_portal_get_posted_dtr_dates($id){
            $result = $this->exec_store_proc('sp_portal_get_posted_dtr_dates', [0, $id]);
            return $result;
		}

        public function sp_portal_get_all_approvals($num, $identityId){
            $result = $this->exec_store_proc('sp_portal_get_all_approvals',[$num,$identityId]);
            return $result;
        }
        public function sp_portal_get_all_approvals_count($num, $identityId){
            $result = $this->exec_store_proc('sp_portal_get_all_approvals_count', [$num, $identityId]);
            return $result;
        }

        public function sp_portal_get_all_pending_applications($num, $identityId){
            //$result = $this->exec_store_proc('sp_portal_get_all_pending_applications', [$num, $identityId]);
            $result = $this->exec_store_proc('sp_application_info', [0,$num,0,$identityId,'P','1991-01-01','',$_POST['r_opt'] ?? '']); 
            if (isset($result['rows']) && is_array($result['rows'])) {
                return count($result['rows']);
            }
            return 0;
        }
}
