<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
$id_buku= $_GET['edit'];
if (isset($_POST['edit'])) {
      $result = edit_buku($_POST);

         if ($result) {
            $_SESSION['buku']= "Data Buku Berhasil Diubah";
            echo "<script>
                document.location.href = 'data-buku.php';
                </script>
                ";
         }

   }
   
   $data_buku = select("SELECT * FROM tb_koleksibuku b LEFT JOIN tb_rak r ON b.id_rak = r.id_rak LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori WHERE id_buku = '$id_buku'")[0];
   $buku = select("SELECT * FROM tb_buku WHERE id_buku = $id_buku");
   @$buku1 = select("SELECT * FROM tb_buku WHERE id_buku = $id_buku")[0];
   $data_rak = select("SELECT * FROM tb_rak");
   $data_kategori = select("SELECT * FROM tb_kategori");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-buku.php">Data Buku</a></li>
              <li class="breadcrumb-item active">Edit Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="card">    
      <h5 class="card-header">Form Edit Buku</h5>
      <div class="card-body">
         <form method="POST" id="deleteform"></form>
         <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-6">
                  <input type="hidden" name="id_buku" id="id_buku" value="<?php echo $id_buku ;?>">
                  <input type="hidden" name="coverLama" value="<?php echo $cover ?>">
                  <div class="mb-1">
                     <label class="form-label">Judul Buku</label>
                     <input type="text" class="form-control" name="judulBuku" placeholder="Masukan Judul Buku" value="<?php echo $data_buku ['judulBuku']; ?>" required>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Penerbit</label>
                     <input type="text" class="form-control" name="penerbit" placeholder="Masukan Penerbit" value="<?php echo $data_buku ['penerbit']; ?>" required>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Penulis</label>
                     <input type="text" class="form-control" name="penulis" placeholder="Masukan Penulis" value="<?php echo $data_buku ['penulis']; ?>" required>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Tahun Terbit</label>
                     <select name="tahunTerbit" class="custom-select">
                        <?php for($i=2022;$i>1980;$i--) {?>
                        <option value="<?php echo $i;?>"<?php if ($data_buku['tahunTerbit']==$i) echo 'selected="selected"';?>> <?php echo $i;?> </option>
                        <?php }?>                                    
                     </select>
               </div>
                  <div class="mb-1">
                     <label class="form-label">Kategori Buku</label>
                     <select class="custom-select" name="kategori">
                        <?php foreach ($data_kategori as $kategori): ?>
                           <option value="<?php echo $kategori['id_kategori'];?>"<?php if($data_buku['nama_kategori'] == $kategori['nama_kategori'])echo 'selected="selected"';?>><?php echo $kategori['nama_kategori'];?></option>
                        <?php endforeach; ?>  
                     </select>
                  </div>
               </div><!--col-md-6 -->
               <div class="col-md-6">
                  <div class="mb-1">
                     <label class="form-label">Rak Buku</label>
                     <select class="custom-select" name="rak">
                        <?php foreach ($data_rak as $rak): ?>
                           <option value="<?php echo $rak['nama_rak'];?>"<?php if($data_buku['nama_rak'] == $rak['nama_rak'])echo 'selected="selected"';?>><?php echo $rak['nama_rak'];?></option>
                        <?php endforeach; ?>  
                     </select>
                  </div>
                  <div class="mb-1">
                     <label class="form-label mt-2 mb-2">Jumlah Eksemplar</label>
                     <button type="button" class="btn btn-primary btn-sm ml-2" id="tambah">
                     Tambah 
                     </button>
                     <div class="Eksemplar" style="max-height: 200px; overflow-y: auto; overflow-x: hidden;">
                        <?php 
                              $id_buku = $buku1['id_buku'];
                              $query = mysqli_query($koneksi,"SELECT no_buku FROM tb_buku WHERE id_buku = '$id_buku'");
                              $jml_data = mysqli_num_rows($query);
                        ?>
                        <?php foreach ($buku as $buku ): ?>
                           <div class="form-row">
                              <div class="col-5">
                                  <label class="form-label">Nomer Buku</label>
                                  <input type="text" class="form-control" name="no_buku[]" placeholder="Masukan No Buku" readonly value="<?= $buku['no_buku']; ?>">
                              </div>
                              <div class="col-5">
                                  <label class="form-label">Status</label>
                                  <select class="custom-select" name="stokBuku[]">
                                      <option value="1" <?php if($buku['stokBuku'] == '1') echo 'selected="selected"'?>>Tersedia</option>
                                      <option value="0" <?php if($buku['stokBuku'] == '0') echo 'selected="selected"'?>>Tidak Tersedia</option>
                                  </select>
                              </div>
                              <div class="col-2">
                                <button type="button" class="btn btn-danger btn-sm btnhapus" onClick="hapus('<?= $buku['no_buku']; ?>')" style="margin-top:33px;">Hapus</button>
                              </div>
                           </div>
                        <?php endforeach; ?>
                           <template id="form-tambah">
                              <div class="form-row">
                                  <div class="col-5">
                                      <label class="form-label">Nomer Buku</label>
                                      <input type="text" class="form-control no_buku" name="no_buku[]" placeholder="Masukan No Buku" id="no_buku{{index}}" required>
                                  </div>
                                  <div class="col-5">
                                      <label class="form-label">Status</label>
                                      <select class="custom-select" name="stokBuku[]">
                                          <option value="1">Tersedia</option>
                                          <option value="0">Tidak Tersedia</option>
                                      </select>
                                  </div>
                                  <div class="col-2">
                                      <button class="btn btn-danger btn-sm hapus" style="margin-top:33px;">Hapus</button>
                                  </div>
                              </div>
                           </template> 
                             <div class="view"></div>
                             <span id="pesan"></span>
                         </div>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Deskripsi Buku</label>
                     <textarea class="form-control" name="deskripsi" placeholder="Masukan Deskripsi Buku" style="height: 100px"><?php echo $data_buku['deskripsi'] ?></textarea>
                  </div>
                  <div class="mb-1">
                     <label class="form-label">Cover Buku</label>
                     <input type="file" class="form-control" name="cover" id="cover" accept="image/*" onchange="previewFile(this);" >
                     <small>Preview cover</small><br>
                     <?php if (empty($data_buku['cover'])) { ?>
                        <img src="../asset/dist/img/cover_default.jpeg" class="img-thumbnail" width="100px"id="previewImg">
                    <?php } else { ?>    
                     <img src="../asset/cover/<?php echo $data_buku['cover']; ?>" class="img-thumbnail" width="100px"id="previewImg">
                     <?php } ?>
                  </div>
               </div>

            </div><!-- row -->
            <button type="submit" name="edit" class="btn btn-primary float-right m-3" id="simpanbuku">
            Simpan Perubahan
            </button>
            <a href="data-buku.php" class="btn btn-danger float-right mt-3">Kembali</a>
         </form>
      </div>
   </div>

    </section>
    <!-- /.content -->
  </div>
<script>
$(document).ready(function(){
    $(document).on('click','.hapus' , function(){
        $(this).closest('.form-row').remove();

    });
    var index = 0
    $("#tambah").click(()=>{
    //untuk ubah id supaya unik
    var form = $("#form-tambah").html().replace(/{{index}}/g, index);    
    $(".view").append(form)
    index++
  })
});
$(document).on("input", ".no_buku", function(){
    $(this).attr("id"), $(this).val()
        $.ajax({
            url     :'../config/ajaxConfig.php',
            method  :'POST',
            data    : {
                "checknobuku": 1,
                "no_buku" : $(this).val(),
            },
            success : function(data){
                if (data == 0) {
                    if ($('.no_buku').val().length == 0) {
                        $('#pesan').hide();  
                    }else{
                        $('#pesan').show();
                    }
                    $('#pesan').html('<i class="fa-solid fa-check text-success"></i> <span class="text-success">Nomer Buku belum terdaftar</span>');
                    $('#tambah').attr("disabled",false);
                    $('#simpanbuku').attr("disabled",false);
                }
                else{
                    $('#pesan').html('<i class="fa-solid fa-exclamation text-danger"></i> <span class="text-danger">Nomer Buku sudah terdaftar</span>');
                    $('#tambah').attr("disabled",true);
                    $('#simpanbuku').attr("disabled",true);
                }
            }
        });
});

function hapus(no_buku){
    if (confirm("Apakah yakin ingin menghapus eksemplar buku?")) {
            $.ajax({
            method:'POST',
            url :'../config/ajaxConfig.php',
            data:{
                'hapusEksemplar': 1,
                'no_buku':no_buku,
            },

            success:function(response){
                if (response == "sukses") {
                    Swal.fire({
                      position: 'top',
                      title: 'Data eksemplar buku berhasil dihapus',
                      icon: 'success',
                      showConfirmButton: false,
                    })
                }else{
                    alert ("Data eksemplar buku gagal dihapus");
                }
                setInterval('location.reload()',2000);
            }
        })
    }
    return false;
    
}
</script>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>