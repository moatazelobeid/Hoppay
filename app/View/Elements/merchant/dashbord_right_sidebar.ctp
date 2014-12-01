<?php //print_r($merchant); ?>
<div class="prof_data2">
						<div class="detailspricepan">
							<h1 class="intitle">
							Account Statistic
							</h1>
							<!--<h2>Lowest Price</h2>
							<h3>
							$2,287
							</h3>--> 
							<span class="linkonline2">
                            	<a href="<?=$this->Template->CreateParamLink1(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'my-products'))?>">
                                    <i class="icon-th" style="padding-right:4px;"></i>
                                    Products - <span class="rightspan1"><?=empty($products_count)?0:$products_count?></span>
                                </a>
                            </span>
                            
                            <span class="linkonline2">
                            	<a href="<?=$this->Template->CreateParamLink1(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'offers'))?>">
                                    <i class="icon-star" style="padding-right:4px;"></i>
                                    Offers - <span class="rightspan1"><?=empty($offer_count)?0:$offer_count?></span>
                                </a>
                            </span>
                            <!--<span class="linkonline2" style="border:none; margin:0; padding-bottom:0; float:right; padding-right:10px;">Inquiries</span>-->
						</div>
						
						<div class="clear" style="height:15px;"></div>
						
						<div class="detailspricepan">
							<h1 class="intitle">
							My Activities
							</h1>
							<span class="linkonline2">Last login - <span class="rightspan1" style="font-size: 78%;word-break: break-word;"><?php echo CakeTime::timeAgoInWords(
      $merchant['User']['last_login'],
    array('format' => 'F jS, Y', 'end' => '+1 year')
);?></span></span>
                            <span class="linkonline2" style="border:none;padding-bottom: 0;w">Last data Update - <span class="rightspan1" >1 hour ago</span></span>
						</div>						
					</div>