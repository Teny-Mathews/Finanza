<?php
session_start();
include("../Assets/Connection/Connection.php");


if(isset($_POST['btn_submit'])){
    $pass=$_POST['txt_pass'];
    $cpass=$_POST['txt_cpass'];
    if($pass==$cpass){
        if(isset($_SESSION['ruid'])){ //User
            $updQry="update tbl_user set user_password='".$pass."' where user_id=".$_SESSION['ruid'];
            if($con->query($updQry)){
                ?>
                <script>
                    alert("Password Updated")
                    window.location="LogOut.php"
                    </script>
                <?php
            }
     
        }
        else{
            ?>
            <script>
                alert('Something went wrong')
                    window.location="LogOut.php"
                </script>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Change Password</title>

  <!-- Font Awesome for show/hide icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #d9ecff, #f0f8ff);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    

    .form-container {
      position: relative;
      background-color: #ffffff;
      padding: 35px 40px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 91, 170, 0.15);
      width: 100%;
      max-width: 430px;
      z-index: 2;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #005baa;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
      color: #003366;
    }

    input[type="password"] {
      width: 90%;
      padding: 12px 40px 12px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f9f9f9;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 38px;
      cursor: pointer;
      color: #888;
    }

    .form-actions {
      text-align: center;
      margin-top: 20px;
    }

    .btn-rounded {
      background: linear-gradient(to right, #007bff, #005baa);
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 15px;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s ease;
      width: 100%;
    }

    .btn-rounded:hover {
      background: linear-gradient(to right, #005baa, #003f7d);
    }
  </style>
</head>

<body>

  <div class="curvy-bg"></div>

  <div class="form-container">
    <h2>Change Password</h2>

    <form action="" method="post">
      <div class="form-group">
        <label for="txt_pass">New Password</label>
        <input type="password" name="txt_pass" id="txt_pass" required>
        <i class="fas fa-eye toggle-password" onclick="togglePassword('txt_pass', this)"></i>
      </div>

      <div class="form-group">
        <label for="txt_cpass">Confirm Password</label>
        <input type="password" name="txt_cpass" id="txt_cpass" required>
        <i class="fas fa-eye toggle-password" onclick="togglePassword('txt_cpass', this)"></i>
      </div>

      <div class="form-actions">
        <input type="submit" name="btn_submit" value="Change Password" class="btn-rounded" />
      </div>
    </form>
  </div>

  <!-- Toggle password visibility -->
  <script>
    function togglePassword(fieldId, icon) {
      const field = document.getElementById(fieldId);
      const type = field.type === 'password' ? 'text' : 'password';
      field.type = type;
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    }
  </script>

</body>
</html>
