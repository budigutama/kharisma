<link rel="stylesheet" href="js/validate/val.css" type="text/css" />
<script type="text/javascript" src="js/validate/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#kontakform").validate({
				rules: {
					nama: "required",
					email: "required",
				  	komentar :	"required",
					code :	"required",
					},
				messages: { 
						nama: {
							required: '. Nama harus di isi'
						},
					  	email: {
							required: '. email harus di isi'
						},
						komentar: {
							required: '. komentar harus di isi'
						},
						code: {
							required: '. kode captcha harus di isi'
						},
				},
				 success: function(label) {
					label.text('OK!').addClass('valid');
				}
			});
		});
</script>

<div class="center_title_bar">Hubungi Kami</div>
<div class="prod_box_big">
	<div class="center_prod_box_big">
  <table width="100%">
  <tr>
    	<td width="96%" style="font-size:12px;" valign="bottom" align="center">
        <b>Silahkan Sampaikan komentar atau apapun yang ingin anda ketahui mengenai www.tokomusikkharisma.com</b></td>
    </tr>
  </table>
<br>
<?php
if(isset($_POST['submit'])){
	if($_POST['code'] == $_SESSION['string']){
		mysql_query("INSERT INTO t_bukutamu
					VALUES(null, '$_SESSION[id_member]','$_POST[nama]','$_POST[email]','$_POST[komentar]','0',now())");
		echo "<h3 style=color:green;  align=center>Terima Kasih Atas Saran Dan Kritiknya...</h3>";
	}
	else{
		echo "<h3 style=color:#F00;  align=center>Kode Captcha salah..</h3>";
	}
}
?>
  <form id="kontakform" method="post" action="">
  <table border="0" cellpadding="5" cellspacing="5" width="100%">
  <tr>
    	<td width="15%">Nama</td>
    	<td width="1%">:</td>
    	<td width="84%"><input name="nama" id="nama" type="text" size="30" class="inputan" /></td>
    </tr>
  	<tr>
    	<td>Email</td>
    	<td>:</td>
    	<td><input name="email" id="email" type="text" size="30" class="inputan"/></td>
    </tr>
  	<tr>
    	<td>Komentar</td>
    	<td>:</td>
    	<td><textarea name="komentar" cols="60" rows="5" id="komentar" class="inputan"></textarea></td>
    </tr>
  	<tr>
  	  <td>&nbsp;</td>
  	  <td>&nbsp;</td>
  	  <td><img src="image.php" /></td>
	  </tr>
  	<tr>
    	<td>Kode Captcha</td>
    	<td>:</td>
    	<td><input name="code" id="code" type="text" size="30" class="inputan"/></td>
    </tr>
  	<tr>
  	  <td>&nbsp;</td>
  	  <td>&nbsp;</td>
  	  <td>	
        <button name="submit"><span class="icon icon125"></span><span class="label1">Kirim</span></button>
	  </td>
	  </tr>
    </form>
  </table>
            
	</div>
</div>