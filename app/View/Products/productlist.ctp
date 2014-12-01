<style>
.overly {
position: absolute;
width: 100%;
height: 100%;
background: rgba(213, 213, 214, 0.28);
top: 0;
left: 0px;
}
.overly .ajax_loader{
  margin-top:200px;
}
.item_value s
{
color:#FF8322;
cursor:default;
}

</style>
<script>
var type="<?=$this->params['type']?>";
var total_count="<?=$productsCount?>";
var sort="<?=isset($this->params['short'])?$this->params['short']:""?>";
var slug="<?=isset($this->params['slug'])?$this->params['slug']:""?>";
var cat_id="<?=isset($this->params['cat_id'])?$this->params['cat_id']:0?>";
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
    data={'slug':slug,'cat':cat_id,'short':sort}
  break;
}
 function loadData() {

      $.ajax({
      type: "POST",
      url: "<?=$this->webroot.$this->Template->getLang()?>/products/GetAutoLoadProduct/"+type+"/"+limit+"/"+nextpage,
      cache: false,       
      data:data,
      success: function(response){
        console.log(response);
          var obj = JSON.parse(response);
         
       // try{
          var str = '';
          var items=[];   
        //  var itemul=$('<ul class="productsCatalog_list"></ul>');
           var template = $('#ProductBlocktemplate1').html();

       //console.log(obj.allproduct);
          var nodj=obj.allproduct
       
            var ii=0;
          var j=0;
          var allp=[];
           allp[j]=[];
          for(var x in  nodj)
          {
            if(ii<4)
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
                 allp[j].push(obj.allproduct[x]);
                 ii++;
             }
             if(ii==4)
             {
              ii=0;
              j++;
              allp[j]=[];
             }
          }
           //
           allp={'allp':allp};
           
             //
          
            //console.log(obj);
            var html = Mustache.to_html(template, allp);
            //console.log(html);
            $('.p-list').append(html);
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
              
            }else
            {
              $('.loadingmore').fadeOut();
            }
       
       loaded=0;
      },
      error: function(){            
        console.log('Error while request..');
      }
     });
        

    }
    var scrollerActive=0;
    var loaded=0;
    function isScrolledIntoView(elem)
    {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
    function imgError(image) {
      image.onerror = "";
      image.src = "<?=$this->webroot?>images/image_not_found.jpg";
      return true;
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
/*$(document).ready(function () {

   $(window).scroll(function () {   
    /*if(scrollerActive==1)
    {    
       var loader= $('.loadingmore').offset();     
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
            }
            } */
           // console.log(scrollerActive);
          /*if(scrollerActive==1)
           { 
             if(isScrolledIntoView('.loadingmore'))
             {
             if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -12) ))
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
          }*/
        
         /*if(scrollerActive==1)
           { 
             if(isScrolledIntoView('.loadingmore'))
             {
              console.log(total_count-12);
              console.log(nextpage*limit);
              if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -12) ))
                {
                  if(loaded==0)
                  {
                    loaded=1;
          
                    console.log(filters.filterFire);
                    if(filters.filterFire == 0)
                               loadData();
                    else
                      filters.getFilterResult();
                  }
                 
                }
                else
                {
                  $('.loadingmore').fadeOut();
                }
             }
          } */
/*
});
});*/
var selected;
window.onload=function(){

 if(total_count>(nextpage*limit) || ((total_count-(nextpage*limit))<=0 && (total_count-(nextpage*limit) >= -11) ))
{
             
}
else
{
   $('.loadingmore').fadeOut();
}
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

           filters.loadTemplate(function(r){              
              if(r==1){
                console.log(filters.getHash());
                if(Object.keys(filters.getHash()).length==0)
                {
                   $('.stickyFilter>.filteroverly').fadeOut('slow');   
                   filters.removeLoaderfilter(); 
                }
                
                scrollerActive=1;             
                //filters.removeLoaderfilter();
              }
           });
}

function handler() {
     $('.productsCatalog_list span.loaded').removeClass('loaded');
}
jQuery(window).resize(function () {
  selected.click();
})
function isEven(n) 
{
   return isNumber(n) && (n % 2 == 0);
}
function isNumber(n)
{
   return n === parseFloat(n);
}
function showdetailspan2(select,pid){
 
    var height = $(window).height();
    var width = $(window).width();
    selected=$(select);
   var cleare= $(select).parents('.productsCatalog_list').find('.clear');
   $(select).parents('.productsCatalog_list').find('.clear').remove();
    if(width<=768 && height<=1024) 
    {
      console.log($(select).index());
     // if($(select).index())
     if(isEven($(select).index()+1))
     {
      $(select).after(cleare);
     }
     else
     {
       $(select).next().after(cleare);
     }
      
       var footUp=300;
    }
    else if (width < 950) {
      //alert('dfg');
       $(select).after(cleare);
       var footUp=300;
    }    
    else {
      $(select).parents('.productsCatalog_list').append(cleare);
       var footUp=420;
    }
  
  if($(select).attr("class")=='active')
  {
    $(select).removeClass("active");
    $('.productsCatalog_list:not(:eq('+eq+')) div.clear .showdetailspnel').hide(); 
    $('.productsCatalog_list:not(:eq('+eq+')) div.clear .icontop').hide();

  }
  else
  {

  $('.p-list li').removeClass('active');
 $(select).addClass('active');
  var pos=$(select).position();
  var left=pos.left+78; 
  var eq=$(select).parent('.productsCatalog_list').index();  
  $('.productsCatalog_list:not(:eq('+eq+')) div.clear .showdetailspnel').slideUp(); 
  $('.productsCatalog_list:not(:eq('+eq+')) div.clear .icontop').hide();
  $(select).parent('.productsCatalog_list').children('div.clear').find(".showdetailspnel").append('<div class="overly"><div class="ajax_loader" style="margin-top:55px;"></div></div></div>').slideDown(function(){
    var sd=$(this);
     $(this).parent('.clear').find('.icontop').show().animate({'left':left});
     jQuery('html, body').animate({
    scrollTop: jQuery(this).offset().top - footUp
    }, 800);
  
  $(this).load('<?=$this->webroot.$this->Template->getLang()?>/products/get/'+pid+'/<?php echo $this->Template->getLang();?>',function(r){
        //console.log(r);
        if(r.length>0)
        {
          
          $('.specification').readmore({
            maxHeight: 28,
            moreLink: '<a href="#"><?=$this->Template->getWord("more")?></a>',
            lessLink: '<a href="#"><?=$this->Template->getWord("less")?></a>',
            afterToggle: function(trigger, element, more) {
               // The "Close" link was clicked
                
                 jQuery('html, body').animate({
                   scrollTop: sd.offset().top - 200
                }, 1000);
              
            }
          });

        }
    })

  
})
   }
}
function hide1()
{
  $(".showdetailspnel").hide();
  $(".icontop").hide();
  $('.p-list li').removeClass('active');
}

$(function() {
    $("img.lazy").lazyload({effect : "fadeIn"});
    $('.productsCatalog_list>li>span.qa-brandName>a').bind( "click" );
    $('.productsCatalog_list>li>div.price_compare>div.fk_underline>a').bind( "click" );
    //console.log('hii');
     
});
/*$(window).bind("load", function() { 
    var timeout = setTimeout(function() { $("img.lazy").trigger("sporty");
     
     }, 5000);
});  */

</script>  

<style>
.p-list ul li.active{
    -moz-box-shadow: 0 1px 8px #ccc;
  -webkit-box-shadow:0 1px 8px #ccc;
  box-shadow: 0 1px 8px #ccc;
  border: 1px solid #ccc
}
.small03_get_details a{
font-size: 15px;
text-decoration: none;
float: left;
margin-top: 5px;
}
.small03_get_details a:hover{

text-decoration: underline;
}
.detailslist_data1 span{
  text-transform: capitalize;
  margin-bottom: 3px;

}
.thumbdata-div h1 a{
color: #1a0dab !important;
}
</style>   
<script id="ProductBlocktemplate" type="text/template">
   
<ul class="productsCatalog_list">
 {{#allproduct.length}}
  {{#allproduct}}
  <li onclick="showdetailspan2(this,{{Product.id}})">
     <span class="lazyImage loaded">
       <span alt="" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS" style="height:100%;">
	   		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="middle" style="height:100%;vertical-align: middle;">
          				<img alt="{{Product_lang.0.title}}" onerror="imgError(this);" src="{{Product.image_path}}" data-original="{{Product.image_path}}" class="loadings lazy">
		  			</td>
		  		</tr>
		  </table>
       </span>
     </span>
     <span class="qa-brandName title mt10 c999" id="qa-brandName0">
         <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/{{Product.id}}-{{Product.slug}}">{{Product_lang.0.title}}</a>
     </span>
     <div style="text-align:center">
     <div id="ratingsajax" class="showratings">
          <div class="star_1 ratings_stars {{#Product.rating.0.rate}}ratings_over{{/Product.rating.0.rate}}"></div>
          <div class="star_2 ratings_stars {{#Product.rating.1.rate}}ratings_over{{/Product.rating.1.rate}}"></div>
          <div class="star_3 ratings_stars {{#Product.rating.2.rate}}ratings_over{{/Product.rating.2.rate}}"></div>
          <div class="star_4 ratings_stars {{#Product.rating.3.rate}}ratings_over{{/Product.rating.3.rate}}"></div>
          <div class="star_5 ratings_stars {{#Product.rating.4.rate}}ratings_over{{/Product.rating.4.rate}}"></div>
     </div>
     <small>({{Product.review_count_new}})</small>
     <div style="clear" style="height:5px"></div>
     </div>
    <div class="clear"></div>
     <div class="item_value">
      
    {{#Product.offer_percent}}   
    <s>{{Product.price}}</s><a href="javaScript:void(0);" style="text-decoration:none;"
                  <?php /*onClick="clickTrack('{{Product.product_url}}','{{Product.id}}','{{Merchant.id}}','{{Product.offer_price_new}}','{{Merchant.image_url}}','{{Merchant.url}}','{{Product.image_path}}','{{Product_lang.0.title}}');"*/ ?>
                  class="shop_by_btn" ><b>{{Product.offer_price}}</b></a>
    {{/Product.offer_percent}} 
    {{^Product.offer_percent}}  
    <a href="javaScript:void(0);" style="text-decoration:none;"
                 <?php /* onClick="clickTrack('{{Product.product_url}}','{{Product.id}}','{{Merchant.id}}','{{Product.offer_price_new}}','{{Merchant.image_url}}','{{Merchant.url}}','{{Product.image_path}}','{{Product_lang.0.title}}');"*/ ?>
                  class="shop_by_btn" ><b>{{Product.offer_price}}</b></a>
    {{/Product.offer_percent}} 
           
     </div>
     <div class="price_compare">
      <div class="fk_underline"></div><?=$this->Template->getWord('compare_by');?>
      <span class="sellertext">{{Product.merchant_count_new}}</span>
     </div>
  </li>
  {{/allproduct}}
  {{/allproduct.length}}
  {{^allproduct.length}}
    <span class="prod_not_found"><?=$this->Template->getWord('no_product_found')?></span>
  {{/allproduct.length}}


  <div class="clear" style="position:relative">
      <div class="icontop" style="left:55px;"></div>
          <div class="showdetailspnel" style="display:none;">
                           
          </div>
      </div>
</ul>

</script>   
<script id="ProductBlocktemplate1" type="text/template">
    {{#allp}}
     {{#allp.0.length}}
<ul class="productsCatalog_list">

 {{#.}}
  <li onclick="showdetailspan2(this,{{Product.id}})">
     <span class="lazyImage loaded">
       <span alt="" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS" style="height:100%;">
	   		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="middle" style="height:100%;vertical-align: middle;">
          				<img alt="{{Product_lang.0.title}}" onerror="imgError(this);" src="{{Product.image_path}}" data-original="{{Product.image_path}}" class="loadings lazy">
		  			</td>
		  		</tr>
		  </table>
          
       </span>
     </span>
     <span class="qa-brandName title mt10 c999" id="qa-brandName0">
        {{Product_lang.0.title}}
     </span>

     <div style="text-align:center">
     <div id="ratingsajax" class="showratings">
          <div class="star_1 ratings_stars {{#Product.rating.0.rate}}ratings_over{{/Product.rating.0.rate}}"></div>
          <div class="star_2 ratings_stars {{#Product.rating.1.rate}}ratings_over{{/Product.rating.1.rate}}"></div>
          <div class="star_3 ratings_stars {{#Product.rating.2.rate}}ratings_over{{/Product.rating.2.rate}}"></div>
          <div class="star_4 ratings_stars {{#Product.rating.3.rate}}ratings_over{{/Product.rating.3.rate}}"></div>
          <div class="star_5 ratings_stars {{#Product.rating.4.rate}}ratings_over{{/Product.rating.4.rate}}"></div>
     </div>
     <small>({{Product.review_count_new}})</small>
     <div style="clear" style="height:5px"></div>
     </div>
     <div class="clear"></div>
     <div class="item_value">
       
    {{#Product.offer_percent}}   
    <s>{{Product.price}}</s><a href="javaScript:void(0);" style="text-decoration:none;"
                 <?php  /*onClick="clickTrack('{{Product.product_url}}','{{Product.id}}','{{Merchant.id}}','{{Product.offer_price_new}}','{{Merchant.image_url}}','{{Merchant.url}}','{{Product.image_path}}','{{Product_lang.0.title}}');"*/ ?>
                  class="shop_by_btn" ><b>{{Product.offer_price}}</b></a>
    {{/Product.offer_percent}} 
    {{^Product.offer_percent}}  
    <a href="javaScript:void(0);" style="text-decoration:none;"
                 <?php /* onClick="clickTrack('{{Product.product_url}}','{{Product.id}}','{{Merchant.id}}','{{Product.offer_price_new}}','{{Merchant.image_url}}','{{Merchant.url}}','{{Product.image_path}}','{{Product_lang.0.title}}');"*/ ?>
                  class="shop_by_btn" ><b>{{Product.offer_price}}</b></a>
    {{/Product.offer_percent}} 
         
     </div>
     <div class="price_compare">
      <div class="fk_underline"></div><?=$this->Template->getWord('compare_by');?><span class="sellertext">{{Product.merchant_count_new}} </span>
     </div>
  </li>
  {{/.}}
  
  <div class="clear" style="position:relative">
      <div class="icontop" style="left:55px;"></div>
          <div class="showdetailspnel" style="display:none;">
                           
          </div>
      </div>
</ul>
{{/allp.0.length}}
{{^allp.0.length}}
<span class="prod_not_found"><?=$this->Template->getWord('no_product_found')?></span>
{{/allp.0.length}}
 {{/allp}}

</script>  
<!--  Main Body Panel Start  -->
<style>
.ratings_stars {
height: 13px;

}
.showratings {
display: inline;
height: 6px;
}
.spinner{
  margin:67px auto;
  z-index:25;
}
.overly{
  z-index:2;
}
</style>


<script type="text/javascript">
  /*  var img = new Image();
    img.onload = function() {
        i = document.getElementById('image');
        i.removeAttribute('class');
       // i.src = img.src;
    };
    img.onerror = function() {
       // document.getElementById('image').setAttribute('class', 'loaderror');
    };
   // img.src = 'http://path/to/image.png';*/
</script>
              
  <div class="box box-bgcolor">
     <?php $total_product = count($products);?>
          <section class="full-width sorted-by mt10 pb10">
          <h1 class="c24 fs16 fl l-hght26" id="qa-new-arrivals">
            <div class="category_title_in_plist" style="display:inline">
            <?php echo $category_searched['Product_category_lang'][0]['category_name'];?></div>: 
          <span class="f-normal c999 ProductCounter">
				  <?=$productsCount?> <?=$this->Template->getWord('product_found');?></span> 
          </h1>
           <div class="fr sortbypan">
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
                  
                        <div class="fr viewbypan">
                        <label class="fl pt5 fs12 f-bold c999"><?=$this->Template->getWord('view_by')?>:</label>
                        <?php $url=preg_replace('/(?i:(-popular|-plow|-phigh|-hdiscount|-ldiscount))/','',$this->here)?>
                         <?php 
                         $url=str_replace("-list", "", $url);
                          
                         ?>
                        <a href="<?=$url?>-list<?=isset($this->params['short'])?"-".$this->params['short']:""?>" class="listview <?=isset($this->params['dtype'])?"active":""?>" title="Listview">&nbsp;</a>
                       
                        <a  href="<?=$url?><?=isset($this->params['short'])?"-".$this->params['short']:""?>" class="gridview <?=isset($this->params['dtype'])?"":"active"?>" title="Gridview">&nbsp;</a>
                      </div>
          </section>
           <div class="overly_main_section">     
          <section class="full-width sorted-by-product mt10 p-list">

          <?php 
				  if(!empty($products))
				  {
					  $i = 0;
					  foreach($products as $key=>$product)
					  {
						  $i++; 
						  //echo '<pre>'; print_r($product); echo '</pre>'; exit;
              //echo $i."-----------".$key;
						  if($i == 1)
						  {?>
						  	 <ul class="productsCatalog_list">
						  <?php }?>
                      
                      
                <li onclick="showdetailspan2(this,<?=$product['Product']['id']?>)" <?php if($i%4 == 0 and $key!=0){?> style="margin-right:0;"<?php }?>>
                  <span class="lazyImage loaded">
                    <span alt="" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS" style="height: 100%;">
									<?php 
                    $product_name = stripslashes($product['Product_lang'][0]['title']);
                    $product_name_slug = $product['Product']['slug'];
                                        
										$pimage = stripslashes($product['Product']['image_url']);
                    $pimage=json_decode($pimage);
                    if(empty($pimage))
										$pimage = str_replace(array('["','"]'),array('',''),$pimage);
                    else
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
										
                                       // echo $this->Html->image($pimage, array('alt' => $product_name,'url' => array('controller' => 'homes','action' => 'produc-detail','type'=>$product_name_slug,'full_base' => true)));?>
                    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td valign="middle" style="height:100%;vertical-align: middle;">
                            <?php //echo $pimage ?>
                            	 <img alt="<?=$product_name?>" onerror="imgError(this);" data-original="<?=$pimage?>" class="loadings lazy">
                            </td>
                        </tr>
                    </table>
                   
                                      <?php  //echo $this->Html->image(' ', array('alt' => $product_name,'class'=>'loadings lazy','data-original'=>$pimage));
                                        ?>
                    </span>									
                    </span>
                                        
                                        
                    <span class="qa-brandName title mt10 c999" id="qa-brandName0">
                      <?php /*?><a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$product['Product']['id']."-".$product_name_slug?>"></a><?php */?>
                      <?=$this->Template->summary($product_name,22)?>
                    </span>
                    <div style="text-align:center">
                    <div id="ratingss_<?=$key?>" class="showratings">
                        <div class="star_1 ratings_stars"></div>
                        <div class="star_2 ratings_stars"></div>
                        <div class="star_3 ratings_stars"></div>
                        <div class="star_4 ratings_stars"></div>
                        <div class="star_5 ratings_stars"></div>
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
                    &nbsp;&nbsp;<small>(<?=$this->Template->getReviewText($rcount)?>)</small>
                  </div>
                    <div class="item_value"> 
           <a href="javaScript:void(0);" style="text-decoration:none;"
                 <?php /*  onClick="clickTrack('<?=$product['Product']['product_url']?>','<?=$product['Product']['id']?>','<?=$product['Merchant']['id']?>','<?=$product['Product']['offer_price_new']?>','<?=$product['Merchant']['image_url']?>','<?=$product['Merchant']['url']?>','<?=$pimage?>','<?=$product_name?>');"*/ ?>
                  class="shop_by_btn" >                                     
									<?php 
									if(!empty($product['Product']['offer_id']))
									{
										echo $this->Template->getProductPrice($product['Product']['price'],$product['Offer']); 
                  }
                  else
                    {
                      	echo '<b>'.$this->Template->getPriceFormat(number_format($product['Product']['price'],2)).'</b>';
                    }?>
                  </a>
                    </div>
                     <?php
                     $modifiedslug=explode('-', $product['Product']['slug']);
                     $modifiedslug=implode("%",  $modifiedslug);
                     $this->Product = ClassRegistry::init('Product');
                     $merchant=$this->Product->find('count',array('conditions'=>array('Product.slug like'=>$modifiedslug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand'])));
                    // echo $merchant;
                     ?>           
                    <div class="price_compare"><div class="fk_underline"></div><?=$this->Template->getWord('compare_by');?><span class="sellertext"> <?=$product['Product']['merchant_count_new']?> <?php //$this->Template->getWord('sellers');?></span></div>

                
                    </li>    
                            
                        <?php if((($i%4 == 0) and ($key!=0)) || ($i == $total_product))
                          {?>
                          <div class="clear"></div>
                          <div class="clear"></div>
                          <div class="clear"></div>
                          <div class="clear"></div>
                            <div class="clear" style="position:relative">
                           <div class="icontop" style="left:55px;"></div>
                            <div class="showdetailspnel" style="display:none;">
                           
                            </div>
                           </div>
                            </ul>
                              <ul class="productsCatalog_list">
                        <?php }

                           /* if($key==4)
                            {
                              echo "</ul>";
                            }*/
                             
                             ?>
                          

                  <?php }
				  }
          else{ ?>
            <span class="prod_not_found"><?=$this->Template->getWord('no_product_found')?></span>
         <?php  }?>
              
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
