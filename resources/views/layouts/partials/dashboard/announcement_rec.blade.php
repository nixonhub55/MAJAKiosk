 <?php
  
 $selectedArray = explode(",", $SelectedID);
 $checkID = "0103210184"; 
 $num = 0;

 ?>
   <div class="row"> 
        <div class="col-12">
            <label for="appNumber" class="form-label">Department</label>
            <select id="depDDL" class="form-select" onchange="ShowModalRecipients(this.value,'datatablesPending')">
                @foreach($departments['rows'] as $rows)
                    <option value="{{$rows->departmentCode}}" 
                            @if($rows->departmentCode === $dep) selected @endif>
                        {{$rows->departmentName}}
                    </option>
                @endforeach
            </select>

        </div> 
    </div>  
    
    <div class="row">
       <div  class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="table-container">
                <table class="table data-table" id="datatablesPending">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" onclick="SelectAll(this.id,'datatablesPending')" value="0"></th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users['rows'] as $rows) 
                            <tr>
                                <!-- <td><center><input type="checkbox" class="checkbox-row" data-id="{{$rows->identityId}}"></center></td> -->
                                <td>
                                    <center>
                                    <input type="checkbox" 
                                    id="{{$rows->identityId}}" 
                                    onclick="SelectID('{{$rows->identityId}}', this.id,0)" 
                                    <?php echo in_array($rows->identityId, explode(",", $SelectedID)) ? 'checked' : ''; ?> value="{{$rows->Fullname}}" >

                                    </center>
                                </td>
                                <td>{{$rows->identityId}}</td>
                                <td>{{$rows->Fullname}}</td>
                                <td>{{$rows->departmentName}}</td>
                            </tr>
                            <?php $num+=1;?>
                        @endforeach 
                    </tbody>
                </table> 
                <div id="div_pagination" class="pagination">
                        <div>
                            <button id="datatablesPending-prevPage">Prev</button>
                            <button id="datatablesPending-nextPage">Next</button>
                        </div>
                </div>
                </div>
            </div> 
       </div>
    </div>

    <script>


        function LoadDynamicTable(){ 
            initializePagination("datatablesPending"); 
        }

        LoadDynamicTable();
    </script>