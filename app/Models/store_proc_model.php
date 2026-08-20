<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class store_proc_model extends Model
{

    public function exec_store_proc($spName,$spParams){  
          
        try {

           if ($this->is_sp_exists($spName)==0){
            $error_result = ["rows" =>[], "num" => 1, "msg"=>$spName." does not exists"];
            return $error_result;
           }

            
            $param_count = "";
            $param_val =[]; 
    
            parse_str($spParams, $params); 
            foreach ($params as $key => $value) { 
                $param_val[] = $value; 
                $param_count = $param_count."?,";
            }
            $param_count=substr($param_count, 0, -1);
            
            $database = Session::get('database');
            DB::purge('mysql');
            config(['database.connections.mysql.database' => $database]);
    
            $results = DB::select(
                'CALL '.$spName.'('.$param_count.', @num, @msg)', $param_val
            );
    
            $output = DB::select('SELECT @num AS num, @msg AS msg'); 
            $num = $output[0]->num;
            $msg = $output[0]->msg;
    
            $final_result = ["rows" =>$results, "num" => $num, "msg"=>$msg];
    
            return $final_result;

        } catch (\Exception $e) {
            $final_result_catch = ["rows" =>[], "num" => 1, "msg"=>$e->getMessage()];
            return $final_result_catch;
        }  
    }


    public function is_sp_exists($spName){

        $database = Session::get('database');
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $database]);
        $result = DB::select("SHOW PROCEDURE STATUS WHERE name = '".$spName."'"); 
        return count($result);
    }
 
}
