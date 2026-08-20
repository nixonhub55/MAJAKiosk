<?php 
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;
use Illuminate\Support\Facades\Session;
class HRISApprovalModel extends Model
{
      protected $authentication; 
      public function __construct() {
            $this->authentication = new Authentication(); 
      }

      /* List */
      public function sp_portal_get_hris_for_approval_list($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_for_approval_list', $spParams);   
            return $str;
	}
       /* Changelogs */
      public function sp_portal_get_hris_for_approval_view($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_for_approval_view', $spParams);   
            return $str;
	}
      
      /* History */
      public function sp_portal_get_hris_for_approval_history($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_for_approval_history', $spParams);   
            return $str;
	}
      /* Approve */
      public function sp_portal_get_hris_for_approval_approve($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_for_approval_approve', $spParams);   
            return $str;
	}
      /* Disapprove */
      public function sp_portal_get_hris_for_approval_disapprove($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_for_approval_disapprove', $spParams);   
            return $str;
	}


      public function sp_portal_get_hris_approval_template($spParams){  
            $str = $this->exec_store_proc('sp_portal_get_hris_approval_template', $spParams);   
            return $str;
	}

   

      // public function sp_myprofile_edit_information($spParams){  
      //       $str = $this->exec_store_proc('sp_myprofile_edit_information', $spParams);   
      //       return $str;
	// }


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


?>