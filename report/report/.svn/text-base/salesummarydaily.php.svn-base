<?
	$param1 = $_GET['param1'];
	$param2 = $_GET['param2'];
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	$pdf->SetMargins(2, -1);
	$pdf->AliasNbPages();

   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 1);


	if (!empty($param2)) {
	   	$pdf->SetFont('Courier', 'B', 12);
	   	$pdf->Cell(14, 1, 'Revenue Summary Daily Report', 0, 0, 'C', 0);
	   	$pdf->Ln();
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(2, 0.4, 'Date', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1), 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(2, 0.4, 'Cashier', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '.$param2, 0, 0, 'L', 0);
	   	$pdf->Ln();
	
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Open', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Close', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Starting Cash', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Revenue', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Discount', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Total Cash', 1, 0, 'C', 1);
	   	$pdf->Ln();
		
	   	$db1->Query("SELECT * FROM salesummary WHERE `date` = '$param1' AND cashier = '$param2'");
	   	if ($db1->NRow() > 0) {
	      	$i = 1;
	      	$pdf->SetFont('Courier', '', 8);
	      	$pdf->SetFillColor(255, 255, 255);
			$omzet = 0;
			$total = 0;
			$ttldisc = 0;
			$rev = 0;
	      	while (list($norec,$date,$cashier,$checkin,$checkout,$cashstart,$cashend,$disc) = $db1->Row()) {			
				$omzet = $cashend - $cashstart;
				if ($omzet < 0) {
					$omzet = 0;
				}
	         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, $checkin, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, $checkout, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($cashstart), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($cashend - $cashstart + $disc), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($disc), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($omzet), 1, 0, 'R', 1);
	         	$pdf->Ln();
	         	$i++;
				$total += $omzet;
				$ttldisc += $disc;
				$rev += $cashend - $cashstart + $disc;
	      	}
	      	$pdf->SetFont('Courier', 'B', 8);
	       	$pdf->Cell(9, 0.5, 'Total', 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($rev), 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($ttldisc), 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($total), 1, 0, 'R', 1);
	   	}
	} else {
	   	$pdf->SetFont('Courier', 'B', 12);
	   	$pdf->Cell(16, 1, 'Sales Summary Daily Report', 0, 0, 'C', 0);
	   	$pdf->Ln();
	   	$pdf->Ln();
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(2, 0.4, 'Date', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1), 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Ln();
	
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Cashier', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Open', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Close', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Starting Cash', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Revenue', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Discount', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Total Cash', 1, 0, 'C', 1);
	   	$pdf->Ln();
		
	   	$db1->Query("SELECT * FROM salesummary WHERE `date` = '$param1'");
	   	if ($db1->NRow() > 0) {
	      	$i = 1;
	      	$pdf->SetFont('Courier', '', 8);
	      	$pdf->SetFillColor(255, 255, 255);
			$omzet = 0;
			$total = 0;
			$ttldisc = 0;
			$rev = 0;
	      	while (list($norec,$date,$cashier,$checkin,$checkout,$cashstart,$cashend,$disc) = $db1->Row()) {			
				$omzet = $cashend - $cashstart;
				if ($omzet < 0) {
					$omzet = 0;
				}
	         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, $cashier, 1, 0, 'L', 1);
	         	$pdf->Cell(2, 0.5, $checkin, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, $checkout, 1, 0, 'C', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($cashstart), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($cashend - $cashstart + $disc), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($disc), 1, 0, 'R', 1);
	         	$pdf->Cell(2, 0.5, _format_uang($omzet), 1, 0, 'R', 1);
	         	$pdf->Ln();
	         	$i++;
				$total += $omzet;
				$ttldisc += $disc;
				$rev += $cashend - $cashstart + $disc;
	      	}
	      	$pdf->SetFont('Courier', 'B', 8);
	       	$pdf->Cell(9, 0.5, 'Total', 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($rev), 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($ttldisc), 1, 0, 'R', 1);
	       	$pdf->Cell(2, 0.5, _format_uang($total), 1, 0, 'R', 1);
	   	}
	}
	
   	$pdf->Output('none.pdf', 'I');
?>