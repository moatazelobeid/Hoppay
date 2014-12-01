
<?php

 
echo $this->element('site-header'); 
$lang = $this->Template->getLang();
//echo $lang;
if($lang=="en"){
    echo $this->Html->css('front-end/offers');
}else
{
     echo $this->Html->css('front-end/offers_ar');
}

$params = $this->params;

if(isset($params) and !empty($params['named']))
	@extract($params['named']);


?>
<style>
#nores
{
	font-size: 16px;
	text-align: center;
}
.search-bar-text
{
	height:33px;
}
.filter_img_cover{

}
</style>

<script type="text/javascript">
function shortBychange(select)
{
	//var url="<?php //echo $this->webroot.$this->Template->getLang?>/homes/offers";
	var url="<?=$this->webroot.$this->Template->getLang()?>/homes/offers";
	var shor=select.options[select.selectedIndex].value;
	var url=url+"/sort:"+shor;
	window.location.assign(url);
}

$(window).load(function () {
  
  $('#limit_start').val(8);
  $('#page').val(1);
  
  //$('.select-box').val("");
});

$(document).ready(function() 
{
	
	var timer = setInterval( hideDiv, 5000);
	
	function hideDiv()
	{
		$aa = $('#nores').hide(3000);
	}

});

//Firefox
/*$('html').on('DOMMouseScroll', function (e) {
    var delta = e.originalEvent.detail;

    if (delta > 0) {

        alert('You scrolled up');
        //$(".grid_inner").append("<p>You scrolled up</p>");

    } else if (delta < 0) {

        alert('You scrolled down');
        //$(".grid_inner").append("<p>You scrolled down</p>");
    }

});

var flag;
//Everything else
$('html').on('mousewheel', function (e) {
    var delta = e.originalEvent.wheelDelta;

    if (flag != 1 && delta < 0) {
        flag = 1;
        alert('You scrolled down');
        //$(".grid_inner").append("<p>You scrolled down</p>");

    } else if (flag != 2 && delta > 0) {
        flag = 2;
        alert('You scrolled up');
        //$(".grid_inner").append("<p>You scrolled up</p>");
    }
});*/



$(window).scroll(function () {
	
  // if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
	  var height=$(document).height();

	  var heightwin=$(window).height()
	  
	 if ($(window).scrollTop() == ((height-100)-(heightwin-100))) {
      //alert('end of page');
	  
	  var limit = parseInt('<?php echo $limit;?>');
	  
	  var page_no = parseInt($('#page').val());
	  
	  var total_count = $('#total_count').val();
	  
	  var limit_start = parseInt($('#limit_start').val());
	  
	  var new_limit_start = parseInt(limit_start)+limit;
	 
	  if(limit_start == page_no*limit)
	  {
		  var new_page_no = page_no+1;
		  $('#page').val(new_page_no)
		  
		  var url = '<?=$this->webroot.$this->Template->getLang()?>/homes/ajaxOffers/'+limit_start+'<?php if(isset($sort))echo '/sort:'.$sort;?>';
		  
		  if(limit_start < total_count)
		  {
			 $('.loadingmore').show();
			 
			 //setTimeout(function(){ 
				  
			  $.get(url,function(data)
			  {
				  //alert(data);
				  if(data != 0)
				  {
					  //alert(data);
					  $('#limit_start').val(new_limit_start);
					  $('#offer_list').append(data);
					  
					  $('.loadingmore').fadeOut(); 
					  
				  }
				  else
				  {
						var nores = '<div id="nores"><br><br>No more offers found.<br><br></div>';
						
						$('. box-bgcolor').append(nores);
						
						$('.loadingmore').fadeOut();  
				  }
			  });
			  
			  //}, 2000);
		  }
		   else
		   {
					var nores = '<div id="nores"><br><br>No more offers found.<br><br></div>';
					
					$('.box-bgcolor').append(nores);
					
					$('.loadingmore').fadeOut();  
		   }
	   
	  }
   }
   else
   {
	   $('.loadingmore').fadeOut();  
   }
});
</script>
        
        <!--  Main Body Panel Start  -->
        <input type="hidden" id="total_count" value="<?php echo $total_products;?>" />
        <input type="hidden" id="limit_start" value="<?php echo $limit;?>" />
        <input type="hidden" id="page" value="1" />
        <div class="bodypanl bodypanl2">
        	<div style="width:100%; margin:0 auto;">
              <section class="clear">
                <div class="grid_inner">
                <div class="col_righttotal" style="border:none; margin-top: 0px; width:100%;padding: 0;margin-left: 0!important;">
               	  <div class="right-content fr" style="width:100%;">
                    
                       <div style="height:5px;" class="clear"></div>  
                      <div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
                        <a class="fs12 c777 f-bold l-hght14" 
                        href="<?php echo $this->webroot;?><?=$this->Template->getLang();?>"> <?php echo $this->template->getWord('home');?> </a> 
                        <span class="breeadset">›</span>
                        <?php /*?><a class="fs12 c777 f-bold l-hght14" href="#" title="Women"> Mobile &amp; Accessories </a> 
                        <span class="breeadset">›</span>
                        <a class="fs12 c777 f-bold l-hght14" href="#" title="Women"> Mobile</a> 
                        <span class="breeadset">›</span><?php */?>
                        <span class="crm_active"><?php echo $this->template->getWord('offers');?></span>
                        <section class="clear"> </section>
                      </div>
                      <div class="fr" style="float: right;">
                        <label class="fl pt5 fs12 f-bold c999"><?php echo $this->template->getWord('sort_by');?> :</label>
                        <select class="select-box" onchange="shortBychange(this)">
                            <option value="popular" <?php if(isset($sort) && $sort == 'popular'){echo 'selected="selected"';}?> ><?php echo $this->template->getWord('popularity');?></option>
                            <option value="phigh" <?php if(isset($sort) && $sort == 'phigh'){echo 'selected="selected"';}?> > <?php echo $this->template->getWord('price_high_to_low');?> </option>
                            <option value="plow" <?php if(isset($sort) && $sort == 'plow'){echo 'selected';}?> > <?php echo $this->template->getWord('price_low_to_high');?></option>
                            <!--<option value="hdiscount"> Discount: High to Low</option>
                            <option value="ldiscount"> Discount: Low to High</option>-->
                        </select>
                      </div>
                       <div style="height:9px;" class="clear"></div>  
                  
                    <div class="box box-bgcolor"> 
                        <!--<section class="full-width sorted-by mt10 pb10">
                          
                          
                          
                          <div class="fr" style="float: right;">
                            <label class="fl pt5 fs12 f-bold c999">View By:</label>
                            <a href="javascript:void(0)" class="listview" title="Listview">&nbsp;</a>
                            <a href="search-result.html" class="gridview" title="Gridview">&nbsp;</a>
                          </div>
                          
                        </section>-->
                        
                        <section class="full-width sorted-by-product mt10 p-list">
                            <div class="dotd-bar1">
                            	<div class="dotd-title">
                                <span class="fllt fk-position-relative"><?php echo $this->template->getWord('best');?></span><div class="ofTheYellow fllt"><?php echo $this->template->getWord('offers');?></div></div>
                                
                                <h3><?php echo $this->template->getWord('one_stop_shop_for_all_our_best_offer');?></h3>
                            </div>
                            
                            <div class="clear"></div>

							<div class="ofrpan">
                            
                            	<div class="row" id="offer_list">
                                
                                	<?php
									if(!empty($products))
									{
										
										$key = 0;
										foreach($products as $key=>$product)
										{
											$key++;
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
											$merchant_count = $this->Template->getProductMerchantCount($product['Product']['id'],$product['Product']['slug']);
											?>
                                            <div class="gd-col gu4 tmargin20 bmargin16 dotdProductModuleNew">
                                                <div class="deal inStock">
                                                        <div class="titleArrows"></div>
                                                        <div class="offerTitleWrap">
                                                            <div><?php echo stripslashes($product['Offer']['offer_title']);?></div>
                                                        </div>
                                                            <div class="offerSubTitle "><?php echo $pname;?></div>
                                                            <div><?php echo $this->template->getWord('by');?> <a href="<?php echo $brand_link;?>"><?php echo $brand_name;?></a></div>
                                                          
		                                                        <a class="noUnderline" href="<?php echo $product_link;?>">
		                                                            <img class="" src="<?php echo $pimage;?>" style="vertical-align: middle;height: 150px;">
		                                                        </a>
                                                          
                                                    <div class="descriptionWrap">
                                                    <div class="description">
                                                        <div style="height: 43px;"><?php //echo wordwrap($pdesc,20, '<br>',true);?>
                                                        
                                                            <div id="ratingss_<?=$key?>" class="showratings" style="display: inline !important;">
                                                                <div class="star_1 ratings_stars"></div>
                                                                <div class="star_2 ratings_stars"></div>
                                                                <div class="star_3 ratings_stars"></div>
                                                                <div class="star_4 ratings_stars"></div>
                                                                <div class="star_5 ratings_stars"></div>
                                                            </div>
															<script>
                                                            $(function(){
																$('#ratingss_<?=$key?> div').each(function(k,v){
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
                                                            
                   <div style="clear: left;"> 
                    <?php echo $this->template->getWord('compare_by');?> <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>"><?php echo $this->Template->getSellerText($merchant_count);?> </a> 
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
                                    }?>
                                </div>
                                
                            </div>
							      
                         <a href="javaScript:void(0);" class="loadingmore" style="display:none;"><?php echo $this->template->getWord('more_items');?></a>                  
                            
                        </div>
                       
                       
                       <div class="clear" style="height:5px;"></div>
                              
                              
                       </div>
                                
                                
                      </div>
                            
                      </div>
                  
                  <div class="clear" style="height:1px;"></div>
               </section>   
          </div>
          <p id="back-top">
          <a href="#top"><span>
              
              <!--<br>Back <br><br>to <br><br>Top-->
              <img src="<?php echo $this->webroot;?>images/front-end/up-arrow.png">
              </span></a>
        </p>
         		</div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:0px;">&nbsp;</div>
        
        <!--  Footer Panel Start  -->
        
        <!--  Footer Panel Start  -->
        <?php echo $this->element('site-footer'); ?>
        <!--  Footer Panel End  -->
        
        
