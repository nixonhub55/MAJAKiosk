@extends('layouts.admin') <!-- main layout file -->

@section('content')  
<style>
    .toolbar {
        padding-bottom: 15px;
        background-color: white;
        border-bottom:1px dotted gray;
        padding-left:10px;
            }
    .toolbar button {
        padding: 10px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn_rebon {
        text-decoration: none;
        margin-left: 20px;
        cursor: pointer;
        border:0;
        background-color: white;
            }
    #editableArea { 
        padding: 15px;
        width: 100%;
        height: 500px;
        overflow-y: auto;
        position: relative;
        background-color:white;
        outline:none
    }
    
    .resizable-image {
        max-width: 100%;
        height: auto;
        resize: both;
        overflow: hidden;
        display: block;
        margin: 10px 0;
        cursor: se-resize;
    }

    .resizable-container {
        position: relative;
        display: inline-block;
        max-width: 100%;
    }

    .resizable-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .resize-handle {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 10px;
        height: 10px;
        background-color: rgba(0, 0, 0, 0.5);
        cursor: se-resize;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /* margin: 10px 0; */
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }

    .file-menu {
            position: relative;
            display: inline-block;
        }

        .file-label {
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .file-toggle {
            display: none;
        }

        /* Style the dropdown menu */
        .file-dropdown {
            display: none;
            position: absolute;
            top: 30px;
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 160px;
            z-index: 1;
        }

        .file-option {
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .file-option:hover {
            background-color: #f1f1f1;
        }

        /* Show dropdown when checkbox is checked */
        .file-toggle:checked + .file-dropdown {
            display: block;
        }

        #fileInput2 {
            display: none;
        }
  </style>
 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <div class="modal fade" id="AnnounceModal" tabindex="-1" aria-labelledby="AnnounceModalLabel"   aria-hidden="true">
          <div class="modal-dialog modal-lg">
                <div class="modal-content">
                      <div class="modal-header bg-primary text-white"> 
                            <h5 class="modal-title">Announce Recipients</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="modal_body"></div> 
                      <div class="modal-footer" id="btns"> 
                            <!-- <button type="button" id="btn1" class="btn btn-success" onclick="return SubmitRequest(0,this.id)">Ok</button> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                </div>
          </div>
    </div>
 
           
    <div class="container-fluid mt-4 card-container">  
    <div class="row">
        <div class="col-md-2 col-12">Announcement Subject</div>
        <div class="col-md-10 col-12"><input type="text" id="txtSubject" class="form-control"/></div>
    </div> 
    <hr>
    <div class="row">
        <div class="col-md-2 col-12"><button class="btn btn-info" id="123123" onclick="ShowModalRecipients('',this.id)">Send To:</button></div>
        <div class="col-md-10 col-12" id="sendTodiv"></div>
    </div> 
    <hr> 
    <div class="toolbar">   
        <div class="file-menu" id="fileMenu">
            <label for="file-options" class="file-label">File</label>
            <input type="checkbox" id="file-options" class="file-toggle">
            <div class="file-dropdown">
                <div class="file-option" onclick="loadContent()">Open</div>
                <div class="file-option" onclick="publishPost()">Save</div>
                <div class="file-option" onclick="Discard()">Discard</div>
                <div class="file-option" onclick="PostNow()">Post now</div>
            </div>  
        </div>
        <button onclick="documentExec('bold')" class="btn_rebon" title="Bold"><b>B</b></button>
        <button onclick="documentExec('italic')" class="btn_rebon" title="Italic"><i>I</i></button>
        <button onclick="documentExec('underline')" class="btn_rebon" title="Underline">U</button>
        <button onclick="documentExec('strikeThrough')" class="btn_rebon" title="Strike Through"><del>S</del></button>
        <button onclick="documentExec('justifyLeft')" class="btn_rebon" title="Left"><i class="fas fa-align-left"></i></button>
        <button onclick="documentExec('justifyRight')" class="btn_rebon" title="Right"><i class="fas fa-align-right"></i></button>
        <button onclick="documentExec('justifyCenter')" class="btn_rebon" title="Center"><i class="fas fa-align-center"></i></button>
        <button onclick="documentExec('insertUnorderedList')" class="btn_rebon" title="Bullets"><i class="fa-solid fa-list"></i></button>
        <button onclick="documentExec('insertOrderedList')" class="btn_rebon" title="Numbered"><i class="fa-solid fa-list-ol"></i></button>
        <button onclick="createLink()" class="btn_rebon" title="Link"><i class="fa-solid fa-link"></i></button>
        <button onclick="insertTable()" class="btn_rebon" title="Table"><i class="fa-solid fa-table"></i></button>
        <button onclick="insertImage()" class="btn_rebon" title="Image"><i class="fa-solid fa-image"></i></button>
    </div>

        <div id="editableArea" class="editor" contenteditable="true">  
        </div> 
        <input type="file" id="imageInput" style="display:none" onchange="uploadImage(event)"/>
        <input type="file" id="fileInput2" onchange="handleFileUpload(event)"/>
 


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


  <script>

    var SelectedID =[];
    var SelectedNames =[];


    function documentExec(command) {
        if (command === 'justifyRight' || command === 'justifyLeft' || command === 'justifyCenter') {
            document.execCommand(command, false, null);

            const images = document.querySelectorAll('.editor img');
            images.forEach(img => {
                img.style.display = 'inline-block';
                img.style.textAlign = command === 'justifyRight' ? 'right' : command === 'justifyLeft' ? 'left' : 'center';
                img.style.margin = '10px';
            });
        } else {
            document.execCommand(command, false, null);
        }
    }

    /*Image*/
    function insertImage() {
      var editor = document.getElementById('editableArea');
      editor.focus();
      document.getElementById('imageInput').click();
    } 

    function uploadImage(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const imageUrl = e.target.result;
          const imgTag = `<div class="resizable-container"><img src="${imageUrl}" class="resizable-image" /></div></br><p>&nbsp;</p>`;
          document.execCommand('insertHTML', false, imgTag);
        };
        reader.readAsDataURL(file);
      }
    } 

    /* table */
    function insertTable() {

        var editor = document.getElementById('editableArea');
        editor.focus();

        const rows = prompt("Enter number of rows:");
        const cols = prompt("Enter number of columns:");
        var tbl = "<table><thead><tr>";

        if (rows && cols) {

            for (let i = 0; i < cols; i++) { /*add columns*/
               tbl+="<th>Header "+(i+1)+"</th>";
            }
            tbl+="</thead></tr><tbody>"; 
            for (let a = 0; a < rows; a++) { /*add rows*/
                tbl+="<tr>";
                for (let i = 0; i < cols; i++) { /*add cells*/
                    tbl+="<td>cell "+(i+1)+"</td>";
                }
                tbl+="</tr>"; 
            }
             tbl+="</tbody></table>"

            const html = `<p>&nbsp;</p><div  class="resizable-container"><div class='resizable-image'>`+tbl+`</div></div></br><p>&nbsp;</p>`;
            document.execCommand('insertHTML', false, html);
        } 
    }
     

    function insertNodeAtCursor(node) {
        const selection = window.getSelection();
        const range = selection.rangeCount > 0 ? selection.getRangeAt(0) : createRange();
        
       
        var par = document.createElement('p'); 
        par.textContent = 'Your text here';

       // range.deleteContents();
        range.insertNode(node);
 
        const editor = document.querySelector('.editor');
        editor.scrollTop = editor.scrollHeight;

        
        range.insertNode(par);
    }

 
    document.getElementById('editableArea').addEventListener('click', function(event) {
      if (event.target.tagName.toLowerCase() === 'img') {
        const img = event.target;
        if (!img.classList.contains('resizable-image')) {
          return;
        }

        const resizableContainer = img.closest('.resizable-container');
        const resizeHandle = document.createElement('div');
        resizeHandle.classList.add('resize-handle');
        resizableContainer.appendChild(resizeHandle);

        // Handle image resizing
        let isResizing = false;
        resizeHandle.addEventListener('mousedown', function(e) {
          e.preventDefault();
          isResizing = true;
          document.body.style.cursor = 'se-resize';

          const initialWidth = img.offsetWidth;
          const initialHeight = img.offsetHeight;
          const initialMouseX = e.clientX;
          const initialMouseY = e.clientY;

          function onMouseMove(e) {
            if (isResizing) {
              const widthChange = e.clientX - initialMouseX;
              const heightChange = e.clientY - initialMouseY;

              const newWidth = initialWidth + widthChange;
              const newHeight = initialHeight + heightChange;

              img.style.width = `${newWidth}px`;
              img.style.height = `${newHeight}px`;
            }
          }

          function onMouseUp() {
            isResizing = false;
            document.body.style.cursor = 'default';
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
          }

          document.addEventListener('mousemove', onMouseMove);
          document.addEventListener('mouseup', onMouseUp);
        });
      }
 
    });

    document.addEventListener('click', function(event) {
            const fileMenu = document.querySelector('.file-menu');
            const checkbox = document.querySelector('.file-toggle');
            const dropdown = document.querySelector('.file-dropdown');

            // Check if the click is outside the file menu
            if (!fileMenu.contains(event.target)) {
                // Uncheck the checkbox to hide the dropdown
                checkbox.checked = false;
            }
    });
 
    
    function publishPost() { 
          const content = document.querySelector('.editor').innerHTML;
          const subject = document.getElementById('txtSubject').value; 
          if (content.trim()) { 
            if (content.trim()) { 
              
            const blob = new Blob([content], { type: "text/html" });
            const url = URL.createObjectURL(blob);
              
            const link = document.createElement("a");
            link.href = url; 
            title = subject.replace(/ /g, '_');
            link.download = title+".pf";  
            link.click();

            } else {
                alert('Please write some content before publishing.');
            }
        }else{
                alert('Please input announcement subject first.');
        }
    }

    function loadContent() { 
          document.getElementById("fileInput2").click();
    }

    function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("editableArea").innerHTML = e.target.result;
                };
                reader.readAsText(file);
            }
    }

    function Discard(){
        document.getElementById("editableArea").innerHTML = "";
    }

    function PostNow(){  

         var styleContent = "<style>"+document.querySelector('style').innerHTML+"</style>";
       
        const content = document.querySelector('.editor').innerHTML;
        const subject = document.getElementById('txtSubject').value; 
        
        if(SelectedID.length === 0){
            alert('Please select recipients first');
            ShowModalRecipients('','123123');
        }else{
          if (subject.trim()) {  
                if (content.trim()) {
                    if(confirm("Are you sure, you want to post this announcement?")){ 
                        PostAnnouncementNow(0,"fileMenu",styleContent,content,subject); 
                    }
                }else{
                    alert("No content created to POST");
                }
          }else{
              alert("Please input announcement subject!");
          }
        }

    } 

    function ShowModalRecipients(dep,objID){
        GlovalHTMLObjLoading(1,objID); 
        var formData = new FormData();
        formData.append('dep', dep); 
        formData.append('SelectedID', SelectedID); 
          
        var myModal = new bootstrap.Modal(document.getElementById('AnnounceModal'));   
        myModal.hide();
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
              url: '{{url("/get_recipients")}}',  
              type: 'POST', 
              data: formData,    
              processData: false,  
              contentType: false,
              headers: {
              'X-CSRF-TOKEN': csrfToken 
              },             
              success: function(response) { 
                    GlovalHTMLObjLoading(0,objID);  
                    $('#modal_body').html(response);   
                    myModal.show();
              },
              error: function(msg) { 
              //alert(JSON.parse(msg.responseText).error.msg.msg);
              console.log('Error:'+JSON.stringify(msg));
              } 
              
        });
    }
    

    async function PostAnnouncementNow(pint_mode,objID,p_style,p_content,p_subject) {  
        // console.log(SelectedID);
        var formData = new FormData();
        formData.append('mode', '15');   
        formData.append('pint_mode', pint_mode); 
        formData.append('pId', 0);     
        formData.append('p_subject', p_subject); 
        formData.append('p_style', p_style);   
        formData.append('p_content', p_content);   
        formData.append('p_recipients', SelectedID);    
        const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
        
        if (response.num!==0){ 
            alert(response.msg);
        }else{ 
            window.location.href='{{url("/dash_cust")}}';
        } 

    }


    function SelectID(thisId,checkboxId,mode){ 
        var hdr_box = "checkAll";
        var targetID =  (mode==0) ?  thisId : hdr_box; 
        //var checkbox_checked = document.getElementById(targetID).checked;  
        var checkbox_checked = document.getElementById(targetID).checked;  
        var checkbox = document.getElementById(thisId); 
        var chkbox_val = checkbox.value;
        var index = SelectedID.indexOf(thisId); 
        var index2 = SelectedNames.indexOf(chkbox_val); 
        
        SelectedID.includes(thisId) && SelectedID.splice(SelectedID.indexOf(thisId), 1);
        SelectedNames.includes(thisId) && SelectedNames.splice(SelectedNames.indexOf(thisId), 1);
        
        if(checkbox!== null){ 
            var tr = checkbox.closest("tr");
            var disp = tr.style.display; 
            if ((disp!=="none") && (checkbox_checked)){
               this.SelectedID.push(thisId);
               this.SelectedNames.push(chkbox_val); 
                checkbox.checked = checkbox_checked;   
                if (mode==0){alert(chkbox_val+' has been successfully added!');}
            }else{
                this.SelectedID.splice(index, 1);
                this.SelectedNames.splice(index2, 1);
                if (mode==0){alert(chkbox_val+' has been successfully removed!');}
            }   
        } 
 
        if (mode==0){
            GenerateSendTo();
        } 
         
    }

    /* function SelectID(thisID,checkboxId,mode){ 
        const index = SelectedID.indexOf(thisID);
        var chkbox_val = document.getElementById(checkboxId).value;
        const index2 = SelectedNames.indexOf(chkbox_val); 

        if(document.getElementById(checkboxId).checked){ 
                if (!SelectedID.includes(thisID)) {
                    SelectedID.push(thisID);
                    SelectedNames.push(chkbox_val);
                    if (mode==0){alert(chkbox_val+' has been successfully added!');}
                }
        }else{
            document.getElementById("checkAll").checked = false; 
            SelectedID.splice(index, 1);
            SelectedNames.splice(index2, 1);
            if (mode==0){alert(chkbox_val+' has been successfully removed!');}
        } 

        if (mode==0){
            GenerateSendTo();
        } 
    } */

    function GenerateSendTo(){
        console.log(SelectedID);
        var sendTo = document.getElementById('sendTodiv');
        let formattedList = SelectedNames.map(item => `<u style="color: blue; text-decoration: underline;">${item}</u>`).join(', ');
        sendTo.innerHTML = formattedList;
    }

    function SelectAll(thisID,tblID){
        
        GlovalHTMLObjLoading(1,'AnnounceModalLabel');   
        //var IsChecked = document.getElementById(thisID).checked;
        var table = document.getElementById(tblID); 
        for (var i = 0; i < table.rows.length; i++) { 
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                var cell = table.rows[i].cells[j]; 
                var checkbox = cell.querySelector('input[type="checkbox"]');
                
                if (checkbox && i!==0) {   
                    //document.getElementById(checkbox.id).checked = IsChecked; 
                    SelectID(checkbox.id,checkbox.id,1); 
                    alert(SelectedID);
                }  
            }
        }
        GenerateSendTo(); 
    }

  </script>

@endsection