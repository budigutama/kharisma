<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					provinsi : "required"
				},
			
				messages: {
						provinsi: {
							required: '. Provinsi harus di isi'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data Provinsi</h2> 
<?php
if(isset($_POST['save'])){
	$qcek = mysql_query("SELECT * FROM t_provinsi WHERE nama_provinsi = '$_POST[provinsi]'");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("INSERT INTO t_provinsi VALUES(null,'$_POST[provinsi]')");
  echo "<div class=sukses>Provinsi $_POST[provinsi] Berhasil Disimpan</div>"; 
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=provinsi"
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
		echo "<div class=gagal>Provinsi Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['update'])){
	$id_provinsi = $_POST['id_provinsi'];
	$qcek = mysql_query("SELECT * FROM t_provinsi WHERE nama_provinsi = '$_POST[provinsi]' AND id_provinsi != $id_provinsi");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("UPDATE t_provinsi SET nama_provinsi = '$_POST[provinsi]' WHERE id_provinsi = $id_provinsi");
  echo "<div class=sukses>Provinsi $_POST[provinsi] Berhasil Disimpan</div>"; 
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=provinsi"
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
		echo "<div class=gagal>Provinsi Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" id="registrationform">
        <table>
        	<tr>
            	<td><label for="provinsi">Nama Provinsi :</label></td>
            	<td><input type="text" name="provinsi" id="provinsi" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=provinsi"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_provinsi = addslashes($_GET['idp']);
	$qprov = mysql_query("SELECT * FROM t_provinsi WHERE id_provinsi = '$id_provinsi'");
	$dprov = mysql_fetch_array($qprov);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="provinsi">Nama Provinsi :</label></td>
            	<td>
                	<input type="hidden" name="id_provinsi" value="<?php echo $dprov['id_provinsi']; ?>" class="inputan"/>
                	<input type="text" name="provinsi" id="provinsi" size="49" maxlength="128" value="<?php echo $dprov['nama_provinsi']; ?>" />
                    </td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=provinsi"/><span class="label1">Batal</span></a>
                </td>
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
	<a href="?page=provinsi&act=add" class="button blue">
    <span class="label1">Tambah Provinsi</span></a>
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
		$sqlquery = "AND nama_provinsi LIKE '%$_POST[textcari]%'";
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
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qprovinsi = mysql_query("SELECT * FROM t_provinsi
								  WHERE 1
								  $sqlquery
								  LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dprovinsi = mysql_fetch_array($qprovinsi)){
			if ($i >= $kolom){
				echo "<tr class='row$dprovinsi[id_provinsi]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dprovinsi['nama_provinsi']; ?></td>
            <td><a href="?page=provinsi&act=edit&idp=<?php echo $dprovinsi['id_provinsi']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td width="45">
            	<a href="<?php echo $dprovinsi['id_provinsi']; ?>" id="provinsi" class="ask" title="Hapus">
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
	$tampil2 = mysql_query("SELECT * FROM t_provinsi
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=provinsi&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=provinsi&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=provinsi&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=provinsi&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=provinsi&halaman=$next'>Next</a></span>";
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