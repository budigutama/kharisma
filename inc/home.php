<?php
$batas   = 9;
if(isset($_GET['halaman']))
	$halaman = $_GET['halaman'];
	
if(empty($halaman)){
	$posisi  = 0;
	$halaman = 1;
}
else{
	$posisi = ($halaman-1) * $batas;
}

if(isset($_POST['textcari'])){
		$sqlcari = "AND nama_produk LIKE '%$_POST[textcari]%'";
}
else
	$sqlcari = "";
?>
<div class="oferta">
    <div class="oferta_details">
    <?php include "inc/ofreta.php"; ?>
    </div>
    </div>
    <?php
			if (isset($_GET['urutkan'])){
				$urut=$_GET['urutkan'];
				if($urut=='produk_terlaris'){
				 $title = "Produk Terlaris";
				 $sqlproduk = "SELECT *,SUM(qty) as jumlah
						  FROM t_detail_pembelian as a, t_detailproduk as b, t_produk as c
						  WHERE a.id_detailproduk = b.id_detailproduk
						  AND b.id_produk = c.id_produk
						  $kat
						  GROUP BY c.id_produk
						  ORDER BY jumlah DESC
						  LIMIT 9";
				}
					elseif($urut=='produk_diskon'){
					 $title = "Produk Diskon";
				     $sqlproduk = "SELECT * FROM t_produk
							 		WHERE diskon_produk > 0
						  		  	$kat
							 		GROUP BY id_produk order by diskon_produk desc
									LIMIT 9";
				}
					elseif($urut=='produk_lihat'){
					 $title = "Produk Paling Banyak Dilihat";
				     $sqlproduk = "SELECT * FROM t_produk
							 		WHERE viewcounter_produk > 0
						  		  	$kat
							 		GROUP BY id_produk order by viewcounter_produk desc
									LIMIT 9";
				}
					elseif($urut=='produk_terbaru'){
					 $title = "Produk Terbaru";
				     $sqlproduk = "SELECT * FROM t_produk a, t_detailproduk b 
					 				WHERE a.id_produk=b.id_produk
					 				$kat
									GROUP BY b.id_produk
									order by tanggal_detailproduk desc
									LIMIT 9";
				}
			}
			elseif (isset($_GET['size'])){
				$size=$_GET['size'];
				$title = "Produk Size $size";
				$sqlproduk = "SELECT * FROM produk a, detailproduk b, ukuran c
							  WHERE a.id_produk=b.id_produk
							  AND b.id_ukuran=c.id_ukuran
							  AND c.nama_ukuran='$size'
							  GROUP BY a.id_produk
							  LIMIT 9";
			}
			elseif (isset($_GET['warna'])){
				$warna=$_GET['warna'];
				$title = "Produk Warna $warna";
				$sqlproduk = "SELECT * FROM produk a, detailproduk b, warna c
							  WHERE a.id_produk=b.id_produk
							  AND b.id_warna=c.id_warna
							  AND c.nama_warna='$warna'
							  GROUP BY a.id_produk
							  LIMIT 9";
			}
			elseif (isset($_GET['harga'])){
				$harga=$_GET['harga'];
				$title = "Produk Harga Rp.".substr($harga,14,7)."an";
				$sqlproduk = "SELECT * FROM produk a, detailproduk b
							  WHERE a.id_produk=b.id_produk
							  AND a.$harga
							  GROUP BY a.id_produk
							  LIMIT 9";
			}
			elseif (isset($_GET['idkat'])){
				$idk=$_GET['idkat'];
				$kategori=mysql_fetch_array(mysql_query("Select * FROM t_kategori Where id_kategori=$idk"));
				$title = "Produk Kategori $kategori[nama_kategori]";
				$sqlproduk = "SELECT * FROM t_produk a, t_detailproduk b, t_kategori c
							  WHERE a.id_produk=b.id_produk
							  AND a.id_kategori=c.id_kategori
							  AND a.id_kategori=$idk
							  GROUP BY a.id_produk
							  LIMIT 9";
			}
			elseif (isset($_GET['idmerk'])){
				$idm=$_GET['idmerk'];
				$merek=mysql_fetch_array(mysql_query("Select * FROM t_merek Where id_merek=$idm"));
				$title = "Produk Merek $merek[nama_merek]";
				$sqlproduk = "SELECT * FROM t_produk a, t_detailproduk b, t_merek c
							  WHERE a.id_produk=b.id_produk
							  AND a.id_merek=c.id_merek
							  AND a.id_merek=$idm
							  GROUP BY a.id_produk
							  LIMIT 9";
			}
			else
			{
				$title = "Produk";
				$sqlproduk = "SELECT * FROM t_produk a, t_detailproduk b 
					 		  WHERE a.id_produk=b.id_produk
					 		  $sqlcari
							  GROUP BY b.id_produk
							  order by tanggal_detailproduk desc";
			}
	?>
   	<div class="center_title_bar" style="margin-bottom:20px;"><?php echo $title; ?></div>
    <div class="sorting"><?php include "inc/sort.php" ?></div>
    <?php

if(isset($_GET['code'])){
	if(mysql_num_rows(mysql_query("SELECT * FROM t_member WHERE verificationcode_member = '$_GET[code]' AND status_member = '0'")) == 1){
		mysql_query("UPDATE t_member SET status_member = '1'
			     WHERE verificationcode_member = '$_GET[code]'");
		echo "<h3>Verifikasi Telah Dilakukan, Silahkan Login !!</h3>";
	}
	else{
		echo "<h3>Verifikasi Gagal !!</h3>";
	}
}
	
	$tampil2 = mysql_query($sqlproduk) or die(mysql_error());
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
					  
	$qproduk = mysql_query($sqlproduk) or die(mysql_error());
	$no = 0;
	$kolom=1;
	$i=0;
	$no = $posisi+1;
	while($dproduk = mysql_fetch_array($qproduk)){
				$qgbr=mysql_fetch_array(mysql_query("SELECT nama_gambar gbr from t_gambar 
												   WHERE id_produk=$dproduk[id_produk]"));
				$gbr=$qgbr['gbr'];
	?>
   	<div class="prod_box">
            <div class="center_prod_box">
            <a href="?page=detail&idb=<?php echo $dproduk['id_produk']; ?>" title="<?php echo $dproduk['nama_produk']; ?>">            
             <div class="product_img">
             <img src="gambar/produk/<?php echo $gbr; ?>" alt=" title="<?php echo $dproduk['nama_produk']; ?>"" height="175" width="160"  border="0" title="Klik Untuk Melihat detil" />
             </div>
         <div class="frame"></div>
         <?php
		if($dproduk['diskon_produk'] != 0){
			$col="#C36";
			$harga="Rp.".number_format($dproduk['harga_produk'],"0",".",".")." - Dis ".$dproduk['diskon_produk']."%";
		}
		else {
			$col="#666";
			$harga="Rp.".number_format(hargadiskon($dproduk['id_produk']),"0",".",".")."";
		}?>
                 <div class="prod_price"><?php echo $dproduk['nama_produk']; ?></div>  
                 <div class="nama_prod" style="color:<?php echo $col;?>"><?php echo $harga; ?></div></a>  
            </div>
    </div>
    <?php
	$i++;
	$no++;
	}
	?>
<div class="pagination">
    <?php

		// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	?>
	</div>
