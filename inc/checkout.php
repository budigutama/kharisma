<div class="center_title_bar">Informasi Pengiriman</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
<?php
if(!isset($_SESSION['id_member'])){
	echo "<script>window.location = '?page=register';</script>"; 
	}
?>
        <div align="center"> 
            <a href="?page=cart&idpr=<?php echo $iddb; ?>">
			<div class="panah"><span class="step">Step 1</span><br />Keranjang Belanja</div></a> 
            <a href="?page=checkout"><div class="panah"><span class="step">Step 2</span><br />Alamat Kirim</div></a>  
            <div class="panah2"><span class="step">Step 4</span><br />Pembayaran</div> 
        </div> 
            <div class="head">
                <h2> &nbsp;Pesanan :</h2>
            </div>
            <div>
<div class="alamat">   
   <table width="100%" cellspacing="0" cellpadding="2" align="center">
      <thead>
      <tr height="30px" bgcolor="#cccccc">
        <th>No</th>
        <th>Nama produk</th>
        <th>Harga</th>
        <th>Berat</th>
        <th>Qty</th>
        <th>Subtotal</th>
      </tr>
      </thead>
      <tbody>
 <?php
	$id=mysql_fetch_array(mysql_query("SELECT id_pembelian id FROM t_pembelian 
						WHERE session_id='".session_id()."' ORDER BY id_pembelian DESC limit 1"));
    $qcart = mysql_query("SELECT * FROM t_detail_pembelian as a, t_detailproduk as b, t_produk as c
                          WHERE a.id_detailproduk = b.id_detailproduk
                          AND b.id_produk = c.id_produk
                          AND a.id_pembelian = '$id[id]'") or die(mysql_error());
    $i = 0;
    $subtotal = 0;
         while($dcart = mysql_fetch_array($qcart)){
	$i++;
		if($i%2)
			echo "<tr style='background-color:#ffffff'>";
  		else
  			echo "<tr style='background-color:#f0f4f5'>"; ?>
    <td><?php echo $i; ?></td>
    <td>
    <b><?php echo $dcart['nama_produk']; ?></b>
    <?php
       if($dcart['id_merek'] != NULL){
        $qukuran = mysql_query("SELECT * FROM t_merek WHERE id_merek = $dcart[id_merek]");
        $dukuran = mysql_fetch_array($qukuran); ?>
        <dt><strong><em>Merek :</em></strong><?php echo $dukuran['nama_merek']; ?></dt>
        <?php  } 
      if($dcart['id_warna'] != NULL){
        $qwarna = mysql_query("SELECT * FROM t_warna WHERE id_warna = $dcart[id_warna]");
        $dwarna = mysql_fetch_array($qwarna);?>
        <dt><strong><em>Warna :</em></strong><?php echo $dwarna['nama_warna']; ?></dt>
        <?php  }  ?>
        </td>
        <td><?php if($dcart['diskon_produk']>0){
	    ?>
        <span style="text-decoration:line-through; font-weight:bold;">
    	Rp. <?php echo number_format($dcart['harga_produk'],"0",".","."); ?></span><br />
    	Diskon <?php echo "$dcart[diskon_produk] % <br /> ";  } ?>
        <span style="font-weight:bold; color:#F00;">
        Rp. <?php echo number_format($dcart['hargabeli'],"0",".","."); ?></span></td>
              <td><?php echo $dcart['berat']; ?> Kg</td>
              <td><?php echo $dcart['qty']; ?></td>
              <td>Rp <?php echo number_format($dcart['hargabeli']*$dcart['qty'],"0",".","."); ?></td>
          </tr>
       <?php
       $subtotal = $subtotal + ($dcart['hargabeli']*$dcart['qty']);
	   $jml = $jml + $dcart['qty']*$dcart['berat'];
       }
       ?>
      </tbody>
      <tfoot>
        <tr bgcolor="#FFFFFF">
         <td colspan="5"><strong>Total</strong></td>
         <td><strong><span class="price">Rp <?php echo number_format($subtotal,"0",".","."); ?></span></strong></td>
          </tr>
      </tfoot>
  </table>
    </div>
</div>
        <h2>Informasi Alamat Pengiriman :</h2>
<?php include "inc/alamat_kirim.php"; ?>

</div>
</div>
