<?php
session_start(); ob_start();
include('db.php');
if(isset($_REQUEST['site_id'])){
		$site_id = $_REQUEST['site_id'];
	
	# remove all crawl_start_date crawl_end_date
	mysql_query("update mc_merchants_new set crawl_start_date='0000-00-00 00:00:00',crawl_end_date='0000-00-00 00:00:00'");
	
	# update crawl_start_date
	mysql_query("update mc_merchants_new set crawl_start_date=now(),site_id='$site_id' where id='$site_id'");
	
	if($site_id == 1){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/souq_en_ar.php');
	}elseif($site_id == 2){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/markavip_en_ar.php');
	}elseif($site_id == 3){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/namshi_en_ar.php');
	}elseif($site_id == 4){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/ikea_en_ar.php');
	}elseif($site_id == 5){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/sukar_en_ar.php');
	}elseif($site_id == 6){
		exec('wget '.$_SERVER['HTTP_HOST'].'/crawling_beta/extrastores_en_ar.php');
	}
}			
?>