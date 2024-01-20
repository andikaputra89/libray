<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
if (isset($_POST['simpan'])) {
   
   if (tambah_peminjam($_POST) > 0) {
      $_SESSION['peminjam']= "Data Peminjam Berhasil Ditambahkan";
            echo "<script>
                document.location.href = 'data-peminjaman.php';
                </script>
                ";
   }else{
       $_SESSION['failed'] = 'Peminjam gagal ditambahkan';
       $_SESSION['failed_icon'] = 'error';
       echo "<script>
                document.location.href = 'data-peminjaman.php';
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
            <h1>Tambah Peminjam</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-peminjaman.php">Data Peminjaman</a></li>
              <li class="breadcrumb-item active">Tambah Peminjam</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card">
         <h5 class="card-header">Form tambah peminjaman</h5>
         <div class="card-body">
            <form action="" method="POST">
               <div class="mb-1">
                  <label class="form-label">Nomor Buku</label>
                  <input type="text" class="form-control" name="no_buku" id="no_buku" placeholder="Masukan nomer buku" onkeyup="(isi_otomatis_buku())" required>
               </div>
               <div class="mb-1">
                  <label class="form-label">Judul Buku</label>
                  <input type="text" class="form-control readonly" name="judulBuku" id="judulBuku" placeholder="Judul Buku dipinjam" required >
               </div>
               <div class="mb-1">
                  <label class="form-label">Nomor Anggota</label>
                  <input type="number" class="form-control" name="nomorAnggota" id="nomorAnggota" placeholder="masukan nomer anggota" onkeyup="isi_otomatis(); datapinjam()" required >
               </div>
               <div class="mb-1">
                  <label class="form-label">Nama peminjam</label>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Anggota" readonly>
               </div>
               <div class="mb-1">
                  <label class="form-label">Status Anggota</label>
                  <input type="text" class="form-control" id="statusanggota" placeholder="Status Anggota"  readonly>
               </div>
               <div class="mb-1">
                  <label class="form-label">Tanggal Pinjam</label>
                  <input type="date" class="form-control" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>" readonly>
               </div>
               <div class="mb-1">
                  <label class="form-label">Estimasi Tanggal Kembali</label>
                  <input type="date" class="form-control" name="estimasitgl_kembali" value="<?php echo date('Y-m-d', strtotime('+ 7 days')); ?>" readonly>
               </div>
               <div class="datauser mt-3" style="display: none;">
                  <div class="card card-primary card-outline">
                    <div class="card-header">Riwayat Buku yang sedang dipinjam</div>
                    <div class="card-body" style="margin: 0; padding:0;">
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
                         <tbody id="tbody">
                        </tbody>
                      </table>

                    </div>
                    <!-- /.card-body -->
                  </div>
               </div>
            <button type="submit" name="simpan" disabled class="btn btn-primary float-right m-3 btnpinjam">
            Simpan 
            </button>
            <a href="data-peminjaman.php" class="btn btn-danger float-right mt-3">Kembali</a>
            </form>
         </div>
      </div><!-- penutup card -->

    </section>
    <!-- /.content -->
  </div>
  <script>
    $(".readonly").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) // ignore tab
            e.preventDefault();
    });
</script>
<?php
require '../template/footer.php';
require '../template/script.php';

?>