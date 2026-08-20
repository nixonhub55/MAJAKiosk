
<style>
  /* body { margin: 0; background: #ffff; color: #000; text-align: center; } */
  video, canvas { position: absolute; top: 60px; left: 0; }
  #controls { position: absolute; top: 10px; left: 10px; z-index: 10; }

  .camContainer {
    position: relative;
    width: 720px;
    height: 560px;
    border: 1px solid #000;
    color: #fff;
  }

  .camBackground {
    width: 100%;
    height: 100%;
    background-color: #645e5eff;
  }

  .camOverlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #645e5eff;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-weight: bold;
    /* opacity: 0.2; */
  }

  .spinner {
    /* border: 6px solid #f3f3f3;
    border-top: 6px solid #3f96cfff; 
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite; */

    width: 8px;
  height: 8px;
  position: relative;
  border-radius: 50%;
  background: #f9fafdff;
  animation: wave 1s ease-in infinite;
  }
 
  @keyframes wave {
    0% {  box-shadow:
    0 0 0 0px rgba(255, 255,255, 1),
    0 0 0 20px rgba(255, 255,255, 0.2),
    0 0 0 40px rgba(255, 255,255, 0.6),
    0 0 0 60px rgba(255, 255,255, 0.4),
    0 0 0 80px rgba(255, 255,255, 0.2)
    }
    100% {  box-shadow:
        0 0 0 80px rgba(255, 255,255, 0),
        0 0 0 60px rgba(255, 255,255, 0.2),
        0 0 0 40px rgba(255, 255,255, 0.4),
        0 0 0 20px rgba(255, 255,255, 0.6),
        0 0 0 0px rgba(255, 255,255, 1)
    }
    }
 
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<?php 
    $username = session()->get('username');
?>


<div class="camContainer"> 
    <div class="camBackground">  
        <div id="controls"> 
            <div class="btn btn-success" id="startCameraBtn" onclick="return startCamera()">Start</div>  
            <div class="btn btn-danger" id="stopCameraBtn" onclick="return stopCamera()">Exit</div> 
            <div id="divCam">Loading models...</div>
        </div>
      <div id="panelCam" style="display: none;">
        <video id="video" width="720" height="560" autoplay muted playsinline></video>
        <canvas id="overlay" width="720" height="560"></canvas>
      </div>
    </div>
    <div id="camOverlay" class="camOverlay"> 
      <div class="spinner"></div>
    </div>
</div>

<script>


    const video = document.getElementById('video');
    const canvas = document.getElementById('overlay');
    const ctx = canvas.getContext('2d');
    var modelsPath = '/portal/public/models';
    var thisMode = '<?=$mode?>';

    let detectionStart = 0;
    let lastBlinkTime = 0;
    let labeledDescriptors = [];
    let faceMatcher;
    const trackedFaces = []; 

    let modelsLoaded = false; 
    let detailsSaved = 0; 
    async function loadModelsAndCheckCamera() { 
        await Promise.all([ 
            faceapi.nets.tinyFaceDetector.loadFromUri(modelsPath),
            faceapi.nets.faceLandmark68Net.loadFromUri(modelsPath),
            faceapi.nets.faceRecognitionNet.loadFromUri(modelsPath)
        ]);
        modelsLoaded = true;
        document.getElementById('divCam').innerHTML = "Checking camera....";  
        checkingCamera();
    } 

    async function checkingCamera() {
        const tempVideo = document.createElement('video');
        tempVideo.width = 1;
        tempVideo.height = 1;
        tempVideo.autoplay = true;
        document.body.appendChild(tempVideo);

        // Use blank MediaStream to warm up
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { width: 1, height: 1 } });
          tempVideo.srcObject = stream;
          await new Promise(resolve => tempVideo.onloadedmetadata = resolve);
          // Perform dummy detection
          await faceapi.detectAllFaces(tempVideo, new faceapi.TinyFaceDetectorOptions({ inputSize: 128 }));
          stream.getTracks().forEach(track => track.stop());
          tempVideo.remove();
          document.getElementById('divCam').innerHTML = "Click start now!"; //Click Start Camera  
          document.getElementById('camOverlay').style.display = "none";
        } catch (err) {
            document.getElementById('divCam').innerHTML = err;
        }
    }

    function stopCamera(){
        document.getElementById('divScanner').style.display = "none";
    }


    async function startCamera() {
        if(document.getElementById('startCameraBtn').innerHTML=="Stop"){
            document.getElementById('divScanner').style.display = "none";
        }else{
            document.getElementById('camOverlay').style.display = "flex";
            document.getElementById('divCam').innerHTML = "Camera Starting please wait.."; 
            const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
            video.srcObject = stream;
            video.onloadedmetadata = () => {
            video.play();
            cameraReady = true;
            tryStartDetection();
            };
        }
    }

    async function tryStartDetection() {
        if (modelsLoaded && cameraReady) {
            document.getElementById('divCam').innerHTML = "Scanner Preparation...";
            const displaySize = { width: video.width, height: video.height };
            faceapi.matchDimensions(canvas, displaySize); 
            detectLoop(displaySize);
        }
    }

   // document.getElementById('startCameraBtn').onclick = startCamera;
 

    loadModelsAndCheckCamera();
    
    async function detectLoop(size) { 
        const runDetection = async () => {
          const detections = await faceapi
            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 128 }))
            .withFaceLandmarks()
            .withFaceDescriptors();

          const resized = faceapi.resizeResults(detections, size);
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          faceapi.draw.drawDetections(canvas, resized);

          const now = Date.now();

          for (let i = trackedFaces.length - 1; i >= 0; i--) {
            if (now - trackedFaces[i].lastSeen > 2000) trackedFaces.splice(i, 1);
          }

          for (let face of resized) {
            const lm = face.landmarks;
            const descriptor = face.descriptor;

            let tracked = findTrackedFace(descriptor);
            if (!tracked) {
              tracked = { descriptor, livenessPercent: 0, promptShown: false, lastSeen: now };
              trackedFaces.push(tracked);
            }
            tracked.lastSeen = now;

            if (checkBlink(lm)) { 
              lastBlinkTime = Date.now();
              tracked.livenessPercent += 30;
              if (tracked.livenessPercent > 100) tracked.livenessPercent = 100;
            } else { 
              tracked.livenessPercent -= 0.5;
              if (tracked.livenessPercent < 0) tracked.livenessPercent = 0;
            }

            if (detectionStart==0){
              document.getElementById('panelCam').style.display = "block";
              document.getElementById('camOverlay').style.display = "none";
              document.getElementById('divCam').innerHTML = "";  
              document.getElementById('startCameraBtn').innerHTML = "Stop";
              detectionStart=1;
            }

            ctx.font = '20px Arial';
            ctx.fillStyle = tracked.livenessPercent >= 50 ? 'lime' : 'red';
            ctx.fillText(`Liveness: ${tracked.livenessPercent.toFixed(0)}%`, face.detection.box.x, face.detection.box.y - 10);

            if (faceMatcher) {
              const match = faceMatcher.findBestMatch(descriptor);
              if (match.label !== 'unknown') {
                ctx.fillStyle = 'yellow';
                ctx.fillText(`Hello, ${match.label}!`, face.detection.box.x, face.detection.box.y - 30);
                if(tracked.livenessPercent>=100) loginNow(match.label); //console.log(match.label);
              } else if (tracked.livenessPercent >= 100 && !tracked.promptShown) {
                tracked.promptShown = true;
               /*  const name = prompt("Face unknown! Enter a name to save:");
                if (name) saveFace(name, descriptor); */
                if (detailsSaved==0){ 
                    saveNewDetails(descriptor);
                }
              }
            } else if (tracked.livenessPercent >= 100 && !tracked.promptShown) {
              tracked.promptShown = true;
             /*  const name = prompt("Face unknown! Enter a name to save:");
              if (name) saveFace(name, descriptor); */
                if (thisMode=='1'){
                    alert('Face not reconized. please make sure that you already enable face recognize in the settings!');
                    return false;
                }
                if (detailsSaved==0){  // REGISTRATION
                    saveNewDetails(descriptor);  
                } 
            }
          }

          requestAnimationFrame(runDetection);
        };
        runDetection();
    }

    async function loginNow(userId) { 
        document.getElementById('panelCam').style.display = "none";
        document.getElementById('startCameraBtn').style.display = "none";
        document.getElementById('camOverlay').style.display = "flex";
        document.getElementById('divCam').innerHTML = "Logining please wait...";
        var database = document.getElementById('database').value;
        loginRedirect(database,userId);
    }
     
    async function saveNewDetails(faceData) {
        
        if(thisMode=='0'){
            document.getElementById('panelCam').style.display = "none";
            document.getElementById('camOverlay').style.display = "flex";
            detailsSaved = 1;
            var formData = new FormData();   
            formData.append('mode', 26);    
            formData.append('pint_mode', thisMode);     
            formData.append('faceData', faceData);
            //const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
            const response = await exec_XMLHttpRequest(formData,'{{url("/faceRecognize")}}'); 
            if(response.num==0){ 
                document.getElementById('divCam').innerHTML = "Saving data please wait...";
                window.location.href = '{{url("/change_password")}}';
            }else{
                alert(response.msg);
            }
        }
        else{ 
            detailsSaved = 1;
            var formData = new FormData();   
            formData.append('mode', 26);    
            formData.append('pint_mode', 1);     
            formData.append('faceData', faceData);
            //const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
            const response = await exec_XMLHttpRequest(formData,'{{url("/faceRecognize")}}'); 
            if((response.rows.length)>0){
                //identityId
                var faceDetails = response.rows[0].faceDetails;
            }
            /* detailsSaved = 1;
            var formData = new FormData();   
            formData.append('mode', 26);    
            formData.append('pint_mode', thisMode);     
            formData.append('faceData', faceData);
            const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
            console.log(response); */
        }
    }

 
    function findTrackedFace(descriptor) {
        let best = null;
        let bestDist = Infinity;
        for (let t of trackedFaces) {
          const dist = faceapi.euclideanDistance(t.descriptor, descriptor);
          if (dist < 0.5 && dist < bestDist) {
            best = t;
            bestDist = dist;
          }
        }
        return best;
    }

    function euclidean(p1, p2) { return Math.hypot(p1.x - p2.x, p1.y - p2.y); }

    function eyeAspectRatio(eye) {
        const A = euclidean(eye[1], eye[5]);
        const B = euclidean(eye[2], eye[4]);
        const C = euclidean(eye[0], eye[3]);
        return (A + B) / (2.0 * C);
    }

    function checkBlink(landmarks) {
        const leftEye = landmarks.getLeftEye(), rightEye = landmarks.getRightEye();
        const avgEAR = (eyeAspectRatio(leftEye) + eyeAspectRatio(rightEye)) / 2.0;
        const BLINK_THRESHOLD = 0.23, BLINK_DURATION = 300;
        if (avgEAR < BLINK_THRESHOLD && Date.now() - lastBlinkTime > BLINK_DURATION) return true;
        return false;
    }

    function saveFace(name, descriptor) {
        /* localStorage.setItem(`face_${name}`, JSON.stringify(Array.from(descriptor)));
        alert(`Saved face as "${name}"`);
        loadSavedFaces(); */ 
        localStorage.setItem(`face_${name}`, JSON.stringify(Array.from(descriptor)));
        loadSavedFaces(); 
    }

    async function loadSavedFaces() {
        var formData = new FormData();   
        formData.append('mode', 26);    
        formData.append('pint_mode', 2);     
        formData.append('faceData', '');
        //const response = await exec_XMLHttpRequest(formData,'{{url("/call_ajax")}}'); 
        const response = await exec_XMLHttpRequest(formData,'{{url("/faceRecognize")}}'); 
        if(response.num==0){ 
            (response.rows).forEach(item => {
                console.log(labeledDescriptors);
                var identityId = item.identityId; 
                var faceDetails = new Float32Array( ((item.faceDetails).replace('"','')).split(',').map(Number));
                 localStorage.setItem(`face_${identityId}`, JSON.stringify(Array.from(faceDetails)));

            });
            
        } 
        labeledDescriptors = [];
        const keys = Object.keys(localStorage).filter(k => k.startsWith('face_'));
        keys.forEach(k => {
          const name = k.replace('face_', '');
          try {
            const desc = JSON.parse(localStorage.getItem(k));
            if (Array.isArray(desc) && desc.length === 128) {
              labeledDescriptors.push(new faceapi.LabeledFaceDescriptors(name, [new Float32Array(desc)]));
            } else {
              console.warn(`Skipping invalid face for ${name}`);
            }
          } catch(e) {
            console.warn(`Skipping invalid JSON for ${name}`);
          }
        });
        if (labeledDescriptors.length > 0)  faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6); 
        
    }
 
    

    if(thisMode=='1'){ 
        console.clear();
        loadSavedFaces();
    }
 
</script>