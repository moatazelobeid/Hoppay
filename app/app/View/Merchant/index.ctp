   <div class="merchantlist">
                  <h1><?=$page_data['Page_lang'][0]['pg_title']?></h1>
                    
                        <?=htmlspecialchars_decode($page_data['Page_lang'][0]['pg_descriptions'])?>
            
       <div class="get_new" style="position:relative"> <a class="cta__button cta__button--small widthfixed" href="<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/signup" style="margin-bottom:0;box-shadow:none!important;">Get started</a><div class="freetag1"><img src="<?=$this->webroot?>img/arrow_next.png" hspace="10" alt="arrow next"/><span class="free_text">It's free</span></div></div>
    
                    <div class="shadow2" style="display:none;">&nbsp;</div>
                    
                    <div class="clear" style="height:1px;"></div>
          
          <?php 
          $attrs=$this->Template->GetPageAttrByActionKey('inner_points',$page_data['Page']['id']);
          $tags=$this->Template->GetPageAttrByActionKey('tagline',$page_data['Page']['id']);
           // print_r($attrs);
         
          $halfCount=round(count($tags)/2);

          ?> 
          <div>
            <?php
            $i=1;
             foreach (array_values($attrs) as $key => $value) { 
                 
              ?>
               <div class="imgpanel<?=$i?>"><img src="<?=$this->webroot?><?=$value->img?>" style="width: 358px;"  alt="hoppay" /></div>
            <div class="merchantright<?=$i?>">
              <h1><?=$value->key?></h1>
              <h4>
                <?=$value->subtitle?>
              </h4>
              <p>
                <?=$value->values?>
              </p>
              <div class="circle1"><?=($key+1)?></div>
              <img src="<?=$this->webroot?>images/merchant/images/arrowmrchnt1.png"  alt="hoppay" style="position:relative; left: -8em;top: -1em; display:none;" />

            </div>
             <div class="clear"></div>
            <img src="<?=$this->webroot?>images/merchant/mm-btm-shad.png"  alt="hoppay" style="position:relative;right:4%; float:right; display:none;" />
            <div class="clear" style="height:60px;"></div>
            <?php 
                if($i==1)
                 {
                   $i=2;
                 }
                 else
                 {
                  $i=1;
                 }
             } ?>
           
           
            
            
            
            
            
           <?php /* ?> <div class="imgpanel2"><img src="<?=$this->webroot?><?=$attrs[1]->img?>"  alt="hoppay" /></div>
            <div class="merchantright2">
              <h1><?=$attrs[1]->key?></h1>
              <h4>
                <?=$attrs[1]->subtitle?>
              </h4>
              <p>
               <?=$attrs[1]->values?>
              </p>
              <div class="circle1">2</div>
              <img src="<?=$this->webroot?>images/merchant/arrowmrchnt2.png" alt="arrow" style="position:relative; left: 30em;top: 0em; display:none;" />
            </div>
            <div class="clear"></div>
            <img src="<?=$this->webroot?>images/merchant/mm-btm-shad.png" alt="shadow" style="position:relative;right:4%; float:right; display:none;" />
            
            
            <div class="clear" style="height:1px;"></div>
            
            <div class="imgpanel1"><img src="<?=$this->webroot?><?=$attrs[2]->img?>"  alt="hoppay" /></div>
            <div class="merchantright1">
              <h1><?=$attrs[2]->key?></h1>
              <h4>
                <?=$attrs[2]->subtitle?>              </h4>
              <p>
                <?=$attrs[2]->values?>
              </p>
              <div class="circle1">3</div>
              <img src="<?=$this->webroot?>images/merchant/arrowmrchnt1.png"  alt="hoppay" style="position:relative; left: -8em;top: -1em; display:none;" />
            </div>
            <div class="clear"></div>
            
          </div>
          
          <div class="clear" style="height:60px;"></div><?php */ ?>
          <div class="shadow2">&nbsp;</div>
          
          <div class="midtitle1">Merchant's Benefits at Hoppay</div>
          <?php if(!empty($tags)){ ?>     
          <div class="features-icons-list "> 
                
            <div class="grid-item">
              <?php 
                  foreach (array_values($tags) as $key => $value) {
                    if($key<$halfCount)
                    {
                      //echo $key;
                   ?>
                  
              <div class="iconlistdata"><img src="<?=$this->webroot?><?=$value->img?>"  alt="hoppay" /></div>
              <div class="icondatalist"><?=$value->key?></div>
              <div class="clear"></div>
              
             

              <?php   } }

              ?>
            </div>
            
            
            
            
            <div class="grid-item">
               <?php 
                  foreach (array_values($tags) as $key => $value) {
                    if($key>=$halfCount)
                    {
                   ?>
              <div class="iconlistdata"><img src="<?=$this->webroot?><?=$value->img?>"  alt="hoppay" /></div>
              <div class="icondatalist"><?=$value->key?></div>
              <div class="clear"></div>
                  <?php } } ?>
            </div>
           
             
          </div>
         <?php } ?>
       
             
                <div class="clear" style="height:1px;">&nbsp;</div>
                
            </div>
        </div>
        <div class="clear"></div>
    
    <div class="cta cta--blue row">
      <div class="grid" style="padding: 14px 0px 17px 0px;margin-bottom: 14px;margin: 0 auto;width: 1002px; text-align:center;">
        <h2 class="cta__title-major">Getting your products listed with Hoppay is easy:</h2>
        <p class="cta__subtitle">Create a Hoppay Merchant Account</p>
    
        <div class="get_new" style="position:relative">
      <a class="cta__button cta__button--small widthfixed" href="<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/signup" style="margin-bottom:0;box-shadow:none!important;">Get started</a>
      <div class="freetag1"><img src="<?=$this->webroot?>img/arrow_next_1.png" hspace="10" alt="Next"/><span class="free_text">It's free</span></div></div>
    
      </div>
    </div>
        </div>
        