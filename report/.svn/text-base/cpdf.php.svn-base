<?
define("FPDF_FONTPATH", "fpdf/font/");
require_once("fpdf/fpdf.php");

class CPDF extends FPDF {
	function Header() {
		$this->Image('logo-kecil.jpg', 2, 1, 3, 2.3);
	    $this->SetFont('Arial', 'B', 10);
		$this->SetY(1.4);
		$this->SetX(5.5);
	   	$this->Cell(18, 0.4, 'Lemah Ledok Garden Resto', 0, 0, 'L', 0);
		$this->Ln();
	    $this->SetFont('Arial', '', 8);
		$this->SetX(5.5);
	   	$this->Cell(18, 0.4, 'Jl. Cangkringan Km 0,3 Kalasan - Sleman', 0, 0, 'L', 0);
		$this->Ln();
		$this->SetX(5.5);
	   	$this->Cell(18, 0.4, 'Telp. 0274-497933', 0, 0, 'L', 0);
		$this->Ln();
		$this->SetX(5.5);
	   	$this->Cell(18, 0.4, 'Email: info@lemahledok.com', 0, 0, 'L', 0);
		$this->Ln();
		$this->SetX(5.5);
	   	$this->Cell(18, 0.4, 'Website: http://www.lemahledok.com', 0, 0, 'L', 0);

		$this->SetLineWidth(0.02);
		$this->Line(2, 3.7, 19, 3.7);
		$this->SetLineWidth(0.03);
		$this->Line(2, 3.75, 19, 3.75);
	}
		
	function Footer() {
		$this->SetY(-1.5);
	   	$this->SetFont('Courier', 'I', 8);
	   	$this->Cell(13, 0.4, 'Printed date: '._tgl_skrg_str(), 0, 0, 'L', 0);
		$this->SetX(13);
	   	$this->Cell(6, 0.4, 'Page: '.$this->PageNo().'/{nb}', 0, 0, 'R', 0);
	}
}
?>