<?
	$ordernum = $_GET['param1'];
	$userid = $_GET['param2'];
	
	$db1->Query("SELECT uname FROM users WHERE userid = $userid");
	list($operator) = $db1->Row();
	
   	$pdf = new FPDF('P', 'cm', 'A4');
	$pdf->AliasNbPages();

   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 2);

   	$pdf->SetFont('Courier', 'B', 14);
   	$pdf->Cell(19, 1, 'Statement of Purchase', 0, 0, 'C', 0);
   	$pdf->Ln();
   	$pdf->Ln();

   	$db1->Query("SELECT r.orderdate,s.name,r.tax,r.total,r.totalvat FROM purchase r, supplier s WHERE r.supid = s.supid AND r.ordernum = '$ordernum'");
	list($orderdate,$name,$tax,$totalall,$totalvat) = $db1->Row();
	$totalend *= 1;

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->Cell(4, 0.4, 'Ref. Number', 0, 0, 'L', 0);
   	$pdf->Cell(6, 0.4, ': '.$ordernum, 0, 0, 'L', 0);
   	$pdf->Cell(3, 0.4, ' ', 0, 0, 'L', 0);
   	$pdf->Cell(2, 0.4, 'Supplier', 0, 0, 'L', 0);
   	$pdf->Cell(6, 0.4, ': '.$name, 0, 0, 'L', 0);
   	$pdf->Ln();
   	$pdf->Cell(4, 0.4, 'Date of Purchase', 0, 0, 'L', 0);
   	$pdf->Cell(6, 0.4, ': '._tgl_to_str($orderdate), 0, 0, 'L', 0);
   	$pdf->Cell(3, 0.4, ' ', 0, 0, 'L', 0);
   	$pdf->Cell(2, 0.4, 'Operator', 0, 0, 'L', 0);
   	$pdf->Cell(6, 0.4, ': '.$operator, 0, 0, 'L', 0);
   	$pdf->Ln();
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->SetFillColor(255, 213, 149);
   	$pdf->SetTextColor(0, 0, 0);
   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
   	$pdf->Cell(5, 0.6, 'Item Description', 1, 0, 'C', 1);
   	$pdf->Cell(1, 0.6, 'Qty', 1, 0, 'C', 1);
   	$pdf->Cell(2, 0.6, 'Unit', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Price', 1, 0, 'C', 1);
   	$pdf->Cell(2, 0.6, 'Discount', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Sub Total', 1, 0, 'C', 1);
   	$pdf->Ln();
	
   	$db1->Query("SELECT r.name,d.qty,d.price,d.disc,d.totaldisc,r.unit FROM dtlpurchase d, materials r WHERE d.matid = r.matid AND d.ordernum = '$ordernum'");
   	if ($db1->NRow() > 0) {
      	$i = 1;
      	$pdf->SetFont('Courier', '', 9);
      	$pdf->SetFillColor(255, 255, 255);
      	while (list($name,$qty,$price,$disc,$totaldisc,$unit) = $db1->Row()) {
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(5, 0.5, $name, 1, 0, 'L', 1);
         	$pdf->Cell(1, 0.5, $qty, 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, unit2str($unit), 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($price), 1, 0, 'R', 1);
         	$pdf->Cell(2, 0.5, $disc.'%', 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($totaldisc), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 9);
       	$pdf->Cell(15, 0.5, 'Total', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
	   	$pdf->Ln();
       	$pdf->Cell(15, 0.5, 'Tax', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, $tax.'%', 1, 0, 'R', 1);
	   	$pdf->Ln();
       	$pdf->Cell(15, 0.5, 'Total (VAT)', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalvat), 1, 0, 'R', 1);
   	}	
	
   	$pdf->Output('none.pdf', 'I');
?>