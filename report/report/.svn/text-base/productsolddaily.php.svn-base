<?
	$param1 = $_GET['param1'];
	$param2 = $_GET['param2'];
	$param3 = $_GET['param3'];
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	$pdf->AliasNbPages();

   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 2);

   	$pdf->SetFont('Courier', 'B', 14);
   	$pdf->Cell(19, 1, 'Sales Summary Daily Report', 0, 0, 'C', 0);
   	$pdf->Ln();
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->Cell(4, 0.4, 'Current Date', 0, 0, 'L', 0);
   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1), 0, 0, 'L', 0);
   	$pdf->Ln();

	$qry = "";
	if (!empty($param2)) {
		$db1->Query("SELECT desc FROM tags WHERE tagid = $param2");
		list($desc) = $db1->Row();
		$qry = "AND c.tagid = ".$param2;
   		$pdf->Cell(4, 0.4, 'Product Tag', 0, 0, 'L', 0);
   		$pdf->Cell(4, 0.4, ': '.$desc, 0, 0, 'L', 0);
	   	$pdf->Ln();
	}
	
	if (!empty($param3)) {
		$qry .= " AND k.cashier = '$param3'";
   		$pdf->Cell(4, 0.4, 'Cashier', 0, 0, 'L', 0);
   		$pdf->Cell(4, 0.4, ': '.$param3, 0, 0, 'L', 0);
	   	$pdf->Ln();
	}
	
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'B', 10);
   	$pdf->SetFillColor(255, 213, 149);
   	$pdf->SetTextColor(0, 0, 0);
   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
   	$pdf->Cell(8, 0.6, 'Item Description', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Price', 1, 0, 'C', 1);
   	$pdf->Cell(2, 0.6, 'Qty', 1, 0, 'C', 1);
   	$pdf->Cell(4, 0.6, 'Total', 1, 0, 'C', 1);
   	$pdf->Ln();
	
   	$db1->Query("SELECT m.menuid,m.name,m.price,SUM(d.qty) AS sqty,(m.price * SUM(d.qty)) AS total FROM menus m,menucats c,dtlkot d,receipt k WHERE d.menuid = m.menuid AND m.catid = c.catid AND k.kotid = d.kotid AND k.`date` = '$param1' AND d.is_void = 'N' $qry GROUP BY m.menuid ORDER BY sqty DESC");
   	if ($db1->NRow() > 0) {
      	$i = 1;
      	$pdf->SetFont('Courier', '', 9);
      	$pdf->SetFillColor(255, 255, 255);
		$totalall = 0;
      	while (list($menuid,$name,$price,$sqty,$total) = $db1->Row()) {		
			$totalall += $total;
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(8, 0.5, $name, 1, 0, 'L', 1);
         	$pdf->Cell(4, 0.5, _format_uang($price), 1, 0, 'R', 1);
         	$pdf->Cell(2, 0.5, $sqty, 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($total), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 9);
       	$pdf->Cell(15, 0.5, 'Total Amount', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
   	}	
	
   	$pdf->Output('none.pdf', 'I');
?>