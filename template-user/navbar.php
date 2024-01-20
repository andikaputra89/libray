<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto"> 
      <li class="nav-item dropdown">
        <a class="nav-link user-panel" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $anggota['nama']?>
            <?php if (empty($anggota['foto'])) { ?>
              <img class="img-circle elevation-2 "
                src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture" >
            <?php } else { ?>
              <img class="img-circle elevation-2 "
                src="../asset/foto/<?= $anggota['foto']?>"
                       alt="User profile picture" >
           <?php } ?>
            
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="">&nbsp<strong><?= $anggota['nama']?></strong></a>
            <a class="dropdown-item" href="biodata-user.php">
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