<script>
var tipNames = ['Address','City', 'State/Province', 'Zip Code', 'Country'];
  var tips = [
    '<p>Select your address</p>',
    '<p>Enter your city name</p>',
    '<p>Enter your State/Province name</p>',
    '<p>Enter your Zip code name</p>',
    '<p>Choose your country name</p>'
    
  ];
  </script>
   <?php
     error_reporting(0);
	if(isset($step_2) )
	{
		extract($step_2);
	}
  
   ?>
   <div class="clear" style="height:15px;">&nbsp;</div>
                <div class="newheadertwo">
                    <h1>Setup your <span class="bluetext">FREE</span> online Merchant account with Hoppay</h1>
                    <!--<p style="text-align:center">
                        Please complete below steps to get registered as a Merchant to start listing  and explore your business. <br />
						Do you have an account? Please <a href="<?php /*?><?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'login'))?><?php */?>">Sign in</a> 
                    </p>-->
                    
                    <div class="clear" style="height:10px;">&nbsp;</div>
                    <div class="shadow2">&nbsp;</div>
                    <div class="clear" style="height:15px;">&nbsp;</div>
                    <div id="header" class="header_main">
                            <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',1))?>" class="active">
                                <div id="header1" class="left ">
								<div class="clear"></div>
                                <div id="create1" class="left number_header margin-notop greencolor"><span class="image_step1"></span></div>
                                <div id="createPro" class="left  widthresp">
                                  <span class="heading1 greencolor">Create Profile</span>
                                  <br>
                                  <span class="subheading">PERSONAL INFORMATION</span>
                                </div>
                                <div class="clear"></div>
                                <div id="hr1" class="hrpadding">
                                  <hr class="horizontalrule widthhr_1">
                                </div>
                            </div></a>
                            
                            <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',2))?>"><div id="header2" class="left  left2per ">
								
								<div id="hr2" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2 green">
                                </div>
                                <div class="clear"></div>
								
                                <div id="Access2" class="left number_header margin-notop greencolor">
                                  <span class="image_step2"></span>
                                </div>
                                <div id="accessacnt" class="left  widthresp">
                                  <span class="heading1 greencolor">Address Information</span>
                                  <br>
                                  <span class="subheading">Address INFORMATION</span>
                                </div>
								
                                
                            </div></a>
                            
                            <a
                             <?php if($active3==1){ ?>
                             href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',3))?>" <?php } ?>><div id="header3" class="left left2per  ">
                                <div id="manage3" class="left number_header margin-notop"><span class="image_step3_gray"></span></div>
                                
                                <div id="managefin" class="left  widthresp">
                                  <span class="heading1 ">Login Information</span>
                                  <br>
                                  <span class="subheading">SETUP LOGIN</span>
                                </div>
                                
                                <div class="clear"></div>
                                <div id="hr3" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2">
                                </div>
                            </div></a>
                            
                            <a 
                            <?php if($active4==1){ ?>
                            href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',4))?>"
                                             <?php } ?>
                                             ><div id="header2" class="left  left2per ">
                                <div id="Access2" class="left number_header margin-notop">
                                  <span class="image_step4_gray"></span>
                                </div>
                                <div id="accessacnt" class="left  widthresp">
                                  <span class="heading1">Confirmation</span>
                                  <br>
                                  <span class="subheading">REGISTRATION COMPLETED</span>
                                </div>
                                <div class="clear"></div>
                                <div id="hr2" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2">
                                </div>
                            </div></a>
                            <div class="clear"></div>
                        </div>
                
                	
                 </div>  
                 
                <div class="clear" style="height:1px;">&nbsp;</div> 
                    
                     <div style="border: 1px solid #DBDADA;padding: 25px;border-radius: 6px;">
                     <div class="signupleftpannew2">
                    <div class="shadowpanel21">
                       <!--  <h1>Your privacy is important to us</h1> -->
                    
                        <!--<h3>
                            Menacompare does not rent or sell your personal information to third parties without your consent. To learn more, read our privacy policy.
                        </h3>-->
                        <!-- <h3>
                            Provide correct contact details as your trading partners may want to get in touch with you. Incorrect or incomplete contact information can lead to account suspension.
                        </h3>
                        
                        
                        <ul class="signUpList">
                            <li><div class="authHeart"></div>Save your favorite items</li>
                            <li><div class="authStar"></div>Receive product recommendations</li>
                            <li><div class="authTag"></div>Get access to exclusive coupons</li>
                            <li><div class="authRibbon"></div>Gain entries to contests</li>
                        </ul>
                        
                        <div class="clear" style="height:10px;"></div> 
                        
                        <h3>
                        	By providing your e-mail address, you agree to receive information about products, services and offers from Hoppay. 

                        </h3> -->
                        <?php 
                         $texts=$this->Template->languageChanger($page_data['Page_lang']);
                        ?>
                       <?=htmlspecialchars_decode($texts['pg_descriptions'])?>
                    </div>
                    
                </div>
                <div class="signupleftpannew1">
                    <div class="rowpanel3" style="position:inherit;">
                        <div class="suez-cols" style="margin-top: -10px;">
                            <div class="rowpanel3" style="margin-top:5px;">
                            
                        <div class="suez-cols" style="margin: 0 auto;">
                            <div class="col3x offers" style="width:100%; margin-top:0; padding-top:0;">
                    
                            <div id="step1" class="loginform" style="width: 95%;">
                              <div class="div60x newlable" style="width:100%;">
                                  <div id="anpHint" data-color="blue">
                                  <div class="anpHintArrow"></div>
                                  <div id="anpHintHeader"></div>
                                  <div id="anpHintContent"></div>
                                </div>
                                              <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
		<form name="loginform" method="post" action="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',3))?>" id="loginform" class="loginregisterform validate" style="display: block;">
										<div class="div60x newlable" style="width:100%;">
											<div class="form-btns" data-role="fieldcontain">
											<fieldset>
											<label class="inline" for="returnuser">
											Contact information
											</label>
											</fieldset>
										</div>
									
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Address</label>
												<input size="30" value="<?=$adress?>" onFocus="geolocate()"  type="text" required name="adress" id="adress" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
												</fieldset>
											</div>
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">City</label>
												<input  value="<?=$city?>" size="30" type="text" required name="city" id="locality" class="form-text hasPlaceholder anpHintable" data-hint-num="1">
												</fieldset>
											</div>
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">State/Province</label>
												<input value="<?=$state?>" size="30" type="text" required name="state" id="administrative_area_level_1" class="form-text hasPlaceholder anpHintable" data-hint-num="2">
												</fieldset>
											</div>
											
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Zip code</label>
												<input value="<?=$zip_code?>" size="30" type="desits" required name="zip_code" id="postal_code" class="form-text hasPlaceholder anpHintable" data-hint-num="3">
												</fieldset>
											</div>
											<script type="text/javascript">
												$(function(){
													$('.country').val('<?=$country?>');
												})
											</script>
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Country</label>
												<select  class="selectbox country anpHintable" required id="country" name="country" data-hint-num="4">
												    <option value="">Select your country</option>
												    <option value="Algeria">Algeria</option>    
                            <option value="Bahrain">Bahrain</option>
                            <option value="Eygpt">Eygpt</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kuwait">Kuwait</option> 
                            <option value="Lebanon">Lebanon</option>
                            <option value="Libya">Libya</option>                             
                            <option value="Morocco">Morocco</option>
                            <option value="Oman"> Oman</option>
                            <option value="Qatar">Qatar</option> 
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Syria"> Syria</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="UAE"> UAE</option>
												</select>
												</fieldset>
											</div>
											
											<div class="form-field">
												<!-- <div class="proceednext">Go to next</div> -->
												<input type="submit" class="next21" value="Proceed Next" >
											</div>
										</div>
										
									</form>
                                </div>
                            </div>
                        </div>
                        
                   </div>
                        </div>
                        
                        
                   </div>
                   
                   
                    
                </div>
            	</div>
                 <div class="clear" style="height:1px;">&nbsp;</div>
                     </div>
                    
                  
                
                
                
	<?php /*?><div class="signupleftpannew1">
   
		 <div class="rowpanel3">
							<h1><span class="bluetext">FREE</span> Merchant Sign Up</h1>
							<p style="text-align:center">
								Please complete below steps to get registered as a Merchant to start listing  and explore your business. <br />
								Do you have an account? Please <a href="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'login'))?>">Sign In</a> 
							</p>
							
							<div class="shadow2">&nbsp;</div>
							
							<div class="suez-cols" style="margin-top: -10px;">
								<div class="rowpanel3" style="margin-top:5px;">
							
							<div class="suez-cols" style="margin: 0 auto;width:438px">
								<div class="col3x offers" style="width:100%; margin-top:0; padding-top:0;">
						
								<ul class="breadcrumb">
									<li><a href="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',1))?>" >Step 1</a></li>
									<li><a href="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',2))?>" class="active">Step 2</a></li>
									<li><a href="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',3))?>">Step 3</a></li>
									<li><a href="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',4))?>">Confirmation</a></li>
									<li><a href="#"></a></li>
								</ul>
								<span class="activearrow" style="left: 80px;top: 25px;"></span>
								
							
								<div id="step1" class="loginform" style="width: 95%;">
									 <div id="anpHint" data-color="blue" style="">
									  <div class="anpHintArrow"></div>
									  <div id="anpHintHeader"></div>
									  <div id="anpHintContent"></div>
									</div>
									<form name="loginform" method="post" action="<?=$this->Template->CreateParamLink(array(                                        
													 'controller' => 'merchant',
													 'action' => 'signup',3))?>" id="loginform" class="loginregisterform validate" style="display: block;">
										<div class="div60x newlable" style="width:100%;">
											<div class="form-btns" data-role="fieldcontain">
											<fieldset>
											<label class="inline" for="returnuser">
											<strong>Contact information</strong>
											</label>
											</fieldset>
										</div>
									
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Address</label>
												<input size="30" value="<?=$adress?>" onFocus="geolocate()"  type="text" required name="adress" id="adress" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
												</fieldset>
											</div>
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">City</label>
												<input  value="<?=$city?>" size="30" type="text" required name="city" id="locality" class="form-text hasPlaceholder anpHintable" data-hint-num="1">
												</fieldset>
											</div>
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">State/Province</label>
												<input value="<?=$state?>" size="30" type="text" required name="state" id="administrative_area_level_1" class="form-text hasPlaceholder anpHintable" data-hint-num="2">
												</fieldset>
											</div>
											
											
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Zip code</label>
												<input value="<?=$zip_code?>" size="30" type="desits" required name="zip_code" id="postal_code" class="form-text hasPlaceholder anpHintable" data-hint-num="3">
												</fieldset>
											</div>
											<script type="text/javascript">
												$(function(){
													$('.country').val('<?=$country?>');
												})
											</script>
											<div class="form-field">
												<fieldset class="user_name">
												<label class="loginaddtion">Country</label>
												<select  class="selectbox country anpHintable" required id="country" name="country" data-hint-num="4">
												   <option value="">Select your country</option>
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
												</fieldset>
											</div>
											
											<div class="form-field">
												<div class="proceednext">Go to next</div>
												<input type="submit" class="next21" value="Proceed Next" >
											</div>
										</div>
										
									</form>
								</div>
							</div>
							</div>
							
					   </div>
							</div>
							
							
					   </div>
	
	</div>
               
      <div class="clear" style="height:1px;">&nbsp;</div>
                
            </div><?php */ ?>
        </div>
        
        </div>