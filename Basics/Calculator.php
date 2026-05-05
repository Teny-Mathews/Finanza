<?php
$result="";
if(isset($_POST["btn_plus"]))
{
	$n1=$_POST["txt_no1"];
	$n2=$_POST["txt_no2"];
	$result=$n1+$n2;
	
	
}
if(isset($_POST["btn_subtract"]))
{
	$n1=$_POST["txt_no1"];
	$n2=$_POST["txt_no2"];
	$result=$n1-$n2;
}
if(isset($_POST["btn_multiply"]))
{
	$n1=$_POST["txt_no1"];
	$n2=$_POST["txt_no2"];
	$result=$n1*$n2;
}
if(isset($_POST["btn_divide"]))
{
	$n1=$_POST["txt_no1"];
	$n2=$_POST["txt_no2"];
	$result=$n1/$n2;
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
  <table width="417" height="163" border="1">
    <tr>
      <td>Number-1</td>
      <td><label for="txt_no1"></label>
      <input type="text" name="txt_no1" id="txt_no1" /></td>
    </tr>
    <tr>
      <td>Number-2</td>
      <td><label for="txt_no2"></label>
      <input type="text" name="txt_no2" id="txt_no2" /></td>
    </tr>
    <tr>
      <td colspan="2" align ="center"><input type="submit" name="btn_plus" id="btn_plus" value="+" />
        <input type="submit" name="btn_subtract" id="btn_subtract" value="-" />
        <input type="submit" name="btn_multiply" id="btn_multiply" value="*" />
      <input type="submit" name="btn_divide" id="btn_divide" value="/" /></td>
    </tr>
    <tr>
      <td>Result</td>
      <td> <?php echo $result; ?> </td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>