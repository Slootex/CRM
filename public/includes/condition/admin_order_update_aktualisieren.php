<?php 

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_firstname = " is-invalid";
	} else {
		$from_firstname = strip_tags($_POST['from_firstname']);
	}

	if(strlen($_POST['from_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_lastname = " is-invalid";
	} else {
		$from_lastname = strip_tags($_POST['from_lastname']);
	}

	if(strlen($_POST['from_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_street = " is-invalid";
	} else {
		$from_street = strip_tags($_POST['from_street']);
	}

	if(strlen($_POST['from_streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_from_streetno = " is-invalid";
	} else {
		$from_streetno = strip_tags($_POST['from_streetno']);
	}

	if(strlen($_POST['from_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_from_zipcode = " is-invalid";
	} else {
		$from_zipcode = strip_tags($_POST['from_zipcode']);
	}

	if(strlen($_POST['from_city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_from_city = " is-invalid";
	} else {
		$from_city = strip_tags($_POST['from_city']);
	}

	if(strlen($_POST['from_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Absender-Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_from_country = " is-invalid";
	} else {
		$from_country = intval($_POST['from_country']);
	}

	if($_POST['from_email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['from_email'])){
		$from_email = strip_tags($_POST['from_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-E-Mail-Adresse ein.</small><br />\n";
		$inp_from_email = " is-invalid";
	}

	if(strlen($_POST['from_mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
	} else {
		$from_mobilnumber = strip_tags($_POST['from_mobilnumber']);
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
	} else {
		$from_phonenumber = strip_tags($_POST['from_phonenumber']);
	}


	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_firstname = " is-invalid";
	} else {
		$to_firstname = strip_tags($_POST['to_firstname']);
	}

	if(strlen($_POST['to_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_lastname = " is-invalid";
	} else {
		$to_lastname = strip_tags($_POST['to_lastname']);
	}

	if(strlen($_POST['to_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_street = " is-invalid";
	} else {
		$to_street = strip_tags($_POST['to_street']);
	}

	if(strlen($_POST['to_streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_to_streetno = " is-invalid";
	} else {
		$to_streetno = strip_tags($_POST['to_streetno']);
	}

	if(strlen($_POST['to_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_to_zipcode = " is-invalid";
	} else {
		$to_zipcode = strip_tags($_POST['to_zipcode']);
	}

	if(strlen($_POST['to_city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_to_city = " is-invalid";
	} else {
		$to_city = strip_tags($_POST['to_city']);
	}

	if(strlen($_POST['to_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Empfänger-Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_to_country = " is-invalid";
	} else {
		$to_country = intval($_POST['to_country']);
	}

	if($_POST['to_email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['to_email'])){
		$to_email = strip_tags($_POST['to_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-E-Mail-Adresse ein.</small><br />\n";
		$inp_to_email = " is-invalid";
	}

	if(strlen($_POST['to_mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
	} else {
		$to_mobilnumber = strip_tags($_POST['to_mobilnumber']);
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
	} else {
		$to_phonenumber = strip_tags($_POST['to_phonenumber']);
	}


	if(strlen($_POST['ref_number']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Referenznummer ein. (max. 256 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if(strlen($_POST['carriers_service']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Service aus.</small><br />\n";
		$inp_carriers_service = " is-invalid";
	} else {
		$carriers_service = strip_tags($_POST['carriers_service']);
	}

	if(strlen($_POST['package_template']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Paketvorlage aus.</small><br />\n";
		$inp_package_template = " is-invalid";
	} else {
		$package_template = intval($_POST['package_template']);
		$row_package_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `package_templates` WHERE `package_templates`.`id`='" . $package_template . "'"), MYSQLI_ASSOC);

		$length = $row_package_template['length'];
		$width = $row_package_template['width'];
		$height = $row_package_template['height'];
		$weight = $row_package_template['weight'];

	}

	if(strlen($_POST['length']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Paketlänge ein.</small><br />\n";
		$inp_length = " is-invalid";
	} else {
		$length = intval($_POST['length']);
	}

	if(strlen($_POST['width']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Paketbreite ein.</small><br />\n";
		$inp_width = " is-invalid";
	} else {
		$width = intval($_POST['width']);
	}

	if(strlen($_POST['height']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Pakethöhe ein.</small><br />\n";
		$inp_height = " is-invalid";
	} else {
		$height = intval($_POST['height']);
	}

	if(strlen($_POST['weight']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Paketgewicht ein.</small><br />\n";
		$inp_weight = " is-invalid";
	} else {
		$weight = floatval(str_replace(",", ".", $_POST['weight']));
	}

	if(strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Versandart aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['amount']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag an.</small><br />\n";
		$inp_amount = " is-invalid";
	} else {
		$amount = number_format(str_replace(",", ".", $_POST['amount']), 2, '.', '');
	}

	if(strlen($_POST['radio_saturday']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Samstagszuschlag besteht.</small><br />\n";
		$inp_radio_saturday = " is-invalid";
	} else {
		$radio_saturday = intval($_POST['radio_saturday']);
	}

	if(strlen($_POST['admin_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_admin_mail = " is-invalid";
	} else {
		$admin_mail = intval($_POST['admin_mail']);
	}

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}

	$_POST['edit'] = "bearbeiten";

?>