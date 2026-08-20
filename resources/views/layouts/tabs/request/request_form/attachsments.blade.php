<?php
     
?>
<script>
    var attachedFiles = [];
    var mode = '<?= $_POST['mode'] ?>';
 

    var empTyItems = `<center style="color:#7c8181"><i class="fas fa-box-open fs-2"></i> <br> No uploaded file</center>`;
    
    function modifyAttachments(mode,divId){
          
        if(mode==0){
            if(confirm('Are you sure you want to remove this file?')){ 
                const elem = document.getElementById(divId);
                attachedFiles = attachedFiles.filter(item => item.id !== divId);
                elem.remove(); 
                if(attachedFiles.length==0){
                    document.getElementById('attachmentContent').innerHTML = empTyItems;
                } 
            }
        } 

        if(mode==1){
            var fileInput = document.getElementById('fileInput');
            fileInput.click();
        }
         
        return false;
    }


    async function  pickSingleAttachment(fileInput) {
        const files = fileInput.files;
        var maxNum = Math.max(0, ...attachedFiles.map(item => item.num)) + 1; 
        for (const fileDetails of files) {
            var newDivID  = `attachDiv`+(maxNum);
            console.log(newDivID);
            const filename = fileDetails.name;
            const fileType = ((fileDetails.type).replace('image/','')).replace('application/','');
            const fileSize = fileDetails.size; 
            const datetoday = new Date().toLocaleString("sv-SE", {
                    timeZone: "Asia/Manila",
                    hour12: false
                }).replace(",", "");

            if (fileSize>5242880){
                this.attachmentContent = "";
                this.attachmentFileName = "";
                this.attachmentFilType = "";

                show_error_message('lblfileInput',filename+' File size to large!');  
                fileInput.value = "";
                return;
            } 

            if(attachedFiles.length==0){
                document.getElementById('attachmentContent').innerHTML = "";
            }

            var base64 =  await encodeImageToBase64(fileDetails);
            var newUploadedFile = generateNewUploadedFile(maxNum,newDivID,filename,datetoday,base64); 
            document.getElementById('attachmentContent').insertAdjacentHTML('beforeend', newUploadedFile);
            maxNum++;
        }
 
        console.log(attachedFiles);
    }

    function generateNewUploadedFile(maxNum, divId, filename, dateUploaded, content) {

            var newItem = {
                "num": maxNum,
                "id": divId,
                "filename": filename,
                "content": content,
                "dateUploaded": dateUploaded
            };

            attachedFiles.push(newItem);

            return `
                <div class="aitem" id="${divId}">
                    <div class="attachmentItem">
                        ${mode == 1
                            ? `<span class="remove-attachment" onclick="return modifyAttachments(0,'${divId}')">&times;</span>`
                            : ''
                        }
                        <i class="fa-solid fa-file-lines fs-1 text-primary"
                        onclick="openBase64('${content}')"></i>
                    </div>
                    <div>${filename}</div>
                    <div style="font-size: 10px; color: #918e8e">${dateUploaded}</div>
                </div>
            `;
    }

    async function encodeImageToBase64(file){ 
        return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;

                reader.readAsDataURL(file);
        });
    } 

</script>

<style>
    .attachmentHeader{
        background-color: #083c46;
        padding: 10px;
        color: #fff;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px; 
        justify-content: space-between;
         display: flex;
    }

    .attachmentHeader .left {
        text-align: left;
    }

    .attachmentHeader .right {
        text-align: right;
        cursor: pointer;
        border: 1px solid #7c8181;
        padding: 5px;
        border-radius: 5px;
        background-color: #458558;
    }


    .attachmentHeader .right:hover { 
        background-color: #c3c9c5;
        color: #000000;
    }

    .attachmentContent{
        padding: 10px;
        border: 1px dotted #757269bb;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .aitem{
        display: inline-block;
        padding: 10px;
    }

    .aitem:hover{
      background-color: #e2dfdf;
    }
    
    .attachmentItem{
       position: relative;
        display: inline-flex;
        padding: 10px;
       /*  display: inline-block;  */
    }

    

    .remove-attachment {
    position: absolute;
    top: 2px;
    right: 5px;
    cursor: pointer;
    color: #888;
    font-size: 16px;
    line-height: 1;
}

.remove-attachment:hover {
    color: red;
}
</style> 
<?php

    $files = trim($_POST['files']);

    if (substr($files, 0, 1) === '"' && substr($files, -1) === '"') {
        $files = substr($files, 1, -1);
    }

    $files = json_decode($files, true);
 

    $existingFiles = $files; 

   

  /*   $existingFiles[] = [
        "filename"     => "file1", 
        "dateUploaded" => "2026-08-01",
        "content" => "asdassdaddasasd",
    ];

    $existingFiles[] = [
        "filename"     => "file2 awdaw dwad awd awdaw w", 
        "dateUploaded" => "2026-08-01",
        "content" => "asdassdaddasasd",
    ];  */

    $num = 0;
?>

<div>
    <label for="fileInput" id="lblfileInput"></label>
    <input type="file" accept=".jpg,.jpeg,.png,.webp,.pdf" id="fileInput" onchange="return pickSingleAttachment(this)" multiple hidden>
    <div class="attachmentHeader"> 
        <div class="left"><i class="fas fa-paperclip"></i> Attached File(s)</div>
        @if($_POST['mode']==1)
            <div class="right" onclick="return modifyAttachments(1,0)"><i class="fas fa-upload"></i> Upload</div>
        @endif
    </div>
    <div id="attachmentContent" class="attachmentContent"></div>
</div>

<script>

 

    var exestingFiles = JSON.parse('<?= json_encode($existingFiles); ?>')
   
    var num = 0;
    exestingFiles.forEach(item => { 
        var divId = 'attachDiv'+num;
        var newUploadedFile = generateNewUploadedFile(num,divId,item.filename,item.dateUploaded,item.content) 
        document.getElementById('attachmentContent').insertAdjacentHTML('beforeend', newUploadedFile); 
      num++;
    });

    if(exestingFiles.length==0){
        document.getElementById('attachmentContent').innerHTML = empTyItems;
    }

    function openBase64(base64) { 
        window.open(base64, '_blank');
    }

</script>
