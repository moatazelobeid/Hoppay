<?php
session_start(); ob_start();

ini_set('max_execution_time','8000000');
ini_set('memory_limit','100000M');

include('db.php');

include('simple_html_dom.php');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Language" content="ar" />
<?php
//mysql_query("truncate table mc_products_temp");
$site_url = 'http://uae.souq.com';
$temp_language = 'en';
$marchant_url = $site_url;

$main_html = file_get_html($site_url."/ae-en/shop-all-categories/c/", true);

// 1 means images index of the webpage
$marchant_logo = $main_html->find('img', 1)->src;

foreach($main_html->find('div.marr-314') as $sub_first) {
	
	foreach($sub_first->find('div h4') as $sub_h4) {
		$department="";
		$department = trim($sub_h4->plaintext);
		
		$sl = 1;
		foreach($sub_first->find('ul li a') as $sub_cate_list_ul) {
		$image_url="";
					$product_full_name="";
					$product_url="";
					$slug="";
					$currency="";
					$price="";
					$product_description="";
					$specification="";
			$category = $sub_cate_list_ul->plaintext;
			$product_list_url = $sub_cate_list_ul->href.'?page=1';
			
			$html = file_get_html($product_list_url, true);
	
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				
				$prod_sl = 1;
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					
					$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]';
					$product_full_name = $sub_sec->find('a', 1)->plaintext;
					$product_url = $sub_sec->find('a', 0)->href;
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					// Get Price and Currency from product details page
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					
					$single_product_list_html = file_get_html($product_url, true);
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
			
			$product_description =addslashes($product_description);
					
					$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						
						foreach($product_spe->find('tr') as $product_spe_tr){
							
							$temp = explode(":", $product_spe_tr->plaintext);
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
					}
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					}
					*/
										$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='".$department."',category_name='$category',currency='$currency',price='$price',image_url='$image_url',specification='$specification',product_description='$product_description',lang=1";
					mysql_query($ins_query);
					
					//if($prod_sl > 10){ break; }
					$prod_sl++;
				}
			}
			
			//if($sl > 0){ break; }
			$sl++;
		}
	}
}


// Arabic version
$site_url = 'http://uae.souq.com';
$temp_language = 'ar';
$marchant_url = $site_url;

$main_html = file_get_html($site_url."/ae-ar/shop-all-categories/c/", true);

// 1 means images index of the webpage
$marchant_logo = $main_html->find('img', 1)->src;

foreach($main_html->find('div.marr-314') as $sub_first) {
	
	foreach($sub_first->find('div h4') as $sub_h4) {
		$department="";
		$department = trim($sub_h4->plaintext);
		
		$sl = 1;
		foreach($sub_first->find('ul li a') as $sub_cate_list_ul) {
		
			$category = $sub_cate_list_ul->plaintext;
			$product_list_url = $sub_cate_list_ul->href.'?page=1';
			
			$html = file_get_html($product_list_url, true);
	
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				
				$prod_sl = 1;
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$image_url="";
					$product_full_name="";
					$product_url="";
					$slug="";
					$currency="";
					$price="";
					$product_description="";
					$specification="";
					$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]';
					$product_full_name = $sub_sec->find('a', 1)->plaintext;
					$product_url = $sub_sec->find('a', 0)->href;
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					// Get Price and Currency from product details page
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$currency = trim($sub_sec->find('div.small-price span.currency', 0)->plaintext);
								
					$single_product_list_html = file_get_html($product_url, true);
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					
					$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						
						foreach($product_spe->find('tr') as $product_spe_tr){
							
							$temp = explode(":", $product_spe_tr->plaintext);
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
					}
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					}*/
					#
					
					$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category',currency='$currency',price='$price',image_url='$image_url',specification='$specification',product_description='$product_description',lang=2,department='".$department."'";
					mysql_query($ins_query);
					
					//if($prod_sl > 0){ break; }
					$prod_sl++;
				}
			}
			
			//if($sl > 0){ break; }
			$sl++;
		}
	}
}

# update crawl_end_date
mysql_query("update mc_merchants_new set crawl_end_date=now() where site_id > '0'");
mysql_query("update mc_merchants_new set site_id='0' where site_id > '0'");

// cron sucess
//mail("maas_kishor@yahoo.in","souq cron sucess","souq hello cron");

// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=1");
mysql_query("update mc_merchants_new set site_id=0");
?>