<?php
 require '../template/header.php';
    if ($_SESSION['id_level'] != '1'){
        die("<script>
          document.location.href = '../index.php';
          </script>");
    }
  require '../template/navbar.php';

    require '../template/sidebar.php';

    if (isset($_POST['simpan'])) {
    
    $result = tambah_pegawai($_POST);
    if ($result) {
        $_SESSION['pegawai']= "Data Pegawai Berhasil Ditambahkan";
        echo "<script>
            document.location.href = 'data-pegawai.php';
            </script>
            ";
    }else{
        echo "<script>
            alert('Data Pegawai gagal ditambahkan');
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
            <h1>Tambah Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-pegawai.php">Data Pegawai</a></li>
              <li class="breadcrumb-item active">Tambah Pegawai</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">    
          <h5 class="card-header">Form tambah pegawai</h5>
          <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                  <form action="" method="POST" enctype="multipart/form-data">
                     <div class="mb-1">
                        <label class="form-label">NIP | NIK</label>
                        <input type="text" class="form-control" name="nomer_pegawai" placeholder="Masukan NIP / NIK" id="nomoranggota" required>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Nama </label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Pegawai" required>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Tempat Lahir </label>
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukan Tempat Lahir" required>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Masukan Tanggal Lahir" required>
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
               </div>
               <div class="col-md-6">
                <div class="mb-1">
                     <label class="form-label">Alamat</label>
                     <textarea class="form-control" name="alamat" placeholder="Masukan Alamat" style="height: 100px"></textarea>
                  </div>
                  
                  <div class="mb-1">
                      <label class="form-label mb-0">Foto Profil</label><br>
                      <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFile(this);" >
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
            <button type="submit" name="simpan"  class="btn btn-primary float-right m-3">
            Simpan 
            </button>
            <a href="data-pegawai.php" class="btn btn-danger float-right mt-3">Kembali</a>
            </form>
         </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>