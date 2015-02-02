<?php $left_menu=array(
  'my_store'=>array(
    'name'=>"My Store",
    'is_parent'=>1,
  ),  
  'dashbord'=>array(
    'name'=>'Dashboard',
    'img_class'=>'icon-home',
   ),
  'my-products'=>array(
    'name'=>'My Products',
     'img_class'=>'icon-th',
   ),  
   'data_feed_setup'=>array(
    'name'=>'Data Feed Setup',
     'img_class'=>'icon-globe',
   ),
   'offers'=>array(
    'name'=>'Offers &amp; Deals',
     'img_class'=>'icon-star',
   ),

   'reviewRatings'=>array(
    'name'=>'Review &amp; Ratings',
     'img_class'=>'icon-star',
   ),
   'reports'=>array(
    'name'=>'Reports',
     'img_class'=>'icon-list-alt',
   ),
    /*'notifications'=>array(
    'name'=>'Notifications',
    'img_class'=>'icon-eye-open',
    'notify_count'=>20
   ),*/
    'store'=>array(
    'name'=>'Store Setup',
     'img_class'=>'icon-ban-circle',
   ),
  'account_settings'=>array(
    'name'=>"Account Settings",
    'is_parent'=>1
  ),  
     'my_account'=>array(
    'name'=>'My Account',
     'img_class'=>'icon-calendar',
   ),
    'change_password'=>array(
    'name'=>'Change Password',
     'img_class'=>'icon-folder-open',
   )
   

    );

//echo $this->params['controller'];
?>

<div class="dashboard_left">
						<div class="photo_panel">
							<div class="profile_img">
								<img src="<?=$this->webroot?><?=($merchant['Merchant']['image_url']!="")?$merchant['Merchant']['image_url']:'img/no-image.png'?>" border="0">
								<a href="<?=$this->Template->CreateParamLink1(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => 'change_profile_pic'))?>">Edit <span></span></a>
							</div>
						</div>
						
						<div class="clear" style="height:15px;"></div>
                        
                        <div class="well nav-collapse sidebar-nav">
                                <ul class="nav nav-tabs nav-stacked main-menu">

                                    <?php foreach($left_menu as $key=>$val) { ?>
                                   <?php if(isset($val['is_parent']) and $val['is_parent']==1) { ?>
                                	     <li class="nav-header hidden-tablet"><?=$val['name']?></li>
                                   <?php } else { 
                                         $active="";

                                   if($this->params['controller']=="products" && $key=="my-products")
                                   {
                                     $active="active";
                                   }
                                   if($this->params['controller']=="Store" && $key=="store")
                                   {
                                     $active="active";
                                   }
								  
								   if($this->params['controller']=="offers" && $key=="offers")
                                   {
                                     $active="active";
                                   }
                                   if($key==$this->params['action'])
                                   {
                                      $active="active";
                                   }
                                    ?>

                                        <li>
                                            <a class="ajax-link <?=$active?>" href="<?=$this->Template->CreateParamLink1(array(                                        
                                                 'controller' => 'merchant',
                                                 'action' => $key))?>">
                                                <i class="<?=$val['img_class']?>"></i>
                                                <span class="hidden-tablet"><?=$val['name']?> 
                                                 <?php   if(isset($val['notify_count'])){ ?>
                                                    <span class="nitification"><?=($val['notify_count']!="")?$val['notify_count']:0?></span>
                                                 <?php } ?>
                                                </span>
                                            </a>
                                        </li>
                                  <?php  } ?> 
                                   
                                 <?php } ?>
                                    
                                  
                                </ul>
						</div>
					</div>