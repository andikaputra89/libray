<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
    $data_pinjambukupaket = select("SELECT a.nama, a.nomorAnggota, GROUP_CONCAT(p.no_buku) AS no_buku, GROUP_CONCAT(kb.judulBuku) AS buku, GROUP_CONCAT( p.tgl_pinjam) AS tgl_pinjam , GROUP_CONCAT(p.estimasi_tglkembali) AS estimasi_tglkembali, GROUP_CONCAT(p.tgl_kembali) AS tgl_kembali, GROUP_CONCAT(p.status_pinjam) AS status_pinjam FROM tb_anggota a JOIN tb_pinjambukupaket p ON a.nomorAnggota = p.nomor_anggota JOIN tb_buku b ON b.no_buku = p.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE status_pinjam != 'Belum dikembalikan' GROUP BY p.nomor_anggota");
?>
<style type="text/css">
    table{
        font-size: 0.9rem;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pengembalian Buku Paket</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Pengembalian Buku Paket</li>
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
          <table class="table table-hover" id="table1">
            <thead>
              <tr>
                  <th>No</th>
                  <th width="120px">Nama Peminjam</th>
                  <th>Judul Buku</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tanggal kembali</th>
                  <?php if ($_SESSION['id_level']=='2') : ?>
                  <th class="text-center">Aksi</th>
                   <?php endif; ?>
              
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($data_pinjambukupaket as $peminjam): ?>
              <tr>
                <td><?php echo $no++; ?></td>
                 <td><?php echo $peminjam['nama'];?></td>
                <td>
                  <ul>
                      <?php
                      foreach( array_combine( explode(',', $peminjam['no_buku']),explode(',', $peminjam['buku'])) as $no_buku => $buku ) {
                                echo '<li>'.'('.$no_buku.')' .' ' .$buku . '</li>';
                            }
                      
                      ?>
                  </ul>
                </td>
                <td>
                  <ul>
                      <?php
                      foreach(explode(',', $peminjam['tgl_pinjam']) as $tgl_pinjam) {
                          echo '<li>'. $tgl_pinjam . '</li>';
                      }
                      ?>
                  </ul>
                </td>
                <td>
                  <ul>
                      <?php
                      foreach(explode(',', $peminjam['tgl_kembali']) as $tgl_kembali) {
                          echo '<li>'. $tgl_kembali . '</li>';
                      }
                      ?>
                  </ul>
                </td>
                <?php if ($_SESSION['id_level']=='2') : ?>
                <td class="text-center">
                  <a href="?delete=<?php echo $peminjam['nomorAnggota']?>" class="btn btn-danger alert_notif" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Data" type = "button"><i class="fa-solid fa-trash"></i></a>
                </td>
                <?php endif; ?>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
      </div>
    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['delete'])) 
    {
        $result = hapuspengembaiaanbukupaket($_GET);
        if($result)
        {
            $_SESSION['peminjam']= "Data Pengembalian Buku paket Berhasil Dihapus";
            echo "<script>
                document.location.href = 'pengembalian-bukupaket.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>