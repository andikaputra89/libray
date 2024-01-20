<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';

    $data_peminjam = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.status_pinjam ='Belum dikembalikan'");

    //$peminjam = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman LEFT JOIN tb_buku ON tb_peminjaman.id_buku = tb_buku.id_buku LEFT JOIN tb_anggota ON tb_peminjaman.nomoranggota_peminjam = tb_anggota.nomorAnggota WHERE status_pinjam ='Belum dikembalikan'");
    //$result = mysqli_fetch_array($peminjam);

    /*$arr = array();
    while ($result = mysqli_fetch_array($peminjam)) {
      $arr[$result['nama']][]=$result;
    }*/

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
            <h1>Data Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Peminjaman</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if ($_SESSION['id_level']=='2') : ?>
        <a href="tambah-peminjam.php">
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
       <div class="tab-content mt-2">
          <div class="active tab-pane" id="peminjaman">
           <table class="table table-hover" id="table1">
              <thead>
                <tr>
                    <th width="10px">No</th>
                    <th>Nama Peminjam</th>
                    <th width="200px">Judul Buku dipinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Estimasi tgl kembali</th>
                    <th>Status Pinjam</th>
                    <?php if ($_SESSION['id_level']=='2') : ?>
                    <th class="text-center" width="60px">Aksi</th>
                  <?php endif; ?>
                
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_peminjam as $peminjam): ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $peminjam['nama'];?></td>
                  <td><?php echo '('.$peminjam['no_buku'].')'.' '.$peminjam['judulBuku'];?></td>
                  <td><?php echo $peminjam['tgl_pinjam'];?></td>
                  <td><?php echo $peminjam['estimasi_tglkembali'];?></td>
                  <td><?php echo $peminjam['status_pinjam'];?></td>
                  <?php if ($_SESSION['id_level']=='2') : ?>
                  <td class="text-center">
                    <a href="edit-peminjam.php?editpinjam=<?php echo $peminjam['id_pinjam']?>" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit peminjaman"><i class="fa-solid fa-pen-to-square"></i></a>
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
        $result = hapuspeminjam($_GET);
        if($result)
        {
            $_SESSION['peminjam']= "Data Peminjam Berhasil Dihapus";
            echo "<script>
                document.location.href = 'data-peminjaman.php';
                </script>
                ";
        }
    }
      require '../template/footer.php';
      require '../template/script.php';

?>