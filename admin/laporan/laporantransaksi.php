<?php
include("../../func/koneksi_db.php");
include("../../func/fungsi.php");
include ('class.ezpdf.php');
$pdf = new Cezpdf();
// Set margin dan font
$pdf->ezSetCmMargins(3, 3, 3, 3);
$pdf->selectFont('fonts/Courier.afm');

$all = $pdf->openObject();

// Tampilkan logo
$pdf->setStrokeColor(0, 0, 0, 1);
$pdf->addJpegFromFile('../gambar/logo.jpg',20,790,50);

// Teks di tengah atas untuk judul header
$pdf->addText(220, 815, 16,'<b>LAPORAN  PENJUALAN</b>');
if (isset($_POST['harian'])){
$pdf->addText(130, 800, 16,'<b> Tangal '.$_POST['tanggal1'].' Sampai '.$_POST['tanggal2']. '</b>'); }
if (isset($_POST['bulanan'])){
$pdf->addText(200, 800, 16,'<b> Bulan '.getBulan($_POST['bulan']).' - '.$_POST['tahun'].'</b>'); }
if (isset($_POST['tahunan'])){
$pdf->addText(258, 800, 16,'<b> Tahun '.$_POST['tahun']. '</b>'); }
// Garis atas untuk header
$pdf->line(10, 785, 578, 785);

// Garis bawah untuk footer
$pdf->line(10, 50, 578, 50);
// Teks kiri bawah
$pdf->addText(30,34,8,'Dicetak tgl:' . date( 'd-m-Y, H:i:s'));

$pdf->closeObject();

// Tampilkan object di semua halaman
$pdf->addObject($all, 'all');
if (isset($_POST['harian'])){
 if(!empty($_POST['tanggal1']) && !empty($_POST['tanggal2'])){
					list($tanggal1,$bulan1,$tahun1) = explode('/',$_POST['tanggal1']);
					list($tanggal2,$bulan2,$tahun2) = explode('/',$_POST['tanggal2']);
					$tanggal1ex = $tahun1."-".$bulan1."-".$tanggal1;
					$tanggal2ex = $tahun2."-".$bulan2."-".$tanggal2;
					$sqldate = "AND ( DATE(tgl_beli) BETWEEN '$tanggal1ex' AND '$tanggal2ex')";
				}
}
if (isset($_POST['bulanan'])){
		$tahun = $_POST['tahun'];
		$bulan = $_POST['bulan'];
		$sqldate = "AND YEAR(tgl_beli) = '$tahun' AND MONTH(tgl_beli) = '$bulan'";
}
if (isset($_POST['tahunan'])){
		$tahun = $_POST['tahun'];
		$sqldate = "AND YEAR(tgl_beli) = '$tahun'";
}
$cari = $sqldate;
$sql = ("SELECT * FROM detail_pembelian a, barang b, barangdetail c,merek d, warna e, pembelian f, member g 
				  WHERE a.idpembelian=f.id_pembelian
				  AND a.id_barangdetail=c.id_barangdetail
				  AND f.id_member=g.id_member
				  AND b.id_barang=c.id_barang
				  AND b.id_merek=d.id_merek
				  AND c.id_warna=e.id_warna
				  AND f.status='terima'
				  $cari");
  $qry = mysql_query($sql) or die ("Gagal query".mysql_error());
  $jml= mysql_num_rows($qry);
  $i= 1;
  
  while ($data1 =mysql_fetch_array($qry)) {
   $sub=($data1['hargabeli'] * $data1['qty']);
   $total=$total+$sub;
   $jumlah=$jumlah+$data1[qty];
   $data[$i]=array('<b>No</b>'=>$i, 
                  '<b>Id</b>'=>$data1[id_pembelian],
				  '<b>Tgl</b>'=>tgl_indo($data1[tgl_beli]),
				  '<b>Nama Member</b>'=>'['.$data1[id_member].']'.$data1[nama_member],
				  '<b>Produk</b>'=>$data1[nama_merek].' '.$data1[nama_barang],
				  '<b>Warna</b>'=>$data1[nama_warna],
				  '<b>qty</b>'=>$data1[qty]. 'pcs',
				  '<b>Harga Satuan</b>'=>'Rp.'.number_format($data1[hargabeli]),
				  );
  $i++;
}
// Penomoran halaman
$pdf->ezStartPageNumbers(320, 15, 8);

$pdf->ezTable($data, '', '', ''); 
$pdf->addText(400, 55, 8,'<b>Total Penjualan      : Rp.'.number_format($total). ',-</b>');
$pdf->addText(400, 65, 8,'<b>Total Penjualan      : $ '.round(konversikedolar($total,2),2). ' </b>');
$pdf->addText(400, 75, 8,'<b>Jumlah Produk terjual: '.$jumlah. ' Pcs</b>');


$pdf->ezStream();
?>
