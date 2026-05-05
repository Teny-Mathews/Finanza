<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

$incometype_name="";
$incometype_id="";
if(isset($_POST["btn_save"]))
{
	$incometype= $_POST["txt_incometype"];
	$hid=$_POST["txt_id"];
	if($hid=="")
	{
	$insQry= "insert into tbl_incometype(incometype_name)values('".$incometype."')";
	if($con->query($insQry))
{	
?>
<script>
alert("Inserted Successfully");
</script>
<?php
}
}


else
{
	$upQry="update tbl_incometype set incometype_name='".$incometype."' where incometype_id='".$hid."'";
	if($con->query($upQry))
	{
		?>
    <script>
	alert("Updated Successfully");
	window.location="IncomeType.php";
	</script>
	<?php
	}
}
}

if(isset($_GET["did"]))
{
   $delqry="delete from tbl_incometype where incometype_id=".$_GET["did"];
    if($con->query($delqry))
    {

?>
<script>
alert("Deleted successfully");
window.location="IncomeType.php";
</script>
<?php
   }
}
   if (isset($_GET['eid']))
   {
	   $delqry="select * from tbl_incometype where incometype_id='".$_GET['eid']."'";
		$row=$con->query($delqry);
	$data=$row->fetch_assoc();
	$incometype_name=$data['incometype_name'];
	$incometype_id=$data['incometype_id'];
   }




?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Income Types</title>

<style>
  /* ---------- Base ---------- */
  body {
    background: linear-gradient(135deg, #f0f6ff, #ffffff);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 50px 20px;
    margin: 0;
    color: #002b5c;
  }

  .container {
    max-width: 700px;
    margin: 0 auto;
  }

  /* ---------- Boxes ---------- */
  .box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0, 91, 170, 0.15);
    padding: 25px 30px;
    margin-bottom: 45px;
    transition: transform 0.25s ease;
  }

  .box:hover {
    transform: translateY(-4px);
  }

  /* ---------- Section Header ---------- */
  .section-header {
    background: #005baa;
    color: white;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
    border-radius: 14px 14px 0 0;
    padding: 15px 0;
    margin: -25px -30px 30px -30px;
    box-shadow: 0 4px 12px rgba(0, 91, 170, 0.3);
  }

  /* ---------- Form ---------- */
  form table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 14px;
  }

  form td {
    padding: 10px 12px;
    vertical-align: middle;
  }

  form td:first-child {
    font-weight: 600;
    color: #003366;
    width: 35%;
  }

  input[type="text"], input[type="hidden"] {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #b6cffc;
    border-radius: 12px;
    font-size: 16px;
    color: #00264d;
    background-color: #f9fbff;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  input[type="text"]:focus {
    outline: none;
    border-color: #005baa;
    box-shadow: 0 0 6px #7aa9ff99;
  }

  input[type="submit"] {
    cursor: pointer;
    background: #007bff;
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 10px 30px;
    border-radius: 22px;
    margin: 10px 8px 0 8px;
    box-shadow: 0 6px 10px #0056b3cc;
    transition: background-color 0.25s ease, transform 0.2s ease;
  }

  input[type="submit"]:hover {
    background-color: #004a99;
    transform: translateY(-2px);
  }

  /* ---------- Table ---------- */
  .list-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    font-size: 16px;
  }

  .list-table thead th {
    background-color: #005baa;
    color: #fff;
    font-weight: 700;
    padding: 14px;
    border-radius: 10px 10px 0 0;
    text-align: center;
  }

  .list-table tbody tr {
    background: #f9fbff;
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0, 91, 170, 0.1);
    transition: background-color 0.25s ease, transform 0.2s ease;
  }

  .list-table tbody tr:hover {
    background-color: #e8f0ff;
    transform: scale(1.01);
  }

  .list-table td {
    padding: 12px 15px;
    text-align: center;
  }

  .list-table tbody td:last-child {
    white-space: nowrap;
  }

  /* ---------- Action Buttons ---------- */
  a.delete, a.edit {
    text-decoration: none;
    font-weight: 600;
    padding: 6px 14px;
    margin: 0 6px;
    border-radius: 14px;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    display: inline-block;
  }

  a.delete {
    color: #b02a37;
    background: #f8d7da;
  }

  a.delete:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-2px);
  }

  a.edit {
    color: #0d6efd;
    background: #cfe2ff;
  }

  a.edit:hover {
    background: #0d6efd;
    color: white;
    transform: translateY(-2px);
  }

  /* ---------- Responsive Design ---------- */
  @media screen and (max-width: 600px) {
    body {
      padding: 20px 10px;
    }

    .container {
      max-width: 95%;
    }

    .box {
      padding: 20px;
    }

    .section-header {
      font-size: 18px;
    }

    input[type="text"] {
      font-size: 15px;
    }

    input[type="submit"] {
      width: 100%;
      margin: 10px 0;
    }

    .list-table thead {
      display: none;
    }

    .list-table, .list-table tbody, .list-table tr, .list-table td {
      display: block;
      width: 100%;
    }

    .list-table tr {
      margin-bottom: 16px;
    }

    .list-table td {
      text-align: right;
      padding-left: 50%;
      position: relative;
    }

    .list-table td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      width: 45%;
      text-align: left;
      font-weight: 600;
      color: #003366;
    }
  }
</style>
</head>

<body>
  <div class="container">

    <!-- Add Income Type -->
    <div class="box">
      <div class="section-header">Add Income Type</div>
      <form id="form1" name="form1" method="post" action="">
        <table>
          <tr>
            <td>Income Type</td>
            <td>
              <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $incometype_id ?>" />
              <input required type="text" name="txt_incometype" id="txt_incometype" value="<?php echo $incometype_name ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="btn_save" id="btn_save" value="Save" />
              <input type="submit" name="btn_cancel" id="btn_cancel" value="Cancel" />
            </td>
          </tr>
        </table>
      </form>
    </div>

    <!-- View Income Types -->
    <div class="box">
      <div class="section-header">View Income Types</div>
      <table class="list-table">
        <thead>
          <tr>
            <th>Slno</th>
            <th>Income Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selqry = "Select * from tbl_incometype";
          $result = $con->query($selqry);
          $i = 0;
          while ($data = $result->fetch_assoc()) {
            $i++;
          ?>
            <tr>
              <td data-label="Slno"><?php echo $i ?></td>
              <td data-label="Income Type"><?php echo htmlspecialchars($data["incometype_name"]) ?></td>
              <td data-label="Action">
                <a href="IncomeType.php?did=<?php echo $data["incometype_id"] ?>" class="delete">Delete</a>
                <a href="IncomeType.php?eid=<?php echo $data["incometype_id"] ?>" class="edit">Edit</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>


<?php
  include("Foot.php");
  ?>