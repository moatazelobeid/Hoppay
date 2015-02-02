
<?php echo $this->element('site-header'); ?>

        
        <!--  Main Body Panel Start  -->
        
        <div class="bodypanl">
        	<div style="width:100%; margin:0 auto;">
              <section class="clear">
                
                <div class="fl left-nav stickyFilter" id="filter-nav" style="top: 0px;">                  
                  <div class="search-box bdr mt10 pos-rel">
                    <strong class="d-block search-by fs12 pl10 cursor ">
                        <small class="common-sprite black-arrow-down "></small> Category
                    </strong>
                    <div class="search-by-cat mt10 mb10 pl14 ">
                      <div class="catTreeLvl0">
                        <a href="#" onClick="#">
                            <span class="common-sprite"></span> Mobile Phone Housing <span class="right_qunt">(150)</span><em></em>
                        </a>
                      </div>
                      <div class="catTreeLvl1">
                        <a href="#" onClick="#">
                            <span class="common-sprite"></span> Screen Protectors <span class="right_qunt">(830)</span><em></em>
                        </a>
                      </div>
                      <div class="catTreeLvl1">
                        <a href="#" onClick="#">
                            <span class="common-sprite"></span>Mobile Handsets <span class="right_qunt">(170) </span><em></em>
                        </a>
                      </div>
                      <div class="catTreeLvl1">
                        <a href="#" onClick="#">
                            <span class="common-sprite"></span> Mobile Batteries<span class="right_qunt"> (41)</span><em></em>
                        </a>
                      </div>
                    </div>
                    <div id="fct-category-data" data-segment="1" data-leave-selected="" style="display:none;"> </div>
                  </div>
                  
                  <div class="search-box bdr mt10 pos-rel">
                    <strong class="d-block search-by fs12 pl10 cursor "><small class="common-sprite black-arrow-down "></small> Price ($)</strong>
                    <div class="search-by-cat ml15 mt10 mb10 ">
                      <div class="search-btype mt5 qa-price">
                        <a href="#" onClick="#">
                            <input type="radio" name="price-range">
                            1000 - 3000 <span class="right_qunt">(22)</span>
                        </a>
                        <a href="#" onClick="#">
                            <input type="radio" name="price-range">
                           3001 - 4000 <span class="right_qunt">(43)</span>
                        </a>
                        <a href="#" onClick="#">
                            <input type="radio" name="price-range" checked="checked">
                           4001 - 6000 <span class="right_qunt">(409)</span>
                        </a>
                        <a href="#" onClick="#">
                            <input type="radio" name="price-range">
                            10000 - 30000 <span class="right_qunt">(222)</span>
                        </a>
                      </div>
                      
                      <div class="catalogPriceSlider enter-price mt5"> <strong class="pd-tb7 d-block fs11 c666">Enter a Price range in ($)</strong>
                        <form class="catalogPriceSliderFilterForm">
                          <div class="sliderInput">
                            <input id="qa-catalogPrice" class="catalogPriceFilterFrom catalogFilterText text p5 fs11" type="text" value="499" name="price_from" maxlength="6">
                            -
                            <input id="qa-catalogPriceTo" class="catalogPriceFilterTo catalogFilterText text p5 fs11" type="text" value="32000" name="price_to" maxlength="6">
                            <input id="qa-catalogPriceSubmit" class="catalogPriceFilterSubmit f-bold cursor c000 fs12" data-gaq-evt="leftfilter!#!price!#!499-32000" type="submit" value="GO">
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                  
                  <div class="search-box bdr mt10 pos-rel">
                    <strong class="d-block search-by fs12 pl10 cursor "><small class="common-sprite black-arrow-down "></small> Discounts </strong>
                    <div class="search-by-cat ml15 mt10 mb10 qa-discount ">
                      <div class="search-btype" id="qa-discoun0">
                        <a href="#" onClick="#">
                            <input type="checkbox" checked="checked">
                            Non-Discounted <span class="right_qunt">(12)</span>
                        </a>
                      </div>
                      
                      <div class="search-btype" id="qa-discoun1">
                        <a href="#" onClick="#">
                            <input type="checkbox">
                            Discounted <span class="right_qunt">(18)</span>
                        </a>
                     </div>
                    </div>
                  </div>
                  
                  
                  <div class="search-box bdr mt10 pos-rel"> <strong class="d-block search-by fs12 pl10 cursor "> <small class="common-sprite black-arrow-down "></small> Brand </strong>
                    <div class="search-by-cat ml15 mt10 mb10 ">
                      <input id="fct-brand-search" placeholder="Search brand..." type="text" class="search-brand common-sprite c999 ui-autocomplete-input placeholder" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                      
                      <div class="auto-scroll color-option search-btype mt5">
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Samsung  <span class="right_qunt">(245)</span>
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            LG  <span class="right_qunt">(190)</span>
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox" checked="checked">
                            Nokia  <span class="right_qunt">(49)</span>
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Micromax  <span class="right_qunt">(209)</span>
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            LAVA  <span class="right_qunt">(309)</span>
                         </a>
                       </div>
                    </div>
                  </div>
                  
                  
                  <div class="search-box bdr mt10 pos-rel"> <strong class="d-block search-by fs12 pl10 cursor "><small class="common-sprite black-arrow-down "></small> Seller </strong>
                    <div class="search-by-cat ml15 mt10 mb10 ">
                      <div class="auto-scroll color-option search-btype mt5">
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Naaptol.com
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Homeshop18.com
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Cbazaar US
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                             Jaboong.com
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            VanGoddy.com
                         </a>
                         <a href="#" onClick="#">
                            <input type="checkbox">
                            Videology.com
                         </a>
                         </div>
                    </div>
                  </div>
                </div>
                
                <!--  Right panel listing start  -->
                <div class="col_righttotal">
                	<div class="right-content fr">
						<div class="breadcrumbs_pan">
							<div class="breadcrumbs fs12 l-hght26" style="float:left;">
								<span class="normal"> You Are Here</span>
								<span class="crm">&nbsp;</span>
								<a class="fs12 c777 f-bold l-hght14" href="#"> Home <!-- <img src="images/home1.png" alt="hoppay" />--> </a>
								<span class="crm">&nbsp;</span>
								<a class="fs12 c777 f-bold l-hght14" href="#" title="Computers & Software">Mobile & Accessories</a> 
								<span class="crm">&nbsp;</span>
								<span class="crm_active">Mobiles</span>
								<!--Filter combined with breadcrumb start-->
								<section class="clear"> </section>
								<div class="clear"></div>
								<!--Filter combined with breadcrumb end-->
							  </div>
							  
							  <div class="fr" style="float: right;">
								<label class="fl pt5 fs12 f-bold c999">Sorted By :</label>
								<select class="select-box">
									<option selected="selected">Popularity</option>
									<option> List View</option>
									<option> Price: High to Low </option>
									<option> Price: Low to High</option>
									<option> Discount: High to Low</option>
								</select>
							  </div>
                          
								<div class="fr" style="float: right;">
								<label class="fl pt5 fs12 f-bold c999">View By:</label>
								<a href="search-result_list.html" class="listview" title="Listview">&nbsp;</a>
								<a href="javascript:void(0)" class="gridview" title="Gridview">&nbsp;</a>
							  </div>
						  
						</div>
                      
                      <div class="box box-bgcolor">
                        <section class="full-width sorted-by mt10 pb10">
                          
                          
                          
                          
                          <h1 class="c24 fs16 fl l-hght26" id="qa-new-arrivals">Mobile Phones: <span class="f-normal c999 ProductCounter">505 products found</span> </h1>
                        </section>
                        
                        <section class="full-width sorted-by-product mt10 p-list">
                          <ul id="productsCatalog list">
							 	  <li onclick="showdetailspan()">
									<span class="lazyImage loaded">
										<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
											<a href="#"><img class="itm-img" style="" src="images/mobil34.jpg" width="176" height="255" title=""></a>										</span>									</span>
									
									<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy S4 16GB LTE Black Frost </a></span>
									<img src="images/reviews.png" alt="hoppay" />
									
									<div class="item_value">
										<span>$1200</span>
										<b>$170.00</b>									</div>
	
									<div class="price_compare"><div class="fk_underline">6 Sellers</div>Compare by</div>
								</li>
								
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile2.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Sony Xperia Z C6603 Black Factory Unlocked</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$700</span>
													<b>$220.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">13 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/Samsung-Galaxy-Note-3.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy Note 10.1 2014 Edition</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$700</span>
													<b>$240.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">2 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile3.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy S4 16GB LTE Black Frost </a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$900</span>
													<b>$170.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">22 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()" style="margin-right:0;">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile6.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Nexus 7 from Google (7-Inch, 16 GB, Black)</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$1000</span>
													<b>$135.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">7 Sellers</div>Compare by</div>
							</li>
                               
  <div class="clear">
								  
								  <div class="showdetailspnel" style="display:none;">
									<div class="icontop" style="left:55px;"></div>
							  <div class="icon_close" onclick="showdetailspan()">&nbsp;</div>
									<div class="listclickpane">
										<div class="thumbnail-div">
											<a href="#">
												<img src="images/Samsung-Galaxy-Note-3.jpg" alt="hoppay" /></a>
											</a>
										</div>
										
										<div class="thumbdata-div">
										  <h1>
												<a href="#">
													Samsung Galaxy S4 16GB LTE Black Frost <font style="font-size:13px;">(Price is the same as two weeks ago )</font>
												</a>
										  </h1>
										  
										  <ul class="specification">
										  		<li>7 inch Display</li>
											<li>Qualcomm Snapdragon S4 Pro 1.5 GHz</li>
											<li>32 GB Flash Memory (actual formatted capacity will be less), 2 GB RAM Memory</li>
											<li>10-hour battery life</li>
											<li>Photos and video with dual HD cameras: 1.2MP front and 5MP rear</li>
										  <div class="clear"></div>
										  </ul>
											
											<h2><a href="#">More Info &raquo;</a></h2>
											
											<div class="showlistprice">
												<a class="pspo-offer-link kpbb" href="#">
													<div class="pspo-ol-price">$277.02</div>
														<div class="pspo-ol-details">
															<div class="pspo-ol-seller">Homeshop18.com</div>
														  <div>Free shipping. No tax</div>
												</div>
													 <div class="psclear"></div>
												</a>
											
												<div class="pspo-offer-flare">
											<span>
											  <span class="shoppingstarsjs__stars" style=" width:auto; float:left; display:inherit; background-image:url(images/shopping_sprites186_hr.png);background-position:-8px -30px;height:10px;width:65px;background-size:128px">
											<span class="shoppingstarsjs__stars" aria-label="4" role="img" style="display: block;margin: inherit;float: left;background-image:url(/images/shopping/shopping_sprites186_hr.png);height:13px;width:52px;background-size:128px;background-position:-17px -14px">
											  </span>
											</span>
											  <a class="pspo-sr-link" href="#">
												 38 seller reviews
											</a>
											  </span>
										  </div>
										  	</div>
										  
											
											<div class="small03">Compare prices from 4 stores</div>
											<div class="clear" style="height:5px;"></div>
											<div class="detailslist_data1">
												<a href="#" target="_blank">NoBetterDeal.com</a>
												<span style="padding-left:5px">: $95.99</span>
											</div>
											<div class="clear"></div>
											<div class="detailslist_data1">
												<a href="#" target="_blank">KS Trend</a> 
												<span style="padding-left:5px">: $129.99</span>
											</div>
											<div class="clear"></div>
											<div class="detailslist_data1">
												<a href="#" target="_blank">Rakuten.com Shopping - TigerDirect</a>
												<span style="padding-left:5px">: $129.99</span>
											</div>
											
										  
										</div>
									</div>
							</div>
								  
							</div>
							
                            
                          </ul>
						  
						  <ul id="productsCatalog list">
							  <li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/Samsung-Galaxy-Note-3.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy Note 10.1 2014 Edition</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$700</span>
													<b>$240.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">2 Sellers</div>Compare by</div>
										</li>
								
<li onclick="showdetailspan()">
											<span class="lazyImage loaded">
												<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
													<a href="#"><img class="itm-img" style="" src="images/mobile2.jpg" width="176" height="255" title=""></a>										</span>									</span>
											
											<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Sony Xperia Z C6603 Black Factory Unlocked</a></span>
											<img src="images/reviews.png" alt="hoppay" />
											
											<div class="item_value">
												<span>$700</span>
												<b>$220.00</b>									</div>
			
											<div class="price_compare"><div class="fk_underline">13 Sellers</div>Compare by</div>
							</li>
										
<li onclick="showdetailspan()">
											<span class="lazyImage loaded">
												<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
													<a href="#"><img class="itm-img" style="" src="images/Samsung-Galaxy-Note-3.jpg" width="176" height="255" title=""></a>										</span>									</span>
											
											<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy Note 10.1 2014 Edition</a></span>
											<img src="images/reviews.png" alt="hoppay" />
											
											<div class="item_value">
												<span>$700</span>
												<b>$240.00</b>									</div>
			
											<div class="price_compare"><div class="fk_underline">2 Sellers</div>Compare by</div>
							</li>
										
<li onclick="showdetailspan()">
											<span class="lazyImage loaded">
												<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
													<a href="#"><img class="itm-img" style="" src="images/mobile3.jpg" width="176" height="255" title=""></a>										</span>									</span>
											
											<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy S4 16GB LTE Black Frost </a></span>
											<img src="images/reviews.png" alt="hoppay" />
											
											<div class="item_value">
												<span>$900</span>
												<b>$170.00</b>									</div>
			
											<div class="price_compare"><div class="fk_underline">22 Sellers</div>Compare by</div>
							</li>
										
<li onclick="showdetailspan()">
											<span class="lazyImage loaded">
												<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
													<a href="#"><img class="itm-img" style="" src="images/mobile6.jpg" width="176" height="255" title=""></a>										</span>									</span>
											
											<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Nexus 7 from Google (7-Inch, 16 GB, Black)</a></span>
											<img src="images/reviews.png" alt="hoppay" />
											
											<div class="item_value">
												<span>$1000</span>
												<b>$135.00</b>									</div>
			
											<div class="price_compare"><div class="fk_underline">7 Sellers</div>Compare by</div>
							</li>
                               
						    <div class="clear"></div>
                          </ul>
						  
						  <ul id="productsCatalog list">
								  <li onclick="showdetailspan()">
									<span class="lazyImage loaded">
										<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
											<a href="#"><img class="itm-img" style="" src="images/mobil34.jpg" width="176" height="255" title=""></a>										</span>									</span>
									
									<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy S4 16GB LTE Black Frost </a></span>
									<img src="images/reviews.png" alt="hoppay" />
									
									<div class="item_value">
										<span>$1200</span>
										<b>$170.00</b>									</div>
	
									<div class="price_compare"><div class="fk_underline">6 Sellers</div>Compare by</div>
								</li>
								
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile2.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Sony Xperia Z C6603 Black Factory Unlocked</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$700</span>
													<b>$220.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">13 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/Samsung-Galaxy-Note-3.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy Note 10.1 2014 Edition</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$700</span>
													<b>$240.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">2 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile3.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Samsung Galaxy S4 16GB LTE Black Frost </a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$900</span>
													<b>$170.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">22 Sellers</div>Compare by</div>
							</li>
											
<li onclick="showdetailspan()">
												<span class="lazyImage loaded">
													<span alt="hoppay" class="itm-imageWrapper overfl-hid itm-imageWrapper-UR256WA22QYFINDFAS">
														<a href="#"><img class="itm-img" style="" src="images/mobile6.jpg" width="176" height="255" title=""></a>										</span>									</span>
												
												<span class="qa-brandName title mt10 c999" id="qa-brandName0"><a href="#">Nexus 7 from Google (7-Inch, 16 GB, Black)</a></span>
												<img src="images/reviews.png" alt="hoppay" />
												
												<div class="item_value">
													<span>$1000</span>
													<b>$135.00</b>									</div>
				
												<div class="price_compare"><div class="fk_underline">7 Sellers</div>Compare by</div>
							</li>
                            
							<div class="clear"></div>
                          </ul>
						  
                        </section>
                      </div>
                  
                  <div class="clear" style="height:1px;"></div>
                  <a href="#" class="loadingmore">More Items</a>       
                  
                </div>
                </div>
                <!--  Right panel listing end  -->
              <div class="clear" style="height:5px;">&nbsp;</div>  
                
              </section>
            </div>
            <div class="clear" style="height:5px;">&nbsp;</div>
        </div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:0px;">&nbsp;</div>
        
        <!--  Footer Panel Start  -->
        
        <!--  Footer Panel Start  -->
        <div>
        	<div id="ft">
              <div class="container clearfix">
                <div class="col1">
                  <form id="footer_signup_form" action="#" class="clearfix" style="display: block;">
                    <p>
                      Be in touch with the MenaCompare Newsletter
                    </p>
                    <p class="signup_form_input_fields">
                      <input type="text" name="email_news" placeholder="Enter your email" class="signup_form_email_input">
                      <input type="submit" class="signup_form_submit" value="Sign Up">
                    </p>
                    <p class="signup_form_status_message">
                    </p>
                  </form>
                  
                </div>
                
                <div class="col2">
                  <p>
                    <b>
                    MenaCompare
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                  About Us
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Jobs
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Advertise
                  </a>
                  <a target="_parent" href="#">
                  Sitemap
                  </a>
                  <a target="_parent" href="#">
                  Mobile Site
                  </a>
                </div>
                
                <div class="col3">
                  <p>
                    <b>
                    Categories
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                   Lorem data 1 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Catg data 1 Sam1 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Lorem data ample3 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Catg Catg dat S4 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  More...
                  </a>
                </div>
                
                <div class="col3">
                  <p>
                    <b>
                    Support
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                  Market Reporter
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Mobile Apps
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Help
                  </a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Policies
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">Return Policy</a>
                 <a target="_parent" href="#" rel="nofollow">Refund Policy</a>
                 <a target="_parent" href="#" rel="nofollow">Shipping Policy</a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Know Us Better
                    </b>
                  </p>
                 	<a target="_parent" href="#" rel="nofollow">Why MenaCompare</a>
                    <a target="_parent" href="#" rel="nofollow">Life At HomeShop18</a>
                    <a target="_parent" href="#" rel="nofollow">Careers</a>
                    <a target="_parent" href="#" rel="nofollow">Connect</a>
                    <a target="_parent" href="#" rel="nofollow">Partner With Us</a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Follow Us:
                    </b>
                  </p>
                  	<div class="clear" style="height:5px;"></div>
                 	<a target="_blank" href="#" class="face" title="Facebook">&nbsp;</a>
                    <a target="_blank" href="#" class="twit" title="Twitter">&nbsp;</a>
                    <a target="_blank" href="#" class="tube" title="Youtube">&nbsp;</a>
                    <a target="_blank" href="#" class="gplus" title="Google Plus">&nbsp;</a>
                </div>
                
                
              </div>
            </div>

            <div class="grid" style="padding: 14px 0px 17px 0px;margin-bottom: 14px;margin: 0 auto;width: 1002px;height: 10px;">
                <div class="fot1">
                	Copyright © Mena Compare 2014. All rights reserved.
                </div>
            
                <div class="fot2">
                    <a href="merchant.html" class="login">Merchant Login</a> &nbsp; | &nbsp;
                    <a href="#">Terms & Conditions</a> &nbsp; | &nbsp;
                    <a href="#">Privacy Policy</a>
                </div>
            
            </div>
        
        </div>
        <!--  Footer Panel End  -->
        
        	
        
        
        
</div>

</body>
</html>
