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
use App\Models\PfCommonModel;

/* use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail; */

class customizationModel extends Model
{

     protected $pfcommonmodel;
     public function __construct()
    {
        $this->pfcommonmodel = new PfCommonModel();
    }

    //get the databases
    public function get_database()
    {

        /* $client_host = $_SERVER['HTTP_HOST']; 
        $client_host = explode(':', $client_host)[0];
        $client_host = explode('.', $client_host)[0]; */
        $client_host = session()->get('hostName');
        
        /* $databases = DB::table('db_profile as a')
                    ->select('a.db_name', DB::raw("
                        CASE 
                            WHEN UPPER(a.db_name) LIKE '%PROD%' THEN CONCAT(a.db_description, '(PROD)') 
                            WHEN UPPER(a.db_name) LIKE '%TEST%' THEN CONCAT(a.db_description, '(TEST)') 
                            ELSE a.db_description 
                        END AS db_description
                    "), 'a.isvisible')
                    ->where('a.isvisible', 1)
                    ->orderBy('db_description')
                    ->get()
                    ->toArray();  */
        
        $databases = DB::table('v_kiosk_database_host as t1')
        ->leftJoin('db_profile as t2', 't1.name', '=', 't2.db_name')
        ->select('t2.*', 't1.hostName')
        ->where('t1.hostName', $client_host)
        ->get()
        ->toArray();
 
        //echo json_encode($databases);

        $client_db = []; 
        $extracted_db = [];
 

         
        $client_db[] =["hostName" => "msipf", "dbName" => "materials_solutions_inc"];
        $client_db[] =["hostName" => "pfstand", "dbName" => "aaisiv4"];
        $client_db[] =["hostName" => "ftlive4", "dbName" => "cambe_dental_inc"];
        $client_db[] =["hostName" => "gxi", "dbName" => "gxinternational"];

        $currnetHost = "";
        foreach ($client_db as $client) {

            if($client_host==$client['hostName']){ 
                foreach ($databases as $db) { 
                   if ($db->db_name==$client['dbName']){ 
                       $extracted_db[] =$db;
                   }
                }
            }
            
        }  
            //return $extracted_db;
            return $databases;
    }

     public function company_customization(){

       
        /* $customized_elements = [];

        $customized_elements[] = ["name" => "dtr","visibility" =>1];


        //MSI CUSTOMIZATION
        if ($client_host=="msipf"){

            $customized_elements = array_map(fn($e) => $e['name'] === 'dtr' ? ['name' => $e['name'], 'visibility' => 0] : $e, $customized_elements);
        
        }

         
        return $customized_elements; */
         
         $user_data = ["hostName" =>session()->get('hostName') ];
         $this->pfcommonmodel->pf_common_exec_store_proc('sp_tenants_table',[0,json_encode($user_data)]);  
         return $this->pf_common_exec_store_proc('sp_host_companySettings', [0,session()->get('hostName')]);

    } 

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

 

    public function exec_store_proc($spName, $spParams){

        try {

            $database = Session::get('database');
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
