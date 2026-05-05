<?php
$Servername = "localhost";
$Username = "root";
$Password = "";
$Database = "db_finanza";
$con = mysqli_connect($Servername,$Username,$Password,$Database);
if(!$con)
{ 
  echo "Connection Failed";
}
?>