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
        $this->SetFont('Arial','B',16);
        $this->Cell(0,5,'Laporan Data Buku',0,1,'C');
        $this->Ln(2);
        $this->Ln(7);
        $this->SetFont('Arial','B','10');
        $this->Cell(10,6,'',0,);
        $this->Cell(8,6,'No.',1,0,'C');
        $this->Cell(60,6,'Judul Buku',1,0,'C');
        $this->Cell(37,6,'Penerbit',1,0,'C');
        $this->Cell(35,6,'Penulis',1,0,'C');
        $this->Cell(35,6,'Rak',1,0,'C');
        $this->Cell(35,6,'kategori Buku',1,0,'C');
        $this->Cell(25,6,'Tahun Terbit',1,0,'C');
        $this->Cell(15,6,'Jumlah',1,0,'C');
        $this->Ln();
    }
 
    //Page Content
    function Content()
    {
        $kategori = $_POST['kategori'];
        

        $this->setWidths(array(8,60,37,35,35,35,25,15));
        $this->SetLineHeight(5);
        /*if ($kategori != 'semua') {
            $namaKategori = select("SELECT nama_kategori FROM tb_kategori WHERE id_kategori = '$kategori'")[0];
            $kategorin = $namaKategori['nama_kategori'];
            $this->SetFont('Arial','I',10);
            $this->Cell(0,5,'Kategori : '.$kategorin,'C');
        }*/
        
        if ($kategori == 'semua'){
            $data_buku = select("SELECT * FROM tb_koleksibuku b LEFT JOIN tb_kategori k ON b.id_kategori=k.id_kategori LEFT JOIN tb_rak r ON b.id_rak = r.id_rak");
        } else {
            $data_buku = select("SELECT * FROM tb_koleksibuku b LEFT JOIN tb_kategori k ON b.id_kategori=k.id_kategori LEFT JOIN tb_rak r ON b.id_rak = r.id_rak WHERE b.id_kategori = '$kategori'");
        }
        $this->SetFont('Arial','',10);
        $no = 1;
        foreach ($data_buku as $buku){
            $id = $buku['id_buku'];
              $totalBuku = 0;
              $total_buku = select("SELECT * FROM tb_buku WHERE id_buku = '$id'");

              foreach ($total_buku as $stok):
                  $stokBuku = $stok['stokBuku'];
                  $totalBuku += $stokBuku;
              endforeach;
            $this->Cell(10,6,'',0,);
            $this->Row(array(
                $no++,
                $buku['judulBuku'],
                $buku['penerbit'],
                $buku['penulis'],
                $buku['nama_rak'],
                $buku['nama_kategori'],
                $buku['tahunTerbit'],
                $totalBuku,

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
$pdf->Output('Laporan Buku.pdf','I');
?>