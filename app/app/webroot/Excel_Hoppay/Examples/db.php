<?php
$con=mysql_connect("localhost","root","");
mysql_select_db('mena1');

// Check connection
if (mysql_errno()) {
  echo "Failed to connect to MySQL: " . mysql_error();
}

//mysqli_close($con);

?>