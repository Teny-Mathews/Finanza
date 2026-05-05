<?php
include("../Assets/Connection/Connection.php");

include("Head.php");


$selqry = "select * from tbl_complaint where complaint_id='" . $_GET['did'] . "'";
$row = $con->query($selqry);
$data = $row->fetch_assoc();


if (isset($_POST["btn_submit"])) {

  $reply = $_POST["txtarea_replycontent"];
  $upqry = "update tbl_complaint set complaint_reply='" . $reply . "' where complaint_id='" . $_GET['did'] . "'";

  if ($con->query($upqry)) {
    ?>
    <script>
      alert("Updated successfully");
      window.location = "ViewComplaint.php"
    </script>
    <?php
  }

}



?>







<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Complaint Reply</title>

  <style>
    /* Base & body */
    body {
      background-color: #f3f7ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #003366;
      padding: 40px 20px;
    }

    .container {
      max-width: 520px;
      margin: 0 auto;
      background: white;
      border-radius: 24px;
      box-shadow: 0 12px 36px rgb(0 75 165 / 0.18);
      padding: 30px 36px 40px;
    }

    /* Heading */
    h1 {
      background: linear-gradient(120deg, #004aad, #003377);
      color: white;
      font-weight: 800;
      font-size: 28px;
      text-align: center;
      padding: 16px 0;
      margin: 0 -36px 28px;
      border-radius: 24px 24px 0 0;
      box-shadow: 0 6px 18px rgba(0, 74, 173, 0.6);
      user-select: none;
      letter-spacing: 1.2px;
    }

    /* Subheading inside form */
    .subheading {
      font-weight: 700;
      font-size: 20px;
      margin-bottom: 22px;
      color: #004aad;
      border-left: 6px solid #0073ff;
      padding-left: 12px;
      user-select: none;
    }

    /* Table styles */
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 18px;
      font-size: 16px;
    }

    td {
      padding: 14px 18px;
      vertical-align: middle;
      font-weight: 600;
      color: #003366;
    }

    td:first-child {
      width: 110px;
      background: #e9f0ff;
      border-radius: 18px 0 0 18px;
      font-weight: 700;
      box-shadow: inset 4px 0 6px rgba(0, 75, 165, 0.12);
    }

    td:last-child {
      background: #f9fbff;
      border-radius: 0 18px 18px 0;
      font-weight: 500;
      color: #002d5c;
      box-shadow: inset -4px 0 6px rgba(0, 75, 165, 0.08);
    }

    /* Textarea styling */
    textarea {
      width: 100%;
      resize: vertical;
      min-height: 120px;
      padding: 12px 14px;
      font-size: 16px;
      font-weight: 500;
      color: #003366;
      border: 2px solid #a6c1ff;
      border-radius: 16px;
      box-shadow: inset 0 0 10px #dbe7ff;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    textarea:focus {
      outline: none;
      border-color: #004aad;
      box-shadow: 0 0 16px #6b8fffcc;
    }

    /* Submit button */
    input[type="submit"] {
      cursor: pointer;
      background: #0059e8;
      color: white;
      font-weight: 700;
      font-size: 17px;
      border: none;
      border-radius: 32px;
      padding: 14px 40px;
      box-shadow: 0 7px 18px #0044b0cc;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      margin: 24px auto 0;
      display: block;
      user-select: none;
    }

    input[type="submit"]:hover {
      background-color: #003f8a;
      box-shadow: 0 10px 30px #002c5dcc;
    }

    /* Responsive margin for smaller screens */
    @media (max-width: 600px) {
      body {
        padding: 20px 12px;
      }

      .container {
        padding: 24px 20px 28px;
        border-radius: 18px;
        box-shadow: 0 8px 28px rgba(0, 75, 165, 0.14);
      }

      td:first-child {
        width: 100px;
        font-size: 15px;
      }

      textarea {
        font-size: 15px;
      }
    }
  </style>

</head>

<body>
  <div class="container">
    <h1>Reply to Complaint</h1>
    <form id="form1" name="form1" method="post" action="">
      <div class="subheading">Complaint Details</div>
      <table>
        <tr>
          <td>Title</td>
          <td><?php echo $data['complaint_title'] ?></td>
        </tr>
        <tr>
          <td>Content</td>
          <td><?php echo $data['complaint_content'] ?></td>
        </tr>
        <tr>
          <td>Reply Content</td>
          <td>
            <textarea required name="txtarea_replycontent" id="txtarea_replycontent" cols="45" rows="5"></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>

</html>

<?php
include("Foot.php");
?>