<?php
require_once 'validateUpload.php';
function select($query)
{
	global $koneksi;

	$result		= mysqli_query($koneksi,$query);
	$rows 		= [];

	while ($row = mysqli_fetch_assoc($result)) {
		$rows[]	= $row;
		
	}
	return $rows;

}

function tambah_buku($data)
{
	global $koneksi;
	$no_buku		= $data['no_buku'];
	$judulBuku 		= $data['judulBuku'];
	$penerbit 		= $data['penerbit'];
	$penulis 		= $data['penulis'];
	$tahunTerbit 	= $data['tahunTerbit'];
	@$kategori		= $data['kategori'];
	@$rakbuku		= $data['rak'];
	$stokBuku 		= $data['stokBuku'];
	$cover 			= uploadfile();
	$deskripsi		= $data['deskripsi'];

	if ($no_buku == null) {
		$_SESSION['failed'] = "Buku Gagal Ditambahkan Karena No buku kosong";
		$_SESSION['failed_icon'] = "error";
		echo "<script>
			document.location.href = 'tambah-buku.php';
			</script>
		";
		die();
	}
	if ($kategori == null AND $rakbuku == null) {
		$_SESSION['failed'] = "Buku Gagal Ditambahkan Karena Kategori atau Rak buku kosong";
		$_SESSION['failed_icon'] = "error";
		echo "<script>
			document.location.href = 'tambah-buku.php';
			</script>
		";
		die();
	}

	$tambahkoleksi 	= mysqli_query($koneksi,"INSERT INTO tb_koleksibuku VALUES (null,'$judulBuku','$penerbit','$penulis','$rakbuku','$kategori','$tahunTerbit','$cover','$deskripsi')");
	$id_buku		  	= select("SELECT max(id_buku) AS id_buku FROM tb_koleksibuku LIMIT 1")[0];
	$buku 			= $id_buku['id_buku'];
	foreach ($no_buku as $index => $no) {
		$s_nobuku = $no;
		$stok = $stokBuku[$index];

		$query ="INSERT INTO tb_buku VALUES ($buku,'$s_nobuku','$stok')";
		$result = mysqli_query($koneksi,$query);
	}

	return mysqli_affected_rows($koneksi);
}
//edit Buku
function edit_buku($data){
	global $koneksi;
	$id_buku 		= $data['id_buku'];
	@$no_buku		= $data['no_buku'];
	$judulBuku		= $data['judulBuku'];
	$penerbit 		= $data['penerbit'];
	$penulis 		= $data['penulis'];
	$tahunTerbit 	= $data['tahunTerbit'];
	@$stokBuku 		= $data['stokBuku'];
	$id_kategori   	= $data['kategori'];
	$rakbuku 		= $data['rak'];
	$coverLama		= $data['coverLama'];
	$deskripsi		= $data['deskripsi'];

	$queryShow = "SELECT * FROM tb_koleksibuku WHERE id_buku = '$id_buku'";
	$sql = mysqli_query($koneksi,$queryShow);
	$hasil = mysqli_fetch_array($sql);

	if ($_FILES['cover']['name'] == "") {
		$cover = $hasil['cover'];
			
	}else{
		@unlink("../asset/cover/".$hasil['cover']);
		$cover = uploadfile();
	}

	$queryrak = mysqli_query($koneksi,"SELECT id_rak FROM tb_rak WHERE nama_rak = '$rakbuku'");
	$data_rak = mysqli_fetch_array($queryrak);
	$rak_buku = $data_rak['id_rak'];

	$query = mysqli_query($koneksi,"UPDATE tb_koleksibuku SET judulBuku = '$judulBuku', penerbit='$penerbit', penulis = '$penulis', id_rak ='$rak_buku',id_kategori = '$id_kategori', tahunTerbit= '$tahunTerbit',deskripsi = '$deskripsi',cover='$cover' WHERE id_buku = '$id_buku'");
	if ($no_buku != null) {

		foreach ($no_buku as $index => $no) {
		$s_nobuku = $no;
		$stok = $stokBuku[$index];
		$query ="INSERT INTO tb_buku VALUES ($id_buku,'$s_nobuku','$stok')";
		$result = mysqli_query($koneksi,$query);
		
		}
		foreach ($no_buku as $index => $no) {
			$s_nobuku = $no;
			$stok = $stokBuku[$index];
			$query = mysqli_query($koneksi,"UPDATE tb_buku SET stokBuku='$stok' WHERE id_buku ='$id_buku' AND no_buku = '$s_nobuku'");
		}
		$_SESSION['failed']="Data Buku berhasil diubah";
				$_SESSION['failed_icon']="success";
				echo "<script>
				document.location.href = 'edit-buku.php?edit=$id_buku';
				</script>";
				exit();

	}

	return mysqli_affected_rows($koneksi);
}
function hapusBuku($data){
	global $koneksi;
	$id_buku 	= $data['delete'];

	$no_buku = select("SELECT no_buku FROM tb_buku WHERE id_buku = '$id_buku'");
	foreach ($no_buku as $nobuku) {
		$noBuku = $nobuku['no_buku'];
		$checkpinjam = mysqli_query($koneksi,"SELECT no_buku FROM tb_peminjaman WHERE no_buku = '$noBuku' AND status_pinjam != 'Dikembalikan'");
		$checkpinjambukupaket = mysqli_query($koneksi,"SELECT no_buku FROM tb_pinjambukupaket WHERE no_buku = '$noBuku' AND status_pinjam != 'Dikembalikan'");
		$datapinjam = mysqli_num_rows($checkpinjam);
		$datapinjambukupaket = mysqli_num_rows($checkpinjambukupaket);

		if ($datapinjam != 0 || $datapinjambukupaket != 0) {
			$_SESSION['failed'] = "Buku gagal di hapus karena masih dipinjam";
			$_SESSION['failed_icon']= "error";
			echo "<script>
			document.location.href = 'data-buku.php';
			</script>";
			die();
		} else{
			$deleteImg 	= "SELECT * FROM tb_koleksibuku WHERE id_buku='$id_buku'";
			$sql 		= mysqli_query($koneksi,$deleteImg);
			$hasil 		= mysqli_fetch_array($sql);

			unlink("../asset/cover/".$hasil['cover']);

			$delete 	= "DELETE FROM tb_koleksibuku WHERE id_buku = '$id_buku'";

			$result = mysqli_query($koneksi,$delete);
		}
	}

	return mysqli_affected_rows($koneksi);
}
function hapuseksemplar($data){
	global $koneksi;
	$no_buku = $data['hapus'];

	$checkpinjam = mysqli_query($koneksi,"SELECT no_buku FROM tb_peminjaman WHERE no_buku = '$no_buku' AND status_pinjam != 'Dikembalikan'");
	$checkpinjambukupaket = mysqli_query($koneksi,"SELECT no_buku FROM tb_pinjambukupaket WHERE no_buku = '$no_buku' AND status_pinjam != 'Dikembalikan'");

	$datapinjam = mysqli_num_rows($checkpinjam);
	$datapinjambukupaket = mysqli_num_rows($checkpinjambukupaket);

	if ($datapinjam != 0 || $datapinjambukupaket != 0) {
		$_SESSION['failed'] = "Buku Gagal Dihapus karena masih dipinjam";
		$_SESSION['failed_icon'] = "error";
		echo "<script>
			document.location.href = 'data-buku.php';
			</script>";
			die();
	} else {
		$hapus = mysqli_query($koneksi,"DELETE FROM tb_buku WHERE no_buku = '$no_buku'");
	}

	return mysqli_affected_rows($koneksi);
}
function tambah_kategori($data){
	global $koneksi;
	$namaKategori	= $data['nama_kategori'];

	$kategori = mysqli_query($koneksi,"SELECT nama_kategori FROM tb_kategori WHERE nama_kategori = '$namaKategori'");
	$cek = mysqli_num_rows($kategori);

	if ($cek != 0) {
		$_SESSION['failed'] = 'Nama kategori Sudah Ada';
		$_SESSION['failed_icon'] = 'warning';
		echo "<script>
			document.location.href = 'data-kategori.php';
			</script>
		";
		die();

	}
	$query 		="INSERT INTO tb_kategori VALUES(null,'$namaKategori')";
	$result		= mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi);
}
function hapus_kategori($data){
	global $koneksi;
	$id_kategori	=$data['delete'];
	if($id_kategori == '1'){
		return false;
	}
	$delete = "DELETE FROM tb_kategori WHERE id_kategori = '$id_kategori'";

	$result = mysqli_query($koneksi,$delete);

	return mysqli_affected_rows($koneksi);
}
function edit_kategori($data){
	global $koneksi;
	$id_kategori = $data['id_kategori'];
	$namaKategori = $data['nama_kategori'];

	$query ="UPDATE tb_kategori SET nama_kategori = '$namaKategori' WHERE id_kategori = '$id_kategori'";
	$result = mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi); 
}
function tambah_rak($data){
	global $koneksi;
	$kode_rak	= $data['kode_rak'];
	$nama_rak	= $data['nama_rak'];

	$query 		="INSERT INTO tb_rak VALUES(null,'$kode_rak','$nama_rak')";
	$result		= mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi);
}
function edit_rak($data){
	global $koneksi;
	$id_rak		= $data['id_rak'];
	$kode_rak	= $data['kode_rak'];
	$nama_rak	= $data['nama_rak'];

	$query ="UPDATE tb_rak SET kode_rak = '$kode_rak', nama_rak = '$nama_rak' WHERE id_rak = '$id_rak'";
	$result = mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi); 
}
function hapus_rak($data){
	global $koneksi;
	$id_rak	=$data['delete'];

	$delete = "DELETE FROM tb_rak WHERE id_rak = '$id_rak'";

	$result = mysqli_query($koneksi,$delete);

	return mysqli_affected_rows($koneksi);
}
function tambah_anggota($data){
	global $koneksi;

	$nomorAnggota 	= $data ['nomorAnggota']; 
	$nama 			= $data ['nama'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$status			= $data ['status'];
	$fotoprofil		= fotoprofil();
	$username		= $data ['username'];
	$password		= md5($data ['password']); 

	$data_anggota = mysqli_query($koneksi,"SELECT nomorAnggota FROM tb_anggota WHERE nomorAnggota = '$nomorAnggota'");
	$result 	  = mysqli_num_rows($data_anggota);

	if ($result != 0) {
		$_SESSION['failed']='Nomor Anggota sudah terdaftar';
		$_SESSION['failed_icon'] ='warning';
		echo "<script>
			document.location.href = 'tambah-anggota.php';
			</script>
		";
		die();
	}

	$data_status= mysqli_query($koneksi,"SELECT id_status FROM status_anggota WHERE status_anggota ='$status'");
	$data_status	= mysqli_fetch_array($data_status);
	$status_anggota = $data_status['id_status'];

	$tambahAnggota = mysqli_query($koneksi,"INSERT INTO tb_anggota VALUES ('$nomorAnggota','$nama','$jenis_kelamin','$no_hp','$alamat','$fotoprofil','$status_anggota')");
	$tambahAkun		= mysqli_query($koneksi,"INSERT INTO tb_user (username,nama,password,id_level,nomerAnggota) VALUES ('$nomorAnggota','$nama','$password','3','$nomorAnggota')");
	return mysqli_affected_rows($koneksi);
}
function edit_anggota($data){
	global $koneksi;

	$nomorAnggota 	= $data ['nomorAnggota'];
	$nama 			= $data ['nama'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$status			= $data ['status'];
	

	$queryShow = "SELECT * FROM tb_anggota WHERE nomorAnggota = '$nomorAnggota'";
	$sql = mysqli_query($koneksi,$queryShow);
	$hasil = mysqli_fetch_array($sql);

	if ($_FILES['foto']['name'] == "") {
		$fotoprofil = $hasil['foto'];
			
	}else{
		@unlink("../asset/foto/".$hasil['foto']);
		$fotoprofil	= fotoprofil();
	}
	$data_status = mysqli_query($koneksi,"SELECT id_status FROM status_anggota WHERE status_anggota = '$status'");
	$data_status = mysqli_fetch_array($data_status);
	$status = $data_status['id_status'];

	$query 	= "UPDATE tb_anggota SET nama ='$nama', jenis_kelamin = '$jenis_kelamin',no_hp ='$no_hp',alamat ='$alamat',foto='$fotoprofil',id_statusanggota='$status' WHERE nomorAnggota ='$nomorAnggota'";
	$result	= mysqli_query($koneksi,$query);

	$user 		= select("SELECT nama FROM tb_user WHERE nomerAnggota = $nomorAnggota")[0];
	$namauser 	= $user['nama'];

	if ($namauser != $nama) {
		$updatenamauser = mysqli_query($koneksi,"UPDATE tb_user SET nama = '$nama' WHERE nomerAnggota = '$nomorAnggota'");
	}
	return mysqli_affected_rows($koneksi); 
	$updateakun = mysqli_query($koneksi,"UPDATE tb_user SET nama = '$nama' WHERE nomerAnggota ='$nomorAnggota'");

	return mysqli_affected_rows($koneksi); 

}
function edit_akunanggota($data){
	global $koneksi;
	$username = $data['username'];
	$password = md5($data['password']);
	$updateakun = mysqli_query($koneksi,"UPDATE tb_user SET password = '$password' WHERE username = '$username'");
	return mysqli_affected_rows($koneksi);

}

function hapus_anggota($data){
	global $koneksi;
	$nomorAnggota 	= $data['delete'];

	$checkanggota = mysqli_query($koneksi,"SELECT nomorAnggota FROM tb_peminjaman WHERE nomorAnggota = '$nomorAnggota' AND status_pinjam !='Dikembalikan'");
	$checkanggota2= mysqli_query($koneksi,"SELECT nomor_anggota FROM tb_pinjambukupaket WHERE nomor_anggota = '$nomorAnggota' AND status_pinjam !='Dikembalikan'");
	$data_pinjam = mysqli_num_rows($checkanggota);
	$data_pinjambukupaket = mysqli_num_rows($checkanggota2);

	if($data_pinjam != 0 || $data_pinjambukupaket != 0){
		$_SESSION['failed']="Data anggota gagal dihapus karena terdapat di transaksi peminjaman";
		$_SESSION['failed_icon']="error";
		echo "<script>
			document.location.href = 'data-anggota.php';
			</script>";

		die();
	}else{
		$deleteImg 	= "SELECT * FROM tb_anggota WHERE nomorAnggota='$nomorAnggota'";
		$sql 		= mysqli_query($koneksi,$deleteImg);
		$hasil 		= mysqli_fetch_array($sql);
		unlink("../asset/foto/".$hasil['foto']);

		$query 		="DELETE FROM tb_anggota WHERE nomorAnggota ='$nomorAnggota'";
		$result		= mysqli_query($koneksi,$query);
	}
	return mysqli_affected_rows($koneksi);
}
function update_passwordA($data){
	global $koneksi;
	$username = $data['username'];
   	$password = md5($data['password']);
   	$password1 = md5($data['password1']);
   	$password2 = md5($data['password2']);

   
   $passwordA = mysqli_query($koneksi,"SELECT password FROM tb_user WHERE username = '$username'");
   $result= mysqli_fetch_array($passwordA);
   $pass= $result['password'];

   if ($pass!=$password) {

	    $_SESSION['succes']='Password Lama salah';
       $_SESSION['succes_icon']='error';
       echo "<script>document.location.href = 'biodata-user.php';
          </script>
            ";
            exit();
	     die();

   } else if($password1 != $password2){
      	$_SESSION['succes']='Konfirmasi Password salah';
          $_SESSION['succes_icon']='error';
         echo "<script>document.location.href = 'biodata-user.php';
         </script>
         ";
         exit();
         die();
     
   }else {
      $query = mysqli_query($koneksi,"UPDATE tb_user SET password = '$password1' WHERE username ='$username'");
      }
      return mysqli_affected_rows($koneksi);
   
}
function tambah_pegawai($data){
	global $koneksi;
	$nomer_pegawai = $data ['nomer_pegawai'];
	$nama 			= $data ['nama'];
	$tempat_lahir	= $data ['tempat_lahir'];
	$tgl_lahir		= $data ['tgl_lahir'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$fotoprofil		= fotoprofil();
	$password		= md5($data ['password']);
	$jabatan		= "Staft Perpustakaan";

	$data_pegawai = mysqli_query($koneksi,"SELECT nomer_pegawai FROM tb_staff WHERE nomer_pegawai = '$nomer_pegawai'");
	$result 	  = mysqli_num_rows($data_pegawai);

	if ($result != 0) {
		$_SESSION['failed']='NIP Atau NIK sudah terdaftar';
		$_SESSION['failed_icon'] ='warning';
		echo "<script>
			document.location.href = 'tambah-pegawai.php';
			</script>
		";
		die();
	}
	$tambah_pegawai	= mysqli_query($koneksi,"INSERT INTO tb_staff VALUES ('$nomer_pegawai','$nama','$tempat_lahir','$tgl_lahir','$jenis_kelamin','$no_hp','$alamat','$fotoprofil','$jabatan')"); 
	$tambahAkun		= mysqli_query($koneksi,"INSERT INTO tb_user (username,nama,password,id_level,nomer_pegawai) VALUES ('$nomer_pegawai','$nama','$password','2','$nomer_pegawai')");
	return mysqli_affected_rows($koneksi);
}
function edit_pegawai($data){
	global $koneksi;

	$nomer_pegawai = $data ['nomer_pegawai'];
	$username	 	= $data ['username'];
	$nama 			= $data ['nama'];
	$tempat_lahir	= $data ['tempat_lahir'];
	$tgl_lahir		= $data ['tgl_lahir'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$jabatan			= $data ['jabatan'];

	$queryShow = "SELECT * FROM tb_staff WHERE nomer_pegawai = '$nomer_pegawai'";
	$sql = mysqli_query($koneksi,$queryShow);
	$hasil = mysqli_fetch_array($sql);

	if ($_FILES['foto']['name'] == "") {
		$fotoprofil = $hasil['foto'];
			
	}else{
		@unlink("../asset/foto/".$hasil['foto']);
		$fotoprofil	= fotoprofil();
	}

	$query 	= "UPDATE tb_staff SET nama ='$nama',tempat_lahir ='$tempat_lahir', tgl_lahir='$tgl_lahir', jenis_kelamin = '$jenis_kelamin',no_hp ='$no_hp',alamat ='$alamat',foto ='$fotoprofil',jabatan ='$jabatan' WHERE nomer_pegawai ='$nomer_pegawai'";
	$result	= mysqli_query($koneksi,$query);

	$user 		= select("SELECT nama FROM tb_user WHERE username = $username")[0];
	$namauser 	= $user['nama'];

	if ($namauser != $nama) {
		$updatenamauser = mysqli_query($koneksi,"UPDATE tb_user SET nama = '$nama' WHERE username
	 = '$username'");
	}
	return mysqli_affected_rows($koneksi); 
}
function edit_biopegawai($data){
	global $koneksi;

	$nomer_pegawai = $data ['nomer_pegawai'];
	$nama 			= $data ['nama'];
	$tempat_lahir	= $data ['tempat_lahir'];
	$tgl_lahir		= $data ['tgl_lahir'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$jabatan		= $data ['jabatan'];

	$queryShow = "SELECT * FROM tb_staff WHERE nomer_pegawai = '$nomer_pegawai'";
	$sql = mysqli_query($koneksi,$queryShow);
	$hasil = mysqli_fetch_array($sql);

	if ($_FILES['foto']['name'] == "") {
		$fotoprofil = $hasil['foto'];
			
	}else{
		@unlink("../asset/foto/".$hasil['foto']);
		$fotoprofil	= fotoprofil();
	}

	$query 	= "UPDATE tb_staff SET nama ='$nama',tempat_lahir ='$tempat_lahir', tgl_lahir='$tgl_lahir', jenis_kelamin = '$jenis_kelamin',no_hp ='$no_hp',alamat ='$alamat',foto ='$fotoprofil',jabatan ='$jabatan' WHERE nomer_pegawai ='$nomer_pegawai'";
	$result	= mysqli_query($koneksi,$query);

	return mysqli_affected_rows($koneksi); 
}
function edit_akunpegawai($data){
	global $koneksi;
	$username = $data['username'];
	$password = md5($data['password']);
	$updateakun = mysqli_query($koneksi,"UPDATE tb_user SET password = '$password' WHERE username = '$username'");
	return mysqli_affected_rows($koneksi);

}
function update_passwordpeg($data){
	global $koneksi;
	$username = $data['username'];
   $password = md5($data['password']);
   $password1 = md5($data['password1']);
   $password2 = md5($data['password2']);

   $passwordpeg = mysqli_query($koneksi,"SELECT password FROM tb_user WHERE username = '$username'");
   $result= mysqli_fetch_array($passwordpeg);
   $pass= $result['password'];

   if ($pass!=$password) {

	    $_SESSION['failed']='Password Lama salah';
       $_SESSION['failed_icon']='error';
       echo "<script>document.location.href = 'biodata-peg.php';
          </script>
            ";
	     die();

   } else if($password1 != $password2){
      	$_SESSION['failed']='Konfirmasi Password salah';
          $_SESSION['failed_icon']='error';
         echo "<script>document.location.href = 'biodata-peg.php';
         </script>
         ";
         die();
     
   }else {
      $query = mysqli_query($koneksi,"UPDATE tb_user SET password = '$password1' WHERE username ='$username'");
      }
      return mysqli_affected_rows($koneksi);
   
}
function hapus_pegawai($data){
	global $koneksi;
	$nomer_pegawai 	= $data['delete'];

	$deleteImg 	= "SELECT * FROM tb_staff WHERE nomer_pegawai='$nomer_pegawai'";
	$sql 		= mysqli_query($koneksi,$deleteImg);
	$hasil 		= mysqli_fetch_array($sql);
	unlink("../asset/foto/".$hasil['foto']);

	$query 			="DELETE FROM tb_staff WHERE nomer_pegawai ='$nomer_pegawai'";
	$result			= mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi);
}
function updatebiodatauser($data){
	global $koneksi;

	$nomorAnggota 	= $data ['nomorAnggota'];
	$nama 			= $data ['nama'];
	$jenis_kelamin	= $data ['jenis_kelamin'];
	$no_hp			= $data ['no_hp'];
	$alamat			= $data ['alamat'];
	$status			= $data ['status'];
	

	$queryShow = "SELECT * FROM tb_anggota WHERE nomorAnggota = '$nomorAnggota'";
	$sql = mysqli_query($koneksi,$queryShow);
	$hasil = mysqli_fetch_array($sql);

	if ($_FILES['foto']['name'] == "") {
		$fotoprofil = $hasil['foto'];
			
	}else{
		@unlink("../asset/foto/".$hasil['foto']);
		$fotoprofil	= fotoprofil();
	}
	$data_status = mysqli_query($koneksi,"SELECT id_status FROM status_anggota WHERE status_anggota = '$status'");
	$data_status = mysqli_fetch_array($data_status);
	$status = $data_status['id_status'];

	$query 	= "UPDATE tb_anggota SET nama ='$nama', jenis_kelamin = '$jenis_kelamin',no_hp ='$no_hp',alamat ='$alamat',foto='$fotoprofil',id_statusanggota='$status' WHERE nomorAnggota ='$nomorAnggota'";
	$result	= mysqli_query($koneksi,$query);

	return mysqli_affected_rows($koneksi);
}
function tambah_peminjam($data){

	global $koneksi;
	$no_buku				= $data['no_buku'];
	$nomorAnggota 		= $data['nomorAnggota'];
	$tgl_pinjam			= $data['tgl_pinjam'];
	$estimasitgl_kembali= $data['estimasitgl_kembali'];
	$status_pinjam		= "Belum dikembalikan";

	$stokBuku = select("SELECT stokBuku FROM tb_buku WHERE no_buku = '$no_buku'")[0];
	$updatestok= $stokBuku ['stokBuku'] - 1;

	$query 	= "INSERT INTO tb_peminjaman (no_buku,nomorAnggota,tgl_pinjam,estimasi_tglkembali,tgl_kembali,status_pinjam) VALUES ('$no_buku','$nomorAnggota','$tgl_pinjam','$estimasitgl_kembali','$status_pinjam','$status_pinjam')";
	$result = mysqli_query($koneksi,$query);

	if ($result) {
		$querystok = mysqli_query($koneksi, "UPDATE tb_buku SET stokBuku = '$updatestok' WHERE no_buku = '$no_buku';");
	}

	return mysqli_affected_rows($koneksi);
	
}
function tambah_peminjambukupaket($data){

	global $koneksi;
	@$judulBuku 			= $data['judulBuku'];
	$nomorAnggota 			= $data['nomorAnggota'];
	$tgl_pinjam				= $data['tgl_pinjam'];
	$estimasitgl_kembali	= $data['estimasitgl_kembali'];
	$status_pinjam			= "Belum dikembalikan";

	$checkanggota = mysqli_query($koneksi,"SELECT nomorAnggota FROM tb_anggota WHERE nomorAnggota = '$nomorAnggota'");
	$dataanggota = mysqli_num_rows($checkanggota);
	if ($judulBuku == null) {
		$_SESSION['failed'] = 'silakan pilih judul buku yang dipinjam';
		$_SESSION['failed_icon'] = 'warning';
		echo "<script>
			document.location.href = 'tambah-peminjambukupaket.php';
			</script>";
		die();

	}
	if ($dataanggota == 0) {
		$_SESSION['failed'] = 'Harap masukan No Anggota yang benar';
		$_SESSION['failed_icon'] = 'warning';
		echo "<script>
			document.location.href = 'tambah-peminjambukupaket.php';
			</script>";
		die();
	}
	foreach ($judulBuku as $buku) {
		$stokBuku = select("SELECT stokBuku FROM tb_buku WHERE no_buku = '$buku'")[0];
		$updatestok= $stokBuku ['stokBuku'] - 1;

		$query 	= "INSERT INTO tb_pinjambukupaket (no_buku,nomor_anggota,tgl_pinjam,estimasi_tglkembali,tgl_kembali,status_pinjam) VALUES ('$buku','$nomorAnggota','$tgl_pinjam','$estimasitgl_kembali','$status_pinjam','$status_pinjam')";
		$result = mysqli_query($koneksi,$query);

		if ($result) {
		$querystok = mysqli_query($koneksi, "UPDATE tb_buku SET stokBuku = '$updatestok' WHERE no_buku = '$buku';");
		}

	}
	return mysqli_affected_rows($koneksi);
	
}
function kembalibukupaket($data){
	global $koneksi;
	$nomorAnggota = $data['nomorAnggota'];
	$judulBuku	  = $data['judulBuku'];
	$status_pinjam = "Dikembalikan";
	$tgl_kembali = $data ['tgl_kembali'];

	if ($judulBuku == null) {
		$_SESSION['failed'] = 'Harap Pilih judul buku yang akan dikembalikan';
		$_SESSION['failed_icon'] = 'warning';
		echo "<script>
			document.location.href = 'edit-peminjam_bukupaket.php?editpinjam=$nomorAnggota';
			</script>";
		die();
	}

	foreach ($judulBuku as $buku) {
		$stokBuku = select("SELECT stokBuku FROM tb_buku WHERE no_buku = '$buku'")[0];
		$updatestok= $stokBuku ['stokBuku'] + 1;

		$query 	= "UPDATE tb_pinjambukupaket SET tgl_kembali = '$tgl_kembali', status_pinjam = '$status_pinjam' WHERE no_buku ='$buku' AND nomor_anggota = '$nomorAnggota'";
		$result = mysqli_query($koneksi,$query);

		if ($result) {
		$querystok = mysqli_query($koneksi, "UPDATE tb_buku SET stokBuku = '$updatestok' WHERE no_buku = '$buku';");
		}

	}
	return mysqli_affected_rows($koneksi);
}

function hapuspengembaiaanbukupaket($data){
	global $koneksi;
	$nomorAnggota 	= $data['delete'];
	$delete 			= mysqli_query($koneksi,"DELETE FROM tb_pinjambukupaket WHERE nomor_anggota = '$nomorAnggota' AND status_pinjam ='Dikembalikan'");
	return mysqli_affected_rows($koneksi);
}

function kembalibuku($data){
	global $koneksi;
	$id_pinjam = $data['id_pinjam'];
	$id_buku = $data['id_buku'];
	$no_buku = $data['no_buku'];
	$keterangan = $data['keterangan'];
	$status = "Dikembalikan";
	$tgl_pinjam = $data ['tgl_pinjam'];
	$tgl_kembali = $data ['tgl_kembali'];
	$pinjam = strtotime($tgl_pinjam);
	$kembali = strtotime($tgl_kembali);

	//$lama_pinjam = $kembali - $pinjam;
	//$hari = $lama_pinjam/60/60/24;

	$hari = abs(strtotime($tgl_pinjam)-strtotime($tgl_kembali));
	$hitung_hari = floor($hari/(60*60*24));
	
	if ($hitung_hari > 7) {
		$terlambat = $hitung_hari -7;
		$denda = 500 * $terlambat;

	}else{
		$terlambat = 0;
		$denda =0;
	}

	$stokBuku =mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE no_buku = '$no_buku'");
	$datastok = mysqli_fetch_array($stokBuku);
	$updatestok= $datastok ['stokBuku'] + 1;

	$query = mysqli_query($koneksi,"UPDATE tb_peminjaman SET tgl_kembali = '$tgl_kembali', telat_pinjam='$terlambat',denda ='$denda', status_pinjam = '$status', keterangan = '$keterangan' WHERE id_pinjam = '$id_pinjam'");
	if ($query) {
		$querystok = mysqli_query($koneksi, "UPDATE tb_buku SET stokBuku = '$updatestok' WHERE no_buku = '$no_buku';");
	}
	return mysqli_affected_rows($koneksi);
}
function hapuspengembalian($data){
	global $koneksi;
	$id_pinjam = $data['delete'];
	$delete = mysqli_query($koneksi,"DELETE FROM tb_peminjaman WHERE id_pinjam = '$id_pinjam'");
	return mysqli_affected_rows($koneksi);
}

function konfirmasiRequest($data){
	global $koneksi;
	$id_req = $data['id_req'];
	$no_buku = $data['no_buku'];
	$judulBuku = $data['judulBuku'];
	$nomorAnggota = $data['nomorAnggota'];
	$tgl_pinjam = $data['tgl_pinjam'];
	$estimasitgl_kembali = $data['estimasitgl_kembali'];

	if ($no_buku == null) {
		$_SESSION['failed'] = "Harap pilih no buku";
		$_SESSION['failed_icon'] = "warning";
		echo "<script>
          document.location.href = 'detail-req.php?edit=$id_req';
          </script>
          ";
		die();
	}

	$status = "Belum dikembalikan";
	$statusreq = "Disetujui";

	$stokBuku =mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE no_buku = '$no_buku'");
	$datastok = mysqli_fetch_array($stokBuku);
	$updatestok= $datastok ['stokBuku'] - 1;

	$tambahpeminjam = mysqli_query($koneksi,"INSERT INTO tb_peminjaman (no_buku, nomorAnggota, tgl_pinjam, estimasi_tglkembali, status_pinjam) VALUES ('$no_buku','$nomorAnggota','$tgl_pinjam','$estimasitgl_kembali','$status')");

	if ($tambahpeminjam) {
		$updatereq = mysqli_query($koneksi,"UPDATE tb_reqbuku SET status_req ='$statusreq' WHERE id_req = '$id_req'");
		$querystok = mysqli_query($koneksi, "UPDATE tb_buku SET stokBuku = '$updatestok' WHERE no_buku = '$no_buku';");
	}
	return mysqli_affected_rows($koneksi);
}

function tolakrequest($data){
	global $koneksi;
	$id_req 	= $data['tolak'];
	$status = "Tidak Disetujui";
	$updatereq = mysqli_query($koneksi,"UPDATE tb_reqbuku SET status_req = '$status' WHERE id_req = '$id_req'");

	return mysqli_affected_rows($koneksi);
}
function requestbuku($data){
	global $koneksi;
	$id_buku 		= $data['id_buku'];
	$no_anggota		= $_SESSION['nomerAnggota'];
	$tgl_request 	= $data['tgl_request'];
	$tgl_exp			= $data['tgl_exp'];
	$status 			="Belum Dikonfirmasi";
	$status_pinjam ="Dikembalikan";

	$totalBuku = 0;
      $total_buku = select("SELECT * FROM tb_buku WHERE id_buku = '$id_buku'");

      foreach ($total_buku as $stok):
          $stokBuku = $stok['stokBuku'];
          $totalBuku += $stokBuku;
      endforeach;

	$datakategori 	= select("SELECT id_kategori FROM tb_koleksibuku WHERE id_buku  = '$id_buku'")[0];
	$id_kategori = $datakategori['id_kategori'];

	$data_peminjam = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman WHERE nomorAnggota = '$no_anggota' AND status_pinjam != '$status_pinjam'");
	$cek_data = mysqli_num_rows($data_peminjam);

	$datapinjam = mysqli_query($koneksi,"SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku WHERE p.nomorAnggota = '$no_anggota' AND p.status_pinjam != '$status_pinjam' AND b.id_buku = '$id_buku'");
	$cekpinjambuku = mysqli_num_rows($datapinjam);

	$data_req = mysqli_query($koneksi,"SELECT * FROM tb_reqbuku WHERE noanggota_req = '$no_anggota' AND status_req = '$status'");
	$cekdata_req = mysqli_num_rows($data_req);

	$data_reqbuku = mysqli_query($koneksi,"SELECT * FROM tb_reqbuku WHERE id_buku = '$id_buku' AND noanggota_req = '$no_anggota' AND status_req = '$status'");
	$cekdata_reqbuku = mysqli_num_rows($data_reqbuku);

	if ($id_kategori == '1') {
		$_SESSION['pinjam']='Untuk Pinjam buku paket harap langsung ke perpustakaan';
		$_SESSION['pinjam_icon']='warning';
		echo "<script>document.location.href = 'katalogbuku.php';
		</script>
		";
	     
	 die();
	}
	if ($totalBuku == 0) {
	     $_SESSION['pinjam']='Saat ini buku tidak tersedia';
	     $_SESSION['pinjam_icon']='warning';
	     echo "<script>document.location.href = 'katalogbuku.php';
	     </script>
	     ";
	     
	 die();
	}
	if ($cekdata_reqbuku != 0) {
		$_SESSION['pinjam']='Buku sudah anda request';
		$_SESSION['pinjam_icon']='warning';
		echo "<script>document.location.href = 'riwayatrequest.php';
		</script>
		";
	 die();
	}
	if ($cek_data >= 3) {
	 	$_SESSION['pinjam']='kembalikan buku terlebih dahulu sebelum melakukan pinjam lagi';
	         $_SESSION['pinjam_icon']='warning';
	         echo "<script>document.location.href = 'katalogbuku.php';
	         </script>
	         ";
	     die();
	 }
	if ($cekdata_req >= 2 ) {
	         $_SESSION['pinjam']='Mohon Menunggu Konfirmasi dahulu sebelum melakukan Request lagi';
	         $_SESSION['pinjam_icon']='warning';
	         echo "<script>document.location.href = 'katalogbuku.php';
	         </script>
	         ";
	     die();
	 }
	if ($cekpinjambuku != 0) {
	 	$_SESSION['pinjam']='Buku sudah anda pinjam';
	 	$_SESSION['pinjam_icon']='warning';
	 	echo "<script>document.location.href = 'riwayatpeminjaman.php';
		</script>
		";
	 die();
	 } 
	$simpan = mysqli_query($koneksi,"INSERT INTO tb_reqbuku (id_req, id_buku, noanggota_req, tgl_req,tgl_exp,status_req) VALUES (null,'$id_buku','$no_anggota','$tgl_request','$tgl_exp','$status')");
	return mysqli_affected_rows($koneksi);;
    
}



?>