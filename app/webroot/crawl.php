<?php 
ini_set('memory_limit','50000M');
ini_set('max_execution_time','100000');

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

//$Dispatcher = new Dispatcher();
include(__dir__.'\..\Vendor\crawl\init.php');


print_r($argv);
$dir=__dir__;
echo $dir;
$data=array(
	'merchant_id'=>$argv[1],
	'merchant_url'=>$argv[2],
	'merchant_path'=>$argv[3]
	);
$crawl=new CrawlInit($data);
$retdata= $crawl->start()->save();
$time_end = microtime_float();
$time=$time_end - $time_start;
/*$myfile = fopen($dir.'\final.html', "w");
fwrite($myfile, $time."\nsuccess\n");*/
$file = fopen($dir."/log.html","w");
//print_r($file);
echo fwrite($file, '0');
fclose($file);
$file = fopen($dir."/final.html","w");
//print_r($file);
echo fwrite($file, $time."/nsuccess/n".json_encode($retdata));
fclose($file);

//file_put_contents($dir.'\final.html', $time."/nsuccess/n".json_encode($retdata));
/*file_put_contents($dir.'\log.html','0');*/
?>