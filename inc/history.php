<div class="center_title_bar">History Pembalian</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
    <?php
	$qidd=mysql_query("SELECT * FROM t_pembelian
					  WHERE id_member='$_SESSION[id_member]'
					  AND kirim_ongkos=0");
	while ($idd=mysql_fetch_array($qidd)){
		$id=mysql_query("SELECT * FROM t_detail_pembelian
						WHERE id_pembelian=$idd[id_pembelian]");
		while($dp=mysql_fetch_array($id)){
			$id_produk 			= $dp['id_detailproduk'];
			$qty 				= $dp['qty'];
			$harga				= $dp['hargabeli'];
			$berat				= $dp['berat'];
		mysql_query("UPDATE t_detailproduk SET stok_detailproduk=stok_detailproduk+$qty 
					WHERE id_detailproduk=$id_produk");
		}
	$hapusdp=mysql_query("DELETE FROM t_detail_pembelian WHERE id_pembelian='$idd[id_pembelian]'");
	$hapusp=mysql_query("DELETE FROM t_pembelian WHERE id_pembelian='$idd[id_pembelian]'");
	}
	?>
<div class="alamat">   
    <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFF">
          <tr align="center" bgcolor="#CCCCCCC">
            <th width="36">Id Pembelian</th>
            <th width="94">Tanggal pembelian</th>
            <th width="107">Total Harga</th>
            <th width="48">Status</th>
            <th width="60">Detail</th>
          </tr>
          <?php
          $qdetailpembelian = mysql_query("SELECT *
                                FROM t_pembelian as a, t_detail_pembelian as b
                                WHERE a.id_pembelian = b.id_pembelian
                                AND a.id_member = $_SESSION[id_member]
                                GROUP BY a.id_pembelian
                                ORDER BY a.tgl_beli DESC") or die(mysql_error());
            $no = 0;
            while($ddetailpembelian = mysql_fetch_array($qdetailpembelian)){
            $no++;
            $stokberat = 0;
			$total = 0;
            $subtotal = 0;
            $querycart = mysql_query("SELECT *
                                   FROM t_pembelian as a, t_detail_pembelian as b, t_detailproduk as c, t_produk as d, t_warna as e
                                   WHERE a.id_pembelian = b.id_pembelian
                                   AND b.id_detailproduk = c.id_detailproduk
                                   AND c.id_produk = d.id_produk
                                   AND c.id_warna = e.id_warna
                                   AND a.id_member = $_SESSION[id_member]
                                   AND a.id_pembelian = $ddetailpembelian[id_pembelian]");
            while($datacart = mysql_fetch_array($querycart)){
                $subtotal = $subtotal + ($datacart['qty'] * $datacart['hargabeli']);
                $stokberat =  $stokberat + ($datacart['qty'] * $datacart['berat']);
                $total = $subtotal +  $datacart['kirim_ongkos'];
            }
          ?>
            <tr>
                <td align="center"><?php echo $ddetailpembelian['id_pembelian']; ?></td>
                <td align="center"><?php echo tgl_indo($ddetailpembelian['tgl_beli']); ?></td>
                <td align="right">Rp. <?php echo number_format($total,"2",",","."); ?></td>
                <td align="center"><?php echo $ddetailpembelian['status']; ; ?></td>
                <td align="center"><a href="?page=view&idn=<?php echo $ddetailpembelian['id_pembelian']; ?>" class="button">
                <span class="icon icon84"></span><span class="label1">Lihat</span></a></td>
            </tr>
          <?php
          }
          ?>
        </table>
    </div>
    </div>
</div>