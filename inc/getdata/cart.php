<?php
if(isset($_POST['addcart'])){
	if($_POST['warna'] != '-' && $_POST['ukuran'] != '-'){
		$qbarang = mysql_query("SELECT * FROM barangdetail WHERE id_barang = $_POST[barang] AND id_warna = $_POST[warna] AND id_ukuran = $_POST[ukuran]");
		$dbarang = mysql_fetch_array($qbarang);
		
		$iddb = $dbarang['id_barangdetail'];
		
		$ncart = mysql_num_rows(mysql_query("SELECT * FROM pembelian
											WHERE session_id = '".session_id()."'
											AND id_barangdetail = $iddb"));
		if($ncart != 0){
			mysql_query("UPDATE pembelian SET stok_temp = stok_temp + 1
						WHERE session_id = '".session_id()."'
						AND id_barangdetail = $iddb");
		}
		else{
			$qdetail = mysql_query("SELECT * FROM barangdetail as a, barang as b
									WHERE a.id_barang = b.id_barang
									AND a.id_barangdetail = $iddb") or die(mysql_error());
			$ddetail = mysql_fetch_array($qdetail);
			$idmember = NULL;
			if(isset($_SESSION['id_member']))
				$idmember = $_SESSION['id_member'];
			
			if($ddetail['diskon_barang'] !=0)
				$hargabarang = hargadiskon($ddetail['id_barang']);
			else
				$hargabarang = $ddetail['harga_barang'];
				
			mysql_query("INSERT INTO pembelian VALUES(null,null,'$idmember',$iddb,$hargabarang,1,$ddetail[berat_barangdetail],'0','".session_id()."')") or die(mysql_error());
		}
	}
	else{
		/*echo "<script>pesan('Maaf, Anda Salah Memasukkan Warna maupun Ukuran, Silahkan Ulangi Kembali.','Peringatan!!!');</script>";*/
		echo "<script>window.history.back(-1);</script>";
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'del'){
		$iddb = addslashes($_GET['iddb']);
		mysql_query("DELETE FROM pembelian WHERE id_barangdetail = $iddb AND session_id = '".session_id()."'");	
	}
}

if(isset($_POST['checkout'])){
	if(isset($_SESSION['id_member'])){
		$qsession = mysql_query("SELECT * FROM pembelian WHERE session_id = '".session_id()."' AND id_detailpembelian IS NULL");
		if(mysql_num_rows($qsession) > 0)
		{
			mysql_query("INSERT INTO detailpembelian(tanggal_detailpembelian, status_pengiriman, session_id) VALUES(now(),'dipesan','".session_id()."')");
			$qlastid = mysql_query("SELECT * FROM detailpembelian WHERE session_id = '".session_id()."' ORDER BY id_detailpembelian DESC LIMIT 1");
			$dlastid = mysql_fetch_array($qlastid);
			mysql_query("UPDATE pembelian SET id_detailpembelian = '$dlastid[id_detailpembelian]' WHERE session_id = '".session_id()."'");
			echo "<script>window.location = '?page=checkout';</script>";
		}
	}
	else{
		echo "<script>window.location = '?page=register';</script>";
	}
}

if(isset($_POST['update'])){
	$item = $_POST['qty'];
	$id = $_POST['iddb'];
	$jumlah = count($id);
	for($i=0;$i<$jumlah;$i++){
	$datastok = mysql_fetch_array(mysql_query("SELECT *
											   FROM pembelian a, barangdetail as b
											   WHERE a.id_barangdetail = b.id_barangdetail
											   AND a.id_barangdetail = $id[$i]
											   AND a.session_id = '".session_id()."'"));
		if($item[$i] > $datastok['stok_barangdetail']){
			?>
			<script>
				pesan('Stok Tidak Mencukupi','Perhatian');
            </script>
			<?php
		}
		elseif($item[$i] <= 0){
			?>
			<script>pesan('Stok Tidak Boleh Kosong','Perhatian');</script>
			<?php
		}
		else{
			mysql_query("UPDATE pembelian
						SET stok_temp = $item[$i]
						WHERE id_barangdetail = $id[$i]");
		}
	}
}
?>
   	<div class="center_title_bar">Keranjang Belanja</div>
    	<div class="prod_box_big">
            <div class="center_prod_box_big">   
            <form method="post" action="">         
<table width="552" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <th width="20" bgcolor="#CCCCCC" scope="col">No</th>
    <th width="94" bgcolor="#CCCCCC" scope="col">Nama barang</th>
    <th width="107" bgcolor="#CCCCCC" scope="col">Gambar</th>
    <th width="48" bgcolor="#CCCCCC" scope="col">Jumlah</th>
    <th width="102" bgcolor="#CCCCCC" scope="col">Harga Satuan</th>
    <th width="73" bgcolor="#CCCCCC" scope="col">Sub Total</th>
    <th width="48" bgcolor="#CCCCCC" scope="col">Hapus</th>
  </tr>
  <?php
  $qcart = mysql_query("SELECT * FROM pembelian as a, barangdetail as b, barang as c, warna as d, ukuran as e
					   WHERE a.id_barangdetail = b.id_barangdetail
					   AND b.id_barang = c.id_barang
					   AND b.id_warna = d.id_warna
					   AND b.id_ukuran = e.id_ukuran
					   AND a.session_id = '".session_id()."'
					   GROUP BY b.id_barangdetail") or die(mysql_error());
  $no = 0;
  $sub = 0;
  $total = 0;
  while($dcart = mysql_fetch_array($qcart)){
  $sub = ($dcart['stok_temp'] *  $dcart['harga_temp']);
  $total = $total + $sub;
  $no++;
  if($no%2)
  	echo "<tr style='background-color:#A5F5FA'>";
  else
  	echo "<tr style='background-color:#D2FFFD'>";
  ?>
    <td><?php echo $no; ?></td>
    <td>
		<?php echo $dcart['nama_barang']; ?><br />
		<strong><em>Warna :</em></strong>
		<?php echo $dcart['nama_warna']; ?><br />
		<strong><em>Ukuran :</em></strong>
		<?php echo $dcart['nama_ukuran']; ?>
    </td>
    <td><img src="images/product/<?php echo $dcart['gambar_barang']; ?>" height="100" width="100" /></td>
    <td align="center">
    	<input type="hidden" name="iddb[]" value="<?php echo $dcart['id_barangdetail']; ?>" />
    	<input type="text" name="qty[]" value="<?php echo $dcart['stok_temp']; ?>" size="1" maxlength="5" style="border-style:solid; text-align:center;" onblur="this.form.submit('update');" />
    </td>
    <td>Rp. <?php echo number_format($dcart['harga_temp'],"2",".",","); ?></td>
    <td>Rp. <?php echo number_format($sub,"2",".",","); ?></td>
    <td align="center"><a href="?page=cart&act=del&iddb=<?php echo $dcart['id_barangdetail']; ?>" onclick="if(!confirm('Yakin dihapus dari Keranjang ?')) return false;"><img src="images/trash.png" border="0" /></a></td>
  </tr>
  <?php
  }
  ?>
   <tr>
    <td colspan="5" align="right"><strong><font color="#FF0000">Total</font></strong></td>
    <td><strong><font color="#FF0000">Rp. <?php echo number_format($total,"2",".",","); ?></font></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
	<div style="padding-top:8px; text-align:center;">
    	<input type="submit" name="lanjut" class="buttonbtn" style="font-size:8px;" value="BELANJA LAGI" onclick="window.location = '?page=home'; return false;" alt="Lanjut Aktifitas Belanja" title="Lanjut Aktifitas Belanja" />&nbsp;
    	<input type="hidden" name="update" class="buttonbtn" value="UBAH" alt="Ubah Jumlah Barang di Keranjang Belanja" title="Ubah Jumlah Barang di Keranjang Belanja" />&nbsp;
    	<input type="submit" name="checkout" class="buttonbtn" value="SELESAI" alt="Lanjut ke Pembayaran" title="Lanjut ke Pembayaran" />
    </div>
</form><br />
<br />
<input type="submit" onclick="window.history.back(-1);" value="kembali" />
	</div>
</div>