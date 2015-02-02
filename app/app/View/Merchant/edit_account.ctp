 <?php extract($merchant)?>
<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
<div class="prof_data_bg">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"> Home </a> 
							<span class="breeadset">›</span>
                           <a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'my_account'))?>"> My Account </a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
                        
                       <!-- <div class="errorpanel">Error message goes here...</div>
                    
                      <div class="successpanel">Success message goes here...</div>-->
						<?=$this->Session->flash('bad')?> 
                        <?=$this->Session->flash('msg')?>
						<div class="prof_data1">
							
                           <form class="dashboardpanform validate" action="" method="POST">

                             	<?php
                             		$merchantErray=$Merchant;
                             		unset($merchantErray['merchant_id']);
                             			unset($merchantErray['image_url']);
                             	 foreach($merchantErray as $key=>$val) { 
                           			$formtitle=ucfirst(str_replace('_', ' ', $key));
                           			$type="text";
	                           			if($key=="id")
	                           			{
	                           				$type="hidden";
	                           			}elseif($key=="phone")
	                           			{
	                           				$type="digits";
	                           			}
	                           			else 		
	                           			{
	                           				$type="text";
	                           			}
                           			$geo="";
	                           			if($key=="adress"){
	                           				$geo='onFocus="geolocate()" ';
	                           			}
	                           			$id="";
	                           			if($key=="city")
	                           			{
	                           				$id="locality";
	                           			}
	                           			if($key=="state")
	                           			{
	                           				$id="administrative_area_level_1";
	                           			}
	                           			if($key=="zip_code")
	                           			{
	                           				$id="postal_code";
	                           			}
	                           		 if($key=="url")
	                           		 { ?>
	                           		 	 <div data-role="fieldcontain" class="form-btns">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											Website Information
											</label>
											</fieldset>
										</div>
	                           		<?php }else if($key=="first_name"){ ?>
	                                    <div data-role="fieldcontain" class="form-btns">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											 Personal Information
											</label>
											</fieldset>
										</div>
	                                <?php } ?>
                           		<fieldset>
                                    <label class="loginaddtion"><?=($key=='id')?'':$formtitle?><span class="errorfield" style="display:none;">Enter Password</span></label>
                                    <?php if($key!="country"){ ?>

                                    <input size="30" type="<?=$type?>"  name="<?=$key?>" <?=$geo?> required id="<?=($id!="")?$id:$key?>" value="<?=$val?>" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                     <?php }else{ ?>
                                     
                                      <script>
                                    $(function(){
                                    	$('#country').val('<?=$val?>');
                                    })
                                    </script>
                                     	  <select style="width:374px" class="selectbox anpHintable" required id="country" name="country" data-hint-num="4">
										   <option value="">Select your Country</option>
                                           <option value="Saudi Arabia">Saudi Arabia</option>
                                           <option value="Qatar">Qatar</option>
                                           <option value="UAE"> UAE</option>
                                           <option value="Kuwait">Kuwait</option>
                                           <option value="Bahrain">Bahrain</option>
                                           <option value="Oman"> Oman</option>
                                           <option value="Yemen">Yemen</option>
                                           <option value="Jordan">Jordan</option>
                                           <option value="Lebanon">Lebanon</option>
                                           <option value="Syria"> Syria</option>
	                                        <option value="Iraq">Iraq</option>
	                                        <option value="Eygpt">Eygpt</option>
	                                        <option value="Algeria">Algeria</option>
	                                        <option value="Libya">Libya</option>
	                                        <option value="Tunisia">Tunisia</option>
	                                        <option value="Morocco">Morocco</option>
										</select>
                                  <?php   } ?>
                                </fieldset>                                
                             <?php } ?>
                                   <div data-role="fieldcontain" class="form-btns">
											<fieldset>
											<label for="returnuser" class="inline newlable1">
											Account Information
											</label>
											</fieldset>
										</div>
								<?php
									$accountInfo=$User;
									unset($accountInfo['id']);
									unset($accountInfo['key']);
									unset($accountInfo['created_date']);
									unset($accountInfo['modified_date']);
									unset($accountInfo['is_agreed']);
									unset($accountInfo['status']);
									unset($accountInfo['login_date']);
									unset($accountInfo['last_login']);
								 foreach ($accountInfo as $key => $val) { 

									$formtitle=ucfirst(str_replace('_', ' ', $key));
									$type="text";
									 if($key=="password")
	                           			{
	                           				$type="password";
	                           			}
	                           			else 		
	                           			{
	                           				$type="text";
	                           			}
								 	?>
									<fieldset>
                                    <label class="loginaddtion"><?=($key=='id')?'':$formtitle?><span class="errorfield" style="display:none;">Enter Password</span></label>
								  <input size="30" <?=($key!='email_id')?'disabled':''?> type="<?=$type?>" <?=($key=='url')?'disabled':''?> name="<?=$key?>" <?=$geo?> required id="<?=($id!="")?$id:$key?>" value="<?=$val?>" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
								</fieldset>
								<?php } ?>
                                <div class="mask" style="height:10px;"></div>
                                
                                <fieldset style="float:left;">
                                   <!-- <input type="submit" class="btn21" value="Reset" onclick="#" style="width: 100px;float: left;margin-right: 15px;">-->
                                    <input type="submit" class="btn21" value="Save" onclick="#" style="width:100px;">
                                </fieldset>
                           </form>
							
							
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
        