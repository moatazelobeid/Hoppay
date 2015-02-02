<?php
ob_start();
ob_end_flush();

ini_set('max_execution_time','5000');

/*$con=mysql_connect("localhost","root","");
mysql_select_db('a_crawl');*/
phpinfo();
exit;
mail("maas_kishor@yahoo.in","My subject","cron text");
exit;
$con=mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
mysql_select_db('menacompare_demo1');

// Check connection
if (mysql_errno()) {
  echo "Failed to connect to MySQL: " . mysql_error();
}

$site_url = 'http://www.sukar.com';
$temp_language = 'en';
$marchant_url = $site_url;
$marchant_logo = 'http://cf1.sukarcdn.com/static/ltr/en/images/sukar/brp_default.png';

include('simple_html_dom.php');

$main_html = file_get_html($site_url."/ae-en/", true);

$main_sl = 0;
foreach($main_html->find('li.padding-li-7') as $sub_cate_list_ul) {
	
	$category = trim($sub_cate_list_ul->find('a', 0)->plaintext);
	
	// 0 = Accessories Week, 1 = women, 2 = men, 3 = Ethnic  4 = Boutique  5 = Home
	if($main_sl == 1){ // only for women
			
		//echo $main_sl.'--'.$category;
		$category_link = trim($sub_cate_list_ul->find('a', 0)->href);
		
		// Create DOM from URL or file
		$html = file_get_html($category_link, true);
		
		foreach($html->find('div.nhp-common') as $sub_cate_list_ul) {
			
			$cate_sl = 0; // number of category in loop
			foreach($sub_cate_list_ul->find('div.medium-6') as $sub_cate_list_last){
				
				$department = trim($sub_cate_list_last->find('p.brand-info',0)->plaintext);
				$product_list_url = trim($sub_cate_list_last->find('a',0)->href);
				
				// Create DOM from URL category list file
				$product_list_html = file_get_html($product_list_url, true);
				
				foreach($product_list_html->find('div[id=available-items]') as $product_list_ul){
					
					$prod_sl = 1;
					foreach($product_list_ul->find('div.listing-items') as $product_list_last){
						
						$product_url = $product_list_last->find('a',0)->href;
						$image_url = $product_list_last->find('span.bord-light-gray',0)->find('img',1)->src;
						
						$product_full_name = mysql_real_escape_string(trim($product_list_last->find('a span.item-name',0)->plaintext));
						
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
						
						$single_product_list_html = file_get_html($product_url, true);
						$product_description = mysql_real_escape_string(trim($single_product_list_html->find('div.infoHide',0)->innertext));
						
						$specification = '';
						foreach($single_product_list_html->find('ul.item-attr-ul li') as $product_spe){
							
							if(trim($product_spe->plaintext) <> ""){
								$temp = explode(":", $product_spe->plaintext);
								if($specification == ''){
									$specification = '"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
								  }else{
									  $specification = $specification.',"'.trim($temp[0]).'"=>"'.trim($temp[1]).'"';
								  }
							}
						}
						$specification = mysql_real_escape_string($specification);
						
						$color = "";
						if(isset($single_product_list_html->find('div.variance-box',0)->innertext)){
							$color = trim($single_product_list_html->find('div.variance-box',0)->innertext);
						}
						
						# Check product exist in database for a particular marchant with product name
						$chk_qry = mysql_query("select id from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
						$chk_num = mysql_num_rows($chk_qry);
						if($chk_num > 0){
							mysql_query("delete from mc_products_temp where marchant_url='$marchant_url' And product_name='$product_full_name' And price='$price'");
						}
						#
						
						$ins_query = "INSERT INTO mc_products_sukar set marchant_url='$marchant_url',marchant_logo='$marchant_logo',language='$temp_language',product_name='$product_full_name',slug='$slug',product_url='$product_url',category_name='$category',department='$department',currency='$currency',price='$price',image_url='$image_url',color='$color',specification='$specification',product_description='$product_description'";
						mysql_query($ins_query);
						//echo '<br>';
						//echo '<br>';
						
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
// Slug generate function
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
/*//use curl to get html content
function getHTML($url,$timeout)
{
       $ch = curl_init($url); // initialize curl with given url
       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
       return @curl_exec($ch);
}*/
?>