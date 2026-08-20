<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class Report_PaysilpModel extends Model
{
     
    //get the databases
    public function get_database()
    {
        
        return DB::table('db_profile as a')
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
            ->toArray(); 
    }
    public function get_employee_payslip($id) {
        // Correct placeholder usage
        $query = "SELECT * FROM users WHERE username = ?";
        $query2 = "	SELECT 
			employeepayslip.code AS code, 
			employeepayslip.identityId AS identityId, 
			employeepayslip.payrollPeriod AS payrollPeriod, 
			employeepayslip.netPay AS netPay,
			IFNULL(employeepayslip.costCenter, employeemovement.`costCode`) AS costCenter, 
			IFNULL(employeepayslip.department, employeemovement.`departmentCode`) AS department,
			CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) AS period, 
			payrollperioddetails.payrollPeriodFrom AS payrollPeriodFrom, 
			payrollperioddetails.payrollPeriodTo AS payrollPeriodTo,
			payrollperioddetails.payrollPeriodPayDate AS payrollPeriodPayDate,
			employeebatchpayslip.status AS STATUS,
			employeebatchpayslip.payrollPeriod,
			employeebatchpayslip.payrollGroup
			FROM employeepayslip 
			LEFT JOIN  employeebatchpayslip
			ON employeepayslip.payslipbatchcode = employeebatchpayslip.payslipbatchcode 

			LEFT JOIN payrollperioddetails ON CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) = employeepayslip.payrollPeriod
			LEFT JOIN employeemovement ON employeemovement.`code` = employeepayslip.`employeeCode`
			LEFT JOIN `vw_rpt_max_employeemovement` ON `vw_rpt_max_employeemovement`.`Code` = employeemovement.`code` 			
			WHERE employeepayslip.identityId= ? 
			AND employeepayslip.payrollPeriod = CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) 
			AND	employeebatchpayslip.payrollPeriod = employeepayslip.payrollPeriod 
			AND employeebatchpayslip.`status`='A'
			AND `vw_rpt_max_employeemovement`.`LineId` = employeemovement.`lineId`";
        
        // Proper parameter binding
        $result = DB::select($query2, [$id]);
        
        return $result;
    }
    
    
}
