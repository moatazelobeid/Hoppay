         
		 
 <?php 
if(count($catlist) > 0)
{
    ?>
    <div class="cat_column" id="catlist_<?php echo $cno;?>">
        <ul>
           <?php foreach($catlist as $key=>$val) 
           { 
                $children = '';
				$children = $this->Template->getCategoryChidren($val['Product_category']['id']);?>
            
                <li class="cat_li" id="cat_li_<?php echo $val['Product_category']['id'];?>">
                    <div class="cname" style="width:auto;">
                        <input type="radio" name="parent_id" value="<?php echo $val['Product_category']['id'];?>" style="width:auto;"  <?php if(isset($parent_id) && ($parent_id == $val['Product_category']['id'])){echo 'checked="checked"';}?> />&nbsp;
                        <?php echo htmlspecialchars_decode($val['Product_category_lang']['category_name']);?>
                    </div>
                    <div class="cat_action">
                        <?php
                        if(!empty($children))
                        {?>
                            <a href="javaScript:void(0);" onclick="getChildCats('<?php echo $val['Product_category']['id'];?>','<?php echo $cno;?>');"><i class="icon-chevron-right"></i></a>
                        <?php }?>
                    </div>
                    <div style="clear:both;"></div>
                </li>
             
            <?php } ?>
        </ul>
    </div>
<?php } ?>
