<?php

	$filename = "steuergeraete-reparaturauftrag-interaktiv.pdf";

	$pdf->setSourceFile('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf');

	$tplIdx = $pdf->importPage(1);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', '', 11);
	$pdf->Code39(110, 270, $order_number, 1.5, '12');

	$pdf->SetFont('Arial', 'B', 26);
	$pdf->SetTextColor(255, 0, 0);
	$pdf->SetXY(166, 276);
	$pdf->Write(0, $order_number);

	$pdf->AddPage();

	$tplIdx = $pdf->importPage(2);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', 'B', 20);
	$pdf->SetTextColor(255, 0, 0);
	$pdf->SetXY(52, 20.4);
	$pdf->Write(0, $order_number);

	$pdf->AddPage();

	$tplIdx = $pdf->importPage(3);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', 'B', 20);
	$pdf->SetTextColor(255, 0, 0);
	$pdf->SetXY(52, 20.4);
	$pdf->Write(0, $order_number);

?>