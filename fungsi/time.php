<?php


$time=time();
$time_check=$time-600;


if(isset($_SESSION['userID'])){
mysql_query("UPDATE member
			 SET waktu_login = '$time'
			 WHERE id_member = '$_SESSION[id_member]'");
}

mysql_query("UPDATE member SET  WHERE time < $time_check");

?>