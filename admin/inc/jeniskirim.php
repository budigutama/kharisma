<script type="text/javascript" src="inc/textform.js"></script>
<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					forwarder : "required",
					jeniskirim : "required",
					jenis : "required"
				},
			
				messages: {
						forwarder: {
							required: '. forwarder harus di isi'
						},
						jeniskirim: {
							required: '. jeniskirim harus di isi'
						},
						jenis: {
							required: '. Jenis jeniskirim harus di isi'	
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data Jenis Pengiriman</h2> 
<?php
if(isset($_POST['save'])){
	$nama_jeniskirim = addslashes($_POST['jeniskirim']);
	$id_forwarder = addslashes($_POST['forwarder']);
	$deskripsi = $_POST['deskripsi'];
	if(mysql_num_rows(mysql_query("SELECT * FROM t_jeniskirim WHERE id_forwarder = $id_forwarder AND nama_jeniskirim = '$nama_jeniskirim'")) == 0){
	mysql_query("INSERT INTO t_jeniskirim VALUES(null,$id_forwarder,'$nama_jeniskirim', '$deskripsi')");
  echo "<div class=sukses>jeniskirim $nama_jeniskirim Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=jeniskirim"
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
		echo "<div class=gagal>jeniskirim Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['update'])){
	$id_jeniskirim = addslashes($_POST['id_jeniskirim']);
	$nama_jeniskirim = addslashes($_POST['jeniskirim']);
	$id_forwarder = addslashes($_POST['forwarder']);
	$deskripsi = $_POST['deskripsi'];
	if(mysql_num_rows(mysql_query("SELECT * FROM t_jeniskirim WHERE id_forwarder = $id_forwarder AND nama_jeniskirim = '$nama_jeniskirim' AND id_jeniskirim != $id_jeniskirim")) == 0){
	mysql_query("UPDATE t_jeniskirim SET id_forwarder = $id_forwarder, nama_jeniskirim = '$nama_jeniskirim', deskripsi_jeniskirim = '$deskripsi' WHERE id_jeniskirim = $id_jeniskirim");
  echo "<div class=sukses>jeniskirim $nama_jeniskirim Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=jeniskirim"
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
		echo "<div class=gagal>jeniskirim Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" id="registrationform">
        <table>
        	<tr>
            	<td><label for="forwarder">Nama forwarder :</label></td>
            	<td>
                		<select size="1" name="forwarder" id="forwarder" class="inputan">
                        <?php
						$qprov = mysql_query("SELECT * FROM t_forwarder");
						while($dprov = mysql_fetch_array($qprov)){
						?>
                        	<option value="<?php echo $dprov['id_forwarder']; ?>"><?php echo $dprov['nama_forwarder']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="jeniskirim">Nama jenis Pengiriman :</label></td>
            	<td><input type="text" name="jeniskirim" id="jeniskirim" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60" class="inputan"></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=jeniskirim"/><span class="label1">Batal</span></a>
				</td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_jeniskirim = addslashes($_GET['idk']);
	$qjeniskirim = mysql_query("SELECT * FROM t_jeniskirim a, t_forwarder b
						 WHERE a.id_forwarder = b.id_forwarder
						 AND a.id_jeniskirim = '$id_jeniskirim'");
	$djeniskirim = mysql_fetch_array($qjeniskirim);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="forwarder">Nama forwarder :</label></td>
            	<td>
                		<select size="1" name="forwarder" id="forwarder" class="inputan">
                        <?php
						$qprov = mysql_query("SELECT * FROM t_forwarder");
						while($dprov = mysql_fetch_array($qprov)){
						?>
                        	<option value="<?php echo $dprov['id_forwarder']; ?>" <?php echo($dprov['id_forwarder'] == $djeniskirim['id_forwarder'])?"selected":""; ?>><?php echo $dprov['nama_forwarder']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="jeniskirim">Nama Jenis Pengiriman :</label></td>
            	<td><input type="text" name="jeniskirim" id="jeniskirim" size="49" maxlength="128" value="<?php echo $djeniskirim['nama_jeniskirim']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"class="inputan">
				<?php echo $djeniskirim['deskripsi_jeniskirim']; ?></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="hidden" name="id_jeniskirim" value="<?php echo $id_jeniskirim; ?>" />
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=jeniskirim"/><span class="label1">Batal</span></a>
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
	<table width="100%" style=" margin-top:10px;">
    <tr>
    <td align="right">
	<a href="?page=jeniskirim&act=add" class="button blue">
    <span class="label1">Tambah Pengiriman</span></a>
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
		$sqlquery = "AND nama_jeniskirim LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         
<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="160" class="rounded" scope="col">Forwarder</th>
            <th width="200" class="rounded" scope="col">Jenis pengiriman</th>
            <th width="444" class="rounded" scope="col">deskripsi</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="32" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qjeniskirim = mysql_query("SELECT * FROM t_jeniskirim a, t_forwarder b
							WHERE a.id_forwarder = b.id_forwarder
							$sqlquery
							LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($djeniskirim = mysql_fetch_array($qjeniskirim)){
			if ($i >= $kolom){
				echo "<tr class='row$djeniskirim[id_jeniskirim]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $djeniskirim['nama_forwarder']; ?></td>
            <td><?php echo $djeniskirim['nama_jeniskirim']; ?></td>
            <td><?php echo $djeniskirim['deskripsi_jeniskirim']; ?></td>
            <td><a href="?page=jeniskirim&act=edit&idk=<?php echo $djeniskirim['id_jeniskirim']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td>
            	<a href="<?php echo $djeniskirim['id_jeniskirim']; ?>" id="jeniskirim" class="ask" title="Simpan">
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
	$tampil2 = mysql_query("SELECT * FROM t_jeniskirim a, t_forwarder as b
							WHERE a.id_forwarder = b.id_forwarder
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=jeniskirim&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=jeniskirim&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=jeniskirim&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=jeniskirim&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=jeniskirim&halaman=$next'>Next</a></span>";
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