<?php ini_set('max_execution_time', 600);?>

<?php 
//echo '<pre>'; print_r($product); echo '<pre>';
if(!empty($products))
{
	//echo count($products); exit;
	
	foreach($products as $product)
	{
		$pname = stripslashes($product['Product_lang'][0]['title']);
		
		if(strlen($pname) > 30) 
			$pname = substr($pname,0,30).'..';
		else
			$pname = $pname;
			
		$pdesc = stripslashes($product['Product_lang'][0]['description']);
		
		if(strlen($pdesc) > 40) 
			$pdesc = substr($pdesc,0,40).'..';
		else
			$pdesc = $pdesc;
			
		$pimage = stripslashes($product['Product']['image_url']);
		$pimage = str_replace(array('["','"]'),array('',''),$pimage);
		
		$product_name_slug = $product['Product']['slug'];
		$product_link = '';
		$product_link = $this->webroot.$this->Template->getLang().'/products/'.$product['Product']['id']."-".$product_name_slug;
		
		?>
		<div class="gd-col gu4 tmargin20 bmargin16 dotdProductModuleNew">
			<div class="deal inStock">
					<div class="titleArrows"></div>
					<div class="offerTitleWrap">
						<div><?php echo stripslashes($product['Offer']['offer_title']);?></div>
					</div>
						<div class="offerSubTitle "><?php echo $pname;?></div>
					<a class="noUnderline" href="<?php echo $product_link;?>">
						<img class="" src="<?php echo $pimage;?>" style="vertical-align: middle;height: 150px;">
					</a>
				<div class="descriptionWrap">
				<div class="description">
					<div style="height: 32px;"><?php echo wordwrap($pdesc,20, '<br>',true);?></div>
				</div>
				</div>
					<div class="priceWrap">
						<div class="containerWrap old">
							<div class="price-title">BEFORE</div>
							<div class="price"><div>Rs. <?php echo $product['Product']['price'];?></div></div>
						</div>
						
						<div class="containerWrap new">
							<div class="price-title">NOW</div>
							<div class="price">
								<div>Rs. <?php echo $this->Template->getOfferProductPrice($product['Product']['price'],$product['Offer']);?></div>
							</div>
						</div>
					</div>
				<a class="noUnderline" href="<?php echo $product['Product']['product_url'];?>" target="_blank">
					<div class="grabNow">go to store</div>
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


         