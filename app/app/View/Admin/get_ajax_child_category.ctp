<style>
	#fade{
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index:1001;
    -moz-opacity: 0.7;
    opacity:.70;
    filter: alpha(opacity=70);
}
#move_popup{
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300px;
    height: 135px;
    margin-left: -150px;
    margin-top: -100px;                 
    padding: 10px;
    border: 2px solid #FFF;
    background: #fff;
    z-index:1002;
    overflow:visible;
}
.close-popup
{
float: right;
background: #1e5ac5;
background: #ED9205;
width: 19px;
color: #fff;
border-radius: 20px;
height: 19px;
line-height: 21px;
text-align: center;
font-family: sans-serif;
font-size: 11px;
cursor: pointer;
position: relative;
top: -7px;
right: -7px;
}
#Product_categoryGetAJAXCategorysChildForm{padding:20px 1em 1em 1em;}
.select label {
font-family: 'Droid Sans', sans-serif;
position: inherit;
color: #252525;
width: 100%;
display: block;
font-size: 13px;
padding-bottom: 4px;
}
#cat_list {
-moz-transition: background-color 0.2s ease 0s;
background: none repeat scroll 0 0 #FAFAFA;
border: 1px solid #BEBEBE;
color: #333333;
font-size: 1em;
margin: 0;
width:100%;
background: none repeat scroll 0 0 #FAFAFA;
border: 1px solid #BEBEBE;
border-radius: 3px 3px 3px 3px;
/* box-shadow: 0 1px 4px 0 rgba(190, 190, 190, 0.6) inset; */
padding: 7px 5px;
outline:none;
margin-top: 5px;
}
.submit input[type=submit]
{
background: #EE932F;
border: 0 none;
border-radius: 4px 4px 4px 4px;
color: #FFFFFF;
cursor: pointer;
display: inline-block;
font: 14px calibri;
padding: 6px 16px;
text-align: center;
font-weight: bold;
width: auto;
outline: none;
text-shadow: none;
height: auto;
margin-top: 10px;
}
</style>      
<div id="move_popup">
	<span class="close-popup" onClick="lightbox_close();">X</span>
	<?php
		echo $this->Form->create('Product_category', array('url' => array('controller' => 'Admin', 'action' => 'getAJAXCategorysChild')));
		echo "<h3>".$this->Form->input('Category Name', array('options' => $cat_nm,'id'=>'cat_list','name'=>'data[Product_category][new_cat_id]'))."</h3>";
		echo $this->Form->input('Old cat id', array('type' => 'hidden','id'=>'old_cat_id','name'=>'data[Product_category][old_cat_id]', 'value'=>''));
		echo $this->Form->submit('Move');
		echo $this->Form->end();
	?>
</div>
<div id="fade" onClick="lightbox_close();"></div>		 
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
                            <a href="<?=$this->webroot?>admin/active_product_cat/<?php echo $val['Product_category']['id'];?>">
								<input type="image" src="<?=$this->webroot?>images/dashbord/inactive.png" title="Active">
							</a>
                        <?php }
                        if($val['Product_category']['status'] == 1)
                        {?>
                            <a href="<?=$this->webroot?>admin/inactive_product_cat/<?php echo $val['Product_category']['id'];?>">
								<input type="image" src="<?=$this->webroot?>images/dashbord/active.png" title="Inactive">
							</a>
                        <?php }?>
						<a href="#" onclick="move_cat_popup_open(<?php echo $val['Product_category']['id'];?>);">
							<input type="image" src="<?=$this->webroot?>images/dashbord/move_icon.png" title="Move">
						</a>
                        <a target="_blank" href="<?=$this->webroot?>admin/update_product_cat/<?php echo $val['Product_category']['id'];?>">
							<input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit">
						</a>
                        <a href="<?=$this->webroot?>admin/delete_product_cat/<?php echo $val['Product_category']['id'];?>" onclick="return confirm('Are you sure to delete this category?');">   
							<input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete">
						</a>
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

 


<script type="text/javascript">
	function move_cat_popup_open(id){
		window.scrollTo(0,0);
		document.getElementById('move_popup').style.display='block';
		document.getElementById('fade').style.display='block';
		$("#old_cat_id").val(id);
	}
	function lightbox_close(){ 
		document.getElementById('move_popup').style.display='none';
		document.getElementById('fade').style.display='none';
		$("#old_cat_id").val('');
	}
	
	window.document.onkeydown = function (e){
		if (!e){
			e = event;
		}
		if (e.keyCode == 27){
			lightbox_close();
		}
	}
</script>