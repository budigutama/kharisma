<link rel="stylesheet" href="css/membertabs.css" type="text/css" media="screen">
<link rel="stylesheet" href="js/validate/val.css" type="text/css" />
<script type="text/javascript" src="js/validate/jquery.validate.js"></script>
<script type="text/javascript" src="js/alamat_validasi.js"></script>
<script>
$(document).ready(function(){
	$("a.tab").click(function () {
		$(".tabactive").removeClass("tabactive");
		$(this).addClass("tabactive");
		$(".tabcontent").slideUp();
		var content_show = $(this).attr("title");
		$("#"+content_show).slideDown();
		return false;
	});
});
</script>
<?php
$qinvo =mysql_query("SELECT * FROM t_pembelian WHERE session_id ='".session_id()."'ORDER BY id_pembelian DESC LIMIT 1");
$dinvo =mysql_fetch_array($qinvo);
$iddb= $dinvo['id_pembelian'];
$email=$_SESSION['email_member'];
if(isset($_POST['submit1'])){
	mysql_query("UPDATE t_pembelian	SET 
				kirim_nama = '$_POST[nama1]',
				kirim_alamat = '$_POST[alamat1]',
				kirim_telp = '$_POST[telp1]',
				kirim_kota = '$_POST[idkota1]',
				kirim_kdpos =  '$_POST[kodepos1]',
				id_jeniskirim =  '$_POST[jeniskirim1]',
				kirim_ongkos =  '$_POST[ongkir]'
				WHERE id_pembelian = '$iddb'");
	emailshipping($iddb,$email);
	echo "<script>window.location = '?page=confirm';</script>";
}
elseif(isset($_POST['submit2'])){
	mysql_query("UPDATE t_pembelian	SET 
				kirim_nama = '$_POST[nama2]',
				kirim_alamat = '$_POST[alamat2]',
				kirim_telp = '$_POST[telp2]',
				kirim_kota = '$_POST[idkota2]',
				kirim_kdpos =  '$_POST[kodepos2]',
				id_jeniskirim =  '$_POST[jeniskirim2]',
				kirim_ongkos =  '$_POST[ongkir]'
				WHERE id_pembelian = '$iddb' ");
	emailshipping($iddb,$email);
	echo "<script>window.location = '?page=confirm';</script>";
}

?>

	<ul class="tabs">
        <li><a href="#" title="content_1_1" class="tab  tabactive">Alamat Sendiri</a></li>
        <li><a href="#" title="content_1_2" class="tab ">Alamat Lain</a></li>
    </ul>
	<?php
    $qmember = mysql_query("SELECT * FROM t_member as a, t_provinsi as b, t_kota as c
                            WHERE a.id_kota = c.id_kota
                            AND b.id_provinsi = c.id_provinsi
                            AND a.id_member = $_SESSION[id_member]");
    $dmember = mysql_fetch_array($qmember);
	$qty=(int)ceil($jml);
    ?>
    <div id="content_1_1" class="tabcontent">
	<h3>Kirim Ke Alamat Sendiri</h3>
    <form method="post" action="" id="registrationform">
        <table>
            <tr>
                <td><label for="nama">Nama Lengkap :</label></td>
                <td><input type="text" name="nama1" id="nama" value="<?php echo $dmember['nama_member']; ?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat :</label></td>
                <td><input type="text" name="alamat1" size="53" readonly value="<?php echo $dmember['alamat_member']; ?>"></td>
            </tr>
            <tr>
                <td><label for="email">Provinsi :</label></td>
                <td><input type="text" name="provinsi1" id="provinsi1" size="40" readonly value="<?php echo $dmember['nama_provinsi']; ?>"/></td>
            </tr>
            <tr>
                <td><label for="telp">Kota :</label></td>
                <td><input type="text" name="kota1" id="kota1" size="20" readonly value="<?php echo $dmember['nama_kota']; ?>"/>
                <input name="idkota1" id="idkota1" value="<?php echo $dmember['id_kota']; ?>" type="hidden">
                </td>
            </tr>
            <tr>
                <td><label for="email">Kode Pos :</label></td>
                <td><input type="text" name="kodepos1" id="kodepos1" size="5" readonly value="<?php echo $dmember['kodepos_member']; ?>"/></td>
            </tr>
            <tr>
                <td><label for="telp">Telephone :</label></td>
                <td><input type="text" name="telp1" id="telp1" size="20" value="<?php echo $dmember['telp_member']; ?>" readonly/></td>
            </tr>
            <tr>
                <td><label for="jeniskirim">Jenis Pengiriman :</label></td>
                <td>
                <select name="jeniskirim1" id="jenis1" class="inputan">
                    <option value="">Pilih Jenis Pengiriman</option>
                    <?php
					$id_kota=$dmember['id_kota'];
                    $qjeniskirim = mysql_query("SELECT * 
											 FROM t_jeniskirim a, t_forwarder b, t_ongkir c
											 WHERE a.id_forwarder=b.id_forwarder
											 AND a.id_jeniskirim=c.id_jeniskirim
											 AND c.id_kota=$id_kota
											 GROUP BY a.id_jeniskirim");
                    while($djeniskirim = mysql_fetch_array($qjeniskirim)){
                    ?>
                        <option value="<?php echo $djeniskirim['id_jeniskirim']; ?>">
						<?php echo $djeniskirim['nama_forwarder']." - ".$djeniskirim['nama_jeniskirim'].": Rp. ".$djeniskirim['harga_ongkir']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </tr>
            <tr>
                <td><label for="telp">Total Ongkir :</label></td>
                <td><input type="hidden" name="jml1" id="jml1" value="<?php echo $qty ?>"/>
                <span id="ongkir1"></span></td>
            </tr>
            <tr>
                <td>
                    <button name="submit1" class="action blue"/>
                    <span class="label1">Lanjut</span></button>
                </td>
            </tr>
        </table>
	</form>
   </div>
   
   <div id="content_1_2" class="tabcontent">
	<h3>Kirim Ke Alamat Lain</h3>
     <form method="post" action="" id="alamatform">
        <table>
            <tr>
                <td><label for="nama">Nama Lengkap :</label></td>
                <td><input type="text" name="nama2" id="nama2" class="inputan"/></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat :</label></td>
                <td><input type="text" size="50" name="alamat2" id="alamat2" class="inputan"></td>
            </tr>
            <tr>
                <td><label for="provinsi">Provinsi :</label></td>
                <td>
                <select name="provinsi" id="provinsi" class="inputan">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php
                    $queryprov = mysql_query("SELECT *
                                                FROM t_provinsi");
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
                <td><label for="kota">Kota :</label></td>
                <td>										
					<select name="idkota2" id="kota" class="inputan"></select>
                </td>
            </tr>
            <tr>
                <td><label for="kodepos">Kode Pos :</label></td>
                <td><input name="kodepos2" class="inputan" type="text" maxlength="5" size="5"></td>
            </tr>
            <tr>
                <td><label for="telp">Telephone :</label></td>
                <td><input name="telp2" class="inputan" type="text" maxlength="15"></td>
            </tr>
            <tr>
                <td><label for="jeniskirim">Jenis Pengiriman :</label></td>
                <td>
					<select name="jeniskirim2" id="jenis2" class="inputan"></select>
            </tr>
            <tr>
                <td><label for="ongkir">Total Ongkir :</label></td>
                <td><input type="hidden" name="jml2" id="jml2" value="<?php echo $qty ?>"/>
                <span id="ongkir2"></span></td>
            </tr>
            <tr>
                <td>
                    <button name="submit2" class="action blue"/>
                    <span class="label1">Lanjut</span></button>
                </td>
            </tr>
        </table>
	</form>
   </div>
			<style>
			#tabbed_box_1 {
				width:100%;
				margin: 0px 0 0px 0;
			}
			#content_1_2 { display:none; }

			</style>
     
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

	$("#kota").change(function(){ 
		var idkota = $("#kota").val();
		$.ajax({ 
				url: "inc/getdata/jeniskirim.php", 
				data: "idkota="+idkota, 
				cache: false, 
				success: function(msg){
					$("#jenis2").html(msg); 
				} 
		}); 
	}); 

	$("#jenis1").change(function(){ 
		var idkota = $("#idkota1").val();
		var jenis = $("#jenis1").val();
		var jml = $("#jml1").val();
		$.ajax({ 
				url: "inc/getdata/ongkir.php", 
				data: "jenis="+jenis+"&jml="+jml+"&idkota="+idkota, 
				cache: false, 
				success: function(msg){
					$("#ongkir1").html(msg); 
				} 
		}); 
	}); 

	$("#jenis2").change(function(){ 
		var idkota = $("#kota").val();
		var jenis = $("#jenis2").val();
		var jml = $("#jml2").val();
		$.ajax({ 
				url: "inc/getdata/ongkir.php", 
				data: "jenis="+jenis+"&jml="+jml+"&idkota="+idkota, 
				cache: false, 
				success: function(msg){
					$("#ongkir2").html(msg); 
				} 
		}); 
	}); 
</script>