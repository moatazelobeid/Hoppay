<?php ini_set('max_execution_time', 600);?>

<?php 
//echo '<pre>'; print_r($products); echo '<pre>'; exit;
if(!empty($products))
{
	//echo count($products); exit;
	//$key = 0;
	foreach($products as $key=>$product)
	{
		//$key++;
		
		$product_lang_data = '';
		$product_lang_data = $this->Template->languageChanger($product['Product_lang']);
		$pname = stripslashes($product_lang_data['title']);
		
		if(strlen($pname) > 30) 
			$pname = substr($pname,0,30).'..';
		else
			$pname = $pname;
			
		$pdesc = stripslashes($product_lang_data['description']);
		
		if(strlen($pdesc) > 40) 
			$pdesc = substr($pdesc,0,40).'..';
		else
			$pdesc = $pdesc;
			
		$pimage = stripslashes($product['Product']['image_url']);
		$pimage = str_replace(array('["','"]'),array('',''),$pimage);
		
		$product_name_slug = $product['Product']['slug'];
		$product_link = '';
		$product_link = $this->webroot.$this->Template->getLang().'/products/'.$product['Product']['id']."-".$product_name_slug;
		
		//get product brand
		if(!empty($product['Product']['brand']))
			$brand_name = $this->Template->getBrandName($product['Product']['brand']);
		else
			$brand_name = '&nbsp;';
			
		//get brand link
		$brand_link = '';
		$brand_link = $this->webroot.$this->Template->getLang().'/brand-'.$product['Product_brand']['slug'];
			
		$this->Reviewed_user = ClassRegistry::init('Reviewed_user');
		$productrate=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($product['Product']['id'],1);
		$rresults = Hash::extract($productrate, '{n}.Product_review.rating');
		$rcount=count($rresults);
		if($rcount>0)
			$avgrate=(array_sum($rresults)/count($rresults));
		else
			$avgrate=0;
		
		$merchant_data = '';
		$merchant_data = $this->Template->getMerchantDetails($product['Product']['retailer_id']);
			
		//echo '<pre>'; print_r($merchant_data);	
		
		$merchant_logo = $merchant_data['image_url'];	
		$merchant_website = $merchant_data['website_name'];
		
	
		//get merchant count
		$merchant_count = $this->Template->getProductMerchantCount($product['Product']['id'],$product['Product']['slug'],$product['Product']['retailer_id']);
		?>
		<div class="gd-col gu4 tmargin20 bmargin16 dotdProductModuleNew">
			<div class="deal inStock">
					<div class="titleArrows"></div>
					<div class="offerTitleWrap">
						<h1>
							<?php 
								$offer_val = stripslashes(trim($product['Offer']['offer_title']));
								//$offer_val = trim($value['Offer']['offer_title']);
								$offer_val = explode("%",$offer_val);
								$offer_val = implode("%",array($offer_val[0],str_replace('.', '', $offer_val[1])));
								echo $offer_val;
							?>
						</h1>
					</div>
						<div class="offerSubTitle "><?php echo $pname;?></div>
						<div><?php echo $this->template->getWord('by');?> <a href="<?php echo $brand_link;?>"><?php echo $brand_name;?></a></div>
					<a class="noUnderline" href="<?php echo $product_link;?>">
						<img class="" src="<?php echo $pimage;?>" style="vertical-align: middle;height: 150px;" alt="offers">
					</a>
				<div class="descriptionWrap">
				<div class="description">
					<div style="height: 47px;"><?php //echo wordwrap($pdesc,20, '<br>',true);?>
					
						<div id="ratingss_ajx_<?=$key?>" class="showratings" style="display:inline !important">
							<div class="star_1 ratings_stars"></div>
							<div class="star_2 ratings_stars"></div>
							<div class="star_3 ratings_stars"></div>
							<div class="star_4 ratings_stars"></div>
							<div class="star_5 ratings_stars"></div>
						</div>
						<script>
						$(function(){
							$('#ratingss_ajx_<?=$key?> div').each(function(k,v){
								var select= <?=floor($product[0]['rating_count'])?>; 
								if(select!=undefined)
								if(k<select)
								{
									$(this).prevAll().andSelf().addClass('ratings_over');
								}
							})
						})
						</script>
						&nbsp;&nbsp;<small>(<?=$this->Template->getReviewText($rcount)?>)</small>
						
					   <div style="clear:left"> 
						<?php echo $this->template->getWord('compare_by');?> <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>"><?php echo $this->Template->getSellerText($merchant_count);?></a> 
					   </div>
					</div>
				</div>
				</div>
					<div class="priceWrap">
						<div class="containerWrap old">
							<div class="price-title"><?php echo $this->template->getWord('before');?></div>
							<div class="price"><div><?php echo $this->Template->getPriceFormat($product['Product']['price']);?></div></div>
						</div>
						
						<div class="containerWrap new">
							<div class="price-title"><?php echo $this->template->getWord('now');?></div>
							<div class="price">
								<div>
									<?php $offer_price = $this->Template->getOfferProductPrice($product['Product']['price'],$product['Offer']);?>
									<?php echo $offer_price;//echo $product['0']['offer_price'];
									$offer_price_val = str_replace(',','',str_replace(' SR','',strip_tags($offer_price)));?>
								</div>
							</div>
						</div>
					</div>
				<a class="noUnderline" href="javaScript:void(0);" 
				
				onClick="clickTrack('<?=$product['Product']['product_url']?>','<?=$product['Product']['id']?>','<?=$product['Product']['retailer_id']?>','<?php echo $offer_price_val?>','<?=$merchant_logo?>','<?=$merchant_website?>','<?=$pimage?>','<?=$pname?>');">
					<div class="grabNow"><?php echo $this->template->getWord('go_to_store');?></div>
				</a>
				
			</div>
		</div>
		<?php
		}
}
else 
{
	echo '0';	
}?>


         