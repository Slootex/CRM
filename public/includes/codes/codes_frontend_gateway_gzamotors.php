<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

include("includes/get_ups_status.php");

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_order_as = "";

$inp_companyname = "";
$inp_gender = "";
$inp_firstname = "";
$inp_lastname = "";
$inp_street = "";
$inp_streetno = "";
$inp_zipcode = "";
$inp_city = "";
$inp_country = "";
$inp_phonenumber = "";
$inp_mobilnumber = "";
$inp_email = "";
$inp_differing_shipping_address = 0;
$inp_differing_gender = "";
$inp_differing_companyname = "";
$inp_differing_firstname = "";
$inp_differing_lastname = "";
$inp_differing_street = "";
$inp_differing_streetno = "";
$inp_differing_zipcode = "";
$inp_differing_city = "";
$inp_differing_country = "";

$inp_machine = "";
$inp_model = "";
$inp_constructionyear = "";
$inp_carid = "";
$inp_kw = "";
$inp_mileage = "";
$inp_mechanism = "";
$inp_fuel = "";

$inp_component = "";
$inp_manufacturer = "";
$inp_serial = "";
$inp_fromthiscar = "";
$inp_reason = "";
$inp_description = "";

$inp_radio_shipping = "";
$inp_radio_payment = "";
$inp_terms = "";
$inp_dsgvo = "";

$order_as = 0;

$companyname = "";
$gender = 0;
$firstname = "";
$lastname = "";
$street = "";
$streetno = "";
$zipcode = "";
$city = "";
$country = 0;
$phonenumber = "";
$mobilnumber = "";
$email = "";
$differing_shipping_address = 0;
$differing_companyname = "";
$differing_gender = 0;
$differing_firstname = "";
$differing_lastname = "";
$differing_street = "";
$differing_streetno = "";
$differing_zipcode = "";
$differing_city = "";
$differing_country = 0;

$run_date = time();

$machine = "";
$model = "";
$constructionyear = "";
$carid = "";
$kw = "";
$mileage = 0;
$mechanism = 0;
$fuel = 0;

$component = "";
$manufacturer = "";
$serial = "";
$fromthiscar = "";
$reason = "";
$description = "";


$radio_shipping = 0;
$radio_payment = 0;
$terms = 0;
$dsgvo = 0;

if(isset($_POST['get']) && $_POST['get'] == "COUNTRIES" && $_POST['url_password'] == $maindata['url_password']){

	$countries = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countries[] = $row;
	}

	$data = array('emsg' => 'OK', 'countries' => $countries);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "REASONS" && $_POST['url_password'] == $maindata['url_password']){

	$reasons = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$reasons[] = $row;
	}

	$data = array('emsg' => 'OK', 'reasons' => $reasons);

	echo json_encode($data);

}

if(isset($_POST['save']) && $_POST['save'] == "WEITER" && $_POST['url_password'] == $maindata['url_password']){

	if(strlen($_POST['order_as']) < 1 || strlen($_POST['order_as']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Option, Ich bestelle als, an.</small><br />\n";
		$inp_order_as = " is-invalid";
		$order_as = 0;
	} else {
		$order_as = intval($_POST['order_as']);
	}

	if(isset($_POST['order_as']) && intval($_POST['order_as']) == 1){
		if(strlen($_POST['companyname']) > 256){
			$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
			$inp_companyname = " is-invalid";
			$companyname = "";
		} else {
			$companyname = strip_tags($_POST['companyname']);
		}
	}

	if(strlen($_POST['gender']) < 1 || strlen($_POST['gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Anrede an.</small><br />\n";
		$inp_gender = " is-invalid";
		$gender = 0;
	} else {
		$gender = intval($_POST['gender']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
		$firstname = "";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
		$lastname = "";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
		$street = "";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
		$streetno = "";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
		$zipcode = "";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
		$city = "";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) < 1 || strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
		$country = 0;
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
		$phonenumber = "";
	} else {
		$phonenumber = strip_tags($_POST['phonenumber']);
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
		$mobilnumber = "";
	} else {
		$mobilnumber = strip_tags($_POST['mobilnumber']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
		$email = "";
	}

	if(isset($_POST['differing_shipping_address']) && intval($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
		$differing_shipping_address = 0;
	} else {
		$differing_shipping_address = intval(isset($_POST['differing_shipping_address']) ? $_POST['differing_shipping_address'] : 0);
	}

	if(strlen($_POST['differing_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
		$differing_companyname = "";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if(strlen($_POST['differing_gender']) < 1 || strlen($_POST['differing_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Anrede an.</small><br />\n";
		$inp_differing_gender = " is-invalid";
		$differing_gender = 0;
	} else {
		$differing_gender = intval($_POST['differing_gender']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) < 1 || strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
		$differing_firstname = "";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) < 1 || strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
		$differing_lastname = "";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) < 1 || strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
		$differing_street = "";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) < 1 || strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
		$differing_streetno = "";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) < 1 || strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
		$differing_zipcode = "";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) < 1 || strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
		$differing_city = "";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) < 1 || strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
		$differing_country = 0;
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if(strlen($_POST['run_date']) < 1 || strlen($_POST['run_date']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte die Bearbeitungsdauer eingeben. (max. 10 Zeichen)</small><br />\n";
		$run_date = 0;
	} else {
		$run_date = intval($_POST['run_date']);
	}


	if(strlen($_POST['machine']) < 1 || strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
		$machine = "";
	} else {
		$machine = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) < 1 || strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
		$model = "";
	} else {
		$model = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) < 1 || strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
		$constructionyear = "";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
		$carid = "";
	} else {
		$carid = strip_tags($_POST['carid']);
	}

	if(strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleistung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
		$kw = "";
	} else {
		$kw = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Kilometerstand eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_mileage = " is-invalid";
		$mileage = 0;
	} else {
		$mileage = intval(str_replace(".", "", $_POST['mileage']));
	}

	if(strlen($_POST['mechanism']) < 1 || strlen($_POST['mechanism']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Getriebe an.</small><br />\n";
		$inp_mechanism = " is-invalid";
		$mechanism = 0;
	} else {
		$mechanism = intval($_POST['mechanism']);
	}

	if(strlen($_POST['fuel']) < 1 || strlen($_POST['fuel']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Getriebe an.</small><br />\n";
		$inp_fuel = " is-invalid";
		$fuel = 0;
	} else {
		$fuel = intval($_POST['fuel']);
	}


	if(strlen($_POST['component']) < 1 || strlen($_POST['component']) > 256 || intval($_POST['component']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
		$component = "";
	} else {
		$component = intval($_POST['component']);
	}

	if(strlen($_POST['manufacturer']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte den Hersteller eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_manufacturer = " is-invalid";
		$manufacturer = "";
	} else {
		$manufacturer = strtoupper(strip_tags($_POST['manufacturer']));
	}

	if(strlen($_POST['serial']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Teile.-/Herstellernummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_serial = " is-invalid";
		$serial = "";
	} else {
		$serial = strip_tags($_POST['serial']);
	}

	if(strlen($_POST['fromthiscar']) < 1 || strlen($_POST['fromthiscar']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Gerät aus dem angegebenen KFZ stammt. (max. 256 Zeichen)</small><br />\n";
		$inp_fromthiscar = " is-invalid";
		$fromthiscar = "";
	} else {
		$fromthiscar = strip_tags($_POST['fromthiscar']);
	}

	if(strlen($_POST['reason']) < 1 || strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
		$reason = "";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
		$description = "";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
	}


	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
		$radio_shipping = 0;
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
		$radio_payment = 0;
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(intval($_POST['terms']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte akzeptieren Sie unsere AGB's.</small><br />\n";
		$inp_terms = " is-invalid";
		$terms = 0;
	} else {
		$terms = intval($_POST['terms']);
	}

	if(intval($_POST['dsgvo']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte bestätigen Sie unsere Datenschutzbestimmungen.</small><br />\n";
		$inp_dsgvo = " is-invalid";
		$dsgvo = 0;
	} else {
		$dsgvo = intval($_POST['dsgvo']);
	}

	if($emsg == ""){

		$hash = bin2hex(random_bytes(32));

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($component)) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($country)) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($differing_country)) . "'"), MYSQLI_ASSOC);

		$time = time();

		$order_number = 0;

		while($order_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`order_number`='" . $random . "'");

			if($result->num_rows == 0){
				$order_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number, 0777);
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/audio/.htaccess");

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$files = "";
		$links = "";
		$docs = "";

		for($j = 1;$j <= 5;$j++){

			if(isset($_FILES['file_' . $j]['tmp_name']) && $_FILES['file_' . $j]['tmp_name'] != ""){
				copy($_FILES['file_' . $j]['tmp_name'], "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_FILES['file_' . $j]['name']);
				$files .= $files == "" ? $_FILES['file_' . $j]['name'] : "\r\n" . $_FILES['file_' . $j]['name'];
				$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_FILES['file_' . $j]['name'] . "\">" . $_FILES['file_' . $j]['name'] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_FILES['file_' . $j]['name'] . "\">" . $_FILES['file_' . $j]['name'] . "</a>\n";
				$docs .= $docs == "" ? $_FILES['file_' . $j]['name'] : ", " . $_FILES['file_' . $j]['name'];
			}

		}

		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		mysqli_query($conn, "	INSERT 	`order_orders` 
								SET 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders`.`mode`='" . mysqli_real_escape_string($conn, 2) . "', 
										`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`creator_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "', 
										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`customer_number`='" . mysqli_real_escape_string($conn, "") . "', 

										`order_orders`.`order_as`='" . mysqli_real_escape_string($conn, strip_tags($order_as)) . "', 
										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, strip_tags($companyname)) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, strip_tags($gender)) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, strip_tags($firstname)) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, strip_tags($lastname)) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, strip_tags($street)) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, strip_tags($streetno)) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, strip_tags($zipcode)) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, strip_tags($city)) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, strip_tags($country)) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, strip_tags($phonenumber)) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, strip_tags($mobilnumber)) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, strip_tags($email)) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, intval($differing_shipping_address)) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, strip_tags($differing_gender)) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, strip_tags($differing_companyname)) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, strip_tags($differing_firstname)) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, strip_tags($differing_lastname)) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, strip_tags($differing_street)) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, strip_tags($differing_streetno)) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, strip_tags($differing_zipcode)) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, strip_tags($differing_city)) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, strip_tags($differing_country)) . "', 

										`order_orders`.`machine`='" . mysqli_real_escape_string($conn, strip_tags($machine)) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, strip_tags($model)) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, strip_tags($constructionyear)) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, strip_tags($carid)) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, strip_tags($kw)) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, strip_tags($mileage)) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, strip_tags($mechanism)) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, strip_tags($fuel)) . "', 

										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, strip_tags($reason)) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, strip_tags($description)) . "', 

										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval($radio_shipping)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($radio_payment)) . "', 
										`order_orders`.`terms`='" . mysqli_real_escape_string($conn, intval($terms)) . "', 
										`order_orders`.`dsgvo`='" . mysqli_real_escape_string($conn, intval($dsgvo)) . "', 

										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, $time) . "', 

										`order_orders`.`public`='1', 
										`order_orders`.`hash`='" . mysqli_real_escape_string($conn, strip_tags($hash)) . "', 
										`order_orders`.`run_date`='" . mysqli_real_escape_string($conn, intval($run_date)) . "', 
										`order_orders`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`cpy_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
		$_SESSION["order"]["id"] = $conn->insert_id;

		$device_number = 0;

		for($i = 11;$i < 100;$i++){

			$number = $order_number . "-" . $i;

			$result = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_devices`.`device_number`='" . $number . "'");

			if($result->num_rows == 0){
				$device_number = $number;
				break;
			}

		}

		$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	INSERT 	`order_orders_devices` 
								SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "', 
										`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
										`order_orders_devices`.`component`='" . mysqli_real_escape_string($conn, strip_tags($component)) . "', 
										`order_orders_devices`.`manufacturer`='" . mysqli_real_escape_string($conn, strip_tags($manufacturer)) . "', 
										`order_orders_devices`.`serial`='" . mysqli_real_escape_string($conn, strip_tags($serial)) . "', 
										`order_orders_devices`.`fromthiscar`='" . mysqli_real_escape_string($conn, strip_tags($fromthiscar)) . "', 
										`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
										`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
		$_SESSION["device"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
								SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
										`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "Gerät " . strip_tags($device_number) . ", erstellt, ID [#" . $_SESSION["device"]["id"] . "]") . "', 
										`order_orders_devices_events`.`subject`='', 
										`order_orders_devices_events`.`body`='', 
										`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['interested_status'])) . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[hash]", $hash, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[order_as]", $order_as, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", ($gender == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($gender == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", ($mobilnumber != "" ? $mobilnumber : $phonenumber), $row_template[$fields[$j]]);
			//$row_template[$fields[$j]] = str_replace("[mobilnumber]", $mobilnumber, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $email . "\">" . $email . "</a>\n", $row_template[$fields[$j]]);

			$differing_shipping_address_html = 	$differing_shipping_address == 0 ? 
												"" : 
												"<h4>Abweichende Lieferadresse</h4>\n" . 
												"<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\">\n" . 
												"	<tr><td width=\"200\"><strong>Firma:</strong></td><td><span>[differing_companyname]</span></td></tr>\n" . 
												"	<tr><td><strong>Vorname:</strong></td><td><span>[differing_firstname]</span></td></tr>\n" . 
												"	<tr><td><strong>Nachname:</strong></td><td><span>[differing_lastname]</span></td></tr>\n" . 
												"	<tr><td><strong>Straße:</strong></td><td><span>[differing_street]</span></td></tr>\n" . 
												"	<tr><td><strong>Hausnummer:</strong></td><td><span>[differing_streetno]</span></td></tr>\n" . 
												"	<tr><td><strong>PLZ:</strong></td><td><span>[differing_zipcode]</span></td></tr>\n" . 
												"	<tr><td><strong>Ort:</strong></td><td><span>[differing_city]</span></td></tr>\n" . 
												"	<tr><td><strong>Land:</strong></td><td><span>[differing_country]</span></td></tr>\n" . 
												"</table>\n" . 
												"<br />\n";

			$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $differing_shipping_address_html, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $differing_companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $differing_firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $differing_lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $differing_street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $differing_streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $differing_zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $differing_city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($machine), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($model), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($constructionyear), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($carid)), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($kw), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($mileage), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", (intval($mechanism) == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", (intval($fuel) == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $reason, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $description, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$radio_shipping], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$radio_payment], $row_template[$fields[$j]]);
			$radio_terms = array(	0 => "", 
									1 => "Ich versichere, dass die vorstehenden Angaben der Wahrheit entsprechen. Ich beauftrage die Fa. GZA MOTORS mit der Fehelerdiagnose für das/die beiligende/n Gerät/e");
			$row_template[$fields[$j]] = str_replace("[terms]", $radio_terms[$_terms], $row_template[$fields[$j]]);
			$radio_dsgvo = array(	0 => "", 
									1 => "Ja, ich habe die <a href=\"" . $domain . "/save/agb.pdf\" target=\"_blank\" class=\"alert-link\">Datenschutzerklärung</a> zur Kenntnis genommen und bin damit einverstanden, dass die von mir angegebenen Daten elektronisch erhoben und gespeichert werden.");
			$row_template[$fields[$j]] = str_replace("[dsgvo]", $radio_dsgvo[$dsgvo], $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`interested_interesteds_statuses` 
								SET 	`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`interested_interesteds_statuses`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
										`interested_interesteds_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`interested_interesteds_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`interested_interesteds_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`interested_interesteds_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`interested_interesteds_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`interested_interesteds_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`interested_interesteds_statuses`.`public`='1', 
										`interested_interesteds_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, erstellt, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		if($files != ""){

			mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
									SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
											`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
											`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
											`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
											`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
											`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
											`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
											`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			for($j = 1;$j <= 5;$j++){

				if(isset($_FILES['file_' . $j]['tmp_name']) && $_FILES['file_' . $j]['tmp_name'] != ""){

					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
													`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
													`order_orders_files`.`type`='4', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $_FILES['file_' . $j]['name']) . "', 
													`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				}

			}

		}

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $company_id . "/" . $order_number . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

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

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress(strip_tags($email), strip_tags($firstname) . " " . strip_tags($lastname));

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

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

		$data = array('id' => $_SESSION["order"]["id"], 'emsg' => 'OK');

		echo json_encode($data);

	}else{

		$data = array('emsg' => $emsg);

		echo json_encode($data);

	}

}

if(isset($_POST['get']) && $_POST['get'] == "AUFTRAG" && $_POST['url_password'] == $maindata['url_password']){

	if(isset($_POST['id']) && intval($_POST['id']) > 0){

		$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																FROM 		`order_orders` 
																WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "' 
																AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);

		$row_order['reason_name'] = isset($row_reason['name']) ? $row_reason['name'] : "";

		echo json_encode($row_order);

	}else{

		$data = array('emsg' => 'Der Auftrag wurde nicht gefunden!');

		echo json_encode($data);

	}

}

if(isset($_POST['get_by_order_number']) && $_POST['get_by_order_number'] == "AUFTRAG" && $_POST['url_password'] == $maindata['url_password']){

	if(isset($_POST['order_number']) && intval($_POST['order_number']) > 0){

		$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																FROM 		`order_orders` 
																WHERE 		`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST["order_number"])) . "' 
																AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

		echo json_encode($row_order);

	}else{

		$data = array('emsg' => 'Der Auftrag wurde nicht gefunden!');

		echo json_encode($data);

	}

}

if(isset($_POST['update']) && $_POST['update'] == "AUFTRAG" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
															FROM 		`order_orders` 
															WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "' 
															AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);
	$time = time();

	// Rechnungsanschrift

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
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

	if(strlen($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = intval($_POST['differing_shipping_address']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_companyname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_companyname']) < 1 || strlen($_POST['differing_companyname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) < 1 || strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) < 1 || strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) < 1 || strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) < 1 || strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) < 1 || strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) < 1 || strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) < 1 || strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
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

	// Fehlerbeschreibung

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

	// Fahrzeugdaten

	if(strlen($_POST['machine']) < 1 || strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
	} else {
		$machine = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) < 1 || strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
	} else {
		$model = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) < 1 || strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) < 1 || strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
	} else {
		$carid = strip_tags($_POST['carid']);
	}

	if(strlen($_POST['kw']) < 1 || strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleisung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
	} else {
		$kw = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) < 1 || strlen($_POST['mileage']) > 10){
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

	// Dateiupload

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	for($j = 1;$j <= 5;$j++){

		if(isset($_FILES['file_' . $j]['tmp_name']) && $_FILES['file_' . $j]['tmp_name'] != ""){

			$ext = pathinfo($_FILES['file_' . $j]['name'], PATHINFO_EXTENSION);
			if(in_array($ext, $allowed)){
				$sumsize+=filesize($_FILES['file_' . $j]['tmp_name']);
			}

		}

	}
				
	if($sumsize > $upload_max_filesize * 1024 * 1024){
		$emsg .= "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
	}

	$uploaddir = 'uploads/';

	$files = "";

	if($emsg == ""){

		for($j = 1;$j <= 5;$j++){

			if(isset($_FILES['file_' . $j]['tmp_name']) && $_FILES['file_' . $j]['tmp_name'] != ""){

				$ext = pathinfo($_FILES['file_' . $j]['name'], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$random = rand(1, 100000);
					$_FILES['file_' . $j]['name'] = str_replace(' ', '', $_FILES['file_' . $j]['name']);
					move_uploaded_file($_FILES['file_' . $j]['tmp_name'], $uploaddir . "company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . basename($random . '_' . $_FILES['file_' . $j]['name']));
					$files .= $files == "" ? $random . '_' . $_FILES['file_' . $j]['name'] : "\r\n" . $random . '_' . $_FILES['file_' . $j]['name'];
					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
													`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
													`order_orders_files`.`type`='0', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES['file_' . $j]['name']) . "', 
													`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
				}else{
					$emsg .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES['file_' . $j]['name'] . "</p>\n";
				}

			}

		}

	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
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
										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_shipping']) ? $_POST['radio_shipping'] : 0)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_payment']) ? $_POST['radio_payment'] : 0)) . "', 

										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 

										`order_orders`.`machine`='" . mysqli_real_escape_string($conn, $machine) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, $model) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, $constructionyear) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, strtoupper($carid)) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, $kw) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, $mileage) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, $mechanism) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, $fuel) . "', 

										`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, ($row_order['files'] == "" ? $files : $row_order['userdata'] . "\r\n" . $files)) . "', 

										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`=" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "");

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($row_order['admin_id'])) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

		echo json_encode($data);

	}else{

		$data = array('emsg' => $emsg);

		echo json_encode($data);

	}

}

if(isset($_POST['file_delete']) && $_POST['file_delete'] == "X" && isset($_POST['id']) && intval($_POST['id']) > 0 && isset($_POST['item']) && $_POST['item'] >= 0 && $_POST['item'] <= 4 && $_POST['url_password'] == $maindata['url_password']){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
															FROM 		`order_orders` 
															WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "' 
															AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		$time = time();

		$files = "";

		$arr_files = explode("\r\n", $row_order['files']);

		$file_id = 0;
		$file_name = "";

		for($i = 0;$i < count($arr_files);$i++){
			if($i == intval($_POST['item'])){
				@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i]);
				$file_id = ($i + 1);
				$file_name = $arr_files[$i];
			}else{
				$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
			}
		}

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`files`='" . mysqli_real_escape_string($conn, $files) . "' 
								WHERE 	`order_orders`.`id`=" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "");

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($row_order['admin_id'])) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

}

if(isset($_POST['move_order']) && $_POST['move_order'] == "AUFTRAG AN UNS ÜBERMITTELN" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`mode`=0, 
									`order_orders`.`hash`='', 
									`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
							SET 	`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$data = array('emsg' => 'OK');

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-AUFTRAG" && isset($_POST['order_number']) && strip_tags($_POST['order_number']) != "" && $_POST['url_password'] == $maindata['url_password']){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT 	*, 

																	(SELECT 		`order_orders_statuses`.`time` AS time 
																		FROM 		`order_orders_statuses` 
																		LEFT JOIN 	`statuses` 
																		ON 			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																		WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																		AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`order_orders_statuses`.`public`='1' 
																		AND 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`statuses`.`public`='1' 
																		ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_time, 

																	(SELECT 		`order_orders_statuses`.`subject` AS subject 
																		FROM 		`order_orders_statuses` 
																		LEFT JOIN 	`statuses` 
																		ON 			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																		WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																		AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`order_orders_statuses`.`public`='1' 
																		AND 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`statuses`.`public`='1' 
																		ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_subject, 

																	(SELECT 		`statuses`.`name` AS name 
																		FROM 		`order_orders_statuses` 
																		LEFT JOIN 	`statuses` 
																		ON 			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																		WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																		AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`order_orders_statuses`.`public`='1' 
																		AND 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		AND 	`statuses`.`public`='1' 
																		ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name 

															FROM 	`order_orders` 
															WHERE 	`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
															AND 	`order_orders`.`public`='1' 
															AND 	`order_orders`.`mode`='0'"), MYSQLI_ASSOC);

	if(isset($row_order['order_number']) && $row_order['order_number'] == strip_tags($_POST['order_number'])){

		echo json_encode($row_order);

	}else{

		$data = array('emsg' => '<p>Der Auftrag wurde nicht gefunden!</p>');

		echo json_encode($row_order);

	}

}

if(isset($_POST['update']) && $_POST['update'] == "STATUS-COUNTER" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`status_counter`=`order_orders`.`status_counter`+1 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-STEP-3" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_step_3 = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS id, 
														`order_orders_statuses`.`status_number` AS status_number, 
														`order_orders_statuses`.`time` AS time, 
														(
															SELECT 	name
															FROM 	`admin` `admin`
															WHERE 	`admin`.`id`=`order_orders_statuses`.`admin_id` 
															AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
														) AS admin_name, 
														`order_orders_statuses`.`subject` AS subject, 
														`statuses`.`name` AS status_name, 
														`statuses`.`color` AS status_color 
											FROM 		`order_orders_statuses` `order_orders_statuses`
											LEFT JOIN 	`statuses` `statuses` 
											ON 			`statuses`.`id`=`order_orders_statuses`.`status_id`
											WHERE 		`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
											AND 		`statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_ending_status'])) . "' 
											AND 		`statuses`.`public`='1' 
											AND 		`order_orders_statuses`.`public`='1' 
											ORDER BY 	CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC");

	$data = array('num_rows' => $result_step_3->num_rows);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-STEP-1-2" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_step_1_2 = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS id, 
															`order_orders_statuses`.`status_number` AS status_number, 
															`order_orders_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`order_orders_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
															) AS admin_name, 
															`order_orders_statuses`.`subject` AS subject, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`order_orders_statuses` `order_orders_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`order_orders_statuses`.`status_id`
												WHERE 		`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`public`='1' 
												AND 		`order_orders_statuses`.`public`='1' 
												ORDER BY 	CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC");

	$data = array('num_rows' => $result_step_1_2->num_rows);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-SENDUNG" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_shipping = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		* 
																FROM 		`order_orders_shipments` 
																WHERE 		`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
																AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

	echo json_encode($row_shipping);

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-UPS-STATUS" && isset($_POST['shipments_id']) && intval($_POST['shipments_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$response = getUpsStatus($maindata, $_POST['shipments_id']);

	echo json_encode($response);

}

if(isset($_POST['get']) && $_POST['get'] == "STATUS-LIST" && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$list_status = 	"				<div class=\"table-responsive overflow-auto border\">\n" . 
					"					<table class=\"table table-borderless mb-0\">\n" . 
					"						<thead><tr class=\"\">\n" . 
					"							<th><strong>Statusverlauf</strong></th>\n" . 
					"							<th><strong>&nbsp;</strong></th>\n" . 
					"						</tr></thead>\n";

	$result_statuses = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS id, 
															`order_orders_statuses`.`status_number` AS status_number, 
															`order_orders_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`order_orders_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
															) AS admin_name, 
															`order_orders_statuses`.`template` AS template, 
															`order_orders_statuses`.`subject` AS subject, 
															`order_orders_statuses`.`body` AS body, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`order_orders_statuses` `order_orders_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`order_orders_statuses`.`status_id`
												WHERE 		`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`public`='1' 
												AND 		`order_orders_statuses`.`public`='1' 
												ORDER BY 	CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC");

	while($row_order_status = $result_statuses->fetch_array(MYSQLI_ASSOC)){
		$list_status .= "						<tr>\n" . 
						"							<td align=\"center\"><span class=\"badge badge-pill\" style=\"background-color: " . $row_order_status['status_color'] . "\">" . $row_order_status['status_name'] . "</span></td>\n" . 
						"							<td>" . $row_order_status['template'] . "</td>\n" . 
						"						</tr>\n";
	}

	$list_status .= "					</table>\n" . 
					"				</div>\n";

	$data = array('list_status' => $list_status);

	echo json_encode($data);

}

// ------------------------------------------------------------------------

if(isset($_POST['get']) && $_POST['get'] == "admin" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_admin_maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'"), MYSQLI_ASSOC);

	$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `admin`.`id`='" . intval($row_admin_maindata['admin_id']) . "'"), MYSQLI_ASSOC);

	$data = array('emsg' => 'OK', 'row_admin' => $row_admin);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_user = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`user_users`.`id` AS id, 
																	`user_users`.`firstname` AS firstname, 
																	`user_users`.`lastname` AS lastname,  
																	`user_users`.`email` AS email,  
																	`user_users`.`user_number` AS user_number  
														FROM 		`user_users` 
														WHERE 		`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "' 
														AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'"), MYSQLI_ASSOC);

	$data = array('emsg' => 'OK', 'row_user' => $row_user);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_by_user" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user']) && strip_tags($_POST['user']) != "" && $_POST['url_password'] == $maindata['url_password']){

	$row_user = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`user_users`.`id` AS id, 
																	`user_users`.`user_number` AS user_number, 
																	`user_users`.`companyname` AS companyname, 
																	`user_users`.`firstname` AS firstname, 
																	`user_users`.`lastname` AS lastname, 
																	`user_users`.`email` AS email, 
																	`user_users`.`password` AS password 
														FROM 		`user_users` 
														WHERE 		`user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['user'])) . "' 
														AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
														AND 		`user_users`.`regverify`=1"), MYSQLI_ASSOC);

	$data = array('emsg' => 'OK', 'row_user' => $row_user, 'user_index' => $maindata['user_index']);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_order" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$data = array('emsg' => 'OK', 'row_order' => $row_order);

	echo json_encode($data);

}

if(isset($_POST['upload']) && $_POST['upload'] == "user_files" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$uploaddir = 'uploads/';

	$files = "";

	$emsg_files = "";

	if(isset($row_order['id'])){

		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

		for($j = 1;$j <= 5;$j++){

			if(isset($_FILES['file_' . $j]['tmp_name']) && $_FILES['file_' . $j]['tmp_name'] != ""){

				$ext = pathinfo($_FILES['file_' . $j]['name'], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$random = rand(1, 100000);
					$_FILES['file_' . $j]['name'] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES['file_' . $j]['name'])));
					move_uploaded_file($_FILES['file_' . $j]['tmp_name'], $uploaddir . "company/" . intval($_POST['company_id']) . "/order/" . $row_order['order_number'] . "/usaerdata/" . basename($random . '_' . $_FILES['file_' . $j]['name']));
					$files .= $files == "" ? $random . '_' . $_FILES['file_' . $j]['name'] : "\r\n" . $random . '_' . $_FILES['file_' . $j]['name'];
					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES['file_' . $j]['name']) . "'");
				}else{
					$emsg_files .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES['file_' . $j]['name'] . "</p>\n";
				}

			}

		}
	}

	if(isset($row_order['id']) && $emsg_files == "" && $files != ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, ($row_order['userdata'] == "" ? $files : $row_order['userdata'] . "\r\n" . $files)) . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

	}else{

		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['userdata_delete']) && $_POST['userdata_delete'] == "X" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		$files = "";

		$arr_files = explode("\r\n", $row_order['userdata']);

		$file_id = 0;
		$file_name = "";

		for($i = 0;$i < count($arr_files);$i++){
			if($i == intval($_POST['item'])){
				@unlink("uploads/company/" . intval($_POST['company_id']) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i]);
				$file_id = ($i + 1);
				$file_name = $arr_files[$i];
			}else{
				$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
			}
		}

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, $files) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_customer_message']) && $_POST['user_customer_message'] == "speichern" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		mysqli_query($conn, "	INSERT 	`order_orders_customer_messages` 
								SET 	`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_customer_messages`.`message`='" . mysqli_real_escape_string($conn, $_POST['message']) . "', 
										`order_orders_customer_messages`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$customer_messages_id = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Kundenhistory, Nachricht erstellt, ID [#" . $customer_messages_id . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Kundenhistory, Nachricht erstellt, ID [#" . $customer_messages_id . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");


		$data = array('emsg' => 'OK', 'customer_messages_id' => $customer_messages_id);

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_customer_history_delete']) && $_POST['user_customer_history_delete'] == "X" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		mysqli_query($conn, "	DELETE FROM `order_orders_customer_messages` 
								WHERE 		`order_orders_customer_messages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['customer_history_id'])) . "' 
								AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
								AND 		`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Kundenhistorie, Nachricht entfernt, ID [#" . intval($_POST['customer_history_id']) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Kundenhistorie, Nachricht entfernt, ID [#" . intval($_POST['customer_history_id']) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_history']) && $_POST['user_history'] == "speichern" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		mysqli_query($conn, "	INSERT 	`order_orders_history` 
								SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$history_id = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistory, Nachricht erstellt, ID [#" . $history_id . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistory, Nachricht erstellt, ID [#" . $history_id . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK', 'history_id' => $history_id);

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_history_status']) && $_POST['user_history_status'] == "speichern" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		mysqli_query($conn, "	UPDATE 	`order_orders_history` 
								SET 	`order_orders_history`.`status`='" . mysqli_real_escape_string($conn, intval($_POST['status'])) . "' 
								WHERE 	`order_orders_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['history_id'])) . "' 
								AND 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
								AND 	`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_history_delete']) && $_POST['user_history_delete'] == "X" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		mysqli_query($conn, "	DELETE FROM 	`order_orders_history` 
								WHERE 			`order_orders_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['history_id'])) . "' 
								AND 			`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
								AND 			`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$data = array('emsg' => 'OK');

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_orders_amount" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){


	$row_orders = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS amount FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "'"), MYSQLI_ASSOC);


	$data = array('emsg' => 'OK', 'row_orders' => $row_orders);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_order_archive" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$_POST["keyword"] = isset($_POST["keyword"]) && strip_tags($_POST["keyword"]) != "" ? strip_tags($_POST["keyword"]) : "";

	$where = 	isset($_POST["keyword"]) && $_POST["keyword"] != "" ? 
				"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`component` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`manufacturer` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`serial` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`fromthiscar` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `order_orders`.`mode`=1 " : " AND `order_orders`.`mode`=1 ";
	$and .= "AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "' ";
	$and .= isset($_POST["extra_search"]) && intval($_POST["extra_search"]) > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . mysqli_real_escape_string($conn, strip_tags($_POST["extra_search"])) : "";

	$query = 	"	SELECT 		`order_orders`.`id` AS id, 
								`order_orders`.`order_number` AS order_number, 
								`order_orders`.`companyname` AS companyname, 
								`order_orders`.`firstname` AS firstname, 
								`order_orders`.`lastname` AS lastname, 
								`order_orders`.`upd_date` AS time, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

								(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

								(SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS color 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

								(SELECT 	(SELECT `statuses`.`extra_search` AS extra_search FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS extra_search 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_extra_search, 

								`order_orders`.`admin_id` AS admin_id 
								
					FROM 		`order_orders` 
					" . $where . $and . " 
					AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
					ORDER BY 	" . mysqli_real_escape_string($conn, strip_tags($_POST['sorting_field_name'])) . " " . mysqli_real_escape_string($conn, strip_tags($_POST['sorting_direction_name']));

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

	$query .= " limit " . mysqli_real_escape_string($conn, intval($_POST['pos'])) . ", " . mysqli_real_escape_string($conn, intval($_POST['amount_rows']));

	$result = mysqli_query($conn, $query);

	$row_orders = array();

	if($rows > 0){

		while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

			$row_orders[] = $row_item;

		}

	}

	$data = array('emsg' => 'OK', 'rows' => $rows, 'row_orders' => $row_orders);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_order_orders" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$_POST["keyword"] = isset($_POST["keyword"]) && strip_tags($_POST["keyword"]) != "" ? strip_tags($_POST["keyword"]) : "";

	$where = 	isset($_POST["keyword"]) && $_POST["keyword"] != "" ? 
				"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`component` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`manufacturer` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`serial` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`fromthiscar` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%' 
				OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_POST["keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `order_orders`.`mode`=0 " : " AND `order_orders`.`mode`=0 ";
	$and .= "AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "' ";
	$and .= isset($_POST["extra_search"]) && intval($_POST["extra_search"]) > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . mysqli_real_escape_string($conn, intval($_POST["extra_search"])) : "";

	$query = 	"	SELECT 		`order_orders`.`id` AS id, 
								`order_orders`.`order_number` AS order_number, 
								`order_orders`.`companyname` AS companyname, 
								`order_orders`.`firstname` AS firstname, 
								`order_orders`.`lastname` AS lastname, 
								`order_orders`.`run_date` AS run_date, 
								`order_orders`.`reg_date` AS reg_date, 
								`order_orders`.`cpy_date` AS cpy_date, 
								`order_orders`.`upd_date` AS time, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

								(	SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

								(	SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS color 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

								(	SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id 
									FROM 	`order_orders_statuses` 
									WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
									AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
									ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_id, 

								`order_orders`.`admin_id` AS admin_id 
								
					FROM 		`order_orders` 
					" . $where . $and . " 
					AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
					ORDER BY 	" . mysqli_real_escape_string($conn, strip_tags($_POST['sorting_field_name'])) . " " . mysqli_real_escape_string($conn, strip_tags($_POST['sorting_direction_name']));

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

	$query .= " limit " . mysqli_real_escape_string($conn, intval($_POST['pos'])) . ", " . mysqli_real_escape_string($conn, intval($_POST['amount_rows']));

	$result = mysqli_query($conn, $query);

	$row_orders = array();

	if($rows > 0){

		while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

			$row_orders[] = $row_item;

		}

	}

	$data = array('emsg' => 'OK', 'rows' => $rows, 'row_orders' => $row_orders);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_statusses_order" && $_POST['url_password'] == $maindata['url_password']){

	$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`type`='1' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$row_statusses = array();

	while($row_item = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$row_statusses[] = $row_item;

	}

	$result_multi_statuses = mysqli_query($conn, "	SELECT 		* 
													FROM 		`statuses` 
													WHERE 		`statuses`.`type`='1' 
													AND 		`statuses`.`multi_status`='1' 
													AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
													ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$row_multi_statusses = array();

	while($row_item = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$row_multi_statusses[] = $row_item;

	}

	$data = array('emsg' => 'OK', 'row_statusses' => $row_statusses, 'row_multi_statusses' => $row_multi_statusses);

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_statusses_archive" && $_POST['url_password'] == $maindata['url_password']){

	$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`type`='1' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$row_statusses = array();

	while($row_item = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$row_statusses[] = $row_item;

	}

	$data = array('emsg' => 'OK', 'row_statusses' => $row_statusses);

	echo json_encode($data);

}

if(isset($_POST['user_save']) && $_POST['user_save'] == "speichern" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihr Name eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihr Zuname eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "' 
								WHERE 	`user_users`.`id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['user_id']) ? $_POST['user_id'] : 0)) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['company_id']) ? $_POST['company_id'] : 1)) . "'");

		$data = array('emsg' => 'OK');

		echo json_encode($data);

	}else{

		$data = array('emsg' => $emsg);

		echo json_encode($data);

	}

}

if(isset($_POST['user_edit_row_order']) && $_POST['user_edit_row_order'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
																	(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
																		FROM 	`order_orders_statuses` 
																		WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																		AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
																		ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST['user_id'])) . "' 
															AND 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id'])){

		$data = array('emsg' => 'OK', 'row_order' => $row_order);

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_shipments']) && $_POST['user_edit_row_shipments'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_shipments = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`id` AS id, 
															(
																SELECT 	name 
																FROM 	`admin` `admin` 
																WHERE 	`admin`.`id`=`order_orders_shipments`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
															) AS admin_name, 
															`order_orders_shipments`.`shipments_id` AS shipments_id, 
															`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
															`order_orders_shipments`.`label_url` AS label_url, 
															`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
															`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
															`order_orders_shipments`.`price` AS price, 
															`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
															`order_orders_shipments`.`carrier` AS carrier, 
															`order_orders_shipments`.`service` AS service, 
															`order_orders_shipments`.`reference_number` AS reference_number, 
															`order_orders_shipments`.`notification_email` AS notification_email, 
															`order_orders_shipments`.`component` AS component, 
															`order_orders_shipments`.`companyname` AS companyname, 
															`order_orders_shipments`.`firstname` AS firstname, 
															`order_orders_shipments`.`lastname` AS lastname, 
															`order_orders_shipments`.`street` AS street, 
															`order_orders_shipments`.`streetno` AS streetno, 
															`order_orders_shipments`.`zipcode` AS zipcode, 
															`order_orders_shipments`.`city` AS city, 
															`order_orders_shipments`.`country` AS country, 
															`order_orders_shipments`.`weight` AS weight, 
															`order_orders_shipments`.`length` AS length, 
															`order_orders_shipments`.`width` AS width, 
															`order_orders_shipments`.`height` AS height, 
															`order_orders_shipments`.`time` AS time 
												FROM 		`order_orders_shipments` `order_orders_shipments` 
												WHERE 		`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC");

	$row_shipments = array();

	while($row_shipments = $result_shipments->fetch_array(MYSQLI_ASSOC)){

		$row_shipments[] = $row_shipments;

	}

	$data = array('emsg' => 'OK', 'row_shipments' => $row_shipments);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_statuses']) && $_POST['user_edit_row_statuses'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_statuses = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS id, 
															`order_orders_statuses`.`status_number` AS status_number, 
															`order_orders_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`order_orders_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
															) AS admin_name, 
															`order_orders_statuses`.`template` AS template, 
															`order_orders_statuses`.`subject` AS subject, 
															`order_orders_statuses`.`body` AS body, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`order_orders_statuses` `order_orders_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`order_orders_statuses`.`status_id`
												WHERE 		`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												ORDER BY 	CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC");

	$row_statuses = array();

	while($row_statuses = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$row_statuses[] = $row_statuses;

	}

	$data = array('emsg' => 'OK', 'row_statuses' => $row_statuses);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_shipments_by_id']) && $_POST['user_edit_row_shipments_by_id'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_shipments = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`id` AS id, 
															(
																SELECT 	name 
																FROM 	`admin` `admin` 
																WHERE 	`admin`.`id`=`order_orders_shipments`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
															) AS admin_name, 
															`order_orders_shipments`.`shipments_id` AS shipments_id, 
															`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
															`order_orders_shipments`.`label_url` AS label_url, 
															`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
															`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
															`order_orders_shipments`.`price` AS price, 
															`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
															`order_orders_shipments`.`carrier` AS carrier, 
															`order_orders_shipments`.`service` AS service, 
															`order_orders_shipments`.`reference_number` AS reference_number, 
															`order_orders_shipments`.`notification_email` AS notification_email, 
															`order_orders_shipments`.`component` AS component, 
															`order_orders_shipments`.`companyname` AS companyname, 
															`order_orders_shipments`.`firstname` AS firstname, 
															`order_orders_shipments`.`lastname` AS lastname, 
															`order_orders_shipments`.`street` AS street, 
															`order_orders_shipments`.`streetno` AS streetno, 
															`order_orders_shipments`.`zipcode` AS zipcode, 
															`order_orders_shipments`.`city` AS city, 
															`order_orders_shipments`.`country` AS country, 
															`order_orders_shipments`.`weight` AS weight, 
															`order_orders_shipments`.`length` AS length, 
															`order_orders_shipments`.`width` AS width, 
															`order_orders_shipments`.`height` AS height, 
															`order_orders_shipments`.`time` AS time 
												FROM 		`order_orders_shipments` `order_orders_shipments` 
												WHERE 		`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_shipments`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['status_id'])) . "' 
												AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC");

	$row_shipments = array();

	while($row = $result_shipments->fetch_array(MYSQLI_ASSOC)){

		$row_shipments[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_shipments' => $row_shipments);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_customer_messages']) && $_POST['user_edit_row_customer_messages'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_customer_messages = mysqli_query($conn, "	SELECT 		`order_orders_customer_messages`.`id` AS id, 
																	(
																		SELECT 	name 
																		FROM 	`admin` `admin` 
																		WHERE 	`admin`.`id`=`order_orders_customer_messages`.`admin_id` 
																		AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
																	) AS admin_name, 
																	`order_orders_customer_messages`.`message` AS message, 
																	`order_orders_customer_messages`.`time` AS time 
														FROM 		`order_orders_customer_messages` `order_orders_customer_messages` 
														WHERE 		`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
														AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
														ORDER BY 	CAST(`order_orders_customer_messages`.`time` AS UNSIGNED) DESC");

	$row_customer_messages = array();

	while($row = $result_customer_messages->fetch_array(MYSQLI_ASSOC)){

		$row_customer_messages[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_customer_messages' => $row_customer_messages);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_history']) && $_POST['user_edit_row_history'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_history = mysqli_query($conn, "	SELECT 		`order_orders_history`.`id` AS id, 
														(
															SELECT 	name 
															FROM 	`admin` `admin` 
															WHERE 	`admin`.`id`=`order_orders_history`.`admin_id` 
															AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
														) AS admin_name, 
														`order_orders_history`.`message` AS message, 
														`order_orders_history`.`status` AS status, 
														`order_orders_history`.`time` AS time 
											FROM 		`order_orders_history` `order_orders_history` 
											WHERE 		`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
											ORDER BY 	CAST(`order_orders_history`.`time` AS UNSIGNED) DESC");

	$row_history = array();

	while($row = $result_history->fetch_array(MYSQLI_ASSOC)){

		$row_history[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_history' => $row_history);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_events']) && $_POST['user_edit_row_events'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_events = mysqli_query($conn, "	SELECT 		`order_orders_events`.`id` AS id, 
														(
															SELECT 	name 
															FROM 	`admin` `admin` 
															WHERE 	`admin`.`id`=`order_orders_events`.`admin_id` 
															AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
														) AS admin_name, 
														`order_orders_events`.`type` AS type, 
														`order_orders_events`.`message` AS message, 
														`order_orders_events`.`subject` AS subject, 
														`order_orders_events`.`body` AS body, 
														`order_orders_events`.`time` AS time 
											FROM 		`order_orders_events` `order_orders_events` 
											WHERE 		`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											AND 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
											ORDER BY 	CAST(`order_orders_events`.`time` AS UNSIGNED) DESC");

	$row_events = array();

	while($row = $result_events->fetch_array(MYSQLI_ASSOC)){

		$row_events[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_events' => $row_events);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_admins']) && $_POST['user_edit_row_admins'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_admins = mysqli_query($conn, "	SELECT 		* 
											FROM 		`admin` 
											WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
											ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	$row_admins = array();

	while($row = $result_admins->fetch_array(MYSQLI_ASSOC)){

		$row_admins[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_admins' => $row_admins);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_reasons']) && $_POST['user_edit_row_reasons'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_reasons = mysqli_query($conn, "	SELECT 		* 
											FROM 		`reasons` 
											WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
											ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	$row_reasons = array();

	while($row = $result_reasons->fetch_array(MYSQLI_ASSOC)){

		$row_reasons[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_reasons' => $row_reasons);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_countries']) && $_POST['user_edit_row_countries'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_countries = mysqli_query($conn, "	SELECT 		* 
												FROM 		`countries` 
												WHERE 		`countries`.`frontend`='1' 
												ORDER BY 	`countries`.`name` ASC");

	$row_countries = array();

	while($row = $result_countries->fetch_array(MYSQLI_ASSOC)){

		$row_countries[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_countries' => $row_countries);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_templates']) && $_POST['user_edit_row_templates'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_templates = mysqli_query($conn, "	SELECT 		`templates`.`id` AS id, 
															`templates`.`name` AS name 
												FROM 		`templates` 
												WHERE 		`templates`.`type`=1 
												AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['order_status_intern'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['order_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['shipping_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['shipping_cancel_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['interested_to_order_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['order_to_archive_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id='" . mysqli_real_escape_string($conn, intval($maindata['archive_to_order_status'])) . "') 
												ORDER BY 	CAST(`templates`.`id` AS UNSIGNED) ASC");

	$row_templates = array();

	while($row = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$row_templates[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_templates' => $row_templates);

	echo json_encode($data);

}

if(isset($_POST['user_edit_row_statuses_2']) && $_POST['user_edit_row_statuses_2'] == "ansehen" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['id']) && intval($_POST['id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$result_statuses = mysqli_query($conn, "	SELECT 		* 
												FROM 		`statuses` 
												WHERE 		`statuses`.`type`='1' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['order_status_intern'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['order_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['shipping_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['shipping_cancel_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['email_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['interested_to_order_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['order_to_archive_status'])) . " 
												AND 		`statuses`.`id`!=" . mysqli_real_escape_string($conn, intval($maindata['archive_to_order_status'])) . " 
												ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$row_statuses = array();

	while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$row_statuses[] = $row;

	}

	$data = array('emsg' => 'OK', 'row_statuses' => $row_statuses);

	echo json_encode($data);

}

if(isset($_POST['user_password_update']) && $_POST['user_password_update'] == "speichern" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && isset($_POST['user_id']) && intval($_POST['user_id']) > 0 && isset($_POST['password']) && $_POST['password'] != "" && $_POST['url_password'] == $maindata['url_password']){

	mysqli_query($conn, "	UPDATE 	`user_users` 
							SET 	`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($_POST['password'])) . "' 
							WHERE 	`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($_POST["user_id"])) . "' 
							AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

	$data = array('emsg' => 'OK');

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_by_email" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && strip_tags($_POST['email']) != "" && $_POST['url_password'] == $maindata['url_password']){

	$row_user = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		*
															FROM 		`user_users` 
															WHERE 		`user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['email'])) . "' 
															AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_user['id'])){

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$recoverhash = bin2hex(random_bytes(32));

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`recoverhash`='" . mysqli_real_escape_string($db->con, $recoverhash) . "' 
								WHERE 	`user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['email'])) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

		$message = "<p>Kennwort wiederherstellen? <a href=\"" . $domain . "/kunden/wiederherstellen/" . strip_tags($_POST['email']) . "/" . $recoverhash . "\" target=\"_blank\">Ja wiederherstellen!</a></p>\n";

		$row_template = array();

		$row_template['subject'] = "GZA motors - Kennwort wiederherstellen";

		$row_template['body'] = $message;

		$mail = new dbbMailer();

		$mail->host = $maindata['smtp_host'];
		$mail->username = $maindata['smtp_username'];
		$mail->password = $maindata['smtp_password'];
		$mail->secure = $maindata['smtp_secure'];
		$mail->port = intval($maindata['smtp_port']);
		$mail->charset = $maindata['smtp_charset'];

		$mail->setFrom($row_admin->email, strip_tags($row_template['from']));
		$mail->addAddress($row_user['email'], $row_user['firstname'] . " " . $row_user['lastname']);

		//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

		//$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

		$mail->subject = strip_tags($row_template['subject']);

		$mail->body = str_replace("[track]", "", $row_template['body']);

		if(!$mail->send()){

		}

		$data = array('emsg' => 'OK', 'row_user' => $row_user);

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['get']) && $_POST['get'] == "user_recover" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && strip_tags($_POST['email']) != "" && $_POST['url_password'] == $maindata['url_password']){

	$row_user = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		*
															FROM 		`user_users` 
															WHERE 		`user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['email'])) . "' 
															AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_user['id'])){

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$recoverhash = bin2hex(random_bytes(32));

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`recoverhash`='" . mysqli_real_escape_string($db->con, $recoverhash) . "' 
								WHERE 	`user_users`.`email`='" . mysqli_real_escape_string($db->con, strip_tags($_POST['email'])) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

		$message = "<p>Kennwort wiederherstellen? <a href=\"" . $domain . "/kunden/wiederherstellen/" . strip_tags($_POST['email']) . "/" . $recoverhash . "\" target=\"_blank\">Ja wiederherstellen!</a></p>\n";

		$row_template = array();

		$row_template['subject'] = "GZA motors - Kennwort wiederherstellen";

		$row_template['body'] = $message;

		$mail = new dbbMailer();

		$mail->host = $maindata['smtp_host'];
		$mail->username = $maindata['smtp_username'];
		$mail->password = $maindata['smtp_password'];
		$mail->secure = $maindata['smtp_secure'];
		$mail->port = intval($maindata['smtp_port']);
		$mail->charset = $maindata['smtp_charset'];

		$mail->setFrom($maindata['email'], strip_tags($row_template['from']));
		$mail->addAddress($row_user['email'], $row_user['firstname'] . " " . $row_user['lastname']);

		//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

		//$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

		$mail->subject = strip_tags($row_template['subject']);

		$mail->body = str_replace("[track]", "", $row_template['body']);

		if(!$mail->send()){

		}

		$data = array('emsg' => 'OK', 'row_user' => $row_user);

	}else{
	
		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

if(isset($_POST['user_save']) && $_POST['user_save'] == "REGISTRIEREN" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihren Namen eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihren Zunamen eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['email'])) . "' limit 0, 1"), MYSQLI_ASSOC);
		if(isset($exist_user['id'])){
			$emsg .= "<span class=\"error\">Ihre E-Mail-Adresse existiert bereits.</span><br />\n";
			$inp_email = " is-invalid";
		}else{
			$email = strip_tags($_POST['email']);
		}
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihre E-Mail-Adresse eingeben.</span><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['password']) < 1 || strlen($_POST['password']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password = " is-invalid";
	} else {
		$password = strip_tags($_POST['password']);
	}

	if(strlen($_POST['password2']) < 1 || strlen($_POST['password2']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort wiederholt eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password2 = " is-invalid";
	} else {
		if($_POST['password'] != $_POST['password2']){
			$emsg .= "<span class=\"error\">Bitte Ihr Kennwort wiederholt eingeben. Die beiden Kennwort eingaben sind unterschiedlich. (max. 128 Zeichen)</span><br />\n";
			$inp_password = " is-invalid";
			$inp_password2 = " is-invalid";
		}else{
			$password2 = strip_tags($_POST['password2']);
		}
	}

	if($emsg == ""){

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "'"), MYSQLI_ASSOC);

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$reghash = bin2hex(random_bytes(32));

		$time = time();

		$user_number = 0;

		while($user_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `user_users`.`user_number`='" . $random . "'");

			if($result->num_rows == 0){
				$user_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number, 0777);
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/audio/.htaccess");

		mysqli_query($conn, "INSERT 	`user_users` 
								SET 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`user_users`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`user_users`.`user_number`='" . mysqli_real_escape_string($conn, $user_number) . "', 
										`user_users`.`gender`='" . mysqli_real_escape_string($conn, (isset($_POST['gender']) ? intval($_POST['gender']) : 0)) . "', 
										`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`user_users`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($password)) . "', 
										`user_users`.`reghash`='" . mysqli_real_escape_string($conn, $reghash) . "', 
										`user_users`.`regverify`='0', 
										`user_users`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`user_users`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		mysqli_query($conn, "INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`user_users_events`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, "Kunde (Intern), erstellt, ID [#" . $_POST["id"]) . "]', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['user_status'])) . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		mysqli_query($conn, "	INSERT 	`user_users_statuses` 
								SET 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "', 
										`user_users_statuses`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`user_users_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`user_users_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`user_users_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`user_users_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $user_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[gender]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $email . "\">" . $email . "</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[verify_email_link]", "<a href=\"" . $domain . "/kunden/verifizieren/" . $reghash . "\">Ja, ich bestätige</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[password]", $password, $row_template[$fields[$j]]);

		}

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			/*$pdfdoc = $pdf->Output("", "S");*/
			$pdf_file = dirname(__FILE__) . "/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf";
			$file = fopen($pdf_file, 'rb');
			$pdfdoc = fread($file, filesize($pdf_file));
			fclose($file);

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

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

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

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

		$data = array('emsg' => 'OK', 'id' => $_POST['id']);

	}else{
	
		$data = array('emsg' => $emsg);

	}

	echo json_encode($data);

}

if(isset($_POST['user_check']) && $_POST['user_check'] == "VERIFY" && isset($_POST['company_id']) && intval($_POST['company_id']) > 0 && $_POST['url_password'] == $maindata['url_password']){

	$exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "' AND `user_users`.`reghash`='" . mysqli_real_escape_string($conn, strip_tags($param['hash'])) . "' limit 0, 1"), MYSQLI_ASSOC);

	if(isset($exist_user['id'])){

		mysqli_query($conn, "	UPDATE 	`user_users` 
								SET 	`user_users`.`regverify`='1', 
										`user_users`.`reghash`='' 
								WHERE 	`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($exist_user['id'])) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_POST['company_id'])) . "'");

		$data = array(
			'emsg' => 'OK', 
			'id' => $exist_user["id"], 
			'firstname' => $exist_user["firstname"], 
			'lastname' => $exist_user["lastname"], 
			'email' => $exist_user["email"]
		);

	}else{

		$data = array('emsg' => 'ERROR');

	}

	echo json_encode($data);

}

?>