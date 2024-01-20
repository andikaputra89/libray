<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
    
if (isset($_POST['simpanbukupaket'])) {
   
    if (tambah_peminjambukupaket($_POST) > 0) {
      $_SESSION['peminjam']= "Data Peminjam Berhasil Ditambahkan";
            echo "<script>
                document.location.href = 'data-pinjambukupaket.php';
                </script>
                ";
   }else{
       $_SESSION['failed'] = 'Peminjam gagal ditambahkan';
       $_SESSION['failed_icon'] = 'error';
       echo "<script>
                document.location.href = 'data-pinjambukupaket.php';
                </script>
                ";
                exit();
   }
}
$data_buku = select("SELECT * FROM tb_buku b JOIN tb_koleksibuku kb ON b.id_buku = kb.id_buku JOIN tb_kategori k ON kb.id_kategori = k.id_kategori WHERE kb.id_kategori = '1' AND b.stokBuku !='0'");
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
              <li class="breadcrumb-item "><a href="data-peminjamanbukupaket.php">Data Peminjaman Buku Paket</a></li>
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
         <h5 class="card-header">Form peminjaman Buku Paket</h5>
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  <form action="" method="POST">
                     <div class="mb-1">
                        <label class="form-label">Judul Buku</label><br>
                        <select class="custom-select" id="judulBuku" multiple data-placeholder="Pilih Judul Buku" name="judulBuku[]">
                           <?php foreach ($data_buku as $buku): ?>
                           <option value="<?= $buku['no_buku']?>"><?= '('.$buku['no_buku'].')'.''.$buku['judulBuku']?></option>
                        <?php endforeach;?>
                        </select>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Nomor Anggota</label>
                        <input type="number" class="form-control" name="nomorAnggota" id="nomorAnggota1" placeholder="Masukan No Anggota" onkeyup="isi_otomatis2(); datapinjambkpaket()" required >
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Nama peminjam</label>
                        <input type="text" class="form-control" name="nama" id="nama2" placeholder="Nama Anggota" required readonly>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Status Anggota</label>
                        <input type="text" class="form-control" name="nama" id="statusanggota2" placeholder="Status Anggota"readonly>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>"required>
                     </div>
                     <div class="mb-1">
                        <label class="form-label">Estimasi Tanggal Kembali</label>
                        <input type="date" class="form-control" name="estimasitgl_kembali" value="<?php echo date('Y-m-d', strtotime('+ 182 days')); ?>" required>
                     </div>
               </div>
            </div>
            <div class="databukupaket mt-3" style="display: none;">
                  <div class="card card-primary card-outline">
                    <div class="card-header">Buku Paket yang masih dipinjam</div>
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
                         <tbody id="tbodypaket">
                        </tbody>
                      </table>

                    </div>
                    <!-- /.card-body -->
                  </div>
               </div>
            <button type="submit" name="simpanbukupaket"  class="btn btn-primary float-right m-3">
            Simpan 
            </button>
            <a href="data-pinjambukupaket.php" class="btn btn-danger float-right mt-3">Kembali</a>
            </form>
         </div>
      </div><!-- penutup card -->

    </section>
    <!-- /.content -->
  </div>
<script src="../asset/js/bootstrap-multiselect.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $('#judulBuku').multiselect({
        nonSelectedText: 'Pilih Judul Buku',
        buttonTextAlignment: 'left',
        enableFiltering: true,
        enableCaseInsensitiveFiltering:true,
        buttonWidth:'100%',
        maxHeight:450
     });
    

 });
</script>
<?php
require '../template/footer.php';
require '../template/script.php';

?>