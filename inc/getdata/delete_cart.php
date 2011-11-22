<?php
session_start();
include "../../config/dbconnection.php";

if(isset($_GET['idp']))
	$idp = addslashes($_GET['idp']);
	
mysql_query("DELETE FROM pembelian
			WHERE id_pembelian = $idp
			AND session_id = '".session_id()."'") or die(mysql_error());
?>