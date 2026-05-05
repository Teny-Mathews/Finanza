<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if(isset($_POST["btn_submit"]))
{
$content=$_POST["txtarea_fdbkcontent"];
$insqry="insert into tbl_feedback (feedback_content,user_id) values('".$content."','".$_SESSION['uid']."')";
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
  <table width="405" height="127" border="1">
    <tr>
      <td>Feedback Content </td>
      <td><label for="txtarea_fdbkcontent"></label>
      <textarea required name="txtarea_fdbkcontent" id="txtarea_fdbkcontent" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
  <table width="401" height="136" border="1">
    <tr>
      <td>Slno</td>
      <td>User_Name</td>
      <td>Feedback</td>
    </tr>
    <tr>
    <?php
	$selqry="select * from tbl_feedback f inner join tbl_user u on u.user_id = f.user_id where f.user_id='".$_SESSION['uid']."'";
	 $result = $con->query($selqry);
	 $i=0;
	 while($data=$result->fetch_assoc())
	 {
		 $i++;
		 ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data["user_name"] ?></td>
      <td> <?php  echo $data ["feedback_content"] ?> </td>
      
      <td></td>
    </tr>
    <?php
	 }
	 ?>
   
  </tr>
    
      
      
    
  </table>
</form>
</body>
</html>
<?php
  include("Foot.php");
  ?>