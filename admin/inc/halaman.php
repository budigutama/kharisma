<?php
if(isset($_GET['page'])){
	switch($_GET['page']){
		case "home"					: include "inc/home.php";break;
		case "admin"				: include "inc/admin.php";break;
		case "kategori"				: include "inc/kategori.php";break;
		case "merek"				: include "inc/merek.php";break;
		case "produk" 				: include "inc/produk.php";break;
		case "detailproduk" 		: include "inc/detailproduk.php";break;
		case "kota" 				: include "inc/kota.php";break;
		case "provinsi" 			: include "inc/provinsi.php";break;
		case "forwarder" 			: include "inc/forwarder.php";break;
		case "warna" 				: include "inc/warna.php";break;
		case "member" 				: include "inc/member.php";break;
		case "rekening" 			: include "inc/rekening.php";break;
		case "ongkir"	 			: include "inc/ongkir.php";break;
		case "kurs"		 			: include "inc/kurs.php";break;
		case "jeniskirim"	 	    : include "inc/jeniskirim.php";break;
		case "transaksi"			: include "inc/transaksi.php";break;
		case "laporanharian"	 	: include "inc/laporanharian.php";break;
		case "laporanbulanan"	 	: include "inc/laporanbulanan.php";break;
		case "laporantahunan"	 	: include "inc/laporantahunan.php";break;
		case "laporan_produk"	 	: include "inc/laporan_produk.php";break;
		case "editprofile" 			: include "inc/editprofile.php";break;
		case "editpassword"			: include "inc/editpassword.php";break;
		case "logout"					:mysql_query("UPDATE t_admin SET status_login = '0' WHERE id_admin = '$_SESSION[id_admin]'");
										session_destroy();
							  			echo "<script>window.location = 'index.php';</script>";
							 	 		break;
	}
}
else{
	include "inc/home.php"; 
}
?>   
