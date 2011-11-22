<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Konfirmasi Penjualan</title>
</head>

<body>
<h2>Konfirmasi Penjualan</h2> 
                  
<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'view'){
  	$id_detailpembelian=addslashes($_GET['id_detailpembelian']);
	$sqlcart = "SELECT *
				FROM konfirmasipembayaran";
  $datakirim=mysql_fetch_array($ambildata);
?>
<form action="" method="post">
	<input type="hidden" name="id_detailpembelian" value="<?php echo $id_detailpembelian;?>" />
	<table>
		<tr>
			<td>No Nota</td>
			<td>: <?php echo $datakirim['id_detailpembelian'];?></td>
		<tr>
        <?php
		if($datakirim['no_resi_pemesan'] != ''){
		?>
		<tr>
			<td>No Resi</td>
			<td>: <strong><?php echo $datakirim['no_resi_pemesan'];?></strong></td>
		<tr>
        <?php
		}
		?>
        <tr>
			<td>Nama</td>
			<td>: <?php echo $datakirim['nama_pemesan'];?></td>
		<tr>
		<tr>
          <td>Alamat</td>
		  <td>: <?php echo $datakirim['alamat_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Kota</td>
		  <td>: <?php echo $datakirim['nama_kota'];?></td>
	  </tr>
		<tr>
          <td>No Telp</td>
		  <td>: <?php echo $datakirim['no_telp_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Email</td>
		  <td>: <?php echo $datakirim['email_pemesan'];?></td>
	  </tr>
		<tr>
          <td>Jenis Pembayaran</td>
		  <td>: <?php echo $datakirim['jenis_pembayaran'];?></td>
	  </tr>
		<tr>
          <td>Status Pembayaran</td>
		  <td>: 
		  <?php echo $datakirim['status_pengiriman'];?>
		  </td>
	  </tr>
	  <?php
	  if(($datakirim['status_pengiriman'] == 'dibayar') && ($datakirim['no_resi_pemesan'] == '')){
		?>
		<tr>
          <td>No Resi <span id="sprytextfield1"></td>
		  <td>:
			<input type="text" name="no_resi_pemesan" />
		  </td>
	  </tr>
	  <?php
	  }
	  ?>
	</table>
    <table width="592" id="rounded-corner">
  <thead>
  <tr>
    <th width="24" scope="col" class="rounded-company">No.</th>
    <th width="125" scope="col" class="rounded" align="center">Nama barang</th>
    <th width="120" scope="col" class="rounded" align="center">Harga</th>
    <th width="40" scope="col" class="rounded" align="center">Berat</th>
    <th width="40" scope="col" class="rounded" align="center">Stok</th>
    <th width="130" scope="col" class="rounded-q4" align="center">Total</th>
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
    <td align="center"><?php echo $data['nama_barang'];?></td>
    <td width="22" align="center"><?php echo "Rp ".number_format($data['harga_temp'],"2",",",".");?></td>
    <td width="22" align="center"><?php echo $data['berat_temp'];?></td>
    <td width="22" align="center"><?php echo $data['stok_temp'];?></td>
    <td width="22" align="right"><?php echo  "Rp ".number_format($data['stok_temp'] * $data['harga_temp'],"2",",",".");?></td>
	</tr>
<?php
$total = $total + ($data['stok_temp'] * $data['harga_temp']);
$qb = $qb + ($data['stok_temp']*$data['berat_temp']);
$reknota = $data['no_rekening_pemesan'];
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
</table>
<?php
	}
}
else{
	$batas   = 10;
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
    	<input type="text" id="tanggal" name="tanggal" />
        <input type="submit" name="cari" value="cari" />
    </form>
	<table width="592" id="rounded-corner">
		<thead>
			<tr>
				<th width="51" class="rounded-company" scope="col">No</th>
				<th width="444" class="rounded" scope="col">No detailpembelian</th>
				<th width="444" class="rounded" scope="col">Nama Member</th>
				<th width="444" class="rounded" scope="col">Tanggal pembelian</th>
				<th width="444" class="rounded" scope="col">Total</th>
				<th width="45" class="rounded" scope="col">Lihat</th>
				<th width="45" class="rounded-q4" scope="col">Hapus
		<tbody>
			<?php
			$sqldate = "";
			if(isset($_POST['cari'])){
			list($tanggal,$bulan,$tahun) = explode('/',$_POST['tanggal']);
			$sqldate = "AND DAY(tanggal_detailpembelian) = '$tanggal'
						AND YEAR(tanggal_detailpembelian) = '$tahun'
						AND MONTH(tanggal_detailpembelian) = '$bulan'";	
			}
			$no = 0;
			$qlapharian = mysql_query("SELECT * FROM detailpembelian as a, pembelian as b, ongkir as c
									  WHERE a.id_detailpembelian = b.id_detailpembelian
									  AND a.id_ongkir = c.id_ongkir
									  AND a.status_pengiriman = 'diterima'
									  $sqldate
									  GROUP BY a.id_detailpembelian DESC LIMIT $posisi,$batas") or die(mysql_error());
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($dlapharian = mysql_fetch_array($qlapharian)){
				if ($i >= $kolom){
					echo "<tr class='row$dlapharian[id_detailpembelian]'>";
				}
				$qdata = mysql_query("SELECT * FROM pembelian WHERE id_detailpembelian = $dlapharian[id_detailpembelian]");
				$total = 0;
				$qb = 0;
				while($ddata = mysql_fetch_array($qdata)){
				$total = $total + ($ddata['stok_temp'] * $ddata['harga_temp']);
				$qb = $qb + ($ddata['stok_temp']*$ddata['berat_temp']);
				}
				$total = ($dlapharian['harga_ongkir']*(int)ceil($qb)) + $total;
			?>
				<td align="center"><?php echo $no; ?></td>
				<td align="center"><?php echo $dlapharian['id_detailpembelian']; ?></td>
				<td><?php echo $dlapharian['nama_pemesan']; ?></td>
				<td><?php echo $dlapharian['tanggal_detailpembelian']; ?></td>
				<td>Rp. <?php echo number_format($total,'2','.',','); ?></td>
                <td><a href="?page=laporanharian&act=view&id_detailpembelian=<?php echo $dlapharian['id_detailpembelian']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
				<td width="45">
					<a href="<?php echo $dlapharian['id_detailpembelian']; ?>" id="laporan" class="ask">
						<img src="images/trash.png" alt="" title="" border="0" />
					</a>
				</td>
			<?php
			$i++;
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
	$perintah = "SELECT * FROM detailpembelian as a, ongkir as b
				 WHERE a.id_ongkir = b.id_ongkir
				 AND status_pengiriman = 'diterima' 
				 $sqldate";
	$tampil2 = mysql_query($perintah);
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=laporanharian&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=laporanharian&halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?page=laporanharian&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?page=laporanharian&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=laporanharian&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
		
	echo "</div>";
?>
<h2>&nbsp;</h2>
<form method="post" action="filepdf/laporanpdf.php">
	<input type="hidden" name="cmd" value="<?php echo $perintah; ?>" />
    <input type="submit" name="print" value="PrintPDF" />
</form>
<?php
}
?>
</body>
</html>