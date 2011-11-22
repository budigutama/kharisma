<link href="js/loginstyle/front.css" media="screen, projection" rel="stylesheet" type="text/css">
<?php
if (!isset($_SESSION['id_member'])) {
	if (isset($_POST['lupas'])){ 
 		$log=$_POST['lupas'];
	}
	else {
 		$log='Login';
	}
?>
  <div id="topnav" class="topnav"> <a href="?page=register" id="signin"><span>Registasi</span></a>	<a href="login" class="signin"><span><?php echo $log ;?></span></a></div>
<div style="width:100%; float:right; background:#063"> 
<fieldset id="signin_menu">
<?php
if(isset($_POST['login'])){
	$email = mysql_escape_string($_POST['email']);
	$password = md5($_POST['password']);
	$qchecklogin = mysql_query("SELECT * FROM t_member 
	WHERE email_member = '$email' AND password_member = '$password' AND status_member = '1'") 
	or die(mysql_error());
		if(mysql_num_rows($qchecklogin) !=0 ){
		$dmember = mysql_fetch_array($qchecklogin);
		$_SESSION['id_member'] = $dmember['id_member'];
		$_SESSION['email_member'] = $dmember['email_member'];
		$_SESSION['nama_member'] = $dmember['nama_member'];
		echo "<script>window.location = '?page=home';</script>";	
	}
	else{
		echo '<script> alert("Email dan Password Salah!!!")</script>';	
	}
}
if(isset($_POST['kirimpass'])){
	lupapassword($_POST['email']);
}
		if (isset($_POST['lupas'])){ 
		?>
    <form method="post" id="signin" action="">
      <label for="username">Masukan Email</label>
      <input id="email" name="email" title="email" tabindex="4" type="text">
      </p>
      <p class="remember">
        <input id="login" value="Kirim Password" name="kirimpass" tabindex="6" type="submit">
      </p>
      <p class="forgot-username">
      <input name="kembali" type="submit" value="Kembali" style="border:0; background:#ddeef6; color:#999;font-size:13;"/></p>
    </form>
	<?php }
    else{
    ?>  
    <form method="post" id="signin" action="">
      <label for="email">Email</label>
      <input id="email" name="email" title="email" tabindex="4" type="text">
      </p>
      <p>
        <label for="password">Password</label>
        <input id="password" name="password" title="password" tabindex="5" type="password">
      </p>
      <p class="remember">
        <input id="login" value="Login" name="login" tabindex="6" type="submit">
      </p>
      <p class="forgot-username">
      <input name="lupas" type="submit" value="lupa Password" style="border:0; background:#ddeef6; color:#999;font-size:13;"/></p>
    </form>
  </fieldset></div>
<?php } ?>
     <?php
} else {
?>
  <div id="topnav" class="topnav"> <a href="?page=logout" id="signin"><span>logout </span></a> 
  	<a href="logout" class="signin"><span>Hai.. <?php echo substr($_SESSION['nama_member'],0,15); ?>.</span></a> </div>
<fieldset id="signin_menu">
<div style="float:left; padding-right:8px; width:93%">
<ul class="left_menu" style="width:150px;">
	<li class="odd"><a href="?page=editakun">
    	<span class='icon icon96' style='margin-top:3px;margin-left:-7px;'></span>Pengaturan Akun</a></li>
	<li class="even"><a href="?page=history">
    	<span class='icon icon21' style='margin-top:3px;margin-left:-7px;'></span>Lihat Histori</a></li>
	<li class="odd"><a href="?page=logout">
    	<span class='icon icon151' style='margin-top:3px;margin-left:-7px;'></span>Logout</a></li>
</ul>
</div>
</fieldset>
<?php } ?>
<script src="js/loginstyle/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function() {

            $(".signin").click(function(e) {          
				e.preventDefault();
                $("fieldset#signin_menu").toggle();
				$(".signin").toggleClass("menu-open");
            });
			
			$("fieldset#signin_menu").mouseup(function() {
				return false
			});
			$(document).mouseup(function(e) {
				if($(e.target).parent("a.signin").length==0) {
					$(".signin").removeClass("menu-open");
					$("fieldset#signin_menu").hide();
				}
			});			
			
        });
</script>
