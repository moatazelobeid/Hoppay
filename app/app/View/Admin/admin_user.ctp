<script>
$(function(){
$('.check_all').change(function(){
  //alert('sdfsd');

  if($(this).is(':checked')){
    $('.check_all').attr('checked','checked');
    $('.user_checked').attr('checked','checked');
  }
  else
  {
     $('.check_all').removeAttr('checked');
     $('.user_checked').removeAttr('checked');
  }

});
$('#action_option').change(function(){
    var data=new Array();
    $('.user_checked:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));
if(data.length<=0){
  //alert('no data');
}
else{
    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'User'},function(r){
          //console.log(r);
          if(r==1)
          {
            window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'User'},function(r){
         // console.log(r);
          if(r==1)
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'User'},function(r){
         // console.log(r);
          if(r==1)
          {
            window.location.assign($('#delete').val());
            
          }
        })
    }
 }
})
})


</script>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Users <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
    <?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'admin',
           'action' => 'adminUser'
        );
  ?>
       
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
  
   
<article class="module width_full">
    <header>
      <h3 class="tabs_involved">Admin User lists</h3>
    <a href="<?=$this->webroot?>admin/add_admin_user" class="heading_link">Add User</a>
    </header>

    <div class="module_content listing_containt">
       <div id="stylized" class="myform search" style="width:100%">
         <table style="width:30%;float:left">
          <tr>
            <td> 
              <select id="action_option" style="width:auto !important">
              <option value="">Bulk Action</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
            <option value="D">Delete</option>            
          </select>
        </td>
          </tr>
        </table>
 <form method="get" action="<?=$this->webroot?>admin/adminUser"> 
        <table style="width:50%;float:right">
          <tr>
            <td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here"> 
           </td>
            <td width="2%">
            <select name="status" style="width:auto !important">
              <option value="" >-- Choose Status --</option>
              <option value="1"  <?=  $this->Template->Select($status,'1')?> > Active </option>
              <option value="0"  <?=$this->Template->Select($status,'0')?>> Inactive </option>
            </select> 
           </td>
          
            <td width="12%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/adminUser" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter" id="table1" style="font-size: 14px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="20px"><input class="check_all" type="checkbox"></th> 
            <th><?php echo $this->Paginator->sort('name', 'Name'); ?></th> 
            <th>Email</th> 
            <th>Phone</th> 
            <th>Username</th> 
            <th>Password</th> 
            <th>Status</th>
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
       <?php if(count($all_user)<=0){ ?>
        <tr><td colspan="7"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php foreach($all_user as $key=>$val) { ?>
        <tr> 
            <td>
           <?php if( $this->Session->read('Admin.id')!=$val['User']['id']){?>
           <input type="checkbox" data-id="<?=$val['User']['id']?>" class="user_checked <?=$val['User']['id']?>">
           <?php } ?>
            </td> 
            <td><?=$val['User']['name']?></td> 
            <td><?=$val['User']['email']?></td> 
            <td><?=$val['User']['phone']?></td> 
            <td><?=$val['User']['username']?></td> 
            <td><?=base64_decode($val['User']['password'])?></td> 
            <td><?=$val['User']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></td> 
            <td>
              <a href="<?=$this->webroot?>admin/update_admin_user/<?=$val['User']['id']?>/<?=$this->params['named']['page']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               <?php if( $this->Session->read('Admin.id')!=$val['User']['id']){?>
            <a onclick="deleteAction('<?=$this->webroot?>admin/delete_admin_user/<?=$val['User']['id']?>/<?=$this->params['named']['page']?>','<?=$menu_title?>','<?=$val['User']['name']?>',false,'Are you want to delete this Admin User?')" href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> 
              <?php } ?>
        </tr> 
        <?php } } ?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input class="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            
           </td>
            <td colspan="4">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
               <?php 

// Shows the next and previous links
echo $this->Paginator->prev(
  '« Previous',
  null,
  null,
  array('class' => 'disabled')
);

echo $this->Paginator->numbers(array('separator' => ''));
// prints X of Y, where X is current page and Y is number of pages

echo $this->Paginator->next(
  'Next »',
  null,
  null,
  array('class' => 'disabled')
);
//echo $this->Paginator->counter();
//debug($this->Paginator->params()); 
?>
                </div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>
      </div><!-- end of #tab1 -->
         
    </div><!-- end of .tab_container -->
    
    </article>



  
 
    

 