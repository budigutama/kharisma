 <div class="border_box">
    <div class="title_box">Kategori</div>
       <ul class="left_menu">
        <?php
		$querycat = mysql_query("SELECT * FROM t_kategori");
		$no = 1;
		while($datacat = mysql_fetch_array($querycat)){
			if($no%2 == 1){
				echo "<li class='odd'>";
			}
			else{
				echo "<li class='even'>";
			}
		echo "<a href='?idkat=$datacat[id_kategori]'><span class='icon icon64' style='margin-top:3px;'></span>$datacat[nama_kategori]</a></li>";
		$no++;
		}
		?>
        </ul> 
        </div>
   
 <div class="border_box">
    <div class="title_box">Merek</div>
       <ul class="left_menu">
        <?php
		$qmerek = mysql_query("SELECT * FROM t_merek");
		$no = 1;
		while($dmerek = mysql_fetch_array($qmerek)){
			if($no%2 == 1){
				echo "<li class='odd'>";
			}
			else{
				echo "<li class='even'>";
			}
		echo "<a href='?idmerk=$dmerek[id_merek]'><span class='icon icon115' style='margin-top:3px;'></span>$dmerek[nama_merek]</a></li>";
		$no++;
		}
		?>
        </ul> 
        </div>
   
     <div class="border_box">
     <div class="title_box">Barang Diskon</div> 
     <?php
	 $qbarang = mysql_query("SELECT * FROM t_produk a, t_gambar b
							  WHERE a.id_produk=b.id_produk
							  AND diskon_produk !=0
							  ORDER BY diskon_produk DESC LIMIT 1") or die(mysql_error());
	 $cbarang = 1;
	 $dbarang = mysql_fetch_array($qbarang);
	 ?>     
<script type="text/javascript">
	$(document).ready(function(){
		//Caption Sliding (Partially Hidden to Visible)
		$('.boxgrid.caption').hover(function(){
			$(".cover", this).stop().animate({top:'130px'},{queue:false,duration:130});
		}, function() {
			$(".cover", this).stop().animate({top:'170px'},{queue:false,duration:130});
		});
	});
</script>

	<div class="boxgrid caption">
		<a href="?page=detail&idb=<?php echo $dbarang['id_produk']; ?>">
        <img src="gambar/produk/<?php echo $dbarang['nama_gambar']; ?>" alt="" width="160" height="200" border="0" title="" />
        </a>
		<div class="cover boxcaption">
			<h3><?php echo $dbarang['nama_produk']; ?></h3>
			<p>Rp. <?php echo number_format($dbarang['harga_produk'],"0",".",","); ?></p>
		</div>
	</div>
</div>

  <div class="border_box">
    <div class="title_box">TIKI Tracking</div>  
			<form action="http://www.tiki-online.com/tracking/track_single" method="POST" target="_blank">      
                <table>
                    <tr>
                        <td>
                            <img src="gambar/tiki.png" width="140" height="60" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                         <input type="text" name="TxtCon" id="TxtCon" autocomplete="off" value="<?php if(isset($_POST['TxtCon'])){ echo $_POST['TxtCon']; } else { echo "TIKI Airwaybill Number..."; }?>" onblur="if(this.value=='') this.value='TIKI Airwaybill Number...';" onfocus="if(this.value=='TIKI Airwaybill Number...') this.value='';" style="width:160px">
                        </td>
                    </tr>
                    <tr>
                        <td><button name="submit" title="Trekking TIKI"/>
                        <span class="icon icon121"></span><span class="label1">TIKI Trek</span></button></td>
                    </tr>
                 </table>
            </form>
     </div>
     
  <div class="border_box">
 <div class="title_box">JNE Tracking</div>  
			<form action="http://jne.co.id/index.php?mib=tracking&lang=IN" method="POST" target="_blank">      
                <table>
                    <tr>
                        <td>
                            <img src="gambar/jne.png" width="140" height="40" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                         <input type="text" name="awbnum" id="awbnum" autocomplete="off" value="<?php if(isset($_POST['awbnum'])){ echo $_POST['awbnum']; } else { echo "JNE Airwaybill Number..."; }?>" onblur="if(this.value=='') this.value='JNE Airwaybill Number...';" onfocus="if(this.value=='JNE Airwaybill Number...') this.value='';" style="width:160px">
                        </td>
                    </tr>
                    <tr>
                        <td><button name="submittracking" title="Trekking JNE"/>
                        <span class="icon icon121"></span><span class="label1">JNE Trek</span></button></td>
                    </tr>
                 </table>
            </form>
     </div>
