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
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Merchant_login'},function(r){
          //console.log(r);
          if(r==1)
          {
            window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Merchant_login'},function(r){
         // console.log(r);
          if(r==1)
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Merchant_login'},function(r){
          //console.log(r);
          if(r==1)
          {
            window.location.assign($('#delete').val());
            
          }
        })
    }
    else if( $(this).val()=='as')
    {
      $.post('<?=$this->webroot?>admin/bulk_add_slider',{'ids':JSON.stringify(jsonArray),'model':'Merchant_login'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#add_slider').val());
            
          }else if(r=='0')
          {
            window.location.assign($('#not_add_slider').val());
          }
        })
    }
     else if( $(this).val()=='rs')
    {
      $.post('<?=$this->webroot?>admin/bulk_remove_slider',{'ids':JSON.stringify(jsonArray),'model':'Merchant_login'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#remove_slider').val());
            
          }
        })
    } else if( $(this).val()=='sm')
    {
      var email_id=[];
       $('.user_checked:checked').each(function(){
        email_id.push($(this).parents('tr').find('td:nth-child(5)').data('email'));
        console.log($(this).parents('tr').find('td:nth-child(5)').data('email'));
       });
       SendMailAction('',email_id.join(),'');
    }

  }
})

})


</script>
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Merchant <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
     <?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'admin',
           'action' => 'merchants'
        );
  ?>
       
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
    <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Add to slider')?>" id="add_slider">
    <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'have not add to slider')?>" id="not_add_slider">
     <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Remove from slider')?>" id="remove_slider">
  
   
<article class="module width_full">
    <header><h3 class="tabs_involved"><?=$inner_section_name?></h3>
   <a href="<?=$this->webroot?>admin/add_merchant" class="heading_link">Add Merchant</a>
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
              <option value="sm">Send Message</option>
              <option value="as">Add to slider</option>
              <option value="rs">Remove from slider</option>
              <option value="D">Delete</option>            
          </select>
        </td>
          </tr>
        </table>
 <form method="get" action="<?=$this->webroot?>admin/merchants"> 
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
               <a class="reset_button" href="<?=$this->webroot?>admin/merchants" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter" id="table1" style="font-size: 12px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="20px"><input class="check_all" type="checkbox"></th> 
            <th><?php echo $this->Paginator->sort('first_name', 'Name'); ?></th>
            <th><?php echo $this->Paginator->sort('username', 'Username'); ?></th> 
            <th>Password</th> 
            <th><?php echo $this->Paginator->sort('email_id', 'Email'); ?></th>
            <th><?php echo $this->Paginator->sort('url', 'URL'); ?></th>
            <th width="100px" align="center">Status</th>  
            <th width="100px"><?php echo $this->Paginator->sort('update_date', 'Last Updated'); ?></th>         
            <th width="100px">Actions</th>
        </tr> 
      </thead> 
      <tbody> 
        <!--<pre>
        <?php //print_r($merchent_list); ?>
           </pre>-->
         <?php if(count($merchent_list)<=0){ ?>
        <tr><td colspan="4"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php foreach($merchent_list as $key=>$val) { ?>
        <tr> 
            <td>
         <?php  //print_r($val); ?>
           <input type="checkbox" data-id="<?=$val['Merchant_login']['id']?>" class="user_checked <?=$val['Merchant_login']['id']?>">
     
            </td> 

            <td><?=strip_tags(stripslashes($val['Profile']['first_name']))?></td> 
            <td><?=strip_tags(stripslashes($val['Merchant_login']['username']))?></td> 
            
            <td><a href="<?=$this->webroot?>admin/forgot_merchant/<?=$val['Merchant_login']['id']?>">Reset Password</a></td>
            <td data-email="<?=strip_tags(stripslashes($val['Merchant_login']['email_id']))?>"><?=strip_tags(stripslashes($val['Merchant_login']['email_id']))?><br> <a href="javascript:void(0)" onclick="SendMailAction('','<?=strip_tags(stripslashes($val['Merchant_login']['email_id']))?>','');">Send Message</a></td> 
            <td><?=strip_tags(stripslashes($val['Profile']['url']))?></td> 
            
            <td><center><?=$val['Merchant_login']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td>
            <td><?=date('d-m-Y',strtotime(strip_tags(stripslashes($val['Merchant_login']['created_date']))))?></td> 
            <td>
             <?php if($val['Merchant_login']['add_to_slider']==0 and $val['Merchant_login']['status']==1){ ?>
            <a  href="<?=$this->webroot?>admin/add_to_slider_merchant/<?=$val['Merchant_login']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/adslider.png" title="Add to Slider" ></a>
            <?php } else if($val['Merchant_login']['add_to_slider']==1 ) {?>
             <a  href="<?=$this->webroot?>admin/remove_to_slider_merchant/<?=$val['Merchant_login']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/removeslider.png" title="Remove from Slider" ></a>
            <?php } ?>
             <a href="<?=$this->webroot?>admin/merchant/report/view/<?=$val['Profile']['id']?>">
            <input type="image" src="<?=$this->webroot?>images/dashbord/icn_categories.png" 
                title="View Details">
            </a>

             <a href="<?=$this->webroot?>admin/update_merchant/<?=$val['Merchant_login']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               
            <a onclick="deleteAction('<?=$this->webroot?>admin/delete_merchant/<?=$val['Merchant_login']['id']?>','<?=$menu_title?>','<?=strip_tags(stripslashes($val['Profile']['first_name']))?>',false,'Are you want to delete this Merchant user?')" href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a> 
             </td>
        </tr> 
        <?php } }?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input class="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            
           </td>
            <td colspan="5">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
                    <?php 

              // Shows the next and previous links
           echo $this->Paginator->first(__('First', true), array('class' => ''));
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
              echo $this->Paginator->last(__('Last', true), array('class' => ''));
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



  
 
    

 