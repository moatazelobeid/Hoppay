<?php
session_start(); ob_start();
error_reporting(0);

if(isset($_SESSION['hoppay_id'])){
	header('Location:home.php');
	exit;
}

include('db.php');

if(isset($_REQUEST['button']) && $_REQUEST['button'] != ""){
	
	$user_name = $_REQUEST['user_name'];
	$password = base64_encode($_REQUEST['password']);
	$res_user = mysql_query("select * from mc_users where username='$user_name' And password='$password'");
	$is_user_exist = mysql_num_rows($res_user);
	if($is_user_exist > 0){
		
		# store in session
		$_SESSION['hoppay_id'] = $is_user_exist;
		
		header('Location:home.php');
		exit;
	}
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crawling Manager</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
function validate(){
	if(document.getElementById('user_name').value == ''){
		document.getElementById('user_name').focus();
		return false;
	}
	if(document.getElementById('password').value == ''){
		document.getElementById('password').focus();
		return false;
	}
}
</script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" align="left" valign="top"><?php include 'header.php';?></td>
    </tr>
    <tr>
        <td height="150">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="33%">&nbsp;</td>
        <td width="33%" align="left" valign="top">
        <form name="login" method="post" onsubmit="return validate();">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border:solid 1px; border-color:#999;">
            <tr>
                <td width="22%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="30%">&nbsp;</td>
                <td width="27%">&nbsp;</td>
            </tr>
            <tr>
                <td rowspan="3" align="center" valign="middle"><img src="img/lock.png" width="64" height="64" /></td>
                <td height="30" align="left" valign="middle" class="text1">User Name :</td>
                <td colspan="2" align="left" valign="middle">
                <input name="user_name" type="text" class="tbox" id="user_name" /></td>
                </tr>
            <tr>
                <td height="30" align="left" valign="middle" class="text1">Password :</td>
                <td colspan="2" align="left" valign="middle">
                <input name="password" type="password" class="tbox" id="password" />
                </td>
                </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">
                <input type="submit" name="button" id="button" value="Login" class="btn" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </form>
        </td>
        <td width="33%">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>