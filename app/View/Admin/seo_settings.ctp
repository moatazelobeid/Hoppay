<?php $data=isset($seo_info)?$seo_info:""; 
       //print_r($data['User']);
       @ extract($data['Seo_setting']);
        
    ?>
    <style type="text/css">
    #stylized label {
    display: block;
    font-weight: bold;
    text-align: left;

    width: 96%;
    float: left;
    }
    </style>
   <script>
    $(function(){
    //$(".tab_content").hide(); //Hide all content
    $("ul.tabs li").removeClass('active');
    $("ul.tabs li:nth-child(4)").addClass("active").show();

    $('#allow_meta_key').change(function(){
      if($(this).is(':checked')){
        $('#meta_key').removeAttr('disabled');
      }
      else
      {
        $('#meta_key').attr('disabled','disabled');
      }

    })
     $('#allow_meta_desc').change(function(){
      if($(this).is(':checked')){
        $('#meta_desc').removeAttr('disabled');
      }
      else
      {
        $('#meta_desc').attr('disabled','disabled');
      }

    })
      $('#allow_google_analitics').change(function(){
      if($(this).is(':checked')){
        $('#google_analitics').removeAttr('disabled');
      }
      else
      {
        $('#google_analitics').attr('disabled','disabled');
      }

    })
       $('#allow_site_map').change(function(){
      if($(this).is(':checked')){
        $('#site_map_path').removeAttr('disabled');
      }
      else
      {
        $('#site_map_path').attr('disabled','disabled');
      }

    })
    })
    </script>
    <?=$this->Session->flash('bad')?> 
    <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> User</h3>
      <ul class="tabs">
        <li><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
        <li><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
        <li><a href="<?=$this->webroot?>admin/tagline">TagLine</a></li>
        <li><a href="#tab1">Seo</a></li>
        <li><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
        <li><a href="<?=$this->webroot?>admin/language_settings">language</a></li>
      </ul>
      </header>
     <style>
     #stylized table tr td textarea{
      width: 75%;
     }
     </style>
        <div class="tab_container">   
        <div id="tab1" class="tab_content">    
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table>
                  <tr>
                    <td width="0">
                   
                    </td>

                    <td>
                    <label> 
                    <input type="checkbox" value="1" <?=($allow_meta_key==1)?'checked="checked"':''?> name="allow_meta_key" id="allow_meta_key"> Allow meta Keyword.
                   </label><br>
                   <textarea name="meta_key" <?=($allow_meta_key==1)?'':'disabled="disabled"'?> id="meta_key"><?=isset($meta_key)?$meta_key:""?></textarea>
                    </td>
                 </tr>
                 <tr>
                    <td>
                    
                   </td>
                    <td>
                       <label> 
                    <input type="checkbox" <?=($allow_meta_desc==1)?'checked="checked"':''?>  value="1" name="allow_meta_desc" id="allow_meta_desc"> Allow meta Description.
                   </label>
                      <textarea name="meta_desc" <?=($allow_meta_desc==1)?'':'disabled="disabled"'?> id="meta_desc"><?=isset($meta_desc)?$meta_desc:""?></textarea>                    
                  </td>
                  </tr>
                    <tr>
                      <td>
                   
                    </td>
                    <td>
                     <label> 
                    <input type="checkbox" <?=($allow_robert==1)?'checked="checked"':''?> value="1" name="allow_robert"> Allow Rrobert.txt.
                   </label>
                    </td>
                    </tr>
                 <tr>
                  <td>
                    
                   </td>
                   <td>
                     <label> 
                    <input type="checkbox" <?=($allow_canonikal_url==1)?'checked="checked"':''?> value="1" name="allow_canonikal_url"> Allow Canonical url.
                   </label>
                   </td>
                  </tr>
                  
                  <tr>
                    <td>
                   
                     </td>
                     <td>
                    <label> 
                    <input type="checkbox" <?=($allow_opengraph_setting==1)?'checked="checked"':''?> value="1" name="allow_opengraph_setting"> Allow Opengraph Setting.
                   </label>
                    </td>
                  </tr>
                                     
                    <tr>
                      <td>
                   
                     </td>
                     <td>
                     <label> 
                    <input type="checkbox" <?=($allow_google_analitics==1)?'checked="checked"':''?> value="1" name="allow_google_analitics" id="allow_google_analitics"> Allow Google Analitics.
                   </label>
                      <textarea name="google_analitics" <?=($allow_google_analitics==1)?'':'disabled="disabled"'?> id="google_analitics"><?=isset($google_analitics)?$google_analitics:""?></textarea>
                    </td>
                  </tr>
                   <tr>
                      <td>
                   
                     </td>
                     <td>
                     <label> 
                    <input type="checkbox" <?=($allow_site_map==1)?'checked="checked"':''?> value="1" name="allow_site_map" id="allow_site_map"> Allow Site Map.
                   </label>
                   <?php if(!empty($site_map_path)) {?>
                   <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$this->webroot?><?=isset($site_map_path)?$site_map_path:""?>">View the XML file</a></p>
                   <?php } ?>
                      <input type="file" name="site_map_path" <?=($allow_site_map==1)?'':'disabled="disabled"'?> id="site_map_path">
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

