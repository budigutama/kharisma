<?php
    include "inc/laporan_filter.php";
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
				<th width="100" class="rounded" scope="col">Id</th>
				<th width="90" class="rounded" scope="col">Tanggal</th>
				<th width="100" class="rounded" scope="col">Member</th>
				<th width="160" class="rounded" scope="col">Produk</th>
				<th width="70" class="rounded" scope="col">Merek</th>
				<th width="60" class="rounded" scope="col">Warna</th>
				<th width="60" class="rounded" scope="col">Qty</th>
				<th width="110" class="rounded" scope="col">Harga Satuan</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php
			$no = 0;
			$qlapmingguan = mysql_query("SELECT * FROM t_detail_pembelian a, t_produk b, t_detailproduk c, t_merek d, t_warna e, 
				  t_pembelian f, t_member g, t_kategori h
				  WHERE a.id_pembelian=f.id_pembelian
				  AND a.id_detailproduk=c.id_detailproduk
				  AND f.id_member=g.id_member
				  AND b.id_produk=c.id_produk
				  AND b.id_merek=d.id_merek
				  AND b.id_kategori=h.id_kategori
				  AND c.id_warna=e.id_warna
				  AND f.status='terima'
				  $sqldate
				  Order BY f.id_pembelian DESC
				  LIMIT $posisi,$batas") or die(mysql_error());
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($dlapmingguan = mysql_fetch_array($qlapmingguan)){
				if ($i >= $kolom){
					echo "<tr class='row$dlapmingguan[id_pembelian]'>";
				}
			?>
				<td align="center"><?php echo $no; ?></td>
				<td align="center"><?php echo $dlapmingguan['id_pembelian']; ?></td>
				<td><?php echo tgl_indo($dlapmingguan['tgl_beli']); ?></td>
				<td><?php echo $dlapmingguan['nama_member']; ?></td>
				<td><?php echo $dlapmingguan['kode_kategori'].$dlapmingguan['kode_merek'].$dlapmingguan['id_produk']." - ".$dlapmingguan['nama_produk']; ?></td>
				<td><?php echo $dlapmingguan['nama_merek']; ?></td>
				<td><?php echo $dlapmingguan['nama_warna']; ?></td>
				<td><?php echo $dlapmingguan['qty']; ?> Pcs</td>
				<td>Rp. <?php echo number_format($dlapmingguan['hargabeli'],'0','.',','); ?></td>
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
	$perintah = "SELECT * FROM t_detail_pembelian a, t_pembelian f
				 WHERE a.id_pembelian=f.id_pembelian
				 AND status = 'terima' 
				 $sqldate";
	$tampil2 = mysql_query($perintah);
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=lap_review&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=lap_review&halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?page=lap_review&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?page=lap_review&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=lap_review&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
		
	echo "</div>";
?>
<h2>&nbsp;</h2>
<form method="post" action="laporan/laporantransaksi.php" target="_blank">
	<input type="hidden" name="cmd" value="<?php echo $sqldate; ?>" />
	<input type="hidden" name="tampil" value="<?php echo $tampil; ?>" />
    <input type="hidden" name="per" value="<?php echo $per; ?>" />
	<button name="cetekpdf"><span class="icon icon153"></span><span class="label1">Cetak Laporan Penjualan</span></button>
</form>
<?php } ?>