<?php
session_start(); ob_start();
error_reporting(0);

if(!isset($_SESSION['hoppay_id'])){
	header('Location:.');
	exit;
}

include('db.php');

$qry_cr = mysql_query("select * from mc_merchants_new where site_id > '0'");
$res_cr = mysql_num_rows($qry_cr);

if($res_cr > 0){
	$btn_class = 'dbtn';
	$btn_val = '   Disable   ';
}else{
	$btn_class = 'btn';
	$btn_val = 'Start Crawl';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crawling Manager</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<script type="text/javascript">
function cur_date() {
	
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
	now = new Date();
	
	day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
	month = "" + (monthNames[now.getMonth()]);
	year = "" + now.getFullYear();
	hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
	minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
	var ampm = hour >= 12 ? 'PM' : 'AM';
	return day + " " + month + ", " + year + " " + hour + ":" + minute + ":" + ampm;
}
function cron_set(site_id){
	
	var formattedDate = cur_date();

	var temp = '<span class="small">Start Date :</span> <span class="pricetext1">'+ formattedDate +'</span>';
	
	$("#lbl_souq").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 1){
		$("#st_souq").html(temp);
	}
	$("#lbl_markavip").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 2){
		$("#st_markavip").html(temp);
	}
	$("#lbl_namshi").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 3){
		$("#st_namshi").html(temp);
	}
	$("#lbl_ikea").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 4){
		$("#st_ikea").html(temp);
	}
	$("#lbl_sukar").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 5){
		$("#st_sukar").html(temp);
	}
	$("#lbl_extrastore").html('<input type="button" value="   Disable   " class="dbtn" onclick="error();" />');
	if(site_id == 6){
		$("#st_extrastore").html(temp);
	}
	$.ajax({
		url: "start_crawl.php?site_id="+site_id,
		cache: false,
		success: function(res){
			//alert(res);
		}
	});
}
function error(){
	alert("Crawling is processing...");
}
function update_error(){
	alert("Import is processing...");
}
function prod_set(site_id){
	
	var r = confirm("Do you want import data ?");
	if (r == true) {
		
		var str = $("#lbl_souq_up").html();
		if(str.trim() != ''){
			$("#lbl_souq_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		
		var str = $("#lbl_markavip_up").html();
		if(str.trim() != ''){
			$("#lbl_markavip_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		
		var str = $("#lbl_namshi_up").html();
		if(str.trim() != ''){
			$("#lbl_namshi_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		
		var str = $("#lbl_ikea_up").html();
		if(str.trim() != ''){
			$("#lbl_ikea_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		
		var str = $("#lbl_sukar_up").html();
		if(str.trim() != ''){
			$("#lbl_sukar_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		
		var str = $("#lbl_extrastore_up").html();
		if(str.trim() != ''){
			$("#lbl_extrastore_up").html('<input type="button" value="Import to Hoppay.com" class="cl_btnd" onclick="update_error();" />');
		}
		$.ajax({
			url: "product_update.php?site_id="+site_id,
			cache: false,
			success: function(res){
				alert("Import has been completed");
				window.location = 'home.php';
			}
		});
	}
}
</script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" align="left" valign="top"><?php include 'header.php';?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="18%" rowspan="2" align="left" valign="top" style="border-right:solid 1px; border-color:#999;"><?php include 'menu.php';?></td>
        <td height="25" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="3%" align="left" valign="middle"><img src="img/arrow-right.png" width="16" height="16" /></td>
                <td width="64%" align="left" valign="middle" class="bigtext1">Crawling</td>
                <td width="33%">&nbsp;</td>
            </tr>
        </table></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="79%" align="left" valign="top" style="border-top:solid 1px; border-color:#999;">
            <table width="100%" border="0" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="4%" height="80" align="center" valign="middle">&nbsp;</td>
                    <td width="16%" align="center" valign="middle"><img src="http://cf1.souqcdn.com/static/ltr/en/images/qsouq/header/souq-logo-en.png" height="30" width="150"><br />
                    <span class="text1">www.souq.com</span></td>
                    <td width="15%" align="left" valign="middle" style="padding-left:5px;" id="lbl_souq">
                    <input type="button" value="<?php echo $btn_val;?>" class="<?php echo $btn_class;?>" onclick="cron_set('1');"/>
                    
                    </td>
                    <td width="19%" align="left" valign="middle" id="lbl_souq_up">&nbsp;</td>
                    <td width="14%" align="center" valign="middle"><img src="img/markavip.png" height="39" width="37"><span class="text1"><br />
                    www.markavip.com</span></td>
                    <td width="15%" align="left" valign="middle" id="lbl_markavip">
                    <input type="button" value="<?php echo $btn_val;?>" class="<?php echo $btn_class;?>" onclick="cron_set('2');"/>
                    </td>
                    <td width="17%" align="left" valign="middle" id="lbl_markavip_up">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_souq"><span class="small">Start Date :</span>
                    <span class="pricetext1">
					<?php
                    if($res_souq["crawl_start_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_souq['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_markavip"><span class="small">Start Date :</span>
                    <span class="pricetext1">
					<?php
                    if($res_mark["crawl_start_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_mark['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
                        <span class="pricetext1"><?php
                    if($res_souq["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_souq['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
					<span class="pricetext1">
					<?php
                    if($res_mark["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_mark['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                
                <tr>
                    <td colspan="7" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td height="80" align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><span  style="font-size:40px; font-weight:bold;">Namshi</span><br />
                    <span class="text1">www.namshi.com</span></td>
                    <td align="left" valign="middle" style="padding-left:5px;" id="lbl_namshi">
                    
                    <input type="button" value="<?php echo $btn_val;?>" class="<?php echo $btn_class;?>" onclick="cron_set('3');"/>
                    
                    </td>
                    <td align="left" valign="middle" id="lbl_namshi_up">&nbsp;</td>
                    <td align="center" valign="middle"><img src="img/ikea.png" height="34" width="74"><br>
                    <span class="text1">www.ikea.com</span></td>
                    <td align="left" valign="middle" id="lbl_ikea">
                    <input type="button" value="<?php echo $btn_val;?>" class="<?php echo $btn_class;?>" onclick="cron_set('4');"/></td>
                    <td align="left" valign="middle" id="lbl_ikea_up">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_namshi"><span class="small">Start Date :</span>
                        <span class="pricetext1"><?php
                    if($res_nam["crawl_start_date"] <> ""){
						//echo $res_nam['crawl_start_date'];
						echo date('d M, Y h:i A', strtotime($res_nam['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_ikea"><span class="small">Start Date :</span>
                        <span class="pricetext1"><?php
                    if($res_ikea["crawl_start_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_ikea['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
                        <span class="pricetext1"><?php
                    if($res_nam["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_nam['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
                        <span class="pricetext1"><?php
                    if($res_ikea["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_ikea['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td height="50" align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle" style="font-size:40px; font-weight:bold; color:#900;"><img src="img/sukar.png" width="133" height="76" /><br />
                    <span class="text1">www.sukar.com</span></td>
                    <td align="left" valign="middle" style="padding-left:5px;" id="lbl_sukar">
                    <input type="button" class="<?php echo $btn_class;?>" value="<?php echo $btn_val;?>" onclick="cron_set('5');"/>
                    </td>
                    <td align="left" valign="middle" id="lbl_sukar_up">&nbsp;</td>
                    <td align="center" valign="middle"><img src="img/extra.png" height="50" width="100"><span class="text1"><br />
                        .<br />
www.extrastores.com</span></td>
                    <td align="left" valign="middle" id="lbl_extrastore">
                    <input type="button" value="<?php echo $btn_val;?>" class="<?php echo $btn_class;?>" onclick="cron_set('6');"/>
                    </td>
                    <td align="left" valign="middle" id="lbl_extrastore_up">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="menutext1">Last Crawl</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_sukar"><span class="small">Start Date :</span>
                        <span class="pricetext1"><?php
                    if($res_sukar["crawl_start_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_sukar['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" id="st_extrastore"><span class="small">Start Date :</span>
                        <span class="pricetext1"><?php
                    if($res_ex["crawl_start_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_ex['crawl_start_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
                        <span class="pricetext1"><?php
                    if($res_sukar["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_sukar['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><span class="small">End Date :</span>
                        <span class="pricetext1"><?php
                    if($res_ex["crawl_end_date"] <> ""){
						echo date('d M, Y h:i A', strtotime($res_ex['crawl_end_date']));
					}else{
						echo 'N/A';
					}
					?></span></td>
                    <td align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle" >&nbsp;</td>
                </tr>
                <tr>
                    <td height="80" colspan="7" align="left" valign="top" id="output">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="3%" align="left" valign="top" style="border-top:solid 1px; border-color:#999;">&nbsp;</td>
    </tr>
</table>
</body>
</html>