
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.cycle.all.js"></script> 
 <link href="<?=$this->webroot?>css/front-end/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css" media="screen"/>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery-ui-1.8.24.custom.min.js"></script>
 <?php /* ?> <script type="text/javascript" src="<?=$this->webroot?>rating/jquery.js"></script>  <?php */ ?>
 
<script>
function validateRating(){
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
}
jQuery(document).ready(function() 
{
  
  var timer = setInterval( showDiv, 5000);
  
  function showDiv()
  {
    $aa = jQuery('.message').slideUp();
  }

});

function innershow1(){
  $("#innersample").toggle();
}
function hide1()
{
  $("#innersample").hide('');
}

$(document).ready(function(e){
  //$('#rateit').rating('www.url.php', {maxvalue:5});
  $("div.hover-text").hide();
    $("div.gimage").hover(function(){
    $(this).find("div.hover-text").slideToggle(500);
  });
  
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


function scrollUpone(id,sthis)
{
  $('.jumplinks2 a').css('border','0px solid');
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top - 50
}, 1000);
}

function scrollUptwo(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top - 50
}, 1000);
$('.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#opentwotab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#opentwotab").slideDown().addClass('ui-accordion-content-active');
$("#openthreetab").slideUp();
$("#openfourtab").slideUp();
}


function scrollUpthree(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top - 50
}, 1000);
$('.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#openthreetab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#openthreetab").slideDown().addClass('ui-accordion-content-active');
$("#opentwotab").slideUp();
$("#openfourtab").slideUp();

}


function scrollUpfour(id,sthis)
{
   $('.jumplinks2 a').css('border','0px solid');
  $(sthis).css('border-bottom','solid 2px rgb(255, 133, 0)');
jQuery('html, body').animate({
scrollTop: jQuery("#"+id).offset().top - 50
}, 1000);
$('h3.ui-accordion-header').removeClass('ui-state-active ui-corner-top');
$('h3.ui-accordion-header').addClass('ui-state-default ui-corner-all');
$('.ui-accordion-content').removeClass('ui-accordion-content-active');
$("#openfourtab").parent('div').children('.ui-accordion-header').addClass('ui-state-active ui-corner-top').removeClass('ui-state-default ui-corner-all').attr('aria-expanded','true').attr('aria-selected','true').attr('tabindex','0');
$("#openfourtab").slideDown().addClass('ui-accordion-content-active');
$("#opentwotab").slideUp();
$("#openthreetab").slideUp();

}
window.onload=function(){
  $('#mypricewise').click();
}

</script>


<style type="text/css">


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
  top: 15%!important;
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
</style>


<script type="text/javascript">
$(document).ready(function() {
  $('a.login-window').click(function() {
    
    // Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

    //Fade in the Popup and add close button
    $(loginBox).fadeIn(500);
    
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

    //Fade in the Popup and add close button
    $(loginBox).fadeIn(500);
    
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
    fx: 'scrollHorz', //'scrollLeft,scrollDown,scrollRight,scrollUp',blindX, blindY, blindZ, cover, curtainX, curtainY, fade, fadeZoom, growX, growY, none, scrollUp,scrollDown,scrollLeft,scrollRight,scrollHorz,scrollVert,shuffle,slideX,slideY,toss,turnUp,turnDown,turnLeft,turnRight,uncover,ipe ,zoom
    speed:  'slow', 
      timeout: 0,
      next:   '#next', 
      prev:   '#prev',
      pager:  '#thumb',
       
    pagerAnchorBuilder: function(idx, slide) { 
          return '<li><a href="#"><img src="' + slide.src + '" width="60" height="60" /></a></li>'; 
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
      $("#accordion").accordion({ header: "h3", autoHeight: false });
      $( "#accordion" ).accordion({
         autoHeight: false,
        navigation: true,
        collapsible: true,
        active: false
      });
      
    });
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
        
        <div class="bodypanl">
        	<div style="width:100%; margin:0 auto;">
              <section class="clear">
                <div class="grid_inner">
                <div class="col_righttotal" style="border:none; margin-top: 0px; width:100%;padding: 0;margin-left: 0!important;">
               	  <div class="right-content fr" style="width:100%;">
                    <?php  $this->Product_category = ClassRegistry::init('Product_category');
                                      $category=$this->Product_category->getPath($product['Product']['category_id']);
                                    //  print_r($category);

                                       ?>
                       <div style="height:5px;" class="clear"></div>  
                      <div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
                        <a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang()?>"> Home </a> 
                        <span class="breeadset">›</span>
                        <?php 
                        if(!empty($category))
                        foreach ($category as $key => $value) { ?>
                       
                        <?php  $data=$this->Product_category->Product_category_lang->findBycat_id($value['Product_category']['id']); ?>
                        <a href="<?=$this->webroot?>products/category-<?=$data['Product_category']['slug']?>" class="fs12 c777 f-bold l-hght14"><?=$data['Product_category_lang']['category_name']?></a>
                     <?php   //echo $this->Html->link($data['Product_category_lang']['category_name'],array('controller' => 'homes','action' => 'productlist','type'=>$data['Product_category']['slug'],'full_base' => true),
                 // array('title'=>$data['Product_category_lang']['category_name'], 'class'=>'fs12 c777 f-bold l-hght14')); ?>
                       
                        <span class="breeadset">›</span>

                          <?php  }?>
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
                        <?php $images=json_decode($product['Product']['image_url'])?>
                        <section class="full-width sorted-by-product mt10 p-list">
                      <div class="product_topsec" style="margin-top:5px;">
                          <div class="product_img">
                            <div class="slide_details">
                                <div id="slide_details1">
                                  <?php foreach ($images as $key => $value) { ?>
                                    
                                   <img border="0" src="<?=$value?>" width="625" height="345" alt="" title="" />

                                   <?php }?>
                                   
                                   
                                </div>
                                <ul id="thumb"></ul>
                            </div>
                            
                          </div>
                                  
                          <div class="product_topsec_det">
                                    <div itemscope="" itemtype="#">
                                      <div class="mspSingleTitle" id="mspSingleTitle" data-mspid="25149">
                                        <div itemprop="name" class="detailstitle">
                                        <?=$product['Product_lang']['title']?>
                                        </div>
                                      </div>

                                      <?php 
                                      $this->Product_brand = ClassRegistry::init('Product_brand');?>

                                      <br clear="all">
                                      <div clear="all" style="height:5px;"></div>
                                      <?php if($product['Product']['brand']!="")
                                      {
                                      $brand=$this->Product_brand->findById($product['Product']['brand']); ?>
                                      By <?=@$brand['Product_brand_lang'][0]['brand_title']?>
                                      <?php } ?>
                                      <div itemprop="aggregateRating" itemscope="">
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
                                        
                                        <div class="view_review">
                                          <div class="reviewCount">
                                          	(<?=$ratingcount?>)
                                          </div>
                                          <!-- </div> -->
										  
										  <a class="write_review_button thickbox cleartextbox login-window1 signin_top" style="font-weight:bold;" href="#login-box1">
                                          	Write a Review
                                          </a>
                                          
                                           <a class="write_review_button thickbox cleartextbox" style="font-weight:bold;" href="#">
                                          	Add to Favorite 
                                          </a>
                                        </div>
                                        <br clear="all">
                                        
                                         <div class="border45"></div>
                                      </div>
                                      <div class="action_bar_border">
                                      </div>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                    
                                  <!-- <table width="207" class="detaitab">
                                        <tbody>
                                          <tr>
                                            <td class="featureName"><strong>Colour</strong></td>
                                            <td class="featureValue">White</td>
                                          </tr>
                                          <tr>
                                            <td class="featureName"><strong>
                                            Operating System
                                            </strong></td>
                                            <td class="featureValue">Android</td>
                                          </tr>
                                          <tr>
                                            <td class="featureName"><strong>Memory Storage</strong></td>
                                            <td class="featureValue">4.00 GB</td>
                                          </tr>
                                        </tbody>
                                      </table>   --> 
                            <div class="clear" style="height:5px;"></div>                                        
                            <div id="product-description-truncated">
                                 <strong><?=$product['Product_lang']['title']?></strong>
                                 <?=$product['Product_lang']['description']?>
                            </div>
                            
                            
                          
                                    <div class="clear" style="height:5px;"></div>    
                                    <div class="key_text">
                                    	<div class="social_details" style="float:left;">
                            <div style="width:auto; float:left; padding-top:10px;">
                                                <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmaasinfotech24x7.com%2Fentertaiment&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="No" frameborder="0" style="border:none; overflow:hidden; width:83px; height:21px;" allowtransparency="true"> </iframe>
                                        
                                                <iframe scrolling="No" frameborder="0" allowtransparency="true" src="https://platform.twitter.com/widgets/tweet_button.1340179658.html#_=1342087412820&amp;count=horizontal&amp;id=twitter-widget-52&amp;lang=en&amp;original_referer=https%3A%2F%2Ftwitter.com%2Fabout%2Fresources%2Fbuttons%23tweet&amp;size=m&amp;text=Entertaiment&amp;url=https%3A%2F%2Ftwitter.com%2Fabout%2Fresources%2Fbuttons" class="twitter-share-button twitter-count-horizontal" style="width:112px; height: 20px;" title="Twitter Tweet Button"> </iframe>
                                        
                                                    <div style="height: 20px; width: 90px; display: inline-block; text-indent: 0px; margin: 0px; padding: 0px; background-color: transparent; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; background-position: initial initial; background-repeat: initial initial;" id="___plusone_3"><iframe frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="position: static; top: 0px; width: 90px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 20px;" tabindex="0" vspace="0" width="100%" id="I3_1360158712034" name="I3_1360158712034" src="https://plusone.google.com/_/+1/fastbutton?bsv&amp;size=medium&amp;hl=en-US&amp;origin=file%3A%2F%2F&amp;url=http%3A%2F%2Fwww.maasinfotech24x7.com%2Fentertainment&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.en.YRc3HAKd_iM.O%2Fm%3D__features__%2Fam%3DQQ%2Frt%3Dj%2Fd%3D1%2Frs%3DAItRSTPyTCjRMfDL6c9vwEONnQMsGFfFRg#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled&amp;id=I3_1360158712034&amp;parent=file%3A%2F%2F" allowtransparency="true" data-gapiattached="true" title="+1"></iframe></div>
                                                    <script type="text/javascript">
                                                                  (function() {
                                                                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                    po.src = 'https://apis.google.com/js/plusone.js';
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
                                Price & Copmare
                             </h1>
                             <h2>Lowest Price</h2>
                             
                            <h3>                            
                                $<?php echo number_format(min($price)); ?>
                            </h3> 

                            <a href="#" class="linkonline" onclick="scrollUpone('one')"><?=count($merchantids)?> online sellers »</a>
                                <div class="pricesaving" style="display: block;">6%</div>
                            </div>
                          </div>
                          
                       </div>
                       
                       <div class="jumplinks2">
                            <span style="color:#0066CC;">Quick Links :</span>
                            <a href="#" onclick="scrollUpone('one',this)">Compare</a> &nbsp; | &nbsp;
                            <a href="#" onclick="scrollUptwo('two',this)">Related Products</a> &nbsp; | &nbsp;
                            <a href="#" onclick="scrollUpthree('three',this)">Product Details</a>&nbsp; | &nbsp;
                            <a href="#" onclick="scrollUpfour('four',this)">Customer Reviews</a> 
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
                          //console.log(rat);
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
                           // console.log(rat);
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
                       <div class="border45" id="one"></div>
                       
                               <div class="clear" style="height:1px;"></div>
                              
                               <div class="tableHead" id="techSpec">
                                Compare Prices from <?=count($merchantids)?> Online Sellers
                                
                                <div class="price_table_out tabbox" id="four price_table_ou" style="float: right;width: 25%;position: relative;bottom: 8px;">
                                  <div class="jumplinks" id="jmp_product_stores">
                                    <span>Sort By: </span>
                                    <a href="javascript:void(0)" id="mypricewise" data-select="top" class="selctchoose active">Price</a> &nbsp; | &nbsp;
                                    <a href="javascript:void(0)" id="mysellerwise" data-select="top" class="selctchoose">Seller Ratings</a>
                                </div>
                                  
                                  
                                    
                                 <div class="clear" style="padding:4px 0px;"></div>
                                  </div>
                              </div>
                              
                                <div class="clients_expand_bg" style="height:auto;">
                                     <div>
                                  
                                        <div class="clear" style="height:5px;"></div>
                                      
                                         <table class="panelstone"  id="priceWise" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="maintop">Seller</td>
                                                <td class="maintop">
                                                  <a href="javascript:void(0)" data-select="bottom" class="sellerrating">Price</a>
                                                 <!-- <span class="sellerrating">Price</span>--></td>
                                                <td class="maintop"><a href="javascript:void(0)" data-select="bottom" class="pricedot">Seller Rating</a></td>
                                                <td class="maintop">Details</td>
                                                <td class="maintop">Buy Now</td>
                                            </tr>
                                                <?php  
                                                $this->Merchant = ClassRegistry::init('Merchant');
                                                 $this->Reviewed_user = ClassRegistry::init('Reviewed_user');
                                     // $category=$this->Merchant->getPath($product['Product']['category_id']);
                                    //  print_r($category);

                                       ?>
                                            <?php foreach ($merchantids as $key => $value) { 
                                               $merchant=$this->Merchant->findById($value['Product']['retailer_id']);
                                               $merchant_img=$merchant['Merchant']['image_url'];
                                               $productrate=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($value['Product']['id'],1);
                                              $rresults = Hash::extract($productrate, '{n}.Product_review.rating');
                                              $rcount=count($rresults);
                                              if($rcount>0)
                                              $avgrate=(array_sum($rresults)/count($rresults));
                                              else
                                                $avgrate=0;

                                                                                           ?>
                                              
                                            <tr>

                                                <td class="maintop1">
                                                    <a href="#" target="_blank" class="left">
                                                        <img src="<?=$this->webroot?><?=($merchant_img!="")?$merchant_img:'img/no-image.png'?>" alt="tradus" style="height: 52px;">
                                                    </a>
                                                </td>

                                                <td class="maintop1">
                                                    <div class="store_price" data-price="<?=$value['Product']['offer_price']?>">
                                                      <?=$this->Template->getProductPrice($value['Product']['price'],$value['Offer']);?>
                                                      <?php //number_format($value['Product']['price']);?>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="price_breakup">
                                                     <?=$merchant['Product_store']['shipping_details']?'+ '.$merchant['Product_store']['shipping_details']:""?>
                                                    </div>
                                                </td>
                                                <td class="maintop1">
                                                    <div class="store_info">
                                                     <div id="ratingss_<?=$key?>" data-rating="<?=floor($avgrate)?>" class="showratings">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
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
                                                    <font style="position:relative; top: -26px;">(<?=$rcount?>)</font>
                                                    <div class="clear"></div>
                                                  </div>
                                                </td>
                                                <td class="maintop1"><?=$merchant['Product_store']['shipping_details']?></td>
                                                <td class="maintop1" style="padding-right:0;">
                                                    <a class="buynow" target="_blank" href="<?=$value['Product']['product_url']?>" title="Buy online"><img src="<?=$this->webroot?>images/front-end/cart.png">Go to Store</a>
                                                </td>
                                            </tr>
                                            
                                            <?php  }?>
                                        
                                            
                                          </table>

                                          <!-- Short by reatings-->

                                       <?php /* ?>  <table class="panelstone" id="ratingWise" style="display:none" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="maintop">Seller</td>
                                                <td class="maintop"> <a href="javascript:void(0)" class="sellerrating">Price</a>
                                                 <!-- <span class="sellerrating">Price</span>--></td>
                                                <td class="maintop"><a href="javascript:void(0)" class="pricedot">Seller Rating</a></td>
                                                <td class="maintop">Details</td>
                                                <td class="maintop">Buy Now</td>
                                            </tr>
                                                <?php  $this->Merchant = ClassRegistry::init('Merchant');
                                                 $this->Reviewed_user = ClassRegistry::init('Reviewed_user');
                                     // $category=$this->Merchant->getPath($product['Product']['category_id']);
                                    //  print_r($category);

                                       ?>
                                            <?php 
                                            $merchant_rating_order=array();
                                            foreach ($merchantids as $key => $value) { 
                                               $merchant=$this->Merchant->findById($value['Product']['retailer_id']);
                                               $merchant_img=$merchant['Merchant']['image_url'];
                                               $productrate=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($value['Product']['id'],1);
                                              $rresults = Hash::extract($productrate, '{n}.Product_review.rating');
                                              $rcount=count($rresults);
                                              if($rcount>0)
                                                 $avgrate=(array_sum($rresults)/count($rresults));
                                              else
                                                  $avgrate=0;
                                                array_push($merchant_rating_order,array(
                                                  'price'=>$value['Product']['price'],
                                                   'image_path'=>$merchant_img,
                                                   'shipping_details' =>$merchant['Product_store']['shipping_details'],
                                                   'avgrate'=> $avgrate,
                                                   'rcount' => $rcount,
                                                   'product_url' => $value['Product']['product_url'],
                                                   'Offer'=>$value['Offer'],
                                                   'offer_price'=>$value['Product']['offer_price'],

                                                    ));
                                                }

                                               // Print_r($merchant_rating_order);
                                                $merchant_rating_order=Hash::sort($merchant_rating_order, '{n}.rcount', 'desc');
                                             foreach ($merchant_rating_order as $key => $value) {
                                              ?>
                                              
                                            <tr>

                                                <td class="maintop1">
                                                    <a href="#" target="_blank" class="left">
                                                        <img src="<?=$this->webroot?><?=($value['image_path']!="")?$value['image_path']:'img/no-image.png'?>" alt="tradus" style="height: 52px;">
                                                    </a>
                                                </td>
                                                <td class="maintop1">
                                                    <div class="store_price" data-price="<?=$value['offer_price']?>">
                                                      <?=$this->Template->getProductPrice($value['price'],$value['Offer']);?>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="price_breakup">
                                                      
                                                      <?=$value['shipping_details']?'+ '.$merchant['Product_store']['shipping_details']:""?>
                                                    </div>
                                                </td>
                                                <td class="maintop1">
                                                    <div class="store_info">
                                                     <div id="ratingsss_<?=$key?>" data-rating="<?=floor($value['avgrate'])?>" class="showratings">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                                    <script>
                                                      $(function(){
                                                         $('#ratingsss_<?=$key?> div').each(function(k,v){
                                                             var select= <?=floor($value['avgrate'])?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                  $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                      })

                                                    </script>
                                                    <font style="position:relative; top: -26px;">(<?=$value['rcount']?>)</font>
                                                    <div class="clear"></div>
                                                  </div>
                                                </td>
                                                <td class="maintop1"><?=$value['shipping_details']?></td>
                                                <td class="maintop1" style="padding-right:0;">
                                                    <a class="buynow" target="_blank" href="<?=$value['product_url']?>" title="Buy online"><img src="<?=$this->webroot?>images/front-end/cart.png">Go to Store</a>
                                                </td>
                                            </tr>
                                            
                                            <?php  }?>
                                        
                                            
                                          </table><?php */ ?> 
                                   </div>
                                </div>
                                
                                
                               
                               <div class="clear" style="height:10px;"></div>
                               
                               
                              <div id="accordion">
                              	
                                  <!--  2nd tab start  -->
                                   
                                  <div id="two">
                                        <h3>
                                        	<a href="#">
                                        	<div class="tableHead" id="techSpec">
                                                Related Products of this Sellers
                                                </div>
                                              <div class="clear"></div>
                                        	</a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto; padding-top:20px;" id="opentwotab">
                                             <section class="full-width sorted-by-product mt10 p-list">
                                                <?php $total_product = count($products);?>
        <?php 
          if(!empty($products))
          {
            $i = 0;
            foreach($products as $prod)
            {
              $i++; 
             
              if($i%5 == 0)
              {?>
                <ul id="productsCatalog list">
              <?php }?>
                      
                      
                            <li onclick="showdetailspan2()" <?php if($i%6 == 0){?> style="margin-right:0;"<?php }?>>
                                <span class="lazyImage loaded">
                                    <span alt="" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
                    <?php 
                                        $product_name = stripslashes($prod['Product_lang'][0]['title']);
                                        $product_name_slug = $prod['Product']['slug'];
                                        
                                        $pimage = stripslashes($prod['Product']['image_url']);
                                        $pimage = str_replace(array('["','"]'),array('',''),$pimage);
                    
                                       // echo $this->Html->image($pimage, array('alt' => $product_name,'url' => array('controller' => 'homes','action' => 'produc-detail','type'=>$product_name_slug,'full_base' => true)));
                                        echo $this->Html->image($pimage, array('alt' => $product_name));
                                        ?>
                                    </span>                 
                                </span>
                                        
                                        
                                <span class="qa-brandName title mt10 c999" id="qa-brandName0">
                                  <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod['Product']['id']."-".$product_name_slug?>"><?=$product_name?></a>
                                  
                                </span>
                                <div id="ratings_tot_relate" class="showratings ratings_tot_relate" style="display:inline">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>
                                                    <script>
                                                    $(function(){
                                                         $('.ratings_tot_relate div').each(function(k,v){
                                                             var select= <?=floor($prod['Product']['reate_count'])?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                          
                                                      })
                                                  </script>
                                                  (<?=$prod['Product']['review_count']?> Reviews)
                                <div class="item_value">
                                    
                  <?php 
                  if(!empty($prod['Product']['offer_id']))
                  {
                    echo $this->Template->getProductPrice($prod['Product']['price'],$prod['Offer']); 
                                    }
                                    else
                                    {
                                      echo '<b>$'.number_format($prod['Product']['price'],2).'</b>';
                                    }?>
                                </div>
                                
                                <div class="price_compare"><div class="fk_underline">
                                  <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod['Product']['id']?>-<?=$prod['Product']['slug']?>"><?=$prod['Product']['merchant_count']?> Sellers</a></div>Compare by</div>
                            </li>
                        
                        <?php if(($i%5 == 0) || ($i == $total_product))
            { ?>
                  <?php }?>
                  <?php }
          }else{
            echo "<center>No related product found.</center>";
          }?>                                  
        <?php /*?><?php */?>
                                                
                                                <div class="clear"></div>
                                              </ul>
                                            </section>
                                        </div>
                              		</div>
                                    
                                  <!--  2nd tab end  -->  
                                    
                                  
                                  <!--  3rd tab start  -->
                                    
                                  <div>
                                        <h3>
                                        	<a href="#" id="three">
                                        	<div class="tableHead" id="techSpec">
                                                Products Details & Features
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
                                                            echo "<center>No Details Available</center>";
                                                          }
                                                      ?>
                                                    
                                                
                                                  <!--  <tr>
                                                        <td class="featureName">Manufacturer Part Number</td>
                                                        <td class="featureValue">SMG_GT-S7582_WHE</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Brand</td>
                                                        <td class="featureValue">Samsung</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Model Number</td>
                                                        <td class="featureValue">GT-S7582</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Colour Name</td>
                                                        <td class="featureValue">Pure White</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Colour</td>
                                                        <td class="featureValue">White</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Item Package Quantity</td>
                                                        <td class="featureValue">1</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td class="featureName">Warranty</td>
                                                        <td class="featureValue">1 year manufacturer warranty for device and 6 months manufacturer warranty for in-box accessories including batteries from the date of purchase</td>
                                                    </tr>-->
                                                
                                            </tbody>
                                            </table>
                                        </div>
                              		</div>
                                    
                                    <!--  3rd tab end  -->
                                    
                          
                          		  <!-- 4th  tab start  -->
                                  
                                  <div>
                                        <h3>
                                        	<a href="#" id="four">
                                        	<div class="tableHead" id="techSpec">
                                               Customer Reviews
                                            </div>
                                              <div class="clear"></div>
                                        	</a>
                                        </h3>
                                        <div class="clients_expand_bg" style="height:auto;" id="openfourtab">
                                             <div style="padding:18px 0 10px 0">
                                      <div id="ratings_tot1" class="showratings ratings_tot1">
                                                        <div class="star_1 ratings_stars"></div>
                                                        <div class="star_2 ratings_stars"></div>
                                                        <div class="star_3 ratings_stars"></div>
                                                        <div class="star_4 ratings_stars"></div>
                                                        <div class="star_5 ratings_stars"></div>
                                                        <!--<div class="total_votes">vote data</div>-->
                                                    </div>

                                                     <script>
                                                      $(function(){
                                                         $('.ratings_tot div').each(function(k,v){
                                                             var select= <?=$avgreating?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                          $('.ratings_tot1 div').each(function(k,v){
                                                             var select= <?=$avgreating?>;
                                                             if(select!=undefined)
                                                              if(k<select)
                                                              {
                                                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                                              }
                                                          })
                                                      })

                                                    </script>
                                      <font style="color:#000; font-size:12px;padding-right:4px">(<?=$ratingcount?>) Reviews</font> 
                                      <a class="write_review_button thickbox cleartextbox login-window1 reviewbtn" style="font-weight:bold;" href="#login-box1">
                                      Write a Review
                                      </a>
                                    </div>
                                    
                                                  <div class="border45"></div>
                                                  <?php 
                                                  if(!empty($allratings))
                                                  {
                                                  foreach ($allratings as $key => $value) { ?>
                                                  <div class="reviewpanle">
                                                  
                                                    <div class="reviewpanle_left">
                                                        <img class="customer-profile-image" src="<?=$this->webroot?>images/front-end/usewr.png" alt="">
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
                                                             var select= <?=$value['Product_review']['rating']?>;
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
                                                     <?=htmlspecialchars_decode($value['Product_review']['comment'])?>
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
                                                  
                                                 </div>
                                                  <?php }}?>
                                                 
                                                 
                                                 
                                                <!--  <div class="reviewpanle">
                                                  
                                                    <div class="reviewpanle_left">
                                                        <img class="customer-profile-image" src="<?=$this->webroot?>images/front-end/usewr.png" alt="">
                                                        <a href="#">Janidel Watson</a>
                                                        <div>
                                                            108 Reviews <br />
                                                            15 votes, 5 helpful
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="reviewrow" itemscope="" itemprop="review" style="border:none;">
                                                    <img src="<?=$this->webroot?>images/front-end/star.png" alt="" style="position:relative; left:-6px;"/>
                                                    <div class="reviewhead" itemprop="name">
                                                      smooth as butter!!
                                                    </div>
                                                    <div class="reviewby">
                                                      <meta itemprop="datePublished" content="2014-03-19">
                                                      2014-03-19
                                                      by
                                                      <span itemprop="author">
                                                      sunjit singh machra
                                                      </span>
                                                      , Mumbai, MAHARASHTRA
                                                      
                                                      | Gender: 
                                                      Male
                                                    </div>
                                                    <p itemprop="description">
                                                      Bought this phone from India
                                                      times. Got delivery in 5 days
                                                      with a discount of 1500!!
                                                      Works smooth as butter, no lag
                                                      must use it to see the
                                                      difference between class
                                                      &amp;
                                                      ordinary phones. Even my
                                                      Samsung grand feels like a
                                                      :dabba' mow
                                                    </p>
                                                    
                                                    <div class="clear" style="height:5px;"></div>
                                                    <div class="ratereview">
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
                                                    </div>
                                                  </div>
                                                  
                                                 </div>
                                                 
                                                 
                                                  <div class="reviewpanle">
                                                  
                                                    <div class="reviewpanle_left">
                                                        <img class="customer-profile-image" src="<?=$this->webroot?>images/front-end/usewr.png" alt="">
                                                        <a href="#">Janidel Watson</a>
                                                        <div>
                                                            108 Reviews <br />
                                                            15 votes, 5 helpful
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="reviewrow" itemscope="" itemprop="review" style="border:none;">
                                                    <img src="<?=$this->webroot?>images/front-end/star.png" alt="" style="position:relative; left:-6px;"/>
                                                    <div class="reviewhead" itemprop="name">
                                                      smooth as butter!!
                                                    </div>
                                                    <div class="reviewby">
                                                      <meta itemprop="datePublished" content="2014-03-19">
                                                      2014-03-19
                                                      by
                                                      <span itemprop="author">
                                                      sunjit singh machra
                                                      </span>
                                                      , Mumbai, MAHARASHTRA
                                                      
                                                      | Gender: 
                                                      Male
                                                    </div>
                                                    <p itemprop="description">
                                                      Bought this phone from India
                                                      times. Got delivery in 5 days
                                                      with a discount of 1500!!
                                                      Works smooth as butter, no lag
                                                      must use it to see the
                                                      difference between class
                                                      &amp;
                                                      ordinary phones. Even my
                                                      Samsung grand feels like a
                                                      :dabba' mow
                                                    </p>
                                                    
                                                    <div class="clear" style="height:5px;"></div>
                                                    <div class="ratereview">
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
                                                    </div>
                                                  </div>
                                                  
                                                 </div>
                                                 
                                                 
                                             <div class="reviewpanle" style="border:none;">
                                                  
            
            
            
            
                                                 <div class="reviewpanle_left">
                                                    <img class="customer-profile-image" src="<?=$this->webroot?>images/front-end/usewr.png" alt="">
                                                    <a href="#">Janidel Watson</a>
                                                    <div>
                                                        108 Reviews <br />
                                                        15 votes, 5 helpful
                                                    </div>
                                                </div>
                                                
                                                 <div class="reviewrow" itemscope="" itemprop="review" style="border:none;">
                                                <img src="<?=$this->webroot?>images/front-end/star.png" alt="" style="position:relative; left:-6px;"/>
                                                <div class="reviewhead" itemprop="name">
                                                  smooth as butter!!
                                                </div>
                                                <div class="reviewby">
                                                  <meta itemprop="datePublished" content="2014-03-19">
                                                  2014-03-19
                                                  by
                                                  <span itemprop="author">
                                                  sunjit singh machra
                                                  </span>
                                                  , Mumbai, MAHARASHTRA
                                                  
                                                  | Gender: 
                                                  Male
                                                </div>
                                                <p itemprop="description">
                                                  Bought this phone from India
                                                  times. Got delivery in 5 days
                                                  with a discount of 1500!!
                                                  Works smooth as butter, no lag
                                                  must use it to see the
                                                  difference between class
                                                  &amp;
                                                  ordinary phones. Even my
                                                  Samsung grand feels like a
                                                  :dabba' mow
                                                </p>
                                                
                                                <div class="clear" style="height:5px;"></div>
                                                <div class="ratereview">
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
                                                </div>
                                              </div>
                                             </div>
                                        </div>
                              		</div>-->
                                    
                                  <!-- 4th  tab end  --> 
                              </div>
                              
                            
                            
                            
                            
                            
                            
                            
                              
                             </div>
                                
                                
            
                            <div id="login-box1" class="login-popup" style="top:15%;">
                                <a href="#login-box" class="close">X</a>
                                <div id="TB_ajaxWindowTitle">Write a Review</div>
                                <h2 class="productname"> <?=$product['Product_lang']['title']?></h2>
                                <form id="loginForm" style="border:none;" method="post" onsubmit="return validateRating();">
                                    
                                    <div class="textsmall">Your Rating <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <div id="rating_1" class="ratings">
                                        <div class="star_1 ratings_stars"></div>
                                        <div class="star_2 ratings_stars"></div>
                                        <div class="star_3 ratings_stars"></div>
                                        <div class="star_4 ratings_stars"></div>
                                        <div class="star_5 ratings_stars"></div>
                                        <!--<div class="total_votes">vote data</div>-->
                                    </div>
                                    <input type="hidden" name="tot_ratings" id="tot_ratings">
                                    <span class="error" style="color:#f00;display:none">No ratings given!!</span>
                                    <?php if(!$user){ ?>
                                     <div class="clear" style="height:8px;"></div>
                                    <div class="textsmall">Your Name <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="name" id="name" class="popuptext" required>
                                    <div class="clear" style="height:12px;"></div>

                                    <div class="textsmall">Your Email <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="email" name="email_id" id="email" class="popuptext" required>
                                   
                                    <?php } else { ?>
                                          <h1>Your name: <?=ucfirst($name)?></h1>
                                          <input type="hidden" name="user_id" value="<?=$user?>">
                                    <?php } ?>
                                     <div class="clear" style="height:12px;"></div>
                                    <div class="textsmall">Review Title <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input type="text" name="title" id="review_title" class="popuptext" required>
                                    <div class="clear" style="height:12px;"></div>
                                    
                                    
                                    <div class="textsmall">Your Review <span class="requiermark">*</span></div>
                                    <div class="clear" style="height:1px;"></div>
                                    <textarea  class="popuptext" name="comment" style="width: 489px;height:100px; padding-top:0px;" required></textarea>
                                    <div class="clear" style="height:12px;"></div>
                                    
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
           <div class="clear" style="height:0px;">&nbsp;</div>
    </div>
        </div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:0px;">&nbsp;</div>
        <script src="<?=$this->webroot?>js/front-end/jquery.scrollToTop.min.js"></script>
<script type="text/javascript">
$(function() {
$("#toTop").scrollToTop(1000);
});
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
<div class="scroll_top">
                        <a href="#top" id="toTop" style="display:inline-block;">&nbsp;</a>
                    </div>


                    <div class="my_alert">
                      <?=$this->Session->flash('bad')?> 
                      <?=$this->Session->flash('msg')?>
                    </div>
    </div>