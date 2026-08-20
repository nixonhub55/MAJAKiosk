<?php

namespace App\Http\Controllers;
use App\Models\DashboardModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    protected $dashboard_model;
    public function __construct()
    {

        $this->dashboard_model = new DashboardModel();
    }



    /* public function show_dtr_view(){ 
        // $identityId = session()->get('identityId'); 
        $identityId = '0601200005'; 
        // $year = $_POST['payrollPeriodId'];  
        $year = '1-2';  
       // echo "<script>alert('".$identityId." and ".$year."')</script>"; 
    //    0601200005
    // 1-2
        $data['dtrView'] = $this->dashboard_model->sp_portal_dtr_vew_per_cutoff_process($identityId, $year);  
       // echo json_encode($data);
        return view('layouts.partials.dashboard.DtrViewCutoff',$data);
    } */

    public function show_dtr_view(){   
        $payrollPeriodId = $_POST['payrollPeriodId']; 
        $identityId = session()->get('identityId');  
        $data['payrollPeriodId'] = $payrollPeriodId; 
        $data['identityId'] = $identityId; 
        $data['dtrView'] = $this->dashboard_model->sp_portal_dtr_vew_per_cutoff_process($identityId, $payrollPeriodId);   
        return view('layouts.partials.dashboard.DtrViewCutoff',$data);
    }

    public function show_loans(){   
        /* $payrollPeriodId = $_POST['payrollPeriodId']; 
        $identityId = session()->get('identityId');  
        $data['payrollPeriodId'] = $payrollPeriodId; 
        $data['identityId'] = $identityId; 
        $data['dtrView'] = $this->dashboard_model->sp_portal_dtr_vew_per_cutoff_process($identityId, $payrollPeriodId);   
        return view('layouts.partials.dashboard.DtrViewCutoff',$data); */

        //$this->dashboard_model->sp_loan_overview([0,$identityId,'','']);
        
         $identityId = session()->get('identityId');  
         $df = $_POST['df']; 
         $dt = $_POST['dt']; 
         $data['loans'] = $this->dashboard_model->sp_loan_overview([0,$identityId, $df,$dt]);  
         return view('layouts.partials.dashboard.employeeLoans',$data);


    }

}
