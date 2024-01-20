<?php
  include '../config/app.php';
  ob_start();
  session_start();
  if(!isset($_SESSION['username'])){
  $_SESSION['login'] = "Anda Harus Login terlebih dahulu";
  $_SESSION['login_alert'] = "alert-danger";
  echo"<script>document.location='../index.php';</script>";   
  die();
  }
  if($_SESSION['id_level'] != '3'){
  die("<script>
          document.location.href = '../index.php';
          </script>");
}
  $data_anggota =mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE nomorAnggota='$_SESSION[nomerAnggota]'");
  $anggota      = mysqli_fetch_array($data_anggota);
  $id_status    = $anggota['id_statusanggota'];   
  $data_status  = mysqli_query($koneksi,"SELECT * FROM status_anggota WHERE id_status ='$id_status'");
  $status       = mysqli_fetch_array($data_status);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Perpustakaan SMA N 1 Tejakula</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../asset/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../asset/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../asset/plugins/toastr/toastr.min.css">
  <script src="../asset/plugins/jquery/jquery.min.js"></script>
  <script src="../asset/plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">