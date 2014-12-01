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

     $.post('<?=$this->webroot?>admin/bulk_order',{'ids':JSON.stringify(jsonArrayids),'datas':JSON.stringify(jsonArraydata),'model':'Menu','field':'order'},function(r){
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
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Menu'},function(r){
          //console.log(r);
          if(r==1)
          {
             window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Menu'},function(r){
          //console.log(r);
          if(r==1)
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Menu'},function(r){
          //console.log(r);
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
<?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'menu',
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
   <h4 class="alert_success">Menu <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
    
   
<article class="module width_full">
    <header><h3 class="tabs_involved">Menu List</h3>
    <a href="<?=$this->webroot?>admin/menu/add" class="heading_link">Add Menu</a>
   <a href="<?=$this->webroot?>admin/menu/position/add" class="heading_link">Add Position</a>
   <a href="<?=$this->webroot?>admin/menu/position/list" class="heading_link"> Position lists</a>
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
 <form method="get" action="<?=$this->webroot?>admin/menu"> 
        <table style="width:50%;float:right">
          <tr>
            <td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here"> 
           </td>
            
            <td width="2%">
            <select name="status" onchange="this.form.submit();" style="width:auto !important">
              <option value="" >-- Choose Status --</option>
              <option value="1"  <?=  $this->Template->Select($status,'1')?> > Active </option>
              <option value="0"  <?=$this->Template->Select($status,'0')?>> Inactive </option>
            </select> 
           </td>
           <td width="2%">
         
          <select name="lang_id" onchange="this.form.submit();" style="width: 105px;">
                        <?php 
                        foreach($lang as $val){ ?>
                        <option value="<?=$val['Language']['id']?>" <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?>><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>)</option>
                       <?php } 
                        ?>
                      </select>
                    
        </td>
            <td width="12%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/menu/" class="reset">Reset</a> 
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
            <th width="400"><?php echo $this->Paginator->sort('Menu_lang.menu_title', 'Name'); ?></th>            
           
          
            <th align="" width="40"><?php echo $this->Paginator->sort('Menu.order', 'Order'); ?> <img id="save_order" src="<?=$this->webroot?>/images/dashbord/save.png" style="float: right;margin-top:0px;margin-left: -7px;"></th> 
            <th align="center" width="80">Status</th>             
            <th width="80">Actions</th>
        </tr> 
      </thead> 
      <tbody> 
         <?php 
         echo "<pre>";
       //print_r($faq_info);
          echo "</pre>";
         if(count($menu_info)<=0){ ?>
        <tr><td colspan="7"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php foreach($menu_info as $key=>$val) { ?>
        <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Menu']['id']?>" class="user_checked <?=$val['Menu']['id']?>">
     
            </td> 
            <td><?=htmlspecialchars_decode($val['Menu_lang']['menu_title'])?></td>        
            
  
            <td><center><input type="text" class="get_order" data-id="<?=$val['Menu']['id']?>" value="<?=$val['Menu']['order']?>" ></center></td>            
            <td><center><?=$val['Menu']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td> 
            <td>
              <a href="<?=$this->webroot?>admin/menu/update/<?=$val['Menu']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
               
            <a onclick="deleteAction('<?=$this->webroot?>admin/menu/delete/<?=$val['Menu']['id']?>','<?=$menu_title?>','<?=preg_replace('/[_]+/','',strip_tags($val['Menu_lang']['menu_title']))?>',false,'Are you want to delete this Menu?')"  href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a></td> 
             
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
           echo $this->Paginator->first('< First');
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
            echo $this->Paginator->last('Last >');
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



  
 
    

 