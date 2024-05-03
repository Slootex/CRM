<?php 

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
$inp_radio_technic_1 = "";
$inp_radio_technic_2 = "";
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
$radio_technic_1 = 0;
$radio_technic_2 = 0;
$info = "";
$storage_space = "";

$emsg = "";

$list = "";

$text_color = "text-secondary";

if(isset($param['order_id']) && isset($param['device_id'])){

	$_POST['id'] = intval($param['device_id']);

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['at']) && $_POST['at'] == "setzen"){
	
	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`atot_mode`='0', 
									`order_orders_devices`.`at`='0', 
									`order_orders_devices`.`ot`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$row_d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$atot_number = 0;

	for($i = 1;$i < 100;$i++){

		$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_d['order_id'])) . "' AND `order_orders_devices`.`atot_mode`='1' AND `order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

		if(!isset($row_device['id'])){
			$atot_number = $i;
			break;
		}

	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`atot_mode`='1', 
									`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($atot_number)) . "', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['ot']) && $_POST['ot'] == "setzen"){

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`atot_mode`='0', 
									`order_orders_devices`.`at`='0', 
									`order_orders_devices`.`ot`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$row_d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$atot_number = 0;

	for($i = 1;$i < 100;$i++){

		$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_d['order_id'])) . "' AND `order_orders_devices`.`atot_mode`='2' AND `order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

		if(!isset($row_device['id'])){
			$atot_number = $i;
			break;
		}

	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`atot_mode`='2', 
									`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($atot_number)) . "', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['edit'] = "bearbeiten";

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

	if(strlen($_POST['radio_technic_1']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie für Technikerfrage 1 aus. (max. 256 Zeichen)</small><br />\n";
		$inp_radio_technic_1 = " is-invalid";
	} else {
		$radio_technic_1 = intval($_POST['radio_technic_1']);
	}

	if(strlen($_POST['radio_technic_2']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie für Technikerfrage 2 aus. (max. 256 Zeichen)</small><br />\n";
		$inp_radio_technic_2 = " is-invalid";
	} else {
		$radio_technic_2 = intval($_POST['radio_technic_2']);
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

	if($row_device['is_storage'] == 1 || $row_device['is_shopin_relocate'] == 1 || $row_device['is_labeling'] == 1 || $row_device['is_photo'] == 1 || $row_device['is_shipping_user'] == 1 || $row_device['is_shipping_technic'] == 1 || $row_device['is_relocate'] == 1){
		$emsg .= "<small class=\"error text-muted\">Es kann nicht gespeichert werden da schon ein Vorgang für dieses Gerät besteht!</small><br />\n";
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
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
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
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz hinzugefügt, " . $row_storage_place['name'] . ", ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz hinzugefügt, " . $row_storage_place['name'] . ", ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Lagerplatz " . $row_storage_place['name'] . " hinzugefügt, ID [#" . $row_device['id'] . "]</span>") . "', 
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
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
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
								SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, $order_id) . "', 
										`order_orders_devices`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
										`order_orders_devices`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
										`order_orders_devices`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
										`order_orders_devices`.`additional_numbers`='" . mysqli_real_escape_string($conn, $additional_numbers) . "', 
										`order_orders_devices`.`fromthiscar`='" . mysqli_real_escape_string($conn, $fromthiscar) . "', 
										`order_orders_devices`.`open_by_user`='" . mysqli_real_escape_string($conn, $open_by_user) . "', 
										`order_orders_devices`.`other_components`='" . mysqli_real_escape_string($conn, intval($other_components)) . "', 
										`order_orders_devices`.`radio_technic_1`='" . mysqli_real_escape_string($conn, intval($radio_technic_1)) . "', 
										`order_orders_devices`.`radio_technic_2`='" . mysqli_real_escape_string($conn, intval($radio_technic_2)) . "', 
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

		mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
								SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-warning\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " geändert, ID [#" . $row_device['id'] . "]</span>") . "', 
										`order_orders_devices_events`.`subject`='', 
										`order_orders_devices_events`.`body`='', 
										`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Das Gerät wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['is_send']) && $_POST['is_send'] == "nein"){

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`is_send`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

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

	$html .= 	"<br />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"/crm/auftraege/" . intval($row_device['order_id']) . "/geraete/" . intval($row_device['id']) . "\" method=\"post\">\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"storage_space\" class=\"col-sm-6 col-form-label\">Lagerplatz</label>\n" . 
				"						<div class=\"col-sm-2 mt-2\">\n" . 
				"							<strong>" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $storage_space : $row_device["storage_space"]) . "</strong>\n" . 
				"							<input type=\"text\" id=\"storage_space\" name=\"storage_space\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $storage_space : $row_device["storage_space"]) . "\" class=\"form-control d-none " . $inp_storage_space . "\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<select id=\"storage_space_id\" name=\"storage_space_id\" class=\"custom-select\">\n" . 
				$options_storage_places . 
				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

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
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 0 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $fromthiscar : $row_device["fromthiscar"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 1 ? "<span class=\"badge-pill badge-danger\">Wurde durch Kunde geöffnet</span>" : "Wurde durch Kunde geöffnet") . "</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"open_by_user_yes\" name=\"open_by_user\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 0 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"open_by_user_no\" name=\"open_by_user\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $open_by_user : $row_device["open_by_user"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Andere Bauteile am Gerät</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"other_components_yes\" name=\"other_components\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 0 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"other_components_no\" name=\"other_components\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $other_components : $row_device["other_components"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Technikerfrage 1</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_1 : $row_device["radio_technic_1"]) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"radio_technic_1_yes\" name=\"radio_technic_1\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_1 : $row_device["radio_technic_1"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_1 : $row_device["radio_technic_1"]) == 0 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"radio_technic_1_no\" name=\"radio_technic_1\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_1 : $row_device["radio_technic_1"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Technikerfrage 2</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_2 : $row_device["radio_technic_2"]) == 1 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"radio_technic_2_yes\" name=\"radio_technic_2\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_2 : $row_device["radio_technic_2"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Ja\n" . 
				"								</label>\n" . 
				"								<label class=\"btn btn-light border border-secondary" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_2 : $row_device["radio_technic_2"]) == 0 ? " active" : "") . "\">\n" . 
				"									<input type=\"radio\" id=\"radio_technic_2_no\" name=\"radio_technic_2\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_technic_2 : $row_device["radio_technic_2"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" /> Nein\n" . 
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

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_number\" value=\"" . $row_order['order_number'] . "\" />\n" . 
				"							<div class=\"btn-group border\">\n" . 
				"								<button type=\"submit\" name=\"at\" value=\"setzen\" class=\"btn btn-light\">Austauschteil <i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i></button>\n" . 
				"								<button type=\"submit\" name=\"ot\" value=\"setzen\" class=\"btn btn-warning\">Originalteil <i class=\"fa fa-certificate\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				($row_device['is_send'] == 1 ? 
					"							<button type=\"submit\" name=\"is_send\" value=\"nein\" class=\"btn btn-primary\">Noch nicht versendet <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n"
				: 
					""
				) . 
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