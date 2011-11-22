<?php
if(isset($_POST['konfirmasi'])){
	mysql_query("UPDATE detailpembelian SET status_pengiriman = 'dibayar' WHERE id_detailpembelian = '$_GET[id_detailpembelian]'");
	emailkonfirmasi($_GET['id_detailpembelian']);
	$qkurang = mysql_query("SELECT * FROM pembelian WHERE id_detailpembelian = $_GET[id_detailpembelian]");
	while($dkurang = mysql_fetch_array($qkurang)){
		mysql_query("UPDATE barangdetail SET stok_barangdetail = stok_barangdetail - $dkurang[stok_temp] WHERE id_barangdetail = $dkurang[id_barangdetail]");	
	}
}

/*
if(isset($_POST['diterima'])){
	mysql_query("UPDATE detailpembelian SET status_pengiriman = 'diterima' WHERE id_detailpembelian = '$_GET[id_detailpembelian]'");
	emailbarangditerima($_GET['id_detailpembelian']);
	echo "<script>window.location = '?page=datatransaksi';</script>";
} */

if(isset($_POST['no_resi_pemesan'])){
	mysql_query("UPDATE detailpembelian
			   SET no_resi_pemesan = '$_POST[no_resi_pemesan]', status_pengiriman = 'dikirim'
			   WHERE id_detailpembelian = '$_GET[id_detailpembelian]'") or die(mysql_error());
	emailresi($_GET['id_detailpembelian']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pengolahan Data Transaksi</title>
</head>

<body>
<h2>Pengolahan Data Transaksi</h2> 
                  
<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'edit'){
  $id_detailpembelian=addslashes($_GET['id_detailpembelian']);
  $qcek = mysql_query("SELECT * FROM detailpembelian WHERE id_detailpembelian = '$id_detailpembelian'");
  $dcek = mysql_fetch_array($qcek);
  if($dcek['id_rekening'] == 0){  //belum bayar
	$sqlcart = "SELECT *
				FROM detailpembelian as a, pembelian as b, barangdetail as c, barang as d,
				warna as f, ukuran as g, ongkir as h,
				kota as i, provinsi as j
				WHERE a.id_detailpembelian = b.id_detailpembelian
				AND b.id_barangdetail = c.id_barangdetail
				AND c.id_barang = d.id_barang
				AND c.id_warna = f.id_warna
				AND c.id_ukuran = g.id_ukuran
				AND a.id_ongkir = h.id_ongkir
				AND h.id_kota = i.id_kota
				AND i.id_provinsi = j.id_provinsi
				AND a.id_detailpembelian = $id_detailpembelian
				GROUP BY b.id_barangdetail";
  }
  else{
	$sqlcart = "SELECT *
				FROM detailpembelian as a, pembelian as b, barangdetail as c, barang as d,
				warna as f, ukuran as g, ongkir as h,
				kota as i, provinsi as j, rekening as k
				WHERE a.id_detailpembelian = b.id_detailpembelian
				AND b.id_barangdetail = c.id_barangdetail
				AND c.id_barang = d.id_barang
				AND c.id_warna = f.id_warna
				AND c.id_ukuran = g.id_ukuran
				AND a.id_ongkir = h.id_ongkir
				AND h.id_kota = i.id_kota
				AND i.id_provinsi = j.id_provinsi
				AND a.id_rekening = k.id_rekening
				AND a.id_detailpembelian = $id_detailpembelian
				GROUP BY b.id_barangdetail";	  
  }
  $ambildata=mysql_query($sqlcart) or die(mysql_error());
  $datakirim=mysql_fetch_array($ambildata);
?>
<form action="" method="post">
	<input type="hidden" name="id_detailpembelian" value="<?php echo $id_detailpembelian;?>" />
	<table>
		<tr>
			<td>No Nota </td>
			<td>: <?php echo $id_detailpembelian;?></td>
		<tr>
        <?php
		if($datakirim['no_resi_pemesan'] != ''){
		?>
		<tr>
			<td>No Resi </td>
			<td>: <strong><?php echo $datakirim['no_resi_pemesan'];?></strong></td>
		<tr>
        <?php
		}
		?>
        <tr>
			<td>Nama </td>
			<td>: <?php echo $datakirim['nama_pemesan'];?></td>
		<tr>
		<tr>
          <td>Alamat </td>
		  <td>: <?php echo $datakirim['alamat_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Kota </td>
		  <td>: <?php echo $datakirim['nama_kota'];?></td>
	  </tr>
		<tr>
          <td>No Telp </td>
		  <td>: <?php echo $datakirim['no_telp_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Email </td>
		  <td>: <?php echo $datakirim['email_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Jenis Pembayaran </td>
		  <td>: <?php echo $datakirim['jenis_pembayaran'];?></td>
	  </tr>
		<tr>
          <td>Status Pembayaran </td>
		  <td>: 
		  <?php echo $datakirim['status_pengiriman'];?>
		  </td>
	  </tr>
	  <?php
	  if(($datakirim['status_pengiriman'] == 'dibayar') && ($datakirim['no_resi_pemesan'] == '')){
		?>
		<tr>
          <td>No Resi </td>
		  <td>:
			<input type="text" name="no_resi_pemesan" />
		  </td>
	  </tr>
	  <?php
	  }
	  ?>
	</table>
    <?php
	if($datakirim['status_pengiriman'] == 'dibayar'){
	?>
	<input type="submit" name="save" value="Simpan" class="button" />
	<input type="button" name="batal" value="Batal" class="button" onClick="javasvript:history.back(-1)" />
    <?php
	}
	?>
</form><br /><br />

<?php
if($datakirim['status_pengiriman'] == 'dikonfirmasi'){
?>
<form method="post" action="">
	<input type="submit" name="konfirmasi" value="Konfirmasi" class="button" />
</form>
<?php
}
elseif($datakirim['status_pengiriman'] == 'dikirim'){
	echo "<h4 style='text-decoration:blink;color:red;'>Menunggu Status Barang Diterima Pelanggan oleh JNE ..</h4>";
}
?>

<table width="592" id="rounded-corner">
  <thead>
  <tr>
    <th width="24">No.</th>
    <th width="125">Nama Barang</th>
    <th width="120">Harga</th>
    <th width="40">Berat</th>
    <th width="40">Stok</th>
    <th width="130">Total</th>
  </tr>
  </thead><?php
$no=0;
$ambildata=mysql_query($sqlcart) or die(mysql_error());
$total = 0;
$qb = 0;
while($data=mysql_fetch_array($ambildata)){
  $no++;
?>
  <tr valign="top">
    <td align="center"><?php echo $no;?></td>
    <td>
    	<?php echo $data['nama_barang']; ?><br />
        	<strong><em>Warna :</em></strong>
        <?php echo $data['nama_warna']; ?><br />
            <strong><em>Ukuran :</em></strong>
        <?php echo $data['nama_ukuran']; ?>
    </td>
    <td width="22" align="center"><?php echo "Rp ".number_format($data['harga_temp'],"2",",",".");?></td>
    <td width="22" align="center"><?php echo $data['berat_temp'];?></td>
    <td width="22" align="center"><?php echo $data['stok_temp'];?></td>
    <td width="22" align="right"><?php echo  "Rp ".number_format($data['stok_temp'] * $data['harga_temp'],"2",",",".");?></td>
	</tr>
<?php
$total = $total + ($data['stok_temp'] * $data['harga_temp']);
$qb = $qb + ($data['stok_temp']*$data['berat_temp']);
$transaksinota = $data['no_transaksi_pemesan'];
$banknota = $data['nama_bank_pemesan'];
}
?>
<tr valign="top">
    <td align="center" colspan="4">Ongkos Kirim (<?php echo (int)ceil($qb);?> Kg * <?php echo "Rp ".number_format($datakirim['harga_ongkir'],"2",",","."); ?>)</td>
    <td width="22" align="center">&nbsp;</td>
    <td width="22" align="right"><?php echo "Rp ".number_format(((int)ceil($qb)*$datakirim['harga_ongkir']),"2",",","."); ?></td>
</tr>
<tr valign="top">
    <td align="center" colspan="4">Total</td>
    <td width="22" align="center"><?php echo (int)ceil($qb);?></td>
    <td width="22" align="right"><font color="#FF0000"><strong>Rp. <?php echo number_format($total + ((int)ceil($qb) * $datakirim['harga_ongkir']),"2",",","."); ?></strong></font></td>
</tr>
</table><br /><br />
<strong>Bukti Pembayaran :</strong><br /><br />
<?php
	if($transaksinota == ''){
		echo "<h3>Tidak Ada Bukti Pembayaran</h3>";
	}
	else{
		echo "<table>
					<tr>
						<td>Pembayaran Melalui</td>
						<td>: $banknota</td>
					</tr>
					<tr>
						<td>No Transaksi</td>
						<td>: $transaksinota</td>
					</tr>
			  </table>";
	}
		}
		elseif($_GET['act'] == 'del'){
			mysql_query("DELETE FROM barang WHERE id_barang = '$_GET[idb]'");
			mysql_query("DELETE FROM barangdetail WHERE id_barang = '$_GET[idb]'");
		}
}
else
{
	$batas   = 5;
	if(isset($_GET['halaman']))
		$halaman = $_GET['halaman'];
		
	if(empty($halaman)){
		$posisi  = 0;
		$halaman = 1;
	}
	else{
		$posisi = ($halaman-1) * $batas;
	}
	?>
    <form method="post" action="">
        <table>
        	<tr>
            	<td>Tanggal</td>
            	<td>: <input type="text" id="tanggal1" name="tanggal" <?php echo(isset($_POST['tanggal'])) ? "value='$_POST[tanggal]'" : "" ; ?> /></td>
            </tr>
        	<tr>
            	<td>Status Pengiriman</td>
            	<td>: 
					<select name="status_pengiriman">
                        <option value="">SEMUA</option>
                        <option value="dipesan" <?php echo(isset($_POST['status_pengiriman']) && $_POST['status_pengiriman'] == 'dipesan') ? "selected" : "" ; ?>>DIPESAN</option>
                        <option value="dikonfirmasi" <?php echo(isset($_POST['status_pengiriman']) && $_POST['status_pengiriman'] == 'dikonfirmasi') ? "selected" : "" ; ?>>DIKONFIRMASI</option>
                        <option value="dibayar" <?php echo(isset($_POST['status_pengiriman']) && $_POST['status_pengiriman'] == 'dibayar') ? "selected" : "" ; ?>>DIBAYAR</option>
                        <option value="dikirim" <?php echo(isset($_POST['status_pengiriman']) && $_POST['status_pengiriman'] == 'dikirim') ? "selected" : "" ; ?>>DIKIRIM</option>
                        <option value="diterima" <?php echo(isset($_POST['status_pengiriman']) && $_POST['status_pengiriman'] == 'diterima') ? "selected" : "" ; ?>>DITERIMA</option>
                    </select>
                </td>
            </tr>
        	<tr>
            	<td>Jenis Pembayaran</td>
            	<td>: 
                    <select name="jenis_pembayaran">
                        <option value="">SEMUA</option>
                        <option value="paypal" <?php echo(isset($_POST['jenis_pembayaran']) && $_POST['jenis_pembayaran'] == 'paypal') ? "selected" : "" ; ?>>PAYPAL</option>
                        <option value="transfer bank" <?php echo(isset($_POST['jenis_pembayaran']) && $_POST['jenis_pembayaran'] == 'transfer bank') ? "selected" : "" ; ?>>TRANSFER</option>
                    </select>                
                </td>
            </tr>
            <tr>
            	<td colspan="2"><input type="submit" name="cari" value="cari" /></td>
            </tr>
        </table>
    </form>	  
	<table width="592" id="rounded-corner">
		<thead>
        	<tr>
				<th scope="col" class="rounded-company">No</th>
				<th scope="col" class="rounded">No Nota</th>
				<th scope="col" class="rounded">Nama Member</th>
				<th scope="col" class="rounded">Tanggal Pembelian </th>
				<th scope="col" class="rounded">Jenis Pembayaran </th>
				<th scope="col" class="rounded">Status Pemesanan </th>
				<th scope="col" class="rounded">Status Pengiriman </th>
				<th scope="col" class="rounded">Print</th>
				<th scope="col" class="rounded">Ubah</th>
				<th scope="col" class="rounded-q4">Hapus</th>
        	</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php
			$sqldate = "";
			if(isset($_POST['cari'])){
			$sqlstates = "";
			$sqlkind = "";
				if(!empty($_POST['tanggal'])){
					list($tanggal,$bulan,$tahun) = explode('/',$_POST['tanggal']);
					$sqldate = "AND DAY(tanggal_detailpembelian) = '$tanggal'
								AND YEAR(tanggal_detailpembelian) = '$tahun'
								AND MONTH(tanggal_detailpembelian) = '$bulan'";
				}
				if(!empty($_POST['status_pengiriman'])){
					$sqlstates = " AND status_pengiriman = '$_POST[status_pengiriman]'";	
				}
				if(!empty($_POST['jenis_pembayaran'])){
					$sqlkind = " AND jenis_pembayaran = '$_POST[jenis_pembayaran]'";	
				}
				$sqldate = $sqldate.$sqlstates.$sqlkind;
			}

			$no = 0;
			$qdatapembelian = mysql_query("SELECT * FROM detailpembelian
										   WHERE 1
										   $sqldate
										   LIMIT $posisi,$batas ");
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($ddatapembelian = mysql_fetch_array($qdatapembelian)){
				if ($i >= $kolom){
					echo "<tr class='row$ddatapembelian[id_detailpembelian]'>";
				}
			$i++;
			?>
					<td><?php echo $no; ?></td>
					<td><?php echo $ddatapembelian['id_detailpembelian']; ?></td>
					<td><?php echo $ddatapembelian['nama_pemesan']; ?></td>
					<td><?php echo $ddatapembelian['tanggal_detailpembelian']; ?></td>
					<td><?php echo $ddatapembelian['jenis_pembayaran']; ?></td>
					<td><?php echo $ddatapembelian['status_pemesanan']; ?></td>
					<td><?php echo $ddatapembelian['status_pengiriman']; ?></td>
					<td>
                    	<form method="post" action="filepdf/laporanpengiriman.php">
                    		<input type="hidden" name="iddp" value="<?php echo $ddatapembelian['id_detailpembelian']; ?>" />
                        	<input type="image" src="images/print.png" />
                        </form>
                    </td>
					<td><a href="?page=datatransaksi&act=edit&id_detailpembelian=<?php echo $ddatapembelian['id_detailpembelian']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
					<td>
                    	<?php
						if($ddatapembelian['status_pemesanan'] == 'cancel'){
						?>
                    	<a href="" id="<?php echo $ddatapembelian['id_detailpembelian']; ?>" class="ask"><img src="images/trash.png" alt="" title="" border="0" /></a>
                        <?php
						}
						?>
                    </td>
				</tr>
			<?php
			$no++;
				if($i >= $kolom){
					echo "</tr>";	
				}
			}
			?>
		</tbody>
	</table>
	
	<div class="pagination">
	<?php
	$tampil2 = mysql_query("SELECT * FROM detailpembelian WHERE status_pengiriman != 'diterima'");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=datatransaksi&halaman=$prev'>Prev</a></span> ";
	}
	else{ 
		echo "<span class=disabled>Prev</span> ";
	}
		
	// Tampilkan link halaman 1,2,3 ...
	$angka=($halaman > 3 ? " ... " : " ");
	for($i=$halaman-2;$i<$halaman;$i++)
	{
	if ($i < 1) 
		  continue;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=datatransaksi&halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?page=datatransaksi&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?page=datatransaksi&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=datatransaksi&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
		
	echo "</div>";
} //end of else or !isset($_GET['act'])
	?>
     
     <h2>&nbsp;</h2>
</body>
</html>