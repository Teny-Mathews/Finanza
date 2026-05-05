<?php

include("../Assets/Connection/Connection.php");
include("Head.php");

$categoryid="";
$subcategory_id="";
$subcategory_name="";
if(isset($_POST["btn_submit"]))
{
$category=$_POST["sel_category"];
$subcategory=$_POST["txt_subcategory"];
$hid=$_POST["txt_hid"];
if($hid=="")
{
$insqry="insert into tbl_subcategory (subcategory_name,category_id) values('".$subcategory."','".$category."')";
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
    $upqry="update tbl_subcategory set subcategory_name='".$subcategory."',category_id='".$category."' where subcategory_id='".$hid."'";
	if($con->query($upqry))
	{
		?>
        <script>
		alert("Updated successfully");
		window.location="Subcategory.php"
		</script>
        <?php
	}
  }
}
  
if(isset($_GET["did"]))
{
	$delqry="delete from tbl_subcategory where subcategory_id=".$_GET["did"];
	if($con->query($delqry))
		{
			?>
            	<script>
				alert("deleted Successfully");
				window.location="Subcategory.php";
				</script>
                	<?php
		}
}
if(isset($_GET["eid"]))
{
	$selqry="select * from tbl_subcategory where subcategory_id ='".$_GET['eid']."' ";
	$row=$con->query($selqry);
	$data=$row->fetch_assoc();
	$category_id=$data['category_id'];
	$subcategory_id=$data['subcategory_id'];
	$subcategory_name=$data['subcategory_name'];
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
  <table width="367" height="183" border="1">
    <tr>
      <td>Category</td>
      <td><label for="sel_category"></label>
        <select name="sel_category" id="sel_category" required >
        <option>Select</option>
      <?php 
	  $selqry="select * from tbl_category";
	  $resopt=$con->query($selqry);
	  while($dataopt=$resopt->fetch_assoc())
	  {
		  ?>
          <option value="<?php echo $dataopt["category_id"] ?>">
          <?php echo $dataopt["category_name"] ?>
          </option>
          <?php
	  }
	    ?>
        
        
      </select></td>
    </tr>
    <tr>
      <td>Subcategory</td>
      <td><label for="txt_subcategory"></label>
      <input type="hidden" name="txt_hid" value="<?php echo $subcategory_id ?>"/>
      <input required type="text" name="txt_subcategory" id="txt_subcategory" value="<?php echo $subcategory_name ?>"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  <table width="200" border="1">
    <tr>
      <td>Slno</td>
      <td>Categoryname</td>
      <td>Subcategoryname</td>
      <td>Action</td>
    </tr>
     <?php
	$selqry="select * from tbl_subcategory s inner join tbl_category c on s.category_id = c.category_id";
	 $result = $con->query($selqry);
	 $i=0;
	 while($data=$result->fetch_assoc())
	 {
		 $i++;
		 ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data ["category_name"] ?> </td>
      <td><?php echo $data ["subcategory_name"] ?> </td>
           <td><a href="Subcategory.php?did=<?php echo $data["subcategory_id"]?>"> delete</a>
           <a href="Subcategory.php?eid=<?php echo $data["subcategory_id"]?>"> edit</a></td>
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