
<div class="clear" style="height:15px;">&nbsp;</div> 
  
<div class="newheadertwo">
    <h1>Forgot Password</h1>
    <p style="text-align:center">
        Please complete below steps to get sign in as a Merchant to start listing  and explore your business. <br>
        Do you have an account? Please <a href="<?=$this->webroot?><?=$this->Template->getLang();?>/merchant/signup">Sign Up</a> 
    </p>
    
    <div class="clear" style="height:10px;">&nbsp;</div>
    <div class="shadow2">&nbsp;</div>
    <div class="clear" style="height:1px;">&nbsp;</div>
</div>

<div class="signupleftpannew2">
    <div class="shadowpanel21">
        <h1>Join Our Merchant Program. It's FREE</h1>
        <h3>
            By providing your e-mail address, you agree to receive information about products, services and offers from Hoppay. 

        </h3>
        
        <ul class="signUpList">
          <li>Easy to setup and use</li>
          <li>List your products for free</li>
          <li>Increase your visibility and traffic</li>
          <li>Advertise your store by publishing your own merchant page</li>
          <li>Get Leads to your site</li>
          <li>Track thousands of traffics daily, weekly or monthly</li>
          <li>Increase your sales</li>
          <li>Pay comissions on sales only</li>
          <li>Flexible online help center</li>   
          <li>Gett offers and alerts</li>             
        </ul>
        
        <div class="clear" style="height:10px;"></div> 
        
    <p class="social_login_button offers">
      <a href="<?=$this->webroot?><?=$this->Template->getLang();?>/merchant/signup">
        <input type="submit" value="Create an Account" name="login" class="form-sub" style="width:180px;float: left;">
      </a>
      </p>
        <div class="clear" style="height:10px;"></div> 
    </div>
    
</div>






<div class="signupleftpannew1">

  <div class="rowpanel3" style="min-height:500px">
  <div class="suez-cols" style="margin:0;">
      <div class="col3x offers" style="width:100%">
      <div class="loginform" style="width:77%">
          <?=$this->Session->flash('bad')?>
          <?=$this->Session->flash('msg')?>
          <form action="" method="post" name="loginform" id="loginform" class="loginregisterform validate" style="display: block;">
         
          <div class="div60x loginpanel">
              <div class="form-field">
              <fieldset class="user_name">
                <label class="loginaddtion mobtx">Username/ Email Id</label>
                <input size="30" required type="text" name="email" id="user_email" class="form-text hasPlaceholder" style="background-image: url(../../images/front-end/id.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 71% !important;">
                </fieldset>
              <p id="user_email_error" class="message">
                </p>
               <p class="talign">( Enter the Username/Email Id so that we will send your password )</p>
            </div>
            </div>
          <div class="form-btns">
              <span class="forgetpwd" style="display: none;">
            <a href="#" class="thickbox" title="Forgot Password">
              Forgot password?
              </a>
            </span>
              <input type="submit" value="Submit" name="login" class="form-sub mobtn">
              <br>
            </div>
        </form>
        </div>
    </div>
      <div class="clear" style="height:5px;">
    </div>
    </div>
</div>

</div>












  <?php /*?><div class="rowpanel3" style="min-height:500px">
                  
                    <div class="suez-cols" style="margin:0;">
                        <div class="col3x offers" style="width:100%">
                  <div class="loginform">
                     <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
                     <form action="" method="post" name="loginform" id="loginform" class="loginregisterform validate" style="display: block;">
                      <h2>
                        Forgot password
                      </h2>
                      <div class="div60x loginpanel">
                        <div class="form-field">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Username/ Email</label>
                          <input size="30" required type="text" name="email" id="user_email" class="form-text hasPlaceholder" style="background-image: url(../../images/front-end/id.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 93%;">
                          </fieldset>
                          <p id="user_email_error" class="message">
                          </p>
                        </div>
                        
                        
                      </div>
                      <div class="form-btns">
                        <span class="forgetpwd" style="display: none;">
                        <a href="#" class="thickbox" title="Forgot Password">
                        Forgot password?
                        </a>
                        </span>
                        <input type="submit" value="Submit" name="login" class="form-sub">
                        <br>
                      </div>
                      
                    </form>
                  </div>
                  <div class="division">&nbsp;</div>
                  <div class="otherlogin">
                    <h3 style="padding-right: 35px;">
                       Join Our Merchant Program. It's FREE
                      </h3>
                    <div id="fbLogin" style="border: none;background: none;">
                      
                      
                      <fieldset class="suez-col-5">
              <ul style="padding-left: 45px;">
                              <li>Easy to setup and use</li>
                              <li>List your products for free</li>
                                <li>Increase your visibility and traffic</li>
                                <li>Advertise your store by publishing your own merchant page</li>
                                <li>Get Leads to your site</li>
                                <li>Track thousands of traffics daily, weekly or monthly</li>
                                <li>Increase your sales</li>
                                <li>Pay comissions on sales only</li>
                                <li>Flexible online help center</li>   
                                <li>Gett offers and alerts</li>                         
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
                    
                    

               </div><?php */?>
               
                <div class="clear" style="height:1px;">&nbsp;</div>
                
            </div>
        </div>
        
        </div>