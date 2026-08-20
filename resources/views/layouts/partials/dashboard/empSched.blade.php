 
<table id="datatablesEmpSched" class="table table-striped">
    <thead class="table-header">
        <tr>
            <th>Identity ID</th>
            <th>Name</th>
            <th>Day</th>
            <th>Date</th>
            <th>Schedule Name</th>
        </tr>
    </thead>
    <tbody>
         @foreach($schedules['rows'] as $rows)
         <tr>
            <td>{{$rows->employeeId}}</td>
            <td>{{$rows->employeeName}}</td>
            <td>{{$rows->day}}</td>
            <td>{{date("l", strtotime($rows->day))}}</td>
            <td>{{$rows->scheduleName}}</td>
         </tr>
         @endforeach
    </tbody>

</table>

<script>
     
    var datatablesEmpSched = document.getElementById('datatablesEmpSched');
    if (datatablesEmpSched) {
        new simpleDatatables.DataTable(datatablesEmpSched, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    } 

</script>