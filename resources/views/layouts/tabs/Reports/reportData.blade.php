 


<div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
    <div class="table-container"> 
        @if($pint_mode==0)
            <table class="table data-table" id="datatablesPending">
                    <thead>
                        <tr> 
                                <th>#</th> 
                                <th>From</th> 
                                <th>To</th>
                                <th>Payroll Date</th> 
                        </tr>
                    </thead> 
                    <tbody>
                    @foreach($report_record['rows'] as $data)   
                    <tr   onclick="return EnterPass_Modal('30%','{{ $data->code }}')">      
                        <td>{{ $data->code }}</td>
                        <td>{{ $data->payrollPeriodFrom }}</td>
                        <td>{{ $data->payrollPeriodTo }}</td>
                        <td>{{ $data->payrollPeriodPayDate }}</td>
                    </tr>
                    @endforeach 
                    </tbody>
            </table>
        @endif


        @if($pint_mode==1)
            <table class="table data-table" id="datatablesPending">
                    <thead>
                        <tr>

                                <th>#</th>
                                <th>Identity ID</th> 
                                <th>Employee Name</th>
                                <th>Payout Date</th> 
                                <th>Net 13th Month Pay</th> 
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($report_record['rows'] as $rows)
                        <tr  onclick="return EnterPass_Modal('30%','{{ $rows->code }}')"> 
                                <td>{{$rows->code}}</td>
                                <td>{{$rows->identityId}}</td>
                                <td>{{$rows->employeeName}}</td>
                                <td>{{$rows->payoutdate}}</td>
                                <td>{{$rows->net13thMonthPay}}</td> 
                        </tr> 
                    @endforeach 
                    </tbody>
            </table>
        @endif
    </div>
</div>

<script> 

        var datatablesPending = document.getElementById('datatablesPending');
        if (datatablesPending) {
                new simpleDatatables.DataTable(datatablesPending);

        } 
</script>

</div>

