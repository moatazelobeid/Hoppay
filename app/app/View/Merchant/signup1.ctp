  <script>
var tipNames = ['ENTER YOUR URL','ENTER YOUR WEBSITE NAME', 'FIRST NAME', 'LAST NAME', 'EMAIL ID', 'VERIFY EMAIL ID', 'PHONE'];
  var tips = [
    '<p>Enter your website url.</p>',
    '<p>Enter your website name</p>',
    '<p>Enter your first name</p>',
    '<p>Enter your last name</p>',
    '<p>Enter valid email id</p>',
    '<p>Re-enter valid email id</p>',
    '<p>Enter valid phone number</p>'
  ];
  
  // custom method for url validation with or without http://
$.validator.addMethod("cus_url", function(value, element) { 
  if(value.substr(0,7) != 'http://'){
    value = 'http://' + value;
  }
  if(value.substr(value.length-1, 1) != '/'){
    value = value + '/';
  }
  return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value); 
}, "Not valid url.");

function add_http(cthis){
  var url=$(cthis).val();
     if((url.substr(0,7) == 'http://') ){
        //url = 'http://' + url;
     }
     else if((url.substr(0,8) == 'https://') )
     {
        //url = 'https://' + url;
     }
     else
     {
       url = 'http://' + url;
     }

   if(url.substr(url.length-1, 1) != '/'){
    url = url + '/';
   }
   
   $(cthis).val(url);
}
  </script>
  <?php
  error_reporting(0);
	if(isset($step_1) )
	{
		extract($step_1);
	}

   ?>
   
	
   <div class="clear" style="height:15px;">&nbsp;</div>
                <div class="newheadertwo">
                    <h1>Setup your <span class="bluetext">FREE</span> online Merchant account with Hoppay</h1>
                    <!--<p style="text-align:center">
                        Please complete below steps to get registered as a Merchant to start listing  and explore your business. <br />
						Do you have an account? Please <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'login'))?>">Sign in</a> 
                    </p>-->
                    
                    <div class="clear" style="height:10px;">&nbsp;</div>
                    <div class="shadow2">&nbsp;</div>
                    <div class="clear" style="height:15px;">&nbsp;</div>
                    <div id="header" class="header_main">
                            <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',1))?>" class="active">
                                <div id="header1" class="left ">
								<div id="hr1" class="hrpadding">
                                  <hr class="horizontalrule widthhr_1 green">
                                </div>
								<div class="clear"></div>
                                <div id="create1" class="left number_header margin-notop greencolor"><span class="image_step1"></span></div>
                                <div id="createPro" class="left widthresp">
                                  <span class="heading1 greencolor">Create Profile</span>
                                  <br>
                                  <span class="subheading">PERSONAL INFORMATION</span>
                                </div>
                                <div class="clear"></div>
                            </div></a>
                            
                            <a 
                            <?php if($active2==1){ ?>
                            href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',2))?>" <?php } ?>><div id="header2" class="left  left2per ">
                                <div id="Access2" class="left number_header margin-notop">
                                  <span class="image_step2_gray"></span>
                                </div>
                                <div id="accessacnt" class="left  widthresp">
                                  <span class="heading1">Address Information</span>
                                  <br>
                                  <span class="subheading">Address INFORMATION</span>
                                </div>
                                <div class="clear"></div>
                                <div id="hr2" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2">
                                </div>
                            </div></a>
                            
                            <a
                             <?php if($active3==1){ ?>
                             href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',3))?>" <?php } ?>><div id="header3" class="left left2per  ">
                                <div id="manage3" class="left number_header margin-notop"><span class="image_step3_gray"></span></div>
                                
                                <div id="managefin" class="left  widthresp">
                                  <span class="heading1">Login Information</span>
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
                                             'action' => 'signup',4))?>" <?php } ?>><div id="header2" class="left  left2per ">
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
                    <div class="shadowpanel21_n">
                        <!-- <h1>Your privacy is important to us</h1>
                    
                        <h3>
                            Hoppay does not rent or sell your personal information to third parties without your consent. To learn more, read our privacy policy.
                        </h3>
                        <h3>
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
                        <?php //print_r($page_data); ?>
                        <?php 
                          $texts=$this->Template->languageChanger($page_data['Page_lang']);
                        ?>
                       <?=htmlspecialchars_decode($texts['pg_descriptions'])?>
                       <!-- <img src="<?=$this->webroot?>img/email-envelope.png" />-->
                        
                    </div>
                    
                </div>
                
                
                <div class="signupleftpannew1">
                    <div class="rowpanel3" style="position:inherit;">
                        <div class="suez-cols" style="margin-top: -10px;">
                            <div class="rowpanel3" style="margin-top:5px;">
                            
                        <div class="suez-cols" style="margin: 0 auto;">
                            <div class="col3x offers" style="width:100%; margin-top:0; padding-top:0;">
                    
                            <div id="step1" class="loginform" style="width: 90%;">
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
                                             'action' => 'signup',2))?>" id="loginform" class="loginregisterform validate" style="display: block;">
								
									<div class="form-btns" data-role="fieldcontain">
										<fieldset>
										<label class="inline" for="returnuser">
										Website information
										</label>
										</fieldset>
									</div>
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Enter your website URL: <!--<small>(Use https://)</small>--></label>
		<input size="30" type="cus_url" value="<?=$url?>" required  class="form-text hasPlaceholder anpHintable " onblur="add_http(this)" data-hint-num="0" name="url" placeholder="http://">
										</fieldset>
									</div>
                  <div class="form-field">
                    <fieldset class="user_name">
                    <label class="loginaddtion">Enter your website name:</label>
                    <input size="30" type="text" required  value="<?=$website_name?>"  class="form-text  hasPlaceholder anpHintable" name="website_name" data-hint-num="1">
                    </fieldset>
                  </div>
									<div class="div60x" style="width:100%;">
									<div class="form-btns" data-role="fieldcontain">
										<fieldset>
										<label class="inline" for="returnuser">
										Provide your personal information
										</label>
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">First name </label>
										<input size="30"  value="<?=$first_name?>" type="text" required id="user_email" class="anpHintable form-text hasPlaceholder"  name="first_name" data-hint-num="2">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Last name</label>
										<input size="30" type="text"   value="<?=$last_name?>" id="user_email" class="anpHintable form-text hasPlaceholder" name="last_name" data-hint-num="3">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Email id</label>
										<input size="30" type="email"  value="<?=$email_id?>" required name="email_id"  id="user_email_id" class=" anpHintable form-text hasPlaceholder" data-hint-num="4">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Verify email id</label>
										<input size="30" type="email"  value="<?=$varify_email_id?>" name="varify_email_id" id="user_email_varify" equalTo="#user_email_id"class="form-text hasPlaceholder anpHintable" required  data-hint-num="5">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Phone</label>
							<input size="30" type="desits" name="phone"   value="<?=$phone?>" id="user_phone" class="form-text hasPlaceholder anpHintable"  required data-hint-num="6">
										</fieldset>
									</div>
									
									<div class="form-field">
                                    	<!-- <div class="proceednext">Go to next</div> -->
										<input type="submit" class="next21 mr" value="Proceed Next">
									</div>
								</div>
								</form>
                                </div>
                            </div>
                        </div>
                        
                   </div>
                        </div>
                        
                        
                   </div>
                   
                    <div class="clear" style="height:1px;">&nbsp;</div>
                    
                </div>
            	</div>
              <div class="clear" style="height:1px;">&nbsp;</div>
              </div>
   
  <?php /*?><div class="signupleftpannew1">
  
  	<div class="rowpanel3 ">
               		<h1><span class="bluetext">FREE</span> Merchant Sign up</h1>
                    <p style="text-align:center">
                        Please complete below steps to get registered as a Merchant to start listing  and explore your business. <br />
						Do you have an account? Please <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'login'))?>">Sign in</a> 
                    </p>
                    
                    <div class="shadow2">&nbsp;</div>
                    
                    <div class="suez-cols" style="margin-top: -10px;">
                        <div class="rowpanel3" style="margin-top:5px;">
               		
                    <div class="suez-cols" style="margin: 0 auto;width:438px">
                        <div class="col3x offers" style="width:100%; margin-top:0; padding-top:0;">
            	
						<ul class="breadcrumb">
							<li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',1))?>" class="active">Step 1</a></li>
							<li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',2))?>">Step 2</a></li>
							<li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',3))?>">Step 3</a></li>
							<li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',4))?>">Confirmation</a></li>
							<li><a href="#"></a></li>
						</ul>
						<span class="activearrow" style="left: -20px;top: 25px;"></span>
						
					
						<div id="step1" class="loginform" style="width: 95%;">
              <div class="div60x newlable" style="width:100%;">
                  <div id="anpHint" data-color="blue" style="">
                  <div class="anpHintArrow"></div>
                  <div id="anpHintHeader"></div>
                  <div id="anpHintContent"></div>
                </div>
                    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
		<form name="loginform" method="post" action="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',2))?>" id="loginform" class="loginregisterform validate" style="display: block;">
								
									<div class="form-btns" data-role="fieldcontain">
										<fieldset>
										<label class="inline" for="returnuser">
										Website information
										</label>
										</fieldset>
									</div>
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Enter your URL: <small>(Use https://)</small></label>
		<input size="30" type="url" value="<?=$url?>" required  class="form-text hasPlaceholder anpHintable" data-hint-num="0" name="url">
										</fieldset>
									</div>
                  <div class="form-field">
                    <fieldset class="user_name">
                    <label class="loginaddtion">Enter your website name:</label>
                    <input size="30" type="text" required  value="<?=$website_name?>"  class="form-text  hasPlaceholder anpHintable" name="website_name" data-hint-num="1">
                    </fieldset>
                  </div>
									<div class="div60x" style="width:100%;">
									<div class="form-btns" data-role="fieldcontain">
										<fieldset>
										<label class="inline" for="returnuser">
										Provide your personal information
										</label>
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">First name </label>
										<input size="30"  value="<?=$first_name?>" type="text" required id="user_email" class="anpHintable form-text hasPlaceholder"  name="first_name" data-hint-num="2">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Last name</label>
										<input size="30" type="text"   value="<?=$last_name?>" id="user_email" class="anpHintable form-text hasPlaceholder" name="last_name" data-hint-num="3">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Email id</label>
										<input size="30" type="email"  value="<?=$email_id?>" required name="email_id"  id="user_email_id" class=" anpHintable form-text hasPlaceholder" data-hint-num="4">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Verify email id</label>
										<input size="30" type="email"  value="<?=$varify_email_id?>" name="varify_email_id" id="user_email_varify" equalTo="#user_email_id"class="form-text hasPlaceholder anpHintable" required  data-hint-num="5">
										</fieldset>
									</div>
									
									<div class="form-field">
										<fieldset class="user_name">
										<label class="loginaddtion">Phone</label>
							<input size="30" type="desits" name="phone"   value="<?=$phone?>" id="user_phone" class="form-text hasPlaceholder anpHintable"  required data-hint-num="6">
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
               
                <div class="clear" style="height:1px;">&nbsp;</div>
                
            </div>
            
  </div><?php */ ?>
  
  
        </div>
        
        </div>
        