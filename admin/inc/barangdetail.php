<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					barang: "required",
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
						barang: {
							required: '. Barang harus di isi'
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
					label.text('OK!').addClass('valid');
				}
			});
		});
</script>
<?php
$idp = $_GET['idp'];
$dtprod=mysql_fetch_array(mysql_query("SELECT * FROM barang a, merek b
									  WHERE a.id_merek=b.id_merek 
									  AND a.id_barang='$idp'
									  GROUP BY a.id_barang"));

if(isset($_POST['save'])){
	$id_warna = addslashes($_POST['id_warna']);
	$berat = addslashes($_POST['berat']);
	$stok = addslashes($_POST['stok']);
	$promo = addslashes($_POST['promo']);
	if(mysql_num_rows(mysql_query("SELECT * FROM barangdetail WHERE id_barang = $idp AND id_warna = $id_warna ")) == 0){
	mysql_query("INSERT INTO barangdetail VALUES(null,$idp,$id_warna,now(),$stok,$berat)") or die(mysql_error());
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script> 
		loading('Data Sedang Disimpan', 'Loading')
		var targetURL="?page=barangdetail&idp=<?php echo $idp; ?>"
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
  		echo "<script>pesan('Maaf, Detail Barang Tidak Boleh Sama !!','Peringatan');</script>";
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
			$target = "../gambar_produk/".$imagepath;
			if(($imagetype[$i]=="image/jpeg") or ($imagetype[$i]=="image/gif")){
				move_uploaded_file($source[$i], $target);
				$qcheckprofile = mysql_query("SELECT * FROM gambar WHERE id_barang = $idp AND profile_gambar = '1'");
				if(mysql_num_rows($qcheckprofile) == 0){
					mysql_query("INSERT INTO gambar
								VALUES(null, $idp, '$imagepath', '1')");
				}
				else{
					mysql_query("INSERT INTO gambar
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
		loading('Data Sedang Disimpan', 'Loading');  
		var targetURL="?page=barangdetail&idp=<?php echo $idp; ?>"
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
	$id_barangdetail = addslashes($_POST['id_barangdetail']);
	$id_warna = addslashes($_POST['id_warna']);
	$promo = addslashes($_POST['promo']);
	$stok = addslashes($_POST['stok']);
	$berat = addslashes($_POST['berat']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM barangdetail WHERE id_barang = $idp AND id_warna = $id_warna AND id_barangdetail != $id_barangdetail")) == 0){
	mysql_query("UPDATE barangdetail SET id_warna = '$id_warna', 
				berat_barangdetail = '$berat', stok_barangdetail = '$stok'
				WHERE id_barangdetail = $id_barangdetail");
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		loading('Data Sedang Diupdate', 'Loading');  
		var targetURL="?page=barangdetail&idp=<?php echo $idp; ?>"
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
  		echo "<script>pesan('Maaf, Detail Barang Tidak Boleh Sama !!','Peringatan');</script>";
	}
}
?>
<div class="judul_halaman">
Pengolahan Detail Produk ( <?php echo $dtprod['kode_merek'].$idp; ?> ) <?php echo $dtprod['nama_barang']; ?></div> 

<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
        	<tr>
            	<td><label for="barang">Nama Barang :</label></td>
            	<td><input type="text" value="<?php echo $dtprod['nama_barang']; ?>" readonly="readonly" />
               	</td>
            </tr>
        	<tr>
            	<td><label for="warna">Warna :</label></td>
            	<td>
                		<select size="1" name="id_warna" id="warna">
                        <?php
						$qwarna = mysql_query("SELECT * FROM warna");
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
                <td><input name="stok" id="stok" size="3" maxlength="6" /></td>
            </tr>
            <tr>
                <td><label for="berat">Berat :</label></td>
                <td><input name="berat" id="berat" size="3" maxlength="6" />&nbsp;<strong>Kg</strong></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="submit" name="save" class="tombol" value="Simpan" />
              <input type="reset" name="reset" value="Batal" class="tombol" onClick="window.location = '?page=barangdetail&idp=<?php echo $idp; ?>';" /></td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_barangdetail = addslashes($_GET['idb']);
	$qbarangdetail = mysql_query("SELECT * FROM barangdetail as a, barang as b,warna as d
						 WHERE a.id_barang = b.id_barang
						 AND a.id_warna = d.id_warna
						 AND a.id_barangdetail = '$id_barangdetail'");
	$dbarangdetail = mysql_fetch_array($qbarangdetail);
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
            <tr>
                <td><label for="barang">Barang :</label></td>
                <td><input type="text" value="<?php echo $dtprod['nama_barang']; ?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <td><label for="warna">Warna :</label></td>
                <td>
                	<select name="id_warna" id="warna">
                    	<?php
						$qwarna = mysql_query("SELECT * FROM warna");
						while($dwarna = mysql_fetch_array($qwarna)){
						?>
                        	<option value="<?php echo $dwarna['id_warna']; ?>" <?php echo($dwarna['id_warna'] == $dbarangdetail['id_warna'])?"selected":""; ?>><?php echo $dwarna['nama_warna']; ?></option>
                        <?php
						}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="stok">Stok :</label></td>
                <td><input name="stok" id="stok" size="3" maxlength="6" value="<?php echo $dbarangdetail['stok_barangdetail']; ?>" /></td>
            </tr>
            <tr>
                <td><label for="berat">Berat :</label></td>
                <td><input name="berat" id="berat" size="3" maxlength="6" value="<?php echo $dbarangdetail['berat_barangdetail']; ?>" />&nbsp;<strong>Kg</strong></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="hidden" name="id_barangdetail" value="<?php echo $id_barangdetail; ?>" />
                	<input type="submit" name="update" class="tombol" value="Ubah" /><input type="reset" class="tombol" name="reset" value="Batal" onClick="window.location = '?page=barangdetail&idp=<?php echo $idp; ?>';" />
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
    <td>Kode Produk</td>
    <td width="100px">: <?php echo $dtprod['kode_merek'].$idp; ?></td>
<?php
$qgbr=mysql_query("SELECT * FROM gambar WHERE id_barang=$idp LIMIT 6");
while ($g=mysql_fetch_array($qgbr)){
?>
  <td width="70" height="80" rowspan="4">
  <img src="../gambar_produk/<?php echo $g['nama_gambar']; ?>" height="80" /></td>
<?php } ?>
  </tr>
  <tr>
    <td>Nama Produk </td>
    <td>: <?php echo $dtprod['nama_barang']; ?></td>
  </tr>
  <tr>
    <td>Harga</td>
    <td>: <?php echo "Rp. ".number_format($dtprod['harga_barang'],2,",",".");?></td>
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
            <th width="42" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qbarangdetail = mysql_query("SELECT * FROM barangdetail as a, barang as b, warna as d
									WHERE a.id_barang = b.id_barang
									AND a.id_warna = d.id_warna
									AND b.id_barang='$idp'
									ORDER BY a.id_barang LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dbarangdetail = mysql_fetch_array($qbarangdetail)){
			if ($i >= $kolom){
  					if($i%2)
  						echo "<tr style='background-color:#a8cee9'class='row$dbarangdetail[id_barangdetail]'>";
  					else
  						echo "<tr style='background-color:#FFF'class='row$dbarangdetail[id_barangdetail]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dbarangdetail['nama_warna']; ?></td>
            <td><?php echo tgl_indo($dbarangdetail['tanggal_barangdetail']); ?></td>
            <td><?php echo $dbarangdetail['berat_barangdetail']; ?> Kg</td>
            <td><?php echo $dbarangdetail['stok_barangdetail']; ?> Pcs</td>
            <td>
            	<a href="?page=barangdetail&act=edit&idb=<?php echo $dbarangdetail['id_barangdetail']; ?>&idp=<?php echo $idp; ?>">
                	<img src="gambar/user_edit.png" alt="" title="" border="0" />
                </a>
            </td>
            <td width="45">
            	<a href="<?php echo $dbarangdetail['id_barangdetail']; ?>" id="barangdetail" class="ask">
                	<img src="gambar/trash.png" alt="" title="" border="0" />
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
<br />
<a href="?page=barangdetail&act=add&idp=<?php echo $idp;?>"><span class="tombol">Tambah Detail Barang</span></a>
<a href="?page=barang"><span class="tombol">Kembali</span></a>    <br /><br />
    <hr width="100%" align="left"/>
    <h4>Tambah Gambar</h4>
    <form method="post" action="" class="niceform" enctype="multipart/form-data">
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
    			<a href="#" id="tambahbtn"><img src="gambar/tambah.png" border="0" title="Tambah Upload"/></a>
            </td>
    	</tr>
        <tr align="center">
        	<td>
            	<input type="submit" name="tambah" class="tombol" value="Simpan Gambar" />
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
	$tampil2 = mysql_query("SELECT * FROM barangdetail as a, barang as b, warna as d
							WHERE a.id_barang = b.id_barang
							AND a.id_warna = d.id_warna
							$sqlquery
							AND b.id_barang='$idp'");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=barangdetail&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=barangdetail&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=barangdetail&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=barangdetail&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=barangdetail&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	
	echo "</div>";
}
	?>
     
     <h2>&nbsp;</h2>
