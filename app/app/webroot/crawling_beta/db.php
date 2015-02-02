<?php
//$con=mysql_connect("localhost","root","");
//mysql_select_db('mena1');

// live site
$con=mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
mysql_select_db('menacompare_demo1');

// maas server
//$con=mysql_connect("MENACOMPARE.db.4375759.hostedresource.com","MENACOMPARE","Men@compare12");
//mysql_select_db('MENACOMPARE');

// Check connection
if (mysql_errno()) {
  echo "Failed to connect to MySQL: " . mysql_error();
}

//mysqli_close($con);

?>