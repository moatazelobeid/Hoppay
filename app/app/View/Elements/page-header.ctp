<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1" />

<title>Mena Compare</title>
<?php
$lang=$this->Template->getLang();
if($lang=="en")
{
echo $this->Html->css('front-end/site_style');
echo $this->Html->css('front-end/mystyle');
echo $this->Html->css('front-end/site_header'); 
echo $this->Html->css('front-end/nanoscroller');
?>
<link rel='stylesheet' href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile.css' />
<link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad.css' /> 
<?php
}
else
{
   echo $this->Html->css('front-end/site_style_ar');
   echo $this->Html->css('front-end/mystyle_ar'); 
   echo $this->Html->css('front-end/site_header_ar'); 
   echo $this->Html->css('front-end/nanoscroller_ar');
   ?>
<link rel='stylesheet' href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile_ar.css' />
<link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad_ar.css' /> 
   <?php

}



echo $this->Html->css('front-end/jquery.nouislider');
echo $this->Html->css('front-end/language-switcher'); 
echo $this->fetch('css');

$lang = $this->Template->getLang();
//echo $this->Html->script('front-end/jquery.min');
?> 


<link rel="shortcut icon" href="<?php echo $this->webroot.$setting['Setting']['favicon'];?>" type="image/x-icon">
 <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script src="<?php echo $this->webroot;?>js/front-end/jquery.min.js"></script> 
<script src="<?php echo $this->webroot;?>js/front-end/jquery.nouislider.min.js"></script> 
<script type="text/javascript" src="<?=$this->webroot?>rating/rating.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$this->webroot?>rating/rating.css" />
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.nanoscroller.min.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/mustache.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/lazyload.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.ba-hashchange.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.polyglot.language.switcher.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.validater.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.numeric.js"></script>
 <script type="text/javascript" src="<?=$this->webroot?>js/front-end/Readmore.js"></script>
 
 <?php //echo $this->Html->script('front-end/jquery.polyglot.language.switcher'); ?>
 <?php //echo $this->Html->script('front-end/jquery.validater'); ?>
 <?php echo $this->Html->script('front-end/filter.js'); ?>
 <?php //echo $this->Html->script('front-end/jquery.nanoscroller.min'); ?>
 <?php /*
if($lang=="en")
{
  ?>
 <style type="text/css">
#polyglotLanguageSwitcher {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 12px;
color: #444;
line-height: normal;
position: relative;
z-index: 100;
margin-top: 12px;
background: white;
height: 26px;
border-radius: 2px;
display: inline-table;
left: 19px;
}
 </style>
 <?php }else
 { ?>
 <style type="text/css">
#polyglotLanguageSwitcher {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 12px;
color: #444;
line-height: normal;
position: absolute;
z-index: 100;
margin-top: 12px;
background: white;
height: 26px;
border-radius: 2px;
display: inline-table;
left: -14px;
}
#polyglotLanguageSwitcher a {
padding: 9px 25px 10px 20px!important;
background-position: 74px center!important;
direction: rtl!important;
line-height: 7px;
}
#polyglotLanguageSwitcher span.trigger {
display: block;
position: absolute;
width: 9px;
height: 5px;
text-indent: -10000em;
top: 10px!important;
left: 8px!important;
right: inherit!important;
font-family: Verdana, Arial, Helvetica, sans-serif;
}
 </style>
 
 
 
 
 
 
<?php } */
 ?>
 <!--[if !IE]><!-->
 <script>  
if (/*@cc_on!@*/false) {  
    document.documentElement.className+=' ie10';  
}  
</script>
<!--<![endif]--> 

<script type="text/javascript">

/*function validates(evt) {
    console.log('sdhf');
 var key = window.event ? event.keyCode : event.which;

    if (event.keyCode == 8 || event.keyCode == 46
     || event.keyCode == 37 || event.keyCode == 39) {
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true;
}*/
function innershow1(sthis){
    $("#innersample").toggle();
    $(sthis).addClass('active');
	$('.nano').nanoScroller({
   preventPageScrolling: true
 });

}
function hide1()
{
	$("#innersample").hide('');
}
jQuery.validator.setDefaults({
              debug: false,
              success: "valid"
            });
$(function(){
$('.nano1').nanoScroller();
  $('.nano').nanoScroller({
   preventPageScrolling: true
 });
  
 
           /* $("form").validate({rules: {
                  phone: {
                    required: true,
                    digits: true
                  },

              }
             });*/
            $(".validate").validate({rules: {
                  phone: {
                    required: true,
                    digits: true
                  },

              }
             });

});
$(document).mouseup(function (e){
    var container = $("#innersample");
    
    
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $("#active1").attr('class', 'department');
        $('.recent_visit').removeClass('active');
        //$('#dept').val(1);
    }
    
   

});
 var rootPath="<?=$this->webroot?>";
       var here="<?=$this->request->here?>";
       function getLangUrl(current,priv){
                  
                     var fullpath=window.location.origin+window.location.pathname;
                     console.log(window.location);
                     var getdata=fullpath.split('/'+priv+'/');
                     if(getdata[1]==undefined)
                     {
                     var path=window.location.origin+rootPath;
                     var rest=fullpath.split(path);
                     //rest[1].split;
                     var langPath=path+current+"/"+rest[1];
                     
                     }
                     else
                     {
                      var langPath=getdata[0]+"/"+current+"/"+getdata[1];
                       
                     }
                      langPath=langPath.replace('#',"");
                    // langPath+=window.location.hash;
                     //alert(langPath);
                     return langPath;
       }
$(document).ready(function(e){
	$("div.hover-text").hide();
		$("div.gimage").hover(function(){
		$(this).find("div.hover-text").slideToggle(500);
	});
	
	$("div.gimage").css({'position' : 'relative'});
	$("div.hover-text").css({'position' : 'absolute','bottom' :1});
    $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
        effect: 'fade',
                testMode: true,
                onChange: function(evt){
                  // alert("The selected language is: "+evt.selectedItem);
                    if(evt.selectedItem=="ar")
                    {
                      langPath=getLangUrl(evt.selectedItem,'en');
                    
                   }else if(evt.selectedItem=="en")
                   {
                     langPath= getLangUrl(evt.selectedItem,'ar');

                   }
                  //alert(langPath);
                  window.location.href=langPath;
                  //location.reload();
                    // console.log(langPath);
                }
//               
            });
    $("input#qa-catalogPrice").numeric(",");
     $("input#qa-catalogPriceTo").numeric(",");
});

console.log(window.location);

function showdetailspan(){
	$(".showdetailspnel").toggle();
}
function capitalize (text) {
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}
function hide1()
{
	$(".showdetailspnel").hide('');
}
function getSearchHints(id,text){
    //alert('dd');
    if(text!="")
    {
            $.post('<?=$this->webroot?>homes/getSearchHints',{'id':id,'text':text},function(r){
            //console.log(r);
            r=r.trim();
            if(r.length>0)
            {
                var searchHint=JSON.parse(r);
                if(searchHint.names!="")
                {   
                    $('.search_hints').slideDown();

                    var hint=$('<ul class="search_hint">');
                   hint.append("<li class='heading'>Search Suggestions</li>")
                    for(var x in searchHint.names)
                    {
                        var clas=""
                        //console.log(x);
                        if(x==0)
                        {
                             var clas="selected move";
                        }
                        else
                        {
                            var clas="move";
                        }
                        //var filter = new RegExp(text + "gi");
                       var changed_text=searchHint.names[x].toLowerCase().replace($.trim(text.toLowerCase()),'<b>'+$.trim(text.toLowerCase())+'</b>')
                        hint.append("<li class='"+clas+"'><a  href='<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-"+searchHint.slugs[x]+"-"+id+"'>"+capitalize(changed_text)+"</a></li>")
                       
                    }
                    /*if(searchHint.barands!="")
                    {
                       hint.append("<li class='heading'>Brand Matches</li>")
                        for(var x in searchHint.barands)
                        {
                            hint.append("<li class='move'><a  href='<?=$this->webroot?>brand-"+searchHint.barands[x]+"'>"+$.trim(searchHint.barands[x].replace(/[-]+/, " ")).toLowerCase()+"</a></li>")
                        }
                    }*/
                    
                    $('.total_hints').html(hint);
                        setTimeout(function() {
                            $(".nano").nanoScroller();
                        }, 100);
                }else
                {
                    $('.search_hints').slideUp();
                }
            }
            


            
        })

    }
    else
    {
      $('.search_hints').slideUp();
    }
}

$(function(){
   
    $('.search-bar-text').keyup(function(e){
        var keyup=0;
        
        switch (e.keyCode) {
            case 40:
                $('.search_hint .move:not(:last-child).selected').removeClass('selected').next('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $('.search-bar-text').val(searchtext);
                 keyup=1;
                break;
            case 38:
                $('.search_hint .move:not(:nth-child(2)).selected').removeClass('selected').prev('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $('.search-bar-text').val(searchtext);
                 keyup=1;
                break;
            case 13:
            var searchtext="";
                    if(keyup==1)
                    {
                         searchtext=$('.search_hint li.selected a').text()
                    }
                    //console.log(searchtext);
                    if(searchtext!='')
                    {
                      $('.search-bar-text').val(searchtext);
                      window.location.assign($('.search_hint li.selected a').attr('href')+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                    }
                     else if($.trim($('.search-bar-text').val())!="")
                    {
                          var id=$("#fk-top-search-box").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-');
                         window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                    }else
                    {
                        
                         var id=$("#fk-top-search-box").attr('data-id');
                         if(id!=0)
                         {
                            var slug=$("#showlistdata").attr('data-slug');
                            window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/products/category-'+slug+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                         }
                    }
                    /*else
                    {
                         var id=$("#fk-top-search-box").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-').toLowerCase();
                         window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id);
                    }*/
            break;
            default:
            if($(this).val().length>3)
               {
                var id=$("#fk-top-search-box").attr('data-id');
                if(id=="")
                {
                    id=0;
                }
               // getOffer(id,$(this).val());
                getSearchHints(id,$(this).val());
            }
            else
               {
                 $('.search_hints').slideUp();
               }
            break;
        }
         
    })

    
})
function changeCss(sert)
{
    //console.log(sert);
     $('.search_hints').slideUp();
}
function onSearch(){
    var id=$("#fk-top-search-box").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-').toLowerCase();
                         //console.log(slug);
                         if($.trim(slug)!="")
                         {
                            window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                         }
                         
}

$(document).mouseup(function (e){
    var container = $("#sample");
    var container1 = $("#sample1");
    var container2 = $("#sample2");
    
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $("#active1").attr('class', 'white');
        //$('#dept').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
    
    if (!container1.is(e.target) // if the target of the click isn't the container...
        && container1.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container1.hide();
        $("#active2").attr('class', 'white');
        //$('#brand').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
    
    if (!container2.is(e.target) // if the target of the click isn't the container...
        && container2.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container2.hide();
        $("#active3").attr('class', 'white');
        //$('#offer').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
     
});

function show1()
{
    // check the panel display status
    if($('#dept').val() == 1){
        $("#sample").show();
        $('#dept').val(2);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'yellow');
    }else{
        $("#sample").hide();
        $('#dept').val(1);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'white');
    }
}

function show2()
{
    if($('#brand').val() == 1){
        $("#sample1").show();
        $('#brand').val(2);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'yellow');
    }else{
        $("#sample1").hide();
        $('#brand').val(1);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'white');
    }
}

function show3()
{
    if($('#offer').val() == 1){
        $("#sample2").show();
        $('#offer').val(2);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'yellow');
		$(".nano").nanoScroller();
    }else{
        $("#sample2").hide();
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'white');
    }
}

function show4()
{
    $(".listdatapan").toggle();
    
}
function hide_department(){
        $("#sample").slideUp();
        $('#dept').val(1);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'white');
}
function hide_brand(){
        $("#sample1").slideUp();
        $('#brand').val(1);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'white');
}
function hide_offer(){
       $("#sample2").slideUp();
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'white');
}
function clear_recent(sthis,id){
$.post('<?=$this->webroot.$this->Template->getLang()?>/products/clear_recent',{'id': ""+id},function(r){
console.log(r);
if(r==1)
{
  
 $(sthis).parents('.gimage').parents('li').fadeOut(function(){
   console.log($('.recent_view ul li:visible').length);
    if($('.recent_view ul li:visible').length<=0)
     {
        $('.recent_view ul').html('<li><div class="not_fount">
        <?php  
                                if($this->Template->getLang() == "en"){
                                echo "You have not visited any Product till now.";
                                }else{
                                echo "لم تبحث عن اي منتج بعد";
                                }
                                ?>

        
        
        </div></li>');
     }
     $('.nano').nanoScroller({
        preventPageScrolling: true
     });
 });
 
}

});
}
function cleae_all_recent(){
    $.post('<?=$this->webroot.$this->Template->getLang()?>/products/clear_recent',{'clear':'all'},function(r){

if(r==1)
{
  
 $('.recent_view ul li').fadeOut(function(){
   console.log($('.recent_view ul li:visible').length);
    if($('.recent_view ul li:visible').length<=0)
     {
        $('.recent_view ul').html('<li><div class="not_fount"><?php  
                                if($this->Template->getLang() == "en"){
                                echo "You have not visited any Product till now.";
                                }else{
                                echo "لم تبحث عن اي منتج بعد";
                                }
                                ?>
</div></li>');
     }
     $('.nano').nanoScroller({
   preventPageScrolling: true
 });
 });
 
}

});
}
function close_recent(){
      var container = $("#innersample"); 
      container.hide();
        $("#active1").attr('class', 'department');
        $('.recent_visit').removeClass('active');
}

</script>
<script>
$(document).ready(function(){

    // hide #back-top first
    $("#back-top").hide();
    
    // fade in #back-top
    $(function () {
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
<style>
.error{
    color:#f00;
}
.inner_lang_switch{
    float: right;
}

</style>
</head>

<body>

    <div class="wrapper">
     <div class="header">   
    <div class="grid">
        <div class="inner_grid">
               	<div class="shopby"><?php echo $this->template->getWord('shop_by');?></div>
				
                <div id="nav">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" onclick="return show1();" id="active1" class="white"><?php echo $this->template->getWord('department');?></a>
                            <input type="hidden" name="dept" id="dept" value="1" />
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="return show2();" id="active2" class="white"><?php echo $this->template->getWord('brands');?></a>
                            <input type="hidden" name="brand" id="brand" value="1" />
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="return show3();" id="active3" class="white"><?php echo $this->template->getWord('offers');?></a>
                            <input type="hidden" name="offer" id="offer" value="1" />
                        </li>
                        <div class="clear" style="height:1px;"></div>
                    </ul>
                </div>
                
                <div class="loginpan" style="display:block;">
                    <ul>
                        <!--<li><a href="#" onclick="language_selector()">Language</a></li>-->
                        
                        <div id="polyglotLanguageSwitcher">
                        <?php $lang = $this->Template->getLang();?>
                            <form action="#">
                                <select id="polyglot-language-options">
                                    <option id="en" value="en" <?php if($lang == 'en'){echo 'selected';}?>><?php echo $this->template->getWord('english');?></option>
                                    <option id="ar" value="ar" <?php if($lang != 'en'){echo 'selected';}?>><?php echo $this->template->getWord('arabic');?></option>
                                </select>
                            </form>
                        </div>
                        
                        <div class="languagepanel" id="languagepan" style="display:none;">
                            <a href="#"><?php echo $this->template->getWord('english');?></a>
                            <a href="#" style="border:none; margin:0; padding:0;"><?php echo $this->template->getWord('arabic');?> </a>
                            <!--<div class="languagedot"></div>-->
                        </div>
                    </ul>
                </div>
             </div>
            </div>
              <div class="menupanel1" id="sample" style="display:none;">
                <div class="grid">
                    <div class="listdata">
                        <ul>
                            <div class="drop1"></div>
                            <?php 
                            if(!empty($product_categories))
                            {
                                foreach($product_categories as $key=>$product_category)
                                {
                                    if($key<13)
                                    {
                                         //echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;?>
                                         <li>
                                        <div class="gimage" onmouseover="">
                                            <div class="img_cover">
                                            <?php 
                                            if(!empty($product_category['Product_category']['image_url']))
                                            {
                                                echo $this->Html->image('../'.$product_category['Product_category']['image_url'], array('alt' => '', 'class'=>'img_thumbnail_image'));
                                            }
                                            else
                                            {
                                                echo $this->Html->image('no-image.png', array('alt' => '', 'class'=>'img_thumbnail_image'));    
                                            }?>
                                        </div>
                                            <h2>
                                                <?php 
                                                
                                                $product_lang_data = $this->Template->languageChanger($product_category['Product_category_lang']);
                                                
                                                $catname = stripslashes($product_lang_data['category_name']);
                                                $lang = $this->Template->getLang();
                                                if($lang == 'en')
                                                {
                                                    if(strlen($catname)>18)
                                                            $catname = substr($catname,0,18).'...';
                                                }
                                                $catslug = $product_category['Product_category']['slug'];
                                                
                                                //echo $this->Html->link($catname,array('controller' => 'homes','action' => 'productlist','full_base' => true));?>
                                                <a href="<?=$this->webroot.$this->Template->getLang();?>/homes/productlist" >
                                                    <?php echo $catname;?>
                                                </a>
                                            </h2>
                                            <?php 
                                            $this->Product_category = ClassRegistry::init('Product_category');
                                            $subcats=$this->Product_category->find('all', array(
                                                                'conditions' => array(
                                                                'Product_category.status' => 1, 
                                                                'Product_category.parent_id' => $product_category['Product_category']['id']
                                                                ),
                                                                //'limit'=>4
                                                            ));
                                                    //print_r($subcats);        
                                            if(!empty($subcats))
                                            {?>
                                                <div class="hover-text">

                                                    <div class="title2">
                                                         <a href="<?=$this->webroot.$this->Template->getLang();?>/products/category-<?=$catslug?>" >
                                                          <?=$catname?>
                                                           </a>
                                                        <?php //echo $this->Html->link($catname,array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true));?>
                                                    </div>
                                                        <ul>
                                                            <?php $i = 0;
                                                            foreach($subcats as $k=>$subcat)
                                                            {
                                                                //print_r();
                   $subcats[$k]['Product_category']['product_count']=$this->Template->GetProductCountBycategory($subcat['Product_category']['id']);
                                                            }
                 $subcats=Hash::sort($subcats, '{n}.Product_category.product_count', 'desc');
                           foreach ($subcats as $subcat) {
                              
                                                               
                                                                if($i<4)
                                                                {?>
            <li>
             <?php 
             $product_category_lang_data = $this->Template->languageChanger($subcat['Product_category_lang']);
            $subcatname = stripslashes($product_category_lang_data['category_name']);
            
            if($lang == 'en')
            {
                if(strlen($subcatname)>20)
                    $subcatname = substr($subcatname,0,20).'...';
            }
                $subcatslug = $subcat['Product_category']['slug'];?>
                    <a href="<?=$this->webroot.$this->Template->getLang();?>/products/category-<?=$subcatslug?>" >
                        <?=$subcatname?>
                    </a>
                <?php
                                                                       // echo $this->Html->link($subcatname,array('controller' => 'homes','action' => 'productlist','type'=>$subcatslug,'full_base' => true));?>
                                                                    </li>
                                                            <?php } $i++;
                                                            }?>
                                                        </ul>
                                                        <?php if(count($subcats)>4)
                                                        {?>
                                                            <div class="clear"></div>
                                                            <a href="<?=$this->webroot.$this->Template->getLang();?>/products/category-<?=$catslug?>" class = 'more'>
                                                           <?php echo $this->template->getWord('more');?>
                                                           </a>
                                                            <?php //echo $this->Html->link('More...',array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true),array('class'=>'more'));?>
                                                        <?php }?>
                                                    </div>
                                                </div>

                                            <?php }
                                            else
                                            {
                                                echo '<span style="color:#FFFFFF">No sub categories found.</span>';   
                                            }?>
                                    </li>

                                    <?php 
                                     }
                                }   
                            }?>
                            <li>
                                <div class="gimage">
                                    <a href="<?=$this->webroot.$this->Template->getLang();?>/homes/categorylist">
                                        <div class="img_cover">
                                        <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                         </div> 
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="icon_close" onclick="hide_department()">&nbsp;</div>
            </div>
            <!--  Shop By Department Menu Panel Start  -->
            
            <!--  Shop By Brand Menu Panel Start  -->
            <div class="menupanel1" id="sample1" style="display:none;">
                <div class="grid">
                    <div class="listdata">
                        <ul>
                            <div class="drop2"></div>
                            <?php 
                            if(!empty($product_brands))
                            {
                                foreach($product_brands as $product_brand)
                                {
                                    //echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;
                                    $brand_slug=$product_brand['Product_brand']['slug']; ?>
                                    <li>
                                        <div class="gimage" onmouseover="">
                                            <div class="img_cover">
                                            <?php 
                                            if(!empty($product_brand['Product_brand']['image_url']))
                                            {
                                                ?>
                                                <a href="<?=$this->webroot.$this->Template->getLang();?>/brand-<?=$brand_slug?>">
                                                <?php
                                                echo $this->Html->image('../'.$product_brand['Product_brand']['image_url'], array('alt' => '', 'class'=>'img_thumbnail_image'));
                                                ?>
                                                </a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="<?=$this->webroot.$this->Template->getLang()?>/brand-<?=$brand_slug?>">
                                                <?php
                                                echo $this->Html->image('no-image.png', array('alt' => '', 'class'=>'img_thumbnail_image'));
                                                ?>
                                                </a>
                                                <?php
                                            }
                                            $product_brand_lang_data = $this->Template->languageChanger($product_brand['Product_brand_lang']);
                                            $brand_title = stripslashes($product_brand_lang_data['brand_title']);
                                            if($lang == 'en')
                                            {
                                                if(strlen($brand_title)>20)
                                                    $brand_title = substr($brand_title,0,20).'...';
                                            }
                                            $brand_slug = $product_brand['Product_brand']['slug'];?>
                                            </div>
                                            <h2>
                                                <a href="<?=$this->webroot.$this->Template->getLang()?>/brand-<?=$brand_slug?>"><?=$brand_title?></a>
                                                <?php //echo $this->Html->link($brand_title,array('brand-'.$brand_slug,'full_base' => true));?>
                                            </h2>
                                        </div>
                                    </li>
                                    <?php 
                                }   
                            }?>
                            <li>
                                <div class="gimage">
                                    <a href="<?=$this->webroot.$this->Template->getLang();?>/homes/shopbybrand">
                                        <div class="img_cover">
                                    <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="icon_close" onclick="hide_brand()">&nbsp;</div>
            </div>
            <!--  Shop By Brand Menu Panel Start  -->
            
            <!--  Shop By Offer Menu Panel Start  -->
            <div class="menupanel1" id="sample2" style="display:none;">
                <div class="grid">
                    <div class="listdata">
                        <?php /*?><ul>
                            <div class="drop3"></div>

                            <?php foreach ($offer as $key => $value) { 
                                
                                $image=json_decode($value['Product']['image_url']);
                                $offer_price=($value['Product']['price']-($value['Product']['price']*$value['Offer']['discount']/100));

                                $product_lang_data = $this->Template->languageChanger($value['Product_lang']);

                                ?>
                                <li>
                                <a href="<?=$this->webroot.$this->Template->getLang()."/products/".$value['Product']['id']?>-<?=$value['Product']['slug']?>" style="text-decoration:none;">
                                <div class="gimage">
                                    <div class="g-offers"><span><?=$this->Template->getPriceFormat(number_format($value['Product']['price'],2));?></span>&nbsp;&nbsp;<b><?=$this->Template->getPriceFormat(number_format($offer_price,2));?></b><br><img src="<?=$value['Offer']['offer_image']?>" style="height:30px;float:left;margin-top:1px;width:auto" alt="hoppay"><span><?=$value['Offer']['offer_desc']?></span></div>
                                    <div class="img_cover">
                               <img src="<?=$image[0]?>" alt="hoppay">
                           </div>
                                <h2><?=(strlen($product_lang_data['title'])>10)?substr($product_lang_data['title'],0,20).'..':$product_lang_data['title']?></h2>
                                </div>
                                </a>
                            </li>
                            <?php } ?>
                             
                            
                          
                            <?php if(!empty($offer)){ ?>
                            <li class="last">
                                <div class="gimage">

                                    <a href="<?=$this->webroot.$this->Template->getLang()?>/homes/offers">
                                      <div class="img_cover">
                                        <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                      </div>
                                    </a>
                                </div>
                            </li> 

                            <?php }else{ ?>
                                <h1 style="width: 100%"><span style="text-align:center;">No offers found.</span></h1>
                            <?php } ?>
                        </ul><?php */?>
                        <?php $this->Template->getHeaderOffers();?>
                    </div>
                </div>
                <div class="icon_close" onclick="hide_offer()">&nbsp;</div>
            </div>
            </div>
    	<div class="inner_header">
        	<!--  Main Menubar link Panel Start  -->
        	<div class="grid_inner">
            	<div class="toplogo">
                	<a href="<?php echo $this->webroot.$this->Template->getLang(); ?>">
                    	<?php echo $this->Html->image('../'.$setting['Setting']['logo'], array('alt' => ''));?>
                        <?=$this->Template->getTagLine('innertag')?>
                        <!--<span class="innertag">Maximize Your Savings</span>-->
                    </a>
                </div>
                
                <div class="righttop">
                	<div class="loginpan">
                        <ul>
                        	<li>24x7 Customer Care</li>
                            <li>|</li>
                            <li><a href="#"><?php echo $this->template->getWord('sign_up');?></a></li>
                            <li>|</li>
                            <li><a href="#" style="padding-right:0;"><?php echo $this->template->getWord('sign_in');?></a></li>
                        </ul>
                    </div>
                    
                    <a href="javascript:void(0)" class="recent_visit"  onclick="return innershow1(this);" onblur="return innerhide1();" id="active1"><?php echo $this->template->getWord('recent_view');?></a>
               
                   <?php /* ?> <div id="polyglotLanguageSwitcher" class="inner_lang_switch" >
                            <form action="javascript:void(0)">
                                <select id="polyglot-language-options">
                                    <option id="en" value="en"<?=$this->Template->Select($this->Template->getLang(),'en')?>>English</option>
                                    <option id="ar" <?=$this->Template->Select($this->Template->getLang(),'ar')?> value="ar">Arabic</option>
                                </select>
                            </form>
                        </div> <?php */ ?> 
                
                   
                    
                	<div class="seacrhpanel">
                    	
                    <div class="unit search-bar-text-wrap size5of6">
                    	<?php
						$cat_lang_data = '';
						if(isset($category_searched))
						{
							$cat_lang_data = $this->Template->languageChanger($category_searched['Product_category_lang']);
						}?>
                        <input type="text" name="q" class="search-bar-text fk-font-13 ac_input" placeholder="<?php echo $this->template->getWord('search_for_a_product');?>" value="<?php echo @$cat_lang_data['category_name'];?>" data-id="<?=@$this->request['pass']['cat_id']?>" id="fk-top-search-box"  autocomplete="off" onfocusout="changeCss(this)" >
                        <style>
                        .search_hints{
                            max-height:400px !important;
                        }
                        </style>
                        <div class="nano search_hints" style="top: 36px;left: 15px;box-shadow: 0px 1px 4px #666;z-index: 1;">
                                <div class="nano-content total_hints">
                                   <!---Here the suggesion will riflect -->
                               </div>
                          </div>
                        <div class="related">
                            Related Searches: <a href="#">cell phones smart...,</a> <a href="#">boost mobile cell...,</a> <a href="#"><?php echo $this->template->getWord('more');?>...</a>
                        </div>
                       
                       <div class="searchnow1_inner" id="imgpan" style="">
                            <input type="submit" class="searchbutton1" value="" onclick="onSearch()">
                        </div>
                    </div>
                    </div>
                </div>
				
				
                
                
                <!--  Login Panel StaEndrt  -->
                
            </div>
            <div class="innertopshadow"></div>
            <div class="grid_inner">
            <div class="menupanel2 recent_view" id="innersample" style="display:none;">
                 <div id="about" class="nano recent_v">
                      <div class="nano-content"> 
                    <div class="grid_inner">
                        <div class="listdata">
                        
                            <ul>
                           <?php /*?><div class="drop1_inner" onclick="return innershow1();" onblur="return innerhide1();" id="active1"><?php echo $this->template->getWord('recent_view');?></div> <?php */?>
                            <?php 
                         //  print_r($recent_viewed);
                            if(!empty($recent_viewed))
                            {

                                $i=0;
                                foreach($recent_viewed as $key=>$recent)
                                {
                                    //echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;
                                    if($i>=5)
                                    {
                                        break;
                                    }
                                    $i++;
                                    $catname=$this->Template->summary($catname,18);
                                                $product_slug = $recent['slug'];
                                                $prod_id=$recent['id'];
                                    ?>
                                    <li>
                                        <div class="gimage" >
                                             <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod_id?>-<?=$product_slug?>" >
                                            <div class="img_recent_cover">
                                               
                                            <?php 
                                            if(!empty($recent['img']))
                                            {
                                                echo $this->Html->image($recent['img'], array('alt' => '', 'class'=>'img_thumbnail_image'));
                                            }
                                            else
                                            {
                                                echo $this->Html->image('no-image.png', array('alt' => '', 'class'=>'img_thumbnail_image'));    
                                            }?>
                                               
                                            </div>
                                             </a>
                                            <div class="viewd_content">
                                            <h2>
                                                <?php 
												
                                                $catname = $recent['name'];
                                                
												/*if($lang == 'en')
												{
                                                	if(strlen($catname)>18)
                                                            $catname = substr($catname,0,18).'...';
												}*/
                                                
                                                ?>
                                                <a href="<?=$this->webroot?><?=$this->Template->getLang()?>/products/<?=$prod_id?>-<?=$product_slug?>" > <?=$catname?>
                                                           </a>
                                                       
                                            </h2>
                                            <span class="price"><?=$recent['price'] ?></span>
                                            <a href="javascript:void(0)" class="clear_view" onclick="clear_recent(this,'<?=$key?>')">&times;</a>
                                        </div>
                                    </li>
                                    <?php 
                                }   
                            }else{
                                ?>
                                <li>
                                <div class="not_fount">
                                <?php  
                                if($this->Template->getLang() == "en"){
                                echo "You have not visited any Product till now.";
                                }else{
                                echo "لم تبحث عن اي منتج بعد";
                                }
                                ?>
                                
                                </div></li>
                                <?php } ?>
                            
                        </ul>

                        </div>
                        
                    </div>
                    </div>
</div>  
                        <div class="stiky_manues">
                            <div class="close_review_all" onclick="close_recent();"><?=$this->Template->getWord('close')?> &times;</div>
                            <div class="clere_review" onclick="cleae_all_recent();"><?=$this->Template->getWord('clear_all')?></div>                           
                        </div>
                </div>
                </div>
        </div>
        
        
        <div class="clear" style="height:1px; background:#fff;"></div>
