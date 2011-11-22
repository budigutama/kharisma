<?php
include "../../fungsi/db_koneksi.php";

if(isset($_GET['idb']))
	$idb = addslashes($_GET['idb']);
	
if(isset($_GET['idw']))
	$idw = addslashes($_GET['idw']);

if($idw != 'undefined'){
	if($idw != '-'){
		$qstok = mysql_query("SELECT SUM(stok_detailproduk) as stok FROM t_detailproduk
							 WHERE id_produk = $idb
							 AND id_warna = $idw");
		$dstok = mysql_fetch_array($qstok);
			echo $dstok['stok']." Pcs";	
	}
	else{
		$qstok = mysql_query("SELECT SUM(stok_detailproduk) as stok FROM t_detailproduk
							 WHERE id_produk = $idb");
		$dstok = mysql_fetch_array($qstok);
			echo $dstok['stok']." Pcs";
	}
}
else{
	$qstok = mysql_query("SELECT SUM(stok_detailproduk) as stok FROM t_detailproduk WHERE id_produk = $idb");
	$dstok = mysql_fetch_array($qstok);
		echo $dstok['stok']." Pcs";	
}
?>