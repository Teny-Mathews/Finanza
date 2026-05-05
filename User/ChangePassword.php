<?php
session_start();

include("../Assets/Connection/Connection.php");
include("Head.php");
 if(isset($_POST["btn_save"]))
   {
	   $oldpswd=$_POST['txt_oldpassword'];
	   $newpswd=$_POST['txt_newpassword'];
	   $cnfmpswd=$_POST['txt_confirmpassword'];
	     
		 $selqry="select * from tbl_user where user_id='".$_SESSION['uid']."'";
         $row=$con->query($selqry);
         $data=$row->fetch_assoc();
           $password=$data['user_password'];
		     
			 if($password==$oldpswd)
			   {
				   if($newpswd==$cnfmpswd) 
				    {
						$updatepassword="update tbl_user set user_password='".$newpswd."'where user_id='".$_SESSION['uid']."'";
						 if($con->query($updatepassword))
	                  {
		                ?>
							<script>
                            alert("Updated successfully");
                            window.location="MyProfile.php"
                            </script>
                            <?php
                       }
                          else
					    {
                          ?>
                          <script>
                          alert("Error");
                            window.location="ChangePassword.php"
                            </script>
                    
                        <?php
                          }
                       }
					   else
					   {
						   ?>
                           <script>
                          alert("Not Same Password");
                            window.location="ChangePassword.php"
                            </script>
	                        <?php
					   }
			   }

						   else
								   {
									   ?>
									   <script>
									  alert("Not Same Password");
										window.location="ChangePassword.php"
										</script>
										<?php
								   }

   }
   
?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Password</title>

<!-- Font Awesome CDN for Eye Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body {
    background-color: #f0f6ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
   
  }

  .form-container {
    background-color: white;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 51, 102, 0.1);
    width: 100%;
    max-width: 500px;
  }

  h2 {
    text-align: center;
    color: #003366;
    margin-bottom: 30px;
  }

  .form-group {
    margin-bottom: 20px;
    position: relative;
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    color: #003366;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 10px 40px 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
  }

  .toggle-password {
    position: absolute;
    right: 12px;
    top: 36px;
    cursor: pointer;
    color: #888;
  }

  .form-actions {
    text-align: center;
    margin-top: 30px;
  }

  .btn-blue {
    background-color: #005baa;
    color: white;
    border: none;
    padding: 10px 24px;
    font-size: 15px;
    border-radius: 25px;
    cursor: pointer;
    margin-right: 12px;
    text-decoration: none;
    display: inline-block;
  }

  .btn-blue:hover {
    background-color: #004080;
    color: white;
    text-decoration: none;
  }
</style>

</head>
<body>

<div class="form-container">
  <h2>Change Password</h2>

  <form id="form1" name="form1" method="post" action="">
    
    <div class="form-group">
      <label for="txt_oldpassword">Old Password</label>
      <input required type="password" name="txt_oldpassword" id="txt_oldpassword" />
      <i class="fas fa-eye toggle-password" onclick="togglePassword('txt_oldpassword', this)"></i>
    </div>

    <div class="form-group">
      <label for="txt_newpassword">New Password</label>
      <input required type="password" name="txt_newpassword" id="txt_newpassword" />
      <i class="fas fa-eye toggle-password" onclick="togglePassword('txt_newpassword', this)"></i>
    </div>

    <div class="form-group">
      <label for="txt_confirmpassword">Confirm Password</label>
      <input required type="password" name="txt_confirmpassword" id="txt_confirmpassword" />
      <i class="fas fa-eye toggle-password" onclick="togglePassword('txt_confirmpassword', this)"></i>
    </div>

    <div class="form-actions">
      <input type="submit" name="btn_save" id="btn_save" value="Save" class="btn-blue" />
      <a href="MyProfile.php" class="btn-blue">Back</a>
    </div>

  </form>
</div>

<!-- JavaScript to Toggle Password Visibility -->
<script>
  function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute("type") === "password" ? "text" : "password";
    field.setAttribute("type", type);
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
  }
</script>

</body>
</html>

<?php
  include("Foot.php");
  ?>