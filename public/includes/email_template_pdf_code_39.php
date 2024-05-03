<?php

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`hash`='" . mysqli_real_escape_string($conn, $hash) . "' 
							WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "'
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$filename = "steuergeraete-reparaturauftrag-interaktiv.pdf";

	$pdf->setSourceFile('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf');

	$tplIdx = $pdf->importPage(1);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', 'B', 26);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(28, 60);
	$pdf->Write(0, utf8_decode("Ihre persönliche Vorgangs-Nr.: " . $row_order['order_number']));


	$pdf->SetFont('Arial', '', 11);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Code39(140, 270, $row_order['order_number'], 1.5, '12');

	$pdf->AddPage();

	$tplIdx = $pdf->importPage(2);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(28, 29);
	$pdf->Write(0, utf8_decode("Ihre persönliche Vorgangs-Nr.: " . $row_order['order_number']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(28, 65);
	$pdf->Write(0, utf8_decode($row_order['machine']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(115, 65);
	$pdf->Write(0, utf8_decode($row_order['model'] . " /                    /                    / " . $row_order['constructionyear']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(28, 74);
	$pdf->Write(0, utf8_decode($row_order['carid']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(115, 74);
	$pdf->Write(0, utf8_decode($row_order['kw']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(28, 83);
	$pdf->Write(0, utf8_decode(number_format(intval($row_order['mileage']), 0, '', '.') . " km"));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(115, 114);
	$pdf->Write(0, utf8_decode($row_order['manufacturer'] . ($row_order['manufacturer'] != "" && $row_order['serial'] != "" ? ", " . $row_order['serial'] : $row_order['serial'])));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetFillColor(239, 239, 239);
	$pdf->SetXY(28, 159);
	$pdf->MultiCell(168.2, 4, mb_substr(utf8_decode(str_replace("\r\n", " ", $row_order['reason'])), 0, 524), '0', 'L', 0);

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetFillColor(239, 239, 239);
	$pdf->SetXY(28, 211);
	$pdf->MultiCell(168.2, 4, mb_substr(utf8_decode(str_replace("\r\n", " ", $row_order['description'])), 0, 524), '0', 'L', 0);

	if($row_order['fromthiscar'] == 1){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(29, 248.6);
		$pdf->Write(0, utf8_decode("X"));
	}else{
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(103, 248.6);
		$pdf->Write(0, utf8_decode("X"));
	}

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Code39(29, 273, $row_order['order_number'], 1.5, '12');


	$pdf->AddPage();

	$tplIdx = $pdf->importPage(3);

	$pdf->useTemplate($tplIdx, 10, 10, 200);

	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(28, 29);
	$pdf->Write(0, utf8_decode("Ihre persönliche Vorgangs-Nr.: " . $row_order['order_number']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 56.4);
	$pdf->Write(0, utf8_decode($row_order['customer_number']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 64.3);
	$pdf->Write(0, utf8_decode(($row_order['companyname'] != "" ? $row_order['companyname'] . ", " : "") . ($row_order['gender'] == 1 ? "Frau " : "Herr ") . $row_order['firstname'] . " " . $row_order['lastname']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 72);
	$pdf->Write(0, utf8_decode($row_order['street'] . " " . $row_order['streetno']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 79.9);
	$pdf->Write(0, utf8_decode($row_order['zipcode'] . ", " . $row_order['city']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 87.8);
	$pdf->Write(0, utf8_decode(($row_order['mobilnumber'] != "" ? $row_order['mobilnumber'] . ", " : "") . $row_order['phonenumber']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 95.5);
	$pdf->Write(0, utf8_decode($row_order['faxnumber']));

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(15, 116, 188);
	$pdf->SetXY(27.8, 103.2);
	$pdf->Write(0, utf8_decode($row_order['email']));

	if($row_order['differing_shipping_address'] == 1){
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(113.6, 56.4);
		$pdf->Write(0, utf8_decode($row_order['customer_number']));

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(113.6, 64.3);
		$pdf->Write(0, utf8_decode(($row_order['differing_companyname'] != "" ? $row_order['differing_companyname'] . ", " : "") . $row_order['differing_firstname'] . " " . $row_order['differing_lastname']));

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(113.6, 72);
		$pdf->Write(0, utf8_decode($row_order['differing_street'] . " " . $row_order['differing_streetno']));

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(113.6, 79.9);
		$pdf->Write(0, utf8_decode($row_order['differing_zipcode'] . ", " . $row_order['differing_city']));
	}

	/*
	if($row_order['radio_payment'] == 0){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(29, 121.6);
		$pdf->Write(0, utf8_decode("X"));
	}
	if($row_order['radio_payment'] == 1){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(78.4, 121.6);
		$pdf->Write(0, utf8_decode("X"));
	}
	if($row_order['radio_payment'] == 2){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(137.8, 121.6);
		$pdf->Write(0, utf8_decode("X"));
	}

	if($row_order['radio_shipping'] == 1){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(29, 139);
		$pdf->Write(0, utf8_decode("X"));
	}
	if($row_order['radio_shipping'] == 0){
		$pdf->SetFont('Arial', '', 9);
		$pdf->SetTextColor(15, 116, 188);
		$pdf->SetXY(83, 139);
		$pdf->Write(0, utf8_decode("X"));
	}
	*/

	/*
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(42.4, 262);
	$pdf->Write(0, utf8_decode(date("d.m.Y", time())));
	*/

	$pdf->SetFont('Arial', '', 11);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Code39(29, 273, $row_order['order_number'], 1.5, '12');

?>