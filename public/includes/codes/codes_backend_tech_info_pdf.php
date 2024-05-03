<?php 

@session_start();

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$html = "";

if(isset($param['id']) && $param['id'] != ""){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
															FROM 		`order_orders` 
															WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "' 
															AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . $row_order['component'] . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		$pdf = new Fpdi();

		$pdf->AddPage();

//		$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo_gzamotors.png', 130, 50, 50);

//		$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo.png', 8, 276, 20);
// row
		$pdf->SetFont('Arial', 'B', 22);
		$pdf->SetY(8.5); // from top
		$pdf->SetX(14.0); // from left
		$pdf->Cell(0, 8, utf8_decode("Auftrag zur Fehlerdiagnose / KVA - Nr: " . $row_order['order_number']));
		$pdf->Ln(0);
// row
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(13.8, 20.3);
		$pdf->Write(0, utf8_decode("Auftragsdatum:    " . date("d.m.Y", time())));

// row
		$pdf->SetLineWidth(0.3);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Line(11.2, 27, 201.9, 27);
// row
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 33.7);
		$pdf->Write(0, utf8_decode("Angaben zum Fahrzeug"));

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(114.7, 33.7);
		$pdf->Write(0, utf8_decode("Angaben zum Gerät"));
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 42.5);
		$pdf->Write(0, utf8_decode("Fahrzeugmarke / Modell:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(41); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode($row_order['machine'] . ", " . $row_order['model']), 0, 0, "L");

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(114.7, 42.5);
		$pdf->Write(0, utf8_decode("Gerätetyp:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(41); // from top
		$pdf->SetX(162.7); // from left
		$pdf->Cell(40, 3, utf8_decode($row_reason['name']), 0, 0, "R");
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 49.3);
		$pdf->Write(0, utf8_decode("Fahrzeug-Ident.-Nr. (FIN):"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(47.8); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode(strtoupper($row_order['carid'])), 0, 0, "L");

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(114.7, 49.3);
		$pdf->Write(0, utf8_decode("Gerätehersteller:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(47.8); // from top
		$pdf->SetX(162.7); // from left
		$pdf->Cell(40, 3, utf8_decode($row_order['manufacturer']), 0, 0, "R");
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 56.1);
		$pdf->Write(0, utf8_decode("Baujahr:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(54.6); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode($row_order['constructionyear']), 0, 0, "L");

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(114.7, 56.1);
		$pdf->Write(0, utf8_decode("Geräteteilenummer:"));

// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 62.9);
		$pdf->Write(0, utf8_decode("Fahrleistung (kW / PS):"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(61.4); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode($row_order['kw']), 0, 0, "L");

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(61.4); // from top
		$pdf->SetX(114.7); // from left
		$pdf->Cell(40, 3, utf8_decode($row_order['serial']), 0, 1, "L");

// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 69.7);
		$pdf->Write(0, utf8_decode("Kilometerstand:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(68.2); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode(number_format(intval($row_order['mileage']), 0, '', '.') . " km"), 0, 0, "L");

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(114.7, 69.7);
		if($row_order['fromthiscar'] == 1){
			$pdf->SetDrawColor(0, 255, 0);
		}else{
			$pdf->SetDrawColor(255, 0, 0);
		}
		$pdf->Cell(88, 6, utf8_decode($row_order['fromthiscar'] == 1 ? "Gerät stammt aus dem angegeben Fahrzeug" : "Gerät stammt nicht aus dem Fahrzeug"), 1, 0, "L");

// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 76.5);
		$pdf->Write(0, utf8_decode("Getriebe:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(74.7); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode(($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik")), 0, 0, "L");

// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 83.3);
		$pdf->Write(0, utf8_decode("Kraftstoffart:"));

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(81.5); // from top
		$pdf->SetX(58.8); // from left
		$pdf->Cell(46, 3, utf8_decode(($row_order['fuel'] == 0 ? "Benzin" : "Diesel")), 0, 0, "L");

// row
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 95.3);
		$pdf->Write(0, utf8_decode("Fehlerbeschreibung, ausgelesene Fehlercodes (Angaben des Kunden):"));
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(99.1); // from top
		$pdf->SetX(10.8); // from left
		$pdf->MultiCell(0, 5, utf8_decode($row_order['reason']), 0);
// row
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 145.3);
		$pdf->Write(0, utf8_decode("Fehlerbeschreibung, bereits geprüft (Angaben des Kunden):"));
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(149.1); // from top
		$pdf->SetX(10.8); // from left
		$pdf->MultiCell(0, 5, utf8_decode($row_order['description']), 0);

// row
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 195.3);
		$pdf->Write(0, utf8_decode("Hinweis an den Techniker:"));
// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(201.1); // from top
		$pdf->SetX(12.8); // from left
		$pdf->MultiCell(0, 5, utf8_decode($row_order['note_to_the_technician']), 0);

		$pdf->SetLineWidth(2);
		$pdf->SetDrawColor(63, 153, 213);
		$pdf->Rect(11.2, 199.1, 191, 48, 'D'); 

// row
		$pdf->SetLineWidth(0.3);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Line(11.2, 255.2, 201.9, 255.2);
// row
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10.8, 259.3);
		$pdf->Write(0, utf8_decode("Lieferadresse / Rechnungsadresse"));

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(128.7, 259.3);
		$pdf->Write(0, utf8_decode("Kontakt"));

// row
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(261.9); // from top
		$pdf->SetX(10.8); // from left
		$pdf->MultiCell(0, 5, utf8_decode("GZA MOTORS Inh. Gazi Ahmad\nStraußberger Platz 13\n10243 Berlin"), 0);

		$pdf->SetFont('Arial', '', 11);
		$pdf->SetY(261.9); // from top
		$pdf->SetX(128.7); // from left
		$pdf->MultiCell(0, 5, utf8_decode("Handy: 0151-12336769\nFax: 0421-17668953\nE-Mail: info@gzamotors.de (bevorzugt)"), 0);
/*
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Code39(29, 273, $row_order['order_number'], 1.5, '12');*/

		$pdfdoc = $pdf->Output("", "S");

		header('Content-Type: application/pdf');

		die($pdfdoc);

	}

}

?>