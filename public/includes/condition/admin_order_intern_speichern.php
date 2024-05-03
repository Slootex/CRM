<?php 

	$time = time();

	if(strlen($_POST['intern_time']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Zeit ein. (max. 256 Zeichen)</small><br />\n";
		$inp_intern_time = " is-invalid";
	} else {
		$intern_time = intval($_POST['intern_time']);
	}

	if(strlen($_POST['intern_acceptance_agreement_1']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Aufnahme-Einverständnis-1 erteilt wurde.</small><br />\n";
		$inp_intern_acceptance_agreement_1 = " is-invalid";
	} else {
		$intern_acceptance_agreement_1 = intval($_POST['intern_acceptance_agreement_1']);
	}

	if(strlen($_POST['intern_verbal_contract']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob ein Mündlicher-Vertrag besteht.</small><br />\n";
		$inp_intern_verbal_contract = " is-invalid";
	} else {
		$intern_verbal_contract = intval($_POST['intern_verbal_contract']);
	}

	if(strlen($_POST['intern_conversation_partner']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Gesprächspartner an. (max. 256 Zeichen)</small><br />\n";
		$inp_intern_conversation_partner = " is-invalid";
	} else {
		$intern_conversation_partner = strip_tags($_POST['intern_conversation_partner']);
	}

	if(strlen($_POST['intern_shipping_after_paying']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob der Versand erst nach Zahlung erfolgt.</small><br />\n";
		$inp_intern_shipping_after_paying = " is-invalid";
	} else {
		$intern_shipping_after_paying = intval($_POST['intern_shipping_after_paying']);
	}

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

	if(strlen($_POST['phonenumber2']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber2']));
	}

	if(strlen($_POST['mobilnumber2']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber2']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email2']) && $_POST['email2'] != ""){
		$email = strip_tags($_POST['email2']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = intval($_POST['differing_shipping_address']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 11 Zeichen)</small><br />\n";
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

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Versandart aus.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlart aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['intern_price_total']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Gesamtsumme ein.</small><br />\n";
		$inp_intern_price_total = " is-invalid";
	} else {
		$_POST['intern_price_total'] = $_POST['intern_price_total'] == "" || $_POST['intern_price_total'] == "0" ? "0,00" : strip_tags($_POST['intern_price_total']);
		$intern_price_total = str_replace(",", ".", $_POST['intern_price_total']);
	}

	if(strlen($_POST['intern_radio_paying']) < 1 || strlen($_POST['intern_radio_paying']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob die Gesamtsumme in Netto oder Brutto berechnet wird.</small><br />\n";
		$inp_intern_radio_paying = " is-invalid";
	} else {
		$intern_radio_paying = intval($_POST['intern_radio_paying']);
	}

	if(strlen($_POST['intern_release_price']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob die Freigrabe / Preis OK erteilt wurde.</small><br />\n";
		$inp_intern_release_price = " is-invalid";
	} else {
		$intern_release_price = intval($_POST['intern_release_price']);
	}

	if(strlen($_POST['intern_redemption_instruction']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob eine Rücknahmebelehrung erteilt wurde.</small><br />\n";
		$inp_intern_redemption_instruction = " is-invalid";
	} else {
		$intern_redemption_instruction = intval($_POST['intern_redemption_instruction']);
	}

	if(strlen($_POST['intern_exchange_instruction']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob eine Austauschgeräte-Belehrung erteilt wurde.</small><br />\n";
		$inp_intern_exchange_instruction = " is-invalid";
	} else {
		$intern_exchange_instruction = intval($_POST['intern_exchange_instruction']);
	}

	if(strlen($_POST['intern_birthday']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_intern_birthday = " is-invalid";
	} else {
		$intern_birthday = strtotime($_POST['intern_birthday']);
	}

	if(strlen($_POST['intern_acceptance_agreement_2']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Aufnahme-Einverständnis-2 erteilt wurde.</small><br />\n";
		$inp_intern_acceptance_agreement_2 = " is-invalid";
	} else {
		$intern_acceptance_agreement_2 = intval($_POST['intern_acceptance_agreement_2']);
	}

	if(strlen($_POST['intern_description']) > 65535){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine interne Beschreibung ein oder wählen ein Textbaustein aus. (max. 65535 Zeichen)</small><br />\n";
		$inp_intern_description = " is-invalid";
	} else {
		$intern_description = strip_tags($_POST['intern_description']);
	}

	if(strlen($_POST['intern_tech_info']) > 65535){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine interne Techniker-Info ein. (max. 65535 Zeichen)</small><br />\n";
		$inp_intern_tech_info = " is-invalid";
	} else {
		$intern_tech_info = strip_tags($_POST['intern_tech_info']);
	}

	if(strlen($_POST['intern_note']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den internen Vermerk an. (max. 256 Zeichen)</small><br />\n";
		$inp_intern_note = " is-invalid";
	} else {
		$intern_note = strip_tags($_POST['intern_note']);
	}

	if(strlen($_POST['intern_allocation']) < 1 || strlen($_POST['intern_allocation']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie Zuteilung.</small><br />\n";
		$inp_intern_allocation = " is-invalid";
	} else {
		$intern_allocation = intval($_POST['intern_allocation']);
	}

	if(strlen($_POST['intern_info']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den internen Hinweis an. (max. 256 Zeichen)</small><br />\n";
		$inp_intern_info = " is-invalid";
	} else {
		$intern_info = strip_tags($_POST['intern_info']);
	}

	if($emsg == ""){

		if(isset($_POST['intern_to_history']) && intval($_POST['intern_to_history']) == 1){

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`intern_time`='" . mysqli_real_escape_string($conn, $intern_time) . "', 
											`order_orders`.`intern_time_history`='" . mysqli_real_escape_string($conn, $intern_time) . "', 
											`order_orders`.`intern_text_module`='" . mysqli_real_escape_string($conn, intval($_POST['intern_text_module'])) . "', 
											`order_orders`.`intern_text_module_history`='" . mysqli_real_escape_string($conn, intval($_POST['intern_text_module'])) . "', 
											`order_orders`.`intern_acceptance_agreement_1`='" . mysqli_real_escape_string($conn, $intern_acceptance_agreement_1) . "', 
											`order_orders`.`intern_verbal_contract`='" . mysqli_real_escape_string($conn, $intern_verbal_contract) . "', 
											`order_orders`.`intern_conversation_partner`='" . mysqli_real_escape_string($conn, $intern_conversation_partner) . "', 
											`order_orders`.`intern_shipping_after_paying`='" . mysqli_real_escape_string($conn, $intern_shipping_after_paying) . "', 
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
											`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, $radio_shipping) . "', 
											`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, $radio_payment) . "', 
											`order_orders`.`intern_price_total`='" . mysqli_real_escape_string($conn, $intern_price_total) . "', 
											`order_orders`.`intern_radio_paying`='" . mysqli_real_escape_string($conn, $intern_radio_paying) . "', 
											`order_orders`.`intern_release_price`='" . mysqli_real_escape_string($conn, $intern_release_price) . "', 
											`order_orders`.`intern_redemption_instruction`='" . mysqli_real_escape_string($conn, $intern_redemption_instruction) . "', 
											`order_orders`.`intern_exchange_instruction`='" . mysqli_real_escape_string($conn, $intern_exchange_instruction) . "', 
											`order_orders`.`intern_birthday`='" . mysqli_real_escape_string($conn, $intern_birthday) . "', 
											`order_orders`.`intern_acceptance_agreement_2`='" . mysqli_real_escape_string($conn, $intern_acceptance_agreement_2) . "', 
											`order_orders`.`intern_description`='" . mysqli_real_escape_string($conn, $intern_description) . "', 
											`order_orders`.`intern_tech_info`='" . mysqli_real_escape_string($conn, $intern_tech_info) . "', 
											`order_orders`.`intern_note`='" . mysqli_real_escape_string($conn, $intern_note) . "', 
											`order_orders`.`intern_allocation`='" . mysqli_real_escape_string($conn, $intern_allocation) . "', 
											`order_orders`.`intern_info`='" . mysqli_real_escape_string($conn, $intern_info) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		}else{

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`intern_time`='" . mysqli_real_escape_string($conn, $intern_time) . "', 
											`order_orders`.`intern_time_history`='0', 
											`order_orders`.`intern_text_module`='" . mysqli_real_escape_string($conn, intval($_POST['intern_text_module'])) . "', 
											`order_orders`.`intern_text_module_history`='0', 
											`order_orders`.`intern_acceptance_agreement_1`='" . mysqli_real_escape_string($conn, $intern_acceptance_agreement_1) . "', 
											`order_orders`.`intern_verbal_contract`='" . mysqli_real_escape_string($conn, $intern_verbal_contract) . "', 
											`order_orders`.`intern_conversation_partner`='" . mysqli_real_escape_string($conn, $intern_conversation_partner) . "', 
											`order_orders`.`intern_shipping_after_paying`='" . mysqli_real_escape_string($conn, $intern_shipping_after_paying) . "', 
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
											`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, $radio_shipping) . "', 
											`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, $radio_payment) . "', 
											`order_orders`.`intern_price_total`='" . mysqli_real_escape_string($conn, $intern_price_total) . "', 
											`order_orders`.`intern_radio_paying`='" . mysqli_real_escape_string($conn, $intern_radio_paying) . "', 
											`order_orders`.`intern_release_price`='" . mysqli_real_escape_string($conn, $intern_release_price) . "', 
											`order_orders`.`intern_redemption_instruction`='" . mysqli_real_escape_string($conn, $intern_redemption_instruction) . "', 
											`order_orders`.`intern_exchange_instruction`='" . mysqli_real_escape_string($conn, $intern_exchange_instruction) . "', 
											`order_orders`.`intern_birthday`='" . mysqli_real_escape_string($conn, $intern_birthday) . "', 
											`order_orders`.`intern_acceptance_agreement_2`='" . mysqli_real_escape_string($conn, $intern_acceptance_agreement_2) . "', 
											`order_orders`.`intern_description`='" . mysqli_real_escape_string($conn, $intern_description) . "', 
											`order_orders`.`intern_tech_info`='" . mysqli_real_escape_string($conn, $intern_tech_info) . "', 
											`order_orders`.`intern_note`='" . mysqli_real_escape_string($conn, $intern_note) . "', 
											`order_orders`.`intern_allocation`='" . mysqli_real_escape_string($conn, $intern_allocation) . "', 
											`order_orders`.`intern_info`='" . mysqli_real_escape_string($conn, $intern_info) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		}

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Intern-Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Intern-Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der " . $order_name . " wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>