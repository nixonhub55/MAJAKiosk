<style>
    .sched-tbl{
        width: 100%;
    }

    .sched-tbl td,th{
        border: 1px solid #c0c0c0;
        font-size: 11px;
        padding: 5px;
    }

    .sched-tbl  th{
       text-align: center;
    }
</style>
<?php 
    //echo json_encode($regularSchedule);
    $colspan = 8;
    $totalAmount = 0;
?>
<script>
    this.toExtItems = '<?= json_encode($regularSchedule['rows'] ?? []) ?>';
</script>
@if(count($regularSchedule['rows'])==0)
    <div style="
                border:0.5px dotted red;
                padding:10px;
                border-radius: 10px;
                color: #797474
        "
    >
        <center>
            <i class="fas fa-frown fs-5"></i> <br> No valid overtime found!
        </center>
    </div>
@else
<div> 
    <label for="tblOTLogs" id="lbldivExtensionAllowanceDetails"></label> 
    <table id="tblOTLogs" class="sched-tbl">
        <thead>
            <tr style="background-color: #e4e9f0;">
                <th colspan="{{$colspan}}">Overtime log details</th>
            </tr>
            <tr>
                <th>Work Date</th>
                <th>Schedule Tag</th>
                <th>Time-In</th>
                <th>Time-Out</th>
                <th>Total Hours</th>
                <th>Remarks</th>
                <th>Total OT</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($regularSchedule['rows'] as $row)
            <tr>
                <td>{{$row->dtrTime}}</td>
                <td>{{$row->regSched}}</td>
                <td>{{$row->timeIn}}</td>
                <td>{{$row->timeOut}}</td>
                <td>{{$row->totalTime}}</td>
                <td @if($row->remarks!=="") class="text-danger" @endif >{!!$row->remarks!!}</td>
                <td>{{$row->totalOT}}</td> 
                <td style="text-align: right;">{{number_format($row->Amount,2)}}</td> 
            </tr>
            <?php
                $totalAmount+=$row->Amount;
            ?>
            @endforeach
            <tr style="border-top: 3px double gray;"> 
                <td colspan="{{$colspan}}"><b>OT Time Summary</b>: {{$regularSchedule['rows'][0]->summaryOT}}</td>  
            </tr>
            <tr> 
                <td colspan="{{$colspan}}"><b>Computed Allowance</b>: <span style="color: #079246">₱{{number_format($totalAmount,2)}}</span> </td>  
            </tr>
        </tbody>
    </table>
</div>
@endif
 