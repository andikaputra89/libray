<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
    require '../lib/vendor/autoload.php';
    if (isset($_POST['import'])) {
        $ekstensi    = "";
        $file_name  = $_FILES['importAanggota']['name'];
        $file_data  = $_FILES['importAanggota']['tmp_name'];

        $ekstensi   = pathinfo($file_name)['extension'];

        $ekstensi_allowed = array("xls","xlsx");
        if (!in_array($ekstensi,$ekstensi_allowed)) {
           $_SESSION['failed'] = "Silahkan Upload File Excel dengan format xlsx";
           $_SESSION['failed_icon'] = 'warning';
            echo "<script>
            document.location.href = 'import-anggota.php';
            </script>
            ";
            die();
        }
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_data);
        $spreadsheet = $reader->load($file_data);
        $sheetdata = $spreadsheet->getActiveSheet()->toArray();

        $jumlahdata = 0;
        for ($i=1; $i <count($sheetdata) ; $i++) { 
          $no_anggota = $sheetdata[$i]['0'];
          $nama = $sheetdata[$i]['1'];
          $jenis_kelamin = $sheetdata[$i]['2'];
          $no_hp = $sheetdata[$i]['3'];
          $alamat = $sheetdata[$i]['4'];
          $id_status = $sheetdata[$i]['5'];
          $password = $sheetdata[$i]['6'];
          $encr = md5($password);

          //echo "$no_anggota - $nama</br>";

          mysqli_query($koneksi,"INSERT INTO tb_anggota(nomorAnggota,nama,jenis_kelamin,no_hp,alamat,id_statusanggota) VALUES ('$no_anggota','$nama','$jenis_kelamin','$no_hp','$alamat','$id_status')");
          mysqli_query($koneksi,"INSERT INTO tb_user(username,nama,password,id_level,nomerAnggota) VALUES ('$no_anggota','$nama','$encr','3','$no_anggota')");

          $jumlahdata++;
        }
        if ($jumlahdata > 0) {
          $_SESSION['anggota'] = "Import data anggota berhasil";
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
            <h1>Import Data Anggota</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-anggota.php">Data Anggota</a></li>
              <li class="breadcrumb-item active">Import Anggota</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="card">    
          <h5 class="card-header">Form Import Anggota</h5>
          <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
            <a href="../asset/import/anggota.xlsx" class="btn btn-primary">
                <span class="glyphicon glyphicon-download"></span>
                Download Template File
            </a>
                <div class="mt-2">
                    <label class="form-label">Pilih File Excel</label>
                    <input type="file" class="form-control" name="importAanggota" placeholder="Masukan No NIS/No Pegawai" id="nomoranggota" required>
                </div>
            <a href="data-anggota.php" class="btn btn-danger float-left mt-3">Kembali</a>
            <button type="submit" name="import"  class="btn btn-success float-left m-3">
            Import 
            </button>
            </form>
         </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <script>
</script>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>