<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloMail; 
use App\Mail\PFMail;
use PhpParser\Node\Stmt\Foreach_;

/* use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail; */

class PfCommonModel extends Model
{
  

    public function pf_common_exec_store_proc($spName, $spParams){

        try {

            $database = 'pf-common';
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

  
    
}
