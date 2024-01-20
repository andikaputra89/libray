<?php
 require '../template/header.php';
  if ($_SESSION['id_level'] != '1'){
        die("<script>
          document.location.href = '../index.php';
          </script>");
    }
  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_pegawai = select("SELECT * FROM tb_staff WHERE jabatan !='Kepala Perpustakaan'");

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Pegawai</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <a href="tambah-pegawai.php">
            <button class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah Pegawai</button>
        </a>
        <?php
          if(isset($_SESSION['pegawai'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['pegawai']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php 
        unset($_SESSION['pegawai']);
        endif;
        ?>
        <table class="table table-hover" id="table">
          <thead>
            <tr>
                <th>No</th>
                <th>No Pegawai</th>
                <th>Nama</th>
                <th>Jenis kelamin</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <?php //if ($_SESSION['id_level']=="2"): ?>
                <th class="text-center">Aksi</th>
            <?php //endif;?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_pegawai as $pegawai): ?>
            <tr class>
              <td><?php echo $no++; ?></td>
              <td><?php echo $pegawai['nomer_pegawai'];?></td>
              <td><?php echo $pegawai['nama'];?></td>
              <td><?php echo $pegawai['jenis_kelamin'];?></td>
              <td><?php echo $pegawai['no_hp'];?></td>
              <td><?php echo $pegawai['alamat'];?></td>
              <td ><?php echo $pegawai['jabatan'];?></td>
              <?php //if ($_SESSION['id_level']=="2"): ?>
              <td style="width: 100px;" class="text-center">
                <a href="edit-pegawai.php?edit-pegawai=<?php echo $pegawai['nomer_pegawai']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="?delete=<?php echo $pegawai['nomer_pegawai']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
            </td>
             <?php //endif;?>
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
        $result = hapus_pegawai($_GET);
        if($result)
        {
            $_SESSION['pegawai']= "Data pegawai Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-pegawai.php';
                </script>
                ";
        } else{
            echo "<script>
                alert('Data pegawai gagal dihapus');
                document.location.href = 'data-pegawai.php';
                </script>
                ";
        }
    }


      require '../template/footer.php';
      require '../template/script.php';


?>