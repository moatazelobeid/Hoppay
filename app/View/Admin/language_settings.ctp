<?php $data=isset($user_data)?$user_data:""; 
       //print_r($data['User']);
       @ extract($data['User']);
        
    ?>
    <script>
    $(function(){
    //$(".tab_content").hide(); //Hide all content
    $("ul.tabs li").removeClass('active');
    $("ul.tabs li:nth-child(6)").addClass("active").show();
    var i=1;
    $('#click_toadd').click(function(){
      $('#add_items').append('<tr id="close_icon'+i+'"><td><input type="text" required name="lang_name[]" placeholder="Enter Language Name" value=""></td><td><input type="text" required name="lang_short_name[]" placeholder="Enter Language Name" value=""></td><td><input type="file" required name="lang_flag[]" placeholder="Enter Language Name" value=""></td><td><img src="" height="20px"></td><td><input type="file" required name="lang_file[]" placeholder="Enter Language Name"></td><td>file</td><td><a href="javascript:void(0)" class="close_icon '+i+'"></a></td></td></tr>');
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
      <header><h3><?=$admin_button?> Language</h3>
      <ul class="tabs">
        <li><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
        <li><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
        <li><a href="<?=$this->webroot?>admin/tagline">TagLine</a></li>
        <?php /*?><li><a href="<?=$this->webroot?>admin/seo_settings">Seo</a></li><?php */?>
        <li><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
        <li><a href="#tab1">language</a></li>
      </ul>
      </header>
     
        <div class="tab_container">   
        <div id="tab1" class="tab_content tab_form">    
          <div id="stylized" class="myform" style="width:100%">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table class="tablesorter" wisth="100%" style="font-size: 12px;" cellspacing="0">
                  <thead> 
                    <tr>
                      <th>Name</th>
                      <th>Short Name</th>
                      <th colspan="2">flag</th>
                      <th >Language file</th>
                      <th >Action</th>
                    </tr>
                    </thead>
                    <tbody id="add_items">
                      <?php if(count($Language_info)<=0){ ?>
                   <tr>
                  

                    <td>
                    <input type="text" required name="lang_name[]" placeholder="Enter Language Name" value="<?=isset($lang_name)?$lang_name:""?>">
                    </td>
                    <td>
                    <input type="text" required name="lang_short_name[]" placeholder="Enter Language Name" value="<?=isset($lang_short_name)?$lang_short_name:""?>">
                    </td>
                    <td>
                    <input type="file" required name="lang_flag[]" placeholder="Enter Language Name" value="<?=isset($lang_flag)?$lang_name:""?>">
                    </td>
                    <td><img src="" height="20px"></td>
                    <td>
                    <input type="file" required name="lang_file[]" placeholder="Enter Language Name" value="<?=isset($lang_file)?$lang_file:""?>">
                    </td>
                    <td>file</td>
                    <td>
                      <a href="<?=$this->webroot?>admin/delete_lang/<!--?=//$val['Banner']['id'];?-->">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a>
                    </td> 
                  </td>
                 </tr>
                 <?php } else{ 
                  foreach($Language_info as $k=>$v){
                    extract($v['Language']);
                   // print_r($v);
                  ?>
                  <tr>
                    <input type="hidden" name="id[]" value="<?=isset($id)?$id:""?>" />
                    <td>
                    <input type="text" required name="lang_name[]" placeholder="Enter Language Name" value="<?=isset($lang_name)?$lang_name:""?>">
                    </td>
                    <td>
                    <input type="text" required name="lang_short_name[]" placeholder="Enter Language Name" value="<?=isset($lang_short_name)?$lang_short_name:""?>">
                    </td>
                    <td>
                    <input type="file"  name="lang_flag[]" placeholder="Enter Language Name" value="<?=isset($lang_flag)?$lang_name:""?>">
                    </td>
                    <td><img src="<?=$this->webroot?><?=isset($lang_flag)?$lang_flag:""?>" height="20px"></td>
                    <td>
                    <input type="file" name="lang_file[]" placeholder="Enter Language Name" value="">
                    <a href="<?=$this->webroot?><?=isset($lang_file)?$lang_file:""?>">Download</a>
                    </td>
                    
                    <td><a href="<?=$this->webroot?>admin/delete_lang/<?=isset($id)?$id:""?>">   <img src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> </td>
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

