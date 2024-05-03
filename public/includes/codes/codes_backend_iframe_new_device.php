<?php 

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$inp_order_number = "";

$inp_component = "";
$inp_manufacturer = "";
$inp_serial = "";
$inp_additional_numbers = "";
$inp_fromthiscar = "";
$inp_open_by_user = "";
$inp_other_components = "";
$inp_info = "";
$inp_storage_space = "";

$order_number = "";
$order_id = 0;

$component = 0;
$manufacturer = "";
$serial = "";
$additional_numbers = "";
$fromthiscar = 1;
$open_by_user = 0;
$other_components = 0;
$info = "";
$storage_space = "";

$atot_mode = 2;

$emsg = "";

$list = "";

$text_color = "text-secondary";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['order_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Auftragsnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_order_number = " is-invalid";
	} else {
		$order_number = strip_tags($_POST['order_number']);
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT `order_orders`.`id` AS id,  `order_orders`.`order_number` AS order_number FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "'"), MYSQLI_ASSOC);
		if(isset($row_order['id']) && $row_order['id'] > 0){
			$order_id = $row_order['id'];
		}else{
			$emsg .= "<small class=\"error text-muted\">Die Auftragsnummer wurde nicht gefunden!</small><br />\n";
			$inp_order_number = " is-invalid";
		}
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

	if(strlen($_POST['other_components']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob andere Bauteile am Gerät sind. (max. 256 Zeichen)</small><br />\n";
		$inp_other_components = " is-invalid";
	} else {
		$other_components = intval($_POST['other_components']);
	}

	if(strlen($_POST['info']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte ein Hinweis eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_info = " is-invalid";
	} else {
		$info = strip_tags($_POST['info']);
	}

	if($emsg == ""){
		if(intval($_POST['storage_space_id']) < 0){
			$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen.</small><br />\n";
			$_POST['storage_space_id'] = 0;
		} else {
			if(intval($_POST['storage_space_id']) > 0){
				$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'"), MYSQLI_ASSOC);
				if($row_storage_place['used'] < $row_storage_place['parts']){
					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'");
					mysqli_query($conn, "	INSERT 	`order_orders_events` 
											SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
													`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Neues Gerät, Lagerplatz " . $row_storage_place['name'] . " hinzugefügt") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Neues Gerät, Lagerplatz " . $row_storage_place['name'] . " hinzugefügt") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Neues Gerät, Lagerplatz " . $row_storage_place['name'] . " hinzugefügt</span>") . "', 
														`order_orders_devices_events`.`subject`='', 
														`order_orders_devices_events`.`body`='', 
														`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
					$storage_space = $row_storage_place['name'];
				}else{
					$_POST['storage_space_id'] = 0;
					$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";
				}
			}
		}
	}

	if($emsg == ""){

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$device_number = $row_order['order_number'];

		for($i = 11;$i < 100;$i++){

			$number = $device_number . "-" . $i;

			$result = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`='" . $number . "'");

			if($result->num_rows == 0){
				$device_number = $number;
				break;
			}

		}

		$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "'"), MYSQLI_ASSOC);

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'"), MYSQLI_ASSOC);

		$atot_mode = 0;

		$at = 0;

		$ot = 0;

		if(isset($_POST['atot_mode'])){

			if(intval($_POST['atot_mode']) == 1){

				$atot_mode = 1;

				$at = 0;

				for($i = 1;$i < 100;$i++){

					$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "' AND `order_orders_devices`.`atot_mode`='1' AND `order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

					if(!isset($row_device['id'])){
						$at = $i;
						break;
					}

				}


			}

			if(intval($_POST['atot_mode']) == 2){

				$atot_mode = 2;

				$ot = 0;

				for($i = 1;$i < 100;$i++){

					$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "' AND `order_orders_devices`.`atot_mode`='2' AND `order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

					if(!isset($row_device['id'])){
						$ot = $i;
						break;
					}

				}

			}

		}

		mysqli_query($conn, "	INSERT 	`order_orders_devices` 
								SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "', 
										`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "', 
										`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($at)) . "', 
										`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($ot)) . "', 
										`order_orders_devices`.`component`='" . mysqli_real_escape_string($conn, intval($component)) . "', 
										`order_orders_devices`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
										`order_orders_devices`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
										`order_orders_devices`.`additional_numbers`='" . mysqli_real_escape_string($conn, $additional_numbers) . "', 
										`order_orders_devices`.`fromthiscar`='" . mysqli_real_escape_string($conn, intval($fromthiscar)) . "', 
										`order_orders_devices`.`open_by_user`='" . mysqli_real_escape_string($conn, intval($open_by_user)) . "', 
										`order_orders_devices`.`other_components`='" . mysqli_real_escape_string($conn, intval($other_components)) . "', 
										`order_orders_devices`.`info`='" . mysqli_real_escape_string($conn, $info) . "', 
										`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags(isset($row_storage_place['name']) ? $row_storage_place['name'] : "")) . "', 
										`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_id']) ? $_POST['storage_space_id'] : 0)) . "', 
										`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
										`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
								SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . strip_tags($device_number . ($atot_mode == 1 ? "-AT-" . $at : ($atot_mode == 2 ? "-ORG-" . $ot : ""))) . " erstellt, ID [#" . intval($_POST["id"]) . "]</span>") . "', 
										`order_orders_devices_events`.`subject`='', 
										`order_orders_devices_events`.`body`='', 
										`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_new_device_status'])) . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[device id]", $device_number . ($atot_mode == 1 ? "-AT-" . $at : ($atot_mode == 2 ? "-ORG-" . $ot : "")), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			if(isset($row_order['id']) && $row_order['id'] > 0){

				$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", (isset($row_country['id']) ? $row_country['name'] : ""), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);
	
				$differing_shipping_address = 	$row_order['differing_shipping_address'] == 0 ? 
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
	
				$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $differing_shipping_address, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_country]", (isset($row_differing_country['id']) ? $row_differing_country['name'] : ""), $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
				$radio_radio_shipping = array(	0 => "Expressversand", 
												1 => "Standardversand", 
												2 => "International", 
												3 => "Abholung");
				$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
				$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
												1 => "Nachnahme", 
												2 => "Bar");
				$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fue'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);
	
//				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			}

		}

		mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
								SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "', 
										`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_statuses`.`public`='1', 
										`order_orders_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . strip_tags($device_number . ($atot_mode == 1 ? "-AT-" . $at : ($atot_mode == 2 ? "-ORG-" . $ot : ""))) . " erstellt, ID [#" . $_POST['id'] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $order_number . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
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
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
				}

			}

		}else{

			if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
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
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
				}

			}

		}

		$_POST['edit'] = "bearbeiten";

	}
	
}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['order_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Auftragsnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_order_number = " is-invalid";
	} else {
		$order_number = strip_tags($_POST['order_number']);
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT `order_orders`.`id` AS id FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "'"), MYSQLI_ASSOC);
		if(isset($row_order['id']) && $row_order['id'] > 0){
			$order_id = $row_order['id'];
		}
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

	if(strlen($_POST['other_components']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob andere Bauteile am Gerät sind. (max. 256 Zeichen)</small><br />\n";
		$inp_other_components = " is-invalid";
	} else {
		$other_components = intval($_POST['other_components']);
	}

	if(strlen($_POST['info']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte ein Hinweis eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_info = " is-invalid";
	} else {
		$info = strip_tags($_POST['info']);
	}

	if(strlen($_POST['storage_space']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Lagerplatz ein. (max. 256 Zeichen)</small><br />\n";
		$inp_storage_space = " is-invalid";
	} else {
		$storage_space = strip_tags($_POST['storage_space']);
	}

	if($emsg == ""){
		if(intval($_POST['storage_space_id']) < 0){
			$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen.</small><br />\n";
			$_POST['storage_space_id'] = 0;
		} else {
			if(intval($_POST['storage_space_id']) > 0 && intval($_POST['storage_space_id']) != $row_device['storage_space_id']){
				$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'"), MYSQLI_ASSOC);
				if($row_storage_place['used'] < $row_storage_place['parts']){
					if($row_device['storage_space_id'] > 0){
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
														`order_orders_devices_events`.`subject`='', 
														`order_orders_devices_events`.`body`='', 
														`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
					}
					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'");
					mysqli_query($conn, "	INSERT 	`order_orders_events` 
											SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
													`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_storage_place['name'] . " hinzugefügt, ID [#" . $row_device['id'] . "]</span>") . "', 
														`order_orders_devices_events`.`subject`='', 
														`order_orders_devices_events`.`body`='', 
														`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
					$storage_space = $row_storage_place['name'];
				}else{
					$_POST['storage_space_id'] = 0;
					$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";
				}
			}elseif(intval($_POST['storage_space_id']) == 0){
				if($row_device['storage_space_id'] > 0){
					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
					mysqli_query($conn, "	INSERT 	`order_orders_events` 
											SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
													`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
														`order_orders_devices_events`.`subject`='', 
														`order_orders_devices_events`.`body`='', 
														`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
				}
			}
		}
	}

	if($emsg == ""){

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id'])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
								SET 	`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['creator_id']) ? $_POST['creator_id'] : 0)) . "', 
										`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, $order_id) . "', 
										`order_orders_devices`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
										`order_orders_devices`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
										`order_orders_devices`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
										`order_orders_devices`.`additional_numbers`='" . mysqli_real_escape_string($conn, $additional_numbers) . "', 
										`order_orders_devices`.`fromthiscar`='" . mysqli_real_escape_string($conn, $fromthiscar) . "', 
										`order_orders_devices`.`open_by_user`='" . mysqli_real_escape_string($conn, $open_by_user) . "', 
										`order_orders_devices`.`other_components`='" . mysqli_real_escape_string($conn, $other_components) . "', 
										`order_orders_devices`.`info`='" . mysqli_real_escape_string($conn, $info) . "', 
										`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($row_storage_place['name'])) . "', 
										`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_id']) ? $_POST['storage_space_id'] : 0)) . "', 
										`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_owner']) ? $_POST['storage_space_owner'] : 0)) . "', 
										`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
								SET 	`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_id']) ? $_POST['storage_space_id'] : 0)) . "', 
										`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
								AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Das Gerät wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(!isset($_POST['id'])){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($param['order_id'])) . "'"), MYSQLI_ASSOC);

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($component) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$options_storage_places = "												<option value=\"0\">Bitte auswählen</option>\n";

	$result_rooms = mysqli_query($conn, "	SELECT 		* 
											FROM 		`storage_rooms` 
											WHERE 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	while($row_room = $result_rooms->fetch_array(MYSQLI_ASSOC)){
		$options_storage_places .= "											<optgroup label=\"" . $row_room['name'] . "\">\n";
		$result_places = mysqli_query($conn, "	SELECT 		* 
												FROM 		`storage_places` 
												WHERE 		`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($row_room['id'])) . "' 
												AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`storage_places`.`pos` AS UNSIGNED) ASC");
		while($row_place = $result_places->fetch_array(MYSQLI_ASSOC)){
			$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . ($row_place['id'] == $row_device['storage_space_id'] ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";
		}
		$options_storage_places .= "											</optgroup>\n";
	}

	$options_storage_space_owner = "";

	$storage_space_owner_name = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_storage_space_owner .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['storage_space_owner']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_device["storage_space_owner"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if(intval($row_device["storage_space_owner"]) == $row['id']){
			$storage_space_owner_name = $row['name'];
		}
	}

	$html = 	"<br />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"/crm/auftraege-neues-geraet/" . intval($param['order_id']) . "\" method=\"post\">\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"storage_space_id\" class=\"col-sm-6 col-form-label\">Lagerplatz</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"storage_space_id\" name=\"storage_space_id\" class=\"custom-select\">\n" . 

				$options_storage_places . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Zusatz Aktion</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['atot_mode']) ? $_POST['atot_mode'] : 0) : $atot_mode) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"atot_mode_change\" name=\"atot_mode\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['atot_mode']) ? $_POST['atot_mode'] : 0) : $atot_mode) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Austauschteil\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['atot_mode']) ? $_POST['atot_mode'] : 0) : $atot_mode) == 2 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"atot_mode_original\" name=\"atot_mode\" value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['atot_mode']) ? $_POST['atot_mode'] : 0) : $atot_mode) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Originalteil\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"component\" class=\"col-sm-6 col-form-label\">Defektes Bauteil</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"manufacturer\" class=\"col-sm-6 col-form-label\">Hersteller</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $manufacturer : strtoupper($manufacturer)) . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"serial\" class=\"col-sm-6 col-form-label\">Teile.-/Herstellernummer</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $serial : $serial) . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"additional_numbers\" class=\"col-sm-6 col-form-label\">Zusätzliche Nummern</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"additional_numbers\" name=\"additional_numbers\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $additional_numbers : $additional_numbers) . "\" class=\"form-control" . $inp_additional_numbers . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary active\">\n" . 
				"									<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $fromthiscar : $fromthiscar) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary\">\n" . 
				"									<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $fromthiscar : $fromthiscar) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Wurde durch Kunde geöffnet</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary\">\n" . 
				"									<input type=\"radio\" id=\"open_by_user_yes\" name=\"open_by_user\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $open_by_user : $open_by_user) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary active\">\n" . 
				"									<input type=\"radio\" id=\"open_by_user_no\" name=\"open_by_user\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $open_by_user : $open_by_user) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Andere Bauteile am Gerät</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label for=\"other_components_yes\" class=\"btn btn-light border border-secondary\">\n" . 
				"									<input type=\"radio\" id=\"other_components_yes\" name=\"other_components\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $other_components : $other_components) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label for=\"other_components_no\" class=\"btn btn-light border border-secondary active\">\n" . 
				"									<input type=\"radio\" id=\"other_components_no\" name=\"other_components\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $other_components : $other_components) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"info\" class=\"col-sm-12 col-form-label\">Hinweis</label>\n" . 
				"						<div class=\"col-sm-12 text-right\">\n" . 
				"							<textarea id=\"info\" name=\"info\" style=\"height: 80px\" class=\"form-control" . $inp_info . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#info_length').html(this.value.length);\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $info : $row_device["info"]) . "</textarea>\n" . 
				"							<small>(<span id=\"info_length\">" . strlen(isset($_POST['save']) && $_POST['save'] == "speichern" ? $info : $info) . "</span> von 700 Zeichen)</small>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_number\" value=\"" . $row_order['order_number'] . "\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n";
	
}else{

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "'"), MYSQLI_ASSOC);

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_device["component"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$options_storage_places = "												<option value=\"0\">Bitte auswählen</option>\n";

	$result_rooms = mysqli_query($conn, "	SELECT 		* 
											FROM 		`storage_rooms` 
											WHERE 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	while($row_room = $result_rooms->fetch_array(MYSQLI_ASSOC)){
		$options_storage_places .= "											<optgroup label=\"" . $row_room['name'] . "\">\n";
		$result_places = mysqli_query($conn, "	SELECT 		* 
												FROM 		`storage_places` 
												WHERE 		`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($row_room['id'])) . "' 
												AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`storage_places`.`pos` AS UNSIGNED) ASC");
		while($row_place = $result_places->fetch_array(MYSQLI_ASSOC)){
			$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . ($row_place['id'] == $row_device['storage_space_id'] ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";
		}
		$options_storage_places .= "											</optgroup>\n";
	}

	$options_storage_space_owner = "";

	$storage_space_owner_name = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_storage_space_owner .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['storage_space_owner']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_device["storage_space_owner"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if(intval($row_device["storage_space_owner"]) == $row['id']){
			$storage_space_owner_name = $row['name'];
		}
	}

	$html = 	"<br />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"/crm/auftraege-neues-geraet/" . intval($param['order_id']) . "\" method=\"post\">\n" . 

				"					<div class=\"form-group row d-none\">\n" . 
				"						<label for=\"storage_space_owner\" class=\"col-sm-6 col-form-label\">Lagerplatz erstellt</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"storage_space_owner_1\" name=\"storage_space_owner\" class=\"custom-select d-none\">\n" . 
				"								<option value=\"0\">Bitte wählen</option>\n" . 

				$options_storage_space_owner . 

				"							</select>\n" . 
				"							<input type=\"text\" id=\"storage_space_owner\" name=\"storage_space_owner_1\" value=\"" . $storage_space_owner_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"component\" class=\"col-sm-6 col-form-label\">Defektes Bauteil</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"manufacturer\" class=\"col-sm-6 col-form-label\">Hersteller</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $manufacturer : strtoupper($row_device["manufacturer"])) . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"serial\" class=\"col-sm-6 col-form-label\">Teile.-/Herstellernummer</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $serial : $row_device["serial"]) . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"additional_numbers\" class=\"col-sm-6 col-form-label\">Zusätzliche Nummern</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"additional_numbers\" name=\"additional_numbers\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $additional_numbers : $row_device["additional_numbers"]) . "\" class=\"form-control" . $inp_additional_numbers . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"						<div class=\"col-sm-6 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"fromthiscar_yes\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"fromthiscar_no\">\n" . 
				"									Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 1 ? "<span class=\"badge-pill badge-danger\">Wurde durch Kunde geöffnet</span>" : "Wurde durch Kunde geöffnet") . "</label>\n" . 
				"						<div class=\"col-sm-6 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"open_by_user_yes\" name=\"open_by_user\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"open_by_user_yes\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"open_by_user_no\" name=\"open_by_user\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"open_by_user_no\">\n" . 
				"									Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Andere Bauteile am Gerät</label>\n" . 
				"						<div class=\"col-sm-6 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"other_components_yes\" name=\"other_components\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"other_components_yes\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"other_components_no\" name=\"other_components\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"other_components_no\">\n" . 
				"									Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"info\" class=\"col-sm-12 col-form-label\">Hinweis</label>\n" . 
				"						<div class=\"col-sm-12 text-right\">\n" . 
				"							<textarea id=\"info\" name=\"info\" style=\"height: 80px\" class=\"form-control" . $inp_info . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#info_length').html(this.value.length);\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $info : $row_device["info"]) . "</textarea>\n" . 
				"							<small>(<span id=\"info_length\">" . strlen(isset($_POST['update']) && $_POST['update'] == "speichern" ? $info : $row_device["info"]) . "</span> von 700 Zeichen)</small>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"storage_space\" class=\"col-sm-6 col-form-label\">Lagerplatz</label>\n" . 
				"						<div class=\"col-sm-2\">\n" . 
				"							" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $storage_space : $row_device["storage_space"]) . "\n" . 
				"							<input type=\"text\" id=\"storage_space\" name=\"storage_space\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $storage_space : $row_device["storage_space"]) . "\" class=\"form-control d-none " . $inp_storage_space . "\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<select id=\"storage_space_id\" name=\"storage_space_id\" class=\"custom-select\">\n" . 

				$options_storage_places . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_number\" value=\"" . $row_order['order_number'] . "\" />\n" . 
				"							<button type=\"submit\" name=\"at\" value=\"setzen\" class=\"btn btn-primary\">Austauschteil <i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"ot\" value=\"setzen\" class=\"btn btn-primary\">Originalteil <i class=\"fa fa-certificate\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n";

}

?>