@extends('layouts.admin') 
@section('content')  

<div class="container-fluid mt-4 card-container">
    <div class="row">
        <div class="col-4">
            
            <select name="ddl_opt" id="ddl_opt" class="form-control" onchange="SelectMode(this.value)">
                <option value="0">--Select--</option>
                <option value="1">Register</option>
                <option value="2">Login</option>
            </select>
            <br>
            <div id="div_load"></div>
        </div>
    </div>
</div>

<script>

    function SelectMode(val){ 
        if (val==1){
            LoadPageIntoDIV_GET('{{url("/test_show_reg")}}','div_load');
        }else{
            document.getElementById('div_load').innerHTML = "";   
        }
        
    }

  
    async function exec_param() {
        var parameters = {
            "id": document.getElementById('txtUname').value,
            "user_id": "1"
        };

        try { 

            var result = await ExexStoredProc_GET('sp_get_users', parameters);
            var data = JSON.parse(result);

            if (data.num!==0){
                alert(data.msg);
            } 

        } catch (error) {
            console.log('Error:', error); 
        }
    } 

</script>

@endsection