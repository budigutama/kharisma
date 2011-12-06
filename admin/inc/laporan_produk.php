<?php
    include "inc/lap_produk_filter.php";
	if ($sqldate != ""){
	$batas   = 20;
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
	<table width="592" id="rounded-corner">
		<thead>
			<tr>
				<th width="40" class="rounded-company" scope="col">No</th>
				<th width="90" class="rounded" scope="col">Id</th>
				<th width="90" class="rounded" scope="col">Tanggal Release</th>
				<th width="80" class="rounded" scope="col">Kategori</th>
				<th width="130" class="rounded" scope="col">Nama Produk</th>
				<th width="70" class="rounded" scope="col">Merek</th>
				<th width="60" class="rounded" scope="col">Warna</th>
				<th width="60" class="rounded" scope="col">Diskon</th>
				<th width="60" class="rounded" scope="col">Stok</th>
				<th width="100" class="rounded" scope="col">Harga</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php
			$no = 0;
			$qlapproduk = mysql_query("SELECT *,b.id_produk prod FROM t_detailproduk a, t_produk b, t_merek c, t_warna d, 
									  t_kategori e
									  WHERE b.id_produk=a.id_produk
									  AND c.id_merek=b.id_merek
									  AND d.id_warna=a.id_warna
									  AND e.id_kategori=b.id_kategori
									  $sqldate
									  GROUP BY a.id_detailproduk
									  Order BY tanggal_detailproduk DESC
									  LIMIT $posisi,$batas") or die(mysql_error());
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($dlapproduk = mysql_fetch_array($qlapproduk)){
				if ($i >= $kolom){
					echo "<tr class='row$dlapproduk[id_pembelian]'>";
				}
			?>
				<td align="center"><?php echo $no; ?></td>
				<td align="center"><?php echo $dlapproduk['kode_kategori'].$dlapproduk['kode_merek'].$dlapproduk['prod']; ?></td>
				<td><?php echo tgl_indo($dlapproduk['tanggal_detailproduk']); ?></td>
				<td><?php echo $dlapproduk['nama_kategori']; ?></td>
				<td><?php echo $dlapproduk['nama_produk']; ?></td>
				<td><?php echo $dlapproduk['nama_merek']; ?></td>
				<td><?php echo $dlapproduk['nama_warna']; ?></td>
				<td><?php echo $dlapproduk['diskon_produk']; ?> %</td>
				<td><?php echo $dlapproduk['stok_detailproduk']; ?> Pcs</td>
				<td>Rp. <?php echo number_format($dlapproduk['harga_produk'],'0','.',','); ?></td>
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
	$perintah = "SELECT * FROM t_detailproduk a, t_produk b, t_kategori e
				 WHERE a.id_produk=b.id_produk
				 AND b.id_kategori=e.id_kategori
				 $sqldate";
	$tampil2 = mysql_query($perintah);
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=laporanproduk&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=laporanproduk&halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?page=laporanproduk&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?page=laporanproduk&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=laporanproduk&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
		
	echo "</div>";
?>
<h2>&nbsp;</h2>
<form method="post" action="laporan/laporan_produk.php" target="_blank">
	<input type="hidden" name="cmd" value="<?php echo $sqldate; ?>" />
    <input type="hidden" name="tampil" value="<?php echo $tampil; ?>" />
    <input type="hidden" name="kat" value="<?php echo $kat; ?>" />
	<button name="cetekpdf"><span class="icon icon153"></span><span class="label1">Cetak Laporan Produk</span></button>
</form>
<?php } ?>
