<?php 
echo $this->element('site-header'); 
$lang=$this->Template->getLang();
if($lang=="en")
{
echo $this->Html->css('front-end/shopby-catagories');
echo $this->Html->css('front-end/category');
}else
{
  echo $this->Html->css('front-end/shopby-catagories_ar');
  echo $this->Html->css('front-end/category_ar');
}
//echo $this->Html->script('front-end/jquery.min.js');
?>
<script type="text/javascript" src="<?=$this->webroot?>js/front-end/category.js"></script>
 <?php //echo $this->Html->script('front-end/jquery.polyglot.language.switcher'); ?>
<script>
$(document).ready(function(){

//$('.bodypanl').prepend('<div class="cat_loading"><div class="spinner"><div class="dot1"></div><div class="dot2"></div></div><center style="font-size:17px;margin-top:-13px">Loading all departments...</center></div>');
	
});

window.onload=function(){

/*$('.categorylistContent').append('<div class=""><div class="spinner"><div class="dot1"></div><div class="dot2"></div></div><center style="font-size:17px;margin-top:-13px">Loading all departments...</center></div>').load('<?=$this->webroot?>homes/getAJAXCategorysListView',function(r){
  //console.log(r);
})*/

  catlist.init();

$('.cat_loading').remove();


};
</script>
  
  
<style>
.arrow-down-siteMap 
{
	width: 0;
	height: 0;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid black;
	display: inline-block!important;
	vertical-align: middle;
	margin-left: 0;
}
.arrow-up-siteMap 
{
	width: 0;
	height: 0;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: 5px solid black;
	display: inline-block!important;
	vertical-align: middle;
	margin-left: 0;
}
li.cathide
{
	display:none;
}
li.has_child1 span
{
	cursor:pointer;
	font-size:16px;
}
ul.hidepanel1
{
	margin-left:22px;
}
li.has_child1 span img
{
	position: relative;
	top: 3px;
}
.ctgicon img
{
	height:22px;
	width:22px;
}
</style>
<script>
function showMoreChild(catid)
{
	var iscat = $('.cat'+catid).hasClass( "cathide" );
	//alert(iscat);
	if(iscat == true)
	{
		$('.cat'+catid).removeClass('cathide');
		$('#show_more_'+catid).html('Show Less <span class="arrow-up-siteMap"></span>');
		//setTimeout(createlist,1001);
		//createlist();
	}
	else
	{
		$('.cat'+catid).addClass('cathide');
		$('#show_more_'+catid).html('Show More <span class="arrow-down-siteMap"></span>');
		//setTimeout(createlist,1001);
		//createlist();
	}
}

/*function displaySubChilds(pid)
{
	var hchild_val = $('#hchild_val_'+pid).val();
	//alert(hchild_val);
	if(hchild_val == 0)
	{
		$('#hchild_'+pid).append('<span id="loading_'+pid+'"><br><img src="<?=$this->webroot?>images/ajax-loader.gif" /></span>');
		
		var url = '<?=$this->webroot.$this->Template->getLang()?>/homes/getAJAXCategorysChildListView/'+pid;
		
		$.get(url,function(data)
		{
			$(data).insertAfter('#loading_'+pid);
			 
			
			 
			$('#loading_'+pid).remove();
			$('#child_list_'+pid).show(1000);
			$('#hchild_val_'+pid).val(1);
			//$('#hchild_'+pid).click();
			$('#has_child_icon_'+pid).html('<img src="<?=$this->webroot?>images/minus.png" />');
			//$('#has_child_icon_'+pid).css('background','url(<?=$this->webroot?>images/default/plus2.png) no-repeat 0 -30px transparent');
			setTimeout(createlist,1001);
		});
	}
	else
	{
		if(hchild_val == 1)
		{
			$('#has_child_icon_'+pid).html('<img src="<?=$this->webroot?>images/plus.png" />');	
			setTimeout(createlist,1001);
			$('#child_list_'+pid).hide(1000);
			
			$('#hchild_val_'+pid).val(2);
			//createlist();
			
		}
		else
		{
			$('#has_child_icon_'+pid).html('<img src="<?=$this->webroot?>images/minus.png" />');
			setTimeout(createlist,1001);
			$('#child_list_'+pid).show(1000);
			
			$('#hchild_val_'+pid).val(1);
			
		}
	}
	createlist();
}*/

    /*$( document ).ready(function(){
        $('.storesSpotBox li.has_child').click(function(){
        
            var child=$(this).children( ".hidepanel" )	
            console.log(child);								
            child.slideToggle('down');
        })
    })*/



      
       var item=4;
       function changeHeight(){
          var data=[];
          var length1=$('.bannerBox').length;
          console.log(length1);
             for(var i=0;i<item;i++ ){
                var k=i;
                data[i]=0;
              for(var j=0;j<length1;j++){
                
               
                if(k<length1){
                   console.log(k);
                   console.log($('#item'+k).height());
                   data[i]=parseInt(data[i]+parseInt($('#item'+k).height())+20);
                   console.log(data[i]);
                   k=item+k 
                 }
                 else
                 {
                  break;
                 }
              }  
             }
          
         //data=0;
         // $('.bannerBox').each(function(k,v){
              //data=data+$('#item'+k).height()

          //});
           
       var maxdata= Math.max.apply(Math, data);
        // console.log(maxdata);
          $('.storesSpotBoxTop').css('height',maxdata+'px');
       }
       function createlist(){
        //alert('hjdhd');
         $('.bannerBox').each(function(k,v){
              $(this).attr('id','item'+k);
             // console.log(k);
              if(k!=0)
              {
                
              var position=$('#item'+(k-1)).position();
               var width=$('#item'+(k-1)).width();
             
              //console.log(position);
              if(k<item)
              {
              $('#item'+k).css({'left':(position.left+width+20)+'px',});
              }
              else
              {
                // console.log('#item'+k);
                 //console.log('#item'+(k-item));
                 var position1=$('#item'+(k-item)).position();
                // console.log(position1)
                 var height=$('#item'+(k-item)).height();
                // console.log(height)
                // console.log(position1.top+height+20);
                $('#item'+k).css({'left':(position.left+width+20)+'px','top':(position1.top+height+20)+'px' });
              }
              }
           })
         changeHeight();
       }
       
  /*$(document).ready(function(){ createlist(); });*/

    catlist.baseUrl="<?=$this->webroot?>";
    catlist.lang="<?=$this->Template->getLang()?>";

</script>
  
  <script id="category_list" type="text/template">
  {{#catlist.length}}
{{#catlist}}
    {{#Product_category}}
    <div class="cat_inner_sub">
    <div class="cat_iner_head">   
      <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/category-{{slug}}">{{title}} ({{count}}) </a>
      </div>
      <div class="clear"></div>
      <div class="cat_child_sub_content">
        {{#clildren.length}}
          {{#clildren}}
              <div class="cat_child_inner_sub">
                <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/category-{{Product_category.slug}}">{{Product_category.title}} ({{Product_category.count}})</a>
                    
                </div>
          {{/clildren}}
          <div class="clear"></div>
          {{/clildren.length}}
          {{^clildren.length}}
            <div class="no_cat_found"> No Category Found!!</div>
          {{/clildren.length}}
        </div>
      </div>  
    {{/Product_category}} 
{{/catlist}}
<div class="clear"></div>
 {{/catlist.length}}
{{^catlist.length}}
  <div class="no_cat_found"> No Category Found!!</div>
{{/catlist.length}}

</script>
<style>
.overly {
position: absolute;
width: 100%;
height: 99.5%;
background: rgba(255, 255, 255, 0.51);
top: 0;
}
.filteroverly {
padding: 7px !important;
left: -8px !important;
}
.ajax_loader {
margin: 91px auto;
}

</style>
        
        <!--  Main Body Panel Start  -->
        
        <div class="bodypanl">
        
        <!--	<div class="cat_loading">
            <div class="spinner"><div class="dot1"></div><div class="dot2"></div></div>
            <center style="font-size:17px;margin-top:-13px">Loading all departments...</center>
        </div> -->
        
        	<div class="grid_inner">
            	
                
                <div class="wrapper">
                  <div style="height:5px;" class="clear"></div>
          <div class="breadcrumbs fs12 l-hght26" style="">
                        <a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?>en"> Home </a> 
                        <span class="breeadset">›</span>

                        <span class="crm_active">Categories</span>
                        <section class="clear"> </section>
            </div>
           <div class="border45"></div>
					<div class="rowpanel3 leftpatern_MrT new_tag5">
        
    				<div class="categorylistContent" style="min-height:500px">

						<h1 class="cat_heading">See all categories</h1>

                        <div class="storesSpotBoxTop">

                          <div class="cat_list_content">
                       <?php 
                       if(!empty($catlist))
                          {
                           $i = 0;
                           $totalCount=count($catlist);
                            // $this->Product_category = ClassRegistry::init('Product_category');
                                                    
                          foreach($catlist as $k=>$product_category)
                          { 

      $pcat_lang_data = $this->Template->languageChanger($product_category['Product_category_lang']);
      $countprod=$this->Template->GetProductCountBycategory($product_category['Product_category']['id']);
                            if($i==0)
                            { ?>
                               <div class="cat_tab_content_area">
                                <div class="cat_tabs">
                           <?php }?>               
             <div class="cat_tab <?=($i==0)?'active':''?>" id="cat_tab<?=$product_category['Product_category']['id']?>" ><span class="sub_clcik" onclick="catlist.checkTabs(this,'<?=$product_category['Product_category']['id']?>');"><?=$pcat_lang_data['category_name']?> (<?=$countprod?>)</span> <span><a href="<?=$this->webroot?>/products/category-<?=$product_category['Product_category']['slug']?>"><span class="view_all_cat"></span></a></span></div>
                            <?php 
                            $i++;
                            if(($i==5) or  ($totalCount==($k+1)))
                            { 
                            ?>
                             </div>
                      <div class="cat_tab_contant">

                      </div>
                       <div class="overly filteroverly"><div class="ajax_loader"></div></div>
                              </div>
                              <div class="clear arbic_clear1" style="height: 2px;background: #FFA441;width: 99.2%;margin-bottom: 15px;margin: 0px auto 15px auto;"></div>
                            <?php 
                              $i=0;
                                } } }
                            ?>
                            
                          </div>


                                         
        </div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:13px;">&nbsp;</div>
        
        <!--  Footer Panel Start  -->
        
        <!--  Footer Panel Start  -->
      <?php echo $this->element('site-footer'); ?>
