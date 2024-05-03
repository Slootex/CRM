<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "shipping_sending";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . intval($_SESSION["admin"]["id"]) . "'"), MYSQLI_ASSOC);

$_SESSION["devices"] = isset($_SESSION["devices"]) && $_SESSION["devices"] != "" ? $_SESSION["devices"] : "";

$show_autocomplete_script = 1;

$countryToId = "";

$emsg = "";

$time = time();

$inp_from_address = "";

$inp_from_shortcut = "";
$inp_from_companyname = "";
$inp_from_gender = "";
$inp_from_firstname = "";
$inp_from_lastname = "";
$inp_from_street = "";
$inp_from_streetno = "";
$inp_from_zipcode = "";
$inp_from_city = "";
$inp_from_country = "";
$inp_from_phonenumber = "";
$inp_from_mobilnumber = "";
$inp_from_email = "";

$inp_from_mail = "";

$inp_to_address = "";

$inp_to_shortcut = "";
$inp_to_companyname = "";
$inp_to_gender = "";
$inp_to_firstname = "";
$inp_to_lastname = "";
$inp_to_street = "";
$inp_to_streetno = "";
$inp_to_zipcode = "";
$inp_to_city = "";
$inp_to_country = "";
$inp_to_phonenumber = "";
$inp_to_mobilnumber = "";
$inp_to_email = "";

$inp_to_mail = "";

$inp_carriers_service = "";

$inp_radio_payment = "";
$inp_amount = "";
$inp_radio_saturday = "";
$inp_mail_with_pdf = "";

$inp_package_template = "";

$inp_length = "";
$inp_width = "";
$inp_height = "";
$inp_weight = "";

$inp_description = "";

$from_address = intval(isset($_POST['from_address']) ? $_POST['from_address'] : $row_admin['address_from']);

$from_shortcut = "";
$from_companyname = "";
$from_gender = 0;
$from_firstname = "";
$from_lastname = "";
$from_street = "";
$from_streetno = "";
$from_zipcode = "";
$from_city = "";
$from_country = 0;
$from_phonenumber = "";
$from_mobilnumber = "";
$from_email = "";

$from_mail = 0;

$to_address = intval(isset($_POST['to_address']) ? $_POST['to_address'] : $row_admin['address_to']);

$to_shortcut = "";
$to_companyname = "";
$to_gender = 0;
$to_firstname = "";
$to_lastname = "";
$to_street = "";
$to_streetno = "";
$to_zipcode = "";
$to_city = "";
$to_country = 0;
$to_phonenumber = "";
$to_mobilnumber = "";
$to_email = "";

$to_mail = 0;

$carriers_service = "11";

$radio_payment = 0;
$amount = 0.00;
$radio_saturday = 0;
$mail_with_pdf = 0;

$package_template = $maindata['package'];

$length = 0;
$width = 0;
$height = 0;
$weight = 0.0;

$description = "Steuergerät";

$html_new_shipping_result = "";

$order_number = "<strong class=\"text-warning\">Kein Auftrag gewählt!</strong>";

if(isset($_POST['devices']) && $_POST['devices'] == "add"){

	if(isset($_POST['order_id']) && intval($_POST['order_id']) > 0){

		$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
													`order_orders_devices`.`device_number` AS device_number, 
													`order_orders_devices`.`atot_mode` AS atot_mode, 
													`order_orders_devices`.`at` AS at, 
													`order_orders_devices`.`ot` AS ot 
										FROM 		`order_orders_devices` `order_orders_devices` 
										WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
										AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`order_orders_devices`.`storage_space_id`>'0' 
										AND 		`order_orders_devices`.`is_send`='0' 
										ORDER BY 	`order_orders_devices`.`device_number` ASC");

		while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

			if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1 && !strpos($_SESSION["devices"], $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")))){

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_devices`.`is_shipping_extern`='1', 
												`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				$_SESSION["devices"] .= $_SESSION["devices"] == "" ? $row_device['id'] . ":" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) : "," . $row_device['id'] . ":" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""));

			}

		}

	}

}

if(isset($_POST['device_delete']) && $_POST['device_delete'] == "entfernen"){

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`is_shipping_extern`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['device_id']) ? $_POST['device_id'] : 0)) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$new_devices = "";

	$arr_devices = explode(",", $_SESSION["devices"]);

	for($i = 0;$i < count($arr_devices);$i++){

		$arr_device = explode(":", $arr_devices[$i]);

		if($arr_device[0] != intval($_POST['device_id'])){

			$new_devices .= $new_devices == "" ? $arr_device[0] . ":" . $arr_device[1] : "," . $arr_device[0] . ":" . $arr_device[1];

		}

	}

	$_SESSION["devices"] = $new_devices;

}

if(isset($_POST['update']) && $_POST['update'] == "aktualisieren"){

	if(strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['from_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_from_mail = " is-invalid";
	} else {
		$from_mail = intval($_POST['from_mail']);
	}

	if(strlen($_POST['to_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Adresse aus.</small><br />\n";
		$inp_to_address = " is-invalid";
	} else {
		$to_address = intval($_POST['to_address']);
	}

	if(strlen($_POST['to_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Empfänger-E-Mail versendet werden soll.</small><br />\n";
		$inp_to_mail = " is-invalid";
	} else {
		$to_mail = intval($_POST['to_mail']);
	}

	if(strlen($_POST['description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
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

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}

	if($emsg == ""){

	}

}

if(isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren"){

	if(strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['from_shortcut']) < 1 || strlen($_POST['from_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Absender-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_shortcut = " is-invalid";
	} else {
		$from_shortcut = strip_tags($_POST['from_shortcut']);
	}

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Anrede aus. </small><br />\n";
		$inp_from_gender = " is-invalid";
	} else {
		$from_gender = intval($_POST['from_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
	} else {
		$from_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_mobilnumber']));
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
	} else {
		$from_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_phonenumber']));
	}

	if(strlen($_POST['from_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_from_mail = " is-invalid";
	} else {
		$from_mail = intval($_POST['from_mail']);
	}


	if(strlen($_POST['to_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Adresse aus.</small><br />\n";
		$inp_to_address = " is-invalid";
	} else {
		$to_address = intval($_POST['to_address']);
	}

	if(strlen($_POST['to_shortcut']) < 1 || strlen($_POST['to_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Empfänger-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_shortcut = " is-invalid";
	} else {
		$to_shortcut = strip_tags($_POST['to_shortcut']);
	}

	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Anrede aus. </small><br />\n";
		$inp_to_gender = " is-invalid";
	} else {
		$to_gender = intval($_POST['to_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
	} else {
		$to_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_mobilnumber']));
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
	} else {
		$to_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_phonenumber']));
	}

	if(strlen($_POST['to_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Empfänger-E-Mail versendet werden soll.</small><br />\n";
		$inp_to_mail = " is-invalid";
	} else {
		$to_mail = intval($_POST['to_mail']);
	}


	if(strlen($_POST['description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
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

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}

	if($emsg == ""){

	}

}

if(isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sofort Senden"){

	if(strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['from_shortcut']) < 1 || strlen($_POST['from_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Absender-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_shortcut = " is-invalid";
	} else {
		$from_shortcut = strip_tags($_POST['from_shortcut']);
	}

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Anrede aus. </small><br />\n";
		$inp_from_gender = " is-invalid";
	} else {
		$from_gender = intval($_POST['from_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
	} else {
		$from_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_mobilnumber']));
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
	} else {
		$from_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_phonenumber']));
	}

	if(strlen($_POST['from_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_from_mail = " is-invalid";
	} else {
		$from_mail = intval($_POST['from_mail']);
	}


	if(strlen($_POST['to_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Adresse aus.</small><br />\n";
		$inp_to_address = " is-invalid";
	} else {
		$to_address = intval($_POST['to_address']);
	}

	if(strlen($_POST['to_shortcut']) < 1 || strlen($_POST['to_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Empfänger-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_shortcut = " is-invalid";
	} else {
		$to_shortcut = strip_tags($_POST['to_shortcut']);
	}

	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Anrede aus. </small><br />\n";
		$inp_to_gender = " is-invalid";
	} else {
		$to_gender = intval($_POST['to_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
	} else {
		$to_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_mobilnumber']));
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
	} else {
		$to_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_phonenumber']));
	}

	if(strlen($_POST['to_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Empfänger-E-Mail versendet werden soll.</small><br />\n";
		$inp_to_mail = " is-invalid";
	} else {
		$to_mail = intval($_POST['to_mail']);
	}


	if(strlen($_POST['description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
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

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}


	if($emsg == ""){

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $from_country . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $to_country . "'"), MYSQLI_ASSOC);

		$carriers_services = array(
			'11' => 'UPS Standard', 
			'65' => 'UPS Saver'
		);

		$saturday_delivery = array();

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}

		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}

		$data = array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => $description, 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => '' . ($from_companyname != "" ? $from_companyname : $maindata['company']), 
						'TaxIdentificationNumber' => '456999', 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => $to_firstname . ' ' . $to_lastname, 
						'AttentionName' => $to_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => $from_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'GZA Motors - Sendung', 
							'ReferenceNumber' => array(
								'Value' => $description, 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height 
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . $weight
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}

		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

		$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments?additionaladdressvalidation=city');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
				'Password: ' . $maindata['ups_password'],
				'Content-Type: application/json',
				'transId: ' . $_SESSION["admin"]["id"] . $time,
				'transactionSrc: ' . $domain,
				'Username: ' . $maindata['ups_username'],
				'Accept: application/json',
				'Content-Length: ' . strlen($data_string)
			)
		);

		$result = curl_exec($ch);

		$response = json_decode($result);

		sleep($maindata['sleep_shipping_label']);

		if(!isset($response->response->errors[0])){

			$data = array(
				'LabelRecoveryRequest' => array(
					'LabelSpecification' => array(
						'HTTPUserAgent' => strip_tags($_SERVER['HTTP_USER_AGENT']), 
						'LabelImageFormat' => array(
							'Code' => 'GIF'
						), 
		/*					'LabelStockSize' => array(
							'Height' => '6', 
							'Width' => '4'
						)*/
					), 
					'Translate' => array(
						'LanguageCode' => 'deu', 
						'DialectCode' => '97', 
						'Code' => '01'
					), 
					'LabelDelivery' => array(
						'LabelLinkIndicator' => '', 
						'ResendEMailIndicator' => '', 
						'EMailMessage' => array(
							'EMailAddress' => $from_email
						)
					), 
					'TrackingNumber' => $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ''
				)
			);

			$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

			$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/labels');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
					'Password: ' . $maindata['ups_password'],
					'Content-Type: application/json',
					'Username: ' . $maindata['ups_username'],
					'Accept: application/json',
					'Content-Length: ' . strlen($data_string)
				)
			);

			$result = curl_exec($ch);

			$response_label = json_decode($result);

			if(!isset($response_label->response->errors[0])){

				$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . $maindata['new_shipping_status'] . "'"), MYSQLI_ASSOC);
				$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . $row_status['email_template'] . "'"), MYSQLI_ASSOC);

				$row_template['body'] .= $row_admin['email_signature'];

				mysqli_query($conn, "	INSERT 	`shipping_history` 
										SET 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`shipping_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shipping_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
												`shipping_history`.`devices`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION["devices"])) . "', 
												`shipping_history`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`shipping_history`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`shipping_history`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)) . "', 
												`shipping_history`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage)) . "', 
												`shipping_history`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) . "', 
												`shipping_history`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, number_format($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue, 2, '.', '')) . "', 
												`shipping_history`.`carrier`='UPS', 
												`shipping_history`.`service`='" . mysqli_real_escape_string($conn, $carriers_service) . "', 

												`shipping_history`.`from_shortcut`='" . mysqli_real_escape_string($conn, $from_shortcut) . "', 
												`shipping_history`.`from_companyname`='" . mysqli_real_escape_string($conn, $from_companyname) . "', 
												`shipping_history`.`from_gender`='" . mysqli_real_escape_string($conn, $from_gender) . "', 
												`shipping_history`.`from_firstname`='" . mysqli_real_escape_string($conn, $from_firstname) . "', 
												`shipping_history`.`from_lastname`='" . mysqli_real_escape_string($conn, $from_lastname) . "', 
												`shipping_history`.`from_street`='" . mysqli_real_escape_string($conn, $from_street) . "', 
												`shipping_history`.`from_streetno`='" . mysqli_real_escape_string($conn, $from_streetno) . "', 
												`shipping_history`.`from_zipcode`='" . mysqli_real_escape_string($conn, $from_zipcode) . "', 
												`shipping_history`.`from_city`='" . mysqli_real_escape_string($conn, $from_city) . "', 
												`shipping_history`.`from_country`='" . mysqli_real_escape_string($conn, $from_country) . "', 
												`shipping_history`.`from_email`='" . mysqli_real_escape_string($conn, $from_email) . "', 
												`shipping_history`.`from_phonenumber`='" . mysqli_real_escape_string($conn, $from_phonenumber) . "', 
												`shipping_history`.`from_mobilnumber`='" . mysqli_real_escape_string($conn, $from_mobilnumber) . "', 

												`shipping_history`.`to_shortcut`='" . mysqli_real_escape_string($conn, $to_shortcut) . "', 
												`shipping_history`.`to_companyname`='" . mysqli_real_escape_string($conn, $to_companyname) . "', 
												`shipping_history`.`to_gender`='" . mysqli_real_escape_string($conn, $to_gender) . "', 
												`shipping_history`.`to_firstname`='" . mysqli_real_escape_string($conn, $to_firstname) . "', 
												`shipping_history`.`to_lastname`='" . mysqli_real_escape_string($conn, $to_lastname) . "', 
												`shipping_history`.`to_street`='" . mysqli_real_escape_string($conn, $to_street) . "', 
												`shipping_history`.`to_streetno`='" . mysqli_real_escape_string($conn, $to_streetno) . "', 
												`shipping_history`.`to_zipcode`='" . mysqli_real_escape_string($conn, $to_zipcode) . "', 
												`shipping_history`.`to_city`='" . mysqli_real_escape_string($conn, $to_city) . "', 
												`shipping_history`.`to_country`='" . mysqli_real_escape_string($conn, $to_country) . "', 
												`shipping_history`.`to_email`='" . mysqli_real_escape_string($conn, $to_email) . "', 
												`shipping_history`.`to_phonenumber`='" . mysqli_real_escape_string($conn, $to_phonenumber) . "', 
												`shipping_history`.`to_mobilnumber`='" . mysqli_real_escape_string($conn, $to_mobilnumber) . "', 

												`shipping_history`.`weight`='" . mysqli_real_escape_string($conn, number_format($weight, 1, '.', '')) . "', 
												`shipping_history`.`length`='" . mysqli_real_escape_string($conn, intval($length)) . "', 
												`shipping_history`.`width`='" . mysqli_real_escape_string($conn, intval($width)) . "', 
												`shipping_history`.`height`='" . mysqli_real_escape_string($conn, intval($height)) . "', 

												`shipping_history`.`radio_payment`='" . mysqli_real_escape_string($conn, $radio_payment) . "', 
												`shipping_history`.`amount`='" . mysqli_real_escape_string($conn, $amount) . "', 
												`shipping_history`.`radio_saturday`='" . mysqli_real_escape_string($conn, $radio_saturday) . "', 
												`shipping_history`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 

												`shipping_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_SESSION["shipments"]["id"] = $conn->insert_id;

				$arr_order_devices = array();

				$arr_od_key_val = explode(",", $_SESSION["devices"]);

				for($od = 0;$od < count($arr_od_key_val);$od++){

					$arr_od_k_v = explode(":", $arr_od_key_val[$od]);

					$arr_device = explode("-", $arr_od_k_v[1]);

					if(!isset($arr_order_devices[$arr_device[0]])){

						$arr_order_devices[$arr_device[0]] = array();

					}

					$arr_order_devices[$arr_device[0]][] = $arr_od_k_v[0];

				}

				foreach($arr_order_devices as $key => $val){

					$r_o = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($key)) . "'"), MYSQLI_ASSOC);

					$status_field = "";

					if($r_o['mode'] < 2){

						$order_name = "Auftrag";

						$order_table = "order_orders";

						$order_id_field = "order_id";

						$status_field = "order_packing_technic_status";

					}else{

						$order_name = "Interessent";

						$order_table = "interested_interesteds";

						$order_id_field = "interested_id";

						$status_field = "interested_packing_technic_status";

					}

					$packing_number = 0;

					while($packing_number == 0){

						$random = rand(100001, 999999);

						$result = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`packing_number`='" . $random . "'");

						if($result->num_rows == 0){

							$packing_number = $random;

						}

					}

					mysqli_query($conn, "	INSERT 	`packing_packings` 
											SET 	`packing_packings`.`mode`='1', 
													`packing_packings`.`type`='5', 
													`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`packing_packings`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`packing_packings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`packing_packings`.`packing_number`='" . mysqli_real_escape_string($conn, $packing_number) . "', 
													`packing_packings`.`order_number`='" . mysqli_real_escape_string($conn, $r_o['order_number']) . "', 
													`packing_packings`.`order_id`='" . mysqli_real_escape_string($conn, $r_o['id']) . "', 
													`packing_packings`.`address_id`='" . mysqli_real_escape_string($conn, intval($to_address)) . "', 
													`packing_packings`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
													`packing_packings`.`gender`='" . mysqli_real_escape_string($conn, $gender) . "', 
													`packing_packings`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
													`packing_packings`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
													`packing_packings`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
													`packing_packings`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
													`packing_packings`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
													`packing_packings`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
													`packing_packings`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
													`packing_packings`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
													`packing_packings`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
													`packing_packings`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
													`packing_packings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_POST['radio_payment'])) . "', 
													`packing_packings`.`amount`='" . mysqli_real_escape_string($conn, number_format($_POST['amount'], 2, '.', '')) . "', 
													`packing_packings`.`carriers_service`='" . mysqli_real_escape_string($conn, intval($_POST['carriers_service'])) . "', 
													`packing_packings`.`weight`='" . mysqli_real_escape_string($conn, $_POST['weight']) . "', 
													`packing_packings`.`length`='" . mysqli_real_escape_string($conn, $_POST['length']) . "', 
													`packing_packings`.`width`='" . mysqli_real_escape_string($conn, $_POST['width']) . "', 
													`packing_packings`.`height`='" . mysqli_real_escape_string($conn, $_POST['height']) . "', 
													`packing_packings`.`message`='', 
													`packing_packings`.`file1`='0', 
													`packing_packings`.`file2`='0', 
													`packing_packings`.`order_extended_items`='', 
													`packing_packings`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_POST["packing_id"] = $conn->insert_id;

					$devices = "";

					for($od = 0;$od < count($arr_order_devices[$key]);$od++){

						$r_d = mysqli_fetch_array(mysqli_query($conn, "	SELECT		*, 
																					(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
																		FROM		`order_orders_devices` 
																		WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "'"), MYSQLI_ASSOC);

						$devices .= $devices == "" ? $r_d['id'] . ":" . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) : "," . $r_d['id'] . ":" . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : ""));

						if($r_d['storage_space_id'] > 0){

							mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");

							mysqli_query($conn, "	INSERT 	`order_orders_events` 
													SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
															`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Daten geändert, Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . intval($arr_order_devices[$key][$od]) . "]") . "', 
															`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Daten geändert, Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . intval($arr_order_devices[$key][$od]) . "]") . "', 
															`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
															`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

							mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
													SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
															`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . $arr_order_devices[$key][$od] . "]</span>") . "', 
															`order_orders_devices_events`.`subject`='', 
															`order_orders_devices_events`.`body`='', 
															`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

							mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
													SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices`.`storage_space_id`='0', 
															`order_orders_devices`.`storage_space_owner`='0', 
															`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
															`order_orders_devices`.`is_shipping_technic`='0', 
															`order_orders_devices`.`is_send`='1', 
															`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
													WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "' 
													AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

						}

						mysqli_query($conn, "	INSERT 	`packing_packings_devices` 
												SET 	`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`packing_packings_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
														`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["packing_id"])) . "', 
														`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "', 
														`packing_packings_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($r_d['device_number'])) . "'");

					}

					$r_s = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$status_field])) . "'"), MYSQLI_ASSOC);
					$r_t = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($r_s['email_template'])) . "'"), MYSQLI_ASSOC);


					$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
											SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
													`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($r_s['id'])) . "', 
													`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $r_t['name']) . "', 
													`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
													`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
													`" . $order_table . "_statuses`.`public`='1', 
													`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_SESSION["status"]["id"] = $conn->insert_id;

					mysqli_query($conn, "	INSERT 	`order_orders_shipments` 
											SET 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_shipments`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`order_orders_shipments`.`status_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["status"]["id"])) . "', 
													`order_orders_shipments`.`devices`='" . mysqli_real_escape_string($conn, strip_tags($devices)) . "', 
													`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
													`order_orders_shipments`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
													`order_orders_shipments`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)) . "', 
													`order_orders_shipments`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage)) . "', 
													`order_orders_shipments`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) . "', 
													`order_orders_shipments`.`price`='" . mysqli_real_escape_string($conn, $amount) . "', 
													`order_orders_shipments`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, number_format(($amount + $saturday_costs[$radio_saturday] + $carriers_services_costs[$_POST['carriers_service']] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, '.', '')) . "', 
													`order_orders_shipments`.`carrier`='UPS', 
													`order_orders_shipments`.`service`='" . mysqli_real_escape_string($conn, $_POST['carriers_service']) . "', 
													`order_orders_shipments`.`reference_number`='" . mysqli_real_escape_string($conn, $r_o['order_number']) . "', 
													`order_orders_shipments`.`notification_email`='" . mysqli_real_escape_string($conn, $maindata['email']) . "', 
													`order_orders_shipments`.`component`='0', 
													`order_orders_shipments`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
													`order_orders_shipments`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
													`order_orders_shipments`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
													`order_orders_shipments`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
													`order_orders_shipments`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
													`order_orders_shipments`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
													`order_orders_shipments`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
													`order_orders_shipments`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
													`order_orders_shipments`.`weight`='" . mysqli_real_escape_string($conn, $_POST['weight']) . "', 
													`order_orders_shipments`.`length`='" . mysqli_real_escape_string($conn, $_POST['length']) . "', 
													`order_orders_shipments`.`width`='" . mysqli_real_escape_string($conn, $_POST['width']) . "', 
													`order_orders_shipments`.`height`='" . mysqli_real_escape_string($conn, $_POST['height']) . "', 
													`order_orders_shipments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_SESSION["shipments"]["id"] = $conn->insert_id;

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
											SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
													`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Sendung durchgeführt, ID [#" . $_SESSION["shipments"]["id"]) . "]', 
													`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
											SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, $r_s['name'] . " - Die Sendung " . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . " wurde an den Kunden versendet.") . "', 
													`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
		
					$_SESSION["history"]["id"] = $conn->insert_id;
		
					mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
											SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
													`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
													`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
													`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $r_s['name']) . "', 
													`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
				}

				$fields = array('subject', 'body', 'admin_mail_subject');

				for($j = 0;$j < count($fields);$j++){

					$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[label_url]", "<a href=\"" . strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[shipments_id]", strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber), $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[tracking_url]", "<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . "&loc=de_DE\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[print_label]", "<a href=\"" . $domain . "/versendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[id]", $_SESSION["shipments"]["id"], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[description]", $description, $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[from_gender]", ($from_gender == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_sexual]", ($from_gender == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_companyname]", $from_companyname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_firstname]", $from_firstname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_lastname]", $from_lastname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_street]", $from_street, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_streetno]", $from_streetno, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_zipcode]", $from_zipcode, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_city]", $from_city, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_country]", $row_from_country['name'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_phonenumber]", $from_phonenumber, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_mobilnumber]", $from_mobilnumber, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_email]", "<a href=\"mailto: " . $from_email . "\">" . $from_email . "</a>\n", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[to_gender]", ($to_gender == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_sexual]", ($to_gender == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_companyname]", $to_companyname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_firstname]", $to_firstname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_lastname]", $to_lastname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_street]", $to_street, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_streetno]", $to_streetno, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_zipcode]", $to_zipcode, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_city]", $to_city, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_country]", $row_to_country['name'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_phonenumber]", $to_phonenumber, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_mobilnumber]", $to_mobilnumber, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_email]", "<a href=\"mailto: " . $to_email . "\">" . $to_email . "</a>\n", $row_template[$fields[$j]]);

					$radio_radio_shipping = array(	"11" => "UPS Standard", 
													"65" => "UPS Saver");
					$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$carriers_service], $row_template[$fields[$j]]);
					$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
													1 => "Nachnahme", 
													2 => "Bar");
					$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$radio_payment], $row_template[$fields[$j]]);
					if($radio_radio_payment[$radio_payment] == 1){
						$row_template[$fields[$j]] = str_replace("[amount]", "<strong><u>Kosten</u></strong> <table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td>Betrag: </td><td>" . number_format($amount, 2, ',', '') . " &euro;</td></tr><tr><td>Versand: </td><td>" . number_format($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue, 2, ',', '') . " &euro;</td></tr><tr><td>Gesamt: </td><td><u>" . number_format(($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue + $amount), 2, ',', '') . " &euro;</u></td></tr></table><br>", $row_template[$fields[$j]]);
					}else{
						$row_template[$fields[$j]] = str_replace("[amount]", "<strong><u>Kosten</u></strong> <table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td>Versand: </td><td>" . number_format($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue, 2, ',', '') . " &euro;</td></tr><tr><td>Gesamt: </td><td><u>" . number_format(($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue), 2, ',', '') . " &euro;</u></td></tr></table><br>", $row_template[$fields[$j]]);
					}
					$radio_radio_saturday = array(	0 => "Nein", 
													1 => "Ja");
					$row_template[$fields[$j]] = str_replace("[radio_saturday]", $radio_radio_saturday[$radio_saturday], $row_template[$fields[$j]]);

				}

				if($mail_with_pdf == 1){

					$filename = "begleitschein.pdf";

					$pdf = new Fpdi();

					$pdf->AddPage();

					require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

					$pdfdoc = $pdf->Output("", "S");

					if($from_mail == 1){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($from_email, $from_firstname . " " . $from_lastname);

						//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

						$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", "", $row_template['body']);

						if(!$mail->send()){
							$emsg .= "<p>Das versenden der E-Mail an den Absender wurde abgebrochen!</p>\n";
						}else{
							$emsg .= "<p>E-Mail an den Absender gesendet.</p>";
						}

					}

					if($to_mail == 1){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($to_email, $to_firstname . " " . $to_lastname);

						//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

						$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", "", $row_template['body']);

						if(!$mail->send()){
							$emsg .= "<p>Das versenden der E-Mail an den Empfänger wurde abgebrochen!</p>\n";
						}else{
							$emsg .= "<p>E-Mail an den Empfänger gesendet.</p>";
						}

					}

				}else{

					if($from_mail == 1){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($from_email, $from_firstname . " " . $from_lastname);

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", "", $row_template['body']);

						if(!$mail->send()){
							$emsg .= "<p>Das versenden der E-Mail an den Absender wurde abgebrochen!</p>\n";
						}else{
							$emsg .= "<p>E-Mail an den Absender gesendet.</p>";
						}

					}

					if($to_mail == 1){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($to_email, $to_firstname . " " . $to_lastname);

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", "", $row_template['body']);

						if(!$mail->send()){
							$emsg .= "<p>Das versenden der E-Mail an den Empfänger wurde abgebrochen!</p>\n";
						}else{
							$emsg .= "<p>E-Mail an den Empfänger gesendet.</p>";
						}

					}

				}

				$html_new_shipping_result = 	"					<div class=\"form-group row\">\n" . 
												"						<div class=\"col-12\">\n" . 
												"							<strong class=\"text-success\">\n" . 
												" 								Die Sendung wurde durchgeführt!\n" . 
												"							</strong><br />\n" . 
												"							<span>Sendungsnummer:</span> <u>" . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . "</u>\n" . 
												"						</div>\n" . 
												"					</div>\n";

	/*			if(isset($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)){
					$html_new_shipping_result .= 	"<script>\n" . 
													"window.open(\"" . $response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL . "\", \"Label_URL\", \"titlebar=1,menubar=1,toolbar=1,bookmarks=1,resizable=1,scrollbars=1,status=1\");\n" . 
													"</script>\n";
				}*/

				if(isset($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame').print();}else{document.getElementById('label_frame').contentWindow.print();}\">drucken <i class=\"fa fa-print\"> </i></button><br />\n" . 
													"<iframe src=\"/versendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . "\" id=\"label_frame\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
													"<script>\n" . 
													"var labelWindow = document.getElementById('label_frame');\n" . 
													"setTimeout(function(){\n" . 
													"	if(navigator.appName == 'Microsoft Internet Explorer'){\n" . 
													"		labelWindow.print();\n" . 
													"	}else{\n" . 
													"		labelWindow.contentWindow.print();\n" . 
													"	}\n" . 
													"}, 2000);\n" . 
													"</script>\n";
				}

	/*			if(isset($shipment->tracking_url)){
					$html_new_shipping_result .= 	"<script>\n" . 
													"window.open(\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . "&loc=de_DE\", \"tracking\", \"titlebar=1,menubar=1,toolbar=1,bookmarks=1,resizable=1,scrollbars=1,status=1\");\n" . 
													"</script>\n";
				}*/

				$emsg .= "<p>Die Sendung wurden erfolgreich durchgeführt!</p>\n";

				$_SESSION['devices'] = "";

			}else{

				$emsg .= isset($response_label->response->errors[0]) ? "<small class=\"error bg-danger text-white\">" . $response_label->response->errors[0]->message . "</small><br />\n" : "";

			}

		}else{
	
			$emsg = isset($response->response->errors[0]) ? "<small class=\"error bg-danger text-white\">" . $response->response->errors[0]->message . "</small><br />\n" : "";

		}

	}

}

if(isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Geräte an Packtisch senden"){

	if(strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['from_shortcut']) < 1 || strlen($_POST['from_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Absender-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_shortcut = " is-invalid";
	} else {
		$from_shortcut = strip_tags($_POST['from_shortcut']);
	}

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Anrede aus. </small><br />\n";
		$inp_from_gender = " is-invalid";
	} else {
		$from_gender = intval($_POST['from_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
	} else {
		$from_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_mobilnumber']));
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
	} else {
		$from_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_phonenumber']));
	}

	if(strlen($_POST['from_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_from_mail = " is-invalid";
	} else {
		$from_mail = intval($_POST['from_mail']);
	}


	if(strlen($_POST['to_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Adresse aus.</small><br />\n";
		$inp_to_address = " is-invalid";
	} else {
		$to_address = intval($_POST['to_address']);
	}

	if(strlen($_POST['to_shortcut']) < 1 || strlen($_POST['to_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Empfänger-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_shortcut = " is-invalid";
	} else {
		$to_shortcut = strip_tags($_POST['to_shortcut']);
	}

	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Anrede aus. </small><br />\n";
		$inp_to_gender = " is-invalid";
	} else {
		$to_gender = intval($_POST['to_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
	} else {
		$to_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_mobilnumber']));
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
	} else {
		$to_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_phonenumber']));
	}

	if(strlen($_POST['to_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Empfänger-E-Mail versendet werden soll.</small><br />\n";
		$inp_to_mail = " is-invalid";
	} else {
		$to_mail = intval($_POST['to_mail']);
	}


	if(strlen($_POST['description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
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

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}

	if($emsg == ""){

		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $from_country . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $to_country . "'"), MYSQLI_ASSOC);

		$arr_order_devices = array();

		$arr_od_key_val = explode(",", $_SESSION["devices"]);

		for($od = 0;$od < count($arr_od_key_val);$od++){

			$arr_od_k_v = explode(":", $arr_od_key_val[$od]);

			$arr_device = explode("-", $arr_od_k_v[1]);

			if(!isset($arr_order_devices[$arr_device[0]])){

				$arr_order_devices[$arr_device[0]] = array();

			}

			$arr_order_devices[$arr_device[0]][] = $arr_od_k_v[0];

		}

		foreach($arr_order_devices as $key => $val){

			$r_o = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($key)) . "'"), MYSQLI_ASSOC);

			$status_field = "";

			if($r_o['mode'] < 2){

				$order_name = "Auftrag";

				$order_table = "order_orders";

				$order_id_field = "order_id";

				$status_field = "order_packing_technic_status";

			}else{

				$order_name = "Interessent";

				$order_table = "interested_interesteds";

				$order_id_field = "interested_id";

				$status_field = "interested_packing_technic_status";

			}

			$packing_number = 0;

			while($packing_number == 0){

				$random = rand(100001, 999999);

				$result = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`packing_number`='" . $random . "'");

				if($result->num_rows == 0){

					$packing_number = $random;

				}

			}

			mysqli_query($conn, "	INSERT 	`packing_packings` 
									SET 	`packing_packings`.`mode`='0', 
											`packing_packings`.`type`='5', 
											`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`packing_packings`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`packing_packings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`packing_packings`.`packing_number`='" . mysqli_real_escape_string($conn, $packing_number) . "', 
											`packing_packings`.`order_number`='" . mysqli_real_escape_string($conn, $r_o['order_number']) . "', 
											`packing_packings`.`order_id`='" . mysqli_real_escape_string($conn, $r_o['id']) . "', 
											`packing_packings`.`address_id`='" . mysqli_real_escape_string($conn, intval($to_address)) . "', 
											`packing_packings`.`companyname`='" . mysqli_real_escape_string($conn, $to_companyname) . "', 
											`packing_packings`.`gender`='" . mysqli_real_escape_string($conn, $to_gender) . "', 
											`packing_packings`.`firstname`='" . mysqli_real_escape_string($conn, $to_firstname) . "', 
											`packing_packings`.`lastname`='" . mysqli_real_escape_string($conn, $to_lastname) . "', 
											`packing_packings`.`street`='" . mysqli_real_escape_string($conn, $to_street) . "', 
											`packing_packings`.`streetno`='" . mysqli_real_escape_string($conn, $to_streetno) . "', 
											`packing_packings`.`zipcode`='" . mysqli_real_escape_string($conn, $to_zipcode) . "', 
											`packing_packings`.`city`='" . mysqli_real_escape_string($conn, $to_city) . "', 
											`packing_packings`.`country`='" . mysqli_real_escape_string($conn, $to_country) . "', 
											`packing_packings`.`email`='" . mysqli_real_escape_string($conn, $to_email) . "', 
											`packing_packings`.`mobilnumber`='" . mysqli_real_escape_string($conn, $to_mobilnumber) . "', 
											`packing_packings`.`phonenumber`='" . mysqli_real_escape_string($conn, $to_phonenumber) . "', 
											`packing_packings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_POST['radio_payment'])) . "', 
											`packing_packings`.`amount`='" . mysqli_real_escape_string($conn, number_format($_POST['amount'], 2, '.', '')) . "', 
											`packing_packings`.`carriers_service`='" . mysqli_real_escape_string($conn, intval($_POST['carriers_service'])) . "', 
											`packing_packings`.`weight`='" . mysqli_real_escape_string($conn, $_POST['weight']) . "', 
											`packing_packings`.`length`='" . mysqli_real_escape_string($conn, $_POST['length']) . "', 
											`packing_packings`.`width`='" . mysqli_real_escape_string($conn, $_POST['width']) . "', 
											`packing_packings`.`height`='" . mysqli_real_escape_string($conn, $_POST['height']) . "', 
											`packing_packings`.`message`='" . mysqli_real_escape_string($conn, $description) . "', 
											`packing_packings`.`file1`='0', 
											`packing_packings`.`file2`='0', 
											`packing_packings`.`order_extended_items`='', 
											`packing_packings`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_POST["packing_id"] = $conn->insert_id;

			$devices = "";

			for($od = 0;$od < count($arr_order_devices[$key]);$od++){

				$r_d = mysqli_fetch_array(mysqli_query($conn, "	SELECT		*, 
																			(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space 
																FROM		`order_orders_devices` 
																WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "'"), MYSQLI_ASSOC);

				$devices .= $devices == "" ? $r_d['id'] . ":" . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) : "," . $r_d['id'] . ":" . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : ""));

				if($r_d['storage_space_id'] > 0){

					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");

					mysqli_query($conn, "	INSERT 	`order_orders_events` 
											SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Daten geändert, Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . intval($arr_order_devices[$key][$od]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Daten geändert, Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . intval($arr_order_devices[$key][$od]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
											SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
													`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $r_d['device_number'] . ($r_d['atot_mode'] == 1 ? "-AT-" . $r_d['at'] : ($r_d['atot_mode'] == 2 ? "-ORG-" . $r_d['ot'] : "")) . ", Lagerplatz " . $r_d['storage_space'] . " entfernt, ID [#" . $arr_order_devices[$key][$od] . "]</span>") . "', 
													`order_orders_devices_events`.`subject`='', 
													`order_orders_devices_events`.`body`='', 
													`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
											SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`storage_space_id`='0', 
													`order_orders_devices`.`storage_space_owner`='0', 
													`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`is_shipping_technic`='0', 
													`order_orders_devices`.`is_shipping_extern`='0', 
													`order_orders_devices`.`is_send`='1', 
													`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
											WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "' 
											AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				}

				mysqli_query($conn, "	INSERT 	`packing_packings_devices` 
										SET 	`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`packing_packings_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($r_o['id'])) . "', 
												`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["packing_id"])) . "', 
												`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($arr_order_devices[$key][$od])) . "', 
												`packing_packings_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($r_d['device_number'])) . "'");

			}

		}

		$html_new_shipping_result = 	"					<div class=\"form-group row\">\n" . 
										"						<div class=\"col-12\">\n" . 
										"							<strong class=\"text-success\">\n" . 
										" 								An Pcktisch versenden wurde durchgeführt!\n" . 
										"							</strong><br />\n" . 
										"						</div>\n" . 
										"					</div>\n";


		$emsg .= "<p>An Packtisch senden wurde erfolgreich durchgeführt!</p>\n";

		$_SESSION['devices'] = "";

	}

}

if(isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung an Packtisch senden"){

	if(strlen($_POST['from_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Adresse aus.</small><br />\n";
		$inp_from_address = " is-invalid";
	} else {
		$from_address = intval($_POST['from_address']);
	}

	if(strlen($_POST['from_shortcut']) < 1 || strlen($_POST['from_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Absender-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_shortcut = " is-invalid";
	} else {
		$from_shortcut = strip_tags($_POST['from_shortcut']);
	}

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Absender-Anrede aus. </small><br />\n";
		$inp_from_gender = " is-invalid";
	} else {
		$from_gender = intval($_POST['from_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
	} else {
		$from_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_mobilnumber']));
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
	} else {
		$from_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['from_phonenumber']));
	}

	if(strlen($_POST['from_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Absender-E-Mail versendet werden soll.</small><br />\n";
		$inp_from_mail = " is-invalid";
	} else {
		$from_mail = intval($_POST['from_mail']);
	}


	if(strlen($_POST['to_address']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Adresse aus.</small><br />\n";
		$inp_to_address = " is-invalid";
	} else {
		$to_address = intval($_POST['to_address']);
	}

	if(strlen($_POST['to_shortcut']) < 1 || strlen($_POST['to_shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Empfänger-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_shortcut = " is-invalid";
	} else {
		$to_shortcut = strip_tags($_POST['to_shortcut']);
	}

	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Empfänger-Anrede aus. </small><br />\n";
		$inp_to_gender = " is-invalid";
	} else {
		$to_gender = intval($_POST['to_gender']);
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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
	} else {
		$to_mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_mobilnumber']));
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
	} else {
		$to_phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['to_phonenumber']));
	}

	if(strlen($_POST['to_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an ob eine Empfänger-E-Mail versendet werden soll.</small><br />\n";
		$inp_to_mail = " is-invalid";
	} else {
		$to_mail = intval($_POST['to_mail']);
	}


	if(strlen($_POST['description']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Hinweis ein. (max. 256 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
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

	if(strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
	} else {
		$mail_with_pdf = intval($_POST['mail_with_pdf']);
	}

	if($emsg == ""){

		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $from_country . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . $to_country . "'"), MYSQLI_ASSOC);

		$packing_number = 0;

		while($packing_number == 0){

			$random = rand(100001, 999999);

			$result = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`packing_number`='" . $random . "'");

			if($result->num_rows == 0){

				$packing_number = $random;

			}

		}

		mysqli_query($conn, "	INSERT 	`packing_packings` 
								SET 	`packing_packings`.`mode`='0', 
										`packing_packings`.`type`='6', 
										`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`packing_packings`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`packing_number`='" . mysqli_real_escape_string($conn, $packing_number) . "', 
										`packing_packings`.`order_number`='', 
										`packing_packings`.`order_id`='0', 
										`packing_packings`.`address_id`='" . mysqli_real_escape_string($conn, intval($to_address)) . "', 
										`packing_packings`.`companyname`='" . mysqli_real_escape_string($conn, $to_companyname) . "', 
										`packing_packings`.`gender`='" . mysqli_real_escape_string($conn, $to_gender) . "', 
										`packing_packings`.`firstname`='" . mysqli_real_escape_string($conn, $to_firstname) . "', 
										`packing_packings`.`lastname`='" . mysqli_real_escape_string($conn, $to_lastname) . "', 
										`packing_packings`.`street`='" . mysqli_real_escape_string($conn, $to_street) . "', 
										`packing_packings`.`streetno`='" . mysqli_real_escape_string($conn, $to_streetno) . "', 
										`packing_packings`.`zipcode`='" . mysqli_real_escape_string($conn, $to_zipcode) . "', 
										`packing_packings`.`city`='" . mysqli_real_escape_string($conn, $to_city) . "', 
										`packing_packings`.`country`='" . mysqli_real_escape_string($conn, $to_country) . "', 
										`packing_packings`.`email`='" . mysqli_real_escape_string($conn, $to_email) . "', 
										`packing_packings`.`mobilnumber`='" . mysqli_real_escape_string($conn, $to_mobilnumber) . "', 
										`packing_packings`.`phonenumber`='" . mysqli_real_escape_string($conn, $to_phonenumber) . "', 
										`packing_packings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_POST['radio_payment'])) . "', 
										`packing_packings`.`amount`='" . mysqli_real_escape_string($conn, number_format($_POST['amount'], 2, '.', '')) . "', 
										`packing_packings`.`carriers_service`='" . mysqli_real_escape_string($conn, intval($_POST['carriers_service'])) . "', 
										`packing_packings`.`weight`='" . mysqli_real_escape_string($conn, $_POST['weight']) . "', 
										`packing_packings`.`length`='" . mysqli_real_escape_string($conn, $_POST['length']) . "', 
										`packing_packings`.`width`='" . mysqli_real_escape_string($conn, $_POST['width']) . "', 
										`packing_packings`.`height`='" . mysqli_real_escape_string($conn, $_POST['height']) . "', 
										`packing_packings`.`message`='" . mysqli_real_escape_string($conn, "Sendung ohne Geräte!") . "', 
										`packing_packings`.`file1`='0', 
										`packing_packings`.`file2`='0', 
										`packing_packings`.`order_extended_items`='', 
										`packing_packings`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["packing_id"] = $conn->insert_id;

		$html_new_shipping_result = 	"					<div class=\"form-group row\">\n" . 
										"						<div class=\"col-12\">\n" . 
										"							<strong class=\"text-success\">\n" . 
										" 								An Pcktisch versenden wurde durchgeführt!\n" . 
										"							</strong><br />\n" . 
										"						</div>\n" . 
										"					</div>\n";


		$emsg .= "<p>An Packtisch senden wurde erfolgreich durchgeführt!</p>\n";

		$_SESSION['devices'] = "";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row_from_address = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`=" . $from_address . ""), MYSQLI_ASSOC);
$row_to_address = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`=" . $to_address . ""), MYSQLI_ASSOC);

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
$options_to_addresses = "";

while($row = $result_address_addresses->fetch_array(MYSQLI_ASSOC)){

	$options_from_addresses .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $from_address ? " selected=\"selected\"" : "") . ">" . $row['shortcut'] . "</option>\n";
	$options_to_addresses .= "<option value=\"" . $row['id'] . "\"" . ($row['id'] == $to_address ? " selected=\"selected\"" : "") . ">" . $row['shortcut'] . "</option>\n";

}

$result_countries = mysqli_query($conn, "SELECT * FROM `countries` ORDER BY `countries`.`name` ASC");

$options_from_countries = "";
$options_to_countries = "";

$to_country_id = 0;

while($row = $result_countries->fetch_array(MYSQLI_ASSOC)){

	$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

	$options_from_countries .= "<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ($row['id'] == ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_country : strip_tags($row_from_address["country"])) ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
	$options_to_countries .= "<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ($row['id'] == ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_country : strip_tags($row_to_address["country"])) ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	$to_country_id = ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_country : strip_tags($row_to_address["country"]));

}

$carriers_services = $to_country_id == 1 ? array(
	'11' => 'UPS Standard', 
	'65' => 'UPS Saver'
) : array(
	'11' => 'UPS Standard'
);

$carrier_services_options = "";

foreach($carriers_services as $key => $val){

	$carrier_services_options .= "<option value=\"" . $key . "\"" . ($row_to_address['servicecode'] == "0" . $key ? " selected=\"selected\"" : "") . ">" . $val . "</option>\n";

}

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`package_templates` 
								ORDER BY 	CAST(`package_templates`.`id` AS UNSIGNED) ASC");

$carrier_package_templates_options = "";

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	if($package_template == $row['id']){
		$package_template = $row['id'];
		if(!isset($_POST['update_country']) && !isset($_POST['new_shipping'])){
			$length = $row['length'];
			$width = $row['width'];
			$height = $row['height'];
			$weight = $row['weight'];
		}
	}

	$carrier_package_templates_options .= "								<option value=\"" . $row['id'] . "\"" . ($package_template == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

}

$devices_list = "";

$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "'"), MYSQLI_ASSOC);

if(isset($row_order['id']) && $row_order['id'] > 0){

	$order_number = $row_order['order_number'];

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`order_orders_devices` `order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_devices`.`storage_space_id`>'0' 
									AND 		`order_orders_devices`.`is_storage`='0' 
									AND 		`order_orders_devices`.`is_shopin_relocate`='0' 
									AND 		`order_orders_devices`.`is_labeling`='0' 
									AND 		`order_orders_devices`.`is_photo`='0' 
									AND 		`order_orders_devices`.`is_shipping_user`='0' 
									AND 		`order_orders_devices`.`is_shipping_technic`='0' 
									AND 		`order_orders_devices`.`is_send`='0' 
									AND 		`order_orders_devices`.`is_relocate`='0' 
									ORDER BY 	`order_orders_devices`.`device_number` ASC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

		$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																FROM	`intern_interns` 
																WHERE	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 	`intern_interns`.`mode`='0' 
																AND 	`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_intern['id']) && $row_intern['id'] > 0){

			//$is_used = true;

		}else{

			$devices_list .= 	"<div class=\"row mb-4\">\n" . 
								"	<label class=\"col-sm-5 col-form-label\">\n" . 
								"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
								"	</label>\n" . 
								"	<div class=\"col-sm-2 text-right\">\n" . 
								"		<div class=\"custom-control custom-checkbox mt-2\">\n" . 
								"			<input type=\"checkbox\" id=\"device_" . $row_device['id'] . "\" name=\"device_" . $row_device['id'] . "\" value=\"1\" class=\"custom-control-input bootstrap-switch\" />\n" . 
								"			<label class=\"custom-control-label\" for=\"device_" . $row_device['id'] . "\">\n" . 
								"				Ja\n" . 
								"			</label>\n" . 
								"		</div>\n" . 
								"	</div>\n" . 
								"	<div class=\"col-sm-5\">\n" . 
								"	</div>\n" . 
								"</div>\n";

		}

	}

}

$session_devices_list = "";

$arr_devices = explode(",", $_SESSION["devices"]);

for($i = 0;$i < count($arr_devices);$i++){

	$arr_device = explode(":", $arr_devices[$i]);

	if(intval($arr_device[0]) > 0){

		$session_devices_list .= 	"<div class=\"row mb-1\">\n" . 
									"	<label class=\"col-sm-6 col-form-label\">\n" . 
									"		" . $arr_device[1] . "\n" . 
									"	</label>\n" . 
									"	<div class=\"col-sm-6\">\n" . 
									"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
									"			<input type=\"hidden\" name=\"device_id\" value=\"" . $arr_device[0] . "\" />\n" . 
									"			<button type=\"submit\" name=\"device_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
									"		</form>\n" . 
									"	</div>\n" . 
									"</div>\n";

	}

}

$list = "";

$searchword = strip_tags(isset($_POST['search_order']) && $_POST['search_order'] != "" ? $_POST['search_order'] : "");

$where = 	isset($_POST['search_order']) && $_POST['search_order'] != "" ? 
			"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`model` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
			OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%') " : 
			"";
$and = $where == "" ? "WHERE `order_orders`.`mode`" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? ">=0" : "=" . intval($_POST['search_mode'])) . " " : " AND `order_orders`.`mode`" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? ">=0" : "=" . intval($_POST['search_mode'])) . " ";

$query = 	"	SELECT 		`order_orders`.`id` AS id, 
							`order_orders`.`creator_id` AS creator_id, 
							`order_orders`.`order_number` AS order_number, 
							`order_orders`.`status_counter` AS status_counter, 
							`order_orders`.`companyname` AS companyname, 
							`order_orders`.`firstname` AS firstname, 
							`order_orders`.`lastname` AS lastname, 
							`order_orders`.`phonenumber` AS phonenumber, 
							`order_orders`.`mobilnumber` AS mobilnumber, 
							`order_orders`.`audio` AS audio, 
							`order_orders`.`call_date` AS call_date, 
							`order_orders`.`intern_time` AS intern_time, 
							`order_orders`.`run_date` AS run_date, 
							`order_orders`.`reg_date` AS reg_date, 
							`order_orders`.`cpy_date` AS cpy_date, 
							`order_orders`.`upd_date` AS time, 

							(SELECT `address_addresses`.`shortcut` AS shortcut FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`=`order_orders`.`intern_allocation`) AS address_shortcut, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

							(SELECT 		`order_orders_payings`.`payed` AS p_payed 
								FROM		`order_orders_payings` 
								WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_payings`.`order_id`=`order_orders`.`id` 
								ORDER BY	CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1) AS payed, 

							(SELECT 		`order_orders_payings`.`shipping` AS p_shipping 
								FROM		`order_orders_payings` 
								WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_payings`.`order_id`=`order_orders`.`id` 
								ORDER BY	CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1) AS shipping, 

							`order_orders`.`admin_id` AS admin_id 

				FROM 		`order_orders` 
				" . $where . $and . " 
				AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
				ORDER BY 	CAST(`order_orders`.`upd_date` AS UNSIGNED) ASC";

$result = mysqli_query($conn, $query);

while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

	$list .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
				"	<tr class=\"" . (isset($_POST['order_id']) && $_POST['order_id'] == $row_orders['id'] ? "bg-warning text-white" : "") . "\">\n" . 
				"		<td class=\"text-nowrap\">\n" . 
				"			<small>" . date("d.m.Y", $row_orders['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['reg_date']) . "</small>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" align=\"center\">\n" . 
				"			<small>" . $row_orders['order_number'] . "</small>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<div style=\"width: 160px;white-space: nowrap;overflow-x: hidden\"><small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small></div>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-nowrap\">\n" . 
				"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<div style=\"white-space: nowrap\">\n" . 
				"				<input type=\"hidden\" name=\"order_id\" value=\"" . $row_orders['id'] . "\" />\n" . 
				"				<input type=\"hidden\" name=\"search_order\" value=\"" . strip_tags(isset($_POST['search_order']) ? $_POST['search_order'] : "") . "\" />\n" . 
				"				<input type=\"hidden\" name=\"search_mode\" value=\"" . intval(isset($_POST['search_mode']) ? $_POST['search_mode'] : "") . "\" />\n" . 
				"				<button type=\"submit\" name=\"order\" value=\"select\" class=\"btn btn-sm btn-success\">auswählen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
				"			</div>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$order_list = "";

if($list != ""){

	$order_list = 	"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 
					"									<h3>Auftrag wählen</h3>\n" . 
					"								</div>\n" . 
					"							</div>\n" . 
					"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-6 border-right\">\n" . 
					"									<div class=\"table-responsive\" style=\"max-height: 400px\">\n" . 
					"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
					"											<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
					"												<th width=\"120\" scope=\"col\">\n" . 
					"													<strong>Erstellt</strong>\n" . 
					"												</th>\n" . 
					"												<th width=\"60\" scope=\"col\">\n" . 
					"													<strong>Auftrag</strong>\n" . 
					"												</th>\n" . 
					"												<th scope=\"col\">\n" . 
					"													<strong>Kunde</strong>\n" . 
					"												</th>\n" . 
					"												<th width=\"120\" scope=\"col\">\n" . 
					"													<strong>Geändert</strong>\n" . 
					"												</th>\n" . 
					"												<th width=\"110\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
					"													<strong>Aktion</strong>\n" . 
					"												</th>\n" . 
					"											</tr></thead>\n" . 
	
					$list . 
	
					"										</table>\n" . 
					"									</div>\n" . 
					"								</div>\n" . 
					"								<div class=\"col-sm-3 border-right\">\n" . 

					"									<form action=\"" . $order_action . "\" method=\"post\">\n" . 

					"										<div class=\"form-group row\">\n" . 
					"											<div class=\"col-sm-12\">\n" . 
					"												<strong><u>Verfügbare Versandartikel</u>:</strong>\n" . 
					"											</div>\n" . 
					"										</div>\n" . 

					$devices_list . 

					"										<div class=\"form-group row\">\n" . 
					"											<div class=\"col-sm-6\">\n" . 
					"												<input type=\"hidden\" name=\"order_id\" value=\"" . (isset($_POST['order_id']) && intval($_POST['order_id']) > 0 ? intval($_POST['order_id']) : 0) . "\" />\n" . 
					"												<input type=\"hidden\" name=\"search_order\" value=\"" . strip_tags(isset($_POST['search_order']) ? $_POST['search_order'] : "") . "\" />\n" . 
					"												<input type=\"hidden\" name=\"search_mode\" value=\"" . intval(isset($_POST['search_mode']) ? $_POST['search_mode'] : "") . "\" />\n" . 
					"												<button type=\"submit\" name=\"devices\" value=\"add\" class=\"btn btn-sm btn-success w-100\">hinzufügen <i class=\"fa fa-plus\" aria-hidden=\"true\"></i></button>\n" . 
					"											</div>\n" . 
					"										</div>\n" . 
					"									</form>\n" . 

					"								</div>\n" . 
					"								<div class=\"col-sm-3\">\n" . 

					"									<div class=\"form-group row\">\n" . 
					"										<div class=\"col-sm-12\">\n" . 
					"											<strong><u>Gewählte Versandartikel</u>:</strong>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 

					$session_devices_list . 

					"								</div>\n" . 

					"							</div>\n" . 
					"							<br />\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Versand - Versenden</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die gewünschten Sendungen durchführen.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col\">\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Paketschein erstellen</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"				<div class=\"form-group row m-3\">\n" . 
		"					<div class=\"col-sm-12 bg-white px-4 border\">\n" . 

		"						<br />\n" . 

		"						<div class=\"form-group row\">\n" . 
		"							<label class=\"col-sm-4 col-form-label\"><h3>Für Versandartikel nach Aufträge suchen</h3></label>\n" . 
		"							<div class=\"col-sm-8\">\n" . 
		"								<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
		"									<div class=\"btn-group\">\n" . 
		"										<input type=\"text\" name=\"search_order\" value=\"" . strip_tags(isset($_POST['search_order']) ? $_POST['search_order'] : "") . "\" placeholder=\"|||||| Suchbegriff\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control form-control-lg bg-white text-primary border border-primary\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"										<select name=\"search_mode\" class=\"custom-select custom-select-lg bg-light text-primary border border-primary\" style=\"border-radius: 0\">\n" . 
		"											<option value=\"10000\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? " selected=\"selected\"" : "")  . ">Alle</option>\n" . 
		"											<option value=\"0\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 0 ? " selected=\"selected\"" : "")  . ">Auftrag-Aktiv</option>\n" . 
		"											<option value=\"1\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 1 ? " selected=\"selected\"" : "")  . ">Auftrag-Archiv</option>\n" . 
		"											<option value=\"2\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 2 ? " selected=\"selected\"" : "")  . ">Interessent-Aktiv</option>\n" . 
		"											<option value=\"3\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 3 ? " selected=\"selected\"" : "")  . ">Interessent-Archiv</option>\n" . 
		"										</select>\n" . 
		"										<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary btn-lg\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"									</div>\n" . 
		"								</form>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 

		"						<hr />\n" . 

		$order_list . 

		"					</div>\n" . 
		"				</div>\n" . 

		"				<br />\n" . 

		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		$html_new_shipping_result . 

		"					<div class=\"form-group row\">\n" . 

		"						<div class=\"col-sm-6 border-right\">\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-12\">\n" . 
		"									<strong>Absender</strong>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-6\">\n" . 
		"									<select id=\"from_address\" name=\"from_address\" class=\"custom-select" . $inp_from_address . "\" onchange=\"\$('#update').click()\">\n" . 

		$options_from_addresses . 

		"									</select>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-6\">\n" . 
		"									<input type=\"text\" id=\"from_shortcut\" name=\"from_shortcut\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_shortcut : $row_from_address["shortcut"]) . "\" class=\"form-control" . $inp_from_shortcut . "\" placeholder=\"Kürzel\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-12\">\n" . 
		"									<input type=\"text\" id=\"from_companyname\" name=\"from_companyname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_companyname : $row_from_address["companyname"]) . "\" class=\"form-control" . $inp_from_companyname . "\" placeholder=\"Firma\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4 mt-2\">\n" . 
		"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"										<input type=\"radio\" id=\"from_gender_0\" name=\"from_gender\" value=\"0\"" . (((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_gender : $row_from_address["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"from_gender_0\">\n" . 
		"											Herr\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"										<input type=\"radio\" id=\"from_gender_1\" name=\"from_gender\" value=\"1\"" . (((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_gender : $row_from_address["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"from_gender_1\">\n" . 
		"											Frau\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_firstname\" name=\"from_firstname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_firstname : $row_from_address["firstname"]) . "\" class=\"form-control" . $inp_from_firstname . "\" placeholder=\"Vorname\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_lastname\" name=\"from_lastname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_lastname : $row_from_address["lastname"]) . "\" class=\"form-control" . $inp_from_lastname . "\" placeholder=\"Nachname\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-9\">\n" . 
		"									<input type=\"text\" id=\"from_street\" name=\"from_street\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_street : $row_from_address["street"]) . "\" class=\"form-control" . $inp_from_street . "\" placeholder=\"Straße\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<input type=\"text\" id=\"from_streetno\" name=\"from_streetno\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_streetno : $row_from_address["streetno"]) . "\" class=\"form-control" . $inp_from_streetno . "\" placeholder=\"Nr\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_zipcode\" name=\"from_zipcode\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_zipcode : $row_from_address["zipcode"]) . "\" class=\"form-control" . $inp_from_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_city\" name=\"from_city\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_city : $row_from_address["city"]) . "\" class=\"form-control" . $inp_from_city . "\" placeholder=\"Ort\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<select id=\"from_country\" name=\"from_country\" class=\"custom-select" . $inp_from_country . "\">\n" . 
		$options_from_countries . 
		"									</select>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_email\" name=\"from_email\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_email : $row_from_address["email"]) . "\" class=\"form-control" . $inp_from_email . "\" placeholder=\"Email\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_mobilnumber\" name=\"from_mobilnumber\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_mobilnumber : $row_from_address["mobilnumber"]) . "\" class=\"form-control" . $inp_from_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"from_phonenumber\" name=\"from_phonenumber\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $from_phonenumber : $row_from_address["phonenumber"]) . "\" class=\"form-control" . $inp_from_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-4 col-form-label\">Benachrichtigung</label>\n" . 
		"								<div class=\"col-sm-7\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"from_mail\" name=\"from_mail\" value=\"1\"" . ($from_mail == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"from_mail\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"						</div>\n" . 

		"						<div class=\"col-sm-6\">\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-12\">\n" . 
		"									<strong>Empfänger</strong>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-6\">\n" . 
		"									<select id=\"to_address\" name=\"to_address\" class=\"custom-select" . $inp_to_address . "\" onchange=\"\$('#update').click()\">\n" . 
		$options_to_addresses . 
		"									</select>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-6\">\n" . 
		"									<input type=\"text\" id=\"to_shortcut\" name=\"to_shortcut\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_shortcut : $row_to_address["shortcut"]) . "\" class=\"form-control" . $inp_to_shortcut . "\" placeholder=\"Kürzel\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-12\">\n" . 
		"									<input type=\"text\" id=\"to_companyname\" name=\"to_companyname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_companyname : $row_to_address["companyname"]) . "\" class=\"form-control" . $inp_to_companyname . "\" placeholder=\"Firma\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4 mt-2\">\n" . 
		"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"										<input type=\"radio\" id=\"to_gender_0\" name=\"to_gender\" value=\"0\"" . (((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_gender : $row_to_address["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"to_gender_0\">\n" . 
		"											Herr\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
		"										<input type=\"radio\" id=\"to_gender_1\" name=\"to_gender\" value=\"1\"" . (((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_gender : $row_to_address["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"to_gender_1\">\n" . 
		"											Frau\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_firstname\" name=\"to_firstname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_firstname : $row_to_address["firstname"]) . "\" class=\"form-control" . $inp_to_firstname . "\" placeholder=\"Vorname\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_lastname\" name=\"to_lastname\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_lastname : $row_to_address["lastname"]) . "\" class=\"form-control" . $inp_to_lastname . "\" placeholder=\"Nachname\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-9\">\n" . 
		"									<input type=\"text\" id=\"to_street\" name=\"to_street\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_street : $row_to_address["street"]) . "\" class=\"form-control" . $inp_to_street . "\" placeholder=\"Straße\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-3\">\n" . 
		"									<input type=\"text\" id=\"to_streetno\" name=\"to_streetno\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_streetno : $row_to_address["streetno"]) . "\" class=\"form-control" . $inp_to_streetno . "\" placeholder=\"Nr\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_zipcode\" name=\"to_zipcode\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_zipcode : $row_to_address["zipcode"]) . "\" class=\"form-control" . $inp_to_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_city\" name=\"to_city\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_city : $row_to_address["city"]) . "\" class=\"form-control" . $inp_to_city . "\" placeholder=\"Ort\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<select id=\"to_country\" name=\"to_country\" class=\"custom-select" . $inp_to_country . "\" onchange=\"$('#update_country').click()\">\n" . 
		$options_to_countries . 
		"									</select>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_email\" name=\"to_email\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_email : $row_to_address["email"]) . "\" class=\"form-control" . $inp_to_email . "\" placeholder=\"Email\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_mobilnumber\" name=\"to_mobilnumber\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_mobilnumber : $row_to_address["mobilnumber"]) . "\" class=\"form-control" . $inp_to_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-4\">\n" . 
		"									<input type=\"text\" id=\"to_phonenumber\" name=\"to_phonenumber\" value=\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_phonenumber : $row_to_address["phonenumber"]) . "\" class=\"form-control" . $inp_to_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-4 col-form-label\">Benachrichtigung</label>\n" . 
		"								<div class=\"col-sm-7\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"to_mail\" name=\"to_mail\" value=\"1\"" . ($to_mail == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"to_mail\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"						</div>\n" . 

		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 

		"						<div class=\"col-sm-12\">\n" . 
		"							<hr />\n" . 
		"						</div>\n" . 

		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 

		"						<div class=\"col-sm-6 border-right\">\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<div class=\"col-sm-12\">\n" . 
		"									<strong>Optionen</strong>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label class=\"col-sm-4 col-form-label\">Hinweis</label>\n" . 
		"								<div class=\"col-sm-8\">\n" . 
		"									<input type=\"text\" id=\"description\" name=\"description\" value=\"" . $description . "\" class=\"form-control" . $inp_description . "\" placeholder=\"Hinweis\" />\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"carriers_services\" class=\"col-sm-4 col-form-label\">Service</label>\n" . 
		"								<div class=\"col-sm-8\">\n" . 
		"									<select id=\"carriers_service\" name=\"carriers_service\" class=\"custom-select\">\n" . 
		$carrier_services_options . 
		"									</select>\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-1\">\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 
		"								<label for=\"package_template\" class=\"col-sm-4 col-form-label\">Paketvorlage</label>\n" . 
		"								<div class=\"col-sm-8\">\n" . 
		"									<select id=\"package_template\" name=\"package_template\" class=\"custom-select\" onchange=\"\$('#update').click()\">\n" . 

		$carrier_package_templates_options . 

		"									</select>\n" . 
		"								</div>\n" . 
		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 

		"								<label class=\"col-sm-4 col-form-label\">Maße / Gewicht</label>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<input type=\"number\" id=\"length\" name=\"length\" step=\"1\" value=\"" . $length . "\" class=\"form-control\" placeholder=\"Länge\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Länge\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<input type=\"number\" id=\"width\" name=\"width\" step=\"1\" value=\"" . $width . "\" class=\"form-control\" placeholder=\"Breite\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Breite\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<input type=\"number\" id=\"height\" name=\"height\" step=\"1\" value=\"" . $height . "\" class=\"form-control\" placeholder=\"Höhe\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Höhe\" />\n" . 
		"								</div>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<input type=\"number\" id=\"weight\" name=\"weight\" step=\"0.1\" value=\"" . $weight . "\" class=\"form-control\" placeholder=\"Gewicht\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gewicht\" />\n" . 
		"								</div>\n" . 

		"							</div>\n" . 

		"							<div class=\"form-group row\">\n" . 

		"								<label class=\"col-sm-4 col-form-label\">Nachnahme</label>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"radio_payment\" name=\"radio_payment\" value=\"1\"" . ($radio_payment == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" onchange=\"if(\$(this).prop('checked') == false){\$('#amount_label').hide();\$('#amount_amount').hide();}else{\$('#amount_label').show();\$('#amount_amount').show();}\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"radio_payment\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		"								<label id=\"amount_label\" class=\"col-sm-2 col-form-label\" style=\"" . ($radio_payment == 0 ? "display: none" : "") . "\" for=\"amount\">Betrag</label>\n" . 
		"								<div id=\"amount_amount\" class=\"col-sm-4\" style=\"" . ($radio_payment == 0 ? "display: none" : "") . "\">\n" . 
		"									<div class=\"input-group\">\n" . 
		"										<input type=\"text\" id=\"amount\" name=\"amount\" value=\"" . number_format($amount, 2, ',', '') . "\" class=\"form-control" . $inp_amount . "\" />\n" . 
		"									    <span class=\"input-group-append\">\n" . 
		"											<span class=\"input-group-text\">&euro;</span>\n" . 
		"										</span>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 
		
		"							</div>\n" . 
		"							<div class=\"form-group row\">\n" . 

		"								<label class=\"col-sm-4 col-form-label\">Samstagszustellung</label>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"radio_saturday\" name=\"radio_saturday\" value=\"1\"" . ($radio_saturday ==  1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"radio_saturday\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 

		"							</div>\n" . 
		"							<div class=\"form-group row\">\n" . 

		"								<label class=\"col-sm-4 col-form-label\">Begleitschein beifügen</label>\n" . 
		"								<div class=\"col-sm-2\">\n" . 
		"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
		"										<input type=\"checkbox\" id=\"mail_with_pdf\" name=\"mail_with_pdf\" value=\"1\"" . ($mail_with_pdf == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
		"										<label class=\"custom-control-label\" for=\"mail_with_pdf\">\n" . 
		"											Ja\n" . 
		"										</label>\n" . 
		"									</div>\n" . 
		"								</div>\n" . 

		"							</div>\n" . 

		"						</div>\n" . 
		"						<div class=\"col-sm-6\">\n" . 

		"							&nbsp;\n" . 

		"						</div>\n" . 

		"					</div>\n" . 


		"					<div class=\"row px-0 card-footer\">\n" . 
		"						<div class=\"col-sm-6\">\n" . 
		"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval(isset($_POST['order_id']) ? $_POST['order_id'] : "") . "\" />\n" . 
		"							<input type=\"hidden\" name=\"search_order\" value=\"" . strip_tags(isset($_POST['search_order']) ? $_POST['search_order'] : "") . "\" />\n" . 
		"							<input type=\"hidden\" name=\"search_mode\" value=\"" . intval(isset($_POST['search_mode']) ? $_POST['search_mode'] : "") . "\" />\n" . 
		"							<button type=\"submit\" name=\"new_shipping\" value=\"Sofort Senden\" class=\"btn btn-primary\">Sofort Senden <i class=\"fa fa-truck\" aria-hidden=\"true\"></i></button>\n" . 
		($_SESSION['devices'] != "" ? 
			"							<button type=\"submit\" name=\"new_shipping\" value=\"Geräte an Packtisch senden\" class=\"btn btn-primary\">Geräte an Packtisch senden <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n"
		: 
			"							<button type=\"submit\" name=\"new_shipping\" value=\"Sendung an Packtisch senden\" class=\"btn btn-primary\">Sendung an Packtisch senden <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n"
		) . 
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