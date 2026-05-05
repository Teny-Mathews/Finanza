<?php
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit'])){
    if($_SESSION['otp']==$_POST['txt_otp']){
        
       ?>
       <script>
        alert('OTP Validated')
        window.location="ResetPassword.php"
        </script>
       <?php
    }
    else{
        ?>
        <script>
            alert('OTP Incorrect')
            </script>
        <?php
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validate OTP</title>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0f0ff, #ffffff);
      margin: 0;
      padding: 50px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #003366;
    }

    .container {
      background: #ffffff;
      padding: 35px 30px;
      max-width: 420px;
      width: 100%;
      border-radius: 18px 5px 18px 5px; /* Unique asymmetric corners */
      box-shadow: 0 8px 25px rgba(0, 91, 170, 0.15);
      transition: all 0.3s ease;
    }

    .container:hover {
      box-shadow: 0 10px 35px rgba(0, 91, 170, 0.2);
    }

    h1 {
      font-size: 26px;
      text-align: center;
      margin-bottom: 25px;
      color: #005baa;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
    }

    input[type="text"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f9f9f9;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus {
      border-color: #007bff;
      outline: none;
      background-color: #fff;
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #007bff, #005baa);
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
      letter-spacing: 0.5px;
    }

    button:hover {
      background: linear-gradient(to right, #005baa, #004080);
    }

    .message {
      text-align: center;
      margin-top: 18px;
      font-size: 14px;
      color: #444;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1>Enter Your OTP</h1>

    <form method="POST" action="">
      <div class="form-group">
        <label for="otp">OTP Code:</label>
        <input type="text" id="otp" name="txt_otp" required />
      </div>

      <button type="submit" name="btn_submit">Validate OTP</button>
    </form>

    <div class="message" id="message">
      <!-- Optionally display PHP message here -->
      <?php 
        // Example: if (isset($msg)) echo $msg;
      ?>
    </div>
  </div>

</body>
</html>

