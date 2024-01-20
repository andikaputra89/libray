<?php
  $page = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <style type="text/css">
    .brand-text{
      font-size: 0.8rem !important;
    }
    .info{
      font-size: 0.8rem !important;
    }
  </style>
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../asset/dist/img/logo.png" alt="Logo SMA" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PERPUSTAKAAN SMA N 1 TEJAKULA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if (empty($peg['foto'])) { ?>
              <img class="img-circle elevation-2"
                 src="../asset/dist/img/default_user.jpg"
                 alt="User profile picture">
            <?php } else { ?>
                  <img class="img-circle elevation-2" src="../asset/foto/<?= $peg['foto']?>">
            <?php } ?>
        </div>
        <div class="info">
          <a href="biodata-peg.php" class="d-block"><?= $peg['nama']?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $page=='dashboard.php' ? 'active':''?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item <?= $page=='data-buku.php' || $page=='data-rak.php' || $page=='data-kategori.php'? 'menu-open':''?>">
            <a href="#" class="nav-link <?= $page=='data-buku.php' || $page=='data-rak.php' || $page=='data-kategori.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-book-open"></i>
              <p>
                Buku
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="data-buku.php" class="nav-link <?= $page=='data-buku.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Buku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="data-rak.php" class="nav-link <?= $page=='data-rak.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Rak Buku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="data-kategori.php" class="nav-link <?= $page=='data-kategori.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kategori Buku</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="data-anggota.php" class="nav-link <?= $page=='data-anggota.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-people-group"></i>
              <p>
                Anggota
              </p>
            </a>
          </li>
          <?php if ($_SESSION['id_level']=='1') : ?>
          <li class="nav-item">
            <a href="data-pegawai.php" class="nav-link <?= $page=='data-pegawai.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-user-tie"></i>
              <p>
                Pegawai
              </p>
            </a>
          </li>
        <?php endif; ?>
          <li class="nav-header">Transaksi</li>
          <?php if ($_SESSION['id_level']=='2') : ?>
          <li class="nav-item">
            <a href="data-requestbuku.php" class="nav-link <?= $page=='data-requestbuku.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-bookmark"></i>
              <p>
                Request Buku
                <span class="badge badge-info right"><?= totalrequest() ?></span>
              </p>
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-item <?= $page=='data-peminjaman.php' || $page=='data-pinjambukupaket.php'? 'menu-open':''?>">
            <a href="#" class="nav-link <?= $page=='data-peminjaman.php' || $page=='data-pinjambukupaket.php' ? 'active':''?>">
              <i class="nav-icon fa-solid fa-book-bookmark"></i>
              <p>
                Peminjaman
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="data-peminjaman.php" class="nav-link <?= $page=='data-peminjaman.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Bacaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="data-pinjambukupaket.php" class="nav-link <?= $page=='data-pinjambukupaket.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Paket</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?= $page=='data-pengembalian.php' || $page=='pengembalian-bukupaket.php'? 'menu-open':''?>">
            <a href="#" class="nav-link <?= $page=='data-pengembalian.php' || $page=='pengembalian-bukupaket.php' ? 'active':''?>">
              <i class=" nav-icon fa-solid fa-file-import mb-1"></i>
              <p>
                Pengembalian
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="data-pengembalian.php" class="nav-link <?= $page=='data-pengembalian.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Bacaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pengembalian-bukupaket.php" class="nav-link <?= $page=='pengembalian-bukupaket.php' ? 'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Paket</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if ($_SESSION['id_level']=='1'): ?>
          <li class="nav-header">Laporan</li>
          <li class="nav-item">
            <a href="laporan.php" class="nav-link">
              <i class="nav-icon fa-solid fa-file"></i>
              <p>Laporan</p>
            </a>
          </li>
        <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>