@extends('layouts.admin') <!-- main layout file -->

@section('content')  
<style>
         
        .container {
            width: 100%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius:5px;
        }
        h1 {
            text-align: center;
        }
        .toolbar {
            margin-bottom: 15px;
        }
        .toolbar button {
            padding: 10px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .editor {
            border: 1px solid #ccc;
            min-height: 500px;
            padding: 10px;
            font-size: 16px;
            background-color: #fff;
            overflow-y: auto;
            position: relative;
        }
        .publish-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .publish-btn:hover {
            background-color: #0056b3;
        }
        #fileInput {
            display: none;
        }
        #fileInput2 {
            display: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
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

        /* table:hover{
            border:1px solid red;
            background-color: red;
        } */

        
        .resizable-wrapper {
            display: inline-block;
            position: relative;
            max-width: 100%;
        }
        .resizable-wrapper img {
            display: inline-block;
            max-width: 100%;
            height: auto;
        }
        .resize-handle {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 16px;
            height: 16px;
            background-color: #007bff;
            cursor: se-resize;
        }

        .editor ul, .editor ol {
            list-style-position: inside;
        }

        .editor li {
            display: list-item;
        }

        .editor img {
            display: inline-block;
            max-width: 100%;
            margin: 10px;
        }

        .editor img[style*="text-align: left"] {
            margin-right: 10px;
        }

        .editor img[style*="text-align: right"] {
            margin-left: 10px;
        }

        .editor img[style*="text-align: center"] {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .btn_rebon {
            text-decoration: none;
            margin-left: 20px;
            cursor: pointer;
            border:0;
            background-color: white;
        }

                /* Basic Styles for the file menu */
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

        .modal-body {
            padding: 2em;
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
                              <button type="button" id="btn1" class="btn btn-success" onclick="return SubmitRequest(0,this.id)">Ok</button>
                        </div>
                  </div>
            </div>
      </div>

    <br>
    <div class="container">  
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
            <button onclick="triggerImageUpload()" class="btn_rebon" title="Image"><i class="fa-solid fa-image"></i></button>
    </div>

    <div id="editableArea" class="editor" contenteditable="true"></div>
        <input type="file" id="fileInput" accept="image/*" onchange="insertImage(event)" />
        <input type="file" id="fileInput2" onchange="handleFileUpload(event)">
        <br> 
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>

        var SelectedID =[];
        var SelectedNames =[];
        // Command function for text styling and alignment
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

        function createLink() {
            const url = prompt("Enter the link URL:");
            if (url) {
                document.execCommand('createLink', false, url);
            }
        }

        // Insert Table Function
        function insertTable() {
            const rows = prompt("Enter number of rows:");
            const cols = prompt("Enter number of columns:");

            if (rows && cols) {
                const table = document.createElement('table');
                for (let i = 0; i < rows; i++) {
                    const row = document.createElement('tr');
                    for (let j = 0; j < cols; j++) {
                        const cell = document.createElement(i === 0 ? 'th' : 'td');
                        cell.textContent = `Row ${i + 1} Col ${j + 1}`;
                        row.appendChild(cell);
                    }
                    table.appendChild(row);
                }
                insertNodeAtCursor(table);
            }
        }

        // Insert Image Function
        function triggerImageUpload() {
            document.getElementById('fileInput').click();
        }

        function insertImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    // Create a resizable wrapper
                    const resizableWrapper = document.createElement('div');
                    resizableWrapper.classList.add('resizable-wrapper');
                    resizableWrapper.appendChild(img);

                    // Add the resize handle
                    const resizeHandle = document.createElement('div');
                    resizeHandle.classList.add('resize-handle');
                    resizableWrapper.appendChild(resizeHandle);

                    // Make the image resizable by adding drag functionality
                    makeImageResizable(img, resizeHandle);

                    // Insert the image at the cursor's current position
                    insertNodeAtCursor(resizableWrapper);
                };
                reader.readAsDataURL(file);
            }
        }

        // Insert the node at the current cursor position
        function insertNodeAtCursor(node) {
            const selection = window.getSelection();
            const range = selection.rangeCount > 0 ? selection.getRangeAt(0) : createRange();
            range.deleteContents();
            range.insertNode(node);

            // Ensure the editor scrolls to keep the cursor visible
            const editor = document.querySelector('.editor');
            editor.scrollTop = editor.scrollHeight;
        }

        // Create a range if no selection exists
        function createRange() {
            const range = document.createRange();
            const selection = window.getSelection();
            const position = document.querySelector('.editor');
            range.selectNodeContents(position);
            selection.removeAllRanges();
            selection.addRange(range);
            return range;
        }

        // Function to make image resizable
        function makeImageResizable(img, handle) {
            let isResizing = false;

            handle.addEventListener('mousedown', function (e) {
                isResizing = true;

                const startX = e.clientX;
                const startY = e.clientY;
                const startWidth = img.width;
                const startHeight = img.height;

                function onMouseMove(e) {
                    if (!isResizing) return;

                    const width = startWidth + (e.clientX - startX);
                    const height = startHeight + (e.clientY - startY);

                    img.style.width = `${Math.max(50, width)}px`;
                    img.style.height = `${Math.max(50, height)}px`;
                }

                function onMouseUp() {
                    isResizing = false;
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            });
        }
 
        function publishPost() { 
            const content = document.querySelector('.editor').innerHTML;
            if (content.trim()) { 

            const blob = new Blob([content], { type: "text/html" });
            const url = URL.createObjectURL(blob);
             
            const link = document.createElement("a");
            link.href = url; 
            link.download = "content.pf";  
            link.click();

            } else {
                alert('Please write some content before publishing.');
            }
        }
 
        document.addEventListener('keydown', function (event) { 
            if (event.ctrlKey || event.metaKey) {
                if (event.key === 'z') {
                    event.preventDefault();
                    document.execCommand('undo');
                } else if (event.key === 'y') {
                    event.preventDefault();
                    document.execCommand('redo');
                }
            }
        });


                // Close the dropdown if clicked outside of the file menu
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

        // Prevent the click event from propagating when clicking inside the file menu
        document.querySelector('.file-menu').addEventListener('click', function(event) {
            event.stopPropagation();
        });
        

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
            const content = document.querySelector('.editor').innerHTML;
            const subject = document.getElementById('txtSubject').value; 
           
            if(SelectedID.length === 0){
                alert('Please select recipients first');
                ShowModalRecipients('','123123');
            }else{
                if (content.trim()) {
                if(confirm("Are you sure, you want to post this announcement?")){ 
                   PostAnnouncementNow(0,"fileMenu",content,subject); 
                }
            }else{
                alert("No content created to POST");
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
        

        async function PostAnnouncementNow(pint_mode,objID,p_content,p_subject) {  
            var formData = new FormData();
            formData.append('mode', '15');   
            formData.append('pint_mode', pint_mode); 
            formData.append('pId', 0);     
            formData.append('p_subject', p_subject); 
            formData.append('p_content', p_content);   
            formData.append('p_recipients', SelectedID);   
              
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
            
            if (response.num!==0){ 
                alert(response.msg);
            }else{ 
                window.location.href='{{url("/dash_cust")}}';
            } 

        }

        function SelectID(thisID,checkboxId,mode){ 
            const index = SelectedID.indexOf(thisID);
            var chkbox_val = document.getElementById(checkboxId).value;
            const index2 = SelectedNames.indexOf(chkbox_val); 
            if(document.getElementById(checkboxId).checked){ 
                    if (!SelectedID.includes(thisID)) {
                        SelectedID.push(thisID);
                        SelectedNames.push(chkbox_val);
                    }
            }else{
                document.getElementById("checkAll").checked = false; 
                SelectedID.splice(index, 1);
                SelectedNames.splice(index2, 1);
            } 

            if (mode==0){
                GenerateSendTo();
            } 
        }

        function GenerateSendTo(){
            var sendTo = document.getElementById('sendTodiv');
            let formattedList = SelectedNames.map(item => `<u style="color: blue; text-decoration: underline;">${item}</u>`).join(', ');
            sendTo.innerHTML = formattedList;
        }

        function SelectAll(thisID,tblID){
            
            GlovalHTMLObjLoading(1,'AnnounceModalLabel');   
            var IsChecked = document.getElementById(thisID).checked;
            var table = document.getElementById(tblID); 
            for (var i = 0; i < table.rows.length; i++) { 
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    var cell = table.rows[i].cells[j]; 
                    var checkbox = cell.querySelector('input[type="checkbox"]');
                    
                    if (checkbox && i!==0) {   
                       document.getElementById(checkbox.id).checked = IsChecked; 
                       SelectID(checkbox.id,checkbox.id,1);
                    }  
                }
            }
            GenerateSendTo(); 
        }
    </script> 
@endsection