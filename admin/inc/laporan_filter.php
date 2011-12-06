<?php
	$sqldate = "";
	if(isset($_POST['carihari'])){
	$sqlkind = "";
		if(!empty($_POST['tanggal1']) && !empty($_POST['tanggal2'])){
			list($tanggal1,$bulan1,$tahun1) = explode('/',$_POST['tanggal1']);
			list($tanggal2,$bulan2,$tahun2) = explode('/',$_POST['tanggal2']);
			$tanggal1ex = $tahun1."-".$bulan1."-".$tanggal1;
			$tanggal2ex = $tahun2."-".$bulan2."-".$tanggal2;
			$sqldate = "AND ( DATE(tgl_beli) BETWEEN '$tanggal1ex' AND '$tanggal2ex')";
		}
		if(!empty($_POST['pembayaran_hari'])){
			$sqlkind = " AND f.pembayaran = '$_POST[pembayaran_hari]'";	
		}
		$sqldate = $sqldate.$sqlkind;
		$tampil="Tanggal ".tgl_indo($tanggal1ex)." s.d. ".tgl_indo($tanggal2ex)."";
		$per="Hari";
	}
	elseif(isset($_POST['caribulan'])){
		$sqlkind = "";
		if(!empty($_POST['tahun']) && !empty($_POST['bulan'])){
			$tahun = addslashes($_POST['tahun']);
			$bulan = addslashes($_POST['bulan']);
			$sqldate = "AND YEAR(tgl_beli) = '$tahun'
						AND MONTH(tgl_beli) = '$bulan'";
		}
		if(!empty($_POST['pembayaran_bulan'])){
			$sqlkind = " AND f.pembayaran = '$_POST[pembayaran_bulan]'";	
		}
		$sqldate = $sqldate.$sqlkind;
		$tampil="Bulan ".getBulan($bulan)." ".$tahun."";
		$per="Bulan";
	}
	elseif(isset($_POST['caritahun'])){
		$sqlkind = "";
		if(!empty($_POST['tahun'])){
			$tahun = addslashes($_POST['tahun']);
			$sqldate = "AND YEAR(tgl_beli) = '$tahun'";
		}
		if(!empty($_POST['pembayaran'])){
			$sqlkind = " AND f.pembayaran = '$_POST[pembayaran]'";	
		}
		$sqldate = $sqldate.$sqlkind;
		$tampil="Tahun ".$tahun."";
		$per="Tahun";
	}
?>
 <div class="spek" style="height:auto; margin-bottom:6px; width:370px;">   
    <table width="100%" cellpadding="1">
    <form method="post" action="">
<?php
if(isset($_GET['per'])){
	if($_GET['per'] == 'hari'){ ?>
    <h2>Laporan Penjualan Perhari</h2>
    <tr>
        <td width="400px">
        Tanggal<br />
        <input type="text" class="newsletter_input" id="tanggal1" name="tanggal1" <?php echo(isset($_POST['tanggal1'])) ? "value='$_POST[tanggal1]'" : "" ; ?> size="7"/> s/d <input type="text" class="newsletter_input" id="tanggal2" name="tanggal2" <?php echo(isset($_POST['tanggal2'])) ? "value='$_POST[tanggal2]'" : "" ; ?> size="7"/></td>
        <td>
        Pembayaran<br />
        <select name="pembayaran_hari" class="newsletter_input" style="height:28px; padding-top:2px; width:94px;">
                <option value="">SEMUA</option>
                <option value="paypal">PAYPAL</option>
                <option value="transfer">TRANSFER</option>
            </select></td>
         <td>
            <button name="carihari" style="margin-bottom:-10px;"/><span class="icon icon198"></span></button>
         </td>
    </tr>
    </form>
    </table>
    </div>
<?php }
	elseif($_GET['per'] == 'bulan'){ ?>
    <h2>Laporan Penjualan Perbulan</h2>
    <tr>
        <td width="400px">
        Bulan<br />
            <select name="bulan" class="newsletter_input" style="height:28px; padding-top:2px;">
                <?php
                    $querybulan = mysql_query( "SELECT MONTH(tgl_beli) as bulan
                                                FROM t_pembelian
                                                GROUP BY MONTH(tgl_beli)");
                    while($databulan = mysql_fetch_array($querybulan)){
                        ?>
                            <option value="<?php echo $databulan['bulan']; ?>" <?php echo(isset($_POST['bulan']) && $_POST['bulan'] == $databulan['bulan']) ? "selected" : "" ; ?>><?php echo getBulan($databulan['bulan']); ?></option>
                        <?php
                    }
                ?>
            </select>
            <select name="tahun" class="newsletter_input" style="height:28px; padding-top:2px; width:80px;">
                <?php
                    $querytahun = mysql_query("SELECT YEAR(tgl_beli) as tahun
                                                FROM t_pembelian
                                                GROUP BY YEAR(tgl_beli)");
                    while($datatahun = mysql_fetch_array($querytahun)){
                        ?>
                            <option value="<?php echo $datatahun['tahun']; ?>" <?php echo(isset($_POST['tahun']) && $_POST['tahun'] == $datatahun['tahun']) ? "selected" : "" ; ?>><?php echo $datatahun['tahun']; ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
        <td>
        Pembayaran<br />
        <select name="pembayaran_bulan" class="newsletter_input" style="height:28px; padding-top:2px; width:94px;">
                <option value="">SEMUA</option>
                <option value="paypal">PAYPAL</option>
                <option value="transfer">TRANSFER</option>
            </select>
         </td>
         <td>
            <button name="caribulan" style="margin-bottom:-10px;"/><span class="icon icon198"></span></button>
         </td>
    </tr>
    </form>
    </table>
    </div>
<?php }
	elseif($_GET['per'] == 'tahun'){ ?>
    <h2>Laporan Penjualan Pertahun</h2>
    <tr>
        <td width="400px">
        Tahun<br />
        <select name="tahun" class="newsletter_input" style="height:28px; padding-top:2px; width:94px;">
                <?php
                    $querytahun = mysql_query("SELECT YEAR(tgl_beli) as tahun
                                                FROM t_pembelian
                                                GROUP BY YEAR(tgl_beli)");
                    while($datatahun = mysql_fetch_array($querytahun)){
                        ?>
                            <option value="<?php echo $datatahun['tahun']; ?>" <?php echo(isset($_POST['tahun']) && $_POST['tahun'] == $datatahun['tahun']) ? "selected" : "" ; ?>><?php echo $datatahun['tahun']; ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
        <td>
        Pembayaran<br />
        <select name="pembayaran" class="newsletter_input" style="height:28px; padding-top:2px; width:94px;">
                <option value="">SEMUA</option>
                <option value="paypal">PAYPAL</option>
                <option value="transfer">TRANSFER</option>
            </select></td>
         <td>
            <button name="caritahun" style="margin-bottom:-10px;"/><span class="icon icon198"></span></button>
         </td>
    </tr>
    </form>
    </table>  
    </div>
 <?php }  } ?>
    
