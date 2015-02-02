<?php
ob_start();

include('db.php');

if(isset($_REQUEST['site_id'])){
	
	$site_id = $_REQUEST['site_id'];
	$retailer_id="";
	
	if($site_id == 1){
		$retailer_id = 23; // souq
	}elseif($site_id == 2){
		$retailer_id = 18; // markavip
	}elseif($site_id == 3){
		$retailer_id = 13; // namshi
	}elseif($site_id == 4){
		$retailer_id = 34; // ikea
	}elseif($site_id == 5){
		$retailer_id = 19; // sukar
	}elseif($site_id == 6){
		$retailer_id = 51; // extrastores
	}

	//////////////////////////////////////////////////
	$rs=mysql_query("select * from mc_products_temp")or die(mysql_error());
	while($row=mysql_fetch_array($rs)){
	$category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];

	/////DEPARTMENT//////////////////////////////////////////
	$rs1=mysql_query("select * from mc_product_category_langs where category_name = '".$department."' and lang_id = '".$lang."'")or die(mysql_error());
	if(mysql_num_rows($rs1) <= 0){
	//echo "department: ".$department."- Lang ".$lang."<br>";
	//echo "insert into mc_product_categories values(null,'".create_url_slug($department)."','','',0,0,0,0,1)";
	mysql_query("insert into mc_product_categories values(null,'".create_url_slug($department)."','','',0,0,0,0,1)")or die(mysql_error());
	$rs2=mysql_query("select id from mc_product_categories where slug = '".create_url_slug($department)."'")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$department_id = $row2[0];
	}
	mysql_query("insert into mc_product_category_langs values(null,$department_id,$lang,'".addslashes($department)."','".addslashes($department)."','','',1)")or die(mysql_error());
	}else{
	$rs2=mysql_query("select id from mc_product_categories where slug = '".create_url_slug($department)."'")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$department_id = $row2[0];
	}
	}

	////CATEGORY//////////////////////////////////////////////
	$rs1=mysql_query("select * from mc_product_categories where slug = '".create_url_slug($category_name)."' and parent_id = $department_id")or die(mysql_error());
	if(mysql_num_rows($rs1) <= 0){
	mysql_query("insert into mc_product_categories values(null,'".create_url_slug($category_name)."','','',$department_id,0,0,0,1)")or die(mysql_error());
	$rs2=mysql_query("select id from mc_product_categories where slug = '".create_url_slug($category_name)."' and parent_id = $department_id")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$cat_id = $row2[0];
	}
	mysql_query("insert into mc_product_category_langs values(null,$cat_id,$lang,'".addslashes($category_name)."','".addslashes($category_name)."','','',1)")or die(mysql_error());
	}else{
	$rs2=mysql_query("select id from mc_product_categories where slug = '".create_url_slug($category_name)."' and parent_id = $department_id")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$cat_id = $row2[0];
	}
	}
	////PRODUCTS/////////////////////////////////////////////////////////////////
	$product_id="";
	$product_name="";
	$product_slug="";
	
	$product_name=$row["product_name"];
	$product_slug=$row["slug"];
	
	$rs1=mysql_query("select * from mc_products where category_id = $cat_id and slug = '".create_url_slug($product_name)."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if(mysql_num_rows($rs1) <= 0){
	
	if($retailer_id == 23){
	$price=round(1.02 * ($row["price"]));
	}
	
	mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".create_url_slug($product_name)."',
	'".$row["product_url"]."',
	$cat_id,$retailer_id,'".$price."','SAR',
	'".$row["image_url"]."','".$row["brand"]."',1,0,now())")or die(mysql_error());
	
	$rs2=mysql_query("select id from mc_products where category_id = $cat_id and slug = '".create_url_slug($product_name)."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$product_id=$row2[0];
	}
	
	mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());
	
	}else{
	$price=0;
	
	if($retailer_id == 23){
	$price=round(1.02 * ($row["price"]));
	}
	
	mysql_query("update mc_products set 
	slug= '".create_url_slug($product_name)."',
	product_url='".$row["product_url"]."',
	category_id=$cat_id,
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$row["brand"]."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = $cat_id and slug = '".create_url_slug($product_name)."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	
	$rs2=mysql_query("select id from mc_products where category_id = $cat_id and slug = '".create_url_slug($product_name)."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row2=mysql_fetch_row($rs2)){
	$product_id=$row2[0];
	}
	
	mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = $product_id and lang_id=$lang")or die(mysql_error());
	
	}
	
	/////////////////////////////////////////////////////////////////////////////
	}
		}
	/////////////////////////////////////////////////
	//mysql_query("update mc_merchants_new set site_id = 0")or die(mysql_error());
	//mysql_query("truncate table mc_products_temp")or die(mysql_error());

function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
  $slug =  mb_strtolower($slug, 'UTF-8');
 return $slug;
  //return strtolower($slug);
}
?>