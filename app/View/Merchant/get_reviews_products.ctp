<?php
if(!empty($products))
{
	//echo '<pre>'; print_r($products);
	echo '<ul>';
	foreach($products as $product)
	{
		?>
		<li onclick="getPslug('<?php echo str_replace('-', ' ', $product['Product']['slug']);?>');"><?php echo str_replace('-', ' ', $product['Product']['slug']);?></li>
		<?php 
	}
	echo '</ul>';
}
?>