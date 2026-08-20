<style>
    .table-responsive {
        overflow-x: auto;
        white-space: nowrap;
        max-width: 100%;
    }

    .amount{
        text-align:right;
    }
</style>
 

<div class="tab-content" id="myTabContent">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab"
                aria-controls="pending" aria-selected="true">Details</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history"
                aria-selected="false">Summary</a>
        </li>
    </ul>

    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
        <div class="table-responsive">
            <table id="datatablesSimpleLeave" class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Pay Period</th>
                        <th>Basic Pay</th>
                        <th>Net Basic Pay</th>
                        <th>Taxable Earnings</th>
                        <th>NonTaxable Earnings</th>
                        <th>Gross Compensation</th>
                        <th>Tax Withheld</th>
                        <th>SSS</th>
                        <th>PHIC</th>
                        <th>HDMF</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emp_ytd_details['rows'] as $rows)
                        <tr>
                            <td>{{$rows->payrollPeriod}}</td>
                            <td class="amount">{{ number_format($rows->basicPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->netBasicPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->taxableEarnings, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->nonTaxableEarnings, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->grossPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->taxWitheld, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->sss, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->phic, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->hdmf, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->deductions, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->netPay, 2, '.', ',') }}</td>
                            <td>{{$rows->source}}</td>
                        </tr>
                    @endforeach 
                    @foreach($emp_ytd_summary['rows'] as $rows)
                        <tr class="bg-light">
                            <td><b>TOTAL</b></td>
                            <td class="amount"><b>{{$rows->totalBasicPay}}</b></td>
                            <td class="amount"><b>{{$rows->totalNetBasicPay}}</b></td>
                            <td class="amount"><b>{{$rows->totalTaxableEarnings}}</b></td>
                            <td class="amount"><b>{{$rows->totalNonTaxableEarnings}}</b></td>
                            <td class="amount"><b>{{$rows->totalGrossPay}}</b></td>
                            <td class="amount"><b>{{$rows->totalTaxWithheld}}</b></td>
                            <td class="amount"><b>{{$rows->totalSSS}}</b></td>
                            <td class="amount"><b>{{$rows->totalPHIC}}</b></td>
                            <td class="amount"><b>{{$rows->totalHDMF}}</b></td>
                            <td class="amount"><b>{{$rows->totalDeduction}}</b></td>
                            <td class="amount"><b>{{$rows->totalNetPay}}</b></td>
                            <td></td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
        <div class="table-responsive">
            <table id="datatablesSimpleLeave" class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>YTD Basic Pay</th>
                        <th>YTD Net Basic Pay</th>
                        <th>YTD Taxable Earnings</th>
                        <th>YTD NonTaxable Earnings</th>
                        <th>YTD Gross Compensation</th>
                        <th>YTD Tax Withheld</th>
                        <th>YTD Statutory</th>
                        <th>YTD Deductions</th>
                        <th>YTD Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emp_ytd_summary['rows'] as $rows)
                        <tr>
                            <td class="amount">{{ number_format($rows->totalBasicPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalNetBasicPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalTaxableEarnings, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalNonTaxableEarnings, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalGrossPay, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalTaxWithheld, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalStatutory, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalDeduction, 2, '.', ',') }}</td>
                            <td class="amount">{{ number_format($rows->totalNetPay, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>