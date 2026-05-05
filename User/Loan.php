
<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
$loan_title="";
$loan_id="";
$loan_details="";
if(isset($_POST["btn_submit"]))
{
	$title= $_POST["txt_title"];
	$content= $_POST["txtarea_details"];
	$duedate= $_POST["txt_duedate"];
	$hid=$_POST["txt_hid"];
     if($hid=="")
    {
	$insQry= "insert into tbl_loan (loan_title,loan_details,loan_date,loan_duedate,user_id) values('".$title."','".$content."',curdate(),'".$duedate."','".$_SESSION['uid']."')";
	if($con->query($insQry))
	   {	
			?>
			<script>
			alert("Inserted Successfully");
			window.location="Loan.php";
			</script>
			<?php
			}
}

else 
  { 
     $upqry="update tbl_loan set loan_title='".$title."',loan_details='".$content."',loan_duedate='".$duedate."' where loan_id='".$hid."'";
	if($con->query($upqry))
	{
		?>
        <script>
		alert("Updated Successfully");
		window.location="Loan.php"
		</script>
        <?php
	}
  }


}





 if(isset($_GET["did"]))
{
	$delqry="delete from tbl_loan where loan_id=".$_GET["did"];
	if($con->query($delqry))
		{
			?>
            	<script>
				alert("Deleted Successfully");
				window.location="Loan.php";
				</script>
                	<?php
		}
}
	if(isset($_GET["eid"]))
{
	 $selqryt="select * from tbl_loan where loan_id ='".$_GET['eid']."' ";
	$rowt=$con->query($selqryt);
	$datat=$rowt->fetch_assoc();
	$loan_title=$datat['loan_title'];
	$loan_id=$datat['loan_id'];
	$loan_details=$datat['loan_details'];
	$loan_duedate=$datat['loan_duedate'];
	
}

?>	



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loan Management</title>
  
  <!-- Font Awesome CDN for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f6ff;
      margin: 0;
      padding: 20px;
    }

    form {
      max-width: 900px;
      margin: auto;
      background-color: #ffffff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 51, 102, 0.1);
    }

    h2 {
      text-align: center;
      color: #003366;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #bcd;
    }

    th {
      background-color: #005baa;
      color: white;
      padding: 10px;
      text-align: left;
    }

    td {
      padding: 10px;
      background-color: #f9fcff;
    }

    input[type="text"], input[type="date"], textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    textarea {
      resize: vertical;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #003366;
    }

    .submit-btn {
      text-align: center;
      margin-top: 20px;
    }

    input[type="submit"] {
      background-color: #0077cc;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #005fa3;
    }

    .action-icons a {
      margin-right: 10px;
      text-decoration: none;
      color: #0077cc;
      font-size: 16px;
    }

    .action-icons a:hover {
      color: #003f7f;
    }

    .action-icons .fa-trash-alt {
      color: #cc0000;
    }

    .action-icons .fa-edit {
      color: #0077cc;
    }

    .action-icons a:hover .fa-trash-alt {
      color: #990000;
    }

    .action-icons a:hover .fa-edit {
      color: #005fa3;
    }
  </style>
</head>

<body>

  <form id="form1" name="form1" method="post" action="">
    <h2>Entry Loan Credentials</h2>

    <table>
      <tr>
        <td width="30%">
          <label for="txt_title">Title</label>
        </td>
        <td>
          <input type="hidden" name="txt_hid" id="txt_hid" value="<?php echo $loan_id ?>" />
          <input required type="text" name="txt_title" id="txt_title" value="<?php echo $loan_title ?>" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="txtarea_details">Details</label>
        </td>
        <td>
          <textarea required name="txtarea_details" id="txtarea_details" cols="45" rows="5"><?php echo $loan_details ?></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <label for="txt_duedate">Due Date</label>
        </td>
        <td>
          <input required type="date" name="txt_duedate" id="txt_duedate" value="<?php echo $loan_duedate ?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="submit-btn">
          <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        </td>
      </tr>
    </table>

    <h2>Loan List</h2>

    <table>
      <tr>
        <th>Slno</th>
        <th>Title</th>
        <th>Details</th>
        <th>Due Date</th>
        <th>Action</th>
      </tr>

      <?php
      $selqry = "select * from tbl_loan where user_id='" . $_SESSION['uid'] . "'";
      $result = $con->query($selqry);
      $i = 0;
      while ($data = $result->fetch_assoc()) {
        $i++;
      ?>
        <tr>
          <td><?php echo $i ?></td>
          <td><?php echo htmlspecialchars($data["loan_title"]) ?></td>
          <td><?php echo htmlspecialchars($data["loan_details"]) ?></td>
          <td><?php echo htmlspecialchars($data["loan_duedate"]) ?></td>
          <td class="action-icons">
            <a href="Loan.php?eid=<?php echo $data["loan_id"] ?>" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a href="Loan.php?did=<?php echo $data["loan_id"] ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this loan?');">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  </form>

</body>
</html>


<?php
  include("Foot.php");
  ?>