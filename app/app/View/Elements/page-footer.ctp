 
        <!--  Footer Panel Start  -->
        <div>
        	<div id="ft">
              <div class="container clearfix">
                <div class="col1">
                  <form id="footer_signup_form" action="#" class="clearfix" style="display: block;">
                    <p>
                      Be in touch with the MenaCompare Newsletter
                    </p>
                    <p class="signup_form_input_fields">
                      <input type="text" name="email_news" placeholder="Enter your email" class="signup_form_email_input">
                      <input type="submit" class="signup_form_submit" value="Sign Up">
                    </p>
                    <p class="signup_form_status_message">
                    </p>
                  </form>
                  
                </div>
                
                <div class="col2">
                  <p>
                    <b>
                    MenaCompare
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                  About Us
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Jobs
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Advertise
                  </a>
                  <a target="_parent" href="#">
                  Sitemap
                  </a>
                  <a target="_parent" href="#">
                  Mobile Site
                  </a>
                </div>
                
                <div class="col3">
                  <p>
                    <b>
                    Categories
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                   Lorem data 1 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Catg data 1 Sam1 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Lorem data ample3 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Catg Catg dat S4 
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  More...
                  </a>
                </div>
                
                <div class="col3">
                  <p>
                    <b>
                    Support
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">
                  Market Reporter
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Mobile Apps
                  </a>
                  <a target="_parent" href="#" rel="nofollow">
                  Help
                  </a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Policies
                    </b>
                  </p>
                  <a target="_parent" href="#" rel="nofollow">Return Policy</a>
                 <a target="_parent" href="#" rel="nofollow">Refund Policy</a>
                 <a target="_parent" href="#" rel="nofollow">Shipping Policy</a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Know Us Better
                    </b>
                  </p>
                 	<a target="_parent" href="#" rel="nofollow">Why MenaCompare</a>
                    <a target="_parent" href="#" rel="nofollow">Life At HomeShop18</a>
                    <a target="_parent" href="#" rel="nofollow">Careers</a>
                    <a target="_parent" href="#" rel="nofollow">Connect</a>
                    <a target="_parent" href="#" rel="nofollow">Partner With Us</a>
                </div>
                
                <div class="col4">
                  <p>
                    <b>
                    Follow Us:
                    </b>
                  </p>
                  	<div class="clear" style="height:5px;"></div>
                 	<a target="_blank" href="#" class="face" title="Facebook">&nbsp;</a>
                    <a target="_blank" href="#" class="twit" title="Twitter">&nbsp;</a>
                    <a target="_blank" href="#" class="tube" title="Youtube">&nbsp;</a>
                    <a target="_blank" href="#" class="gplus" title="Google Plus">&nbsp;</a>
                </div>
                
                
              </div>
            </div>

            <div class="grid" style="padding: 14px 0px 17px 0px;margin-bottom: 14px;margin: 0 auto;width: 1002px;height: 10px;">
                <div class="fot1">
                	<?php 
      $lang = $this->Template->getLang();
      if($lang == 'en')
        echo stripslashes($setting['Setting']['copyrgt_txt']);
      else
        echo stripslashes($setting['Setting']['copyrgt_txt_ar']);?>
                </div>
            
                <div class="fot2">
                  <?php 
                    $count=count($footer_menu);
                    foreach($footer_menu as $key=>$val){ 

                           if($key==0) {?>
                            <a href="<?=$this->Template->CreateParamLink(array(                                     
                                                     'controller' => $val['Menu']['menu_controller'],
                                                     'action' => $val['Menu']['menu_action']))?>" class="login"><?=$val['Menu_lang'][0]['menu_title']?></a> 
                            <?php } else {?>
                             <a href="<?=$this->Template->CreateParamLink(array(                                        
                                                     'controller' => 'p',
                                                     'action' => $val['Menu']['slug']))?>" ><?=$val['Menu_lang'][0]['menu_title']?></a> 
                                                    
                    <?php }
                        if($key!=($count-1))
                        {
                            echo " &nbsp; | &nbsp;";
                        }

                     } ?>
                </div>
            
            </div>
        
        </div>