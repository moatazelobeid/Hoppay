<?php $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1'; ?>
<?php $cat_id=isset($_GET['cat_id'])?$_GET['cat_id']:'1'; ?>
<script>
$(function(){

 $('#save_order').click(function(){
  var data=new Array();
  var id=new Array();
    $('.get_order').each(function(){
        console.log($(this).attr('value'));
        data.push($(this).attr('value'));
        id.push($(this).data('id'));
    })
     var jsonArraydata = JSON.parse(JSON.stringify(data));
     var jsonArrayids  = JSON.parse(JSON.stringify(id));

     $.post('<?=$this->webroot?>admin/bulk_order',{'ids':JSON.stringify(jsonArrayids),'datas':JSON.stringify(jsonArraydata),'model':'Newsletter','field':'order'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#order').val());
            
          }
        })

 }); 
 
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
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Newsletter'},function(r){
          console.log(r);
          if(r=='1')
          {
             window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Newsletter'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Newsletter'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#delete').val());
            
          }
        })
    }
 }
})

})
  
</script>
<?php 
//echo '<pre>'; print_r($subscriber_list); echo '</pre>';

$status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
$stype=isset($this->request['url']['stype'])?$this->request['url']['stype']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'newsletter',
           'action' => 'index'
        );
  ?>
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'ordered')?>" id="order">
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Newsletter <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>

<div style="margin: 20px 3% 0 3%;">
<a class="reset_button" href="<?=$this->webroot?>admin/newsletter">Subscriber List</a>
<a class="reset_button" href="<?=$this->webroot?>admin/newsletter/email_template">Manage Email Template</a>
<a class="reset_button" href="<?=$this->webroot?>admin/newsletter/send_bulk_email">Send Bulk Email</a>
<a class="reset_button" href="<?=$this->webroot?>admin/newsletter/set_schedule_email">Set Scheduled Email</a>
</div>
   
<article class="module width_full">
    <header><h3 class="tabs_involved">Subscriber List</h3>
   <?php /*?> <a href="<?=$this->webroot?>admin/newsletter/add" class="heading_link">Add Newsletter</a><?php */?>
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
 <form method="get" action="<?=$this->webroot?>admin/newsletter"> 
        <table style="width:50%;float:right">
          <tr>
            <td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Only Subscriber Email"> 
           </td>
            
            <td width="2%">
            <select name="stype" onchange="this.form.submit();" style="width:auto !important">
              <option value="" >-- Type --</option>
              <option value="User" <?=$this->Template->Select($stype,'User')?>> User </option>
              <option value="Merchant" <?=$this->Template->Select($stype,'Merchant')?>> Merchant </option>
            </select> 
           </td>
           
            <td width="2%">
            <select name="status" onchange="this.form.submit();" style="width:auto !important">
              <option value="" >-- Status --</option>
              <option value="1"  <?=  $this->Template->Select($status,'1')?> > Active </option>
              <option value="0"  <?=$this->Template->Select($status,'0')?>> Inctive </option>
            </select> 
           </td>
           
            <td width="12%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/newsletter/" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter ordered" id="" style="font-size: 14px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="20px"><input class="check_all" type="checkbox"></th> 
            <th width="350"><?php echo $this->Paginator->sort('Newsletter.email_id', 'Subscriber Email'); ?></th>            
           
          
            <th align="" width="90">Subscriber Type</th> 
            <th align="center" width="80">Status</th>             
            <th width="80">Actions</th>
        </tr> 
      </thead> 
      <tbody> 
		<?php 
        /*echo "<pre>";
        print_r($subscriber_list);
        echo "</pre>";*/
         if(count($subscriber_list)<=0){ ?>
        <tr><td colspan="7"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php foreach($subscriber_list as $key=>$val) { ?>
        <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Newsletter']['id']?>" class="user_checked <?=$val['Newsletter']['id']?>">
     
            </td> 
            <td><?=htmlspecialchars_decode($val['Newsletter']['email_id'])?></td>        
            
  
            <td><center><?=$val['Newsletter']['stype']?></center></td>            
            <td><center><?=$val['Newsletter']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td> 
            <td>
              <?php /*?><a href="<?=$this->webroot?>admin/newsletter/update/<?=$val['Newsletter']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a><?php */?>
               
              <a onclick="deleteAction('<?=$this->webroot?>admin/newsletter/delete/<?=$val['Newsletter']['id']?>/<?=@$this->params['named']['page']?>','<?=$menu_title?>','<?=htmlspecialchars_decode($val['Newsletter']['email_id'])?>',false,'Are you want to delete this SUBSCRIBER LIST?')" href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></a>
            </td> 
             
        </tr> 
        <?php } } ?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input class="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
         
            <td colspan="4">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
           <?php     
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
            ); ?>
                </div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>
      </div><!-- end of #tab1 -->
           
    </div><!-- end of .tab_container -->
    
    </article>



  
 
    

 