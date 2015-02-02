<?php
ob_start();
session_start();

if(isset($_SESSION['hoppay_id'])){
	
	session_destroy();
	
	header('Location:.');
	exit;
}