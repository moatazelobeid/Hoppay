<?php ini_set('max_execution_time', 600);?>

<?php 
//echo '<pre>'; print_r($catlist); echo '<pre>';
if(!empty($catlist))
{
	$i = 0;
	// $this->Product_category = ClassRegistry::init('Product_category');
	?>
	<ul class="hidepanel1" id="child_list_<?php echo $pid;?>" style="display:none;">
	<?php 
	foreach($catlist as $child)
	{
		//echo '<pre>'; print_r($child); echo '<pre>';
		$countprod=$this->Template->GetProductCountBycategory($child['Product_category']['id']);
		
		$pcat_lang_data = '';
		$pcat_lang_data = $this->Template->languageChanger($child['Product_category_lang']);
		$catname = stripslashes($pcat_lang_data['category_name']);
		
		//$catname = stripslashes($child['Product_category_lang'][0]['category_name']);
		$catslug = $child['Product_category']['slug'];
		
		if(strlen($catname) > 30) 
			$dcatname = substr($catname,0,30).'..';
		else
			$dcatname = $catname;
			
		$ctitle_link = '<a href="'.$this->webroot.$this->Template->getLang().'/products/category-'.$catslug.'" >
				  '.$catname.' '.'('.$countprod.')</a>';
				  
		$sub_children = $this->Template->getCategoryChidren($child['Product_category']['id']);		  
		if(empty($sub_children))
		{
			?><li><?php echo $ctitle_link;?></li><?php
		}
		else
		{
			?><input type="hidden" id="hchild_val_<?php echo $child['Product_category']['id'];?>" value="0" />
            <li class="has_child1" id="hchild_<?php echo $child['Product_category']['id'];?>">
            <span onclick="displaySubChilds('<?php echo $child['Product_category']['id'];?>');" id="has_child_icon_<?php echo $child['Product_category']['id'];?>">
            	<img src="<?=$this->webroot?>images/plus.png" />
            </span>
			<?php echo $ctitle_link;?></li><?php
		}
	}
	?>
	</ul>
	<?php 
}?>


         