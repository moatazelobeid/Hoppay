<?php //echo 111;exit;
ob_start();
ob_end_flush();

ini_set('max_execution_time','5000000');
ini_set('memory_limit','1000000M');

include('db.php');

include('simple_html_dom.php');

$site_url = 'https://en-sa.namshi.com';
$temp_language = 'en';
$marchant_url = $site_url;
//mysql_query("truncate table mc_products_temp")or die(mysql_error());
// Create DOM from URL or file
$main_html = file_get_html($site_url);

foreach($main_html->find('ul.level_01') as $sub_cate_list_ul) {
	
	$main_sl = 0;
	foreach($sub_cate_list_ul->find('li a') as $sub_cate_list_ul_li) {
		if(isset($sub_cate_list_ul_li->find('span', 0)->plaintext)){
			
			$category = trim($sub_cate_list_ul_li->find('span', 0)->plaintext);
			
			// 0 = new products, 1 = women, 2 = men, 3 = sports 4 = Sports Shop
			if($category <> "" && ($main_sl <= 4)){
				
				if($main_sl == 1){// only for women
			
					$category_link = $site_url.trim($sub_cate_list_ul_li->href);
					
					// Create DOM from URL or file
					$html = file_get_html($category_link); 
					
					foreach($html->find('div.sub_navigation_container') as $sub_cate_list_ul) {
						
						foreach($sub_cate_list_ul->find('ul.sub_navigation') as $sub_cate_list_ul_li){
							
							$cate_sl = 0; // number of category in loop
							foreach($sub_cate_list_ul_li->find('li ul li a') as $sub_cate_list_last){
								
								$department = trim($sub_cate_list_last->plaintext);
								$product_list_url = $site_url.trim($sub_cate_list_last->href);
								
								// Create DOM from URL category list file
								$product_list_html = file_get_html($product_list_url);
								
								foreach($product_list_html->find('ul[id=catalog_listings]') as $product_list_ul){
									
									$prod_sl = 1;
									foreach($product_list_ul->find('li a.product_listing_link') as $product_list_last){
										//echo "<pre>";print_r($product_list_last);exit;
										
										
										$product_url = $site_url.$product_list_last->href;
										$image_url = '["'.$product_list_last->find('img',0)->data-src.'"]';
										
										// Create DOM from URL category list file
										
										$single_product_list_html = file_get_html($product_url);
										$product_full_name = trim($single_product_list_html->find('div.product_details h2',0)->plaintext);
										
										// Get Price and Currency from product details page
										$temp_price = trim($single_product_list_html->find('p.price span', 0)->plaintext);
										$temp2_price = explode(" ", $temp_price);
										$currency = trim($temp2_price[1]);
										$price = trim($temp2_price[0]);
										$product_description ="";
										$product_description = trim($single_product_list_html->find('div.info_content', 0)->plaintext);

										
										//echo "ss-".$product_full_name."-".$product_description; exit();
										# Get Product full name for SLUG
										if($product_full_name <> ""){
											$slug = create_url_slug($product_full_name);
										}
										# End Slug
										
										$sku = "";
										$color = "";
										foreach($single_product_list_html->find('table.product_details tbody') as $table_sku){						
											$sku = trim($table_sku->find('td', 0)->plaintext);
											$color = trim($table_sku->find('td', 1)->plaintext);
											//$product_description = $product_description."<br>SKU: ".$sku."<br>Color: ".$color."<br>";
$product_description = $product_description."<br>".trim($table_sku->find('th', 0)->plaintext)."  ".trim($table_sku->find('td', 0)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 1)->plaintext)."  ".trim($table_sku->find('td', 1)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 2)->plaintext)."  ".trim($table_sku->find('td', 2)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 3)->plaintext)."  ".trim($table_sku->find('td', 3)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 4)->plaintext)."  ".trim($table_sku->find('td', 4)->plaintext);
$product_description = trim($product_description);

										}
										
										# Check product exist in database for a particular marchant with product name
										/*$str_q = "select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'";
										$chk_qry = mysql_query($str_q);
										if(isset($chk_qry)){
											$chk_num = mysql_num_rows($chk_qry);
										}
										if($chk_num > 0){
											mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
										}*/
										#
														
										$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='3',marchant_url='$marchant_url',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',product_description='$product_description',category_name='$category',department='$department',currency='$currency',price='$price',image_url='$image_url',color='$color',lang=1";
										mysql_query($ins_query);
										
										//if($prod_sl > 2){	break;	}
										$prod_sl++;
									}
								}
								//if($cate_sl > 0){ break;}
								$cate_sl++;
							}
						}					
					}
				}
			}
			$main_sl++;
		}		
	}	
}

// Arabic version
$site_url = 'https://ar-sa.namshi.com';
$temp_language = 'ar';
$marchant_url = $site_url;

// Create DOM from URL or file
$main_html = file_get_html($site_url);

$main_sl = 0;

foreach($main_html->find('ul.level_01') as $sub_cate_list_ul) {
	
	$main_sl = 0;
	foreach($sub_cate_list_ul->find('li a') as $sub_cate_list_ul_li) {
		if(isset($sub_cate_list_ul_li->find('span', 0)->plaintext)){
			
			$category = trim($sub_cate_list_ul_li->find('span', 0)->plaintext);
			
			// 0 = new products, 1 = women, 2 = men, 3 = sports 4 = Sports Shop
			if($category <> "" && ($main_sl <= 4)){
				
				if($main_sl == 1){// only for women
			
					$category_link = $site_url.trim($sub_cate_list_ul_li->href);
					
					// Create DOM from URL or file
					$html = file_get_html($category_link); 
					
					foreach($html->find('div.sub_navigation_container') as $sub_cate_list_ul) {
						
						foreach($sub_cate_list_ul->find('ul.sub_navigation') as $sub_cate_list_ul_li){
							
							$cate_sl = 0; // number of category in loop
							foreach($sub_cate_list_ul_li->find('li ul li a') as $sub_cate_list_last){
								
								$department = trim($sub_cate_list_last->plaintext);
								$product_list_url = $site_url.trim($sub_cate_list_last->href);
								
								// Create DOM from URL category list file
								$product_list_html = file_get_html($product_list_url);
								
								foreach($product_list_html->find('ul[id=catalog_listings]') as $product_list_ul){
									
									$prod_sl = 1;
									foreach($product_list_ul->find('li a.product_listing_link') as $product_list_last){
										
										$product_url = $site_url.$product_list_last->href;
										$image_url = '["'.$product_list_last->find('img',0)->data-src.'"]';
										
										// Create DOM from URL category list file
										$single_product_list_html = file_get_html($product_url);
										$product_full_name = trim($single_product_list_html->find('div.product_details h2',0)->plaintext);
										
										// Get Price and Currency from product details page
										$temp_price = trim($single_product_list_html->find('p.price span', 0)->plaintext);
										$temp2_price = explode(" ", $temp_price);
										$currency = trim($temp2_price[1]);
										$price = trim($temp2_price[0]);
										$product_description ="";
										$product_description = trim($single_product_list_html->find('div.info_content', 0)->innertext);

										# Get Product full name for SLUG
										if($product_full_name <> ""){
											$slug = create_url_slug($product_full_name);
										}
										# End Slug
										
										$sku = "";
										$color = "";
										foreach($single_product_list_html->find('table.product_details tbody') as $table_sku){						
											$sku = trim($table_sku->find('td', 0)->plaintext);
											$color = trim($table_sku->find('td', 1)->plaintext);
											$product_description = $product_description."<br>".trim($table_sku->find('th', 0)->plaintext).":  ".trim($table_sku->find('td', 0)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 1)->plaintext)."  ".trim($table_sku->find('td', 1)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 2)->plaintext)."  ".trim($table_sku->find('td', 2)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 3)->plaintext)."  ".trim($table_sku->find('td', 3)->plaintext);
$product_description = $product_description."<br>".trim($table_sku->find('th', 4)->plaintext)."  ".trim($table_sku->find('td', 4)->plaintext);
$product_description = trim($product_description);

										}
										
										# Check product exist in database for a particular marchant with product name
										/*$str_q = "select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'";
										$chk_qry = mysql_query($str_q);
										if(isset($chk_qry)){
											$chk_num = mysql_num_rows($chk_qry);
										}
										if($chk_num > 0){
											mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
										}*/
										#
														
										$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='3',marchant_url='$marchant_url',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',product_description='$product_description',category_name='$category',department='$department',currency='$currency',price='$price',image_url='$image_url',color='$color',lang=2";
										mysql_query($ins_query);
										
										//if($prod_sl > 2){	break;	}
										$prod_sl++;
									}
								}
								//if($cate_sl > 0){ break;}
								$cate_sl++;
							}
						}					
					}
				}
			}
			$main_sl++;
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
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=3");
mysql_query("update mc_merchants_new set site_id=0");

?>