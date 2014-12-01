
<div class="footersection">
    <div class="grid" style="padding-top: 12px;">
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
