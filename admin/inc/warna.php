<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					warna: "required",
				  	format: {
          	 			required: false,
						minlength: 3
          			}
				},
			
				messages: { 
						warna: {
							required: '. Warna harus di isi'
						},
						format: {
							minlength: '. Format minimal 3 karakter'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data warna</h2> 
<?php
if(isset($_POST['save'])){
	$qcek = mysql_query("SELECT * FROM t_warna WHERE nama_warna = '$_POST[warna]'");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("INSERT INTO t_warna VALUES(null,'$_POST[warna]','$_POST[format]')");
  echo "<div class=sukses>warna $_POST[warna] Berhasil Ditambah</div>"; 
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=warna"
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
		echo "<div class=gagal>warna Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_POST['update'])){
	$id_warna = $_POST['id_warna'];
	$qcek = mysql_query("SELECT * FROM t_warna WHERE nama_warna = '$_POST[warna]' AND id_warna != $id_warna");
	if(mysql_num_rows($qcek) == 0){
		mysql_query("UPDATE t_warna SET nama_warna = '$_POST[warna]', format_warna = '$_POST[format]' WHERE id_warna = $id_warna");
  echo "<div class=sukses>warna $_POST[warna] Berhasil Diupdate</div>"; 
		?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=warna"
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
		echo "<div class=gagal>warna Tidak Boleh Sama..!!</div>";	
	}
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" id="registrationform">
        <table>
        	<tr>
            	<td><label for="warna">Nama warna :</label></td>
            	<td><input type="text" name="warna" id="warna" size="49" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="format">Format warna :</label></td>
            	<td><input type="text" name="format" id="format" class="inputan"/></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                <input type="submit" name="save" value="Simpan" class="buton"/>
                <input type="reset" name="reset" value="Batal" onClick="window.location = '?page=warna';" class="buton"/></td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_warna = addslashes($_GET['idu']);
	$qwarna = mysql_query("SELECT * FROM t_warna WHERE id_warna = '$id_warna'");
	$dwarna = mysql_fetch_array($qwarna);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="warna">Nama warna :</label></td>
            	<td>
                <input type="hidden" name="id_warna" value="<?php echo $dwarna['id_warna']; ?>" />
                <input type="text" name="warna" id="warna" size="49" maxlength="128" value="<?php echo $dwarna['nama_warna']; ?>" class="inputan"/>
                </td>
            </tr>
        	<tr>
            	<td><label for="format">Format warna :</label></td>
            	<td><input  type="text" name="format" id="format" value="<?php echo $dwarna['format_warna']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                <input type="submit" name="update" value="Ubah" class="buton"/>
                <input type="reset" name="reset" value="Batal" onClick="window.location = '?page=warna';" class="buton"/></td>
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
	<a href="?page=warna&act=add" class="buton">Tambah Warna</a>
    </td>
    <td align="right" width="70%">
    <form method="post" action="">
    	<input type="text" name="textcari" class="newsletter_input" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /><input type="image" src="images/search.png" width="45" name="cari" style="margin-bottom:-14px;" title="Cari"/>
    </form>
    </td></tr>
    </table>
    <?php
	if(isset($_POST['textcari'])){
		$sqlquery = "AND nama_warna LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         
      
<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="444" class="rounded" scope="col">Nama warna</th>
            <th width="444" class="rounded" scope="col">Format</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qwarna = mysql_query("SELECT * FROM t_warna
								WHERE 1
								$sqlquery
								LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dwarna = mysql_fetch_array($qwarna)){
			if ($i >= $kolom){
				echo "<tr class='row$dwarna[id_warna]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dwarna['nama_warna']; ?></td>
            <td><?php echo $dwarna['format_warna']; ?></td>
            <td><a href="?page=warna&act=edit&idu=<?php echo $dwarna['id_warna']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
            <td width="45">
            	<a href="<?php echo $dwarna['id_warna']; ?>" id="warna" class="ask">
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
	$tampil2 = mysql_query("SELECT * FROM t_warna WHERE 1 $sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=warna&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=warna&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=warna&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=warna&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=warna&halaman=$next'>Next</a></span>";
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