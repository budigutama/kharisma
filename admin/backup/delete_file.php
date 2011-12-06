<?php
    // Get the filename to be deleted
    $file=$_GET['file'];
    $aksi=$_GET['aksi'];
    // Check if the file has needed args
    if ($file==NULL){
        print("<script type='text/javascript'>window.alert('You have not provided a file to delete.')</script>");
        print("<script type='text/javascript'>window.location='backup_overview.php'</script>");
        print("You have not provided a file to delete.<br>Click <a href='backup_overview.php'>here</a> if your browser doesn't automatically redirect you.");
        die();
    }
 
    // Delete the file
    if (!is_dir("file/" . $file)) {
        unlink("file/" . $file);
    }
 
    // Redirect
	header("Location:../index.php?page=backup_restore&aksi=".$aksi."&pesan=4");
?>