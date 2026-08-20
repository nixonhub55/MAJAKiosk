 
<div class="card-body">
        <table id="datatablesBioLogs" class="table table-striped">
            <thead>
            <tr> 
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Biometrics ID</th>
                <th>Name</th>
                <th>Machine ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($biolist['rows'] as $list)
            <tr>
                <td>{{$list->DATE}}</td>
                <td>{{$list->TIME}}</td>
                <td>{{$list->dtrtype}}</td>
                <td>{{$list->biometricsid}}</td>
                <td>{{$list->firstName}}</td>  
                <td>{{$list->machineid}}</td>  
            </tr>
            @endforeach 
        </tbody>
            </table>
    </div>
 

<script>
     
    var datatablesBioLogs = document.getElementById('datatablesBioLogs');
    if (datatablesBioLogs) {
        new simpleDatatables.DataTable(datatablesBioLogs, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    } 

</script>

