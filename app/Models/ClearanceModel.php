<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ClearanceModel extends Model
{
    protected $authentication; 
    public function __construct() {
        $this->authentication = new Authentication(); 
    }

    public function sp_clearance_get_form($spParams){  
        $str = $this->exec_store_proc('sp_clearance_get_form', $spParams);   
        return $str;
	} 

    public function sp_clearance_get_form_list($spParams){  
        $str = $this->exec_store_proc('sp_clearance_get_form_list', $spParams);   
        return $str;
	}     

    public function sp_clearance_get_header_info($spParams){  
        $str = $this->exec_store_proc('sp_clearance_get_header_info', $spParams);   
        return $str;
	}   
    public function sp_clearance_get_tin($spParams){  
        $str = $this->exec_store_proc('sp_clearance_get_tin', $spParams);   
        return $str;
	}

    public function sp_get_clearance_for_approval($spParams){  
        $str = $this->exec_store_proc('sp_get_clearance_for_approval', $spParams);   
        return $str;
	}

    public function sp_get_clearance_for_approval_details($spParams): array{  
        $str = $this->exec_store_proc('sp_get_clearance_for_approval_details', $spParams);   
        return $str;
	}

    public function sp_insert_clearance_status($spParams): array{  
        $str = $this->exec_store_proc('sp_insert_clearance_status', $spParams);   
        return $str;
	}
    
    public function sp_get_clearance_for_approvalHistory($spParams): array{  
        $str = $this->exec_store_proc('sp_get_clearance_for_approvalHistory', $spParams);   
        return $str;
	}
    public function sp_get_clearance_for_hr($spParams): array{  
        $str = $this->exec_store_proc('sp_get_clearance_for_hr', $spParams);   
        return $str;
	}

    public function sp_acknowledge_clearance($spParams): array{  
        $str = $this->exec_store_proc('sp_acknowledge_clearance', $spParams);   
        return $str;
	}


    // public function sp_get_hr_status()


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