<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_req = select("SELECT * FROM tb_reqbuku r LEFT JOIN tb_koleksibuku b ON r.id_buku = b.id_buku LEFT JOIN tb_anggota a ON r.noanggota_req = a.nomorAnggota WHERE status_req = 'Belum Dikonfirmasi'");

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Request Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Request Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
              if(isset($_SESSION['req'])): ?>

              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['req']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

          <?php 
          unset($_SESSION['req']);
          endif;
          ?>
        <table class="table table-hover" id="table">
          <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Rak Buku</th>
                <th>No Anggota</th>
                <th>Nama</th>
                <th>Tanggal Request</th>
                <th>Tanggal Kadaluarsa</th>
                <th class="text-center" width="100px">Aksi</th>
            
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_req as $request): ?>
            <tr class>
              <?php
                $id_rak = $request['id_rak'];
                $data_rak = mysqli_query($koneksi,"SELECT * FROM tb_rak WHERE id_rak = '$id_rak'");
                $data_rak = mysqli_fetch_array($data_rak);
                $rak = $data_rak['nama_rak'];
                $req = $request['tgl_req'];
                $date = new DateTime($req);
                $newdate = $date->format('d-m-Y H:i');
                $exp = $request['tgl_exp'];
                $date1 = new DateTime($exp);
                $newExp = $date1->format('d-m-Y H:i');
              ?>
              <td><?php echo $no++; ?></td>
              <td><?php echo $request['judulBuku'];?></td>
              <td><?php echo $rak?></td>
              <td><?php echo $request['nomorAnggota'];?></td>
              <td><?php echo $request['nama'];?></td>
              <td><?php echo $newdate;?></td>
              <td><?php echo $newExp;?></td>
              <td class="text-center">
                <a href="detail-req.php?edit=<?php echo $request['id_req']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Data"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="?tolak=<?php echo $request['id_req']?>" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tolak" type = "button" onClick="return confirm('Tolak Request Buku ??')"><i class="fa-solid fa-circle-xmark"></i></a>
            </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['tolak'])) 
    {
        $result = tolakrequest($_GET);
        if($result)
        {
            $_SESSION['req']= "Data request buku berhasil diubah";
            echo "<script>
                document.location.href = 'data-requestbuku.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>