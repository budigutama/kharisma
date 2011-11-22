<div class="center_title_bar">Informasi Pembayaran</div>

<div class="prod_box_big">

	<div class="center_prod_box_big">

<?php

if(!isset($_SESSION['id_member']))

	echo "<script>window.location = '?page=register';</script>";

	

if(isset($_POST['checkout'])){

	if(isset($_SESSION['id_member'])){

		$qsession = mysql_query("SELECT * FROM pembelian WHERE session_id = '".session_id()."' AND id_detailpembelian IS NULL");

		if(mysql_num_rows($qsession) > 0)

		{

			mysql_query("INSERT INTO detailpembelian(tanggal_detailpembelian, status_pengiriman, session_id) VALUES(now(),'dipesan','".session_id()."')");

			$qlastid = mysql_query("SELECT * FROM detailpembelian WHERE session_id = '".session_id()."' ORDER BY id_detailpembelian DESC LIMIT 1");

			$dlastid = mysql_fetch_array($qlastid);

			mysql_query("UPDATE pembelian SET id_detailpembelian = '$dlastid[id_detailpembelian]' WHERE session_id = '".session_id()."'");

		}

	}

	else{

		echo "<script>window.location = '?page=register';</script>";

	}

}



if(isset($_POST['submit1'])){

	$qongkos = mysql_query("SELECT * FROM ongkir WHERE id_kota = $_POST[idkota1]") or die(mysql_error());

	$dongkos = mysql_fetch_array($qongkos);

	mysql_query("UPDATE detailpembelian

				SET nama_pemesan = '$_POST[nama1]',

				alamat_pemesan = '$_POST[alamat1]',

				email_pemesan = '$_POST[email1]',

				no_telp_pemesan = '$_POST[telp1]',

				kodepos_pemesan =  '$_POST[kodepos1]',

				id_ongkir = $dongkos[id_ongkir]

				WHERE session_id = '".session_id()."'

				ORDER BY id_detailpembelian DESC LIMIT 1");

	mysql_query("UPDATE pembelian SET session_id = '' WHERE session_id = '".session_id()."'");

	$qinvo = mysql_query("SELECT * FROM detailpembelian WHERE session_id = '".session_id()."' ORDER BY id_detailpembelian DESC LIMIT 1");

	$dinvo = mysql_fetch_array($qinvo);

	emailshipping($dinvo['id_detailpembelian']);

	$_SESSION['confirm'] = true;

	echo "<script>window.location = '?page=confirm';</script>";

}

elseif(isset($_POST['submit2'])){

	$qongkos = mysql_query("SELECT * FROM ongkir WHERE id_kota = $_POST[idkota2]") or die(mysql_error());

	$dongkos = mysql_fetch_array($qongkos);

	mysql_query("UPDATE detailpembelian

				SET nama_pemesan = '$_POST[nama2]',

				alamat_pemesan = '$_POST[alamat2]',

				email_pemesan = '$_POST[email2]',

				no_telp_pemesan = '$_POST[telp2]',

				kodepos_pemesan =  '$_POST[kodepos2]',

				id_ongkir = $dongkos[id_ongkir]

				WHERE session_id = '".session_id()."'

				ORDER BY id_detailpembelian DESC LIMIT 1");

	mysql_query("UPDATE pembelian SET session_id = '' WHERE session_id = '".session_id()."'");

	$qinvo = mysql_query("SELECT * FROM detailpembelian WHERE session_id = '".session_id()."' ORDER BY id_detailpembelian DESC LIMIT 1");

	$dinvo = mysql_fetch_array($qinvo);

	emailshipping($dinvo['id_detailpembelian']);

	$_SESSION['confirm'] = true;

	echo "<script>window.location = '?page=confirm';</script>";

}

?>

    <ol id="checkoutSteps" class="one-page-checkout">

    	<li id="opc-billing" class="section allow active">

            <div>

            	<form method="post" action="">

				<table border="0" cellpadding="0" cellspacing="0">

				<tbody>

                    <tr>

                         <th align="center">JNE</th>

                    </tr>

                    <tr>

                    	<td width="50%">

                            <?php

                                $qjenispengiriman = mysql_query("SELECT * FROM jenispengiriman") or die(mysql_error());

                                $cjenispengiriman = 0;

                                while($djenispengiriman = mysql_fetch_array($qjenispengiriman)){

                            ?>

                                    <input name="idjenispengiriman" class="shippingradio" id="shippingradio_<?php echo $cjenispengiriman; ?>" value="<?php echo $djenispengiriman['id_jenispengiriman']; ?>" type="radio">

                                    <label for="shippingradio_<?php echo $cjenispengiriman; ?>">

                                        <?php echo $djenispengiriman['nama_jenispengiriman']."  (".$djenispengiriman['deskripsi_jenispengiriman'].")"; ?>

                                    </label><br><br />

                                <?php

                                $cjenispengiriman++;

                                }

                                ?>

                    	</td>

                    </tr>

                  	<tr>

                        <td colspan="2">

                                    <small><font color="red">* ParentalBabyStore.com tidak bertanggung jawab jika waktu pengiriman melalui JNE lebih lama dari estimasinya.</font></small>

                    	</td>

                	</tr>

				</tbody>

			</table>

            <hr /><br>

            <script type="text/javascript">

                $(function() {

                    $('#container-1').tabs({ fxFade: true, fxSpeed: 'fast' });

                });

            </script>

				<div id="container-1">

					<ul>

						<li><a href="#1"><span>Sendiri</span></a></li>

						<li><a href="#2"><span>Alamat Lain</span></a></li>

					</ul>

                    	<?php

						$qmember = mysql_query("SELECT * FROM member as a, provinsi as b, kota as c

												WHERE a.id_kota = c.id_kota

												AND b.id_provinsi = c.id_provinsi

												AND a.id_member = $_SESSION[id_member]");

						$dmember = mysql_fetch_array($qmember);

						?>

					<div id="1" style="border-radius:10px; -moz-border-radius: 5px; -webkit-border-radius: 10px; border:1px #D64800 solid;border-collapse:collapse;">

						<table class="affiliateTable" width="100%" border="0" cellpadding="0" cellspacing="0">

							<tbody>

								<tr>

									<td><font color="black"><strong>Nama Lengkap</strong></font></td>

									<td>

										<input name="nama1" id="namaLengkap" value="<?php echo $dmember['nama_member']; ?>" size="35" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td width="20%"><font color="black"><strong>Alamat</strong></font></td>

									<td>

										<textarea class="addressText" name="alamat1" readonly="readonly"><?php echo $dmember['alamat_member']; ?></textarea>

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Provinsi</strong></font></td>

									<td>

										<input name="provinsi1" value="<?php echo $dmember['nama_provinsi']; ?>" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Kota</strong></font></td>

									<td>

										<input name="idkota1" value="<?php echo $dmember['id_kota']; ?>" type="hidden">

										<input name="kota1" value="<?php echo $dmember['nama_kota']; ?>" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Kodepos</strong></font></td>

									<td>

										<input name="kodepos1" value="<?php echo $dmember['kodepos_member']; ?>" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Email</strong></font></td>

									<td>

										<input name="email1" value="<?php echo $dmember['email_member']; ?>" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>No Telp</strong></font></td>

									<td>

										<input name="telp1" value="<?php echo $dmember['telp_member']; ?>" class="loginText" type="text" readonly="readonly">

									</td>

								</tr>

								<tr>

									<td>&nbsp;</td>

									<td>

										<input name="submit1" value="Finish »" class="backButton" type="submit">

									</td>

								</tr>

							</tbody>

						</table>

					</form>

					</div>

					<div id="2" style="border-radius:10px; -moz-border-radius: 5px; -webkit-border-radius: 10px; border:1px #D64800 solid;border-collapse:collapse;">

						<table class="affiliateTable" width="100%" border="0" cellpadding="0" cellspacing="0">

							<tbody>

								<tr>

									<td><font color="black"><strong>Nama Lengkap</strong></font></td>

									<td><input name="nama2" id="namaLengkap" size="35" class="loginText" type="text"></td>

								</tr>

								<tr>

									<td width="20%"><font color="black"><strong>Alamat</strong></font></td>

									<td>

										<textarea class="addressText" name="alamat2"></textarea>

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Provinsi</strong></font></td>

									<td>

										<select name="provinsi" id="provinsi">

											<option value="-">-- Pilih Provinsi --</option>

											<?php

											$queryprov = mysql_query("SELECT *

																		FROM provinsi");

											while($dataprov = mysql_fetch_array($queryprov)){

											?>

												<option value="<?php echo $dataprov['id_provinsi']; ?>"><?php echo $dataprov['nama_provinsi']; ?></option>

											<?php

											}

											?>

										</select>

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Kota</strong></font></td>

									<td>

										<select name="idkota2" id="kota"></select>

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Kodepos</strong></font></td>

									<td>

										<input name="kodepos2" class="postcodeText" type="text" maxlength="5">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>Email</strong></font></td>

									<td>

										<input name="email2" class="loginText" type="text">

									</td>

								</tr>

								<tr>

									<td><font color="black"><strong>No Telp</strong></font></td>

									<td>

										<input name="telp2" class="loginText" type="text" maxlength="15">

									</td>

								</tr>

								<tr>

									<td>&nbsp;</td>

									<td>

										<input name="submit2" value="Finish »" class="backButton" type="submit">

									</td>

								</tr>

							</tbody>

						</table>

					</form>

            </div>

    	</li>

        <li id="opc-review" class="section active">

            <div class="head">

                <h3> &nbsp;Pesanan</h3>

            </div>

            <div>

                <div>

                    <table width="100%">

                        <thead>

                            <tr>

                                <th style="background:#999;">No</th>

                                <th style="background:#999;">Nama barang</th>

                                <th style="background:#999;">Harga</th>

                                <th style="background:#999;">Berat</th>

                                <th style="background:#999;">Qty</th>

                                <th style="background:#999;">Subtotal</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                        $qcart = mysql_query("SELECT * FROM pembelian as a, barangdetail as b, barang as c

                                         WHERE a.id_barangdetail = b.id_barangdetail

                                         AND b.id_barang = c.id_barang

                                         AND a.session_id = '".session_id()."'") or die(mysql_error());

                        $i = 0;

                        $subtotal = 0;

                        while($dcart = mysql_fetch_array($qcart)){

						$i++;

						  if($i%2)

							echo "<tr style='background-color:#A5F5FA'>";

						  else

							echo "<tr style='background-color:#D2FFFD'>";

                        ?>

                                <td><?php echo $i; ?></td>

                                <td>

                                    <h4 class="title"><a href="?page=detail&idb=<?php echo $dcart['id_barang']; ?>"><?php echo $dcart['nama_barang']; ?></a></h4>

                                    <!-- item custom options -->

                                    <dl class="item-options">

                                        <?php

                                        if($dcart['id_warna'] != NULL){

                                        $qwarna = mysql_query("SELECT * FROM warna WHERE id_warna = $dcart[id_warna]");

                                        $dwarna = mysql_fetch_array($qwarna);

                                        ?>

                                            <dt><strong><em>Warna</em></strong></dt>

                                            <dd><?php echo $dwarna['nama_warna']; ?></dd>

                                        <?php

                                        }

                                        ?>

                                    </dl>

                                    <dl class="item-options">

                                        <?php

                                        if($dcart['id_ukuran'] != NULL){

                                        $qukuran = mysql_query("SELECT * FROM ukuran WHERE id_ukuran = $dcart[id_ukuran]");

                                        $dukuran = mysql_fetch_array($qukuran);

                                        ?>

                                            <dt><strong><em>Ukuran</em></strong></dt>

                                            <dd><?php echo $dukuran['nama_ukuran']; ?></dd>

                                        <?php

                                        }

                                        ?>

                                    </dl>

                                <!-- / -->

                                </td>

                                <td>

                                    <div class="cart-price" align="right">

                                        <span class="price">Rp <?php echo number_format($dcart['harga_temp'],"2",".",","); ?></span>

                                    </div>

                                </td>

                                <td><?php echo $dcart['berat_temp']; ?></td>

                                <td><?php echo $dcart['stok_temp']; ?></td>

                                <td>Rp <?php echo number_format($dcart['harga_temp']*$dcart['stok_temp'],"2",".",","); ?></td>

                            </tr>

                         <?php

                         $subtotal = $subtotal + ($dcart['harga_temp']*$dcart['stok_temp']);

                         }

                         ?>

                        </tbody>

                        <tfoot>

                            <tr>

                                <td colspan="5"><strong>Total</strong></td>

                                <td><strong><span class="price">Rp <?php echo number_format($subtotal,"2",".",","); ?></span></strong></td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

                <div class="content button-set">

                    <p class="left"><button type="button" onclick="window.location = '?page=cart';" value="Edit Cart">Edit Cart</button></p>

                    <p>

                        <span id="review-please-wait" style="display: none;" class="opc-please-wait">

                            <img src="templates/images/opc-ajax-loader.gif" class="v-middle" alt=""> &nbsp; Submitting order information... &nbsp;

                        </span>

                    </p>

                </div>

            </div>

        </li>

    </ol>

    </div>

</div>

<script>

	$("#provinsi").change(function(){ 

		var idprov = $("#provinsi").val();

		$.ajax({ 

				url: "inc/getdata/kota.php", 

				data: "idprov="+idprov, 

				cache: false, 

				success: function(msg){

					$("#kota").html(msg); 

				} 

		}); 

	}); 

</script>