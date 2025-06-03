<?php
session_start();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EVIL - Login / Signup</title>
  <style>
 * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #1a1a1a;
      font-family: 'Inter', sans-serif;
    }
    .login-box {
      width: 1000px;
      min-height: 500px;
      max-height: auto;
      display: flex;
      border-radius: 16px;
      overflow: hidden;
      background-color: oklch(70.9% 0.01 56.259);
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      position: relative;
    }
    .back-btn {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #fff;
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 14px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
      z-index: 10;
    }
    form {
      display: none;
      flex-direction: column;
      gap: 12px;
    }
    .form-group label {
      font-weight: bold;
    }
    label {
      margin-top: 4px;
    }
    input, select {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .btn {
      margin-bottom: 12px;
      margin-top: 12px;
      padding: 12px;
      background: oklch(44.4% 0.011 73.639);
      color: #fff; border: none; border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    .toggle-form {
      text-align: center;
      font-size: 14px;
    }
    .toggle-form a {
      color: oklch(44.4% 0.011 73.639);
      cursor: pointer;
      text-decoration: underline;
    }
    .login-form {
      flex: 1;
      padding: 24px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #fff;
      color: #000;
    }
    .card {
      min-height: 500px;
      max-height: auto;
      flex: 1;
      position: relative;
      
    }
    .card img {
      position: absolute;
      width: 100%; height: 100%;
      object-fit: cover;
    }
     @keyframes slideOut {
      from { transform: translateY(0) rotateX(0); opacity: 1; }
      to   { transform: translateY(-100%) rotateX(-30deg); opacity: 0; }
    }
    @keyframes slideIn {
      from { transform: translateY(100%) rotateX(30deg); opacity: 0; }
      to   { transform: translateY(0) rotateX(0); opacity: 1; }
    }
    .card img {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      transform-style: preserve-3d;
    }
    .card img.slide-out {
      animation: slideOut 0.8s ease-in-out forwards;
    }
    .card img.slide-in {
      animation: slideIn 0.8s ease-in-out forwards;
    }
    ::-webkit-scrollbar { width: 0; }
    .formTitle{


      margin-left: 40%;
      margin-bottom: 15px;
      margin-top: 5px;
    }  </style>
</head>
<body>
  <div class="login-box">
    <a href="new22.php" class="back-btn">← Back</a>

    <div class="login-form">
      <h2 class="formTitle" id="formTitle">Login</h2>

      <!-- LOGIN FORM -->
      <form id="loginForm" action="auth_handler.php" method="POST">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <label>Email</label>
        <input type="email" name="login_email" required>
        <label>Password</label>
        <input type="password" name="login_password" required>
        <button class="btn" type="submit">Login</button>
      </form>

      <!-- SIGN UP FORM -->
      <form id="signupForm" action="auth_handler.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <label>First Name</label>
        <input type="text" name="first_name" required>
        <label>Last Name</label>
        <input type="text" name="last_name" required>
        <label>Gender</label>
        <select name="gender" required>
          <option value="">Select Gender</option>
          <option>Female</option>
          <option>Male</option>
          <option>Other</option>
        </select>
        <label>Age</label>
        <input type="number" name="age" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Profile Picture</label>
        <input type="file" name="profile_picture" required>
        <button class="btn" type="submit">Create Account</button>
      </form>

      <div class="toggle-form">
        <span id="toggleText">Don't have an account? <a onclick="switchForm()">Sign up</a></span>
      </div>
    </div>

    <div class="card">
      <img id="cardSlideshow" src="1.jpeg" alt="Slideshow">
    </div>
  </div>

  <script>
    function setupSlideshow(imgId) {
      let current = 1, total = 16;
      const el = document.getElementById(imgId);
      setInterval(() => {
        el.classList.remove('slide-in');
        el.classList.add('slide-out');
        setTimeout(() => {
          current = current < total ? current + 1 : 1;
          el.src = `${current}.jpeg`;
          el.classList.remove('slide-out');
          el.classList.add('slide-in');
        }, 1000);
      }, 4000);
    }

    setupSlideshow('cardSlideshow');

    const loginForm = document.getElementById("loginForm");
    const signupForm = document.getElementById("signupForm");
    const toggleText = document.getElementById("toggleText");
    const formTitle = document.getElementById("formTitle");

    function switchForm() {
      const isLogin = loginForm.style.display !== "none";
      loginForm.style.display = isLogin ? "none" : "flex";
      signupForm.style.display = isLogin ? "flex" : "none";
      formTitle.innerText = isLogin ? "Sign Up" : "Login";
      toggleText.innerHTML = isLogin
        ? 'Already have an account? <a onclick="switchForm()">Login</a>'
        : 'Don\'t have an account? <a onclick="switchForm()">Sign up</a>';
    }

    loginForm.style.display = "flex";
  </script>
</body>
</html>
