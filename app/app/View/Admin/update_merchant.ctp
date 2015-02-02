<?php $data=isset($user_data)?$user_data:""; 
       //print_r($data['User']);
       @ extract($data['Profile']);
        
    ?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Merchant</h3>
      <a href="<?=$this->webroot?>admin/merchants" class="heading_link">View Lists</a>
      </header>
     <style type="text/css">
     #stylized input, #stylized select, #stylized textarea, #stylized iframe {

         width: 50%;
      }
     </style>
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action=""  enctype="multipart/form-data"> 
      <input type="hidden" value="<?=isset($data['Merchant_login']['id'])?$data['Merchant_login']['id']:""?>" name="profile_id" >
                   <table>
                  <tr>
                    <td width="150">
                   <label>First Name
                     <span class="small">Add First name</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="first_name" placeholder="Enter first name." value="<?=isset($first_name)?$first_name:""?>">
                    </td>
                 </tr>
                   <tr>
                    <td>
                   <label>Last Name
                     <span class="small">Add Last name</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="last_name" placeholder="Enter last name." value="<?=isset($last_name)?$last_name:""?>">
                    </td>
                 </tr>
                 <tr>
                    <td>
                    <label>Email
                     <span class="small">Add Email-id</span>
                   </label>
                   </td>
                    <td>
                    <input type="email" value="<?=isset($data['Merchant_login']['email_id'])?$data['Merchant_login']['email_id']:""?>" required name="email_id" placeholder="Enter  Email-ID.">
                  </td>
                  </tr>
                    <tr>
                      <td>
                    <label>Phone
                     <span class="small">Add Phone number.</span>
                    </label>
                    </td>
                      <td>
                    <input type="disits" value="<?=isset($phone)?$phone:""?>" required name="phone"  placeholder="Enter Phone Number.">
                    </td>
                    </tr>
                 <tr>
                  <td>
                    <label>Username
                     <span class="small">Add Username</span>
                   </label>
                   </td>
                   <td>
                    <input type="text" value="<?=isset($data['Merchant_login']['username'])?$data['Merchant_login']['username']:""?>" required name="username" placeholder="Username">
                  </td>
                  </tr>
                  
                  <tr>
                    <td>
                    <label>URL
                     <span class="small">Add URL</span>
                     </label>
                     </td>
                     <td>
                   <input type="url"  value="<?=isset($url)?$url:""?>" required name="url" placeholder="Url">
                    </td>
                  </tr>
                     <tr>
                    <td>
                    <label>Website Name
                     <span class="small">Add URL</span>
                     </label>
                     </td>
                     <td>
                   <input type="text"  value="<?=isset($website_name)?$website_name:""?>" required name="website_name" placeholder="website_name">
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
                        <input type="hidden" name="updateImage" value="<?=isset($image_url)?$image_url:""?>">
                        </td>
                        </tr>
                    <?php } ?>
                 
                    <tr>
                      <td>
                    <label>Merchant Image
                     <span class="small">Add Banner Image</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($image_url)?'':'required'?> name="image_url" placeholder="Choose image">     
                  </td>
                   </tr>
                     <tr>
                    <td>
                    <label>Address
                     <span class="small">Add address</span>
                     </label>
                     </td>
                     <td>
                   <input type="text"  value="<?=isset($adress)?$adress:""?>" required name="adress" placeholder="address">
                    </td>
                  </tr>   
                    <tr>
                    <td>
                    <label>City
                     <span class="small">Add City</span>
                     </label>
                     </td>
                     <td>
                   <input type="text"  value="<?=isset($city)?$city:""?>" required name="city" placeholder="city">
                    </td>
                  </tr>        
                   <tr>
                    <td>
                    <label>State
                     <span class="small">Add State</span>
                     </label>
                     </td>
                     <td>
                   <input type="text"  value="<?=isset($state)?$state:""?>" required name="state" placeholder="state">
                    </td>
                  </tr>               
                   <tr>
                    <td>
                    <label>Zip Code
                     <span class="small">Add Zip Code</span>
                     </label>
                     </td>
                     <td>
                   <input type="desits"  value="<?=isset($zip_code)?$zip_code:""?>" required name="zip_code" placeholder="Zip Code">
                    </td>
                  </tr>      
                     <tr>
                    <td>
                    <label>Country
                     <span class="small">Add Country</span>
                     </label>
                     </td>
                     <td>
                   <input type="text"  value="<?=isset($country)?$country:""?>" required name="country" placeholder="Country">
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
                      <option value="1" <?php if(isset($data['Merchant_login']['status']) && $data['Merchant_login']['status']==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($data['Merchant_login']['status']) && $data['Merchant_login']['status']==0){ echo "selected='selected'";} ?>>Inactive</option>
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

