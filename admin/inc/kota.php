<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					provinsi : "required",
					kota : "required",
					jenis : "required"
				},
			
				messages: {
						provinsi: {
							required: '. Provinsi harus di isi'
						},
						kota: {
							required: '. Kota harus di isi'
						},
						jenis: {
							required: '. Jenis Kota harus di isi'	
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data Kota</h2> 
<?php
if(isset($_POST['save'])){
	$nama_kota = addslashes($_POST['kota']);
	$id_provinsi = addslashes($_POST['provinsi']);
	$jenis = $_POST['jenis'];
	if(mysql_num_rows(mysql_query("SELECT * FROM t_kota WHERE id_provinsi = $id_provinsi AND nama_kota = '$nama_kota'")) == 0){
	mysql_query("INSERT INTO t_kota VALUES(null,$id_provinsi,'$nama_kota','$jenis')");
  echo "<div class=sukses>Kota $nama_kota Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=kota"
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
		echo "<div class=gagal>Kota Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['update'])){
	$id_kota = addslashes($_POST['id_kota']);
	$nama_kota = addslashes($_POST['kota']);
	$id_provinsi = addslashes($_POST['provinsi']);
	$jenis = $_POST['jenis'];
	if(mysql_num_rows(mysql_query("SELECT * FROM t_kota WHERE id_provinsi = $id_provinsi AND nama_kota = '$nama_kota' AND id_kota != $id_kota")) == 0){
	mysql_query("UPDATE t_kota SET id_provinsi = $id_provinsi, nama_kota = '$nama_kota', kabkota = '$jenis' WHERE id_kota = $id_kota");
  echo "<div class=sukses>Kota $nama_kota Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=kota"
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
		echo "<div class=gagal>Kota Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" id="registrationform">
        <table>
        	<tr>
            	<td><label for="provinsi">Nama Provinsi :</label></td>
            	<td>
                		<select size="1" name="provinsi" id="provinsi" class="inputan">
                        <?php
						$qprov = mysql_query("SELECT * FROM t_provinsi");
						while($dprov = mysql_fetch_array($qprov)){
						?>
                        	<option value="<?php echo $dprov['id_provinsi']; ?>"><?php echo $dprov['nama_provinsi']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="kota">Nama Kota :</label></td>
            	<td><input type="text" name="kota" id="kota" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="jenis">Jenis Kota :</label></td>
            	<td>
                		<select size="1" name="jenis" id="jenis" class="inputan">
                        	<option value="KOTA">KOTA</option>
                        	<option value="KABUPATEN">KABUPATEN</option>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=kota"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_kota = addslashes($_GET['idk']);
	$qkota = mysql_query("SELECT * FROM t_kota a, t_provinsi b
						 WHERE a.id_provinsi = b.id_provinsi
						 AND a.id_kota = '$id_kota'");
	$dkota = mysql_fetch_array($qkota);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="provinsi">Nama Provinsi :</label></td>
            	<td>
                		<select size="1" name="provinsi" id="provinsi" class="inputan">
                        <?php
						$qprov = mysql_query("SELECT * FROM t_provinsi");
						while($dprov = mysql_fetch_array($qprov)){
						?>
                        	<option value="<?php echo $dprov['id_provinsi']; ?>" <?php echo($dprov['id_provinsi'] == $dkota['id_provinsi'])?"selected":""; ?>><?php echo $dprov['nama_provinsi']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="kota">Nama Kota :</label></td>
            	<td><input type="text" name="kota" id="kota" size="49" maxlength="128" value="<?php echo $dkota['nama_kota']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="jenis">Jenis Kota :</label></td>
            	<td>
                		<select size="1" name="jenis" id="jenis" class="inputan">
                        	<option value="KOTA" <?php echo($dkota['kabkota'] == 'KOTA')?"selected":""; ?>>KOTA</option>
                        	<option value="KABUPATEN" <?php echo($dkota['kabkota'] == 'KABUPATEN')?"selected":""; ?>>KABUPATEN</option>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="hidden" name="id_kota" value="<?php echo $id_kota; ?>" />
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=kota"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
    <?php
	}
}
else{
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
	<table width="100%" style=" margin-top:10px;">
    <tr>
    <td align="right">
	<a href="?page=kota&act=add" class="button blue">
    <span class="label1">Tambah Kota</span></a>
    </td>
    <td align="right" width="70%">
    <form method="post" action="">
    	<input type="text" name="textcari" class="newsletter_input" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /></td><td>
        <button name="cari" class="action"/>
        <span class="icon icon198"></span></button>
    </form>
    </td></tr>
    </table>
    <?php
	if(isset($_POST['textcari'])){
		$sqlquery = "AND nama_kota LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         
<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Nama Provinsi</th>
            <th width="444" class="rounded" scope="col">Nama Kota</th>
            <th width="444" class="rounded" scope="col">Kabupaten / Kota</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qkota = mysql_query("SELECT * FROM t_kota a, t_provinsi b
							WHERE a.id_provinsi = b.id_provinsi
							$sqlquery
							LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dkota = mysql_fetch_array($qkota)){
			if ($i >= $kolom){
				echo "<tr class='row$dkota[id_kota]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dkota['nama_provinsi']; ?></td>
            <td><?php echo $dkota['nama_kota']; ?></td>
            <td><?php echo $dkota['kabkota']; ?></td>
            <td><a href="?page=kota&act=edit&idk=<?php echo $dkota['id_kota']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td>
            	<a href="<?php echo $dkota['id_kota']; ?>" id="kota" class="ask" title="Hapus">
                	<span class="icon icon186"></span></a></td>
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
	$tampil2 = mysql_query("SELECT * FROM t_kota a, t_provinsi as b
							WHERE a.id_provinsi = b.id_provinsi
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kota&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kota&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kota&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=kota&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kota&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	
	echo "</div>";
}
	?>
     
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