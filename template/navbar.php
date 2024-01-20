<?php
  include '../config/total_data.php';
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- Notifications Dropdown Menu -->
      <?php if ($_SESSION['id_level'] == "2") : ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?= totalrequest()?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <?php  if (totalrequest() == 0): ?>
              <div class="dropdown-divider"></div>
              <p class="dropdown-item text-center">
              Tidak Ada Notifikasi</p>
            <?php endif; ?>
          <?php foreach ($data_request as $request): ?>
            <div class="dropdown-divider"></div>
            <a href="data-requestbuku.php" class="dropdown-item">
              <i class="fas fa-bell mr-2"></i><?php echo $request['nama'];?> Request Buku
            </a>
            
          <?php endforeach ?>
          <?php if (totalrequest() != 0 AND totalrequest()>='5') { ?>
            <div class="dropdown-divider"></div>
            <a href="data-requestbuku.php" class="dropdown-item dropdown-footer">Lihat data request</a>
          <?php } ?>
          
        </div>
      </li>
    <?php endif; ?>
      <li class="nav-item dropdown">
        <a class="nav-link user-panel" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if (empty($peg['foto'])) { ?>
              <img class="img-circle elevation-2 "
                src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture" >
            <?php } else { ?>
              <img class="img-circle elevation-2 "
                src="../asset/foto/<?= $peg['foto']?>"
                       alt="User profile picture" >
           <?php } ?>
            
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="">&nbsp<strong><?= $peg['nama']?></strong></a>
            <a class="dropdown-item" href="biodata-peg.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../config/logout.php">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>
      
    </ul>
  </nav>