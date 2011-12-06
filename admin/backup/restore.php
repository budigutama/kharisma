<?php
    // Get the provided arg
    $id=$_GET['id'];
 
    // Check if the file has needed args
    if ($id==NULL){
        print("<script type='text/javascript'>window.alert('You have not provided a backup to restore.')</script>");
        print("<script type='text/javascript'>window.location='backup_overview.php'</script>");
        print("You have not provided a backup to restore.<br>Click <a href='backup_overview.php'>here</a> if your browser doesn't automatically redirect you.");
    }
 
    // Include settings
    include("config.php");
 
    // Generate filename and set error variables
    $filename = './file/' . $id;
    $sqlErrorText = '';
    $sqlErrorCode = 0;
    $sqlStmt      = '';
 
    // Restore the backup
    $con = mysql_connect($DBhost,$DBuser,$DBpass);
    if ($con !== false){
 
        // Load and explode the sql file
        mysql_select_db("$DBName");
        $f = fopen($filename,"r+");
        $sqlFile = fread($f,filesize($filename));
        $sqlArray = explode(';<|||||||>',$sqlFile);
 
        // Process the sql file by statements
        foreach ($sqlArray as $stmt) {
            if (strlen($stmt)>3){
                $result = mysql_query($stmt);
            }
        }
    }
 
    // Print message (error or success)
    /*if ($sqlErrorCode == 0){
        print("Database restored successfully!<br>\n");
        print("Backup used: " . $filename);
    } else {
        print("An error occurred while restoring backup!<br><br>\n");
        print("Error code: $sqlErrorCode<br>\n");
        print("Error text: $sqlErrorText<br>\n");
        print("Statement:<br/> $sqlStmt<br>");
    }*/
 
    // Close the connection
    mysql_close();
	header("Location:../index.php?page=backup_restore&pesan=1");
?>