<?php
 session_start();
 if (!empty($_SESSION['username'])) {
     if (@$_SESSION['token-login']=="1") {
        if (@$_SESSION['id_level']=="1" || @$_SESSION['id_level']=="2") {
          echo"<script>document.location='view/dashboard.php';</script>";
        } else if (@$_SESSION['id_level']=="3"){
          echo"<script>document.location='view/dashboard-user.php';</script>";
        }
     }else{
        echo"<script>document.location='index.php';</script>";
        exit();
     }

 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset/plugins/fontawesome/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <img style="width : 90px" src="asset/dist/img/logo.png"><br>
        <a href="index.php" class="h5"><strong>SISTEM INFORMASI PERPUSTAKAAN <br>SMA N 1 TEJAKULA</strong></a>
      </div>
      <div class="card-body">
        <?php
          if(isset($_SESSION['login'])): ?>
          <div class="alert <?=$_SESSION['login_alert'];?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['login']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php 
        unset($_SESSION['login']);
        endif;
        ?>
        <form action="config/proses_login.php?op=in" method="post" class="needs-validation" novalidate>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Masukan Username" name="username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fa-solid fa-user"></i>
              </div>
            </div>
            <div class="invalid-feedback">
              Masukan Username
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Masukan Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              Masukan Password
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
              <a href="asset/import/Panduan.pdf" class="d-flex justify-content-center mt-2" target="_blank">Panduan Penggunaan Sistem</a>
            </div>
              
           
          </div>
        </form>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="asset/dist/js/adminlte.min.js"></script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>
