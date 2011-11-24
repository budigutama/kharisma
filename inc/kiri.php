<script type="text/javascript">
anylinkcssmenu.init("anchorclass")
</script>

 <div class="border_box">
    <div class="title_box">Kategori</div>
       <ul class="left_menu">
        <?php
		$querycat = mysql_query("SELECT * FROM t_kategori a, t_produk b WHERE a.id_kategori=b.id_kategori GROUP BY a.id_kategori");
		$no = 1;
		while($datacat = mysql_fetch_array($querycat)){
			$idkat =$datacat['id_kategori'];
			if($no%2 == 1){
				echo "<li class='odd'>";
			}
			else{
				echo "<li class='even'>";
			} ?>
		<a href='#' class="anchorclass someotherclass" rel="submenu2" rev="lr">
        <span class='icon icon64' style='margin-top:3px;'></span><?php echo $datacat[nama_kategori]; ?>
        </a>
           <div id="submenu2" class="anylinkcss">
           <ul>
           		<li>
                <a href="?idkat=<?php echo $idkat ?>">
                <span class='icon icon115' style='margin-top:3px;'></span>Semua
                </a></li>
			<?php
            $Qmer = mysql_query("SELECT * FROM t_merek a, t_produk b 
									WHERE a.id_merek=b.id_merek
									AND b.id_kategori=$idkat
									GROUP BY a.id_merek");
            $i=1;
			while($mer = mysql_fetch_array($Qmer)){
                if($i%2 == 1){
                    echo "<li style='background:#f0f4f5'>";
                }
                else{
                    echo "<li>";
                } ?>
                <a href="?idkat=<?php echo $idkat ?>&idmerk=<?php echo $mer['id_merek'] ?>">
                <span class='icon icon115' style='margin-top:3px;'></span><?php echo $mer['nama_merek']; ?>
                </a></li>
				<?php 
                $i++;
                }
                ?>
            </ul>
            </div>
        </li>
        <?php 
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
