<?php
function emailkeadmin($judul,$pesan,$dari){
	$queryemail=mysql_query("SELECT * FROM t_admin");
	
	
	while ($email=mysql_fetch_array($queryemail)){
		$admin="$email[email_admin]";
		mail($admin,$judul,$pesan,$dari);
	}
}

function emailregister($email,$nama,$alamat,$id_kota,$telp,$kodepos,$code){
	$querykota = mysql_query("SELECT *
							  FROM t_provinsi as a, t_kota as b
							  WHERE a.id_provinsi = b.id_provinsi
							  AND b.id_kota = '$id_kota'");
	$datakota = mysql_fetch_array($querykota);
	$kepada = "$email";
	$judul  = "[ tokomusikkharisma.com ] Registrasi dan Aktivasi";
	$ke	  	= "Kepada Yth. Sdr/i. $nama,<br />
			   <br />
			   Terima kasih atas kepercayaan Anda menjadi anggota tokomusikkharisma.com 
			   (<a href='http://www.tokomusikkharisma.com'>http://www.tokomusikkharisma.com</a>).<br />
			   <br />
			   Berikut adalah data diri Anda <br />
			   <br />
			   --------------------------------------------------------------<br />";
	$keadmin = "Dear Admin<br />
			   <br />
			   Telah ada 1 member baru yang mendaftar di tokomusikkharisma.com.<br />
			   <br />
			   Berikut adalah data diri member  :<br />
			   <br />
			   --------------------------------------------------------------<br />";
	$pesan	="	   <table>
					<tr>
						<td>Nama Lengkap</td>
						<td>: $nama</td>
					<tr>
					<tr>
						<td>Alamat</td>
						<td>: $alamat</td>
					<tr>
					<tr>
						<td>Telepon</td>
						<td>: $telp</td>
					<tr>
					<tr>
						<td>Email</td>
						<td>: $email</td>
					<tr>
					<tr>
						<td>Kota</td>
						<td>: $datakota[nama_kota]</td>
					<tr>
					<tr>
						<td>Provinsi</td>
						<td>: $datakota[nama_provinsi]</td>
					<tr>
					<tr>
						<td>Kodepos</td>
						<td>: $kodepos</td>
					<tr>
			   </table>
			   --------------------------------------------------------------<br /><br />";
			   
	$footer	=" Untuk Melanjutkan Aktivitas Belanja Anda, Silahkan Verifikasi Akun Anda<br /><br />
			   Silahkan Klik Link Dibawah Ini Untuk Melakukan Verifikasi Akun<br />
			   <a href='localhost/kharisma/index.php?page=home&code=$code'>localhost/kharisma/index.php?page=home&code=$code</a><br />
			   Jika tidak berjalan dengan baik, Silahkan copy link diatas ke Url Anda.
			   <br />
			   <br />
			   Terima kasih atas kepercayaan Anda.<br /><br />
			   ---<br />
			   tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$ke.$pesan.$footer,$dari);
	emailkeadmin($judul,$keadmin.$pesan,$dari);
}

function emailshipping($id_pembelian,$email){
	$querycustomer = mysql_query("SELECT * FROM t_pembelian WHERE id_pembelian = '$id_pembelian'");
	$datacustomer = mysql_fetch_array($querycustomer);
	$kepada = "$email";
	$judul  = "[ tokomusikkharisma.com ] Daftar Pesanan";
	$ke	 	= "Terima Kasih Telah Memesan Di tokomusikkharisma.com :";
	$keadmin= "Telah diterima satu transaksi pembalian:";
	$pesan  ="		 <br />
					 <br />
					 Berikut adalah rincian pesanan:
					 <br />
					 <table>
					 	<tr>
							<td>Id Pembelian</td>
							<td>: $id_pembelian</td>
						</tr>
					 	<tr>
							<td>Nama </td>
							<td>: $datacustomer[kirim_nama]</td>
						</tr>
					 	<tr>
							<td>Alamat </td>
							<td>: $datacustomer[kirim_alamat]</td>
						</tr>
					 	<tr>
							<td>Kodepos </td>
							<td>: $datacustomer[kirim_kdpos]</td>
						</tr>
					 	<tr>
							<td>No. Telp </td>
							<td>: $datacustomer[kirim_telp]</td>
						</tr>
					 	<tr>
							<td>Email </td>
							<td>: $email</td>
						</tr>
					 </table>
					 <table border=0 cellspacing=0 cellpadding=3 style='border:1px #666 solid'>
						<tr>
						  <th style='background-color:#999'>No.</th>
						  <th style='background-color:#999'>Nama produk</th>
						  <th style='background-color:#999'>Merek</th>
						  <th style='background-color:#999'>Warna</th>
						  <th style='background-color:#999'>Harga</th>
						  <th style='background-color:#999'>Berat</th>
						  <th style='background-color:#999'>Stok</th>
						  <th style='background-color:#999'>Jumlah</th>
						</tr>";
	
	$qcart = mysql_query("SELECT * FROM t_detail_pembelian a, t_pembelian b, t_detailproduk c, t_produk d, t_warna e, t_merek f
						  WHERE a.id_pembelian = b.id_pembelian
						  AND a.id_detailproduk = c.id_detailproduk
						  AND c.id_produk = d.id_produk
						  AND c.id_warna = e.id_warna
						  AND d.id_merek = f.id_merek
						  AND b.id_pembelian = '$id_pembelian'");
	$no = 0;
	$total = 0;
	$ongkos = 0;
	$qb = 0;
	while($dcart = mysql_fetch_array($qcart)){
	$ongkos = $dcart['kirim_ongkos'];
	$qb = $qb + ($dcart['qty']*$dcart['berat']);
	$total = $total + ($dcart['hargabeli']*$dcart['qty']);
	$no++;
	$pesan .="  <tr align=center>
					  <td>$no.</td>
					  <td>$dcart[nama_produk]</td>
					  <td>$dcart[nama_merek]</td>
					  <td>$dcart[nama_warna]</td>
					  <td align='right'>Rp".number_format($dcart['hargabeli'],"2",",",".")."</td>
					  <td>$dcart[berat] KG</td>
					  <td>$dcart[qty]</td>
					  <td align='right'>Rp".number_format(($dcart['hargabeli']*$dcart['qty']),"2",",",".")."</td>
			    </tr>";
	}
	$total = $total + $ongkos;
	
	$pesan .="<tr style='background-color:#ccc'>
				  <td colspan='7'>Ongkos Kirim </td>
				  <td align='right'>Rp. ".number_format($ongkos,"2",",",".")."</td>
			</tr>
			<tr>
				  <td colspan='7'>Total Bayar</td>
				  <td align='right' style=color:#F00><strong>Rp. ".number_format($total,"2",",",".")."</strong></td>
			</tr>
			</table>
			<br />";
			
	$bayaran ="Pembayaran dapat pesanan dilakukan Menggukakan metode pembayaran yang kami gunakan dibawah ini :
			<br />
			<table  border=0 cellspacing=0 cellpadding=3>
			<tr>
				<td colspan=3><a href='localhost/kharisma/?page=view&idn=$id_pembelian'>
				<img src='localhost/kharisma/paypal/btn.gif'></a></td>
			</tr>";
			$ambilrek=mysql_query("SELECT * FROM t_rekening");
			while ($rek=mysql_fetch_array($ambilrek)){
	$bayaran .="
			<tr>
              <td rowspan='3' style='padding-left:10px;'>
              <a href='localhost/kharisma/?page=view&idn=$id_pembelian'>
			  <img src='localhost/kharisma/gambar/$rek[gambar_rekening]'></a></td>
              <td style='padding-left:10px;'>Atas Nama</td>
              <td style='padding-left:10px;'>: $rek[nama_rekening]</td>
            </tr>
            <tr>
              <td style='padding-left:10px;'>No. Rekening</td>
              <td style='padding-left:10px;'>: $rek[no_rekening]</td>
            </tr>
            <tr>
              <td style='padding-left:10px;'>Cabang</td>
              <td style='padding-left:10px;'>: $rek[cabang_rekening]</td>
            </tr>
            <tr>
              <td style='padding-left:10px;'>&nbsp;</td>
              <td style='padding-left:10px;'>&nbsp;</td>
              <td colspan='2'>&nbsp;</td>
            </tr>"; }
	$bayaran .="
			<table>
			Untuk Konfirmasi Pembayaran dapat Dilakukan dihalaman History atau bisa klik pada gambar<br />
			Terima kasih atas kepercayaan Anda.<br />
			tokomusikkharisma.com<br />
			<br />
			---<br />
			tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$ke.$pesan.$bayaran,$dari);
	emailkeadmin($judul,$keadmin.$pesan,$dari);
}

function emailbayar($id_pembelian){
	$qdetailpembelian = mysql_query("SELECT * FROM t_pembelian a, t_rekening b, t_member c
							WHERE a.id_rekening = b.id_rekening
							AND a.id_member=c.id_member
							AND a.id_pembelian = '$id_pembelian'
							GROUP BY a.id_pembelian");
	$ddetailpembelian = mysql_fetch_array($qdetailpembelian);
	
	$kepada = "$ddetailpembelian[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Pembayaran Pesanan";
			
	$ke     = "Kepada Yth. Sdr/i. $ddetailpembelian[kirim_nama],<br />
				<br />
				Terimakasih Telah Melakukan Pembayaran.<br /> 
				Kami Akan Mengirimkan Konfirmasi Kepada Anda Paling Lambat 1 x 24 Jam Melalui Email.
				Pesanan Anda Sudah Tidak Dapat Dibatalkan.
				<br />
				Berikut adalah data konfirmasi yang anda masukkan :<br />";
	$keadmin = "Dear Admin <br>
				Telah diterima konfirmasi pembayaran dari $ddetailpembelian[email_member] <br />
				Berikut adalah detail konfirmasi bembayarannya :";			
	$pesan 	=" 	<table>
					<tr>
						<td>Id Pembelian</td>
						<td>: <strong>$id_pembelian<strong></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: $ddetailpembelian[kirim_nama]</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>: $ddetailpembelian[email_member]</td>
					</tr>
					<tr>
						<td>Tanggal Pembayaran</td>
						<td>: ".tgl_indo($ddetailpembelian['tgl_bayar'])." </td>
					</tr>
					<tr>
						<td>Besar Pembayaran</td>
						<td>: Rp ".number_format($ddetailpembelian['totalbayar'],"2",",",".").",-</td>
					</tr>
					<tr>
						<td colspan='2'>Bank Tujuan</td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>: $ddetailpembelian[bank_rekening]</td>
					</tr>
					<tr>
						<td>No. Rekening</td>
						<td>: $ddetailpembelian[no_rekening]</td>
					</tr>
					<tr>
						<td colspan='2'>Pembayaran dari</td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>: $ddetailpembelian[transfer_bank]</td>
					</tr>
					<tr>
						<td>No. Transaksi</td>
						<td>: $ddetailpembelian[transfer_no]</td>
					</tr>
				</table>";
	$footer	.=" Terima kasih atas kepercayaan Anda.<br />
				tokomusikkharisma.com<br />
				<br />
				---<br />
				tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$footadmin.="Silahkan 
	<a href='http://www.tokomusikkharisma.com/admin/index.php?page=datatransaksi&act=edit&id_pembelian=$id_pembelian'>Klik Disini</a> Untuk melakukan konfirmasi ";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$ke.$pesan.$footer,$dari);
	emailkeadmin($judul,$keadmin.$pesan.$footadmin,$dari);
}

function emailkonfirmasi($id_pembelian){
	$qdetailpembelian = mysql_query("SELECT * FROM t_pembelian a, t_rekening b, t_member c
							WHERE a.id_rekening = b.id_rekening
							AND a.id_member=c.id_member
							AND a.id_pembelian = '$id_pembelian'
							GROUP BY a.id_pembelian");
	$ddetailpembelian = mysql_fetch_array($qdetailpembelian);
	
	$kepada = "$ddetailpembelian[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Konfirmasi Pembayaran Tagihan";
			
	$ke     = "Kepada Yth. Sdr/i. $ddetailpembelian[kirim_nama],<br />
				<br />
				Pembayaran Telah kami konfirmasi.<br />
				Kami Beritahukan Bahwa Anda Telah Membayar Lunas Pemesanan Anda.<br />
				Silahkan Tunggu Nomor Resi produk Pesanan Anda karena Sedang Dalam Proses Pengiriman.";
	$keadmin = "Dear Admin,<br />
				<br />
				Pasanan dengan ID : $id_pembelian oleh member $ddetailpembelian[email_member]<br />
				Telah dikonfirmasi.";
	$pesan  = " <br />
				<br />
				Berikut adalah data konfirmasi yang anda masukkan :<br />
				<table>
					<tr>
						<td>Id Pembelian</td>
						<td>: <strong>$id_pembelian<strong></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: $ddetailpembelian[kirim_nama]</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>: $ddetailpembelian[email_member]</td>
					</tr>
					<tr>
						<td>Besar Pembayaran</td>
						<td>: Rp ".number_format($ddetailpembelian['totalbayar'],"2",",",".").",-</td>
					</tr>
					<tr>
						<td colspan='2'>Bank Tujuan</td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>: $ddetailpembelian[bank_rekening]</td>
					</tr>
					<tr>
						<td>No. Rekening</td>
						<td>: $ddetailpembelian[no_rekening]</td>
					</tr>
					<tr>
						<td colspan='2'>Pembayaran dari</td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>: $ddetailpembelian[transfer_bank]</td>
					</tr>
					<tr>
						<td>No. Transaksi</td>
						<td>: $ddetailpembelian[transfer_no]</td>
					</tr>
				</table>";
	$footer	 ="Terima kasih atas kepercayaan Anda.<br />
				tokomusikkharisma.com<br />
				<br />
				---<br />
				tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$ke.$pesan.$footer,$dari);
	emailkeadmin($judul,$ke.$pesan,$dari);
}

function emailresi($id_pembelian){
	$querycustomer = mysql_query("SELECT * FROM t_pembelian a, t_member b 
								 WHERE a.id_member=b.id_member 
								 AND a.id_pembelian = '$id_pembelian'");
	$datacustomer = mysql_fetch_array($querycustomer);
	$kepada = "$datacustomer[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Nomor Resi Paket Kiriman";
	$pesan  = "Pesanan Anda Telah Kami Kirim,<br />
			   Id Pembelian : $id_pembelian<br />
			   Nomor Resi Anda Adalah : <b>$datacustomer[kirim_resi].</b>
			   Untuk Informasi Penulusuran Paket Silahkan Cek DI sini 
			   <a href='http://www.jne.co.id/index.php?mib=tracking.detail&awb=$datacustomer[kirim_resi]'>
			   Tracking JNE</a><br><br>
			   Silahkan Tunggu Paket Kiriman Anda
			   <br /><br />
			   Terima kasih atas kepercayaan Anda Berbelanja Di website Kami.<br />
			   Salam Hangat,<br /><br />
			   tokomusikkharisma.com<br />
			   <br />
			   ---<br />
			  tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$pesanadmin   = "Nomor Resi Pengiriman Pesanan:
					Id Pembelian 	 : $id_pembelian <br/>
					Pembeli / Member : $datacustomer[nama_member] - $datacustomer[email_member]<br />
					No Resi 		 : <b>$datacustomer[kirim_resi].</b>";	
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);
	emailkeadmin($judul,$pesanadmin,$dari);
	
}

function emailhapuspesanan($id_pembelian){
	$querycustomer = mysql_query("SELECT * FROM pembelian a member b 
								 WHERE a.id_member=b.id_member 
								 AND id_pembelian = '$id_pembelian'");
	$datacustomer = mysql_fetch_array($querycustomer);
	$kepada = "$datacustomer[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Hapus Pesanan";
	$pesan = "Maaf, Waktu yang kami tentukan untuk konfirmasi pembayaran pesanan anda telah habis.<br />
			Data akan otomatis terhapus dari history.<br />
			Silahkan melakukan pesanan kembali.
			Terima kasih atas perhatian Anda.<br />
			tokomusikkharisma.com<br />
			<br />
			---<br />
			tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$pesanadmin =" Pesanan Dengan ID $datacostumer[id_pembelian], tanggal ".tgl_indo($datacostumer['tgl_beli'])." Oleh :
				  $datacostumer[email_member], Telah dibatalkan karena telah melebihi batas waktu pembayaran..
			  ";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);
	emailkeadmin($judul,$pesanadmin,$dari);
}

function emailbayarpaypal($id_pembelian,$payer,$recipe){
	$qdetailpembelian = mysql_query("SELECT * FROM pembelian a, member b
							WHERE a.id_member=b.id_member
							AND a.id_pembelian = '$id_pembelian'
							GROUP BY a.id_pembelian");
	$ddetailpembelian = mysql_fetch_array($qdetailpembelian);
	
	$kepada = "$ddetailpembelian[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Pembayaran Pesanan Paypal";
			
	$ke	    = "Kepada Yth. Sdr/i. $ddetailpembelian[kirim_nama],<br />
				<br />
				Terimakasih Telah Melakukan Pembayaran.<br /> 
				Pesanan Anda Sudah Tidak Dapat Dibatalkan.
				<br />
				Berikut adalah data pembayaran paypal anda:<br />";
	$keadmin = "Dear Admin,<br />
				<br />
				Telah diterima pembayaran menggunakan PayPal dari $ddetailpembelian[email_member].<br /> 
				Berikut adalah  detailnya:<br />";
	$pesan	="<table>
					<tr>
						<td>Id Pembelian</td>
						<td>: <strong>$id_pembelian<strong></td>
					</tr>
					<tr>

						<td>Nama</td>
						<td>: $ddetailpembelian[kirim_nama]</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>: $ddetailpembelian[email_member]</td>
					</tr>
					<tr>
						<td>Tanggal Pembayaran</td>
						<td>: ".tgl_indo($ddetailpembelian['tgl_bayar'])." </td>
					</tr>
					<tr>
						<td>Besar Pembayaran</td>
						<td>: $ddetailpembelian[totalbayar] </td>
					</tr>
					<tr>
						<td>Account Penjual</td>
						<td>: $recipe</td>
					</tr>
					<tr>
						<td>Account Pembayar</td>
						<td>: $payer</td>
					</tr>
					<tr>
						<td>No. Transaksi</td>
						<td>: $ddetailpembelian[transfer_no]</td>
					</tr>
				</table>";
	$footer	 ="Terima kasih atas kepercayaan Anda.<br />
				tokomusikkharisma.com<br />
				<br />
				---<br />
				tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$ke.$pesan.$footer,$dari);
	emailkeadmin($judul,$keadmin.$pesan,$dari);
}

function emailprodukditerima($id_pembelian){
	$querycustomer = mysql_query("SELECT * FROM t_pembelian a, t_member b 
								 WHERE a.id_member=b.id_member
								 AND a.id_pembelian = '$id_pembelian'");
	$datacustomer = mysql_fetch_array($querycustomer);
	$kepada = "$datacustomer[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Konfirmasi Pesanan Telah Sampai";
	$pesan = "Terima Kasih Telah Memesan Di tokomusikkharisma.com<br />
			  Status Pesanan Anda Sesuai dengan Jasa Pengiriman Kami Telah Sampai Kepada Anda.
					 <br />
					 <br />
					 Berikut adalah rincian pesanan anda :
					 <br />
					 <table>
					 	<tr>
							<td>Id Pembelian</td>
							<td>: $id_pembelian</td>
						</tr>
					 	<tr>
							<td>Nama </td>
							<td>: $datacustomer[kirim_nama]</td>
						</tr>
					 	<tr>
							<td>Alamat </td>
							<td>: $datacustomer[kirim_alamat]</td>
						</tr>
					 	<tr>
							<td>Kodepos </td>
							<td>: $datacustomer[kirim_kdpos]</td>
						</tr>
					 	<tr>
							<td>No. Telp </td>
							<td>: $datacustomer[kirim_telp]</td>
						</tr>
					 </table>
					 <table border=0 cellspacing=0 cellpadding=3 style='border:1px #666 solid'>
						<tr>
						  <th style='background-color:#999'>No.</th>
						  <th style='background-color:#999'>Nama produk</th>
						  <th style='background-color:#999'>Merek</th>
						  <th style='background-color:#999'>Warna</th>
						  <th style='background-color:#999'>Harga</th>
						  <th style='background-color:#999'>Berat</th>
						  <th style='background-color:#999'>Stok</th>
						  <th style='background-color:#999'>Jumlah</th>
						</tr>";
	
	$qcart = mysql_query("SELECT * FROM t_pembelian a, t_detail_pembelian b, t_detailproduk c, t_produk d, t_warna e, t_merek f
						  WHERE a.id_pembelian = b.id_pembelian
						  AND b.id_detailproduk = c.id_detailproduk
						  AND c.id_produk = d.id_produk
						  AND c.id_warna = e.id_warna
						  AND d.id_merek = f.id_merek
						  AND a.id_pembelian = '$id_pembelian'");
	$no = 0;
	$total = 0;
	$ongkos = 0;
	$qb = 0;
	while($dcart = mysql_fetch_array($qcart)){
	$ongkos = $dcart['kirim_ongkos'];
	$qb = $qb + ($dcart['qty']*$dcart['berat']);
	$total = $total + ($dcart['hargabeli']*$dcart['qty']);
	$no++;
	$pesan .="  <tr>
					  <td>$no.</td>
					  <td>$dcart[nama_produk]</td>
					  <td>$dcart[nama_merek]</td>
					  <td>$dcart[nama_warna]</td>
					  <td align='right'>Rp".number_format($dcart['hargabeli'],"2",",",".")."</td>
					  <td align=center>$dcart[berat]</td>
					  <td align=center>$dcart[qty]</td>
					  <td align='right'>Rp".number_format(($dcart['hargabeli']*$dcart['qty']),"2",",",".")."</td>
			    </tr>";
	}
	$total = $total + $ongkos;
	
	$pesan .="<tr style='background-color:#ccc'>
				  <td colspan='7'>Ongkos Kirim </td>
				  <td align='right'>Rp".number_format($ongkos,"2",",",".")."</td>
			</tr>
			<tr>
				  <td colspan='7'>Total</td>
				  <td align='right' style='color:#F00'>Rp".number_format($total,"2",",",".")."</td>
			</tr>
			</table>
			<br /><br />
			Jika Ada Produk didalam Pesanan Anda yang Tidak Sesuai dengan yang Anda Pesan<br />
			Anda Dapat Melakukan Pengembalian Produk Kepada Kami,<br />
			Terima kasih atas kepercayaan Anda.<br />
			tokomusikkharisma.com<br />
			<br />
			---<br />
			tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);
}

function email_bukutamu($email,$nama,$isi){
	$kepada = "$email";
	$judul  = "[ tokomusikkharisma.com ] Balasan Buku Tamu";
	$pesan  = "Kepada Yth. Sdr/i. $nama,<br />
			   <br />
			   Terimakasih atas kritik dan sarannya kepada kami, kami akan berusaha untuk selalu meningkatkan mutu pelayanan kami.<br>
			   berikut adalah jawaban kami atas Pertanyaan sodara.<br>
			   $isi
			   <br />
			   <br />
			   Terima kasih atas kepercayaan Anda.<br /><br />
			   ---<br />
			   tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);
}

function emaillupasadmin($email,$verifikasi){
	$qemail = mysql_query("SELECT * FROM admin WHERE email_admin = '$email'");
	$demail = mysql_fetch_array($qemail);
	$kepada = "$email";
	$judul  = "[ tokomusikkharisma.com ] Verifikasi Permintaan Password Admin Baru";
	$pesan  = "Kepada Yth. Sdr/i. $demail[nama_admin],<br />
			   <br />
			   Untuk Melakukan Perubahan Password Akun Anda, Silahkan Klik Link Dibawah Ini<br />
			   <a href='http://tokomusikkharisma.com/admin/login.php?code=$verifikasi'>http://tokomusikkharisma.com/admin/login.php?code=$verifikasi</a><br />
			   Jika tidak berjalan dengan baik, Silahkan Copy link diatas ke Url Anda.
			   <br />
			   ---<br />
			   tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);	
}

function emaillupapassword($email,$verifikasi){
	$qemail = mysql_query("SELECT * FROM t_member WHERE email_member = '$email'");
	$demail = mysql_fetch_array($qemail);
	$kepada = "$email";
	$judul  = "[ tokomusikkharisma.com ] Verifikasi Permintaan Password Baru";
	$pesan  = "Kepada Yth. Sdr/i. $demail[nama_member],<br />
			   <br />
			   Untuk Melakukan Perubahan Password Akun Anda, Silahkan Klik Link Dibawah Ini<br />
			   <a href='http://tokomusikkharisma.com/index.php?page=lupapassword&code=$verifikasi'>http://tokomusikkharisma.com/index.php?page=lupapassword&code=$verifikasi</a><br />
			   Jika tidak berjalan dengan baik, Silahkan Copy link diatas ke Url Anda.
			   <br />
			   <br />
			   Terima kasih atas kepercayaan Anda.<br /><br />
			   ---<br />
			   tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);	
}

function emailtesti($id_testi){
	$qtesti = mysql_query("SELECT * FROM testi_produk a, member b, produk c 
				WHERE a.id_produk=c.id_produk
				AND a.id_member = b.id_member
				AND a.id_testi=$id_testi");
	$dtesti = mysql_fetch_array($qtesti);
	$kepada = "$dtesti[email_member]";
	$judul  = "[ tokomusikkharisma.com ] Testimoni Produk $dtesti[nama_produk]";
	$pesan  = "Kepada Yth. Sdr/i. $dtesti[nama_member],<br />
			   <br />
			   Berikut adalah testimoni untuk produk $dtesti[nama_produk] pada tenggal tgl_indo($dtesti[tgl_testi])<br />
			   Isi testimoni sebagai berikut : $dtesti[testimoni]
			   <br />
			   Terima kasih atas kepercayaan Anda.<br /><br />
			   ---<br />
			   tokomusikkharisma.com<br />
			   Main Office: Jl. buah batu no. 238 Bandung Jawa Barat.<br />
			   Email: admin@tokomusikkharisma.com<br />
			   ---";
	$pesanadmin ="Dear Admin <br />
				Telah diterima testimoni untuk produk $dtesti[nama_produk] oleh member <b>$dtesti[nama_member]</b>:<br />
			   Isi testimoni sebagai berikut : $dtesti[testimoni]
				<br />
				";
	$dari   = "From: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Reply-To: admin@tokomusikkharisma.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);	
	emailkeadmin($judul,$pesanadmin,$dari);
}
?>