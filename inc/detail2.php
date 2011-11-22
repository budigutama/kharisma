<script src="js/star/jquery.tools.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/star/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="js/star/jquery.ui.stars.js"></script>

<?php
viewcounter($_GET['idb']);

if(isset($_POST['submitvote']))
	updatevote($_POST['idb'],$_POST['vote']);

if(isset($_GET['idb']))
	$idb = addslashes($_GET['idb']);
	$qdetail = mysql_query("SELECT * FROM t_produk a, t_kategori b, t_merek c
						   WHERE a.id_produk = $idb
						   AND a.id_kategori=b.id_kategori
						   AND c.id_merek=a.id_merek
						   GROUP BY a.id_produk");
	$ddetail = mysql_fetch_array($qdetail);
	$dgambar="SELECT nama_gambar as gbr FROM t_gambar WHERE id_produk = $idb";
	//$gbr = mysql_fetch_array($dgambar);
?>
   	<div class="center_title_bar">Detail Produk <?php echo $ddetail['nama_produk']; ?></div>
    	<div class="prod_box_big">
            <div class="center_prod_box_big">
 <?php 
  if(isset($_POST['submit'])){
	$jml=$_POST['jml'];
	if($_POST['warna'] != '-'){
	  if ($jml >0 && $jml!=''){	
		$qproduk = mysql_query("SELECT * FROM t_detailproduk WHERE id_produk = $_POST[produk] AND id_warna = $_POST[warna]");
		$dproduk = mysql_fetch_array($qproduk);
		if ($jml<=$dproduk['stok_detailproduk']){
		$iddb = $dproduk['id_detailproduk'];
		$ncart = mysql_num_rows(mysql_query("SELECT * FROM t_pemesanan
											WHERE session_id = '".session_id()."'
											AND id_detailproduk = $iddb"));
		if($ncart != 0){
			mysql_query("UPDATE t_pemesanan SET qty = qty + $jml
						WHERE session_id = '".session_id()."'
						AND id_detailproduk = $iddb");
			mysql_query("UPDATE t_detailproduk SET stok_detailproduk=stok_detailproduk-$jml WHERE id_detailproduk=$iddb");
		echo "<script>window.location = '?page=cart';</script>";
		}
		else{
			$qdetail = mysql_query("SELECT * FROM t_detailproduk a, t_produk b
									WHERE a.id_produk = b.id_produk
									AND a.id_detailproduk = $iddb") or die(mysql_error());
			$ddetail = mysql_fetch_array($qdetail);
			$berat = $ddetail['berat_detailproduk'];
			$idmember = NULL;
			if(isset($_SESSION['id_member']))
				$idmember = $_SESSION['id_member'];
			if($ddetail['diskon_produk'] !=0)
				$hargaproduk = hargadiskon($ddetail['id_produk']);
			else
				$hargaproduk = $ddetail['harga_produk'];
			mysql_query("INSERT INTO t_pemesanan VALUES(null,$iddb,'".session_id()."',$jml,$berat,$hargaproduk,now())") or die(mysql_error());
			mysql_query("UPDATE t_detailproduk SET stok_detailproduk=stok_detailproduk-$jml WHERE id_detailproduk=$iddb");
			
		echo "<script>window.location = '?page=cart';</script>";
		}
	}
	else{
		echo "<h3> Maaf, Stok tidak mencukupi atau jumlah tidak boleh -, Silahkan Ulangi Kembali.</h3>";
	}
	} 
	else{
		echo "<h3> Jumlah Tidak Valid, Jumlah harus lebih besar dari 0..</h3>";
	}
	} 
	else{
		echo "<h3> Anda Belum Memilih Warna. Silahkan Ulangi Kembali.</h3>";
	}
}
 ?>
              <div class="product_img_big" style="width:47%;">
                 <?php include "inc/gambar_detail.php"; ?>
              </div>
              <div class="details_big_box" style="width:48%; border:#CCC solid 1px; height:345px">
                       <form method="post" action="" >
                         <div class="product_title_big"><?php echo $ddetail['nama_produk']; ?></div>
                         <div class="specifications">
                         <table>
                         	<tr>
                            	<td>Kategori</td>
                            	<td>: <span class="blue"><?php echo $ddetail['nama_kategori']; ?>
                                </span></td>
                            </tr>
                         	<tr>
                            	<td>Merek</td>
                            	<td>: <span class="blue"><?php echo $ddetail['nama_merek']; ?>
                                </span></td>
                            </tr>
                         	<tr>
                            	<td>Warna</td>
                            	<td>: <span class="blue">
								<select name="warna" id="warna">
                                	<option value="-">-- Pilih Warna --</option>
                                    <?php
								$qwarna = mysql_query("SELECT * FROM t_detailproduk a,t_warna b
													   WHERE a.id_warna = b.id_warna
													   AND a.id_produk = $idb
													   GROUP BY a.id_warna");
								while($dwarna = mysql_fetch_array($qwarna)){
									?>
                                    <option value="<?php echo $dwarna['id_warna']; ?>"><?php echo $dwarna['nama_warna']; ?></option>
                                    <?php
									}
									?>
                                </select>
                                </span></td>
                            </tr>
                         	<tr>
                            	<td>Stok</td>
                            	<td>: <span class="blue" id="stok"></span></td>
                            </tr>
                         	<tr>
                            	<td>Berat</td>
                            	<td>: <span class="blue" id="berat"><?php echo $ddetail['berat_detailproduk']; ?></span><span class="blue"> Kg</span></td>
                            </tr>
                         	<tr>
                            	<td>Diskon</td>
                            	<td>: <span class="red"><?php echo $ddetail['diskon_produk']; ?> %</span></td>
                            </tr>
                            <tr>
                            	<td><strong>Jumlah</strong></td>
                            	<td>: <input name="jml" type="text" size="2" /> Pcs
                                </td>
                            </tr>
                         </table>
                         </div>
                         <div class="prod_price_big">
                         <?php
						 if($ddetail['diskon_produk'] != 0){
						 ?>
                         	<span class="reduce">Rp. <?php echo number_format($ddetail['harga_produk'],"2",".",","); ?></span>
                         <?php
						 }
						 ?>
                            <span class="price">Rp. <?php echo number_format(hargadiskon($idb),"2",".",","); ?></span>
                         </div>
                         <input type="hidden" id="produk" name="produk" value="<?php echo $ddetail['id_produk']; ?>" />
                         <button name="submit" class="button">
                         <span class="label1">Add To Cart</span><span class="icon icon169"></span>
                         </button>
                     </form>
    				<?php include "inc/vote.php"; ?>
                     </div>                        
            </div>                            
        </div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
    	<H3 align="left">Detail Produk</H3>
        <p align="justify"><?php echo $ddetail['deskripsi_produk']; ?></p>
    </div>
</div>        
<div class="prod_box_big">
	<div class="center_prod_box_big"">
    	<H3 align="left">Anda Mungkin Menyukai Juga Produk Lainnya...</H3>
        <?php $idkat = $ddetail['id_kategori'];$idmer = $ddetail['id_merek']; 
		$lainnya=mysql_query("SELECT * FROM t_produk a, t_gambar b
							  WHERE a.id_produk=b.id_produk
							  AND ( a.id_kategori=$idkat OR a.id_merek=$idmer )
							  AND a.id_produk != $idb
							  GROUP BY a.id_produk
							  LIMIT 6"); 
		while ($lain=mysql_fetch_array($lainnya)){
		?>
   	<div class="prod_box" style="padding:5px;">
            <div class="center_prod_box">
            <a href="?page=detail&idb=<?php echo $lain['id_produk']; ?>" title="<?php echo $lain['nama_produk']; ?>">            
             <div class="product_img">
             <img src="gambar/produk/<?php echo $lain['nama_gambar']; ?>" alt=" title="<?php echo $lain['nama_produk']; ?>"" height="175" width="160"  border="0" title="Klik Untuk Melihat detil" />
             </div>
         <div class="frame"></div>
         <?php
		if($lain['diskon_produk'] != 0){
			$col="#C36";
			$harga="Rp.".number_format($lain['harga_produk'],"0",".",".")." - Dis ".$lain['diskon_produk']."%";
		}
		else {
			$col="#666";
			$harga="Rp.".number_format(hargadiskon($lain['id_produk']),"0",".",".")."";
		}?>
                 <div class="prod_price"><?php echo $lain['nama_produk']; ?></div>  
                 <div class="nama_prod" style="color:<?php echo $col;?>"><?php echo $harga; ?></div></a>  
    </div>
</div>        
        <?php } ?>
    </div>
</div>        
<div class="prod_box_big">
	<div class="center_prod_box_big">
    	<H3 align="left">Testimoni Produk</H3>
        <p align="justify"><?php echo $ddetail['deskripsi_produk']; ?></p>
    </div>
</div>        
<script type="text/javascript"> 
	
	$("#warna").change(function(){ 
		var idb = $("#produk").val();
		var idw = $("#warna").val();
		$.ajax({ 
			url: "inc/getdata/stok.php", 
			data: "idb="+idb+"&idw="+idw, 
			cache: false, 
			success: function(msg){
				$("#stok").html(msg); 
			} 
		 }); 
    });
	
	$("#ukuran").change(function(){ 
		var idb = $("#produk").val();
		var idw = $("#warna").val();
		var idu = $("#ukuran").val();
		$.ajax({ 
			url: "inc/getdata/stok.php", 
			data: "idb="+idb+"&idw="+idw+"&idu="+idu, 
			cache: false, 
			success: function(msg){
				$("#stok").html(msg); 
			} 
		 }); 
    });
	
	$("#warna").change(function(){ 
		var idb = $("#produk").val();
		var idw = $("#warna").val();
		$.ajax({ 
			url: "inc/getdata/berat.php", 
			data: "idb="+idb+"&idw="+idw, 
			cache: false, 
			success: function(msg){
				$("#berat").html(msg); 
			} 
		 }); 
    });
	
</script> 