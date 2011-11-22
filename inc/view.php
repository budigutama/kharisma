<?php
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
<div class="center_title_bar">Nota - <?php echo $idn; ?></div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
                <?php
            $qstatus = mysql_query("SELECT * FROM detailpembelian as a, pembelian as b
                                   WHERE a.id_detailpembelian = b.id_detailpembelian
                                   AND b.id_member = '$_SESSION[id_member]'
                                   AND a.id_detailpembelian = $idn
                                   GROUP BY a.id_detailpembelian") or die(mysql_error());
            $status = mysql_fetch_array($qstatus);
            $nstatus = mysql_num_rows($qstatus);
            if($nstatus){
/*              ?>
                <form method="post" action="" style="float:right;"> 
                    <input type="hidden" name="idn" value="<?php echo $idn; ?>">
                <?php
                if(($status['status_pengiriman'] == 'dipesan') && ($status['status_pemesanan'] == 'ok')){
                ?>
                    <input type="submit" name="batalkan" value="Batalkan" onClick="if(confirm('Anda yakin akan Dibatalkan ?')) return true; return false;">
                <?php
                }
                elseif($status['status_pemesanan'] == 'cancel'){
                ?>
                    <input type="submit" name="aktifkan" value="Aktifkan" onClick="if(confirm('Anda yakin akan Diaktifkan lagi ?')) return true; return false;">
                <?php
                }
                
                elseif($status['status_pengiriman'] == 'dikirim'){
                ?>
                    <input type="submit" name="diterima" value="Barang Diterima" onClick="if(confirm('Apakah Pesanan Sudah Anda Terima ?')) return true; return false;">
                <?php	
                }
                ?>
                </form>
                <?php*/
                    $qlastdetailpembelian = mysql_query("SELECT *
                                                 FROM detailpembelian as a, pembelian as b
                                                 WHERE a.id_detailpembelian = b.id_detailpembelian
                                                 AND b.id_member = $_SESSION[id_member]
                                                 AND a.id_detailpembelian = $idn
                                                 GROUP BY a.id_detailpembelian
                                                 ORDER BY a.id_detailpembelian DESC LIMIT 1");
                    $datacustom = mysql_fetch_array($qlastdetailpembelian);
                ?>
                    <table>
                        <?php
                        if($datacustom['no_resi_pemesan'] != ''){
                        ?>
                        <tr align="left">
                            <td><h3>No Resi Anda </h3></td>
                            <td><h3>: <?php echo $datacustom['no_resi_pemesan']; ?></h3></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr align="left">
                            <td>Nama Pemesan</td>
                            <td>: <?php echo $datacustom['nama_pemesan']; ?></td>
                        </tr>
                        <tr align="left">
                            <td>Alamat</td>
                            <td>: <?php echo $datacustom['alamat_pemesan']; ?></td>
                        </tr>
                        <tr align="left">
                            <td>Kodepos</td>
                            <td>: <?php echo $datacustom['kodepos_pemesan']; ?></td>
                        </tr>
                        <tr align="left">
                            <td>Email</td>
                            <td>: <?php echo $datacustom['email_pemesan']; ?></td>
                        </tr>
                        <tr align="left">
                            <td>No Telp</td>
                            <td>: <?php echo $datacustom['no_telp_pemesan']; ?></td>
                        </tr>
                    </table>    
                <table border="0" cellpadding="5" cellspacing="6" width="100%" style="font-size:12px; border:#444 dotted 1px;">
                <tr>
                    <td align="center"><strong>No</strong></td>
                    <td align="center"><strong>Nama Barang</strong></td>
                    <td align="center"><strong>Berat</strong></td>
                    <td align="center"><strong>Jumlah</strong></td>
                    <td align="center"><strong>Harga</strong></td>
                    <td align="center"><strong>Total</strong></td>
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
                                           AND a.id_detailpembelian = $idn");
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
                    <td>
						<?php echo $datacart['nama_barang']; ?><br />
                        <strong><em>Warna :</em></strong>
                        <?php echo $datacart['nama_warna']; ?><br />
                        <strong><em>Ukuran :</em></strong>
                        <?php echo $datacart['nama_ukuran']; ?>
                    </td>
                    <td align="center"><?php echo $datacart['berat_temp']; ?></td>
                    <td align="center">
                        <?php echo $datacart['stok_temp']; ?>
                    </td>
                    <td align="right">Rp. <?php echo number_format($datacart['harga_temp'],"2",",","."); ?></td>
                    <td align="right">Rp. <?php echo number_format(($datacart['stok_temp'] * $datacart['harga_temp']),"2",",","."); ?></td>
                </tr>
                <?php
                } //end while
                ?>
                <tr>
                    <td colspan="2" align="center">
                    Ongkos Kirim
                    </td>
                    <td colspan="2" align="center">
                    <?php
                    $qongkos = mysql_query("SELECT * FROM detailpembelian as a, ongkir as b
                                           WHERE a.id_ongkir = b.id_ongkir
                                           AND a.id_detailpembelian = $_GET[idn]");
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
                </tr>
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
              </table><br><br>
              <?php
            if($status['status_pemesanan'] == 'ok'){
                echo "<h3>Pemesanan Telah ".$status['status_pengiriman']."</h3>";
            }
            else
                echo "<h3>Status Pemesanan Dibatalkan</h3>";
			}
        else{
            echo "<h3>Tidak Ada pembelian Pembelian<h3>";
        }
        ?>
    </div>
</div>