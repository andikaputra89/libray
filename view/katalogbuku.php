<?php
 require '../template-user/header.php';

  require '../template-user/navbar.php';

    require '../template-user/sidebar.php';
      
$jumlahdataPerhalaman = 12;
$jumlahData = count(select("SELECT * FROM tb_buku"));
$jumlahHalaman = ceil($jumlahData / $jumlahdataPerhalaman);
  if (isset($_GET['page'])) {
      $halamanAktif = $_GET['page'];
  }else{
      $halamanAktif= 1;
  }
  $dataAwal = ($halamanAktif * $jumlahdataPerhalaman)- $jumlahdataPerhalaman;

  if (isset($_POST['cari'])) {
      $keyword = $_POST['keyword'];
      $data_buku = select("SELECT * FROM tb_koleksibuku b JOIN tb_kategori k ON b.id_kategori = k.id_kategori WHERE b.judulBuku LIKE '%$keyword%' LIMIT $dataAwal, $jumlahdataPerhalaman");
      
  }else{
      $data_buku = select("SELECT * FROM tb_koleksibuku b JOIN tb_kategori k ON b.id_kategori = k.id_kategori LIMIT $dataAwal, $jumlahdataPerhalaman");
  }
?>
<style type="text/css">
.card{
  
}
.card:hover{
     box-shadow: 0 0 11px rgba(33,33,33,.2);
    }
.card-img-top{
    width: 150px;
}
.mx-auto{
    height: 250px;
}
.judul{
    height: 60px;
    width: auto;
}
.card-img-top:hover{
     transition: transform .8s;
    transform: translateY(7px);
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Katalog Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard-user.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Katalog Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-8"></div>
        <div class="col-12 col-sm-8 col-md-4 col-lg-3 ">
            <form action="" method="POST" class="d-flex ml-5" style="width: 300px; ">
              <input class="form-control mr-2" name="keyword" type="search" placeholder="Cari buku" aria-label="Search" autocomplete="off">
              <button class="btn btn-outline-success" name="cari" type="submit">Search</button>
            </form>
          </div>
        </div>
        <div class="row mt-2"><!-- row -->          
            <?php
            foreach ($data_buku as $buku):?>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card mt-2">
                  <div class="mx-auto">
                    <?php if (empty($buku['cover'])) { ?>
                  <img src="../asset/dist/img/cover_default.jpeg" class="card-img-top mt-3 rounded" alt="Cover Buku">
                    <?php } else {  ?>
                      <img src="../asset/cover/<?= $buku['cover']?>" class="card-img-top mt-3 rounded" alt="Cover Buku">
                  <?php } ?>
                  </div>
                  <div class="card-body text-center">
                      <h5 class="judul"><?php echo $buku['judulBuku'];?></h5>
                      <p class="card-text"><small><?php echo $buku['penulis'];?></small></p>
                       <p class="card-text"><small><?php echo $buku['nama_kategori'];?></small></p>
                      <div class="button">
                          <a href="detailbuku.php?detail-buku=<?php echo $buku['id_buku']?>" class="btn btn-primary">Detail</a>
                          <a id="pinjambuku" data-toggle="modal" data-target="#pinjambuku<?php echo $buku['id_buku'];?>" class="btn btn-success">Pinjam</a>
                      </div>
                  </div>
                </div>
            </div>
            <div class="modal fade" id="pinjambuku<?= $buku['id_buku'] ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Peminjaman</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="POST">
                      <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
                      <input type="hidden" name="nomerAnggota" value="<?php echo $_SESSION['username']; ?>">
                      <div class="mb-1">
                        <label  class="col-form-label">Judul Buku</label>
                        <input type="text" class="form-control" name="judulBuku" value="<?php echo $buku['judulBuku'];?>" readonly>
                      </div>
                      <div class="mb-1">
                        <label for="message-text" class="col-form-label">Penulis</label>
                        <input type="text" class="form-control" name="penulis" value="<?php echo $buku['penulis'];?>" readonly>
                      </div>
                      <?php date_default_timezone_set('Asia/Ujung_Pandang'); ?>
                        <input type="hidden" class="form-control" name="tgl_request" value="<?php echo date('Y-m-d H:i');?>" readonly>
                        <input type="hidden" class="form-control" name="tgl_exp" value="<?php echo date('Y-m-d H:i',strtotime('+1 day'));?>" readonly>
                    
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                    <button type="submit" name="konfirmasipinjam" class="btn btn-success">Pinjam</button>

                    </form>
                    <!-- end form -->
                  </div>
                  <!-- end modal footer-->
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <?php endforeach;?>                            
        </div><!-- end row -->
        <!-- penomoran halanan -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-2">
              <?php  if ($halamanAktif <= 1): ?>
                  <li class="page-item disabled">
                    <a class="page-link" href="?page=<?=$halamanAktif - 1;?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
              <?php else :?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?=$halamanAktif - 1;?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
              <?php endif; ?>
              
              <?php for ($i = 1; $i<=$jumlahHalaman; $i++):  ?>
                  <?php if($i == $halamanAktif): ?>
                      <li class="page-item active"><a class="page-link" href="?page=<?= $i; ?>"><?php echo $i;?></a></li> 
                  <?php else : ?>
                      <li class="page-item"><a class="page-link" href="?page=<?= $i; ?>"><?php echo $i;?></a></li>
                  <?php endif; ?>  
             <?php endfor;?>
             <?php if ($halamanAktif >= $jumlahHalaman): ?>
              <li class="page-item disabled">
                  <a class="page-link" href="?page=<?=$halamanAktif + 1?>" aria-label="Next">
                   <span aria-hidden="true">&raquo;</span>
                  </a>
              </li> 
             <?php else:  ?>
              <li class="page-item">
                  <a class="page-link" href="?page=<?=$halamanAktif + 1?>" aria-label="Next">
                   <span aria-hidden="true">&raquo;</span>
                  </a>
              </li> 

              <?php endif; ?>
              
            </ul>
          </nav><!-- end nav penomoran halaman -->

      </div>

    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_POST['konfirmasipinjam'])) {
    $result = requestbuku($_POST);
    if ($result) {
      $_SESSION['pinjam']='Data permintaan Pinjam Buku Berhasil Ditambahkan';
      $_SESSION['pinjam_icon']='success';
      echo "<script>document.location.href = 'riwayatrequest.php';
            </script>
            ";
            exit();
    } else {
      $_SESSION['pinjam']='Data permintaan Pinjam Buku Gagal Ditambahkan';
      $_SESSION['pinjam_icon']='error';
      echo "<script>document.location.href = 'riwayatrequest.php';
            </script>
            ";
            exit();
    }
}

      require '../template-user/footer.php';
      require '../template-user/script.php';

?>