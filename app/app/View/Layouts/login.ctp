
<?php $cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<?php //echo $cakeDescription ?>
		<?php //echo $title_for_layout; ?>
		Hoppay | Admin Section
	</title>
	<?php
		echo $this->Html->meta('icon');		
		echo $this->Html->css('screen');
		echo $this->Html->css('login/style');
		echo $this->Html->script('jquery-1.4.1.min'); 
		echo $this->Html->script('custom_jquery'); 
	  	echo $this->Html->script('jquery.pngFix.pack');
		echo $this->fetch('script'); 

		echo $this->fetch('meta');
		echo $this->fetch('css');
		
	?>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 <?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>

<!-- End: login-holder -->
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>