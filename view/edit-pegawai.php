<?php
 require '../template/header.php';
 //sesion 
 if ($_SESSION['id_level'] != '1'){
        die("<script>
          document.location.href = '../index.php';
          </script>");
    }
  require '../template/navbar.php';

    require '../template/sidebar.php';
$nomer_pegawai = $_GET['edit-pegawai'];
$data_pegawai = select("SELECT * FROM tb_staff WHERE nomer_pegawai = '$nomer_pegawai'")[0];
$nomer_pegawai = $data_pegawai['nomer_pegawai'];
$data_user = select("SELECT username FROM tb_user WHERE nomer_pegawai = '$nomer_pegawai'")[0];

if (isset($_POST['edit'])) {
      $result = edit_pegawai($_POST);

         if ($result) {
            $_SESSION['pegawai']= "Data Pegawai Berhasil Diubah";
            echo "<script>
            document.location.href = 'data-pegawai.php';
            </script>
            ";
         }else {
          $_SESSION['failed'] = 'Data pegawai gagal diubah';
          $_SESSION['failed_icon'] = 'error';
          echo "<script>
            document.location.href = 'data-pegawai.php';
            </script>";
            exit();
         }

   }
 if (isset($_POST['editakun'])) {
    $result = edit_akunpegawai($_POST);

       if ($result) {
          $_SESSION['pegawai']= "Data akun pegawai Berhasil Diubah";
          echo "<script>
          document.location.href = 'data-pegawai.php';
          </script>
          ";
       }
 }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Data Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-pegawai.php">Data Pegawai</a></li>
              <li class="breadcrumb-item active">Edit Pegawai</li>
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
                  <?php if (empty($data_pegawai['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $data_pegawai['foto'];?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $data_pegawai['nama']?></h3>

                <p class="text-muted text-center"><?= $data_pegawai['jabatan']?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>NIP | NIK</b>
                    <p class="text-secondary mb-0"><?= $data_pegawai ['nomer_pegawai']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Tempat Lahir</b>
                    <p class="text-secondary mb-0"><?= $data_pegawai ['tempat_lahir']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-calendar"></i> <b>Tanggal Lahir</b>
                    <p class="text-secondary mb-0"><?= $data_pegawai ['tgl_lahir']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $data_pegawai ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $data_pegawai['no_hp']?></p>
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
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#editbiodata" data-toggle="tab">Edit Biodata</a></li>
                  <li class="nav-item"><a class="nav-link" href="#editakun" data-toggle="tab">Edit Akun</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editbiodata">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="inputpegawai" class="col-sm-2 col-form-label">NIP | NIK</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputpegawai" placeholder="NIP/NIK Pegawai" name="nomer_pegawai" value="<?= $data_pegawai['nomer_pegawai']?>" readonly>
                          <input type="hidden" class="form-control" id="inputpegawai" placeholder="NIP/NIK Pegawai" name="username" value="<?= $data_user['username']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama" placeholder="Nama Anggota" name="nama" value="<?= $data_pegawai['nama']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tempatlahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="tempatlahir" placeholder="Tempat Lahir" name="tempat_lahir" value="<?= $data_pegawai['tempat_lahir']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tgllahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="tgllahir" placeholder="Tanggal Lahir" name="tgl_lahir" value="<?= $data_pegawai['tgl_lahir']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="custom-select" name="jenis_kelamin">
                           <option value="Laki-laki" <?php if($data_pegawai['jenis_kelamin'] =='Laki-laki') echo 'selected="selected"'?>>Laki-laki</option>
                           <option value="Perempuan" <?php if ($data_pegawai['jenis_kelamin'] =='Perempuan') echo 'selected="selected"'?>>Perempuan</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputalamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputalamat" placeholder="Alamat" name="alamat" required><?= $data_pegawai['alamat']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnohp" class="col-sm-2 col-form-label">No Hp</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnohp" placeholder="No HP" name="no_hp" value="<?= $data_pegawai['no_hp']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="jabatan" placeholder="No HP" name="jabatan" value="<?= $data_pegawai['jabatan']?>">
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Profil</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFile(this);">
                          <small>Ukuran file max 3 MB (JPG,PNG,JPEG)</small><br>
                          <?php if (empty($data_pegawai['foto'])) { ?>
                            <img src="../asset/dist/img/default_user.jpg" class="img-thumbnail mt-2" width="100px" id="previewImg">
                         <?php } else { ?>
                            <img src="../asset/foto/<?= $data_pegawai['foto'] ?>" class="img-thumbnail mt-2" width="100px" id="previewImg">
                          <?php } ?>
                        </div>
                     </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <a class="btn btn-danger" href="data-pegawai.php">Kembali</a>
                          <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="editakun">
                    <!-- The editakun -->
                    <form class="form-horizontal" method="POST">
                      <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="username" placeholder="Username" name="username" value="<?= $data_user['username']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Ubah Password</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="password" placeholder="Password Baru" name="password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="editakun" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
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