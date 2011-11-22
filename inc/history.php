<?php
if(isset($_GET['idn']))
	$idn = addslashes($_GET['idn']);
	
if(isset($_POST['batalkan'])){
	mysql_query("UPDATE detailpembelian SET status_pemesanan = 'cancel' WHERE id_detailpembelian = '$_POST[idn]'");	
}
            
if(isset($_POST['aktifkan'])){
	mysql_query("UPDATE detailpembelian SET status_pemesanan = 'ok' WHERE id_detailpembelian = '$_POST[idn]'");	
}
            
if(isset($_POST['diterima'])){
	mysql_query("UPDATE detailpembelian SET status_pengiriman = 'diterima' WHERE id_detailpembelian = '$_POST[idn]'");	
}
?>
<div class="center_title_bar">History</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
		<table width="552" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <th width="20" bgcolor="#CCCCCC" scope="col">No Nota</th>
            <th width="94" bgcolor="#CCCCCC" scope="col">Tanggal pembelian</th>
            <th width="107" bgcolor="#CCCCCC" scope="col">Total Harga</th>
            <th width="48" bgcolor="#CCCCCC" scope="col">Status</th>
            <th width="48" bgcolor="#CCCCCC" scope="col">&nbsp;</th>
          </tr>
          <?php
          $qdetailpembelian = mysql_query("SELECT *
                                FROM detailpembelian as a, pembelian as b
                                WHERE a.id_detailpembelian = b.id_detailpembelian
                                AND b.id_member = $_SESSION[id_member]
                                GROUP BY a.id_detailpembelian
                                ORDER BY a.tanggal_detailpembelian DESC") or die(mysql_error());
            $no = 0;
            while($ddetailpembelian = mysql_fetch_array($qdetailpembelian)){
            $no++;
            $stokberat = 0;
			$total = 0;
            $subtotal = 0;
            $querycart = mysql_query("SELECT *
                                   FROM detailpembelian as a, pembelian as b, barangdetail as c, barang as d, warna as e, ukuran as f
                                   WHERE a.id_detailpembelian = b.id_detailpembelian
                                   AND b.id_barangdetail = c.id_barangdetail
                                   AND c.id_barang = d.id_barang
                                   AND c.id_warna = e.id_warna
                                   AND c.id_ukuran = f.id_ukuran
                                   AND b.id_member = $_SESSION[id_member]
                                   AND a.id_detailpembelian = $ddetailpembelian[id_detailpembelian]");
            while($datacart = mysql_fetch_array($querycart)){
                $subtotal = $subtotal + ($datacart['stok_temp'] * $datacart['harga_temp']);
                $stokberat =  $stokberat + ($datacart['stok_temp'] * $datacart['berat_temp']);
                $qongkos = mysql_query("SELECT * FROM detailpembelian as a, ongkir as b
                                       WHERE a.id_ongkir = b.id_ongkir
                                       AND a.id_detailpembelian = $ddetailpembelian[id_detailpembelian]");
                $dongkos = mysql_fetch_array($qongkos);
                $total = $subtotal + ((int)ceil($stokberat) * $dongkos['harga_ongkir']);
            }
          ?>
            <tr>
                <td align="center"><?php echo $ddetailpembelian['id_detailpembelian']; ?></td>
                <td align="center"><?php echo $ddetailpembelian['tanggal_detailpembelian']; ?></td>
                <td align="right">Rp. <?php echo number_format($total,"2",",","."); ?></td>
                <td align="center"><?php if($ddetailpembelian['status_pemesanan'] == 'ok') echo $ddetailpembelian['status_pengiriman']; else echo "dibatalkan"; ?></td>
                <td align="center"><a href="?page=view&idn=<?php echo $ddetailpembelian['id_detailpembelian']; ?>">View</a></td>
            </tr>
          <?php
          }
          ?>
        </table>
    </div>
</div>