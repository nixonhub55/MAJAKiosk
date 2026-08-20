<script>
    var attachedFiles = [];
</script>

<style>
    .attachmentHeader{
        background-color: #94c2ca;
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

    $existingFiles = []; 

    $existingFiles[] = [
        "filename"     => "file1", 
        "dateUploaded" => "2026-08-01",
        "content" => "asdassdaddasasd",
    ];

    $existingFiles[] = [
        "filename"     => "file2 awdaw dwad awd awdaw w", 
        "dateUploaded" => "2026-08-01",
        "content" => "asdassdaddasasd",
    ]; 

    $num = 0;
?>

<div>
    <label for="fileInput" id="lblfileInput"></label>
    <input type="file" accept=".jpg,.jpeg,.png,.webp,.pdf" id="fileInput" onchange="return pickSingleAttachment(this)" multiple hidden>
    <div class="attachmentHeader"> 
        <div class="left"><i class="fas fa-paperclip"></i> Attached File(s)</div>
        <div class="right" onclick="return modifyAttachments(1,0)"><i class="fas fa-upload"></i> Upload</div>
    </div>
    <div id="attachmentContent" class="attachmentContent">
        @if(count($existingFiles)==0)
            <center style="color:#7c8181"><i class="fas fa-box-open fs-2"></i> <br> No uploaded file</center>
        @else
            @foreach($existingFiles as $item)
                <?php $divId = "attachDiv".$num; ?>
                <div class="aitem" id="{{$divId}}"> 
                    <div class="attachmentItem">
                        <span class="remove-attachment" onclick="return modifyAttachments(0,'{{$divId}}')">&times;</span>
                        <i class="fa-solid fa-file-lines fs-1 text-primary"></i>   
                    </div> 
                    <div>{{$item['filename']}}</div>
                    <div style="font-size: 10px; color: #918e8e">{{$item['dateUploaded']}}</div>
                </div> 
                <script>
                     
                     var newItem = {
                        "num" : '<?= $num ?>',
                        "id" : '<?= $divId ?>',
                        "filename" : '<?= $item['filename'] ?>',
                        "dateUploaded" : '<?= $item['dateUploaded'] ?>'
                     } 
                     attachedFiles.push(newItem); 
                </script>
                <?php  $num++; ?>
                <!-- <span class="remove-attachment" onclick="this.parentElement.remove()">&times;</span> -->
            @endforeach
        @endif
    </div>
</div>

<script>
    
    function modifyAttachments(mode,divId){
          
        if(mode==0){
            if(confirm('Are you sure you want to remove this file?')){

                const elem = document.getElementById(divId);
                attachedFiles = attachedFiles.filter(item => item.id !== divId);
                elem.remove(); 
            }
        } 

        if(mode==1){
            var fileInput = document.getElementById('fileInput');
            fileInput.click();
        }
         
        //elem.parentElement.remove(); 
    }


    async function  pickSingleAttachment(fileInput) {
        const files = fileInput.files;
        const maxNum = (Math.max(...attachedFiles.map(item => item.num)))+1;
        const newDivID  = `attachDiv`+(maxNum);

        for (const fileDetails of files) {

            const filename = fileDetails.name;
            const fileType = ((fileDetails.type).replace('image/','')).replace('application/','');
            const fileSize = fileDetails.size;
            const datetoday = "2026-08-08";

            if (fileSize>5242880){
                this.attachmentContent = "";
                this.attachmentFileName = "";
                this.attachmentFilType = "";

                show_error_message('lblfileInput',filename+' File size to large!');  
                fileInput.value = "";
                return;
            } 

            var base64 =  await encodeImageToBase64(fileDetails);
            var newUploadedFile = generateNewUploadedFile(newDivID,filename,datetoday);
            document.getElementById('attachmentContent').insertAdjacentHTML('beforeend', newUploadedFile);

            var newItem = {
                "num" : maxNum,
                "id" : newDivID,
                "filename" : filename,
                "dateUploaded" :datetoday
                } 
            attachedFiles.push(newItem); 
        }



        console.log(attachedFiles);
    }

    function generateNewUploadedFile(divId,filename,dateUploaded){
        return `<div class="aitem" id="`+divId+`"> 
                    <div class="attachmentItem">
                        <span class="remove-attachment" onclick="return modifyAttachments(0,'`+divId+`')">&times;</span>
                        <i class="fa-solid fa-file-lines fs-1 text-primary"></i>   
                    </div> 
                    <div>`+filename+`</div>
                    <div style="font-size: 10px; color: #918e8e">`+dateUploaded+`</div>
                </div>`;
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