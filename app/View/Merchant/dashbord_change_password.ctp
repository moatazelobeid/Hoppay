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
                           		<fieldset>
                                    <label class="loginaddtion">Current password: <span class="errorfield" style="display:none;">Enter Password</span></label>
                                    
                                    <input size="30" type="text" name="old_pass" required id="old_pass" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
                                
                                <fieldset>
                                    <label class="loginaddtion">New password:<span class="errorfield" style="display:none;">Enter Password</span></label>
                                    <input size="30" type="password" name="new_pass" required  id="new_pass" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
                                
                                <fieldset>
                                    <label class="loginaddtion">Re-enter password: <span class="errorfield" style="display:none;">Enter Password</span></label>
                                    <input size="30" type="password" name="re_new_pass" required id="re_pass" equalTo="#new_pass" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
							
                                <div class="mask" style="height:10px;"></div>
                                
                                <fieldset style="float:left;">
                                    <input type="reset" class="btn21" value="Reset" onclick="#" style="width: 100px;">
                                    <input type="submit" class="btn21" value="Save" onclick="#" style="width:100px;margin:0px 5px;">
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
        