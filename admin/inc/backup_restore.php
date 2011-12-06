<?php
  if (isset($_GET['pesan'])){
	 if ($_GET['pesan'] == 1){
		$pesan="Restore Database Berhasil";  
	 }
	 elseif ($_GET['pesan'] == 2){
		$pesan="Backup Database Berhasil";  
	 }
	 elseif ($_GET['pesan'] == 3){
		$pesan="Backup Sistem Berhasil";  
	 }
	 elseif ($_GET['pesan'] == 4){
		$pesan="File Backup Berhasil Dihapus";  
	 }
	 $tampilkan= "<div class=sukses>$pesan</div>";
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=backup_restore&aksi=<?php echo $_GET['aksi']?>"
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
  
 if ($_GET['aksi'] == "up"){
?>
<h2>Upload File Database</h2>
<?php echo $tampilkan ?>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="upload_db.php">
  <label>
Upload file untuk di restore : <input type="file" name="file" id="file" />
  </label>
  <label>
  <input name="type" type="hidden" value="upload" />
  <input type="submit" name="button" id="button" value="OK" />
  </label>
</form>
<?php  } 
 elseif ($_GET['aksi'] == "db"){ ?>
<h2>Backup - Restore Database</h2>
<?php echo $tampilkan ?>
<p><a href="../admin/backup/backup_perform.php" class="button red">
    <span class='icon icon87'></span><span class="label1">Backup File Database</span></a>
<h3>File yang sudah dibackup</h3>
<table width="592" id="rounded-corner" align="center">
<thead>
<tr>
    <th width="444" class="rounded-company" scope="col">Nama File</th>
    <th width="40" class="rounded" scope="col">Restore</th>
    <th width="50" class="rounded" scope="col">Unduh File</th>
    <th width="40" class="rounded-q4" scope="col">Hapus</th>
</tr>
</thead>
<tfoot>
</tfoot>
<tbody>
<?php
    // List the files
    $dir = opendir ("../admin/backup/file");
    while (false !== ($file = readdir($dir))) {
 
        // Print the filenames that have .sql extension
        if (strpos($file,'.sql',1)) {
 
            // Get time and date from filename
            $date = substr($file, 9, 10);
            $time = substr($file, 20, 8);
 
            // Print the cells
            print("<tr>\n");
            print("  <td>" . $file . "</td>\n");
            print("  <td><a href='../admin/backup/restore.php?id=" . $file . "&aksi=db' title=Restore><span class='icon icon189'></span></a></td>\n");
            print("  <td><a href='../admin/backup/download.php?file=" . $file . "' title=Download><span class='icon icon70'></span></a></td>\n");
            print("  <td><a href='../admin/backup/delete_file.php?file=" . $file . "&aksi=db' title=Hapus><span class='icon icon186'></span></a></td>\n");
            print("</tr>\n");
        }
    }
?>
    </tbody>
</table>
<?php  } 
 elseif ($_GET['aksi'] == "sis"){ ?>
<h2>Backup Sistem</h2>
<?php echo $tampilkan ?>
<p><a href="./../admin/backup_system.php" class="button red">
    <span class='icon icon87'></span><span class="label1">Backup File Sistem</span></a>
<h3>File yang sudah dibackup</h3>
<table width="592" id="rounded-corner" align="center">
<thead>
<tr>
    <th width="500" class="rounded-company" scope="col">Nama File</th>
    <th width="50" class="rounded" scope="col">Unduh File</th>
    <th width="40" class="rounded-q4" scope="col">Hapus</th>
</tr>
</thead>
<tfoot>
</tfoot>
<tbody>
<?php
    // List the files
    $dir = opendir ("../admin/backup/file");
    while (false !== ($file = readdir($dir))) {
 
        // Print the filenames that have .sql extension
        if (strpos($file,'.zip',1)) {
 
            // Get time and date from filename
            $date = substr($file, 9, 10);
            $time = substr($file, 20, 8);
 
            // Print the cells
            print("<tr>\n");
            print("  <td>" . $file . "</td>\n");
            print("  <td><a href='../admin/backup/download.php?file=" . $file . "' title=Download><span class='icon icon70'></span></a></td>\n");
            print("  <td><a href='../admin/backup/delete_file.php?file=" . $file . "&aksi=sis' title=Hapus><span class='icon icon186'></span></a></td>\n");
            print("</tr>\n");
        }
    }
?>
    </tbody>
</table>
<?php  } ?>