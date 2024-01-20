<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$id_pinjam = $_GET['detail'];
$sql = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_rak r ON kb.id_rak = r.id_rak JOIN status_anggota s ON s.id_status = a.id_statusanggota WHERE p.id_pinjam='$id_pinjam'");
$data_pengembalian = mysqli_fetch_array($sql);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pengembalian Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-pengembalian.php">Data Pengembalian</a></li>
              <li class="breadcrumb-item active">Detail Pengembalian</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-header">Profil Peminjam Buku</div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php if (empty($data_pengembalian['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $data_pengembalian['foto']?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $data_pengembalian['nama']?></h3>

                <p class="text-muted text-center"><?= $data_pengembalian['status_anggota'] ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>No Anggota</b>
                    <p class="text-secondary mb-0"><?= $data_pengembalian ['nomorAnggota']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $data_pengembalian ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $data_pengembalian['no_hp']?></p>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                Data Buku Dipinjam
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editbiodata">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="No Buku" name="no_buku" value="<?= $data_pengembalian['no_buku']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnama" class="col-sm-2 col-form-label">Judul Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama" name="nama" value="<?= $data_pengembalian['judulBuku']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnama" class="col-sm-2 col-form-label">Nama Rak Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama"name="nama" value="<?= $data_pengembalian['nama_rak']; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tglpinjam" class="col-sm-2 col-form-label">Tanggal Pinjam</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="tglpinjam" name="tgl_pinjam" value="<?= $data_pengembalian['tgl_pinjam']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tgl_kembali" class="col-sm-2 col-form-label">Tgl Kembali</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="<?= $data_pengembalian['tgl_kembali']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="telat_pinjam" class="col-sm-2 col-form-label">Telat Pinjam</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="telat_pinjam" name="telat_pinjam" value="<?= $data_pengembalian['telat_pinjam']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="telat_pinjam" class="col-sm-2 col-form-label">Denda</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="telat_pinjam" name="telat_pinjam" value="<?= $data_pengembalian['denda']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="status_pinjam" class="col-sm-2 col-form-label">Status Pinjam</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="status_pinjam" name="status_pinjam" value="<?= $data_pengembalian['status_pinjam']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="status_pinjam" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="status_pinjam" name="status_pinjam" value="<?= $data_pengembalian['keterangan']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <a class="btn btn-danger" href="data-pengembalian.php">Kembali</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
  </div>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>