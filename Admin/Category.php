
<?php
include("../Assets/Connection/Connection.php");
include("Head.php");

$category_name="";
$category_id="";
if(isset($_POST["btn_submit"]))
{
$category=$_POST["txt_cat"];
$hid=$_POST["txt_id"];
if($hid=="")
{
$insqry="insert into tbl_category (category_name) values('".$category."')";
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
    $upqry="update tbl_category set category_name='".$category."' where category_id='".$hid."'";
	if($con->query($upqry))
	{
		?>
        <script>
		alert("Updated successfully");
		window.location="Category.php"
		</script>
        <?php
	}
  }
}
  


if(isset($_GET["did"]))
{
	$delqry="delete from tbl_category where category_id=".$_GET["did"];
	if($con->query($delqry))
		{
			?>
            	<script>
				alert("deleted Successfully");
				window.location="Category.php";
				</script>
                	<?php
		}
	}
	if(isset($_GET["eid"]))
{
	$selqry="select * from tbl_category where category_id ='".$_GET['eid']."' ";
	$row=$con->query($selqry);
	$data=$row->fetch_assoc();
	$category_name=$data['category_name'];
	$category_id=$data['category_id'];
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
  <table width="393" height="169" border="1">
    <tr>
      <td width="147">Category</td>
      <td width="230"><label for="txt_cat"></label>
      <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $category_id ?>"/>
      <input required type="text" name="txt_cat" id="txt_cat"  value="<?php echo $category_name?>"/>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  <table width="200" border="1">
    <tr>
      <td>Slno</td>
      <td>Category</td>
      <td>Action</td>
    </tr>
    <?php
	$selqry="select * from tbl_category";
	 $result = $con->query($selqry);
	 $i=0;
	 while($data=$result->fetch_assoc())
	 {
		 $i++;
		 ?>
    <tr>
      <td><?php echo $i ?></td>
      <td> <?php  echo $data ["category_name"] ?> </td>
      <td><a href="Category.php?did=<?php echo $data["category_id"]?>"> delete</a>
      <a href="Category.php?eid=<?php echo $data["category_id"]?>"> Edit</a></td>
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