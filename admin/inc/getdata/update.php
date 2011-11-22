<?php
include "../../../fungsi/db_koneksi.php";

$id = addslashes($_GET['id']);
$page = $_GET['page'];

if($page == "member"){
	$qcek = mysql_query("SELECT * FROM t_member WHERE id_member = $id");
	$dcek = mysql_fetch_array($qcek);
	if($dcek['status_member'] == 1){
	mysql_query("UPDATE t_member SET status_member = '0'
				WHERE id_member = $id") or die(mysql_error());
	}
	elseif($dcek['status_member'] == 0){
	mysql_query("UPDATE t_member SET status_member = '1'
				WHERE id_member = $id") or die(mysql_error());
	}	
}
elseif($page == "kota"){
	$qcek = mysql_query("SELECT * FROM kota WHERE id_kota = $id");
	$dcek = mysql_fetch_array($qcek);
	if($dcek['cod'] == 1){
	mysql_query("UPDATE kota SET cod = '0'
				WHERE id_kota = $id") or die(mysql_error());
	}
	elseif($dcek['cod'] == 0){
	mysql_query("UPDATE kota SET cod = '1'
				WHERE id_kota = $id") or die(mysql_error());
	}	
}
?>