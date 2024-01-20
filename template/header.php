<?php
ob_start();
session_start();
if(!isset($_SESSION['username'])){
  $_SESSION['login'] = "Anda Harus Login terlebih dahulu";
  $_SESSION['login_alert'] = "alert-danger";
  echo"<script>document.location='../index.php';</script>";   
  die();
}
if($_SESSION['id_level'] == '3'){
  die("<script>
          document.location.href = '../index.php';
          </script>");
}
include '../config/app.php';
$data_peg =mysqli_query($koneksi, "SELECT * FROM tb_staff WHERE nomer_pegawai='$_SESSION[nomer_pegawai]'");
$peg   =mysqli_fetch_array($data_peg);

$data_request = select("SELECT * FROM tb_reqbuku LEFT JOIN tb_anggota ON tb_reqbuku.noanggota_req = tb_anggota.nomorAnggota WHERE status_req ='Belum Dikonfirmasi' LIMIT 5");
$datareq = select("SELECT tgl_exp FROM tb_reqbuku");
date_default_timezone_set('Asia/Ujung_Pandang');
$waktusekarang = date('Y-m-d H:i:s');

foreach ($datareq as $req ) {
  $tgl_exp = $req['tgl_exp'];
  if ($tgl_exp <= $waktusekarang) {
    mysqli_query($koneksi,"UPDATE tb_reqbuku SET status_req = 'Dibatalkan' WHERE tgl_exp = '$tgl_exp'");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Perpustakaan SMA N 1 Tejakula</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../asset/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../asset/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../asset/dist/css/bootstrap-multiselect.css">
  <link rel="stylesheet" href="../asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  
  <script src="../asset/plugins/jquery/jquery.min.js"></script>
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">