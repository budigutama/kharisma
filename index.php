<?php
session_start();
/*function redirectToHTTPS()
{
  if($_SERVER['HTTPS']!="on")
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location:$redirect");
  }
}
redirectToHTTPS();*/
include "fungsi/function.php";
include "fungsi/email.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Toko Kharisma Musik Indramayu</title>
<?php
require_once('fungsi/db_koneksi.php');
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" href="js/validate/val.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="js/star/css/crystal-stars.css"/>
<link rel="stylesheet" href="css/css3-buttons.css" type="text/css"  media="screen">
<link rel="stylesheet" type="text/css" href="css/box.css" />
<link href="js/jalert/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="css/anylinkcssmenu.css" />
<script type="text/javascript" src="js/anylinkcssmenu.js"></script>

<link rel="stylesheet" href="js/tabs/jquery.tabs.css" type="text/css" media="print, projection, screen">
<script src="js/jalert/jquery.alerts.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.3.1.js"></script>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/drop.js" type="text/javascript"></script>
<script src="js/jalert/jquery.alerts.js" type="text/javascript"></script>
<script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
<script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="js/validate/jquery.validate.js"></script>

<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>

</head>
<body>
<div id="header">
</div>
<!-- end of menu tab -->
<div id="main_container">
       <?php include "inc/menus.php"; ?>  
<div id="main_content">
<div class="left_content">  
   <?php include "inc/kiri.php"; ?>
</div><!-- end of left content --> 
<div class="center_content">
   <?php include "inc/tengah.php"; ?>
</div><!-- end of center content -->

<div class="right_content">
    <?php include "inc/kanan.php"; ?>  
</div><!-- end of right content -->   
   </div>
<!-- end of main content -->
   <div class="footer">
   <hr width="100%" />
        <img src="gambar/payment.gif" alt="" title="" /><br />  
   </div> <!-- end footer -->                
   
</div>
</body>
</html>