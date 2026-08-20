<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  
  <style>
      /* Container fills the screen and centers its content */
    #camContaner {
        margin: 0;
        /* background: transparent; */
        background: transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        height:500px;
        /* height: 100vh; */
        overflow: hidden;
        color: white;
        font-family: sans-serif;
        position: relative; 
    }

    #video,
    #overlay {
      max-width: 100%;    /* never exceed container width */
      max-height: 100%;   /* never exceed container height */
      width: auto;        /* scale proportionally */
      height: auto;       /* scale proportionally */
      border-radius: 8px; 
    }

    #overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      pointer-events: none;
      z-index: 2; 
    }

    #log {
      position: fixed;
      top: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0,0,0,0.6);
      padding: 10px 20px;
      border-radius: 6px;
      font-size: 14px;
      max-width: 90vw;
      text-align: center;
      z-index: 999;
    } 

    
    

    /* Mobile devices */
    @media only screen and (max-width: 600px) {
      #camContaner{ 
        margin-top: -100px; 
        background-color: #fff;
        height: 100vh;
      } 

       #video , #overlay{
       width: 400px;
       height: 300px;
      }


      #divScanner{
        background-color: #fff;
      }

      
      
    }
  
  </style>


</head>
<body id="bodyCam">
  <div id="camContaner" onclick="return closeCamera()">  
      <video id="video" width="640" height="480" autoplay muted></video>
      <canvas id="overlay" width="640" height="480"></canvas>
    <div id="log">Loading...</div>
    <div id="divChallenge" style="position:absolute;z-index: 99999; display:none"></div>  
  </div> 
  
 
<script>
/* ============================================================
   DOM ELEMENTS
============================================================ */
const video  = document.getElementById("video");
const canvas = document.getElementById("overlay");
const ctx    = canvas.getContext("2d");
const log    = document.getElementById("log");
var tempStop = 0;
var challengeNo = 0;
var blinked = 0;
var modelpaths = "/kiosk/public/models"; //LIVE
//var modelpaths =  "/portal/public/models";  // local
var thisMode = '<?=$mode?>';

/* ============================================================
   FACE MATCHING STORAGE
============================================================ */
let labeledDescriptors = [];
let faceMatcher = null;

function stableFaceId(descriptor) {
  return descriptor.map(v => Math.round(v * 100)).join("-");
}

/* ============================================================
   MODEL LOADING
============================================================ */
async function loadModels() {
  log.textContent = "Loading models...";

  await Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri(modelpaths),
    faceapi.nets.faceLandmark68Net.loadFromUri(modelpaths),
    faceapi.nets.faceRecognitionNet.loadFromUri(modelpaths)
  ]);

  log.textContent = "Models loaded. Starting camera...";
   
  if (thisMode==1){
    loadSavedFaces('[]'); 
  }
  
  await startVideo();
  await warmUpModels();
  startDetectionLoop(); 
 
}
 

async function startVideo() {
  const stream = await navigator.mediaDevices.getUserMedia({
    video: { width: 640, height: 480 }
  });
  video.srcObject = stream;

  return new Promise(resolve => video.onplaying = resolve);
}

async function warmUpModels() {
  const dummy = faceapi.createCanvasFromMedia(video);
  await faceapi.detectSingleFace(dummy, new faceapi.TinyFaceDetectorOptions({ inputSize: 160 }));
  log.textContent = "Models warmed up!";
} 

async function loadSavedFaces(_data) {
    
    var formData = new FormData();   
    formData.append('mode', 2);     
    formData.append('faceData', _data); 
    const response = await exec_XMLHttpRequest(formData,'{{url("/faceRecognize")}}');  
    
    if (response.num==0){
      const data = response.rows; 
      if (!data) return log.textContent = "No saved faces yet.";
      const parsed = data;

      parsed.forEach(item => {
        var details = JSON.parse(item.faceDetails)[0];
        var label = details.label;
        var descriptors = details.descriptors;
        
        labeledDescriptors = parsed.map(p =>
          new faceapi.LabeledFaceDescriptors(
            label,
            descriptors.map(d => new Float32Array(d))
          )
        ); 

      });


      localStorage.setItem(
        "savedFaces",
        JSON.stringify(
          labeledDescriptors.map(ld => ({
            label: ld.label,
            descriptors: ld.descriptors.map(d => Array.from(d))
          }))
        )
      );

      faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);


      

      //console.log(labeledDescriptors);
    }else{
      log.textContent =response.msg;
    } 
}
  
  
const challengesMaster = [   
    /* "Blink twice", */
    "Look left",
    "Look right",
    "Look up", 
    "Open your mouth",
    "Smile" 
];


/* const challengesMaster = [    
    "Smile" 
];
  */

function pickRandomItems(arr, n) {
  const shuffled = [...arr].sort(() => 0.5 - Math.random());
  return shuffled.slice(0, n).map(item => ({
    cName: item,
    cStatus: 0
  }));
}

const challenges = pickRandomItems(challengesMaster, 3); 

//divChallenge//Blink
challenges.forEach(item => {
   var lbl = (item.cName=="Blink twice") ? "Face down and blink eyes twice" : item.cName;
    var newHTML = `<label>`+lbl+` </label> <cStatus id="`+item.cName+`"><st style="color:red">&#10007;</st></cStatus></br>`
    document.getElementById('divChallenge').innerHTML+=newHTML;
});


let currentChallenge = null;
let challengeSatisfied = false;
let lastLandmarks = null;

const state = {
  blinkCount: 0,
  opticalScore: 0
};
 
//DETECTIONS FUNCITONS

    function detectEyebrows(landmarks){
          const leftEye = landmarks.getLeftEye?.() || [];
          const rightEye = landmarks.getRightEye?.() || [];
          const leftBrow = landmarks.getLeftEyebrow?.() || [];
          const rightBrow = landmarks.getRightEyebrow?.() || [];

          if (!leftEye.length || !rightEye.length || !leftBrow.length || !rightBrow.length) {
            console.warn("Missing eye/brow landmarks");
            return false;
          }

          // Helper: average Y of a group of points
          const avgY = (points) => points.reduce((s, p) => s + p.y, 0) / points.length;

          // Compute average positions
          const leftEyeY = avgY(leftEye);
          const rightEyeY = avgY(rightEye);
          const leftBrowY = avgY(leftBrow);
          const rightBrowY = avgY(rightBrow);

          // Vertical distances (eye → eyebrow)
          const leftGap = leftEyeY - leftBrowY;
          const rightGap = rightEyeY - rightBrowY;

          // Normalize using eye height (to avoid face-size differences)
          const leftEyeHeight = Math.abs(leftEye[0].y - leftEye[3].y) || 0.01;
          const rightEyeHeight = Math.abs(rightEye[0].y - rightEye[3].y) || 0.01;

          const leftRatio = (leftGap / leftEyeHeight).toFixed(2);
          const rightRatio = (rightGap / rightEyeHeight).toFixed(2);

           
          // Threshold (typical raised-eyebrows ≈ 1.4–2.5)
          const THRESHOLD = 1.45;
          if(leftRatio > THRESHOLD && rightRatio > THRESHOLD) console.log("Eyebrow ratios:", leftRatio, rightRatio);

          return leftRatio > THRESHOLD && rightRatio > THRESHOLD;
    }

    function detectSmile(landmarks){
          const mouth = landmarks.getMouth();
          if (!mouth || mouth.length < 8) return false;

          // Identify mouth corners
          const leftCorner = mouth.reduce((a, b) => (a.x < b.x ? a : b));
          const rightCorner = mouth.reduce((a, b) => (a.x > b.x ? a : b));

          // Identify approximate upper/lower lip center
          const upperLip = mouth.reduce((a, b) => (a.y < b.y ? a : b));
          const lowerLip = mouth.reduce((a, b) => (a.y > b.y ? a : b));

          // Basic geometry
          const mouthWidth = Math.abs(rightCorner.x - leftCorner.x);
          const mouthHeight = Math.abs(lowerLip.y - upperLip.y);

          if (mouthHeight === 0) return false; 
          const ratio = (mouthWidth / mouthHeight).toFixed(2); 
          const THRESHOLD = 3.30; 
          //console.log(ratio);
          return ratio > THRESHOLD;
    }
  
    function detectOpenMouth(landmarks) {
      const mouth = landmarks.getMouth();
      if (!mouth || mouth.length < 8) return false;

      // --- 1️⃣ FILTER ONLY TRUE LIP POINTS ---
      // Remove extreme outliers (chin or noise)
      const sortedByY = [...mouth].sort((a, b) => a.y - b.y);
      const central60 = sortedByY.slice(
        Math.floor(mouth.length * 0.2),
        Math.ceil(mouth.length * 0.8)
      );

      // --- 2️⃣ FIND TOP + BOTTOM LIP USING MIDPOINT CLUSTERING ---
      const upperLip = central60.reduce((best, p) =>
        p.y < best.y ? p : best
      );

      const lowerLip = central60.reduce((best, p) =>
        p.y > best.y ? p : best
      );

      // If Y axis is reversed, swap
      let top = upperLip;
      let bottom = lowerLip;
      if (top.y > bottom.y) {
        [top, bottom] = [bottom, top];
      }

      // --- 3️⃣ FIND LEFT + RIGHT CORNERS ---
      const left = mouth.reduce((a, b) => (a.x < b.x ? a : b));
      const right = mouth.reduce((a, b) => (a.x > b.x ? a : b));

      // --- 4️⃣ COMPUTE GAPS ---
      const verticalGap = Math.abs(bottom.y - top.y);
      const mouthWidth = Math.abs(right.x - left.x);

      if (mouthWidth === 0) return false;

      const ratio = (verticalGap / mouthWidth).toFixed(2); 

      // --- 5️⃣ ROBUST THRESHOLD ---
      // Closed mouth: 0.02–0.06
      // Slight open:  0.07–0.12
      // Open mouth:   0.13+
      const THRESHOLD = 0.50;

      //if(ratio > THRESHOLD) console.log("Filtered mouth ratio:", ratio);

      return ratio > THRESHOLD;
    }
 
    function ear(eye) {
      const d = (p1, p2) => Math.hypot(p1.x - p2.x, p1.y - p2.y);
      return (d(eye[1], eye[5]) + d(eye[2], eye[4])) / (2.0 * d(eye[0], eye[3]));
    }
    
    function detectBlink(landmarks) {
      const leftEAR  = ear(landmarks.getLeftEye());
      const rightEAR = ear(landmarks.getRightEye());
    
      const blinkThreshold = 0.23; 
    
      const leftBlink = leftEAR < blinkThreshold;
      const rightBlink = rightEAR < blinkThreshold;
    
      const isBlinking = leftBlink || rightBlink; 
      return ({"isTrue" : isBlinking, "dtls": isBlinking});
    } 

    function detectHeadPoseBalanced(landmarks) {
        const nose = landmarks.getNose();
        const leftEye = landmarks.getLeftEye();
        const rightEye = landmarks.getRightEye();
        const jaw = landmarks.getJawOutline();

        // Horizontal detection
        const eyeMidX = (leftEye[0].x + rightEye[3].x) / 2;
        const noseX = nose[3].x;
        const left = noseX > eyeMidX + 12;
        const right = noseX < eyeMidX - 12;

        // Vertical detection using normalized ratio
        const eyeMidY = (leftEye[1].y + rightEye[1].y) / 2;
        const chinY = jaw[8].y;
        const noseY = nose[3].y;

        // Vertical ratio normalized to eye-chin distance
        const verticalRatio = (noseY - eyeMidY) / (chinY - eyeMidY);

        // Adjust thresholds for better "down" detection
        const up = verticalRatio < 0.35;    // head tilted up
        const down = verticalRatio > 0.55;  // head tilted down (more sensitive)

        return { left, right, up, down };
    } 
    
    function opticalFlowScore(current) { 
      if (!lastLandmarks) {
        lastLandmarks = current;
        return 0;
      }

      let score = 0;
      for (let i = 0; i < current.length; i++) {
        score += Math.hypot(
          current[i].x - lastLandmarks[i].x,
          current[i].y - lastLandmarks[i].y
        );
      }

      lastLandmarks = current;
      return score;
    }
 
    function detectScreenReplay(det) { 
      
      const box = det.detection.box;
      const data = ctx.getImageData(box.x, box.y, box.width, box.height).data;

      let avg = 0, variance = 0;

      for (let i = 0; i < data.length; i += 4) {
        avg += data[i];
      } 
      
      avg /= (data.length / 4);

      for (let i = 0; i < data.length; i += 4) {
        const diff = data[i] - avg;
        variance += diff * diff;
      }
      variance /= (data.length / 4); 
      return variance < 200; // too uniform => screen replay
    }
//DETECTIONS FUNCITONS


/* ------------------------ CHALLENGE PICKER ---------------- */
async function pickChallenge(details,faceMatcher) { 
 

    if((challengeNo+1)<=challenges.length){
      currentChallenge = challenges[challengeNo].cName;
      challengeSatisfied = false;
      if(document.getElementById('divChallenge').style.display=="block"){
        log.textContent = `Challenge: ${currentChallenge}`;
      }
    }else{ 
      if(tempStop==0){
          tempStop=1;  

          const landmarks = details.landmarks;
          const live = evaluateChallenge(landmarks, details); 

          if (!faceMatcher) { 
            //if (live) await registerNewFace(details.descriptor);
            if (live) await fetchDataNow(details.descriptor);
            if (!live) log.textContent = "No live face detected!";
            return false;
          }
          
          const match = faceMatcher.findBestMatch(details.descriptor);

          if (thisMode==0){
              fetchDataNow(details.descriptor,'');
          }else{
              if (match.label === "unknown") { 
                log.textContent = "Face not found in our record!";
              } else {
                //log.textContent = match.label;
                fetchDataNow(details.descriptor,match.label);
              }
          }

          
      }
      return false;
    }
}
 
 
async function fetchDataNow(_data,user) { 
      tempStop = 1;
      var username = '<?=session()->get('username')?>';

      if(thisMode==0){ 
        labeledDescriptors.push(
          new faceapi.LabeledFaceDescriptors(username, [_data])
        );

        _data = JSON.stringify(
                labeledDescriptors.map(ld => ({
                  label: ld.label,
                  descriptors: ld.descriptors.map(d => Array.from(d))
                }))
              )
      }


      var formData = new FormData();   
      formData.append('mode', thisMode);     
      formData.append('faceData', _data); 
      const response = await exec_XMLHttpRequest(formData,'{{url("/faceRecognize")}}'); 
      if(response.num==0){
        if(thisMode==0){
          log.textContent = "Saving data. please wait..."; 
          window.location.href = '{{url("/change_password")}}';
        }else{ 
          log.textContent = "Logining, please wait..."; 
          log.id = "123123";
          loginRedirect('<?= session()->get('database') ?>',user);
        }
      }else{
        
        log.textContent = response.msg; 
      }
}

/* ------------------------ LIVENESS CHECK ------------------ */
function evaluateChallenge(landmarks, det) {
  const blink = detectBlink(landmarks);
  //const pose  = detectHeadPose(landmarks);
  const pose  = detectHeadPoseBalanced(landmarks);
  const flow  = opticalFlowScore(landmarks.positions);
  const mouth = detectOpenMouth(landmarks);
  const smile = detectSmile(landmarks);
  //const eyebrows = detectEyebrows(landmarks);

  
   
  state.opticalScore = flow;
 
  switch (currentChallenge) {
    case "Blink twice":  
      if (blink.isTrue){
        blinked++;
        state.blinkCount++;  
      }
      if (state.blinkCount >= 2) challengeSatisfied = true;
      break;

    case "Look left":
      if (pose.left) challengeSatisfied = true;
      break;

    case "Look right":
      if (pose.right) challengeSatisfied = true;
      break;

    case "Look up":  
      if (pose.up) challengeSatisfied = true;
      break;

    case "Look down": 
      if (pose.down) challengeSatisfied = true;
      break;

    case "Open your mouth":  
      if (mouth) challengeSatisfied = true;
      break;

    case "Smile":  
      if (smile) challengeSatisfied = true;
      break;

    case "Raise your eyebrows":  
      if (eyebrows) challengeSatisfied = true;
      break;
      
 
  } 
  
  if(challengeSatisfied){
    num = 0;
    challenges.forEach(item => {
      if(item.cName==currentChallenge){ 
        challenges[num].cStatus  =1;
        challengeNo = (num+1);
      }
      num++;
    }); 
    document.getElementById(currentChallenge).innerHTML = `<st style="color: #219412ff">&#10004;</st>`;
  } 
  
  return challengeSatisfied;

}

/* ============================================================
   DETECTION LOOP
============================================================ */
function startDetectionLoop() {
  if(tempStop==0){
    pickChallenge('',null);

    const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 160 });

    const loop = async () => {
      const results = await faceapi
        .detectAllFaces(video, options)
        .withFaceLandmarks()
        .withFaceDescriptors();

      ctx.clearRect(0, 0, canvas.width, canvas.height);

      if (results.length === 0) {
        log.textContent = "Make sure that your face is fit inside the circle closely";
        return requestAnimationFrame(loop);
      }

      const det = results[0];
      const landmarks = det.landmarks;
      const live = evaluateChallenge(landmarks, det); 
      drawFace(landmarks);
      if(document.getElementById('divChallenge').style.display=="none"){
        document.getElementById('divChallenge').style.display="block";
      }
  
      if (live) pickChallenge(det,faceMatcher); // next challenge 
      requestAnimationFrame(loop); 
    };

    loop();
  }
}

//DRAWING FUNCTION
function drawFace(landmarks) {
  ctx.strokeStyle = "#00FFFF";
  ctx.lineWidth = 1.2;

  const groups = [
    landmarks.getJawOutline(),
    landmarks.getLeftEyeBrow(),
    landmarks.getRightEyeBrow(),
    landmarks.getLeftEye(),
    landmarks.getRightEye(),
    landmarks.getNose(),
    landmarks.getMouth()
  ];

  for (const pts of groups) {
    ctx.beginPath();
    ctx.moveTo(pts[0].x, pts[0].y);
    pts.forEach(p => ctx.lineTo(p.x, p.y));
    ctx.closePath();
    ctx.stroke();
  }
} 


function drawFaceGuide() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const centerX = canvas.width / 2;
  const centerY = canvas.height / 2;
  const radiusX = 190; // horizontal radius
  const radiusY = 220; // vertical radius

  // Draw blurred dark overlay outside ellipse
  ctx.fillStyle = 'rgba(255, 255, 255)';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  ctx.save();
  ctx.globalCompositeOperation = 'destination-out'; // remove ellipse area from overlay
  ctx.beginPath();
  ctx.ellipse(centerX, centerY, radiusX, radiusY, 0, 0, Math.PI * 2);
  ctx.fill();
  ctx.restore();

  // Draw ellipse border (face guide)
  ctx.strokeStyle = 'rgba(7, 95, 29, 0.9)';
  ctx.lineWidth = 3;
  ctx.beginPath();
  ctx.ellipse(centerX, centerY, radiusX, radiusY, 0, 0, Math.PI * 2);
  ctx.stroke();

  requestAnimationFrame(drawFaceGuide);
}

function closeCamera(){
  if(confirm('Are you sure, you want to stop scanning?')){
    const thisUrl = (window.location.href).replace('#',''); 
   window.location.href = thisUrl; 
    }
} 
 
 
drawFaceGuide(); 
loadModels();

</script>


</body>
</html>
