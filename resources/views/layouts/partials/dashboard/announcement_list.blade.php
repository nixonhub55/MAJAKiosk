<style>

    .ann{
        cursor: pointer;
    }

    .ann:hover{
       background-color: #f7f7f7;
    }
</style>


<?php

    $announcement = $announcement['rows']; 
    $ann_count = count($announcement);  

?>


@if($ann_count==0)
No announcement posted this time!
@endif


@foreach($announcement as $row)
<p class="ann" onclick="view_announcement('{{$row->id}}')"><b>{{$row->fullname}}</b> posted about "<b style="font-size:20px; color: green" >{{$row->pSubject}}</b>" {{$row->time_ago}}</p>
@endforeach