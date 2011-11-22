<?php
include "../lib_func/config.php";
include "../lib_func/function.php";

$qupdate1 = mysql_query("SELECT * FROM detailpembelian WHERE TIMEDIFF(now(),tanggal_detailpembelian) > '24:00:00' AND TIMEDIFF(now(),tanggal_detailpembelian) < '24:01:00' AND status_pengiriman = 'dipesan'");
while($dupdate1 = mysql_fetch_array($qupdate1 )){
    emailreminderpembelian($dupdate1['id_detailpembelian']);
}

$qupdate2 = mysql_query("SELECT * FROM detailpembelian WHERE TIMEDIFF(now(),tanggal_detailpembelian) > '48:00:00' AND TIMEDIFF(now(),tanggal_detailpembelian) < '48:01:00' AND status_pengiriman = 'dipesan'");
while($dupdate2 = mysql_fetch_array($qupdate2 )){
    emailreminderpembelian($dupdate2['id_detailpembelian']);
}

$qdel = mysql_query("SELECT * FROM detailpembelian WHERE TIMEDIFF(now(),tanggal_detailpembelian) > '72:00:00' AND status_pengiriman = 'dipesan'");
while($ddel = mysql_fetch_array($qdel)){
    emailhapuspembelian($ddel['id_detailpembelian']);
    mysql_query("DELETE FROM detailpembelian WHERE id_detailpembelian= '$ddel[id_detailpembelian]'");
    mysql_query("DELETE FROM pembelian WHERE id_detailpembelian= '$ddel[id_detailpembelian]'");
}
?>