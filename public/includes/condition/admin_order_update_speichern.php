<?php 

	$time = time();

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(isset($_POST['differing_shipping_address']) && (intval($_POST['differing_shipping_address']) > 1 || intval($_POST['differing_shipping_address']) < 0)){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = (isset($_POST['differing_shipping_address']) ? intval($_POST['differing_shipping_address']) : 0);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_companyname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_companyname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichendes Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
	}

	if(strlen($_POST['pricemwst']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag ein.</small><br />\n";
		$inp_pricemwst = " is-invalid";
	} else {
		$pricemwst = str_replace(",", ".", $_POST['pricemwst']);
	}

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['ref_number']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Referenznummer eingeben. (max. 128 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if(strlen($_POST['call_date']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Termin eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_call_date = " is-invalid";
	} else {
		$call_date = strtotime($_POST['call_date']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['creator_id']) ? $_POST['creator_id'] : 0)) . "', 
										`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, $ref_number) . "', 
										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, $call_date) . "', 
										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_shipping_address']) ? $_POST['differing_shipping_address'] : 0)) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, $differing_companyname) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_gender']) ? $_POST['differing_gender'] : 0)) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, $differing_firstname) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, $differing_lastname) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, $differing_street) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, $differing_streetno) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, $differing_zipcode) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, $differing_city) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, $differing_country) . "', 
										`order_orders`.`pricemwst`='" . mysqli_real_escape_string($conn, $pricemwst) . "', 
										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_shipping']) ? $_POST['radio_shipping'] : 0)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_payment']) ? $_POST['radio_payment'] : 0)) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Kundendaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Kundendaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

		if($parameter['order_move'] == "Archiv"){

			$_POST['move'] = "Archiv";

		}

	}

	$_POST['edit'] = "bearbeiten";

?>