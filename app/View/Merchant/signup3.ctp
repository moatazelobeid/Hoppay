<script type="text/javascript">
var tipNames = ['Username','Password', 'Re-Enter Password'];
  var tips = [
    '<p>Enter your username</p>',
    '<p>Enter password</p>',
    '<p>Re-enter password</p>'
    
  ];
  </script>
 <?php
 error_reporting(0);
	if(isset($step_3) )
	{
		extract($step_3);
	}
  ?>
   
    <div class="clear" style="height:15px;">&nbsp;</div>
                <div class="newheadertwo">
                    <!--<h1><span class="bluetext">FREE</span> Merchant Sign up</h1>-->
					<h1>Setup your <span class="bluetext">FREE</span> online Merchant account with Hoppay</h1>
					
                   <!-- <p style="text-align:center">
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
                                <div id="Access2" class="left number_header margin-notop greencolor">
                                  <span class="image_step2"></span>
                                </div>
                                <div id="accessacnt" class="left  widthresp">
                                  <span class="heading1 greencolor">Address Information</span>
                                  <br>
                                  <span class="subheading">Address Information</span>
                                </div>
                                <div class="clear"></div>
                                <div id="hr2" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2">
                                </div>
                            </div></a>
                            
                            <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',3))?>">
                                             <div id="header3" class="left left2per  ">
                                <div id="manage3" class="left number_header margin-notop greencolor"><span class="image_step3"></span></div>
                                
                               <!-- <div id="hr1" class="hrpadding">
                                  <hr class="horizontalrule widthhr_1 green">
                                </div>
                                 -->
                                <div id="managefin" class="left  widthresp">
                                  <span class="heading1 greencolor">Login Information</span>
                                  <br>
                                  <span class="subheading">SETUP LOGIN</span>
                                </div>
                                
                              <div class="clear"></div>
                                <div id="hr3" class="hrpadding">
                                  <hr class="horizontalrule widthhr_2 green">
                                </div>
                            </div>
                           </a>
                            
                            <a 
                            <?php if($active4==1){ ?>
                            href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup',4))?>" <?php } ?>><div id="header2" class="left  left2per ">
                                <div id="Access2" class="left number_header margin-notop">
                                  <span class="image_step4_gray"></span>
                                </div>
                                <div id="accessacnt" class="left widthresp">
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
                       <!--  <h3>
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
    <form name="loginform"  method="post" action="<?=$this->Template->CreateParamLink(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'signup',4))?>" id="loginform" class="loginregisterform validate" style="display: block;">
                                    <div class="div60x newlable" style="width:100%;">
                                        
                                        <div class="form-btns" data-role="fieldcontain">
                                    <fieldset>
                                    <label class="inline" for="returnuser">
                                    Login Details
                                    </label>
                                    </fieldset>
                                </div>
                                
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Username</label>
                                            <input value="<?=$username?>" size="30"  required type="text" name="username" id="username" data-hint-num="0" class="anpHintable form-text hasPlaceholder">
                                            </fieldset>
                                        </div>
                                        
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Password</label>
                                            <input value="<?=$password?>" size="30" type="password"  required name="password" data-hint-num="1" id="user_password" class="anpHintable form-text hasPlaceholder">
                                            <span style="font-size: 11px;padding-top: 5px;display: block;">
                                                <!--(Must be at least 8 characters in length and contain both letters and numbers)-->
                                            </span>
                                            </fieldset>
                                        </div>
                                        
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Re-enter password</label>
                                            <input value="<?=$re_password?>" size="30" type="password" required equalTo="#user_password" name="re_password" data-hint-num="2" id="user_password_varyfy" class="anpHintable form-text hasPlaceholder">
                                            <span style="font-size: 11px;padding-top: 5px;display: block;">
                                                <!--(Must be at least 8 characters in length and contain both letters and numbers)-->
                                            </span>
                                            </fieldset>
                                        </div>
                                        
                                        <div class="clear" style="height:5px;"></div>
                                        
                                        <div class="form-field check_3">
                                            <fieldset class="user_name">
                                        <input  type="checkbox" <?=isset($is_agreed)?"checked":""?> name="is_agreed" required id="is_agreed" value="1" style="margin-left: 0;float: left;margin-right: 6px;">
                                        <label class="loginaddtion tpmr" for="is_agreed">I have  read and agreed to the <a class="various" href="#inline" >Terms and conditions</a> of Hoppay. </label>
                                            </fieldset>
                                        </div>
                                        <div id="inline" style="display:none;width:66%;" class="termleft">
                                            <h2>Terms and conditions</h2>
    
                                            <p>
                                                Terms and conditions Text goes here.
                                                
                                            </p>
                                            <!--<CENTER><a class="button button-blue" href="javascript:$.fancybox.close();">Close</a></center>-->
                                            
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
                                                 'action' => 'signup',2))?>" >Step 2</a></li>

                                <li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'signup',3))?>" class="active">Step 3</a></li>
                                <li><a href="<?=$this->Template->CreateParamLink(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'signup',4))?>">Confirmation</a></li>
                                <li><a href="#"></a></li>
                            </ul>
                            <span class="activearrow" style="left: 190px;top: 25px;"></span>
                            
                        
                            <div id="step1" class="loginform" style="width: 95%;">
                   <div id="anpHint" data-color="blue" style="">
                      <div class="anpHintArrow"></div>
                      <div id="anpHintHeader"></div>
                      <div id="anpHintContent"></div>
                    </div>
                             <?=$this->Session->flash('bad')?> 
                             <?=$this->Session->flash('msg')?>
                                <form name="loginform"  method="post" action="<?=$this->Template->CreateParamLink(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'signup',4))?>" id="loginform" class="loginregisterform validate" style="display: block;">
                                    <div class="div60x newlable" style="width:100%;">
                                        
                                        <div class="form-btns" data-role="fieldcontain">
                                    <fieldset>
                                    <label class="inline" for="returnuser">
                                    <strong>Login Details</strong>
                                    </label>
                                    </fieldset>
                                </div>
                                
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Username</label>
                                            <input value="<?=$username?>" size="30"  required type="text" name="username" id="username" data-hint-num="0" class="anpHintable form-text hasPlaceholder">
                                            </fieldset>
                                        </div>
                                        
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Password</label>
                                            <input value="<?=$password?>" size="30" type="password"  required name="password" data-hint-num="1" id="user_password" class="anpHintable form-text hasPlaceholder">
                                            <span style="font-size: 11px;padding-top: 5px;display: block;">
                                                <!--(Must be at least 8 characters in length and contain both letters and numbers)-->
                                            </span>
                                            </fieldset>
                                        </div>
                                        
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                            <label class="loginaddtion">Re-enter password</label>
                                            <input value="<?=$re_password?>" size="30" type="password" required equalTo="#user_password" name="re_password" data-hint-num="2" id="user_password_varyfy" class="anpHintable form-text hasPlaceholder">
                                            <span style="font-size: 11px;padding-top: 5px;display: block;">
                                                <!--(Must be at least 8 characters in length and contain both letters and numbers)-->
                                            </span>
                                            </fieldset>
                                        </div>
                                        
                                        <div class="clear" style="height:5px;"></div>
                                        
                                        <div class="form-field">
                                            <fieldset class="user_name">
                                        <input  type="checkbox" <?=isset($is_agreed)?"checked":""?> name="is_agreed" required id="is_agreed" value="1" style="margin-left: 0;float: left;margin-right: 6px;">
                                        <label class="loginaddtion" for="is_agreed">I have  read and agreed to the <a class="various" href="#inline" >Terms and conditions</a> of Mena Compare. </label>
                                            </fieldset>
                                        </div>
                                        <div id="inline" style="display:none;width:100%;">
                                            <h2>Terms and conditions</h2>
    
                                            <p>
                                                Terms and conditions Text goes here.
                                                
                                            </p>
                                            <!--<CENTER><a class="button button-blue" href="javascript:$.fancybox.close();">Close</a></center>-->
                                            
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
        