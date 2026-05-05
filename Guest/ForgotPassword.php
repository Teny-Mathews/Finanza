<?php
session_start();
include("../Assets/Connection/Connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Assets/phpMail/src/Exception.php';
require '../Assets/phpMail/src/PHPMailer.php';
require '../Assets/phpMail/src/SMTP.php';

function generateOTP($length = 6) {
    $digits = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $digits[rand(0, strlen($digits) - 1)];
    }
    return $otp;
}

function otpEmail($email,$otp){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'infofinanza123@gmail.com'; // Your gmail
    $mail->Password = 'bklz zfka plgn mtpf'; // Your gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
  
    $mail->setFrom('infofinanza123@gmail.com'); // Your gmail
  
    $mail->addAddress($email);
  
    $mail->isHTML(true);
    $message = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Your OTP Code
        </div>
        <p>Hello,</p>
        <p>Here is your One-Time Password (OTP) for verification:</p>
        <h2 style="font-size: 36px; color: #333;">' . $otp . '</h2>
        <p>This OTP is valid for the next 5 minutes. Please use it to complete your verification process.</p>
        <p>If you did not request this OTP, please ignore this email or contact support if you have concerns.</p>
        <p>Best regards,<br>Finanza</p>
        <div class="footer">
            This is an automated message. Please do not reply.
        </div>
    </div>
</body>
</html>
';
    $mail->Subject = "Reset your password";  //Your Subject goes here
    $mail->Body = $message; //Mail Body goes here
  if($mail->send())
  {
    ?>
<script>
    alert("Email Send")
    window.location="OTP_validator.php";
</script>
    <?php
  }
  else
  {
    ?>
<script>
    alert("Email Failed")
</script>
    <?php
  }
}

if(isset($_POST['btn_submit'])){
    $email=$_POST['txt_email'];
    $selUser="select * from tbl_user where user_email='".$email."'";	
	$resUser=$con->query($selUser);
   
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    if($userData=$resUser->fetch_assoc())
	{
		$_SESSION['ruid'] = $userData['user_id'];
		otpEmail($email,$otp);
	}
	
	else{
	?>
    	<script>
		alert("Account Doesn't Exists")
		</script>
    <?php	
	}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>

  <!-- Font Awesome for email icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #e0f2ff, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-wrapper {
      background: #ffffff;
      padding: 35px 30px;
      border-radius: 20px 5px 20px 5px;
      box-shadow: 0 8px 25px rgba(0, 91, 170, 0.15);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #005baa;
    }

    .form-group {
      position: relative;
      margin-bottom: 25px;
    }

    .form-group input[type="text"] {
      width: 85%;
      padding: 12px 40px 12px 12px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      transition: border 0.3s ease;
    }

    .form-group input[type="text"]:focus {
      outline: none;
      border-color: #007bff;
      background-color: #ffffff;
    }

    .form-group .fa-envelope {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      color: #888;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #007bff, #005baa);
      color: white;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
      letter-spacing: 0.5px;
    }

    .btn-submit:hover {
      background: linear-gradient(to right, #005baa, #004080);
    }
  </style>
</head>

<body>

  <form action="" method="post">
    <div class="form-wrapper">
      <h2>Reset Password</h2>

      <div class="form-group">
        <input type="text" name="txt_email" placeholder="Enter your email" required />
        <i class="fas fa-envelope"></i>
      </div>

      <input type="submit" name="btn_submit" value="Reset" class="btn-submit" />
    </div>
  </form>

</body>
</html>
