              <?php extract($merchant)?>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'dashbord'))?>"> Home </a> 
							<span class="breeadset">›</span>
							
							<span class="crm_active">My Account</span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
						
						<div class="prof_data1">
							<div data-role="fieldcontain" class="form-btns" style="margin-bottom: 20px;">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											Website Information
											</label>
											</fieldset>
										</div>
							<div class="font12B PaddT5">
								<strong>Website Name : </strong>
								<span style="padding-left:5px;"><?=$Merchant['website_name']?></span>
							</div>			
							<div class="font12B PaddT5">
								<strong>Website URL : </strong>
								<span style="padding-left:5px;"><?=$Merchant['url']?></span>
							</div>
							<div data-role="fieldcontain" class="form-btns"  style="margin-top: 20px;margin-bottom: 20px;">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											Personal Information
											</label>
											</fieldset>
										</div>
							<div class="font12B">
								<strong>
							    Name : 
						    </strong>
								<span style="padding-left:3px;"><?=htmlspecialchars_decode($Merchant['first_name']." ".$Merchant['last_name'])?></span>
							</div>
							<div class="font12B PaddT5">
								<strong>Contact : </strong>
								<span style="padding-left:5px;"><?=$Merchant['phone']?></span>
							</div>
							<div class="font12B PaddT5">
								<strong>Address : </strong>
								<span style="padding-left:5px;"><?=$Merchant['adress']?></span>
							</div>
							<div class="font12B PaddT5">
								<strong>City : </strong>
								<span style="padding-left:5px;"><?=$Merchant['city']?></span>
							</div>							
							<div class="font12B PaddT5">
								<strong>State: </strong>
								<span style="padding-left:5px;"><?=$Merchant['state']?></span>
							</div>
							</div>
								<div class="font12B PaddT5">
								<strong>Country: </strong>
								<span style="padding-left:5px;"><?=$Merchant['country']?></span>
							</div>

							<div data-role="fieldcontain" class="form-btns" style="margin-top: 20px;margin-bottom: 20px;">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											Account Information
											</label>
											</fieldset>
										</div>
							<div class="font12B PaddT5">
								<strong>Email Id : </strong>
								<span style="padding-left:5px;"><?=$User['email_id']?></span>
							</div>
							
							
							
							<div class="font12B PaddT5">
								<strong>Username : </strong>
								<span style="padding-left:5px;"><?=$User['username']?></span>
							</div>
							
							<div class="font12B PaddT5">
								<strong>Password : </strong>
								<span style="padding-left:5px;">******** <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'change_password'))?>">Change password</a></span>
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
				
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
