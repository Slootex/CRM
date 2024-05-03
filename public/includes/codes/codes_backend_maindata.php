<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "maindata";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$show_autocomplete_script = 1;

$countryToId = "";

$emsg = "";

$inp_company = "";
$inp_firstname = "";
$inp_lastname = "";
$inp_street = "";
$inp_streetno = "";
$inp_zipcode = "";
$inp_city = "";
$inp_country = "";
$inp_email = "";
$inp_phonenumber = "";
$inp_mobilnumber = "";

$inp_bank_name = "";
$inp_bank_iban = "";
$inp_bank_bic = "";

$inp_logo_url = "";
$inp_logout_index = "";
$inp_user_index = "";
$inp_input_file_accept = "";
$inp_input_file_audio_accept = "";
$inp_url_password = "";
$inp_super_password = "";
$inp_customer_history_delay_time = "";

$inp_smtp_host = "";
$inp_smtp_username = "";
$inp_smtp_password = "";
$inp_smtp_secure = "";
$inp_smtp_port = "";
$inp_smtp_charset = "";
$inp_smtp_debug = "";

$inp_vindecoder_url = "";
$inp_vindecoder_api_key = "";
$inp_vindecoder_secret = "";

$inp_ups_url = "";
$inp_ups_username = "";
$inp_ups_password = "";
$inp_ups_customer_number = "";
$inp_ups_access_license_number = "";
$inp_package = "";

$inp_order_extended_items = "";

$inp_style_backend = "";
$inp_script_backend = "";
$inp_script_backend_activate = "";

$company = "";
$firstname = "";
$lastname = "";
$street = "";
$streetno = "";
$zipcode = "";
$city = "";
$country = 0;
$email = "";
$phonenumber = "";
$mobilnumber = "";

$bank_name = "";
$bank_iban = "";
$bank_bic = "";

$logo_url = "";
$logout_index = "";
$user_index = "";
$input_file_accept = "";
$input_file_audio_accept = "";
$url_password = "";
$super_password = "";
$customer_history_delay_time = "";

$smtp_host = "";
$smtp_username = "";
$smtp_password = "";
$smtp_secure = "";
$smtp_port = "";
$smtp_charset = "";
$smtp_debug = "";

$vindecoder_url = "";
$vindecoder_api_key = "";
$vindecoder_secret = "";

$ups_url = "";
$ups_username = "";
$ups_password = "";
$ups_customer_number = "";
$ups_access_license_number = "";
$package = 0;

$order_extended_items = "";

$style_backend = "";
$script_backend = "";
$script_backend_activate = 0;

$none_file_accept = explode(",", $systemdata['none_file_accept']);

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['company']) < 1 || strlen($_POST['company']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihren Firmenname eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_company = " is-invalid";
	} else {
		$company = strip_tags($_POST['company']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 20){
		$emsg .= "<span class=\"error\">Bitte den Eigentümer Vorname eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 20){
		$emsg .= "<span class=\"error\">Bitte den Eigentümer Nachname eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 128){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Straße eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Hausnummer eingeben. (max. 10 Zeichen)</span><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Postleitzahl eingeben. (max. 10 Zeichen)</span><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 20){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Ort eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) < 1 || strlen($_POST['country']) > 11){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Land eingeben. (max. 11 Zeichen)</span><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = $_POST['email'];
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihre E-Mail-Adresse eingeben.</span><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Telefonnummer eingeben. (max. 100 Zeichen)</span><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = strip_tags($_POST['phonenumber']);
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<span class=\"error\">Bitte die Eigentümer Mobilnummer eingeben. (max. 100 Zeichen)</span><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = strip_tags($_POST['mobilnumber']);
	}


	if(strlen($_POST['bank_name']) > 128){
		$emsg .= "<span class=\"error\">Bitte den Eigentümer Bankname eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_bank_name = " is-invalid";
	} else {
		$bank_name = strip_tags($_POST['bank_name']);
	}

	if(strlen($_POST['bank_iban']) > 128){
		$emsg .= "<span class=\"error\">Bitte den Eigentümer IBAN-Nummer eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_bank_iban = " is-invalid";
	} else {
		$bank_iban = strip_tags($_POST['bank_iban']);
	}

	if(strlen($_POST['bank_bic']) > 20){
		$emsg .= "<span class=\"error\">Bitte den Eigentümer BIC-Nummer eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_bank_bic = " is-invalid";
	} else {
		$bank_bic = strip_tags($_POST['bank_bic']);
	}


	if(strlen($_POST['logo_url']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine Logo-URL eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_logo_url = " is-invalid";
	} else {
		$logo_url = strip_tags($_POST['logo_url']);
	}

	if(strlen($_POST['logout_index']) < 1 || strlen($_POST['logout_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Zielort, für nach dem abmelden, eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_logout_index = " is-invalid";
	} else {
		$logout_index = strip_tags($_POST['logout_index']);
	}

	if(strlen($_POST['user_index']) < 1 || strlen($_POST['user_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Zielort, für nach der Kundenanmelden, eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_user_index = " is-invalid";
	} else {
		$user_index = strip_tags($_POST['user_index']);
	}

	if(strlen($_POST['input_file_accept']) > 512){
		$emsg .= "<span class=\"error\">Bitte die erlaubten Dateiendungen eingeben. (max. 512 Zeichen)</span><br />\n";
		$inp_input_file_accept = " is-invalid";
	} else {
		$input_file_accept = strip_tags($_POST['input_file_accept']);
		for($e = 0;$e < count($none_file_accept);$e++){
			$input_file_accept = str_replace("," . $none_file_accept[$e], "", $input_file_accept);
			$input_file_accept = str_replace($none_file_accept[$e], "", $input_file_accept);
		}
	}

	if(strlen($_POST['input_file_audio_accept']) > 512){
		$emsg .= "<span class=\"error\">Bitte die erlaubten Dateiendungen eingeben. (max. 512 Zeichen)</span><br />\n";
		$inp_input_file_audio_accept = " is-invalid";
	} else {
		$input_file_audio_accept = strip_tags($_POST['input_file_audio_accept']);
		for($e = 0;$e < count($none_file_accept);$e++){
			$input_file_audio_accept = str_replace("," . $none_file_accept[$e], "", $input_file_audio_accept);
			$input_file_audio_accept = str_replace($none_file_accept[$e], "", $input_file_audio_accept);
		}
	}

	if(strlen($_POST['url_password']) > 128){
		$emsg .= "<span class=\"error\">Bitte das, als bezahlt gestellt, Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_url_password = " is-invalid";
	} else {
		$url_password = strip_tags($_POST['url_password']);
	}

	if(strlen($_POST['super_password']) > 128){
		$emsg .= "<span class=\"error\">Bitte super Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_super_password = " is-invalid";
	} else {
		$super_password = strip_tags($_POST['super_password']);
	}

	if(strlen($_POST['customer_history_delay_time']) > 11){
		$emsg .= "<span class=\"error\">Bitte die Telefonhistorie-Zeitunterbindung eingeben. (max. 11 Zeichen)</span><br />\n";
		$inp_customer_history_delay_time = " is-invalid";
	} else {
		$customer_history_delay_time = intval($_POST['customer_history_delay_time']);
	}

	if(strlen($_POST['smtp_host']) > 256){
		$emsg .= "<span class=\"error\">Bitte die SMTP-Server-URL eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_smtp_host = " is-invalid";
	} else {
		$smtp_host = strip_tags($_POST['smtp_host']);
	}

	if(strlen($_POST['smtp_username']) > 256){
		$emsg .= "<span class=\"error\">Bitte den SMTP-Benutzername eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_smtp_username = " is-invalid";
	} else {
		$smtp_username = strip_tags($_POST['smtp_username']);
	}

	if(strlen($_POST['smtp_password']) > 256){
		$emsg .= "<span class=\"error\">Bitte das SMTP-Kennwort eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_smtp_password = " is-invalid";
	} else {
		$smtp_password = strip_tags($_POST['smtp_password']);
	}

	if(strlen($_POST['smtp_secure']) > 256){
		$emsg .= "<span class=\"error\">Bitte das SMTP-Verschlüsselung z.b. tls eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_smtp_secure = " is-invalid";
	} else {
		$smtp_secure = strip_tags($_POST['smtp_secure']);
	}

	if(strlen($_POST['smtp_port']) > 11){
		$emsg .= "<span class=\"error\">Bitte das SMTP-Port z.b. 587 eingeben.</span><br />\n";
		$inp_smtp_port = " is-invalid";
	} else {
		$smtp_port = intval($_POST['smtp_port']);
	}

	if(strlen($_POST['smtp_charset']) > 256){
		$emsg .= "<span class=\"error\">Bitte das SMTP-Kodierung z.b. UTF-8 eingeben.</span><br />\n";
		$inp_smtp_charset = " is-invalid";
	} else {
		$smtp_charset = strip_tags($_POST['smtp_charset']);
	}

	if(strlen($_POST['vindecoder_url']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Vindecoder-URL eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_vindecoder_url = " is-invalid";
	} else {
		$vindecoder_url = strip_tags($_POST['vindecoder_url']);
	}

	if(strlen($_POST['vindecoder_api_key']) > 20){
		$emsg .= "<span class=\"error\">Bitte den Vindecoder-API-KEY eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_vindecoder_api_key = " is-invalid";
	} else {
		$vindecoder_api_key = strip_tags($_POST['vindecoder_api_key']);
	}

	if(strlen($_POST['vindecoder_secret']) > 20){
		$emsg .= "<span class=\"error\">Bitte das Vindecoder-SECRET eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_vindecoder_secret = " is-invalid";
	} else {
		$vindecoder_secret = strip_tags($_POST['vindecoder_secret']);
	}


	if(strlen($_POST['ups_url']) > 256){
		$emsg .= "<span class=\"error\">Bitte die UPS-URL eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_ups_url = " is-invalid";
	} else {
		$ups_url = strip_tags($_POST['ups_url']);
	}

	if(strlen($_POST['ups_username']) > 20){
		$emsg .= "<span class=\"error\">Bitte den UPS-Benutzername eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_ups_username = " is-invalid";
	} else {
		$ups_username = strip_tags($_POST['ups_username']);
	}

	if(strlen($_POST['ups_password']) > 20){
		$emsg .= "<span class=\"error\">Bitte das UPS-Kennwort eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_ups_password = " is-invalid";
	} else {
		$ups_password = strip_tags($_POST['ups_password']);
	}

	if(strlen($_POST['ups_customer_number']) > 20){
		$emsg .= "<span class=\"error\">Bitte die UPS-Kundennummer eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_ups_customer_number = " is-invalid";
	} else {
		$ups_customer_number = strip_tags($_POST['ups_customer_number']);
	}

	if(strlen($_POST['ups_access_license_number']) > 20){
		$emsg .= "<span class=\"error\">Bitte die UPS-Zugriff-Lizens-Nummer eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_ups_access_license_number = " is-invalid";
	} else {
		$ups_access_license_number = strip_tags($_POST['ups_access_license_number']);
	}

	if(strlen($_POST['package']) < 1 || strlen($_POST['package']) > 11){
		$emsg .= "<span class=\"error\">Bitte das standard Paket auswählen.</span><br />\n";
		$inp_package = " is-invalid";
	} else {
		$package = intval($_POST['package']);
	}


	if(strlen($_POST['order_extended_items']) > 65536){
		$emsg .= "<span class=\"error\">Bitte ein Zusatzartikel eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_order_extended_items = " is-invalid";
	} else {
		$order_extended_items = strip_tags($_POST['order_extended_items']);
	}

	if(strlen($_POST['style_backend']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Backend-Style eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style_backend = " is-invalid";
	} else {
		$style_backend = html_entity_decode($_POST['style_backend']);
	}

	if(strlen($_POST['script_backend']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Backend-JavaScript eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_script_backend = " is-invalid";
	} else {
		$script_backend = html_entity_decode($_POST['script_backend']);
	}

	if(isset($_POST['script_backend_activate']) && intval($_POST['script_backend_activate']) != 1){
		$emsg .= "<span class=\"error\">Bitte wählen Sie ob das Backend-Script aktiviert werden soll.</span><br />\n";
		$inp_script_backend_activate = " is-invalid";
	} else {
		$script_backend_activate = (isset($_POST['script_backend_activate']) && intval($_POST['script_backend_activate']) == 1 ? 1 : 0);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`maindata` 
								SET 	`maindata`.`company`='" . mysqli_real_escape_string($conn, $company) . "', 
										`maindata`.`gender`='" . mysqli_real_escape_string($conn, (isset($_POST['gender']) ? intval($_POST['gender']) : 0)) . "', 
										`maindata`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`maindata`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`maindata`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`maindata`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`maindata`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`maindata`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`maindata`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`maindata`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`maindata`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`maindata`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 

										`maindata`.`bank_name`='" . mysqli_real_escape_string($conn, $bank_name) . "', 
										`maindata`.`bank_iban`='" . mysqli_real_escape_string($conn, $bank_iban) . "', 
										`maindata`.`bank_bic`='" . mysqli_real_escape_string($conn, $bank_bic) . "', 

										`maindata`.`logo_url`='" . mysqli_real_escape_string($conn, $logo_url) . "', 
										`maindata`.`supervisor_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['supervisor_id']) ? $_POST['supervisor_id'] : 0)) . "', 
										`maindata`.`logout_index`='" . mysqli_real_escape_string($conn, $logout_index) . "', 
										`maindata`.`user_index`='" . mysqli_real_escape_string($conn, $user_index) . "', 
										`maindata`.`input_file_accept`='" . mysqli_real_escape_string($conn, $input_file_accept) . "', 
										`maindata`.`input_file_audio_accept`='" . mysqli_real_escape_string($conn, $input_file_audio_accept) . "', 
										`maindata`.`url_password`='" . mysqli_real_escape_string($conn, $url_password) . "', 
										`maindata`.`super_password`='" . mysqli_real_escape_string($conn, $super_password) . "', 
										`maindata`.`mwst`='" . mysqli_real_escape_string($conn, intval(isset($_POST['mwst']) ? $_POST['mwst'] : 1)) . "', 
										`maindata`.`counter`='" . mysqli_real_escape_string($conn, intval(isset($_POST['counter']) ? $_POST['counter'] : 1)) . "', 
										`maindata`.`customer_history_delay_time`='" . mysqli_real_escape_string($conn, intval(isset($_POST['customer_history_delay_time']) ? $_POST['customer_history_delay_time'] : 0)) . "', 

										`maindata`.`smtp_host`='" . mysqli_real_escape_string($conn, $smtp_host) . "', 
										`maindata`.`smtp_username`='" . mysqli_real_escape_string($conn, $smtp_username) . "', 
										`maindata`.`smtp_password`='" . mysqli_real_escape_string($conn, $smtp_password) . "', 
										`maindata`.`smtp_secure`='" . mysqli_real_escape_string($conn, $smtp_secure) . "', 
										`maindata`.`smtp_port`='" . mysqli_real_escape_string($conn, $smtp_port) . "', 
										`maindata`.`smtp_charset`='" . mysqli_real_escape_string($conn, $smtp_charset) . "', 
										`maindata`.`smtp_debug`='" . mysqli_real_escape_string($conn, intval(isset($_POST['smtp_debug']) ? $_POST['smtp_debug'] : 0)) . "', 

										`maindata`.`vindecoder_url`='" . mysqli_real_escape_string($conn, $vindecoder_url) . "', 
										`maindata`.`vindecoder_api_key`='" . mysqli_real_escape_string($conn, $vindecoder_api_key) . "', 
										`maindata`.`vindecoder_secret`='" . mysqli_real_escape_string($conn, $vindecoder_secret) . "', 

										`maindata`.`ups_url`='" . mysqli_real_escape_string($conn, $ups_url) . "', 
										`maindata`.`ups_username`='" . mysqli_real_escape_string($conn, $ups_username) . "', 
										`maindata`.`ups_password`='" . mysqli_real_escape_string($conn, $ups_password) . "', 
										`maindata`.`ups_customer_number`='" . mysqli_real_escape_string($conn, $ups_customer_number) . "', 
										`maindata`.`ups_access_license_number`='" . mysqli_real_escape_string($conn, $ups_access_license_number) . "', 
										`maindata`.`package`='" . mysqli_real_escape_string($conn, $package) . "', 
										`maindata`.`new_shipping_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['new_shipping_status']) ? $_POST['new_shipping_status'] : 0)) . "', 
										`maindata`.`pickup_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['pickup_status']) ? $_POST['pickup_status'] : 1)) . "', 
										`maindata`.`sleep_shipping_label`='" . mysqli_real_escape_string($conn, intval(isset($_POST['sleep_shipping_label']) ? $_POST['sleep_shipping_label'] : 0)) . "', 

										`maindata`.`admin_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
										`maindata`.`storage_space_owner_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_owner_id']) ? $_POST['storage_space_owner_id'] : 0)) . "', 
										`maindata`.`order_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_status']) ? $_POST['order_status'] : 1)) . "', 
										`maindata`.`order_status_intern`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_status_intern']) ? $_POST['order_status_intern'] : 1)) . "', 
										`maindata`.`shipping_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['shipping_status']) ? $_POST['shipping_status'] : 1)) . "', 
										`maindata`.`shipping_cancel_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['shipping_cancel_status']) ? $_POST['shipping_cancel_status'] : 0)) . "', 
										`maindata`.`email_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['email_status']) ? $_POST['email_status'] : 1)) . "', 
										`maindata`.`order_to_archive_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_to_archive_status']) ? $_POST['order_to_archive_status'] : 1)) . "', 
										`maindata`.`archive_to_order_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['archive_to_order_status']) ? $_POST['archive_to_order_status'] : 1)) . "', 
										`maindata`.`order_payed_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_payed_status']) ? $_POST['order_payed_status'] : 1)) . "', 
										`maindata`.`order_to_booking_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_to_booking_status']) ? $_POST['order_to_booking_status'] : 1)) . "', 
										`maindata`.`order_ending_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_ending_status']) ? $_POST['order_ending_status'] : 1)) . "', 
										`maindata`.`order_claim_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_claim_status']) ? $_POST['order_claim_status'] : 1)) . "', 
										`maindata`.`order_recall_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_recall_status']) ? $_POST['order_recall_status'] : 1)) . "', 
										`maindata`.`order_in_checkout_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_in_checkout_status']) ? $_POST['order_in_checkout_status'] : 1)) . "', 
										`maindata`.`order_extra_evaluation_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_extra_evaluation_status']) ? $_POST['order_extra_evaluation_status'] : 1)) . "', 
										`maindata`.`order_inspection_process_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_inspection_process_status']) ? $_POST['order_inspection_process_status'] : 1)) . "', 
										`maindata`.`order_extra_verification_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_extra_verification_status']) ? $_POST['order_extra_verification_status'] : 1)) . "', 
										`maindata`.`order_extra_edit_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_extra_edit_status']) ? $_POST['order_extra_edit_status'] : 1)) . "', 
										`maindata`.`order_extra_checkout_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_extra_checkout_status']) ? $_POST['order_extra_checkout_status'] : 1)) . "', 
										`maindata`.`order_new_device_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_new_device_status']) ? $_POST['order_new_device_status'] : 1)) . "', 
										`maindata`.`order_problem_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_problem_status']) ? $_POST['order_problem_status'] : 1)) . "', 
										`maindata`.`order_packing_user_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_packing_user_status']) ? $_POST['order_packing_user_status'] : 1)) . "', 
										`maindata`.`order_packing_technic_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_packing_technic_status']) ? $_POST['order_packing_technic_status'] : 1)) . "', 
										`maindata`.`order_relocate_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_relocate_status']) ? $_POST['order_relocate_status'] : 1)) . "', 
										`maindata`.`order_labeling_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_labeling_status']) ? $_POST['order_labeling_status'] : 1)) . "', 
										`maindata`.`order_photo_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_photo_status']) ? $_POST['order_photo_status'] : 1)) . "', 

										`maindata`.`order_extended_items`='" . mysqli_real_escape_string($conn, strip_tags($order_extended_items)) . "', 

										`maindata`.`user_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['user_status']) ? $_POST['user_status'] : 1)) . "', 
										`maindata`.`user_status_intern`='" . mysqli_real_escape_string($conn, intval(isset($_POST['user_status_intern']) ? $_POST['user_status_intern'] : 1)) . "', 
										`maindata`.`user_email_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['user_email_status']) ? $_POST['user_email_status'] : 1)) . "', 

										`maindata`.`interested_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_status']) ? $_POST['interested_status'] : 1)) . "', 
										`maindata`.`interested_status_intern`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_status_intern']) ? $_POST['interested_status_intern'] : 1)) . "', 
										`maindata`.`interested_status_intern_orderform_per_mail`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_status_intern_orderform_per_mail']) ? $_POST['interested_status_intern_orderform_per_mail'] : 1)) . "', 
										`maindata`.`interested_email_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_email_status']) ? $_POST['interested_email_status'] : 1)) . "', 
										`maindata`.`interested_to_archive_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_to_archive_status']) ? $_POST['interested_to_archive_status'] : 1)) . "', 
										`maindata`.`archive_to_interested_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['archive_to_interested_status']) ? $_POST['archive_to_interested_status'] : 1)) . "', 
										`maindata`.`order_to_interested_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_to_interested_status']) ? $_POST['order_to_interested_status'] : 1)) . "', 
										`maindata`.`order_archive_to_interested_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['order_archive_to_interested_status']) ? $_POST['order_archive_to_interested_status'] : 1)) . "', 
										`maindata`.`interested_to_order_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_to_order_status']) ? $_POST['interested_to_order_status'] : 1)) . "', 
										`maindata`.`interested_success_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_success_status']) ? $_POST['interested_success_status'] : 1)) . "', 
										`maindata`.`interested_new_device_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_new_device_status']) ? $_POST['interested_new_device_status'] : 1)) . "', 
										`maindata`.`interested_problem_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_problem_status']) ? $_POST['interested_problem_status'] : 1)) . "', 
										`maindata`.`interested_packing_user_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_packing_user_status']) ? $_POST['interested_packing_user_status'] : 1)) . "', 
										`maindata`.`interested_packing_technic_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_packing_technic_status']) ? $_POST['interested_packing_technic_status'] : 1)) . "', 
										`maindata`.`interested_relocate_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_relocate_status']) ? $_POST['interested_relocate_status'] : 1)) . "', 
										`maindata`.`interested_labeling_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_labeling_status']) ? $_POST['interested_labeling_status'] : 1)) . "', 
										`maindata`.`interested_photo_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['interested_photo_status']) ? $_POST['interested_photo_status'] : 1)) . "', 

										`maindata`.`shopping_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['shopping_status']) ? $_POST['shopping_status'] : 1)) . "', 
										`maindata`.`shopping_to_archive_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['shopping_to_archive_status']) ? $_POST['shopping_to_archive_status'] : 1)) . "', 
										`maindata`.`archive_to_shoppings_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['archive_to_shoppings_status']) ? $_POST['archive_to_shoppings_status'] : 1)) . "', 
										`maindata`.`retoure_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['retoure_status']) ? $_POST['retoure_status'] : 1)) . "', 
										`maindata`.`shopping_to_retoures_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['shopping_to_retoures_status']) ? $_POST['shopping_to_retoures_status'] : 1)) . "', 
										`maindata`.`retoure_to_shoppings_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['retoure_to_shoppings_status']) ? $_POST['retoure_to_shoppings_status'] : 1)) . "', 

										`maindata`.`packing_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['packing_status']) ? $_POST['packing_status'] : 1)) . "', 
										`maindata`.`packing_to_archive_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['packing_to_archive_status']) ? $_POST['packing_to_archive_status'] : 1)) . "', 
										`maindata`.`archive_to_packings_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['archive_to_packings_status']) ? $_POST['archive_to_packings_status'] : 1)) . "', 

										`maindata`.`style_backend`='" . mysqli_real_escape_string($conn, $style_backend) . "', 
										`maindata`.`script_backend`='" . mysqli_real_escape_string($conn, $script_backend) . "', 
										`maindata`.`script_backend_activate`='" . mysqli_real_escape_string($conn, $script_backend_activate) . "' 

								WHERE 	`maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Die Grunddaten wurden erfolgreich geändert!</p>\n";

	}

}

if(isset($_POST['delete_temp']) && $_POST['delete_temp'] == "entfernen"){

	$files = glob('temp/*');

	foreach($files as $file){
		if(is_file($file) && $file != ".htaccess"){
			unlink($file);
		}
	}

	$time = time();

	mysqli_query($conn, "	UPDATE 	`maindata` 
							SET 	`maindata`.`delete_temp_date`='" . mysqli_real_escape_string($conn, $time) . "' 
							WHERE 	`maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$emsg = "<p>Die temporären Dateien wurden entfernt!</p>\n";

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$types = array(
	0 => "Abholen", 
	1 => "Aufträge", 
	2 => "Versand", 
	3 => "Kunden", 
	4 => "Interessenten", 
	5 => "Einkäufe", 
	6 => "Retouren", 
	7 => "Packtisch"
);

$row_company = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$row_maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$result_countries = mysqli_query($conn, "SELECT * FROM `countries` ORDER BY `countries`.`name` ASC");

$countries_options = "";

while($row = $result_countries->fetch_array(MYSQLI_ASSOC)){

	$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

	$countries_options .= "<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ($row['id'] == (isset($_POST['save']) && $_POST['save'] == "speichern" ? $country : strip_tags($row_maindata["country"])) ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

}

$result_package_templates = mysqli_query($conn, "SELECT * FROM `package_templates` ORDER BY CAST(`package_templates`.`id` AS UNSIGNED) ASC");

$package_options = "";

while($row = $result_package_templates->fetch_array(MYSQLI_ASSOC)){

	$package_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == (isset($_POST['save']) && $_POST['save'] == "speichern" ? $package : $row_maindata["package"]) ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

}

$options_supervisor_id = "";

$options_admin_id = "";

$options_storage_space_owner_id = "";

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`admin` 
								WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	`admin`.`name`");

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$options_supervisor_id .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['supervisor_id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	$options_admin_id .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['admin_id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	$options_storage_space_owner_id .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['storage_space_owner_id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$pickup_statuses_options = "";
$statuses_options = "";
$statuses_intern_options = "";
$shipping_statuses_options = "";
$shipping_cancel_statuses_options = "";
$email_statuses_options = "";
$order_to_archive_statuses_options = "";
$archive_to_statuses_options = "";
$order_payed_statuses_options = "";
$order_to_booking_statuses_options = "";
$order_ending_statuses_options = "";
$order_claim_statuses_options = "";
$order_recall_statuses_options = "";
$order_in_checkout_statuses_options = "";
$order_extra_evaluation_statuses_options = "";
$order_inspection_process_statuses_options = "";
$order_extra_verification_statuses_options = "";
$order_extra_edit_statuses_options = "";
$order_extra_checkout_statuses_options = "";
$order_new_device_statuses_options = "";
$order_problem_statuses_options = "";
$order_packing_user_statuses_options = "";
$order_packing_technic_statuses_options = "";
$order_relocate_statuses_options = "";
$order_labeling_statuses_options = "";
$order_photo_statuses_options = "";

$new_shipping_status_options = "";

$user_statuses_options = "";
$user_statuses_intern_options = "";
$user_email_statuses_options = "";

$interested_statuses_options = "";
$interested_statuses_intern_options = "";
$interested_status_intern_orderform_per_mail_options = "";
$interested_email_statuses_options = "";
$interested_to_archive_statuses_options = "";
$archive_to_interested_statuses_options = "";
$order_to_interested_statuses_options = "";
$order_archive_to_interested_statuses_options = "";
$interested_to_order_statuses_options = "";
$interested_success_statuses_options = "";
$interested_new_device_statuses_options = "";
$interested_problem_statuses_options = "";
$interested_packing_user_statuses_options = "";
$interested_packing_technic_statuses_options = "";
$interested_relocate_statuses_options = "";
$interested_labeling_statuses_options = "";
$interested_photo_statuses_options = "";

$shopping_status_options = "";
$shopping_to_archive_status_options = "";
$archive_to_shoppings_status_options = "";

$retoure_status_options = "";
$shopping_to_retoures_status_options = "";
$retoure_to_shoppings_status_options = "";

$packing_status_options = "";
$packing_to_archive_status_options = "";
$archive_to_packings_status_options = "";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

	switch($row['type']){

		case 0: // Abholen
			$pickup_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['pickup_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 1: // Aufträge
			$statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$statuses_intern_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_status_intern'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$shipping_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['shipping_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$shipping_cancel_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['shipping_cancel_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$email_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['email_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_to_archive_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_to_archive_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$archive_to_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['archive_to_order_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_payed_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_payed_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_to_booking_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_to_booking_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_ending_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_ending_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_claim_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_claim_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_recall_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_recall_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_in_checkout_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_in_checkout_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_extra_evaluation_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_extra_evaluation_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_inspection_process_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_inspection_process_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_extra_verification_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_extra_verification_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_extra_edit_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_extra_edit_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_extra_checkout_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_extra_checkout_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_new_device_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_new_device_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_problem_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_problem_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_packing_user_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_packing_user_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_packing_technic_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_packing_technic_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_relocate_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_relocate_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_labeling_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_labeling_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_photo_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_photo_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 2: // 
			$new_shipping_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['new_shipping_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 3: // Kunden
			$user_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['user_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$user_statuses_intern_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['user_status_intern'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$user_email_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['user_email_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 4: // Interesenten
			$interested_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_statuses_intern_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_status_intern'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_status_intern_orderform_per_mail_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_status_intern_orderform_per_mail'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_email_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_email_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_to_archive_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_to_archive_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$archive_to_interested_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['archive_to_interested_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_to_interested_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_to_interested_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$order_archive_to_interested_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['order_archive_to_interested_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_to_order_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_to_order_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_success_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_success_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_new_device_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_new_device_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_problem_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_problem_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_packing_user_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_packing_user_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_packing_technic_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_packing_technic_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_relocate_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_relocate_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_labeling_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_labeling_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$interested_photo_statuses_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['interested_photo_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 5: // Einkäufe
			$shopping_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['shopping_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$shopping_to_archive_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['shopping_to_archive_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$archive_to_shoppings_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['archive_to_shoppings_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 6: // Retouren
			$retoure_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['retoure_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$shopping_to_retoures_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['shopping_to_retoures_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$retoure_to_shoppings_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['retoure_to_shoppings_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

		case 7: // Packtisch
			$packing_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['packing_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$packing_to_archive_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['packing_to_archive_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			$archive_to_packings_status_options .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $row_maindata['archive_to_packings_status'] ? " selected=\"selected\"" : "") . ">" . $types[$row['type']] . ", " . $row['name'] . "</option>\n";
			break;

	}

}

$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

$options_pages_logout_index = "";
$options_pages_user_index = "";

$result_pages = mysqli_query($conn, "	SELECT 		* 
										FROM 		`pages` 
										ORDER BY 	`pages`.`name` ASC");

while($row = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$options_pages_logout_index .= "								<option value=\"" . $row['url'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (strip_tags($_POST['logout_index']) == $row['url'] ? " selected=\"selected\"" : "") : (strip_tags($row_maindata['logout_index']) == $row['url'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	$options_pages_user_index .= "								<option value=\"" . $row['url'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (strip_tags($_POST['user_index']) == $row['url'] ? " selected=\"selected\"" : "") : (strip_tags($row_maindata['user_index']) == $row['url'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Einstellungen - Grunddaten</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Grunddaten verwalten.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col\">\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Grunddaten</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		"					<div class=\"row mb-3\">\n" . 
		"						<div class=\"col-3 border-right\">\n" . 
		"							<div class=\"nav flex-column nav-pills\" id=\"v-pills-tab\" role=\"tablist\" aria-orientation=\"vertical\">\n" . 
		"								<a class=\"nav-link active\" id=\"v-pills-companydata-tab\" data-toggle=\"pill\" href=\"#v-pills-companydata\" role=\"tab\" aria-controls=\"v-pills-companydata\" aria-selected=\"true\">Firmendaten</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-bankdata-tab\" data-toggle=\"pill\" href=\"#v-pills-bankdata\" role=\"tab\" aria-controls=\"v-pills-bankdata\" aria-selected=\"false\">Bankdaten</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-systemdata-tab\" data-toggle=\"pill\" href=\"#v-pills-systemdata\" role=\"tab\" aria-controls=\"v-pills-systemdata\" aria-selected=\"false\">Systemdaten</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-vindecoder-tab\" data-toggle=\"pill\" href=\"#v-pills-vindecoder\" role=\"tab\" aria-controls=\"v-pills-vindecoder\" aria-selected=\"false\">VIN-Decoder</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-shipping-tab\" data-toggle=\"pill\" href=\"#v-pills-shipping\" role=\"tab\" aria-controls=\"v-pills-shipping\" aria-selected=\"false\">Versand</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-orders-tab\" data-toggle=\"pill\" href=\"#v-pills-orders\" role=\"tab\" aria-controls=\"v-pills-orders\" aria-selected=\"false\">Aufträge</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-users-tab\" data-toggle=\"pill\" href=\"#v-pills-users\" role=\"tab\" aria-controls=\"v-pills-users\" aria-selected=\"false\">Kunden</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-interesteds-tab\" data-toggle=\"pill\" href=\"#v-pills-interesteds\" role=\"tab\" aria-controls=\"v-pills-interesteds\" aria-selected=\"false\">Interessenten</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-shoppings-tab\" data-toggle=\"pill\" href=\"#v-pills-shoppings\" role=\"tab\" aria-controls=\"v-pills-shoppings\" aria-selected=\"false\">Einkäufe</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-retoures-tab\" data-toggle=\"pill\" href=\"#v-pills-retoures\" role=\"tab\" aria-controls=\"v-pills-retoures\" aria-selected=\"false\">Retouren</a>\n" . 
		"								<a class=\"nav-link\" id=\"v-pills-packing-tab\" data-toggle=\"pill\" href=\"#v-pills-packing\" role=\"tab\" aria-controls=\"v-pills-packing\" aria-selected=\"false\">Packtisch</a>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-9\">\n" . 
		"							<div class=\"tab-content\" id=\"v-pills-tabContent\">\n" . 
		"								<div class=\"tab-pane fade show active\" id=\"v-pills-companydata\" role=\"tabpanel\" aria-labelledby=\"v-pills-companydata-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-12\">\n" . 
		"											<input type=\"text\" id=\"company\" name=\"company\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $company : strip_tags($row_maindata["company"])) . "\" class=\"form-control" . $inp_company . "\" placeholder=\"Firma\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4 mt-1\">\n" . 
		"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"												<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : $maindata["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"												<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
		"													Herr\n" . 
		"												</label>\n" . 
		"											</div>\n" . 
		"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"												<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : $maindata["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"												<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
		"													Frau\n" . 
		"												</label>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $firstname : strip_tags($row_maindata["firstname"])) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $lastname : strip_tags($row_maindata["lastname"])) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Nachname\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-9\">\n" . 
		"											<input type=\"text\" id=\"street\" name=\"street\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $street : strip_tags($row_maindata["street"])) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-3\">\n" . 
		"											<input type=\"text\" id=\"streetno\" name=\"streetno\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $streetno : strip_tags($row_maindata["streetno"])) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"zipcode\" name=\"zipcode\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $zipcode : strip_tags($row_maindata["zipcode"])) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"city\" name=\"city\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $city : strip_tags($row_maindata["city"])) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">" . $countries_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"email\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $email : strip_tags($row_maindata["email"])) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $mobilnumber : strip_tags($row_maindata["mobilnumber"])) . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $phonenumber : strip_tags($row_maindata["phonenumber"])) . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-bankdata\" role=\"tabpanel\" aria-labelledby=\"v-pills-bankdata-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"bank_name\" class=\"col-sm-6 col-form-label\">Bankname <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihren Bankname ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"bank_name\" name=\"bank_name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $bank_name : strip_tags($row_maindata["bank_name"])) . "\" class=\"form-control" . $inp_bank_name . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"bank_iban\" class=\"col-sm-6 col-form-label\">IBAN <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihre IBAN-Nummer ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"bank_iban\" name=\"bank_iban\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $bank_iban : strip_tags($row_maindata["bank_iban"])) . "\" class=\"form-control" . $inp_bank_iban . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"bank_bic\" class=\"col-sm-6 col-form-label\">BIC <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ihre BIC-Nummer ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"bank_bic\" name=\"bank_bic\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $bank_bic : strip_tags($row_maindata["bank_bic"])) . "\" class=\"form-control" . $inp_bank_bic . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-systemdata\" role=\"tabpanel\" aria-labelledby=\"v-pills-systemdata-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"logo_url\" class=\"col-sm-6 col-form-label\">Logo URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Zielort für nach dem anklicken des Logos bestimmen. Eine Raute (#) schaltet bei einem klick darauf zum Vollbildmodus um.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"logo_url\" name=\"logo_url\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $logo_url : strip_tags($row_maindata["logo_url"])) . "\" class=\"form-control" . $inp_logo_url . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"supervisor_id\" class=\"col-sm-6 col-form-label\">Supervisor <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Mitarbeiter, der Supervisor-Berechtigung erhält, ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"supervisor_id\" name=\"supervisor_id\" class=\"custom-select\">" . $options_supervisor_id . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"logout_index\" class=\"col-sm-6 col-form-label text-right\">URL einfügen</label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select name=\"pages\" class=\"custom-select\" onchange=\"$('#logout_index').val(this.value)\">\n" . 

		$options_pages_logout_index . 

		"											</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"logout_index\" class=\"col-sm-6 col-form-label\">Abmelden Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Zielort für nach dem Anmelden bestimmen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"logout_index\" name=\"logout_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $logout_index : strip_tags($row_maindata["logout_index"])) . "\" class=\"form-control" . $inp_logout_index . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"logout_index\" class=\"col-sm-6 col-form-label text-right\">URL einfügen</label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select name=\"pages\" class=\"custom-select\" onchange=\"$('#user_index').val(this.value)\">\n" . 

		$options_pages_user_index . 

		"											</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"user_index\" class=\"col-sm-6 col-form-label\">Kunden Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Zielort für nach dem Kunden-Anmelden bestimmen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"user_index\" name=\"user_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $user_index : strip_tags($row_maindata["user_index"])) . "\" class=\"form-control" . $inp_user_index . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"input_file_accept\" class=\"col-sm-6 col-form-label\">Upload Dokumente, erlaubte Dateiendungen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die erlaubten Dateiendungen für den Dokumenteupload ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"input_file_accept\" name=\"input_file_accept\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $input_file_accept : strip_tags($row_maindata["input_file_accept"])) . "\" class=\"form-control" . $inp_input_file_accept . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"input_file_audio_accept\" class=\"col-sm-6 col-form-label\">Upload Audio, erlaubte Dateiendungen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die erlaubten Dateiendungen für den Audioupload ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"input_file_audio_accept\" name=\"input_file_audio_accept\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $input_file_audio_accept : strip_tags($row_maindata["input_file_audio_accept"])) . "\" class=\"form-control" . $inp_input_file_audio_accept . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"delete_temp_date\" class=\"col-sm-6 col-form-label\">Temporäre Dateien <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die temporären Dateien entfernen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<button type=\"submit\" name=\"delete_temp\" value=\"entfernen\" class=\"btn btn-danger\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
		"											Zuletzt entfernt am: <strong>" . date("d.m.Y", intval($row_maindata["delete_temp_date"])) . "</strong>&nbsp;&nbsp;&nbsp;\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"url_password\" class=\"col-sm-6 col-form-label\">URL Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das URL Kennwort ändern. Z.b. für " . $domain . "/bezahlt/" . $row_company['login_slug'] . "/" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $url_password : strip_tags($row_maindata["url_password"])) . "/{{ Vorgang.Stammdaten.ExterneAuftragsnummer }}\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"url_password\" name=\"url_password\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $url_password : strip_tags($row_maindata["url_password"])) . "\" class=\"form-control" . $inp_url_password . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"super_password\" class=\"col-sm-6 col-form-label\">Super Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das super Kennwort ändern. Dies wird z.b. für das entfernen, bei der Lagerplatzübersicht (Lager --&gt; System), von vorhandenen Geräten verwendet!\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"super_password\" name=\"super_password\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $super_password : strip_tags($row_maindata["super_password"])) . "\" class=\"form-control" . $inp_super_password . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"mwst\" class=\"col-sm-6 col-form-label\">MwSt. Satz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den MwSt. Satz in % ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<div class=\"input-group\">\n" . 
		"												<input type=\"number\" id=\"mwst\" name=\"mwst\" min=\"1\" max=\"100\" step=\"1\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['mwst']) : $row_maindata["mwst"]) . "\" class=\"form-control\" />\n" . 
		"												<div class=\"input-group-append\">\n" . 
		"													<span class=\"input-group-text\">%</span>\n" . 
		"												</div>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"counter\" class=\"col-sm-6 col-form-label\">Frontend, Counter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Startnummer des Frontend-Counters festlegen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<div class=\"input-group\">\n" . 
		"												<input type=\"number\" id=\"counter\" name=\"counter\" min=\"1\" step=\"1\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['counter']) : $row_maindata["counter"]) . "\" class=\"form-control\" />\n" . 
		"												<div class=\"input-group-append\">\n" . 
		"													<span class=\"input-group-text\">Stck.</span>\n" . 
		"												</div>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"customer_history_delay_time\" class=\"col-sm-6 col-form-label\">Telefonhistorie-Zeitunterbindung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Zeitunterbindung der Statusabfrage bei der Telefonhistorie festlegen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<div class=\"input-group\">\n" . 
		"												<input type=\"number\" id=\"customer_history_delay_time\" name=\"customer_history_delay_time\" min=\"0\" step=\"1\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['customer_history_delay_time']) : $row_maindata["customer_history_delay_time"]) . "\" class=\"form-control\" />\n" . 
		"												<div class=\"input-group-append\">\n" . 
		"													<span class=\"input-group-text\">Minuten</span>\n" . 
		"												</div>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_host\" class=\"col-sm-6 col-form-label\">SMTP-Server-URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die SMTP-Server-URL festlegen (Host).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"smtp_host\" name=\"smtp_host\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_host : strip_tags($row_maindata["smtp_host"])) . "\" class=\"form-control" . $inp_smtp_host . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_username\" class=\"col-sm-6 col-form-label\">SMTP-Benutzername <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den SMTP-Benutzername festlegen (Username).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"smtp_username\" name=\"smtp_username\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_username : strip_tags($row_maindata["smtp_username"])) . "\" class=\"form-control" . $inp_smtp_username . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_password\" class=\"col-sm-6 col-form-label\">SMTP-Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das SMTP-Kennwort festlegen (Password).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"smtp_password\" name=\"smtp_password\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_password : strip_tags($row_maindata["smtp_password"])) . "\" class=\"form-control" . $inp_smtp_password . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_secure\" class=\"col-sm-6 col-form-label\">SMTP-Verschlüsselung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die SMTP-Verschlüsselung festlegen (tls).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"smtp_secure\" name=\"smtp_secure\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_secure : strip_tags($row_maindata["smtp_secure"])) . "\" class=\"form-control" . $inp_smtp_secure . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_port\" class=\"col-sm-6 col-form-label\">SMTP-Port <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die SMTP-Port festlegen (587).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"number\" id=\"smtp_port\" name=\"smtp_port\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_port : intval($row_maindata["smtp_port"])) . "\" class=\"form-control" . $inp_smtp_port . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_charset\" class=\"col-sm-6 col-form-label\">SMTP-Zeichensatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die SMTP-Zeichensatz festlegen (UTF-8).\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"smtp_charset\" name=\"smtp_charset\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_charset : strip_tags($row_maindata["smtp_charset"])) . "\" class=\"form-control" . $inp_smtp_charset . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"smtp_debug\" class=\"col-sm-6 col-form-label\">SMTP-Debug <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den SMTP-Debug Modus festlegen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"												<input type=\"checkbox\" id=\"smtp_debug\" name=\"smtp_debug\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $smtp_debug : $row_maindata['smtp_debug']) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"												<label class=\"custom-control-label\" for=\"smtp_debug\">\n" . 
		"													aktivieren\n" . 
		"												</label>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
				
		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-vindecoder\" role=\"tabpanel\" aria-labelledby=\"v-pills-vindecoder-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"vindecoder_url\" class=\"col-sm-6 col-form-label\">URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Vindecoder-URL ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"vindecoder_url\" name=\"vindecoder_url\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $vindecoder_url : strip_tags($row_maindata["vindecoder_url"])) . "\" class=\"form-control" . $inp_vindecoder_url . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"vindecoder_api_key\" class=\"col-sm-6 col-form-label\">API KEY <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Vindecoder-API-KEY ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"vindecoder_api_key\" name=\"vindecoder_api_key\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $vindecoder_api_key : strip_tags($row_maindata["vindecoder_api_key"])) . "\" class=\"form-control" . $inp_vindecoder_api_key . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"vindecoder_secret\" class=\"col-sm-6 col-form-label\">SECRET <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Vindecoder-SECRET ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"vindecoder_secret\" name=\"vindecoder_secret\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $vindecoder_secret : strip_tags($row_maindata["vindecoder_secret"])) . "\" class=\"form-control" . $inp_vindecoder_secret . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-shipping\" role=\"tabpanel\" aria-labelledby=\"v-pills-shipping-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"ups_url\" class=\"col-sm-6 col-form-label\">UPS-URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die UPS-URL ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"ups_url\" name=\"ups_url\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $ups_url : strip_tags($row_maindata["ups_url"])) . "\" class=\"form-control" . $inp_ups_url . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"ups_username\" class=\"col-sm-6 col-form-label\">UPS-Benutzername <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den UPS-Benutzername ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"ups_username\" name=\"ups_username\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $ups_username : strip_tags($row_maindata["ups_username"])) . "\" class=\"form-control" . $inp_ups_username . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"ups_password\" class=\"col-sm-6 col-form-label\">UPS-Kennwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das UPS-Kennwort ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"ups_password\" name=\"ups_password\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $ups_password : strip_tags($row_maindata["ups_password"])) . "\" class=\"form-control" . $inp_ups_password . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"ups_customer_number\" class=\"col-sm-6 col-form-label\">UPS-Kundennummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die UPS-Kundennummer ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"ups_customer_number\" name=\"ups_customer_number\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $ups_customer_number : strip_tags($row_maindata["ups_customer_number"])) . "\" class=\"form-control" . $inp_ups_customer_number . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"ups_access_license_number\" class=\"col-sm-6 col-form-label\">UPS-Zugriff-Lizens-Nummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die UPS-Zugriff-Lizens-Nummer ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"ups_access_license_number\" name=\"ups_access_license_number\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $ups_access_license_number : strip_tags($row_maindata["ups_access_license_number"])) . "\" class=\"form-control" . $inp_ups_access_license_number . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"package\" class=\"col-sm-6 col-form-label\">Standard - Paket <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Standard - Paket ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"package\" name=\"package\" class=\"custom-select" . $inp_package . "\">" . $package_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"new_shipping_status\" class=\"col-sm-6 col-form-label\">Versendung beauftragt, Vorgang (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Versand (intern) verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"new_shipping_status\" name=\"new_shipping_status\" class=\"custom-select\">" . $new_shipping_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"pickup_status\" class=\"col-sm-6 col-form-label\">Abholen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einer neuen Abholung verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"pickup_status\" name=\"pickup_status\" class=\"custom-select\">" . $pickup_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"sleep_shipping_label\" class=\"col-sm-6 col-form-label\">Timeout zwischen Sendung und Label erstellung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen wieviel Zeit, zwischen Sendung und Label erstellung, vergehen soll. (Bei schwierigkeiten seitens UPS, stellen Sie ein höheren Wert ein.)\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<output for=\"sleep_shipping_label\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['sleep_shipping_label']) : $row_maindata['sleep_shipping_label']) . "</output>\n" . 
		"											<input type=\"range\" id=\"sleep_shipping_label\" name=\"sleep_shipping_label\" min=\"0\" max=\"500\" step=\"1\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['sleep_shipping_label']) : $row_maindata['sleep_shipping_label']) . "\" class=\"form-control\" orient=\"horizontal\" oninput=\"document.querySelector('output').value=this.value\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-orders\" role=\"tabpanel\" aria-labelledby=\"v-pills-orders-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"admin_id\" class=\"col-sm-6 col-form-label\">Neuer Auftrag, Mitarbeiter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Mitarbeiter, der bei einem neuen Auftrag verwendet werden soll, ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"admin_id\" name=\"admin_id\" class=\"custom-select\">" . $options_admin_id . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"storage_space_owner_id\" class=\"col-sm-6 col-form-label\">Neuer Auftrag, Lagerplatzzuweisung, Mitarbeiter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Mitarbeiter für die Lagerplatzzuweisung, der bei einem neuen Auftrag verwendet werden soll, ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"storage_space_owner_id\" name=\"storage_space_owner_id\" class=\"custom-select\">" . $options_storage_space_owner_id . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_status_intern\" class=\"col-sm-6 col-form-label\">Neuer Auftrag, Vorgang (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Auftrag (intern) verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_status_intern\" name=\"order_status_intern\" class=\"custom-select\">" . $statuses_intern_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_status\" class=\"col-sm-6 col-form-label\">Neuer Auftrag, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Auftrag verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_status\" name=\"order_status\" class=\"custom-select\">" . $statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"shipping_status\" class=\"col-sm-6 col-form-label\">Auftrag, Sendung beauftragt, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Versand verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"shipping_status\" name=\"shipping_status\" class=\"custom-select\">" . $shipping_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"shipping_cancel_status\" class=\"col-sm-6 col-form-label\">Auftrag, Sendung storniert, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei der stornierung einer Sendung verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"shipping_cancel_status\" name=\"shipping_cancel_status\" class=\"custom-select\">" . $shipping_cancel_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"email_status\" class=\"col-sm-6 col-form-label\">Auftrag, Neue Email, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einer neuen Email verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"email_status\" name=\"email_status\" class=\"custom-select\">" . $email_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_to_archive_status\" class=\"col-sm-6 col-form-label\">Auftrag nach Archiv verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Archiv verschieben eines Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_to_archive_status\" name=\"order_to_archive_status\" class=\"custom-select\">" . $order_to_archive_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"archive_to_order_status\" class=\"col-sm-6 col-form-label\">Archiv nach Aufträge verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Aufträge verschieben eines Archiv's verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"archive_to_order_status\" name=\"archive_to_order_status\" class=\"custom-select\">" . $archive_to_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_payed_status\" class=\"col-sm-6 col-form-label\">Auftrag bezahlt, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang, den Auftrag als bezahlt markiert, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_payed_status\" name=\"order_payed_status\" class=\"custom-select\">" . $order_payed_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_to_booking_status\" class=\"col-sm-6 col-form-label\">Auftrag nach Buchhaltung übertragen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Buchhaltung übertragen eines Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_to_booking_status\" name=\"order_to_booking_status\" class=\"custom-select\">" . $order_to_booking_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_ending_status\" class=\"col-sm-6 col-form-label\">Auftrag Abgeschlossen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem Abschluss des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_ending_status\" name=\"order_ending_status\" class=\"custom-select\">" . $order_ending_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_claim_status\" class=\"col-sm-6 col-form-label\">Reklamation eingegangenen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Reklamation eingegangenen des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_claim_status\" name=\"order_claim_status\" class=\"custom-select\">" . $order_claim_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_recall_status\" class=\"col-sm-6 col-form-label\">Rückruf vereinbart, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Rückruf vereinbart des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_recall_status\" name=\"order_recall_status\" class=\"custom-select\">" . $order_recall_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_in_checkout_status\" class=\"col-sm-6 col-form-label\">Auftrag in Prüffung, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag in Prüffung des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_in_checkout_status\" name=\"order_in_checkout_status\" class=\"custom-select\">" . $order_in_checkout_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_extra_evaluation_status\" class=\"col-sm-6 col-form-label\">Auftrag in gesonderter Auswertung, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag in gesonderter Auswertung des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_extra_evaluation_status\" name=\"order_extra_evaluation_status\" class=\"custom-select\">" . $order_extra_evaluation_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_inspection_process_status\" class=\"col-sm-6 col-form-label\">Auftrag im Prüfprozess, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag im Prüfprozess des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_inspection_process_status\" name=\"order_inspection_process_status\" class=\"custom-select\">" . $order_inspection_process_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_extra_verification_status\" class=\"col-sm-6 col-form-label\">Auftrag in gesonderter Überprüfung, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag in gesonderter Überprüfung des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_extra_verification_status\" name=\"order_extra_verification_status\" class=\"custom-select\">" . $order_extra_verification_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_extra_edit_status\" class=\"col-sm-6 col-form-label\">Auftrag in gesonderter Bearbeitung, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag in gesonderter Bearbeitung des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_extra_edit_status\" name=\"order_extra_edit_status\" class=\"custom-select\">" . $order_extra_edit_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_extra_checkout_status\" class=\"col-sm-6 col-form-label\">Auftrag in gesonderter Prüfung, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag in gesonderter Prüfung des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_extra_checkout_status\" name=\"order_extra_checkout_status\" class=\"custom-select\">" . $order_extra_checkout_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_new_device_status\" class=\"col-sm-6 col-form-label\">Auftrag, neues Gerät, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, neues Gerät, des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_new_device_status\" name=\"order_new_device_status\" class=\"custom-select\">" . $order_new_device_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_problem_status\" class=\"col-sm-6 col-form-label\">Auftrag, Problem melden, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Problem melden, des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_problem_status\" name=\"order_problem_status\" class=\"custom-select\">" . $order_problem_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_packing_user_status\" class=\"col-sm-6 col-form-label\">Auftrag, Versandauftrag Kunde, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Versandauftrag Kunde, des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_packing_user_status\" name=\"order_packing_user_status\" class=\"custom-select\">" . $order_packing_user_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_packing_technic_status\" class=\"col-sm-6 col-form-label\">Auftrag, Versandauftrag Techniker, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Versandauftrag Techniker, des Auftrags verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_packing_technic_status\" name=\"order_packing_technic_status\" class=\"custom-select\">" . $order_packing_technic_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_relocate_status\" class=\"col-sm-6 col-form-label\">Auftrag, Umlagern durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Umlagern durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_relocate_status\" name=\"order_relocate_status\" class=\"custom-select\">" . $order_relocate_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_labeling_status\" class=\"col-sm-6 col-form-label\">Auftrag, Beschriften durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Beschriften durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_labeling_status\" name=\"order_labeling_status\" class=\"custom-select\">" . $order_labeling_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_photo_status\" class=\"col-sm-6 col-form-label\">Auftrag, Fotografieren durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Fotografieren durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_photo_status\" name=\"order_photo_status\" class=\"custom-select\">" . $order_photo_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_extended_items\" class=\"col-sm-6 col-form-label\">Auftrag, Zusatzartikel <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Zusatzartikel festlegen, die bei den Versandaufträgen-Kunde verwendet werden. Geben Sie untereinander die Artikel an (Bezeichnung|Name|Checked z.b. gummi|Gummibärchen|0)\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<textarea id=\"order_extended_items\" name=\"order_extended_items\" class=\"form-control\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $order_extended_items : strip_tags($row_maindata["order_extended_items"])) . "</textarea>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-users\" role=\"tabpanel\" aria-labelledby=\"v-pills-users-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"user_status_intern\" class=\"col-sm-6 col-form-label\">Neuen Kunden, Vorgang (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Kunden (intern) verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"user_status_intern\" name=\"user_status_intern\" class=\"custom-select\">" . $user_statuses_intern_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"user_status\" class=\"col-sm-6 col-form-label\">Neuen Kunden, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Kunden verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"user_status\" name=\"user_status\" class=\"custom-select\">" . $user_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"user_email_status\" class=\"col-sm-6 col-form-label\">Kunden, Neue Email, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einer neuen Kunden-Email verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"user_email_status\" name=\"user_email_status\" class=\"custom-select\">" . $user_email_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-interesteds\" role=\"tabpanel\" aria-labelledby=\"v-pills-interesteds-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_status_intern\" class=\"col-sm-6 col-form-label\">Neuen Interessenten, Vorgang (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Interessenten (intern) verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_status_intern\" name=\"interested_status_intern\" class=\"custom-select\">" . $interested_statuses_intern_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_status_intern_orderform_per_mail\" class=\"col-sm-6 col-form-label\">Neuen Interessenten, Vorgang (intern, Auftragsformular per Email) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Interessenten (intern, Auftragsformular per Email) verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_status_intern_orderform_per_mail\" name=\"interested_status_intern_orderform_per_mail\" class=\"custom-select\">" . $interested_status_intern_orderform_per_mail_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"user_status\" class=\"col-sm-6 col-form-label\">Neuen Interessenten, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Interessenten verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_status\" name=\"interested_status\" class=\"custom-select\">" . $interested_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_email_status\" class=\"col-sm-6 col-form-label\">Interessenten, Neue Email, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einer neuen Interessenten-Email verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_email_status\" name=\"interested_email_status\" class=\"custom-select\">" . $interested_email_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_to_archive_status\" class=\"col-sm-6 col-form-label\">Interessent nach Archiv verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Archiv verschieben eines Interessent's verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_to_archive_status\" name=\"interested_to_archive_status\" class=\"custom-select\">" . $interested_to_archive_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"archive_to_interested_status\" class=\"col-sm-6 col-form-label\">Archiv nach Interessenten verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Interessenten verschieben eines Archiv's verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"archive_to_interested_status\" name=\"archive_to_interested_status\" class=\"custom-select\">" . $archive_to_interested_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_to_interested_status\" class=\"col-sm-6 col-form-label\">Auftrag nach Interessenten verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Interessenten verschieben eines Auftrag's verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_to_interested_status\" name=\"order_to_interested_status\" class=\"custom-select\">" . $order_to_interested_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"order_archive_to_interested_status\" class=\"col-sm-6 col-form-label\">Auftrag-Archiv nach Interessenten verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Interessenten verschieben eines Auftrag-Archiv's verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"order_archive_to_interested_status\" name=\"order_archive_to_interested_status\" class=\"custom-select\">" . $order_archive_to_interested_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_to_order_status\" class=\"col-sm-6 col-form-label\">Interessent nach Aufträge verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei dem nach Aufträge verschieben eines Interessenten verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_to_order_status\" name=\"interested_to_order_status\" class=\"custom-select\">" . $interested_to_order_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_success_status\" class=\"col-sm-6 col-form-label\">Interessent Erfolgreich, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Interessent erfolgreich verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_success_status\" name=\"interested_success_status\" class=\"custom-select\">" . $interested_success_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_new_device_status\" class=\"col-sm-6 col-form-label\">Interessent, neues Gerät, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Interessent, neues Gerät, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_new_device_status\" name=\"interested_new_device_status\" class=\"custom-select\">" . $interested_new_device_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_problem_status\" class=\"col-sm-6 col-form-label\">Interessent, Problem melden, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Interessent, Problem melden, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_problem_status\" name=\"interested_problem_status\" class=\"custom-select\">" . $interested_problem_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_packing_user_status\" class=\"col-sm-6 col-form-label\">Interessent, Versandauftrag Kunde, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Interessent, Versandauftrag Kunde, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_packing_user_status\" name=\"interested_packing_user_status\" class=\"custom-select\">" . $interested_packing_user_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_packing_technic_status\" class=\"col-sm-6 col-form-label\">Interessent, Versandauftrag Techniker, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Interessent, Versandauftrag Techniker, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_packing_technic_status\" name=\"interested_packing_technic_status\" class=\"custom-select\">" . $interested_packing_technic_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_relocate_status\" class=\"col-sm-6 col-form-label\">Interessent, Umlagern durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Umlagern durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_relocate_status\" name=\"interested_relocate_status\" class=\"custom-select\">" . $interested_relocate_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_labeling_status\" class=\"col-sm-6 col-form-label\">Interessent, Beschriften durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Beschriften durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_labeling_status\" name=\"interested_labeling_status\" class=\"custom-select\">" . $interested_labeling_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"interested_photo_status\" class=\"col-sm-6 col-form-label\">Interessent, Fotografieren durchführen, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei Auftrag, Fotografieren durchführen, verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"interested_photo_status\" name=\"interested_photo_status\" class=\"custom-select\">" . $interested_photo_statuses_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-shoppings\" role=\"tabpanel\" aria-labelledby=\"v-pills-shoppings-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"shopping_status\" class=\"col-sm-6 col-form-label\">Neuer Einkauf, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Einkauf verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"shopping_status\" name=\"shopping_status\" class=\"custom-select\">" . $shopping_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"shopping_to_archive_status\" class=\"col-sm-6 col-form-label\">Einkauf nach Archiv verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Einkauf nach Archiv verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"shopping_to_archive_status\" name=\"shopping_to_archive_status\" class=\"custom-select\">" . $shopping_to_archive_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"archive_to_shoppings_status\" class=\"col-sm-6 col-form-label\">Archiv nach Einkäufe verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Archiv nach Einkäufe verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"archive_to_shoppings_status\" name=\"archive_to_shoppings_status\" class=\"custom-select\">" . $archive_to_shoppings_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-retoures\" role=\"tabpanel\" aria-labelledby=\"v-pills-retoures-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"retoure_status\" class=\"col-sm-6 col-form-label\">Neue Retoure, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einer neuen Retoure verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"retoure_status\" name=\"retoure_status\" class=\"custom-select\">" . $retoure_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"shopping_to_retoures_status\" class=\"col-sm-6 col-form-label\">Einkauf nach Retouren verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Einkauf nach Retouren verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"shopping_to_retoures_status\" name=\"shopping_to_retoures_status\" class=\"custom-select\">" . $shopping_to_retoures_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"retoure_to_shoppings_status\" class=\"col-sm-6 col-form-label\">Retoure nach Einkäufe verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Retoure nach Einkäufe verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"retoure_to_shoppings_status\" name=\"retoure_to_shoppings_status\" class=\"custom-select\">" . $retoure_to_shoppings_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"								<div class=\"tab-pane fade\" id=\"v-pills-packing\" role=\"tabpanel\" aria-labelledby=\"v-pills-packing-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"packing_status\" class=\"col-sm-6 col-form-label\">Neuer Packtisch, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang bei einem neuen Packtisch verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"packing_status\" name=\"packing_status\" class=\"custom-select\">" . $packing_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"packing_to_archive_status\" class=\"col-sm-6 col-form-label\">Packtisch nach Archiv verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Einkauf nach Archiv verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"packing_to_archive_status\" name=\"packing_to_archive_status\" class=\"custom-select\">" . $packing_to_archive_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"archive_to_packings_status\" class=\"col-sm-6 col-form-label\">Archiv nach Packtische verschieben, Vorgang <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie bestimmen welcher Vorgang beim Archiv nach Einkäufe verschieben verwendet wird.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select id=\"archive_to_packings_status\" name=\"archive_to_packings_status\" class=\"custom-select\">" . $archive_to_packings_status_options . "</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"row px-0 border-top mb-3\">\n" . 
		"						<label for=\"stylebackend\" class=\"col-sm-12 col-form-label\">Backend-Style <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Style im Backend mit einbeziehen\">?</span></label>\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<textarea id=\"stylebackend\" name=\"style_backend\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_style_backend . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($style_backend) : htmlentities($row_maindata["style_backend"])) . "</textarea>\n" . 
		"						</div>\n" . 
		"						<label for=\"scriptbackend\" class=\"col-sm-12 col-form-label\">Backend-Script <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Javascript im Backend mit einbeziehen\">?</span></label>\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<textarea id=\"scriptbackend\" name=\"script_backend\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_script_backend . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($script_backend) : htmlentities($row_maindata["script_backend"])) . "</textarea>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"								<input type=\"checkbox\" id=\"script_backend_activate\" name=\"script_backend_activate\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $script_backend_activate : $row_maindata['script_backend_activate']) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"								<label class=\"custom-control-label\" for=\"script_backend_activate\">\n" . 
		"									Backend-Script aktivieren\n" . 
		"								</label>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"row px-0 card-footer\">\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-sm-6\" align=\"right\">\n" . 
		"							&nbsp;\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</form>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";

?>