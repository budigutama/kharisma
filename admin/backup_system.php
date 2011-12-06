<?php
    // Include the PclZip library
    require_once('pclzip.lib.php');
 
    // Set the arhive filename
    $archive = new PclZip('backup/file/kharisma'.date("YMd").'.zip');
 
    // Set the dir to archive
    $v_dir = dirname(getcwd()); // or dirname(__FILE__);
    $v_remove = $v_dir;
 
    // Create the archive
    $v_list = $archive->create($v_dir, PCLZIP_OPT_REMOVE_PATH, $v_remove);
    if ($v_list == 0) {
        die("Error : ".$archive->errorInfo(true));
    }
	header("Location:../admin/index.php?page=backup_restore&aksi=sis&pesan=3");
?>