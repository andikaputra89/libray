<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
    $tgl_kembali = date('Y-m-d');
    $data_peminjam = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.status_pinjam !='Belum dikembalikan' AND p.tgl_kembali != '$tgl_kembali' ORDER BY p.status_pinjam  DESC");

    $data_peminjamS = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_rak r ON r.id_rak = kb.id_rak WHERE p.status_pinjam !='Belum dikembalikan' AND p.tgl_kembali ='$tgl_kembali'");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pengembalian Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Pengembalian Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
          if(isset($_SESSION['peminjam'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['peminjam']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php 
        unset($_SESSION['peminjam']);
        endif;
        ?>
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link active" href="#sekarang" data-toggle="tab">Sekarang</a></li>
         <li class="nav-item"><a class="nav-link" href="#sebelumnya" data-toggle="tab">Sebelumnya</a></li>
       </ul>
       <div class="tab-content mt-2">
        <div class="active tab-pane" id="sekarang">
            <table class="table table-hover" id="table">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal kembali</th>
                    <th>Telat Pinjam</th>
                    <th>Denda</th>
                    <th class="text-center" width="80px">Aksi</th>
                
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_peminjamS as $peminjam): ?>
                <tr class="<?php if ($peminjam['keterangan'] != null) {
                  echo "text-danger";
                } ?>">
                  <?php
                    if ($peminjam['telat_pinjam'] == 0) {
                      $telatpinjam = "0";
                    }else{
                      $telatpinjam = $peminjam['telat_pinjam']." hari";
                    }
                  ?>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo "(".$peminjam['no_buku'].") ".$peminjam['judulBuku'];?></td>
                  <td><?php echo $peminjam['nama'];?></td>
                  <td><?php echo $peminjam['tgl_pinjam'];?></td>
                  <td><?php echo $peminjam['tgl_kembali'];?></td>
                  <td><?php echo $telatpinjam;?></td>
                  <td><?php echo $peminjam['denda'];?></td>
                  <td class="text-center">
                    <a href="detail-pengembalian.php?detail=<?php echo $peminjam['id_pinjam']?>" class="btn btn-primary text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lihat Detail Peminjam"><i class="fa-solid fa-eye"></i></a>
                    <?php if ($_SESSION['id_level']=='2') : ?>
                    <a href="?delete=<?php echo $peminjam['id_pinjam']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
                  <?php endif; ?>
                </td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <!-- pengembalian sebelumnya -->
          <div class="tab-pane" id="sebelumnya">
            <table class="table table-hover" id="table1">
              <thead>
                <tr>
                    <th>No</th>
                    <th width="150px">Judul Buku</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal kembali</th>
                    <th>Telat Pinjam</th>
                    <th>Denda</th>
                    <th class="text-center" width="70px">Aksi</th>
                
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_peminjam as $peminjam): ?>
                <tr class="<?php if ($peminjam['keterangan'] != null) {
                  echo "text-danger";
                } ?>">
                  <?php
                    if ($peminjam['telat_pinjam'] == 0) {
                      $telatpinjam = "0";
                    }else{
                      $telatpinjam = $peminjam['telat_pinjam']." hari";
                    }
                  ?>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo "(".$peminjam['no_buku'].") ".$peminjam['judulBuku'];?></td>
                  <td><?php echo $peminjam['nama'];?></td>
                  <td><?php echo $peminjam['tgl_pinjam'];?></td>
                  <td><?php echo $peminjam['tgl_kembali'];?></td>
                  <td><?php echo $telatpinjam;?></td>
                  <td><?php echo $peminjam['denda'];?></td>
                  <td class="text-center">
                    <a href="detail-pengembalian.php?detail=<?php echo $peminjam['id_pinjam']?>" class="btn btn-primary text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lihat Detail Peminjam"><i class="fa-solid fa-eye"></i></a>
                    <?php if ($_SESSION['id_level']=='2') : ?>
                    <a href="?delete=<?php echo $peminjam['id_pinjam']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
                  <?php endif; ?>
                </td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>

        </div><!--tab content -->
      </div>
    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['delete'])) 
    {
        $result = hapuspengembalian($_GET);
        if($result)
        {
            $_SESSION['peminjam']= "Data Peminjam Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-pengembalian.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>