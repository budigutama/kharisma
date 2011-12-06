<script type="text/javascript" src="inc/textform.js"></script>
<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					forwarder : "required",
					kode: {
          	 			required: true,
					   	minlength: 2,
					   	maxlength: 5
          			}
				},
			
				messages: {
						forwarder: {
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
<h2>Pengolahan Data Forwarder</h2> 

<?php
if(isset($_POST['save'])){
  $nama_forwarder=$_POST['forwarder'];
  $deskripsi_forwarder=$_POST['deskripsi'];
  if(mysql_num_rows(mysql_query("SELECT * FROM t_forwarder WHERE nama_forwarder = '$nama_forwarder'")) == '0'){
  		mysql_query("INSERT INTO t_forwarder
					 VALUES(null,'$nama_forwarder','$deskripsi_forwarder')");
  echo "<div class=sukses>forwarder $nama_forwarder Berhasil Disimpan</div>"; 
    	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=forwarder"
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
		echo "<div class=gagal>forwarder Tidak Boleh Sama..!!</div>";	
  }
}

if(isset($_POST['update'])){
	  $id_forwarder=$_POST['id_forwarder'];
	  $nama_forwarder=$_POST['forwarder'];
	  $deskripsi_forwarder=$_POST['deskripsi'];
  	  if(mysql_num_rows(mysql_query("SELECT * FROM t_forwarder WHERE nama_forwarder = '$nama_forwarder' AND id_forwarder != $id_forwarder")) == '0'){
			mysql_query("UPDATE t_forwarder
						 SET nama_forwarder = '$nama_forwarder', deskripsi_forwarder = '$deskripsi_forwarder' WHERE id_forwarder = '$id_forwarder'");
  echo "<div class=sukses>forwarder $nama_forwarder Berhasil Diupdate</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=forwarder"
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
		echo "<div class=gagal>forwarder Tidak Boleh Sama..!!</div>";	
    }
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'add'){
	?>
    <form action="" method="post" class="niceform" id="registrationform">
        <table>
        	<tr>
            	<td><label for="forwarder">Nama forwarder :</label></td>
            	<td><input type="text" name="forwarder" id="forwarder" size="25" maxlength="128" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60" class="inputan"></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=forwarder"/><span class="label1">Batal</span></a>
                </td>
            </tr>
        </table>
	</form>
     <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_forwarder = addslashes($_GET['idk']);
	$qforwarder = mysql_query("SELECT * FROM t_forwarder
							  WHERE id_forwarder = '$id_forwarder'");
	$dforwarder = mysql_fetch_array($qforwarder);
	?>
    <form action="" method="post" onSubmit="return conf();" id="registrationform">
        <table>
        	<tr>
            	<td><label for="forwarder">Nama forwarder :</label></td>
            	<td><input type="text" name="forwarder" id="forwarder" size="25" maxlength="128" value="<?php echo $dforwarder['nama_forwarder']; ?>" class="inputan"/></td>
            </tr>
        	<tr>
            	<td><label for="deskripsi">Deskripsi :</label></td>
            	<td><textarea name="deskripsi" id="deskripsi" rows="5" cols="60"class="inputan">
				<?php echo $dforwarder['deskripsi_forwarder']; ?></textarea></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<input type="hidden" name="id_forwarder" value="<?php echo $_GET['idk']; ?>" />
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=forwarder"/><span class="label1">Batal</span></a>
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
	<a href="?page=forwarder&act=add" class="button blue">
    <span class="label1">Tambah Forwarder</span></a>
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
		$sqlquery = "AND nama_forwarder LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
?>         

<table width="592" id="rounded-corner">
    <thead>
    	<tr>
        	<th width="51" class="rounded-company" scope="col">No</th>
            <th width="170" class="rounded" scope="col">Nama Forwarder</th>
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
		$qforwarder = mysql_query("SELECT * FROM t_forwarder WHERE 1
								 $sqlquery
								 LIMIT $posisi,$batas");
		$kolom=1;
		$i=1;
		$no = $posisi+1;
		while($dforwarder = mysql_fetch_array($qforwarder)){
			if ($i >= $kolom){
				echo "<tr class='row$dforwarder[id_forwarder]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dforwarder['nama_forwarder']; ?></td>
            <td><?php echo $dforwarder['deskripsi_forwarder']; ?></td>
            <td><a href="?page=forwarder&act=edit&idk=<?php echo $dforwarder['id_forwarder']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td width="45">
            	<a href="<?php echo $dforwarder['id_forwarder']; ?>" id="forwarder" class="ask" title="Hapus">
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
	$tampil2 = mysql_query("SELECT * FROM t_forwarder
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=forwarder&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=forwarder&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=forwarder&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=forwarder&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=forwarder&halaman=$next'>Next</a></span>";
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