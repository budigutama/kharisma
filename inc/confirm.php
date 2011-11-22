<div class="center_title_bar">Informasi Pemesanan</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
    <?php
        $qlastdetailpembelian = mysql_query("SELECT *
                                     FROM t_detail_pembelian as a, t_pembelian as b
                                     WHERE a.id_pembelian = b.id_pembelian
                                     AND b.id_member = $_SESSION[id_member]
                                     GROUP BY b.id_pembelian
                                     ORDER BY b.id_pembelian DESC LIMIT 1");
        $datacustom = mysql_fetch_array($qlastdetailpembelian);
		$idn=$datacustom['id_pembelian'];
		$cara=$datacustom['pembayaran'];
        ?>
        <div align="center"> 
            <a href="?page=cart&idpr=<?php echo $idn; ?>">
            <div class="panah"><span class="step">Step 1</span><br />Keranjang Belanja</div></a>  
            <a href="?page=checkout"><div class="panah"><span class="step">Step 2</span><br />Alamat Kirim</div></a>  
            <a href="?page=confirm"><div class="panah"><span class="step">Step 4</span><br />Konklusi</div></a>
         </div>  
    <div style="padding-left:1%;">
         <h4>Id Pembelian :  <?php echo $idn;  ?></h4>
<div class="alamat">   
          <table border="0" cellpadding="5" cellspacing="0" width="100%" align="center">
        <tr align="center" bgcolor="#cccccc">
            <th>No</th>
            <th>Nama produk</th>
            <th>Berat</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
        <?php
        $querycart = mysql_query("SELECT * FROM t_detail_pembelian as a, t_pembelian as b, t_detailproduk as c, t_produk as d, t_warna as e, t_member g
								 WHERE a.id_pembelian = b.id_pembelian
								 AND a.id_detailproduk = c.id_detailproduk
								 AND c.id_produk = d.id_produk
								 AND c.id_warna = e.id_warna
								 AND b.id_member = g.id_member
								 AND b.id_member = $_SESSION[id_member]
								 AND b.id_pembelian = $idn");
        $no = 0;
        $subtotal = 0;
        $stokberat = 0;
        while($datacart = mysql_fetch_array($querycart)){
            $no++;
            $subtotal = $subtotal + ($datacart['qty'] * $datacart['hargabeli']);
			$ongkos=$datacart['kirim_ongkos'];
            $stokberat =  $stokberat + ($datacart['qty'] * $datacart['berat']);
            $total = $subtotal + $ongkos;
			$bayar=$total;
  if($no%2)
  	echo "<tr align=center style='background-color:#ffffff'>";
  else
  	echo "<tr align=center style='background-color:#f0f4f5'>";
        ?>
            <td><?php echo $no; ?></td>
            <td>    
			<b><?php echo $datacart['nama_produk']; ?></b>
        <?php 
        $qmerek = mysql_query("SELECT * FROM t_merek WHERE id_merek = $datacart[id_merek]");
        $dmerek = mysql_fetch_array($qmerek); ?>
        <dt><strong><em>Merek :</em></strong><?php echo $dmerek['nama_merek']; ?></dt>
        <dt><strong><em>Warna :</em></strong><?php echo $datacart['nama_warna']; ?></dt>
</td>
            <td><?php echo $datacart['berat']; ?> Kg</td>
            <td align="center"><?php if($datacart['diskon_produk']>0){ ?>
        <span style="text-decoration:line-through; font-weight:bold;">
    	Rp. <?php echo number_format($datacart['harga_produk'],"0",".","."); ?></span><br />
    	Diskon <?php echo "$datacart[diskon_produk] % <br /> ";  } ?>
        <span style="font-weight:bold; color:#F00;">
        Rp. <?php echo number_format($datacart['hargabeli'],"0",".","."); ?></span></td>
            <td>
                <?php echo $datacart['qty']; ?> Pcs
            </td>
            <td align="right">Rp. <?php echo number_format(($datacart['qty'] * $datacart['hargabeli']),"0",".","."); ?></td>
        </tr>
        <?php
        }
        ?>
		<tr bgcolor="#FFFFFF">
        <td colspan="2" align="left"> <strong>Subtotal</strong>
		</td>
            <td colspan="3" align="center">&nbsp;
            </td>
            <td align="right">
                <span style="font-weight:bold;">Rp. <?php echo number_format($subtotal,"0",".","."); ?></span>
            </td>
		</tr>
				<tr bgcolor="#FFFFFF">
                    <td colspan="2" align="left">
                    <strong>Ongkos Kirim</strong>
                    </td>
                    <td colspan="3" align="center">(
                    <?php
                    echo (int)ceil($stokberat)." Kg  x  ";
                    ?>
                     Rp. <?php echo number_format($ongkos,"0",".","."); ?> )
                    </td>
                    <td align="right" style="font-weight:bold">
                      <u>Rp. <?php echo number_format($ongkos,"0",".","."); ?> </u> <strong>+</strong>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td colspan="2" align="left">
                    <strong>Total Pembelian</strong>
                    </td>
                    <td colspan="3" align="center">&nbsp;
                    </td>
                    <td align="right" style="color:#F00;font-weight:bold;">
                        Rp. <?php echo number_format($total,"0",".","."); 
					$updatebeli=mysql_query("UPDATE t_pembelian SET totalbayar=$total WHERE id_pembelian=$idn")?>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF" style="color:#F00; font-weight:bold; font-size:14px;">
                    <td colspan="4" align="left">Total Bayar</td>
                    <td align="right" colspan="2">
                        Rp. <?php echo number_format($bayar,"0",".","."); ?>
                    </td>
                </tr>
      </table>
</div>	  
         <div class="alamat">   
            <table width="100%" cellpadding="2">
            <tr align="center"> 
            	<td colspan="2" style="font-size:14px; font-weight:bold">ALAMAT PENGIRIMAN PAKET</td></tr>
            <tr>
            	<td width="160px">Nama Penerima Paket</td>
            	<td> :<?php echo $datacustom['kirim_nama'];?></td>
            </tr>
            <tr>
            	<td width="160px">Alamat </td>
            	<td> :<?php echo $datacustom['kirim_alamat'];?>
               <?php
					$kota=mysql_fetch_array(mysql_query("SELECT * FROM t_kota a, t_provinsi b
														WHERE a.id_provinsi=b.id_provinsi
														AND a.id_kota=$datacustom[kirim_kota]"));
					echo "     $kota[nama_kota] - $kota[nama_provinsi]";?></td>
            </tr>
            <tr>
            	<td width="160px">Kode Pos</td>
            	<td> :<?php echo $datacustom['kirim_kdpos'];?></td>
            </tr>
            <tr>
            	<td width="160px">No. telepon</td>
            	<td> :<?php echo $datacustom['kirim_telp'];?></td>
            </tr>
            <tr>
            	<td colspan="2"><strong>Peket dikirim dengan :</strong></td>
            </tr>
            <tr>
            	<td width="160px">Jenis Pengiriman</td>
            	<td> :<?php
					$kirim=mysql_fetch_array(mysql_query("SELECT * FROM t_forwarder a, t_jeniskirim b
														WHERE a.id_forwarder=b.id_forwarder
														AND b.id_jeniskirim=$datacustom[id_jeniskirim]")); 
					echo "$kirim[nama_forwarder] - jenis $kirim[nama_jeniskirim]";?></td>
            </tr>
            <tr>
            	<td width="160px">No. Resi Pengiriman</td>
            	<td> :<?php echo $datacustom['kirim_resi'];?></td>
            </tr>
            </table>  
         </div> 
         <hr />
        Proses Order / Pemesanan selesai, info detailnya telah kami kirikan kepada email <?php echo $_SESSION['email_member']; ?>, 
        Jika ada data yang belum sesuai silahkan pilih Step ( langkah ) diatas yang ingin diperbaiki..<br />
        Selanjutnya silahkan pilih menu history untuk melakukan konfirmasi pembayaran..<br />
	<input type="reset" class="buton" value="Selesai" onClick="window.location ='?page=history';" />
</div></div></div>

