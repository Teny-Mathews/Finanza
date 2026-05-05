<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

if(isset($_POST["btn_submit"]))
{
$brand=$_POST["txt_brand"];
$insqry="insert into tbl_brand (brand_name) values('".$brand."')";
if($con->query($insqry))
{
	?>
    <script>
	alert("Inserted Successfully");
	</script>
    <?php
}

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
  <table width="350" height="169" border="1">
    <tr>
      <td width="154">Brand</td>
      <td width="180"><label for="txt_brand"></label>
      <input type="text" name="txt_brand" id="txt_brand" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
   include("Foot.php");
   ?>