<?php
include 'koneksi.php';
	session_start();
	$username = $_SESSION['username'];
	$logout = mysqli_query($koneksi,"UPDATE tb_user SET token_login='0' WHERE username='$username'");
	if ($logout) {
		session_destroy();
		header("location:../index.php");

	}
	

	

?>