<?php
 require '../template-user/header.php';

  require '../template-user/navbar.php';

    require '../template-user/sidebar.php';
$data_anggota = $_SESSION['nomerAnggota'];      
$data_req = select("SELECT * FROM tb_reqbuku r LEFT JOIN tb_koleksibuku b ON r.id_buku = b.id_buku WHERE noanggota_req ='$data_anggota' AND status_req != 'Belum Dikonfirmasi'");
$data_req1 = select("SELECT * FROM tb_reqbuku r JOIN tb_koleksibuku b ON r.id_buku = b.id_buku WHERE noanggota_req ='$data_anggota' AND status_req = 'Belum Dikonfirmasi'");

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Request Pinjam Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard-user.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Request Pinjam Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <ul class="nav nav-tabs m-2">
          <li class="nav-item"><a class="nav-link active" href="#belumkonfirmasi" data-toggle="tab">Belum dikonfirmasi</a></li>
          <li class="nav-item"><a class="nav-link" href="#Sudahkonfirmasi" data-toggle="tab">Sudah dikonfirmasi</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="belumkonfirmasi">
            <table class="table table-hover" id="pinjam">
              <?php if ($data_req1 != null): ?>
                <div class="alert alert-info">
                 <small>
                  * Harap segera datang ke perpustakaan<br/>
                  * Jika lewat dari tgl kedaluarsa dianggap batal<br/>
                 </small>
                </div>
              <?php endif; ?>
              <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Rak Buku</th>
                    <th>Tanggal Request</th>
                    <th>Tanggal Kedaluarsa</th>
                    <th>Status Request</th>
                
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_req1 as $request): ?>
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
                  <td><?php echo $newdate;?></td>
                  <td><?php echo $newExp;?></td>
                  <td><?php echo $request['status_req']?></td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="Sudahkonfirmasi">
            <table class="table table-hover" id="kembalibkpaket">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Rak Buku</th>
                    <th>Tanggal Request</th>
                    <th>Tanggal Kedaluarsa</th>
                    <th>Status Request</th>
                
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
                  <td><?php echo $newdate;?></td>
                  <td><?php echo $newExp;?></td>
                  <td><?php echo $request['status_req']?></td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
<?php
      require '../template-user/footer.php';
      require '../template-user/script.php';

?>