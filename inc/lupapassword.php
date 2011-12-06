<?php

if(isset($_POST['sendpassword'])){
	if($_POST['password'] == $_POST['confirmpassword']){
		$password = md5($_POST['password']);
		$qubah = mysql_query("UPDATE t_member SET password_member = '$password' WHERE verificationcode_member = '$_POST[code]'") or die(mysql_error());
		if($qubah){
			$changever = md5(uniqid());
			mysql_query("UPDATE t_member SET verificationcode_member = '$changever' WHERE verificationcode_member = '$_POST[code]'") or die(mysql_error());
			echo "<script> alert('Password Telah Dirubah !!');</script>";
		}
		else
			echo "<script>alert('Password Gagal Dirubah, Verifikasi Tidak Cocok !!');</script>";
	}
	else{
		echo "<script>alert('Password Tidak Cocok !!');</script>";	
	}
}
?>

<div class="center_title_bar">Lupa Password</div>
   	<div class="prod_box_big">
	    <div class="center_prod_box_big"> 
    <?php
		if(isset($_GET['code'])){
			if(mysql_num_rows(mysql_query("SELECT * FROM t_member WHERE verificationcode_member = '$_GET[code]' AND status_member = '1'")) == 1){
			?>
            <p align="justify">Silahkan Masukkan Password Baru Anda :</p>
            <div style="padding-left:25%; padding-top:50px; padding-bottom:50px;">
            	<form action="" method="post">
                	<table border="0" cellpadding="0" cellspacing="0">
                    	<tbody>
                                <tr>
                                    <td>Password</td>
                                    <td>
                                        : <input name="password" class="nameText" size="35" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Konfirmasi Password</td>
                                    <td>
                                        : <input name="confirmpassword" class="nameText" size="35" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
										<input name="code" type="hidden" value="<?php echo $_GET['code']; ?>" />
                                        <button name="sendpassword" class="blue"/><span class="label1">Ganti Password</span></button>
                                    </td>
                                </tr>
                            </tbody>
                      </table>
                </form>
            </div>
            <?php
				mysql_query("UPDATE t_member
							SET status_member = '1'
							WHERE verificationcode_member = '$_GET[code]'");
			}
			else{
				echo "<script>window.location = '?page=index';</script>";	
			}
		} ?>
    </div>
    <!-- end content -->
</div>