<link rel="stylesheet" type="text/css" href="css/style_2.css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.easing.js"></script>
<script language="javascript" type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
 $(document).ready( function(){	
		$('#lofslidecontent45').lofJSidernews( {interval:4000,
											   direction:'opacity',
											   duration:1000,
											   easing:'easeInOutSine'} );						
	});

</script>
<div id="lofslidecontent45" class="lof-slidecontent">
<div class="preload"></div>
 <!-- MAIN CONTENT --> 
  <div class="lof-main-outer">
  	<ul class="lof-main-wapper">
   <?php 
   $prod = "SELECT * FROM t_produk a, t_detailproduk b, t_gambar c
			WHERE a.id_produk=b.id_produk
			AND a.id_produk=c.id_produk
			GROUP BY b.id_produk
			order by tanggal_detailproduk desc
			LIMIT 6";
   $Qprod=mysql_query($prod);
   while ($Dprod=mysql_fetch_array($Qprod)){
   ?>
  		<li>
        		<img src="gambar/produk/<?php echo $Dprod['nama_gambar']; ?>" height="300" width="300">           
                 <div class="lof-main-item-desc">
                <h3><a target="_parent" title="" href="#"><?php echo $Dprod['nama_produk']; ?></a></h3>

                <p><?php echo $Dprod['deskripsi_produk']; ?></p>
             </div>
        </li>
    <?php } ?> 
     </ul>  	
  </div>

  <div class="lof-navigator-outer" style="width:60PX;">
  		<ul class="lof-navigator">
   <?php 
   $prods=mysql_query($prod);
   while ($wprod=mysql_fetch_array($prods)){
   ?>
        <li>
            <div>
                <img src="gambar/produk/<?php echo $wprod['nama_gambar']; ?>" width="140" />
             <h3><?php echo $wprod['nama_produk']; ?> </h3>
            <span><?php echo tgl_indo($wprod['tanggal_detailproduk']); ?></span> : <?php echo $wprod['deskripsi_produk']; ?>
           </div>    
        </li>
   <?php } ?>
        </ul>
  </div>
 </div> 
