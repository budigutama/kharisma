<script type="text/javascript" src="../js/validate/jquery.validate.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
	  $("#registrationform").validate({
		  rules: {
			  nama : "required",
			  email : "required",
			  telp: {
				  required: false,
				  number: true,
				  minlength: 7,
				  maxlength: 15
			  }
		  },
	  
		  messages: {
				  nama: {
					  required: '. Nama Admin harus di isi'
				  },
				  telp: {
					  number  : '. Hanya boleh di isi Angka',
					  minlength: '. Telepon minimal 7 Angka',
					  maxlength: '. Telepon maksimal 15 Angka'
				  },
				  email: {
					  required: '. email harus di isi'
				  }
		  },
		   
		   success: function(label) {
			  label.text('.').addClass('valid');
		  }
	  });
  });
</script>
<?php
if(isset($_POST['update'])){
	$qcek = mysql_query("SELECT * FROM t_admin 
						WHERE email_admin = '$_POST[email]' 
						AND id_admin != $_SESSION[id_admin]");
	if(mysql_num_rows($qcek) == 0){	
	mysql_query("UPDATE t_admin SET nama_admin = '$_POST[nama]', email_admin = '$_POST[email]', nama_admin = '$_POST[nama]',
				 telp_admin = '$_POST[telp]', alamat_admin = '$_POST[alamat]'
				 WHERE id_admin = $_SESSION[id_admin]");
  echo "<div class=sukses>Admin $_POST[email] Berhasil Diupdate</div>"; 
	?>
        <form name="redirect">
 			<input type="hidden" name="redirect2">
  		</form>
		<script>
		var targetURL="?page=admin"
		var countdownfrom=3
		var currentsecond=document.redirect.redirect2.value=countdownfrom+1
		function countredirect(){
		  if (currentsecond!=1){
			currentsecond-=1
			document.redirect.redirect2.value=currentsecond
		  }
		  else{
			window.location=targetURL
			return
		  }
		  setTimeout("countredirect()",1000)
		}
		countredirect()
	    </script>
    <?php
        }
	else{
		echo "<div class=gagal>Admin $_POST[nama] Email $_POST[email] Sudah Ada Sebelumnya !!!</div>";	
	}
}
?>
<h2>Edit Profile</h2> 
<?php
$qadmin = mysql_query("SELECT * FROM t_admin WHERE id_admin = $_SESSION[id_admin]");
$dadmin = mysql_fetch_array($qadmin);
?>
<form action="" method="post" class="niceform">
	<table>
      	<tr>
           	<td><label for="nama">Nama :</label></td>
           	<td><input type="text" name="nama" id="nama" size="49" maxlength="128" value="<?php echo $dadmin['nama_admin']; ?>" /></td>
        </tr>
      	<tr>
           	<td><label for="email">Email :</label></td>
           	<td><input type="text" name="email" id="email" size="49" maxlength="128" value="<?php echo $dadmin['email_admin']; ?>" /></td>
        </tr>
      	<tr>
           	<td><label for="telp">Telephone :</label></td>
           	<td><input type="text" name="telp" id="telp" size="49" maxlength="128" value="<?php echo $dadmin['telp_admin']; ?>" /></td>
        </tr>
        <tr>
           	<td><label for="alamat">Alamat :</label></td>
           	<td><textarea name="alamat" id="alamat" rows="5" cols="60"><?php echo $dadmin['alamat_admin']; ?></textarea></td>
        </tr>
       	<tr>
           	<td colspan="2" align="center">
            <button name="update" class="blue"/><span class="label1">Update</span></button>
            </td>
        </tr>
    </table>
</form>