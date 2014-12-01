<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">
$(function(){ 
	$(".social_h").hover(function(){ 
		$(".social_h").stop(true, false).animate({left: "84" }, 500, 'easeOutQuint' ); }, function(){
		$(".social_h").stop(true, false).animate({left: "0px" }, 500, 'easeInQuint' ); 
	},1000); 
});

</script>


<style>
.social_h{ width: 80px; position: fixed; top: 100px; z-index: 99997;left:0px; }
		
.social_text{ 
float: left;
cursor: pointer;
position: relative;
background: rgb(32, 96, 167);
z-index: 99998;
width: 39px;
height: 108px;
background: url(<?=$this->webroot?>images/refer.png);
background-repeat: no-repeat;
cursor: pointer;
top: -17px;
} 
			 .clt1{
  float: none;
  width: 286px;
  position: relative;
  bottom: 25px;
  margin: 0 auto;
}
.clt2{
  float: none;
margin: 0 auto;
background: #fff no-repeat;
height: 50px;
box-shadow: 0 0 7px #8D9197;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
opacity: .7;
-webkit-transition: all .2s ease-in-out 0s;
-moz-transition: all .2s ease-in-out 0s;
-o-transition: all .2s ease-in-out 0s;
-ms-transition: all .2s ease-in-out 0s;
transition: all .2s ease-in-out 0s;
border: 2px solid #fff;
position: relative;
width: 70%;
top: -16px;
}
/*.sharebutton { 
/*box-shadow: 0px 1px 1px rgb(123, 124, 124);
background-color: #fff;
float: left;
top: -150px;
position: relative;
z-index: 99999;
width: 60px;
padding: 10px;
height: auto;
border-bottom-right-radius: 6px;
border-top-right-radius: 6px;
left:-84px;
border:#526dbf 2px solid;
 }	 */

</style>



<body style="overflow:hidden;">
<meta property="og:title"
content="<?=$htitle?>" />
<meta property="og:site_name" content="<?=$htitle?>"/>
<meta property="og:url"
content="<?=$this->webroot?>" />
<meta property="og:description" content="<?=$hdescription?>" />
<meta property="fb:app_id" content="" />
<meta property="og:type" content="Home Page" />

    <div class="wrapper">
    
    	<div class="header">
        	<!--  Main Menubar link Panel Start  -->
        	<div class="grid">
            	<div class="shopby"><?php echo $this->template->getWord('shop_by');?></div>

            	<div id="nav">
                    <ul>
                        <li>
							<a href="#" onclick="return show1();" id="active1" class="white"><?php echo $this->template->getWord('department');?></a>
							<input type="hidden" name="dept" id="dept" value="1" />
						</li>
						<li>
							<a href="#" onclick="return show2();" id="active2" class="white"><?php echo $this->template->getWord('brands');?></a>
							<input type="hidden" name="brand" id="brand" value="1" />
						</li>
                        <li>
							<a href="#" onclick="return show3();" id="active3" class="white"><?php echo $this->template->getWord('offers');?></a>
							<input type="hidden" name="offer" id="offer" value="1" />
						</li>
                        <div class="clear" style="height:1px;"></div>
                    </ul>
                </div>
                
                <div class="loginpan" style="display:block;">
                	<ul>
                        <!--<li><a href="#" onclick="language_selector()">Language</a></li>-->
						<?php 

            $this->Template->getMultiLang();
            ?>
						<?php /*?><div id="polyglotLanguageSwitcher">
                        
							<form action="#">
								<select id="polyglot-language-options">
									<option id="en" value="en" <?php if($lang == 'en'){echo 'selected';}?>>English<?php //echo $this->template->getWord('english');?></option>
									<option id="ar" value="ar" <?php if($lang != 'en'){echo 'selected';}?>><?php echo $this->template->getWord('arabic');?></option>
								</select>
							</form>
						</div>
						
						<div class="languagepanel" id="languagepan" style="display:none;">
							<a href="#"><?php echo $this->template->getWord('english');?></a>
							<a href="#" style="border:none; margin:0; padding:0;"><?php echo $this->template->getWord('arabic');?> </a>
							<!--<div class="languagedot"></div>-->
						</div><?php */?>
                    </ul>
                </div>
                
                <style>
									
					#twitter-widget-0{
					/*width:49px !important;*/
					}
					#twitter-width-0 #widget .btn-o a span.lable{
					font-size: 9px !important;
					}
					#___plus_0{
					display:block !important;
					margin-top:7px !important;
					}
				</style>
				
                
                
              <!--   <div class="social_h">
        	<div class="social_text">&nbsp;</div> -->
          
           	  <div class="sharebutton">
			   		<!--<a href="#"><?php //echo $this->Html->image('sahre.png', array('alt' => '', 'title' => 'Facebook'));?></a>-->
                    <!--  <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmaasinfotech24x7.com%2Fentertaiment&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="No" frameborder="0" style="border:none; overflow:hidden; width:83px; height:21px;" allowtransparency="true"> </iframe> -->
                   <!--  <a href="javascript:fbShare('<?=$this->webroot?>', 'Fb Share', 'Facebook share popup', 'http://goo.gl/dS52U', 520, 350)">Share</a> -->
                   <!-- <div class="fb-like" data-href="http://menacompare.com/demo" data-width="90" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div> -->
                   <!-- <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-width="108"></div> -->
                   <div class="fb-like" data-href="http://hoppay.com" data-width="1000" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                   <div class="clear" style="height:5px;"></div>
                   
                   <a href="https://twitter.com/share" class="twitter-share-button"></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- Place this tag in your head or just before your close body tag. -->
<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble" data-href="http://hoppay.com"></div>
                 <?php /*?> <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://menacompare.com/demo" data-counturl="http://menacompare.com/demo" data-lang="en" data-count="vertical"></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script><?php */ ?>
			   </div>
          
     <!--    </div> -->
                
                
              
                
                
            </div>
			
			
			
			
			
            <!--  Main Menubar link Panel End  -->
            
            <!--  Shop By Department Menu Panel Start  -->
            <div class="menupanel1" id="sample" style="display:none;">
            	<?php echo $this->Template->getDepartMentTop(); ?>
            </div>
            <!--  Shop By Department Menu Panel Start  -->
            
            <!--  Shop By Brand Menu Panel Start  -->
            <div class="menupanel1" id="sample1" style="display:none;">
            <?php echo $this->Template->getBrandOnTop(); ?>
            </div>
            <!--  Shop By Brand Menu Panel Start  -->
            
            <!--  Shop By Offer Menu Panel Start  -->
            <div class="menupanel1" id="sample2" style="display:none;">
            	<div class="grid">
                	<div class="listdata">                    	
                        <?php $this->Template->getHeaderOffers();?>
                    </div>
                </div>
                  <div class="icon_close" onclick="hide_offer()">&nbsp;</div>
            </div>
            <!--  Shop By Offer Menu Panel End  -->
           
        </div>
      
        <!--<div class="shadow"></div>-->
        
        <!--  Main body Slider Panel Start  -->
        <?php if(!empty($banners))
		{?>
    	<div class="sliderpanel">
		  	<div id="responsive_wrapper">
			  <ul id="demo1">
              	<?php 
              
				foreach($banners as $banner)
				{ 
					  $banner_lang_data = $this->Template->languageChanger($banner['Banner_lang']);?>
                	<li>
       <img class="front_back_banner" alt="" src="<?=$this->webroot?><?=htmlspecialchars_decode($banner['Banner']['banner_img'])?>" 
        data-port="<?=$this->webroot?><?=htmlspecialchars_decode($banner['Banner']['banner_img_port'])?>" data-land="<?=$this->webroot?><?=htmlspecialchars_decode($banner['Banner']['banner_img'])?>" alt="<?=stripslashes($banner_lang_data['banner_title'])?>">
					
                    </li>
                <?php } ?>
			  </ul>
			</div>
        </div>
		<?php }?>
        <!--  Main body Slider Panel End  -->
         
        <!--Footer Slider Panel Start-->
		
        <div class="fotpanslider">
			<div class="fullscreen" onclick="hidefooter()">&nbsp;</div>
			<div id="ca-container" class="ca-container">
				<div class="ca-wrapper">
					<?php foreach ($slider as $key => $value) { ?>	
                    <?php if($value['Profile']['image_url']!=""){ ?>	
						<div class="ca-item">
							<div class="ca-item-main">
							  <div class="bottomtitle"><a target="_blank" href="<?=$value['Profile']['url']?>"><?=$value['Profile']['website_name']?></a></div>
							  <?php //echo $this->Html->image($value['Profile']['image_url'], array('alt' => ''));?>
							<a target="_blank" href="<?=$value['Profile']['url']?>"> 
                            <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="middle" style="height:100%;vertical-align: middle;"> 
                                    <img src="<?=$this->webroot?><?=$value['Profile']['image_url']?>" alt="<?=$value['Profile']['website_name']?>" alt="">
                        </td>
                    </tr>
          </table>
                            </a>
							</div>
						 </div>
					<?php }}?>
				<?php /*?><div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://ikea.com">Ikea</a></div>
						  <a target="_blank" href="http://ikea.com"><?php echo $this->Html->image('ikea.png', array('alt' => ''));?></a>
						</div>
					  </div> 
					 
					  
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://souq.com">Souq</a></div>
						  <a target="_blank" href="http://souq.com"><?php echo $this->Html->image('souq.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  
					 
					  
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://sukkar.com">Sukar</a></div>
						 <a target="_blank" href="http://sukkar.com"> <?php echo $this->Html->image('sukar.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  
					 
					  
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://markavip.com">Marka VIP</a></div>
						 <a target="_blank" href="http://markavip.com"> <?php echo $this->Html->image('mark-vip.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://axiomtelecom.com">Axiom Telecom</a></div>
						<a target="_blank" href="http://axiomtelecom.com">  <?php echo $this->Html->image('axiom.png', array('alt' => ''));?></a>
						</div>
					  </div>

					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://alhaddadshop.com">Alhaddad</a></div>
						<a target="_blank" href="http://alhaddadshop.com">  <?php echo $this->Html->image('alhaddad.jpg', array('alt' => ''));?></a>
						</div>
					  </div>
                     <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://fmp.com.sa">FMP</a></div>
						<a target="_blank" href="http://fmp.com.sa">  <?php echo $this->Html->image('fmp.png', array('alt' => ''));?></a>
						</div>
					  </div>

					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://memega.com">Memega</a></div>
						<a target="_blank" href="http://memega.com">  <?php echo $this->Html->image('memega.png', array('alt' => ''));?></a>
						</div>
					  </div>
					   <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://i-weaver.com">Iweaver</a></div>
						<a target="_blank" href="http://i-weaver.com">  <?php echo $this->Html->image('i-weaver.png', array('alt' => ''));?></a>
						</div>
					  </div>
					   <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://store.istyle.sa">Istyle</a></div>
						<a target="_blank" href="http://store.istyle.sa">  <?php echo $this->Html->image('istyle.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://aljiser.com">Aljiser</a></div>
						<a target="_blank" href="http://aljiser.com">  <?php echo $this->Html->image('aljiser.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://mrinksystem.com">MRinksystem</a></div>
						<a target="_blank" href="http://mrinksystem.com">  <?php echo $this->Html->image('mrinksystem.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://e-nogta.com">e-nogta</a></div>
						<a target="_blank" href="http://e-nogta.com">  <?php echo $this->Html->image('e-nogta.png', array('alt' => ''));?></a>
						</div>
					  </div>
					   <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://iphady.com">Iphady</a></div>
						<a  target="_blank" href="http://iphady.com">  <?php echo $this->Html->image('iphady.png', array('alt' => ''));?></a>
						</div>
					  </div>	
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://harfone.com">Harfon</a></div>
						<a target="_blank" href="http://iphady.com">  <?php echo $this->Html->image('harfone.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://terfih.com">Terfih</a></div>
						<a target="_blank" href="http://terfih.com">  <?php echo $this->Html->image('terfih.png', array('alt' => ''));?></a>
						</div>
					  </div>
					  <div class="ca-item">
						<div class="ca-item-main">
						  <div class="bottomtitle"><a target="_blank" href="http://estore.dng.sa">Estore</a></div>
						<a target="_blank" href="http://estore.dng.sa">  <?php echo $this->Html->image('dng.png', array('alt' => ''));?></a>
						</div>
					  </div>	
                      <div class="ca-item">
                        <div class="ca-item-main">
                          <div class="bottomtitle"><a target="_blank" href="http://soukokadh.com/">Soukokadh</a></div>
                        <a target="_blank" href="http://soukokadh.com/">  <?php echo $this->Html->image('merchant/souk.png', array('alt' => ''));?></a>
                        </div>
                      </div>    
					 <?php */ ?>
					  
					 
				</div>
		 </div>
        </div>
		
		
		
        <!--Footer Slider Panel End-->
		
        <!--  Search Panel Start  -->
        <div class="grid">
             <div class="serachpan">
                <div class="clt1">
                    <?php echo $this->Html->image('../'.$setting['Setting']['logo'], array('alt' => ''));?>
                    <br />
                    <?=$this->Template->getTagLine()?>
                </div>
                
               <div class="clt2" onmouseover="changeThe1(this)" onmouseout="changeCss1(this)">
               <!--  <div class="clt2"> -->
                    <div class="leftitempanel2">            
						<?php 
						//echo $id;
						//echo $text;
                        //echo "<pre>";print_r($product_cate);echo "</pre>";
						?>
						<div class="searchlistpan dropdown_product" data-id="0" data-slug="" id="showlistdata" onclick="show4()">
							<?php echo $this->template->getWord('all');?>
						</div>
					
					
						<div class="listdatapan" style="display:none;">
                            <div id="about" class="nano">
                                 <div class="nano-content">  
							<span id="linkID0" onclick="displayDropdown(0)"><?php echo $this->template->getWord('all');?></span>
							<?php 

                            foreach ($product_cate as $key => $value) 
							{ 
								 $product_category_lang_data = '';
								 $product_category_lang_data = $this->Template->languageChanger($value['Product_category_lang']);
                                // echo $value['Product_category']['slug'];
                                 ?>

								<span id="linkID<?=$value['Product_category']['id']?>" onclick="displayDropdown(<?=$value['Product_category']['id']?>,'<?=$value['Product_category']['slug']?>')"><?=$product_category_lang_data['category_name']?></span>

							<?php }?>
                            </div>
                            </div>
							
						</div>
                        <div class="leftitempanel">
                           <input type="text" name="q" id="searchbar" autocomplete="off"  class="searchbar" placeholder="<?php echo $this->template->getWord('what_are_you_shopping_for');?>" onfocusin="changeThe(this)" onfocusout="changeCss(this)"  onkeyup="addimage(this.value)"/>
                            <?php /*?><input type="text" name="q" id="searchbar" autocomplete="off"  class="searchbar" placeholder="<?php echo $this->template->getWord('what_are_you_shopping_for');?>" /><?php */?>
                            <div class="nano search_hints">
                                <div class="nano-content total_hints">
                                   <!---Here the suggesion will riflect -->
                               </div>
                          </div>
                        </div>
					      
						
                        <div class="searchright">
                        	<div class="searchnow_normal" id="imgpan">
                            <input type="submit" class="searchbutton_normal" onclick="onSearch()" value=""/>
                            </div>
                            
                            
                            <div class="searchnow" id="imgpan" style="display:none;">
                                <input type="submit" class="searchbutton" onclick="onSearch()" value=""/>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
                <div class="clear" style="height:1px;"></div>
            </div>
        </div>
        <!--  Search Panel End  -->
      