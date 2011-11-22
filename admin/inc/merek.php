<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					merek : "required",
					kode: {
          	 			required: true,
					   	minlength: 2,
					   	maxlength: 5
          			}
				},
			
				messages: {
						merek: {
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
<h2>Pengolahan Data merek</h2> 

<?php
if(isset($_POST['save'])){
  $nama_merek=$_POST['merek'];
  $kode_merek=$_POST['kode'];
  $deskripsi_merek=$_POST['deskripsi'];
  if(mysql_num_rows(mysql_query("SELECT * FROM t_merek WHERE nama_merek = '$nama_merek' OR kode_merek = '$kode_merek'")) == '0'){
  		mysql_query("INSERT INTO t_merek
					 VALUES(null,'$kode_merek','$nama_merek','$deskripsi_merek')");
  echo "<div class=sukses>merek $nama_merek Berhasil Disimpan</div>"; 
    	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=merek"
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
		echo "<div class=gagal>merek Tidak Boleh Sama..!!</div>";	
  }
}

if(isset($_POST['update'])){
	  $id_merek=$_POST['id_merek'];
	  $nama_merek=$_POST['merek'];
	  $kode_merek=$_POST['kode'];
	  $deskripsi_merek=$_POST['deskripsi'];
  	  if(mysql_num_rows(mysql_query("SELECT * FROM t_merek WHERE nama_merek = '$nama_merek' AND id_merek != $id_merek")) == '0'){
			mysql_query("UPDATE t_merek
						 SET nama_merek = '$nama_merek', kode_merek = '$kode_merek', deskripsi_merek = '$deskripsi_merek'
						 WHERE id_merek = '$id_merek'");
  echo "<div class=sukses>merek $nama_merek Berhasil Diupdate</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=merek"
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
		echo "<div class=gagal>merek Tidak Boleh Sama..!!</div>";	
    }
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
        	<tr>
            	<td><label for="merek">Nama merek :</label></td>
            	<td><input type="text" name="merek" id="merek" size="25" maxlength="128" class="inputan"/></td>
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
                <input type="submit" name="save" value="Simpan" class="buton"/>
                <input type="reset" name="reset" value="Batal" onClick="window.location = '?page=merek';" class="buton"/></td>
            </tr>
        </table>
	</form>
     <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_merek = addslashes($_GET['idk']);
	$qmerek = mysql_query("SELECT * FROM t_merek
							  WHERE id_merek = '$id_merek'");
	$dmerek = mysql_fetch_array($qmerek);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="merek">Nama merek :</label></td>
            	<td><input type="text" name="merek" id="merek" size="25" maxlength="128" value="<?php echo $dmerek['nama_merek']; ?>" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="kode">Kode :</label></td>
                <td colspan="2">
                	<input type="text" name="kode" id="kode" size="20" maxlength="15" value="<?php echo $dmerek['kode_merek']; ?>" class="inputan"/>
                </td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"class="inputan">
				<?php echo $dmerek['deskripsi_merek']; ?></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<input type="hidden" name="id_merek" value="<?php echo $_GET['idk']; ?>" />
                	<input type="submit" name="update" value="Ubah" class="buton"/>
                    <input type="reset" name="reset" value="Batal" onClick="window.location = '?page=merek';" class="buton"/>
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
	<a href="?page=merek&act=add" class="buton">Tambah merek</a>
    </td>
    <td align="right" width="70%">
    <form method="post" action="">
    	<input type="text" name="textcari" class="newsletter_input" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /><input type="image" src="images/search.png" width="45" name="cari" style="margin-bottom:-14px;" title="Cari"/>
    </form>
    </td></tr>
    </table>
    <?php
	if(isset($_POST['textcari'])){
		$sqlquery = "AND nama_merek LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         

<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Nama merek</th>
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
		$qmerek = mysql_query("SELECT * FROM t_merek WHERE 1
								 $sqlquery
								 LIMIT $posisi,$batas");
		$kolom=1;
		$i=1;
		$no = $posisi+1;
		while($dmerek = mysql_fetch_array($qmerek)){
			if ($i >= $kolom){
				echo "<tr class='row$dmerek[id_merek]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dmerek['nama_merek']; ?></td>
            <td><?php echo $dmerek['kode_merek']; ?></td>
            <td><?php echo $dmerek['deskripsi_merek']; ?></td>
            <td><a href="?page=merek&act=edit&idk=<?php echo $dmerek['id_merek']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
            <td width="45">
            	<a href="<?php echo $dmerek['id_merek']; ?>" id="merek" class="ask">
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

	<div class="pagination">
	<?php
	$tampil2 = mysql_query("SELECT * FROM t_merek
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=merek&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=merek&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=merek&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=merek&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=merek&halaman=$next'>Next</a></span>";
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