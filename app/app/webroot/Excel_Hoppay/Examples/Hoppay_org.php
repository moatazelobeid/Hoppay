<?php
ob_start();

ob_end_flush();
ini_set('max_execution_time','5000');

require_once 'db.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table width="600" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="61" align="center" valign="middle" bgcolor="#999900"><strong>Sl</strong></td>
    <td width="333" align="left" valign="middle" bgcolor="#999900"><strong>English Category</strong></td>
    <td width="198" align="left" valign="middle" bgcolor="#999900"><strong>Arabic</strong></td>
  </tr>
  <?php
  $sl = 1;
  $qry = mysql_query("select * from mc_product_category_langs where lang_id='1'");
	while($res = mysql_fetch_array($qry)){
		
		$ar_qry = mysql_query("select * from mc_product_category_langs where lang_id='2' And cat_id='$res[id]'");
		$ar_res = mysql_fetch_array($ar_qry);
		if($ar_res["category_name"] == ""){
	?>
  <tr>
    <td align="center" valign="middle"><?php echo $sl;?>-<?php echo $res["id"];?></td>
    <td align="left" valign="middle"><?php echo $res["category_name"];?></td>
    <td align="left" valign="middle"><?php echo $ar_res["category_name"];?></td>
  </tr>
  <?php $sl++; }}?>
</table>