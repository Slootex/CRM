<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "pickup_pickup";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

require_once('includes/class_dbbmailer.php');

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$show_autocomplete_script = 1;

$countryToId = "";

$emsg = "";

$inp_from_address = "";

$inp_pickup_pickupdate = "";

$inp_pickup_readytime_hours = "";
$inp_pickup_readytime_minutes = "";
$inp_pickup_closetime_hours = "";
$inp_pickup_closetime_minutes = "";
$inp_pickup_shortcut = "";
$inp_pickup_companyname = "";
$inp_pickup_gender = "";
$inp_pickup_firstname = "";
$inp_pickup_lastname = "";
$inp_pickup_street = "";
$inp_pickup_streetno = "";
$inp_pickup_zipcode = "";
$inp_pickup_city = "";
$inp_pickup_country = "";
$inp_pickup_email = "";
$inp_pickup_phone = "";
$inp_pickup_room = "";
$inp_pickup_floor = "";
$inp_pickup_pickuppoint = "";
$inp_pickup_weight = "";
$inp_pickup_servicecode = "";
$inp_pickup_paymentmethod = "";
$inp_pickup_quantity = "";
$inp_pickup_referencenumber = "";
$inp_pickup_description = "";

$from_address = intval(isset($_POST['from_address']) ? $_POST['from_address'] : 1);

$pickup_pickupdate = 0;
$pickup_readytime_hours = "10";
$pickup_readytime_minutes = "00";
$pickup_closetime_hours = "18";
$pickup_closetime_minutes = "00";
$pickup_shortcut = "";
$pickup_companyname = "";
$pickup_gender = 0;
$pickup_firstname = "";
$pickup_lastname = "";
$pickup_street = "";
$pickup_streetno = "";
$pickup_zipcode = "";
$pickup_city = "";
$pickup_country = 1;
$pickup_email = "";
$pickup_phone = "";
$pickup_room = "R01";
$pickup_floor = "1";
$pickup_pickuppoint = "";
$pickup_weight = 5.0;
$pickup_servicecode = "011";
$pickup_paymentmethod = "00";
$pickup_quantity = "1";
$pickup_referencenumber = "";
$pickup_description = "";

$html_new_pickup_result = "";

$time = time();

if(isset($_POST['update']) && $_POST['update'] == "aktualisieren"){

	if(strlen($_POST['from_address']) < 1 || strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['pickup_pickupdate']) < 10 || strlen($_POST['pickup_pickupdate']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte das Abholdatum auswählen.</small><br />\n";
		$inp_pickup_pickupdate = " is-invalid";
	} else {
		$pickup_pickupdate = strtotime($_POST['pickup_pickupdate']);
	}

	if(strlen($_POST['pickup_readytime_hours']) < 2 || strlen($_POST['pickup_readytime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Stunden auswählen.</small><br />\n";
		$inp_pickup_readytime_hours = " is-invalid";
	} else {
		$pickup_readytime_hours = strip_tags($_POST['pickup_readytime_hours']);
	}

	if(strlen($_POST['pickup_readytime_minutes']) < 2 || strlen($_POST['pickup_readytime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Minuten auswählen.</small><br />\n";
		$inp_pickup_readytime_minutes = " is-invalid";
	} else {
		$pickup_readytime_minutes = strip_tags($_POST['pickup_readytime_minutes']);
	}

	if(strlen($_POST['pickup_closetime_hours']) < 2 || strlen($_POST['pickup_closetime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Stunden auswählen.</small><br />\n";
		$inp_pickup_closetime_hours = " is-invalid";
	} else {
		$pickup_closetime_hours = strip_tags($_POST['pickup_closetime_hours']);
	}

	if(strlen($_POST['pickup_closetime_minutes']) < 2 || strlen($_POST['pickup_closetime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Minuten auswählen.</small><br />\n";
		$inp_pickup_closetime_minutes = " is-invalid";
	} else {
		$pickup_closetime_minutes = strip_tags($_POST['pickup_closetime_minutes']);
	}

	if($emsg == ""){

	}

}

if(isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren"){

	if(strlen($_POST['from_address']) < 1 || strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['pickup_pickupdate']) < 10 || strlen($_POST['pickup_pickupdate']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte das Abholdatum auswählen.</small><br />\n";
		$inp_pickup_pickupdate = " is-invalid";
	} else {
		$pickup_pickupdate = strtotime($_POST['pickup_pickupdate']);
	}

	if(strlen($_POST['pickup_readytime_hours']) < 2 || strlen($_POST['pickup_readytime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Stunden auswählen.</small><br />\n";
		$inp_pickup_readytime_hours = " is-invalid";
	} else {
		$pickup_readytime_hours = strip_tags($_POST['pickup_readytime_hours']);
	}

	if(strlen($_POST['pickup_readytime_minutes']) < 2 || strlen($_POST['pickup_readytime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Minuten auswählen.</small><br />\n";
		$inp_pickup_readytime_minutes = " is-invalid";
	} else {
		$pickup_readytime_minutes = strip_tags($_POST['pickup_readytime_minutes']);
	}

	if(strlen($_POST['pickup_closetime_hours']) < 2 || strlen($_POST['pickup_closetime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Stunden auswählen.</small><br />\n";
		$inp_pickup_closetime_hours = " is-invalid";
	} else {
		$pickup_closetime_hours = strip_tags($_POST['pickup_closetime_hours']);
	}

	if(strlen($_POST['pickup_closetime_minutes']) < 2 || strlen($_POST['pickup_closetime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Minuten auswählen.</small><br />\n";
		$inp_pickup_closetime_minutes = " is-invalid";
	} else {
		$pickup_closetime_minutes = strip_tags($_POST['pickup_closetime_minutes']);
	}

	if(strlen($_POST['pickup_room']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Raum an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_room = " is-invalid";
	} else {
		$pickup_room = strip_tags($_POST['pickup_room']);
	}

	if(strlen($_POST['pickup_floor']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Stockwerk an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_floor = " is-invalid";
	} else {
		$pickup_floor = strip_tags($_POST['pickup_floor']);
	}

	if(strlen($_POST['pickup_pickuppoint']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Abholort an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_pickuppoint = " is-invalid";
	} else {
		$pickup_pickuppoint = strip_tags($_POST['pickup_pickuppoint']);
	}

	if(strlen($_POST['pickup_weight']) < 1 || strlen($_POST['pickup_weight']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Gewicht an. (max. 13 Zeichen)</small><br />\n";
		$inp_pickup_weight = " is-invalid";
	} else {
		$pickup_weight = floatval(str_replace(",", ".", $_POST['pickup_weight']));
	}

	if(strlen($_POST['pickup_quantity']) < 1 || strlen($_POST['pickup_quantity']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anzahl an Gesamtpakete aus.</small><br />\n";
		$inp_pickup_quantity = " is-invalid";
	} else {
		$pickup_quantity = strip_tags($_POST['pickup_quantity']);
	}

	if(strlen($_POST['pickup_paymentmethod']) < 2 || strlen($_POST['pickup_paymentmethod']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlart aus.</small><br />\n";
		$inp_pickup_paymentmethod = " is-invalid";
	} else {
		$pickup_paymentmethod = strip_tags($_POST['pickup_paymentmethod']);
	}

	if(strlen($_POST['pickup_companyname']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Firmenname ein. (max. 128 Zeichen)</small><br />\n";
		$inp_pickup_companyname = " is-invalid";
	} else {
		$pickup_companyname = strip_tags($_POST['pickup_companyname']);
	}

	if(strlen($_POST['pickup_shortcut']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Kürzel ein bzw. wählen Sie eine Abholadresse aus. (max. 128 Zeichen)</small><br />\n";
		$inp_pickup_shortcut = " is-invalid";
	} else {
		$pickup_shortcut = strip_tags($_POST['pickup_shortcut']);
	}

	if(strlen($_POST['pickup_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Anrede aus.</small><br />\n";
		$inp_pickup_gender = " is-invalid";
	} else {
		$pickup_gender = strip_tags($_POST['pickup_gender']);
	}

	if(strlen($_POST['pickup_firstname']) < 1 || strlen($_POST['pickup_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_firstname = " is-invalid";
	} else {
		$pickup_firstname = strip_tags($_POST['pickup_firstname']);
	}

	if(strlen($_POST['pickup_lastname']) < 1 || strlen($_POST['pickup_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_lastname = " is-invalid";
	} else {
		$pickup_lastname = strip_tags($_POST['pickup_lastname']);
	}

	if(strlen($_POST['pickup_street']) < 1 || strlen($_POST['pickup_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Straße ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_street = " is-invalid";
	} else {
		$pickup_street = strip_tags($_POST['pickup_street']);
	}

	if(strlen($_POST['pickup_streetno']) < 1 || strlen($_POST['pickup_streetno']) > 6){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Hausnummer ein. (max. 6 Zeichen)</small><br />\n";
		$inp_pickup_streetno = " is-invalid";
	} else {
		$pickup_streetno = strip_tags($_POST['pickup_streetno']);
	}

	if(strlen($_POST['pickup_zipcode']) < 4 || strlen($_POST['pickup_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_pickup_zipcode = " is-invalid";
	} else {
		$pickup_zipcode = strip_tags($_POST['pickup_zipcode']);
	}

	if(strlen($_POST['pickup_city']) < 1 || strlen($_POST['pickup_city']) > 40){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Ort ein. (max. 40 Zeichen)</small><br />\n";
		$inp_pickup_city = " is-invalid";
	} else {
		$pickup_city = strip_tags($_POST['pickup_city']);
	}

	if(strlen($_POST['pickup_country']) < 1 || strlen($_POST['pickup_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie das Land aus. (max. 11 Zeichen)</small><br />\n";
		$inp_pickup_country = " is-invalid";
	} else {
		$pickup_country = intval($_POST['pickup_country']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['pickup_email']) && $_POST['pickup_email'] != ""){
		$pickup_email = strip_tags($_POST['pickup_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine E-Mail-Adresse ein.</small><br />\n";
		$inp_pickup_email = " is-invalid";
	}

	if(strlen($_POST['pickup_phone']) < 1 || strlen($_POST['pickup_phone']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_pickup_phone = " is-invalid";
	} else {
		$pickup_phone = preg_replace("/[^0-9]/", "", strip_tags($_POST['pickup_phone']));
	}

	if($emsg == ""){

	}

}

if(isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen"){

	if(strlen($_POST['pickup_referencenumber']) < 1 || strlen($_POST['pickup_referencenumber']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Referenznummer ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_referencenumber = " is-invalid";
	} else {
		$pickup_referencenumber = strip_tags($_POST['pickup_referencenumber']);
	}

	if(strlen($_POST['pickup_description']) < 1 || strlen($_POST['pickup_description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_description = " is-invalid";
	} else {
		$pickup_description = strip_tags($_POST['pickup_description']);
	}

	if(strlen($_POST['pickup_pickupdate']) < 10 || strlen($_POST['pickup_pickupdate']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte das Abholdatum auswählen.</small><br />\n";
		$inp_pickup_pickupdate = " is-invalid";
	} else {
		$pickup_pickupdate = strtotime($_POST['pickup_pickupdate']);
	}

	if(strlen($_POST['pickup_readytime_hours']) < 2 || strlen($_POST['pickup_readytime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Stunden auswählen.</small><br />\n";
		$inp_pickup_readytime_hours = " is-invalid";
	} else {
		$pickup_readytime_hours = strip_tags($_POST['pickup_readytime_hours']);
	}

	if(strlen($_POST['pickup_readytime_minutes']) < 2 || strlen($_POST['pickup_readytime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Minuten auswählen.</small><br />\n";
		$inp_pickup_readytime_minutes = " is-invalid";
	} else {
		$pickup_readytime_minutes = strip_tags($_POST['pickup_readytime_minutes']);
	}

	if(strlen($_POST['pickup_closetime_hours']) < 2 || strlen($_POST['pickup_closetime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Stunden auswählen.</small><br />\n";
		$inp_pickup_closetime_hours = " is-invalid";
	} else {
		$pickup_closetime_hours = strip_tags($_POST['pickup_closetime_hours']);
	}

	if(strlen($_POST['pickup_closetime_minutes']) < 2 || strlen($_POST['pickup_closetime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Minuten auswählen.</small><br />\n";
		$inp_pickup_closetime_minutes = " is-invalid";
	} else {
		$pickup_closetime_minutes = strip_tags($_POST['pickup_closetime_minutes']);
	}

	if(strlen($_POST['pickup_shortcut']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Kürzel ein bzw. wählen Sie eine Abholadresse aus. (max. 128 Zeichen)</small><br />\n";
		$inp_pickup_shortcut = " is-invalid";
	} else {
		$pickup_shortcut = strip_tags($_POST['pickup_shortcut']);
	}

	if(strlen($_POST['pickup_companyname']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Firmenname ein. (max. 128 Zeichen)</small><br />\n";
		$inp_pickup_companyname = " is-invalid";
	} else {
		$pickup_companyname = strip_tags($_POST['pickup_companyname']);
	}

	if(strlen($_POST['pickup_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Anrede aus.</small><br />\n";
		$inp_pickup_gender = " is-invalid";
	} else {
		$pickup_gender = strip_tags($_POST['pickup_gender']);
	}

	if(strlen($_POST['pickup_firstname']) < 1 || strlen($_POST['pickup_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_firstname = " is-invalid";
	} else {
		$pickup_firstname = strip_tags($_POST['pickup_firstname']);
	}

	if(strlen($_POST['pickup_lastname']) < 1 || strlen($_POST['pickup_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_lastname = " is-invalid";
	} else {
		$pickup_lastname = strip_tags($_POST['pickup_lastname']);
	}

	if(strlen($_POST['pickup_street']) < 1 || strlen($_POST['pickup_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Straße ein. (max. 256 Zeichen)</small><br />\n";
		$inp_pickup_street = " is-invalid";
	} else {
		$pickup_street = strip_tags($_POST['pickup_street']);
	}

	if(strlen($_POST['pickup_streetno']) < 1 || strlen($_POST['pickup_streetno']) > 6){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Hausnummer ein. (max. 6 Zeichen)</small><br />\n";
		$inp_pickup_streetno = " is-invalid";
	} else {
		$pickup_streetno = strip_tags($_POST['pickup_streetno']);
	}

	if(strlen($_POST['pickup_zipcode']) < 4 || strlen($_POST['pickup_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_pickup_zipcode = " is-invalid";
	} else {
		$pickup_zipcode = strip_tags($_POST['pickup_zipcode']);
	}

	if(strlen($_POST['pickup_city']) < 1 || strlen($_POST['pickup_city']) > 40){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Ort ein. (max. 40 Zeichen)</small><br />\n";
		$inp_pickup_city = " is-invalid";
	} else {
		$pickup_city = strip_tags($_POST['pickup_city']);
	}

	if(strlen($_POST['pickup_country']) < 1 || strlen($_POST['pickup_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie das Land aus. (max. 11 Zeichen)</small><br />\n";
		$inp_pickup_country = " is-invalid";
	} else {
		$pickup_country = intval($_POST['pickup_country']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['pickup_email']) && $_POST['pickup_email'] != ""){
		$pickup_email = strip_tags($_POST['pickup_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine E-Mail-Adresse ein.</small><br />\n";
		$inp_pickup_email = " is-invalid";
	}

	if(strlen($_POST['pickup_phone']) < 1 || strlen($_POST['pickup_phone']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_pickup_phone = " is-invalid";
	} else {
		$pickup_phone = preg_replace("/[^0-9]/", "", strip_tags($_POST['pickup_phone']));
	}

	if(strlen($_POST['pickup_room']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Raum an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_room = " is-invalid";
	} else {
		$pickup_room = strip_tags($_POST['pickup_room']);
	}

	if(strlen($_POST['pickup_floor']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Stockwerk an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_floor = " is-invalid";
	} else {
		$pickup_floor = strip_tags($_POST['pickup_floor']);
	}

	if(strlen($_POST['pickup_pickuppoint']) > 30){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Abholort an. (max. 30 Zeichen)</small><br />\n";
		$inp_pickup_pickuppoint = " is-invalid";
	} else {
		$pickup_pickuppoint = strip_tags($_POST['pickup_pickuppoint']);
	}

	if(strlen($_POST['pickup_weight']) < 1 || strlen($_POST['pickup_weight']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Gewicht an. (max. 13 Zeichen)</small><br />\n";
		$inp_pickup_weight = " is-invalid";
	} else {
		$pickup_weight = floatval(str_replace(",", ".", $_POST['pickup_weight']));
	}

	if(strlen($_POST['pickup_servicecode']) < 3 || strlen($_POST['pickup_servicecode']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Service aus.</small><br />\n";
		$inp_pickup_servicecode = " is-invalid";
	} else {
		$pickup_servicecode = strip_tags($_POST['pickup_servicecode']);
	}

	if(strlen($_POST['pickup_paymentmethod']) < 2 || strlen($_POST['pickup_paymentmethod']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlart aus.</small><br />\n";
		$inp_pickup_paymentmethod = " is-invalid";
	} else {
		$pickup_paymentmethod = strip_tags($_POST['pickup_paymentmethod']);
	}

	if(strlen($_POST['pickup_quantity']) < 1 || strlen($_POST['pickup_quantity']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anzahl an Gesamtpakete aus.</small><br />\n";
		$inp_pickup_quantity = " is-invalid";
	} else {
		$pickup_quantity = strip_tags($_POST['pickup_quantity']);
	}

	if($emsg == ""){

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $pickup_country . "'"), MYSQLI_ASSOC);

		$data = array(
			'PickupCreationRequest' => array(
				'RatePickupIndicator' => 'N', 					// Y = Bewertung dieser Abholung, N = Keine Bewertung dieser Abholung (Standard)
				'Shipper' => array(
					'Account' => array(
						'AccountNumber' => $maindata['ups_customer_number'], 
						'AccountCountryCode' => 'DE'
					)
				), 
				'PickupDateInfo' => array(
					'CloseTime' => $pickup_closetime_hours . $pickup_closetime_minutes, 
					'ReadyTime' => $pickup_readytime_hours . $pickup_readytime_minutes, 
					'PickupDate' => date("Ymd", $pickup_pickupdate)
				), 
				'PickupAddress' => array(
					'CompanyName' => $pickup_companyname, 
					'ContactName' => $pickup_firstname . ' ' . $pickup_lastname, 
					'AddressLine' => $pickup_street . ' ' . $pickup_streetno, 
					'Room' => $pickup_room, 
					'Floor' => $pickup_floor, 
					'City' => $pickup_city, 
					'StateProvince' => '', 
					'Urbanization' => '', 
					'PostalCode' => $pickup_zipcode, 
					'CountryCode' => $row_country['code'], 
					'ResidentialIndicator' => 'Y', 
					'PickupPoint' => $pickup_pickuppoint, 
					'Phone' => array(
						'Number' => $pickup_phone/*, 
						'Extension' => ''*/
					)
				), 
				'AlternateAddressIndicator' => 'Y', 			// Y = Alternative Adresse N = Ursprüngliche Abholadresse (Standard)
				'PickupPiece' => array(
					0 => array(
						'ServiceCode' => $pickup_servicecode, 
						'Quantity' => $pickup_quantity, 
						'DestinationCountryCode' => 'DE', 
						'ContainerCode' => '01' 				// 01 = PACKAGE, 02 = UPS LETTER, 03 = PALLET, Note: 03 is used for only WWEF services
					)
				), 
				'TotalWeight' => array(
					'Weight' => '' . $pickup_weight, 
					'UnitOfMeasurement' => 'KGS'
				), 
				'OverweightIndicator' => 'N', 					// Y = Übergewicht, N = Nicht Übergewicht (Standard)
				'PaymentMethod' => $pickup_paymentmethod, 						// 00 = Keine Zahlung erforderlich, 01 = Zahlung per Versenderkonto, 03 = Mit Kreditkarte bezahlen, 04 = Bezahlen mit 1Z Tracking-Nummer, 05 = Per Scheck oder Zahlungsanweisung bezahlen, 06 = Bargeld (gilt nur für diese Länder oder Gebiete - BE, FR, DE, IT, MX, NL, PL, ES, GB, CZ, HU, FI, NO), 07 = PayPal bezahlen
				'SpecialInstruction' => $pickup_description,  
				'ReferenceNumber' => $pickup_referencenumber, 
				'Notification' => array(
					'ConfirmationEmailAddress' => $pickup_email, 
					'UndeliverableEmailAddress' => $pickup_email
				), 
				'CSR' => array(
					'ProfileId' => $maindata['ups_customer_number'], 
					'ProfileCountryCode' => 'DE'
				)
			)
		);

		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

		$ch = curl_init($maindata['ups_url'] . '/ship/v1707/pickups');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
				'Password: ' . $maindata['ups_password'],
				'transactionSrc: ' . $domain,
				'transId: ' . $time,
				'Content-Type: application/json',
				'Username: ' . $maindata['ups_username'],
				'Accept: application/json',
				'Content-Length: ' . strlen($data_string)
			)
		);

		$result = curl_exec($ch);

		curl_close($ch);

		$response = json_decode($result);

		if(isset($response->PickupCreationResponse->Response->TransactionReference->TransactionIdentifier)){

			$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . intval($_SESSION["admin"]["id"]) . "'"), MYSQLI_ASSOC);
			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . $maindata['pickup_status'] . "'"), MYSQLI_ASSOC);
			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . intval($row_status['email_template']) . "'"), MYSQLI_ASSOC);

			$row_template['body'] .= $row_admin['email_signature'];

			$fields = array('subject', 'body', 'admin_mail_subject');

			for($j = 0;$j < count($fields);$j++){

				$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status['name'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[pickupdate]", date("d.m.Y (H:i)", $pickup_pickupdate), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[readytime]", $pickup_readytime_hours . ":" . $pickup_readytime_minutes . " - " . $pickup_closetime_hours . ":" . $pickup_closetime_minutes . " Uhr", $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[room]", $pickup_room, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[floor]", $pickup_floor, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[weight]", number_format($pickup_weight, 2, ',', ''), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[quantity]", $pickup_quantity, $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[companyname]", $pickup_companyname, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($pickup_gender == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($pickup_gender == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", $pickup_firstname, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", $pickup_lastname, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $pickup_street, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $pickup_streetno, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $pickup_zipcode, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $pickup_city, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[pickuppoint]", $pickup_pickuppoint, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $pickup_phonenumber, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $pickup_email . "\">" . $pickup_email . "</a>\n", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[description]", $pickup_description, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[referencenumber]", $pickup_referencenumber, $row_template[$fields[$j]]);

			}

			mysqli_query($conn, "	INSERT 	`pickup_pickups` 
									SET 	`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`pickup_pickups`.`admin_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
											`pickup_pickups`.`referencenumber`='" . mysqli_real_escape_string($conn, $pickup_referencenumber) . "', 
											`pickup_pickups`.`description`='" . mysqli_real_escape_string($conn, $pickup_description) . "', 
											`pickup_pickups`.`pickupdate`='" . mysqli_real_escape_string($conn, $pickup_pickupdate) . "', 
											`pickup_pickups`.`readytime_hours`='" . mysqli_real_escape_string($conn, $pickup_readytime_hours) . "', 
											`pickup_pickups`.`readytime_minutes`='" . mysqli_real_escape_string($conn, $pickup_readytime_minutes) . "', 
											`pickup_pickups`.`closetime_hours`='" . mysqli_real_escape_string($conn, $pickup_closetime_hours) . "', 
											`pickup_pickups`.`closetime_minutes`='" . mysqli_real_escape_string($conn, $pickup_closetime_minutes) . "', 
											`pickup_pickups`.`shortcut`='" . mysqli_real_escape_string($conn, $pickup_shortcut) . "', 
											`pickup_pickups`.`companyname`='" . mysqli_real_escape_string($conn, $pickup_companyname) . "', 
											`pickup_pickups`.`contactname`='" . mysqli_real_escape_string($conn, $pickup_firstname . " " . $pickup_lastname) . "', 
											`pickup_pickups`.`addressline`='" . mysqli_real_escape_string($conn, $pickup_street . " " . $pickup_streetno) . "', 
											`pickup_pickups`.`postalcode`='" . mysqli_real_escape_string($conn, $pickup_zipcode) . "', 
											`pickup_pickups`.`city`='" . mysqli_real_escape_string($conn, $pickup_city) . "', 
											`pickup_pickups`.`countrycode`='" . mysqli_real_escape_string($conn, $pickup_country) . "', 
											`pickup_pickups`.`email`='" . mysqli_real_escape_string($conn, $pickup_email) . "', 
											`pickup_pickups`.`phone`='" . mysqli_real_escape_string($conn, $pickup_phone) . "', 
											`pickup_pickups`.`room`='" . mysqli_real_escape_string($conn, $pickup_room) . "', 
											`pickup_pickups`.`floor`='" . mysqli_real_escape_string($conn, $pickup_floor) . "', 
											`pickup_pickups`.`pickuppoint`='" . mysqli_real_escape_string($conn, $pickup_pickuppoint) . "', 
											`pickup_pickups`.`weight`='" . mysqli_real_escape_string($conn, $pickup_weight) . "', 
											`pickup_pickups`.`servicecode`='" . mysqli_real_escape_string($conn, $pickup_servicecode) . "', 
											`pickup_pickups`.`paymentmethod`='" . mysqli_real_escape_string($conn, $pickup_paymentmethod) . "', 
											`pickup_pickups`.`transactionidentifier`='" . mysqli_real_escape_string($conn, $response->PickupCreationResponse->Response->TransactionReference->TransactionIdentifier) . "', 
											`pickup_pickups`.`prn`='" . mysqli_real_escape_string($conn, $response->PickupCreationResponse->PRN) . "'");

			if(isset($_POST['mail_with_pdf']) && intval($_POST['mail_with_pdf']) == 1){

				$filename = "begleitschein.pdf";

				$pdf = new Fpdi();

				$pdf->AddPage();

				require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

				$pdfdoc = $pdf->Output("", "S");

				if(isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $pickup_email != ""){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($pickup_email, $pickup_firstname . " " . $pickup_lastname);

					//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

					$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

					$mail->subject = strip_tags($row_template['subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}

				if(isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($row_admin['email']);

					//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

					$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

					$mail->subject = strip_tags($row_template['admin_mail_subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}


			}else{

				if(isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $pickup_email != ""){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($pickup_email, $pickup_firstname . " " . $pickup_lastname);

					$mail->subject = strip_tags($row_template['subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}

				if(isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1){

					$mail = new dbbMailer(true);

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($row_admin['email']);

					$mail->subject = strip_tags($row_template['admin_mail_subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}

			}

			$html_new_pickup_result = 	"					<div class=\"form-group row\">\n" . 
										"						<div class=\"col-12\">\n" . 
										"							<strong class=\"text-success\">\n" . 
										" 									Die Abholung wurde beauftragt!\n" . 
										"							</strong>\n" . 
										"						</div>\n" . 
										"					</div>\n";

			$emsg = "<p>Die Abholung wurde erfolgreich gespeichert!</p>\n";

			header('Location: /crm/abholungen');

		}else{

			$emsg = "<p>" . $response->response->errors[0]->message . "</p>\n";

		}

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row_address = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`='" . $from_address . "'"), MYSQLI_ASSOC);

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `address_addresses`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$result_address_addresses = mysqli_query($conn, "	SELECT 		* 
													FROM 		`address_addresses` 
													WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													" . $and . " 
													ORDER BY 	CAST(`address_addresses`.`id` AS UNSIGNED) ASC");

$options_from_addresses = "";

while($row = $result_address_addresses->fetch_array(MYSQLI_ASSOC)){

	$options_from_addresses .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $from_address ? " selected=\"selected\"" : "") . ">" . $row['shortcut'] . "</option>\n";

}

$options_admin_id = "";

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`admin` 
								WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : ($_SESSION["admin"]["id"] == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

}

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`countries` 
								ORDER BY 	`countries`.`name` ASC");

$options_countrycode_countries = "";

$to_country_id = 0;

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

	$options_countrycode_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ($row['id'] == ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $pickup_country : $row_address["country"]) ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	$to_country_id = ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $pickup_country : $row_address["country"]);

}

$carriers_services = $to_country_id == 1 ? array(
	'011' => 'UPS Standard', 
	'065' => 'UPS Saver'
) : array(
	'011' => 'UPS Standard'
);

$carrier_services_options = "";

foreach($carriers_services as $key => $val){

	$carrier_services_options .= "<option value=\"" . $key . "\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_servicecode : $row_address['servicecode']) == $key ? " selected=\"selected\"" : "") . ">" . $val . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Versand - Abholen</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die gewünschte Abholung beauftragen.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col\">\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Abholungsdaten</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		$html_new_pickup_result . 

		"					<div class=\"form-group row mb-0\">\n" . 
		"						<div class=\"col-sm-6\">\n" . 

		"							<div class=\"form-group row mb-0\">\n" . 
		"								<div class=\"col-sm-3 mt-1\">\n" . 
		"									<span>Abholadresse</span>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<select id=\"from_address\" name=\"from_address\" class=\"custom-select" . $inp_from_address . "\" onchange=\"\$('#update').click()\">\n" . 

		$options_from_addresses . 

		"									</select>\n" . 
		"									<input type=\"hidden\" id=\"pickup_shortcut\" name=\"pickup_shortcut\" value=\"" . $row_address['shortcut'] . "\" />\n" . 
		"								</div>\n" . 

		($_SESSION["admin"]["id"] == $maindata['admin_id'] ? 
			"								<div class=\"col-sm-3 mt-1 text-right\">\n" . 
			"									<span>Mitarbeiter: </span>\n" . 
			"								</div>\n" . 
			"								<div class=\"col-sm-3\">\n" . 
			"									<select id=\"admin_id\" name=\"admin_id\" class=\"custom-select\">\n" . 
			$options_admin_id . 
			"									</select>\n" . 
			"								</div>\n"
		: 
			"								<div class=\"col-sm-6\">\n" . 
			"									<input type=\"hidden\" name=\"admin_id\" value=\"" . $_SESSION["admin"]["id"] . "\" />\n" . 
			"								</div>\n"
		) . 

		"							</div>\n" . 

		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"form-group row mb-0\">\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<hr />\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"form-group row\">\n" . 
		"						<div class=\"col-sm-6 border-right\">\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"datepicker\" class=\"col-sm-3 col-form-label\">Abholung am</label>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<div class=\"input-group date\">\n" . 
		"										<input type=\"text\" id=\"datepicker\" name=\"pickup_pickupdate\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? date("d.m.Y", intval($pickup_pickupdate)) : date("d.m.Y", $time)) . "\" placeholder=\"00.00.0000\" class=\"form-control" . $inp_pickup_pickupdate . "\" />\n" . 
		"										<div class=\"input-group-append\">\n" . 
		"											<span class=\"input-group-text\">Datum</span>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_readytime_hours\" class=\"col-sm-3 col-form-label\">Abholzeit</label>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<div class=\"input-group border rounded\">\n" . 
		"										<select id=\"pickup_readytime_hours\" name=\"pickup_readytime_hours\" class=\"custom-select border-0" . $inp_pickup_readytime_hours . "\" onchange=\"setToTimeAfter2HoursPickup()\">\n" . 
		"											<option value=\"00\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
		"											<option value=\"01\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
		"											<option value=\"02\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
		"											<option value=\"03\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
		"											<option value=\"04\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
		"											<option value=\"05\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
		"											<option value=\"06\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
		"											<option value=\"07\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
		"											<option value=\"08\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
		"											<option value=\"09\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
		"											<option value=\"10\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"											<option value=\"11\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
		"											<option value=\"12\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
		"											<option value=\"13\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
		"											<option value=\"14\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
		"											<option value=\"15\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
		"											<option value=\"16\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
		"											<option value=\"17\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
		"											<option value=\"18\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
		"											<option value=\"19\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
		"											<option value=\"20\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"											<option value=\"21\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
		"											<option value=\"22\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
		"											<option value=\"23\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_hours : $row_address['readytime_hours']) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
		"										</select>\n" . 
		"										<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
		"										<select id=\"pickup_readytime_minutes\" name=\"pickup_readytime_minutes\" class=\"custom-select border-0" . $inp_pickup_readytime_minutes . "\" onchange=\"setToTimeAfter2HoursPickup()\">\n" . 
		"											<option value=\"00\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
		"											<option value=\"01\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
		"											<option value=\"02\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
		"											<option value=\"03\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
		"											<option value=\"04\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
		"											<option value=\"05\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
		"											<option value=\"06\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
		"											<option value=\"07\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
		"											<option value=\"08\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
		"											<option value=\"09\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
		"											<option value=\"10\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"											<option value=\"11\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
		"											<option value=\"12\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
		"											<option value=\"13\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
		"											<option value=\"14\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
		"											<option value=\"15\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
		"											<option value=\"16\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
		"											<option value=\"17\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
		"											<option value=\"18\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
		"											<option value=\"19\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
		"											<option value=\"20\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"											<option value=\"21\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
		"											<option value=\"22\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
		"											<option value=\"23\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
		"											<option value=\"24\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
		"											<option value=\"25\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
		"											<option value=\"26\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
		"											<option value=\"27\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
		"											<option value=\"28\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
		"											<option value=\"29\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
		"											<option value=\"30\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
		"											<option value=\"31\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
		"											<option value=\"32\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
		"											<option value=\"33\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
		"											<option value=\"34\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
		"											<option value=\"35\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
		"											<option value=\"36\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
		"											<option value=\"37\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
		"											<option value=\"38\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
		"											<option value=\"39\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
		"											<option value=\"40\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"											<option value=\"41\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
		"											<option value=\"42\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
		"											<option value=\"43\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
		"											<option value=\"44\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
		"											<option value=\"45\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
		"											<option value=\"46\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
		"											<option value=\"47\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
		"											<option value=\"48\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
		"											<option value=\"49\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
		"											<option value=\"50\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"											<option value=\"51\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
		"											<option value=\"52\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
		"											<option value=\"53\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
		"											<option value=\"54\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
		"											<option value=\"55\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
		"											<option value=\"56\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
		"											<option value=\"57\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
		"											<option value=\"58\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
		"											<option value=\"59\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_readytime_minutes : $row_address['readytime_minutes']) == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
		"										</select>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<label class=\"col-sm-1 col-form-label\">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</label>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<div class=\"input-group border rounded\">\n" . 
		"										<select id=\"pickup_closetime_hours\" name=\"pickup_closetime_hours\" class=\"custom-select border-0" . $inp_pickup_closetime_hours . "\">\n" . 
		"											<option value=\"00\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
		"											<option value=\"01\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
		"											<option value=\"02\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
		"											<option value=\"03\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
		"											<option value=\"04\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
		"											<option value=\"05\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
		"											<option value=\"06\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
		"											<option value=\"07\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
		"											<option value=\"08\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
		"											<option value=\"09\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
		"											<option value=\"10\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"											<option value=\"11\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
		"											<option value=\"12\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
		"											<option value=\"13\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
		"											<option value=\"14\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
		"											<option value=\"15\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
		"											<option value=\"16\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
		"											<option value=\"17\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
		"											<option value=\"18\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
		"											<option value=\"19\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
		"											<option value=\"20\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"											<option value=\"21\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
		"											<option value=\"22\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
		"											<option value=\"23\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_hours : $row_address['closetime_hours']) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
		"										</select>\n" . 
		"										<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
		"										<select id=\"pickup_closetime_minutes\" name=\"pickup_closetime_minutes\" class=\"custom-select border-0" . $inp_pickup_closetime_minutes . "\">\n" . 
		"											<option value=\"00\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
		"											<option value=\"01\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
		"											<option value=\"02\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
		"											<option value=\"03\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
		"											<option value=\"04\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
		"											<option value=\"05\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
		"											<option value=\"06\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
		"											<option value=\"07\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
		"											<option value=\"08\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
		"											<option value=\"09\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
		"											<option value=\"10\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"											<option value=\"11\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
		"											<option value=\"12\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
		"											<option value=\"13\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
		"											<option value=\"14\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
		"											<option value=\"15\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
		"											<option value=\"16\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
		"											<option value=\"17\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
		"											<option value=\"18\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
		"											<option value=\"19\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
		"											<option value=\"20\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"											<option value=\"21\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
		"											<option value=\"22\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
		"											<option value=\"23\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
		"											<option value=\"24\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
		"											<option value=\"25\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
		"											<option value=\"26\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
		"											<option value=\"27\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
		"											<option value=\"28\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
		"											<option value=\"29\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
		"											<option value=\"30\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
		"											<option value=\"31\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
		"											<option value=\"32\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
		"											<option value=\"33\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
		"											<option value=\"34\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
		"											<option value=\"35\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
		"											<option value=\"36\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
		"											<option value=\"37\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
		"											<option value=\"38\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
		"											<option value=\"39\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
		"											<option value=\"40\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"											<option value=\"41\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
		"											<option value=\"42\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
		"											<option value=\"43\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
		"											<option value=\"44\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
		"											<option value=\"45\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
		"											<option value=\"46\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
		"											<option value=\"47\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
		"											<option value=\"48\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
		"											<option value=\"49\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
		"											<option value=\"50\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"											<option value=\"51\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
		"											<option value=\"52\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
		"											<option value=\"53\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
		"											<option value=\"54\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
		"											<option value=\"55\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
		"											<option value=\"56\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
		"											<option value=\"57\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
		"											<option value=\"58\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
		"											<option value=\"59\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_closetime_minutes : $row_address['closetime_minutes']) == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
		"										</select>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-2 mt-1\">\n" . 
		"									<label>Uhr</label>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_room\" class=\"col-sm-3 col-form-label\">Raum</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<input type=\"text\" id=\"pickup_room\" name=\"pickup_room\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_room : "R01") . "\" class=\"form-control" . $inp_pickup_room . "\" placeholder=\"R01\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_floor\" class=\"col-sm-3 col-form-label\">Stockwerk</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<input type=\"text\" id=\"pickup_floor\" name=\"pickup_floor\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_floor : "1") . "\" class=\"form-control" . $inp_pickup_floor . "\" placeholder=\"1\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_weight\" class=\"col-sm-3 col-form-label\">Gesamtgewicht</label>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<div class=\"input-group date\">\n" . 
		"										<input type=\"text\" id=\"pickup_weight\" name=\"pickup_weight\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? number_format($pickup_weight, 1, ',', '') : number_format($row_address['weight'], 1, ',', '')) . "\" placeholder=\"5,0\" class=\"form-control" . $inp_pickup_weight . "\" />\n" . 
		"										<div class=\"input-group-append\">\n" . 
		"											<span class=\"input-group-text\">kg</span>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-6 mt-1 text-right\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_quantity\" class=\"col-sm-3 col-form-label\">Gesamtpakete</label>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<div class=\"input-group date\">\n" . 
		"										<input type=\"number\" id=\"pickup_quantity\" name=\"pickup_quantity\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_quantity : $row_address['quantity']) . "\" placeholder=\"1\" class=\"form-control" . $inp_pickup_quantity . "\" />\n" . 
		"										<div class=\"input-group-append\">\n" . 
		"											<span class=\"input-group-text\">Stück</span>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-6 mt-1 text-right\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"pickup_paymentmethod\" class=\"col-sm-3 col-form-label\">Zahlart</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<select id=\"pickup_paymentmethod\" name=\"pickup_paymentmethod\" class=\"custom-select" . $inp_pickup_paymentmethod . "\">\n" . 
		"										<option value=\"00\"" . ($pickup_paymentmethod == "00" ? " selected=\"selected\"" : "") . ">Keine Zahlung erforderlich</option>\n" . 
		"										<option value=\"01\"" . ($pickup_paymentmethod == "01" ? " selected=\"selected\"" : "") . ">Zahlung per Versenderkonto</option>\n" . 
		"										<option value=\"03\"" . ($pickup_paymentmethod == "03" ? " selected=\"selected\"" : "") . ">Mit Kreditkarte bezahlen</option>\n" . 
		"										<option value=\"04\"" . ($pickup_paymentmethod == "04" ? " selected=\"selected\"" : "") . ">Bezahlen mit 1Z Tracking-Nummer</option>\n" . 
		"										<option value=\"05\"" . ($pickup_paymentmethod == "05" ? " selected=\"selected\"" : "") . ">Per Scheck oder Zahlungsanweisung bezahlen</option>\n" . 
		"										<option value=\"06\"" . ($pickup_paymentmethod == "06" ? " selected=\"selected\"" : "") . ">Bargeld (Nur bei Ländercode: BE, FR, DE, IT, MX, NL, PL, ES, GB, CZ, HU, FI, NO)</option>\n" . 
		"										<option value=\"07\"" . ($pickup_paymentmethod == "07" ? " selected=\"selected\"" : "") . ">PayPal bezahlen</option>\n" . 
		"									</select>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									&nbsp;\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-3 col-form-label\">Abholer-Mail</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"usermail\" name=\"usermail\" value=\"1\"" . (isset($_POST['usermail']) && intval($_POST['usermail']) ==  1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"usermail\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 
		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-3 col-form-label\">Admin-Mail</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"adminmail\" name=\"adminmail\" value=\"1\"" . (isset($_POST['adminmail']) && intval($_POST['adminmail']) ==  1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"adminmail\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 
		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-3 col-form-label\">Begleitschein</label>\n" . 
		"								<div class=\"col-sm-5\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"mail_with_pdf\" name=\"mail_with_pdf\" value=\"1\"" . (isset($_POST['mail_with_pdf']) && intval($_POST['mail_with_pdf']) ==  1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"mail_with_pdf\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"						</div>\n" . 
		"						<div class=\"col-sm-6\">\n" . 

		"							<div class=\"form-group row m-1\">\n" . 
		"								<div class=\"col-sm-12 bg-light border\">\n" . 

		"									<div class=\"form-group row mt-3\">\n" . 
		"										<div class=\"col-sm-12\">\n" . 
		"											<strong>Abholadresse</strong>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-12\">\n" . 
		"											<input type=\"text\" id=\"pickup_companyname\" name=\"pickup_companyname\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_companyname : $row_address['companyname']) . "\" class=\"form-control" . $inp_pickup_companyname . "\" placeholder=\"Firma\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4 mt-1\">\n" . 
		"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"												<input type=\"radio\" id=\"gender_01\" name=\"pickup_gender\" value=\"0\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $_POST['gender'] : $row_address["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"												<label class=\"custom-control-label\" for=\"gender_01\">\n" . 
		"													Herr\n" . 
		"												</label>\n" . 
		"											</div>\n" . 
		"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"												<input type=\"radio\" id=\"gender_11\" name=\"pickup_gender\" value=\"1\"" . (((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $_POST['gender'] : $row_address["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"												<label class=\"custom-control-label\" for=\"gender_11\">\n" . 
		"													Frau\n" . 
		"												</label>\n" . 
		"											</div>\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_firstname\" name=\"pickup_firstname\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_firstname : $row_address['firstname']) . "\" class=\"form-control" . $inp_pickup_firstname . "\" placeholder=\"Vorname\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_lastname\" name=\"pickup_lastname\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_lastname : $row_address['lastname']) . "\" class=\"form-control" . $inp_pickup_firstname . "\" placeholder=\"Nachname\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-10\">\n" . 
		"											<input type=\"text\" id=\"pickup_street\" name=\"pickup_street\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_street : $row_address['street']) . "\" class=\"form-control" . $inp_pickup_street . "\" placeholder=\"Straße\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-2\">\n" . 
		"											<input type=\"text\" id=\"pickup_streetno\" name=\"pickup_streetno\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_streetno : $row_address['streetno']) . "\" class=\"form-control" . $inp_pickup_streetno . "\" placeholder=\"Nr\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_zipcode\" name=\"pickup_zipcode\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_zipcode : $row_address['zipcode']) . "\" class=\"form-control" . $inp_pickup_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_city\" name=\"pickup_city\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_city : $row_address['city']) . "\" class=\"form-control" . $inp_pickup_city . "\" placeholder=\"Stadt\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<select id=\"pickup_country\" name=\"pickup_country\" class=\"custom-select" . $inp_pickup_country . "\" onchange=\"\$('#update_country').click()\">\n" . 

		$options_countrycode_countries . 

		"											</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_pickuppoint\" name=\"pickup_pickuppoint\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_pickuppoint : "") . "\" class=\"form-control" . $inp_pickup_pickuppoint . "\" placeholder=\"Abholort\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_phone\" name=\"pickup_phone\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_phone : ($row_address['mobilnumber'] != "" ? $row_address['mobilnumber'] : $row_address['phonenumber'])) . "\" class=\"form-control" . $inp_pickup_phone . "\" placeholder=\"Telefonnummer\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"email\" id=\"pickup_email\" name=\"pickup_email\" value=\"" . ((isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen") || (isset($_POST['update_country']) && $_POST['update_country'] == "Aktualisieren") ? $pickup_email : $row_address['email']) . "\" class=\"form-control" . $inp_pickup_email . "\" placeholder=\"Email\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<select id=\"pickup_servicecode\" name=\"pickup_servicecode\" class=\"custom-select" . $inp_pickup_servicecode . "\">\n" . 

		$carrier_services_options . 

		"											</select>\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_description\" name=\"pickup_description\" value=\"" . (isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen" ? $pickup_description : date("Ymd", time()) . "_" . strtoupper($row_address['shortcut'])) . "\" class=\"form-control" . $inp_pickup_description . "\" placeholder=\"Hinweis\" />\n" . 
		"										</div>\n" . 
		"										<div class=\"col-sm-4\">\n" . 
		"											<input type=\"text\" id=\"pickup_referencenumber\" name=\"pickup_referencenumber\" value=\"" . (isset($_POST['pickup']) && $_POST['pickup'] == "Abholung beauftragen" ? $pickup_referencenumber : date("Ymd", time()) . "_" . strtoupper($row_address['shortcut'])) . "\" class=\"form-control" . $inp_pickup_referencenumber . "\" placeholder=\"Referenznummer\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"								</div>\n" . 
		"							</div>\n" . 

		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"row px-0 card-footer\">\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<button type=\"submit\" name=\"pickup\" value=\"Abholung beauftragen\" class=\"btn btn-primary\">Abholung beauftragen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
		"							<input type=\"submit\" id=\"update\" name=\"update\" value=\"aktualisieren\" class=\"d-none\" />\n" . 
		"							<input type=\"submit\" id=\"update_country\" name=\"update_country\" value=\"aktualisieren\" class=\"d-none\" />\n" . 
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