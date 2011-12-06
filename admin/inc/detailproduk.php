<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					produk: "required",
					warna: "required",
				  	stok: {
          	 			required: true,
					   	number: true
          			},
				  	berat: {
          	 			required: true,
					   	number: true
          			}
				},
			
				messages: { 
						produk: {
							required: '. produk harus di isi'
						},
						warna: {
							required: '. Warna harus di isi'
						},
					  	stok: {
							required: '. Stok harus di isi',
							number  : '. Hanya boleh di isi Angka'
						},
					  	berat: {
							required: '. Berat harus di isi',
							number  : '. Hanya boleh di isi Angka'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<H2>Pengolahan Detail Produk </H2> 
<?php
$idp = $_GET['idp'];
$dtprod=mysql_fetch_array(mysql_query("SELECT * FROM t_produk a, t_merek b, t_kategori c
									  WHERE a.id_merek=b.id_merek
									  AND a.id_kategori=c.id_kategori
									  AND a.id_produk='$idp'
									  GROUP BY a.id_produk"));

if(isset($_POST['save'])){
	$id_warna = addslashes($_POST['id_warna']);
	$berat = addslashes($_POST['berat']);
	$stok = addslashes($_POST['stok']);
	$promo = addslashes($_POST['promo']);
	if(mysql_num_rows(mysql_query("SELECT * FROM t_detailproduk WHERE id_produk = $idp AND id_warna = $id_warna ")) == 0){
	mysql_query("INSERT INTO t_detailproduk VALUES(null,$idp,$id_warna,now(),$stok,$berat)") or die(mysql_error());
  echo "<div class=sukses>detail Produk Berhasil Ditambah</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script> 
		var targetURL="?page=detailproduk&idp=<?php echo $idp; ?>"
		var countdownfrom=3
		var currentsecond=document.redirect.redirect2.value=countdownfrom+1
		function countredirect(){
		  if (currentsecond!=1){
			currentsecond-=1
			document.redirect.redirect2.value=currentsecond
		  }
		  else{
			window.location=targetURL
			return
		  }
		  setTimeout("countredirect()",1000)
		}
		countredirect()
	    </script>
    <?php
	}
	else{
		echo "<div class=gagal>Detail produk Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['tambah'])){
		$imagename = $_FILES['upload']['name'];
	    $imagetype = $_FILES['upload']['type'];
		$source = $_FILES['upload']['tmp_name'];

		$ncount = count($imagename);
		$i = 0;
		while($i < $ncount){
			$imagepath = $imagename[$i];
			$target = "../gambar/produk/".$imagepath;
			if(($imagetype[$i]=="image/jpeg") or ($imagetype[$i]=="image/gif")){
				move_uploaded_file($source[$i], $target);
				$qcheckprofile = mysql_query("SELECT * FROM t_gambar WHERE id_produk = $idp AND profile_gambar = '1'");
				if(mysql_num_rows($qcheckprofile) == 0){
					mysql_query("INSERT INTO t_gambar
								VALUES(null, $idp, '$imagepath', '1')");
				}
				else{
					mysql_query("INSERT INTO t_gambar
								VALUES(null, $idp, '$imagepath', '0')");
				}
			}
			else
				echo "<script>pesan('Gambar Ke-".($i+1)." Harus Bertype JPEG dan GIF !!!','Peringatan');</script>";
				
		$i++;
		}
		?>
		<form name="redirect">
			<input type="hidden" name="redirect2">
		</form>
		<script>
		var targetURL="?page=detailproduk&idp=<?php echo $idp; ?>"
		var countdownfrom=3
		var currentsecond=document.redirect.redirect2.value=countdownfrom+1
		function countredirect(){
		  if (currentsecond!=1){
			currentsecond-=1
			document.redirect.redirect2.value=currentsecond
		  }
		  else{
			window.location=targetURL
			return
		  }
		  setTimeout("countredirect()",1000)
		}
		countredirect()
		  </script>        
  <?php
}

if(isset($_POST['update'])){
	$id_detailproduk = addslashes($_POST['id_detailproduk']);
	$id_warna = addslashes($_POST['id_warna']);
	$promo = addslashes($_POST['promo']);
	$stok = addslashes($_POST['stok']);
	$berat = addslashes($_POST['berat']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM t_detailproduk WHERE id_produk = $idp AND id_warna = $id_warna AND id_detailproduk != $id_detailproduk")) == 0){
	mysql_query("UPDATE t_detailproduk SET id_warna = '$id_warna', 
				berat_detailproduk = '$berat', stok_detailproduk = '$stok'
				WHERE id_detailproduk = $id_detailproduk");
  echo "<div class=sukses>Detail Produk Berhasil Diupdate</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=detailproduk&idp=<?php echo $idp; ?>"
		var countdownfrom=3
		var currentsecond=document.redirect.redirect2.value=countdownfrom+1
		function countredirect(){
		  if (currentsecond!=1){
			currentsecond-=1
			document.redirect.redirect2.value=currentsecond
		  }
		  else{
			window.location=targetURL
			return
		  }
		  setTimeout("countredirect()",1000)
		}
		countredirect()
	    </script>
    <?php
	}
	else{
		echo "<div class=gagal>Detail produk Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" id="registrationform">
        <table>
        	<tr>
            	<td><label for="produk">Nama produk :</label></td>
            	<td><b><?php echo $dtprod['nama_produk']; ?></b></td>
            </tr>
        	<tr>
            	<td><label for="warna">Warna :</label></td>
            	<td>
                		<select size="1" name="id_warna" id="warna">
                        <?php
						$qwarna = mysql_query("SELECT * FROM t_warna");
						while($dwarna = mysql_fetch_array($qwarna)){
						?>
                        	<option value="<?php echo $dwarna['id_warna']; ?>"><?php echo $dwarna['nama_warna']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
            <tr>
                <td><label for="stok">Stok :</label></td>
                <td><input name="stok" id="stok" size="3" maxlength="6" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="berat">Berat :</label></td>
                <td><input name="berat" id="berat" size="3" maxlength="6" class="inputan"/>&nbsp;<strong>Kg</strong></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                <button name="save" class="blue"/><span class="label1">Simpan</span></button>
                <a class="button red" href="?page=detailproduk&idp=<?php echo $idp; ?>"/><span class="label1">Batal</span></a>
            </td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_detailproduk = addslashes($_GET['idb']);
	$qdetailproduk = mysql_query("SELECT * FROM t_detailproduk a, t_produk b, t_warna d
						 WHERE a.id_produk = b.id_produk
						 AND a.id_warna = d.id_warna
						 AND a.id_detailproduk = '$id_detailproduk'");
	$ddetailproduk = mysql_fetch_array($qdetailproduk);
	?>
    <form action="" method="post" id="registrationform">
        <table>
            <tr>
                <td><label for="produk">produk :</label></td>
                <td><input type="text" value="<?php echo $dtprod['nama_produk']; ?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <td><label for="warna">Warna :</label></td>
                <td>
                	<select name="id_warna" id="warna">
                    	<?php
						$qwarna = mysql_query("SELECT * FROM t_warna");
						while($dwarna = mysql_fetch_array($qwarna)){
						?>
                        	<option value="<?php echo $dwarna['id_warna']; ?>" <?php echo($dwarna['id_warna'] == $ddetailproduk['id_warna'])?"selected":""; ?>><?php echo $dwarna['nama_warna']; ?></option>
                        <?php
						}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="stok">Stok :</label></td>
                <td><input name="stok" id="stok" size="3" maxlength="6" value="<?php echo $ddetailproduk['stok_detailproduk']; ?>" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="berat">Berat :</label></td>
                <td><input name="berat" id="berat" size="3" maxlength="6" value="<?php echo $ddetailproduk['berat_detailproduk']; ?>" class="inputan"/>&nbsp;<strong>Kg</strong></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                <input type="hidden" name="id_detailproduk" value="<?php echo $id_detailproduk; ?>" />
                <button name="update" class="blue"/><span class="label1">Ubah</span></button>
                <a class="button red" href="?page=detailproduk&idp=<?php echo $idp; ?>"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
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
<table>
<tr>
    <td>Nama Produk</td>
    <td width="100px">: <?php echo $dtprod['nama_produk'];?></td>
<?php
$qgbr=mysql_query("SELECT * FROM t_gambar WHERE id_produk=$idp LIMIT 6");
while ($g=mysql_fetch_array($qgbr)){
?>
  <td width="70" height="80" rowspan="4">
  <img src="../gambar/produk/<?php echo $g['nama_gambar']; ?>" height="80" /></td>
<?php } ?>
  </tr>
  <tr>
    <td>Nama Kategori </td>
    <td>: <?php echo $dtprod['nama_kategori']; ?></td>
  </tr>
  <tr>
    <td>Nama Merek </td>
    <td>: <?php echo $dtprod['nama_merek']; ?></td>
  </tr>
  <tr>
    <td>Harga</td>
    <td>: <?php echo "Rp. ".number_format($dtprod['harga_produk'],2,",",".");?></td>
  </tr>
</table>
<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="100" class="rounded" scope="col">Warna</th>
            <th width="200" class="rounded" scope="col">Tanggal Input</th>
            <th width="50" class="rounded" scope="col">Berat</th>
            <th width="50" class="rounded" scope="col">Stok</th>
            <th width="36" class="rounded" scope="col">Ubah</th>
            <th width="36" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qdetailproduk = mysql_query("SELECT * FROM t_detailproduk a, t_produk b, t_warna d
									WHERE a.id_produk = b.id_produk
									AND a.id_warna = d.id_warna
									AND b.id_produk='$idp'
									ORDER BY a.id_produk LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($ddetailproduk = mysql_fetch_array($qdetailproduk)){
			if ($i >= $kolom){
  					if($i%2)
  						echo "<tr style='background-color:#a8cee9'class='row$ddetailproduk[id_detailproduk]'>";
  					else
  						echo "<tr style='background-color:#FFF'class='row$ddetailproduk[id_detailproduk]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $ddetailproduk['nama_warna']; ?></td>
            <td><?php echo tgl_indo($ddetailproduk['tanggal_detailproduk']); ?></td>
            <td><?php echo $ddetailproduk['berat_detailproduk']; ?> Kg</td>
            <td><?php echo $ddetailproduk['stok_detailproduk']; ?> Pcs</td>
            <td>
            	<a href="?page=detailproduk&act=edit&idb=<?php echo $ddetailproduk['id_detailproduk']; ?>&idp=<?php echo $idp; ?>" title="Ubah"><span class="icon icon145"></span></a>
            </td>
            <td width="45">
            	<a href="<?php echo $ddetailproduk['id_detailproduk']; ?>" id="detailproduk" class="ask" title="Hapus">
                	<span class="icon icon186"></span></a>
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
<br />
<a href="?page=detailproduk&act=add&idp=<?php echo $idp;?>"class="button blue"><span class="label1">Tambah Produk</span></a>
<a href="?page=produk"class="button red"><span class="label1">Kembali</span></a>   <br /><br /><br />
    <hr width="100%" align="left"/>
    <h4>Tambah Gambar</h4>
    <form method="post" action="" enctype="multipart/form-data">
   	<table>
   		<tr>
        	<td>
            	<div id="gambarupload">
                    <table>
                        <tr>
                            <td width="99"><label for="upload">Upload :</label></td>
                            <td><input type="file" name="upload[]" id="upload" /></td>
                        </tr>
                    </table>
            	</div>
            	<div id="app"></div>
            </td>
        </tr>
        <tr>
        	<td>
    			<a href="#" id="tambahbtn"><img src="images/tambah.png" border="0" title="Tambah Upload"/></a>
            </td>
    	</tr>
        <tr align="center">
        	<td>
            	<button name="tambah" class="blue"/><span class="label1">Simpan Gambar</span></button>
            </td>
    	</tr>
    </table>
    </form>
    <script>
		$("#tambahbtn").click(function(){
			$("#gambarupload").clone().appendTo('#app');					   
		});
	</script>

<div class="pagination">
	<?php
	$tampil2 = mysql_query("SELECT * FROM t_detailproduk a, t_produk b, t_warna d
							WHERE a.id_produk = b.id_produk
							AND a.id_warna = d.id_warna
							$sqlquery
							AND b.id_produk='$idp'");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=detailproduk&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=detailproduk&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=detailproduk&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=detailproduk&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=detailproduk&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	
	echo "</div>";
}
	?>
     
     <h2>&nbsp;</h2>
