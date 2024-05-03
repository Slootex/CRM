<?php 

	$filename = "begleitschein.pdf";

	$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo.png', 167, 5.6, 35.6, 27.6);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetY(8.7); // from top
	$pdf->SetX(16.1); // from left
	$pdf->Cell(150, 6, utf8_decode(($maindata['company'] != "" ? $maindata['company'] . ", " : "") . $maindata['firstname'] . " " . $maindata['lastname'] . ", " . $maindata['street'] . " " . $maindata['streetno'] . ", " . $maindata['zipcode'] . " " . $maindata['city']));
	$pdf->Ln(0);

	$pdf->SetFont('Arial', 'B', 22);
	$pdf->SetY(40.6); // from top
	$pdf->SetX(15.5); // from left
	$pdf->Cell(0, 8, utf8_decode("GZA MOTORS - Ihr aktueller Auftragsstatus - Auftragsnummer [#" . $row_order['order_number'] . "]"));
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetY(52.8); // from top
	$pdf->SetX(15.2); // from left
	$pdf->Cell(0, 6, utf8_decode("Auftragsdatum:    " . date("d.m.Y", $time)));
	$pdf->Ln(0);

	$pdf->SetLineWidth(0.3);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Line(11.1, 72.6, 201.9, 72.6);

	// Row
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetY(76.3); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(100, 6, utf8_decode("Angaben zum Fahrzeug"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetY(76.3); // from top
	$pdf->SetX(114.8); // from left
	$pdf->Cell(87.1, 6, utf8_decode("Angaben zum Gerät"), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(85.2); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Fahrzeugmarke / Modell:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(85.2); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode($row_order['machine'] . ", " . $row_order['model']), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(85.2); // from top
	$pdf->SetX(114.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Gerätetyp:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(85.2); // from top
	$pdf->SetX(162.2); // from left
	$pdf->Cell(39.6, 6, utf8_decode($row_reason['name']), 0, 0, "R");
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(94.1); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Hersteller-Nr. (HSN):"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(94.1); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode($row_order['serial']), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(94.1); // from top
	$pdf->SetX(114.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Gerätehersteller:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(94.1); // from top
	$pdf->SetX(162.2); // from left
	$pdf->Cell(39.6, 6, utf8_decode($row_order['manufacturer']), 0, 0, "R");
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(103); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Typ-Nr. (TSN):"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(103); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode("XYZ 321"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(103); // from top
	$pdf->SetX(114.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Geräte Teilenummer:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(103); // from top
	$pdf->SetX(162.2); // from left
	$pdf->Cell(39.6, 6, utf8_decode("8J06145174"), 0, 0, "R");
	$pdf->Ln(0);


	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(111.9); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Fahrzeug-Ident.-Nr. (FIN):"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(111.9); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode($row_order['carid']), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', 'B', 11);
	$pdf->SetY(111.9); // from top
	$pdf->SetX(114.8); // from left
	$pdf->Cell(87, 6, utf8_decode($radio_fromthiscar[$row_order['fromthiscar']]), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(120.8); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Baujahr:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(120.8); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode($row_order['constructionyear']), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(129.7); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Fahrleistung (kW / PS):"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(129.7); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode($row_order['kw']), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(138.6); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Kilometerstand:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(138.6); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode(number_format(intval($row_order['mileage']), 0, '', '.') . " km"), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(147.5); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(47.4, 6, utf8_decode("Fahrzeuggetriebe:"), 0);
	$pdf->Ln(0);

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetY(147.5); // from top
	$pdf->SetX(58.1); // from left
	$pdf->Cell(52.6, 6, utf8_decode("Automatikgetriebe"), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetY(167.7); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(0, 6, utf8_decode("Fehlerbeschreibung, ausgelesene Fehlercodes (Angaben des Kunden):"), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 10);
	$pdf->SetY(174.3); // from top
	$pdf->SetX(10.8); // from left
	$pdf->MultiCell(0, 5, utf8_decode($row_order['reason']), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetY(223.7); // from top
	$pdf->SetX(10.8); // from left
	$pdf->Cell(0, 6, utf8_decode("Fehlerbeschreibung, bereits geprüft (Angaben des Kunden):"), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 10);
	$pdf->SetY(230.3); // from top
	$pdf->SetX(10.8); // from left
	$pdf->MultiCell(0, 5, utf8_decode($row_order['description']), 0);
	$pdf->Ln(0);

	// Row
	$pdf->SetFont('Arial', '', 10);
	$pdf->SetY(271); // from top
	$pdf->SetX(10.8); // from left
	$pdf->MultiCell(0, 5, utf8_decode("Dieses Schreiben wurde maschinell erstellt und bedarf keiner Unterschrift"), 0);
	$pdf->Ln(0);

?>