<?php $data=isset($user_data)?$user_data:""; 
       //print_r($data['User']);
       @ extract($data['User']);
        
    ?>
    <script>
    $(function(){
    //$(".tab_content").hide(); //Hide all content
    $("ul.tabs li").removeClass('active');
    $("ul.tabs li:nth-child(5)").addClass("active").show();
    var i=1;
    $('#click_toadd').click(function(){
      $('#add_items').append('<tr id="close_icon'+i+'"><td><input type="text" required name="title[]" placeholder="Enter social Name" value=""></td><td><input type="file" required name="image[]" placeholder="Enter Language Name" value=""></td><td><img src="" height="20px"></td><td><input type="text" required name="link_slide[]" placeholder="Enter social link" value=""></td><td><input type="text" required name="social_order[]" style=" width: 30px !important;" placeholder="Enter order" value=""></td><td><select name="status[]" requred><option value="1">Active</option><option value="0">Inactive</option></select></td><td><a href="javascript:void(0)" class="close_icon '+i+'"></a></td></tr>');
        i++;
        $('.close_icon').click(function(){
          var p=$(this).attr('class');
          var arr=p.split(" ");
          var id='#'+arr[0]+arr[1];
          $(id).remove();
          i--;
        })
    })


    })
    </script>
    <!--<input type="image" src="<?=$this->webroot?>images/table/table_icon_2.gif" title="Trash">-->
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Social Links</h3>
      <ul class="tabs">
        <li><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
        <li><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
        <li><a href="<?=$this->webroot?>admin/tagline">TagLine</a></li>
        <?php /*?><li><a href="<?=$this->webroot?>admin/seo_settings">Seo</a></li><?php */?>
        <li><a href="#tab1">Social</a></li>
        <li><a href="<?=$this->webroot?>admin/language_settings">language</a></li>
      </ul>
      </header>
     
        <div class="tab_container">   
        <div id="tab1" class="tab_content tab_form">    
          <div id="stylized" class="myform" style="width:100%">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table class="tablesorter" wisth="100%" style="font-size: 12px;" cellspacing="0">
                  <thead> 
                    <tr>
                      <th><?=$this->Paginator->sort('title', 'Title')?></th>
                      <th colspan="2">Social Icon</th>
                      <th>Link</th>
                      <th ><?=$this->Paginator->sort('social_order', 'Order')?></th>
                      <th width="80">Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="add_items">
                     <?php if(count($social_info)<=0){ ?>
                  <tr>
                  

                    <td>
                    <input type="text" required name="title[]" placeholder="Enter social Name" value="<?=isset($title)?$title:""?>">
                    </td>                    
                    <td>
                    <input type="file" required name="image[]" placeholder="Enter Language Name" value="">
                    </td>
                    <td><img src="" height="20px"></td>
                    <td>
                    <input type="url" required name="link_slide[]" placeholder="Enter social link" value="<?=isset($link_slide)?$link_slide:""?>">
                    </td>
                    <td>
                    <input type="text" required name="social_order[]" placeholder="Enter order" style=" width: 30px !important;" value="<?=isset($social_order)?$social_order:""?>">
                    </td>
                    <td>
                    <select name="status[]" requred>
                      <option value="1" <?php if(isset($status) && $status==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($status) && $status==0){ echo "selected='selected'";} ?>>Inactive</option>
                    </select>
                    </td>
                    
                    <td><a href="<?=$this->webroot?>admin/delete_lang/<!--?=//$val['Banner']['id'];?-->">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> 
                 </tr>
                 <?php } else { 

                    foreach($social_info as $k=>$v){
                    extract($v['Social_setting']);
                  ?>
                     <tr>            
                    <input type="hidden" name="id[]" value="<?=isset($id)?$id:""?>" />
                    <td>
                    <input type="text" required name="title[]" placeholder="Enter social Name" value="<?=isset($title)?$title:""?>">
                    </td>                    
                    <td>
                    <input type="file"  name="image[]" value="">
                    </td>
                    <td><img src="<?=$this->webroot?><?=isset($image)?$image:""?>" height="20px"></td>
                    <td>
                    <input type="url" required name="link_slide[]" placeholder="Enter social link" value="<?=isset($link_slide)?$link_slide:""?>">
                    </td>
                    <td>
                    <input type="text" required name="social_order[]" placeholder="Enter order" style=" width: 30px !important;" value="<?=isset($social_order)?$social_order:""?>">
                    </td>
                    <td>
                    <select name="status[]" requred>
                      <option value="1" <?php if(isset($status) && $status==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($status) && $status==0){ echo "selected='selected'";} ?>>Inactive</option>
                    </select>
                    </td>
                    
                    <td><a  onclick="deleteAction('<?=$this->webroot?>admin/delete_social/<?=$id?>','<?=$menu_title?>','<?=isset($title)?$title:""?>',false,'Are you want to delete this Social link?')" href="javascript:void(0)">   
                      <img src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></td>
                 </tr>
                 <?php } } ?>
                 <tbody>
                 <tfoot>
                  <tr>
                    <td colspan="4"></td> 
                    <td  align="right">
                       <a href="javascript:void(0)" id="click_toadd" class="reset_button">Add New</a>
                    </td>
                    <td align="right">
                       <button type="submit" class="search_button" name=""><?=$admin_button?></button>
                    <td>
                </tr>
              </tfoot>
         
               </table>
         
               
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       </div>
       
     </div>
    </article><!-- end of post new article -->

