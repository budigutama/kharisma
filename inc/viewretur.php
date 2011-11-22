<?php
$idn = addslashes($_GET['idn']);
if(isset($_POST['retur'])){
	mysql_query("UPDATE invoice SET status_pemesanan = 'cancel' WHERE id_invoice = '$_POST[idn]'");	
}
?>
<div class="center_title_bar">Invoice - <?php echo $idn; ?></div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
                <?php
            $qstatus = mysql_query("SELECT * FROM invoice as a, transaksi as b
                                   WHERE a.id_invoice = b.id_invoice
                                   AND b.id_member = '$_SESSION[id_member]'
                                   AND a.id_invoice = $idn
								   AND a.status_pengiriman = 'diterima'
                                   GROUP BY a.id_invoice") or die(mysql_error());
            $status = mysql_fetch_array($qstatus);
            $nstatus = mysql_num_rows($qstatus);
            if($nstatus){
                ?>
                <form method="post" action="" style="float:right;"> 
                    <input type="hidden" name="idn" value="<?php echo $idn; ?>">
                <?php
                    $qlastinvoice = mysql_query("SELECT *
                                                 FROM invoice as a, transaksi as b
                                                 WHERE a.id_invoice = b.id_invoice
                                                 AND b.id_member = $_SESSION[id_member]
                                                 AND a.id_invoice = $idn
                                                 GROUP BY a.id_invoice
                                                 ORDER BY a.id_invoice DESC LIMIT 1");
                    $datacustom = mysql_fetch_array($qlastinvoice);
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
                    <td align="center"><strong>Retur</strong></td>
                    <td align="center"><strong>Jumlah</strong></td>
                    <td align="center"><strong>Keterangan</strong></td>
                </tr>
                <?php
                $querycart = mysql_query("SELECT *
                                           FROM invoice as a, transaksi as b, detailproduk as c, produk as d, manufaktur as e
                                           WHERE a.id_invoice = b.id_invoice
                                           AND b.id_detailproduk = c.id_detailproduk
                                           AND c.id_produk = d.id_produk
                                           AND c.id_manufaktur = e.id_manufaktur
                                           AND b.id_member = $_SESSION[id_member]
                                           AND a.id_invoice = $idn");
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
                    <td><?php echo $datacart['nama_produk']; ?> ( <?php echo $datacart['nama_manufaktur']; ?> )</td>
                    <td align="center"><input type="checkbox" name="checkretur" /></td>
                    <td align="center">
                    	<select name="stok_retur">
                        <?php
						$i=1;
						$nstok = $datacart['stok_temp'];
						while($i<=$nstok){
							?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>	
							<?php
							$i++;
						}
						?>
                        </select>
                    </td>
                    <td align="right">
                    	<textarea name="keterangan_retur"></textarea>
                    </td>
                </tr>
                <?php
                } //end while
                ?>
              </table>
              <input type="submit" name="retur" value="Retur" />
              </form>
              <br><br>
              <?php
		}
        else{
            echo "<h3>Tidak Ada Transaksi Pembelian<h3>";
        }
		echo "</div>
            </div>";
        ?>
    </div>
</div>