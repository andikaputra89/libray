<?php
 require '../template/header.php';

  require '../template/navbar.php';

    require '../template/sidebar.php';
if (isset($_POST['add'])) {

     if (tambah_buku($_POST) > 0) {
        $_SESSION['buku']= "Data Buku Berhasil Ditambahkan";
        echo "<script>
            document.location.href = 'data-buku.php';
            </script>
            ";
     } else{
        $_SESSION['failed'] = "Data Buku Gagal Ditambahkan";
        $_SESSION['failed_icon'] = "error";
        echo "<script>
            document.location.href = 'tambah-buku.php';
            </script>
            ";
        exit();
     }

   }
   $data_rak = select("SELECT * FROM tb_rak");
   $data_kategori = select("SELECT * FROM tb_kategori");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item "><a href="data-buku.php">Data Buku</a></li>
              <li class="breadcrumb-item active">Tambah Buku</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">    
          <h5 class="card-header">Form tambah buku</h5>
          <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" name="judulBuku" placeholder="Masukan Judul Buku" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" placeholder="Masukan Penerbit" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" placeholder="Masukan Penulis" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Tahun Terbit</label>
                            <select name="tahunTerbit" class="custom-select">
                            <?php for($i=2022;$i>1980;$i--) {?>
                            <option value="<?=$i?>"> <?=$i?> </option>
                            <?php }?>                                    
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Kategori Buku</label>
                            <select class="custom-select" name="kategori" required="true">
                                <option disabled selected>--Pilih Kategori--</option>
                                <?php foreach ($data_kategori as $kategori): ?>
                                <option value="<?php echo $kategori['id_kategori'];?>"><?php echo $kategori['nama_kategori'];?></option>
                                <?php endforeach ?>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="mb-1">
                            <label class="form-label">Rak Buku</label>
                            <select class="custom-select" name="rak" required>
                            <option disabled selected>--Pilih Rak--</option>
                            <?php foreach ($data_rak as $rak): ?>
                               <option value="<?php echo $rak['id_rak'];?>"><?php echo $rak['nama_rak'];?></option>
                            <?php endforeach ?>  
                            </select>
                        </div> 
                        <div class="mb-1">
                            <label class="form-label mt-2 mb-2">Jumlah Eksemplar</label>
                            <button type="button" class="btn btn-primary btn-sm ml-2" id="tambah">
                            Tambah 
                            </button>
                            <div class="Eksemplar" style="max-height: 200px; overflow-y: auto; overflow-x: hidden;">
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
                            <textarea class="form-control" name="deskripsi" placeholder="Masukan Deskripsi Buku" style="height: 90px"></textarea>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Cover Buku</label><br>
                            <small>Ukuran file max 3 MB (JPG,PNG,JPEG)</small>
                            <input type="file" class="form-control" name="cover" id="cover" accept="image/*" onchange="previewFile(this);" >
                            <img src="" class="img-thumbnail mt-2" width="100px" id="previewImg">
                        </div>
                   </div>
             </div>
             <button type="submit" name="add" class="btn btn-primary float-right m-3" id="simpanbuku" disabled> Simpan </button>
             <a href="data-buku.php" class="btn btn-danger float-right m-3">Kembali</a>
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
                    $('.no_buku').css({"border":"1px","border-style":"solid","border-color":"green"});
                    $('#pesan').html('<i class="fa-solid fa-check text-success"></i> <span class="text-success">Nomer Buku belum terdaftar</span>');
                    $('#tambah').attr("disabled",false);
                    $('#simpanbuku').attr("disabled",false);
                }
                else{
                    $('.no_buku').css({"border":"1px","border-style":"solid","border-color":"red"});
                    $('#pesan').html('<i class="fa-solid fa-exclamation text-danger"></i> <span class="text-danger">Nomer Buku sudah terdaftar</span>');
                    $('#tambah').attr("disabled",true);
                    $('#simpanbuku').attr("disabled",true);
                }
            }
        });
});

</script>
<?php
      require '../template/footer.php';
      require '../template/script.php';

?>