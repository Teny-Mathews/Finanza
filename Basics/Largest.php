<?php

$Largest="";
$Smallest="";
if(isset($_POST["btn_submit"]))
{
	$n1=$_POST["txt_no1"];
	$n2=$_POST["txt_no2"];
	$n3=$_POST["txt_no3"];
	
	if($n1>$n2 && $n1>$n3)
	{
	$Largest=$n1;
	}
	else if ($n2>$n1 && $n2>$n3)
	{
		$Largest=$n2;
	}
	else
	{
		$Largest=$n3;
	}
	
	//Find the Smallest
	if ($n1<$n2 && $n1<$n3)
	{
	$Smallest=$n1;
	}
	else if($n2<$n1 && $n2<$n3)
	{
		$Smallest=$n2;
	}
	else
	{
		$Smallest=$n3;
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
  <table width="439" border="1">
    <tr>
      <td width="68">NO1</td>
      <td width="355"><label for="txt_no1"></label>
        <label for="txt_no2"></label>
        <input type="text" name="txt_no1" id="txt_no1" /></td>
    </tr>
    <tr>
      <td>NO2
        <label for="txt_no2"></label></td>
      <td><label for="txt_no3"></label>
      <input type="text" name="txt_no2" id="txt_no3" /></td>
    </tr>
    <tr>
      <td>NO3</td>
      <td><label for="txt_no4"></label>
      <input type="text" name="txt_no3" id="txt_no4" /></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
    <tr>
      <td>Largest</td>
      <td><?php echo $Largest;?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Smallest</td>
      <td><?php echo $Smallest;?></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>