
<script type="text/javascript">
function selectEmail(val)
{
	if(val == 1)
	{
		$('#user_list').hide();	
		$('#merchant_list').hide();	
	}
	if(val == 2)
	{
		$('#user_list').show();	
		$('#merchant_list').hide();	
	}
	if(val == 3)
	{
		$('#user_list').hide();	
		$('#merchant_list').show();	
	}
}

function selectUser(val)
{
	//alert(val);	
}
</script>

    <div style="margin: 20px 3% 0 3%;">
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter">Subscriber List</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/email_template">Manage Email Template</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/send_bulk_email">Send Bulk Email</a>
        <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/set_schedule_email">Set Scheduled Email</a>
    </div>
   
    
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
        
     <?php //print_r($user_list);
	 
	 $email_id_list = explode(', ',$semail_data['email_id']);
	 ?>   
        
 <article class="module width_full">
      <header><h3><?=$admin_button?> Schedule Email</h3>
      <a href="<?=$this->webroot?>admin/newsletter/schedule_email_list" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
             
              <form method="post" action="" enctype="multipart/form-data"> 
			  <input type="hidden" name="id" value="<?php echo $semail_data['id'];?>" />
                <table>
                    <tr>
                      <td>
                    <label>Select Group </label>
                     </td>
                     <td>
                    <select name="group" requred onchange="selectEmail(this.value);">
                      <option value="1" <?php if($semail_data['user_group']=='1'){ echo "selected='selected'";} ?>>All</option>
                      <option value="2" <?php if($semail_data['user_group']=='2'){ echo "selected='selected'";} ?>>Users (<?php echo count($user_list);?>)</option>
                      <option value="3" <?php if($semail_data['user_group']=='3'){ echo "selected='selected'";} ?>>Merchant (<?php echo count($merchant_list);?>)</option>
                    </select>
                    </td>
                  </tr>
                    <tr <?php if($semail_data['user_group']!='2'){?>style="display:none;"<?php }?> id="user_list">
                      <td>
                    <label>Select User </label>
                     </td>
                     <td>
                    <select name="user_id[]" multiple="multiple" requred onchange="selectUser(this.value);">
                      <option value="All" <?php if($semail_data['email_id']=='All'){ echo "selected='selected'";} ?>>All</option>
                      <?php
					  if(!empty($user_list))
					  {
							foreach($user_list as $user_email)
							{
								?>
                                <option value="<?php echo $user_email['Newsletter']['email_id'];?>" 
								<?php if(!empty($email_id_list) && in_array($user_email['Newsletter']['email_id'],$email_id_list)){echo "selected='selected'";}?>>
								<?php echo $user_email['Newsletter']['email_id'];?></option>
                                <?php 	
							}  
					  }
					  ?>
                    </select>
                    </td>
                  </tr>
                    <tr <?php if($semail_data['user_group']!='3'){?>style="display:none;"<?php }?> id="merchant_list">
                      <td>
                    <label>Select Merchant </label>
                     </td>
                     <td>
                    <select name="merchant_id[]" multiple="multiple" requred onchange="selectMerchant(this.value);">
                      <option value="All" <?php if($semail_data['email_id']=='All'){ echo "selected='selected'";} ?>>All</option>
                      <?php
					  if(!empty($merchant_list))
					  {
							foreach($merchant_list as $merchant_email)
							{
								?>
                                <option value="<?php echo $merchant_email['Newsletter']['email_id'];?>"  
								<?php if(!empty($email_id_list) && in_array($merchant_email['Newsletter']['email_id'],$email_id_list)){echo "selected='selected'";}?>>
								<?php echo $merchant_email['Newsletter']['email_id'];?></option>
                                <?php 	
							}  
					  }
					  ?>
                    </select>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>
                   <label>Email Subject
                     <span class="small">Enter Email Subject.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="email_subject" placeholder="Enter Email Subject." value="<?=isset($semail_data['email_subject'])?$semail_data['email_subject']:""?>" />
                    </td>
                 </tr>
                 
                  <tr>
                    <td>
                    <label>Email Content  
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
                    echo $this->Fck->fckeditor(array('email_body'), $this->html->base, $semail_data['email_body']); 
                   
                    ?>
                    </td>
                  </tr>
                    <tr>
                      <td>
                    <label>Select Email Template </label>
                     </td>
                     <td>
                    <select name="email_temp" requred >
                      <option value=""> - Select - </option>
                      <?php
					  if(!empty($email_templates))
					  {
							foreach($email_templates as $email_template)
							{
								?>
                                <option value="<?php echo $email_template['Email_template']['id'];?>" <?php if($semail_data['email_temp']==$email_template['Email_template']['id']){ echo "selected='selected'";} ?>>
								<?php echo $email_template['Email_template']['email_type'];?>
                                </option>
                                <?php 	
							}  
					  }
					  ?>
                    </select>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>
                   <label>Schedule Time
                     <span class="small">( dd-mm-yyyy H:i )</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="schedule_time" placeholder="Enter Schedule Time." style="width: 200px;" value="<?=isset($semail_data['schedule_time'])?$semail_data['schedule_time']:""?>" />
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
                      <option value="1" <?php if($semail_data['status']=='1'){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if($semail_data['status']=='0'){ echo "selected='selected'";} ?>>Inactive</option>
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

