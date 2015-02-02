<?php $data=isset($brand_data)?$brand_data:""; 
       //print_r($lang);
       @extract($data);
       @extract($data['Product_brand']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
       if(isset($Product_brand_lang))
       {
        foreach($Product_brand_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Product_brand_lang=$val;
          }
        }
      }
    ?>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Brand</h3>
      <a href="<?=$this->webroot?>admin/Product_brand" class="heading_link">View Lists</a>
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
              <form method="post" name="Image" enctype="multipart/form-data" action=""> 
                   <input type="hidden" name="lang_id" value="<?=$lang_id?>"/>
                   <input type="hidden" name="brand_lang_id" value="<?=@$Product_brand_lang['id']?>"/>
                <table>
                  <tr>
                    <td>
                   <label>Brand Name:
                     <span class="small">Add Brand Name.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="brand_title" placeholder="Enter brand name here" value="<?=isset($Product_brand_lang['brand_title'])?$Product_brand_lang['brand_title']:""?>">
                  </td>
                 </tr>
                 <tr>
                  <td>
                 <label>Descriptions:
                     <span class="small">Add Brand Descriptions.</span>
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
                    echo $this->Fck->fckeditor(array('description'), $this->html->base, isset($Product_brand_lang['description'])?htmlspecialchars_decode($Product_brand_lang['description']):""); 
                   
                    ?>
                  </td>
                   </tr>               
                      <?php if(isset($image_url) and $image_url!=""){ ?>
                        <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image.</span>
                        </label>  
                        </td>
                        <td>
                         
                        <img src="<?=isset($image_url)?$this->webroot.$image_url:""?>" style="height:100px"/>
                        </td>
                        </tr>
                    <?php } ?>
                 
                    <tr>
                      <td>
                    <label>Brand Image
                     <span class="small">Add Brand Image</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($image_url)?'':''?> name="image_url" placeholder="Choose image">     
                  </td>
                   </tr>
                    <tr>
                  <td>
                 <label>Meta Description:
                     <span class="small">Add Meta Description.</span>
                   </label>
                   </td>
                    <td>
                   
                    <textarea name="meta_description"><?=isset($Product_brand_lang['meta_description'])?$Product_brand_lang['meta_description']:""?></textarea>
                  </td>
                   </tr>
                  
                     <tr>
                  <td>
                 <label>Meta Keyword:
                     <span class="small">Add Meta Keyword.</span>
                   </label>
                   </td>
                    <td>
                   
                    <textarea name="meta_keyword"><?=isset($Product_brand_lang['meta_description'])?$Product_brand_lang['meta_keyword']:""?></textarea>
                  </td>
                   </tr>
                  <tr>
                    <td>
                    <label>status
                     <span class="small">Choose Status</span>
                     </label>
                   </td>
                   <td>
                    <select name="status" requred>
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

