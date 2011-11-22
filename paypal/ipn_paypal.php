<?php
// AWAL: Ambil data yang dikirim dari paypal, kemudian buat request untuk validasi pembayaran
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// AKHIR: Ambil data yang dikirim dari paypal, kemudian buat request untuk validasi pembayaran

// AWAL: Kirimkan request kembali ke Paypal
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
// AKHIR: Kirimkan request kembali ke Paypal

// AWAL: Baca semua data dari paypal, simpan ke variable local.
// Nama-nama variable, baca di dokumentasi IPN Guide
$item_name 			= $_POST['item_name'];
$item_number 		= $_POST['item_number'];
$payment_status 	= $_POST['payment_status'];
$payment_amount 	= $_POST['mc_gross'];
$payment_currency 	= $_POST['mc_currency'];
$txn_id 			= $_POST['txn_id'];
$receiver_email 	= $_POST['receiver_email'];
$payer_email 		= $_POST['payer_email'];
$no_pesanan 		= $_POST['invoice'];
$waktu				= $_POST['payment_date'];
$qty				= $_POST['quantity'];
// AKHIR: Baca semua data dari paypal, simpan ke variable local.

if (!$fp) {
// Jika pengiriman validasi gagal, lakukan sesuatu di bawah ini
} else {
	fputs ($fp, $header . $req); // Kirimkan Request
	while (!feof($fp)) {
		$res = fgets ($fp, 1024); // Baca Response
		if (strcmp ($res, "VERIFIED") == 0) { // Jika pembayaran telah terverifikasi
   			/*
			Sebelum melakukan update pembayaran seharusnya ada beberapa validasi:
			- Uang yang dikirim sesuai dengan pesanan?
			- Pesanan sudah dibayar?
			*/
			// AWAL: update data pembayaran
			include "../lib_func/config.php";
   			$sql2="UPDATE detailpembelian
				   SET jenis_pembayaran = 'paypal', status_pengiriman = 'dibayar', no_transaksi_pemesan = '$txn_id', nama_bank_pemesan = 'PAYPAL'
				   WHERE id_detailpembelian = '$no_pesanan'";
			mysql_query("INSERT INTO konfirmasipembayaran VALUES(null,'no_pesanan','PAYPAL','$txn_id','$payment_amount',now())");
   			$res2=mysql_query($sql2);
			// AKHIR: update data pembayaran
			if($res2){
				// AWAL: update stok produk
			  $querymin = mysql_query("SELECT *
										FROM pembelian
										WHERE id_detailpembelian = '$no_pesanan'");
				while($datamin = mysql_fetch_array($querymin)){
				mysql_query("UPDATE detailbarang
							SET stok_detailbarang = stok_detailbarang - $datamin[stok_temp]
							WHERE id_detailbarang = '$datamin[id_detailbarang]'");
				}
				// AKHIR: update stok produk
			}
			// AWAL: Mengirim email yang berisi data IPN (tidak wajib dibuat)
   			$post_ipn="";
   			foreach ($_POST as $key => $value) {
      			$post_ipn .= "$key = $value\n";
   			}
   			mail("admin-store@parentaladvisory-online.com","IPN : $no_pesanan",$post_ipn."\n\nRES: \n".$res);
			// AKHIR: Mengirim email yang berisi data IPN (tidak wajib dibuat)
   			
		}
		else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
		}
	}
	fclose ($fp);// Tutup Request/Respose
}
?>
