<?php $data=isset($faq_data)?$faq_data:""; 
       //print_r($lang);
       @extract($data);
       @extract($data['Faq']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
       if(isset($Faq_lang))
       {
        foreach($Faq_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Faq_lang=$val;
          }
        }
      }
    ?>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> FAQ</h3>
      <a href="<?=$this->webroot?>admin/faq_manager" class="heading_link">View Lists</a>
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
                 <input type="hidden" name="faq_lang_id" value="<?=@$Faq_lang['id']?>"/>
                <table>
                  <tr>
                    <td>
                   <label>Question:
                     <span class="small">Add Question Here.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="question" placeholder="Enter Question here." value="<?=isset($Faq_lang['question'])?$Faq_lang['question']:""?>">
                  </td>
                 </tr>
                 <tr>
                  <td>
                 <label>Answer:
                     <span class="small">Add Answer.</span>
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
                    echo $this->Fck->fckeditor(array('answer'), $this->html->base, isset($Faq_lang['answer'])?htmlspecialchars_decode($Faq_lang['answer']):""); 
                   
                    ?>
                  </td>
                   </tr>
                   <tr>
                    <td>
                    <label>Category:
                     <span class="small">Choose category here</span>
                   </label>
                   </td>
                    <td>
                      <?php //print_r($faq_cat_names)?>
                     <select name="category_id" required>
                       <option value="">Choose Parent</option>
                      <?php 
                      foreach ($faq_cat_names as $key => $value) { ?>
                        <option value="<?=$value['Faq_category']['id']?>"  <?php echo $this->Template->Select($value['Faq_category']['id'],isset($category_id)?$category_id:"");?>><?=$value['Faq_category_lang']['category_name']?></option>
                    <?php  } 
                      ?>
                    </select>
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

