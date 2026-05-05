<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

$dis_name="";
$dis_id="";
if(isset($_POST["btn_submit"]))
{
$district=$_POST["txt_dist"];
$hid=$_POST["txt_id"];
if($hid=="")
{
$insqry="insert into tbl_district (district_name) values('".$district."')";
if($con->query($insqry))
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
    $upqry="update tbl_district set district_name='".$district."'where district_id='".$hid."'";
	if($con->query($upqry))
	{
		?>
        <script>
		alert("Updated successfully");
		window.location="district.php"
		</script>
        <?php
	}
  }
}
  
  
if(isset($_GET["did"]))
{
	$delqry="delete from tbl_district where district_id='".$_GET["did"]."'";
	if($con->query($delqry))
		{
			?>
            	<script>
				alert("Deleted Successfully");
				window.location="District.php";
				</script>
                	<?php
		}
	}

if(isset($_GET["eid"]))
{
	$selqry="select * from tbl_district where district_id ='".$_GET['eid']."' ";
	$row=$con->query($selqry);
	$data=$row->fetch_assoc();
	$dis_name=$data['district_name'];
	$dis_id=$data['district_id'];
}
		?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Districts</title>
<style>
  /* Reset & base */
  body {
    background-color: #f5f8ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 40px 20px;
    color: #003366;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .container {
    max-width: 520px;
    margin: 0 auto;
  }

  /* Headings */
  h1, h2 {
    margin: 0 0 16px 0;
    font-weight: 700;
    text-align: center;
    color: white;
    padding: 14px 0;
    border-radius: 20px 20px 10px 10px;
    box-shadow: 0 5px 18px rgba(0, 60, 160, 0.6);
  }

  h1 {
    background: linear-gradient(135deg, #0052cc 0%, #003d99 100%);
    font-size: 28px;
    letter-spacing: 1.3px;
    user-select: none;
  }

  h2 {
    background: #004aad;
    font-size: 20px;
    margin-top: 50px;
    letter-spacing: 0.8px;
    box-shadow: 0 3px 12px rgba(0, 74, 173, 0.6);
  }

  /* Form styling */
  form {
    background: white;
    padding: 30px 28px 36px;
    border-radius: 22px;
    box-shadow: 0 10px 30px rgba(0, 91, 170, 0.12);
    margin-top: 20px;
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 20px;
  }

  table input[type="text"], table input[type="hidden"] {
    width: 100%;
    padding: 11px 14px;
    font-size: 16px;
    border-radius: 14px;
    border: 2px solid #a0c0ff;
    font-weight: 500;
    color: #004080;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 8px #e6f0ff;
  }

  table input[type="text"]:focus {
    outline: none;
    border-color: #004aad;
    box-shadow: 0 0 12px #5a8effaa;
  }

  /* Submit button */
  input[type="submit"] {
    cursor: pointer;
    background: #004aad;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    border: none;
    border-radius: 28px;
    padding: 12px 38px;
    margin: 10px auto 0;
    display: block;
    box-shadow: 0 6px 15px #003075cc;
    transition: background-color 0.25s ease, box-shadow 0.25s ease;
  }

  input[type="submit"]:hover {
    background-color: #002f80;
    box-shadow: 0 10px 30px #001d4dcc;
  }

  /* Data table styling */
  table.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 14px;
    margin-top: 40px;
    box-shadow: 0 10px 30px rgba(0, 91, 170, 0.12);
    border-radius: 22px;
    overflow: hidden;
    background: white;
  }

  table.data-table thead th {
    background: #004aad;
    color: white;
    font-weight: 700;
    padding: 18px 20px;
    font-size: 17px;
    letter-spacing: 0.9px;
    user-select: none;
  }

  table.data-table tbody tr {
    background: #f7faff;
    transition: background-color 0.3s ease;
    border-radius: 0 0 20px 20px;
  }

  table.data-table tbody tr:hover {
    background-color: #d3e2ff;
  }

  table.data-table tbody td {
    padding: 16px 20px;
    font-weight: 600;
    color: #003366;
    text-align: center;
  }

  /* Action links */
  table.data-table tbody td a {
    text-decoration: none;
    font-weight: 600;
    padding: 7px 14px;
    margin: 0 8px;
    border-radius: 18px;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.07);
  }

  table.data-table tbody td a:first-child {
    color: #b71c1c;
    background: #f8d7da;
    box-shadow: 0 4px 12px rgba(183, 28, 28, 0.3);
  }

  table.data-table tbody td a:first-child:hover {
    background: #c82333;
    color: white;
    box-shadow: 0 6px 18px #7a1212;
  }

  table.data-table tbody td a:last-child {
    color: #0d47a1;
    background: #cfe2ff;
    box-shadow: 0 4px 12px rgba(13, 71, 161, 0.3);
  }

  table.data-table tbody td a:last-child:hover {
    background: #094b9a;
    color: white;
    box-shadow: 0 6px 18px #042a5a;
  }

  /* Responsive spacing */
  @media (max-width: 600px) {
    body {
      padding: 20px 12px;
    }
    form, table.data-table {
      box-shadow: none;
      border-radius: 14px;
      padding: 18px 20px;
    }
    input[type="submit"] {
      width: 100%;
      margin-top: 20px;
      padding: 14px 0;
    }
  }
</style>
</head>

<body>

<div class="container">

  <h1>District Management</h1>

  <form name="form1" method="post" action="">
    <h2>Add / Edit District</h2>
    <table>
      <tr>
        <td>District</td>
        <td>
          <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $dis_id?>" />
          <input required type="text" name="txt_dist" id="txt_dist" value="<?php echo $dis_name?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        </td>
      </tr>
    </table>
  </form>

  <h2>Existing Districts</h2>

  <table class="data-table" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th>Slno</th>
        <th>District</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $selqry="select * from tbl_district";
        $result = $con->query($selqry);
        $i=0;
        while($data=$result->fetch_assoc())
        {
          $i++;
      ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo htmlspecialchars($data["district_name"]) ?></td>
        <td>
          <a href="District.php?did=<?php echo $data["district_id"] ?>">Delete</a>
          <a href="District.php?eid=<?php echo $data["district_id"] ?>">Edit</a>
        </td>
      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

</div>

</body>
</html>

<?php
  include("Foot.php");
  ?>