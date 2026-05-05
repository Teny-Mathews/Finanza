<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

// Initialize variables
$expense_id = "";
$expense_title = "";
$expense_content = "";
$expense_price = "";
$expense_date = "";
$expense_mode = "";
$expense_file = "";
$expensetypeid = 0;

// ✅ Insert / Update
if (isset($_POST["btn_submit"])) {
    $title   = $_POST["txt_title"];
    $content = $_POST["txtarea_content"];
    $price   = $_POST["txt_price"];
    $etype   = $_POST["sel_expensetype"];
    $mode    = $_POST["txt_radio"];
    $date    = $_POST["txt_date"];
    $hid     = $_POST["txt_id"];

    // File upload
    $photo = "";
    if (!empty($_FILES["txt_file"]["name"])) {
        $photo = time() . "_" . $_FILES["txt_file"]["name"]; // unique filename
        $tempPhoto = $_FILES["txt_file"]["tmp_name"];
        move_uploaded_file($tempPhoto, "../Assets/Files/Expense/" . $photo);
    }

    if ($hid == "") {
        // Insert
        $insQry = "INSERT INTO tbl_expense (expense_title, expense_content, expense_price, expense_date, expensetype_id, user_id, expense_mode, expense_file) 
                   VALUES ('$title','$content','$price','$date','$etype','".$_SESSION['uid']."','$mode','$photo')";
        if ($con->query($insQry)) {
            echo "<script>alert('Inserted Successfully'); window.location='Expense.php';</script>";
        }
    } else {
        // Update
        $upqry = "UPDATE tbl_expense SET 
                     expense_title='$title',
                     expense_content='$content',
                     expense_price='$price',
                     expense_date='$date',
                     expensetype_id='$etype',
                     expense_mode='$mode' ";
        if ($photo != "") {
            $upqry .= ", expense_file='$photo' ";
        }
        $upqry .= "WHERE expense_id='$hid'";

        if ($con->query($upqry)) {
            echo "<script>alert('Updated Successfully'); window.location='Expense.php';</script>";
        }
    }
}

// ✅ Delete
if (isset($_GET["did"])) {
    $delqry = "DELETE FROM tbl_expense WHERE expense_id=" . $_GET["did"];
    if ($con->query($delqry)) {
        echo "<script>alert('Deleted Successfully'); window.location='Expense.php';</script>";
    }
}

// ✅ Edit
if (isset($_GET["eid"])) {
    $selqryt = "SELECT * FROM tbl_expense WHERE expense_id ='" . $_GET['eid'] . "'";
    $rowt = $con->query($selqryt);
    $datat = $rowt->fetch_assoc();

    $expense_id      = $datat['expense_id'];
    $expense_title   = $datat['expense_title'];
    $expense_content = $datat['expense_content'];
    $expense_price   = $datat['expense_price'];
    $expense_date    = $datat['expense_date'];
    $expense_mode    = $datat['expense_mode'];
    $expense_file    = $datat['expense_file'];
    $expensetypeid   = $datat['expensetype_id'];
}
?> 


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Expense Manager</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
  body {
    background: linear-gradient(135deg, #e6f3ff, #ffffff);
    font-family: 'Segoe UI', sans-serif;
  }

  h2 {
    text-align: center;
    color: #004c99;
    margin-bottom: 25px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: #fdfdff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.07);
    margin-bottom: 40px;
  }

  table th {
    background-color: #007acc;
    color: #ffffff;
    padding: 12px;
    text-align: center;
    font-size: 14px;
  }

  table td {
    padding: 12px;
    text-align: center;
    font-size: 14px;
    border: 1px solid #d0e6ff;
  }

  input[type="text"],
  input[type="file"],
  textarea,
  select,
  input[type="date"] {
    width: 90%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 12px;
    border: 1px solid #aacdf1;
    background-color: #f5fbff;
  }

  input[type="submit"] {
    background-color: #007acc;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #005f99;
  }

  .action-icons a {
    margin: 0 6px;
    text-decoration: none;
    font-size: 18px;
  }

  .action-icons .delete-icon {
    color: #e63946;
  }

  .action-icons .edit-icon {
    color: #1d3557;
  }

  .form-section {
    margin-bottom: 40px;
    padding: 20px;
    background: #ffffffcc;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0, 128, 255, 0.08);
  }

  label {
    font-weight: bold;
    color: #003366;
  }
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
  <div class="main-wrapper">
    
    <div class="form-section">
      <h2><?php echo $expense_id ? "Edit Expense" : "Add Expense"; ?></h2>
      <table border="0">
        <tr>
          <td><label for="txt_title">Title</label></td>
          <td>
            <input type="hidden" name="txt_id" value="<?php echo $expense_id ?>"/>
            <input required type="text" name="txt_title" value="<?php echo $expense_title ?>" />
          </td>
        </tr>
        <tr>
          <td><label for="txtarea_content">Content</label></td>
          <td>
            <textarea required name="txtarea_content" cols="45" rows="5"><?php echo $expense_content ?></textarea>
          </td>
        </tr>
        <tr>
          <td><label for="txt_price">Price</label></td>
          <td>
            <input required type="text" name="txt_price" value="<?php echo $expense_price ?>" />
          </td>
        </tr>
        <tr>
          <td><label for="">Date</label></td>
          <td>
            <input type="date" name="txt_date" max="<?php echo date('Y-m-d')?>" 
                   value="<?php echo $expense_date ?>">
          </td>
        </tr>
        <tr>
          <td><label for="sel_expensetype">Expense Type</label></td>
          <td>
            <select name="sel_expensetype" required>
              <option value="">Select</option>
              <?php
              $selqry = "SELECT * FROM tbl_expensetype";
              $resopt = $con->query($selqry);
              while ($dataopt = $resopt->fetch_assoc()) {
                $selected = ($dataopt["expensetype_id"] == $expensetypeid) ? "selected" : "";
                echo "<option value='".$dataopt["expensetype_id"]."' $selected>".$dataopt["expensetype_name"]."</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Mode Of Payment</label></td>
          <td>
            <input type="radio" name="txt_radio" value="Cash" <?php if($expense_mode=="Cash") echo "checked"; ?> />Cash
            <input type="radio" name="txt_radio" value="UPI" <?php if($expense_mode=="UPI") echo "checked"; ?> />UPI
            <input type="radio" name="txt_radio" value="Card" <?php if($expense_mode=="Card") echo "checked"; ?> />Card
          </td>
        </tr>
        <tr>
          <td><label for="txt_file">Receipt Upload</label></td>
          <td>
            <input type="file" name="txt_file" />
            <?php if($expense_file) { ?>
              <br/><img src="../Assets/Files/Expense/<?php echo $expense_file ?>" width="120px">
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="btn_submit" value="Submit" />
          </td>
        </tr>
      </table>
    </div>

    <!-- Expense List -->
    <h2>Your Expense Records</h2>
    <table>
      <thead>
        <tr>
          <th>Slno</th>
          <th>Title</th>
          <th>Content</th>
          <th>Price</th>
          <th>Date</th>
          <th>Expense Type</th>
          <th>Mode</th>
          <th>Receipt</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $selqry="SELECT * FROM tbl_expense e 
                 INNER JOIN tbl_expensetype t ON e.expensetype_id = t.expensetype_id 
                 WHERE user_id='".$_SESSION['uid']."'";
        $result = $con->query($selqry);
        $i=0;
        while($data=$result->fetch_assoc()) {
          $i++;
        ?>
        <tr>
          <td><?php echo $i ?></td>
          <td><?php echo $data["expense_title"] ?></td>
          <td><?php echo $data["expense_content"] ?></td>
          <td><?php echo $data["expense_price"] ?></td>
          <td><?php echo $data["expense_date"] ?></td>
          <td><?php echo $data["expensetype_name"] ?></td>
          <td><?php echo $data["expense_mode"] ?></td>
          <td>
            <?php if($data["expense_file"]) { ?>
              <img src="../Assets/Files/Expense/<?php echo $data["expense_file"] ?>" width="120px">
            <?php } ?>
          </td>
          <td class="action-icons">
            <a href="Expense.php?eid=<?php echo $data["expense_id"] ?>" title="Edit"><i class="fas fa-pen edit-icon"></i></a>
            <a href="Expense.php?did=<?php echo $data["expense_id"] ?>" onclick="return confirm('Delete this expense?');" title="Delete"><i class="fas fa-trash-alt delete-icon"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</form>
</body>
</html>


<?php include("Foot.php"); ?>
