<?php
#fungsi untuk konversi ke tanggal indonesia
function tgl_indo($tgl){
  $tanggal = substr($tgl,8,2);
  $bulan = getBulan(substr($tgl,5,2));
  $tahun = substr($tgl,0,4);
  return $tanggal.' '.$bulan.' '.$tahun;		 
}	
#fungsi untuk mendapatkan nama bulan
function getBulan($bln){
  switch ($bln){
    case 1: 
      return "Jan";
      break;
    case 2:
      return "Feb";
      break;
    case 3:
      return "Mar";
      break;
    case 4:
      return "Apr";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Jun";
      break;
    case 7:
      return "Jul";
      break;
    case 8:
      return "Agu";
      break;
    case 9:
      return "Sep";
      break;
    case 10:
      return "Okt";
      break;
    case 11:
      return "Nov";
      break;
    case 12:
      return "Des";
      break;
  }
}

#untuk menampilkan hari
function hari(){
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];
echo $hari_ini;
}

#fungsi ngitung umur
function birthday ($birthday){
  list($year,$month,$day) = explode("-",$birthday);
  $year_diff  = date("Y") - $year;
  $month_diff = date("m") - $month;
  $day_diff   = date("d") - $day;
  if ($month_diff < 0) $year_diff--;
  elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
  return $year_diff;
}

function status_bayar($stat){
  switch ($stat){
    case 1: 
      return "Belum Bayar";
      break;
    case 2:
      return "Lunas";
      break;
    case 3:
      return "Dibatalkan";
      break;
  }
}

function check_query($querystring){
	$filtered = mysql_escape_string($querystring);
	return $filtered;
}

function updatevote($idproduk,$vote){
	$s = 0;
	$qrate = mysql_query("SELECT * FROM t_produk WHERE id_produk = $idproduk");
	$drate = mysql_fetch_array($qrate);
	$avg = (($drate['voterrating_produk'] * $drate['rating_produk']) + $vote) / ($drate['voterrating_produk'] + 1);
	if(!isset($_SESSION['vote'][$s])){
		$updatevote = true;
	}
	else{
		$updatevote = true;
		while(isset($_SESSION['vote'][$s])){
			if($_SESSION['vote'][$s] == $idproduk){
				echo "<script>pesan('Maaf, Anda Hanya Boleh 1 Kali Mengisi Voting !!','Peringatan');</script>";
				$updatevote = false;
				break;
			}
		$s++;
		}
	}	
	
	if($updatevote){
		$_SESSION['vote'][$s] = $idproduk;
		$avg = (int)ceil($avg);
		mysql_query("UPDATE t_produk SET voterrating_produk = voterrating_produk + 1, rating_produk = $avg WHERE id_produk = $idproduk");
		echo "<script>alert('Terima Kasih Telah Melakukan Voting');</script>";
	}
}

function loginadmin($email,$password){
	$password = md5($password);
	$qadmin = mysql_query("SELECT *
							   FROM t_admin
							   WHERE email_admin = '$email' AND password_admin = '$password'");
	if(mysql_num_rows($qadmin) == 1){
		$dadmin = mysql_fetch_array($qadmin);
		$_SESSION['id_admin'] = $dadmin['id_admin'];
		$_SESSION['email_admin'] = $dadmin['email_admin'];
		$_SESSION['nama_admin'] = $dadmin['nama_admin'];
		
		mysql_query("UPDATE t_admin SET status_login = '1' WHERE id_admin = '$dadmin[id_admin]'") or die(mysql_error()); // Update status login
		echo "<script>window.location = 'index.php';</script>";
	}
	else{
		?>
        <script>alert('Maaf, account tidak ditemukan','Peringatan');</script>
        <?php
	}
}

function viewcounter($idb){
	mysql_query("UPDATE t_produk SET viewcounter_produk = viewcounter_produk + 1 WHERE id_produk = $idb") or die(mysql_error());
}

function konversikedolar($uang){
	$res=mysql_query("SELECT * FROM t_kurs WHERE id_kurs = 'USD'");
	if($res){
		$data=mysql_fetch_array($res);
		return $uang/$data['nilai_kurs'];
	}
	else
		return 0;
}

function lupapassword($email){
	$qcheckemail = mysql_query("SELECT * FROM t_member WHERE email_member = '$email'");
	$ncheckemail = mysql_num_rows($qcheckemail);
	if($ncheckemail == 1){

		$code = md5(rand(0,9999999));
		mysql_query("UPDATE t_member SET verificationcode_member = '$code' WHERE email_member = '$email'");
		emaillupapassword($email,$code);
		echo "<h3> Verifikasi Password Baru Telah Dikirim Ke Email </h3>";
	}
	else
	{
		echo "<h3>Email Anda Tidak ditemukan </h3>";
	}	
}

function hargadiskon($idb){
	$qdiskon = mysql_query("SELECT * FROM t_produk WHERE id_produk = $idb");
	$ddiskon = mysql_fetch_array($qdiskon);
	$harga = $ddiskon['harga_produk'];
	$diskon = $harga-(($ddiskon['diskon_produk']/100)*$harga);
	return ($diskon);
}

function get_jnestates($id_invoice){
	$link = "http://jne.co.id/index.php?mib=tracking.detail&awb=$id_invoice&awb_list=$id_invoice";
	$result =  curl($link);
	if($result){
		$part = explode('Delivered', $result);
		if(count($part) == 3){
			mysql_query("UPDATE detailpembelian SET status_pengiriman = 'diterima' WHERE id_detailpembelian = '$id_invoice'");
			emailprodukditerima($id_invoice);
		}
	}
}
?>