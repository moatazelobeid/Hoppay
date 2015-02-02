 <?php $data=isset($banner_data)?$banner_data:""; 
       //print_r($lang);
       @extract($data);
       @extract($data['Banner']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
       if(isset($Banner_lang))
       {
        foreach($Banner_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Banner_lang=$val;
          }
        }
      }


    ?>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Banner</h3>
      <a href="<?=$this->webroot?>admin/banner_manager" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" >
             <?php if(isset($id)){ ?>
        <form>
           <table>
                  <tr>
                    <td>
                   <label>Choose Language
                     <span class="small">Select Language</span>
                   </label>
                    </td>
                    <td>
                   

                      <select name="lang_id" onchange="this.form.submit();" style="width: 185px;">
                        <?php 
                        foreach($lang as $val){ ?>
                        <option value="<?=$val['Language']['id']?>" <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?>><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>)</option>
                       <?php } 
                        ?>
                      </select>
                      </td>
                  </tr>
                </table>
              </form>
         <?php } 
         else
           { ?>
            <form>
                <table>
                    <tr>
                      <td>
                     <label>Choose Language
                       <span class="small">Select Language</span>
                     </label>
                      </td>
                      <td>
             <select name="lang_id" disabled="disabled" onchange="this.form.submit();" style="width: 185px;">
                <option value="1" readonly="readonly">English</option>
             </select>
              </td>
                    </tr>
                  </table>
                </form>
         <?php  }
            ?>
              <form method="post" class="validate" name="Image" enctype="multipart/form-data" action=""> 
                <input type="hidden" name="lang_id" value="<?=$lang_id?>"?>
                <input type="hidden" name="banner_lang_id" value="<?=@$Banner_lang['id']?>"?>
                <table>
                  <tr>
                    <td>
                   <label>Banner Title:
                     <span class="small">Add Banner Title</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="banner_title" placeholder="Enter Banner Title." value="<?=isset($Banner_lang['banner_title'])?$Banner_lang['banner_title']:""?>">
                  </td>
                 </tr>
                 <tr>
                  <td>
                 <label>Banner Description:
                     <span class="small">Add Description</span>
                   </label>
                   </td>
                    <td>
                    <style>
                      iframe{
                        border-bottom: 1px solid #000 !important;
                        border-radius:5px;
                        margin-bottom: 5px !important;
                        margin-top: 5px !important;
                      }
                    </style>
                    <?php
                    echo $this->Fck->fckeditor(array('banner_description'), $this->html->base, isset($Banner_lang['banner_description'])?htmlspecialchars_decode($Banner_lang['banner_description']):""); 
                   
                    ?>
                  </td>
                   </tr>
                  <?php /*?> <tr>
                    <td>
                    <label>Banner Link URL:
                     <span class="small">Add Banner Link URL (Ex: http://xyz.com)</span>
                   </label>
                   </td>
                    <td>
                    <input type="url" required name="blink" placeholder="Enter Banner Link URL." value="<?=isset($banner_link)?$banner_link:""?>">
                    </td>
                  </tr><?php */ ?>
                    <?php if(isset($banner_img) and $banner_img!=""){ ?>
                        <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image.</span>
                        </label>  
                        </td>
                        <td>
                         
                        <img src="<?=isset($banner_img)?$this->webroot.$banner_img:""?>" style="height:100px"/>
                        </td>
                        </tr>
                    <?php } ?>
                 
                    <tr>
                      <td>
                    <label>Banner Image (Landscape)
                     <span class="small">Landscape image</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($banner_img)?'':'required'?> name="bimage" placeholder="Choose image">     
                  </td>
                   </tr>
                    <?php if(isset($banner_img_port) and $banner_img_port!=""){ ?>
                        <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image.</span>
                        </label>  
                        </td>
                        <td>
                         
                        <img src="<?=isset($banner_img_port)?$this->webroot.$banner_img_port:""?>" style="height:100px"/>
                        </td>
                        </tr>
                    <?php } ?>
                     <tr>
                      <td>
                    <label>Banner Image (Portrait)
                     <span class="small">Portrait image</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($banner_img_port)?'':'required'?> name="bimage_port" placeholder="Choose image">     
                  </td>
                   </tr>
                  <tr>
                    <td>
                    <label>status
                     <span class="small">Choose Status</span>
                     </label>
                   </td>
                   <td>
                    <select name="bstatus" requred>
                      <option value="1" <?php if(isset($status) && $status==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($status) && $status==0){ echo "selected='selected'";} ?>>Inactive</option>
                    </select>
                  </td>
                 </tr>
                 <tr>
                  <td></td>
                    <td>
            <button type="submit" name=""><?=$admin_button?></button>
                  </td>
                 </tr>

         
               
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       
     </div>
    </article><!-- end of post new article -->

