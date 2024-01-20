<?php
	session_start();

	include 'koneksi.php';
	$username = mysqli_escape_string($koneksi,$_POST['username']);
	$password = mysqli_escape_string($koneksi,md5($_POST['password']));

	$querylogin = mysqli_query($koneksi,"UPDATE tb_user SET token_login ='1' WHERE username = '$username'");
	$op = $_GET['op'];

	if ($op ="in"){
			$login = mysqli_query($koneksi,"SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");
			if (mysqli_num_rows($login)==1) {
				$data = mysqli_fetch_array($login);
				$_SESSION['username'] = $data['username'];
				$_SESSION['password'] = $data['password'];
				$_SESSION['nama'] 		= $data['nama'];
				$_SESSION['nomer_pegawai'] =  $data['nomer_pegawai'];
				$_SESSION['nomerAnggota'] = $data['nomerAnggota'];
				$_SESSION['id_level'] = $data['id_level'];
				$_SESSION['token-login'] = $data['token_login'];

				if ($data['id_level']=="1" || $data['id_level']=="2" ) {
					$_SESSION['login'] = "Login Sukses";
					$_SESSION['login_icon'] = "success";
					echo"<script>document.location='../view/dashboard.php';</script>";
					exit();
				}
				else if ($data['id_level'=="3"]) {
					$_SESSION['login'] = "Login Sukses";
					$_SESSION['login_icon'] = "success";
					echo"<script>document.location='../view/dashboard-user.php';</script>";
					exit();
				// code...
				}
				// code...
			}else{
		
				$_SESSION['login'] = "Username atau Password Salah";
				$_SESSION['login_alert'] = "alert-danger";
				echo"<script>document.location='../index.php';</script>";
				exit();
     
		}

	}
	else if($op=="out"){
        unset($_SESSION['username']);
        unset($_SESSION['level']);
        header("location:index.php");
    }
		// code...
	
	
?>
	