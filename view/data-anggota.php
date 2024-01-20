<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_anggota = select("SELECT * FROM tb_anggota LEFT JOIN status_anggota ON tb_anggota.id_statusanggota = status_anggota.id_status ORDER BY id_statusanggota ASC");
?>
<style type="text/css">
    table{
            font-size: 1rem;
          }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Anggota</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Anggota</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
        <a href="tambah-anggota.php">
            <button class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah Anggota</button>
        </a>
        <a href="import-anggota.php">
            <button class="btn btn-success mb-2"><i class="fa-solid fa-file-excel"></i> Import Data</button>
        </a>
      <?php endif; ?>
      <?php
          if(isset($_SESSION['anggota'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['anggota']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php 
        unset($_SESSION['anggota']);
        endif;
        ?>
        <table class="table table-hover" id="table">
          <thead>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>Nama</th>
                <th>Jenis kelamin</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Status</th>
                <?php if ($_SESSION['id_level']=="2"): ?>
                <th class="text-center">Aksi</th>
            <?php endif;?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_anggota as $anggota): ?>
            <tr class>
              <td><?php echo $no++; ?></td>
              <td><?php echo $anggota['nomorAnggota'];?></td>
              <td><?php echo $anggota['nama'];?></td>
              <td><?php echo $anggota['jenis_kelamin'];?></td>
              <td><?php echo $anggota['no_hp'];?></td>
              <td><?php echo $anggota['alamat'];?></td>
              <td ><?php echo $anggota['status_anggota'];?></td>
              <?php if ($_SESSION['id_level']=="2"): ?>
              <td style="width: 100px;" class="text-center">
                <a href="edit-anggota.php?edit=<?php echo $anggota['nomorAnggota']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="?delete=<?php echo $anggota['nomorAnggota']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
            </td>
             <?php endif;?>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['delete'])) 
    {
        $result = hapus_anggota($_GET);
        if($result)
        {
            $_SESSION['anggota']= "Data Anggota Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-anggota.php';
                </script>
                ";
        } else{
            echo "<script>
                alert('Data anggota gagal dihapus');
                document.location.href = 'data-anggota.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>