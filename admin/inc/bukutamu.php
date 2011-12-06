<script type="text/javascript" src="inc/textform.js"></script>

<?php
if(isset($_POST['kirim'])){
	$email=$_POST['email'];
	$nama=$_POST['nama'];
	$isi=$_POST['balasan'];
	email_bukutamu($email,$nama,$isi);		
  echo "<div class=sukses>Balasan Buku tamu ke $nama - $email Berhasil Dikirim</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=bukutamu"
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
?>
<body>
<h2>Pengolahan Buku Tamu</h2> 
                  
<?php
if(isset($_GET['act'])){
	if($_GET['act'] == 'view'){
	  $idb=$_GET['idb'];
	  mysql_query("UPDATE t_bukutamu SET status_bukutamu='1' WHERE id_bukutamu='$idb'");
      $ambildata=mysql_query("SELECT * FROM t_bukutamu WHERE id_bukutamu=$idb");
	  $data=mysql_fetch_array($ambildata);	
	?>
    <form action="" method="post" class="niceform">
        <table>
            <tr>
                <td><label for="nama">Nama :</label></td>
                <td><input type="text" name="nama" id="nama" size="40" maxlength="100" value="<?php echo $data['nama_bukutamu'];?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="email">Email :</label></td>
                <td><input type="text" name="email" id="email" size="40" maxlength="100" readonly value="<?php echo $data['email_bukutamu'];?>"/></td>
            </tr>
            <tr>
                <td><label for="telp">Tanggal:</label></td>
                <td><input type="text" name="tgl" id="tgl" size="20" maxlength="15" readonly value="<?php echo tgl_indo($data['tanggal_bukutamu']);?>"/></td>
            </tr>
            <tr>
                <td><label for="alamat">Isi Komentar :</label></td>
                <td><textarea name="isi" id="deskripsi" rows="10" cols="60" readonly><?php echo $data['isi_bukutamu'];?></textarea></td>
            </tr>
                <td colspan="2" align="center">
                <a href="?page=bukutamu&act=reply&idb=<?php echo $idb;?>" class="button blue">
                <span class="label1">Balas</span></a>
                <a class="button red" href="?page=bukutamu"/><span class="label1">Batal</span></a></td>
            </tr>
        </table>
	</form>
	<?php
	}
	elseif($_GET['act'] == 'reply'){
	  $idb=$_GET['idb'];
      $ambildata=mysql_query("SELECT * FROM t_bukutamu WHERE id_bukutamu='$idb'");
	  $data=mysql_fetch_array($ambildata);	
	?>
    <form action="" method="post">
        <table>
            <tr>
                <td><label for="nama">Kepada :</label></td>
                <td><input type="text" name="email" value="<?php echo $data['email_bukutamu'];?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="email">Nama  :</label></td>
                <td><input type="text" name="nama" value="<?php echo $data['nama_bukutamu'];?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="alamat">Isi Balasan :</label></td>
                <td><textarea name="balasan" id="deskripsi" rows="8" cols="60"></textarea></td>
            </tr>
                <td colspan="2" align="center">
                	<button name="kirim" class="blue"/><span class="label1">Kirim</span></button>
                    <a class="button red" href="?page=bukutamu"/><span class="label1">Batal</span></a>
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
<form method="post" action="">
<tr>
<td align="right" width="50%">
</td>
<td align="right">
    	<select name="type">
        	<option value="0">Semua</option>
        	<option value="1" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 1)?"selected":""; } ?>>Nama</option>
            <option value="2" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 2)?"selected":""; } ?>>Tanggal</option>
        </select>
    	<input type="text" name="textcari" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Keyword..."; }?>" onBlur="if(this.value=='') this.value='Keyword...';" onFocus="if(this.value=='Keyword...') this.value='';" />
        </td><td>
        <button name="cari" class="action"/>
        <span class="icon icon198"></span></button>
</td></tr>
</form>
</table>
    <?php
	if(isset($_POST['type'])){
		$type = addslashes($_POST['type']);
		if($type == 0)
			$sqlquery = "";
		elseif($type == 1)
			$sqlquery = "AND nama_bukutamu LIKE '%$_POST[textcari]%'";
		elseif($type == 2)
			$sqlquery = "AND tanggal_bukutamu LIKE '%$_POST[textcari]%'";
	}
	else{
		$sqlquery = "";	
	}
	?>
	<table width="592" id="rounded-corner">
		<thead>
			<tr>
				<th width="51" class="rounded-company" scope="col">No</th>
				<th width="444" class="rounded" scope="col">Nama</th>
				<th width="444" class="rounded" scope="col">Email</th>
				<th width="444" class="rounded" scope="col" align="center">Tanggal</th>
                <th width="45" class="rounded" scope="col" align="center">Status</th>
				<th width="45" class="rounded" scope="col" align="center">Lihat</th>
				<th width="45" class="rounded-q4" scope="col" align="center">Hapus</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php
			$no = 0;
			$qbukutamu = mysql_query("SELECT * FROM t_bukutamu
									WHERE 1
									$sqlquery LIMIT $posisi,$batas");
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($dbukutamu = mysql_fetch_array($qbukutamu)){
				if ($i >= $kolom){
					echo "<tr class='row$dbukutamu[id_bukutamu]'>";
				}
			?>
				<td><?php echo $no; ?></td>
				<td><?php echo $dbukutamu['nama_bukutamu']; ?></td>
				<td><?php echo $dbukutamu['email_bukutamu']; ?></td>
				<td align="center"><?php echo tgl_indo($dbukutamu['tanggal_bukutamu']); ?></td>
                <td align="center">
					<?php
					if($dbukutamu['status_bukutamu'] == 1){ ?>
                    	<a title="Sudah Dibaca"><span class="icon icon44"></span></a>
					<?php }
					elseif($dbukutamu['status_bukutamu'] == 0){
                    	echo "<a title='Belum Doibaca'><span class='icon icon35'></span></a>";
					}
					?>
				<td align="center"><a href="?page=bukutamu&act=view&idb=<?php echo $dbukutamu['id_bukutamu']; ?>" title="Lihat">
                    	<span class="icon icon84"></span></a>
                   </td>
				<td width="45" align="center">
					<a href="<?php echo $dbukutamu['id_bukutamu']; ?>" id="buku_tamu" class="ask" title="Hapus"> 
						<span class="icon icon186"></span></a>
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
	$tampil2 = mysql_query("SELECT * FROM t_bukutamu
							WHERE 1
							$sqlquery");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
			
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=bukutamu&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=bukutamu&halaman=$i'>$i</a> ";
	}
		
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	 if ($i > $jmlhal) 
		  break;
  	$angka .= "<a href='$_SERVER[PHP_SELF]?page=bukutamu&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
  	<a href='$_SERVER[PHP_SELF]?page=bukutamu&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";
	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=bukutamu&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
		
	echo "</div>";
} //end of else or !isset($_GET['act'])
	?>
     
</body>
</html>