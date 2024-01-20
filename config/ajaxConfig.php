<?php

require_once 'app.php';

if(isset($_POST['checknobuku']))
	{
		$no_buku = $_POST['no_buku'];
		$data_buku 		= mysqli_query($koneksi,"SELECT no_buku FROM tb_buku WHERE no_buku = '$no_buku'");
		echo mysqli_num_rows($data_buku);
		
	}

if (isset($_POST['hapusEksemplar'])) {
	$no_buku = $_POST['no_buku'];

	$hapus = mysqli_query($koneksi,"DELETE FROM tb_buku WHERE no_buku = '$no_buku'");
	if($hapus){
		echo "sukses";
	}else{
		echo "Gagal";
	}
}
if (isset($_POST['checknoanggota'])) {
	$nomorAnggota = $_POST['nomorAnggota'];
	$data_anggota 		= mysqli_query($koneksi,"SELECT nomorAnggota FROM tb_anggota WHERE nomorAnggota = '$nomorAnggota'");
	echo mysqli_num_rows($data_anggota);
}

if (isset($_POST['autofillBuku'])) {
	
	$no_buku = $_POST['no_buku'];
	$query = mysqli_query($koneksi, "SELECT * FROM tb_buku b JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE b.no_buku='$no_buku'");
	$anggota= mysqli_fetch_array($query);
	$data = array(
	            'judulBuku'      =>  @$anggota['judulBuku']
	            );

//tampil data
echo json_encode($data);
}

if (isset($_POST['autofillAnggota'])) {
	$nomorAnggota = $_POST['nomorAnggota'];
	$query = mysqli_query($koneksi, "SELECT * FROM tb_anggota a JOIN status_anggota s ON a.id_statusanggota = s.id_status WHERE a.nomorAnggota='$nomorAnggota'");
	$anggota= mysqli_fetch_array($query);
	$data = array(
	            'nama'      =>  @$anggota['nama'],
	            'status_anggota'    => @$anggota['status_anggota']
	            );
	echo json_encode($data);
}

if (isset($_POST['datapinjam'])) {
	$nomorAnggota = $_POST['nomorAnggota'];

	$query = mysqli_query($koneksi, "SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku WHERE p.nomorAnggota='$nomorAnggota' AND p.status_pinjam = 'Belum dikembalikan'");
	while ($anggota= mysqli_fetch_array($query)) {
	   echo "
	         <tr>
	          <td>$anggota[no_buku]</td>
	          <td>$anggota[judulBuku]</td>
	          <td>$anggota[tgl_pinjam]</td>
	          <td>$anggota[estimasi_tglkembali]</td>
	          <td>$anggota[status_pinjam]</td>
	        </tr>)";
	}
}

if (isset($_POST['datapinjambkpaket'])) {
	$nomorAnggota = $_POST['nomorAnggota'];
	$query = mysqli_query($koneksi, "SELECT * FROM tb_pinjambukupaket p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_anggota a ON p.nomor_anggota = a.nomorAnggota WHERE p.nomor_anggota='$nomorAnggota' AND p.status_pinjam = 'Belum dikembalikan'");
	while ($anggota= mysqli_fetch_array($query)) {
	   echo "
	         <tr>
	          <td>$anggota[no_buku]</td>
	          <td>$anggota[judulBuku]</td>
	          <td>$anggota[tgl_pinjam]</td>
	          <td>$anggota[estimasi_tglkembali]</td>
	          <td>$anggota[status_pinjam]</td>
	        </tr>)";
	}
}