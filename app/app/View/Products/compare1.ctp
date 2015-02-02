   <?php $images=json_decode(stripslashes($product['Product']['image_url']));?>
  <meta property="og:title" content="<?=$product['Product_lang']['title']?>" />
  <meta property="og:site_name" content="Hoppay.com"/>
  <meta property="og:url" content="<?=$this->here?>" />
  <meta property="og:description" content="<?=$product['Product_lang']['description']?>" />
  <meta property="fb:app_id" content="690551654362644" />
  <meta property="og:type" content="product" />
  <meta property="og:image" content="<?=$images[0]?>" />

  <meta name="twitter:card" content="product" />
  <meta name="twitter:site" content="" />
  <meta name="twitter:creator" content="" />

  <meta itemprop="name" content="<?=$product['Product_lang']['title']?>">
<meta itemprop="description" content="<?=$product['Product_lang']['description']?>">
<meta itemprop="image" content="<?=$images[0]?>">


  <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.cycle.all.js"></script> 
 <link href="<?=$this->webroot?>css/front-end/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css" media="screen"/>
 <?php /*?><link href="<?=$this->webroot?>owl/owl.carousel.css" rel="stylesheet">
 <link href="<?=$this->webroot?>owl/owl.theme.css" rel="stylesheet"><?php */?>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery-ui-1.8.24.custom.min.js"></script>
  <script type="text/javascript" src="<?=$this->webroot?>js/front-end/rating_details.js"></script>
 <?php /*?><script src="<?=$this->webroot?>owl-carousel/owl.carousel.js"></script><?php */?>
 <?php /* ?> <script type="text/javascript" src="<?=$this->webroot?>rating/jquery.js"></script>  <?php */ ?>
 <?php /*?><link type="text/css" rel="stylesheet" href="<?=$this->webroot?>css/front-end/jquery-ui-1.8.9.custom/jquery-ui-1.8.9.custom.css" /><?php */?>
 
 
 <?php
echo $this->Html->script('front-end/jquery.easing.1.3.js');
echo $this->Html->script('front-end/jquery.contentcarousel.js');
?>

<style> 
a.sorted123
{
	font-weight:bold;
}

.panelstone .maintop1 .delivery_detail, .price_breakup
{
	font-size:11px !important;	
	color: gray;
}

.store_price, .store_price2, .pmain_price_data {
color: #c00;
font-size: 16px;
vertical-align: middle;
height: auto;
text-align: center;
line-height: 18px !important;
}
.pmain_price_data s{
  font-size:18px;
  }
.pmain_price_data {font-size:24px; float: left;;}
.store_price span, .store_price2{font-weight:bold;}
.panelstone .maintop, .panelstone .maintop1
{
	width: 168.8px;
}

 /*
Back to top button 
*/
#back-top {
	position: fixed;
	bottom: 40px;
	/*margin-left: -150px;*/
	right:0;
}
#back-top a {
	width: 50px;
	display: block;
	text-align: center;
	font: 11px/100% Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	text-decoration: none;
	color: #bbb;
	/* background color transition */
	-webkit-transition: 1s;
	-moz-transition: 1s;
	transition: 1s;
}
#back-top a:hover {
	color: #000;
}
/* arrow icon (span tag) */
#back-top span {
	width: 50px;
	height: 80px;
	display: block;
	margin-bottom: 7px;
	background: #ddd url(up-arrow.png) no-repeat center center;
	/* rounded corners */
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
	/* background color transition */
	-webkit-transition: 1s;
	-moz-transition: 1s;
	transition: 1s;
}
#back-top a:hover span {
	background-color: #777;
}


.ratings{height:8px;}

</style>
<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
     $('.ratingContener').ratingDetails({ajaxUrl:'<?=$this->webroot?><?=$this->Template->getLang()?>/products/ajaxGetRatings',lang:'<?=$this->Template->getLang()?>'});
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>
 
 
 
<script>

function scrollToTop()
{
	
}
$(function(){
  $(".form1").validate({
    ignore: "",
    rules: {
        tot_ratings: {
            number:true,
            min:1,
            required:true
        }
    }
});
  $(".form2").validate({
    ignore: "",
    rules: {
        tot_ratings_sel: {
            number:true,
            min:1,
            required:true
        }
    }
});
})

/*function validateRating(){
  var reatit=$('#tot_ratings').val();
  if(reatit=="")
  {
    $('.error').show();
    return false;
  }
  else
  {
      $('.error').hide();
    return true;
  }
}*/
jQuery(document).ready(function() 
{
  
  var timer = setInterval( showDiv, 5000);
  
  function showDiv()
  {
    $aa = jQuery('.message').slideUp();
  }

});

/*function innershow1(){
  $("#innersample").toggle();
}*/
function hide1()
{
  $("#innersample").hide('');
}

/*$(document).ready(function(e){
  //$('#rateit').rating('www.url.php', {maxvalue:5});
  $("div.hover-text").hide();
    $("div.gimage").hover(function(){
    $(this).find("div.hover-text").slideToggle(500);
  });
  
  $("div.gimage").css({'position' : 'relative'});
  $("div.hover-text").css({'position' : 'absolute','bottom' :1});
});*/

function showdetailspan(){
  $(".showdetailspnel").toggle();
}
function hide1()
{
  $(".showdetailspnel").hide('');
}


function scrollUpone(id,sthis)
{
  $('.jumplinks2 a').css('border','0px solid');
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
  jQuery('html, body').animate({
  scrollTop: jQuery("#"+id).offset().top-100
  }, 1000);
}

function scrollUptwo(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
   $("#"+id).find('.compare_accordians').removeClass("plus_colapse");
   $("#"+id).find('.compare_accordians').addClass("minush_colapse");
   $("#"+id).find('.clients_expand_bg').slideDown();
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top - 100
}, 1000);
/*$('.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#opentwotab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#opentwotab").slideDown().addClass('ui-accordion-content-active');
$("#openthreetab").slideUp();
$("#openfourtab").slideUp();*/
}


function scrollUpthree(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
   $("#"+id).find('.compare_accordians').removeClass("plus_colapse");
   $("#"+id).find('.compare_accordians').addClass("minush_colapse");
   $("#"+id).parents('.colaps_class').find('.clients_expand_bg').slideDown();
   
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top-100
}, 1000);
/*$('.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#openthreetab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#openthreetab").slideDown().addClass('ui-accordion-content-active');
$("#opentwotab").slideUp();
$("#openfourtab").slideUp();*/

}


function scrollUpfour(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
  $("#"+id).find('.compare_accordians').removeClass("plus_colapse");
   $("#"+id).find('.compare_accordians').addClass("minush_colapse");
   $("#"+id).parents('.colaps_class').find('.clients_expand_bg').slideDown();
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top+50
}, 1000);
/*$('h3.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('h3.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#openfourtab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#openfourtab").slideDown().addClass('ui-accordion-content-active');
$("#opentwotab").slideUp();
$("#openthreetab").slideUp();*/

}
function imgError(image) {
      image.onerror = "";
      image.src = "<?=$this->webroot?>images/image_not_found.jpg";
      return true;
    }
window.onload=function(){
  $('#mypricewise').click();
  var firstPhoto = $("img");
//console.log(firstPhoto);
if (firstPhoto.complete) {
    // Already loaded, call the handler directly
    handler();
}
else {
    // Not loaded yet, register the handler
  firstPhoto.load(handler);
}
}
function handler() {
     $('.ca-item ul li span.loaded').removeClass('loaded');
}
$(function(){
  if(window.location.hash!="")
  {
    console.log(jQuery("#one").offset().top-100);
    jQuery('html, body').animate({
    scrollTop: jQuery("#one").offset().top-100
    }, 1000);
  }
  
})

</script>


<style type="text/css">
.box-bgcolor {
min-height: 300px;
}

#mask {
  display: none;
  background:#101214; 
  position: fixed; left: 0; top: 0; 
  z-index: 10;
  width: 100%; height: 100%;
  opacity: 0.8;
  z-index: 500000;
}

.login-popup{
  display: none;
  float: left;
  position: fixed;
  top: 6%!important;
  left: 30%;
  margin: 0!important;
  z-index: 500000000000;
  width: 500px;
  -moz-border-radius: 4px;
  padding: 12px;
  border: 3px solid #FFFFFF;
  border-radius: 4px;
  background: #fff;
}

img.btn_close {
  float: right; 
  margin:-7px -8px 0 0;
}

fieldset { 
  border:none; 
}

form.signin .textbox label { 
  display:block; 
  padding-bottom:7px; 
}

form.signin .textbox span { 
  display:block;
}

form.signin p, form.signin span { 
  color:#FFFFFF; 
  font-size:12px; 
  line-height:20px;
} 

form.signin .textbox input { 
  background:#FFFFFF; 
  color:#000000; 
  font:13px Arial, Helvetica, sans-serif;
  padding:8px 5px;
  width:250px;
  outline:none;
  text-shadow:none;
}
.product_topsec_det
  {
    width: 490px;
  }


.sorted-by-product li
{
  width: 145px;
}
 .view_review{position: relative;top: -3px;}
 /*.grid_inner{
  position: static!important;
 }*/
 .right-content{
   position: static;
 }
</style>


<script type="text/javascript">
$(document).ready(function() {
  $('a.login-window').click(function() {
    
    // Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

    //Fade in the Popup and add close button
   removeRatings($(loginBox+' .ratings'));
    //Set the center alignment padding + border
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(500);
    
    return false;
  });
  
  // When clicking on the button close or the mask layer the popup closed
  $('a.close, #mask').live('click', function() { 
    $('#mask , .login-popup').fadeOut(500 , function() {
  }); 
  return false;
  });
});


$(document).ready(function() {
  $('a.login-window1').click(function() {
    
    // Getting the variable's value from a link 
    var loginBox = $(this).attr('href');
removeRatings($(loginBox+' .ratings'));
    //Fade in the Popup and add close button
    $(loginBox).fadeIn(500);
    
     jQuery('html, body').animate({
    scrollTop: $(loginBox).offset().top - 50
    }, 800);
    //Set the center alignment padding + border
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(500);
    
    return false;
  });
  
  // When clicking on the button close or the mask layer the popup closed
  $('a.close, #mask').live('click', function() { 
    $('#mask , .login-popup').fadeOut(500 , function() {
  }); 
  return false;
  });
});
$(document).ready(function() {
  $('a.login-window2').click(function() {
    
    // Getting the variable's value from a link 
    var loginBox = $(this).attr('href');
    removeRatings($(loginBox+' .ratings'));
    var merchantname=$(this).data('merchantname');
    var merchantId=$(this).data('merchantid');
      console.log($(this).data());
    $('.merchant_id_review').val(merchantId);
    $('.merchantname').text(merchantname);
    
    //Fade in the Popup and add close button
    $(loginBox).fadeIn(500);
    
     jQuery('html, body').animate({
    scrollTop: $(loginBox).offset().top - 50
    }, 800);
    //Set the center alignment padding + border
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(500);
    
    return false;
  });
  
  // When clicking on the button close or the mask layer the popup closed
  $('a.close, #mask').live('click', function() { 
    $('#mask , .login-popup').fadeOut(500 , function() {
  }); 
  return false;
  });
});
</script>



<script language="javascript">
$(document).ready(function(){

  $('#slide_details1').cycle({
    fx: 'scrollHorz', /*scrollLeft,scrollDown,scrollRight,scrollUp,blindX, blindY, blindZ, cover, curtainX, curtainY, fade, fadeZoom, growX, growY, none, scrollUp,scrollDown,scrollLeft,scrollRight,scrollHorz,scrollVert,shuffle,slideX,slideY,toss,turnUp,turnDown,turnLeft,turnRight,uncover,ipe ,zoom',*/
    speed:  'slow', 
      timeout: 0,
      next:   '#next', 
      prev:   '#prev',
      pager:  '#thumb',
       
    pagerAnchorBuilder: function(idx, slide) { 
      //console.log($(slide).find('img'));
          return '<li><a href="#"><img src="' + $(slide).find('img').attr('src') + '" width="60" height="60"  alt="" /></a></li>'; 
      }  
  });


}); 
</script>



<script type="text/javascript">

$(document).ready(function(){
$(".ui-accordion-content-active").css('height','300px');
});
    $(function(){

      // Accordion
   /*   $("#accordion").accordion({ header: "h3", autoHeight: false});
      $( "#accordion" ).accordion({
         autoHeight: false,
        navigation: true,
        collapsible: true,
        active: false
      });*/
	  
	  
	  /*$('#accordion').multiAccordion({
				active: [1, 2],
				click: function(event, ui) {
					//console.log('clicked')
				},
				init: function(event, ui) {
					//console.log('whoooooha')
				},
				tabShown: function(event, ui) {
					//console.log('shown')
				},
				tabHidden: function(event, ui) {
					//console.log('hidden')
				}
				
			});
			
			$('#accordion').multiAccordion("option", "active", [0, 2]);*/
	  
	  
	  /*$("#accordion").addClass("ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
  .find("h3")
    .addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
    .hover(function() { $(this).toggleClass("ui-state-hover"); })
    .prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
    .click(function() {
		
      $(this).find(".ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
        
        
        .next().toggleClass("ui-accordion-content-active").slideToggle();
        return false;
    })
    .next()
      .addClass("ui-accordion-content  ui-helper-reset ui-widget-content ui-corner-bottom")
      .hide();*/
	  
	  
	  
	  
	  
    });
	
	  $(document).ready(function(){
		 //$("#demo").accordion("option", "active", [2,3]);
		 //$(".tableHead").addClass('ui-state-active ui-accordion-header');
		// $(".ui-state-content").CSS('display','block');
		
		
		$('#ca-container2').contentcarousel({
    // speed for the sliding animation
    sliderSpeed     : 500,
    // easing for the sliding animation
    sliderEasing    : 'easeOutExpo',
    // speed for the item animation (open / close)
    itemSpeed       : 500,
    // easing for the item animation (open / close)
    itemEasing      : 'easeOutExpo',
    // number of items to scroll at a time
    scroll          : 1 
});

		 
	  });
	
	function colapsh(cthis){
  //alert('dfgfd');
  if($(cthis).hasClass("minush_colapse"))
  {
      $(cthis).removeClass("minush_colapse");
      $(cthis).addClass("plus_colapse");
      $(cthis).parents('.colaps_class').find('.clients_expand_bg').slideUp();
  }
  else
  {
    $(cthis).addClass("minush_colapse");
    $(cthis).removeClass("plus_colapse");
     $(cthis).parents('.colaps_class').find('.clients_expand_bg').slideDown();
  }
}
  </script>

<style type="text/css">
#toTop {
display: none;
position: fixed;
bottom: 5px;
right: 5px;
width: 50px;
height: 50px;
background-image: url(js/scroll.png);
background-repeat: no-repeat;
background-repeat: no-repeat;
}
</style>



  <div class="clear" style="height:1px; background:#fff;"></div>
        
        <!--  Main Body Panel Start  -->
        
        <div class="bodypanl bodypanl2">
        	<div style="width:100%; margin:0 auto;">
              <section class="clear">
                <div class="grid_inner">
                <div class="col_righttotal" style="border:none; margin-top: 0px; width:100%;padding: 0;margin-left: 0!important;">
               	  <div class="right-content fr" style="width:100%;">
                    <?php  $this->Product_category = ClassRegistry::init('Product_category');
                                      $category=$this->Product_category->getPath($product['Product']['category_id']);
                                      
									// echo '<pre>'; print_r($product);exit;

                                       ?>
									   
                       <div style="height:5px;" class="clear"></div>  
                      <div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
                        <a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang()?>"> <?=$this->Template->getWord('home')?> </a> 
                        <span class="breeadset">›</span>
                        <?php 
                        if(!empty($category))
                        foreach ($category as $key => $value) { ?>
                       
                        <?php  $data=$this->Product_category->findByid($value['Product_category']['id']); 
                        //print_r($data['Product_category_lang']);
                          $data['Product_category_lang']=$this->Template->languageChanger($data['Product_category_lang']);
                        ?>
                        <a href="<?=$this->webroot.$this->Template->getLang()?>/products/category-<?=$data['Product_category']['slug']?>" class="fs12 c777 f-bold l-hght14"><?=$data['Product_category_lang']['category_name']?></a>
                     <?php   //echo $this->Html->link($data['Product_category_lang']['category_name'],array('controller' => 'homes','action' => 'productlist','type'=>$data['Product_category']['slug'],'full_base' => true),
                 // array('title'=>$data['Product_category_lang']['category_name'], 'class'=>'fs12 c777 f-bold l-hght14')); ?>
                       
                        <span class="breeadset">›</span>

                          <?php  }
						  
						  
						  ?>
                       <!-- <a class="fs12 c777 f-bold l-hght14" href="#" title="Women"> Mobile</a> 
                        <span class="breeadset">›</span>-->
                        <span class="crm_active"><?=$product['Product_lang']['title']?></span>
                        <section class="clear"> </section>
                      </div>
                      <div class="border45"></div>
                      
                       <div style="height:1px;" class="clear"></div>  
                  
                    <div class="box box-bgcolor"> 
                        <!--<section class="full-width sorted-by mt10 pb10">
                          
                          
                          
                          <div class="fr" style="float: right;">
                            <label class="fl pt5 fs12 f-bold c999">View By:</label>
                            <a href="javascript:void(0)" class="listview" title="Listview">&nbsp;</a>
                            <a href="search-result.html" class="gridview" title="Gridview">&nbsp;</a>
                          </div>
                          
                        </section>-->
                       
                        <section class="full-width sorted-by-product mt10 p-list">
                      <div class="product_topsec" style="margin-top:5px;">
                          <div class="product_img">
                            <div class="slide_details">
                                <div id="slide_details1">
                                  
                                  <?php foreach ($images as $key => $value) { 
								  
								 ?> <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                                 <tr>
                                    <td valign="middle" style="height:100%;vertical-align: middle;">
                            
                                       <img border="0" src="<?=$value?>"  alt="" title="" />
                                 
                                    <td>
                                 </tr>
                              </table>

                                   <?php }?>
                                   
                                    
                                </div>
                                <ul id="thumb">

                                </ul>
                            </div>
                            
                          </div>
                                  
                          <div class="product_topsec_det">
                                    <div itemscope="" itemtype="#">
                                      <div class="mspSingleTitle" id="mspSingleTitle" data-mspid="25149">
                                        <div itemprop="name" class="detailstitle">
                                        <h1><?=ucwords($product['Product_lang']['title'])?></h1>
                                        </div>
                                      </div>

                                      <?php 
                                      $this->Product_brand = ClassRegistry::init('Product_brand');?>

                                      <br clear="all">
                                      <div clear="all" style="height:5px;"></div>
                                      <?php if($product['Product']['brand']!="")
                                      {
										  $brand=$this->Product_brand->findById($product['Product']['brand']); 
										  $brand_link = '';
										  $brand_link = $this->webroot.$this->Template->getLang().'/brand-'.$brand['Product_brand']['slug'];
                      $brand['Product_brand_lang']=$this->Template->languageChanger($brand['Product_brand_lang']);
									  ?>
                                      
                                      
                                      <?=$this->Template->getWord('by')?> <a href="<?php echo $brand_link;?>" style="font-weight: bold;"><?=@$brand['Product_brand_lang']['brand_title']?></a>
                                      <?php } ?>
                                      <div itemprop="aggregateRating" itemscope="">
    <div class="ratingContener" data-type="product" data-id="<?=$product['Product']['id']?>">
         <div id="ratings_tot" class="showratings ratings_tot" style="overflow: visible;
padding: 0px 0px;
position: relative;
width: 75px;
height: 20px;
/* display: inline; */
margin-top: 9px;
float: left;">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                            </div>
                                        <div class="view_review">
                                          <div class="reviewCount" onclick="scrollUpfour('four','')">
                                          	(<?=$ratingcount?>)
                                          </div>
                                          <!-- </div> -->
										  
										  <a class="write_review_button thickbox cleartextbox login-window1 signin_top" style="font-weight:bold;" href="#login-box1">
                                          	<?php echo $this->Template->getWord("write_a_review"); ?>
                                          </a>
                                          
                                           <!--<a class="write_review_button thickbox cleartextbox" style="font-weight:bold;" href="#">
                                          	Add to Favorite 
                                          </a>-->
                                        </div>
                                        <br clear="all">
                                        
                                         <div class="border45"></div>
                                      </div>
                                      <div class="action_bar_border">
                                      </div>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                 
                            <div class="clear" style="height:5px;"></div>                                        
                            <div id="product-description-truncated">
                                 <strong><?php // echo $product['Product_lang']['title']?></strong>
                                 <!--<table class="" cellpadding="2">
                                    
                                                    <tbody>
                                                       <tr height="30">
                                                        
                                                        <td style="font-size: 18px;" colspan="2">-->
														<?php $cdate = date('Y-m-d');
                           // echo "sdkljfsdkf";
                            //print_r($product['Product']);
														if(!empty($product['Product']['offer_id']) && ($product['Product']['Offer']['end_date'] >= $cdate) && ($product['Product']['Offer']['status'] == 1))
														{
															$pprice = $product['Product']['offer_price'];
															
															//if(is_float($pprice))
																//$pprice = number_format($pprice,2);
															
															echo '<div class="pmain_price_data">';
                              
															echo '<s>'.$this->Template->getPriceFormat(number_format($product['Product']['price'],2)).'</s><b>('.$product['Product']['Offer']['discount'].'%)</b>';
															echo '<span>'.$this->Template->getPriceFormat(number_format($pprice,2));
															echo '</span></div>';
														}
														else
														{
															$pprice = $product['Product']['offer_price'];
															
															//if(is_float($pprice))
																$pprice = number_format($pprice,2);
															
															echo '<div style="font-size: 25px;color: #FF8322;">'.$this->Template->getPriceFormat($pprice).'</div>';
														}?>
                                                        <div class="clear" style="height:10px;"></div>
                                                        <?php echo $this->template->summary($product['Product_lang']['description'],200);?>
                                                        <div class="clear" style="height:5px;"></div>
                                                        <!--</td>
                                                       </tr>-->
                                                      <?php
                                                        $product_details=htmlspecialchars_decode($product['Product_lang']['product_details']);
                                                       // print_r($product_details);
                                                        $product_details=json_decode($product_details);
                                                       //  print_r($product_details);
                                                        if(!empty($product_details))
                                                        {
															$pd = 0;
                              echo "<table style='border-top: 1px solid #ccc;
width: 100%;'>";
                                                       foreach ($product_details as $key => $value) { 
													  
													   if($pd<5)
													   {   
                               echo "<tr>";
                              ?>

                                                       <?php /*?><tr height="30">
                                                        <td class="featureName"><?=ucfirst($key)?>:</td>
                                                        <td class=""><?=$value?></td>
                                                       </tr><?php */?>
                                                       
                                                       <?='<td width="35%">'.ucfirst($key)?></td> <td><?=$value?></td>
                                                     </tr>
                                                      <?php $pd++;}
                              
													   }
                             echo "</table>";
													   }

                                                       if(empty($product_details) and $product['Product_lang']['description']=="")
                                                          {
                                                            echo "<span>No Details Available</span>";
                                                          }
                                                      ?>
                                                      <!--<tr></tr>
                                            </tbody>
                                            </table>-->
                                            <?php //if(count($product_details) > 5)
											//{?>
                                                <div class="clear" style="height:10px;"></div>
                                            	<a href="javaScript:void(0);" onclick="scrollUpthree('three','')"><?php echo $this->Template->getWord("view_more_details"); ?></a>
                                            <?php //}?>
                            </div>
                            
                            <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=690551654362644&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
                          
                                    <div class="clear" style="height:5px;"></div>   
                                    <div class="border45"></div>
                                    <div class="key_text">
                                    	<div class="social_details" style="float:left;">
                            <div style="width:auto; float:left; padding-top:10px;">
                                              <div class="fb-like" data-href="<?=$this->here?>" data-width="50" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                                        <style type="text/css">
                                        #twitter-widget-0{
                                          width:79px!important;
                                        }
                                        </style>
                   <a href="<?=$this->here?>" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                        
                                                    <!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?=$this->here?>"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
                                            </div>
                            
                    </div>
                                    </div>
                                    <br clear="all">
                                    <br clear="all">
                        </div>
                        
                          <div class="detailspricepan">
                            <h1 class="prod_price">
                                <b><?php echo $this->Template->getWord("where_to_buy"); ?></b>
                             </h1>
                             <h2><?php echo $this->Template->getWord("lowest_price"); ?></h2>
                             
                            <h3>    
							
							                        
                                <?php $min_price = min($price); 
								$pname = '';
								$pimage = '';
								$merchant_website = '';
								$merchant_logo = '';
								
								//get product details of the min product price
								//echo '<pre>'; print_r($merchantids);	exit;
								if(!empty($merchantids))
								{
									foreach($merchantids as $merchantid_data)
									{
										if($merchantid_data['Product']['offer_price'] == $min_price)
										{
											$min_price_pid = $merchantid_data['Product']['id'];
											$min_price_purl = $merchantid_data['Product']['product_url'];
											$min_price_mid = $merchantid_data['Product']['retailer_id'];
											$min_price_price = $min_price;
											$merchantid_data['Product_lang']=$this->Template->languageChanger($merchantid_data['Product_lang']);
											$pname = $merchantid_data['Product_lang']['title'];
											
											$pimages = json_decode($merchantid_data['Product']['image_url']);
											
											$pimage = $pimages[0];
											
											//echo '<pre>'; print_r($merchantid_data);	exit;
											$merchant_logo = $merchantid_data['Merchant']['image_url'];	
											$merchant_website = $merchantid_data['Merchant']['website_name'];
											
										}
                      $allImg[]=$merchantid_data['Merchant']['image_url'];
                      $allName[]=$merchantid_data['Merchant']['website_name'];
									}
								}
								
									   
								
								
								
								//if(is_float($min_price))
									$min_price = number_format($min_price,2);
								
								echo $this->Template->getPriceFormat($min_price);
								?>
                      </h3>  

								<?php if(!empty($min_price_purl))
                                {
                                  if(count($merchantids)>1)
                                  { ?>
                    <div id="sellerLogoRating" style="margin:10px 0px" >                      
                      <img title="<?=$merchant_website?>" src="<?=$this->webroot?><?=($merchant_logo!="")?$merchant_logo:'img/no-image.png'?>" alt="<?=$merchant_website?>"  style="display:block; margin:0 auto;max-height: 80px;max-width: 98px;">
                    </div>
                                  <?php }
                                  ?>

                                    <a href="javaScript:void(0);" 
									onClick="clickTrack('<?=$min_price_purl?>','<?=$min_price_pid?>','<?=$min_price_mid?>','<?=$min_price_price?>','<?=$merchant_logo?>','<?=$merchant_website?>','<?=$pimage?>','<?=addslashes($pname)?>');"
									class="shop_by_btn_plus" ><?=$this->Template->getWord('buy_on_seller');?></a>
                                <?php }?>
                                    
                           <div class="clear" style="height:10px"></div>
                                <?php if(count($merchantids)!=1) {
 
                                 // print_r($allImg);
                                 /* foreach($allImg as $key=>$val)
                                  {
                                  ?>
                                 
                               <!--    <div class="sellerLogoRating" class="">                      
                      <img title="<?=$allName[$key]?>" src="<?=$this->webroot?><?=($val!="")?$val:'img/no-image.png'?>" alt="<?=$allName[$key]?>" style="display:block; margin:0 auto;max-height: 80px;max-width: 98px;">
                    </div> -->
                                  <?php } */?>
                                  <div style="text-align: center;"><img src="<?=$this->webroot?>images/or.png" style="width: 47px;" alt="" ></div>
                            <a href="#" class="linkonline" onclick="scrollUpone('one')"> <?=$this->Template->getWord('compare_all')?> <?=count($merchantids)?> <?=$this->Template->getWord('sellers')?> >></a>
                            <?php }else{ ?>

                <?php  
                                                $this->Merchant = ClassRegistry::init('Merchant');
                                                 $this->Reviewed_user = ClassRegistry::init('Reviewed_user');
                                     // $category=$this->Merchant->getPath($product['Product']['category_id']);
                                     //echo '<pre>';print_r($merchantids); echo"</pre>";

                                       ?>
                                        <?php foreach ($merchantids as $key => $value) { 
                                         // $this->Merchant->recursive=0;
                                       
                                               $merchant=$this->Merchant->findById($value['Product']['retailer_id']);
                                               $merchant_img=$merchant['Merchant']['image_url'];
                                              
                                               $productrate=$this->Reviewed_user->Merchant_rating->findAllByMerchantIdAndStatus($value['Product']['retailer_id'],1);
                                              $rresults = Hash::extract($productrate, '{n}.Merchant_rating.rating');
                                              $rcount=count($rresults);
                                              if($rcount>0)
                                              $avgrate=(array_sum($rresults)/count($rresults));
                                              else
                                                $avgrate=0;

                                                                                           
                        $pname = '';
                        $pimage = '';
                        $merchant_website = '';
                        $merchant_logo = '';
                        $value['Product_lang']=$this->Template->languageChanger($value['Product_lang']);
                        $pname = $value['Product_lang']['title'];
                        
                        $pimages = json_decode($value['Product']['image_url']);
                        
                        $pimage = $pimages[0];
                        
                       // echo '<pre>'; print_r($merchant);  exit;
                        $merchant_logo = $value['Merchant']['image_url']; 
                        $merchant_id = $value['Merchant']['id']; 
                        $merchant_website = $value['Merchant']['website_name'];
                                               
                                               ?>
                  <?php $shipping_name = '';
                           if(!empty($value['Product']['shipping_name']))
                           {
                            $shipping_name = $value['Product']['shipping_name'];   
                           }
                           else
                           {
                            if(!empty($merchant['Product_store']['shipping_details']))
                              $shipping_name = $merchant['Product_store']['shipping_details'] ;  
                           }
                           
                           
                           ?>
                <div>
                    <div class="sellerInfo">
                    	<?php echo $shipping_name;?>
                                                <?php if(!empty($shipping_price))
                        {?>
                                                  <br>(<?=$this->Template->getPriceFormat($shipping_price)?>)
                                                <?php }
                        if(!empty($merchant['Product_store']['shipping_price']))
                        {?>
                                                <br><?=stripslashes($merchant['Product_store']['shipping_time'])?>
                                                <?php }
                        
                        if(empty($shipping_name) && empty($shipping_price) && empty($merchant['Product_store']['shipping_time']))
                        {
                          //echo 'N/A'; 
                        }?>
                    </div>
                    <div class="clear" style="height:10px;"></div>
                    
                    <div id="sellerLogoRating" class="" style="text-align:center">                      
                      <img src="<?=$this->webroot?><?=($merchant_img!="")?$merchant_img:'img/no-image.png'?>" alt="Cart2India" style="display:block; margin:0 auto;max-height: 90px;max-width: 120px;">
                    </div>
                    
                    <div class="clear" style="height:1px;"></div>
                    <?php $lang=$this->Template->getLang(); ?>
                    <div itemprop="aggregateRating" itemscope="">
            <div class="ratingContener"  data-type="merchant" data-id="<?=$merchant_id?>">          
    					  <div id="ratingss_<?=$key?>"  data-rating="<?=floor($avgrate)?>" class="showratings ratings_tot rtngs23">
        						<div class="star_1 ratings_stars"></div>
        						<div class="star_2 ratings_stars"></div>
        						<div class="star_3 ratings_stars"></div>
        						<div class="star_4 ratings_stars"></div>
        						<div class="star_5 ratings_stars"></div>
    					  </div>
           </div>
          <script>
                                                      $(function(){
                                                       
                                                         $('#ratingss_<?=$key?> div').each(function(k,v){
                                                             var select= <?=floor($avgrate)?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                      })

                                                    </script>
				
					<div class="view_review">
					  <div class="reviewCount" onclick="scrollUpfour('four','')">
						(<?=$rcount?>)
					  </div>
					  <!-- </div> -->
					  
					</div>

					 <div class="clear"></div>
            <a class="thickbox cleartextbox signin_top login-window2" 
            data-merchantId="<?=$merchant_id?>" data-merchantName="<?=ucfirst($merchant_website)?>" href="#merchant-reviews" style="text-align:center;display:block"><?=$this->Template->getWord('rate_this_seller');?></a>
            <div class="clear" style="height:5px"></div>
				  </div>
                    
                </div>
                
                
        
    </div>

                           <?php } } ?>
                               
                            </div>
                          </div>
                          
                       </div>
                       
                       <div class="jumplinks2">
                            <span style="color:#0066CC;"> <?php echo $this->Template->getWord("quick_links"); ?> :</span>
                            <?php if(count($merchantids)!=1) {?>
                            <a href="#" onclick="scrollUpone('one',this)"><?=$this->Template->getWord('compare')?></a> &nbsp; | &nbsp;<?php } ?>
                           
                            <a href="#" onclick="scrollUpthree('three',this)"> <?php echo $this->Template->getWord("product_details"); ?> </a>&nbsp; | &nbsp;
                             <a href="#" onclick="scrollUptwo('two',this)"><?php echo $this->Template->getWord("related_products"); ?> </a> &nbsp; | &nbsp;
                            <a href="#" onclick="scrollUpfour('four',this)"><?php echo $this->Template->getWord("customer_reviews"); ?> </a> 
                        </div>
                       <script>
                        $(function(){
                         /* $('#mypricewise').click(function(){
                            $('.selctchoose').removeClass('active');
                            $(this).addClass('active');
                              $('#ratingWise').fadeOut('first',function(){
                                 $('#priceWise').fadeIn('slow');

                              });
                             
                          })*/
                        /*  $('#mysellerwise').click(function(){
                             $('.selctchoose').removeClass('active');
                              $(this).addClass('active');
                              $('#priceWise').fadeOut('first',function(){

                                $('#ratingWise').fadeIn('slow');
                              });
                              
                             
                          })*/


                        })
                        $(function(){
							
                          $('.pricedot,#mysellerwise').click(function(){
							  
							  $('.pricedot').removeClass('sorted123');
							  
                              var trs=$('table.panelstone').find('tr:not(:first-child)');  
                               var select= $(this).data('select');
                             if(select=='top')
                             {
                               $('#mypricewise').removeClass('active');
                               $('#mysellerwise').addClass('active');
                               $('.pricedot').addClass('desc');
                             }
                             else
                             {
                                $('.pricedot').toggleClass('desc');
                             }
                           
							  
							   $('.pricedot').addClass('sorted123');
							   $('.totalprice').removeClass('sorted123');
							   $('.sellerrating').removeClass('sorted123');
							  
                          
                          //console.log(trs);
                            rat=[];
                            trs.each(function(k,v){
                              rat[k]={};
                              rat[k]['key']=k;
                              rat[k]['val']=$(v).find('td div.showratings').data('rating');
                              rat[k]['tag']=v;
                            // rat.push({k:$(v).find('td div.showratings').data('rating')});
                            v.remove();
                            })
                           //console.log(rat);
                           var clas=$('.pricedot').attr('class')
                           clas=clas.split(' ');
                           if(clas[1]=="desc")
                           {
                           rat.sort(function(a, b){if (
                            a.val < b.val)
                            return 1;
                          if (a.val > b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                         else
                         {
                          rat.sort(function(a, b){if (
                            a.val > b.val)
                            return 1;
                          if (a.val < b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                           console.log(rat);
                            for(var x in rat)
                            {



                             $('table.panelstone').append(rat[x].tag);
                              
                            }
                           // rat.each(function(k,v){
                              //$('#priceWise').find('tr:not(:first-child)').find('')
                           // })
                          })
						  
							
                          $('.totalprice').click(function(){
							  
							  
							   $('.totalprice').removeClass('sorted123');
							  
                              var trs=$('table.panelstone').find('tr:not(:first-child)');  
                             var select= $(this).data('select');
                             if(select=='top')
                             {
                               $('.totalprice').removeClass('desc');
                             }
                             else
                             {
                               $('.totalprice').toggleClass('desc');
                             }
							  
							   $('.pricedot').removeClass('sorted123');
							   $('.totalprice').addClass('sorted123');
							   $('.sellerrating').removeClass('sorted123');
							  
                              //if()
                              
                          
                         // console.log(trs);
                            rat=[];
                            trs.each(function(k,v){
                              rat[k]={};
                              rat[k]['key']=k;
                              rat[k]['val']=$(v).find('td div.store_price2').data('price');
                              rat[k]['tag']=v;
                            // rat.push({k:$(v).find('td div.showratings').data('rating')});
                            v.remove();
                            })
                          //console.log(rat);
                           var clas=$('.totalprice').attr('class')
                           clas=clas.split(' ');
                           if(clas[1]=="desc")
                           {
                           rat.sort(function(a, b){if (
                            a.val < b.val)
                            return 1;
                          if (a.val > b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                         else
                         {
                          rat.sort(function(a, b){if (
                            a.val > b.val)
                            return 1;
                          if (a.val < b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                          // console.log(rat);
                            for(var x in rat)
                            {
                             $('table.panelstone').append(rat[x].tag);
                              
                            }
                           // rat.each(function(k,v){
                              //$('#priceWise').find('tr:not(:first-child)').find('')
                           // })
                          })
						  
						  
                           $('.sellerrating,#mypricewise').click(function(){
							   
							   $('.sellerrating').removeClass('sorted123');
							   
                              var trs=$('table.panelstone').find('tr:not(:first-child)');  
                             var select= $(this).data('select');
                             if(select=='top')
                             {
                               $('#mysellerwise').removeClass('active');
                               $('#mypricewise').addClass('active');
                               $('.sellerrating').removeClass('desc');
                             }
                             else
                             {
                               $('.sellerrating').toggleClass('desc');
                             }
							  
							   $('.pricedot').removeClass('sorted123');
							   $('.totalprice').removeClass('sorted123');
							   $('.sellerrating').addClass('sorted123');
							  
                              //if()
                              
                          
                         // console.log(trs);
                            rat=[];
                            trs.each(function(k,v){
                              rat[k]={};
                              rat[k]['key']=k;
                              rat[k]['val']=$(v).find('td div.store_price').data('price');
                              rat[k]['tag']=v;
                            // rat.push({k:$(v).find('td div.showratings').data('rating')});
                            v.remove();
                            })
                         // console.log(rat);
                           var clas=$('.sellerrating').attr('class')
                           clas=clas.split(' ');
                           if(clas[1]=="desc")
                           {
                           rat.sort(function(a, b){if (
                            a.val < b.val)
                            return 1;
                          if (a.val > b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                         else
                         {
                          rat.sort(function(a, b){if (
                            a.val > b.val)
                            return 1;
                          if (a.val < b.val)
                            return -1;
                          // a must be equal to b
                          return 0;});
                         }
                         //console.log(rat);
                            for(var x in rat)
                            {
                             $('table.panelstone').append(rat[x].tag);
                              
                            }
                           // rat.each(function(k,v){
                              //$('#priceWise').find('tr:not(:first-child)').find('')
                           // })
                          })
                        })
                       </script>
                       
                       
                               
                              <?php if(count($merchantids)!=1) {?>
                              <div class="border45" id="one"></div>
                              <div class="clear" style="height:1px;"></div>
                               <div class="tableHead" id="techSpec">
                               </span> <?=$this->Template->getWord('compare_prices_from')?> 
                               <?=count($merchantids)?> <?=$this->Template->getWord('online_sellers')?>
                                
                                <div class="price_table_out tabbox" id="four price_table_ou" style="float: right;width: 25%;position: relative;bottom: 8px;">
                                  <div class="jumplinks" id="jmp_product_stores">
                                    <span><?=$this->Template->getWord('sort_by')?>: </span>
                                    <a href="javascript:void(0)" id="mypricewise" data-select="top" class="selctchoose active"><?=$this->Template->getWord('price')?></a> &nbsp; | &nbsp;
                                    <a href="javascript:void(0)" id="mysellerwise" data-select="top" class="selctchoose"><?=$this->Template->getWord('seller_ratings')?></a>
                                </div>
                                  
                                  
                                    
                                 <div class="clear" style="padding:4px 0px;"></div>
                                  </div>
                              </div>
                              
                                <div class="clients_expand_bg" style="height:auto;">
                                     <div>
                                  
                                        <div class="clear" style="height:5px;"></div>
                                      
                                         <table class="panelstone"  id="priceWise" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="maintop" style="font-weight:normal;"><?=$this->Template->getWord('seller')?></td>
                                                <td class="maintop" style="font-weight:normal;"><a href="javascript:void(0)" data-select="bottom" class="pricedot"><?=$this->Template->getWord('seller_ratings')?></a></td>
                                                <td class="maintop" style="font-weight:normal;">
                                                  <a href="javascript:void(0)" data-select="bottom" class="sellerrating sorted123"><?=$this->Template->getWord('price')?></a>
                                                 <!-- <span class="sellerrating">Price</span>--></td>
                                               <!--  <td class="maintop" style="font-weight:normal;">
                                                  <a href="javascript:void(0)" data-select="bottom" class="totalprice">Total Price</a>
                                                </td> -->
                                                
                                                <td class="maintop" style="font-weight:normal;">
                                                  <?=$this->Template->getWord('estimated_delivery')?></td>
                                                <td class="maintop" style="font-weight:normal;">
                                                  <?=$this->Template->getWord('payment_method')?></td>
                                                <!--<td class="maintop">Details</td>-->
                                                <td class="maintop" style="font-weight:normal;">
                                                   <?=$this->Template->getWord('buy_now')?></td>
                                            </tr>
                                                <?php  
                                                $this->Merchant = ClassRegistry::init('Merchant');
                                                 $this->Reviewed_user = ClassRegistry::init('Reviewed_user');
                                     // $category=$this->Merchant->getPath($product['Product']['category_id']);
                                      //echo '<pre>';print_r($merchantids);

                                       ?>
                                            <?php foreach ($merchantids as $key => $value) { 
                                               $merchant=$this->Merchant->findById($value['Product']['retailer_id']);
                                               $merchant_img=$merchant['Merchant']['image_url'];
                                               $productrate=$this->Reviewed_user->Merchant_rating->findAllByMerchantIdAndStatus($value['Product']['retailer_id'],1);
                                              $rresults = Hash::extract($productrate, '{n}.Merchant_rating.rating');
                                              $rcount=count($rresults);
                                              if($rcount>0)
                                              $avgrate=(array_sum($rresults)/count($rresults));
                                              else
                                                $avgrate=0;

                                                                                           
												$pname = '';
												$pimage = '';
												$merchant_website = '';
												$merchant_logo = '';
												 $value['Product_lang']=$this->Template->languageChanger($value['Product_lang']);
                        $pname = $value['Product_lang']['title'];
												
												
												$pimages = json_decode($value['Product']['image_url']);
												
												$pimage = $pimages[0];
												
												//echo '<pre>'; print_r($merchantid_data);	exit;
												$merchant_logo = $value['Merchant']['image_url'];	
                        $merchant_id = $value['Merchant']['id'];
												$merchant_website = $value['Merchant']['website_name'];
																						   
																						   ?>
                                              
                                            <tr>

                                                <td class="maintop1">
                                                    <a href="#" target="_blank" class="left">
                                                        <img src="<?=$this->webroot?><?=($merchant_img!="")?$merchant_img:'img/no-image.png'?>" alt="tradus" style="height: 52px;">
                                                   </a>
                                                </td>
                                                 <td class="maintop1" align="center">
                                                    <div class="store_info">
                                 <div class="ratingContener" data-type="merchant" data-id="<?=$merchant_id?>">
                                                     <div id="ratingss_<?=$key?>" data-rating="<?=floor($avgrate)?>" class="showratings">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                    </div>
                                                    <script>
                                                      $(function(){

                                                         $('#ratingss_<?=$key?> div').each(function(k,v){
                                                             var select= <?=floor($avgrate)?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                      })

                                                    </script>
                                                    <span style="position: relative;left: -17px;color: gray;font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?=$rcount?>)</span>
                                                    <div class="clear"></div>
            <a class="thickbox cleartextbox signin_top login-window2" 
            data-merchantId="<?=$merchant_id?>" data-merchantName="<?=ucfirst($merchant_website)?>" href="#merchant-reviews" style="/*text-align:center;display:block*/"><?=$this->Template->getWord('rate_this_seller')?></a>
                                                  </div>
                                                </td> 
                                                <td class="maintop1">
                                                
                                                      <?php 
													  $product_price = '';
													 // $product_price = $this->Template->getProductPrice($value['Product']['price'],$value['Offer']);
													 
													 if(!empty($merchant['Product_store']['shipping_price']))
													 	$shipping_price = $merchant['Product_store']['shipping_price'];
													  else
													  	$shipping_price = 0;
													$product_price = '';
													$cdate = date('Y-m-d');
													if(!empty($value['Product']['offer_id']) && ($value['Offer']['end_date'] >= $cdate) && ($value['Product']['status'] == 1)) 
													{
														$product_price = $value['Product']['offer_price'];  
														
														//if(is_float($product_price))
                            $product_price_filter=$product_price;
															$product_price = number_format($product_price,2);
														
														$price_data = '<s>'.$this->Template->getPriceFormat(number_format($value['Product']['price'],2)).' ('.$value['Offer']['discount'].'%)</s><br>';
														$price_data .= '<span>'.$this->Template->getPriceFormat($product_price).'</span>';
													}
													else
													{
														$product_price = $value['Product']['price'];  
														
														//if(is_float($product_price))
                              $product_price_filter=$product_price;
														 	$product_price = number_format($product_price,2);
														
														$price_data = '<span>'.$this->Template->getPriceFormat($product_price).'</span>';
													}

													  
													  ?>
                                                
                                                    <div class="store_price" data-price="<?=$product_price_filter?>">
                                                      <?php echo $price_data;?>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="price_breakup">
                                                     <?php $shipping_name = '';
													 if(!empty($value['Product']['shipping_name']))
													 {
														$shipping_name = $value['Product']['shipping_name'];	 
													 }
													 else
													 {
														if(!empty($merchant['Product_store']['shipping_details']))
															$shipping_name = $merchant['Product_store']['shipping_details']	;	 
													 }
													 
													 if(!empty($value['Product']['shipping_cost']))
													 	$shipping_price = $value['Product']['shipping_cost'];
													 
													 
													 if(!empty($shipping_name))
													 {
													 	echo '+ '; 
													 
														 if(!empty($shipping_price)) 
														 {
															echo $this->Template->getPriceFormat($shipping_price)." "; 
														 } 
													 
													 	echo $shipping_name;
													 }
													 $tax_price = 0;
													if(!empty( $value['Product']['tax']) && ($value['Product']['tax']>0) && ($value['Product']['tax']!= 'yes'))
													{
														$tax_price_val = (str_replace(',','',$product_price)*$value['Product']['tax'])/100;

														
														if(!empty($tax_price_val))
															$tax_price = $this->Template->getPriceFormat($tax_price_val); 
															
														echo '<div class="clear"></div>+ '.$tax_price.' tax';
													}
													else
													{
														$tax_price_val = 0;
														$tax_price = 0;	
													}
													//echo $total_price1 = str_replace(',','',$product_price).'+'.$shipping_price.'+'.$tax_price_val;
													$total_price = str_replace(',','',$product_price)+$shipping_price+$tax_price_val;
													
													//if(is_float($total_price))
                            $total_price_filter= str_replace(',','',(string)$total_price);
                            //echo  $total_price_filter;
														$total_price = number_format($total_price,2);
													 ?>
                                                    </div>
                                                </td>
                                              <?php /* ?> <td class="maintop1">
                                                <div class="store_price2" data-price="<?=$total_price_filter?>"><?=$this->Template->getPriceFormat($total_price)?></div>
                                                </td><?php */ ?>
                                               
                                                <td class="maintop1">
                                                <div class="delivery_detail">
												<?php //echo $shipping_name;?>
                                                <?php if(!empty($shipping_price))
												{?>
                                                <!-- 	<br>(<?php //echo $this->Template->getPriceFormat($shipping_price)?>) -->
                                                <?php }
												if(!empty($merchant['Product_store']['shipping_price']))
												{?>
                                                <br><?=stripslashes($merchant['Product_store']['shipping_time'])?>
                                                <?php }
												
												if(empty($shipping_name) && empty($shipping_price) && empty($merchant['Product_store']['shipping_time']))
												{
													echo 'N/A';	
												}
                        else if($shipping_name!=""){
                            echo $shipping_name;
                        }?>
                                                </div>
                                                </td>
                                                <td class="maintop1">
												
												<?php $payment_methods = json_decode($merchant['Product_store']['payment_details']);
												//print_r($payment_methods);
												if(!empty($payment_methods))
												{
													$cod  = 0;
													foreach($payment_methods as $pmethod=>$pval)
													{
														if($pval == 1)
														{
															if($pmethod == 'visa')
															{
																echo '<img src="'.$this->webroot.'images/front-end/Payment-method/visa.jpg" style="height:15px; width:26px;" alt="" > ';
															}
															if($pmethod == 'paypal')
															{
																echo '<img src="'.$this->webroot.'images/front-end/Payment-method/paypal.jpg" style="height:15px; width:26px;" alt="" > ';
															}
															if($pmethod == 'mastercard')
															{
																echo '<img src="'.$this->webroot.'images/front-end/Payment-method/mastercard.jpg" style="height:15px; width:26px;" alt="" > ';
															}
															if($pmethod == 'SADAD')
															{
																echo '<img src="'.$this->webroot.'images/front-end/Payment-method/sadad.gif" style="height:15px; width:26px;" alt="" > ';
															}
															if($pmethod == 'wire_transfer')
															{
																echo '<img src="'.$this->webroot.'images/front-end/Payment-method/wire_transfer.png" style="height:15px; width:26px;" alt="" > ';
															}
															if($pmethod == 'cod')
															{
																$cod = 1;
															}
														}
													}
													if($cod == 1)
													{
														echo '<div style="height:1px;" class="clear "></div> <span class="delivery_detail">Cash On Delivery</span>';	
													}
													
												}
												else
												{
													echo '<span class="delivery_detail">N/A</span>';	
												}
												?>
                                                
                                                </td>
                                                <td class="maintop1" style="padding-right:0;">
                                                    <a class="buynow" href="javaScript:void(0);" 
                                                    onClick="clickTrack('<?=$value['Product']['product_url']?>','<?=$value['Product']['id']?>','<?=$value['Product']['retailer_id']?>','<?=$product_price?>','<?=$merchant_logo?>','<?=$merchant_website?>','<?=$pimage?>','<?=addslashes($pname)?>');" title="Shop Now"><img src="<?=$this->webroot?>images/front-end/cart.png" alt=""><?=$this->Template->getWord('buy_on_seller');?></a>
                                                </td>
                                            </tr>
                                            
                                           <!-- <tr>
                                            	<td colspan="7"><div class="borderrpt"></div></td>
                                            </tr>-->
                                            
                                            <?php  }?>
                                        
                                            
                                          </table>
                                          <!-- Short by reatings-->

                                   </div>
                                </div>
                                <?php } ?>
                                
                                
                               
                               <div class="clear" style="height:1px;"></div>
                               
                               
                              <div id="accordion">
                              	<!-- Product Details Accordian-->
                                    
                                  <div class="colaps_class">
                                        <h3>
                                        	<a href="javascript:void(0)" id="three">
                                        	<div class="tableHead" id="techSpec">
                                              <span class="compare_accordians minush_colapse" onclick="colapsh(this)"></span>
                                              <?=$this->Template->getWord('product_details')?>  
                                            </div>
                                              <div class="clear"></div>
                                        	</a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto;" id="openthreetab">
                                             <div class="description">
                                                 <p itemprop="description" style="padding-top:15px;">
                                                  <?=htmlspecialchars_decode($product['Product_lang']['description'])?>
                                                  
                                                </p>
                                                
                                                
                                                
                                                <div class="clear"></div>
                                             </div>
                                                             


                                              <table class="detailstab">
                                    
                                                    <tbody>
                                                      <?php
                                                        $product_details=htmlspecialchars_decode($product['Product_lang']['product_details']);
                                                       // print_r($product_details);
                                                        $product_details=json_decode($product_details);
                                                       //  print_r($product_details);
                                                        if(!empty($product_details))
                                                        {
                                                       foreach ($product_details as $key => $value) { ?>

                                                       <tr>
                                                        <td class="featureName"><?=$key?></td>
                                                        <td class="featureValue"><?=$value?></td>
                                                       </tr>

                                                      <?php } }

                                                       if(empty($product_details) and $product['Product_lang']['description']=="")
                                                          {
                                                            echo "<span>No Details Available</span>";
                                                          }
                                                      ?>
                                            </tbody>
                                            </table>
                                        </div>
                              		</div>
                                    
                                    <!--  3rd tab end  -->
                                        <div id="two" class="colaps_class">
                                        <h3>
                                          <a href="javascript:void(0)">
                                          <div class="tableHead colaps_class" id="techSpec">
                                               <span class="compare_accordians minush_colapse" onclick="colapsh(this)"></span> <?php echo $this->Template->getWord("related_products"); ?> 
                                                </div>
                                              <div class="clear"></div>
                                          </a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto; padding-top:20px;" id="opentwotab">
                                             <section class="full-width sorted-by-product mt10 p-list">
                                                <?php $total_product = count($products);?>
        <?php 
         $lang = $this->Template->getLang();
          if(!empty($products))
          {
            $i = 0; $f = 0;?>
            
            <div id="ca-container2" class="ca-container2">
            <div class="ca-wrapper">
            <?php 
            foreach($products as $k=>$prod)
            {
             
             
              if($i%6 == 0)
              {?>
                <!--<ul id="productsCatalog list" >-->
              <?php }?><div class="ca-item"><ul>
                      <?php if($lang == 'en')
                {
                  
                  ?>
                      <li onclick="showdetailspan2()" <?php if(($i%5 == 0 && $i>0) || ($i == $total_product)){?> style="margin-right:0;"<?php }?>>
                      <?php 
                }
                else
                {
              ?>
                            
                            <li onclick="showdetailspan2()" <?php if(($i%6 == 0) || ($i == $total_product)){?> style="margin-right:0;"<?php }?>>
                            <?php 
              
            }
                      
                            ?>

                                <span class="lazyImage loaded">
                                    <span alt="" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
                    <?php 
                                        $product_name = stripslashes($prod['Product_lang'][0]['title']);
                                        $product_name_slug = $prod['Product']['slug'];
                                        
                                        $pimage = stripslashes($prod['Product']['image_url']);
                                        $pimage = str_replace(array('["','"]'),array('',''),$pimage);
                    
                                       // echo $this->Html->image($pimage, array('alt' => $product_name,'url' => array('controller' => 'homes','action' => 'produc-detail','type'=>$product_name_slug,'full_base' => true)));
                                        ?>
                                        <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod['Product']['id']."-".$product_name_slug?>" style="height:144px;display: block;">
                                    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                                      <tr>
                                         <td valign="middle" style="height:100%;vertical-align: middle;">
                                        <?php
                                        echo $this->Html->image($pimage, array('alt' => $product_name,'onerror'=>'imgError(this);'));
                                        ?>
                                      </td>
                                    </tr>
                                      </table>
                                      </a>
                                    </span>                 
                                </span>
                                        
                                        
                                <span class="qa-brandName title mt10 c999" id="qa-brandName0">
                                  <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod['Product']['id']."-".$product_name_slug?>"><?=$this->Template->summary($product_name,20)?></a>
                                  
                                </span>

                                <div id="ratings_tot_relate_<?=$k?>" class="showratings ratings_tot_relate" style="display:inline">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>

                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                                   
                                                    <script>
                                                    $(function(){
                                                         $('#ratings_tot_relate_<?=$k?> div').each(function(k,v){
                                                             var select= <?=floor($prod['Product']['reate_count'])?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                          
                                                      })
                                                  </script>
                                                  (<?=$this->Template->getReviewText($prod['Product']['review_count'])?> )
                                <div class="item_value">
                                   <a href="javaScript:void(0);" style="text-decoration:none;"
                  <?php /*?>onClick="clickTrack('<?=$prod['Product']['product_url']?>','<?=$prod['Product']['id']?>','<?=$prod['Merchant']['id']?>','<?=$prod['Product']['offer_price']?>','<?=$prod['Merchant']['image_url']?>','<?=$prod['Merchant']['url']?>','<?=$pimage?>','<?=$product_name?>');"<?php */?>
                  class="shop_by_btn" >  
                  <?php 
                  if(!empty($prod['Product']['offer_id']))
                  {
                    echo $this->Template->getProductPrice($prod['Product']['price'],$prod['Offer']); 
                                    }
                                    else
                                    {
                                      echo '<b>'.$this->Template->getPriceFormat(number_format($prod['Product']['price'],2)).'</b>';
                                    }?>
                                  </a>
                                </div>
                                
                                <div class="price_compare"><div class="fk_underline">
                                 </div><?=$this->Template->getWord('compare_by');?><span class="sellertext"><?=$prod['Product']['merchant_count_new']?></span></div>
                            </li></ul></div>
                        
                        <?php /*if(($i%6 == 0 && $i>0) || ($i == $total_product))
            { $f = 0;?></ul>
                  <?php }*/?>
                  <?php $i++; $f++; }
      ?>
            </div>
            </div>
            <?php 
          }else{
            echo "<span style='text-align: center'>No related product found.</span>";
          }?>                                  
        <?php /*?><?php */?>
                                                
                                                <div class="clear"></div>
                                              </ul>
                                            </section>
                                        </div>
                                  </div>  
                          
                          		  <!-- 4th  tab start  -->
                                  
                                  <div class="colaps_class">
                                        <h3>
                                        	<a href="javascript:void(0)" id="four">
                                        	<div class="tableHead" id="techSpec">
                                              <span class="compare_accordians minush_colapse" onclick="colapsh(this)"></span> <?php echo $this->Template->getWord("customer_reviews"); ?> 
                                            </div>
                                              <div class="clear"></div>
                                        	</a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto;" id="openfourtab">
                                             <div style="padding:18px 0 10px 0">
                                                <div class="ratingContener" data-rot="left" data-type="product" data-id="<?=$product['Product']['id']?>">
                                      <div id="ratings_tot1" class="showratings ratings_tot1">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                                  </div>
                                                     <script>
                                                      $(function(){
                                                         $('.ratings_tot div').each(function(k,v){
                                                             var select= <?=floor($avgreating)?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                          $('.ratings_tot1 div').each(function(k,v){
                                                             var select= <?=floor($avgreating)?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }

                                                          })
                                                      })

                                                    </script>
                                                    <?php $lang=$this->Template->getLang();
                                                      if($lang=="ar")
                                                      {
                                                        $style="float:right;";
                                                      }
                                                    ?>
                                      <span style="color:#000; font-size:12px;padding-right:4px;<?=$style?>">(<?=$this->Template->getReviewText($ratingcount)?>)</span> 
                                      <a class="write_review_button thickbox cleartextbox login-window1 reviewbtn" style="font-weight:bold;" href="#login-box1">
                                      <?php echo $this->Template->getWord("write_a_review"); ?>
                                      </a>
                                    </div>
                                    
                                                  <div class="border45"></div>
                                                  <?php 
                                                  if(!empty($allratings))
                                                  {
                                                  foreach ($allratings as $key => $value) { ?>
                                                  <div class="reviewpanle">
                                                  
                                                    <div class="reviewpanle_left">
                                                       <?php /*?> <img class="customer-profile-image" src="<?=$this->webroot?>images/front-end/usewr.png" alt=""><?php */ ?>
                                                        <a href="#"><?=$value['Reviewed_user']['name']?></a>
                                                        <!--<div>
                                                            108 Reviews <br />
                                                            15 votes, 5 helpful
                                                        </div>-->
                                                    </div>
                                                    
                                                    <div class="reviewrow" itemscope="" itemprop="review" style="border:none;">

                                                    <div id="ratings_<?=$key?>" class="showratings">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->

                                                    </div>
                                                    <script>
                                                      $(function(){
                                                         $('#ratings_<?=$key?> div').each(function(k,v){
                                                             var select= <?=floor($value['Product_review']['rating'])?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                      })

                                                    </script>
                                                    <div class="reviewhead" itemprop="name">
                                                     <?=$value['Product_review']['title']?>
                                                    </div>
                                                    <!--<div class="reviewby">
                                                      <meta itemprop="datePublished" content="2014-03-19">
                                                      2014-03-19
                                                      by
                                                      <span itemprop="author">
                                                      sunjit singh machra
                                                      </span>
                                                      , Mumbai, MAHARASHTRA
                                                      
                                                      | Gender: 
                                                      Male
                                                    </div>-->
                                                    <p itemprop="description">
                                                     <?=nl2br(htmlspecialchars_decode($value['Product_review']['comment']))?>
                                                    </p>

                                                    
                                                    <div class="clear" style="height:5px;"></div>
                                                    <!--<div class="ratereview">
                                                      <div class="flt">
                                                        Was this review helpful to you?
                                                      </div>
                                                      <div class="yesno_button">
                                                        <a href="#" class="hlp1" rel="43144">
                                                        Yes(0)
                                                        </a>
                                                        <a href="#" class="hlp1" rel="43144">
                                                        No(0)
                                                        </a>
                                                      </div>
                                                    </div>-->
                                                   
                                                  </div>
                                                   <div class="clear"></div>
                                                 </div>
                                                  <?php }}?>
                                                 
                                                 
                                                 
                                                 
                                                 
                                              
                                    
                                  <!-- 4th  tab end  --> 
                              </div>
                              
                            
                            
                            
                            
                            
                            
                            
                              
                             </div>
                                
                               <!--<div style="text-align: center;margin: 10px 0;">
                                  <span>
                                  	<a class="buynow" target="_blank" href="javaScript:void(0);" onClick="scrollToTop();" title="Buy online" style="width: 100px; text-indent:inherit;">Scroll To Top</a>
                                  </span>
                              </div>-->
            
                            <div id="login-box1" class="login-popup" style="top:15%;">
                                <a href="#login-box" class="close">X</a>
                                <div id="TB_ajaxWindowTitle" class="fl"><?php echo $this->Template->getWord("write_a_review"); ?></div>

                                <h2 class="productname"> <?=$product['Product_lang']['title']?></h2>
                                <form id="loginForm" class="form1 farobic" style="border:none;" method="post" >
                                    
                                    <div class="textsmall"><?php echo $this->Template->getWord("your_rating"); ?><span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <div id="rating_1" class="ratings fl">
                                        <div class="star_1 ratings_stars"></div>
                                        <div class="star_2 ratings_stars"></div>
                                        <div class="star_3 ratings_stars"></div>
                                        <div class="star_4 ratings_stars"></div>
                                        <div class="star_5 ratings_stars"></div>
                                        <!--<div class="total_votes">vote data</div>-->
                                    </div> <!--  -->
                                    <input type="hidden" name="tot_ratings" id="tot_ratings">
                                    <div class="clear" style="height:5px;"></div>
                                    <span class="error" style="color:#f00;display:none"><?php echo $this->Template->getWord("no_ratings_given"); ?></span>
                                    <?php if(!$user){ ?>
                                     <div class="clear" style="height:5px;"></div>
                                    <div class="textsmall"><?php echo $this->Template->getWord("your_name"); ?><span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="name" id="name" class="popuptext" required>
                                    <div class="clear" style="height:5px;"></div>

                                    <div class="textsmall"><?php echo $this->Template->getWord("your_email"); ?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="email" name="email_id" id="email" class="popuptext" required>
                                   
                                    <?php } else { ?>
                                          <h1><?php echo $this->Template->getWord("your_name"); ?> : <?=ucfirst($name)?></h1>
                                          <input type="hidden" name="user_id" value="<?=$user?>">
                                    <?php } ?>
                                     <div class="clear" style="height:5px;"></div>
                                    <div class="textsmall"><?php echo $this->Template->getWord("review_title"); ?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="title" id="review_title" class="popuptext" required>
                                    <div class="clear" style="height:5px;"></div>


                                    
                                    
                                    <div class="textsmall"><?php echo $this->Template->getWord("your_review"); ?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <textarea  class="popuptext" name="comment" style="width: 489px;height:100px; padding-top:0px;" required></textarea>
                                    <div class="clear" style="height:5px;"></div>
                                    
                                    <input type="submit" class="btnsubmit" value="Submit">
                                   <!-- <input type="button" class="btnsubmit" value="Cancel">-->
                                </form>
                                
                                </div>

                                 <div id="merchant-reviews" class="login-popup" style="top:15%;">
                                <a href="#login-box" class="close">X</a>
                                <div id="TB_ajaxWindowTitle" class="fl"><?=$this->Template->getWord('write_a_review');?></div>

                                <h2 class="productname merchantname"> </h2>
                                <form id="loginForm" class="form2 farobic" style="border:none;" method="post" >
                                    <input type="hidden" value="" name="merchant_id" class="merchant_id_review" />
                                    <div class="textsmall">
                                      <?=$this->Template->getWord('your_rating');?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <div id="saller_rating_1" class="ratings">
                                        <div class="star_1 ratings_stars"></div>
                                        <div class="star_2 ratings_stars"></div>
                                        <div class="star_3 ratings_stars"></div>
                                        <div class="star_4 ratings_stars"></div>
                                        <div class="star_5 ratings_stars"></div>
                                        <!--<div class="total_votes">vote data</div>-->
                                    </div>
                                    <input type="hidden" name="tot_ratings_sel" class="tot_ratings_sel">
                                    <span class="error" style="color:#f00;display:none">
                                       <?=$this->Template->getWord('no_ratings_given');?>
                                    </span>
                                    <?php if(!$user){ ?>
                                     <div class="clear" style="height:5px;"></div>
                                    <div class="textsmall"> <?=$this->Template->getWord('your_name');?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="name" id="name" class="popuptext" required>
                                    <div class="clear" style="height:5px;"></div>

                                    <div class="textsmall"><?=$this->Template->getWord('your_email');?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="email" name="email_id" id="email" class="popuptext" required>
                                   
                                    <?php } else { ?>
                                          <h1><?=$this->Template->getWord('your_name');?>: <?=ucfirst($name)?></h1>
                                          <input type="hidden" name="user_id" value="<?=$user?>">
                                    <?php } ?>
                                     <div class="clear" style="height:5px;"></div>
                                    <div class="textsmall"><?=$this->Template->getWord('review_title');?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="title" id="review_title" class="popuptext" required>
                                    <div class="clear" style="height:5px;"></div>


                                    
                                    
                                    <div class="textsmall"><?=$this->Template->getWord('your_review');?> <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <textarea  class="popuptext" name="comment" style="width: 489px;height:100px; padding-top:0px;" required></textarea>
                                    <div class="clear" style="height:5px;"></div>
                                  
                                    <input type="submit" class="btnsubmit" value="Submit">
                                   <!-- <input type="button" class="btnsubmit" value="Cancel">-->
                                </form>
                                
                                </div>                                 
                      </div>
                            
                      </div>
                  
                  <div class="clear" style="height:1px;"></div>
                  
          </div>
         		</div>
      </div>
                <!--  Right panel listing end  -->
           <div class="clear" style="height:50px;">&nbsp;</div>
    </div>
        </div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:0px;">&nbsp;</div>
        <script src="<?=$this->webroot?>js/front-end/jquery.scrollToTop.min.js"></script>
<script type="text/javascript">
/*$(function() {
$("#toTop").scrollToTop(1000);
});*/
</script>

<!--<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>-->
<!--<div class="scroll_top">
                        <a href="#top" id="toTop" style="display:inline-block;">&nbsp;</a>
                    </div>-->

	<p id="back-top">
		<a href="#top"><span>
        
        <!--<br>Back <br><br>to <br><br>Top-->
        <img src="<?php echo $this->webroot;?>images/front-end/up-arrow.png" alt="">
        </span></a>
	</p>


                    <div class="my_alert">
                      <?=$this->Session->flash('bad')?> 
                      <?=$this->Session->flash('msg')?>
                    </div>
    </div>
    
    
    
