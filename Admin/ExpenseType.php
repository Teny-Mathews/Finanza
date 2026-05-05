<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

$expensetype_name="";
$expensetype_id="";
if(isset($_POST["btn_save"]))
{
	$expensetype= $_POST["txt_ext"];
	$hid=$_POST["txt_id"];
	if($hid=="")
	{
	$insQry= "insert into tbl_expensetype(expensetype_name)values('".$expensetype."')";
	if($con->query($insQry))
{	
?>
<script>
alert("Inserted successfully");
</script>
<?php
}
}


else
{
	$upQry="update tbl_expensetype set expensetype_name='".$expensetype."' where expensetype_id='".$hid."'";
	if($con->query($upQry))
	{
		?>
    <script>
	alert("Updated successfully");
	window.location="ExpenseType.php";
	</script>
	<?php
	}
}
}

if(isset($_GET["did"]))
{
   $delqry="delete from tbl_expensetype where expensetype_id=".$_GET["did"];
    if($con->query($delqry))
    {

?>
<script>
alert("Deleted successfully");
window.location="ExpenseType.php";
</script>
<?php
   }
}
   if (isset($_GET['eid']))
   {
	   $delqry="select * from tbl_expensetype where expensetype_id='".$_GET['eid']."'";
		$row=$con->query($delqry);
	$data=$row->fetch_assoc();
	$expensetype_name=$data['expensetype_name'];
	$expensetype_id=$data['expensetype_id'];
   }




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Expense Type</title>

<style>
  body {
    background-color: #e9f0ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 40px 20px;
  }

  .container {
    max-width: 650px;
    margin: 0 auto;
  }

  /* Shared box style */
  .box {
    background: white;
    border-radius: 22px;
    box-shadow: 0 14px 36px rgb(0 91 170 / 0.15);
    padding: 30px 40px;
    margin-bottom: 40px;
  }

  .section-header {
    background-color: #004aad;
    color: white;
    font-weight: 700;
    font-size: 24px;
    text-align: center;
    padding: 18px 0;
    border-radius: 20px 20px 0 0;
    margin: -30px -40px 30px -40px;
    letter-spacing: 1.2px;
    box-shadow: 0 7px 20px rgb(0 74 173 / 0.45);
    user-select: none;
  }

  /* Form styles */
  form table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 18px;
  }

  form td {
    padding: 12px 15px;
    vertical-align: middle;
    color: #002e6d;
    font-weight: 600;
  }

  form input[type="text"],
  form input[type="hidden"] {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #a6c8ff;
    border-radius: 12px;
    font-size: 15px;
    color: #003080;
    font-weight: 500;
    transition: border-color 0.3s ease;
  }

  form input[type="text"]:focus {
    border-color: #004aad;
    outline: none;
  }

  form input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 28px;
    font-weight: 700;
    border-radius: 28px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: 20px auto 0 auto;
    display: inline-block;
    min-width: 100px;
  }

  form input[type="submit"]:hover {
    background-color: #004aad;
  }

  /* Table styles */
  table.list-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 14px;
    border-radius: 18px;
    overflow: hidden;
  }

  table.list-table thead tr {
    background-color: #007bff;
    color: white;
    font-weight: 700;
    letter-spacing: 0.8px;
  }

  table.list-table th, 
  table.list-table td {
    padding: 14px 12px;
    text-align: center;
  }

  table.list-table tbody tr {
    background-color: #f7faff;
    color: #003366;
    font-weight: 600;
    border-radius: 14px;
    box-shadow: inset 0 0 5px #c7d9ff;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  /* Shadow and highlight on hover and focus */
  table.list-table tbody tr:hover,
  table.list-table tbody tr:focus-within {
    background-color: #dbe8ff;
    box-shadow: 0 4px 15px rgb(0 74 173 / 0.25);
  }

  /* Action links */
  table.list-table td a {
    font-weight: 600;
    margin: 0 6px;
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 18px;
    transition: background-color 0.25s ease, color 0.25s ease;
    user-select: none;
  }

  /* Delete link - red */
  table.list-table td a.delete {
    color: #c62828;
    border: 1.8px solid #c62828;
  }

  table.list-table td a.delete:hover {
    background-color: #c62828;
    color: white;
  }

  /* Edit link - blue */
  table.list-table td a.edit {
    color: #004aad;
    border: 1.8px solid #004aad;
  }

  table.list-table td a.edit:hover {
    background-color: #004aad;
    color: white;
  }
</style>

</head>

<body>
  <div class="container">

    <!-- Add Expense Type Box -->
    <div class="box">
      <div class="section-header">Add Expense Type</div>

      <form id="form1" name="form1" method="post" action="">
        <table>
          <tr>
            <td>Expense Type</td>
            <td>
              <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $expensetype_id ?>" />
              <input required type="text" name="txt_ext" id="txt_ext" value="<?php echo $expensetype_name ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center;">
              <input type="submit" name="btn_save" id="btn_save" value="Save" />
              <input type="submit" name="txt_cal" id="txt_cal" value="Cancel" />
            </td>
          </tr>
        </table>
      </form>
    </div>

    <!-- View Expense Types Box -->
    <div class="box">
      <div class="section-header">View Expense Types</div>

      <table class="list-table" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>Slno</th>
            <th>Expense Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selqry = "Select * from tbl_expensetype";
          $result = $con->query($selqry);
          $i = 0;
          while ($data = $result->fetch_assoc()) {
            $i++;
          ?>
            <tr tabindex="0">
              <td><?php echo $i ?></td>
              <td><?php echo htmlspecialchars($data["expensetype_name"]) ?></td>
              <td>
                <a class="delete" href="ExpenseType.php?did=<?php echo $data["expensetype_id"] ?>">Delete</a>
                <a class="edit" href="ExpenseType.php?eid=<?php echo $data["expensetype_id"] ?>">Edit</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
</body>

</html>


<?php
  include("Foot.php");
  ?>









