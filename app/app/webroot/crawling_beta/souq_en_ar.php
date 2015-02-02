<?php
session_start(); ob_start();
error_reporting(0);
ini_set('max_execution_time','99999999999');
ini_set('memory_limit','9999999999M');
include('db.php');
include('simple_html_dom.php');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Language" content="ar" />
<?php
$site_url = 'http://uae.souq.com';
$temp_language = 'en';
$marchant_url = $site_url;
$main_html = file_get_html($site_url."/ae-en/shop-all-categories/c/", true);
$marchant_logo = $main_html->find('img', 1)->src;

$dept = array("Clothing & Accessories"); 
$categories = array( "Jackets & Coats"=>"http://uae.souq.com/ae-en/jacket-coats/l/","Accessories"=>"http://uae.souq.com/ae-en/accessories/l/", "Athletic Wear"=>"http://uae.souq.com/ae-en/athletic-wear/l/", "Baby Clothes"=>"http://uae.souq.com/ae-en/baby-clothes/l/", "Dresses"=>"http://uae.souq.com/ae-en/dresses/l/", "Eyewear"=>"http://uae.souq.com/ae-en/eyewear/l/", "Pants"=>"http://uae.souq.com/ae-en/pants/l/", "Skirts"=>"http://uae.souq.com/ae-en/skirts/l/", "Sleepwear"=>"http://uae.souq.com/ae-en/sleepwears/l/", "Swimwear"=>"http://uae.souq.com/ae-en/swimwears/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; //echo $result;exit;
		$no_page = floor($result/$tot); //echo $no_page;exit;
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; //echo $html;exit;
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				//$prod_sl = 1;
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';				
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
									
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}


$dept = array("Books"); 
$categories = array("Books & Manuscripts"=>"http://uae.souq.com/ae-en/books-manuscript/l/", "Comic & Graphic Novels"=>"http://uae.souq.com/ae-en/comic-graphic-novel/l/", "Educational Books"=>"http://uae.souq.com/ae-en/educational-book/l/", "Fiction & Literature"=>"http://uae.souq.com/ae-en/fiction-literature/l/", "General Books"=>"http://uae.souq.com/ae-en/books/l/", "Kids Books"=>"http://uae.souq.com/ae-en/kids-book/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Coins, Stamps & Paper money"); 
$categories = array("Coins"=>"http://uae.souq.com/ae-en/coins/l/", "Stamps"=>"http://uae.souq.com/ae-en/stamps/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Games & Toys"); 
$categories = array("Game Consoles"=>"http://uae.souq.com/ae-en/games-console/l/", "Game Gadgets & Accessories"=>"http://uae.souq.com/ae-en/games-console-accessories/l/", "Toys"=>"http://uae.souq.com/ae-en/toys/l/", "Video Games"=>"http://uae.souq.com/ae-en/games/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}		


$dept = array("Mobiles"); 
$categories = array("Mobile Phones"=>"http://uae.souq.com/ae-en/mobile-phone/sony/a-7/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Shoes & Bags"); 
$categories = array("Backpacks"=>"http://uae.souq.com/ae-en/backpacks/l/","Boots"=>"http://uae.souq.com/ae-en/boots/l/","Business Bags"=>"http://uae.souq.com/ae-en/business-bags/l/","Casual & Formal Shoes"=>"http://uae.souq.com/ae-en/shoes/l/","Handbags"=>"http://uae.souq.com/ae-en/handbags/l/","Luggage"=>"http://uae.souq.com/ae-en/luggage/l/","Messenger Bags"=>"http://uae.souq.com/ae-en/messenger-bags/l/","Sandals"=>"http://uae.souq.com/ae-en/sandals/l/","School Bags"=>"http://uae.souq.com/ae-en/school-bags/l/","Slippers"=>"http://uae.souq.com/ae-en/slippers/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
				
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}		



$dept = array("Jewelry & Accessories"); 
$categories = array("Necklaces, Pendants & Charms"=>"http://uae.souq.com/ae-en/necklace-pendant/l/","Rings"=>"http://uae.souq.com/ae-en/rings/l/","Earrings"=>"http://uae.souq.com/ae-en/earrings/l/","Bracelets"=>"http://uae.souq.com/ae-en/bracelets/l/","Men's Jewelry"=>"http://uae.souq.com/ae-en/men-jewleries/l/","Loose Gemstones & Diamonds"=>"http://uae.souq.com/ae-en/loose-gemstones-diamond/l/","Jewelry Accessories"=>"http://uae.souq.com/ae-en/jewelry-accessories/l/","Jewelry Sets"=>"http://uae.souq.com/ae-en/jewelry-set/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Watches & Accessories"); 
$categories = array("Watch Accessories"=>"http://uae.souq.com/ae-en/watch-accessories/l/","Watches"=>"http://uae.souq.com/ae-en/watches/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Office Products & Supplies"); 
$categories = array("Ink & Toner Cartridges"=>"http://uae.souq.com/ae-en/ink-cartridges/l/","Multifunctional Devices"=>"http://uae.souq.com/ae-en/multifunction-devices/l/","Office Equipment"=>"http://uae.souq.com/ae-en/office-equipment/l/","Office Supplies"=>"http://uae.souq.com/ae-en/office-supplies/l/","Printers"=>"http://uae.souq.com/ae-en/printer/l/","Stationary"=>"http://uae.souq.com/ae-en/stationary/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	


$dept = array("Home, Kitchen & Garden"); 
$categories = array("Kitchen & Dining Tools"=>"http://uae.souq.com/ae-en/kitchen-dining/l/","Home Supplies"=>"http://uae.souq.com/ae-en/home-supplies/l/","Vacuum Cleaners"=>"http://uae.souq.com/ae-en/vacuum-cleaner/l/","Hot Beverage Makers"=>"http://uae.souq.com/ae-en/hot-beverage-maker/l/","Kitchen Scales"=>"http://uae.souq.com/ae-en/kitchen-scale/l/","Cooking Sets"=>"http://uae.souq.com/ae-en/cooking-set/l/","Air Treatment"=>"http://uae.souq.com/ae-en/air-treatment/l/","Steam Cleaners"=>"http://uae.souq.com/ae-en/steam-cleaner/l/","Small Appliances"=>"http://uae.souq.com/ae-en/small-appliance/l/","Power Tools"=>"http://uae.souq.com/ae-en/power-tool/l/","Smoking Accessories"=>"http://uae.souq.com/ae-en/smoking-accessories/l/","Hand Tools"=>"http://uae.souq.com/ae-en/hand-tool/l/","Barbecue Tools & Grill Accessories"=>"http://uae.souq.com/ae-en/barbecue-tool-grill-accessories/l/","Clocks & Compasses"=>"http://uae.souq.com/ae-en/clock-compasses/l/","Cabinets"=>"http://uae.souq.com/ae-en/cabinet/l/","Chairs"=>"http://uae.souq.com/ae-en/chair-bench/l/","Lamps"=>"http://uae.souq.com/ae-en/lamp/l/","Interior Decoration"=>"http://uae.souq.com/ae-en/home-decor/l/","Rugs & Carpets"=>"http://uae.souq.com/ae-en/rugs-carpets/l/","Bedding Supplies"=>"http://uae.souq.com/ae-en/bedding/l/","Bathroom Supplies"=>"http://uae.souq.com/ae-en/bathroom-equipment/l/","Garden Decoration"=>"http://uae.souq.com/ae-en/garden-decoration/l/","Garden Lighting"=>"http://uae.souq.com/ae-en/garden-light/l/", "Pet Supplies"=>"http://uae.souq.com/ae-en/pet-supplies/l/","Gardening & Watering Supplies"=>"http://uae.souq.com/ae-en/garden-equipment-watering/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Electronics"); 
$categories = array("Rechargeable Batteries"=>"http://uae.souq.com/ae-en/rechargeable-batteries/l/","VCD, VCP and VCR Players"=>"http://uae.souq.com/ae-en/vcd-vcp-vcr-player/l/","TV & Satellite Accessories"=>"http://uae.souq.com/ae-en/tv-satellite-accessories/l/","Stereo Systems & Equalizers"=>"http://uae.souq.com/ae-en/stereo-system-equalizer/l/","Security & Surveillance Systems"=>"http://uae.souq.com/ae-en/security-surveillance-system/l/","Recording & Studio Equipment"=>"http://uae.souq.com/ae-en/recording-studio-equipment/l/","MP3 & MP4 Players"=>"http://uae.souq.com/ae-en/mp3-player/l/","Home Video Accessories"=>"http://uae.souq.com/ae-en/video-accessories/l/","E-Book Readers"=>"http://uae.souq.com/ae-en/ebook-reader/l/","Clock Radios"=>"http://uae.souq.com/ae-en/clock-radio/l/","CD Recording Media"=>"http://uae.souq.com/ae-en/cd-recording-media/l/","Camera & Camcorder Accessories"=>"http://uae.souq.com/ae-en/camera-camcorder-accessories/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Baby"); 
$categories = array("Baby Clothes"=>"http://uae.souq.com/ae-en/baby-clothes/l/","Baby Safety & Health"=>"http://uae.souq.com/ae-en/baby-safety-health/l/","Baby Toys and Accessories"=>"http://uae.souq.com/ae-en/baby-toy-accessories/l/","Baby Gear"=>"http://uae.souq.com/ae-en/baby-gear/l/","Baby Gift Sets"=>"http://uae.souq.com/ae-en/baby-gift-set/l/","Baby Accessories"=>"http://uae.souq.com/ae-en/baby-accessories/l/","Feeding"=>"http://uae.souq.com/ae-en/feeding-diapering-bathing/l/","Diapers"=>"http://uae.souq.com/ae-en/diapers/l/","Baby Bath & Skincare"=>"http://uae.souq.com/ae-en/baby-bath-skin-care/l/","Baby Bags"=>"http://uae.souq.com/ae-en/baby-bag/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Sports & Outdoors"); 
$categories = array("GPS Receiver"=>"http://uae.souq.com/ae-en/gps-receiver/l/","Sporting Goods"=>"http://uae.souq.com/ae-en/sporting-goods/l/","Camping Goods"=>"http://uae.souq.com/ae-en/camping-goods/l/","Fitness Technology"=>"http://uae.souq.com/ae-en/fitness_technology/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Music & Movies"); 
$categories = array("CDs"=>"http://uae.souq.com/ae-en/music-cd/l/","Movies, Plays & Series"=>"http://uae.souq.com/ae-en/movies-plays-series/l/","Musical Instruments Accessories"=>"http://uae.souq.com/ae-en/musical-instrument-parts/l/","Musical Instruments"=>"http://uae.souq.com/ae-en/musical-instrument/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Health & Beauty"); 
$categories = array("Beauty Tools & Accessories"=>"http://uae.souq.com/ae-en/beauty-tools-accessories/l/","Dental Care"=>"http://uae.souq.com/ae-en/dental-care/l/","Food Supplements & Nutrition"=>"http://uae.souq.com/ae-en/food-supplement/l/","Hair Electronics"=>"http://uae.souq.com/ae-en/hair_electronics/l/","Men's Grooming"=>"http://uae.souq.com/ae-en/men-grooming/l/","Natural Nutrition Products"=>"http://uae.souq.com/ae-en/natural-nutrition-products/l/","Personal Care"=>"http://uae.souq.com/ae-en/health-personal-care/l/","Personal Scales"=>"http://uae.souq.com/ae-en/personal-scale/l/","Shavers & Hair Removals"=>"http://uae.souq.com/ae-en/electrical-personal-machine/l/","Skin Care"=>"http://uae.souq.com/ae-en/skin-care/l/","Vitamins & Minerals"=>"http://uae.souq.com/ae-en/vitamin-mineral/l/","Wigs"=>"http://uae.souq.com/ae-en/wigs/l/","Bath & Body"=>"http://uae.souq.com/ae-en/bath-body/l/","Beauty Gifts Sets"=>"http://uae.souq.com/ae-en/beauty-gift-set/l/","Hair Care"=>"http://uae.souq.com/ae-en/hair-care/l/","Makeup"=>"http://uae.souq.com/ae-en/makeup/l/","Perfumes & Fragrances"=>"http://uae.souq.com/ae-en/perfumes-fragrances/l/","Sports Nutrition"=>"http://uae.souq.com/ae-en/sport-nutrition/l/","Small Medical Equipment"=>"http://uae.souq.com/ae-en/small-medical-equipment/l/","Digital Fever Thermometers"=>"http://uae.souq.com/ae-en/digital-fever-thermometer/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Computers & Networking"); 
$categories = array("Card Readers & Writers"=>"http://uae.souq.com/ae-en/card-reader-writer/l/","Computer Monitors"=>"http://uae.souq.com/ae-en/computer-monitor/l/","Cooling Pads"=>"http://uae.souq.com/ae-en/cooling-pad/l/","Memory Modules"=>"http://uae.souq.com/ae-en/usb-drive-memory/l/","Optical Drives"=>"http://uae.souq.com/ae-en/optical-drive/l/","Desktop PCs"=>"http://uae.souq.com/ae-en/computer/l/","Servers"=>"http://uae.souq.com/ae-en/server/l/","Webcams"=>"http://uae.souq.com/ae-en/webcam/l/","Video Cards"=>"http://uae.souq.com/ae-en/video-card/l/","CPUs"=>"http://uae.souq.com/ae-en/cpu-ram/l/","Power Supplies"=>"http://uae.souq.com/ae-en/power-supply/l/","Sound Cards"=>"http://uae.souq.com/ae-en/sound-card/l/","Software"=>"http://uae.souq.com/ae-en/software/l/","Media Gateways"=>"http://uae.souq.com/ae-en/media-gateway/l/","Tablets"=>"http://uae.souq.com/ae-en/tablet/l/","Netbooks"=>"http://uae.souq.com/ae-en/netbook/l/","Laptops & Notebooks"=>"http://uae.souq.com/ae-en/laptop-notebook/l/","Scanners"=>"http://uae.souq.com/ae-en/scanner/l/","Printers"=>"http://uae.souq.com/ae-en/printer/l/","Printer & Scanner Accessories"=>"http://uae.souq.com/ae-en/printer-scanner-accessories/l/","Cables"=>"http://uae.souq.com/ae-en/cables/l/","Docking Stations"=>"http://uae.souq.com/ae-en/docking-station/l/","Network Cards & Adapters"=>"http://uae.souq.com/ae-en/network-card-adapter/l/","Network Switches"=>"http://uae.souq.com/ae-en/network-switch/l/","Networking Tools"=>"http://uae.souq.com/ae-en/networking-tool/l/","Routers"=>"http://uae.souq.com/ae-en/router/l/","Uninterruptible Power Supply UPS"=>"");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	




$dept = array("Car Electronics & Accessories"); 
$categories = array("Car Audio and Video Accessories"=>"http://uae.souq.com/ae-en/car-audio-video-accessories/l/","GPS accessories"=>"http://uae.souq.com/ae-en/gps-accessories/l/","Keys & Key Chains"=>"http://uae.souq.com/ae-en/keys-key-chains/l/","Car Care Products"=>"http://uae.souq.com/ae-en/car-care-product/l/","Car Audio"=>"http://uae.souq.com/ae-en/car-audio/l/","Car Navigation"=>"http://uae.souq.com/ae-en/car-navigation/l/","Car Video"=>"http://uae.souq.com/ae-en/car-video/l/","GPS Navigators"=>"http://uae.souq.com/ae-en/gps-navigator/l/","GPS Receiver"=>"http://uae.souq.com/ae-en/gps-receiver/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	




$dept = array("Art, Crafts & Collectables"); 
$categories = array("Antiques"=>"http://uae.souq.com/ae-en/antique/l/","Drawings & Paintings"=>"http://uae.souq.com/ae-en/drawing-painting/l/","Handcrafts, sculpture & carvings"=>"http://uae.souq.com/ae-en/handcraft-sculpture-carving/l/","Islamic, Ethnic and Digital Art"=>"http://uae.souq.com/ae-en/islamic-ethnic-digital-art/l/","Maps, Atlases & Globes"=>"http://uae.souq.com/ae-en/map-atlas-globe/l/","Photographs"=>"http://uae.souq.com/ae-en/photograph/l/","Posters"=>"http://uae.souq.com/ae-en/poster/l/","Prints"=>"http://uae.souq.com/ae-en/prints/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
						$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 1, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=1")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=1";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	

	
		
		
// Arabic version
$site_url = 'http://uae.souq.com';
$temp_language = 'ar';
$marchant_url = $site_url;
$main_html = file_get_html($site_url."/ae-ar/shop-all-categories/c/", true);
$marchant_logo = $main_html->find('img', 1)->src;


$dept = array("Clothing & Accessories"); 
$categories = array("Accessories"=>"http://uae.souq.com/ae-ar/accessories/l/", "Athletic Wear"=>"http://uae.souq.com/ae-ar/athletic-wear/l/", "Baby Clothes"=>"http://uae.souq.com/ae-ar/baby-clothes/l/", "Dresses"=>"http://uae.souq.com/ae-ar/dresses/l/", "Eyewear"=>"http://uae.souq.com/ae-ar/eyewear/l/", "Jackets & Coats"=>"http://uae.souq.com/ae-ar/jacket-coats/l/", "Pants"=>"http://uae.souq.com/ae-ar/pants/l/", "Skirts"=>"http://uae.souq.com/ae-ar/skirts/l/", "Sleepwear"=>"http://uae.souq.com/ae-ar/sleepwears/l/", "Swimwear"=>"http://uae.souq.com/ae-ar/swimwears/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; //echo $result;exit;
		$no_page = floor($result/$tot); //echo $no_page;exit;
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; //echo $html;exit;
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				//$prod_sl = 1;
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Books"); 
$categories = array("Books & Manuscripts"=>"http://uae.souq.com/ae-ar/books-manuscript/l/", "Comic & Graphic Novels"=>"http://uae.souq.com/ae-ar/comic-graphic-novel/l/", "Educational Books"=>"http://uae.souq.com/ae-ar/educational-book/l/", "Fiction & Literature"=>"http://uae.souq.com/ae-ar/fiction-literature/l/", "General Books"=>"http://uae.souq.com/ae-ar/books/l/", "Kids Books"=>"http://uae.souq.com/ae-ar/kids-book/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Coins, Stamps & Paper money"); 
$categories = array("Coins"=>"http://uae.souq.com/ae-ar/coins/l/", "Stamps"=>"http://uae.souq.com/ae-ar/stamps/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Games & Toys"); 
$categories = array("Game Consoles"=>"http://uae.souq.com/ae-ar/games-console/l/", "Game Gadgets & Accessories"=>"http://uae.souq.com/ae-ar/games-console-accessories/l/", "Toys"=>"http://uae.souq.com/ae-ar/toys/l/", "Video Games"=>"http://uae.souq.com/ae-ar/games/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}		
		


$dept = array("Mobiles & Accessories"); 
$categories = array("Mobile Phones"=>"http://uae.souq.com/ae-ar/mobile-phone/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Shoes & Bags"); 
$categories = array("Backpacks"=>"http://uae.souq.com/ae-ar/backpacks/l/","Boots"=>"http://uae.souq.com/ae-ar/boots/l/","Business Bags"=>"http://uae.souq.com/ae-ar/business-bags/l/","Casual & Formal Shoes"=>"http://uae.souq.com/ae-ar/shoes/l/","Handbags"=>"http://uae.souq.com/ae-ar/handbags/l/","Luggage"=>"http://uae.souq.com/ae-ar/luggage/l/","Messenger Bags"=>"http://uae.souq.com/ae-ar/messenger-bags/l/","Sandals"=>"http://uae.souq.com/ae-ar/sandals/l/","School Bags"=>"http://uae.souq.com/ae-ar/school-bags/l/","Slippers"=>"http://uae.souq.com/ae-ar/slippers/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}		



$dept = array("Jewelry & Accessories"); 
$categories = array("Necklaces, Pendants & Charms"=>"http://uae.souq.com/ae-ar/necklace-pendant/l/","Rings"=>"http://uae.souq.com/ae-ar/rings/l/","Earrings"=>"http://uae.souq.com/ae-ar/earrings/l/","Bracelets"=>"http://uae.souq.com/ae-ar/bracelets/l/","Men's Jewelry"=>"http://uae.souq.com/ae-ar/men-jewleries/l/","Loose Gemstones & Diamonds"=>"http://uae.souq.com/ae-ar/loose-gemstones-diamond/l/","Jewelry Accessories"=>"http://uae.souq.com/ae-ar/jewelry-accessories/l/","Jewelry Sets"=>"http://uae.souq.com/ae-ar/jewelry-set/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Watches & Accessories"); 
$categories = array("Watch Accessories"=>"http://uae.souq.com/ae-ar/watch-accessories/l/","Watches"=>"http://uae.souq.com/ae-ar/watches/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}



$dept = array("Office Products & Supplies"); 
$categories = array("Ink & Toner Cartridges"=>"http://uae.souq.com/ae-ar/ink-cartridges/l/","Multifunctional Devices"=>"http://uae.souq.com/ae-ar/multifunction-devices/l/","Office Equipment"=>"http://uae.souq.com/ae-ar/office-equipment/l/","Office Supplies"=>"http://uae.souq.com/ae-ar/office-supplies/l/","Printers"=>"http://uae.souq.com/ae-ar/printer/l/","Stationary"=>"http://uae.souq.com/ae-ar/stationary/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	


$dept = array("Home, Kitchen & Garden"); 
$categories = array("Kitchen & Dining Tools"=>"http://uae.souq.com/ae-ar/kitchen-dining/l/","Home Supplies"=>"http://uae.souq.com/ae-ar/home-supplies/l/","Vacuum Cleaners"=>"http://uae.souq.com/ae-ar/vacuum-cleaner/l/","Hot Beverage Makers"=>"http://uae.souq.com/ae-ar/hot-beverage-maker/l/","Kitchen Scales"=>"http://uae.souq.com/ae-ar/kitchen-scale/l/","Cooking Sets"=>"http://uae.souq.com/ae-ar/cooking-set/l/","Air Treatment"=>"http://uae.souq.com/ae-ar/air-treatment/l/","Steam Cleaners"=>"http://uae.souq.com/ae-ar/steam-cleaner/l/","Small Appliances"=>"http://uae.souq.com/ae-ar/small-appliance/l/","Power Tools"=>"http://uae.souq.com/ae-ar/power-tool/l/","Smoking Accessories"=>"http://uae.souq.com/ae-ar/smoking-accessories/l/","Hand Tools"=>"http://uae.souq.com/ae-ar/hand-tool/l/","Barbecue Tools & Grill Accessories"=>"http://uae.souq.com/ae-ar/barbecue-tool-grill-accessories/l/","Clocks & Compasses"=>"http://uae.souq.com/ae-ar/clock-compasses/l/","Cabinets"=>"http://uae.souq.com/ae-ar/cabinet/l/","Chairs"=>"http://uae.souq.com/ae-ar/chair-bench/l/","Lamps"=>"http://uae.souq.com/ae-ar/lamp/l/","Interior Decoration"=>"http://uae.souq.com/ae-ar/home-decor/l/","Rugs & Carpets"=>"http://uae.souq.com/ae-ar/rugs-carpets/l/","Bedding Supplies"=>"http://uae.souq.com/ae-ar/bedding/l/","Bathroom Supplies"=>"http://uae.souq.com/ae-ar/bathroom-equipment/l/","Garden Decoration"=>"http://uae.souq.com/ae-ar/garden-decoration/l/","Garden Lighting"=>"http://uae.souq.com/ae-ar/garden-light/l/", "Pet Supplies"=>"http://uae.souq.com/ae-ar/pet-supplies/l/","Gardening & Watering Supplies"=>"http://uae.souq.com/ae-ar/garden-equipment-watering/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Electronics"); 
$categories = array("Rechargeable Batteries"=>"http://uae.souq.com/ae-ar/rechargeable-batteries/l/","VCD, VCP and VCR Players"=>"http://uae.souq.com/ae-ar/vcd-vcp-vcr-player/l/","TV & Satellite Accessories"=>"http://uae.souq.com/ae-ar/tv-satellite-accessories/l/","Stereo Systems & Equalizers"=>"http://uae.souq.com/ae-ar/stereo-system-equalizer/l/","Security & Surveillance Systems"=>"http://uae.souq.com/ae-ar/security-surveillance-system/l/","Recording & Studio Equipment"=>"http://uae.souq.com/ae-ar/recording-studio-equipment/l/","MP3 & MP4 Players"=>"http://uae.souq.com/ae-ar/mp3-player/l/","Home Video Accessories"=>"http://uae.souq.com/ae-ar/video-accessories/l/","E-Book Readers"=>"http://uae.souq.com/ae-ar/ebook-reader/l/","Clock Radios"=>"http://uae.souq.com/ae-ar/clock-radio/l/","CD Recording Media"=>"http://uae.souq.com/ae-ar/cd-recording-media/l/","Camera & Camcorder Accessories"=>"http://uae.souq.com/ae-ar/camera-camcorder-accessories/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Baby"); 
$categories = array("Baby Clothes"=>"http://uae.souq.com/ae-ar/baby-clothes/l/","Baby Safety & Health"=>"http://uae.souq.com/ae-ar/baby-safety-health/l/","Baby Toys and Accessories"=>"http://uae.souq.com/ae-ar/baby-toy-accessories/l/","Baby Gear"=>"http://uae.souq.com/ae-ar/baby-gear/l/","Baby Gift Sets"=>"http://uae.souq.com/ae-ar/baby-gift-set/l/","Baby Accessories"=>"http://uae.souq.com/ae-ar/baby-accessories/l/","Feeding"=>"http://uae.souq.com/ae-ar/feeding-diapering-bathing/l/","Diapers"=>"http://uae.souq.com/ae-ar/diapers/l/","Baby Bath & Skincare"=>"http://uae.souq.com/ae-ar/baby-bath-skin-care/l/","Baby Bags"=>"http://uae.souq.com/ae-ar/baby-bag/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Sports & Outdoors"); 
$categories = array("GPS Receiver"=>"http://uae.souq.com/ae-ar/gps-receiver/l/","Sporting Goods"=>"http://uae.souq.com/ae-ar/sporting-goods/l/","Camping Goods"=>"http://uae.souq.com/ae-ar/camping-goods/l/","Fitness Technology"=>"http://uae.souq.com/ae-ar/fitness_technology/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					$single_product_list_html = file_get_html($product_url, true);
					
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Music & Movies"); 
$categories = array("CDs"=>"http://uae.souq.com/ae-ar/music-cd/l/","Movies, Plays & Series"=>"http://uae.souq.com/ae-ar/movies-plays-series/l/","Musical Instruments Accessories"=>"http://uae.souq.com/ae-ar/musical-instrument-parts/l/","Musical Instruments"=>"http://uae.souq.com/ae-ar/musical-instrument/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Health & Beauty"); 
$categories = array("Beauty Tools & Accessories"=>"http://uae.souq.com/ae-ar/beauty-tools-accessories/l/","Dental Care"=>"http://uae.souq.com/ae-ar/dental-care/l/","Food Supplements & Nutrition"=>"http://uae.souq.com/ae-ar/food-supplement/l/","Hair Electronics"=>"http://uae.souq.com/ae-ar/hair_electronics/l/","Men's Grooming"=>"http://uae.souq.com/ae-ar/men-grooming/l/","Natural Nutrition Products"=>"http://uae.souq.com/ae-ar/natural-nutrition-products/l/","Personal Care"=>"http://uae.souq.com/ae-ar/health-personal-care/l/","Personal Scales"=>"http://uae.souq.com/ae-ar/personal-scale/l/","Shavers & Hair Removals"=>"http://uae.souq.com/ae-ar/electrical-personal-machine/l/","Skin Care"=>"http://uae.souq.com/ae-ar/skin-care/l/","Vitamins & Minerals"=>"http://uae.souq.com/ae-ar/vitamin-mineral/l/","Wigs"=>"http://uae.souq.com/ae-ar/wigs/l/","Bath & Body"=>"http://uae.souq.com/ae-ar/bath-body/l/","Beauty Gifts Sets"=>"http://uae.souq.com/ae-ar/beauty-gift-set/l/","Hair Care"=>"http://uae.souq.com/ae-ar/hair-care/l/","Makeup"=>"http://uae.souq.com/ae-ar/makeup/l/","Perfumes & Fragrances"=>"http://uae.souq.com/ae-ar/perfumes-fragrances/l/","Sports Nutrition"=>"http://uae.souq.com/ae-ar/sport-nutrition/l/","Small Medical Equipment"=>"http://uae.souq.com/ae-ar/small-medical-equipment/l/","Digital Fever Thermometers"=>"http://uae.souq.com/ae-ar/digital-fever-thermometer/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Computers & Networking"); 
$categories = array("Card Readers & Writers"=>"http://uae.souq.com/ae-ar/card-reader-writer/l/","Computer Monitors"=>"http://uae.souq.com/ae-ar/computer-monitor/l/","Cooling Pads"=>"http://uae.souq.com/ae-ar/cooling-pad/l/","Memory Modules"=>"http://uae.souq.com/ae-ar/usb-drive-memory/l/","Optical Drives"=>"http://uae.souq.com/ae-ar/optical-drive/l/","Desktop PCs"=>"http://uae.souq.com/ae-ar/computer/l/","Servers"=>"http://uae.souq.com/ae-ar/server/l/","Webcams"=>"http://uae.souq.com/ae-ar/webcam/l/","Video Cards"=>"http://uae.souq.com/ae-ar/video-card/l/","CPUs"=>"http://uae.souq.com/ae-ar/cpu-ram/l/","Power Supplies"=>"http://uae.souq.com/ae-ar/power-supply/l/","Sound Cards"=>"http://uae.souq.com/ae-ar/sound-card/l/","Software"=>"http://uae.souq.com/ae-ar/software/l/","Media Gateways"=>"http://uae.souq.com/ae-ar/media-gateway/l/","Tablets"=>"http://uae.souq.com/ae-ar/tablet/l/","Netbooks"=>"http://uae.souq.com/ae-ar/netbook/l/","Laptops & Notebooks"=>"http://uae.souq.com/ae-ar/laptop-notebook/l/","Scanners"=>"http://uae.souq.com/ae-ar/scanner/l/","Printers"=>"http://uae.souq.com/ae-ar/printer/l/","Printer & Scanner Accessories"=>"http://uae.souq.com/ae-ar/printer-scanner-accessories/l/","Cables"=>"http://uae.souq.com/ae-ar/cables/l/","Docking Stations"=>"http://uae.souq.com/ae-ar/docking-station/l/","Network Cards & Adapters"=>"http://uae.souq.com/ae-ar/network-card-adapter/l/","Network Switches"=>"http://uae.souq.com/ae-ar/network-switch/l/","Networking Tools"=>"http://uae.souq.com/ae-ar/networking-tool/l/","Routers"=>"http://uae.souq.com/ae-ar/router/l/","Uninterruptible Power Supply UPS"=>"");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"'; 
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	




$dept = array("Car Electronics & Accessories"); 
$categories = array("Car Audio and Video Accessories"=>"http://uae.souq.com/ae-ar/car-audio-video-accessories/l/","GPS accessories"=>"http://uae.souq.com/ae-ar/gps-accessories/l/","Keys & Key Chains"=>"http://uae.souq.com/ae-ar/keys-key-chains/l/","Car Care Products"=>"http://uae.souq.com/ae-ar/car-care-product/l/","Car Audio"=>"http://uae.souq.com/ae-ar/car-audio/l/","Car Navigation"=>"http://uae.souq.com/ae-ar/car-navigation/l/","Car Video"=>"http://uae.souq.com/ae-ar/car-video/l/","GPS Navigators"=>"http://uae.souq.com/ae-ar/gps-navigator/l/","GPS Receiver"=>"http://uae.souq.com/ae-ar/gps-receiver/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
		}
	}
}	



$dept = array("Art, Crafts & Collectables"); 
$categories = array("Antiques"=>"http://uae.souq.com/ae-ar/antique/l/","Drawings & Paintings"=>"http://uae.souq.com/ae-ar/drawing-painting/l/","Handcrafts, sculpture & carvings"=>"http://uae.souq.com/ae-ar/handcraft-sculpture-carving/l/","Islamic, Ethnic and Digital Art"=>"http://uae.souq.com/ae-ar/islamic-ethnic-digital-art/l/","Maps, Atlases & Globes"=>"http://uae.souq.com/ae-ar/map-atlas-globe/l/","Photographs"=>"http://uae.souq.com/ae-ar/photograph/l/","Posters"=>"http://uae.souq.com/ae-ar/poster/l/","Prints"=>"http://uae.souq.com/ae-ar/prints/l/");
foreach($dept as $dep){ 
	$department="";
	$department = addslashes(html_entity_decode($dep));
	foreach($categories as $cate=>$cat_url){ 
		$category = "";
		$category = addslashes(html_entity_decode($cate));
		$html_prv = $cat_url;
		$html_prv = file_get_html($cat_url, true);	
		
		$tot = $html_prv->find('div[id=search-results-title]',0)->find('span[id=showingOffers]',0)->plaintext;
		$result = $html_prv->find('div[id=search-results-title]',0)->find('b',1)->plaintext; 
		$no_page = floor($result/$tot); 
		
		for($i=1;$i<=$no_page;$i++){
		$html = '';
		$html = $cat_url.'?page='.$i; 
		$html = file_get_html($cat_url, true);
			foreach($html->find('div[id=ItemResultList]') as $sub_first) {
				foreach($sub_first->find('div.single-item-browse') as $sub_sec) {
					$product_url = '';
					$product_full_name = '';
					$image_url = '';
					$currency = '';
					$price = '';
					$id_en = '';
					$brand = '';
					//$image_url = '["'.addslashes($sub_sec->find('img', 0)->src).'"]'; 
					$image_url = '"'.addslashes($sub_sec->find('img', 0)->src).'"';  
					$product_full_name = addslashes($sub_sec->find('a', 1)->plaintext);  
					$product_url = $sub_sec->find('a', 0)->href; 
					if($product_full_name <> ""){
						$slug = create_url_slug($product_full_name);
					}
					$currency = trim($sub_sec->find('div span.currency', 0)->plaintext);  
					$price = trim(str_replace($currency, "", $sub_sec->find('div.small-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					if($price == ''){
						$price = trim(str_replace($currency, "", $sub_sec->find('div.meduim-price', 0)->plaintext));
					$price = str_replace( ',', '', $price );
					}
					if(isset($sub_sec->find('span.striked', 0)->plaintext)){
						$old_price = trim(str_replace($currency, "", $sub_sec->find('span.striked', 0)->plaintext));
						$old_price = str_replace( ',', '', $old_price );
						$diff = round($old_price) - round($price);
						$percent = $diff/$old_price;
						$percent_friendly = number_format( $percent * 100, 2 ) . '%';
						$ins_qry_en = "INSERT INTO mc_offers set merchant_id='1', offer_title='$percent_friendly. Discount', discount='$percent_friendly'"; //echo $ins_qry;
						mysql_query($ins_qry_en);
						$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_offers"); 
						$off_id_en = mysql_fetch_array($lst_insrt_id_en); 
						$id_en = $off_id_en["MaximumID"];
					}else{
						$id_en = '';
					}
					
					
					$single_product_list_html = file_get_html($product_url, true);
					
					if(isset($single_product_list_html->find('div.product-attributes ul li',0)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',0)->plaintext)){
						$brand_nm = $single_product_list_html->find('div.product-attributes ul li',0)->plaintext;
						$brand_nm = explode(":",$brand1); 
						$brand_nm = addslashes(trim($brand_nm[1]));
						
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand_nm."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$chk_brand1 = mysql_query("INSERT INTO mc_product_brands set slug ='$brand_nm', status=1");
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");							
						}
					}else{
						$brand = 'None';
						$chk_brand =  mysql_query("SELECT id FROM  `mc_product_brands` WHERE  `slug` = '".$brand."'");
						$brand_id = mysql_fetch_array($chk_brand);		
						if(isset($brand_id) && !empty($brand_id)){ 
							$brand = $brand_id['id'];
						}else{ 
							$inst = "INSERT INTO mc_product_brands set slug ='$brand',status=1";
							$chk_brand = mysql_query($inst);
							$lst_insrt_id_en = mysql_query("SELECT MAX(id) as MaximumID FROM mc_product_brands"); 
							$brand_id_en = mysql_fetch_array($lst_insrt_id_en); 
							$brand = $brand_id_en["MaximumID"];
							$insrt_langs = mysql_query("INSERT INTO mc_product_brand_langs set brand_id ='$brand', lang_id = 2, brand_title = '$brand_nm', description = '$brand_nm',status=1 ");
						}	
					}	
					$specification = '';$color = '';
					if(isset($single_product_list_html->find('div.product-attributes ul li',2)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',2)->plaintext)){
						$color = $single_product_list_html->find('div.product-attributes ul li',2)->plaintext; 
						$color = explode(":",$color); 
						$color = trim($color[1]);
						$specification = '"'.trim('Color').'":"'.trim($color).'"';
					}
					if(isset($single_product_list_html->find('div.product-attributes ul li',1)->plaintext) && !empty($single_product_list_html->find('div.product-attributes ul li',1)->plaintext)){
						$size = $single_product_list_html->find('div.product-attributes ul li',1)->plaintext; 
						$size = explode(":",$size); 
						$size = trim($size[1]);
						$specification = $specification.',"'.trim('Size').'":"'.trim($size).'"';
					}
					$specification = mysql_real_escape_string($specification);
					
					
					if(isset($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)){
						$thumb1 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',0)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb1;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)){
						$thumb2 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',1)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb2;
					}else if(isset($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src) && !empty($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)){
						$thumb3 = '"'.addslashes(trim($single_product_list_html->find('div.pic_list ul li',2)->find('img',0)->src)).'"';
						$image_url = $image_url.",".$thumb3;
					}
					$image_url = '['.$image_url.']'; 
					
					$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',0)->plaintext));
					$product_description .= "<br><br>".mysql_real_escape_string(trim($single_product_list_html->find('div.item_tab_contents_wrapper',1)->plaintext));
					$product_description =addslashes($product_description); 
					/*$specification = '';
					foreach($single_product_list_html->find('div.ui-tabs-panel table') as $product_spe){
						foreach($product_spe->find('tr') as $product_spe_tr){
							$temp = explode(":", $product_spe_tr->plaintext); 
							if($specification == ''){
								$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}else{
								$specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
							}
						}
						$specification = mysql_real_escape_string($specification);
						$specification = addslashes($specification);
					}*/
					if($price != ''){
						$rs1 = mysql_query("select * from mc_products_temp where product_url = '".$product_url."' and lang=2")or die(mysql_error());
						if(mysql_num_rows($rs1) <= 0){
							$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='1',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',department='$department',category_name='$category',currency='$currency',price='$price',image_url='$image_url',brand='$brand',offer_id='$id_en',specification='$specification',product_description='$product_description',lang=2";
							mysql_query($ins_query);
						}
					}
				}
			}
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


/*
$request = "https://www.kimonolabs.com/api/92w05jxk?apikey=dvJ988sneRUG8l8cbAlVK6EKk9963T0m";
//$response = file_get_contents($request); pr($response);
$response =file_get_html("https://www.kimonolabs.com/api/92w05jxk?apikey=dvJ988sneRUG8l8cbAlVK6EKk9963T0m", true);  //echo "<pre>";print_r($response);
$results = json_decode($response, TRUE); //echo "<pre>";print_r($results);exit;
$dept = $results['results']['collection1'];
$cat = $results['results']['collection2'];
foreach($results['results'] as $res){ echo "<pre>";print_r($res);exit;	
}
*/
?>