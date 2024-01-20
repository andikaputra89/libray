<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_kategori = select("SELECT * FROM tb_kategori");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Kategori</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Kategori</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#kategori"><i class="fa fa-plus"></i> Tambah Data Kategori</button>
      <?php endif; ?>

            <?php
          if(isset($_SESSION['kategori'])): ?>

              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['kategori']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

          <?php 
          unset($_SESSION['kategori']);
          endif;
          ?>
        <table class="table table-hover" id="table">
          <thead>
            <tr>
                <th width="20px">No</th>
                <th>Nama kategori</th>
                <?php if ($_SESSION['id_level']=='2') : ?>
                <th class="text-center" width="170px">Aksi</th>
                <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_kategori as $kategori): ?>
            <tr class>
              <td><?php echo $no++; ?></td>
              <td><?php echo $kategori['nama_kategori'];?></td>
              <?php if ($_SESSION['id_level']=='2') : ?>
              <td class="text-center">
                <a id="editkategori" data-toggle="modal" data-target="#editkategori<?php echo $kategori['id_kategori'];?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="?delete=<?php echo $kategori['id_kategori']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
            <?php endif;?>
            </td>
            </tr>
                <!-- Modal Edit -->
                <div class="modal fade" id="editkategori<?php echo $kategori['id_kategori'];?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-warning">
                        <h4 class="modal-title">Edit Data kategori</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="" method="POST">
                          <input type="hidden" name="id_kategori" value="<?= $kategori['id_kategori'] ?>">
                          <div class="mb-1">
                            <label  class="col-form-label">Nama kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>"<?php if ($kategori['nama_kategori'] == 'Buku Paket') echo 'readonly' ?> required>
                          </div>
                        
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                          </div>
                        </form>
                      
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- Modal tambah kategori -->
<div class="modal fade" id="kategori" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah data kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST">
                <div class="mb-1">
                  <label  class="col-form-label">Nama kategori</label>
                  <input type="text" class="form-control" name="nama_kategori" required>
                </div>
              
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<?php
if (isset($_POST['simpan'])) 
{
  $result = tambah_kategori($_POST);
  if($result)
  {
    $_SESSION['kategori']= "Data kategori Berhasil Ditambahkan";
            echo "<script>
                document.location.href = 'data-kategori.php';
                </script>
                ";

  }else{
    $_SESSION['failed']='Data kategori gagal ditambahkan';
    $_SESSION['failed_icon']='error';
    echo "<script>
            document.location.href = 'data-kategori.php';
            </script>
            ";
  }
}
if (isset($_GET['delete'])) 
{
  $result = hapus_kategori($_GET);
  if($result)
  {
   $_SESSION['kategori']= "Data kategori Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-kategori.php';
                </script>
                ";
  } else{
    $_SESSION['failed']='Data kategori gagal dihapus';
    $_SESSION['failed_icon']='error';
    echo "<script>
            document.location.href = 'data-kategori.php';
            </script>
            ";
  }
  
}
if (isset($_POST['edit'])) {
      $result = edit_kategori($_POST);

         if ($result) {
            $_SESSION['kategori']= "Data kategori Berhasil Diubah";
            echo "<script>
                document.location.href = 'data-kategori.php';
                </script>
                ";
         
         }else{
          $_SESSION['failed']='Data kategori gagal diubah';
          $_SESSION['failed_icon']='error';
          echo "<script>
            document.location.href = 'data-kategori.php';
            </script>
            ";

         }

   }
      require '../template/footer.php';
      require '../template/script.php';

?>