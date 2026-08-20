<!DOCTYPE html>
<html>
<head>
  <title>Canvas CAPTCHA</title>
  <style>
    canvas {
      border: 1px solid #ccc;
      display: block;
      margin-bottom: 10px;
    }
    input, button {
      margin: 5px 0;
    }
    #result {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <h2>Image-based CAPTCHA</h2>

  <canvas id="captchaCanvas" width="200" height="50"></canvas>

  <input type="text" id="captchaInput" placeholder="Type the code above" maxlength="6">
  <br>
  <button onclick="checkCaptcha()">Submit</button>
  <button onclick="generateCaptcha()">Reload</button>

  <p id="result"></p>

  <script>
    let captchaCode = "";

    function generateCaptcha() {
      const canvas = document.getElementById("captchaCanvas");
      const ctx = canvas.getContext("2d");

      // Clear canvas
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Fill background
      ctx.fillStyle = "#f0f0f0";
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Generate random CAPTCHA
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      captchaCode = "";
      for (let i = 0; i < 6; i++) {
        captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
      }

      // Draw characters
      for (let i = 0; i < captchaCode.length; i++) {
        const x = 20 + i * 25;
        const y = 35 + Math.random() * 5;

        ctx.font = "24px Arial";
        ctx.fillStyle = getRandomColor();
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate((Math.random() - 0.5) * 0.4);
        ctx.fillText(captchaCode[i], 0, 0);
        ctx.restore();
      }

      // Add noise lines
      for (let i = 0; i < 5; i++) {
        ctx.strokeStyle = getRandomColor();
        ctx.beginPath();
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.stroke();
      }

      // Reset input and result
      document.getElementById("captchaInput").value = "";
      document.getElementById("result").textContent = "";
    }

    function checkCaptcha() {
      const userInput = document.getElementById("captchaInput").value;
      if (userInput === captchaCode) {
        document.getElementById("result").textContent = "✅ Correct!";
        document.getElementById("result").style.color = "green";
      } else {
        document.getElementById("result").textContent = "❌ Incorrect. Try again.";
        document.getElementById("result").style.color = "red";
        generateCaptcha(); // 🔁 Regenerate if incorrect
      }
    }

    function getRandomColor() {
      const r = Math.floor(Math.random() * 150);
      const g = Math.floor(Math.random() * 150);
      const b = Math.floor(Math.random() * 150);
      return `rgb(${r},${g},${b})`;
    }

    window.onload = generateCaptcha;
  </script>

</body>
</html>
