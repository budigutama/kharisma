<?php
session_start();
include "../../../fungsi/db_koneksi.php";

if(isset($_GET['id']))
	$id = addslashes($_GET['id']);
	
if(isset($_GET['table']))
{
	switch($_GET['table']){
		case "admin"		: $table = "t_admin"; $field = "id_admin = $id";break;
		case "kategori"		: $table = "t_kategori"; $field = "id_kategori = $id";break;
		case "member"		: $table = "t_member"; $field = "id_member = $id";break;
		case "kota"			: $table = "t_kota"; $field = "id_kota = $id";break;
		case "provinsi"		: $table = "t_provinsi"; $field = "id_provinsi = $id";break;
		case "produk"		: $table = "t_produk"; $field = "id_produk = $id";break;
		case "detailproduk"	: $table = "t_detailproduk"; $field = "id_detailproduk = $id";break;
		case "warna"		: $table = "t_warna"; $field = "id_warna = $id";break;
		case "ukuran"		: $table = "t_ukuran"; $field = "id_ukuran = $id";break;
		case "kurs"			: $table = "t_kurs"; $field = "id_kurs = $id";break;
		case "rekening"		: $table = "t_rekening"; $field = "id_rekening = $id";break;
		case "ongkir"		: $table = "t_ongkir"; $field = "id_ongkir = $id";break;
		case "forwarder"	: $table = "t_forwarder"; $field = "id_forwarder = $id";break;
		case "jeniskirim"	: $table = "t_jeniskirim"; $field = "id_jeniskirim = $id";break;
	}
	 mysql_query("DELETE FROM $table
				WHERE $field") or die(mysql_error());	
	
	if($table == 't_provinsi'){
			mysql_query("DELETE FROM t_kota WHERE id_provinsi = $id");
	}
	elseif($table == 't_produk'){
			mysql_query("DELETE FROM t_produkdetail WHERE id_produk = $id");
	}
	elseif($table == 't_forwarder'){
			mysql_query("DELETE FROM t_jeniskirim WHERE id_forwarder = $id");
	}
}
			
?>