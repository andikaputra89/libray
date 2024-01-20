<?php
 require '../template-user/header.php';

  require '../template-user/navbar.php';

    require '../template-user/sidebar.php';
/*$nomoranggota = $_SESSION['nomerAnggota'];     
$reminder = mysqli_query($koneksi,"SELECT tgl_pinjam,estimasi_tglkembali FROM tb_peminjaman WHERE nomoranggota_peminjam ='$nomoranggota' AND status_pinjam ='Belum dikembalikan'");
$result = mysqli_fetch_array($reminder);

$tgl_pinjam = $result['tgl_pinjam'];
$estimasitgl_kembali = $result['estimasi_tglkembali'];
$pinjam

$kembali = strtotime
$lama_pinjam = $kembali - $pinjam;
$hari = $lama_pinjam/60/60/24;*/
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
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
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php if (empty($anggota['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $anggota['foto']?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $anggota['nama']?></h3>

                <p class="text-muted text-center"><?= $status['status_anggota']?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>No Anggota</b>
                    <p class="text-secondary mb-0"><?= $anggota ['nomorAnggota']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $anggota ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $anggota['no_hp']?></p>
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
                <p>Biodata</p>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table>
                  <tr>
                    <table class="table table-hover table-borderless">
                            <tbody>
                                <tr>
                                    <td width="200px">Nomor Anggota</td>
                                    <td><?php echo $anggota['nomorAnggota'];?></td>
                                </tr>
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td><?php echo $anggota['nama'];?></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td><?php echo $anggota['jenis_kelamin'];?></td>
                                </tr>
                                <tr>
                                    <td>No Handphone</td>
                                    <td><?php echo $anggota['no_hp'];?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><?php echo $anggota['alamat'];?></td>
                                </tr>
                                <tr>
                                    <td>Status Anggota</td>
                                    <td><?php echo $status['status_anggota']?></td>
                                </tr>
                            </tbody>
                        </table>
                  </tr>
                </table>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
<div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Warning Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-outline-dark">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#modal-warning1").modal('show');
  });
</script>
<?php
      require '../template-user/footer.php';
      require '../template-user/script.php';

?>