<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					kode: {
          	 			required: true,
					   	minlength: 2,
					   	maxlength: 5
          			},
					simbol: {
          	 			required: true,
					   	minlength: 1,
					   	maxlength: 3
          			},
					harga: {
          	 			required: true,
					   	number:true
          			}
				},
			
				messages: {
						kode: {
							required: '. Kode harus di isi',
							minlength: '. Kode minimal 2 Karakter',
							maxlength: '. Kode maksimal 5 Karakter'
						},
						simbol: {
							required: '. Simbol harus di isi',
							minlength: '. Simbol minimal 1 Karakter',
							maxlength: '. Simbol maksimal 3 Karakter'
						},
						harga: {
							required: '. Harga harus di isi',
							number: '. Harga harus berupa angka'
					}
				},
				 
				 success: function(label) {
					label.text('OK!').addClass('valid');
				}
			});
		});
</script>
<?php
if(isset($_POST['save'])){
	$qcek = mysql_query("SELECT * FROM kurs WHERE kode_kurs = '$_POST[kode]'");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("INSERT INTO kurs VALUES(null,'$_POST[kode]','$_POST[simbol]','$_POST[harga]','$_POST[deskripsi]','0')");
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		loading('Data Sedang Disimpan', 'Loading');  
		var targetURL="?page=kurs"
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

if(isset($_POST['update'])){
	$id_kurs = $_POST['id_kurs'];
	$qcek = mysql_query("SELECT * FROM kurs WHERE kode_kurs = '$_POST[kode]' AND id_kurs != $id_kurs");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("UPDATE kurs SET kode_kurs = '$_POST[kode]', symbol_kurs = '$_POST[simbol]', harga_kurs = '$_POST[harga]',
					 deskripsi_kurs = '$_POST[deskripsi]'
					 WHERE id_kurs = $id_kurs");
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		loading('Data Sedang Diupdate', 'Loading');  
		var targetURL="?page=kurs"
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pengolahan Data kurs</title>
</head>

<body>
<h2>Pengolahan Data kurs</h2> 

<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
        	<tr>
            	<td><label for="kode">Kode kurs :</label></td>
            	<td><input type="text" name="kode" id="kode" size="5" maxlength="5" /></td>
            </tr>
        	<tr>
            	<td><label for="simbol">Simbol :</label></td>
            	<td><input type="text" name="simbol" id="simbol" size="3" maxlength="2" /></td>
            </tr>
        	<tr>
            	<td><label for="harga">Harga :</label></td>
            	<td><input type="text" name="harga" id="harga" size="10" maxlength="10" /></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="submit" name="save" value="Simpan" /><input type="reset" name="reset" value="Batal" onClick="window.location = '?page=kurs';" /></td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_kurs = addslashes($_GET['idk']);
	$qkurs = mysql_query("SELECT * FROM kurs WHERE id_kurs = '$id_kurs'");
	$dkurs = mysql_fetch_array($qkurs);
	?>
    <form action="" method="post" class="niceform" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="kode">Kode kurs :</label></td>
            	<td>
                	<input type="hidden" name="id_kurs" value="<?php echo $dkurs['id_kurs']; ?>" />
                	<input type="text" name="kode" id="kode" size="5" maxlength="5" value="<?php echo $dkurs['kode_kurs']; ?>" />
                </td>
            </tr>
        	<tr>
            	<td><label for="simbol">Simbol :</label></td>
            	<td><input type="text" name="simbol" id="simbol" size="3" maxlength="2" value="<?php echo $dkurs['symbol_kurs']; ?>" /></td>
            </tr>
        	<tr>
            	<td><label for="harga">Harga :</label></td>
            	<td><input type="text" name="harga" id="harga" size="10" maxlength="10" value="<?php echo $dkurs['harga_kurs']; ?>" /></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"><?php echo $dkurs['deskripsi_kurs']; ?></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center"><input type="submit" name="update" value="Ubah" /><input type="reset" name="reset" value="Batal" onClick="window.location = '?page=kurs';" /></td>
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
    Cari Berdasarkan :
    <form method="post" action="">
    	<select name="type">
        	<option value="0">Semua</option>
        	<option value="1" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 1)?"selected":""; } ?>>Kode</option>
            <option value="2" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 2)?"selected":""; } ?>>Simbol</option>
        </select>
    	<input type="text" name="textcari" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /><input type="submit" name="cari" value="Cari" />
    </form>
    <?php
	if(isset($_POST['type'])){
		$type = addslashes($_POST['type']);
		if($type == 0)
			$sqlquery = "";
		elseif($type == 1)
			$sqlquery = "AND kode_kurs LIKE '%$_POST[textcari]%'";
		elseif($type == 2)
			$sqlquery = "AND symbol_kurs LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         
              
<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Kode</th>
            <th width="444" class="rounded" scope="col">Simbol</th>
            <th width="444" class="rounded" scope="col">Harga</th>
            <th width="444" class="rounded" scope="col">Deskripsi</th>
            <th width="32" class="rounded" scope="col">Status</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qkurs = mysql_query("SELECT * FROM kurs
								  WHERE 1
								  $sqlquery
								  LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dkurs = mysql_fetch_array($qkurs)){
			if ($i >= $kolom){
				echo "<tr class='row$dkurs[id_kurs]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dkurs['kode_kurs']; ?></td>
            <td><?php echo $dkurs['symbol_kurs']; ?></td>
            <td><?php echo $dkurs['harga_kurs']; ?></td>
            <td><?php echo $dkurs['deskripsi_kurs']; ?></td>
            <td>
                <a href="<?php echo $dkurs['id_kurs']; ?>" id="publish-kurs" class="ask">
                	<?php
					if($dkurs['status_kurs'] == 1){
                    	echo "<img src='images/publish_t.png' border='0' alt='aktif' title='aktif' />";
					}
					elseif($dkurs['status_kurs'] == 0){
                    	echo "<img src='images/publish_y.png' border='0' alt='non aktif' title='non aktif' />";
					}
					?>
                </a>
            </td>
            <td><a href="?page=kurs&act=edit&idk=<?php echo $dkurs['id_kurs']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
            <td width="45">
            	<a href="<?php echo $dkurs['id_kurs']; ?>" id="kurs" class="ask">
                	<img src="images/trash.png" alt="" title="" border="0" />
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
	<a href="?page=kurs&act=add" class="bt_green"><span class="bt_green_lft"></span><strong>Tambah kurs</strong><span class="bt_green_r"></span></a>
	<div class="pagination">
	<?php
	$tampil2 = mysql_query("SELECT * FROM kurs
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kurs&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kurs&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=kurs&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=kurs&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=kurs&halaman=$next'>Next</a></span>";
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