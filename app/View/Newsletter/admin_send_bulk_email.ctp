
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
        
     <?php //print_r($user_list);?>   
        
 <article class="module width_full">
      <header><h3><?=$admin_button?> Bulk Email</h3>
      <?php /*?><a href="<?=$this->webroot?>admin/newsletter/email_template" class="heading_link">View Lists</a><?php */?>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
             
              <form method="post" action="" enctype="multipart/form-data"> 
                <table>
                    <tr>
                      <td>
                    <label>Select Group </label>
                     </td>
                     <td>
                    <select name="group" requred onchange="selectEmail(this.value);">
                      <option value="1">All</option>
                      <option value="2">Users (<?php echo count($user_list);?>)</option>
                      <option value="3">Merchant (<?php echo count($merchant_list);?>)</option>
                    </select>
                    </td>
                  </tr>
                    <tr style="display:none;" id="user_list">
                      <td>
                    <label>Select User </label>
                     </td>
                     <td>
                    <select name="user_id[]" multiple="multiple" requred onchange="selectUser(this.value);">
                      <option value="All">All</option>
                      <?php
					  if(!empty($user_list))
					  {
							foreach($user_list as $user_email)
							{
								?>
                                <option value="<?php echo $user_email['Newsletter']['email_id'];?>"><?php echo $user_email['Newsletter']['email_id'];?></option>
                                <?php 	
							}  
					  }
					  ?>
                    </select>
                    </td>
                  </tr>
                    <tr style="display:none;" id="merchant_list">
                      <td>
                    <label>Select Merchant </label>
                     </td>
                     <td>
                    <select name="merchant_id[]" multiple="multiple" requred onchange="selectMerchant(this.value);">
                      <option value="All">All</option>
                      <?php
					  if(!empty($merchant_list))
					  {
							foreach($merchant_list as $merchant_email)
							{
								?>
                                <option value="<?php echo $merchant_email['Newsletter']['email_id'];?>"><?php echo $merchant_email['Newsletter']['email_id'];?></option>
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
                    <input type="text" required name="email_subject" placeholder="Enter Email Subject." />
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
                    echo $this->Fck->fckeditor(array('email_body'), $this->html->base, ""); 
                   
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
                                <option value="<?php echo $email_template['Email_template']['id'];?>"><?php echo $email_template['Email_template']['email_type'];?></option>
                                <?php 	
							}  
					  }
					  ?>
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

