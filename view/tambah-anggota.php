<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    if (isset($_POST['simpan'])) {
    
        $result = tambah_anggota($_POST);
        if ($result) {
            $_SESSION['anggota']= "Data Anggota Berhasil Ditambahkan";
            echo "<script>
                document.location.href = 'data-anggota.php';
                </script>
                ";
        }

    }

    $status_anggota = select("SELECT status_anggota FROM status_anggota")

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Anggota</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-anggota.php">Data Anggota</a></li>
              <li class="breadcrumb-item active">Tambah Anggota</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="card">    
          <h5 class="card-header">Form tambah Anggota</h5>
          <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                  <form action="" method="POST" enctype="multipart/form-data">
                     <div class="mb-1">
                        <label class="form-label">No Anggota</label>
                        <input type="text" class="form-control" name="nomorAnggota" placeholder="Masukan NIS/NIP/NIK" id="nomoranggota" required>
                        <span id="pesan"></span>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Anggota" required>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="custom-select" name="jenis_kelamin">
                           <option value="Laki-laki">Laki-laki</option>
                           <option value="Perempuan">Perempuan</option>
                        </select>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">No Handphone</label>
                        <input type="tel" pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$" class="form-control" name="no_hp" placeholder="Masukan No Handphone" required>
                     </div>
                     
                     <div class="mb-1">
                        <label class="form-label">Status Anggota</label>
                        <select class="custom-select" name="status">
                           <?php foreach ($status_anggota as $status): ?>
                               <option value="<?php echo $status['status_anggota'];?>"><?php echo $status['status_anggota'];?></option>
                            <?php endforeach ?>
                        </select>
                     </div>
                  <div class="mb-1">
                     <label class="form-label">Alamat</label>
                     <textarea class="form-control" name="alamat" placeholder="Masukan Alamat" style="height: 100px"></textarea>
                  </div>
               </div>
               <div class="col-md-6">
                  
                  <div class="mb-1">
                      <label class="form-label mb-0">Foto Profil</label><br>
                      <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFile(this);">
                      <small>Ukuran file max 3 MB (JPG,PNG,JPEG)</small><br>
                      <img src="../asset/dist/img/default_user.jpg" class="img-thumbnail mt-2" width="100px" id="previewImg">
                   </div>
                  <div class="mb-1">
                     <label class="form-label">Username</label>
                     <input type="text" class="form-control" name="username" id="Username" placeholder="Masukan Username" readonly>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Password</label>
                     <input type="text" class="form-control" name="password" placeholder="Masukan Password" required>
                  </div> 
               </div>
            </div>
            <button type="submit" name="simpan" id="simpananggota" disabled class="btn btn-primary float-right m-3">
            Simpan 
            </button>
            <a href="data-anggota.php" class="btn btn-danger float-right mt-3">Kembali</a>
            </form>
         </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <script>
$(document).on('keyup',function(){
        var nomorAnggota = $("#nomoranggota").val();
        $("#Username").val(nomorAnggota);
    })

$(document).on("keyup", "#nomoranggota", function(){
    var nomorAnggota = $('#nomoranggota').val();
    $.ajax({
        url     :'../config/ajaxConfig.php',
        method  :'POST',
        data    : {
            "checknoanggota": 1,
            "nomorAnggota" : nomorAnggota,
        },
        success : function(data){
            if (data == 0) {
                if ($('#nomoranggota').val().length == 0) {
                    $('#pesan').hide();  
                }else{
                    $('#pesan').show();
                }
                $('#pesan').html('<i class="fa-solid fa-check text-success"></i> <span class="text-success">Nomer Anggota belum terdaftar</span>');
                $('#simpananggota').attr("disabled",false);
            }
            else{
                $('#pesan').html('<i class="fa-solid fa-exclamation text-danger"></i> <span class="text-danger">Nomer Anggota sudah terdaftar</span>');
                $('#simpananggota').attr("disabled",true);
            }
        }
    });
});
</script>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>