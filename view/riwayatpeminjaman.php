<?php
 require '../template-user/header.php';

  require '../template-user/navbar.php';

    require '../template-user/sidebar.php';
$data_anggota = $_SESSION['nomerAnggota'];

$data_peminjaman = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_rak r ON r.id_rak = kb.id_rak WHERE p.nomorAnggota = '$data_anggota' AND p.status_pinjam = 'Belum dikembalikan'");
$data_pengembalian = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_rak r ON r.id_rak = kb.id_rak WHERE p.nomorAnggota = '$data_anggota' AND p.status_pinjam = 'Dikembalikan'");

$data_pinjambukupaket = select("SELECT * FROM tb_pinjambukupaket p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.nomor_anggota = '$data_anggota' AND status_pinjam = 'Belum dikembalikan'");
$data_kembalibukupaket = select("SELECT * FROM tb_pinjambukupaket p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.nomor_anggota = '$data_anggota' AND status_pinjam = 'Dikembalikan'");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Riwayat Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard-user.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Riwayat Peminjaman</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills ">
                  <li class="nav-item"><a class="nav-link active" href="#Peminjaman" data-toggle="tab">Peminjaman</a></li>
                  <li class="nav-item"><a class="nav-link" href="#pengembalian" data-toggle="tab">Sudah Dikembalikan</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="Peminjaman">
                    <h6><b>Peminjaman Buku Bacaan</b></h6>
                    <table class="table table-hover" id="pinjam">
                      <thead>
                        <tr>
                            <th>No Buku</th>
                            <th>Judul Buku</th>
                            <th>Rak Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Estimasi Tgl Kembali</th>
                            <th>Status Pinjam</th>
                        
                        </tr>
                      </thead>
                      <tbody >
                        <?php $no = 1; ?>
                        <?php foreach ($data_peminjaman as $peminjam): ?>
                        <tr>
                          <td><?php echo $peminjam['no_buku'];?></td>
                          <td><?php echo $peminjam['judulBuku'];?></td>
                          <td><?php echo $peminjam['nama_rak']?></td>
                          <td><?php echo $peminjam['tgl_pinjam'];?></td>
                          <td><?php echo $peminjam['estimasi_tglkembali']?></td>
                          <td><?php echo $peminjam['status_pinjam']?></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <!--peminjaman buku paket -->
                    <h6 class="mt-5"><b>Peminjaman Buku Paket</b></h6>
                    <table class="table table-hover" id="pinjambkpaket">
                      <thead>
                        <tr>
                          <th>No Buku</th>
                          <th>Judul Buku</th>
                          <th>Tanggal Pinjam</th>
                          <th width="50px">Estimasi pengembalian</th>
                          <th>Status Pinjam</th>                        
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data_pinjambukupaket as $peminjam): ?>
                        <tr>
                          <td><?php echo $peminjam['no_buku'];?></td>
                          <td><?php echo $peminjam['judulBuku'];?></td>
                          <td><?php echo $peminjam['tgl_pinjam'];?></td>
                          <td><?php echo $peminjam['estimasi_tglkembali']?></td>
                          <td><small><?php echo $peminjam['status_pinjam']?></small></td>
                        </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="pengembalian">
                    <ul class="nav nav-tabs ">
                      <li class="nav-item"><a class="nav-link active" href="#bukubacaan" data-toggle="tab">Buku Bacaan</a></li>
                      <li class="nav-item"><a class="nav-link" href="#bukupaket" data-toggle="tab">Buku Paket</a></li>
                    </ul>
                    <div class="tab-content"><!-- tab content pemngembalian -->
                      <div class="active tab-pane" id="bukubacaan">
                        <!-- The pengembalian -->
                        <table class="table table-hover" id="kembali">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th width="200px">Judul Buku</th>
                                <th>Rak Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Telat Pinjam</th>
                                <th>Denda</th>
                                <th>Status Pinjam</th>
                            
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_pengembalian as $kembali): ?>
                            <tr>
                              <?php
                                if ($kembali['telat_pinjam'] == 0) {
                                  $telatpinjam = "0";
                                }else{
                                  $telatpinjam = $kembali['telat_pinjam']." hari";
                                }
                              ?>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo $kembali['judulBuku'];?></td>
                              <td><?php echo $kembali['nama_rak']?></td>
                              <td><?php echo $kembali['tgl_pinjam'];?></td>
                              <td><?php echo $kembali['tgl_kembali']?></td>
                              <td><?php echo $telatpinjam?></td>
                              <td><?php echo $kembali['denda']?></td>
                              <td><?php echo $kembali['status_pinjam']?></td>
                            </tr>
                            <?php endforeach;?>
                          </tbody>
                        </table>
                      </div><!-- penutup tab pane -->
                      <!-- tab pane pengembalian buku paket -->
                      <div class="tab-pane" id="bukupaket">
                        <!-- The pengembalian Buku paket-->
                        <table class="table table-hover" id="kembalibkpaket">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>No Buku</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status Pinjam</th>
                            
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_kembalibukupaket as $kembali): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo $kembali['no_buku'];?></td>
                              <td><?php echo $kembali['judulBuku'];?></td>
                              <td><?php echo $kembali['tgl_pinjam'];?></td>
                              <td><?php echo $kembali['tgl_kembali']?></td>
                              <td><?php echo $kembali['status_pinjam']?></td>
                            </tr>
                            <?php endforeach;?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>   
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
      </div>

    </section>
    <!-- /.content -->
  </div>

<?php
      require '../template-user/footer.php';
      require '../template-user/script.php';

?>