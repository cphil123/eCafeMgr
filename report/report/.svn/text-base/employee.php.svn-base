<?
	$posid = $_GET['id'];
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	$pdf->SetMargins(2.5, 3);
	$pdf->AliasNbPages();
	
   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 1);

   	$pdf->SetFont('Courier', 'B', 14);
   	$pdf->Cell(16, 1, 'Employee List', 0, 0, 'C', 0);
   	$pdf->Ln(1);

	if (empty($posid)) {
	   	$pdf->SetFont('Courier', 'B', 10);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Emp ID', 1, 0, 'C', 1);
	   	$pdf->Cell(8, 0.6, 'Name', 1, 0, 'C', 1);
	   	$pdf->Cell(5, 0.6, 'Job Title', 1, 0, 'C', 1);
	   	$pdf->Ln();
		
	   	$db1->Query("SELECT e.empid,e.name,p.name AS jobtitle FROM employee e, position p WHERE p.posid = e.posid ORDER BY e.name ASC");
	   	if ($db1->NRow() > 0) {
	      	$i = 1;
	      	$pdf->SetFont('Courier', '', 9);
	      	$pdf->SetFillColor(255, 255, 255);
			$totalall = 0;
	      	while (list($empid,$name,$jobtitle) = $db1->Row()) {
				$totalall += $total;
	         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, $empid, 1, 0, 'L', 1);
	         	$pdf->Cell(8, 0.5, $name, 1, 0, 'L', 1);
	         	$pdf->Cell(5, 0.5, $jobtitle, 1, 0, 'L', 1);
	         	$pdf->Ln();
	         	$i++;
	      	}
		}
   	} else {
		$db1->Query("SELECT name FROM position WHERE posid = '$posid'");
		list($name) = $db1->Row();
		
	   	$pdf->SetFont('Courier', 'I', 10);
	   	$pdf->Cell(8, 0.6, 'Job Title: '.$name, 0, 0, 'L', 0);
		$pdf->Ln();
		
	   	$pdf->SetFont('Courier', 'B', 10);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(3, 0.6, 'Emp ID', 1, 0, 'C', 1);
	   	$pdf->Cell(12, 0.6, 'Name', 1, 0, 'C', 1);
	   	$pdf->Ln();
		
	   	$db1->Query("SELECT e.empid,e.name FROM employee e WHERE e.posid = '$posid' ORDER BY e.name ASC");
	   	if ($db1->NRow() > 0) {
	      	$i = 1;
	      	$pdf->SetFont('Courier', '', 9);
	      	$pdf->SetFillColor(255, 255, 255);
			$totalall = 0;
	      	while (list($empid,$name) = $db1->Row()) {
				$totalall += $total;
	         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
	         	$pdf->Cell(3, 0.5, $empid, 1, 0, 'L', 1);
	         	$pdf->Cell(12, 0.5, $name, 1, 0, 'L', 1);
	         	$pdf->Ln();
	         	$i++;
	      	}
		}
	}
	
   	$pdf->Output('none.pdf', 'I');
?>