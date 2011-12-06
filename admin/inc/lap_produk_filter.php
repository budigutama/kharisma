<?php
$sqldate = "";
if(isset($_POST['cariproduk'])){
	$sqldate = " ";
	$sqlkind = "";
	if(!empty($_POST['kategori'])){
		$sqlkind = " AND e.nama_kategori = '$_POST[kategori]'";
		$kat="Kategori $_POST[kategori]";
	}
	else{
		$kat="Semua Kategori";
	}
	if(!empty($_POST['tahun']) && !empty($_POST['bulan'])){
		$tahun = addslashes($_POST['tahun']);
		$bulan = addslashes($_POST['bulan']);
		$sqldate = "AND YEAR(tanggal_detailproduk) = '$tahun'
					AND MONTH(tanggal_detailproduk) = '$bulan'";
	$tampil="Bulan ".getBulan($bulan)." ".$tahun."";
	$bulan ="<h4>$tampil</h4>";
	}
	$sqldate = $sqldate.$sqlkind;
}
?>
 <div class="spek" style="height:auto; margin-bottom:6px; width:370px;">   
  <h2>Laporan Produk <?php echo $kat; ?></h2>
  <?php echo $bulan; ?>
<table width="100%" cellpadding="1">
<form method="post" action="">
<tr>
    <td width="200px">
    Bulan<br />
    <select name="bulan" class="newsletter_input" style="height:28px; padding-top:2px;">
        <option value="">SEMUA</option>
            <?php
                $querybulan = mysql_query( "SELECT MONTH(tanggal_detailproduk) as bulan
                                            FROM t_detailproduk
                                            GROUP BY MONTH(tanggal_detailproduk)");
                while($databulan = mysql_fetch_array($querybulan)){
                ?>
                  <option value="<?php echo $databulan['bulan']; ?>"><?php echo getBulan($databulan['bulan']); ?></option>
                <?php
                }
            ?>
        </select>
        <select name="tahun" class="newsletter_input" style="height:28px; padding-top:2px;">
        <option value="">SEMUA</option>
            <?php
                $querytahun = mysql_query("SELECT YEAR(tanggal_detailproduk) as tahun
                                            FROM t_detailproduk
                                            GROUP BY YEAR(tanggal_detailproduk)");
                while($datatahun = mysql_fetch_array($querytahun)){
                    ?>
                        <option value="<?php echo $datatahun['tahun']; ?>"><?php echo $datatahun['tahun']; ?></option>
                    <?php
                }
            ?>
        </select>
    </td>
    <td>
    Kategori<br />
    <select name="kategori" class="newsletter_input" style="height:28px; padding-top:2px; width:110px;">
        <option value="">SEMUA</option>
            <?php
                $querykategori = mysql_query("SELECT nama_kategori
                                            FROM t_produk a, t_kategori b
                                            Where a.id_kategori=b.id_kategori
                                            GROUP BY b.id_kategori");
                while($kategori = mysql_fetch_array($querykategori)){
                    ?>
                    <option value="<?php echo $kategori['nama_kategori']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                    <?php
                }
            ?>
        </select>
    </td>
     <td>
      <button name="cariproduk" style="margin-bottom:-10px;"/><span class="icon icon198"></span></button>
     </td>
</tr>
</form>
</table>  
</div> 
