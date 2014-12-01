<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Product">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1" />

<meta http-equiv="Content-Language" content="<?=$hlang?>" />
<title><?php $lang = $this->Template->getLang();
            if($lang == 'en')
                echo stripslashes($setting['Setting']['site_title']);
            else
                echo stripslashes($setting['Setting']['site_title_ar']); ?> | <?=$htitle?></title>
<meta name="title" content="<?=$htitle?>" />
<meta name="description" content="<?=$hdescription?>">
<meta name="keywords" content="<?=$hkeyword?>">
<?php
$lang=$this->Template->getLang();
if($lang=="en")
{
echo $this->Html->css('front-end/site_style');
echo $this->Html->css('front-end/mystyle');
echo $this->Html->css('front-end/bottomslider');
echo $this->Html->css('front-end/nanoscroller');
?>
<link rel='stylesheet' href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile.css' />
<link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad.css' /> 
<!-- <link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/tablet/portrait/tablet_view_frontend.css' /> -->

<!-- <link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/min_desktop/mindeskto_pview_frontend.css' /> -->
<?php
}
else
{
   echo $this->Html->css('front-end/site_style_ar');
   echo $this->Html->css('front-end/mystyle_ar'); 
   echo $this->Html->css('front-end/bottomslider_ar');
   echo $this->Html->css('front-end/nanoscroller_ar');
   ?>
   <link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile_ar.css' />

  <link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad_ar.css' /> 

   <!-- <link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/min_desktop/mindeskto_pview_frontend_ar.css' /> -->
   <?php
}
echo $this->Html->css('front-end/slider');
echo $this->Html->css('front-end/language-switcher');
echo $this->Html->script('front-end/jquery.min.js');
echo $this->Html->script('front-end/skdslider.min.js');
//echo $this->Html->script('front-end/jquery.nanoscroller.min');

echo $this->Html->css('front-end/nanoscroller');
echo $this->Html->css('front-end/skdslider');
?> 
<script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.typing-0.2.0.min.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="shortcut icon" href="<?php echo $this->webroot.$setting['Setting']['favicon'];?>" type="image/x-icon">

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#demo1').skdslider({
		'delay':5000,
		'animationSpeed': 2500,
		'showNextPrev':false,
		'showPlayButton':false,
		<?php if(count($banners)!=1){ ?>
		'autoSlide':true,
		<?php } else {?>
			'autoSlide':false,
		<?php } ?>
		'animationType':'fading'
	});	
	
	
});

</script>
<!-- Language selector script start   -->

<?php
echo $this->Html->css('front-end/language-switcher');
echo $this->Html->script('front-end/jquery.polyglot.language.switcher.js');

echo $this->Html->script('front-end/jquery.easing.1.3.js');
echo $this->Html->script('front-end/jquery.contentcarousel.js');

?> 
<script type="text/javascript" src="<?=$this->webroot?>js/front-end/home_app.js"></script>

<script type="text/javascript">
        var rootPath="<?=$this->webroot?>";
        var here="<?=$this->request->here?>";
        var lang="<?=$this->Template->getLang()?>";
     
   
          
    </script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55012366-1', 'auto');
  ga('send', 'pageview');

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
#back-top{bottom: -12px!important;}
</style>


</head>
