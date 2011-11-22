<div class="center_title_bar">Informasi Pemesanan</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
    <?php
if(!isset($_SESSION['confirm']))
	echo "<script>window.location = '?page=index';</script>";
?>
    <div style="padding-left:10%;">
    	Kepada Yth.
        <br /><br />
        Sdr/i &nbsp;&nbsp;<b><?php echo $_SESSION['nama_member']; ?></b>
        <br />
        <br />
        Terimakasih atas Order Anda. Email detailpembelian telah kami kirimkan ke alamat email Anda.<br><br>
        Berikut ini data anda yang telah kami terima.<br /><br /><hr /><br />
        <?php
        $qlastdetailpembelian = mysql_query("SELECT *
                                     FROM detailpembelian as a, pembelian as b
                                     WHERE a.id_detailpembelian = b.id_detailpembelian
                                     AND b.id_member = $_SESSION[id_member]
                                     GROUP BY a.id_detailpembelian
                                     ORDER BY a.id_detailpembelian DESC LIMIT 1");
        $datacustom = mysql_fetch_array($qlastdetailpembelian);
        ?>
        <table>
            <tr>
                <td>No Nota</td>
                <td>: <?php echo $datacustom['id_detailpembelian']; ?></td>
            </tr>
            <tr>
                <td>Nama Pemesan</td>
                <td>: <?php echo $datacustom['nama_pemesan']; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?php echo $datacustom['alamat_pemesan']; ?></td>
            </tr>
            <tr>
                <td>Kodepos</td>
                <td>: <?php echo $datacustom['kodepos_pemesan']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <?php echo $datacustom['email_pemesan']; ?></td>
            </tr>
            <tr>
                <td>No Telp</td>
                <td>: <?php echo $datacustom['no_telp_pemesan']; ?></td>
            </tr>
        </table>
          <table border="0" cellpadding="5" cellspacing="6" width="100%" style="font-size:12px; border:#444 dotted 1px;">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Berat</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
        <?php
        $querycart = mysql_query("SELECT *
                                   FROM detailpembelian as a, pembelian as b, barangdetail as c, barang as d, warna as e, ukuran as f
                                   WHERE a.id_detailpembelian = b.id_detailpembelian
                                   AND b.id_barangdetail = c.id_barangdetail
                                   AND c.id_barang = d.id_barang
								   AND c.id_warna = e.id_warna
								   AND c.id_ukuran = f.id_ukuran
                                   AND b.id_member = $_SESSION[id_member]
                                   AND a.id_detailpembelian = $datacustom[id_detailpembelian]");
        $no = 0;
        $subtotal = 0;
        $stokberat = 0;
        while($datacart = mysql_fetch_array($querycart)){
            $no++;
            $subtotal = $subtotal + ($datacart['stok_temp'] * $datacart['harga_temp']);
            $stokberat =  $stokberat + ($datacart['stok_temp'] * $datacart['berat_temp']);
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $datacart['nama_barang']; ?> ( <?php echo $datacart['nama_warna']; ?> )</td>
            <td><?php echo $datacart['berat_temp']; ?></td>
            <td>
                <?php echo $datacart['stok_temp']; ?>
            </td>
            <td align="right">Rp. <?php echo number_format($datacart['harga_temp'],"2",",","."); ?></td>
            <td align="right">Rp. <?php echo number_format(($datacart['stok_temp'] * $datacart['harga_temp']),"2",",","."); ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="2" align="center">
            Ongkos Kirim
            </td>
            <td colspan="2" align="center">
            <?php
            $qongkos = mysql_query("SELECT * FROM detailpembelian as a, ongkir as b
                                   WHERE a.id_ongkir = b.id_ongkir
                                   AND a.id_detailpembelian = $datacustom[id_detailpembelian]");
            $dongkos = mysql_fetch_array($qongkos);
            echo (int)ceil($stokberat)." Kg";
            $total = $subtotal + ((int)ceil($stokberat) * $dongkos['harga_ongkir']);
            ?>
            </td>
            <td align="right">
                Rp. <?php echo number_format($dongkos['harga_ongkir'],"2",",","."); ?>
            </td>
            <td align="right">
                Rp. <?php echo number_format(((int)ceil($stokberat) * $dongkos['harga_ongkir']),"2",",","."); ?>
            </td>
        <tr>
            <td colspan="2" align="center">
            Total Pembayaran
            </td>
            <td colspan="3" align="center">&nbsp;
            </td>
            <td align="right">
                Rp. <?php echo number_format($total,"2",",","."); ?>
            </td>
        </tr>
      </table>
      </div>
    </div>
</div>