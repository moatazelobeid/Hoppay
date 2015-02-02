  
<script type="text/javascript">

function clickTrack(purl,pid,mid,price,merchant_logo,merchant_website,pimage, pname)
{
	var url = '<?php echo $this->webroot;?>products/ajaxClickTrack/'+pid+'/'+mid+'/'+price;	
	//alert(url);
	
	var merchant_data = '';
	
	if(merchant_logo == '')
	{
		merchant_data = merchant_website;	
	}
	else
	{
		merchant_data = '<img src="<?php echo $this->webroot;?>'+merchant_logo+'" alt="'+merchant_website+'" />';
	}
	
	var html = '<div id="loadder_section"></div><div id="loadder_counter"><div class="pop_logo"><?php echo $this->Html->image('../'.$setting['Setting']['logo'], array('alt' => ''));?></div><h1><?=$this->Template->getWord("thank_you_for_checking_price")?> <br> Hoppay</h1><h3><?=$this->Template->getWord("we_are_redirecting_you_to")?> '+merchant_data+'</h3><img src="http://www.clashofclans-tools.com/images/block-loading.gif" alt="block-loading" style="width:50px; display:block; margin:0 auto;"/><div class="product_iconlink"><img src="'+pimage+'" alt="'+pname+'"></div><h4>'+pname+'</h4><h5><?=$this->Template->getWord("clik_heare_to_redirect")?> <a href="'+purl+'"><?=$this->Template->getWord("here")?></a></h5></div>';
	
	$('body').prepend(html);
	
	var counter = 0;
	setInterval(function () {
	++counter;
	//$('#loadder_counter').html(counter);
	  
	}, 1000);
	setTimeout(function(){
		
		$.get(url,function(data)
		{
			//alert(data);
			if(data == 1)
			{
				window.location.href = purl;
        //window.open( purl, '_blank');
			}
		
		});
	},5000);
}
</script>        
        <div class="clear" style="height:0px;">&nbsp;</div>
        
        <!--  Footer Panel Start  -->
        
        <!--  Footer Panel Start  -->
        <div class="footer">
        	<!--<div id="ft">
              <div class="container clearfix">
                <div class="col1">
                  <form id="footer_signup_form" action="#" onsubmit="return add_newsletter();" class="clearfix validate" style="display: block;">
                      <p>
                        Be in touch with the MenaCompare Newsletter
                      </p>
                      <p class="signup_form_input_fields">
                        <input type="email" name="email_news" id="email_id_newsletter" required placeholder="Enter your email" class="signup_form_email_input">
                        <input type="submit" class="signup_form_submit" value="Sign Up">
                      </p>
                      <p class="signup_form_status " style="display:none" ></p>
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
                    <h1>Follow Us:</h1>
                    </b>
                  </p>
                  	<div class="clear" style="height:5px;"></div>
                 	<a target="_blank" href="#" class="face" title="Facebook">&nbsp;</a>
                    <a target="_blank" href="#" class="twit" title="Twitter">&nbsp;</a>
                    <a target="_blank" href="#" class="tube" title="Youtube">&nbsp;</a>
                    <a target="_blank" href="#" class="gplus" title="Google Plus">&nbsp;</a>
                </div>
                
                
              </div>
            </div>-->

            <div class="grid" style="padding: 14px 0px 17px 0px;margin-bottom: 14px;margin: 0 auto;width: 1170px;height: 10px;">
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

                   $menu_lang_data = '';
				   $menu_lang_data = $this->Template->languageChanger($val['Menu_lang']);

                   if($key==0) {?>
                    <a href="<?=$this->Template->CreateParamLink1(array(                                     
                                             'controller' => $val['Menu']['menu_controller'],
                                             'action' => $val['Menu']['menu_action']))?>" class=""><?=$menu_lang_data['menu_title']?></a> 
                    <?php } else {?>
                     <a href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'p',
                                             'action' => $val['Menu']['slug']))?>" ><?=$menu_lang_data['menu_title']?></a> 
                                            
            <?php }
                if($key!=($count-1))
                {
                    echo " &nbsp; | &nbsp;";
                }

             } ?>
                </div>
            
            </div>
        
        </div>
        <!--  Footer Panel End  -->
        
        	
        
        
        
</div>
<!--<p id="back-top" style="display: block;">
<a href="#top"><span>
        
        <!--<br>Back <br><br>to <br><br>Top-->
        <!--<img src="/menacompare/images/front-end/up-arrow.png">
        </span></a>
</p>-->
<script>

  function add_newsletter(){
    var email=$('#email_id_newsletter').val();
   // console.log(email);
    $('.signup_form_submit').addClass('signup_form_status_message').val('');
    $.post('<?=$this->webroot?>homes/newsletter_signup',{'email_id':email},function(r){

        if(r)
        {
          $('.signup_form_submit').removeClass('signup_form_status_message').val('Sign Up');
          $('p.signup_form_status').html(r).css('color','rgb(11, 114, 11)').slideDown();
          $('#email_id_newsletter').val('');
        }else{
           $('p.signup_form_status').html('There is a problem, Try later.').css('color','#f00');
        }
        setTimeout(function(){

           $('p.signup_form_status').slideUp();
        },2000)
    })
   return false;
  }


</script>
</body>
</html>
