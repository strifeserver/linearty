<?php
    
    use setasign\Fpdi\Fpdi;
    
    ob_start(); 
    
    require_once('vendor/setasign/fpdf/fpdf.php');
	require_once('vendor/setasign/fpdi/src/autoload.php');
	$pdf = new Fpdi();
	$pdf->AddPage();
	$pdf->setSourceFile('Templates/Barangay-Clearance-Template.pdf');
	$tplIdx = $pdf->importPage(1);
	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
	$pdf->SetFont('Times', 'B', 12);
	$pdf->SetTextColor(0, 0, 0);
		
	$pdf->SetXY(118, 99);
	$pdf->Write(0, 'Testasdsad');
	
	$pdf->SetXY(62, 107);
	$pdf->Write(0, 'Testasdsad');
	
	$pdf->SetXY(36, 115);
	$pdf->Write(0, 'Testasdsad');
	
	$pdf->SetXY(101, 123);
	$pdf->Write(0, 'Testasdsad');
	
	$pdf->SetXY(72, 138);
	$pdf->Write(0, 'Testasdsad');
		
	ob_end_clean();
 	$pdf->Output('I', 'BrgyClearance.pdf');


?>