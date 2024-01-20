<?php
 require '../template-user/header.php';

  require '../template-user/navbar.php';

    require '../template-user/sidebar.php';

if (isset($_POST['edit'])) {
      $result = updatebiodatauser($_POST);

         if ($result) {
            $_SESSION['succes']='Biodata berhasil diperbahurui';
             $_SESSION['succes_icon']='success';
            echo "<script>document.location.href = 'biodata-user.php';
            </script>
            ";
            exit();
         }else{
            $_SESSION['succes']='Biodata gagal diperbahurui';
             $_SESSION['succes_icon']='error';
            echo "<script>document.location.href = 'biodata-user.php';
            </script>
            ";
            exit();
         }

   }
 if (isset($_POST['updatepassword'])) {
    $result = update_passwordA($_POST);
       if ($result) {
           $_SESSION['succes']='Password berhasil diperbahurui';
             $_SESSION['succes_icon']='success';
            echo "<script>document.location.href = 'biodata-user.php';
            </script>
            ";
            exit();
       } else {
          $_SESSION['succes']='Password gagal diperbahurui';
             $_SESSION['succes_icon']='error';
            echo "<script>document.location.href = 'biodata-user.php';
            </script>
            ";
            exit();
       }
 }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Biodata</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard-user.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Biodata</li>
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
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">Biodata</a></li>
                  <li class="nav-item"><a class="nav-link" href="#editbiodata" data-toggle="tab">Edit Biodata</a></li>
                  <li class="nav-item"><a class="nav-link" href="#editakun" data-toggle="tab">Edit Akun</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="biodata">
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
                  </div>
                  <div class="tab-pane" id="editbiodata">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="inputnoanggota" class="col-sm-2 col-form-label">No Anggota</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputnoanggota" placeholder="No Anggota" name="nomorAnggota" value="<?= $anggota['nomorAnggota']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnama" placeholder="Nama Anggota" name="nama" value="<?= $anggota['nama']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="custom-select" name="jenis_kelamin">
                           <option value="Laki-laki" <?php if($anggota['jenis_kelamin'] =='Laki-laki') echo 'selected="selected"'?>>Laki-laki</option>
                           <option value="Perempuan" <?php if ($anggota['jenis_kelamin'] =='Perempuan') echo 'selected="selected"'?>>Perempuan</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputalamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputalamat" placeholder="Alamat" name="alamat" required><?= $anggota['alamat']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputnohp" class="col-sm-2 col-form-label">No Hp</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputnohp" placeholder="No HP" name="no_hp" value="<?= $anggota['no_hp']?>">
                        </div>
                      </div>
                      <input type="hidden" name="status" value="<?= $status['status_anggota'] ?>">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Profil</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFile(this);">
                          <small>Ukuran file max 3 MB (JPG,PNG,JPEG)</small><br>
                          <?php if (empty($anggota['foto'])) { ?>
                            <img src="../asset/dist/img/default_user.jpg" class="img-thumbnail mt-2" width="100px" id="previewImg">
                         <?php } else { ?>
                            <img src="../asset/foto/<?= $anggota['foto'] ?>" class="img-thumbnail mt-2" width="100px" id="previewImg">
                          <?php } ?>
                        </div>
                     </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <a class="btn btn-danger" href="dashboard-user.php">Kembali</a>
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
                          <input type="number" class="form-control" id="username" placeholder="Username" name="username" value="<?= $anggota['nomorAnggota']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="passwordlama" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="passwordlama" placeholder="Password lama" name="password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password" placeholder="Password Baru" name="password1" minlength="5" maxlength="10">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password" placeholder=" Konfirmasi Password Baru" name="password2" minlength="5" maxlength="10">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="updatepassword" class="btn btn-danger">Simpan Perubahan</button>
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
  <script type="text/javascript">
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
  <?php if(isset($_SESSION['succes']) && $_SESSION['succes'] !='') : ?>
    <script type="text/javascript">
        $(function() {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000
        });

          Toast.fire({
            icon: '<?= $_SESSION['succes_icon']; ?>',
            title: '<?= $_SESSION['succes']; ?>'
          })
    });
  </script>
<?php 
unset($_SESSION['succes']);
endif; ?>
<?php
      require '../template-user/footer.php';
      require '../template-user/script.php';

?>