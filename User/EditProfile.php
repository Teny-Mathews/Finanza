<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$selqry = "SELECT * FROM tbl_user WHERE user_id='" . $_SESSION['uid'] . "'";
$row = $con->query($selqry);
$data = $row->fetch_assoc();

if (isset($_POST["btn_save"])) {
  $name = $_POST["txt_name"];
  $email = $_POST["txt_email"];
  $address = $_POST["txtarea_address"];
  $contact = $_POST["txt_contact"];
  $gender = $_POST["txt_gender"];
  $expenselimit = $_POST["txt_expenselimit"];


  $photo = $data['user_photo']; // current photo as default

  if ($_FILES["file_photo"]["name"] != "") {
    $fileName = $_FILES["file_photo"]["name"];
    $tempPath = $_FILES["file_photo"]["tmp_name"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newName = "user_" . $_SESSION['uid'] . "_" . time() . "." . $ext;
    $destination = "../Assets/Files/UserPhotos/" . $newName;

    // Move the uploaded file
    if (move_uploaded_file($tempPath, $destination)) {
      $photo = $newName;
    }
  }

  $upqry = "UPDATE tbl_user SET 
              user_name='$name', 
              user_email='$email', 
              user_address='$address', 
              user_contact='$contact',
              user_gender='$gender',
              user_photo='$photo',
              user_expenselimit='$expenselimit'
            WHERE user_id='" . $_SESSION['uid'] . "'";


  if ($con->query($upqry)) {
    echo "<script>alert('Profile updated successfully'); window.location='MyProfile.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <title>Edit Profile</title>
  <style>
    body {
      background-color: #f0f6ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px;
    }

    .form-container {
      background-color: #ffffff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 51, 102, 0.1);
      width: 100%;
      max-width: 550px;
      margin: auto;
    }

    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 25px;
    }

    .profile-img {
      display: block;
      margin: 0 auto 20px auto;
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #007bff55;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 15px;
    }

    td {
      vertical-align: top;
      padding: 5px;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    .form-actions {
      text-align: center;
      margin-top: 25px;
    }

    .btn-blue {
      background-color: #005baa;
      color: white;
      border: none;
      padding: 10px 24px;
      font-size: 15px;
      border-radius: 25px;
      cursor: pointer;
      margin-right: 10px;
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
  <h2>Edit Profile</h2>

  <!-- Profile Image -->
  <img src="../Assets/Files/UserPhotos/<?php echo $data['user_photo'] ?>" alt="User Photo" class="profile-img" />

  <!-- Form Start -->
  <form method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td><label for="txt_name">User Name</label></td>
        <td><input required type="text" name="txt_name" id="txt_name" value="<?php echo $data['user_name'] ?>" /></td>
      </tr>
      <tr>
        <td><label for="txt_gender">Gender</label></td>
        <td><input required type="text" name="txt_gender" id="txt_gender" value="<?php echo $data['user_gender'] ?>" /></td>
      </tr>
      <tr>
        <td><label for="txt_email">Email</label></td>
        <td><input required type="text" name="txt_email" id="txt_email" value="<?php echo $data['user_email'] ?>" /></td>
      </tr>
      <tr>
        <td><label for="txtarea_address">Address</label></td>
        <td><textarea required name="txtarea_address" id="txtarea_address" rows="4"><?php echo $data['user_address'] ?></textarea></td>
      </tr>
      <tr>
        <td><label for="txt_contact">Contact</label></td>
        <td><input required type="text" name="txt_contact" id="txt_contact" value="<?php echo $data['user_contact'] ?>" /></td>
      </tr>
      <tr>
  <td><label for="txt_expenselimit">Expense Limit (₹)</label></td>
  <td><input required type="number" name="txt_expenselimit" id="txt_expenselimit"
             value="<?php echo $data['user_expenselimit'] ?>" 
             min="0" step="0.01" /></td>
</tr>

      <tr>
        <td><label for="file_photo">Update Profile Photo</label></td>
        <td><input type="file" name="file_photo" id="file_photo" accept="image/*" /></td>
      </tr>
    </table>

    <div class="form-actions">
      <input type="submit" name="btn_save" id="btn_save" value="Save" class="btn-blue" />
      <a href="MyProfile.php" class="btn-blue">Back</a>
    </div>
  </form>
</div>

</body>
</html>

<?php include("Foot.php"); ?>
