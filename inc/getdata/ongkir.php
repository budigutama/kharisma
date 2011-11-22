<?php
include "../../fungsi/db_koneksi.php";

if (isset($_GET['idkota']))
	$idkota = addslashes($_GET['idkota']);
if (isset($_GET['jenis']))
	$jenis = addslashes($_GET['jenis']);
if (isset($_GET['jml']))
	$jml = addslashes($_GET['jml']);
	
if ($jenis != 'undefined'){
	$ongkir=mysql_fetch_array(mysql_query("SELECT harga_ongkir harga FROM t_ongkir 
										   WHERE id_jeniskirim=$jenis
										   AND id_kota=$idkota"));
	$total =$ongkir['harga']*$jml;
	echo "<b>$jml Kg x Rp. ".number_format($ongkir['harga'],"0",".",",")."</b><br>";
	echo "<input type='text' name='ongkir' id='ongkir' value='$total' >";
}
?>