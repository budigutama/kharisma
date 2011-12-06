<h2>Edit Password</h2> 
<?php
if(isset($_POST['update'])){
	$querygetpass = mysql_query("SELECT *
								FROM t_admin
								WHERE id_admin = '$_SESSION[id_admin]'");
	$datagetpass = mysql_fetch_array($querygetpass);
	if($datagetpass['password_admin'] == md5($_POST['oldpassword'])){
		if($_POST['newpassword'] == $_POST['confirm']){
			$querypass = mysql_query("UPDATE t_admin
										SET password_admin = '".md5($_POST['newpassword'])."'
										WHERE id_admin = '$_SESSION[id_admin]'");
			  echo "<div class=sukses>Password Admin $_POST[email] Berhasil Diupdate</div>"; 
			if($querypass){
				?>
					<form name="redirect">
						<input type="hidden" name="redirect2">
					</form>
					<script>
					var targetURL="?page=editpassword"
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
				?>
					<div class=gagal>Password Admin Gagal diupdate !!!</div>	
				<?php
			}
		}
		else{
			?>
					<div class=gagal>Password dan Konfirmasi tidak cocok !!!</div>	
			<?php
		}
	}
	else{
		?>
					<div class=gagal>Password Lama tidak ditemukan !!!</div>	
		<?php
	}
}
?>
<form action="" method="post" class="niceform">
	<table>
      	<tr>
           	<td><label for="oldpassword">Password Lama :</label></td>
           	<td><input type="password" name="oldpassword" id="oldpassword" size="30" maxlength="50" /></td>
        </tr>
       	<tr>
           	<td colspan="2" align="center"><hr /></td>
        </tr>
      	<tr>
           	<td><label for="newpassword">Password Baru :</label></td>
           	<td><input type="password" name="newpassword" id="newpassword" size="30" maxlength="50" /></td>
        </tr>
      	<tr>
           	<td><label for="confirm">Konfirasi Password :</label></td>
           	<td><input type="password" name="confirm" id="confirm" size="30" maxlength="50" /></td>
        </tr>
       	<tr>
           	<td colspan="2" align="center">
            <button name="update" class="blue"/><span class="label1">Update</span></button>
			</td>
        </tr>
    </table>
</form>