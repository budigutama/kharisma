<?php
include "../../fungsi/db_koneksi.php";

$idprov = addslashes($_GET['idprov']);
$qkota = mysql_query("SELECT * FROM t_kota
					 WHERE id_provinsi = $idprov");
echo "<option value=''>-- Pilih Kota --</option>";
while($dkota = mysql_fetch_array($qkota)){
	echo "<option value='$dkota[id_kota]'>$dkota[nama_kota]</option>";	
}
?>