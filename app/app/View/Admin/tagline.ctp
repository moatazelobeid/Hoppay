<?php $data=isset($setting_info)?$setting_info:""; 
       //print_r($data['User']);
       @ extract($data['Setting']);
        
    ?>
    <script>
    $(function(){
    //$(".tab_content").hide(); //Hide all content
    $("ul.tabs li").removeClass('active');
    $("ul.tabs li:nth-child(3)").addClass("active").show();
     var i=1;
    $('#click_toadd').click(function(){

      $('#add_items').append('<tr id="close_icon'+i+'"><td width="20"><input type="radio" name="tagline" value="'+i+'" style="margin-top:7px"></td><td width="150"><input required type="text" name="tagline_title[]"></td><td width="150"><input type="text" placeholder="Enter arabic Tagline"  required name="tagline_title_ar[]"></td><td width="40">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#<input type="text" name="color_code[]" class="picker" ></input></td><td><a href="javascript:void(0)" style="margin-left: 12px" class="close_icon '+i+'"></a></td></tr>');
        i++;
        $('.close_icon').click(function(){
          var p=$(this).attr('class');
          var arr=p.split(" ");
          var id='#'+arr[0]+arr[1];
          $(id).remove();
          i--;
        })
         CollerPick();
    })
    
    })
   function CollerPick(){
    $(function(){    
     $('.picker').colpick({
        layout:'hex',
        submit:0,
        colorScheme:'dark',
        onChange:function(hsb,hex,rgb,el,bySetColor) {
          $(el).css('border-color','#'+hex);
          // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
          if(!bySetColor) $(el).val(hex);
        }
        }).keyup(function(){
          $(this).colpickSetColor(this.value);
        });
     });
   }
   //window.onload=function(){

    CollerPick();
  // };
    </script>
    <style type="text/css">
    .picker {
  margin:0;
  padding:0;
 width: 70px !important;
height: 20px;
border-right: 20px solid green;
line-height: 20px;
float: none !important;
}
    </style>
    <?=$this->Session->flash('bad')?> 
    <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Tag Line</h3>
      <ul class="tabs">
        <li><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
        <li><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
        <li><a href="#tab1">TagLine</a></li>
        <?php /*?><li><a href="<?=$this->webroot?>admin/seo_settings">Seo</a></li><?php */?>
        <li><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
        <li><a href="<?=$this->webroot?>admin/language_settings">language</a></li>
      </ul>
      </header>
     
        <div class="tab_container">   
        <div id="tab1" class="tab_content">    
          <div id="stylized" class="myform" style="width:828px">
              <form method="post" action="" enctype="multipart/form-data"> 
                   <table>
                   <?php if(empty($tag_data)){?>
                      <tbody id="add_items">
                        <tr>
                          <td width="20">
                            <input type="radio" name="tagline" value="0" style="margin-top:7px">
                          </td>
                          
                          <td width="150">
                            <input type="text"  required name="tagline_title[]">
                          </td>
                          <td width="150">
                            <input type="text" placeholder="Enter arabic Tagline"  required name="tagline_title_ar[]">
                          </td>
                         
                              <td width="40"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#<input type="text" name="color_code[]" class="picker"></input></td></td>
                          <td width="10">
                        
                          </td>
                       </tr>
                     </tbody>
                  <?php } else {?>
                       <tbody id="add_items">
                        <?php foreach ($tag_data as $key => $value) { ?>    
                        <tr>
                          <input type="hidden"  name="id[]" value="<?=$value['Tagline']['id']?>">
                          <td width="20">
                            <input type="radio" <?=$this->Template->Select($value['Tagline']['status'],1,'checked')?> name="tagline" value="<?=$key?>" style="margin-top:7px">
                          </td>
                          
                          <td width="150">
                            <input type="text"  required name="tagline_title[]" placeholder="Enter English Tagline"  value="<?=$value['Tagline']['tag_line']?>">
                          </td>
                          <td width="150">
                            <input type="text" placeholder="Enter arabic Tagline"  required name="tagline_title_ar[]"  value="<?=$value['Tagline']['tag_line_ar']?>">
                          </td>
                         
                               <td width="40"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#<input type="text" name="color_code[]" value="<?=$value['Tagline']['color_code']?>" class="picker"></input></td></td>
                          <td width="10">
                            <a href="<?=$this->webroot?>admin/delete_tagline/<?=$value['Tagline']['id']?>">  <img src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a>
                          </td>
                       </tr>
                       <?php } ?>
                     </tbody>
                  <?php } ?>
                   
                  <tr>
                    <td></td>
                    <td colspan="2"><a href="javascript:void(0)" id="click_toadd" class="reset_button">Add New</a>             
                    <button type="submit" name=""><?=$admin_button?></button></td> 
                    
                </tr>
         
               </table>
         
               
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       </div>
       
     </div>
    </article><!-- end of post new article -->

