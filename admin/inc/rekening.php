<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					bank : "required",
					nama : "required",
				  	no_rekening: {
          	 			required: true,
					   	number: true,
						minlength: 9
          			},
					cabang : "required"
				},
			
				messages: {
						bank: {
							required: '. Bank harus di isi'
						},
						nama: {
							required: '. Nama Pemilik harus di isi'
						},
					  	no_rekening: {
							required: '. Harga harus di isi',
							number  : '. Hanya boleh di isi Angka',
							minlength  : '. Minimal Harus 9 Angka'
						},
						cabang: {
							required: '. Cabang harus di isi'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data Rekening</h2> 
<?php
if(isset($_POST['save'])){
	$qcek = mysql_query("SELECT * FROM t_rekening WHERE no_rekening = '$_POST[no_rekening]'");
	if(mysql_num_rows($qcek) == 0){
	    $imagename = $_FILES['upload']['name'];
	    $imagetype = $_FILES['upload']['type'];
		$source = $_FILES['upload']['tmp_name'];
		$imagepath = md5(date("m-d-y H:i:s")).$imagename;
		$target = "../gambar/".$imagepath;
		if(($imagetype=="image/jpeg") or ($imagetype=="image/gif")){
			mysql_query("INSERT INTO t_rekening	VALUES (null,'$_POST[nama]','$_POST[bank]','$_POST[cabang]','$_POST[no_rekening]','$imagepath')");
			move_uploaded_file($source, $target);
  echo "<div class=sukses>Rekening $_POST[no_rekening] Berhasil Disimpan</div>"; 
			?>
			<form name="redirect">
				<input type="hidden" name="redirect2">
			</form>
			<script>
			var targetURL="?page=rekening"
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
			echo "<script>pesan('Gambar Harus Bertipe JPEG dan GIF','Perhatian');</script>";	
		}
	}
	else{
		echo "<div class=gagal>Rekenning Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['update'])){
	$id_rekening = addslashes($_POST['id_rekening']);
	$qcek = mysql_query("SELECT * FROM t_rekening WHERE no_rekening = '$_POST[no_rekening]' AND id_rekening != $id_rekening");
	if(mysql_num_rows($qcek) == 0){
	    $imagename = $_FILES['upload']['name'];
	    $imagetype = $_FILES['upload']['type'];
		$source = $_FILES['upload']['tmp_name'];
		$imagepath = md5(date("m-d-y H:i:s")).$imagename;
		$target = "../gambar/".$imagepath;
		$qgambar = mysql_query("SELECT * FROM t_rekening WHERE id_rekening = $id_rekening");
		$dgambar = mysql_fetch_array($qgambar);
		if(($imagetype=="image/jpeg") or ($imagetype=="image/gif")){
			unlink("../gambar/".$dgambar['gambar_rekening']);
			mysql_query("UPDATE t_rekening SET nama_rekening = '$_POST[nama]', bank_rekening = '$_POST[bank]', cabang_rekening = '$_POST[cabang]', no_rekening = '$_POST[no_rekening]', gambar_rekening = '$imagepath' WHERE id_rekening = $id_rekening");
			move_uploaded_file($source, $target);
  echo "<div class=sukses>Rekening $_POST[no_rekening] Berhasil Disimpan</div>"; 
			?>
			<form name="redirect">
				<input type="hidden" name="redirect2">
			</form>
			<script>
			var targetURL="?page=rekening"
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
			mysql_query("UPDATE t_rekening SET nama_rekening = '$_POST[nama]', bank_rekening = '$_POST[bank]', cabang_rekening = '$_POST[cabang]', no_rekening = '$_POST[no_rekening]' WHERE id_rekening = $id_rekening");	
  echo "<div class=sukses>Rekening $_POST[no_rekening] Berhasil Disimpan</div>"; 
			?>
            <form name="redirect">
				<input type="hidden" name="redirect2">
			</form>
			<script>
			var targetURL="?page=rekening"
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
	}
	else{
		echo "<div class=gagal>Rekening Tidak Boleh Sama..!!</div>";	
	}
}

?>
                  
<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" enctype="multipart/form-data" id="registrationform">
        <table>
        	<tr>
            	<td><label for="bank">Nama Bank :</label></td>
            	<td><input type="text" name="bank" id="bank" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="rekening">Nama Pemilik :</label></td>
            	<td><input type="text" name="nama" id="nama" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="nomor">Nomor Rekening :</label></td>
            	<td><input type="text" name="no_rekening" id="no_rekening" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="cabang">Cabang :</label></td>
            	<td><input type="text" name="cabang" id="cabang" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="gambar">Gambar :</label></td>
            	<td><input type="file" name="upload" id="upload" /></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=rekening"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_rekening = addslashes($_GET['idr']);
	$qrek = mysql_query("SELECT * FROM t_rekening WHERE id_rekening = '$id_rekening'");
	$drek = mysql_fetch_array($qrek);
	?>
    <form action="" method="post" enctype="multipart/form-data" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
                <td rowspan="3"><img src="../gambar/<?php echo $drek['gambar_rekening']; ?>" border="1" /></td>
                <td rowspan="6">&nbsp;</td>
            	<td><label for="bank">Nama Bank :</label></td>
            	<td><input type="text" name="bank" id="bank" size="49" maxlength="128" value="<?php echo $drek['bank_rekening']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="rekening">Nama Pemilik :</label></td>
            	<td><input type="text" name="nama" id="nama" size="49" maxlength="128" value="<?php echo $drek['nama_rekening']; ?>"  class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="nomor">Nomor Rekening :</label></td>
            	<td>
                	<input type="hidden" name="id_rekening" value="<?php echo $drek['id_rekening']; ?>" />
                	<input type="text" name="no_rekening" id="no_rekening" size="49" maxlength="128" value="<?php echo $drek['no_rekening']; ?>" class="inputan"/>
                </td>
            </tr>
        	<tr>
                <td rowspan="3">&nbsp;</td>
            	<td><label for="cabang">Cabang :</label></td>
            	<td><input type="text" name="cabang" id="cabang" size="49" maxlength="128" value="<?php echo $drek['cabang_rekening']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="gambar">Gambar :</label></td>
            	<td><input type="file" name="upload" id="upload" /></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=rekening"/><span class="label1">Batal</span></a></td>
            </tr>
        </table>
	</form>
    <?php
	}
}
else
{
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
	<table width="100%" style=" margin-top:10px;">
    <tr>
    <td align="right">
	<a href="?page=rekening&act=add" class="button blue">
    <span class="label1">Tambah Rekening</span></a>
    </td>
    <td align="right" width="70%">
    <form method="post" action="">
    	<select name="type">
        	<option value="0">Semua</option>
        	<option value="1" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 1)?"selected":""; } ?>>Nama Pemilik</option>
            <option value="2" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 2)?"selected":""; } ?>>Bank</option>
            <option value="3" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 3)?"selected":""; } ?>>Cabang</option>
            <option value="4" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 4)?"selected":""; } ?>>No Rekening</option>
        </select>
    	<input type="text" name="textcari" class="newsletter_input" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /></td><td>
        <button name="cari" class="action"/>
        <span class="icon icon198"></span></button>
    </form>
    </td></tr>
    </table>
    <?php
	if(isset($_POST['type'])){
		$type = addslashes($_POST['type']);
		if($type == 0)
			$sqlquery = "";
		elseif($type == 1)
			$sqlquery = "AND nama_rekening LIKE '%$_POST[textcari]%'";
		elseif($type == 2)
			$sqlquery = "AND bank_rekening LIKE '%$_POST[textcari]%'";
		elseif($type == 3)
			$sqlquery = "AND cabang_rekening LIKE '%$_POST[textcari]%'";
		elseif($type == 4)
			$sqlquery = "AND no_rekening LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         

<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Nama Rekening</th>
            <th width="444" class="rounded" scope="col">Bank</th>
            <th width="444" class="rounded" scope="col">Cabang</th>
            <th width="444" class="rounded" scope="col">No Rekening</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qrekening = mysql_query("SELECT * FROM t_rekening
								  WHERE 1
								  $sqlquery
								  LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($drekening = mysql_fetch_array($qrekening)){
			if ($i >= $kolom){
				echo "<tr class='row$drekening[id_rekening]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $drekening['nama_rekening']; ?></td>
            <td><?php echo $drekening['bank_rekening']; ?></td>
            <td><?php echo $drekening['cabang_rekening']; ?></td>
            <td><?php echo $drekening['no_rekening']; ?></td>
            <td><a href="?page=rekening&act=edit&idr=<?php echo $drekening['id_rekening']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td width="45">
            	<a href="<?php echo $drekening['id_rekening']; ?>" id="rekening" class="ask" title="Hapus">
                	<span class="icon icon186"></span>
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
	$tampil2 = mysql_query("SELECT * FROM t_rekening
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=rekening&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=rekening&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=rekening&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=rekening&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=rekening&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	
	echo "</div>";
}
	?>
     
     <h2>&nbsp;</h2>
</body>
</html>
<script>
function conf(){
	var yesno = confirm('Apakah Anda Yakin Ingin Mengubah Data ?','confimation message');
	if(yesno){
		return true;
	}
	else{
		return false;
	}
}
</script>