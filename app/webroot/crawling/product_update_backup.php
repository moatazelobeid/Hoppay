<?php
ob_start();

include('db.php');

if(isset($_REQUEST['site_id'])){
	
	$site_id = $_REQUEST['site_id'];
	$merchant_product_id="";
	
	if($site_id == 1){
		$merchant_product_id = 23; // souq
	}elseif($site_id == 2){
		$merchant_product_id = 18; // markavip
	}elseif($site_id == 3){
		$merchant_product_id = 13; // namshi
	}elseif($site_id == 4){
		$merchant_product_id = 34; // ikea
	}elseif($site_id == 5){
		$merchant_product_id = 19; // sukar
	}elseif($site_id == 6){
		$merchant_product_id = 51; // extrastores
	}
	
	$qry_prod = mysql_query("select * from mc_products_temp where merchant_product_id='$site_id'");
	$k = 1;
	while($res_prod = mysql_fetch_array($qry_prod)){
		
		if($res_prod['language'] == 'en'){
			$lang_id = 1;
		}elseif($res_prod['language'] == 'ar'){
			$lang_id = 2;
		}		
		
		// insert new department [New clothes]
		if($res_prod['department'] <> ""){
			
			// create department slug
			$dept_slug = create_url_slug($res_prod['department']);
			$dept_slug_org = $res_prod['department'];
			
			// Get category id
			$qry_dept = mysql_query("select * from mc_product_categories where slug='$dept_slug'");
			$res_dept = mysql_fetch_array($qry_dept);
		
			if($res_dept['id'] > 0 && $res_dept['parent_id'] == '0'){
				$category_id = $res_dept['id'];
				$parent_id = $category_id;
			}else{
				
				echo 'd1-'.$str_temp_dept_first = "insert into mc_product_categories set slug='$dept_slug'";
				echo '<br>';
				mysql_query($str_temp_dept_first);
				$parent_id = mysql_insert_id();	
				
				// insert in category_lang
				echo 'd2-'.$str_temp_dept_sec = "insert into mc_product_category_langs set cat_id='$parent_id',lang_id='$lang_id',category_name='$dept_slug_org',description='$dept_slug_org'";
				echo '<br>';
				mysql_query($str_temp_dept_sec);
				
				// create category slug and check duplicate
				$cate_slug = create_url_slug($res_prod['category_name']);
				$cate_slug_org = $res_prod['category_name'];
				
				$qry_cate = mysql_query("select * from mc_product_categories where slug='$cate_slug'");
				$res_cate = mysql_fetch_array($qry_cate);
				if($res_cate['id'] > 0){
					
					$category_id = $res_dept['parent_id'];
				}else{
					
					// insert new category [Women]
					echo 'c1-'.$str_temp_cate_first = "insert into mc_product_categories set slug='$cate_slug',parent_id='$parent_id'";
					echo '<br>';
					mysql_query($str_temp_cate_first);
					$category_id = mysql_insert_id();
					
					
					// insert in category_lang
					echo 'c2-'.$str_temp_cate = "insert into mc_product_category_langs set cat_id='$parent_id',lang_id='$lang_id',category_name='$cate_slug_org',description='$cate_slug_org'";
					echo '<br>';
					mysql_query($str_temp_cate);
				}
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
			}
			
		}
		
		
		$chk_qry = mysql_query("select id from mc_products where retailer_id='$merchant_product_id' And product_url='$res_prod[product_url]'");
		$chk_num = mysql_num_rows($chk_qry);
		if($chk_num > 0){
			
			echo $k.'---'.$update_query = "update mc_products set slug='$res_prod[slug]',category_id='$category_id',sku='$res_prod[sku]',price_type='$res_prod[currency]',image_url='$res_prod[image_url]',manufacturer='',brand='0',department='$parent_id',upc='',mpn='',isbn='',color='',shipping_name='',shipping_cost='',shipping_weight='',weight='',height='',width='',last_modified=now() where retailer_id='$merchant_product_id' And product_url='$res_prod[product_url]'";
	
			mysql_query($update_query);
			echo '<br>';
		}else{
			
			$str_query = "insert into mc_products set slug='$res_prod[slug]',product_url='$res_prod[product_url]',category_id='$category_id',retailer_id='$merchant_product_id',sku='$res_prod[sku]',price='$res_prod[price]',price_type='$res_prod[currency]',image_url='$res_prod[image_url]',manufacturer='',brand='0',department='$parent_id',upc='',mpn='',isbn='',color='',shipping_name='',shipping_cost='',shipping_weight='',weight='',height='',width='',created_date=now()";
	
			mysql_query($str_query);
			
			$insert_id = mysql_insert_id();
			
			echo $str_dtls = "insert into mc_product_langs set product_id='$insert_id',lang_id='$lang_id',title='$res_prod[product_name]',description='$res_prod[product_description]'";
	
			mysql_query($str_dtls);
			echo '<br>';
		}
		// delete from temparary table
		//mysql_query("delete from mc_products_temp where id='$res_prod[id]'");
		
		$k++;
	}
}
function create_url_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return strtolower($slug);
}
?>