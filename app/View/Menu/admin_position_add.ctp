<?php $data=isset($menu_position_data)?$menu_position_data:""; 
       //print_r($data['User']);
       @ extract($data['Menu_position']);
        
    ?>     <script type="text/javascript">       $(function(){
$("#title").keyup(function(){           var Text = $(this).val();
Text = Text.toLowerCase();           Text =
Text.replace(/[^a-zA-Z0-9]+/g,'-');           $("#slug").val(Text);
});       })
    

    </script>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Menu Positions</h3>
      <a href="<?=$this->webroot?>admin/menu/position/list" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" >
              <form method="post" name="Image" enctype="multipart/form-data" action=""> 
                <table>
                  <tr>
                    <td>
                   <label>Title:
                     <span class="small">Add Title</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="title" id="title" placeholder="Enter Menu Posotion Title." value="<?=isset($title)?$title:""?>">
                  </td>
                 </tr>
                   <tr>
                    <td>
                    <label>Slug
                     <span class="small">Add slugs</span>
                   </label>
                   </td>
                    <td>
                    <input type="text" required name="slug" id="slug" placeholder="Enter slug here." value="<?=isset($slug)?$slug:""?>">
                    
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

