<div class="center_title_bar">Keranjang Belanja</div>
    <div class="prod_box_big">
        <div class="center_prod_box_big">
        <div align="center"> 
            <div class="panah"><span class="step">Step 1</span><br />Keranjang Belanja</div>  
            <div class="panah2"><span class="step">Step 2</span><br />Alamat Kirim</div>  
            <div class="panah2"><span class="step">Step 4</span><br />Pembayaran</div>  
        </div>
<?php
$idpr=$_GET['idpr'];
if(isset($idpr)){
	$det = mysql_query("SELECT * FROM t_detail_pembelian WHERE id_pembelian='$idpr'");
	while ($dp = mysql_fetch_array($det)) 
		{
			$id_produk 			= $dp['id_detailproduk'];
			$qty 				= $dp['qty'];
			$harga				= $dp['hargabeli'];
			$berat				= $dp['berat'];
		mysql_query("INSERT INTO t_pemesanan VALUES(null,'$id_produk','".session_id()."','$qty','$berat','$harga',now())");
		}
		$hapus = mysql_query("DELETE FROM t_detail_pembelian WHERE id_pembelian ='$idpr'");
		$hapusp = mysql_query("DELETE FROM t_pembelian WHERE id_pembelian ='$idpr'");
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'del'){
		$iddb = addslashes($_GET['iddb']);
		$temp=mysql_fetch_array(mysql_query("SELECT * FROM t_pemesanan 
											WHERE id_detailproduk = $iddb AND session_id = '".session_id()."'"));
		$updatestok="UPDATE t_detailproduk SET stok_detailproduk=stok_detailproduk+$temp[qty] 
					WHERE id_detailproduk=$iddb";
		$res=mysql_query($updatestok);
		if ($res)
			mysql_query("DELETE FROM t_pemesanan WHERE id_detailproduk = $iddb AND session_id = '".session_id()."'");	
	}
}

if(isset($_POST['checkout'])){
	if(isset($_SESSION['id_member'])){
	$sid = session_id();
	$masukpesanan = mysql_query("INSERT INTO t_pembelian(session_id,tgl_beli,status,status_pembayaran,id_member,pembayaran) 
						VALUES ('$sid', now(),'pesan','1', '$_SESSION[id_member]','')");
	$id=mysql_fetch_array(mysql_query("select * from t_pembelian where session_id='$sid' order by id_pembelian desc limit 1"));
	$temp1 = mysql_query("SELECT * FROM t_pemesanan WHERE session_id='$sid'");
	while ($temp = mysql_fetch_array($temp1)) 
		{
			$id_produk 			= $temp['id_detailproduk'];
			$qty 				= $temp['qty'];
			$harga				= $temp['temp_hargadiskon'];
			$berat				= $temp['berat'];
		mysql_query("INSERT INTO t_detail_pembelian VALUES(NULL,'$id[id_pembelian]','$harga','$id_produk','$qty','$berat',0)");
		}
		$hapus = mysql_query("DELETE FROM t_pemesanan WHERE session_id ='$sid'");
		echo "<script>window.location = '?page=checkout';</script>";
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
											   FROM t_pemesanan a, t_detailproduk as b
											   WHERE a.id_detailproduk = b.id_detailproduk
											   AND a.id_detailproduk = $id[$i]
											   AND a.session_id = '".session_id()."'"));
	    $qty=$datastok['qty'];
		$sisastok=$item[$i]-$qty;
		if($sisastok > $datastok['stok_detailproduk']){
			?>
			<h3>Stok Tidak Mencukupi</h3>
			<?php
		}
		elseif($item[$i] <= 0){
			?>
			<h3>Jumlah Tidak Valid, Jumlah harus lebih besar dari 0..!!</h3>
			<?php
		}
		else{
		$updatestok="UPDATE t_detailproduk SET stok_detailproduk=stok_detailproduk-$sisastok 
					WHERE id_detailproduk=$id[$i]";
		$res=mysql_query($updatestok);
		if ($res)
			mysql_query("UPDATE t_pemesanan SET qty = $item[$i] WHERE id_detailproduk = $id[$i]");
			
		}
	}
}
?>
<form method="post" action="">         
<div class="alamat">   
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr height="30">
    <th width="20" bgcolor="#ccc" scope="col">No</th>
    <th width="94" bgcolor="#ccc" scope="col">Produk</th>
    <th width="80" bgcolor="#ccc" scope="col">Gambar</th>
    <th width="100" bgcolor="#ccc" scope="col">Harga Satuan</th>
    <th width="48" bgcolor="#ccc" scope="col">Jumlah</th>
    <th width="100" bgcolor="#ccc" scope="col">Sub Total</th>
    <th width="48" bgcolor="#ccc" scope="col">Hapus</th>
  </tr>
  <?php
  $qcart = mysql_query("SELECT * FROM t_pemesanan a, t_detailproduk b, t_produk c, t_warna d, t_gambar f, t_merek e
					   WHERE a.id_detailproduk = b.id_detailproduk
					   AND b.id_produk = c.id_produk
					   AND b.id_produk = f.id_produk
					   AND b.id_warna = d.id_warna
					   AND c.id_merek = e.id_merek
					   AND a.session_id = '".session_id()."'
					   GROUP BY b.id_detailproduk") or die(mysql_error());
  $no = 0;
  $sub = 0;
  $total = 0;
  while($dcart = mysql_fetch_array($qcart)){
  $sub = ($dcart['qty'] *  $dcart['temp_hargadiskon']);
  $total = $total + $sub;
  $no++;
  if($no%2)
  	echo "<tr style='background-color:#ffffff'>";
  else
  	echo "<tr style='background-color:#f0f4f5'>";
  ?>
    <td><?php echo $no; ?></td>
    <td>
		<?php echo $dcart['nama_produk']; ?><br />
		<strong><em>Merek :</em></strong>
		<?php echo $dcart['nama_merek']; ?><br />
		<strong><em>Warna :</em></strong>
		<?php echo $dcart['nama_warna']; ?>
    </td>
    <td><img src="gambar/produk/<?php echo $dcart['nama_gambar']; ?>" height="80" width="80" /></td>
    <td><?php if($dcart['diskon_produk']>0){
	    ?>
        <span style="text-decoration:line-through; font-weight:bold;">
    	Rp. <?php echo number_format($dcart['harga_produk'],"0",".","."); ?></span><br />
    	Diskon <?php echo "$dcart[diskon_produk] % <br /> ";  } ?>
        <span style="font-weight:bold; color:#F00;">
        Rp. <?php echo number_format($dcart['temp_hargadiskon'],"0",".","."); ?></span></td>
    <td align="center">
    	<input type="hidden" name="iddb[]" value="<?php echo $dcart['id_detailproduk']; ?>" />
    	<input type="text" name="qty[]" value="<?php echo $dcart['qty']; ?>" size="1" maxlength="5" style="border-style:solid; text-align:center;" onblur="this.form.submit('update');" />
    </td>
     <td>Rp. <?php echo number_format($sub,"0",".","."); ?></td>
   <td align="center">
   <?php $cekret=mysql_query("SELECT * FROM t_retur a, t_detail_retur b, t_member c
							 WHERE a.id_retur=b.id_retur
							 AND a.id_member=a.id_member
							 AND c.id_member=1
							 AND b.id_detailproduk=$dcart[id_detailproduk]");
   if (mysql_num_rows($cekret)== 0) {?>
   <a href="?page=cart&act=del&iddb=<?php echo $dcart['id_detailproduk']; ?>" class="button" onclick="if(!confirm('Yakin dihapus dari Keranjang ?')) return false;">
   <span class="icon icon186"></span></a>
   <?php } ?></td>
  </tr>
  <?php
  }
  ?>
   <tr>
    <td colspan="5" align="left"><strong><font color="#FF0000">Total</font></strong></td>
    <td><strong><font color="#FF0000">Rp. <?php echo number_format($total,"0",".","."); ?></font></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
	<div style="padding-top:8px; text-align:right;">
    	<a href="?page=home" class="button" title="Lanjut Aktifitas Belanja" />
        <span class="icon icon169"></span><span class="label1">Belanja Lagi</span></a>
    	<input type="hidden" name="update" class="buttonbtn" value="UBAH" alt="Ubah Jumlah produk di Keranjang Belanja" title="Ubah Jumlah produk di Keranjang Belanja" />&nbsp;
    	<button name="checkout" class="action blue"/>
        <span class="label1">Checkout</span>
        </button>
    </div>
</form>
	</div>
</div>