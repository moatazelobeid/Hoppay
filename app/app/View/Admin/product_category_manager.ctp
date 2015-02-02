<script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.contextMenu.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$this->webroot?>css/front-end/jquery.contextMenu.css">
<?php $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1'; ?>
<script>
$(document).mouseup(function (e){
    var container = $('li.cat_li .cname').find('textarea');
    var content1=$('.alert_notification');

   
    
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
         var func=container.attr('onblur');
         eval(func);
          //$('#dept').val(1);
    }
     if (!content1.is(e.target) // if the target of the click isn't the container...
        && content1.has(e.target).length === 0) // ... nor a descendant of the container
    {
         $('.alert_overly,.add_overly').fadeOut();
          //$('#dept').val(1);
    }
    
   

});
function getEditOption(cthis,cat_id,lang){
    removeEditor();
    var text=$(cthis).text();
    $( "#catlist_section .sortable-list" ).sortable( "disable" );
    addEdditor(cthis,text,cat_id,lang)
}
function addEdditor(sthis,text,cat_id,lang){
 $(sthis).html('<textarea onblur="saveCatename(this,'+cat_id+','+lang+')" onfocusout="" onfocusout="saveCatename(this,'+cat_id+','+lang+')" style="width:127px;">'+text+'</textarea>')
}
function removeEditor(){
  var texts=$('li.cat_li .cname').find('textarea').val();
  $( "li.cat_li .cname").find('textarea').replaceWith( texts );
 // alert(texts);
}
function saveCatename(cthis,catid,lang){
  var txt=$(cthis).val();
  console.log(txt);
  removeEditor();
  if(txt!="")
  {
    if(catid!=undefined && lang!=undefined)
    {
      $.post('<?=$this->webroot?>admin/ajax_add_category_name/'+catid,{txt:''+txt,lang:lang},function(r){
        console.log(r);
        if(r==1)
        {
          alertBox('This Department successfully updated',3000);
        }
      }) 
    }
  }
  else
  {
      //alertBox('This Department successfully updated',3000);
  }
  $( "#catlist_section .sortable-list" ).sortable( "enable" );
   
}

$(function(){
   /*$( ".cat_li" ).droppable({
        accept: ".cat_li",
        activeClass: "ui-state-hover",
        hoverClass: "ui-state-active",
        over: function( event, ui ) {
          event.preventDefault();
          var child_click=$(this).find('.child_click');      
          if(child_click.is(':visible'))
          {
            /*setTimeout(function(e){
             
                child_click.click();
            },2000)*/
      /*    }
        },
        drop:function( event, ui ) {
          event.preventDefault();

        }

      });*/
 $.contextMenu({
        selector: '.cat_li', 
        callback: function(key, options) {
         // console.log(options);
          //console.log($(this).text());
           // var m = "clicked: " + key;
           // window.console && console.log(m) || alert(m); 
           var cid=$(this).data('catid');
           switch(key){
            case 'add_cat':            
            addCatBox(cid);             
            break;
            case 'edit_cat':
              $(this).find('.cname').dblclick();             
            break;
            case 'delete_cat':
            deleteAction('deleteCat('+cid+')',"Category",'',false,'Are you sure, Want to delete the category?',true);
            break;
           }
        },
        items: {
            "edit_cat": {name: "Edit", icon: "edit"},  
            "delete_cat": {name: "Delete", icon: "delete"}, 
            "add_cat": {name: "Add Category", icon: "add"}, 

        }
    });
  $('#catlist_section .sortable-list').sortable({
    connectWith: '#catlist_section .sortable-list',
    placeholder: 'placeholder',
    cancel: ".active",
    cursor: "move",
    scroll:true,
    containment: '#catlist_section',
    opacity: 0.6, 
    update: function( event, ui ) {
      var order = $(this).sortable("serialize") + '&parent='+$(this).parent().data('pid')+'&action=updateRecordsListings';
      //console.log($(this).parent());
     // console.log($(this).parent().data('pid'));
    
      $.post('<?=$this->webroot?>/admin/update_order_ajax',order,function(r){
        if(r==1)
        {
           alertBox('This Department successfully updated',2000);
        }
      })
    }
  });
  $( "#catlist_section li" ).disableSelection();
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

     $.post('<?=$this->webroot?>admin/bulk_order',{'ids':JSON.stringify(jsonArrayids),'datas':JSON.stringify(jsonArraydata),'model':'Product_category','field':'cat_order'},function(r){
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
        $.post('<?=$this->webroot?>admin/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Product_category'},function(r){
          console.log(r);
          if(r=='1')
          {
             window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>admin/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Product_category'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>admin/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Product_category'},function(r){
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
<?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'admin',
           'action' => 'product_category_manager'
        );
  ?>
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'ordered')?>" id="order">
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">PRODUCT Catagory <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
    
   
<article class="module width_full">
    <header><h3 class="tabs_involved">PRODUCT Department LIST</h3>
   <!-- <a href="<?=$this->webroot?>admin/add_faq" class="heading_link">Add Product</a>-->
    <a href="<?=$this->webroot?>admin/add_product_category" class="heading_link">Add Department</a>
    </header>

     <div class="module_content listing_containt">
       <div id="stylized" class="myform search" style="width:100%">
        <?php /*?><table style="width:30%;float:left">
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
        </table><?php */?>
 <form method="get" action="<?=$this->webroot?>admin/product_category_manager"> 
        <table style="width:38%;float:right">
          <tr>
            <?php /*?><td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here"> 
           </td>
            <td width="2%">
            <select name="status" onchange="this.form.submit();" style="width:auto !important">
              <option value="" >-- Choose Status --</option>
              <option value="1"  <?=$this->Template->Select($status,'1')?> > Active </option>
              <option value="0"  <?=$this->Template->Select($status,'0')?>> Inactive </option>
            </select> 
           </td><?php */?>
           <td>
         
          <select name="lang_id" id="lang_id" onchange="this.form.submit();" style="width: 185px;">
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
               <a class="reset_button" href="<?=$this->webroot?>admin/product_category_manager" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter ordered" id="" style="font-size: 14px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="240">Department<!--<input class="check_all" type="checkbox">--></th> 
            <th width="240"> Category<?php //echo $this->Paginator->sort('Product_category.lft', 'Category'); ?></th>            
            <!--<th><-?php echo $this->Paginator->sort('Product_category.parent_id', 'Parent'); ?></th>-->             
            <th align="" width="240" >Sub Category<?php //echo $this->Paginator->sort('Product_category.cat_order', 'Order'); ?> <?php /*?><img id="save_order" src="<?=$this->webroot?>/images/dashbord/save.png" style="float: right;margin-top:0px;margin-left: -7px;"><?php */?></th> 
            <th align="center" width="100"><!--Status--></th>             
            <th width="100"><!--Actions--></th>
        </tr> 
      </thead> 
      <tbody> 
       
         <?php 
       //  print_r($faq_cat_info);
        
         if(count($product_cat_info)<=0)
		 { ?>
            <tr>
            	<td colspan="7"><center>No record found.</center></td>
            <tr>
        <?php } 
		else 
		{
			?>
            <tr>
                <td colspan="7" style="padding:0px;">
                <input type="hidden" name="ccount" id="ccount" value="1" />
                <div id="catlist_section">
                <div class="column-view-composition" id="catlist_section_list">
                    <div class="cat_column" id="catlist_0"  data-pid="0">
                        <ul class="sortable-list">
						   <?php foreach($product_cat_info as $key=>$val) 
						   { 
						   		$children = '';
								$children = $this->Template->getAdminCategoryChidren($val['Product_category']['id'],$lang_id);
								//print_r($children);
								?>
                            
                                <li class="cat_li" id="cat_li_<?php echo $val['Product_category']['id'];?>" data-catid="<?php echo $val['Product_category']['id'];?>">
									<div class="cname" data-catid="<?=$val['Product_category']['id']?>" data-lang="<?=$val['Product_category_lang']['lang_id']?>" ondblclick="getEditOption(this,'<?=$val['Product_category']['id']?>','<?=$val['Product_category_lang']['lang_id']?>');"><?php echo htmlspecialchars_decode($val['Product_category_lang']['category_name']);?></div>
                                    <div class="cat_action">
                                    	<?php if($val['Product_category']['status'] == 0)
										{?>
                                            <a href="<?=$this->webroot?>admin/active_product_cat/<?php echo $val['Product_category']['id'];?>"><input type="image" src="<?=$this->webroot?>images/dashbord/inactive.png" title="Active"></a>
										<?php }
										if($val['Product_category']['status'] == 1)
										{?>
                                            <a href="<?=$this->webroot?>admin/inactive_product_cat/<?php echo $val['Product_category']['id'];?>"><input type="image" src="<?=$this->webroot?>images/dashbord/active.png" title="Inactive"></a>
										<?php }?>
                                    	<a target="_blank" href="<?=$this->webroot?>admin/update_product_cat/<?php echo $val['Product_category']['id'];?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
                                        <a href="<?=$this->webroot?>admin/delete_product_cat/<?php echo $val['Product_category']['id'];?>" onclick="return confirm('Are you sure to delete this category?');">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a>
                                        <?php
										if(!empty($children))
										{?>
                                        	<a href="javaScript:void(0);" class="child_click" onclick="getChildCats('<?php echo $val['Product_category']['id'];?>',0);"><i class="icon-chevron-right"></i></a>
                                        <?php }?>
                                    </div>
                                    <div style="clear:both;"></div>
                                </li>
                             
                            <?php } ?>
                        </ul>
                    </div>
                    </div>
                    </div>
               </td>
           </tr>
		<?php } ?>
      </tbody> 
       <?php /*?><tfoot>
        <tr>
          <td colspan="1"><input class="check_all" type="checkbox"><lable for="check_all" style="position:absolute;margin-top: 2px;">Select All</lable></td>
          
            <td colspan="6">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
           <?php     
            echo $this->Paginator->first(__('< First', true), array('class' => ''));
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
              echo $this->Paginator->last(__('Last >', true), array('class' => ''));?>
                </div>
              </div>
            </td>
        </tr>
      </tfoot><?php */?>
      </table>
      </div><!-- end of #tab1 -->
           
    </div><!-- end of .tab_container -->
    
    </article>


<script type="text/javascript">
function removeer(cno2,cnt,callback){
    for(var i = cno2; i<= cnt; i++)
      {
        $('#catlist_'+i).remove();  
      } 
  if(typeof callback == "function") 
          callback(i);
}
function getChildCats(catid,cno)
{
	var lang_id = $('#lang_id').val();
	
	var cno2 = parseInt(cno)+1;
	
	$('#catlist_section_list').append('<div id="loading_'+catid+'" class="cat_loading"><br><img src="<?=$this->webroot?>images/ajax-loader.gif" /></div>');
	
	var cnt = parseInt($('#ccount').val());
	
	var url = '<?=$this->webroot?>admin/getAJAXCategorysChild/'+catid+'/'+cno2+'/'+lang_id;
	
	//alert(url);
	
	$('#catlist_'+cno+' .cat_li').removeClass('active');
	
	$('#cat_li_'+catid).addClass('active');
	
	/*alert(url);
	alert(cno);
	alert(cnt);*/
	//return false;
	removeer(cno2,cnt,function(rr){
    console.log(rr);
    if(rr>1)
    {
        $.get(url,function(data)
  {
    //$(data).insertAfter('#catlist_'+pid);
    
    //$('.cat_li').removeClass('active');
    /*$(cthis).parents('li').addClass('ui-state-disabled');
    $(cthis).parents('li').addClass('ui-state-disabled');*/
    
    $('.cat_column').last().after(data);
     
    $('#loading_'+catid).remove();
    
    $('#ccount').val(cnt+1);
    
    //$('#catlist_'+cno2+' ul li:first').addClass('aaa');
    //var t="";
     var act=0;
    var wdth = $('#catlist_section').width();
    
    var t;
  
    //alert(wdth);
    $('#catlist_section .sortable-list').sortable({
    connectWith: '#catlist_section .sortable-list',
    placeholder: 'placeholder',
    cancel: ".active",
    cursor: "move",
    scroll:true,
    containment: '#catlist_section',
    opacity: 0.6, 
    update: function( event, ui ) {
     
      /*var num=$(this).parent().attr('id');
      var id=$(this).parent().data('pid')
         
          num=num.split('_');
           console.log(num);*/
      var order = $(this).sortable("serialize") + '&parent='+$(this).parent().data('pid')+'&action=updateRecordsListings';     

      $.post('<?=$this->webroot?>admin/update_order_ajax',order,function(r){
        console.log(r);
        if(r==1)
        {

         /* if(num[1]!=0)
          {
            getChildCats(id,(parseInt(num[1])-1))
          }
          else
          {
            window.location.reload();
          }    */       
           alertBox('This Department successfully updated',2000);
        }
      })
    },
    receive: function(e, ui) { 
       var item_id = ui.item[0].id;
       var num= $("#"+item_id).parents('.cat_column').attr('id');
       num=num.split('_');
       //console.log(num);
      var cid= $("#"+item_id).data('catid');
       $("#"+item_id).find('.child_click').attr('onclick','getChildCats('+cid+','+num[1]+')');
    }
  });
     $( "#catlist_section li" ).disableSelection();
    $('#catlist_section').scrollLeft(wdth);
    
  });
    }

  })
	

}
</script>
  
 
    

 