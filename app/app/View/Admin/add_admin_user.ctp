<?php $data=isset($user_data)?$user_data:""; 
       //print_r($data['User']);
       @ extract($data['User']);
        
    ?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> User</h3>
      <a href="<?=$this->webroot?>admin/adminUser" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action=""> 
                   <table>
                  <tr>
                    <td>
                   <label>Name
                     <span class="small">Add name</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="uname" placeholder="Enter your Name." value="<?=isset($name)?$name:""?>">
                    </td>
                 </tr>
                 <tr>
                    <td>
                    <label>Email
                     <span class="small">Add Email-id</span>
                   </label>
                   </td>
                    <td>
                    <input type="email" value="<?=isset($email)?$email:""?>" required name="email" placeholder="Enter your Email-ID.">
                  </td>
                  </tr>
                    <tr>
                      <td>
                    <label>Phone
                     <span class="small">Add Phone number.</span>
                    </label>
                    </td>
                      <td>
                    <input type="number" value="<?=isset($phone)?$phone:""?>" required name="phone"  placeholder="Enter your Phone Number.">
                    </td>
                    </tr>
                 <tr>
                  <td>
                    <label>Username
                     <span class="small">Add Username</span>
                   </label>
                   </td>
                   <td>
                    <input type="text" value="<?=isset($username)?$username:""?>" required name="username" placeholder="Username">
                  </td>
                  </tr>
                  
                  <tr>
                    <td>
                    <label>Password
                     <span class="small">Add Password</span>
                     </label>
                     </td>
                     <td>
                    <input type="password"  value="<?=isset($password)?base64_decode($password):""?>" required name="password" placeholder="Password">
                    </td>
                  </tr>
                                     
                    <tr>
                      <td>
                    <label>status
                     <span class="small">Choose Status</span>
                     </label>
                     </td>
                     <td>
                    <select name="user_status" requred>
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

