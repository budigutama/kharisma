<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "balasan",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,style,table,print,paste,directionality,fullscreen,nonbreaking,xhtmlxtras,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect",
		theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,cleanup,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,print,|,ltr,rtl,|,fullscreen",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "tiny_mce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	});

</script>
<!-- /TinyMCE -->

<?php
if(isset($_POST['kirim'])){
	$email=$_POST['email'];
	$subjek=$_POST['subjek'];
	$isi=$_POST['balasan'];
	$kepada = "$email";
	$judul  = "[ tridi.com ] $subjek";
	$pesan  = "$isi<br />
			   Terima kasih.<br />
			   ---<br />
			   tridi pilar pratama<br />
			   Store: Graha Mustika Ratu 7th Floor Jl. Gatot Subroto Kav. 74-75 Jakarta 12870<br />
			   Email: admin@tridi.com<br />
			   ---";
					
	$dari   = "From: admin@tridi.com \r\n";
	$dari  .= "Reply-To: admin@tridi.com \r\n";
	$dari  .= "Content-type: text/html \r\n";
	mail($kepada,$judul,$pesan,$dari);		?>
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
	  mysql_query("UPDATE buku_tamu SET status='1' WHERE id_tamu='$idb'");
      $ambildata=mysql_query("SELECT * FROM buku_tamu WHERE id_tamu='$idb'");
	  $data=mysql_fetch_array($ambildata);	
	?>
    <form action="" method="post" class="niceform">
        <table>
            <tr>
                <td><label for="nama">Nama :</label></td>
                <td><input type="text" name="nama" id="nama" size="40" maxlength="100" value="<?php echo $data['nama'];?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="email">Email :</label></td>
                <td><input type="text" name="email" id="email" size="40" maxlength="100" readonly value="<?php echo $data['email'];?>"/></td>
            </tr>
            <tr>
                <td><label for="telp">Tanggal:</label></td>
                <td><input type="text" name="tgl" id="tgl" size="20" maxlength="15" readonly value="<?php echo tgl_indo($data['tgl_input']);?>"/></td>
            </tr>
            <tr>
                <td><label for="alamat">Isi Komentar :</label></td>
                <td><textarea name="isi" id="isi" rows="10" cols="60" readonly><?php echo $data['komentar'];?></textarea></td>
            </tr>
                <td colspan="2" align="center"><a href="?page=bukutamu&act=reply&idb=<?php echo $idb;?>"><input type="button" name="balas" value="Reply" /></a></td>
            </tr>
        </table>
	</form>
	<?php
	}
	elseif($_GET['act'] == 'reply'){
	  $idb=$_GET['idb'];
      $ambildata=mysql_query("SELECT * FROM buku_tamu WHERE id_tamu='$idb'");
	  $data=mysql_fetch_array($ambildata);	
	?>
    <form action="" method="post" class="niceform">
        <table>
            <tr>
                <td><label for="nama">Kepada :</label></td>
                <td><input type="text" name="email" id="email" size="40" maxlength="100" value="<?php echo $data['email'];?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="email">Subjek :</label></td>
                <td><input type="text" name="subjek" id="subjek" size="40" maxlength="100"</td>
            </tr>
            <tr>
                <td><label for="alamat">Isi Balasan :</label></td>
                <td><textarea name="balasan" id="balasan" rows="8" cols="60"></textarea></td>
            </tr>
                <td colspan="2" align="center"><input type="submit" name="kirim" value="Send" /></td>
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
        	<option value="1" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 1)?"selected":""; } ?>>Nama</option>
            <option value="2" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 2)?"selected":""; } ?>>Tanggal</option>
        </select>
    	<input type="text" name="textcari" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Keyword..."; }?>" onBlur="if(this.value=='') this.value='Keyword...';" onFocus="if(this.value=='Keyword...') this.value='';" /><input type="submit" name="cari" value="Cari" />
    </form>
    <?php
	if(isset($_POST['type'])){
		$type = addslashes($_POST['type']);
		if($type == 0)
			$sqlquery = "";
		elseif($type == 1)
			$sqlquery = "AND nama LIKE '%$_POST[textcari]%'";
		elseif($type == 2)
			$sqlquery = "AND tgl_input LIKE '%$_POST[textcari]%'";
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
				<th width="45" class="rounded" scope="col" align="center">View</th>
				<th width="45" class="rounded-q4" scope="col" align="center">Delete</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php
			$no = 0;
			$qbukutamu = mysql_query("SELECT * FROM buku_tamu
									WHERE 1
									$sqlquery LIMIT $posisi,$batas");
			$kolom=1;
			$i=0;
			$no = $posisi+1;
			while($dbukutamu = mysql_fetch_array($qbukutamu)){
				if ($i >= $kolom){
					echo "<tr class='row$dbukutamu[id_tamu]'>";
				}
			?>
				<td><?php echo $no; ?></td>
				<td><?php echo $dbukutamu['nama']; ?></td>
				<td><?php echo $dbukutamu['email']; ?></td>
				<td align="center"><?php echo tgl_indo($dbukutamu['tgl_input']); ?></td>
                <td align="center">
					<?php
					if($dbukutamu['status'] == 1){
                    	echo "<img src='images/y.png' border='0' alt='Sudah Dibaca' title='Sudah Dibaca' />";
					}
					elseif($dbukutamu['status'] == 0){
                    	echo "<img src='images/n.png' border='0' alt='Belum Dibaca' title='Belum Dibaca' />";
					}
					?>
				<td align="center"><a href="?page=bukutamu&act=view&idb=<?php echo $dbukutamu['id_tamu']; ?>" title="View">
                    	<img src="images/view.png" alt="" title="" border="0" />
                    </a></td>
				<td width="45" align="center">
					<a href="<?php echo $dbukutamu['id_tamu']; ?>" id="buku_tamu" class="ask" title="Delete"> 
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
	$tampil2 = mysql_query("SELECT * FROM buku_tamu
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
     
     <h2>&nbsp;</h2>
</body>
</html>