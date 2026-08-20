@extends('layouts.admin')  
@section('content')   

   


<div class="container my-4">
<i class="fas fa-search"></i> Related results for "<b style="color:#57a9b9"><?=$result?></b>".
</div>


    <div class="container"  id="content">    
 
        <div id="div_dashboard" class="divSearch" onclick="go_to_page('web_helper/div_dashboard')">
            <b>Dashboard</b>
            <br><br>
            <p>In this facility, user allow to track the counts of pending for Approval or Application of the employee. This also includes the DTR VIEW PER CUT - OFF, Leave Balances, Total Employee Application Received Per Cut - Off, Biometrics Data, Application Monitoring per Cut - Off and Leave balances, Creating Announcement
                and Checking Calendar Schedule.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related features in this facility</h5></i>
            
            <i class="content_p">How to check leave balances</i>
            <i class="content_p2">Leave balances is included in the dashboard from the bottom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=leaveBallbl")}}'>here</a> to view Leave balances</i>

            <i class="content_p">How to check my Daily Time Record (DTR)</i> 
            <i class="content_p2">Leave balances is included in the dashboard from the buttom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=dtrlbl")}}'>here</a> to view Leave balances</i>

            <i class="content_p">How to check Total Employee Application Received</i> 
            <i class="content_p2">Leave balances is included in the dashboard from the buttom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=forApprovallbl")}}'>here</a> to view Leave balances</i>

            <i class="content_p">How to check Biometrics Data</i> 
            <i class="content_p2">Leave balances is included in the dashboard from the buttom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=biolbl")}}'>here</a> to view Leave balances</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to check For Approval total</i> 
            <i class="content_p2">Leave balances is included in the dashboard from the buttom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=forApprovallbl")}}'>here</a> to view Leave balances</i>
            @endif

            <i class="content_p">How to check Application total</i>
            <i class="content_p2">Leave balances is included in the dashboard from the buttom part.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=applicationllbl")}}'>here</a> to view Leave balances</i>  
 

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to Create announcement</i>
            <i class="content_p2">This is refers to a public statement or declaration meant to inform people about something, such as news, events, changes, or important information. It can be made through various mediums like speeches, emails, posters, or social media.</i>
            <i class="content_p2">1.) Goto Dashboard / Announcement <a href='{{url("/dash_cust?id=announcelbl")}}'>here</a>.</i>
            <i class="content_p2">2.) In the right part of the phange, click [+ Create] button.</i><br>
            @endif

            <i class="content_p">How to check announcement</i>
            <i class="content_p2">This is refers to a public statement or declaration meant to inform people about something, such as news, events, changes, or important information. It can be made through various mediums like speeches, emails, posters, or social media.</i>
            <i class="content_p2">1.) Goto Dashboard / Announcement <a href='{{url("/dash_cust?id=announcelbl")}}'>here</a>.</i> 

            <i class="content_p">How to check my Calendar Schedule</i>
            <i class="content_p2">This is refers  is a plan or list of events, activities, or appointments organized by date and time, usually displayed in a calendar format. It helps individuals or organizations keep track of upcoming events, deadlines, or commitments.</i>
            <i class="content_p2">1.) Goto Dashboard / Schedule <a href='{{url("/dash_cust?id=announcelbl")}}'>here/a>.</i>
            <i class="content_p2">2.) You can use Next << and Previous >>  button to navigate month </i>
            <i class="content_p2">3.) You can click event details in the date </i>
            <i class="content_p2">4.) Click <a href='{{url("/dash_cust?id=calendarlbl")}}'>here/a> to go to Schedule Calendar</i><br>

            <i class="content_p">How to update my Schedules</i>
            <i class="content_p2">This is refers  is a plan or list of events, activities, or appointments organized by date and time, usually displayed in a calendar format. It helps individuals or organizations keep track of upcoming events, deadlines, or commitments.</i>
            <i class="content_p2">1.) Goto Dashboard / Schedule <a href='{{url("/dash_cust?id=calendarlbl")}}'>here/a>.</i>
            <i class="content_p2">2.) You can use Next << and Previous >>  button to navigate month </i>
            <i class="content_p2">3.) You can click event details in the date to change schedule</i>
             
            <i class="content_p">How to update my Pending modified schedule</i>
            <i class="content_p2">This is refers  is a plan or list of events, activities, or appointments organized by date and time, usually displayed in a calendar format. It helps individuals or organizations keep track of upcoming events, deadlines, or commitments.</i>
            <i class="content_p2">1.) click <a href='{{url("/sc_application")}}'>here</a> to view list of pending schedule</i>
            <i class="content_p2">2.) Click view icon to view details</i>
            <i class="content_p2">3.) Click button submit </i> 

            <i class="content_p">How to check my Application per Cut - Off</i>
            <i class="content_p2"> These are formal documents employees fill out to request approval for things like Entry Time, Overtime, Offset, Leave, Time Adjustment, Official Business and Schedule Change</i>
            <i class="content_p2">1.) click <a href='{{url("/dash_cust?id=appCutofflbl")}}'>here/a> to monitor application per cut - off.</i> 
           
            @if(session()->get('if_approver')==1)
                <i class="content_p">How to check  Employee Biometrics Logs</i>
                <i class="content_p2"> These  refer to the recorded data from a biometric system used to track employees’ time and attendance. These logs are usually collected through devices like fingerprint scanners, facial recognition, or hand geometry readers at entry/exit points.</i>
                <i class="content_p2">1.) click <a href='{{url("/dash_cust?id=empbiolbl")}}'>here/a> to monitor application per cut - off.</i> 
            @endif


            @if(session()->get('if_approver')==1)
                <i class="content_p">How to check  Employee Schedule</i>
                <i class="content_p2"> These  refer to the recorded employees schedule such as identity ID, Name, Day, Date and Schedule Name</i>
                <i class="content_p2">1.) click <a href='{{url("/dash_cust?id=EmpSchedlbl")}}'>here/a> to view Employee Schedule</i> 
            @endif
            
            <i class="content_p">How to check Employee Year To Date</i>
            <i class="content_p2">This is refers to the total amount of an employee's earnings or other relevant financial data accumulated from the beginning of the current calendar year (or fiscal year) up until the present date.</i>
            <i class="content_p2">Year to date is located at the bottom part of the dasboard.</i>
            <i class="content_p2">Click <a href='{{url("/dash_cust?id=ytdlbl")}}'>here/a> to view Leave balances</i>
        </div>  


        

        @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for Offset</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/offset_approval")}}'>Offset</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>

            <i class="content_p">How to reject application for Offset</i> 
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/offset_approval")}}'>Offset</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>
            @endif

    
        <div id="div_payrol_slip" class="divSearch" onclick="go_to_page('web_helper/div_payrol_slip')">
            <b>Payslip Record (SSRS)</b>
            <br><br>
            <p>A payslip record is an essential document that details an employee's earnings, deductions, and net pay for a specific pay period. It serves as a transparent record for employees, helps ensure compliance with tax and labor laws, and supports financial and payroll management for employers. Properly managing and issuing payslip records is critical for both employee satisfaction and organizational accountability.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to check my payslip</i>
            <i class="content_p2">1.) In web menu span <b>Reports</b></i>
            <i class="content_p2">2.) click <a href='{{url("/payslip_record")}}'>Payslip Record</a>.</i>

            <i class="content_p">How to check my deductions</i>  
            <i class="content_p2">Your deduction is also included in payroll slip report. just click <a href='{{url("/payslip_record")}}'>here</a>.</i> 
        </div>  

        
            
        <div id="div_13th_month" class="divSearch" onclick="go_to_page('web_helper/div_13th_month')">
            <b>13th Month Pay (SSRS)</b>
            <br><br>
            <p>13th Month Pay is an additional benefit provided to employees, typically in countries like the Philippines and other parts of Asia, where it is a legal requirement or a common practice. It is a form of monetary benefit granted to workers as a way of recognizing their contribution to the company and providing additional financial support, especially at the end of the year.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to check my bunos payroll for 13th Month pay</i>   
            <i class="content_p2">1.) In web menu span <b>Reports</b></i>
            <i class="content_p2">2.) click <a href='{{url("/th_month_apy")}}'>13th Month Payslip</a>.</i>

        </div>  

        <div id="div_2307" class="divSearch" onclick="go_to_page('web_helper/div_2307')">        
            <b>2307 Report (SSRS)</b>
            <br><br>
            <p>The 2307 Report is a document used primarily in the Philippines, associated with the Bureau of Internal Revenue (BIR). It is specifically linked to tax withholding and is used for documenting tax withheld at source from payments made to a taxpayer, typically for services rendered by independent contractors, professionals, or other non-employee individuals.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to check my 2307 BIR Report</i>   
            <i class="content_p2">1.) In web menu span <b>Reports</b></i>
            <i class="content_p2">2.) click <a href='{{url("/twenty_report")}}'>2307 Report</a>.</i>
        </div>  
    
        <div id="div_2316" class="divSearch" onclick="go_to_page('web_helper/div_2316')">
            <b>BIR Form 2316 (SSRS)</b>
            <br><br>
            <p>BIR Form 2316 is the Certificate of Compensation Payment/Tax Withheld, which is issued by employers to their employees in the Philippines. It provides a summary of an employee's total compensation for the year and the tax that has been withheld from their salary. The 2316 form is a vital document for employees as it helps them report their income and taxes during the annual income tax filing process.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to check 2316 BIR Report</i>   
            <i class="content_p2">1.) In web menu span <b>Reports</b></i>
            <i class="content_p2">2.) click <a href='{{url("/bir_form_2316")}}'>BIR Form 2316</a>.</i>
        </div>  

        <div id="div_timeentry" class="divSearch" onclick="go_to_page('web_helper/div_timeentry')">
            <b>Time Entry</b>
            <br><br>
            <p> allows users to log their work hours, track time spent on tasks/projects, and sometimes even generate reports or invoices from that data.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to create application for Time Entry</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/te_application")}}'>Time Entry</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>

            <i class="content_p">How to update application for Time Entry</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/te_application")}}'>Time Entry</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for Time Entry</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/te_application")}}'>Time Entry</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>



            <i class="content_p">How to reject application for Time Entry</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/te_application")}}'>Time Entry</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>
            @endif


            <i class="content_p">How to discard application for overtime</i>
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_application")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">4.) Click <b>Yes</b> in confirmation box. End</i>

        </div> 
    
        <div id="div_overtime" class="divSearch" onclick="go_to_page('web_helper/div_overtime')">
            <b>Overtime</b>
            <br><br>
            <p>Overtime in an office setting refers to the additional work hours that an employee works beyond their regular or contracted working hours. It typically occurs when employees work more than the standard 40 hours per week (or whatever the company's normal schedule is). Overtime is usually compensated at a higher pay rate, commonly referred to as "time and a half" or "double time," depending on company policy or labor laws in the region.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to create application for overtime</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_application")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>

            <i class="content_p">How to update application for overtime</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_application")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for overtime</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_approval")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>



            <i class="content_p">How to reject application for overtime</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_approval")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>
            @endif


            <i class="content_p">How to discard application for overtime</i>
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/overtime_application")}}'>Overtime</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">4.) Click <b>Yes</b> in confirmation box. End</i>

        </div>  
    
        <div id="div_offset" class="divSearch" onclick="go_to_page('web_helper/div_offset')">
            <b>Offset</b>
            <br><br>
            <p>Offset in the context of work and office hours typically refers to a practice where an employee compensates for extra hours worked (overtime) by taking time off at a later date. It's essentially a way to "balance out" or "offset" the additional hours worked with time off, rather than receiving immediate extra pay. This can be a way to manage work-life balance without overburdening employees with too much time at the office</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            <i class="content_p">How to create application for Offset</i>   
            
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/offset_application")}}'>Offset</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>

 
            <i class="content_p">How to update application for Offset</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/offset_application")}}'>Offset</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

           

            <i class="content_p">How to discard application for Offset</i>
            <i class="content_p2">2.) click <a href='{{url("/offset_approval")}}'>Offset</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">4.) Click <b>Yes</b> in confirmation box. End</i>
        </div>  

        <div id="div_leave" class="divSearch" onclick="go_to_page('web_helper/div_leave')">
            <b>Leave</b>
            <br><br>
            <p>leave refers to authorized time off from work, which an employee can take for various reasons. Leave can be paid or unpaid, depending on the company's policy and the reason for the leave.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            <i class="content_p">How to create application for Leave</i>
            
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/leave_application")}}'>Leave</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>
 

            <i class="content_p">How to update application for Leave</i>
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/leave_application")}}'>Leave</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for Leave</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/leave_approval")}}'>Leave</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>


            <i class="content_p">How to reject application for Leave</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/leave_approval")}}'>Leave</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>
            @endif

            <i class="content_p">How to discard application for Leave</i>
            <i class="content_p2">2.) click <a href='{{url("/leave_approval")}}'>Leave</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">4.) Click <b>Yes</b> in confirmation box. End</i>
        </div>  

        <div id="div_time_adj" class="divSearch" onclick="go_to_page('web_helper/div_time_adj')">
            <b>Time Adjustment</b>
            <br><br>
            <p>Time adjustment in the context of the workplace refers to the process of modifying an employee’s work schedule or hours worked to account for different factors, such as overtime, time off, flexible work arrangements, or special requests. This practice allows both employers and employees to manage work hours in a way that aligns with their needs, ensuring fairness and compliance with company policies or labor laws.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to create application for Time Adjustment</i>
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/time_adj_application")}}'>Time adjustment</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>
 
  
            <i class="content_p">How to update application for Time Adjustment</i>
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/time_adj_application")}}'>Time adjustment</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for Time Adjustment</i>
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/time_adjust_approval")}}'>Time adjustment</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>

            
            <i class="content_p">How to reject application for Time Adjustment</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/time_adjust_approval")}}'>Time adjustment</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>
            @endif


            <i class="content_p">How to discard application for Time Adjustment</i>
            <i class="content_p2">1.) click <a href='{{url("/time_adj_application")}}'>Time adjustment</a>.</i>
            <i class="content_p2">2.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">3.) Click <b>Yes</b> in confirmation box. End</i>
        
        </div>  

        <div id="div_offi_bus" class="divSearch" onclick="go_to_page('web_helper/div_offi_bus')">
            <b>Official Business</b>
            <br><br>
            <p>Official business refers to activities or tasks that an employee performs on behalf of their employer, usually related to the company's operations, goals, or interests. This can involve tasks that require an employee to leave their usual work location or involve specific duties that are part of their job description. Official business typically covers a wide range of activities and often carries specific policies or guidelines related to time, compensation, and expenses.</p>
            <l>Learn more...</l>
            <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i>
            
            <i class="content_p">How to create application for Official Business</i> 
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/ob_application")}}'>Official Business</a>.</i>
            <i class="content_p2">3.) From the upper right part of the system, click <b>+ Add Application</b></i>
            <i class="content_p2">4.) Fill all mandatory feilds then click <b>Save Changes</b> Button.</i>
 
            <i class="content_p">How to update application for Official Business</i>  
            <i class="content_p2">1.) In web menu span <b>Application</b></i>
            <i class="content_p2">2.) click <a href='{{url("/ob_application")}}'>Official Business</a>.</i>
            <i class="content_p2">3.) In the list of your application, select the request you want to update. there should be form will popup.</i>
            <i class="content_p2">4.) After you edit all the feilds you want then click <b>Save Changes</b> Button.</i>

            @if(session()->get('if_approver')==1)
            <i class="content_p">How to approve application for Official Business</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/ob_approval")}}'>Official Business</a>.</i>
            <i class="content_p2">3.) Guide is not ready yet, please wait............</b></i>

            <i class="content_p">How to reject application for Official Business</i> 
            <i class="content_p2"><b>Note:</b> This facility is for approver only. just follow the steps.</i>
            <i class="content_p2">1.) In web menu span <b>For Approval</b></i>
            <i class="content_p2">2.) click <a href='{{url("/ob_approval")}}'>Official Business</a>.</i>
            @endif
           
            <i class="content_p">How to discard application for Official Business</i>
            <i class="content_p2">1.) click <a href='{{url("/ob_application")}}'>Official Business</a>.</i>
            <i class="content_p2">2.) In the list of your application, select the request you want to discard.</i>
            <i class="content_p2">3.) Click <b>Yes</b> in confirmation box. End</i>

        </div>   

        <div id="div_sys_accss" class="divSearch" onclick="go_to_page('web_helper/div_sys_accss')">
            <b>System Access</b>
            <br><br>
            <p>system access refers to the ability or permission to interact with, view, or modify different components and resources of a website's underlying infrastructure. This term encompasses various levels of access within a website's environment. you can also manage your profile information and password</p>
                <l>Learn more...</l>  
                <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i> 
                 

                <i class="content_p">How to check user information</i>  
                <i class="content_p2">1.) From the right top part of the system, click <b>User</b> icon.</i>
                <i class="content_p2">2.) click <a href='{{url("/change_password")}}'>Settings</a>.</i>
                <i class="content_p2">3.) You can check it now</i> 


                <i class="content_p">How to update user password</i>
                <i class="content_p2">1.) From the right top part of the system, click <b>User</b> icon.</i>
                <i class="content_p2">2.) click <a href='{{url("/change_password")}}'>Settings</a>.</i>
                <i class="content_p2">3.) You can check it now</i>

                <i class="content_p">How to logout</i>  
                <i class="content_p2">1.) From the right top part of the system, click <b>User</b> icon.</i>
                <i class="content_p2">2.) click <a href='{{url("/")}}'>Settings</a>.</i>
                <i class="content_p2">3.) You can check it now</i> 
        </div> 

        <div id="div_sys_admin" class="divSearch" onclick="go_to_page('web_helper/div_sys_admin')">
                <b>System Admin or SysAdmin</b>
                <br><br>
                <p>plays a crucial role in managing and maintaining the servers, infrastructure, and overall backend systems that support the application. Their responsibilities typically include a range of tasks to ensure the application runs smoothly, securely, and efficiently. This role involves creating, assigning, and modifying different user roles, as well as controlling what each user can do within the application</p>
                <l>Learn more...</l>
                <i class="content_p2"><h5>Here are some related features in this facility</h5></i>
                
                <i class="content_p">How to create access</i>  
                <i class="content_p2">1.) Your immediate super visor should submit request into <b>HR</b>.</i>
                <i class="content_p2">2.) <b>HR</b> should get your personal information.</i>
                <i class="content_p2">3.) ...</i>

                <i class="content_p">How to retrieve password</i>  
                <i class="content_p2">1.) In login form, Click <a href='{{url("/")}}'>Forgot password</a>.</i>
                <i class="content_p2">2.) Enter you <b>Email</b>. make sure that the email you have is registered on this system.</i>
                <i class="content_p2">3.) System generate OTP and it will send into your email</i>
                <i class="content_p2">4.) Enter OTP in system for verification</i>
                <i class="content_p2">5.) Enter/Re-Enter new password.</i>
                <i class="content_p2">6.) Done.</i> 
        </div>


        <div id="div_help_info" class="divSearch" onclick="go_to_page('web_helper/div_help_info')">
                <b>Help Information</b>
                <br><br>
                <p>to the resources, instructions, or guidance provided to assist users in understanding how to use the application effectively. This information can be presented in various forms, depending on the design and functionality of the app</p>
                <l>Learn more...</l>
                <i class="content_p2"><h5>Here are some related fetures in this facility</h5></i> 
                <i class="content_p">how to view user guides</i>   
        </div>



    </div> 


<script>

        function ShowHelps(){      

                var query = '<?=$result?>'.toLowerCase();  
                var org_res = query;
                query = query.trim(); 
                query = query.replace(/\s+/g, ' ').trim(); 


                const pronouns = {
                                    personal: {
                                        subject: ["I", "You", "He", "She", "It", "We", "They"],
                                        object: ["Me", "You", "Him", "Her", "It", "Us", "Them","im"],
                                        possessive: ["Mine", "Yours", "His", "Hers", "Its", "Ours", "Theirs"]
                                    },
                                    reflexive: ["Myself", "Yourself", "Himself", "Herself", "Itself", "Ourselves", "Yourselves", "Themselves"],
                                    demonstrative: ["This", "That", "These", "Those"],
                                    interrogative: ["Who", "What", "Which", "Whose"],
                                    indefinite: ["Anyone", "Anything", "Each", "Everyone", "Everything", "Someone", "Somebody", "Something", "No one", "Nobody", "Nothing", "All", "Some", "Few", "Many", "Several", "Any"],
                                    relative: ["Who", "Whom", "Which", "That", "Whose"],
                                    reciprocal: ["Each other", "One another"],
                                    possessiveAdjectives: ["My", "Your", "His", "Her", "Its", "Our", "Their"]
                };


                const verbs = {
                                regular: {
                                    base: ["know","want","walk", "talk", "play", "work", "jump", "clean", "cook", "study", "watch"],
                                    present: ["knowing","wanting","walking", "talking", "playing", "working", "jumping", "cleaning", "cooking", "studying", "watching"],
                                    past: ["walked", "talked", "played", "worked", "jumped", "cleaned", "cooked", "studied", "watched"],
                                    pastParticiple: ["walked", "talked", "played", "worked", "jumped", "cleaned", "cooked", "studied", "watched"]
                                },
                                irregular: {
                                    base: ["go", "eat", "be", "have", "see", "do", "get", "take", "come", "give"],
                                    present: ["going", "eating", "being", "having", "seing", "doing", "getting", "coming", "giving"],
                                    past: ["went", "ate", "was/were", "had", "saw", "did", "got", "took", "came", "gave"],
                                    pastParticiple: ["gone", "eaten", "been", "had", "seen", "done", "gotten", "taken", "come", "given"]
                                },
                                modal: ["can", "could", "will", "would", "shall", "should", "may", "might", "must","how"],
                                phrasal: {
                                    base: ["get up", "turn off", "put on", "take off", "look after", "run out of", "give up"],
                                    past: ["got up", "turned off", "put on", "took off", "looked after", "ran out of", "gave up"],
                                    pastParticiple: ["gotten up", "turned off", "put on", "taken off", "looked after", "run out of", "given up"]
                                }
                }; 

                const prepositions = {
                                time: ["at", "on", "in", "before", "after", "during", "since", "for", "until", "by"],
                                place: ["at", "in", "on", "under", "over", "between", "next to", "behind", "in front of", "beside", "among"],
                                direction: ["to", "into", "onto", "from", "towards", "through", "across", "up", "down", "along"],
                                manner: ["by", "with", "like", "as", "in", "for"],
                                agent: ["by"],
                                cause: ["because of", "due to", "thanks to", "on account of"],
                                accompaniment: ["with", "without"],
                                instrument: ["with", "by"]
                };

                const conjunctions = {
                                coordinating: ["and", "but", "or", "nor", "for", "yet", "so"],
                                subordinating: ["although", "because", "since", "unless", "if", "while", "as", "before", "after", "even though", "until", "in case", "so that"],
                                correlative: ["either...or", "neither...nor", "not only...but also", "both...and", "whether...or"],
                                adverbial: ["therefore", "however", "thus", "meanwhile", "consequently", "moreover", "nevertheless"]
                };

                const others = {
                                other1: ["need","view"],
                                other2: ["modify","change","edit","update"] 
                };

            
                let words = query.split(" ");

                let allPronouns = [
                                ...pronouns.personal.subject,
                                ...pronouns.personal.object,
                                ...pronouns.personal.possessive,
                                ...pronouns.reflexive,
                                ...pronouns.demonstrative,
                                ...pronouns.interrogative,
                                ...pronouns.indefinite,
                                ...pronouns.relative,
                                ...pronouns.reciprocal,
                                ...pronouns.possessiveAdjectives
                            ];

                let filProNouns = words.filter(word => 
                !allPronouns.some(pronoun => pronoun.toLowerCase() === word.toLowerCase())
                ); 
               
                
                let all_verbs = [
                                ...verbs.regular.base,
                                ...verbs.regular.present,
                                ...verbs.regular.past,
                                ...verbs.regular.pastParticiple,
                                ...verbs.irregular.base,
                                ...verbs.irregular.present,
                                ...verbs.irregular.past,
                                ...verbs.irregular.pastParticiple,
                                ...verbs.modal,
                                ...verbs.phrasal.base,
                                ...verbs.phrasal.past,
                                ...verbs.phrasal.pastParticiple,
                            ];

                let filVerbs = words.filter(word => 
                !all_verbs.some(verb => verb.toLowerCase() === word.toLowerCase())
                ); 

               

                let allPrepositions = [
                                ...prepositions.time,
                                ...prepositions.place,
                                ...prepositions.direction,
                                ...prepositions.manner,
                                ...prepositions.agent,
                                ...prepositions.cause,
                                ...prepositions.accompaniment,
                                ...prepositions.instrument
                            ];

                let filPrepositions = words.filter(word => 
                !allPrepositions.some(preposition => preposition.toLowerCase() === word.toLowerCase())
                ); 

               
                let all_conjunctions = [
                                ...conjunctions.coordinating,
                                ...conjunctions.subordinating,
                                ...conjunctions.correlative,
                                ...conjunctions.adverbial
                            ];

                let filConjunctions = words.filter(word => 
                !all_conjunctions.some(conjunction => conjunction.toLowerCase() === word.toLowerCase())
                );
                
                let all_others = [
                                ...others.other1,
                                ...others.other2 
                            ];
                let filOthers = words.filter(word => 
                !all_others.some(other => other.toLowerCase() === word.toLowerCase())
                ); 

                query = filOthers.join(" ");
                query = filConjunctions.join(" ");
                query = filPrepositions.join(" ");
                query = filVerbs.join(" ");
                query = filProNouns.join(" ");
                words = query.split(" ");


                console.log(words);
                //console.log(query);


                let contentDiv = document.getElementById("content");
                let divs = document.querySelectorAll(".container .divSearch");
                let results = []; 
                if (query === "") { 
                    contentDiv.style.display = 'none';
                    return;
                }

                query = query.split(" ");

                query.forEach(item => { 
                    divs.forEach(function(div) {  
                        
                        var new_div_inner = div.innerHTML.toLowerCase();   
                        if(new_div_inner.includes(item)){  
                            if(new_div_inner.includes(item) && !results.includes(div.outerHTML)){
                                results.push(div.outerHTML); 
                            }
                        }
                    });               
                });  


                

                contentDiv.innerHTML = "";
                const resultsDiv = document.getElementById("search-results"); 
        

                if (results.length > 0) { 
                    contentDiv.innerHTML = results.join('<br>');
                    } 
                else { 
                    window.location.replace("/no_result_fround/"+org_res); 
                }   
        }


        ShowHelps();

        function SearchRelated(){  
            var query = document.getElementById('search-input').value.toLowerCase();   
            window.location.replace('{{url("/search/a")}}'+query);  
        }


</script>

@endsection