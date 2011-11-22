<?php
include "../../fungsi/db_koneksi.php";

$idkota = addslashes($_GET['idkota']);
$kota=mysql_fetch_array(mysql_query("Select nama_kota FROM t_kota WHERE id_kota=$idkota"));
$qjenis = mysql_query("SELECT * 
						 FROM t_jeniskirim a, t_forwarder b, t_ongkir c
						 WHERE a.id_forwarder=b.id_forwarder
						 AND a.id_jeniskirim=c.id_jeniskirim
						 AND c.id_kota=$idkota
						 GROUP BY a.id_jeniskirim");
echo "<option value=''>-- Pilih Jenis Pengiriman --</option>";
$jml=mysql_num_rows($qjenis);
if ($jml ==0) { 
	echo "<option value=''>Tidak Ada Pengiriman Ke $kota[nama_kota]</option>";	
}
else {
while($djenis = mysql_fetch_array($qjenis)){
	echo "<option value='$djenis[id_jeniskirim]'>$djenis[nama_forwarder] - $djenis[nama_jeniskirim] : Rp. $djenis[harga_ongkir]</option>";	
}
}
?>