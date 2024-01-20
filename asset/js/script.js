function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }

        reader.readAsDataURL(file);
    }
}
function isi_otomatis_buku(){
    var no_buku = $("#no_buku").val();
        $.ajax({
            method: 'POST',
            url: '../config/ajaxConfig.php',
            data:{
                'autofillBuku': 1,
                'no_buku':no_buku,
        },
        success:function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#judulBuku').val(obj.judulBuku);
            if (obj.judulBuku != null) {
                $('.btnpinjam').attr('disabled',false);
            }else{
                $('.btnpinjam').attr('disabled',true);
            }
          }
    });
}
function isi_otomatis(){
        var nomorAnggota = $("#nomorAnggota").val();
        $.ajax({
            method:'POST',
            url: '../config/ajaxConfig.php',
            data:{
                'autofillAnggota':1,
                'nomorAnggota':nomorAnggota,
            },
        success:function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#nama').val(obj.nama);
            if (obj.nama != null) {
                $('.datauser').show();
                $('.btnpinjam').attr('disabled',false);
            }else{
                $('.datauser').hide();
                $('.btnpinjam').attr('disabled',true);
            }
            $('#statusanggota').val(obj.status_anggota);
          }
        });
    }

function datapinjam(){
  var nomorAnggota = $("#nomorAnggota").val();
        $.ajax({
            method:'POST',
            url: '../config/ajaxConfig.php',
            data:{
                'datapinjam': 1,
                'nomorAnggota':nomorAnggota,
            },
        success:function (response) {
            $('#tbody').html(response);
            
          }
        });
}

function isi_otomatis2(){
        var nomorAnggota1 = $("#nomorAnggota1").val();
        $.ajax({
            method:'POST',
            url: '../config/ajaxConfig.php',
            data:{
                'autofillAnggota':1,
                'nomorAnggota':nomorAnggota1,
            },

        success:function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#nama2').val(obj.nama);
            if (obj.nama != null) {
                $('.databukupaket').show();
                $('.btnpinjam2').attr('disabled',false);
            }else{
                $('.databukupaket').hide();
                $('.btnpinjam2').attr('disabled',true);
            }
            $('#statusanggota2').val(obj.status_anggota);
          }
        });
    }
function datapinjambkpaket(){
  var nomorAnggota1 = $("#nomorAnggota1").val();
        $.ajax({
            method:'POST',
            url: '../config/ajaxConfig.php',
            data:{
                'datapinjambkpaket':1,
                'nomorAnggota':nomorAnggota1,
            },
        success:function (response) {
            $('#tbodypaket').html(response);
            
          }
        });
}