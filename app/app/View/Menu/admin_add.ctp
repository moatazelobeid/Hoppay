<?php //print_r($controllers) ?>
 <?php //echo json_encode($controllers)?>
<script type="text/javascript">
var controllers='<?php echo json_encode($controllers)?>';
var controller=JSON.parse(controllers);
console.log(controller);
/*var slug = function(str) {
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
  var to   = "aaaaaeeeeeiiiiooooouuuunc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes

  return str;
};*/
$(function(){
$("#menu_title").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#menu_slug").val(Text);        
});


})
function ucwords(str,force){
  str=force ? str.toLowerCase() : str;  
  return str.replace(/(\b)([a-zA-Z])/g,
           function(firstLetter){
              return   firstLetter.toUpperCase();
           });
}
function myControllerChange(values){
  var newvalue=ucwords(values)+"Controller";
  console.log(newvalue);
  console.log(controller[newvalue]);
  $('#actionList').html('<option value="">--Choose Actions--</option>');
  for(var n in controller[newvalue])
  {
    //console.log(controller[newvalue][n]);
    $('#actionList').append('<option value="'+controller[newvalue][n]+'">'+controller[newvalue][n]+'</option>')
  }
}
function menuFunction(values){
  console.log(values);
  $('.active').removeClass('active').addClass('hide');
  $('.hide input,.hide select').attr('disabled','disabled').removeAttr('required');

  if(values==1)
  {
    $('.direct_link').removeClass('hide').addClass('active');
    $('.active input').attr('required','required').removeAttr('disabled');
  }
  else if(values==2)
  {
    $('.controllers,.action').removeClass('hide').addClass('active');
    $('.active input,.active select').attr('required','required').removeAttr('disabled');
    $('.pages').removeClass('hide').addClass('active');
    $('.active input,.active select').attr('required','required').removeAttr('disabled');
  }
  /*else if(values==3){
    $('.pages').removeClass('hide').addClass('active');
    $('.active input,.active select').attr('required','required').removeAttr('disabled');
  }*/
}

</script>
<style type="text/css">
.hide{
  display:none;
}
.active{
  
}
</style>
<?php $data=isset($menu_info)?$menu_info:""; 
      //print_r($data);
       @extract($data);
       @extract($data['Menu']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
      // print_r($Menu_lang);
       if(isset($Menu_lang))
       {
        foreach($Menu_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Menu_lang=$val;
          }
        }
      }
    ?>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Menu</h3>
      <a href="<?=$this->webroot?>admin/menu/position/add" class="heading_link">Add Position</a>
      <a href="<?=$this->webroot?>admin/menu" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" >
             <?php if(isset($id)){ ?>
        <form>

           <table>
                  <tr>
                    <td style="width: 152px;">
                   <label>Choose Language
                     <span class="small">Select Language</span>
                   </label>
                    </td>
                    <td>
                   

                      <select name="lang_id" onchange="this.form.submit();" style="width: 185px;">
                        <?php 
                        foreach($lang as $val){ ?>
                        <option value="<?=$val['Language']['id']?>" <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?>><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>)</option>
                       <?php } 
                        ?>
                      </select>
                      </td>
                  </tr>
                </table>
              </form>
         <?php } 
         else
           { ?>
            <form>
                <table>
                    <tr>
                      <td style="width: 152px;">
                     <label>Choose Language
                       <span class="small">Select Language</span>
                     </label>
                      </td>
                      <td>
             <select name="lang_id" disabled="disabled" onchange="this.form.submit();" style="width: 185px;">
                <option value="1" readonly="readonly">English</option>
             </select>
              </td>
                    </tr>
                  </table>
                </form>
         <?php  }
            ?>
              <form method="post" name="Image" enctype="multipart/form-data" action=""> 
              <input type="hidden" name="lang_id" value="<?=$lang_id?>">
              <input type="hidden" name="menu_lang_id" value="<?=isset($Menu_lang['id'])?$Menu_lang['id']:""?>">
                <table>
                  <tr>
                    <td>
                   <label>Title:
                     <span class="small">Add menu title.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="menu_title" id="menu_title" placeholder="Enter menu name here" value="<?=isset($Menu_lang['menu_title'])?$Menu_lang['menu_title']:""?>">
                  </td>
                 </tr>  
                 <?php if($lang_id==1){ ?>
                 <tr>
                    <td>
                   <label>Slug:
                     <span class="small">Add Slug</span>
                   </label>
                    </td>
                    <td>
                       <input type="text" required name="slug" id="menu_slug" placeholder="Enter menu slug here" value="<?=isset($Menu['slug'])?$Menu['slug']:""?>"> 
                    </td>
                 </tr> 
                 <?php } ?>
                  <tr>
                    <td>
                   <label>Type:
                     <span class="small">Add type.</span>
                   </label>
                   </td>
                    <td>
                      <script type="text/javascript">
                        $(function(){
                          $('#menu_type_id').val(<?=$Menu['menu_type_id']?>).trigger('change');
                         <?php if($Menu['menu_type_id']==2){ ?>
                            $('#menu_controller').val('<?=$Menu['menu_controller']?>').trigger('change');
                            $('#actionList').val('<?=$Menu['menu_action']?>');
                            $('#page_id').val('<?=$Menu['page_id']?>');
                         <?php } else if($Menu['menu_type_id']==3){ ?>
                            //$('#page_id').val('<?=$Menu['page_id']?>');
                         <?php } ?>
                            $('#menu_position_id').val('<?=$Menu['menu_position_id']?>');
                             $('#menu_access').val('<?=$Menu['menu_access']?>');

                              $('#parent_id').val('<?=$Menu['parent_id']?>');
                        })
                      </script>
                      <select name="menu_type_id" id="menu_type_id" onchange="menuFunction(this.value)" required>
                         <option>--Choose type--</option>
                         <option value="1">Custom</option>
                         <option value="2">Dynamic</option>
                         <!--<option value="3">Pages</option>-->
                      </select>
                   </td>
                  </tr> 
                  <tr class="direct_link hide">
                    <td>
                   <label>Direct Link:
                     <span class="small">Add Direct link</span>
                   </label>
                    </td>
                    <td>
                       <input type="url" required name="menu_link" placeholder="Enter direct link here" value="<?=isset($Menu['menu_link'])?$Menu['menu_link']:""?>"> 
                    </td>
                 </tr>       
                 <tr class="controllers hide">
                  <td >
                   <label>Controller:
                     <span class="small">Add Controller.</span>
                   </label>
                    </td>
                    <td>
                      <select name="menu_controller" id="menu_controller" onchange="myControllerChange(this.value)">
                        <option>--Choose Controller--</option>
                        <?php 
                          $cont_arrya=array_keys($controllers);
                        foreach (array_keys($controllers) as $key => $value) { 
                            if(!in_array($value,array("AdminController",'MenuController') ))
                            {
                          ?>
                          <option value="<?=$this->Template->getControllerName($value)?>"><?=$this->Template->getControllerName($value)?></option>
                       <?php } }?>
                      </select>
                  </td>
                 </tr>      
                 <tr class="action hide">
                    <td>
                   <label>Action:
                     <span class="small">Add Actions.</span>
                   </label>
                    </td>
                    <td>
                      <select name="menu_action" id="actionList">
                        <option>--Choose Action--</option>
                      </select>
                  </td>
                 </tr >  
                      <tr class="pages hide">
                    <td>
                   <label>Pages:
                     <span class="small">Add Pages.</span>
                   </label>
                    </td>
                    <td>
                      <select name="page_id" id="page_id">
                        <option>--Choose Pages--</option>
                        <?php foreach ($pages as $key => $value) { ?>
                          <option value="<?=$value['Page']['id']?>"><?=$value['Page_lang']['pg_title']?></option>
                       <?php }?>
                      </select>
                  </td>
                 </tr>            
                 <tr>
                    <td>
                    <label>Menu Position:
                     <span class="small">Position</span>
                   </label>
                   </td>
                    <td>
                        <!--<pre><?php //print_r($chield_ids)?></pre>-->
                     <select name="menu_position_id" id="menu_position_id" required>
                      <option value="">Choose Position</option>
                      <?php foreach ($position as $key => $value) { ?>
                      <option value="<?=$value['Menu_position']['id']?>"><?=$value['Menu_position']['title']?></option>
                      <?php } ?>
                     </select>
                    </td>                 
                    </tr>
                    <tr>
                    <td>
                    <label>Menu Parent:
                     <span class="small">Choose category Parent</span>
                   </label>
                   </td>
                    <td>
                        <!--<pre><?php //print_r($chield_ids)?></pre>-->
                     <select name="parent_id" id="parent_id">
                      <option value="">--Choose Parent--</option>
                      <?php 

                      foreach ($menu_parent_names as $key => $value) { ?>                      
                        <option value="<?=$key?>" <?php echo $this->Template->Select($key,isset($parent_id)?$parent_id:"");?>><?=$value?></option>
                        <?php  } ?>
                     
                    </select>
                    </td>                 
                    </tr>
                     <tr>
                    <td>
                    <label>Menu Authentication:
                     <span class="small">Add Authentication</span>
                   </label>
                   </td>
                    <td>
                        <!--<pre><?php //print_r($chield_ids)?></pre>-->
                     <select name="menu_access"  id="menu_access" required>
                      <option value="">Choose Authentication</option>
                      <option value="1">user</option>
                      <option value="2">merchant</option>
                      <option value="3">admin</option>    
                      <option value="4">Only User</option>                  
                     </select>
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

