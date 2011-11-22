<?php
#konfigurasi server
if($_SERVER['SERVER_NAME'] == 'localhost'){
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "kharisma_db";
}
else{
	$host = 'localhost';
	$username = 'kharisma_db';
	$password = 'unikomyes';
	$database = 'kharisma_db';	
}

#koneksi ke database
mysql_connect($host, $username, $password) or die("koneksi gagal.");
mysql_select_db($database) or die("database tidak ditemukan.");

?>
