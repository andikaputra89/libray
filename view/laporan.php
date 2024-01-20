<?php
 require '../template/header.php';
if ($_SESSION['id_level'] != '1'){
        die("<script>
          document.location.href = '../index.php';
          </script>");
    }
  require '../template/navbar.php';

    require '../template/sidebar.php';
  $status_anggota = select("SELECT * FROM status_anggota");
  $data_kategori = select("SELECT * FROM tb_kategori"); 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Laporan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p>Laporan Buku</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a id="peminjaman" data-toggle="modal" data-target="#buku" class="small-box-footer">Downloads <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <p>Laporan Anggota</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people"></i>
              </div>
              <a id="peminjaman" data-toggle="modal" data-target="#status" class="small-box-footer">Downloads <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>       
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <p>Peminjaman</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-bookmarks"></i>
              </div>
              <a id="peminjaman" data-toggle="modal" data-target="#pinjam" class="small-box-footer">Downloads <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <p>Pengembalian</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-bookmarks-outline"></i>
              </div>
               <a id="peminjaman" data-toggle="modal" data-target="#kembali" class="small-box-footer">Downloads <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
        </div>
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="buku">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../laporan/laporanbuku.php" method="POST" target="_blank">
                <label class="col-form-label">Pilih Kategori Buku</label>
                <select class="custom-select" name="kategori">
                  <option value="semua" >Cetak Semua</option>
                  <?php foreach ($data_kategori as $kategori) { ?>
                    <option value="<?= $kategori['id_kategori']?>" ><?= $kategori['nama_kategori']?></option>
                 <?php } ?>
                </select>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
   <div class="modal fade" id="pinjam">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Periode Tanggal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../laporan/laporan-peminjaman.php" method="POST" target="_blank">
                <label class="col-form-label">Dari Tanggal</label>
                <input type="date" class="form-control" name="start" value="<?php echo date('Y-m-d') ?>">
                <label>Sampai Tanggal</label>
                <input type="date" class="form-control" name="end" value="<?php echo date('Y-m-d')?>">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="status">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Status Anggota</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../laporan/laporan-anggota.php" method="POST" target="_blank">
                <label class="col-form-label">Pilih Status Anggota</label>
                <select class="custom-select" name="status">
                  <option value="semua" >Cetak Semua</option>
                  <?php foreach ($status_anggota as $status) { ?>
                    <option value="<?= $status['id_status']?>" ><?= $status['status_anggota']?></option>
                 <?php } ?>
                </select>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="kembali">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Periode Tanggal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../laporan/laporan-pengembalian.php" method="POST" target="_blank">
                <label class="col-form-label">Dari Tanggal</label>
                <input type="date" class="form-control" name="start" value="<?php echo date('Y-m-d') ?>">
                <label>Sampai Tanggal</label>
                <input type="date" class="form-control" name="end" value="<?php echo date('Y-m-d')?>">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  <?php
      require '../template/footer.php';
      require '../template/script.php';

?>