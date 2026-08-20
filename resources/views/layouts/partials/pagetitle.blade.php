@switch(true)  
                @case(request()->is('dashboard')) Dashboard @break
                @case(request()->is('dash_cust')) Dashboard @break
                @case(request()->is('my_profile')) My Profile @break
                @case(request()->is('new_announcement')) Announcement @break
                @case(request()->is('announcement_details')) Announcement @break
                @case(request()->is('web_helper*')) Help Center @break 
                @case(request()->is('search*')) Help Center / No Record Found @break 
                @case(request()->is('no_result_fround*')) Help Center / No Record Found @break 
                @case(request()->is('help_system_admin')) Help Center / System Admin @break 
                @case(request()->is('help_dashboard')) Help Center / Dashboard @break 
                @case(request()->is('help_payslip_record')) Help Center / Payslip Record @break
                @case(request()->is('help_thry_month_pay')) Help Center / 13th Month Pay @break
                @case(request()->is('help_twenty3_report')) Help Center / 2307 Report @break
                @case(request()->is('help_bir_form')) Help Center / BIR Form 2316 @break
                @case(request()->is('help_reports')) Help Center / Reports @break
                @case(request()->is('help_leave')) Help Center / Leave @break
                @case(request()->is('help_offset')) Help Center / Offset @break
                @case(request()->is('help_time_adjustment')) Help Center / Time Adjustment @break
                @case(request()->is('help_off_bus')) Help Center / Official Business @break
                @case(request()->is('help_appr_form')) Help Center / Appraisal Form @break
                @case(request()->is('help_auth_deduct')) Help Center / Authority to Deduct @break
                @case(request()->is('help_clrnce_from')) Help Center / Clearance Form @break
                @case(request()->is('help_system_access')) Help Center / System Access @break 
                @case(request()->is('hrd_application_dtls')) HRD Certificate Details @break 
                
                

                @case(request()->is('timeentry_approval')) Time Entry List For Approval @break
                @case(request()->is('overtime_approval')) Overtime List For Approval @break
                @case(request()->is('offset_approval')) Offset List For Approval @break
                @case(request()->is('leave_approval')) Leave List For Approval @break 
                @case(request()->is('time_adjust_approval')) Time Adjustment List For Approval @break
                @case(request()->is('ob_approval')) Official Business List For Approval @break
                @case(request()->is('sc_approval')) Schedule Change List For Approval @break
                @case(request()->is('hrd_approval')) HRD Certificate For Approval @break   
                @case(request()->is('clearance_approval')) Clearance For Approval @break   
                @case(request()->is('clearance_hr_view')) Clearance For Approval @break  
                @case(request()->is('overtimeExt_approval')) Extension Allowance For Approval @break  
                
                @case(request()->is('te_application')) Time Entry @break
                @case(request()->is('overtime_application')) Overtime / Under Time Applications @break
                @case(request()->is('offset_application')) Offset Applications @break 
                @case(request()->is('leave_application')) Leave Applications @break
                @case(request()->is('time_adj_application')) Time Adjustment Applications @break
                @case(request()->is('ob_application')) Official Business Applications @break
                @case(request()->is('sc_application')) Schedule Change Applications @break
                @case(request()->is('app_form_application')) Appraisal Form Applications @break
                @case(request()->is('hrd_application')) HRD Certificate Applications @break
                @case(request()->is('clearance')) Clearance Form @break
                @case(request()->is('authority_to_deduct')) Authority to Deduct @break  
                @case(request()->is('my_profile_details')) My Profile Details @break  
                @case(request()->is('my_profile_payroll')) My Profile Payroll @break 
                @case(request()->is('overtimeExt_application')) Extension Allowance Application @break 
                
                @case(request()->is('payslip_record')) Payslip Record @break
                @case(request()->is('th_month_apy')) 13th Month Pay @break
                @case(request()->is('twenty_report')) 2307 Report @break 
                @case(request()->is('bir_form_2316')) BIR Form 2316 @break 
                @case(request()->is('change_password')) Settings @break 



                @case(request()->is('hris_approval_personalinformation')) HRIS Approval @break 
                @case(request()->is('hris_approval_dependent')) HRIS Approval @break 
                @case(request()->is('appraisal_form_view_supervisor')) Appraisal Form Supervisor @break 
                @case(request()->is('appraisal_supervisor_approver')) Appraisal Form Approval @break 



                @default Default @break
            @endswitch