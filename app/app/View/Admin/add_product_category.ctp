<?php $data=isset($product_cat_data)?$product_cat_data:""; 
      //print_r($data);
       @ extract($data['Product_category']);
        @ extract($data);
        $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1';
        if(isset($Product_category_lang)){
        foreach($Product_category_lang as $val){
          if($val['lang_id']==$lang_id)
          {
            $Product_category_lang1=$val;
          }
        }
      }
        @$cid=$id;
        unset($id);
        @extract($Product_category_lang1);
      //  print_r($Product_category_lang1);
    ?>
    <?php /*?><script type="text/javascript">
 
$(function(){
$("#autocomplete").autocomplete({
        delay: 500,
        minLength: 3,
        source: function(request, response) {
          //alert(request.term);
          $.getJSON("<?=$this->webroot?>products/getCategoryByName/"+request.term, {            
            ajax: "true",           
            page_limit: 10
          }, function(data) {
            // data is an array of objects and must be transformed for autocomplete to use
           
            var array = data.error ? [] : $.map(data, function(m) {
              return {
                label: m.label,
                value: m.value,                
              };
            });
            response(array);
          });
        },
        focus: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          //$(this).val(ui.item.label);
        },
        select: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // navigate to the selected item's url
          //window.open(ui.item.url);
          $(this).val(ui.item.label);
          $("#autocomplete2-value").val(ui.item.value);
        }
      }).data("ui-autocomplete")._renderItem = function(ul, item) {
        var $a = $("<a></a>").text(item.label);
        highlightText(this.term, $a);
        return $("<li></li>").append($a).appendTo(ul);
      };
function highlightText(text, $node) {
        var searchText = $.trim(text).toLowerCase(), currentNode = $node.get(0).firstChild, matchIndex, newTextNode, newSpanNode;
        while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
          newTextNode = currentNode.splitText(matchIndex);
          currentNode = newTextNode.splitText(searchText.length);
          newSpanNode = document.createElement("span");
          newSpanNode.className = "highlight";
          currentNode.parentNode.insertBefore(newSpanNode, currentNode);
          newSpanNode.appendChild(newTextNode);
        }
      }
})

</script><?php */?>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
 <article class="module width_full">
      <header><h3><?=$admin_button?> Product Department</h3>

      <a href="<?=$this->webroot?>admin/product_category_manager" class="heading_link">View Department Lists</a>
      <!--<a href="<?=$this->webroot?>admin/faq_manager" class="heading_link">View Product Lists</a>-->
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:100%;">
            <?php if(isset($cid)){ ?>
        <form>
           <table>
                  <tr>
                    <td style="width: 15%;">
                   <label>Choose Language
                     <span class="small">Select Language</span>
                   </label>
                    </td>
                    <td>
                   

                      <select name="lang_id" id="lang_id" onchange="this.form.submit();" style="width: 185px;">
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
         <?php } else{
         ?>
            <form>
                <table>
                    <tr>
                      <td style="width: 15%;">
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
         <?php
          
         }
            ?>
              <form method="post" name="Image" enctype="multipart/form-data" action=""> 
                <input type="hidden" name="lang_id" value="<?=$lang_id?>"/>
                 <input type="hidden" name="cat_lang_id" value="<?=@$id?>"/>
                <table>
                  <tr>
                    <td style="width: 15%;">
                   <label>Department Name
                     <span class="small">Add Department Name</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="category_name" placeholder="Enter Department." value="<?=isset($category_name)?$category_name:""?>">
                  </td>
                 </tr>
                  <tr>
                  <td>
                 <label>Description:
                     <span class="small">Add Description.</span>
                   </label>
                   </td>
                    <td>
                    <style>
                      iframe{
                        border-bottom: 1px solid #000 !important;
                        border-radius:5px;
                        margin-bottom: 5px !important;
                        margin-top: 5px !important;
                      }
                    </style>
                    <?php
                  //  echo $this->Fck->fckeditor(array('description'), $this->html->base, isset($Product_category_lang1['description'])?htmlspecialchars_decode($Product_category_lang1['description']):""); 
                   
                    ?>
                    <textarea name="description"><?=isset($Product_category_lang1['description'])?$Product_category_lang1['description']:""?></textarea>
                  </td>
                   </tr>
                   <?php if(isset($image_url) and $image_url!=""){ ?>
                        <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image.</span>
                        </label>  
                        </td>
                        <td>
                         
                        <img src="<?=isset($image_url)?$this->webroot.$image_url:""?>" style="height:100px"/>
                        </td>
                        </tr>
                    <?php } ?>
                 
                    <tr>
                      <td>
                    <label>Department Image
                     <span class="small">Add Department Image</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($image_url)?'':''?> name="cat_image" placeholder="Choose image">     
                  </td>
                   </tr>
                   <?php if(isset($icon_url) and $icon_url!=""){ ?>
                        <tr>
                        <td>
                        <label>Uploaded Icon
                         <span class="small">current Icon.</span>
                        </label>  
                        </td>
                        <td>
                         
                        <img src="<?=isset($icon_url)?$this->webroot.$icon_url:""?>" style="height:16px"/>
                        </td>
                        </tr>
                    <?php } ?>
                    <tr>
                      <td>
                    <label>Department Icon
                     <span class="small">Add Department Icon</span>
                    </label> 
                    </td>
                    <td>                   
                    <input type="file" value="" <?=isset($icon_url)?'':''?> name="cat_icon" placeholder="Choose Icon">     
                  </td>
                   </tr>
                   <tr>
                    <td>
                    <label>Parent:
                     <span class="small">Choose Department Parent</span>
                   </label>
                   </td>
                    <td>
                      <?php //if(!isset($id)){?>
                   <!-- <input size="30" type="text" name="parent" required="" id="autocomplete" value=""  class="form-text hasPlaceholder anpHintable" data-hint-num="0" placeholder="Choose Parent">
                   <input id="autocomplete2-value" value="" type="hidden" name="parent_id">
                                    <span class="loading"></span>
                                    <?php //} else { ?>
                       <!-- <pre><?php //print_r($chield_ids)?></pre>-->
                     <?php /*?><select name="parent_id" requred>
                      <option value="">Choose Parent</option>
                      <?php 

                      foreach ($product_cat_names as $key => $value) { ?>                      
                        <option value="<?=$key?>" <?php echo $this->Template->Select($key,isset($parent_id)?$parent_id:"");?>><?=$value?></option>
                        <?php  } ?>
                     
                    </select><?php */?>
                     <?php // } ?>
                     
                     
					   <?php $ccount = 1;	
                       if(!empty($product_cat_info))
                       {
							if(isset($all_parentid))
							{
								//echo '<pre>'; print_r($all_parentid); echo '</pre>';  exit;
								
								$ccount = count($all_parentid);
								$parent_count = count($all_parentid)-1;
								$pi = 0;
								foreach($all_parentid as $pid)
								{
									$pi++;
									if($pi < $parent_count)
									{?>
                                	<input type="hidden" id="parent_<?php echo $pi;?>" value="<?php echo $pid['Product_category']['id'];?>" />
                                <?php }
								}
							}
							else
							{
								$count = 1;	
								$parent_count = 0;
							}?>
                            <input type="hidden" id="parent_count" value="<?php echo $parent_count;?>" />
                            <input type="hidden" id="ccount" value="<?php echo $ccount;?>" />
                            <div id="catlist_section" style="width:800px;border: 1px solid #999;margin-left: 10px;">
                            <div class="column-view-composition" id="catlist_section_list">
                                <div class="cat_column" id="catlist_0"> 
                                    <ul>
										<?php    
                                       foreach($product_cat_info as $key=>$val) 
                                       { 
                                            $children = '';
                                            $children = $this->Template->getAdminCategoryChidren($val['Product_category']['id'],$lang_id);?>
                                        
                                            <li class="cat_li" id="cat_li_<?php echo $val['Product_category']['id'];?>">
                                                <div class="cname" style="width:auto;">
                                                    <input type="radio" name="parent_id" value="<?php echo $val['Product_category']['id'];?>" <?php if(isset($parent_id) && ($parent_id == $val['Product_category']['id'])){echo 'checked="checked"';}?> style="width:auto;" />&nbsp;
                                                    <?php echo htmlspecialchars_decode($val['Product_category_lang']['category_name']);?>
                                                </div>
                                                <div class="cat_action">
                                                    <?php
                                                    if(!empty($children))
                                                    {?>
                                                        <a href="javaScript:void(0);" onclick="getChildCats('<?php echo $val['Product_category']['id'];?>',0);"><i class="icon-chevron-right"></i></a>
                                                    <?php }?>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </li>
                                         
                                        <?php } 
										
										?>
                                        
									</ul>
								</div>
                                
                                <?php 
								if(!empty($all_parentid))
								{
									$i = 0; //print_r($all_parentid); exit;
									foreach($all_parentid as $parent_data)
									{
										$parent_id_val = $parent_data['Product_category']['id'];
										if($i<($parent_count-1))
										{
											?>
                                        
                                            <div class="cat_column" id="catlist_<?php echo ($i+1);?>">
                                                <ul>
                                                    <?php   
												   $sub_children = '';
												   $sub_children = $this->Template->getAdminCategoryChidren($parent_data['Product_category']['id'],$lang_id); 
                                                   foreach($sub_children as $key=>$val) 
                                                   { 
                                                        
														$li_class = '';
														
														if($parent_id_val == $val['Product_category']['parent_id'])
														{
															$li_class = ' active';
														}
														$children = '';
                                                        $children = $this->Template->getAdminCategoryChidren($val['Product_category']['id'],$lang_id);?>
                                                    
                                                        <li class="cat_li <?php // echo $li_class;?>" id="cat_li_<?php echo $val['Product_category']['id'];?>">
                                                            <div class="cname" style="width:auto;">
                                                                <input type="radio" name="parent_id" value="<?php echo $val['Product_category']['id'];?>" <?php if(isset($parent_id) && ($parent_id == $val['Product_category']['id'])){echo 'checked="checked"';}?> style="width:auto;" />&nbsp;
                                                                <?php echo htmlspecialchars_decode($this->Template->getProductCategoryTitle($val['Product_category']['id']));?>
                                                            </div>
                                                            <div class="cat_action">
                                                                <?php
                                                                if(!empty($children))
                                                                {?>
                                                                    <a href="javaScript:void(0);" onclick="getChildCats('<?php echo $val['Product_category']['id'];?>','<?php echo $i;?>');"><i class="icon-chevron-right"></i></a>
                                                                <?php }?>
                                                            </div>
                                                            <div style="clear:both;"></div>
                                                        </li>
                                                     
                                                    <?php //exit; 
													} 
                                                    
                                                    ?>
                                                    
                                                </ul>
                                            </div>
                                		
                                <?php   } $i++;
									}
								}
								?>
                            </div>
                        </div>
					  <?php }?>
                     
                     
                     
                     
                    </td>                 
                    </tr>
                   
                      <tr>
                  <td>
                 <label>Meta Description:
                     <span class="small">Add Meta Description.</span>
                   </label>
                   </td>
                    <td>
                   
                    <textarea name="meta_description"><?=isset($Product_category_lang1['meta_description'])?$Product_category_lang1['meta_description']:""?></textarea>
                  </td>
                   </tr>
                  
                     <tr>
                  <td>
                 <label>Meta Keyword:
                     <span class="small">Add Meta Keyword.</span>
                   </label>
                   </td>
                    <td>
                   
                    <textarea name="meta_keyword"><?=isset($Product_category_lang1['meta_description'])?$Product_category_lang1['meta_keyword']:""?></textarea>
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
<script type="text/javascript">

$(document).ready(function(){
	
	/*var pcount = $('#parent_count').val();
	
	if(pcount > 0)
	{
		//alert(pcount);	
		
		for(var i = 1; i<pcount; i++)
		{
			
			catid = $('#parent_'+i).val();
			var cno = parseInt(i)-1;
			getChildCats(catid,cno);
			
		}
	}*/
	
	
<?php /*?><?php
if(isset($all_parentid))
{
	?>
	var i=0;
	var total = '<?php echo ($ccount-1);?>';
	//alert(total);
	<?php 
	foreach($all_parentid as $pid)
	{?>
		var catid = '<?php echo $pid['Product_category']['id'];?>';
		//alert(i);
		//alert(catid);
		if((parseInt(i)+1) < total)
		{
			getChildCats(catid,i);
			i++;
		}
		
<?php }
}
?>
<?php */?>});

function getChildCats(catid,cno)
{
	//alert(catid);
	var lang_id = $('#lang_id').val();
	
	var cno2 = parseInt(cno)+1;
	
	$('#catlist_section_list').append('<div id="loading_'+catid+'" class="cat_loading"><br><img src="<?=$this->webroot?>images/ajax-loader.gif" /></div>');
	
	var cnt = parseInt($('#ccount').val());
	
	var url = '<?=$this->webroot?>admin/getAJAXCategorysChildForm/'+lang_id+'/'+catid+'/'+cno2+'<?php if(isset($parent_id))echo '/'.$parent_id;?>';
	
	$('#catlist_'+cno+' .cat_li').removeClass('active');
	
	$('#cat_li_'+catid).addClass('active');
	
	for(var i = cno2; i<= cnt; i++)
	{
		$('#catlist_'+i).remove();	
	}	
	
	$.get(url,function(data)
	{
		$('.cat_column').last().after(data);
		 
		$('#loading_'+catid).remove();
		
		$('#ccount').val(cnt+1);
		
		var wdth = $('#catlist_section').width();
		
		$('#catlist_section').scrollLeft(wdth);
		
	});
}
</script>
<style>
#stylized input, #stylized textarea
{
	width:50%;
}
</style>