<script>
$(function(){

$('#check_all').change(function(){
  //alert('sdfsd');
  if($(this).is(':checked')){

    $('.user_checked').attr('checked','checked');
    
  }
  else
  {
     $('.user_checked').removeAttr('checked');
    
  }

});
$('#check_all1').change(function(){
  //alert('sdfsd');
  if($(this).is(':checked')){

    
    $('.user_checked1').attr('checked','checked');
   
  }
  else
  {
     
     $('.user_checked1').removeAttr('checked');
    
  }

});
$('#check_all2').change(function(){
  //alert('sdfsd');
  if($(this).is(':checked')){

   
    $('.user_checked2').attr('checked','checked');
  }
  else
  {
    
     $('.user_checked2').removeAttr('checked');
  }

});
$('#action_option').change(function(){
    var data=new Array();
    $('.user_checked:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));

    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Activated');
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Inactivate');
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Deleted');
            
          }
        })
    }

})
$('#action_option1').change(function(){
    var data=new Array();
    $('.user_checked1:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));

    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Activated');
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Inactivate');
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Deleted');
            
          }
        })
    }

})
$('#action_option2').change(function(){
    var data=new Array();
    $('.user_checked2:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));

    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Activated');
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Inactivate');
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Page'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign('<?=$this->webroot?>admin/page_manager?msg=Deleted');
            
          }
        })
    }

})
})


</script>
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Page <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
    
   
<article class="module width_full">
    <header><h3 class="tabs_involved"><?=$inner_section_name?></h3>
    <ul class="tabs">
        <li><a href="#tab1">All</a></li>
        <li><a href="#tab2">Active</a></li>
        <li><a href="#tab3">Inactive</a></li>
        <li><a href="<?=$this->webroot?>admin/add_page">Add Page</a></li>
    </ul>
    </header>

    <div class="tab_container">
      <div id="tab1" class="tab_content">
      <table class="tablesorter" id="table1" style="font-size: 12px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th>Sl#</th> 
            <th>Title</th>
            <th>keyword</th> 
            <th>Meta Desc.</th> 
            <th>Content</th>
            <th>Image</th> 
            <th>Temp Name</th>           
            <th>Status</th>             
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
       <?php foreach($page_list as $key=>$val) { ?>
        <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Page']['id']?>" class="user_checked <?=$val['Page']['id']?>">
     
            </td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_title']))?></td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_keyword']))?></td>
            <td><?=strip_tags(stripslashes($val['Page']['pg_desp']))?></td>
            <td><?=htmlspecialchars_decode(stripslashes($val['Page']['pg_detail']))?></td>
            
            <td>
              <?php if($val['Page']['pg_img']!="" or file_exists($this->webroot."uploads/page/".$val['Page']['pg_img'])) { ?>
              <center><img src="<?=$this->webroot?>uploads/page/<?=$val['Page']['pg_img']?>" height="60px"></center>
              <?php } ?>
            </td>
             <td><?=str_replace("_"," ", strip_tags(stripslashes($val['Page']['page_template']))) ?></td>                  
            <td><center><?=$val['Page']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td> 
            <td>
              <a href="<?=$this->webroot?>admin/update_page/<?=$val['Page']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               
            <a href="<?=$this->webroot?>admin/delete_page/<?=$val['Page']['id']?>">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> 
             
        </tr> 
        <?php } ?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input id="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            <select id="action_option">
              <option value="">--Choose Action--</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
            <option value="D">Delete</option>            
          </select>
           </td>
            <td colspan="5">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination"></div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>
      </div><!-- end of #tab1 -->
      
      <div id="tab2" class="tab_content">
      <table class="tablesorter" id="table2" cellspacing="0"> 
      <thead> 
        <tr> 
            <th>Sl#</th> 
            <th>Title</th>
            <th>keyword</th> 
            <th>Meta Desc.</th> 
            <th>Content</th>
            <th>Image</th> 
            <th>Temp Name</th>           
            <th>Status</th>             
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
        <?php foreach($page_list as $key=>$val) { 
        if($val['Page']['status']==1){
          ?>
        <tr> 
        
          
            <td>
          
           <input type="checkbox" data-id="<?=$val['Page']['id']?>" class="user_checked1 <?=$val['Page']['id']?>">
     
            </td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_title']))?></td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_keyword']))?></td>
            <td><?=strip_tags(stripslashes($val['Page']['pg_desp']))?></td>
            <td><?=htmlspecialchars_decode(stripslashes($val['Page']['pg_detail']))?></td>
            <td><center><img src="<?=$this->webroot?>uploads/page/<?=$val['Page']['pg_img']?>" height="60px"></center></td>
             <td><?=str_replace("_"," ", strip_tags(stripslashes($val['Page']['page_template']))) ?></td>                  
            <td><center><?=$val['Page']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td> 
            <td>
              <a href="<?=$this->webroot?>admin/update_page/<?=$val['Page']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               
            <a href="<?=$this->webroot?>admin/delete_page/<?=$val['Page']['id']?>">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a>
          </td> 
        </tr> 
        <?php } }?>
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input id="check_all1" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            <select id="action_option1">
              <option value="">--Choose Action--</option>
            <option value="0">Inactive</option>
            <option value="D">Delete</option>            
          </select>
           </td>
            <td colspan="5">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination"></div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>

      </div><!-- end of #tab2 -->
       <div id="tab3" class="tab_content">
      <table class="tablesorter" id="table3" cellspacing="0"> 
      <thead> 
        <tr> 
            <th>Sl#</th> 
            <th>Title</th>
            <th>keyword</th> 
            <th>Meta Desc.</th> 
            <th>Content</th>
            <th>Image</th> 
            <th>Temp Name</th>           
            <th>Status</th>             
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
       <?php foreach($page_list as $key=>$val) { 
        if($val['Page']['status']==0 or $val['Page']['status']==""){
          ?>
        <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Page']['id']?>" class="user_checked2 <?=$val['Page']['id']?>">
     
            </td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_title']))?></td> 
            <td><?=strip_tags(stripslashes($val['Page']['pg_keyword']))?></td>
            <td><?=strip_tags(stripslashes($val['Page']['pg_desp']))?></td>
            <td><?=htmlspecialchars_decode(stripslashes($val['Page']['pg_detail']))?></td>
            <td><center><img src="<?=$this->webroot?>uploads/page/<?=$val['Page']['pg_img']?>" height="60px"></center></td>
             <td><?=str_replace("_"," ", strip_tags(stripslashes($val['Page']['page_template']))) ?></td>                  
            <td><center><?=$val['Page']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td> 
            <td>
              <a href="<?=$this->webroot?>admin/update_page/<?=$val['Page']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               
            <a href="<?=$this->webroot?>admin/delete_page/<?=$val['Page']['id']?>">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> 
        </tr> 
        <?php } }?>
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input id="check_all2" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            <select id="action_option2">
              <option value="">--Choose Action--</option>
            <option value="1">Active</option>            
            <option value="D">Delete</option>            
          </select>
           </td>
            <td colspan="5">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination"></div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>

      </div><!-- end of #tab2 -->
    </div><!-- end of .tab_container -->
    
    </article>



  
 
    

 