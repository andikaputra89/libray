<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

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
            <h1>Data Peminjaman Buku Paket</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Peminjaman Buku Paket</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
        <a href="tambah-peminjambukupaket.php">
            <button class="btn btn-primary mb-1"><i class="fa fa-plus"></i> Tambah Peminjam</button>
        </a>
      <?php endif; ?> 
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
              <tr class="text-center th">
                  <th>No</th>
                  <th width="120px">Nama Peminjam</th>
                  <th class="text-left">Judul Buku dipinjam</th>
                  <th>Tanggal Pinjam</th>
                  <th width="25px">Tanggal kembali</th>
                  <?php if ($_SESSION['id_level']=='2') : ?>
                  <th class="text-center">Aksi</th>
                  <?php endif; ?>
            </tr>
            </thead>
        <?php
 
        // query sql
        $sql = "SELECT a.nama, a.nomorAnggota, GROUP_CONCAT(kb.judulBuku) AS buku, GROUP_CONCAT(b.no_buku) AS no_buku, GROUP_CONCAT( p.tgl_pinjam) AS tgl_pinjam , GROUP_CONCAT(p.estimasi_tglkembali) AS estimasi_tglkembali, p.tgl_kembali AS tgl_kembali, GROUP_CONCAT(p.status_pinjam) AS status_pinjam FROM tb_anggota a JOIN tb_pinjambukupaket p ON a.nomorAnggota = p.nomor_anggota JOIN tb_buku b ON b.no_buku = p.no_buku  JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.status_pinjam = 'Belum dikembalikan' GROUP BY p.nomor_anggota";
 
        // jalankan query sql
        $res = mysqli_query($koneksi, $sql);
        $no = 1;
        if($res) {
          ?> <tbody> <?php
            while($data = mysqli_fetch_array($res)): ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td class="text-left">
                        <ul>
                            <?php
                            foreach( array_combine( explode(',', $data['no_buku']),explode(',', $data['buku'])) as $no_buku => $buku ) {
                                echo '<li>'.'('.$no_buku.')' .' ' .$buku . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <?php
                            foreach(explode(',', $data['tgl_pinjam']) as $tanggal_pinjam) {
                                echo '<li>'. $tanggal_pinjam . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                    <td>
                        <?= $data['tgl_kembali'] ?>
                    </td>
                    <?php if ($_SESSION['id_level']=='2') : ?>
                    <td class="text-center">
                      <a href="edit-peminjam_bukupaket.php?editpinjam=<?php echo $data['nomorAnggota']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit peminjaman"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                  <?php endif;?>
                </tr>
            <?php endwhile;

            }
            ?>
            </tbody>
        </table>

      </div>
    </section>
    <!-- /.content -->
  </div>

<?php
if (isset($_GET['delete'])) 
    {
        $result = hapuspeminjambukupaket($_GET);
        if($result)
        {
            $_SESSION['peminjam']= "Data Peminjam Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-pinjambukupaket.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>