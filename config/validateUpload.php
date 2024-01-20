<?php
function uploadfile(){
	$halaman = substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],"/")+1);
	$namaFile 	= $_FILES['cover']['name'];
	$ukuranFile	= $_FILES['cover']['size'];
	$error		= $_FILES['cover']['error'];
	$tmpName	= $_FILES['cover']['tmp_name'];

	if ($namaFile == null) {
		return false;
	}

	$extensiFileValid = ['jpg','png','jpeg'];
	$extensiFile 		= explode('.', $namaFile);
	$extensiFile 		= strtolower(end($extensiFile));

	if (!in_array($extensiFile, $extensiFileValid)) 
	{
		$_SESSION['failed']='Format file tidak valid';
		$_SESSION['failed_icon']='error';
		header("location:$halaman");
		die();
	}
	if ($ukuranFile > 3000000) 
	{
		$_SESSION['failed']='Maksimal Ukuran gambar 3 MB';
		$_SESSION['failed_icon']='error';
		header("location:$halaman");
		die();
	
	}
	$namafilebaru = uniqid();
	$namafilebaru.= '.';
	$namafilebaru.= $extensiFile;
	$dir ="../asset/cover/";

	move_uploaded_file($tmpName, $dir.$namafilebaru);
	return $namafilebaru;

}

function fotoprofil(){
	$halaman = substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],"/")+1);
	$namaFile 	= $_FILES['foto']['name'];
	$ukuranFile	= $_FILES['foto']['size'];
	$error		= $_FILES['foto']['error'];
	$tmpName	= ($_FILES['foto']['tmp_name']);
	if ($namaFile == null) {
		return false ;
	}
	$extensiFileValid = ['jpg','png','jpeg'];
	$extensiFile 		= explode('.', $namaFile);
	$extensiFile 		= strtolower(end($extensiFile));

	if (!in_array($extensiFile, $extensiFileValid)) 
	{
		$_SESSION['failed']='Extensi file tidak valid';
		$_SESSION['failed_icon']='warning';
		header("location:$halaman");
		die();
	}
	if ($ukuranFile > 3000000) 
	{
		$_SESSION['failed']='Ukuran Maksimal Gambar 3 MB';
		$_SESSION['failed_icon']='warning';
		header("location:$halaman");
		die();
	
	}
	$namafilebaru = uniqid();
	$namafilebaru.= '.';
	$namafilebaru.= $extensiFile;
	$dir = "../asset/foto/";

	move_uploaded_file($tmpName, $dir.$namafilebaru);
	return $namafilebaru;

}