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
		$status = $_POST['status'];
		$tgl_sekarang = date('d-m-Y');
		$this->setWidths(array(8,40,55,25,30,70,45));
        $this->SetLineHeight(6);
		$this->SetFont('Arial','B',16);
        $this->Cell(0,5,'Laporan Data Anggota',0,1,'C');
		$this->Ln(2);
		if ($status !='semua') {
			$status_anggota = select("SELECT * FROM status_anggota WHERE id_status ='$status'")[0];
			$status_a= $status_anggota['status_anggota'];
		$this->SetFont('Arial','i','10');
		$this->Cell(0,5,'Status Anggota : '.$status_a,'C');
		}
		$this->Ln(7);
		$this->SetFont('Arial','B','10');
		$this->Cell(8,6,'No.',1,0,'C');
		$this->Cell(40,6,'Nomor Anggota',1,0,'C');
		$this->Cell(55,6,'Nama',1,0,'C');
		$this->Cell(25,6,'Jenis Kelamin',1,0,'C');
		$this->Cell(30,6,'No Hp',1,0,'C');
		$this->Cell(70,6,'Alamat',1,0,'C');
		$this->Cell(45,6,'Status Anggota',1,0,'C');

		$this->Ln();
		if($status == 'semua'){
			$data_anggota = select("SELECT * FROM tb_anggota JOIN status_anggota ON tb_anggota.id_statusanggota = status_anggota.id_status ORDER BY id_statusanggota");
		}else{
			$data_anggota = select("SELECT * FROM tb_anggota JOIN status_anggota ON tb_anggota.id_statusanggota = status_anggota.id_status WHERE id_statusanggota ='$status'");
		}
		$no = 1;
		$this->SetFont('Arial','',10);
		foreach ($data_anggota as $anggota): {
			$this->Row(array(
                $no++,
                $anggota['nomorAnggota'],
                $anggota['nama'],
                $anggota['jenis_kelamin'],
                $anggota['no_hp'],
                $anggota['alamat'],
                $anggota['status_anggota'],

            ));

		}endforeach;

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
$pdf->Output('laporan data anggota.pdf','I');
?>