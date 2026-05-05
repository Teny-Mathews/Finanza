<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST["btn_login"]))
{
	$email = $_POST["txt_email"];
    $password=$_POST["txt_password"];
	$selAdmin="select * from tbl_admin where admin_email='".$email."' and admin_password='".$password."' ";
	$resultAdmin=$con->query($selAdmin);
	if($rowAdmin=$resultAdmin->fetch_assoc())
	{
		$_SESSION["aid"]=$rowAdmin["admin_id"];
		$_SESSION["admin_name"]=$rowAdmin['admin_name'];
		header("Location:../Admin/HomePage.php");
	}
	
	$selUser="select * from tbl_user where user_email='".$email."' and user_password='".$password."' ";
	$resultUser=$con->query($selUser);
	if($rowUser=$resultUser->fetch_assoc())
	{
		$_SESSION["uid"]=$rowUser["user_id"];
		$_SESSION["username"]=$rowUser["user_name"];
		header("Location:../User/HomePage.php");
	}
	
	
	
	}
    ?>
	
	





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Finanza Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Raleway', sans-serif;
    }

    body {
      background: radial-gradient(ellipse at top left, #3b6cf9 0%, #e6f0ff 100%);
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Animated Glow Circles */
    body::before, body::after {
      content: "";
      position: absolute;
      width: 600px;
      height: 600px;
      border-radius: 50%;
      background: rgba(59, 108, 249, 0.2);
      filter: blur(120px);
      z-index: 0;
      animation: floatGlow 10s ease-in-out infinite;
    }

    body::before {
      top: -200px;
      left: -200px;
    }

    body::after {
      bottom: -200px;
      right: -200px;
      animation-delay: 5s;
    }

    @keyframes floatGlow {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(40px);
      }
    }

    .container {
      display: flex;
      width: 900px;
      border-radius: 20px;
      overflow: hidden;
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 2;
    }

    /* Left Panel */
    .new-user {
      width: 40%;
      background: linear-gradient(135deg, #3b6cf9, #5f87ff);
      color: white;
      padding: 50px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .new-user h2 {
      font-size: 30px;
      font-weight: 800;
      margin-bottom: 20px;
    }

    .new-user p {
      font-size: 16px;
      margin-bottom: 30px;
      line-height: 1.5;
    }

    .new-user a {
      padding: 12px 30px;
      background: white;
      color: #3b6cf9;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s ease;
    }

    .new-user a:hover {
      background: #dce6ff;
      color: #234adc;
    }

    /* Login Panel */
    .screen {
      width: 60%;
      padding: 50px;
      background: rgba(255, 255, 255, 0.8);
    }

    .login {
      max-width: 360px;
      margin: auto;
    }

    .login h2 {
      font-size: 28px;
      color: #3b6cf9;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 800;
    }

    .login__field {
      position: relative;
      margin-bottom: 20px;
    }

    .login__icon {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #888;
      font-size: 16px;
    }

    .login__input {
      width: 100%;
      padding: 12px 12px 12px 38px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: #f1f3ff;
      font-weight: 600;
      transition: border-color 0.3s, background 0.3s;
    }

    .login__input:focus {
      border-color: #3b6cf9;
      background: white;
      outline: none;
    }

    .login__submit {
      width: 100%;
      background: #3b6cf9;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      text-transform: uppercase;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .login__submit:hover {
      background: #2a51c3;
      transform: scale(1.02);
    }

    .login__links {
      margin-top: 20px;
      text-align: center;
    }

    .login__links a {
      color: #3b6cf9;
      text-decoration: none;
      font-size: 14px;
    }

    .login__links a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        width: 90%;
      }

      .new-user, .screen {
        width: 100%;
      }

      .new-user {
        padding: 30px;
      }

      .screen {
        padding: 30px;
      }

      body::before, body::after {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Panel -->
    <div class="new-user">
      <h2>New Here?</h2>
      <p>Sign up and start managing your finances better with Finanza.</p>
      <a href="UserRegistration.php">Register Now</a>
    </div>

    <!-- Login Panel -->
    <div class="screen">
      <form class="login" method="post">
        <h2>Log In</h2>
        <div class="login__field">
          <i class="login__icon fas fa-user"></i>
          <input required type="text" name="txt_email" id="txt_email" class="login__input" placeholder="Email or Username">
        </div>
        <div class="login__field">
          <i class="login__icon fas fa-lock"></i>
          <input required type="password" name="txt_password" id="txt_password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters"
            class="login__input" placeholder="Password">
        </div>
        <button class="login__submit" type="submit" name="btn_login">Log In</button>
        <div class="login__links">
          <a href="ForgotPassword.php">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>


