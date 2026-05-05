<?php
include("../Assets/Connection/Connection.php");

if(isset($_POST["btn_submit"]))
{
	$question=$_POST["sel_question"];
    $answer=$_POST["txt_answer"];
	$email = $_POST["txt_email"];
	
	$selAdmin="select * from tbl_user where user_question='".$question."' and user_answer='".$answer."' and user_email='".$email."' ";
	$resultAdmin=$con->query($selAdmin);
	if($rowAdmin=$resultAdmin->fetch_assoc())
	{
			?>
		<script>
		window.location="ForgotPassword.php";
		</script>
		<?php
	}
	else
	{
		?>
		<script>
		alert("Invalid");
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
  <table width="469" height="205" border="1">
    <tr>
      <td width="228">Question</td>
      <td width="225"><label for="sel_question"></label>
        <select name="sel_question" id="sel_question">
         
      <option>Select</option>
     <option value="What was the name of your Primary School?">What was the name of your Primary School?</option>
        <option value="What is the name of your First Pet?">What is the name of your First Pet?</option>
        <option value="What is your nickname?">What is your nickname?</option>
        <option value="Who is your childhood friend?">Who is your childhood friend?</option>
         </select></td>
    </tr>
    <tr>
      <td>Answer</td>
      <td><label for="txt_answer"></label>
      <input type="text" name="txt_answer" id="txt_answer" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><label for="txt_email"></label>
      <input type="text" name="txt_email" id="txt_email" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>