<?php
ob_start();
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Language" content="ar" />
<?php
if(!isset($_SESSION['hoppay_id'])){
	header('Location:.');
	exit;
}

include('db.php');

$merchant_id = base64_decode($_REQUEST['siteid']);

$str_qry = "select * from mc_products_temp where merchant_product_id='$merchant_id'";
$qry_record = mysql_query($str_qry);
$no_record = mysql_num_rows($qry_record);

$qry_mar = mysql_query("select * from mc_merchants_new where id='$merchant_id'");
$res_mar = mysql_fetch_array($qry_mar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crawling Manager</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" align="left" valign="top"><?php include 'header.php';?></td>
    </tr>
    <tr>
        <td style="border-right:solid 1px; border-color:#999;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="18%" rowspan="2" align="left" valign="top" style="border-right:solid 1px; border-color:#999;"><?php include 'menu.php';?></td>
        <td height="25" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="3%" align="left" valign="middle"><img src="img/arrow-right.png" width="16" height="16" /></td>
                <td width="64%" align="left" valign="middle" class="bigtext1"><?php echo $res_mar['first_name'];?> Products (<?php echo $no_record;?>) > English and Arabic</td>
                <td width="33%">&nbsp;</td>
            </tr>
        </table></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="75%" align="left" valign="top" style="border-top:solid 1px; border-color:#999; padding-left:20px;"><br />

        <?php
		$qry_prod = mysql_query($str_qry);
		//$res_prod = mysql_fetch_array($qry_prod); echo "<pre>";print_r($res_prod);exit;
		while($res_prod = mysql_fetch_array($qry_prod)){ //
		?>
        <table width="190" border="0" cellspacing="2" cellpadding="2" style="float:left;">
            <tr>
                <td align="center" valign="top">
                <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
                    <tr>
                        <?php
						$temp = $res_prod['image_url'];
						$temp = str_replace('["', "", $temp);
						$temp = str_replace('"]', "", $temp);
						?>
                        <td colspan="3" height="150" align="center" valign="top"><img src="<?php echo $temp;?>" width="90%" height="90%" /></td>
                        </tr>
                    <tr>
                        <td height="40" colspan="3" align="left" valign="middle" class="pricetext1"><?php echo $res_prod['product_name'];?></td>
                        </tr>
                    <tr>
                        <td width="3%">&nbsp;</td>
                        <td width="34%" class="text1">Category :</td>
                        <td width="63%" align="left" valign="middle" class="pricetext1"><?php echo $res_prod['category_name'];?></td>
                    </tr>
                    <!--tr>
                        <td>&nbsp;</td>
                        <td height="14" colspan="2" align="left" valign="top">
							<span class="text1">Dept:</span> 
							<span class="pricetext1"><?php   
															//echo $res_prod['product_name'];
															//$a = $res_prod['product_name'];
															//$b = explode(" ", $a);
															//echo end($b);
															
													?></span></td>
                    </tr-->
					
					<tr>
                        <td>&nbsp;</td>
                        <td height="14" colspan="2" align="left" valign="top">
							<span class="text1">Brand:</span> 
							<span class="pricetext1"><?php echo $res_prod['department'];?></span></td>
                    </tr>					
                    <tr>
                        <td>&nbsp;</td>
                        <td class="text1">Price :</td>
                        <td align="left"  class="pricetext1"><?php echo $res_prod['price'];?>&nbsp;<?php echo $res_prod['currency'];?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="pricetext1">&nbsp;</td>
                    </tr>
                </table></td>
            </tr>
        </table>
        <?php }?>
        </td>
        <td width="7%" align="left" valign="top" style="border-top:solid 1px; border-color:#999;">&nbsp;</td>
    </tr>
</table>
</body>
</html>