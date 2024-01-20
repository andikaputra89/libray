<?php

function totalbuku()
{
	global $koneksi;
	$totalBuku = 0;
	$total_buku = select("SELECT * FROM tb_buku");

	foreach ($total_buku as $buku):
	    $stokBuku = $buku['stokBuku'];
	    $totalBuku += $stokBuku; 
	endforeach;
	    
	return $totalBuku;
}
function totalanggota(){
	global $koneksi;
  	$query = "SELECT * FROM tb_anggota";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahAnggota= mysqli_num_rows($result);

  	return $jumlahAnggota;
}
function totalpegawai(){
	global $koneksi;
  	$query = "SELECT * FROM tb_staff WHERE jabatan != 'Kepala Perpustakaan'";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahpegawai= mysqli_num_rows($result);

  	return $jumlahpegawai;
}
function totalrequest(){
	global $koneksi;
  	$query = "SELECT * FROM tb_reqbuku WHERE status_req ='Belum Dikonfirmasi'";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahrequest= mysqli_num_rows($result);

  	return $jumlahrequest;

}
function totalpeminjam(){
	global $koneksi;
  	$query = "SELECT * FROM tb_peminjaman WHERE status_pinjam ='Belum Dikembalikan'";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahpeminjam= mysqli_num_rows($result);

  	return $jumlahpeminjam;

}
function totalpinjambukupaket(){
	global $koneksi;
  	$query = "SELECT * FROM tb_pinjambukupaket WHERE status_pinjam ='Belum Dikembalikan'";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahpeminjam= mysqli_num_rows($result);

  	return $jumlahpeminjam;

}
function totalkembali(){
	global $koneksi;
  	$query = "SELECT * FROM tb_peminjaman WHERE status_pinjam ='Dikembalikan'";
  	$result = mysqli_query($koneksi,$query);
  	$jumlahpeminjam= mysqli_num_rows($result);

  	return $jumlahpeminjam;

}
function totalbukupaket()
{
	global $koneksi;
	$totalBuku = 0;
	$total_buku = select("SELECT * FROM tb_buku b JOIN tb_koleksibuku kb ON b.id_buku = kb.id_buku WHERE kb.id_kategori = '1' ");

	foreach ($total_buku as $buku):
	    $stokBuku = $buku['stokBuku'];
	    $totalBuku += $stokBuku; 
	endforeach;
	    
	return $totalBuku;
}
function totalbukubacaan()
{
	global $koneksi;
	$totalBuku = 0;
	$total_buku = select("SELECT * FROM tb_buku b JOIN tb_koleksibuku kb ON b.id_buku = kb.id_buku WHERE kb.id_kategori = '3' ");

	foreach ($total_buku as $buku):
	    $stokBuku = $buku['stokBuku'];
	    $totalBuku += $stokBuku; 
	endforeach;
	    
	return $totalBuku;
}
function kategoriBuku(){
	global $koneksi;
	$kategori = select("SELECT nama_kategori FROM tb_kategori");
	foreach ($kategori as $namaKategori) {
		$namaKategori = $namaKategori['nama_kategori'];
	}
	return $namaKategori;
}