<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;
use Illuminate\Support\Facades\Session;


class AuthorityToDeductModel extends Model
{
      protected $authentication; 
      public function __construct() {
            $this->authentication = new Authentication(); 
      }


      public function sp_authority_to_deduct_get_list($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_get_list', $spParams);   
            return $str;
	} 


      public function sp_authority_to_deduct_get_list_history($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_get_list_history', $spParams);   
            return $str;
	} 

      public function sp_authority_to_deduct_get_details($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_get_details', $spParams);   
            return $str;
	} 

      public function sp_authority_to_deduct_acknowledge($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_acknowledge', $spParams);   
            return $str;
	}
      public function sp_authority_to_deduct_decline($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_decline', $spParams);   
            return $str;
	}
      public function sp_authority_to_deduct_add_employee_deduction($spParams){  
            $str = $this->exec_store_proc('sp_authority_to_deduct_add_employee_deduction', $spParams);   
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





?>