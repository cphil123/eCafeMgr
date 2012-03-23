<?
	$param1 = $_GET['param1'];
	$param2 = $_GET['param2'];
	
   	$pdf = new FPDF('P', 'cm', 'A4');
	$pdf->AliasNbPages();

   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 2);

   	$pdf->SetFont('Courier', 'B', 14);
   	$pdf->Cell(19, 1, 'Purchasing Daily Report', 0, 0, 'C', 0);
   	$pdf->Ln();
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->Cell(4, 0.4, 'Current Date', 0, 0, 'L', 0);
   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param), 0, 0, 'L', 0);
   	$pdf->Ln();
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->SetFillColor(255, 213, 149);
   	$pdf->SetTextColor(0, 0, 0);
   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
   	$pdf->Cell(5, 0.6, 'Item Description', 1, 0, 'C', 1);
   	$pdf->Cell(2, 0.6, 'Qty', 1, 0, 'C', 1);
   	$pdf->Cell(2, 0.6, 'Unit', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Price per Unit', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Total', 1, 0, 'C', 1);
   	$pdf->Ln();
	
   	$db1->Query("SELECT r.name,d.qty,d.price,d.total,r.unit FROM dtlpurchase d, materials r WHERE d.matid = r.matid AND d.ordernum = '$ordernum'");
   	if ($db1->NRow() > 0) {
      	$i = 1;
      	$pdf->SetFont('Courier', '', 9);
      	$pdf->SetFillColor(255, 255, 255);
		$totalall = 0;
      	while (list($name,$qty,$price,$total,$unit) = $db1->Row()) {
			$total *= 1;
			$totalall += $total;
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(5, 0.5, $name, 1, 0, 'L', 1);
         	$pdf->Cell(2, 0.5, $qty, 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, unit2str($unit), 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($price), 1, 0, 'R', 1);
         	$pdf->Cell(4, 0.5, _format_uang($total), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 9);
       	$pdf->Cell(14, 0.5, 'Total Amount', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
	   	$pdf->Ln();
       	$pdf->Cell(14, 0.5, 'Tax', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($tax), 1, 0, 'R', 1);
	   	$pdf->Ln();
       	$pdf->Cell(14, 0.5, 'Total Amount', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalend), 1, 0, 'R', 1);
   	}	
	
   	$pdf->Output('none.pdf', 'I');
?>