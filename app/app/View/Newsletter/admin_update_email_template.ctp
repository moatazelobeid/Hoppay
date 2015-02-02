
   <?php $data=isset($page_data)?$page_data:""; 
       //print_r($lang);
       @extract($data);
       @extract($data['Page']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
       if(isset($Page_lang))
       {
         //print_r($Page_lang);
        foreach($Page_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Page_lang=$val;
          }
          else
          {
            $Page_lang="";
          }
        }
      }
     // print_r($Page_lang);
    ?>
    

    <?php /*?><div style="margin: 20px 3% 0 3%;">
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter">Subscriber List</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/email_template">Manage Email Template</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/send_bulk_email">Send Bulk Email</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/set_schedule_email">Set Scheduled Email</a>
    </div><?php */?>
   
    
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Email Template</h3>
      <a href="<?=$this->webroot?>admin/newsletter/email_template" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
             
              <form method="post" action="" enctype="multipart/form-data"> 
                
                 <input type="hidden" name="id" value="<?=$temp_data['id']?>"/>
                <table>
                  <tr>
                    <td>
                   <label>Title
                     <span class="small">Add Title.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="email_type" placeholder="Enter Title." value="<?=isset($temp_data['email_type'])?$temp_data['email_type']:""?>" />
                    </td>
                 </tr>
                 
                  <tr>
                    <td>
                   <label>Email Subject
                     <span class="small">Add Email Subject.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="email_subject" placeholder="Enter Email Subject." value="<?=isset($temp_data['email_subject'])?$temp_data['email_subject']:""?>">
                    </td>
                 </tr>
                 
                  <tr>
                    <td>
                    <label>Email Content Editor  
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
                    echo $this->Fck->fckeditor(array('email_body'), $this->html->base, isset($temp_data['email_body'])?htmlspecialchars_decode($temp_data['email_body']):""); 
                   
                    ?>
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
                      <option value="1" <?php if(isset($temp_data['status']) && $temp_data['status']==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($temp_data['status']) && $temp_data['status']==0){ echo "selected='selected'";} ?>>Inactive</option>
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

