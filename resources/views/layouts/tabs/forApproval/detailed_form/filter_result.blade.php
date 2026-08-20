 
<div class="table-container">
    @if($id==0) <!-- OVERTIME -->
        <table class="table table-striped" id="datatablesHistory">
                <thead>
                    <tr> 
                            <th>App #</th>
                            <th>Application Date</th>
                            <th>Work Date</th>
                            <th>Name</th>
                            <th>Cost Center</th>
                            <th>Department</th>
                            <th>Type</th> 
                            <th>Status</th>
                            <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl_hist">
                @foreach($request_history['rows'] as $list) 
                    <tr>
                            <td>{{$list->otAppNo}}</td>
                            <td>{{$list->otReqDate}}</td>
                            <td>{{$list->otDate}}</td>
                            <td>{{$list->otName}}</td>
                            <td>{{$list->otCosCenter}}</td>
                            <td>{{$list->department}}</td>
                            <td>
                                @if($list->otType=="OT") Overtime @else Under Time @endif
                            </td> 
                            <td>{{$list->r_status}}</td>  
                            <td>
                                <div class="btn-container"> 
                                    <button id="{{$list->otAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(<?= $switch ?>,'{{$list->enc_id}}','{{$list->r_srcDb}}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                    </tr>
                @endforeach 
                </tbody>
        </table> 
    @endif

    @if($id==1) <!-- LEAVE -->
            <table class="table table-striped" id="datatablesHistory">
                <thead>
                        <tr> 
                            <th>App #</th>
                            <th>Employee No.</th> 
                            <th>Employee Name</th> 
                            <th>App Date</th> 
                            <th>Date From</th> 
                            <th>Date To</th>
                            <th>Leave Type</th>
                            <th>Total Leave Days</th> 
                            <th>Status</th>
                            <th>Action</th>
                        </tr> 
                </thead>
                <tbody>
                @foreach($request_history['rows'] as $rows)
                        <tr>
                            <td>{{$rows->laAppNo}}</td>
                            <td>{{$rows->laID}}</td>
                            <td>{{$rows->laName}}</td>
                            <td>{{$rows->laAppDate}}</td>
                            <td>{{$rows->laDateFrom}}</td>
                            <td>{{$rows->laDateTo}}</td>
                            <td>{{$rows->laType}}</td>
                            <td>{{$rows->laTotalDays}}</td> 
                            <td>{{$rows->r_status}}</td>  
                            <td>
                                <div class="btn-container"> 
                                    <button id="{{$rows->laAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(1,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                @endforeach 
                </tbody>
            </table>
    @endif

    @if($id==2) <!-- TIME ADJSUTMENT -->
        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Emp ID</th> 
                        <th>Employee Name</th> 
                        <th>App Date</th> 
                        <th>Time Adjustment Date</th>
                        <th>Type</th> 
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->taAppNo}}</td>
                        <td>{{$rows->taID}}</td>
                        <td>{{$rows->taName}}</td>
                        <td>{{$rows->taAppDate}}</td> 
                        <td>{{$rows->taDate}}</td>
                        <td>{{$rows->taType}}</td>    
                        <td>{{$rows->r_status}}</td>
                        <td>
                            <div class="btn-container"> 
                                <button id="{{$rows->taAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(2,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>   
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif

    @if($id==3) <!-- OFFICIAL BUSINESS -->
        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Emp ID</th> 
                        <th>Employee Name</th> 
                        <th>App Date</th> 
                        <th>OB Date</th>
                        <th>Type</th> 
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->obAppNo}}</td>
                        <td>{{$rows->obID}}</td>
                        <td>{{$rows->obName}}</td>
                        <td>{{$rows->obAppDate}}</td> 
                        <td>{{$rows->obDateFrom}}</td>
                        <td>{{$rows->obType}}</td>   
                        <td>{{$rows->r_status}}</td>  
                        <td>
                            <div class="btn-container"> 
                                <button id="{{$rows->obAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(3,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>  
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif

    @if($id==4) <!-- OFFEST -->
        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Emp ID</th> 
                        <th>Employee Name</th> 
                        <th>App Date</th> 
                        <th>Offset Date</th> 
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->osAppNo}}</td>
                        <td>{{$rows->osID}}</td>
                        <td>{{$rows->osName}}</td>
                        <td>{{$rows->osAppDate}}</td> 
                        <td>{{$rows->osDate}}</td>
                        <td>{{$rows->osReason}}</td>  
                        <td>{{$rows->r_status}}</td>  
                        <td>
                            <div class="btn-container"> 
                                <button id="{{$rows->osAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(4,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td> 
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif

    @if($id==5) <!-- TIME ENTRY -->
        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Emp ID</th> 
                        <th>Employee Name</th> 
                        <th>App Date</th> 
                        <th>Time Entry Date</th>
                        <th>Type</th> 
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->teAppNo}}</td>
                        <td>{{$rows->teID}}</td>
                        <td>{{$rows->teName}}</td>
                        <td>{{$rows->teAppDate}}</td> 
                        <td>{{$rows->teDate}}</td>
                        <td>{{$rows->teType}}</td>    
                        <td>{{$rows->r_status}}</td>
                        <td>
                            <div class="btn-container"> 
                                <button id="{{$rows->teAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(5,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>   
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif


    @if($id==6) <!-- SCHEDULE -->
        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Emp ID</th> 
                        <th>Employee Name</th> 
                        <th>App Date</th> 
                        <th>Previous Schedule</th>
                        <th>Requested Schedule</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->scAppNo}}</td>
                        <td>{{$rows->scID}}</td>
                        <td>{{$rows->scName}}</td>
                        <td>{{$rows->scAppDate}}</td> 
                        <td>{{$rows->scPreviousSched}}</td>
                        <td>{{$rows->scSchedule}}</td>    
                        <td>{{$rows->r_status}}</td>
                        <td>
                            <div class="btn-container"> 
                                <button id="{{$rows->scAppNo}}" class="btn btn-action btn-view" title="More Details" onclick="show_hist_details(6,'{{$rows->enc_id}}','{{$rows->r_srcDb}}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>   
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif

    @if($id==7) <!-- HRD CERT -->

        <table class="table table-striped" id="datatablesHistory">
            <thead>
                    <tr> 
                        <th>App #</th>
                        <th>Request Date</th> 
                        <th>Employee Name</th> 
                        <th>Cost Center</th>
                        <th>Department</th>
                        <th>Date Needed</th>  
                        <th>Status</th>
                        <th>Actions</th>
                    </tr> 
            </thead>
            <tbody>
            @foreach($request_history['rows'] as $rows)
                    <tr>
                        <td>{{$rows->appNo}}</td>
                        <td>{{$rows->requestDate}}</td>
                        <td>{{$rows->fullName}}</td>
                        <td>{{$rows->costName}}</td>
                        <td>{{$rows->departmentName}}</td>
                        <td>{{$rows->dateNeeded}}</td> 
                        <td>{{$rows->r_status}}</td>
                        <td>
                            <div class="btn-container"> 
                                    <button id="{{$rows->appNo}}" class="btn btn-action btn-view" title="More Details" onclick="EditCert('{{$rows->enc_id}}','{{$num}}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                            </div>
                        </td>
                    </tr>
            @endforeach 
            </tbody>
        </table>
    @endif
</div> 

<script>

      
        function Refresh(){ 
            const datatablesHistory = document.getElementById('datatablesHistory');  
            new simpleDatatables.DataTable(datatablesHistory, {
                searchable: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25, ["All", 0]],
                sortable: true
            });
        }
        Refresh();
        
</script>