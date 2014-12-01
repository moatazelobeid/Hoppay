<?php 
echo $this->element('site-header');
$lang=$this->Template->getLang();
if($lang=="en")
{
echo $this->Html->css('front-end/shopby-catagories');
echo $this->Html->css('front-end/site_header'); 
}else
{
  echo $this->Html->css('front-end/shopby-catagories_ar');
  echo $this->Html->css('front-end/site_header_ar'); 
}
 ?>
<style>
.paper_box ul
{
	width:100%;
}
.paper_box ul li
{
	/*margin-right:3%;
	width: 17%;
	float:left;*/
	border: none;
	line-height: 17px;
	text-align: center;
}
.sticky-header .select_number
{
	color:#fff;
	background:#ff921d;
}
</style>    
<script type="text/javascript">
var alldata={};

//function innershow1(){
//	$("#innersample").toggle();
//}
function hide1()
{
	$("#innersample").hide('');
}

$(document).ready(function(e){
	$("div.hover-text").hide();
		/*$("div.gimage").hover(function(){
		$(this).find("div.hover-text").slideToggle(500);
	});*/
	
	$("div.gimage").css({'position' : 'relative'});
	$("div.hover-text").css({'position' : 'absolute','bottom' :1});
});



function showdetailspan(){
	$(".showdetailspnel").toggle();
}
function hide1()
{
	$(".showdetailspnel").hide('');
}

</script>


<script type="text/javascript">
function scrollUp(id)
{
	jQuery('html, body').animate({
	scrollTop: jQuery("#"+id).offset().top - 150
	}, 1500);
	$('.hd').removeClass('select_number');
	$('#h'+id).addClass('select_number');
}
$(function(){
		
	$('.letter').each(function(){
			var id=$(this).attr('id');
			var offsets=$(this).offset();
			var height=$(this).height();
			console.log(id);
			console.log(offsets);
			//letter.push(id);
			alldata[id]=offsets.top+height-150;
	})
	//console.log(alldata);
	//console.log(letter);

})
	
function isScrolledIntoView(elem)
    {
        var docViewTop = $(window).scrollTop();
        var stykyTop=  $('.sticky-header').offset().top;    
        var docViewBottom = docViewTop+stykyTop+$('.sticky-header').height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop /*+ $(elem).height()*/;
         console.log(elemBottom);
         console.log(docViewBottom);
        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

$(window).scroll(function(){
    if ($(window).scrollTop() >= 110) {
       $('.sticky-header').addClass('listing_fixed');
    }
    else {
       $('.sticky-header').removeClass('listing_fixed');
    }
    /*$.each(alldata,function(k,v){
		//console.log(k);
			if(isScrolledIntoView('#'+k))
			{
				$('.hd').removeClass('select_number');
		        $('#h'+k).addClass('select_number');
			}

	})*/
	

	//console.log($(window).scrollTop());
	var position=$(window).scrollTop()+$('.sticky-header').height();
	console.log(position);
	var selct="";
	var i=0;
	$.each(alldata,function(k,v){
		console.log(v);
			if(position<=Math.round(v) && i==0)
			{
				selct=k;
				i++;
				//break;
				//console.log(k);
			}

	})
	//console.log(selct);
	$('.hd').removeClass('select_number');
           $('#h'+selct).addClass('select_number');
	var scrollTop     = $(window).scrollTop(),
    elementOffset = $('.brand_sec').offset().top,
    distance      = (elementOffset - scrollTop);
	//alert(distance);	
	
});

$(function() {
	
	$(".back_to_top_btn").click(function(){
		
        jQuery('html, body').animate({
            scrollTop: 0
        }, 600);	
	
	});
	
});

    function backToTop()
    {
        jQuery('html, body').animate({
            scrollTop: 0
        }, 600);	
    }


</script>

<script src="<?=$this->webroot?>js/jquery.scrollToTop.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#toTop").scrollToTop(1000);
	});
</script>
    
    
<!--  Main Body Panel Start  -->
	<div class="bodypanl bodypanl2">
    <div class="grid_inner">
        
        <div class="wrapper">
        	<div style="height:5px;" class="clear"></div>
        	<div class="breadcrumbs fs12 l-hght26" style="">
                        <a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?>en"> Home </a> 
                        <span class="breeadset">›</span>

                        <span class="crm_active">Brands</span>
                        <section class="clear"> </section>
            </div>
           <div class="border45"></div>
            <div class="rowpanel3 leftpatern_MrT new_tag5" style="margin-top:0;">
            <h1>Compare Prices by Brand</h1>
            <p>
                Hoppay help of an approved partner, you can manage your products, making it easier to drive traffic and sales to your online	store.
            </p>
            
            <div class="sticky-header">
            	<span class="styky_touch"> Click on any alphabet: </span>
                <ul>                	
                	<?php
					
					$lang = $this->Template->getLang();
					
					if($lang == 'en')
						$langid = 1;
					else
						$langid = 2;
					
					//$langid = array(1,2);
			  
					foreach (range('A', 'Z') as $char)
					{
						$this->Product_brand = ClassRegistry::init('Product_brand');
				  
				  		$brandcount = $this->Product_brand->find('count', array(
		
										'conditions' => array(
											'Product_brand.status' => 1,
											
											'TRIM(LEADING "-" from Product_brand.slug) LIKE' => strtolower($char).'%'
											),
											
										'order'=>array('TRIM(LEADING "-" from Product_brand.slug)'=>'asc')
										)); 
				  if($brandcount>0)
				  {
						?>
                    	<li><a href="javaScript:void(0);" id="h<?php echo $char;?>" class="hd" onclick="scrollUp('<?php echo $char;?>')"><?php echo $char;?></a></li>
                    <?php } }?>
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="clear" style="height:10px;"></div>
            <div class="shadow2">&nbsp;</div>
            <div class="clear" style="height:10px;"></div>
            
            
            <div class="storesSpotBoxTop">
              <?php foreach (range('A', 'Z') as $char)
			  {
				  $this->Product_brand = ClassRegistry::init('Product_brand');
				  
				  $brandlist = $this->Product_brand->find('all', array(
		
										'conditions' => array(
											'Product_brand.status' => 1,
											//'Product_brand_lang.lang_id' => $langid,
											'TRIM(LEADING "-" from Product_brand.slug) LIKE' => strtolower($char).'%'
											),
											
										'order'=>array('TRIM(LEADING "-" from Product_brand.slug)'=>'asc')
										)); 
										
				  //echo '<pre>'; print_r($brandlist); echo '</pre>';
				  //if(!empty($brandlist))
				  //{
					  $total = count($brandlist);?>
					   <?php if(!empty($brandlist))
								{?>
                      <div class="letter brand_sec" id="<?php echo $char;?>">
                        <div class="big_letter">
							<?php echo $char;?>
                        	<a href="javaScript:void(0);" class="back_to_top_btn">Back to top</a>
                        </div>
                            <div class="paper_box">
                                <!--<ul>-->
                               <?php
									$b=0;
									foreach($brandlist as $brand)
									{
										//Get total product cound belongs to this brand
										$product_count =   $this->Product_brand->getProductCount($brand['Product_brand']['id']);
										//echo '<pre>'; print_r($product_count); echo '</pre>';
										
										if(($b==0) || ($b%5 == 0))
										{
											echo '<ul>';	
										}
										
										$b++;
										/*if(($total<=5) || ($total%5==0))
										{
											$last_row_count = 5;
										}
										else
										{
											$last_row_count = $total%5;
										}*/
										
										/*$border = '';
										if($b <= ($total-$last_row_count))
										{
											$border = '';
										}
										else
										{
											$border = 'style="border-bottom:0px;"';
										}*/
                                        
										$brand_slug = $brand['Product_brand']['slug'];
										
										$pbrand_title = $this->Template->languageChanger($brand['Product_brand_lang']);
										
										$brand_link_title = stripslashes($pbrand_title['brand_title']).'<span> ('.$product_count.')</span>';
										
										$brand_link = $this->webroot.$this->Template->getLang().'/brand-'.$brand_slug;
										
										$brand_img = $brand['Product_brand']['image_url'];
										if(empty($brand_img))
											$brand_img = 'images/image_not_found.jpg';
										?>
										<li <?php //echo $border;?>> 
                                        <div class="brand_img_cover">
                                        	<a href="<?php echo $brand_link;?>" style="display: block;height: 100px;width: 100%;">
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="middle" style="height:100px;vertical-align: middle;">
                                        		<img alt="" src="<?php echo $this->webroot.$brand_img;?>" />

                                        	</td></tr></table></a>
                                        </div>
                                        <?php echo '<a href="'.$brand_link.'">'.$brand_link_title.'</a>';?></li>
									<?php 
									
										if(($b==$total) || ($b%5 == 0))
										{
											echo '</ul>';	
										}

									}?>
                                
                                <!--</ul>-->
                            </div>
                      </div>
                      <?php }
								else
								{
									//echo 'No brand name found.';	
								}?>
              <?php //}
			  }?>
            </div>
              
            <div class="clear" style="height:10px;"></div>

       </div>
        </div>
       
        <div class="clear" style="height:1px;">&nbsp;</div>
        
    </div>
</div>


<!--  Main Body Panel End  -->

<?php echo $this->element('site-footer'); ?>
