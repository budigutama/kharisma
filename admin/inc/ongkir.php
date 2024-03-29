<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#registrationform").validate({
				rules: {
					provinsi : "required",
					kota : "required",
					jeniskirim : "required",
					kota : "required",		
				  	harga: {
          	 			required: true,
					   	number: true
          			}
				},
			
				messages: {
						provinsi: {
							required: '. Provinsi harus di isi'
						},
						kota: {
							required: '. Kota harus di isi'
						},
						jeniskirim: {
							required: '. Jenis Pengiriman harus di isi'
						},
					  	harga: {
							required: '. Harga harus di isi',
							number  : '. Hanya boleh di isi Angka'
						}
				},
				 
				 success: function(label) {
					label.text('.').addClass('valid');
				}
			});
		});
</script>
<h2>Pengolahan Data Ongkos Kirim</h2> 
<?php
if(isset($_POST['save'])){
	if(mysql_num_rows(mysql_query("SELECT * FROM t_ongkir WHERE id_kota = '$_POST[kota]' AND id_jeniskirim = $_POST[jeniskirim]")) == 0){
	mysql_query("INSERT INTO t_ongkir VALUES(null,$_POST[kota],$_POST[jeniskirim],$_POST[harga])");
  echo "<div class=sukses>Ongkos Kirim Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=ongkir"
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
		echo "<div class=gagal>Ongkos Kirim Tidak Boleh Sama..!!</div>";	
	  }
}

if(isset($_POST['update'])){
	$id_ongkir = $_POST['id_ongkir'];
	if(mysql_num_rows(mysql_query("SELECT * FROM t_ongkir WHERE id_kota = '$_POST[kota]' AND id_jeniskirim = $_POST[jeniskirim] AND id_ongkir != $id_ongkir")) == 0){
	mysql_query("UPDATE t_ongkir SET id_kota = $_POST[kota], id_jeniskirim = $_POST[jeniskirim], harga_ongkir = $_POST[harga] WHERE id_ongkir = $id_ongkir");
  echo "<div class=sukses>Ongkos Kirim Berhasil Disimpan</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=ongkir"
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
		echo "<div class=gagal>Ongkos Kirim Tidak Boleh Sama..!!</div>";	
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
                        	<option value="">-- Pilih Provinsi --</option>
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
            	<td>
                		<select size="1" name="kota" id="kota" class="inputan">
                        	<option value="">-- Pilih Kota --</option>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="jeniskirim">Jenis :</label></td>
            	<td>
                		<select size="1" name="jeniskirim" id="jeniskirim" class="inputan">
                        <?php
						$qjp = mysql_query("SELECT * FROM t_jeniskirim a, t_forwarder b 
										   WHERE a.id_forwarder=b.id_forwarder");
						while($djp = mysql_fetch_array($qjp)){
						?>
                        	<option value="<?php echo $djp['id_jeniskirim']; ?>">
							<?php echo $djp['nama_forwarder'].' - '.$djp['nama_jeniskirim']; ?>
                            </option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="harga">Harga Ongkos Kirim :</label></td>
            	<td><input type="text" name="harga" id="harga" size="10" maxlength="10" class="inputan"/></td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="save" class="blue"/><span class="label1">Simpan</span></button>
                    <a class="button red" href="?page=ongkir"/><span class="label1">Batal</span></a>
				</td>
            </tr>
        </table>
	</form>
    <?php
	}
	elseif($_GET['act'] == 'edit'){
	$id_ongkir = addslashes($_GET['idok']);
	$qongkir = mysql_query("SELECT * FROM t_ongkir a, t_kota b, t_provinsi c
						   WHERE a.id_kota = b.id_kota
						   AND b.id_provinsi = c.id_provinsi
						   AND a.id_ongkir = '$id_ongkir'");
	$dongkir = mysql_fetch_array($qongkir);
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
                        	<option value="<?php echo $dprov['id_provinsi']; ?>" <?php echo($dprov['id_provinsi'] == $dongkir['id_provinsi'])?"selected":""; ?>><?php echo $dprov['nama_provinsi']; ?></option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="kota">Nama Kota :</label></td>
            	<td>
                		<select size="1" name="kota" id="kota" class="inputan">
                        	<option value="">-- Pilih Kota --</option>
                        <?php
						$qkota = mysql_query("SELECT * FROM t_kota");
						while($dkota = mysql_fetch_array($qkota)){
						?>
                        	<option value="<?php echo $dkota['id_kota']; ?>" <?php echo($dkota['id_kota'] == $dongkir['id_kota'])?"selected":""; ?>><?php echo $dkota['nama_kota']; ?></option>
                        <?php
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="jeniskirim">Jenis :</label></td>
            	<td>
                		<select size="1" name="jeniskirim" id="jeniskirim" class="inputan">
                        <?php
						$qjp = mysql_query("SELECT * FROM t_jeniskirim a, t_forwarder b 
										   WHERE a.id_forwarder=b.id_forwarder");
						while($djp = mysql_fetch_array($qjp)){
						?>
                        	<option value="<?php echo $djp['id_jeniskirim']; ?>" <?php echo($djp['id_jeniskirim'] == $dongkir['id_jeniskirim'])?"selected":""; ?>>
							<?php echo $djp['nama_forwarder'].' - '.$djp['nama_jeniskirim']; ?>
                            </option>
                        <?php	
						}
						?>
                        </select>
               	</td>
            </tr>
        	<tr>
            	<td><label for="harga">Harga Ongkos Kirim :</label></td>
            	<td>
                	<input type="hidden" name="id_ongkir" value="<?php echo $dongkir['id_ongkir']; ?>" class="inputan"/>
                	<input type="text" name="harga" id="harga" size="10" maxlength="10" value="<?php echo $dongkir['harga_ongkir']; ?>" />
                </td>
            </tr>
        	<tr>
            	<td colspan="2" align="center">
                	<button name="update" class="blue"/><span class="label1">Ubah</span></button>
                    <a class="button red" href="?page=jeniskirim"/><span class="label1">Batal</span></a>
				</td>
            </tr>
        </table>
	</form>
    <?php
	}
}
else
{
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
	<a href="?page=ongkir&act=add" class="button blue">
    <span class="label1">Tambah Ongkos Kirim</span></a>
    </td>
    <td align="right" width="70%">
    <form method="post" action="">
    	<select name="type">
        	<option value="0">Semua</option>
        	<option value="1" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 1)?"selected":""; } ?>>Kota</option>
            <option value="2" <?php if(isset($_POST['type'])){ echo($_POST['type'] == 2)?"selected":""; } ?>>Provinsi</option>
        </select>
    	<input type="text" name="textcari" class="newsletter_input" value="<?php if(isset($_POST['textcari'])){ echo $_POST['textcari']; } else { echo "Kata Kunci..."; }?>" onBlur="if(this.value=='') this.value='Kata Kunci...';" onFocus="if(this.value=='Kata Kunci...') this.value='';" /></td><td>
        <button name="cari" class="action"/>
        <span class="icon icon198"></span></button>
    </form>
    </td></tr>
    </table>
   <?php
	if(isset($_POST['type'])){
		$type = addslashes($_POST['type']);
		if($type == 0)
			$sqlquery = "";
		elseif($type == 1)
			$sqlquery = "AND nama_kota LIKE '%$_POST[textcari]%'";
		elseif($type == 2)
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
            <th width="444" class="rounded" scope="col">Provinsi</th>
            <th width="444" class="rounded" scope="col">Kota</th>
            <th width="444" class="rounded" scope="col">Jenis Pengiriman</th>
            <th width="444" class="rounded" scope="col">Harga Kirim</th>
            <th width="32" class="rounded" scope="col">Ubah</th>
            <th width="45" class="rounded-q4" scope="col">Hapus</th>
        </tr>
    </thead>
        <tfoot>
    </tfoot>
    <tbody>
    	<?php
		$no = 0;
		$qongkir = mysql_query("SELECT * FROM t_ongkir a, t_kota b, t_provinsi c, t_jeniskirim d,
							   		 t_forwarder e
									 WHERE a.id_kota = b.id_kota
									 AND a.id_jeniskirim = d.id_jeniskirim
									 AND d.id_forwarder = e.id_forwarder
									 $sqlquery
									 AND b.id_provinsi = c.id_provinsi
									 ORDER BY a.id_kota ASC LIMIT $posisi,$batas");
		$kolom=1;
		$i=0;
		$no = $posisi+1;
		while($dongkir = mysql_fetch_array($qongkir)){
			if ($i >= $kolom){
				echo "<tr class='row$dongkir[id_ongkir]'>";
			}
		?>
        	<td><?php echo $no; ?></td>
            <td><?php echo $dongkir['nama_provinsi']; ?></td>
            <td><?php echo $dongkir['nama_kota']; ?></td>
            <td><?php echo $dongkir['nama_forwarder'].' - '.$dongkir['nama_jeniskirim']; ?></td>
            <td>Rp. <?php echo number_format($dongkir['harga_ongkir'],"2",".",","); ?></td>
            <td><a href="?page=ongkir&act=edit&idok=<?php echo $dongkir['id_ongkir']; ?>" title="Ubah">
                	<span class="icon icon145"></span></a></td>
            <td width="45">
            	<a href="<?php echo $dongkir['id_ongkir']; ?>" id="ongkir" class="ask" title="Hapus">
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
	$tampil2 = mysql_query("SELECT * FROM t_ongkir a, t_kota b, t_provinsi c
							WHERE a.id_kota = b.id_kota
							$sqlquery
							AND b.id_provinsi = c.id_provinsi");
	$jmldata = mysql_num_rows($tampil2);
	$jmlhal  = ceil($jmldata/$batas);
		
	echo "<div class=paging>";
	// Link ke halaman sebelumnya (previous)
	if($halaman > 1){
		$prev=$halaman-1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=ongkir&halaman=$prev'>Prev</a></span> ";
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
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=ongkir&halaman=$i'>$i</a> ";
	}
	
	$angka .= "<span class=current>$halaman</span> ";
	for($i=$halaman+1;$i<($halaman+3);$i++)
	{
	  if ($i > $jmlhal) 
		  break;
	  $angka .= "<a href='$_SERVER[PHP_SELF]?page=ongkir&halaman=$i'>$i</a> ";
	}
	
	$angka .= ($halaman+2<$jmlhal ? " ...  
			  <a href='$_SERVER[PHP_SELF]?page=ongkir&halaman=$jmlhal'>$jmlhal</a> " : " ");
	
	echo "$angka ";	
	// Link kehalaman berikutnya (Next)
	if($halaman < $jmlhal){
		$next=$halaman+1;
		echo "<span class=prevnext><a href='$_SERVER[PHP_SELF]?page=ongkir&halaman=$next'>Next</a></span>";
	}
	else{ 
		echo "<span class=disabled>Next</span>";
	}
	
	echo "</div>";
}
	?>
     

<script>
	$("#provinsi").change(function(){ 
		var idprov = $("#provinsi").val();
		$.ajax({ 
				url: "../inc/getdata/kota.php", 
				data: "idprov="+idprov, 
				cache: false, 
				success: function(msg){
					$("#kota").html(msg); 
				} 
		}); 
	}); 
	
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