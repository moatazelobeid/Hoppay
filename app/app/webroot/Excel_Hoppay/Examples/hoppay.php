<?php

/*
 * PHP Excel - Read a simple 2007 XLSX Excel file
 */

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('America/Los_Angeles');
?>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<?php
ini_set('max_execution_time','50000');

require_once '../Classes/PHPExcel/IOFactory.php';

$con=mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
mysql_select_db('menacompare_demo1');

// Check connection
if (mysql_errno()) {
  echo "Failed to connect to MySQL: " . mysql_error();
}

/*'host' => 'localhost',
		'login' => 'menacompare_demo',
		'password' => 'nEPQX.BBTEqd',
		'database' => 'menacompare_demo1',*/
		
$inputFileName = 'hoppay_new.xlsx';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
    . '": ' . $e->getMessage());
}

for ($x = 0; $x <= 4; $x++) {

	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet($x);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
	
	//  Loop through each row of the worksheet in turn
	for ($row = 1; $row <= $highestRow; $row++) {
		
		//  Read a row of data into an array
		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		
		$first_en = mysql_real_escape_string(trim($rowData[0][0]));
		$first_ar = trim($rowData[0][1]);
		if($first_ar <> "" && $first_en <> ""){
			
			# Check english category is exist or not
			$en_qry = mysql_query("select * from mc_product_category_langs where lang_id='1' And category_name='$first_en'");
			$en_res = mysql_fetch_array($en_qry);
			$cat_id = $en_res["cat_id"];
			
			# If found in the database
			if($cat_id > 0){
				
				# Check arabic category is exist in  or not
				$ar_qry = mysql_query("select * from mc_product_category_langs where lang_id='2' And cat_id='$cat_id'");
				$ar_res = mysql_fetch_array($ar_qry);
				if($ar_res["category_name"] == ""){
					
					# insert new records for Arabic
					echo $in_str = "insert into mc_product_category_langs set cat_id='$cat_id',lang_id='2',category_name='$first_ar',description='$first_ar'";
					echo '<br>';
					echo '<br>';
					mysql_query($in_str);
				}else{
					
					# update new records for Arabic
					echo $in_str = "update mc_product_category_langs set category_name='$first_ar',description='$first_ar' where lang_id='2' And cat_id='$cat_id'";
					echo '<br>';
					echo '<br>';
					mysql_query($in_str);
				}
			}
		}
		
		/*foreach($rowData[0] as $k=>$v){        
			//echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
		}*/
	}

}
//echo 'ok';
?>