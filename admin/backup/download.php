<?php
$dbName='file/'.$_GET['file'];
$dbNames=$_GET['file'];
header("Content-Disposition: attachment; filename=".$dbNames);
header("Content-type: application/download");
$fp  = fopen($dbName, 'r');
$content = fread($fp, filesize($dbName));
fclose($fp);
echo $content;
?>