<?php
require 'Multicell.php';
include '../config/app.php';


class PDF extends PDF_MC_Table
{
    //Page header
    function Header()
    {
        //Logo
        $teks1 ="SISTEM INFORMASI PERPUSTAKAAN";
        $teks2 ="SMA N 1 TEJAKULA";
        $teks4 ="Jln. Singaraja-Amlapura Desa Tejakula Kec. Tejakula ";
        $teks5 ="Kab. Buleleng Prov. Bali, Tejakula, Kec. Tejakula, Kab. Buleleng Prov. Bali";
        $this->Image('../asset/dist/img/logo.png',10,6,25);
        //Arial bold 15
        $this->Cell(25);
        $this->SetFont('Arial','B',16);
        $this->Cell(0,5,$teks1,0,1,'C');
        $this->Cell(25);
        $this->Cell(0,5,$teks2,0,1,'C');
        $this->Cell(25);
        $this->SetFont('Arial','i','8');
        $this->Cell(0,5,$teks4,0,1,'C');
        $this->Cell(25);
        $this->Cell(0,2,$teks5,0,1,'C');
        //pindah baris
        $this->Ln(5);
        //buat garis horisontal
        $this->Cell(280,0.6,'','0','1','C',true);
        $this->Ln(5);
    }
 
    //Page Content
    function Content()
    {
    	$tgl_awal = $_POST['start'];
    	$tgl_akhir = $_POST['end'];

    	$tgl_sekarang = date('d-m-Y');
        $data_peminjam = select("SELECT * FROM tb_peminjaman p JOIN tb_buku b ON p.no_buku = b.no_buku JOIN tb_koleksibuku kb ON kb.id_buku = b.id_buku JOIN tb_anggota a ON p.nomorAnggota = a.nomorAnggota WHERE tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir' AND status_pinjam ='Dikembalikan'");
        //$jml = mysqli_query($GLOBALS['koneksi'],"SELECT * FROM tb_peminjaman WHERE tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'");
        //$jml2 = mysqli_query($GLOBALS['koneksi'],"SELECT * FROM tb_peminjaman WHERE tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir' AND status_pinjam = 'Belum dikembalikan'");
        //$jumlahpeminjam = mysqli_num_rows($jml);
        //$blmdikembalikan = mysqli_num_rows($jml2);
        $this->setWidths(array(8,20,60,25,50,35,35,25,20));
        $this->SetLineHeight(6);
        $this->SetFont('Arial','B',16);
        $this->Cell(0,5,'Laporan Data Pengembalian',0,1,'C');
        $this->Ln(2);
        $this->SetFont('Arial','i','10');
        $this->Cell(0,5,'Periode :'.$tgl_awal.' S/D '.$tgl_akhir,0,1,'C');
        $this->Ln(7);
        $this->SetFont('Arial','B','10');
        $this->Cell(8,6,'No.',1,0,'C');
        $this->Cell(20,6,'No buku',1,0,'C');
        $this->Cell(60,6,'Judul Buku',1,0,'C');
        $this->Cell(25,6,'No Anggota',1,0,'C');
        $this->Cell(50,6,'Nama Peminjam',1,0,'C');
        $this->Cell(35,6,'Tanggal Pinjam',1,0,'C');
        $this->Cell(35,6,'Tanggal Kembali',1,0,'C');
        $this->Cell(25,6,'Telat Pinjam',1,0,'C');
        $this->Cell(20,6,'denda',1,0,'C');
        $this->Ln();
     
        $this->SetFont('Arial','',10);
        $no = 1;
        foreach ($data_peminjam as $peminjam){
            if ($peminjam['telat_pinjam'] == 0) {
                $telatpinjam = "0";
            }else{
                $telatpinjam = $peminjam['telat_pinjam']." hari";
            }
            $this->Row(array(
                $no++,
                $peminjam['no_buku'],
                $peminjam['judulBuku'],
                $peminjam['nomorAnggota'],
                $peminjam['nama'],
                $peminjam['tgl_pinjam'],
                $peminjam['tgl_kembali'],
                $telatpinjam,
                $peminjam['denda'],

            ));

        } 

    }
    //Page footer
    function Footer()
    {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-15);
        //buat garis horizontal
        $this->Line(10,$this->GetY(),280,$this->GetY());
        //Arial italic 9
        $this->SetFont('Arial','I',9);
        //nomor halaman
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }
}
 
//contoh pemanggilan class
$pdf = new PDF('L');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->Content();
$pdf->Output('Laporan Pengembalian.pdf','I');
?>