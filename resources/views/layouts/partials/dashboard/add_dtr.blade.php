 

<div class="row" >

    <div class="col-md-12 col-lg-12">
        <div id="div_validation"></div>
    </div>

    <div class="col-md-12 col-lg-12">
        <label for="ddlDTRType" id="ddlDTRTypelbl">Type:</label>
        <select id="ddlDTRType" class="form-select"> 
            @foreach($dropdown_fill['rows'] as $rows)
                <option value="{{$rows->enc_id}}">{{$rows->txt}}</option>
            @endforeach
        </select>
    </div> 

</div>
<br>
 
<label for="dtrLocation" id="dtrLocationLbl">Location:</label>
<div class="form-control" id="dtrLocation">
    <input type="hidden" id="geolocation" name="geolocation">
    <p id="demo"></p>
</div>


<script>
    
    var x = document.getElementById("demo");
    var geo = document.getElementById("geolocation");  

    function getLocation() { 
         
        if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
 
    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
        geo.value = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                geo.value = "User denied the request for Geolocation."
            break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                geo.value = "Location information is unavailable."
            break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                geo.value = "The request to get user location timed out."
            break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                geo.value = "An unknown error occurred."
            break;
        }
    } 
    getLocation();   
    async function SubmitDTR(pint_mode,objID){ 
        
            GlovalHTMLObjLoading(1,objID); 
            var dtrType = document.getElementById('ddlDTRType').value;  
            var formData = new FormData();
            formData.append('mode', '19');     
            formData.append('pint_mode', pint_mode);  
            formData.append('dtrType',dtrType); 
            formData.append('geo',geo.value);  
            
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}');  

            setTimeout(() => {
                  addAuditTrails(window.location.pathname.split('/').pop(),JSON.stringify(response));
                  GlovalHTMLObjLoading(0,objID); 
            }, maxMinExec);

            if (pint_mode==0){
                  if (response.num!==0){
                        var id = JSON.parse(response.msg).id;
                        if (id!== undefined){  
                              console.log(id); 
                              show_error_message(id,JSON.parse(response.msg).msg);  
                        }
                        else{
                              var alert = '<div id="myAlert" class="alert alert-danger" role="alert">'+JSON.parse(response.msg).msg+'</div>';
                              document.getElementById('div_validation').innerHTML = alert; 
                        }
                  } 
                  else{ 
                  confirm_submit("Are you sure, you want to submit this DTR?");
                  } 
                  GlovalHTMLObjLoading(0,objID); 
            }else{ 
                  GlovalHTMLObjLoading(1,objID); 
                  window.location.href='{{url("/dash_cust?id=biolbl")}}'; 
            } 

    }

    function confirm_submit(msg){   
            fbconfirm('Submit Confirmation', msg, 'Yes','Cancel', 'ConfirmApplication()'); 
      }
    function ConfirmApplication(){
        SubmitDTR(1,"btnDTR2");
    }

</script>
<br>
<div class="modal-footer" id="btns">
    <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success" id="btnDTR2" onclick="return SubmitDTR(0,this.id)">Submit</button>
</div>