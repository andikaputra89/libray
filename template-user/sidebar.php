<?php
  $page = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
  $no_anggota = $_SESSION['nomerAnggota'];
  $jumlahreq = mysqli_query($koneksi,"SELECT * FROM tb_reqbuku WHERE noanggota_req = '$no_anggota' AND status_req = 'Belum Dikonfirmasi'");
  $jumlahreq = mysqli_num_rows($jumlahreq);
  $jumlahpeminjaman = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman WHERE nomorAnggota ='$no_anggota' AND status_pinjam = 'Belum dikembalikan'");
  $jumlahpeminjaman = mysqli_num_rows($jumlahpeminjaman);

  $jumlahpinjambukupaket = mysqli_query($koneksi,"SELECT * FROM tb_pinjambukupaket WHERE nomor_anggota ='$no_anggota' AND status_pinjam = 'Belum dikembalikan'");
  $jumlahpinjambukupaket = mysqli_num_rows($jumlahpinjambukupaket);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <style type="text/css">
    .brand-text{
      font-size: 0.8rem !important;
    }
    .info{
      font-size: 0.9rem !important;
    }
  </style>
    <!-- Brand Logo -->
    <a href="dashboard-user.php" class="brand-link">
      <img src="../asset/dist/img/logo.png" alt="logo sma" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PERPUSTAKAAN SMA N 1 TEJAKULA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if (empty($anggota['foto'])) { ?>
              <img class="img-circle elevation-2"
                 src="../asset/dist/img/default_user.jpg"
                 alt="User profile picture">
            <?php } else { ?>
                  <img class="img-circle elevation-2" src="../asset/foto/<?= $anggota['foto']?>">
            <?php } ?>
        </div>
        <div class="info">
          <a href="biodata-user.php" class="d-block"><?= $anggota['nama']?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard-user.php" class="nav-link <?= $page=='dashboard-user.php' ? 'active':''?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="katalogbuku.php" class="nav-link <?= $page=='katalogbuku.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-book"></i>
              <p>
                Katalog Buku
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayatrequest.php" class="nav-link <?= $page=='riwayatrequest.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-bookmark"></i>
              <p>
                Riwayat Request Buku
              </p>
              <span class="badge badge-info right"><?= $jumlahreq ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayatpeminjaman.php" class="nav-link <?= $page=='riwayatpeminjaman.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-book-bookmark"></i>
              <p>
                Riwayat Peminjaman
              </p>
              <span class="badge badge-danger right"><?= $jumlahpeminjaman + $jumlahpinjambukupaket ?></span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>