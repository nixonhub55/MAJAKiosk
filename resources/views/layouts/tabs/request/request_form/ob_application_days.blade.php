<style>
    .inv{
        display: none;
    }
</style>
<?php

    $txtId = "txt".$_POST['trID']; 
    $location = $_POST['obLocation'];
 
?>
<tr id="<?=$_POST['trID']?>">
    <td><?=$_POST['trID']?></td>
    <td>
        <b><?=$_POST['obLstDate']?></b>
        <p><?=$_POST['Day']?></p>
    </td>
    <td>
        <label class="fixed_lbl" id="<?="lbl".$_POST['trID']?>" for="<?="Loc".$_POST['trID']?>"></label>
        <!-- <input type="text" id="<?="Loc".$_POST['trID']?>" value="<?=$_POST['obLocation']?>" class="form-control"   onchange="UpdateArray('obLocation',<?=$_POST['trID']?>,this.value)"> -->
         <select  id="<?="Loc".$_POST['trID']?>" class="form-select" onchange="return SelectLocation(this.id,'{{$txtId}}',<?=$_POST['trID']?>)">
            @foreach($locations['rows'] as $rows)
                <option value="{{$rows->locationCode}}" <?=($location==$rows->locationCode ? "selected" : "") ?> >{{$rows->locationName}}</option>
            @endforeach
         </select>
         <input type="text" id="<?=$txtId?>" value="<?=$_POST['locationName'];?>" class="form-control <?=($_POST['obLocation']=="Others" ? "" : "inv") ?>" placeholder="Specify Others" onchange="UpdateArray('location',<?=$_POST['trID']?>,this.value)">
    </td>
    <td>
        <div class="input-group">
            <label class="fixed_lbl" id="<?="lbl".$_POST['time_id1']?>"  for="<?=$_POST['time_id1']?>"></label>
            <select id="<?=$_POST['time_id1']?>" class="time form-control"  onchange="UpdateArray('obLstTimeFrom',<?=$_POST['trID']?>,this.value)"></select> 
        </div>
    </td>
    <td>
        <div class="input-group">
            <label class="fixed_lbl" id="<?="lbl".$_POST['time_id2']?>"  for="<?=$_POST['time_id2']?>"></label>
            <select id="<?=$_POST['time_id2']?>" class="time form-control" onchange="UpdateArray('obLstTimeTo',<?=$_POST['trID']?>,this.value)"></select> 
        </div>
    </td>
    <td id="<?="tot".$_POST['trID']?>"><?=$_POST['obLstTotHours']?></td>
    <td>
     <i  class="fas fa-trash btn text-danger fs-5" onclick="return remove_row('<?=$_POST['trID']?>')"></i></button> 
    </td>
</tr> 
 