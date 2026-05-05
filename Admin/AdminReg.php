<?php

include("../Assets/Connection/Connection.php");
include("Head.php");
$admin_name="";
$admin_id="";
$admin_email="";
$admin_password="";
if(isset($_POST["btn_submit"]))
{
$name=$_POST["txt_name"];
$email=$_POST["txt_email"];
$password=$_POST["txt_password"];
$hid=$_POST["txt_hid"];
if($hid=="")
{
$insqry="insert into tbl_admin (admin_name,admin_email,admin_password) values('".$name."','".$email."','".$password."')";
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
     $upqry="update tbl_admin set admin_name='".$name."',admin_email='".$email."',admin_password='".$password."' where admin_id='".$hid."'";
	if($con->query($upqry))
	{
		?>
        <script>
		alert("Updated successfully");
		window.location="Adminreg.php"
		</script>
        <?php
	}
  }
}
  

if(isset($_GET["did"]))
{
	$delqry="delete from tbl_admin where admin_id=".$_GET["did"];
	if($con->query($delqry))
		{
			?>
            	<script>
				alert("deleted Successfully");
				window.location="Adminreg.php";
				</script>
                	<?php
		}
}
	if(isset($_GET["eid"]))
{
	$selqry="select * from tbl_admin where admin_id ='".$_GET['eid']."' ";
	$row=$con->query($selqry);
	$data=$row->fetch_assoc();
	$admin_name=$data['admin_name'];
	$admin_id=$data['admin_id'];
	$admin_email=$data['admin_email'];
	$admin_password=$data['admin_password'];
}
	
		?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="653" height="361" border="1">
    <tr>
      <td width="320">Name</td>
      <td width="317"><label for="txt_name"></label>
      <input type="hidden" name="txt_hid" value="<?php echo $admin_id ?>"/>
      <input required type="text" name="txt_name" id="txt_name" value="<?php echo $admin_name ?>"/></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><label for="txt_email"></label>
      <input required type="text" name="txt_email" id="txt_email" value="<?php echo $admin_email ?>"/></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><label for="txt_password"></label>
      <input required type="text" name="txt_password" id="txt_password" value="<?php echo $admin_password ?>"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  <table width="200" border="1">
    <tr>
      <td>Slno</td>
      <td>Name</td>
      <td>Email</td>
      <td>Password</td>
      <td>Action</td>
    </tr>
     <?php
	$selqry="select * from tbl_admin";
	 $result = $con->query($selqry);
	 $i=0;
	 while($data=$result->fetch_assoc())
	 {
		 $i++;
		 ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data ["admin_name"] ?> </td>
      <td><?php echo $data ["admin_email"] ?> </td>
      <td><?php echo $data ["admin_password"] ?> </td>
           <td><a href="AdminReg.php?did=<?php echo $data["admin_id"]?>"> delete</a>
           <a href="AdminReg.php?eid=<?php echo $data["admin_id"]?>"> edit</a> </td>
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