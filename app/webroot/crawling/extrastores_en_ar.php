<?php
ob_start();
ob_end_flush();

ini_set('max_execution_time','5000');
ini_set('memory_limit','1000M');

include('db.php');
//mysql_query("truncate table mc_products_temp")or die(mysql_error());
include('simple_html_dom.php');

$site_url = 'http://www.extrastores.com';
$language = 'ar-sa';
$temp_language = 'ar';
$marchant_url = $site_url;

// Create DOM from URL or file
$html = file_get_html($site_url.'/'.$language.'/sitemap'); 

// 3 means images index of the webpage
$marchant_logo = $site_url.'/'.str_replace("../","",$html->find('img', 3)->src);

$list_sl = 1; // Don't remove this
foreach($html->find('div.sitemapbox ul li.smtitle') as $ulspacer) {
	
	$product_link_page = $ulspacer->find('a', 0)->href;
	for($page_no = 1; $page_no <= 1; $page_no++){
				
		// Product list page
		$temp_url = $site_url.$product_link_page.'?page='.$page_no;
		$prod_list = file_get_html($temp_url);
		
		$sl = 1;
		
		// Get Product List Div
		foreach($prod_list->find('div.prodlisttitle') as $productbox) {
						
			$prod_page_link = $productbox->find('a', 0)->href;
			$temp_prod_page_link = $prod_page_link;
			$temp_prod_page_link = explode('/', $temp_prod_page_link);
			
			$category_name = trim($temp_prod_page_link[2]);
			$department = trim($temp_prod_page_link[3]);
			$product_full_name = $productbox->find('a', 0)->plaintext;			
			$product_url = $site_url.$prod_page_link;
			
			// Product individual page
			$prod_dtls_page = file_get_html($product_url);
			
			# Get Product full name for SLUG
			foreach($prod_dtls_page->find('div.proddscrpt') as $temp_slug){				
				$slug = trim($temp_slug->find('h1', 0)->plaintext);
			}
			if($slug <> ""){
				$slug = create_url_slug($slug);
			}
			# End Slug
			
			$temp_slug = trim($prod_dtls_page->find('li.price2', 0)->plaintext);
			$temp_model_sku = $prod_dtls_page->find('li.modelno',0)->plaintext;
			
			// Get Price and Currency from product details page
			$temp_price = trim($prod_dtls_page->find('li.price2', 0)->plaintext);
			$currency = trim(substr($temp_price, -2));
			$price = trim(str_replace($currency, "", $temp_price));
			
			// Find product images
			foreach($prod_dtls_page->find('div.mainpic') as $img_element){
				
				$img_src = $img_element->find('img', 0)->src;
				$img_ext = substr($img_src, -3);
				if($img_ext == 'jpg'){
					$temp_image_url = $img_src;
				}else{
					$temp_image_url = $img_element->find('img', 1)->src;
				}
			}
			
			$image_url = '["'.$site_url.'/'.str_replace("../../../", "", $temp_image_url).'"]';
			
			$temp_model_sku = $prod_dtls_page->find('li.modelno',0)->plaintext;
			$arr_model_sku = explode('|', $temp_model_sku);
			
			$temp_model = explode(':', $arr_model_sku[0]);
			$model_no = trim($temp_model[1]);
			
			$temp_sku = explode(':', $arr_model_sku[1]);
			$sku = trim($temp_sku[1]);
			
			// Specification			
			foreach($prod_dtls_page->find('div.specstable') as $spe_element){
				$x = 1;
				$specification = '';
				foreach($spe_element->find('li') as $li_spe_element){
															
					$temp_line_text = trim($li_spe_element->plaintext);
					if($temp_line_text <> ""){
						if ( $x & 1 ) {
						  $num = 'odd';
						  if($specification == ''){
							$specification = '"'.trim($li_spe_element->plaintext).'"=>';
						  }else{
							  $specification = $specification.'"'.trim($li_spe_element->plaintext).'"=>';
						  }
						} else {
						  $num = 'even';
						  $specification = $specification.'"'.trim($li_spe_element->plaintext).'",';
						}
						$x++;
					}
				}
				$specification = mysql_real_escape_string(rtrim($specification, ','));	
			}
			
			# Check product exist in database for a particular marchant with product name
			/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
			$chk_num = mysql_num_rows($chk_qry);
			if($chk_num > 0){
				mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
			}*/
			
			# query string
			$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='6',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category_name',department='$department',currency='$currency',model_no='$model_no',sku='$sku',price='$price',image_url='$image_url',specification='$specification',lang=2";
			mysql_query($ins_query);
			
			//if($sl > 1){ break; }
			$sl++;
		}
	}
	
	if($list_sl > 31){ // Don't remove this [sitemap all category like Accessories. this is the last category]
		break;
	}
	$list_sl++; // Don't remove this
	$prod_list = '';
}

// Arabic Version
$site_url = 'http://www.extrastores.com';
$language = 'en-sa';
$temp_language = 'en';
$marchant_url = $site_url;

// Create DOM from URL or file
$html = file_get_html($site_url.'/'.$language.'/sitemap'); 

// 3 means images index of the webpage
$marchant_logo = $site_url.'/'.str_replace("../","",$html->find('img', 3)->src);

$list_sl = 1; // Don't remove this
foreach($html->find('div.sitemapbox ul li.smtitle') as $ulspacer) {
	
	$product_link_page = $ulspacer->find('a', 0)->href;
	for($page_no = 1; $page_no <= 1; $page_no++){
				
		// Product list page
		$temp_url = $site_url.$product_link_page.'?page='.$page_no;
		$prod_list = file_get_html($temp_url);
		
		$sl = 1;
		
		// Get Product List Div
		foreach($prod_list->find('div.prodlisttitle') as $productbox) {
						
			$prod_page_link = $productbox->find('a', 0)->href;
			$temp_prod_page_link = $prod_page_link;
			$temp_prod_page_link = explode('/', $temp_prod_page_link);
			
			$category_name = trim($temp_prod_page_link[2]);
			$department = trim($temp_prod_page_link[3]);
			$product_full_name = $productbox->find('a', 0)->plaintext;			
			$product_url = $site_url.$prod_page_link;
			
			// Product individual page
			$prod_dtls_page = file_get_html($product_url);
			
			# Get Product full name for SLUG
			foreach($prod_dtls_page->find('div.proddscrpt') as $temp_slug){				
				$slug = trim($temp_slug->find('h1', 0)->plaintext);
			}
			if($slug <> ""){
				$slug = create_url_slug($slug);
			}
			# End Slug
			
			$temp_slug = trim($prod_dtls_page->find('li.price2', 0)->plaintext);
			$temp_model_sku = $prod_dtls_page->find('li.modelno',0)->plaintext;
			
			// Get Price and Currency from product details page
			$temp_price = trim($prod_dtls_page->find('li.price2', 0)->plaintext);
			$currency = trim(substr($temp_price, -2));
			$price = trim(str_replace($currency, "", $temp_price));
			
			// Find product images
			foreach($prod_dtls_page->find('div.mainpic') as $img_element){
				
				$img_src = $img_element->find('img', 0)->src;
				$img_ext = substr($img_src, -3);
				if($img_ext == 'jpg'){
					$temp_image_url = $img_src;
				}else{
					$temp_image_url = $img_element->find('img', 1)->src;
				}
			}
			
			$image_url = '["'.$site_url.'/'.str_replace("../../../", "", $temp_image_url).'"]';
			
			$temp_model_sku = $prod_dtls_page->find('li.modelno',0)->plaintext;
			$arr_model_sku = explode('|', $temp_model_sku);
			
			$temp_model = explode(':', $arr_model_sku[0]);
			$model_no = trim($temp_model[1]);
			
			$temp_sku = explode(':', $arr_model_sku[1]);
			$sku = trim($temp_sku[1]);
			
			// Specification			
			foreach($prod_dtls_page->find('div.specstable') as $spe_element){
				$x = 1;
				$specification = '';
				foreach($spe_element->find('li') as $li_spe_element){
															
					$temp_line_text = trim($li_spe_element->plaintext);
					if($temp_line_text <> ""){
						if ( $x & 1 ) {
						  $num = 'odd';
						  if($specification == ''){
							$specification = '"'.trim($li_spe_element->plaintext).'"=>';
						  }else{
							  $specification = $specification.'"'.trim($li_spe_element->plaintext).'"=>';
						  }
						} else {
						  $num = 'even';
						  $specification = $specification.'"'.trim($li_spe_element->plaintext).'",';
						}
						$x++;
					}
				}
				$specification = mysql_real_escape_string(rtrim($specification, ','));	
			}
			
			# Check product exist in database for a particular marchant with product name
			/*$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
			$chk_num = mysql_num_rows($chk_qry);
			if($chk_num > 0){
				mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price' and language='$temp_language'");
			}*/
			
			# query string
			$ins_query = "INSERT INTO mc_products_temp set merchant_product_id='6',marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category_name',department='$department',currency='$currency',model_no='$model_no',sku='$sku',price='$price',image_url='$image_url',specification='$specification',lang=1";
			mysql_query($ins_query);
			
			//if($sl > 1){ break; }
			$sl++;
		}
	}
	
	if($list_sl > 31){ // Don't remove this [sitemap all category like Accessories. this is the last category]
		break;
	}
	$list_sl++; // Don't remove this
	$prod_list = '';
}

# update crawl_end_date
mysql_query("update mc_merchants_new set crawl_end_date=now() where site_id > '0'");
mysql_query("update mc_merchants_new set site_id='0' where site_id > '0'");

// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
mysql_query("update mc_merchants_new set crawl_end_date=now() where id=6");
mysql_query("update mc_merchants_new set site_id=0");

?>