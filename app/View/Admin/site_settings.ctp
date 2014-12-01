<?php $data=isset($setting_info)?$setting_info:""; 
       //print_r($data['User']);
       @ extract($data['Setting']);
        
    ?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> General Setting</h3>
      <ul class="tabs">
        <li><a href="#tab1">General</a></li>
        <li><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
        <li><a href="<?=$this->webroot?>admin/tagline">TagLine</a></li>
        <?php /*?><li><a href="<?=$this->webroot?>admin/seo_settings">Seo</a></li><?php */?>
        <li><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
        <li><a href="<?=$this->webroot?>admin/language_settings">language</a></li>
      </ul>
      </header>
     <?php $allow_capcha=json_decode($allow_capcha) ;
      //print_r($allow_capcha);
     ?>
     <style type="text/css">
     #stylized input, #stylized select, #stylized textarea, #stylized iframe {

         width: 72%;
      }
     </style>
        <div class="tab_container">   
        <div id="tab1" class="tab_content">    
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table>
                  <tr>
                    <td>
                   <label>Site title 
                     <span class="small">Add Site Title</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="site_title" placeholder="Enter your Name." value="<?=isset($site_title)?$site_title:""?>">
                    </td>
                 </tr>
                  <tr>
                    <td>
                   <label>Site title (Arabic) 
                     <span class="small">Add Site Title (Arabic)</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="site_title_ar" placeholder="Enter your Name." value="<?=isset($site_title_ar)?$site_title_ar:""?>">
                    </td>
                 </tr>
                 <tr>
                    <td>
                    <label>Site Descriptions
                     <span class="small">Add Description.</span>
                   </label>
                   </td>
                    <td>
                      <textarea name="site_desc"><?=isset($site_desc)?$site_desc:""?></textarea>                    
                  </td>
                  </tr>
                  <?php if(@$logo!=""){ ?>
                    <tr>
                      <td>
                    <label> Your current Logo 
                     <span class="small">See your logo.</span>
                    </label>
                    </td>
                    <td>
                       <img src="<?=$this->webroot.$logo?>" height="60px">
                    </td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td>
                    <label>Logo 
                     <span class="small">Add site logo.</span>
                    </label>
                    </td>
                    <td>
                       <input type="file"  name="logo" >
                    </td>
                    </tr>
                 <!--    <tr>
                    <td>
                   <label>Tag Line
                     <span class="small">Add Tag Line</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="tag_line" placeholder="Enter your Name." value="<?=isset($tag_line)?$tag_line:""?>">
                    </td>
                 </tr>
                    <tr>
                    <td>
                   <label>Tag Line(Ar)
                     <span class="small">Add Tag Line(Ar)</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="tag_line_ar" placeholder="Enter your Name." value="<?=isset($tag_line_ar)?$tag_line_ar:""?>">
                    </td>
                 </tr> -->
                     <?php if(@$favicon!=""){ ?>
                    <tr>
                      <td>
                    <label> Your current Favicon 
                     <span class="small">See your favicon.</span>
                    </label>
                    </td>
                    <td>
                       <img src="<?=$this->webroot.$favicon?>" height="60px">
                    </td>
                    </tr>
                    <?php } ?>
                 <tr>
                  <td>
                    <label>favicon
                     <span class="small">Add favicon.</span>
                   </label>
                   </td>
                   <td>
                     <input type="file" name="favicon" >
                   </td>
                  </tr>
                  
                  <tr>
                    <td>
                    <label>Copyright Text
                     <span class="small">Add Copyright Text</span>
                     </label>
                     </td>
                     <td>
                    <input type="text"  value="<?=isset($copyrgt_txt)?$copyrgt_txt:""?>" required name="copyrgt_txt" placeholder="Copyright Text ">
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <label>Copyright Text(Ar)
                     <span class="small">Add Copyright Text(Ar)</span>
                     </label>
                     </td>
                     <td>
                    <input type="text"  value="<?=isset($copyrgt_txt_ar)?$copyrgt_txt_ar:""?>" required name="copyrgt_txt_ar" placeholder="Copyright Text For Arabic">
                    </td>
                  </tr>
                     <tr>
                      <td>
                    <label>Email
                     <span class="small">Add site Email</span>
                     </label>
                     </td>
                     <td>
                      <input type="email" value="<?=isset($site_email)?$site_email:""?>" name="site_email" placeholder="Enter your email.">                   
                    </td>
                    </tr>                
                    <tr>
                      <td>
                    <label>Time Zone
                     <span class="small">Add TimeZone</span>
                     </label>
                     </td>
                     <td>
                      <input type="text" value="<?=isset($time_zone)?$time_zone:""?>" name="time_zone" placeholder="Enter your timezone">                   
                    </td>
                  </tr>
                  <!--  <tr>
                      <td>
                      <label>Allow Capcha:
                     <span class="small">Please check where you want to show capcha.</span>
                     </label>
                     </td>
                     <td>
                      <label style="text-align:left;">
                      <input type="checkbox" <?=@($allow_capcha->register==1)?'checked="checked"':''?> value="1" name="allow_capcha[register]" id="allow_reg_log"> Registr
                     </label>    
                      <label style="text-align:left;">
                      <input type="checkbox" <?=@($allow_capcha->login==1)?'checked="checked"':''?> value="1" name="allow_capcha[login]" id="allow_reg_log"> Login
                     </label>  
                      <label style="text-align:left;">
                      <input type="checkbox" <?=@($allow_capcha->forget==1)?'checked="checked"':''?> value="1" name="allow_capcha[forget]" id="allow_reg_log"> Forget Password
                     </label>  
                      <label style="text-align:left;">
                      <input type="checkbox" <?=@($allow_capcha->contact==1)?'checked="checked"':''?> value="1" name="allow_capcha[contact]" id="allow_reg_log"> Contact Us.
                     </label>                               
                    </td>
                  </tr> -->
                  <tr>
                      <td>
                   
                     </td>
                     <td>
                       <label style="text-align:left;">
                      <input type="checkbox" <?=($allow_reg_log==1)?'checked="checked"':''?> value="1" name="allow_reg_log" id="allow_reg_log"> Allow Site Map.
                     </label>                                 
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

