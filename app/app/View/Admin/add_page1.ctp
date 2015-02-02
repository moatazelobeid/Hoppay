<?php $data=isset($page_data)?$page_data:""; 
       //print_r($data['User']);
       @ extract($data['Page']);
        
    ?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Page</h3>
      <a href="<?=$this->webroot?>admin/page_manager" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action="" enctype="multipart/form-data"> 
                <table>
                  <tr>
                    <td>
                   <label>Title
                     <span class="small">Add Page Title.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="pg_title" placeholder="Enter Page Title." value="<?=isset($pg_title)?$pg_title:""?>">
                    </td>
                 </tr>
                 <tr>
                  <td>
                    <label>Meta Keywords:
                     <span class="small">Enter Key words. Ex. (abc, xxx, yyy)</span>
                   </label>
                   </td>
                   <td>
                    <textarea name="pg_keyword"><?=isset($pg_keyword)?$pg_keyword:""?></textarea>
                    
                  </td>
                  </tr>
                  <tr>
                    <td>
                    <label>Meta Descriptions
                     <span class="small">Add Meta Description</span>
                   </label>
                   </td>
                    <td>
                     <textarea name="pg_desp"><?=isset($pg_desp)?$pg_desp:""?></textarea>
                  </td>
                  </tr>
                  <tr>
                    <td>
                    <label>Page Content Editor  
                     <span class="small">(Use it carefully)</span>
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
                    echo $this->Fck->fckeditor(array('pg_detail'), $this->html->base, isset($pg_detail)?$pg_detail:""); 
                   
                    ?>
                    </td>
                  </tr>
                    <tr>
                      <td>
                    <label>Choose Template Page
                     <span class="small">Select Template Page.</span>
                    </label>
                    </td>
                    <td>
                      <?php  $tempalate_name=$this->Template->getTemplateFilename();                         
                      ?>
                       <select name="page_template" requred>
                        <option value="">-- Choose Template --</option>
                         <?php foreach($tempalate_name as $val){ ?>
                      <option value="<?=$val['Tfile']?>" <?php if(isset($page_template) && ($page_template==$val['Tfile'])){ echo "selected='selected'";} ?>><?=$val['Tname']?></option>
                      <?php } ?>
                      </select>
                    </td>
                    </tr>
                    
                       <?php if(isset($pg_img) and $pg_img!=""){ ?>
                       <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image</span>
                        </label>  
                        </td>
                        <td>
                        <img src="<?=isset($pg_img)?$this->webroot.'uploads/page/'.$pg_img:""?>" style="height:100px"/>
                        </td>
                        </tr>
                    <?php } ?>

                    
               <tr>
                    <td>
                      <label>Image
                     <span class="small">Upload Image For this page.</span>
                     </label>
                    </td>
                    <td>
                      <input type="file" name="pg_img" placeholder="Choose Image For the Page">
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
                    <td>
                </tr>
         
               </table>
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       
     </div>
    </article><!-- end of post new article -->

