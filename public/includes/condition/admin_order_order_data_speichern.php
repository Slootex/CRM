<?php 

	if(strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
	} else {
		$machine = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
	} else {
		$model = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
	} else {
		$carid = strtoupper(strip_tags($_POST['carid']));
	}

	if(strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleistung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
	} else {
		$kw = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Kilometerstand eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_mileage = " is-invalid";
	} else {
		$mileage = intval(str_replace(".", "", $_POST['mileage']));
	}

	if(strlen($_POST['mechanism']) < 1 || strlen($_POST['mechanism']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte das Getriebe auswählen.</small><br />\n";
		$inp_mechanism = " is-invalid";
	} else {
		$mechanism = intval($_POST['mechanism']);
	}

	if(strlen($_POST['fuel']) < 1 || strlen($_POST['fuel']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte die Kraftstoffart auswählen.</small><br />\n";
		$inp_fuel = " is-invalid";
	} else {
		$fuel = intval($_POST['fuel']);
	}

	if(strlen($_POST['component']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
	} else {
		$component = intval($_POST['component']);
	}

	if(strlen($_POST['manufacturer']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte den Hersteller eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_manufacturer = " is-invalid";
	} else {
		$manufacturer = strtoupper(strip_tags($_POST['manufacturer']));
	}

	if(strlen($_POST['serial']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Teile.-/Herstellernummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_serial = " is-invalid";
	} else {
		$serial = strip_tags($_POST['serial']);
	}

	if(strlen($_POST['additional_numbers']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die zusätzlichen Nummern eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_additional_numbers = " is-invalid";
	} else {
		$additional_numbers = strip_tags($_POST['additional_numbers']);
	}

	if(strlen($_POST['fromthiscar']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Gerät aus dem angegebenen KFZ stammt. (max. 256 Zeichen)</small><br />\n";
		$inp_fromthiscar = " is-invalid";
	} else {
		$fromthiscar = intval($_POST['fromthiscar']);
	}

	if(strlen($_POST['open_by_user']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob durch Kunde geöffnet wurde. (max. 256 Zeichen)</small><br />\n";
		$inp_open_by_user = " is-invalid";
	} else {
		$open_by_user = intval($_POST['open_by_user']);
	}

	if(strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
	}

	if(strlen($_POST['note_to_the_technician']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Hinweis an den Techniker ein. (max. 700 Zeichen)</small><br />\n";
		$inp_note_to_the_technician = " is-invalid";
	} else {
		$note_to_the_technician = str_replace("\r\n", " - ", strip_tags($_POST['note_to_the_technician']));
	}

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`machine`='" . mysqli_real_escape_string($conn, $machine) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, $model) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, $constructionyear) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, strtoupper($carid)) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, $kw) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, $mileage) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, $mechanism) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, $fuel) . "', 
										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`order_orders`.`note_to_the_technician`='" . mysqli_real_escape_string($conn, $note_to_the_technician) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Auftragsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Auftragsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der " . $order_name . " wurde erfolgreich geändert!</p>\n";

		if($parameter['order_move'] == "Archiv"){

			$_POST['move'] = "Archiv";

		}

	}

	$_POST['edit'] = "bearbeiten";

?>