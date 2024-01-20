<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$id_buku = $_GET['detail-buku'];

$data_buku = mysqli_query($koneksi,"SELECT * FROM tb_koleksibuku b JOIN tb_rak r ON b.id_rak = r.id_rak JOIN tb_kategori k ON b.id_kategori = k.id_kategori WHERE id_buku = '$id_buku' ");
$buku = mysqli_fetch_array($data_buku);
$id_buku = $buku['id_buku'];

$databuku = select("SELECT no_buku,stokBuku FROM tb_buku WHERE id_buku = '$id_buku'");
?>
<style type="text/css">
   .product-image{
      
   }
   img:hover{
    transition: .3s ease-in-out;
    opacity: .7;
   }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-4">
              <h3 class="d-inline-block d-sm-none"><?= $buku['judulBuku']?></h3>
              <div class="col-12">
                <?php if (empty($buku['cover'])) { ?>
                  <img src="../asset/dist/img/cover_default.jpeg" class="product-image" alt="Cover Buku">
                <?php } else {  ?>
                  <img src="../asset/cover/<?= $buku['cover']?>" class="product-image" alt="Cover Buku">
              <?php } ?>
              </div>
            </div>
            <div class="col-12 col-sm-8 mt-2">
              <table class="table table-hover">
              <tbody>
                <tr>
                  <td width="200px">Judul Buku</td>
                  <td><?php echo $buku['judulBuku']; ?></td>
                </tr>
                <tr>
                  <td>Penerbit</td>
                  <td><?php echo $buku['penerbit'];?></td>
                </tr>
                <tr>
                  <td>Penulis</td>
                  <td><?php echo $buku['penulis'];?></td>
                </tr>
                <tr>
                  <td>Kategori</td>
                  <td><?php echo $buku['nama_kategori'];?></td>
                </tr>
                <tr>
                  <td>Tahun Terbit</td>
                  <td><?php echo $buku['tahunTerbit'];?></td>
                </tr>
                <tr>
                  <td>Kode Rak</td>
                  <td><?php echo $buku['kode_rak'];?></td>
                </tr>
                <tr>
                  <td>Nama Rak</td>
                  <td><?php echo $buku['nama_rak'];?></td>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" role="tab" aria-controls="product-desc" aria-selected="true">Deskripsi Buku</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"><em> <?php if($buku['deskripsi'] == null){
                echo "<p class = 'text-secondary'>Tidak Ada deskripsi</p>";

              }else{
                echo $buku['deskripsi'];
              } ?></em> </div>
            </div>
          </div>

          <div class="card mt-3" style="width:500px;">
              <div class="card-header p-2">
                <h5>Jumlah Eksemplar</h5>
              </div><!-- /.card-header -->
              <div class="card-body" style="max-height: 500px; overflow-y:auto;">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No Buku</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <?php foreach($databuku as $databuku): 

                        $stok = $databuku['stokBuku'];
                        if ($stok != 0) {
                          $stokBuku = "Tersedia";
                        }else{
                          $stokBuku = "Tidak Tersedia";
                        }

                      ?>
                    <tbody>
                      <tr>
                        <td><?php echo $databuku['no_buku']; ?></td>
                        <td><?php echo $stokBuku; ?></td>
                      </tr>
                    </tbody>
                  <?php endforeach; ?>
                  </table>
              </div>
          </div>      
            <div class="mt-4">
               <a class="btn btn-danger btn-flat float-right" href="data-buku.php">Kembali</a>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php
      require '../template/footer.php';
      require '../template/script.php';

?>