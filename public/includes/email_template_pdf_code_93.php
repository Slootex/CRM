<?php

	$filename = "begleitschein.pdf";

	$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/briefpapier_blank.jpg', 0, 0, 215);

	$pdf->SetLeftMargin(25);
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(0, 90, utf8_decode(($maindata['company'] != "" ? $maindata['company'] . ", " : "") . $maindata['firstname'] . " " . $maindata['lastname'] . ", " . $maindata['street'] . " " . $maindata['streetno'] . ", " . $maindata['zipcode'] . " " . $maindata['city']));

	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetX(20);
	$pdf->SetY(60);
	$pdf->MultiCell(100, 5, utf8_decode($row_packing['companyname'] . "\n" . strip_tags($row_packing['firstname']) . " " . strip_tags($row_packing['lastname']) . "\n" . strip_tags($row_packing['street']) . " " . strip_tags($row_packing['streetno']) . "\n" . strip_tags($row_packing['zipcode']) . " " . strip_tags($row_packing['city']) . "\n" . $row_country_to['name']));

	$pdf->SetX(20);
	$pdf->SetY(20);
	$pdf->Ln(0);
	$pdf->SetLeftMargin(175);
	$pdf->Cell(170, 185, date("d.m.Y", $time));

	$pdf->SetLeftMargin(25);
	$pdf->Ln(0);
	$pdf->SetFont('Arial', 'B', 20);
	$pdf->Cell(0, 180, utf8_decode(""));

	$pdf->SetLeftMargin(25);
	$pdf->Ln(0);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->Ln(0);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Code39(26, 125, $row_order['order_number'], 1.5, '12');

	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(0, 200, utf8_decode(""));

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetX(100);
	$pdf->SetY(150);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->MultiCell(170, 5, utf8_decode("Legen Sie diesen Schein mit ins Paket. / Set this expression in the package"));

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetX(100);
	$pdf->SetY(160);
	$pdf->MultiCell(170, 5, utf8_decode("\n\nGZA MOTORS (Mail Boxes Etc.)\nViolenstraße 37\n28195 Bremen\nDeutschland"));

?>