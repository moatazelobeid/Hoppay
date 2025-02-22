<?php
ob_start();
ob_end_flush();

ini_set('max_execution_time','800000');
ini_set('memory_limit','100000M');

include('db.php');
//mysql_query("truncate table mc_products_temp")or die(mysql_error());
include('simple_html_dom.php');

$site_url = 'http://markavip.com';
$language = 'sa';
$temp_language = 'en';
$marchant_url = $site_url;
$marchant_logo = 'http://assets.ak.markavip-cdn.com/skin/frontend/inception/default/images/logo.png';

$all_category = array("women","men","children","electronics","home");
//$all_category = array("women");
foreach($all_category as $temp_cate){
	
	// Create DOM from URL or file
	$html = file_get_html($site_url.'/'.$language.'/'.$temp_cate.'/?___lang='.$temp_language);
		
	foreach($html->find('div.group-events') as $cate_list) {
		
		foreach($cate_list->find('a') as $each_cate_list) { 					
			$category_name = $temp_cate; 
			$department = $each_cate_list->find('strong.title', 0)->plaintext; 
			$product_list_url = trim($each_cate_list->href);
			
			// Get product list page
			$prod_list_html = file_get_html($product_list_url);
			
			foreach($prod_list_html->find('ul.products-grid') as $all_product_list) {
				
				$prod_sl = 1;
				foreach($all_product_list->find('a') as $all_product_list_link) {
					
					$product_url = $all_product_list_link->href;
					
					// Get single product page
					$single_prod_html = file_get_html($product_url);  
					
					$product_full_name = $single_prod_html->find('h1',0)->plaintext;
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					$currency = trim($single_prod_html->find('span.sign',0)->plaintext);
					$price = trim($single_prod_html->find('span.digits',0)->plaintext);
					$product_description = mysql_real_escape_string(trim($single_prod_html->find('div.std',0)->plaintext));					
					$image_url = '["'.$single_prod_html->find('div.product-img-box', 0)->find('a', 0)->href.'"]';
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and category_name='$category_name' and department='$department' and language='$temp_language'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and category_name='$category_name' and department='$department' and language='$temp_language'");
					}*/
					#
					
					// query string
					$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='2',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',product_description='$product_description',category_name='$category_name',brand='$department',currency='$currency',price='$price',image_url='$image_url',lang=1";
					mysql_query($ins_query);
					/*if($prod_sl == 2){ // Number of products
						echo "Crawl Completed.";
						break;
					}*/
					$prod_sl++;
				}
			}
		}
	}
}


// Arabic version
$site_url = 'http://markavip.com';
$language = 'sa';
$temp_language = 'ar';
$marchant_url = $site_url;
$marchant_logo = 'http://assets.ak.markavip-cdn.com/skin/frontend/inception/default/images/logo.png';

$all_category = array("women","men","children","electronics","home");
//$all_category = array("women");
foreach($all_category as $temp_cate){
	
	// Create DOM from URL or file
	$html = file_get_html($site_url.'/'.$language.'/'.$temp_cate.'/?___lang='.$temp_language);
	
	foreach($html->find('div.group-events') as $cate_list) {
		
		foreach($cate_list->find('a') as $each_cate_list) {
									
			$category_name = $temp_cate;
			$department = $each_cate_list->find('strong.title', 0)->plaintext;
			$product_list_url = trim($each_cate_list->href).'?___lang='.$temp_language;
			
			// Get product list page
			$prod_list_html = file_get_html($product_list_url);
			
			foreach($prod_list_html->find('ul.products-grid') as $all_product_list) {
				
				$prod_sl = 1;
				foreach($all_product_list->find('a') as $all_product_list_link) {
					
					$product_url = $all_product_list_link->href.'?___lang='.$temp_language;
					
					// Get single product page
					$single_prod_html = file_get_html($product_url);
					
					$product_full_name = $single_prod_html->find('h1',0)->plaintext;
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					$currency = trim($single_prod_html->find('span.sign',0)->plaintext);
					$price = trim($single_prod_html->find('span.digits',0)->plaintext);
					$product_description = mysql_real_escape_string(trim($single_prod_html->find('div.std',0)->plaintext));					
					$image_url = '["'.$single_prod_html->find('div.product-img-box', 0)->find('a', 0)->href.'"]';
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					}*/
					#
					
					# query string
					$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='2',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',product_description='$product_description',category_name='$category_name',brand='$department',currency='$currency',price='$price',image_url='$image_url',lang=2";
					mysql_query($ins_query);
					/*if($prod_sl == 2){ // Number of products
					break;
					}*/
					$prod_sl++;
				}
			}
		}
	}
}

# update crawl_end_date
mysql_query("update mc_merchants_new set crawl_end_date=now() where site_id > '0'");
mysql_query("update mc_merchants_new set site_id='0' where site_id > '0'");

// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=2");
mysql_query("update mc_merchants_new set site_id=0");
?>