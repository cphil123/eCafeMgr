<?
	$param1 = $_GET['param1'];
	$param2 = $_GET['param2'];
	$param3 = $_GET['param3'];
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	
   	$pdf->Open();
	$pdf->SetMargins(2.5, 2);
	$pdf->SetAutoPageBreak(false);
	$pdf->AliasNbPages();
	
  	$pdf->AddPage();	

	if (!empty($param3)) {
		$db1->Query("SELECT e.empid,e.name,p.name AS position FROM employee e,position p WHERE e.posid = p.posid AND e.empid = '$param3'");
	} else {
		$db1->Query("SELECT e.empid,e.name,p.name AS position FROM employee e,position p WHERE e.posid = p.posid");
	}
	
	if ($db1->NRow() > 0) {
		while (list($empid,$name,$position) = $db1->Row()) {						
		   	$y = $pdf->GetY();
		   	$pdf->SetY($y + 1);

		   	$pdf->SetFont('Courier', 'B', 14);
		   	$pdf->Cell(14, 0.4, 'Attendance Recap', 0, 0, 'C', 0);
		   	$pdf->Ln();
		   	$pdf->SetFont('Courier', 'BI', 10);
			if ($type == "monyear") {
			   	$pdf->Cell(14, 1, 'Periode: '.mon_str($param1).' '.$param2, 0, 0, 'C', 0);
			} else if ($type == "startend") {
			   	$pdf->Cell(14, 1, 'Periode: '._tgl_to_str($param1).' - '._tgl_to_str($param2), 0, 0, 'C', 0);
			}
		   	$pdf->Ln();
	
		   	$pdf->SetFont('Courier', 'B', 10);
		   	$pdf->Cell(5, 0.4, 'Employee ID', 0, 0, 'L', 0);
		   	$pdf->Cell(6, 0.4, ': '.$empid, 0, 0, 'L', 0);
		   	$pdf->Cell(2, 0.4, ' ', 0, 0, 'L', 0);
		   	$pdf->Ln();
		   	$pdf->Cell(5, 0.4, 'Name', 0, 0, 'L', 0);
		   	$pdf->Cell(6, 0.4, ': '.$name, 0, 0, 'L', 0);
		   	$pdf->Cell(2, 0.4, ' ', 0, 0, 'L', 0);
		   	$pdf->Ln();
		   	$pdf->Cell(5, 0.4, 'Position / Job Title', 0, 0, 'L', 0);
		   	$pdf->Cell(6, 0.4, ': '.$position, 0, 0, 'L', 0);
		   	$pdf->Cell(2, 0.4, ' ', 0, 0, 'L', 0);
		   	$pdf->Ln();
		   	$pdf->SetFont('Courier', 'B', 10);
		   	$pdf->SetFillColor(255, 213, 149);
		   	$pdf->SetTextColor(0, 0, 0);
		   	$pdf->Ln();
		   	$pdf->Cell(3, 0.6, 'Date', 1, 0, 'C', 1);
		   	$pdf->Cell(3, 0.6, 'Check In', 1, 0, 'C', 1);
		   	$pdf->Cell(3, 0.6, 'Check Out', 1, 0, 'C', 1);
		   	$pdf->Cell(2, 0.6, 'Duration', 1, 0, 'C', 1);
		   	$pdf->Ln();

			$lastday = lastday($param1, $param2);
			for ($tgl = 1; $tgl <= $lastday; $tgl++) {
				if ($tgl < 10) {
					$stgl = '0'.$tgl;
				}  else {
					$stgl = $tgl;
				}
				if ($param1 < 10) {
					$smon = '0'.$param1;
				} else {
					$smon = $param1;
				}
				$dtgl = $param2.'-'.$smon.'-'.$stgl;					
			   	$db2->Query("SELECT shift,date,checkin,checkout,TIMEDIFF(checkout, checkin) AS diff FROM attendance WHERE empid = '$empid' AND date = '$dtgl'");
				if ($db2->NRow() > 0) {			
			      	while (list($shift,$date,$checkin,$checkout,$diff) = $db2->Row()) {		
						if ($checkout == '00:00:00') {
							$diff = 'NONE';
						}
			    	  	$pdf->SetFont('Courier', '', 9);
				      	$pdf->SetFillColor(255, 255, 255);
			         	$pdf->Cell(3, 0.5, _tgl_to_str($date), 1, 0, 'C', 1);
			         	$pdf->Cell(3, 0.5, $checkin, 1, 0, 'C', 1);
			         	$pdf->Cell(3, 0.5, $checkout, 1, 0, 'C', 1);
			         	$pdf->Cell(2, 0.5, $diff, 1, 0, 'C', 1);
			         	$pdf->Ln();
					}
	   	  		} else {
		    	  	$pdf->SetFont('Courier', '', 9);
			      	$pdf->SetFillColor(255, 255, 255);
		         	$pdf->Cell(3, 0.5, _tgl_to_str($dtgl), 1, 0, 'C', 1);
		         	$pdf->Cell(3, 0.5, 'NONE', 1, 0, 'C', 1);
		         	$pdf->Cell(3, 0.5, 'NONE', 1, 0, 'C', 1);
		         	$pdf->Cell(2, 0.5, 'NONE', 1, 0, 'C', 1);
		         	$pdf->Ln();
				}
			}
	  		$pdf->AddPage();
		}
	}
	
   	$pdf->Output('none.pdf', 'I');
?>