<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_buku = select("SELECT * FROM tb_koleksibuku b LEFT JOIN tb_rak r ON b.id_rak = r.id_rak LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori ORDER BY id_buku");
    $data_eksemplar = select("SELECT * FROM tb_buku b JOIN tb_koleksibuku kb ON b.id_buku = kb.id_buku JOIN tb_kategori k ON kb.id_kategori = k.id_kategori JOIN tb_rak r ON kb.id_rak = r.id_rak ORDER BY `b`.`id_buku` ASC");
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
          <a href="tambah-buku.php">
            <button class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah Buku</button>
        </a>
        <!--<a href="tambah-buku.php">
            <button class="btn btn-success mb-2"><i class="fa-solid fa-file-excel"></i> Import</button>
        </a>-->
        <?php endif; ?>
        <ul class="nav nav-tabs m-2">
          <li class="nav-item"><a class="nav-link active" href="#datakoleksi" data-toggle="tab">Data Koleksi</a></li>
          <li class="nav-item"><a class="nav-link" href="#dataeksemplar" data-toggle="tab">Data Eksemplar</a></li>
        </ul>
        
        <?php
          if(isset($_SESSION['buku'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['buku']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php 
        unset($_SESSION['buku']);
        endif;
        ?>
        <style type="text/css">
          .product-image{
            width: 3.5em !important; 
          }
          table{
            font-size: 0.9rem;
          }
        </style>
        <div class="tab-content">
          <div class="active tab-pane" id="datakoleksi">
            <table class="table table-hover" id="table">
              <thead>
                <tr>
                    <th width="10px">No</th>
                    <th width="200px">Judul Buku</th>
                    <th>Penerbit</th>
                    <th>Penulis</th>
                    <th>Rak Buku</th>
                    <th>Kategori</th>
                    <th>Tahun Terbit</th>
                    <th width="50px">Jumlah Buku</th>
                    <th <?php if($_SESSION['id_level']=="2") echo "width='125px'"; ?>  class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_buku as $buku): 
                  $id = $buku['id_buku'];
                  $totalBuku = 0;
                  $total_buku = select("SELECT * FROM tb_buku WHERE id_buku = '$id'");

                  foreach ($total_buku as $stok):
                      $stokBuku = $stok['stokBuku'];
                      $totalBuku += $stokBuku;
                  endforeach;
                  ?>
                <tr class>
                  <td><?php echo $no++; ?></td>
                  <td class="row">
                    <div class="col-md-3">
                      <?php if (empty($buku['cover'])) { ?>
                          <img src="../asset/dist/img/cover_default.jpeg" class="product-image" alt="Cover Buku">
                        <?php } else {  ?>
                          <img src="../asset/cover/<?= $buku['cover']?>" class="product-image" alt="Cover Buku">
                      <?php } ?>
                    </div>
                    <div class="col-md-9">
                    <?php echo $buku['judulBuku'];?>
                    </div>
                    </td>
                  <td><?php echo $buku['penerbit'];?></td>
                  <td><?php echo $buku['penulis'];?></td>
                  <td><?php echo $buku['nama_rak'];?></td>
                  <td><?php echo $buku['nama_kategori']?></td>
                  <td><?php echo $buku['tahunTerbit'];?></td>
                  <td><?php echo $totalBuku; ?></td>
                  <td class="text-center">
                    <a href="detail-buku.php?detail-buku=<?php echo $buku['id_buku']?>" id="detail-buku"
                    class="btn btn-primary text-white" 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="bottom" title="Lihat Detail"><i class="fa-solid fa-eye"></i></a>
                    <?php if ($_SESSION['id_level']=="2"): ?>
                    <a href="edit-buku.php?edit=<?php echo $buku['id_buku']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="?delete=<?php echo $buku['id_buku']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
                <?php endif;?>
                </td>
                </tr>
                    <!-- Modal -->
                    
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="dataeksemplar">
            <table class="table table-hover" id="table1">
              <thead>
                <tr>
                    <th width="10px">No</th>
                    <th>No Buku</th>
                    <th width="200px">Judul Buku</th>
                    <th>Penerbit</th>
                    <th>Penulis</th>
                    <th>Rak Buku</th>
                    <th>Kategori</th>
                    <th>Tahun Terbit</th>
                    <th width="50px">Salinan</th>
                    <?php if ($_SESSION['id_level']=="2"): ?>
                    <th class="text-center">Aksi</th>
                    <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_eksemplar as $buku): 
                  
                  if ($buku['stokBuku'] != 0) {
                    $stok = $buku['stokBuku'];
                  }else{
                    $stok = "Tidak Tersedia";
                  }

                  ?>
                <tr class>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $buku['no_buku']?></td>
                  <td class="row">
                    <div class="col-md-3">
                      <?php if (empty($buku['cover'])) { ?>
                          <img src="../asset/dist/img/cover_default.jpeg" class="product-image" alt="Cover Buku">
                        <?php } else {  ?>
                          <img src="../asset/cover/<?= $buku['cover']?>" class="product-image" alt="Cover Buku">
                      <?php } ?>
                    </div>
                    <div class="col-md-9">
                    <?php echo $buku['judulBuku'];?>
                    </div>
                    </td>
                  <td><?php echo $buku['penerbit'];?></td>
                  <td><?php echo $buku['penulis'];?></td>
                  <td><?php echo $buku['nama_rak'];?></td>
                  <td><?php echo $buku['nama_kategori']?></td>
                  <td><?php echo $buku['tahunTerbit'];?></td>
                  <td class="<?php if($buku['stokBuku'] == 0) echo "text-danger font-weight-bold" ?>"><?php echo $stok ?></td>
                  <?php if ($_SESSION['id_level']=="2"): ?>
                  <td class="text-center">
                    <a href="?hapus=<?php echo $buku['no_buku']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
                    <?php endif;?>
                  </td>
                </tr>
                    <!-- Modal -->
                    
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['delete'])) 
    {
        $result = hapusBuku($_GET);
        if($result)
        {
            $_SESSION['buku']= "Data Buku Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-buku.php';
                </script>
                ";
        }
    }
if (isset($_GET['hapus'])) {
      $result = hapuseksemplar($_GET);
      if ($result) {
            $_SESSION['buku']= "Data Eksemplar Buku Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-buku.php';
                </script>
                ";
         }

   }
      require '../template/footer.php';
      require '../template/script.php';

?>