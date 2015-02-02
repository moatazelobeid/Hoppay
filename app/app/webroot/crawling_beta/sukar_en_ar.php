<?php
ob_start();
ob_end_flush();
error_reporting(0);
ini_set('max_execution_time','99999999999');
ini_set('memory_limit','9999999999M');
include('db.php');
//mysql_query("truncate table mc_products_temp")or die(mysql_error());
include('simple_html_dom.php');
$site_url = 'http://www.sukar.com';
$temp_language = 'en';
$marchant_url = $site_url;
$marchant_logo = 'http://cf1.sukarcdn.com/static/ltr/en/images/sukar/brp_default.png';
$main_html = file_get_html($site_url."/ae-en/", true);
$main_sl = 0;
foreach($main_html->find('li.padding-li-6') as $sub_cate_list_ul) {
	$category = addslashes(trim($sub_cate_list_ul->find('a', 0)->plaintext));	
	# 0 = Accessories Week, 1 = women, 2 = men, 3 = Ethnic  4 = Boutique  5 = Home
	if($main_sl > 0){ 	
		# Check product exist in database for a particular marchant with product name	
		$res_cate = mysql_query("select id from mc_product_categories where slug='$category'");
		$category_id = $res_cate['id'];		
		$category_link = trim($sub_cate_list_ul->find('a', 0)->href);
		# Create DOM from URL or file
		$html = file_get_html($category_link, true);
		foreach($html->find('div.nhp-common') as $sub_cate_list_ul) {
			$cate_sl = 0; # number of category in loop
			foreach($sub_cate_list_ul->find('div.medium-6') as $sub_cate_list_last){
				$department = addslashes(trim($sub_cate_list_last->find('p.brand-info',0)->plaintext));
				$product_list_url = trim($sub_cate_list_last->find('a',0)->href);	
				# Create DOM from URL category list file
				$product_list_html = file_get_html($product_list_url, true);
				
				$offer_end_dt = $product_list_html->find('div.eventTime span',0)->plaintext; 
				$offer_end_dt = explode('Event Ends',$offer_end_dt);
				$offer_end_dt = explode('at',$offer_end_dt[1]);
				$offer_end_dt = date('Y-m-d', strtotime($offer_end_dt[1])); 
				$offer_start_dt = date('Y-m-d');
				
				
				foreach($product_list_html->find('div[id=available-items]') as $product_list_ul){	  
					$prod_sl = 1;
					foreach($product_list_ul->find('div.listing-items') as $product_list_last){		
						$product_url = $product_list_last->find('a',0)->href; 	echo $product_url."<br>";
						if(isset($product_list_last->find('span.bord-light-gray',0)->find('img',1)->src)){
							//$image_url = '["'.$product_list_last->find('span.bord-light-gray',0)->find('img',1)->src.'"]';
							$image_url = '"'.addslashes($product_list_last->find('span.bord-light-gray',0)->find('img',1)->src).'"';
						}
						$product_full_name = mysql_real_escape_string(trim($product_list_last->find('a span.item-name',0)->plaintext));
						$product_full_name = addslashes($product_full_name);
						# Get Product full name for SLUG
						if($product_full_name <> ""){
						  $slug = create_url_slug($product_full_name);
						}
						# End Slug
						# Get Price and Currency from product details page
						$temp_price = trim($product_list_last->find('span.item-price span', 0)->plaintext); 
						$temp2_price = explode(" ", $temp_price);
						$currency = trim($temp2_price[1]);
						$price = trim($temp2_price[0]);
						$price = str_replace( ',', '', $price );
						if(isset($product_list_last->find('span.item-price',0)->find('span.item-old-price',0)->plaintext)){
							$old_price = trim($product_list_last->find('span.item-price',0)->find('span.item-old-price',0)->plaintext);
							$old_price = explode(" ", $old_price);
							$old_price = trim($old_price[0]);
							$old_price = str_replace( ',', '', $old_price );
							$diff = round($old_price) - round($price);
							$percent = $diff/$old_price;
							$percent_friendly = number_format( $percent * 100, 2 ) . '%';
							$ins_qry_en = "INSERT INTO mc_offers set merchant_id='5', offer_title='$percent_friendly. Discount', discount='$percent_friendly',status=1, start_date='$offer_start_dt', end_date='$offer_end_dt'"; //echo $ins_qry;
							mysql_query($ins_qry_en);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); //echo $lst_insrt_id;exit;
							$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$id_en = $off_id_en["MaximumID"];
						}else{
							$id_en = ''; 
						}						
						$single_product_list_html = file_get_html($product_url, true);
						
						foreach($single_product_list_html->find('div[id=vip-thumbs]') as $thumb){
							foreach($thumb->find('div.thumb') as $timg){
								//echo $timg->find('img',0)->src."<br>";
								$thumb1 = '"'.addslashes(trim($timg->find('img',0)->src)).'"';
								$image_url = $image_url.",".$thumb1;
							}
						}
						$image_url = '['.$image_url.']';
						
						$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.infoHide',0)->plaintext));
						$product_description = addslashes($product_description);
						# Get Product Specification
						$specification = ''; $color = "";
						foreach($single_product_list_html->find('ul.item-attr-ul li') as $product_spe){
							if(trim($product_spe->plaintext) <> ""){
								$temp = explode(":", $product_spe->plaintext); 
								if(strtolower(trim($temp[0])) == 'brand'){
									$brand_nm = addslashes(trim($temp[1]));
									if(isset($brand_nm) && !empty($brand_nm)){
										$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
										$brand_id = mysql_fetch_array($chk_brand);		
										if(isset($brand_id) && !empty($brand_id)){ 
											$brand = $brand_id['id'];
										}else{ 
											$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm',status=1");
											$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
											$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
											$brand = $brand_id_en["MaximumID"];
											$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
										}					
									}else{
										$brand_nm = 'None';
										$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
										$brand_id = mysql_fetch_array($chk_brand);		
										if(isset($brand_id) && !empty($brand_id)){ 
											$brand = $brand_id['id'];
										}else{ 
											$inst = "INSERT INTO mc_product_brands set slug ='$brand_nm',status=1";
											$chk_brand = mysql_query($inst);
											$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
											$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
											$brand = $brand_id_en["MaximumID"];
											$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
										}	
									}
								}
								if(strtolower(trim($temp[0])) == 'color' || strtolower(trim($temp[0])) == 'Band Color'){
									//$color = trim($temp[1]);
									$specification = '"'.trim('Color').'":"'.trim($temp[1]).'"';
								}
								if(strtolower(trim($temp[0])) == 'Size'){
									//$size = trim($temp[1]);
									$specification = $specification.',"'.trim('Size').'":"'.trim($temp[1]).'"';
								}
								if(strtolower(trim($temp[0])) == 'Resolution' || strtolower(trim($temp[0])) == 'Display Resolution'){
									$specification = $specification.',"'.trim('Resolution').'":"'.trim($temp[1]).'"';
								}
								$specification = '{'.$specification.'}';
								
								/*if($specification == ''){
									//$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
									$specification = '"'.trim($temp[0]).'":"'.trim($temp[1]).'"';
								}else{
									$specification = $specification.',"'.trim($temp[0]).'":"'.trim($temp[1]).'"';
								}*/
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
						# Get Color from Product details page
						
						/*if(isset($single_product_list_html->find('div.variance-box',0)->plaintext)){
							$color = trim($single_product_list_html->find('div.variance-box',0)->plaintext);
						}*/
						
						# Check product exist in database for a particular marchant with product name
						/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
						$chk_num = mysql_num_rows($chk_qry);
						if($chk_num > 0){
							mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
						}*/
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error()); 
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='5',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category',category_id='$category_id',brand='$brand',department='$department',currency='$currency',price='$price',image_url='$image_url',color='$color',specification='$specification',product_description='$product_description',offer_id='$id_en',lang=1";
							mysql_query($ins_query);
						}
						//if($prod_sl > 2){ break;}
						$prod_sl++;
					}
				}
				//if($cate_sl > 2){ break;}
				$cate_sl++;
			}       
		}
	}
	$main_sl++;
}

// Arabic version
$site_url = 'http://www.sukar.com';
$temp_language = 'ar';
$marchant_url = $site_url;
$marchant_logo = 'http://cf1.sukarcdn.com/static/ltr/en/images/sukar/brp_default.png';
$main_html = file_get_html($site_url."/ae-ar/", true);
$main_sl = 0;
foreach($main_html->find('li.padding-li-7') as $sub_cate_list_ul) {	
	$category = addslashes(trim($sub_cate_list_ul->find('a', 0)->plaintext));	
	// 0 = Accessories Week, 1 = women, 2 = men, 3 = Ethnic  4 = Boutique  5 = Home
	if($main_sl > 0){ 		
		$category_link = trim($sub_cate_list_ul->find('a', 0)->href);		
		// Create DOM from URL or file
		$html = file_get_html($category_link, true);		
		foreach($html->find('div.nhp-common') as $sub_cate_list_ul) {			
			$cate_sl = 0; // number of category in loop
			foreach($sub_cate_list_ul->find('div.medium-6') as $sub_cate_list_last){				
				$department = addslashes(trim($sub_cate_list_last->find('p.brand-info',0)->plaintext));
				$product_list_url = trim($sub_cate_list_last->find('a',0)->href);				
				// Create DOM from URL category list file
				$product_list_html = file_get_html($product_list_url, true);

				$offer_end_dt = $product_list_html->find('div.eventTime span',0)->plaintext; 
				$offer_end_dt = explode('Event Ends',$offer_end_dt);
				$offer_end_dt = explode('at',$offer_end_dt[1]);
				$offer_end_dt = date('Y-m-d', strtotime($offer_end_dt[1])); 
				$offer_start_dt = date('Y-m-d');  
				
				foreach($product_list_html->find('div[id=available-items]') as $product_list_ul){					
					$prod_sl = 1;
					foreach($product_list_ul->find('div.listing-items') as $product_list_last){						
						$product_url = $product_list_last->find('a',0)->href;					
						if(isset($product_list_last->find('span.bord-light-gray',0)->find('img',1)->src)){
							//$image_url = '["'.$product_list_last->find('span.bord-light-gray',0)->find('img',1)->src.'"]';
							$image_url = '"'.addslashes($product_list_last->find('span.bord-light-gray',0)->find('img',1)->src).'"';
						}
						$product_full_name = mysql_real_escape_string(trim($product_list_last->find('a span.item-name',0)->plaintext));	
						$product_full_name = addslashes($product_full_name);
						# Get Product full name for SLUG
						if($product_full_name <> ""){
							$slug = create_url_slug($product_full_name);
						}
						# End Slug						
						// Get Price and Currency from product details page
						$temp_price = trim($product_list_last->find('span.item-price span', 0)->plaintext);	
						$temp2_price = explode(" ", $temp_price);
						$currency = trim($temp2_price[1]);
						$price = trim($temp2_price[0]);	
						$price = str_replace( ',', '', $price );
						if(isset($product_list_last->find('span.item-price',0)->find('span.item-old-price',0)->plaintext)){
							$old_price = trim($product_list_last->find('span.item-price',0)->find('span.item-old-price',0)->plaintext);
							$old_price = explode(" ", $old_price);
							$old_price = trim($old_price[0]);
							$old_price = str_replace( ',', '', $old_price );
							$diff = round($old_price) - round($price);
							$percent = $diff/$old_price;
							$percent_friendly = number_format( $percent * 100, 2 ) . '%';
							$ins_qry_en = "INSERT INTO mc_offers set merchant_id='5', offer_title='$percent_friendly. Discount', discount='$percent_friendly',status=1, start_date='$offer_start_dt', end_date='$offer_end_dt'"; //echo $ins_qry;
							mysql_query($ins_qry_en);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); //echo $lst_insrt_id;exit;
							$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$id_ar = $off_id_en["MaximumID"];
						}else{
							$id_ar = ''; 
						}		
						$single_product_list_html = file_get_html($product_url, true);
						foreach($single_product_list_html->find('div[id=vip-thumbs]') as $thumb){
							foreach($thumb->find('div.thumb') as $timg){
								//echo $timg->find('img',0)->src."<br>";
								$thumb1 = '"'.addslashes(trim($timg->find('img',0)->src)).'"';
								$image_url = $image_url.",".$thumb1;
							}
						}
						$image_url = '['.$image_url.']';
						$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.infoHide',0)->plaintext));
						$product_description = addslashes($product_description);
						$specification = ''; $color = "";
						foreach($single_product_list_html->find('ul.item-attr-ul li') as $product_spe){							
							if(trim($product_spe->plaintext) <> ""){
								$temp = explode(":", $product_spe->plaintext);
								if(strtolower(trim($temp[0])) == 'brand'){
									$brand_nm = trim($temp[1]);
									if(isset($brand_nm) && !empty($brand_nm)){
										$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
										$brand_id = mysql_fetch_array($chk_brand);		
										if(isset($brand_id) && !empty($brand_id)){ 
											$brand = $brand_id['id'];
										}else{ 
											$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm',status=1");
											$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
											$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
											$brand = $brand_id_en["MaximumID"];
											$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
										}					
									}else{
										$brand_nm = 'None';
										$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
										$brand_id = mysql_fetch_array($chk_brand);		
										if(isset($brand_id) && !empty($brand_id)){ 
											$brand = $brand_id['id'];
										}else{ 
											$inst = "INSERT INTO mc_product_brands set slug ='$brand_nm',status=1";
											$chk_brand = mysql_query($inst);
											$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
											$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
											$brand = $brand_id_en["MaximumID"];
											$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
										}	
									}
								}
								if(strtolower(trim($temp[0])) == 'color' || strtolower(trim($temp[0])) == 'Band Color'){
									//$color = trim($temp[1]);
									$specification = '"'.trim('Color').'":"'.trim($temp[1]).'"';
								}
								if(strtolower(trim($temp[0])) == 'Size'){
									//$size = trim($temp[1]);
									$specification = $specification.',"'.trim('Size').'":"'.trim($temp[1]).'"';
								}
								if(strtolower(trim($temp[0])) == 'Resolution' || strtolower(trim($temp[0])) == 'Display Resolution'){
									$specification = $specification.',"'.trim('Resolution').'":"'.trim($temp[1]).'"';
								}
								$specification = '{'.$specification.'}';
								/*if($specification == ''){
									$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
								  }else{
									  $specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
								  }*/
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);						
						/*if(isset($single_product_list_html->find('div.variance-box',0)->plaintext)){
							$color = trim($single_product_list_html->find('div.variance-box',0)->plaintext);
						}
						if(isset($single_product_list_html->find('div[id=colors_ar] a',0)->plaintext)){
							$color = $color.','.trim($single_product_list_html->find('div[id=colors_ar] a',0)->plaintext);
						}*/
						
						# Check product exist in database for a particular marchant with product name
						/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
						$chk_num = mysql_num_rows($chk_qry);
						if($chk_num > 0){
							mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
						}*/
						#
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error()); 
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='5',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category',brand='$brand',department='$department',currency='$currency',price='$price',image_url='$image_url',color='$color',specification='$specification',product_description='$product_description',offer_id='$id_ar',lang=2";
							mysql_query($ins_query);
						}
						//if($prod_sl > 1){ break;}
						$prod_sl++;
					}
				}
				//if($cate_sl > 0){ break;}
				$cate_sl++;
			}       
		}
	}
	$main_sl++;
}
# update crawl_end_date
mysql_query("update mc_merchants_new set crawl_end_date=now() where site_id > '0'");
mysql_query("update mc_merchants_new set site_id='0' where site_id > '0'");

// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=5");
mysql_query("update mc_merchants_new set site_id=0");

?>