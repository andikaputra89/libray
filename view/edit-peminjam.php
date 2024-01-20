<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$id_pinjam = $_GET['editpinjam'];
$sql = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_rak r ON kb.id_rak = r.id_rak JOIN status_anggota s ON s.id_status = a.id_statusanggota WHERE p.id_pinjam='$id_pinjam'");
$data_peminjaman = mysqli_fetch_array($sql);
/*$id_status = $data_peminjaman ['id_statusanggota'];
$data_status = mysqli_query($koneksi,"SELECT * FROM status_anggota WHERE id_status ='$id_status'");
$data_status= mysqli_fetch_array($data_status);
$status = $data_status['status_anggota'];

$id_rak = $data_peminjaman['id_rak'];
$data_rak = mysqli_query($koneksi,"SELECT * FROM tb_rak WHERE id_rak = '$id_rak'");
$data_rak = mysqli_fetch_array($data_rak);
$rak = $data_rak['nama_rak'];*/
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data peminjaman Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-peminjaman.php">Data Peminjaman</a></li>
              <li class="breadcrumb-item active">Detail Peminjam</li>
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
                  <?php if (empty($data_peminjaman['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $data_peminjaman['foto']?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $data_peminjaman['nama']?></h3>

                <p class="text-muted text-center"><?= $data_peminjaman ['status_anggota'];?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>No Anggota</b>
                    <p class="text-secondary mb-0"><?= $data_peminjaman ['nomorAnggota']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $data_peminjaman ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $data_peminjaman['no_hp']?></p>
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
                    <form class="form-horizontal" method="POST">
                      <div class="form-group row">
                        <input type="hidden" name="id_pinjam" value="<?= $data_peminjaman['id_pinjam']?>">
                        <input type="hidden" name="id_buku" value="<?= $data_peminjaman['id_buku']?>">
                        <label class="col-sm-2 col-form-label">No Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control"placeholder="No Buku" name="no_buku" value="<?= $data_peminjaman['no_buku']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Judul Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama" name="judulBuku" value="<?= $data_peminjaman['judulBuku']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Rak Buku</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama"name="nama_rak" value="<?= $data_peminjaman ['nama_rak']; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tglpinjam" class="col-sm-2 col-form-label">Tanggal Pinjam</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="tglpinjam" name="tgl_pinjam" value="<?= $data_peminjaman['tgl_pinjam']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="estimasi_tglkembali" class="col-sm-2 col-form-label">Estimasi Tgl Kembali</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="estimasi_tglkembali" name="estimasi_tglkembali" value="<?= $data_peminjaman['estimasi_tglkembali']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tgl_kembali" class="col-sm-2 col-form-label">Tgl Kembali</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="denda" class="col-sm-2 col-form-label">Terlambat Pinjam</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="terlambat"readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="denda" class="col-sm-2 col-form-label">Denda</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="denda"readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="status_pinjam" class="col-sm-2 col-form-label">Status Pinjam</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="status_pinjam" name="status_pinjam" value="<?= $data_peminjaman['status_pinjam']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="status_pinjam" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="status_pinjam" placeholder="keterangan pengembalian" name="keterangan" >
                          <!--<small><em>kosongkan jika tidak perlu</em></small>-->
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <a class="btn btn-danger" href="data-peminjaman.php">Kembali</a>
                          <button type="submit" name="kembali" class="btn btn-primary">Konfirmasi Pengembalian</button>
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
  <script type="text/javascript">
    $(document).ready(function(){
      var tanggalpinjam = $('#tglpinjam').val();
      var tanggalkembali = $('#tgl_kembali').val();

      const pinjam = new Date(tanggalpinjam);
      const kembali = new Date(tanggalkembali);
      const time = Math.abs(kembali - pinjam);
      const days = Math.ceil(time/(1000*60*60*24));
      var terlambat = 0 ;
      var denda = 0 ;
      if (days > 7) {
        terlambat = days - 7;
        denda = 500 * terlambat;

      }else{
        terlambat = 0;
        denda = 0;
      }
      $('#terlambat').val(terlambat);
      $('#denda').val(denda);

    })
  </script>
<?php
if (isset($_POST['kembali'])){
      $result = kembalibuku($_POST);
      if ($result) {
      $_SESSION['peminjam']= "Buku berhasil dikembalikan";
            echo "<script>
                document.location.href = 'data-pengembalian.php';
                </script>
                ";
      }

    }
      require '../template/footer.php';
      require '../template/script.php';

?>