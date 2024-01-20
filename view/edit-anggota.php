<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$nomorAnggota = $_GET['edit'];
$data_anggota = select("SELECT * FROM tb_anggota LEFT JOIN status_anggota ON tb_anggota.id_statusanggota = status_anggota.id_status WHERE nomorAnggota = '$nomorAnggota'")[0];
$status_anggota = select("SELECT * FROM status_anggota");

if (isset($_POST['edit'])) {
      $result = edit_anggota($_POST);

         if ($result) {
            $_SESSION['anggota']= "Data Anggota Berhasil Diubah";
            echo "<script>
            document.location.href = 'data-anggota.php';
            </script>
            ";
         }

   }
   if (isset($_POST['editakun'])) {
      $result = edit_akunanggota($_POST);

         if ($result) {
            $_SESSION['anggota']= "Data Akun Anggota Berhasil Diubah";
            echo "<script>
            document.location.href = 'data-anggota.php';
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
            <h1>Edit Data Anggota</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-anggota.php">Data Anggota</a></li>
              <li class="breadcrumb-item active">Edit Anggota</li>
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
                  <?php if (empty($data_anggota['foto'])) { ?>
                    <img class="profile-user-img img-fluid img-circle"
                       src="../asset/dist/img/default_user.jpg"
                       alt="User profile picture">
                  <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle" src="../asset/foto/<?= $data_anggota['foto']?>">
                  <?php } ?>
                </div>

                <h3 class="profile-username text-center"><?= $data_anggota['nama']?></h3>

                <p class="text-muted text-center"><?= $data_anggota['status_anggota']?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <i class="fas fa-id-card"></i> <b>No Anggota</b>
                    <p class="text-secondary mb-0"><?= $data_anggota ['nomorAnggota']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-location-dot"></i> <b>Alamat</b>
                    <p class="text-secondary mb-0"><?= $data_anggota ['alamat']?></p>
                  </li>
                  <li class="list-group-item">
                    <i class="fa-solid fa-phone"></i> <b>No HP</b>
                    <p class="text-secondary mb-0"><?= $data_anggota['no_hp']?></p>
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
                        <label for="inputnoanggota" class="col-sm-2 col-form-label">No Anggota</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputnoanggota" placeholder="No Anggota" name="nomorAnggota" value="<?= $data_anggota['nomorAnggota']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama" placeholder="Nama Anggota" name="nama" value="<?= $data_anggota['nama']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="custom-select" name="jenis_kelamin">
                           <option value="Laki-laki" <?php if($data_anggota['jenis_kelamin'] =='Laki-laki') echo 'selected="selected"'?>>Laki-laki</option>
                           <option value="Perempuan" <?php if ($data_anggota['jenis_kelamin'] =='Perempuan') echo 'selected="selected"'?>>Perempuan</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputalamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputalamat" placeholder="Alamat" name="alamat" required><?= $data_anggota['alamat']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnohp" class="col-sm-2 col-form-label">No Hp</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnohp" placeholder="No HP" name="no_hp" value="<?= $data_anggota['no_hp']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="statusanggota" class="col-sm-2 col-form-label">Status Anggota</label>
                        <div class="col-sm-10">
                          <select class="custom-select" name="status">
                          <?php foreach ($status_anggota as $status): ?>
                             <option value="<?php echo $status['status_anggota'];?>"<?php if($data_anggota['status_anggota'] == $status['status_anggota'])echo 'selected="selected"';?>><?php echo $status['status_anggota'];?></option>
                          <?php endforeach ?> 
                          </select> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Profil</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFile(this);">
                          <small>Ukuran file max 3 MB (JPG,PNG,JPEG)</small><br>
                          <?php if (empty($data_anggota['foto'])) { ?>
                            <img src="../asset/dist/img/default_user.jpg" class="img-thumbnail mt-2" width="100px" id="previewImg">
                         <?php } else { ?>
                            <img src="../asset/foto/<?= $data_anggota['foto'] ?>" class="img-thumbnail mt-2" width="100px" id="previewImg">
                          <?php } ?>
                        </div>
                     </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <a class="btn btn-danger" href="data-anggota.php">Kembali</a>
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
                          <input type="number" class="form-control" id="username" placeholder="Username" name="username" value="<?= $data_anggota['nomorAnggota']?>" readonly>
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
  <script>

   function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
</script>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>