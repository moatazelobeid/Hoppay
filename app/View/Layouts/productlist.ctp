
<?php echo $this->element('site-header'); ?>
<script>
$(document).ready(function(){

  // hide #back-top first
  $("#back-top").hide();
  
  // fade in #back-top
  $(function () {

    $(window).scroll(function () {
      var footer=$('.footer').offset();
      var filter=$('.small_for_filter_button').offset();
      footer=footer.top-$('.footer').height()-550;
      filter=filter.top;
      if ($(this).scrollTop() > 100) {
        $('#back-top').fadeIn();
      } else {
        $('#back-top').fadeOut();
      }
    //  console.log(footer + "----- "+ $(this).scrollTop());
      if($(this).scrollTop() >=footer)
      {
        //console.log('in');
        $('.filter_top_but').animate({
            bottom:'81px',
        },100);
      }
      else
      {
      //  console.log('out');
        $('.filter_top_but').animate({
            bottom:'19px',
        },100);
      }
     /* if($(this).scrollTop() >=filter)
      {
        //console.log('in');
        $('.filter_top_but').fadeIn();
      }
      else
      {
      //  console.log('out');
        $('.filter_top_but').fadeOut();
      }*/
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


function filterHideShow(cthis){
  //alert('dsfdsf');
  $('.tot_colaps').slideToggle();
  $('.nano').nanoScroller({
   preventPageScrolling: true
 });
}
function gotoFilter(){
   jQuery('html, body').animate({
    scrollTop: jQuery(".small_for_filter_button").offset().top - 300
    }, 800);
    $('.tot_colaps').slideDown();
    $('.nano').nanoScroller({
     preventPageScrolling: true
   });
}
</script>
 
<script>
var filters=new filter(<?=json_encode($filter_category)?>,<?=json_encode($brand_filter)?>,<?=json_encode($merchant_filter)?>,"<?=$this->params['type']?>","<?=$this->params['slug']?>","<?=$search_id?>","<?=$this->webroot?>",'<?=isset($this->params['dtype'])?$this->params['dtype']:'block'?>','<?=$this->params["short"]?>',<?=json_encode($attribute_filter)?>,'<?=$this->Template->getLang()?>');
//filters.brand_filter="";
      //var filter_category=;
       $(function() {
            $(window).hashchange(function() {
              if(Object.keys(filters.getHash()).length!=0)
              {

                filters.setLoader();
                filters.setLoaderfilter();
                //alert("hashchange = " + window.location.hash); // do something on hashchange

                filters.init();
              }
              else
              {
                filters.setCategory(filters.search_id,filters.type);
                filters.removeLoaderfilter(); 
                scrollerActive=1;
               //window.location.reload();
              }
            })
 
            $(window).hashchange(); // force hashchange onload
 
            
        });

 jQuery(document).ready(function($) {

  //if (window.history && window.history.pushState) {
    if (history.popState) {
     window.history.replaceState(true, null, window.location.pathname);
  //  window.history.pushState('forward', null, './#forward');

    $(window).bind('popstate', function() {
        //if (event.originalEvent.state) {
            if(Object.keys(filters.getHash()).length==0)
            {
              window.location.reload();
            }
       // }
       //
    });

  }
});
</script>
<style>
.cat_bold{
  font-weight: bold;
}
.cat_over_bg{
  background: #EBEEF0;
}
</style>
<!--- Template Section -->

  <!-- Category Template -->
<script id="category_filter" type="text/template">
{{#category.length}}
{{#category}}
   <div class="catTreeLvl0">
        <a href="javascript:void(0)" class="{{#checked}}cat_over_bg{{/checked}}">
            <span class="common-sprite"></span> 
            <input type="checkbox" class="category_check css-checkbox " id="checkbox{{id}}" {{#checked}}checked="checked"{{/checked}} onclick="filters.check_category({{id}},this,{{checked}})" />
            <label for="checkbox{{id}}" name="checkbox{{id}}_lbl" class="css-label dark-check-green {{#checked}}cat_bold{{/checked}}">{{category_name}}</label>
           
            <span class="right_qunt"></span><em></em>
        </a>
        {{#children}}
           {{>childcat}}
        {{/children}}
    </div>
{{/category}}
{{/category.length}}
{{^category.length}}
<span class="not_found_filters"> <?=$this->Template->getWord('no_department_found');?></span>
{{/category.length}}
</script>
<script id="childcat" type="text/template">
   <div class="catTreeLvl0" style="margin-left:20px;margin-botton:5px">
        <a href="javascript:void(0)" class="{{#checked}}cat_over_bg{{/checked}}">
            <span class="common-sprite"></span> 
            <input type="checkbox" class="category_check css-checkbox " id="checkbox{{id}}" {{#checked}}checked="checked"{{/checked}} onclick="filters.check_category({{id}},this,{{checked}})" />
            <label for="checkbox{{id}}" name="checkbox{{id}}_lbl" class="css-label dark-check-green {{#checked}}cat_bold{{/checked}}">{{category_name}}</label>
            <span class="right_qunt">({{prod_count}})</span><em></em>
        </a>
        {{#children}}
          {{>childcat}}
        {{/children}}     
    </div>

    </script>
   <!-- End Category Template -->
   <!-- Brand Template -->
     <script id="brand_filter" type="text/template">
        {{#brand.length}}
        {{#brand}}
          <a href="javascript:void(0)" class="{{#checked}}cat_over_bg{{/checked}}">
            <input type="checkbox" class="brand_check css-checkbox" id="checkbox_brand{{id}}" 
            {{#checked}}checked="checked"{{/checked}} onclick="filters.check_brand({{id}},this,{{checked}})" />
            <label for="checkbox_brand{{id}}" name="checkbox_brand{{id}}_lbl" class="css-label dark-check-green {{#checked}}cat_bold{{/checked}}">{{brand_name}}</label><span class="right_qunt">({{product_count}})</span>
          </a>                
        {{/brand}}
        {{/brand.length}}
        {{^brand.length}}
        <span class="not_found_filters"><?=$this->Template->getWord('no_brands_found');?> </span>
        {{/brand.length}}
     </script>

   <!-- End Brand Template -->
   <!-- Merchant Template -->
     <script id="merchant_filter" type="text/template">
        {{#merchant.length}}
        {{#merchant}}
          <a href="javascript:void(0)" class="{{#checked}}cat_over_bg{{/checked}}">
            <input type="checkbox" class="merchant_check css-checkbox" id="checkbox_merchant{{id}}" 
            {{#checked}}checked="checked"{{/checked}} onclick="filters.check_merchant({{id}},this,{{checked}})" />
            <label for="checkbox_merchant{{id}}" name="checkbox_merchant{{id}}_lbl" class="css-label dark-check-green {{#checked}}cat_bold{{/checked}}">{{website_name}}</label>
          </a>                
        {{/merchant}}
        {{/merchant.length}}
        {{^merchant.length}}
        <span class="not_found_filters"> <?=$this->Template->getWord('no_sellers_found')?></span>
        {{/merchant.length}}
     </script>
     <script id="attr_filter" type="text/template">
        {{#attr.length}}
        {{#attr}}
         <div class="search-box bdr mt10 colaps_class"> <strong class="d-block search-by fs12 pl10 cursor ">
         <div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
         <small class="common-sprite black-arrow-down "></small> {{title}}  <a href="javascript:void(0)" onclick="filters.clearAttr('{{tslug}}')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a> </strong>
            <div class="search-by-cat ml15 mt10 mb10 ">  
             <div id="about" class="nano filter_nano colaps_content">
            <div class="nano-content"> 
            <div class=" color-option search-btype mt5">            
          {{#children}}
            <a href="javascript:void(0)" class="{{#checked}}cat_over_bg{{/checked}}">
              <input type="checkbox" class="attr_check css-checkbox" id="checkbox_attr{{id}}" 
              {{#checked}}checked="checked"{{/checked}} onclick="filters.check_attr('{{slug}}','{{tslug}}',this,{{checked}})" />
              <label for="checkbox_attr{{id}}" name="checkbox_attr{{id}}_lbl" class="css-label dark-check-green {{#checked}}cat_bold{{/checked}}">{{item}}</label><span class="right_qunt">({{count}})</span>
            </a>  
          {{/children}}
           </div>
           </div>
           </div>
          </div>
        </div>              
        {{/attr}}
        {{/attr.length}}
       
     </script>
     <script id="breadcron_change" type="text/template">
     <div class="breadcrumbs fs12 l-hght26" style="float:left;">
        <span><a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang();?>"> <?=$this->Template->getWord('home')?> </a></span>
        <span class="crm">&nbsp;</span>
        {{#.}}
          <span class="{{#Product_category.last}}crm_active{{/Product_category.last}}">
          {{^Product_category.last}}<a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/category-{{Product_category.slug}}">{{Product_category.title}}</a>
          {{/Product_category.last}}
          {{#Product_category.last}}
              {{Product_category.title}}
          {{/Product_category.last}}
          </span> 
          {{^Product_category.last}}
          <span class="crm">&nbsp;</span>
          {{/Product_category.last}}
        {{/.}}
                                                     
        <section class="clear"> </section>
        <div class="clear"></div>                        
    </div>
     </script>
   <!-- End Merchant Template -->
<script>

function colapsh(cthis){
  //alert('dfgfd');
  if($(cthis).hasClass("minush_colapse"))
  {
    $(cthis).removeClass("minush_colapse");
    $(cthis).addClass("plus_colapse");
    $(cthis).parents('.colaps_class').find('.colaps_content').slideUp();
  }
  else
  {
    $(cthis).addClass("minush_colapse");
    $(cthis).removeClass("plus_colapse");
     $(cthis).parents('.colaps_class').find('.colaps_content').slideDown();
  }
}
</script>
<style>
.filter_nano { width: 100%;
min-height: 35px;
max-height: 200px; }
.filter_nano .nano-content { padding: 0px; }
.filter_nano .nano-pane   { background: #888; }
.filter_nano .nano-slider { background: #111; }
.filter_nano > .nano-pane > .nano-slider {
background: #F39042;
}
.folter_collapas{
  float: left;  
  height: 20px;
  width: 20px;
}
/*.colaps_content{
  display: none;
}*/
</style>
<!--- End Template Section -->
<?php $total_product = count($products);?>
<div class="bodypanl  bodypanel_inner">
    <div style="width:100%; margin:0 auto;">
      <section class="clear">
       
        <div class="fl left-nav stickyFilter" id="filter-nav" style="top: 0px;">   
         <div class="small_for_filter_button" onclick="filterHideShow(this)">Filter</div>                      
          <div class="search-box bdr mt10 pos-rel colaps_class tot_colaps">
            	  
                    <strong class="d-block search-by fs12 pl10 cursor ">
                       <div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
                        <small class="common-sprite black-arrow-down "></small> <?=$this->Template->getWord('department');?>
                        <a href="javascript:void(0)" onclick="filters.clear('cat')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a>
                    </strong>
                    <div class="nano filter_nano colaps_content">
                       <div class="nano-content"> 
                        <div class="search-by-cat mt10 mb10 pl14 " id="filter_category">
                             <!-- category filter -->
                   
                        </div>
                       </div>
                     </div>
			
            
            <div id="fct-category-data" data-segment="1" data-leave-selected="" style="display:none;"> </div>
          </div>
          
          <div class="search-box bdr mt10 pos-rel colaps_class tot_colaps">
            
            <strong class="d-block search-by fs12 pl10 cursor ">
              <div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
              <small class="common-sprite black-arrow-down "></small> <?=$this->Template->getWord('price');?><a href="javascript:void(0)" onclick="filters.clear('price')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a></strong>
            <div class="search-by-cat ml15 mt10 mb10 colaps_content ">              
             <?php if($total_product>0){?>
              <div class="catalogPriceSlider enter-price mt5">
                <br>
                  <div id="price_range" style="width: 160px;margin-left: 9px;"></div>
                <strong class="pd-tb7 d-block fs11 c666"><?=$this->Template->getWord('enter_price_range');?></strong>

              
                  <div class="sliderInput">
                    <input id="qa-catalogPrice" class="catalogPriceFilterFrom catalogFilterText text p5 fs11" type="text" value="" name="price_from" >
                    -
                    <input id="qa-catalogPriceTo" class="catalogPriceFilterTo catalogFilterText text p5 fs11" type="text" value="" name="price_to">
                    <input id="qa-catalogPriceSubmit" class="catalogPriceFilterSubmit f-bold cursor c000 fs12" onclick="filters.check_price(2,this)" type="button" value="GO">
                  </div> 
                 <script>
              $("#price_range").noUiSlider({
                  start: [ <?=$price_filter['price']['min']?> , <?=$price_filter['price']['max']?>],    
                  connect: true,
                  <?php if($this->Template->getLang()=="ar"){?>
                  direction: "rtl",  
                  <?php } ?>           
                  range: {
                    'min': [ <?=$price_filter['price']['min']?> ],
                    'max': [ <?=$price_filter['price']['max']?> ]
                  },
                  serialization: {
                    lower: [
                      $.Link({
                      target: $('#qa-catalogPrice')
                      })
                    ],
                    upper: [
                    $.Link({
                      target: $('#qa-catalogPriceTo')
                      })
                    ],
                    format: {
                      thousand: ",",
                      decimals: 0
                      
                    }
                  }
                }).on({                     
                    change: function(){
                      filters.check_price(2,'this')
                    }
                });
              </script>
              </div>
              <?php }else{
                ?>
                    <span class="not_found_filters"><?=$this->Template->getWord('no_price_found')?></span>
                <?php } ?>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="search-box bdr mt10 pos-rel colaps_class tot_colaps">
            
            <strong class="d-block search-by fs12 pl10 cursor ">
              <div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
              <small class="common-sprite black-arrow-down "></small> <?=$this->Template->getWord('discount');?> <a href="javascript:void(0)" onclick="filters.clear('discount')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a></strong>
            <div class="search-by-cat ml15 mt10 mb10 qa-discount colaps_content">
               <?php if($total_product>0){?>
              <div class="search-btype" id="qa-discoun0">
                <a href="javascript:void(0)" >
                <input type="checkbox" class="non_disc_check css-checkbox" data-select="0" id="non_disc1" 
                onclick="filters.check_discount(1,this)" />
                <label for="non_disc1" name="non_disc_1_lbl" class="css-label dark-check-green"><?=$this->Template->getWord('non_discounted');?> </label>
                <span class="right_qunt" id="discount1">(<?=$count_discount['noncount']?>)</span>
              </a>
              </div>
              
              <div class="search-btype" id="qa-discoun1">
                <a href="javascript:void(0)">
                   <input type="checkbox" class="non_disc_check css-checkbox" data-select="0" id="non_disc2" 
                onclick="filters.check_discount(2,this)" />
                <label for="non_disc2" name="non_disc_2_lbl" class="css-label dark-check-green"><?=$this->Template->getWord('discounted');?></label>
                <span class="right_qunt" id="discount2">(<?=$count_discount['count']?>)</span>
                </a>
             </div>
              <?php }else{
                ?>
                    <span class="not_found_filters"> <?=$this->Template->getWord('no_discounts_found')?></span>
                <?php } ?>
            </div>
          </div>
          
          
          <div class="search-box bdr mt10 pos-rel colaps_class tot_colaps"> <strong class="d-block search-by fs12 pl10 cursor "><div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
            <small class="common-sprite black-arrow-down "></small> <?=$this->Template->getWord('brands');?> <a href="javascript:void(0)" onclick="filters.clear('brand')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a></strong>
            <div class="search-by-cat ml15 mt10 mb10 ">
              <!--<input id="fct-brand-search" placeholder="Search brand..." type="text" class="search-brand common-sprite c999 ui-autocomplete-input placeholder" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">-->
              <div id="about" class="nano filter_nano colaps_content">
                <div class="nano-content"> 
                  <div class="color-option search-btype mt5 brand_filter">
                   <!--  Brand template -->
                  </div>
               </div>
            </div>
            </div>
          </div>
          <!--auto-scroll -->
          
          <div class="search-box bdr mt10 pos-rel colaps_class tot_colaps"> <strong class="d-block search-by fs12 pl10 cursor ">
            <div class="folter_collapas minush_colapse" onclick="colapsh(this)"></div>
            <small class="common-sprite black-arrow-down "></small><?=$this->Template->getWord('sellers')?><a href="javascript:void(0)" onclick="filters.clear('merchant')" class="clear_infilter_section"><?=$this->Template->getWord('clear')?></a></strong>
            <div class="search-by-cat ml15 mt10 mb10 ">
               <div id="about" class="nano filter_nano colaps_content">
                       <div class="nano-content"> 
              <div class="auto-scroll color-option search-btype mt5 merchant_filter">
               <!-- Merchant tempalte -->
                 </div>
               </div>
             </div>
            </div>
          </div>

          <div class="attr_filter tot_colaps" style="width:100%;">
              <!--Attr Filter-->
          </div>
          <div class="overly filteroverly"></div>
        </div>
       
        <!--  Right panel listing start  -->
        <div class="col_righttotal">
            <div class="right-content fr">
                <div class="breadcrumbs_pan">
                    <div class="breadcrumbs fs12 l-hght26" style="float:left;">
                       <?php /*?> <span class="normal"> <?=$this->Template->getWord('you_are_here')?></span>
                        <span class="crm">&nbsp;</span> <?php */?>
                        <a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang(); ?>"> <?=$this->Template->getWord('home')?> </a>
                        <span class="crm">&nbsp;</span>
                        <?php 
						if(!empty($cat_path))
						{
							$c = 0;
							$totalc = count($cat_path);
							foreach($cat_path as $cpath)
							{
								$this->Product_category_lang = ClassRegistry::init('Product_category_lang');
								$ptitle=$this->Product_category_lang->find('all', array(
													'conditions' => array(
													'Product_category_lang.cat_id' => $cpath['Product_category']['id'], 
													//'Product_category_lang.status' => 1
													)
												));
								$ptitle = $this->Template->languageChanger($ptitle);				
								//echo '<pre>'; print_r($ptitle);exit;
								$pcattitle = stripslashes($ptitle['Product_category_lang']['category_name']);
								$pcatslug = $ptitle['Product_category']['slug'];
								$c++;
								if($c != $totalc)
								{ ?>
									<a href="<?php echo $this->webroot.$this->Template->getLang(); ?>/products/category-<?php echo $pcatslug;?>"><?=$pcattitle?></a>
									<?php //echo $this->Html->link($pcattitle,array('controller' => 'homes','action' => 'productlist','type'=>$pcatslug,'full_base' => true),
									//array('title'=>$pcattitle, 'class'=>'fs12 c777 f-bold l-hght14'));?>
                                    
                                    <span class="crm">&nbsp;</span>
                                    <?php 
								}
								else
								{
									?> <span class="crm_active"><?php echo $pcattitle;?></span> <?php 
								}?>
							<?php }?>
                        
                        <?php }else{ ?>
                        <span class="crm_active"><?php echo $pcattitle;?></span>
                        <?php }?>
                        <!--Filter combined with breadcrumb start-->
                        <section class="clear"> </section>
                        <div class="clear"></div>
                        <!--Filter combined with breadcrumb end-->
                      </div>
                      
                     
                  
                </div>
 <?php echo $this->fetch('content'); ?><!--  Main Body Panel End  -->
<?php echo $this->element('sql_dump'); ?>
<?php echo $this->element('site-footer'); ?>
<div class="filter_top_but" onclick="gotoFilter();">Filter</div>
<p id="back-top">
    <a href="#top"><span>
        
        <!--<br>Back <br><br>to <br><br>Top-->
        <img src="<?php echo $this->webroot;?>images/front-end/up-arrow.png">
        </span></a>
  </p>
