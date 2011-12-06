<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					kategori : "required",
					kode: {
          	 			required: true,
					   	minlength: 2,
					   	maxlength: 5
          			}
				},
			
				messages: {
						kategori: {
							required: '. Nama harus di isi',
						},
						kode: {
							required: '. Kode harus di isi',
							minlength: '. Kode minimal 2 Karakter',
							maxlength: '. Kode maksimal 5 Karakter'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<script type="text/javascript" src="inc/textform.js"></script>
<h2>Pengolahan Data Kategori</h2> 

<?php
if(isset($_POST['save'])){
  $nama_kategori=$_POST['kategori'];
  $kode_kategori=$_POST['kode'];
  $deskripsi_kategori=$_POST['deskripsi'];
  if(mysql_num_rows(mysql_query("SELECT * FROM t_kategori WHERE nama_kategori = '$nama_kategori' OR kode_kategori = '$kode_kategori'")) == '0'){
  		mysql_query("INSERT INTO t_kategori
					 VALUES(null,'$kode_kategori','$nama_kategori','$deskripsi_kategori')");
  echo "<div class=sukses>Kategori $nama_kategori Berhasil Disimpan</div>"; 
    	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=kategori"
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
		echo "<div class=gagal>Kategori Tidak Boleh Sama..!!</div>";	
  }
}

if(isset($_POST['update'])){
	  $id_kategori=$_POST['id_kategori'];
	  $nama_kategori=$_POST['kategori'];
	  $kode_kategori=$_POST['kode'];
	  $deskripsi_kategori=$_POST['deskripsi'];
  	  if(mysql_num_rows(mysql_query("SELECT * FROM t_kategori WHERE nama_kategori = '$nama_kategori' AND id_kategori != $id_kategori")) == '0'){
			mysql_query("UPDATE t_kategori
						 SET nama_kategori = '$nama_kategori', kode_kategori = '$kode_kategori', deskripsi_kategori = '$deskripsi_kategori'
						 WHERE id_kategori = '$id_kategori'");
  echo "<div class=sukses>Kategori $nama_kategori Berhasil Diupdate</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=kategori"
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
		echo "<div class=gagal>Kategori Tidak Boleh Sama..!!</div>";	
    }
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
        	<tr>
            	<td><label for="kategori">Nama Kategori :</label></td>
            	<td><input type="text" name="kategori" id="kategori" size="25" maxlength="128" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="kode">Kode :</label></td>
                <td>
                	<input type="text" name="kode" id="kode" size="5" maxlength="5" class="inputan"/>
                </td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60" class="inputan"></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=kategori"/><span class="label1">Batal</span></a>
            </tr>
        </table>
	</form>
     <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_kategori = addslashes($_GET['idk']);
	$qkategori = mysql_query("SELECT * FROM t_kategori
							  WHERE id_kategori = '$id_kategori'");
	$dkategori = mysql_fetch_array($qkategori);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="kategori">Nama Kategori :</label></td>
            	<td><input type="text" name="kategori" id="kategori" size="25" maxlength="128" value="<?php echo $dkategori['nama_kategori']; ?>" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="kode">Kode :</label></td>
                <td colspan="2">
                	<input type="text" name="kode" id="kode" size="20" maxlength="15" value="<?php echo $dkategori['kode_kategori']; ?>" class="inputan"/>
                </td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"class="inputan">
				<?php echo $dkategori['deskripsi_kategori']; ?></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<input type="hidden" name="id_kategori" value="<?php echo $_GET['idk']; ?>" />
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=kategori"/><span class="label1">Batal</span></a>
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
	<a href="?page=kategori&act=add" class="button blue">
    <span class="label1">Tambah Kategori</span></a>
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
		$sqlquery = "AND nama_kategori LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         

<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Nama Kategori</th>
            <th width="100" class="rounded" scope="col">Kode</th>
            <th width="444" class="rounded" scope="col">Deskripsi</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qkategori = mysql_query("SELECT * FROM t_kategori WHERE 1
								 $sqlquery
								 LIMIT $posisi,$batas");
		$kolom=1;
		$i=1;
		$no = $posisi+1;
		while($dkategori = mysql_fetch_array($qkategori)){
			if ($i >= $kolom){
				echo "<tr class='row$dkategori[id_kategori]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dkategori['nama_kategori']; ?></td>
            <td><?php echo $dkategori['kode_kategori']; ?></td>
            <td><?php echo $dkategori['deskripsi_kategori']; ?></td>
            <td><a href="?page=kategori&act=edit&idk=<?php echo $dkategori['id_kategori']; ?>" title="Ubah">
            <span class="icon icon145"></span>
            </a></td>
            <td width="45">
            	<a href="<?php echo $dkategori['id_kategori']; ?>" id="kategori" class="ask" title="Hapus">
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
	$tampil2 = mysql_query("SELECT * FROM t_kategori
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kategori&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kategori&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kategori&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=kategori&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kategori&halaman=$next'>Next</a></span>";
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