<div class="container-fluid card-container"> 
      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                  <div class="table-container">
                        <table class="table data-table" id="datatablesPending2">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Biometrics In</th>
                                <th>Biometrics Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ref_list['rows'] as $list)
                            <tr onclick="PickRefNo('{{$list->biometricsIn}}','{{$list->biometricsOut}}')">
                                <td>{{$list->date}}</td>
                                <td>{{$list->day}}</td>
                                <td>{{$list->biometricsIn}}</td>
                                <td>{{$list->biometricsOut}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                  </div>
            </div> 
      </div>  
</div>

<script>
     
     function LoadDynamicTable(){
        const datatablesPending = document.getElementById('datatablesPending2');
        if (datatablesPending) {
                new simpleDatatables.DataTable(datatablesPending);

        }
     }

     LoadDynamicTable();
</script>
 