
var rowsPerPage = 10;
var currentPage = 1;
var url = window.location.origin + window.location.pathname;
var baseUrl = url.split('/').slice(0, 4).join('/');
var execDone = 0;
var globalSysteError = 'An unexpected system error occurred. Please try again in a few moments. If the problem persists, contact your system administrator or support team for assistance.';
var maxMinExec = 300000;  // 60000 for 1 min
var JsonMessges = {
    "sucess_hdr": "Success",
    "app_delete": "<i style='color:green; font-size:40px' class='fa-solid fa-circle-check'></i> Your Application has been successfully deleted. thank you!"
};

var CurrentInnerHtml;
var lockApproverMessage = "<div class='alert alert-danger'><i class='fas fa-info-circle'></i>  Buttons are disabled due to payroll locked</div>";
var isCompleted = false;
//let div = document.querySelector('.modal-content');  
var gloalCode;
var refreshNum = 0;
var btns_div = document.getElementById('btns');

async function addAuditTrails(module, details) {
    try {
        const params = new URLSearchParams({
            module: module,
            type: 'Error',
            details: details,
        });

        const response = await fetch(`./addAuditTrails?${params}`);

        if (!response.ok) {
            throw new Error("Request failed");
        }

        const data = await response.json();
        console.log(data);
    } catch (error) {
        console.error(error);
    }
    //alert(globalSysteError);
    if (this.execDone == 1) {
        alert(globalSysteError);
    }
}


function ResetModalButtons() {
    if (refreshNum > 0) {
        btns_div.innerHTML = CurrentInnerHtml;
        refreshNum = 0;
    }
}

function GetMinDate(txtId) {
    frmDate = document.getElementById(txtId).value;
    year = new Date(frmDate).getFullYear();
    month = new Date(frmDate).getMonth();
    day = new Date(frmDate).getDate();

    var minDate = new Date(year, month, day);
    return minDate;
}

function EnterPassModal2(this_width, code) {

    this.this_code = code;
    var modal = document.getElementById("modal_enterpass");
    div.style.maxWidth = this_width;
    var jsonData = {
        mode: '1',
        code: code
    };
    //LoadPage('{{ route("modal.show", ["param" => "__PARAM__"]) }}'.replace("__PARAM__", encodeURIComponent(JSON.stringify(jsonData))),'modal-content');   
    LoadPage('{{ route("modal.show", ["param" => "__PARAM__"]) }}'.replace("__PARAM__", encodeURIComponent(JSON.stringify(jsonData))), 'modal-content');
    modal.style.display = "block";

}


function LoadPage(php_page, thisDiv) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', php_page, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(thisDiv).innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

async function SelectDate(num) {
    var df = document.getElementById('dateFrom').value;
    var dt = document.getElementById('dateTo').value;

    thisUrl = "";
    if (num == 0) {
        this.thisUrl = baseUrl + '/view_report_data';  // PAYSLIP REPORT
    } else if (num == 1) {
        this.thisUrl = baseUrl + '/view_report_data';  // 13th MONTH PAY REPORT
    }

    var formData = new FormData();
    formData.append('pint_mode', num);
    formData.append('df', df);
    formData.append('dt', dt);
    GlovalHTMLObjLoading(1, 'myTabContent');
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: thisUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            $('#myTabContent').html(response);
        },
        error: function (msg) {
            console.log('Error:' + JSON.stringify(msg));
        }

    });
}


function tester() {
    alert("You access this file. thanks");
}

function show_error_message(id, msg) {
    let targetElement = document.getElementById(id);
    let span = document.createElement('span');
    span.id = 'spanInfo';
    span.textContent = msg;
    span.classList.add('comic-box');
    targetElement.appendChild(span);
    document.getElementById(id).focus();

    setTimeout(function () {
        span.remove();
    }, 5000);
}


function hover_success_message(id, msg) {
    let targetElement = document.getElementById(id);
    let span = document.createElement('span');
    span.innerHTML = msg;
    span.classList.add('comic-box2');
    targetElement.appendChild(span);
    document.getElementById(id).focus();

    setTimeout(function () {
        span.remove();
    }, 1000);
}


function this_should_be_verified(checkbox_id) {
    var num = 1;
    var msg = 'OK';
    var json = {
        "num": num,
        "id": checkbox_id,
        "msg": msg
    };

    var chk_box = document.getElementById(checkbox_id).checked;
    num = (chk_box == true ? 0 : 1);
    msg = (chk_box == true ? "OK" : "Please check the ckeckbox verification");
    json.num = num;
    json.msg = msg;
    return json;
}

function EnterPassword(txtPass, divMsg) {
    var pass = document.getElementById(txtPass).value.trim();
    if (pass == "") {
        document.getElementById(divMsg).innerHTML = "Please enter your password!";
        return false;
    }
}

/* 
    function GlovalHTMLObjLoading(num,obj_id){ 
        
        const words = ['Processing', 'Loading', 'Executing', 'Please wait','Working','In progress','Running']; 
        const randomWord = words[Math.floor(Math.random() * words.length)];

        if (document.getElementById(obj_id) !== null){
            document.getElementById(obj_id).focus();
            if (num==1){
                CurrentInnerHtml = document.getElementById(obj_id).innerHTML; 
                document.getElementById(obj_id).innerHTML = "<b>"+randomWord+"</b> <i class='fa fa-spinner fa-spin'></i>&nbsp;";
                document.getElementById(obj_id).disabled = true;
            }else{ 
                document.getElementById(obj_id).innerHTML = CurrentInnerHtml;
                document.getElementById(obj_id).disabled = false;
            }
        }
    }
 */

function GlovalHTMLObjLoading(num, obj_id) {

    const words = ['Processing', 'Loading', 'Executing', 'Please wait', 'Working', 'In progress', 'Running'];
    const randomWord = words[Math.floor(Math.random() * words.length)];
    var newRowd = randomWord;

    if (!navigator.onLine) {
        newRowd = "No internet";
    }


    if (document.getElementById(obj_id) !== null) {
        document.getElementById(obj_id).focus();
        if (num == 1) {
            CurrentInnerHtml = document.getElementById(obj_id).innerHTML;
            document.getElementById(obj_id).innerHTML = "<b>" + newRowd + "</b> <i class='fa fa-spinner fa-spin'></i>&nbsp;";
            document.getElementById(obj_id).disabled = true;
        } else {
            document.getElementById(obj_id).innerHTML = CurrentInnerHtml;
            document.getElementById(obj_id).disabled = false;
        }
    }
}


function ForApprovalStatus(appStatus) {
    /* if (refreshNum==0){
        CurrentInnerHtml = btns_div.innerHTML;
    }
    if(appStatus=="F"){  
        var checkbox = document.getElementById('verification_checkbox');
       
        if(checkbox !== null){
            var label = document.querySelector(`label[for='${checkbox.id}']`); 
            btns_div.innerHTML="";
            checkbox.style.display="none"; 
            label.innerHTML = "<i class='fa-solid fa-triangle-exclamation'></i>  Note: You cannot Edit application [Pending] for approval!"
            label.style.color = 'red';   
        }
        
 
    }else{
        btns_div.innerHTML = CurrentInnerHtml;
    } */

    if (refreshNum == 0) {
        CurrentInnerHtml = (btns_div) ? btns_div.innerHTML : '';
    }
    if (appStatus == "F") {
        var checkbox = document.getElementById('verification_checkbox');
        var btns = document.getElementById('btns');

        if (checkbox !== null) {
            var label = document.querySelector(`label[for='${checkbox.id}']`);
            if (btns_div) {
                btns_div.innerHTML = "";
            }
            if(btns){
                btns.innerHTML = "";
            }
            checkbox.style.display = "none";
            label.innerHTML = "<i class='fa-solid fa-triangle-exclamation'></i>  Note: You cannot Edit application [Pending] for approval!"
            label.style.color = 'red';
        }


    } else {
        if (btns_div) {
            btns_div.innerHTML = CurrentInnerHtml;
        }
    }
    refreshNum += 1;

}

async function show_hist_details(switchNo, appNo,srcDb) { 

    num = (switchNo == 1000) ? 0 : switchNo;
    var formData = new FormData();
    formData.append('num', switchNo);
    formData.append('appNo', appNo);
    formData.append('r_opt',JSON.stringify({"srcDB":srcDb})); 
    
    var modals = ["overtimeModal", "leaveModal", "taModal", "obModal", "offsetModal", "teModal", "scModal"];
    var myModal;
    const thisModal = document.getElementById(modals[num]);

    if (thisModal === null) {
        myModal = new bootstrap.Modal(document.getElementById("dashboardModal"));
    }
    else {
        myModal = new bootstrap.Modal(document.getElementById(modals[num]));
    }

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        //url: '{{url("/hist_details_form")}}',  
        url: baseUrl + '/hist_details_form',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            $('#modal_body').html(response);
            document.getElementById('btns').style.display = "none";
            myModal.show();
        },
        error: function (msg) {
            console.log('Error:' + JSON.stringify(msg));
        }

    });

}

function FadeOut() {
    $("#myAlert").fadeOut(5000);
}



async function call_page_into_div(formData, this_page, container = null) {
    isCompleted = false;
    return new Promise((resolve, reject) => {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', this_page, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) { 
                resolve(xhr.responseText)

                if(container){ 
                    container.innerHTML = xhr.responseText;
                    container.querySelectorAll('script').forEach(oldScript => {
                        const newScript = document.createElement('script');  
                        Array.from(oldScript.attributes).forEach(attr => {
                            newScript.setAttribute(attr.name, attr.value);
                        }); 
                        newScript.textContent = oldScript.textContent; 
                        oldScript.replaceWith(newScript);
                    });
                }
                
            } else {
                reject(new Error('Request failed with status: ' + xhr.status));
                //console.log(xhr);
            }
            isCompleted = true;
        };
        xhr.onerror = function () {
            reject(new Error('Network error occurred'));
            isCompleted = true;
        };
        xhr.send(formData);
    });
}

async function loadAttachmentsAssets(mode, existingFiles) {
    GlovalHTMLObjLoading(0, "divFormsAttachmentsFiles");

    const formData = new FormData();
    formData.append('mode', mode);
    formData.append('files', existingFiles);
    //console.log(existingFiles);

    try {
        const response = await call_page_into_div(
            formData,
            window.attachedFilesAssetsUrl
        );

        const container = document.getElementById('divFormsAttachmentsFiles');
        container.innerHTML = response;

        container.querySelectorAll('script').forEach(oldScript => {
            const newScript = document.createElement('script');

            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });

            newScript.textContent = oldScript.textContent;
            oldScript.replaceWith(newScript);
        });

    } catch (error) {
        document.getElementById('divFormsAttachmentsFiles').innerHTML = error;
    }
}


function ShowHidePassword(txtPass) {
    var passwordField = document.getElementById(txtPass);
    var eyeIcon = document.getElementById('eyeIcon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}


function LoadPageIntoDiv(php_page, thisDiv) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', php_page, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(thisDiv).innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}


function LoadPageIntoDIV_GET(this_page, this_div) {
    try {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', this_page, true);
        xhr.onload = function () {
            try {
                if (xhr.status >= 200 && xhr.status < 300) {/*IF SUCCESS*/
                    document.getElementById(this_div).innerHTML = xhr.responseText;
                }
                else {

                    document.getElementById(this_div).innerHTML = "Error while executing function with status code:" + xhr.status;
                }
            } catch (error) {
                document.getElementById(this_div).innerHTML = "Error: " + error.message;
            }
        };
        xhr.send();
    } catch (error) {
        document.getElementById(this_div).innerHTML = "Error: " + error.message;
    }

}

function LoadPage(this_page, thisDiv, formData) {
    GlovalHTMLObjLoading(1, thisDiv);
    var xhr = new XMLHttpRequest();
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    xhr.open('POST', this_page, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(thisDiv).innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);
}

function call_route(formData, this_page) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this_page;


    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }


    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = token.getAttribute('content');
        form.appendChild(csrfInput);
    } else {
        console.warn("CSRF token not found in meta tag!");
    }

    document.body.appendChild(form);
    form.submit();
}



function CloasePopupInformMessage(id) { /*spanInfo*/
    if (document.getElementById(id) !== null) {
        document.getElementById(id).style.display = "none";
    }
}


function saveErrorLogs(log) {

    try {
        let logs = JSON.parse(localStorage.getItem('errorLogs')) || [];
        logs.push(log);
        localStorage.setItem('errorLogs', JSON.stringify(logs));
    } catch (error) {

    }

}

async function exec_XMLHttpRequest(formData, this_page) {
    this.execDone = 1;
    refreshNum = 0;

    CloasePopupInformMessage('spanInfo');

    return new Promise((resolve, reject) => {

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var xhr = new XMLHttpRequest();

        xhr.open('POST', this_page, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

     
        var lastResponseLength = 0;
        var progressBuffer = '';

        xhr.onprogress = () => {
            //console.log(1);
            var newData = xhr.responseText.substring(lastResponseLength);
            lastResponseLength = xhr.responseText.length;
            progressBuffer += newData;
            var lines = progressBuffer.split("\n");
            progressBuffer = lines.pop();

            lines.forEach(line => { 
                line = line.trim();
                console.log(line);
                if (!line) {
                    return;
                }

                try {

                    var progData = JSON.parse(line);
                    
                    if (progData.isUpdate == 1) {

                        const obj = document.getElementsByName(progData.id)[0];
                        
                        if (obj) {
                            obj.parentElement
                                .querySelectorAll('.progress-message')
                                .forEach(el => el.remove());

                            obj.insertAdjacentHTML(
                                'beforebegin',
                                `<span class="progress-message" style="margin-right:5px; color:#2da362">
                                    ${progData.msg}
                                </span>`
                            );
                        }

                    }

                } catch (e) {

                    //  console.log('Invalid progress JSON:', line);

                }

            });
        };

        
        xhr.onload = () => {

            if (xhr.status >= 200 && xhr.status < 300) {

                this.execDone = 0;


                var lines = xhr.responseText
                    .trim()
                    .split("\n");

                var finalResponse = JSON.parse(
                    lines[lines.length - 1]
                );
                //console.log('Done');
                resolve(finalResponse);

            } else {

                reject(new Error(
                    'Request failed with status: ' + xhr.status
                ));

                saveErrorLogs({ 'logId': 1, 'identityId': identityId,  'formData': formData,  'time': new Date(),  'errorMsg': xhr.responseText  });
            }
        };

        xhr.onerror = function () {

            reject(new Error('Network error occurred'));

            saveErrorLogs({
                'logId': 2,
                'identityId': identityId,
                'formData': formData,
                'time': new Date(),
                'errorMsg': new Error('Network error occurred')
            });
        };

        xhr.send(formData);
    });
}



/* 
async function exec_XMLHttpRequest(formData,this_page) { 
    this.execDone = 1;   
    refreshNum = 0;
    //saveErrorLogs(({'logId':0,'identityId':identityId,'formData':formData, 'time' :  new Date(),'errorMsg' :'Test'}));
    CloasePopupInformMessage('spanInfo');
    return new Promise((resolve, reject) => {
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       var xhr = new XMLHttpRequest();
       xhr.open('POST', this_page, true);
       xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);  
       //xhr.onload = function () {
       xhr.onload = () => {
          if (xhr.status >= 200 && xhr.status < 300) { 
             this.execDone = 0;
             //console.log(xhr.responseText);    
             resolve(JSON.parse(xhr.responseText)); 
          } else { 
             reject(new Error('Request failed with status: ' + xhr.status));   
             //reject(xhr.responseText); 
             saveErrorLogs(({'logId':1,'identityId':identityId,'formData':formData, 'time' :  new Date(),'errorMsg' : xhr.responseText}));
          }  
       }; 
       xhr.onerror = function () {
           //console.log(2);
          reject(new Error('Network error occurred')); 
          saveErrorLogs(({'logId':2,'identityId':identityId,'formData':formData, 'time' :  new Date(),'errorMsg' : new Error('Network error occurred')}));
       }; 
       xhr.send(formData); 
    }); 
}
  */

// TEST
/* async function exec_XMLHttpRequest(formData, this_page, onProgress = null) { 
    this.execDone = 1;
    refreshNum = 0; 
    CloasePopupInformMessage('spanInfo');

    return new Promise((resolve, reject) => {

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const xhr = new XMLHttpRequest();

        xhr.open('POST', this_page, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        let lastPosition = 0;
        let buffer = '';
        let lastData = null;


        // =========================================
        // RECEIVE PROGRESS WHILE PHP IS RUNNING
        // =========================================
        xhr.onprogress = () => {

            // Get only newly received text
            const newData = xhr.responseText.substring(lastPosition);

            lastPosition = xhr.responseText.length;

            buffer += newData;

            // PHP separates each JSON object using "\n"
            const lines = buffer.split('\n');

            // Keep incomplete JSON for the next progress event
            buffer = lines.pop();


            for (const line of lines) {

                if (!line.trim()) {
                    continue;
                }

                try {

                    const data = JSON.parse(line);

                    lastData = data;


                    // =========================================
                    // UPDATE PAGE WITH PROGRESS MESSAGE
                    // =========================================
                    if (data.isUpdate) {

                        const obj = document.getElementsByName(data.id)[0];

                        if (obj) {

                            obj.insertAdjacentHTML(
                                'beforebegin',
                                `<span style="margin-right:5px; color:#2da362">${data.msg}</span>`
                            );

                        }
                    }


                    // =========================================
                    // CUSTOM PROGRESS CALLBACK
                    // =========================================
                    if (typeof onProgress === 'function') {

                        onProgress(data);

                    }

                } catch (e) {

                    console.log(
                        'Progress JSON parse error:',
                        line,
                        e
                    );

                }
            }
        };


        // =========================================
        // REQUEST FINISHED
        // =========================================
        xhr.onload = () => {

            this.execDone = 0;


            if (xhr.status >= 200 && xhr.status < 300) {

                // =========================================
                // PROCESS ANY REMAINING BUFFER
                // =========================================
                if (buffer.trim()) {

                    try {

                        const data = JSON.parse(buffer);

                        lastData = data;


                        // Update page if final message
                        if (data.isUpdate) {

                            const obj =
                                document.getElementsByName(data.id)[0];

                            if (obj) {

                                obj.insertAdjacentHTML(
                                    'beforebegin',
                                    `<span style="margin-right:5px; color:#2da362">${data.msg}</span>`
                                );

                            }
                        }


                        // Call progress callback
                        if (typeof onProgress === 'function') {

                            onProgress(data);

                        }

                    } catch (e) {

                        console.log(
                            'Final buffer JSON parse error:',
                            buffer,
                            e
                        );

                    }
                }


                // =========================================
                // REQUEST SUCCESS
                // =========================================
                resolve(lastData);

            } else {

                // =========================================
                // REQUEST FAILED
                // =========================================
                const error = new Error(
                    'Request failed with status: ' + xhr.status
                );

                reject(error);


                saveErrorLogs({
                    logId: 1,
                    identityId: identityId,
                    formData: formData,
                    time: new Date(),
                    errorMsg: xhr.responseText
                });
            }
        };


        // =========================================
        // NETWORK ERROR
        // =========================================
        xhr.onerror = () => {

            this.execDone = 0;

            const error = new Error(
                'Network error occurred'
            );

            reject(error);


            saveErrorLogs({
                logId: 2,
                identityId: identityId,
                formData: formData,
                time: new Date(),
                errorMsg: error
            });
        };


        // =========================================
        // ABORTED REQUEST
        // =========================================
        xhr.onabort = () => {

            this.execDone = 0;

            reject(
                new Error('Request was aborted')
            );
        };


        // =========================================
        // SEND REQUEST
        // =========================================
        xhr.send(formData);

    });
}
  */

async function ExexStoredProc_GET(sp_name, parameters) {
    try {

        var errorList = {
            "row": [],
            "num": 1,
            "msg": ""
        };
        var queryString = Object.keys(parameters)
            .map(key => key + '=' + encodeURIComponent(parameters[key]))
            .join('&');
        var this_page = "/stored_proc/" + sp_name + '/' + queryString;
        return new Promise((resolve, reject) => {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', this_page, true);
            xhr.onload = function () {
                try {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resolve(xhr.responseText);
                    } else {
                        errorList.msg = "Error here with number: 1";
                        reject(errorList);
                    }
                } catch (error) {
                    errorList.msg = "Error here with number: 2";
                    reject(errorList);
                }
            };
            xhr.onerror = function () {
                errorList.msg = "Error here with number: 3";
                reject(errorList);
            };
            xhr.send();
        });
    } catch (error) {
        errorList.msg = error;
        reject(errorList);
    }
}

async function EditCert(num, mode) {
    const formData = new FormData();
    formData.append('appNo', num);
    formData.append('mode', mode);
    await call_route(formData, baseUrl + '/hrd_application_dtls');
}

async function loginRedirect(database, username) {
    const formData = new FormData();
    formData.append('database', database);
    formData.append('username', username);
    await call_route(formData, baseUrl + '/directLogin');
}


function Filter_History(pint_mode, objID, id) {
    GlovalHTMLObjLoading(1, objID);
    var formData = new FormData();
    formData.append('pint_mode', pint_mode);
    formData.append('id', id);
    formData.append('df', document.getElementById('txtdf').value);
    formData.append('dt', document.getElementById('txtdt').value);
    formData.append('status', document.getElementById('ddlStatus').value);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: 'filter_request',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            $('#divTbl').html(response);
            GlovalHTMLObjLoading(0, objID);
        },
        error: function (msg) {
            console.log('Error:' + JSON.stringify(msg));
        }

    });

}

function Filter_HistoryRequester(pint_mode, objID, id) {
    console.log('pint_mode:' + pint_mode + ' id:' + id);
    GlovalHTMLObjLoading(1, objID);
    var formData = new FormData();
    formData.append('pint_mode', pint_mode);
    formData.append('id', id);
    formData.append('df', document.getElementById('txtdf').value);
    formData.append('dt', document.getElementById('txtdt').value);
    formData.append('status', document.getElementById('ddlStatus').value);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: 'filter_requestRequester',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            $('#divTbl').html(response);
            GlovalHTMLObjLoading(0, objID);
        },
        error: function (msg) {
            console.log('Error:' + JSON.stringify(msg));
        }

    });

}

function SetAll(hdr_box, tbl_id) {
    TableRowsCheckUncheck(hdr_box, tbl_id);
}

function TableRowsCheckUncheck(hdr_box, myTable) {
    var checkbox_checked = document.getElementById(hdr_box).checked;

    let table = document.getElementById(myTable);
    let tbody = table.getElementsByTagName("tbody")[0];
    let rows = tbody.getElementsByTagName("tr");

    var num = rows.length - 1;
    for (let i = 0; i <= num; i++) {
        var new_checkbox = 'chkbox' + i;
        CheckMe(0, new_checkbox, hdr_box, myTable);
    }

    var arraysAreEqual = chkbox_list.length === chkbox_list_org.length && chkbox_list.every((val, index) => val === chkbox_list_org[index]);
    document.getElementById(hdr_box).checked = arraysAreEqual;
}

function loadTimeSelection(divId, txtID, selectedTime = null) {
    const selectElement = document.getElementById(divId);
    const txtElem = document.getElementById(txtID);
    for (let hour = 0; hour < 24; hour++) {
        for (let minute = 0; minute < 60; minute += 15) {
            const formattedTime = `${hour.toString().padStart(2, "0")}:${minute.toString().padStart(2, "0")}`;
            var newDiv = document.createElement("div");
            newDiv.innerHTML = formattedTime;
            newDiv.setAttribute('class', 'autofillItem');
            newDiv.setAttribute('onclick', `setTimeVal('` + txtID + `','` + formattedTime + `')`);
            selectElement.appendChild(newDiv);
        }
        txtElem.onclick = function () {
            selectElement.setAttribute('style', 'display: block;');
        };

        document.addEventListener('click', function (event) {
            if (!txtElem.contains(event.target)) {
                selectElement.setAttribute('style', 'display: none;');
            }
        });
    }
}

function setTimeVal(txtID, val) {
    var elem = document.getElementById(txtID);
    elem.value = val;
    time_validator();
}


function filterTime(id, thisId) {
    const searchText = document.getElementById(id).value.toLowerCase();
    const div = document.getElementById(thisId);
    const items = div.querySelectorAll('.autofillItem');

    items.forEach(item => {
        const itemText = item.innerText.toLowerCase();
        if (itemText.includes(searchText)) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
}

function filterItems(id, thisClass) {
    const searchText = document.getElementById(id).value.toLowerCase();
    const items = document.querySelectorAll(thisClass);
    const subs = document.querySelectorAll('.sub');

    if (searchText !== "") {
        subs.forEach(item => {
            //item.style.display = "block";
            item.classList.add('unSub');
        });
    } else {
        subs.forEach(item => {
            item.classList.remove('unSub');
        });
    }

    items.forEach(item => {
        const itemText = item.innerText.toLowerCase();
        if (itemText.includes(searchText)) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
}

function CheckMe(mode, thisId, hdr_box, tbl_id) {
    var targetID = (mode == 0) ? hdr_box : thisId;
    var checkbox_checked = document.getElementById(targetID).checked;
    var checkbox = document.getElementById(thisId);

    chkbox_list.includes(thisId) && chkbox_list.splice(chkbox_list.indexOf(thisId), 1);

    if ((checkbox_checked)) { chkbox_list.push(thisId); }
    if (checkbox !== null) {
        var tr = checkbox.closest("tr");
        var disp = tr.style.display;
        if (disp !== "none") {
            document.getElementById(thisId).checked = checkbox_checked;
        } else {
            chkbox_list.includes(thisId) && chkbox_list.splice(chkbox_list.indexOf(thisId), 1);
        }
    }

    chkbox_list.sort((a, b) => {
        return parseInt(a.replace('chkbox', '')) - parseInt(b.replace('chkbox', ''));
    });


    if (mode == 1) {
        var arraysAreEqual = chkbox_list.length === chkbox_list_org.length && chkbox_list.every((val, index) => val === chkbox_list_org[index]);
        document.getElementById(hdr_box).checked = arraysAreEqual;
    }

    show_approve_btn(tbl_id);


}

function get_original_checkbox_list(myTable) {

    let table = document.getElementById(myTable);
    let tbody = table.getElementsByTagName("tbody")[0];
    let rows = tbody.getElementsByTagName("tr");

    var num = rows.length - 1;
    for (let i = 0; i <= num; i++) {
        var new_checkbox = 'chkbox' + i;
        //if (document.getElementById(new_checkbox) !==null){ 
        chkbox_list_org.push(new_checkbox);
        //}
    }
    chkbox_list_org.sort((a, b) => {
        return parseInt(a.replace('chkbox', '')) - parseInt(b.replace('chkbox', ''));
    });
}

function RemoveClassInCheckBox(checkbox_id) {
    try {
        const button = document.querySelector(checkbox_id + ' button');
        const checkbox = button.querySelector('input[type="checkbox"]');

        button.remove();
        document.querySelector(checkbox_id).appendChild(checkbox);
        const thElement = document.querySelector(checkbox_id);
        thElement.appendChild(checkbox);
        thElement.style.textAlign = 'center';
        checkbox.style.margin = '0';
    } catch (error) {

    }
}

function show_approve_btn(tbl_id) {

    var pagination = document.getElementById("div_pagination");
    var htmlString = "<button  id='btn9999btn' class='btn btn-success' onclick='approveItems(this.id)'>Approve selected item(s)</button> <button id='btn9999btn2' class='btn btn-danger' onclick='rejectItems(this.id)'>Reject selected item(s)</button>";
    var btnApprove = document.getElementById('btn9999btn');
    var btnReject = document.getElementById('btn9999btn2');

    if (chkbox_list.length > 0) {
        if (btnApprove) btnApprove.remove();
        if (btnReject) btnReject.remove();
        pagination.insertAdjacentHTML('beforeend', htmlString);
    }
    else {
        if (btnApprove) btnApprove.remove();
        if (btnReject) btnReject.remove();
    }
}

/* function show_approve_btn(tbl_id){
      var table = document.getElementById(tbl_id); 
      
    if (chkbox_list.length>0 && approveBtnShow==0){ 
         
          var newRow = table.insertRow(-1);  
          var cell1 = newRow.insertCell(0);  
          cell1.colSpan =table.rows[0].cells.length;
          cell1.innerHTML = "<button id='btn9999btn' class='btn btn-success' onclick='approveItems(this.id)'>Approve selected item(s)</button> <button id='btn9999btn2' class='btn btn-danger' onclick='rejectItems(this.id)'>Reject selected item(s)</button>"; 
          approveBtnShow = 1;
    }else{
        
          if (chkbox_list.length<=0){
                table.deleteRow(table.rows.length - 1);
                approveBtnShow = 0;
          } 
    }  
   
} */


function HideText(id) {
    var txt = document.getElementById(id);
    if (txt.value.length > 0) {
        if (txt.value.length == 0) {
            txt.type = 'text';
        } else {
            txt.type = 'password'
        }

    } else {
        txt.type = 'text'
        OffAutoComplete(txt);
    }

}

function OffAutoComplete(txt) {
    var new_name = getRandomText(10);
    txt.setAttribute('autocomplete', new_name);
    //txt.addEventListener('change','hidetext('+txt+')'); 
}


function getRandomText(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return Array.from({ length }, () => characters.charAt(Math.floor(Math.random() * characters.length))).join('');
}

function fucosOnMe() {
    OffAutoComplete(txt);
}

function TblChangePage(val, tblId) {
    this.rowsPerPage = val;
    initializePagination(tblId.id);
}


function FilterTbl(txtId) {
    let tblId = txtId.replace("txt", "");
    let input = document.getElementById(txtId);
    let filter = input.value.toLowerCase();
    let table = document.getElementById(tblId);
    let tr = table.getElementsByTagName('tr');

    let visibleCount = 0;

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let rowContainsFilter = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                let txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    rowContainsFilter = true;
                    break; // No need to keep checking once we found a match
                }
            }
        }

        if (rowContainsFilter && visibleCount < rowsPerPage) {
            tr[i].style.display = '';
            visibleCount++;
        } else {
            tr[i].style.display = 'none';
        }
    }
}


function initializePagination(tblId) {
    var tbl = document.getElementById(tblId);
    var rowCount = tbl.rows.length - 1; // Exclude the header row 

    function displayTable(page) {
        const table = document.getElementById(tblId);
        const PageSelectorId = tblId + 'DDL';
        const PageLabel = tblId + 'Label';
        const PageText = tblId + 'txt';

        var ddl = document.getElementById(PageSelectorId);
        var lbl = document.getElementById(PageLabel);
        var txt = document.getElementById(PageText);

        const progressBar = `<div style="width: 100%;"> 
                                <div style="
                                    width: 100%;
                                    height: 10px;
                                    background: #ddd;
                                ">
                                    <div
                                        id="progressBar"
                                        style="
                                            width: 0%;
                                            height: 30px;
                                            background: #3498db;
                                            color: white;
                                            text-align: center;
                                            line-height: 30px;
                                            transition: width 0.3s;
                                        "
                                    >
                                        0%
                                    </div>
                                </div>`;


        const pageSelect = `<div  style='float:left' id=` + PageSelectorId + `>Show: 
                                <select class='tbl_entries' onchange='TblChangePage(this.value)'>
                                    <option value="5" ` + (rowsPerPage == 5 ? 'selected' : '') + `>5</option>
                                    <option value="10"  ` + (rowsPerPage == 10 ? 'selected' : '') + `>10</option>
                                    <option value="15" ` + (rowsPerPage == 15 ? 'selected' : '') + `>15</option>
                                    <option value="20" ` + (rowsPerPage == 20 ? 'selected' : '') + `>20</option>
                                    <option value="25" ` + (rowsPerPage == 25 ? 'selected' : '') + `>25</option>
                                    <option value="` + rowCount + `" ` + (rowsPerPage == rowCount ? 'selected' : '') + `>All</option>
                                </select> entrie(s)
                            <br><br></div>
                            `;


        var page_details = 'Showing ' + (((currentPage * rowsPerPage) - rowsPerPage) + 1) + ' to ' + (Math.min(rowsPerPage * currentPage, rowCount)) + ' of ' + rowCount + ' entries';
        const totalPage = "<label style='width:100%' id=" + PageLabel + ">" + page_details + "</label>";

        const SearchTxt = "<input class='tbl_search' style='float:right' type='text' id='" + PageText + "' onkeyup='return FilterTbl(this.id)' placeholder='Search' />";

        if (ddl) ddl.remove();
        if (lbl) lbl.remove();
        if (txt) txt.remove();
        table.insertAdjacentHTML('beforebegin', pageSelect);
        table.insertAdjacentHTML('beforeend', totalPage);
        table.insertAdjacentHTML('beforebegin', SearchTxt);

        table.classList.add('table-striped');
        table.querySelector('thead').classList.add('table-dark');
        const rows = table.getElementsByTagName('tr');

        const startIndex = (page - 1) * rowsPerPage + 1;
        const endIndex = Math.min(page * rowsPerPage + 1, rowCount + 1);

        // Loop through each row and hide or show depending on page number
        for (let i = 1; i < rows.length; i++) {
            rows[i].removeAttribute("style");
            //rows[i].className = '';
            if (i >= startIndex && i < endIndex) {
                rows[i].style.display = '';
                //rows[i].classList.add('show_tr');
            } else {
                rows[i].style.display = 'none';
                //rows[i].classList.add('hide_tr');
            }
        }

        // Disable/Enable the Prev and Next buttons
        document.getElementById(tblId + '-prevPage').disabled = (page === 1);
        document.getElementById(tblId + '-nextPage').disabled = (page * rowsPerPage >= rowCount);
    }

    // Next page button click event
    document.getElementById(tblId + '-nextPage').addEventListener('click', function () {
        const rows = document.getElementById(tblId).getElementsByTagName('tr');
        if (currentPage * rowsPerPage < rowCount) {
            currentPage++;
            displayTable(currentPage);
        }
    });

    // Prev page button click event
    document.getElementById(tblId + '-prevPage').addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            displayTable(currentPage);
        }
    });

    // Handle page change when the dropdown value is changed
    window.TblChangePage = function (rowsPerPageValue) {
        rowsPerPage = parseInt(rowsPerPageValue);  // Fixed here
        currentPage = 1;  // Reset to first page when changing rows per page
        displayTable(currentPage);
    };

    // Initialize table view
    displayTable(currentPage);
}

function searchTable(txtSearch, tblID) {
    const input = document.getElementById(txtSearch);
    const filter = input.value.toLowerCase();
    const table = document.getElementById(tblID);
    const trs = table.getElementsByTagName("tr");

    for (let i = 1; i < trs.length; i++) {
        let showRow = false;
        const tds = trs[i].getElementsByTagName("td");
        for (let j = 0; j < tds.length; j++) {
            if (tds[j].textContent.toLowerCase().includes(filter)) {
                showRow = true;
                break;
            }
        }
        trs[i].style.display = showRow ? "" : "none";
    }
}

async function SetSession(sessionName, val) {
    var formData = new FormData();
    formData.append('sessionName', sessionName);
    formData.append('val', val);
    await call_page_into_div(formData, "set_session");
}

window.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.querySelector('#sidebarToggle');

    if (!sidebarToggle) return;

    // Prevent double attaching
    if (sidebarToggle.dataset.bound === "true") return;
    sidebarToggle.dataset.bound = "true";

    sidebarToggle.addEventListener('click', (event) => {
        event.preventDefault();
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem(
            'sb|sidebar-toggle',
            document.body.classList.contains('sb-sidenav-toggled')
        );
    });
});




/* 
function TableRowsCheckUncheck(hdr_box,myTable){ 
    var checkbox_checked = document.getElementById(hdr_box).checked;


    let table = document.getElementById(myTable); 
    let tbody = table.getElementsByTagName("tbody")[0]; 
    let rows = tbody.getElementsByTagName("tr");

    
    try {
          var num = rows.length - 1; 
          for (let i = 0; i <= num; i++) {
          var new_checkbox = 'chkbox'+i;
          var this_checkbox = document.getElementById(new_checkbox); 
          this_checkbox.checked = checkbox_checked; 
                if (checkbox_checked){ 
                      if (chkbox_list.indexOf(new_checkbox) === -1) {
                           chkbox_list.push(new_checkbox);
                      } 
                }else{
                      chkbox_list = [];
          } 
    }  
    } catch (error) { 
    } 
   show_approve_btn(myTable); 
  

} */