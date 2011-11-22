<?php
include "../lib_func/config.php";
include "../lib_func/function.php";

$qupdate = mysql_query("SELECT * FROM detailpembelian WHERE status_pengiriman = 'dikirim'");
while($dupdate = mysql_fetch_array($qupdate)){
	get_jnestates($dupdate['id_invoice']);
}
?>