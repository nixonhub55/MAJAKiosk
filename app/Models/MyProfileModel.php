<?php 
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;
use Illuminate\Support\Facades\Session;
class MyProfileModel extends Model
{
      protected $authentication; 
      public function __construct() {
            $this->authentication = new Authentication(); 
      }
      public function sp_myprofile_get_information($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_information', $spParams);   
            return $str;
	}
      
      public function sp_myprofile_edit_information($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_edit_information', $spParams);   
            return $str;
	}
      public function sp_myprofile_check_pending($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_check_pending', $spParams);   
            return $str;
	}
      public function sp_myprofile_get_emergencycontact($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_emergencycontact', $spParams);   
            return $str;
	}

      public function sp_myprofile_get_education($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_emergencycontact', $spParams);   
            return $str;
	}

      public function sp_myprofile_save_education($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_save_education', $spParams);   
            return $str;
	}
      public function sp_myprofile_save_contact($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_save_contact', $spParams);   
            return $str;
	}

      public function sp_myprofile_save_employement($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_save_employment', $spParams);   
            return $str;
	}
      public function sp_myprofile_save_training($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_save_training', $spParams);   
            return $str;
	}
      public function sp_myprofile_get_payroll($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_payroll', $spParams);   
            return $str;
	}

      public function sp_myprofile_get_payroll_previous($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_payroll', $spParams);   
            return $str;
	}
      public function sp_myprofile_get_payroll_accountability($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_payroll', $spParams);   
            return $str;
	}

      public function sp_myprofile_get_payroll_loan($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_payroll', $spParams);   
            return $str;
	}

      public function sp_myprofile_get_payroll_leaveBalance($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_get_payroll', $spParams);   
            return $str;
	}

      public function sp_myprofile_save_hmo_dependent($spParams){  
            $str = $this->exec_store_proc('sp_myprofile_save_hmo_dependent', $spParams);   
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