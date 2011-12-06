 <div class="border_box">
   		<div class="shopping_cart">
        	<div class="title_box">Keranjang Belanja</div>
            
            <div class="cart_details">
            <?php
			$qcart = mysql_query("SELECT * FROM t_pemesanan
								 WHERE session_id = '".session_id()."'");
			
			$qty = 0;
			$total = 0;
			while($dcart = mysql_fetch_array($qcart)){
				$qty   = $qty + $dcart['qty'];
				$total = $total + ($dcart['temp_hargadiskon'] * $dcart['qty']);
			}
			echo $qty; ?> items <br />
            <span class="border_cart"></span>
            Total: <span class="price">Rp. <?php echo number_format($total,"0",".",","); ?></span>
            </div>
            
            <div class="cart_icon"><a href="?page=cart" title=""><img src="gambar/shoppingcart.jpg" alt="" title="" width="35" height="35" border="0" /></a></div>
        </div>
        </div>

<div class="border_box">
        <div class="title_box">Layanan Konsumen</div>  
         <div class="product_img"><a href="http://www.facebook.com/tokomusikkharisma" title="Join to Our Pages on Facebook">
         <img src="gambar/fb2.png" alt="Join facebook" width="60" height="60" border="0" title="" /></a>
         <a href="http://www.twitter.com/tokomusikkharisma" title="Follow Our Twitter @tokomusikkharisma">
         <img src="gambar/twitter2.png" alt="follow Us" width="60" height="60" border="0" title="" /></a></div>
         <div class="product_title">Yahoo messenger</div>
         <div class="product_img"><a href="ymsgr:sendIM?mrbudy_88"><img src="http://opi.yahoo.com/online?u=mrbudy_88&amp;m=g&amp;t=13&amp;rand=1276558051" width="125" height="85" border="0"></a></div>
     </div>  
 
     <div class="border_box">
     <div class="title_box">Paling Banyak Lihat</div> 
     <?php
	 $qmostview = mysql_query("SELECT * FROM t_produk a, t_gambar b
							  WHERE a.id_produk=b.id_produk
							  ORDER BY viewcounter_produk DESC LIMIT 1") or die(mysql_error());
	 $cmostview = 1;
	 $dmostview = mysql_fetch_array($qmostview);
	 ?>     
<script type="text/javascript">
	$(document).ready(function(){
		//Caption Sliding (Partially Hidden to Visible)
		$('.boxgrid.caption').hover(function(){
			$(".cover", this).stop().animate({top:'130px'},{queue:false,duration:160});
		}, function() {
			$(".cover", this).stop().animate({top:'170px'},{queue:false,duration:160});
		});
	});
</script>

	<div class="boxgrid caption">
		<a href="?page=detail&idb=<?php echo $dmostview['id_produk']; ?>">
        <img src="gambar/produk/<?php echo $dmostview['nama_gambar']; ?>" alt="" width="160" height="200" border="0" title="" />
        </a>
		<div class="cover boxcaption">
			<h3><?php echo $dmostview['nama_produk']; ?></h3>
			<p>Rp. <?php echo number_format($dmostview['harga_produk'],"2",".",","); ?></p>
		</div>
	</div>
</div>
             
  <div class="border_box">
 <div class="title_box">POS Tracking</div>  
			<form name="piol" id="piol" action="http://www.posindonesia.co.id/lacak.php" method="POST" target="_blank">      
                <table>
                    <tr>
                        <td>
                            <img src="gambar/pos.jpg" width="140" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                         <input type="text" name="barcode" id="barcode" autocomplete="off" value="<?php if(isset($_POST['barcode'])){ echo $_POST['barcode']; } else { echo "Barcode POS..."; }?>" onblur="if(this.value=='') this.value='Barcode POS...';" onfocus="if(this.value=='Barcode POS...') this.value='';" style="width:160px">
                        </td>
                    </tr>
                    <tr>
                        <td><button name="submit" title="Trekking POS"/>
                        <span class="icon icon121"></span><span class="label1">POS Trek</span></button></td>
                    </tr>
                 </table>
            </form>
     </div>
