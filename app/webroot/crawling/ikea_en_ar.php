<?php
ob_start();
ob_end_flush();

ini_set('max_execution_time','5000');
ini_set('memory_limit','1000M');

include('db.php');
//mysql_query("truncate table mc_products_temp")or die(mysql_error());
include('simple_html_dom.php');

$site_url = 'http://ar.ikea.com/sa/ar/';
$temp_language = 'ar';
$marchant_url = $site_url;

// Create DOM from URL or file
$all_cate_html = file_get_html($site_url, true); 

// 3 means images index of the webpage
$marchant_logo = trim($all_cate_html->find('img', 0)->src);

$all_cate_sl = 1;
foreach($all_cate_html->find('div.linkContainer') as $all_cate_list) {
	
	$cate_sl = 1;
	foreach($all_cate_list->find('a') as $all_cate_list_link) {
		
		$category_name = trim($all_cate_list_link->plaintext);
		$category_link = $all_cate_list_link->href.'series/';
		
		// Create DOM from URL or file
		$single_cate_url = $category_link;		
		$single_cate_html = file_get_html($single_cate_url, true);
		
		$prod_sl = 1;
		foreach($single_cate_html->find('div.allSeriesContainer') as $single_cate_list) {
					
			$department = $single_cate_list->find('span.categoryName',0)->plaintext;
			$product_list_url = $single_cate_list->find('a',0)->href;
			$product_list_html = file_get_html($product_list_url, true);
			
			$sl = 1;
			foreach($product_list_html->find('div.productDetails') as $product_list) {
				
				$product_page_url = '';
				if(isset($product_list->find('a',0)->href)){
					
					$product_url = $product_list->find('a',0)->href;
					$single_product_html = file_get_html($product_url, true);
					
					$temp_p_name = $single_product_html->find('div.productName',0)->plaintext;
					$product_full_name = trim($temp_p_name).' '.trim($single_product_html->find('div.productType',0)->plaintext);
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					// Get Price and Currency from product details page
					$temp_price = trim($single_product_html->find('span.packagePrice', 0)->plaintext);
					$temp_price2 = explode(" ", $temp_price);
					$currency = $temp_price2[0];
					$price = trim(str_replace($currency, "", $temp_price));
					//$price = trim(str_replace(",", "", $price));
					
					$image_url = '["'.trim($site_url.$single_product_html->find('img[id=productImg]', 0)->src).'"]';
					$product_description = mysql_real_escape_string(trim($single_product_html->find('div[id=custMaterials]', 0)->plaintext));
					$item_no = trim($single_product_html->find('div[id=itemNumber]', 0)->plaintext);
					
					// Color
					$color = '';
					foreach($single_product_html->find('select[id=dropcolor_1_00018] option') as $color_list) {
						if($color == ''){
							$color = trim($color_list->plaintext);
						}else{
							$color = $color.",".trim($color_list->plaintext);
						}
					}
					// Specification
					$specification = trim($single_product_html->find('div[id=metric]', 0)->plaintext);
					if($specification <> ""){
						//$specification = '<br>'.$specification.trim($single_product_html->find('div[id=metric]', 0)->plaintext);
					}
					// End Specification
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
					}*/
					#
					
					// query string
					$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='4',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',product_description='$product_description',slug='$slug',product_url='$product_url',category_name='$category_name',department='$department',currency='$currency',price='$price',image_url='$image_url',specification='$specification',color='$color',item_no='$item_no',lang=2";
					mysql_query($ins_query);
				}
				
				// Number of product has to be inserted in database
				//if($sl > 2){ break; }
				$sl++;
			}
			//if($prod_sl > 0){ break;}
			$prod_sl++;
		}
		//if($cate_sl > 0){ break;}
		$cate_sl++;
	}
	
	//if($all_cate_sl > 2){
	//if($all_cate_sl > 2){ break;}
	$all_cate_sl++;
}

$site_url = 'http://www.ikea.com';
$language = 'us/en/';
$temp_language = 'en';
$marchant_url = $site_url;

// Create DOM from URL or file
$all_cate_html = file_get_html($site_url.'/'.$language); 

// 3 means images index of the webpage
$marchant_logo = $site_url.str_replace("../","",$all_cate_html->find('img', 0)->src);

$all_cate_sl = 1;
foreach($all_cate_html->find('div.linkContainer') as $all_cate_list) {
	
	$cate_sl = 1;
	foreach($all_cate_list->find('a') as $all_cate_list_link) {
		
		$category_name = trim($all_cate_list_link->plaintext);
		$category_link = $all_cate_list_link->href.'series/';
		
		// Create DOM from URL or file
		$single_cate_url = $site_url.$category_link;		
		$single_cate_html = file_get_html($single_cate_url);
		
		$prod_sl = 1;
		foreach($single_cate_html->find('div.allSeriesContainer') as $single_cate_list) {
					
			$department = $single_cate_list->find('span.categoryName',0)->plaintext;
			$product_list_url = $site_url.$single_cate_list->find('a',0)->href;
			$product_list_html = file_get_html($product_list_url, true);
			
			$sl = 1;
			foreach($product_list_html->find('div.productDetails') as $product_list) {
				
				$product_page_url = '';
				if(isset($product_list->find('a',0)->href)){
					
					$product_url = $site_url.$product_list->find('a',0)->href;
					$single_product_html = file_get_html($product_url, true);
					
					$temp_p_name = $single_product_html->find('div.productName',0)->plaintext;
					$product_full_name = trim($temp_p_name).' '.trim($single_product_html->find('div.productType',0)->plaintext);
					
					# Get Product full name for SLUG
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					# End Slug
					
					// Get Price and Currency from product details page
					$temp_price = trim($single_product_html->find('span.packagePrice', 0)->plaintext);
					$currency = trim($temp_price[0]);
					$price = trim(str_replace($currency, "", $temp_price));
					$price = trim(str_replace(",", "", $price));
					
					$image_url = '["'.trim($site_url.$single_product_html->find('img[id=productImg]', 0)->src).'"]';
					$product_description = mysql_real_escape_string(trim($single_product_html->find('div[id=custMaterials]', 0)->plaintext));
					$item_no = trim($single_product_html->find('div[id=itemNumber]', 0)->plaintext);
					
					// Color
					$color = '';
					foreach($single_product_html->find('select[id=dropcolor_1_00018] option') as $color_list) {
						if($color == ''){
							$color = trim($color_list->plaintext);
						}else{
							$color = $color.",".trim($color_list->plaintext);
						}
					}
					// Specification
					$specification = trim($single_product_html->find('div[id=imperial]', 0)->plaintext);
					if($specification <> ""){
						$specification = '<br>'.$specification.trim($single_product_html->find('div[id=metric]', 0)->plaintext);
					}
					// End Specification
					
					# Check product exist in database for a particular marchant with product name
					/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
					$chk_num = mysql_num_rows($chk_qry);
					if($chk_num > 0){
						mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
					}*/
					#
					
					// query string
					$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='4',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',product_description='$product_description',slug='$slug',product_url='$product_url',category_name='$category_name',department='$department',currency='$currency',price='$price',image_url='$image_url',specification='$specification',color='$color',item_no='$item_no',lang=1";
					mysql_query($ins_query);
					
				}
				
				// Number of product has to be inserted in database
				//if($sl > 2){ break; }
				$sl++;
			}
			//if($prod_sl > 0){ break;}
			$prod_sl++;
		}
		//if($cate_sl > 0){ break;}
		$cate_sl++;
	}
	
	//if($all_cate_sl > 2){
	//if($all_cate_sl > 2){ break;}
	$all_cate_sl++;
}




# update crawl_end_date
mysql_query("update mc_merchants_new set crawl_end_date=now() where site_id > '0'");
mysql_query("update mc_merchants_new set site_id='0' where site_id > '0'");

// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=4");
mysql_query("update mc_merchants_new set site_id=0");

?>