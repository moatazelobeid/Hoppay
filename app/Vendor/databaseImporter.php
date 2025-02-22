<?php
/*
* phpMyImporter
* -------------
* Version: 1.00
* Copyright (c) 2009 by Micky Holdorf
* Holdorf.dk/Software - micky.holdorf@gmail.com
* GNU Public License http://opensource.org/licenses/gpl-license.php
*
*/

/*
phpMyImporter is a php class, that can be used to import database tables into a MySQL database from a sql file. This is useful if filesize of the sql file is too large to be imported with phpMyAdmin. 
*/

class phpMyImporter {
	/**
	* @access private
	*/
	var $database = null;
	var $connection = null;
	var $compress = null;
	var $utf8 = null;

	var $importFilename = null;

	/**
	* Class constructor
	* @param string $db The database name
	* @param string $connection The database connection handler
	* @param boolean $compress It defines if the output/import file is compressed (gzip) or not
	* @param string $filepath The file where the dump will be written
	*/
	function phpMyImporter($connection=null, $filepath, $compress=false) {

        $this->connection = $connection;
		$this->compress = $compress;
		$this->importFilename = $filepath;

		$this->utf8 = true;

		//return $this->setDatabase($db);
	}

	/**
	* Sets the database to work on
	* @param string $db The database name
	*/
	function setDatabase($db){
		$this->database = $db;
		if ( !@mysql_select_db($this->database) )
			return false;
		return true;
  	}

	/**
	* Read from SQL file and make sql query
	*/
	function importSql($file) {
		// Reading SQL from file
		//echo "Reading SQL from file '".$this->importFilename."': ";
		if ($this->compress) {
			$lines = gzfile($file);
		}
		else {
			$lines = file($file);
		}
		//echo " DONE!\n";

		//echo "Importing SQL into database '".$this->database."': ";
        $x = 0;
		$importSql = "";
		$procent = 0;
		foreach ($lines as $line) {
			//Print progress
			$x++;
			$numOfLines = count($lines);
			if ($x%(int)($numOfLines/20) == 0) {
				$procent += 5;
				if ($procent%25 == 0){
                    echo "$procent%";
                    echo "<script>alert('$procent%');</script>";
                }
				else echo ".";
			}

			// Importing SQL
			$importSql .= $line;
			if ( substr(trim($line), strlen(trim($line))-1) == ";" ) {
                $importSql = stripslashes($importSql);
                $query=$this->connection->query($importSql);               
				//$query = @mysql_query($importSql,$this->connection);
				if (!$query)
					return false;
				$importSql = "";
			}
		}
		return true;
	}

	/**
	* Import SQL file into selected database
	*/
	function doImport() {		
//		if ( !$this->setDatabase($this->database) )
//			return false;
        
		if ( $this->utf8 ) {
			$encoding=$this->connection->query("SET NAMES 'utf8'");
			//$encoding = @mysql_query("SET NAMES 'utf8'", $this->connection);
		}

		if ( $this->importFilename ) {
			$import = $this->importSql($this->importFilename);			
			if (!$import) 
				return true;
			else 
				return true;
			
		}
		else {
			return false;
		}
	}
}
?>