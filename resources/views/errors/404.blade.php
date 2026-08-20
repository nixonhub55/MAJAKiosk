 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pay Factor Pages Not Found</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to top, #87ceeb, #ffffff);
      overflow: hidden;
      height: 100vh;
    }

    .cloud {
      position: absolute;
      font-size: 6em; /* Bigger clouds */
      animation: floatLeft linear infinite;
      opacity: 0.85;
      white-space: nowrap;
    }

    .cloud1 { top: 10%; animation-duration: 5s; left: 100vw; }
    .cloud2 { top: 20%; animation-duration: 6s; left: 110vw; }
    .cloud3 { top: 30%; animation-duration: 4s; left: 105vw; }
    .cloud4 { top: 40%; animation-duration: 5s; left: 120vw; }
    .cloud5 { top: 50%; animation-duration: 6s; left: 115vw; }
    .cloud6 { top: 60%; animation-duration: 7s; left: 125vw; }
    .cloud7 { top: 70%; animation-duration: 8s; left: 130vw; }
    .cloud8 { top: 80%; animation-duration: 9s; left: 135vw; }
    .cloud9 { top: 90%; animation-duration: 5s; left: 140vw; }
    .cloud10 { top: 50%; animation-duration: 6s; left: 145vw; }

    @keyframes floatLeft {
      from {
        transform: translateX(0);
      }
      to {
        transform: translateX(-250vw);
      }
    }

    /* 404 Message Styling */
    .message {
      position: relative;
      text-align: center;
      color: #333;
      font-family: Arial, sans-serif;
    }

    .message h1 {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .message p {
      font-size: 20px;
      margin-bottom: 20px;
    }

    .message a {
      color: #007BFF;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
    }

    .message a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>


  <div class="message">
    <h5>Pay Factor</h5>
    <h1>404 - Page Not Found</h1>
    <p>Sorry, the page you're looking for doesn't exist.</p>
     <a href="{{ url('/') }}">Go back to login</a>
  </div>


  <div class="cloud cloud1">☁️</div>
  <div class="cloud cloud2">☁️</div>
  <div class="cloud cloud3">☁️</div>
  <div class="cloud cloud4">☁️</div>
  <div class="cloud cloud5">☁️</div>
  <div class="cloud cloud6">☁️</div>
  <div class="cloud cloud7">☁️</div>
  <div class="cloud cloud8">☁️</div>
  <div class="cloud cloud9">☁️</div>
  <div class="cloud cloud10">☁️</div>

</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>2D Floating Clouds</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to top, #87ceeb, #ffffff);
      overflow: hidden;
      height: 100vh;
    }

    .cloud {
      position: absolute;
      background-color: #fff;
      border-radius: 50%;
      opacity: 0.85;
      animation: floatLeft linear infinite;
    }

    /* Create individual cloud shapes */
    .cloud1 { width: 150px; height: 80px; top: 10%; left: 100vw; animation-duration: 5s; }
    .cloud2 { width: 180px; height: 90px; top: 20%; left: 110vw; animation-duration: 6s; }
    .cloud3 { width: 130px; height: 70px; top: 30%; left: 105vw; animation-duration: 4s; }
    .cloud4 { width: 160px; height: 85px; top: 40%; left: 120vw; animation-duration: 5s; }
    .cloud5 { width: 140px; height: 75px; top: 50%; left: 115vw; animation-duration: 6s; }
    .cloud6 { width: 170px; height: 95px; top: 60%; left: 125vw; animation-duration: 7s; }
    .cloud7 { width: 150px; height: 80px; top: 70%; left: 130vw; animation-duration: 8s; }
    .cloud8 { width: 180px; height: 90px; top: 80%; left: 135vw; animation-duration: 9s; }
    .cloud9 { width: 160px; height: 85px; top: 90%; left: 140vw; animation-duration: 5s; }
    .cloud10 { width: 150px; height: 80px; top: 50%; left: 145vw; animation-duration: 6s; }

    /* Create a cloud effect by adding smaller circles to the cloud */
    .cloud:before, .cloud:after {
      content: '';
      position: absolute;
      background-color: #fff;
      border-radius: 50%;
    }

    /* Add small circles on the left and right for cloud shape */
    .cloud1:before { width: 50px; height: 50px; top: -20px; left: 10px; }
    .cloud1:after { width: 70px; height: 70px; top: -40px; left: 80px; }

    .cloud2:before { width: 60px; height: 60px; top: -30px; left: 20px; }
    .cloud2:after { width: 80px; height: 80px; top: -50px; left: 100px; }

    .cloud3:before { width: 40px; height: 40px; top: -20px; left: 10px; }
    .cloud3:after { width: 60px; height: 60px; top: -40px; left: 70px; }

    .cloud4:before { width: 50px; height: 50px; top: -20px; left: 15px; }
    .cloud4:after { width: 70px; height: 70px; top: -30px; left: 85px; }

    .cloud5:before { width: 50px; height: 50px; top: -20px; left: 15px; }
    .cloud5:after { width: 70px; height: 70px; top: -30px; left: 85px; }

    .cloud6:before { width: 60px; height: 60px; top: -30px; left: 20px; }
    .cloud6:after { width: 80px; height: 80px; top: -50px; left: 100px; }

    .cloud7:before { width: 50px; height: 50px; top: -20px; left: 10px; }
    .cloud7:after { width: 70px; height: 70px; top: -40px; left: 80px; }

    .cloud8:before { width: 60px; height: 60px; top: -30px; left: 20px; }
    .cloud8:after { width: 80px; height: 80px; top: -50px; left: 100px; }

    .cloud9:before { width: 50px; height: 50px; top: -20px; left: 15px; }
    .cloud9:after { width: 70px; height: 70px; top: -30px; left: 85px; }

    .cloud10:before { width: 50px; height: 50px; top: -20px; left: 15px; }
    .cloud10:after { width: 70px; height: 70px; top: -30px; left: 85px; }

    /* Keyframe for the movement */
    @keyframes floatLeft {
      from {
        transform: translateX(0);
      }
      to {
        transform: translateX(-250vw);
      }
    }
  </style>
</head>
<body>

  <div class="cloud cloud1"></div>
  <div class="cloud cloud2"></div>
  <div class="cloud cloud3"></div>
  <div class="cloud cloud4"></div>
  <div class="cloud cloud5"></div>
  <div class="cloud cloud6"></div>
  <div class="cloud cloud7"></div>
  <div class="cloud cloud8"></div>
  <div class="cloud cloud9"></div>
  <div class="cloud cloud10"></div>

</body>
</html>
 -->
