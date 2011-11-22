<link rel="stylesheet" href="js/validate/valconfirm.css" type="text/css" />
<script type="text/javascript">
		$(document).ready(function(){
			var i = 1;
			while(i <= 7){
				$("#registrationform" + i).validate({
					rules: {
						namabank: "required",
						notransaksi: {
							required: true,
							number: true,
							minlength: 7,
							maxlength: 20
						},
						jumlahbayar:  {
							required: true,
							number: true
						}
					},
				
					messages: { 
							namabank: {
								required: '. Nama Bank harus di pilih'
							},
							notransaksi: {
								required: '. No Transaksi harus di isi',
								number  : '. Hanya boleh di isi Angka',
								minlength: '. No Transaksi minimal 7 karakter',
								maxlength: '. No Transaksi maksimal 20 karakter'
							},
							jumlahbayar: {
								required: '. Jumlah Bayar harus di isi',
								number  : '. Hanya boleh di isi Angka'
							}
					},
					 
					 success: function(label) {
						label.text('OK!').addClass('valid');
					}
				});
				i = i + 1;
			}
		});
</script>
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
/*                ?>
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
                if(($status['status_pengiriman'] == 'dipesan')&&($status['status_pemesanan'] == 'ok')){
                  ?>
                  <button name="Konfirmasi" id="konfirmasi-btn">Konfirmasi</button><br>
        
            <script>
                $("#konfirmasi-btn").click(function(){
                    $("#fieldconfirm").fadeIn();
                });
            </script>
          <div id="fieldconfirm" style="display:none;">
            <div>
                <h5>Silahkan Klik Gambar Dibawah Ini Sesuai Pembayaran yang Telah Dilakukan.</h5><br />
                <table border="0">
                    <tr>
                        <td colspan="4" style='padding-left:10px;'>
                        <?php
						$qkurs = mysql_query("SELECT * FROM kurs WHERE status_kurs = '1'");
						$dkurs = mysql_fetch_array($qkurs);
						?>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                  <input type="hidden" name="business" value="parentaladvisoryonline@yahoo.co.id">
                                  <input type="hidden" name="cmd" value="_xclick">
                                  <input type="hidden" name="item_name" value="<?php echo "No. Nota ".$idn;?>">
                                  <input type="hidden" name="quantity" value="1">
                                  <input type="hidden" name="amount" value="<?php echo round(konversikedolar($total),2);?>">
                                  <input type="hidden" name="shipping" value="0">
                                  <input type="hidden" name="currency_code" value="<?php echo $dkurs['kode_kurs']; ?>">
                                  <input type="hidden" name="return" value="http://www.parentaladvisory-online.com/?page=success" />
                                  <input type="hidden" name="cancel_return" value="http://www.parentaladvisory-online.com/?page=failed" />
                                  <input type="hidden" name="notify_url" value="http://www.parentaladvisory-online.com/paypal/ipn_paypal.php" />
                                  <input type="hidden" name="invoice" value="<?php echo $idn;?>" />
                                  <input type="image" name="submit" border="0" src="paypal/btn_buynow_LG.gif">
                             </form>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                    </tr>
                        <?php
                        $notaID = addslashes($_GET['idn']);
                        $sqlbank = "SELECT * FROM rekening";
                        $querybank = mysql_query($sqlbank) or die(mysql_error());
                        $nomor=0;
                        while($databank = mysql_fetch_array($querybank)){
                            $nomor++;
                            ?>
                              <tr>
                                <td rowspan='3' style='padding-left:10px;'><input type="image" src="images/<?php echo $databank['gambar_rekening']; ?>" name="jenisbank" class='<?php echo "myDiv_$nomor"; ?>' /></td>
                                <td style='padding-left:10px;'>Nama Pemilik</td>
                                <td style='padding-left:10px;'>: <?php echo $databank['nama_rekening']; ?></td>
                              </tr>
                              <tr>
                                <td style='padding-left:10px;'>No. Rekening</td>
                                <td style='padding-left:10px;'>: <?php echo $databank['no_rekening']; ?></td>
                              </tr>
                              <tr>
                                <td style='padding-left:10px;'>Cabang</td>
                                <td style='padding-left:10px;'>: <?php echo $databank['cabang_rekening']; ?></td>
                              </tr>
                              <tr>
                                <td style='padding-left:10px;'>&nbsp;</td>
                                <td style='padding-left:10px;'>&nbsp;</td>
                                <td colspan='2'>&nbsp;</td>
                              </tr>
                              <?php
                        } //end while
                        ?>
                </table>
        
                <script type="text/javascript">
                $(document).ready(function(){
                    $('input[name="jenisbank"]').click(function() {
                        var selected = $(this).attr("class");					
						$('.shade').fadeTo('slow', 0, function(){
							$('.shade').hide();							
							$('#' + selected).fadeTo('slow', 1, function(){});
							$('#' + selected).show();
                        });
                    });
                });
                </script>
                
                <?php
                $sqlbank = "SELECT * FROM rekening";
                $qbank = mysql_query($sqlbank);
                $noid = 0;
                while($dbank = mysql_fetch_array($qbank)){
                $noid++;
                ?>
                <div id='myDiv_<?php echo $noid; ?>' class='shade' style='display:none;'>
                <hr />
                <h2>Form Konfirmasi Pembayaran Rekening</h2>
                    <form action="?page=confirmpay" method="post" id="registrationform<?php echo $noid; ?>">
                        <table width="100%" align="left" cellspacing="5">
                            <tr>
                                <td>Bank Tujuan</td>
                                <td>: <?php echo $dbank['bank_rekening']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td>: <?php echo $dbank['nama_rekening']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>No. Rekening Tujuan</td>
                                <td>: <?php echo $dbank['no_rekening']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Nama Bank</td>
                                <td>:
                                <select name="namabank">
                                	<option value="-">-- Pilih Bank --</option>
                                	<option value="BCA">BCA</option>
                                	<option value="Mandiri">Mandiri</option>
                                	<option value="BNI">BNI</option>
                                	<option value="HSBC">HSBC</option>
                                	<option value="Danamon">Danamon</option>
                                	<option value="BII">BII</option>
                                </select>
                                    <input name="idn" type="hidden" value="<?php echo $idn; ?>" />
                                    <input type="hidden" name="id_rekening" value="<?php echo $dbank['id_rekening']; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>No. Transaksi</td>
                                <td>: <input name="notransaksi" id="notransaksi" size="30" type="text" /></td>
                            </tr>
                            <tr>
                                <td>Jumlah Pembayaran</td>
                                <td>: <input name="jumlahbayar" id="jumlahbayar" size="10" type="text" value="<?php echo $total; ?>" /></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" name="confirmpayment" value="Konfirmasi" id="konfirmasi<?php echo $noid; ?>" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
                } //endif

            }
            elseif(($status['status_pengiriman'] != 'dipesan')&&($status['status_pemesanan'] == 'ok')){
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
    </div>
</div>