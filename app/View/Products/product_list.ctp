<style>
.overly {
position: absolute;
width: 100%;
height: 100%;
background: rgba(213, 213, 214, 0.28);
top: 0;
left: 0px;
}

</style>
<script type="text/javascript">
var type="<?=$this->params['type']?>";
var total_count="<?=$productsCount?>";
var sort='<?=isset($this->params['short'])?$this->params['short']:""?>';
var slug='<?=isset($this->params['slug'])?$this->params['slug']:""?>';
var cat_id='<?=isset($this->params['cat_id'])?$this->params['cat_id']:0?>'
var limit=12;
var nextpage=2;
var data={};
switch(type){
  case "category":
    var all_subid='<?=@json_encode($category_ids)?>';
   data={'all_subid':all_subid,'short':sort}
  break;
  case "brand":
     data={'slug':slug,'short':sort}
  break;
  case "search-for":
    data={'slug':slug,'cat_id':cat_id,'short':sort}
  break;
}
 function loadData() {

      $.ajax({
      type: "POST",
      url: "<?=$this->webroot?>products/GetAutoLoadProduct/"+type+"/"+limit+"/"+nextpage,
      cache: false,       
      data:data,
      success: function(response){
         // console.log(response);
          var obj = JSON.parse(response);
         
       // try{
          var str = '';
          var items=[];   
        //  var itemul=$('<ul class="productsCatalog_list"></ul>');
           var template = $('#ProductBlocktemplate').html();

       //console.log(obj.allproduct);
          var nodj=obj.allproduct
          for(var x in  nodj)
          {
              var rat= nodj[x].Product.reate_count
               obj.allproduct[x].Product.rating=[]
             for(var i=0;i<5;i++){
             
              obj.allproduct[x].Product.rating[i]={};
              //console.log(rat);
                if(i<rat)
                {
                     obj.allproduct[x].Product.rating[i]['rate']=true;
                }
                else
                {
                    obj.allproduct[x].Product.rating[i]['rate']=false;
                }
                if(obj.allproduct[x].Product.discount==0)
                {
                  obj.allproduct[x].Product.discount="false";
                }
             }
          }
            var html = Mustache.to_html(template, obj);
            //console.log(html);
            $('.listitempan').append(html);
            nextpage=nextpage+1;
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
            if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -11) ))
            {
                         
            }
            else
            {
               $('.loadingmore').fadeOut();
            }
         loaded=0;
      },
      error: function(){            
        alert('Error while request..');
      }
     });
        

    }
   //var scrollerActive=0;
   var loaded=0;
    function isScrolledIntoView(elem)
    {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

     function moreloader(){
         if(scrollerActive==1)
           { 
             if(isScrolledIntoView('.loadingmore'))
             {
             if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -11) ))
                {
                  if(loaded==0)
                  {
                    loaded=1;
                     loadData();
                  }
                 
                }
                else
                {
                  $('.loadingmore').fadeOut();
                }
             }
          }
    }
//$(document).ready(function () {
   //$(window).scroll(function () {    
   /*var loader= $('.loadingmore').offset();     
  // console.log($(window).scrollTop()); 
  // console.log(( $(document).height() - $(window).height()));
        if ($(window).scrollTop() == ( ($(document).height()-100) -($(window).height()-100)) ){
          if(total_count>(nextpage*limit))
          {
            loadData();
          }
          else
          {
            $('.loadingmore').fadeOut();
          }
        }*/
         //if(scrollerActive==1)
          // { 
             /*if(isScrolledIntoView('.loadingmore'))
             {
              if(total_count>(nextpage*limit))
                {
                  if(loaded==0)
                  {
                    loaded=1;
                     loadData();
                  }
                }
                else
                {
                  $('.loadingmore').fadeOut();
                }
             }*/
          //}
    //});
/*$('.loadingmore').waypoint(function() {
  if(total_count>(nextpage*limit))
              {
                loadData();
              }
              else
              {
                $('.loadingmore').fadeOut();
              }
});*/
    
   

//});
window.onload=function(){
//  $('.colaps_content').slideDown();
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
 if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -11) ))
{
             
}
else
{
   $('.loadingmore').fadeOut();
}
  filters.loadTemplate(function(r){              
              if(r==1){
                // console.log(r);
               if(Object.keys(filters.getHash()).length==0)
                {
                   $('.stickyFilter>.filteroverly').fadeOut('slow');   
                   filters.removeLoaderfilter(); 
                }
                scrollerActive=1; 
              }
           });
  $('#polyglotLanguageSwitcher ul.dropdown>a').attr('href','javascript:void(0)');
  }
/*function innershow1(){
    $("#innersample").toggle();
}*/
function hide1()
{
    $("#innersample").hide('');
}
function handler() {
     $('.productsCatalog_list span.loaded').removeClass('loaded');
}


$(function() {
    $("img.lazy").lazyload({effect : "fadeIn"});
    $('.lazyImage.loaded').css('background-image','');
    //console.log('hii');
     
});

function showdetailspan(){
    $(".showdetailspnel").toggle();
}
function hide1()
{
    $(".showdetailspnel").hide('');
}
function imgError(image) {
      image.onerror = "";
      image.src = "<?=$this->webroot?>images/image_not_found.jpg";
      return true;
    }

</script>
<script id="ProductBlocktemplate" type="text/template">
  {{#allproduct}}
   <li>     
     <div class="list_img lazyImage loaded">
          <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/{{Product.id}}-{{Product.slug}}">
          <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                  <tr>
                      <td valign="middle" style="height:100%;vertical-align: middle;">
                     <img alt="{{Product_lang.0.title_list}}" onerror="imgError(this);" src="{{Product.image_path}}" data-original="{{Product.image_path}}" class="loadings lazy">
                  </td>
                </tr>
            </table>
          </a>
     </div>

     <div class="loistdata-div">
        <h2 class="listtitle">
        <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/{{Product.id}}-{{Product.slug}}">{{Product_lang.0.title_list_new}}</a></h2>
        <h4 class="smalltext">
           {{Product_lang.0.description}}
        </h4>
        <br>
         <div class="clear" style="height:5px;"></div>
        <div id="ratingsajax" class="showratings" style="display: inline !important;">
          <div class="star_1 ratings_stars {{#Product.rating.0.rate}}ratings_over{{/Product.rating.0.rate}}"></div>
          <div class="star_2 ratings_stars {{#Product.rating.1.rate}}ratings_over{{/Product.rating.1.rate}}"></div>
          <div class="star_3 ratings_stars {{#Product.rating.2.rate}}ratings_over{{/Product.rating.2.rate}}"></div>
          <div class="star_4 ratings_stars {{#Product.rating.3.rate}}ratings_over{{/Product.rating.3.rate}}"></div>
          <div class="star_5 ratings_stars {{#Product.rating.4.rate}}ratings_over{{/Product.rating.4.rate}}"></div>
     </div>
      &nbsp;&nbsp;<small>({{Product.review_count_new}})</small>
       <div class="clear" style="height:5px;"></div>
        {{#Product.offer_percent}}  
<a href="javaScript:void(0);" style="text-decoration:none;">
        <span class="msrp-value" style="position:inherit!important; float:left;padding-left: 0; padding-top:7px;background-image: url(<?=$this->webroot?>images/front-end/pricetotal.png);
background-repeat: no-repeat;padding-left: 31px;background-size: 21px;background-position: 5px 4px;
">{{Product.price}}</span>
</a>
      <div class="listprice" style="float:left;margin-top: 3px;">
        <b>{{Product.offer_price}}</b>
      </div>  
    {{/Product.offer_percent}} 
    {{^Product.offer_percent}}  
    <div class="listprice" style="float:left;margin-top: 3px;">
   
        <b>{{Product.offer_price}}</b>
      </div>
    {{/Product.offer_percent}} 
    <a   onClick="clickTrack('{{Product.product_url}}','{{Product.id}}','{{Merchant.id}}','{{Product.offer_price_new}}','{{#Merchant.image_url}}{{Merchant.image_url}}{{/Merchant.image_url}}{{^Merchant.image_url}}img/no-image.png{{/Merchant.image_url}}','{{Merchant.url}}','{{Product.image_path}}','{{Product_lang.0.title_list}}');" href="javascript:void(0);" class="gotostore"><?=$this->Template->getWord('buy_on_seller');?></a>
    <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/{{Product.id}}-{{Product.slug}}" class="comparetoothe">{{#Product.merchantCountlesthen}}Compare with ({{Product.merchant_count_new}}){{/Product.merchantCountlesthen}}{{^Product.merchantCountlesthen}} More info {{/Product.merchantCountlesthen}}</a>  
     </div>
     <div class="loistdata-logo-div">
          <img src="<?=$this->webroot?>{{#Merchant.image_url}}{{Merchant.image_url}}{{/Merchant.image_url}}{{^Merchant.image_url}}img/no-image.png{{/Merchant.image_url}} " width="120" /> 
          <br/>
     </div>
     <div class="clear" style="height:1px;"></div> 
  </li>
  {{/allproduct}}
  {{^allproduct}}
    <span class="prod_not_found"><?=$this->Template->getWord('no_product_found')?></span>
  {{/allproduct}}
  


</script>  
   
 <div class="box box-bgcolor overly_main_section"> 
                        <!--<section class="full-width sorted-by mt10 pb10">
                          
                          
                          
                          <div class="fr" style="float: right;">
                            <label class="fl pt5 fs12 f-bold c999">View By:</label>
                            <a href="javascript:void(0)" class="listview" title="Listview">&nbsp;</a>
                            <a href="search-result.html" class="gridview" title="Gridview">&nbsp;</a>
                          </div>
                          
                        </section>-->
                        <?php $total_product = count($products);?>
          <section class="full-width sorted-by mt10 pb10">
          <h1 class="c24 fs16 fl l-hght26" id="qa-new-arrivals">
            <div class="category_title_in_plist" style="display:inline"><?php echo $category_searched['Product_category_lang'][0]['category_name'];?></div>: 
          <span class="f-normal c999 ProductCounter">
          <?=$productsCount?> <?=$this->Template->getWord('product_found');?></span> 
          </h1>
           <div class="fr sortbypan" >
                        <label class="fl pt5 fs12 f-bold c999"><?=$this->Template->getWord('sort_by')?> :</label>
                        <?php
                          //echo $this->here;
                         // echo parse_url($this->here,PHP_URL_FRAGMENT);
                         ?>
                        <script>
                          function shortBychange(select)
                          {
                            var url="<?=preg_replace('/(?i:(-popular|-plow|-phigh|-hdiscount|-ldiscount))/','',$this->here)?>";
                            var shor=select.options[select.selectedIndex].value;
                            var url=url+"-"+shor+window.location.hash;
                            window.location.assign(url);
                         
                          }
                        </script>
                        <script>
                          $(function(){
                            $('.select-box').val("<?=$this->params['short']?>");
                          })
                        </script>
                        <select class="select-box" onchange="shortBychange(this)">
                            <option selected="selected" value="popular"><?=$this->Template->getWord('popularity')?></option>
                            <option value="phigh" > <?=$this->Template->getWord('price_high_to_low')?> </option>
                            <option value="plow"><?=$this->Template->getWord('price_low_to_high')?> </option>
                            <option value="hdiscount"> <?=$this->Template->getWord('discount_high_to_low')?></option>
                            <option value="ldiscount"><?=$this->Template->getWord('discount_low_to_high')?></option>
                        </select>
                      </div>
                  
                        <div class="fr viewbypan" >
                        <label class="fl pt5 fs12 f-bold c999"><?=$this->Template->getWord('view_by')?>:</label>
                        <?php $url=preg_replace('/(?i:(-popular|-plow|-phigh|-hdiscount|-ldiscount))/','',$this->here)?>
                         <?php 
                         $url=str_replace("-list", "", $url);
                          
                         ?>
                        <a href="<?=$url?>-list<?=isset($this->params['short'])?"-".$this->params['short']:""?>" class="listview <?=isset($this->params['dtype'])?"active":""?>" title="Listview">&nbsp;</a>
                       
                        <a  href="<?=$url?><?=isset($this->params['short'])?"-".$this->params['short']:""?>" class="gridview <?=isset($this->params['dtype'])?"":"active"?>" title="Gridview">&nbsp;</a>
                      </div>
          </section>
                        <section class="full-width sorted-by-product mt10 p-list">
                        	<ul class="listitempan">
                                <?php 
                                if(!empty($products))
                                {
                                foreach($products as $key=>$product)
                      {
                         $product_name = stripslashes($product['Product_lang'][0]['title']);
                          $product_name_slug = $product['Product']['slug'];
                                        
                                       $pimage = json_decode(stripslashes($product['Product']['image_url']));
                                       // $pimage = str_replace(array('["','"]'),array('',''),$pimage);
                                        $pimage=$pimage[0];
                   //  $this->Merchant = ClassRegistry::init('Merchant');
                                                 $this->Reviewed_user = ClassRegistry::init('Reviewed_user');
                    $productrate=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($product['Product']['id'],1);
                                              $rresults = Hash::extract($productrate, '{n}.Product_review.rating');
                                              $rcount=count($rresults);
                                              if($rcount>0)
                                              $avgrate=(array_sum($rresults)/count($rresults));
                                              else
                                                $avgrate=0;
                                        
                                       // echo $this->Html->image($pimage, array('alt' => $product_name,'url' => array('controller' => 'homes','action' => 'produc-detail','type'=>$product_name_slug,'full_base' => true)));
                                        
                                ?>
                                    <li>
                                        <div class="list_img lazyImage loaded">
                                            <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>">
                                               <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                  <tr>
                      <td valign="middle" style="height:100%;vertical-align: middle;">
                        
                                      <img alt="<?=$product_name?>" onerror="imgError(this);" data-original="<?=$pimage?>" class="loadings lazy" />
                                    </td></tr></table>
                                              </a>                                        </div>
                                        
                                        <div class="loistdata-div">
                                            <h2 class="listtitle">
                                            <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>"><?=$product_name?></a></h2>
                                            
                                            <h4 class="smalltext">
                                                <?=$this->Template->summary($product['Product_lang'][0]['description'],200)?></h4>
                                            <br />
                                             <div class="clear" style="height:5px;"></div>
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
                               var select= <?=floor($product['Product']['reate_count'])?>;
                               if(select!=undefined)
                                if(k<select)
                                {
                                      $(this).prevAll().andSelf().addClass('ratings_over');
                                }
                            })
                        })

                    </script>
                    &nbsp;&nbsp;<small>(<?=$this->Template->getReviewText($rcount)?>)</small>
                   <div class="clear" style="height:5px;"></div>
                                   <!--  onClick="clickTrack('<?=$product['Product']['product_url']?>','<?=$product['Product']['id']?>','<?=$product['Merchant']['id']?>','<?=$product['Product']['offer_price_new']?>','<?=$product['Merchant']['image_url']?>','<?=$product['Merchant']['url']?>','<?=$pimage?>','<?=addslashes($product_name)?>');" -->         
               <a href="javaScript:void(0);" style="text-decoration:none;" class="shop_by_btn" >                                   
                  <?php 
                  if($product['Product']['offer_id'])
                  {
                    echo $this->Template->getProductPriceList($product['Product']['price'],$product['Offer']); 
                  }
                  else
                    {
                        echo '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->Template->getPriceFormat(number_format($product['Product']['price'],2)).'</b></div>';
                    }?><!--</div>-->
                  </a>
        <a  onClick="clickTrack('<?=$product['Product']['product_url']?>','<?=$product['Product']['id']?>','<?=$product['Merchant']['id']?>','<?=$product['Product']['offer_price']?>','<?=$product['Merchant']['image_url']?>','<?=$product['Merchant']['url']?>','<?=$pimage?>','<?=addSlashes($product['Product_lang'][0]['title'])?>');"
         href="javascript:void(0)" class="gotostore"><?=$this->Template->getWord('buy_on_seller');?></a>
                                          <?php   $modifiedslug=explode('-', $product['Product']['slug']);
                     $modifiedslug=implode("%",  $modifiedslug);
                     $this->Product = ClassRegistry::init('Product');
                     $merchant=$this->Product->find('count',array('conditions'=>array('Product.slug like'=>$modifiedslug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']))); ?>
                     <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>" class="comparetoothe"><?php if($product['Product']['merchant_count_new']>1){ 
                      ?>
                      Compare with 
                      (<?=$product['Product']['merchant_count_new']?>)
                      <?php 
                        }else
                        {
                          echo $this->Template->getWord('more_info');
                        }
                      ?>
                      </a>                                        </div>
                                        
                                        <div class="loistdata-logo-div">
              <img src="<?=$this->webroot?><?=$product['Merchant']['image_url']?$product['Merchant']['image_url']:"img/no-image.png"?>" width="120" /><br />
                                        </div>
                                        <div class="clear" style="height:1px;"></div>
                                    </li>
							<?php }	} else{ ?>
            <span class="prod_not_found"><?=$this->Template->getWord('no_product_found')?></span>
         <?php  }?>

						  
			  	      	  </ul>
                        </section>
                         <div class="overly filteroverly"><div class="ajax_loader"></div></div>
                      </div>
                  
                  <div class="clear" style="height:1px;"></div>
      <a href="javascript:void(0);" onclick="moreloader();" class="loadingmore" style=""><?=$this->Template->getWord('more_items');?></a>    
                 

              </div>
        </div>
        <!--  Right panel listing end  -->
      <div class="clear" style="height:5px;">&nbsp;</div>  
        
      </section>
    </div>
    <div class="clear" style="height:5px;">&nbsp;</div>
    
</div>
                  