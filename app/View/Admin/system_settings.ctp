<?php $data=isset($setting_info)?$setting_info:""; 
       //print_r($data['User']);
       @ extract($data['Setting']);
        
    ?>
    <script>
    $(function(){
    //$(".tab_content").hide(); //Hide all content
    $("ul.tabs li").removeClass('active');
    $("ul.tabs li:nth-child(2)").addClass("active").show();
    })
    </script>
    <?=$this->Session->flash('bad')?> 
    <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> System Setting</h3>
      <ul class="tabs">
        <li><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
        <li class="active"><a href="javaScript:void(0);">System</a></li>
        <li><a href="<?=$this->webroot?>admin/tagline">TagLine</a></li>
        <?php /*?><li><a href="<?=$this->webroot?>admin/seo_settings">Seo</a></li><?php */?>
        <li><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
        <li><a href="<?=$this->webroot?>admin/language_settings">language</a></li>
      </ul>
      </header>
     
        <div class="tab_container">   
        <div id="tab1" class="tab_content">    
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table>
                  <tr>
                    <td>
                   <label>Default Language 
                     <span class="small">Choose Language</span>
                   </label>
                    </td>
                    
                    <td>
                      <?php //print_r($lang_info['Language']);?>
                      <select name="default_language_id">
                        <option value="">-- Choose Language --</option>

                        <?php foreach($lang_info as $val){?>
                          <option <?=$this->Template->Select($val['Language']['id'],$default_language_id)?> value="<?=$val['Language']['id']?>"><?=$val['Language']['lang_name']?></option>
                        <?php } ?>
                      </select>
                   
                    </td>
                 </tr>
                 <tr>
                    <td>
                    <label>CharSet
                     <span class="small">Add Charset</span>
                   </label>
                   </td>
                    <td>
                       <select name="charset">
                        <option value="">-- Choose Charset --</option>
                        <option value="utf-8" <?=$this->Template->Select($charset,'utf-8')?> >utf-8</option>
                        <option value="utf-16" <?=$this->Template->Select($charset,'utf-16')?>>utf16</option>
                      </select>                   
                  </td>
                  </tr>
                   
                  <tr>
                    <td></td> 
            <td>
               <button type="submit" name=""><?=$admin_button?></button>
            <td>
                </tr>
         
               </table>
         
               
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       </div>
       
     </div>
    </article><!-- end of post new article -->

