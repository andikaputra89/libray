<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_rak = select("SELECT * FROM tb_rak ORDER BY kode_rak asc");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Rak</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Rak</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#rak"><i class="fa fa-plus"></i> Tambah Data Rak</button>
      <?php endif; ?>

            <?php
              if(isset($_SESSION['rak'])): ?>

              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['rak']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

          <?php 
          unset($_SESSION['rak']);
          endif;
          ?>
        <table class="table table-hover" id="table">
          <thead>
            <tr>
                <th width="20px">No</th>
                <th width="100px">Kode Rak</th>
                <th>Nama Rak</th>
                <?php if ($_SESSION['id_level']=='2') : ?>
                <th class="text-center" width="170px">Aksi</th>
                <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_rak as $rak): ?>
            <tr class>
              <td><?php echo $no++; ?></td>
              <td><?php echo $rak['kode_rak'];?></td>
              <td><?php echo $rak['nama_rak'];?></td>
              <?php if ($_SESSION['id_level']=='2') : ?>
              <td class="text-center">
                <a id="editrak" data-toggle="modal" data-target="#editrak<?php echo $rak['id_rak'];?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="?delete=<?php echo $rak['id_rak']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
            <?php endif;?>
            </td>
            </tr>
                <!-- Modal Edit -->
                <div class="modal fade" id="editrak<?php echo $rak['id_rak'];?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-warning">
                        <h4 class="modal-title">Edit Data Rak</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="" method="POST">
                          <div class="mb-1">
                            <input type="hidden" name="id_rak" value="<?= $rak['id_rak'] ?>">
                            <label  class="col-form-label">Kode Rak</label>
                            <input type="text" class="form-control" name="kode_rak" value="<?= $rak['kode_rak'] ?>" required>
                          </div>
                          <div class="mb-1">
                            <label  class="col-form-label">Nama Rak</label>
                            <input type="text" class="form-control" name="nama_rak" value="<?= $rak['nama_rak'] ?>" onkeyup="this.value = this.value.toUpperCase()" required>
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
  <!-- Modal tambah rak -->
<div class="modal fade" id="rak" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah data Rak</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST">
                <div class="mb-1">
                  <label  class="col-form-label">Kode Rak</label>
                  <input type="text" class="form-control" name="kode_rak" required>
                </div>
                <div class="mb-1">
                  <label  class="col-form-label">Nama Rak</label>
                  <input type="text" class="form-control" name="nama_rak" onkeyup="this.value = this.value.toUpperCase()" required>
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
  $result = tambah_rak($_POST);
  if($result)
  {
    $_SESSION['rak']= "Data Rak Berhasil Ditambahkan";
            echo "<script>
                document.location.href = 'data-rak.php';
                </script>
                ";

  }else{
    echo "<script>
            alert('Data gagal ditambahkan');
            document.location.href = 'data-kategori.php';
            </script>
            ";
  }
}
if (isset($_GET['delete'])) 
{
  $result = hapus_rak($_GET);
  if($result)
  {
   $_SESSION['rak']= "Data Rak Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-rak.php';
                </script>
                ";
  } else{
    echo "<script>
            alert('Data rak gagal dihapus');
            document.location.href = 'data-rak.php';
            </script>
            ";
  }
  
}
if (isset($_POST['edit'])) {
      $result = edit_rak($_POST);

         if ($result) {
            $_SESSION['rak']= "Data Rak Berhasil Diubah";
            echo "<script>
                document.location.href = 'data-rak.php';
                </script>
                ";
         
         }else{
          echo "<script>
            alert('Data Rak gagal diubah ');
            document.location.href = 'data-rak.php';
            </script>
            ";

         }

   }
      require '../template/footer.php';
      require '../template/script.php';

?>