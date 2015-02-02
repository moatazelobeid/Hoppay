       
		 
 <?php 
if(count($catlist) > 0)
{
    ?>
    <div class="cat_column" id="catlist_<?php echo $cno;?>" data-pid="<?php echo $pid;?>">
        <ul class="sortable-list">

           <?php foreach($catlist as $key=>$val) 
           { 
                $children = '';
				$children = $this->Template->getCategoryChidren($val['Product_category']['id']);?>
            
                <li class="cat_li" id="cat_li_<?php echo $val['Product_category']['id'];?>" data-catid="<?php echo $val['Product_category']['id'];?>">
              <?php /* ?>      <script>
                    $(function(){
                        $( "#cat_li_<?php echo $val['Product_category']['id'];?>" ).droppable({
        accept: ".cat_li",
        activeClass: "ui-state-hover",
        hoverClass: "ui-state-active",
        over: function( event, ui ) {
          event.preventDefault();
        
            var child_click=$(this).find('.child_click');      
            if(child_click.is(':visible'))
            {
               t=setTimeout(function(){
                  child_click.click();
              },1000)
              
            }
         
         
         //$( "#catlist_section .sortable-list" ).sortable( "disable" );
        },
        out:function(){
          clearTimeout(t);
          //$( "#catlist_section .sortable-list" ).sortable( "enable" );
        },
        drop:function( event, ui ) {
         
            var catid=$(this).data('catid');
            var sort=0;
            console.log(catid);
          
        }

      });
                    })

                    </script><?php */?>
                    <div class="cname"  data-catid="<?=$val['Product_category']['id']?>" data-lang="<?=$val['Product_category_lang']['lang_id']?>" ondblclick="getEditOption(this,'<?=$val['Product_category']['id']?>','<?=$val['Product_category_lang']['lang_id']?>');"><?php echo htmlspecialchars_decode($val['Product_category_lang']['category_name']);?></div>
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
                            <a href="javaScript:void(0);" class="child_click" onclick="getChildCats('<?php echo $val['Product_category']['id'];?>','<?php echo $cno;?>');"><i class="icon-chevron-right"></i></a>
                        <?php }?>
                    </div>
                    <div style="clear:both;"></div>
                </li>
             
            <?php } ?>
        </ul>
    </div>
<?php } ?>
