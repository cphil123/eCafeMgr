<?
	$param1 = $_GET['param1'];
	$param2 = $_GET['param2'];
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	$pdf->SetMargins(1, -1);
	$pdf->AliasNbPages();

   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 1);

   	$pdf->SetFont('Courier', 'B', 12);
   	$pdf->Cell(19, 1, 'POS Journal Report', 0, 0, 'C', 0);
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'BU', 10);
   	$pdf->Cell(19, 1, 'Sales Journal', 0, 0, 'L', 0);
   	$pdf->Ln();

   	$db1->Query("SELECT r.recid,r.`time`,r.custname,r.total,r.disc,r.totalall,r.tendered,r.change FROM receipt r, employee e WHERE r.server = e.empid AND r.`date` = '$param1' AND r.cashier = '$param2' AND r.is_paid = 'Y'");
   	if ($db1->NRow() > 0) {
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(4, 0.4, 'Date - Time', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1).' - '._now(), 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Cell(4, 0.4, 'Cashier', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '.$param2, 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Ln();

	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Bill Num', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Time', 1, 0, 'C', 1);
	   	$pdf->Cell(3, 0.6, 'Customer', 1, 0, 'C', 1);
	   	$pdf->Cell(2.5, 0.6, 'Total', 1, 0, 'C', 1);
	   	$pdf->Cell(1, 0.6, 'Disc', 1, 0, 'C', 1);
	   	$pdf->Cell(2.5, 0.6, 'Amount Due', 1, 0, 'C', 1);
	   	$pdf->Cell(2.5, 0.6, 'Cash Tendered', 1, 0, 'C', 1);
	   	$pdf->Cell(2.5, 0.6, 'Cash Change', 1, 0, 'C', 1);
	   	$pdf->Ln();
	
      	$i = 1;
      	$pdf->SetFont('Courier', '', 8);
      	$pdf->SetFillColor(255, 255, 255);
		$totalall = 0;
		$totaldisc = 0;
		$totaltender = 0;
		$totalchange = 0;
      	while (list($recid,$time,$custname,$total,$disc,$amount,$tender,$change) = $db1->Row()) {			
			$total *= 1;
			$totalall += $total;
			$totaldisc += $amount;
			$totaltender += $tender;
			$totalchange += $change;
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, $recid, 1, 0, 'L', 1);
         	$pdf->Cell(2, 0.5, $time, 1, 0, 'C', 1);
         	$pdf->Cell(3, 0.5, $custname, 1, 0, 'L', 1);
         	$pdf->Cell(2.5, 0.5, _format_uang($total), 1, 0, 'R', 1);
         	$pdf->Cell(1, 0.5, $disc.'%', 1, 0, 'C', 1);
         	$pdf->Cell(2.5, 0.5, _format_uang($amount), 1, 0, 'R', 1);
         	$pdf->Cell(2.5, 0.5, _format_uang($tender), 1, 0, 'R', 1);
         	$pdf->Cell(2.5, 0.5, _format_uang($change), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 8);
       	$pdf->Cell(8, 0.5, 'Total', 1, 0, 'R', 1);
       	$pdf->Cell(2.5, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
       	$pdf->Cell(1, 0.5, "", 1, 0, 'R', 1);
       	$pdf->Cell(2.5, 0.5, _format_uang($totaldisc), 1, 0, 'R', 1);
       	$pdf->Cell(2.5, 0.5, _format_uang($totaltender), 1, 0, 'R', 1);
       	$pdf->Cell(2.5, 0.5, _format_uang($totalchange), 1, 0, 'R', 1);
   	} else {	
	   	$pdf->SetFont('Courier', 'B', 12);
	   	$pdf->Cell(19, 0.4, 'NO DATA AVAILABLE', 0, 0, 'L', 0);
	}
	      
	$pdf->SetMargins(1, 3);
    $pdf->AddPage();

   	$y = $pdf->GetY();
   	$pdf->SetY($y + 1);
	
   	$pdf->SetFont('Courier', 'B', 12);
   	$pdf->Cell(19, 1, 'POS Journal Report', 0, 0, 'C', 0);
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'BU', 10);
   	$pdf->Cell(19, 1, 'Product Sold', 0, 0, 'L', 0);
   	$pdf->Ln();

   	$db1->Query("SELECT d.menuid,m.name,m.price,m.disc,SUM(d.qty) FROM receipt r,dtlkot d, menus m WHERE r.date = '$param1' AND r.cashier = '$param2' AND r.kotid = d.kotid AND d.menuid = m.menuid AND r.is_void = 'N' AND d.is_void = 'N' GROUP BY menuid");
   	if ($db1->NRow() > 0) {
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(4, 0.4, 'Date - Time', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1).' - '._now(), 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Cell(4, 0.4, 'Cashier', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '.$param2, 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Ln();

	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Product Id', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Description', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Price', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Disc', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Qty', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Total', 1, 0, 'C', 1);
	   	$pdf->Ln();
	
      	$i = 1;
      	$pdf->SetFont('Courier', '', 8);
      	$pdf->SetFillColor(255, 255, 255);
		$totalall = 0;
      	while (list($menuid,$name,$price,$disc,$qty) = $db1->Row()) {
			$total = 1 * $price * $qty;
			if ($disc != '0') {
				$discnum = ($total * $disc) / 100;
				$total = $total - $discnum;
			}			
			$totalall += $total;
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, $menuid, 1, 0, 'L', 1);
         	$pdf->Cell(4, 0.5, $name, 1, 0, 'L', 1);
         	$pdf->Cell(4, 0.5, _format_uang($price), 1, 0, 'R', 1);
         	$pdf->Cell(2, 0.5, $disc.'%', 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, $qty, 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($total), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 8);
       	$pdf->Cell(15, 0.5, 'Total', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
   	} else {	
	   	$pdf->SetFont('Courier', 'B', 12);
	   	$pdf->Cell(19, 0.4, 'NO DATA AVAILABLE', 0, 0, 'L', 0);
	}

   	$pdf->Ln();
   	$pdf->Ln();

   	$pdf->SetFont('Courier', 'BU', 10);
   	$pdf->Cell(19, 1, 'Item Order Voided', 0, 0, 'L', 0);
   	$pdf->Ln();

   	$db1->Query("SELECT d.menuid,m.name,m.price,m.disc,SUM(d.qty) FROM receipt r,dtlkot d, menus m WHERE r.date = '$param1' AND r.cashier = '$param2' AND r.kotid = d.kotid AND d.menuid = m.menuid AND r.is_void = 'N' AND d.is_void = 'Y' GROUP BY menuid");
   	if ($db1->NRow() > 0) {
	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->Cell(4, 0.4, 'Date - Time', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '._tgl_to_str($param1).' - '._now(), 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Cell(4, 0.4, 'Cashier', 0, 0, 'L', 0);
	   	$pdf->Cell(4, 0.4, ': '.$param2, 0, 0, 'L', 0);
	   	$pdf->Ln();
	   	$pdf->Ln();

	   	$pdf->SetFont('Courier', 'B', 8);
	   	$pdf->SetFillColor(255, 213, 149);
	   	$pdf->SetTextColor(0, 0, 0);
	   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Product Id', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Description', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Price', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Disc', 1, 0, 'C', 1);
	   	$pdf->Cell(2, 0.6, 'Qty', 1, 0, 'C', 1);
	   	$pdf->Cell(4, 0.6, 'Total', 1, 0, 'C', 1);
	   	$pdf->Ln();
	
      	$i = 1;
      	$pdf->SetFont('Courier', '', 8);
      	$pdf->SetFillColor(255, 255, 255);
		$totalall = 0;
      	while (list($menuid,$name,$price,$disc,$qty) = $db1->Row()) {
			$total = 1 * $price * $qty;
			if ($disc != '0') {
				$discnum = ($total * $disc) / 100;
				$total = $total - $discnum;
			}			
			$totalall += $total;
         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, $menuid, 1, 0, 'L', 1);
         	$pdf->Cell(4, 0.5, $name, 1, 0, 'L', 1);
         	$pdf->Cell(4, 0.5, _format_uang($price), 1, 0, 'R', 1);
         	$pdf->Cell(2, 0.5, $disc.'%', 1, 0, 'C', 1);
         	$pdf->Cell(2, 0.5, $qty, 1, 0, 'C', 1);
         	$pdf->Cell(4, 0.5, _format_uang($total), 1, 0, 'R', 1);
         	$pdf->Ln();
         	$i++;
      	}
      	$pdf->SetFont('Courier', 'B', 8);
       	$pdf->Cell(15, 0.5, 'Total', 1, 0, 'R', 1);
       	$pdf->Cell(4, 0.5, _format_uang($totalall), 1, 0, 'R', 1);
   	} else {	
	   	$pdf->SetFont('Courier', 'B', 12);
	   	$pdf->Cell(19, 0.4, 'NO DATA AVAILABLE', 0, 0, 'L', 0);
	}

 	$pdf->Output('none.pdf', 'I');
?>