<?php
session_start();
include "../fungsi/db_koneksi.php";
include "../fungsi/function.php";

if(!isset($_SESSION['id_admin']))
	echo "<script>window.location = 'login.php';</script>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href='../images/icn.png' rel='SHORTCUT ICON'/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator Toko Alat Musik K H A R I S M A</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="menu.css" />
<link rel="stylesheet" type="text/css" href="../js/validate/val.css" />
<link rel="stylesheet" type="text/css" media="all" href="../js/jalert/jquery.alerts.css" />
<link type="text/css" href="../js/datepicker/ui.all.css" rel="stylesheet" />   
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../js/jalert/jquery.alerts.js"></script>
<script type="text/javascript" src="ddaccordion.js"></script>
<script type="text/javascript" src="../js/datepicker/ui.core.js"></script>
<script type="text/javascript" src="../js/datepicker/ui.datepicker.js"></script>   
<script type="text/javascript" src="../js/datepicker/ui.datepicker-id.js"></script>
<script type="text/javascript" src="../js/datepicker/effects.core.js"></script>
<script type="text/javascript" src="../js/datepicker/effects.drop.js"></script>
<script type="text/javascript"> 
   $(document).ready(function(){
      $("#tanggal1").datepicker({
        showAnim    : "drop",
        showOptions : { direction: "up" }
      });
      $("#tanggal2").datepicker({
        showAnim    : "drop",
        showOptions : { direction: "up" }
      });
    });
</script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
</script>

</head>
<body>
<div id="main_container">
	<div class="header">
    </div>
    <div class="main_content">
    	<div class="menu"></div>
        <div class="center_content">
      		<div class="left_content">
               <?php include "inc/menu.php"; ?> 
		  </div>  
            <div class="right_content">            
               <?php include "inc/halaman.php"; ?> 
    		</div><!-- end of right content-->
		</div>   <!--end of center content -->               
		<div class="clear"></div>
    </div> <!--end of main content-->
</div>
</div>		
</body>
</html>