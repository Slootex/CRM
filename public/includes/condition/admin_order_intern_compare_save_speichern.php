<?php 

	use setasign\Fpdi\Fpdi;
	
	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	if(strlen($_POST['intern_compare_price']) < 1 || strlen($_POST['intern_compare_price']) > 13){
		$emsg .= "<span class=\"error\">Bitte einen Betrag eingeben. (max. 13 Zeichen)</span><br />\n";
		$inp_intern_compare_price = " is-invalid";
	} else {
		$intern_compare_price = str_replace(",", ".", $_POST['intern_compare_price']);
	}

	if($emsg == ""){

		$time = time();

		$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																FROM 		`order_orders` 
																WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
																AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);
	
		if(isset($row_order['id'])){

			$row_compare_modules = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `compare_modules` WHERE `compare_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `compare_modules`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['intern_compare_text'])) . "'"), MYSQLI_ASSOC);

			$pdf = new Fpdi();
	
			$pdf->AddPage();
	
			$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/gzamotors_logo.png', 146, 20, 35);

//			$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/logo.png', 8, 276, 20);

			$pdf->SetFont('Arial', 'B', 22);
			$pdf->SetY(8.5); // from top
			$pdf->SetX(80.0); // from left
			$pdf->Cell(0, 8, utf8_decode("Vereinbarung"));
			$pdf->Ln(0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 20.3);
			$pdf->MultiCell(0, 5, utf8_decode("zwischen\nder Firma\n" . $maindata['company'] . "\n" . $maindata['street'] . " " . $maindata['streetno'] . ", " . $maindata['zipcode'] . " " . $maindata['city'] . ""), 0);

			$pdf->SetFont('Arial', 'B', 11);
			$pdf->SetY(39.0); // from top
			$pdf->SetX(13.8); // from left
			$pdf->Cell(0, 8, utf8_decode("- Vertragspartner zu 1) -"));
			$pdf->Ln(0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 46.5);
			$pdf->MultiCell(0, 5, utf8_decode("und"), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 52.5);
			$pdf->MultiCell(0, 5, utf8_decode("Ihnen\n" . $row_order['firstname'] . " " . $row_order['lastname'] . "\n" . $row_order['street'] . " " . $row_order['streetno'] . ", " . $row_order['zipcode'] . " " . $row_order['city']), 0);

			$pdf->SetFont('Arial', 'B', 11);
			$pdf->SetY(66.6); // from top
			$pdf->SetX(13.8); // from left
			$pdf->Cell(0, 8, utf8_decode("- Vertragspartner zu 2) -"));
			$pdf->Ln(0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 76.0);
			$pdf->MultiCell(0, 5, utf8_decode("§ 1 Die Vertragspartner vertreten unterschiedliche Auffassungen hinsichtlich der Auftragsabwicklung\nmit der Firma " . $maindata['company'] . " mit folgender Vorgangs-Nr und Auftrags-Nr " . $row_order['order_number']), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 88.0);
			$pdf->MultiCell(0, 5, utf8_decode("§ 2 Zur abschließenden Erledigung dieser Angelegenheit schließen die Parteien unter Aufrechterhaltung\nihrer jeweiligen Rechtsauffassungen und damit jeweils ohne Anerkennung einer dahingehenden\nRechtspflicht und ohne präjudizierende Wirkung für zukünftige gleiche oder vergleichbare Fälle\nzur Vermeidung eines Rechtsstreites folgenden Vergleich:"), 0);

			$pos_top = 110.0;

			if(isset($row_compare_modules['id'])){
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetXY(13.8, 110.0);
				$pdf->MultiCell(0, 5, chr(149) . " " . utf8_decode($row_compare_modules['text']), 0);
				$pos_top += 11;
			}

			$pdf->SetFont('Arial', 'B', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top);
			$pdf->MultiCell(0, 5, chr(149) . " " . utf8_decode("Der Vertragspartner zu 1) zahlt an den Vertragspartner zu 2) ein Betrag in Höhe von\n" . number_format($intern_compare_price, 2, ',', '') . " ") . chr(128) . utf8_decode(" inkl. Mwst"), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top + 12);
			$pdf->MultiCell(0, 5, utf8_decode("§ 3 Mit der vorstehenden Regelung sind sämtliche wechselseitigen Ansprüche der Vertragspartner\nund Rechte dritter aus der Angelegenheit gem. § 1 erledigt."), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top + 24);
			$pdf->MultiCell(0, 5, utf8_decode("§ 4 Mit dem Vollzug des vorliegenden Vertrages erklären sich die beiden Parteien per Saldo\nsämtlicher Ansprüche in dieser Sache als auseinandergesetzt."), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top + 35);
			$pdf->MultiCell(0, 5, utf8_decode("§ 5 Über den Inhalt des geschlossenen Vertrages, insbesondere aus der Angelegenheit gem. § 1, \nvereinbaren die Vertragspartner gegenüber Dritten Stillschweigen zu bewahren. Gespräche mit Vertretern\nder Presse oder presseähnlicher Einrichtungen und öffentliche Auftritte, die im Zusammenhang\nmit dieser Angelegenheit stehen, etwaige Rezensionen bzw. öffentliche Kritiken, auch durch dritte\nPersonen, Veröffentlichungen sowohl im Internet als auch in Zeitungen, Fernseher, Radio\noder div. anderen Medien sind ausgeschlossen."), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top + 66.4);
			$pdf->MultiCell(0, 5, utf8_decode("§ 6 Mündliche Nebenabreden bestehen nicht. Änderungen und Ergänzungen bedürfen der Schriftform.\nSollte eine der Bestimmungen dieser Vereinbarung unwirksam sein oder eine Lücke enthalten, \nso behalten die übrigen Bestimmungen ihre Gültigkeit."), 0);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, $pos_top + 83);
			$pdf->MultiCell(0, 5, utf8_decode("§ 7 Salvatorische Klausel\nSollte eine Bestimmung dieses Vertrages unwirksam sein oder werden oder sollte sich eine Regelungs-\nlücke zeigen, so berührt dies nicht die Wirksamkeit der übrigen Bestimmungen dieses Vertrages.\nDie Parteien verpflichten sich, die etwa unwirksame Bestimmung durch eine Bestimmung\nzu ersetzen, die dem rechtlichen und wirtschaftlichen Regelungsgehalt der etwa unwirksamen Bestimmung\nam nächsten kommt. In gleicher Weise werden die Parteien eine etwa auftretende ausfüllungsbedürftige\nRegelungslücke schließen."), 0);

			$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/stamp.jpg', 83.8, 243, 30);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetY(244.0); // from top
			$pdf->SetX(13.8); // from left
			$pdf->Cell(0, 8, utf8_decode("Berlin, den " . date("d.m.Y", $time)));
			$pdf->Ln(0);

			$pdf->Image('uploads/company/' . intval($_SESSION["admin"]["company_id"]) . '/img/signature.jpg', 23.8, 252, 30);

			$pdf->Line(13.8, 263, 63.8, 263);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(13.8, 265);
			$pdf->MultiCell(0, 5, utf8_decode($maindata['company'] . ", " . $maindata['firstname'] . " " . $maindata['lastname'] . "\n- Vertragspartner zu 1) -"), 0);

			$pdf->Line(133.8, 263, 183.8, 263);

			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY(133.8, 265);
			$pdf->MultiCell(0, 5, utf8_decode($row_order['firstname'] . " " . $row_order['lastname'] . "\n- Vertragspartner zu 2) -"), 0);

			$random = rand(1, 100000);

			$arr_files = explode("\r\n", $row_order['files']);

			$old_file = "";

			for($f = 0;$f < count($arr_files);$f++){
				if($arr_files[$f] != "" && substr($arr_files[$f], strpos($arr_files[$f], "_") + 1) == "vergleich.pdf"){
					$old_file = $arr_files[$f];
				}
			}

			if($old_file != ""){

				$pdfdoc = $pdf->Output("F", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $old_file, true);

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
										SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
												`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Vergleich hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
												`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Vergleich hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
												`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Datei: [" . $old_file . "]") . "', 
												`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
				$document_open = "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $old_file;

			}else{

				$pdfdoc = $pdf->Output("F", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . "_vergleich.pdf"), true);

				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`order_orders_files`.`type`='0', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . "_vergleich.pdf") . "', 
												`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
				mysqli_query($conn, "	UPDATE 	`order_orders` 
										SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders`.`files`='" . mysqli_real_escape_string($conn, ($row_order['files'] == "" ? $random . "_vergleich.pdf" : $row_order['files'] . "\r\n" . $random . "_vergleich.pdf")) . "', 
												`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
										SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
												`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Vergleich hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
												`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Vergleich hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
												`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Datei: [" . $random . "_vergleich.pdf]") . "', 
												`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
				$document_open = "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . "_vergleich.pdf");

			}

			$parameter['tab'] = "files";

			$emsg_files = "<p>Der " . $order_name . " wurde erfolgreich geändert!</p>\n";

		}
	
	}

	$_POST['edit'] = "bearbeiten";

?>