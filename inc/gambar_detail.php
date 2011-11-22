<link rel="stylesheet" type="text/css" href="css/demo.css" />
<script type="text/javascript" src="js/script2.js"></script>

<div id="main">

  <div id="gallery">
   <div id="slides">
   <?php
   $gambar1=mysql_query($dgambar);
   while ($gbr = mysql_fetch_array($gambar1)){
   ?>
    <div class="slide"><img src="gambar/produk/<?php echo $gbr['gbr']?>" width="270px" height="300" alt="side" /></div>
   <?php } ?> 
    </div>
    <div id="menu">
    <ul>
	   <?php
   	   $gambar2=mysql_query($dgambar);
       while ($gbr2 = mysql_fetch_array($gambar2)){
       ?>    
        <li class="menuItem" id="aa"><a href="">
        <img src="gambar/produk/<?php echo $gbr2['gbr']?>" height="34" alt="thumbnail" style="margin-top:-10px"/></a></li>
   <?php } ?> 
    </ul>
    </div>
  </div>
</div>
