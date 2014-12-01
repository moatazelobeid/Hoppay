              <?php extract($merchant)?>
				<div  class="arabic_wr"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg">
						<h1 class="font25"><?=$text_data['title']?></h1>
						<div class="borderdash"></div>
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"> Home </a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
						
						<div class="prof_data1">
							<div class="font12B">
								
							    <div class="dlr_text">Name</div>  
						    
								<span style="padding-left:5px;">:&nbsp; <?=htmlspecialchars_decode($Merchant['first_name']." ".$Merchant['last_name'])?></span>
							</div>
							
							<div class="font12B PaddT5">
								<div class="dlr_text">Email Id</div> 
								<span style="padding-left:5px;">:&nbsp; <?=$User['email_id']?></span>
							</div>
							
							<div class="font12B PaddT5">
								<div class="dlr_text">Website URL</div>
								<span style="padding-left:5px;">:&nbsp; <?=$Merchant['url']?></span>
							</div>
							
							<div class="font12B PaddT5">
								<div class="dlr_text">Contact</div> 
								<span style="padding-left:5px;">:&nbsp; <?=$Merchant['phone']?></span>
							</div>
							
							<div class="font12B PaddT5">
								<div class="dlr_text">Password</div> 
								<span style="padding-left:5px;">:&nbsp; ******** <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'change_password'))?>">Change Password</a></span>
							</div>
							
							<div class="mask" style="height:30px;"></div>
							
							<input type="button" class="btn21" value="Edit Account" onclick="location.href='<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'edit_account'))?>'">
							
						</div>
						
						
						<div class="mask" style="height:10px;"></div>
						
						
						<div class="mask" style="height:10px;"></div>
					</div>
					
					<?=$this->element('merchant/dashbord_right_sidebar')?>
				</div>
				
				
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
