<?
	$tag = $_GET['param'];
	
	if (!empty($tag)) {
		$db1->Query("SELECT desc FROM tag WHERE tag = '$tag'");
		list($tagname) = $db1->Row();
	}
	
   	$pdf = new CPDF('P', 'cm', 'A4');
	$pdf->SetMargins(2.5, 3);
	$pdf->AliasNbPages();
	
   	$pdf->Open();
  	$pdf->AddPage();
	
   	$y = $pdf->GetY();
   	$pdf->SetY($y + 1);

   	$pdf->SetFont('Courier', 'B', 14);
   	$pdf->Cell(16, 1, 'Material List', 0, 0, 'C', 0);
	if (!empty($tag)) {
	   	$pdf->Ln();
	   	$pdf->SetFont('Courier', 'I', 12);
	   	$pdf->Cell(16, 1, 'Tag: '.$tagname, 0, 0, 'C', 0);
	}
   	$pdf->Ln();

	$db1->Query("SELECT catid,name FROM categories ORDER BY name ASC");
	if ($db1->NRow() > 0) {
		while (list($catid,$catname) = $db1->Row()) {
		   	$pdf->SetFont('Courier', 'B', 10);
		   	$pdf->SetFillColor(255, 213, 149);
		   	$pdf->SetTextColor(0, 0, 0);
		   	$pdf->Cell(16, 1, 'Category: '.$catname, 0, 0, 'L', 0);
		   	$pdf->Ln();
		   	$pdf->Cell(1, 0.6, 'No.', 1, 0, 'C', 1);
		   	$pdf->Cell(4, 0.6, 'Material Id', 1, 0, 'C', 1);
		   	$pdf->Cell(7, 0.6, 'Name', 1, 0, 'C', 1);
		   	$pdf->Cell(2, 0.6, 'Stock', 1, 0, 'C', 1);
		   	$pdf->Cell(2, 0.6, 'Unit', 1, 0, 'C', 1);
		   	$pdf->Ln();
					
		   	$db2->Query("SELECT m.matid,m.name,m.stock,m.unit,s.name AS supname FROM materials m,supplier s WHERE m.supid = s.supid AND m.catid = '$catid' AND m.tag LIKE '%$tag%' ORDER BY m.name ASC");
		   	if ($db2->NRow() > 0) {
		      	$i = 1;
		      	$pdf->SetFont('Courier', '', 9);
		      	$pdf->SetFillColor(255, 255, 255);
		      	while (list($matid,$name,$stock,$unit) = $db2->Row()) {
		         	$pdf->Cell(1, 0.5, $i, 1, 0, 'C', 1);
		         	$pdf->Cell(4, 0.5, $matid, 1, 0, 'L', 1);
		         	$pdf->Cell(7, 0.5, $name, 1, 0, 'L', 1);
		         	$pdf->Cell(2, 0.5, $stock, 1, 0, 'C', 1);
		         	$pdf->Cell(2, 0.5, unit2str($unit), 1, 0, 'L', 1);
		         	$pdf->Ln();
		         	$i++;
		      	}
			}
         	$pdf->Ln();
		}
	}
	
   	$pdf->Output('none.pdf', 'I');
?>