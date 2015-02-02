<div class="clear" style="height:15px;">&nbsp;</div>

<div class="newheadertwo">
    <h1>Merchant Sign In</h1>
    <!--<p style="text-align:center">
        Please complete below steps to get sign in as a Merchant to start listing  and explore your business. <br>
        Do you have an account? Please <a href="<?=$this->webroot?><?=$this->Template->getLang();?>/merchant/signup">Sign Up</a> 
    </p>-->
    
    <div class="clear" style="height:10px;">&nbsp;</div>
    <div class="shadow2">&nbsp;</div>
    <div class="clear" style="height:1px;">&nbsp;</div>
</div>

<script>
var container= document.getElementById("signinftr");
signinftr.style.height=(window.innerHeight);
signinftr.style.width=window.innerWidth;
</script>
                 
 <div class="signinleftpannew1" id="signinftr" style="height:inherit;">
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
                    <form action="" method="post" name="loginform" id="loginform" class="loginregisterform validate" style="display: block;">
                      <h2>
                        Have an Account? Sign in Here
                      </h2>
                      <div class="div60x loginpanel">
                        
                        <div class="form-field">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Username</label>
                          <input size="30" required type="text" name="username" id="user_email" class="form-text hasPlaceholder" style="background-image: url(../../images/front-end/id.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 93%;">
                          </fieldset>
                          <p id="user_email_error" class="message">
                          </p>
                        </div>
                        <div class="form-field givepassword">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Password</label>
                          <input size="30" required name="password" id="password" type="password" class="form-text" validate="" style="background-image: url(../../images/front-end/pass.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 40px;width: 93%;">
                          </fieldset>
                        </div>
                        
                      </div>
                      <div class="form-btns">
                        <span class="forgetpwd" style="display: none;">
                        <a href="#" class="thickbox" title="Forgot Password">
                        Forgot password?
                        </a>
                        </span>
                        <input type="submit" value="Sign in" name="login" class="form-sub">
                        <br>
                      </div>
                      <div class="form-field" data-role="fieldcontain">
                        <fieldset>
                        <label class="inline newfiled">
                        <a href="<?=$this->Template->CreateParamLink(array(                                    
                                             'controller' => 'merchant',
                                             'action' => 'forgot_password'))
                                             ?>">
                        Forgot password?
                        </a>
                        </label>
                        </fieldset>
                      </div>
                    </form>
                                </div>
                            </div>
                        </div>
                        
                   </div>
                        </div>
                        
                        
                   </div>
                   
                    <div class="clear">&nbsp;</div>
                    
                </div>
            	</div>                



<?php /*?><div class="rowpanel3" style="min-height:600px;">
               		
                    <div class="suez-cols" style="margin:0;">
                        <div class="col3x offers" style="width:100%">
                  <div id="stepss" class="loginform">
                               <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
                    <form action="" method="post" name="loginform" id="loginform" class="loginregisterform validate" style="display: block;">
                      <h2>
                        Have an Account? Sign in Here
                      </h2>
                      <div class="div60x loginpanel">
                        <div class="form-btns" data-role="fieldcontain">
                          <fieldset>
                          <label class="inline" for="returnuser">Have an Account?  Sign in Here</label>
                          </fieldset>
                        </div>
                        <div class="form-field">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Username</label>
                          <input size="30" required type="text" name="username" id="user_email" class="form-text hasPlaceholder" style="background-image: url(../../images/front-end/id.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 93%;">
                          </fieldset>
                          <p id="user_email_error" class="message">
                          </p>
                        </div>
                        <div class="form-field givepassword">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Password</label>
                          <input size="30" required name="password" id="password" type="password" class="form-text" validate="" style="background-image: url(../../images/front-end/pass.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 93%;">
                          </fieldset>
                        </div>
                        
                      </div>
                      <div class="form-btns">
                        <span class="forgetpwd" style="display: none;">
                        <a href="#" class="thickbox" title="Forgot Password">
                        Forgot password?
                        </a>
                        </span>
                        <input type="submit" value="Sign in" name="login" class="form-sub">
                        <br>
                      </div>
                      <div class="form-field" data-role="fieldcontain">
                        <fieldset>
                        <label class="inline newfiled">
                        <a href="<?=$this->Template->CreateParamLink(array(                                    
                                             'controller' => 'merchant',
                                             'action' => 'forgot_password'))
                                             ?>">
                        Forgot password?
                        </a>
                        </label>
                        </fieldset>
                      </div>
                    </form>
                  </div>
                  <div class="division">&nbsp;</div>
                  <div class="otherlogin">
                  	<h3 style="padding-right: 64px;">
                       Join Our Merchant Program. It's FREE
                      </h3>
                    <div id="fbLogin" style="border: none;background: none;">
                      
                      
                      <fieldset class="suez-col-5">
                        
                      
							            <ul style="padding-left: 45px;">
                            	 <?php 
                                 echo $this->Template->GetTagesByKey('mena-compare-merchant-benefits');
                               ?>                      	
                            </ul>
                      </fieldset>
                      <div class="clear" style="height:10px;"></div>
                      <p class="social_login_button">
                        <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup'))?>">
                        	<input type="submit" value="Create an Account" name="login" class="form-sub" style="width:200px;float: left;margin-left: 11px;">
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                        <div class="clear" style="height:5px;"></div>
                    </div>
                    
                    
                    
                    <div class="clear" style="height:20px;"></div>
                    
                    

               </div>
               <?php */ ?>
                <div class="clear" style="height:1px;">&nbsp;</div>
                <div class="clear" style="height:100px;">&nbsp;</div>
            </div>
        </div>
        
        </div>