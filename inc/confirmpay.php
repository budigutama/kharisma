<div class="center_title_bar">Konfirmasi Pembayaran</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
<?php
if(isset($_POST['confirmpayment'])){
	if(!empty($_POST['namabank']) && !empty($_POST['notransaksi']) && !empty($_POST['jumlahbayar'])){
		if(strlen($_POST['notransaksi']) < 7){
			echo "<script>alert('Nomor Transaksi Minimal 7 Karakter.');</script>";
			$errormsg = 1;	
		}
		else{
			$qdata = mysql_query("SELECT *
								 FROM detailpembelian as a, pembelian as b, ongkir as c
								 WHERE a.id_detailpembelian = b.id_detailpembelian
								 AND a.id_ongkir = c.id_ongkir
								 AND a.id_detailpembelian = '$_POST[idn]'");
			$ttoharga = 0;
			$ongkirs = 0;
			$qb = 0;
			while($ddata = mysql_fetch_array($qdata)){
				$qb = $qb + ($ddata['stok_temp'] * $ddata['berat_temp']);
				$ttoharga = $ttoharga + ($ddata['harga_temp'] * $ddata['stok_temp']);
				$ongkirs = $ddata['harga_ongkir'];
			}
			$ongkirs = $ongkirs * (int)ceil($qb);
			$ttoharga = $ongkirs + $ttoharga;
			
			if($_POST['jumlahbayar'] < $ttoharga){
			echo "<script>alert('Maaf, Jumlah Pembayaran Kurang !! $_POST[jumlahbayar] $ttoharga');history:back(-1);</script>";
			$errormsg = 1;
			}
			else{
					if($_POST['jumlahbayar'] > $ttoharga){
					?>
						<script>
							if(confirm('Pembayaran Lebih, Apakah anda yakin ?')){
								<?php
									mysql_query("UPDATE detailpembelian as a, pembelian as b SET nama_bank_pemesan = '$_POST[namabank]', no_transaksi_pemesan = '$_POST[notransaksi]', status_pengiriman = 'dikonfirmasi', id_rekening = $_POST[id_rekening], jenis_pembayaran = 'transfer bank' 
									WHERE a.id_detailpembelian = b.id_detailpembelian
									AND a.id_detailpembelian = '$_POST[idn]' AND b.id_member = '$_SESSION[id_member]'");
								?>
							}
							else{
								history:back(-1);
							}
						</script>
					<?php
					}
					else{
						mysql_query("UPDATE detailpembelian as a, pembelian as b SET nama_bank_pemesan = '$_POST[namabank]', no_transaksi_pemesan = '$_POST[notransaksi]', status_pengiriman = 'dikonfirmasi', id_rekening = $_POST[id_rekening], jenis_pembayaran = 'transfer bank'
									WHERE a.id_detailpembelian = b.id_detailpembelian
									AND a.id_detailpembelian = '$_POST[idn]' AND b.id_member = '$_SESSION[id_member]'");
					}
					mysql_query("INSERT INTO konfirmasipembayaran VALUES(null,'$_POST[idn]','$_POST[namabank]','$_POST[notransaksi]','$_POST[jumlahbayar]',now())");
			}
			$errormsg = 0;
		}
	}
	else{
		echo "<script>alert('Maaf, Data Tidak Boleh Ada yang Kosong.');</script>";
		$errormsg = 1;
	}
}
else{
	echo "<script>window.location = '?page=index';</script>";
}
?>
	<div class="mainContent">
        <?php
		if($errormsg == 0){
		?>
			<div class="content">
				Kepada Yth.
				<br />
				<br />
				Sdr/i &nbsp;&nbsp;<b><?php echo $_SESSION['nama_member']; ?></b>
				<br />
				<br />
				Terimakasih Telah Melakukan Pembayaran. Kami Akan Mengirimkan Konfirmasi Kepada Anda Paling Lambat 1 x 24 Jam Melalui Email.<br>
				Pesanan Anda Sudah Tidak Dapat Dibatalkan.
				<br>
				<br>
				Administrator ParentalBabyShop.com
				<br><br>
                <input type="submit" onclick="window.location = '?page=history';" value="Kembali">
		  </div>
          <?php
		  }
		  else{
		  ?>
		<div class="content">
				Kepada Yth.
				<br />
				<br />
				Sdr/i &nbsp;&nbsp;<b><?php echo $_SESSION['nama_member']; ?></b>
				<br />
				<br />
				Maaf, untuk Sementara Kami Tidak Dapat Menerima Konfirmasi Pembayaran Anda, Lakukan Pembayaran Sesuai dengan Data yang kami perlukan.
				<br>
				<br>
				Administrator ParentalBabyShop.com
				<br><br>
                <input type="submit" onclick="history.back(-1);" value="Kembali">
		  </div>
          <?php  
		  }
		  ?>
    </div>
    </div>
</div>