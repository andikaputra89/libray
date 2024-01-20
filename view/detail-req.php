<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$id_req = $_GET['edit'];
$data_req = select("SELECT * FROM tb_reqbuku r LEFT JOIN tb_koleksibuku b ON r.id_buku = b.id_buku LEFT JOIN tb_anggota a ON r.noanggota_req = a.nomorAnggota WHERE id_req = '$id_req'")[0];

$id_status = $data_req ['id_statusanggota'];
$data_status = mysqli_query($koneksi,"SELECT * FROM status_anggota WHERE id_status ='$id_status'");
$data_status= mysqli_fetch_array($data_status);
$status = $data_status['status_anggota'];

$id_rak = $data_req['id_rak'];
$data_rak = mysqli_query($koneksi,"SELECT * FROM tb_rak WHERE id_rak = '$id_rak'");
$data_rak = mysqli_fetch_array($data_rak);
$rak = $data_rak['nama_rak'];

$no = 1; 

$id = $data_req['id_buku'];
$totalBuku = 0;
$total_buku = select("SELECT * FROM tb_buku WHERE id_buku = '$id'");

  foreach ($total_buku as $stok):
      $stokBuku = $stok['stokBuku'];
      $totalBuku += $stokBuku;
  endforeach;
                  
$checkbuku = select("SELECT no_buku FROM tb_buku WHERE id_buku = '$id' AND stokBuku != '0'");
$nomorAnggota = $data_req['nomorAnggota'];
$checkpinjam= select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE nomorAnggota = '$nomorAnggota' AND status_pinjam != 'Dikembalikan'");
?>
<link rel="stylesheet" href="../asset/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Request Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-requestbuku.php">Data Request Buku</a></li>
              <li class="breadcrumb-item active">Detail Request</li>
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
              <div class="card-header">Profil Request Buku</div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php if (empty($data_req['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $data_req['foto']?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $data_req['nama']?></h3>

                <p class="text-muted text-center"><?= $status ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>No Anggota</b>
                    <p class="text-secondary mb-0"><?= $data_req ['nomorAnggota']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $data_req ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $data_req['no_hp']?></p>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="#datareq" data-toggle="tab">Data Request buku</a></li>
                <li class="nav-item"><a class="nav-link" href="#datapinjam" data-toggle="tab">Data Peminjaman</a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="datareq">
                  <div class="card">
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="active tab-pane" id="editbiodata">
                          <form class="form-horizontal" method="POST">
                            <input type="hidden" name="id_req" value="<?= $data_req['id_req']?>" readonly>
                            <input type="hidden" name="nomorAnggota" value="<?= $data_req['nomorAnggota']?>" readonly>
                            <input type="hidden" class="form-control" name="tgl_pinjam" value="<?php echo date('Y-m-d');?>" readonly>
                            <input type="hidden" class="form-control" name="estimasitgl_kembali" value="<?php echo date('Y-m-d',strtotime('+7 days'));?>" readonly>
                            <div class="form-group row">
                              <label for="judul" class="col-sm-2 col-form-label">No Buku</label>
                              <div class="col-sm-10">
                                <select class="form-control select2" style="width: 100%;" name="no_buku">
                                  <option value=""></option>
                                  <?php foreach ($checkbuku as $buku): ?>
                                    <option value="<?= $buku['no_buku'] ?>"><?= $buku['no_buku'] ?></option>
                                  <?php endforeach ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="judul" name="judulBuku" value="<?= $data_req['judulBuku']?>" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="koderak" class="col-sm-2 col-form-label">Kode Rak Buku</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="koderak" name="kode_rak" value="<?= $data_rak['kode_rak']; ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="rakbuku" class="col-sm-2 col-form-label">Nama Rak Buku</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="rakbuku"name="nama_rak" value="<?= $rak; ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="jumlahbuku" class="col-sm-2 col-form-label">Jumlah Buku</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="jumlahbuku" placeholder="Nama Anggota" name="stokBuku" value="<?= $totalBuku ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10">
                                <a class="btn btn-danger" href="data-requestbuku.php">Kembali</a>
                                <button type="submit" name="konfirmasipeminjaman" class="btn btn-primary">Konfirmasi</button>
                        
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
                <div class="tab-pane" id="datapinjam">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-hover" id="tablepinjam">
                            <thead>
                               <tr>
                                  <th>No Buku</th>
                                  <th>Judul Buku</th>
                                  <th>Tgl Pinjam</th>
                                  <th>Estimasi tgl kembali</th>
                                  <th>Status pinjam</th>
                               </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($checkpinjam as $pinjam): ?>
                                <tr>
                                  <td><?= $pinjam['no_buku'];?></td>
                                  <td><?= $pinjam['judulBuku'];?></td>
                                  <td><?= $pinjam['tgl_pinjam'];?></td>
                                  <td><?= $pinjam['estimasi_tglkembali'];?></td>
                                  <td><?= $pinjam['status_pinjam'];?></td>
                                </tr>
                              <?php endforeach ?>
                           </tbody>
                         </table>
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>
          </div>
          <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <script src="../asset/plugins/select2/js/select2.full.min.js"></script>
  <script type="text/javascript">
    $(function () {
    $('.select2').select2({
    theme: 'bootstrap4',
    placeholder: "Pilih No Buku"

    })
      
    
    })
  </script>
<?php
  if (isset($_POST['konfirmasipeminjaman'])) {
    $result = konfirmasiRequest($_POST);
    if ($result) {
      $_SESSION['peminjam']='Data Peminjam Berhasil Ditambahkan';
      echo "<script>
                document.location.href = 'data-peminjaman.php';
                </script>
                ";
    }else{
      $_SESSION['failed'] ='Data Peminjam gagal ditambahkan';
      $_SESSION['failed_icon'] ='error';
      echo "<script>
          document.location.href = 'data-requestbuku.php';
          </script>
          ";
    }
  }
      require '../template/footer.php';
      require '../template/script.php';

?>