    <!--<div class="wrapper">
                    <div class="rowpanel3 leftpatern_MrT new_tag3" style="">      
                    <h1 style="text-align: left;">How it works</h1>
                    <p></p> 
                    <h1>Coming Soon</h1>
                  

                    </div>
                </div>
               
                <div class="clear" style="height:420px;">&nbsp;</div>
                
            </div>
        </div>
        
        </div>
        <div class="clear" style="height:0px;">&nbsp;</div>
        <!--  Main Body Panel End  -->
        <?php 
        	 $attrs=$this->Template->GetPageAttrByActionKey('howitwork_inner',$page_data['Page']['id']);
        	 $video=$this->Template->GetPageAttrByActionKey('video_link',$page_data['Page']['id']);
        	 $video=array_values($video);
        	 //print_r($video);
        	 $menutitle=$this->Template->languageChanger($menu_data['Menu_lang']);
        ?>
        
  <div class="wrapper" >
					<div class="rowpanel3">
               		<h1><?=$menutitle['menu_title']?></h1>
					
					
					
					
					<div style="height:40px; clear:both;"></div>
					
					<div>
						<?php foreach ($attrs as $key => $value) { ?>	
						<div class="worksSteps">
	                        	<a href="javascript:void(0)" style="cursor:default" title="worksSteps">
	                            	<img src="<?=$this->webroot?><?=$value->img?>" alt="<?=$value->key?>" />
	                        	</a>
	                        	<a href="javascript:void(0)" style="cursor:default"><span class="step"><?=($key+1)?>.</span><?=$value->key?></a>
	                        </div>
                        <?php }?>
                       <!--  <div class="worksSteps">
                        	<a href="#fn1" title="">
                            	<img src="<?=$this->webroot?>img/stpeping2.jpg"  alt="hoppay" />
                        	</a>
                        	<a href="#"><span class="step">2.</span>Upload data feed in Merchant panel</a>
                        </div>
                        
                        <div class="worksSteps">
                        	<a href="#fn1" title="worksSteps">
                            	<img src="<?=$this->webroot?>img/stpeping3.jpg"  alt="hoppay" />
                        	</a>
                        	<a href="#"><span class="step">3.</span>List your product at Menacompare</a>
                        </div>
                        
                        <div class="worksSteps">
                        	<a href="#fn1" title="worksSteps">
                            	<img src="<?=$this->webroot?>img/stpeping4.jpg"  alt="hoppay" />
                        	</a>
                        	<a href="#"><span class="step">4.</span>Customer see your products</a>
                        </div>
                        
                        <div class="worksSteps">
                        	<a href="#fn1" title="worksSteps">
                            	<img src="<?=$this->webroot?>img/stpeping5.png"  alt="hoppay" />
                        	</a>
                        	<a href="#"><span class="step">5.</span>Customer Buy your Products</a>
                        </div> -->
                    </div>
					
					<div style="height:25px; clear:both;border-bottom: 1px solid rgb(216, 216, 216);margin-bottom: 13px;"></div>
					
					
                    
                    
                    
                    <div class="vid_l">
                    <?php foreach ($attrs as $key => $value) { ?>	
					
					<h4 class="worksSteps">
						<span class="step">Step <?=($key+1)?></span><?=htmlspecialchars_decode($value->key)?>
					</h4>
					
					<p class="datapan talign">
						<?=htmlspecialchars_decode($value->values)?>        
					</p>
					<?php }?>
					
                    </div>
                    
                    <div class="vid_r">
                    <div class="videopan1" style="height:422px">
                    	<?php 
                    	if($video[0]->values!="")
                    	{
                    		echo htmlspecialchars_decode($video[0]->values);
                    	}
                    	else if($video[0]->img!="")
                    	{
                    		echo "<img src='".$this->webroot.$video[0]->img."' style='width:100%;height:100%' alt="video">";
                    	}
						

						?>
						<!-- <object width="479" height="422"><param name="movie" value="//www.youtube-nocookie.com/v/yas90zRY640?version=3&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//www.youtube-nocookie.com/v/yas90zRY640?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="479" height="422" allowscriptaccess="always" allowfullscreen="true"></embed></object> -->
					</div>
                    </div>
                    
                    <div class="clear"></div>
                    
					
					
					<!-- <h4 class="worksSteps">
						<span class="step">Step 2</span>Upload data feed in Merchant panel
					</h4>
					
					<p class="datapan" style="text-align:left!important;">
						Upload data feed at Menacompare to list all your products quickly. Menacompare’s data feed upload is very handy to upload your product details in less time.        
					</p>
					
					
					<h4 class="worksSteps">
						<span class="step">Step 3</span>List your product at Menacompare
					</h4>
					
					<p class="datapan" style="text-align:left!important;">
						Once you have uploaded the data feed, your products will be available to the customers to view the product details and put their comments.       
					</p>
					
					
					<h4 class="worksSteps">
						<span class="step">Step 4</span>Customers see your products 
					</h4>
					
					<p class="datapan" style="text-align:left!important;">
						Customers at Menacompare can search, find and compare your products, put comments and can also view the related products.        
					</p>
					
					
					<h4 class="worksSteps">
						<span class="step">Step 5</span>Customer Buy your Products
					</h4>
					
					<p class="datapan" style="text-align:left!important;">
						Customers can jump to the Buyer’s site to purchase any product from Menacompare. We provide very handy tools to manage the products, eye catching product visuals to attract more customers to visit and buy your products.        
					</p> -->
					
					
					
					
					
					
					
					
					
					
					
					<div style="height:25px; clear:both;"></div>
					
					<!--<h1><?=$page_data['Page_lang'][0]['pg_title']?></h1>-->
					
                    <!--<p style="text-align:left">
                        <?=htmlspecialchars_decode($page_data['Page_lang'][0]['pg_descriptions'])?>
                    </p>-->
					
					
                    
                   <?php /* ?> <div class="shadow2">&nbsp;</div>
                    
					
					
					
                    
					<div class="MrT_NorDV">
						<div class="MrT_dv1">
							<img src="<?=$this->webroot?>images/front-end/homeslide/Bigstock_44483356.jpg" width="100%" height="100%"  alt="hoppay" />
						</div>
						
						<div class="MrT_dv2 suez-col-5">
							<h3>Trusted Stores</h3>
							<p>
								The Mena Compare program is designed to help customers easily find merchants who offer a superior online shopping experience.
Merchants who are accepted into the Program can become eligible to display the Program badge on pages of their websites to let shoppers know that they offer reliable shipping and great customer service.
For retailers, it creates an opportunity to differentiate their business, attract new customers, and increase sales by displaying a Trusted Stores badge, awarded to merchants that demonstrate a strong track record of on-time shipping and excellent customer service.  </p>
<p>When a customer completes an order with a Merchant who has been deemed eligible to display the badge on their website, the customer will be offered the opportunity on the order confirmation page to have their order protected by Mena Compare. This protection helps ensure a great shopping experience for customers. </p>


							</p>
						</div>
						
						<div class="clear"></div>
					</div>
					
					<div class="clear" style="height:20px;"></div>
                    <div class="shadow2">&nbsp;</div>
                    <div class="clear" style="height:5px;"></div>
					
					<div class="MrT_NorDV">
						<div class="MrT_dv3">
							<h3>Shop online with confidence</h3>
							<p>
								Shop knowing you’ll receive reliable shipping, excellent customer service, and free purchase protection with Mena Compare Trusted Stores.
							</p>
							<a class="MrT_normal_btn" href="#">Get Started Now</a>
						</div>
						
						<div class="MrT_dv4 suez-col-5">
							<object type="application/x-shockwave-flash" data="http://player.longtailvideo.com/player5.9.swf" width="100%" height="100%" bgcolor="#000000" id="player1" name="player1" tabindex="0">
								<param name="allowfullscreen" value="true" />
								MrT is Typing...
								<param name="allowscriptaccess" value="always" />
								<param name="seamlesstabbing" value="true" />
								<param name="wmode" value="opaque" />
								<param name="flashvars" value="netstreambasepath=http%3A%2F%2Fwww.longtailvideo.com%2Faddons%2Fskins%2F18%2FDangDang%3Fq%3D&amp;image=%2Fjw%2Fupload%2Fbunny.jpg&amp;id=player1&amp;levels=%5B%5BJSON%5D%5D%5B%7B%22file%22%3A%22%2Fjw%2Fupload%2Fbunny.mp4%22%2C%22type%22%3A%22video%2Fmp4%22%2C%22width%22%3A0%2C%22bitrate%22%3A0%7D%5D&amp;stretching=fill&amp;skin=http%3A%2F%2Fwww.longtailvideo.com%2Ffiles%2Fskins%2Fdangdang%2F4%2Fdangdang.swf&amp;controlbar.position=over&amp;volume=100" />
							</object>
						</div>
						
						<div class="clear"></div>
					</div>
					
					
					
					
					<div class="MrT_NorDV">
						<div class="MrT_dv1">
							<img src="<?=$this->webroot?>images/front-end/homeslide/Bigstock_44483356.jpg" width="100%" height="100%"  alt="hoppay" />
						</div>
						
						<div class="MrT_dv2 suez-col-5">
							<h3>See if a store is reliable and offers great service</h3>
							<p>
								When shopping on Mena Compare Trusted Store's site, check to see that the store offers reliable shipping, great customer service and a good returns process.
							</p>
						</div>
						
						<div class="clear"></div>
					</div>
					
					<div class="clear" style="height:20px;"></div>
                    <div class="shadow2">&nbsp;</div>
                    <div class="clear" style="height:5px;"></div>
					
					<div class="MrT_NorDV">
						<div class="MrT_dv3">
							<h3>Catalogs on Merchant Shopping</h3>
							<p>
								Mena Compare Catalogs allows shoppers to browse and shop all their favorite catalogs in one place and makes catalog shopping even more engaging by enabling your brand to annotate your catalogs with rich media content (products, videos, photo albums, etc.) with which shoppers can interact.
							</p>
							<a class="MrT_normal_btn" href="#">Get Started Now</a>
						</div>
						
						<div class="MrT_dv4 suez-col-5">
							<object type="application/x-shockwave-flash" data="http://player.longtailvideo.com/player5.9.swf" width="100%" height="100%" bgcolor="#000000" id="player1" name="player1" tabindex="0">
								<param name="allowfullscreen" value="true" />
								MrT is Typing...
								<param name="allowscriptaccess" value="always" />
								<param name="seamlesstabbing" value="true" />
								<param name="wmode" value="opaque" />
								<param name="flashvars" value="netstreambasepath=http%3A%2F%2Fwww.longtailvideo.com%2Faddons%2Fskins%2F18%2FDangDang%3Fq%3D&amp;image=%2Fjw%2Fupload%2Fbunny.jpg&amp;id=player1&amp;levels=%5B%5BJSON%5D%5D%5B%7B%22file%22%3A%22%2Fjw%2Fupload%2Fbunny.mp4%22%2C%22type%22%3A%22video%2Fmp4%22%2C%22width%22%3A0%2C%22bitrate%22%3A0%7D%5D&amp;stretching=fill&amp;skin=http%3A%2F%2Fwww.longtailvideo.com%2Ffiles%2Fskins%2Fdangdang%2F4%2Fdangdang.swf&amp;controlbar.position=over&amp;volume=100" />
							</object>
						</div>
						
						<div class="clear"></div>
					</div>
					
					
                    <div class="clear" style="height:35px;"></div> <?php */ ?>
                </div></div></div> 