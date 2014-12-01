<?php
exec('wget '.$_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php');
//exec('/usr/bin/php /home/moatazelobeid/crawling/souq_en_ar.php 2>&1 &');
//phpinfo();

/*$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";*/

//exec("/usr/bin/php /crawling/souq_en_ar.php > /dev/null 2>&1 &");

exit;
shell_exec('/usr/bin/php -q /crawling/ /dev/null 2>&1 &');
//shell_exec("php -q ".$_SERVER['HTTP_HOST']."/crawling/souq_en_ar.php");

//shell_exec('php /crawling/souq_en_ar.php > /dev/null 2>/dev/null &');

//shell_exec('/usr/bin/php -q /crawling/souq_en_ar.php /dev/null 2>&1 &');
//exit;

//shell_exec('php -q  '.$_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php');

// working
//shell_exec('/usr/bin/curl '.$_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php'); //

// working
//exec('/usr/bin/curl '.$_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php');


// //shell_exec ('php '.$_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php > /dev/null 2>/dev/null &');























///usr/bin/curl
//exec('/usr/bin/php -q  public_html/app/webroot/crawling/souq_en_ar.php');
echo 'ok1';
//echo $_SERVER['HTTP_HOST'].'/crawling/souq_en_ar.php';
//phpinfo();
//mail("maas_kishor@yahoo.in","My subject","hello cron");

/*
/usr/bin/php -q  public_html/app/webroot/crawling/souq_en_ar.php
/usr/bin/php -q  public_html/app/webroot/crawling/markavip_en_ar.php
/usr/bin/php -q  public_html/app/webroot/crawling/namshi_en_ar.php
/usr/bin/php -q  public_html/app/webroot/crawling/ikea_en_ar.php
/usr/bin/php -q  public_html/app/webroot/crawling/sukar_en_ar.php
/usr/bin/php -q  public_html/app/webroot/crawling/extrastores_en_ar.php
*/
/*include('db.php');
	
$qry_cron = mysql_query("select id from mc_merchants_new where site_id > '0'");
$res_cron = mysql_fetch_array($qry_cron);
$site_id = $res_cron['id'];
if($site_id <> 3){ echo "A";exit; }else{ echo "Y";}*/
?>