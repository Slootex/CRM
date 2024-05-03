<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "storage_overview";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$storage_overview_session = "storage_overview_search";

if(isset($_POST["sorting_field"])){$_SESSION[$storage_overview_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$storage_overview_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$storage_overview_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$storage_overview_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["room_id"])){$_SESSION["room"]["id"] = intval($_POST["room_id"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$storage_overview_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`companies`.`name`"
);
$sorting[] = array(
	"name" => "Thema", 
	"value" => "`companies_themes`.`name`"
);
$sorting[] = array(
	"name" => "Anmelde-Slug", 
	"value" => "`companies`.`login_slug`"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`companies`.`time` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`companies`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$storage_overview_session]["sorting_field"]) ? $sorting[$_SESSION[$storage_overview_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$storage_overview_session]["sorting_field"]) ? $_SESSION[$storage_overview_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$storage_overview_session]["sorting_direction"]) ? $directions[$_SESSION[$storage_overview_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$storage_overview_session]["sorting_direction"]) ? $_SESSION[$storage_overview_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$storage_overview_session]["rows"]) && $_SESSION[$storage_overview_session]["rows"] > 0 ? $_SESSION[$storage_overview_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_device_number = "";

$device_number = "";

$arr_area = array('Aufträge-Aktiv', 'Aufträge-Archiv', 'Interessenten-Aktiv', 'Interessenten-Archiv');

$arr_edit_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

$arr_shopin_area = array('Wareneingang-Aktiv', 'Wareneingang-Archiv');

$arr_shopin_edit_url = array('neue-packtische', 'packtische-archiv');

$arr_intern_area = array('Intern-Aktiv', 'Intern-Archiv');

$arr_intern_edit_url = array('neue-packtische', 'packtische-archiv');

$time = time();

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if($emsg == ""){

		$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['place_id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_storage_place['id']) && $row_storage_place['id'] > 0){

			if($row_device['storage_space_id'] > 0){

				mysqli_query($conn, "	UPDATE 	`storage_places` 
										SET 	`storage_places`.`used`=`storage_places`.`used`-1 
										WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
										AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			}

			mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
									SET 	`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($row_storage_place['name'])) . "', 
											`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "', 
											`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
									AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			mysqli_query($conn, "	UPDATE 	`storage_places` 
									SET 	`storage_places`.`used`=`storage_places`.`used`+1 
									WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "' 
									AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			$emsg = "<p>Die Einlagerung wurde erfolgreich geändert!</p>\n";

		}else{

			$emsg = "<p>Bitte wählen Sie einen freien Lagerplatz für dieses Gerät!</p>\n";

		}

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['update_shopin']) && $_POST['update_shopin'] == "speichern"){

	if(strlen($_POST['device_number']) < 1 || strlen($_POST['device_number']) > 8){
		$emsg .= "<span class=\"error\">Bitte eine Gerätsnummer für einen Platzbereich des Lagerplatzes eingeben. (max. 8 Zeichen)</span><br />\n";
		$inp_device_number = " is-invalid";
	} else {
		$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`help_device_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['device_number'])) . "'"), MYSQLI_ASSOC);
		if(isset($row_device['id']) && $row_device['id'] > 0){
			$device_number = intval($_POST['device_number']);
		}else{
			$emsg .= "<span class=\"error\">Die Gerätsnummer für einen Platzbereich des Lagerplatzes wurde nicht gefunden.</span><br />\n";
			$inp_device_number = " is-invalid";
		}
	}

	if($emsg == ""){

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['place_id'])) . "'"), MYSQLI_ASSOC);

		if($row_device['storage_space_id'] != intval($_POST['place_id'])){

			mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
									SET 	`shopin_shopins`.`admin`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['place_id']) ? $_POST['place_id'] : 0)) . "', 
											`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
									AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			mysqli_query($conn, "	UPDATE 	`storage_places` 
									SET 	`storage_places`.`used`=`storage_places`.`used`+1 
									WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['place_id'])) . "' 
									AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			if($row_device['storage_space_id'] > 0){

				mysqli_query($conn, "	UPDATE 	`storage_places` 
										SET 	`storage_places`.`used`=`storage_places`.`used`-1 
										WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
										AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			}

		}else{
			
			mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
									SET 	`order_orders_devices`.`admin`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, (isset($_POST['place_id']) ? intval($_POST['place_id']) : 0)) . "', 
											`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
									AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}

		$emsg = "<p>Die Lagerplatz einlagerung wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit_shopin'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`storage_space`='', 
									`order_orders_devices`.`storage_space_id`='0', 
									`order_orders_devices`.`storage_space_owner`='0', 
									`order_orders_devices`.`storage_space_date`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	if($row_device['storage_space_id'] > 0){

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`used`=`storage_places`.`used`-1 
								WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
								AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete_shopin']) && $_POST['delete_shopin'] == "entfernen"){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");

	if($row_device['storage_space_id'] > 0){

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`used`=`storage_places`.`used`-1 
								WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
								AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

}


if(isset($_POST['prog1']) && $_POST['prog1'] == "device_next"){

	$place = array();

	$i = 0;
	foreach($_SESSION['places'] as $key => $val){
		if($i == $_SESSION['places_step']){
			$place = $_SESSION['places'][$key];
			break;
		}
		$i++;
	}

	$i = 0;
	foreach($_SESSION['devices'] as $key => $val){
		if($place['id'] == $_SESSION['devices'][$key]['place_id']){
			if($i == $_SESSION['devices_step']){
				$device = $_SESSION['devices'][$key];
			}
			$i++;
		}
	}

	if(($_SESSION['devices_step'] + 1) < $i){
		$_SESSION['devices_step']++;
		$_POST['prog1'] = "place_step";
	}else if(($_SESSION['places_step'] + 1) < count($_SESSION['places'])){
		$_SESSION['devices_step'] = 0;
		$_SESSION['places_step']++;
		$_POST['prog1'] = "place_step";
	}else{
		$_POST['prog1'] = "ready";
	}

}

if(isset($_POST['prog1']) && $_POST['prog1'] == "device_delete"){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");


	if($row_device['storage_space_id'] > 0){

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`used`=`storage_places`.`used`-1 
								WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
								AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

	$place = array();

	$i = 0;
	foreach($_SESSION['places'] as $key => $val){
		if($i == $_SESSION['places_step']){
			$place = $_SESSION['places'][$key];
			break;
		}
		$i++;
	}

	$i = 0;
	foreach($_SESSION['devices'] as $key => $val){
		if($place['id'] == $_SESSION['devices'][$key]['place_id']){
			if($i == $_SESSION['devices_step']){
				$device = $_SESSION['devices'][$key];
			}
			$i++;
		}
	}

	if(($_SESSION['devices_step'] + 1) < $i){
		$_SESSION['devices_step']++;
		$_POST['prog1'] = "place_step";
	}else if(($_SESSION['places_step'] + 1) < count($_SESSION['places'])){
		$_SESSION['devices_step'] = 0;
		$_SESSION['places_step']++;
		$_POST['prog1'] = "place_step";
	}else{
		$_POST['prog1'] = "ready";
	}

}

if(isset($_POST['prog1']) && $_POST['prog1'] == "has_next_place"){

	if(($_SESSION['places_step'] + 1) < count($_SESSION['places'])){

		$_POST['prog1'] = "place_step";

	}else{

		$_POST['prog1'] = "ready";

	}

}


if(isset($_POST['prog2']) && $_POST['prog2'] == "has_next_place"){

	if(($_SESSION['places_step'] + 1) < count($_SESSION['places'])){

		$_POST['prog2'] = "place_step";

	}else{

		$_POST['prog2'] = "ready";

	}

}

if(isset($_POST['prog2']) && $_POST['prog2'] == "place_next"){

	if(($_SESSION['places_step'] + 1) < count($_SESSION['places'])){

		$_SESSION['places_step']++;

		$_POST['prog2'] = "place_step";

	}else{

		$_POST['prog2'] = "delete_system_devices";

	}

}

if(isset($_POST['prog2']) && $_POST['prog2'] == "delete_system_devices"){

	$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
														`order_orders_devices`.`device_number` AS device_number, 
														`order_orders_devices`.`atot_mode` AS atot_mode, 
														`order_orders_devices`.`at` AS at, 
														`order_orders_devices`.`ot` AS ot, 
														`order_orders_devices`.`storage_space_id` AS storage_space_id 
											FROM 		`order_orders_devices` `order_orders_devices` 
											WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	while($row_devices = $result_devices->fetch_array(MYSQLI_ASSOC)){

		$found = false;

		foreach($_SESSION['storage_devices'] as $key => $val){

			if(	$row_devices['device_number'] == $_SESSION['storage_devices'][$key]['device_number'] && 
				$row_devices['atot_mode'] == $_SESSION['storage_devices'][$key]['atot_mode'] && 
				$row_devices['at'] == $_SESSION['storage_devices'][$key]['at'] && 
				$row_devices['ot'] == $_SESSION['storage_devices'][$key]['ot']){

				if($row_devices['storage_space_id'] > 0){
					
					mysqli_query($conn, "	UPDATE 	`storage_places` 
											SET 	`storage_places`.`used`=`storage_places`.`used`-1 
											WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_devices['storage_space_id'])) . "' 
											AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
					
				}

				mysqli_query($conn, "	UPDATE 	`storage_places` 
										SET 	`storage_places`.`used`=`storage_places`.`used`+1 
										WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION['storage_devices'][$key]['place_id'])) . "' 
										AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`fnd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
												`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['storage_devices'][$key]['place_id'])) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_devices['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				$found = true;

			}

		}

		if($found == false){

			mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
									WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
									AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_devices['id'])) . "'");

			if($row_devices['storage_space_id'] > 0){

				mysqli_query($conn, "	UPDATE 	`storage_places` 
										SET 	`storage_places`.`used`=`storage_places`.`used`-1 
										WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_devices['storage_space_id'])) . "' 
										AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			}

		}

	}

	$_SESSION['storage_devices'] = array();

	$_POST['prog2'] = "ready";

}


if(isset($_POST['prog3']) && $_POST['prog3'] == "devices_to_places"){

	mysqli_query($conn, "	UPDATE 	`storage_places` 
							SET 	`storage_places`.`used`='0' 
							WHERE 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
														`order_orders_devices`.`device_number` AS device_number, 
														`order_orders_devices`.`atot_mode` AS atot_mode, 
														`order_orders_devices`.`at` AS at, 
														`order_orders_devices`.`ot` AS ot, 
														`order_orders_devices`.`storage_space_id` AS storage_space_id 
											FROM 		`order_orders_devices` `order_orders_devices` 
											WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	while($row_devices = $result_devices->fetch_array(MYSQLI_ASSOC)){

		if($row_devices['storage_space_id'] > 0){

			mysqli_query($conn, "	UPDATE 	`storage_places` 
									SET 	`storage_places`.`used`=`storage_places`.`used`+1 
									WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_devices['storage_space_id'])) . "' 
									AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}

	}

}


if(isset($_POST['prog4']) && $_POST['prog4'] == "delete_devices"){

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	UPDATE 	`storage_places` 
							SET 	`storage_places`.`used`='0' 
							WHERE 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$_POST['prog4'] = "init";

}

if(isset($_POST['prog4']) && $_POST['prog4'] == "check_place"){

	$row_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['place_name'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_place['id']) && $row_place['id'] > 0){

		$_SESSION['place'] = array(
			"id" => $row_place['id'], 
			"name" => $row_place['name']
		);

		$_POST['prog4'] = "next_device";

	}else{

		$emsg = "<p class=\"text-danger\">Der angegebene Lagerplatz wurde nicht gefunden!</p>\n";

		$_POST['prog4'] = "next_place";

	}

}

if(isset($_POST['prog4']) && $_POST['prog4'] == "check_device"){

	if(isset($_POST['full_device_name']) && $_POST['full_device_name'] != ""){

		$device = explode("-", strip_tags($_POST['full_device_name']));

		if(count($device) == 4){

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0])) . "'"), MYSQLI_ASSOC);

			if(isset($row_order['id']) && $row_order['id'] > 0){

				$atot_mode = $device[2] == "AT" ? 1 : 2;

				$device_number = $device[0] . "-" . $device[1];

				$at_or_ot_field = $device[2] == "AT" ? "at" : "ot";

				$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																		FROM	`order_orders_devices` 
																		WHERE	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 	`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
																		AND 	`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "' 
																		AND 	`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "' 
																		AND 	`order_orders_devices`.`" . $at_or_ot_field . "`='" . mysqli_real_escape_string($conn, intval($device[3])) . "'"), MYSQLI_ASSOC);

				if(isset($row_device['id']) && $row_device['id'] > 0){

					if($row_device['storage_space_id'] > 0){
					
						mysqli_query($conn, "	UPDATE 	`storage_places` 
												SET 	`storage_places`.`used`=`storage_places`.`used`-1 
												WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
												AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
					
					}

					mysqli_query($conn, "	UPDATE 	`storage_places` 
											SET 	`storage_places`.`used`=`storage_places`.`used`+1 
											WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
											AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
											SET 	`order_orders_devices`.`fnd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
											WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
											AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					$emsg = "<p class=\"text-success\">Das Gerät " . strip_tags($_POST['full_device_name']) . " existiert im System!</p>\n";

				}else{
					
					$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

					mysqli_query($conn, "	UPDATE 	`storage_places` 
											SET 	`storage_places`.`used`=`storage_places`.`used`+1 
											WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
											AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					mysqli_query($conn, "	INSERT 	`order_orders_devices` 
											SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0] . "-" . $device[1])) . "', 
													`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "', 
													`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($atot_mode == 1 ? $device[3] : 0)) . "', 
													`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($atot_mode == 2 ? $device[3] : 0)) . "', 
													`order_orders_devices`.`component`='0', 
													`order_orders_devices`.`manufacturer`='', 
													`order_orders_devices`.`serial`='', 
													`order_orders_devices`.`additional_numbers`='', 
													`order_orders_devices`.`fromthiscar`='0', 
													`order_orders_devices`.`open_by_user`='0', 
													`order_orders_devices`.`other_components`='0', 
													`order_orders_devices`.`info`='', 
													`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['place']['name'])) . "', 
													`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "', 
													`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
													`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$emsg = "<p class=\"text-danger\">Das Gerät existiert NICHT im System !<br />Gerät " . strip_tags($_POST['full_device_name']) . " wurde angelegt!</p>\n";

				}

			}else{

				$emsg = "<p class=\"text-danger\">Der Auftrag des Geräts existiert NICHT im System !<br />Nehmen Sie das Gerät aus dem Platz und Wählen Sie für das Gerät &quot;kein Barcode&quot;!</p>\n";

			}


		}else{

			$emsg = "<p class=\"text-danger\">Die Gerätenummer ist nicht vollständig!</p>\n";

		}

	}else{

		$emsg = "<p class=\"text-danger\">Bitte ein Gerät eintragen, das Eingabefeld war leer!</p>\n";

	}

	$_POST['prog4'] = "next_device";

}


if(isset($_POST['prog5']) && $_POST['prog5'] == "delete_devices"){

	if(isset($_POST['password']) && strip_tags($_POST['password']) == $maindata['super_password']){

		mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
								WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_devices`.`storage_space_id`>'0'");

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`used`='0' 
								WHERE 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p class=\"text-success\">Das entfernen war erfolgreich!</p>";

	}else{

		$emsg = "<p class=\"text-danger\">Das Kennwort ist falsch!</p>";

	}

	$_POST['prog5'] = "init";

}

if(isset($_POST['prog5']) && $_POST['prog5'] == "check_device"){

	$row_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['place_name'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_place['id']) && $row_place['id'] > 0){

		$_SESSION['place'] = array(
			"id" => $row_place['id'], 
			"name" => $row_place['name']
		);

		if(isset($_POST['full_device_name']) && $_POST['full_device_name'] != ""){

			$device = explode("-", strip_tags($_POST['full_device_name']));

			if(count($device) == 4){

				$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0])) . "'"), MYSQLI_ASSOC);

				if(isset($row_order['id']) && $row_order['id'] > 0){

					$atot_mode = $device[2] == "AT" ? 1 : 2;

					$device_number = $device[0] . "-" . $device[1];

					$at_or_ot_field = $device[2] == "AT" ? "at" : "ot";

					$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																			FROM	`order_orders_devices` 
																			WHERE	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 	`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
																			AND 	`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "' 
																			AND 	`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "' 
																			AND 	`order_orders_devices`.`" . $at_or_ot_field . "`='" . mysqli_real_escape_string($conn, intval($device[3])) . "'"), MYSQLI_ASSOC);

					if(isset($row_device['id']) && $row_device['id'] > 0){

						if($row_device['storage_space_id'] > 0){

							mysqli_query($conn, "	UPDATE 	`storage_places` 
													SET 	`storage_places`.`used`=`storage_places`.`used`-1 
													WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "' 
													AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

						}

						mysqli_query($conn, "	UPDATE 	`storage_places` 
												SET 	`storage_places`.`used`=`storage_places`.`used`+1 
												WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
												AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

						mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
												SET 	`order_orders_devices`.`fnd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
														`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
												WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
												AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

						$emsg = "<p class=\"text-success\">Das Gerät " . strip_tags($_POST['full_device_name']) . " existiert im System!</p>\n";

					}else{
					
						$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

						mysqli_query($conn, "	UPDATE 	`storage_places` 
												SET 	`storage_places`.`used`=`storage_places`.`used`+1 
												WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "' 
												AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

						mysqli_query($conn, "	INSERT 	`order_orders_devices` 
												SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
														`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0] . "-" . $device[1])) . "', 
														`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "', 
														`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($atot_mode == 1 ? $device[3] : 0)) . "', 
														`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($atot_mode == 2 ? $device[3] : 0)) . "', 
														`order_orders_devices`.`component`='0', 
														`order_orders_devices`.`manufacturer`='', 
														`order_orders_devices`.`serial`='', 
														`order_orders_devices`.`additional_numbers`='', 
														`order_orders_devices`.`fromthiscar`='0', 
														`order_orders_devices`.`open_by_user`='0', 
														`order_orders_devices`.`other_components`='0', 
														`order_orders_devices`.`info`='', 
														`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['place']['name'])) . "', 
														`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['place']['id'])) . "', 
														`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
														`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
														`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
														`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

						$emsg = "<p class=\"text-success\">Das Gerät existiert NICHT im System !<br />Gerät " . strip_tags($_POST['full_device_name']) . " wurde angelegt!</p>\n";

					}

				}else{

					$emsg = "<p class=\"text-danger\">Der Auftrag des Geräts existiert NICHT im System !<br />Nehmen Sie das Gerät aus dem Platz und Wählen Sie für das Gerät &quot;kein Barcode&quot;!</p>\n";

				}

			}else{

				$emsg = "<p class=\"text-danger\">Die Gerätenummer ist nicht vollständig!</p>\n";

			}

		}else{

			$emsg = "<p class=\"text-danger\">Bitte ein Gerät eintragen, das Eingabefeld war leer!</p>\n";

		}

	}else{

		$emsg = "<p class=\"text-danger\">Der angegebene Lagerplatz wurde nicht gefunden!</p>\n";

	}

	$_POST['prog5'] = "next_device";

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['prog1']) && !isset($_POST['prog2']) && !isset($_POST['prog3']) && !isset($_POST['prog4']) && !isset($_POST['prog5']) && !isset($_POST['edit_shopin']) && !isset($_POST['save']) && !isset($_POST['update']) && !isset($_POST['update_shopin'])){

	if(intval($_SESSION["room"]["id"]) == 0){

		$result_room = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`extra`='0' ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	}else{

		$result_room = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["room"]["id"])) . "' ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	}

	while($row_room = $result_room->fetch_array(MYSQLI_ASSOC)){

		$result_place = mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($row_room['id'])) . "' ORDER BY CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

		while($row_place = $result_place->fetch_array(MYSQLI_ASSOC)){

			$where = 	isset($_SESSION[$storage_overview_session]["keyword"]) && $_SESSION[$storage_overview_session]["keyword"] != "" ? 
						"WHERE 	(`order_orders_devices`.`device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%' 
						OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%') " : 
						"WHERE 	`order_orders_devices`.`id`>0";

			$query = "	SELECT 		`order_orders_devices`.`id` AS id, 
									`order_orders_devices`.`atot_mode` AS atot_mode, 
									`order_orders_devices`.`at` AS at, 
									`order_orders_devices`.`ot` AS ot, 
									`order_orders_devices`.`order_id` AS order_id, 
									`order_orders_devices`.`device_number` AS device_number, 
									`order_orders_devices`.`fnd_date` AS fnd_date, 
									`order_orders_devices`.`upd_date` AS upd_date, 
									`order_orders`.`mode` AS mode, 
									`order_orders`.`order_number` AS order_number, 
									(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_devices`.`admin_id`) AS admin_name 
						FROM 		`order_orders_devices` 
						LEFT JOIN	`order_orders` 
						ON			`order_orders`.`id`=`order_orders_devices`.`order_id` 
						" . $where . " 
						AND 		`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_place['id'])) . "' 
						AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
						ORDER BY 	`order_orders_devices`.`device_number` " . $sorting_direction_name;

			$result_devices = mysqli_query($conn, $query);

			$rows = $result_devices->num_rows;

			$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows, 
												$pos, 
												$amount_rows, 
												"/pos", 
												$page['url'] . "/" . intval($_SESSION["room"]["id"]), 
												$getParam = "", 
												10, 
												1);

			$query .= " limit " . $pos . ", " . $amount_rows;

			$result_devices = mysqli_query($conn, $query);

			$i = 1;

			while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

				$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
							"	<tr" . (isset($_POST['device_id']) && $_POST['device_id'] == $row_device['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['id'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . date("d.m.Y (H:i)", intval($row_device['upd_date'])) . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_room['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_place['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>Auftragsgerät</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\">\n" . 
							"			<span>" . $row_device['admin_name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<a href=\"/crm/" . $arr_edit_url[$row_device['mode']] . "/bearbeiten/" . $row_device['order_id'] . "\">" . $row_device['order_number'] . " <i class=\"fa fa-external-link\"></i></a>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . ($row_device['fnd_date'] != "" ? date("d.m.Y (H:i)", intval($row_device['fnd_date'])) : "noch keine") . "</span>\n" . 
							"		</td>\n" . 
							"		<td align=\"center\">\n" . 
							"			<input type=\"hidden\" name=\"room_id\" value=\"" . $row_place['room_id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"place_id\" value=\"" . $row_place['id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"device_id\" value=\"" . $row_device['id'] . "\" />\n" . 
							"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
							"		</td>\n" . 
							"	</tr>\n" . 
							"</form>\n";

				$i++;

			}

			$where = 	isset($_SESSION[$storage_overview_session]["keyword"]) && $_SESSION[$storage_overview_session]["keyword"] != "" ? 
						"WHERE 	(`shopin_shopins`.`help_device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%' 
						OR		`shopin_shopins`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%') " : 
						"WHERE 	`shopin_shopins`.`id`>0";

			$query = "	SELECT 		`shopin_shopins`.`id` AS id, 
									`shopin_shopins`.`mode` AS mode, 
									`shopin_shopins`.`type` AS type, 
									`shopin_shopins`.`order_id` AS order_id, 
									`shopin_shopins`.`order_number` AS order_number, 
									`shopin_shopins`.`help_device_number` AS device_number, 
									`shopin_shopins`.`upd_date` AS upd_date, 
									(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`shopin_shopins`.`admin_id`) AS admin_name 
						FROM 		`shopin_shopins` 
						" . $where . " 
						AND 		`shopin_shopins`.`mode`='0' 
						AND 		`shopin_shopins`.`type`>'0' 
						AND 		`shopin_shopins`.`type`<'4' 
						AND 		`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_place['id'])) . "' 
						AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
						ORDER BY 	`shopin_shopins`.`order_number` " . $sorting_direction_name;

			$result_devices = mysqli_query($conn, $query);

			$rows = $result_devices->num_rows;

			$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows, 
												$pos, 
												$amount_rows, 
												"/pos", 
												$page['url'] . "/" . intval($_SESSION["room"]["id"]), 
												$getParam = "", 
												10, 
												1);

			$query .= " limit " . $pos . ", " . $amount_rows;

			$result_devices = mysqli_query($conn, $query);

			while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

				$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
							"	<tr>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['id'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . date("d.m.Y (H:i)", intval($row_device['upd_date'])) . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_room['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_place['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>WE-Hilfsgerät</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\">\n" . 
							"			<span>" . $row_device['admin_name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<a href=\"/crm/" . $arr_shopin_edit_url[$row_device['mode']] . "/we-bearbeiten-" . $row_device['type'] . "/" . $row_device['id'] . "\">" . $row_device['device_number'] . " <i class=\"fa fa-external-link\"></i></a>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['order_number'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>&nbsp;</span>\n" . 
							"		</td>\n" . 
							"		<td align=\"center\">\n" . 
							"			<input type=\"hidden\" name=\"room_id\" value=\"" . $row_place['room_id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"place_id\" value=\"" . $row_place['id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"device_id\" value=\"" . $row_device['id'] . "\" />\n" . 
							"			<button type=\"submit\" name=\"edit_shopin\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
							"		</td>\n" . 
							"	</tr>\n" . 
							"</form>\n";

				$i++;

			}

			$where = 	isset($_SESSION[$storage_overview_session]["keyword"]) && $_SESSION[$storage_overview_session]["keyword"] != "" ? 
						"WHERE 	(`intern_interns`.`help_device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%' 
						OR		`intern_interns`.`intern_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_overview_session]["keyword"]) . "%') " : 
						"WHERE 	`intern_interns`.`id`>0";

			$query = "	SELECT 		`intern_interns`.`id` AS id, 
									`intern_interns`.`mode` AS mode, 
									`intern_interns`.`order_id` AS order_id, 
									`intern_interns`.`intern_number` AS intern_number, 
									`intern_interns`.`upd_date` AS upd_date, 
									(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`intern_interns`.`order_id`) AS order_mode, 
									(SELECT `order_orders`.`order_number` AS o_order_number FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`intern_interns`.`order_id`) AS order_number, 
									(SELECT `order_orders_devices`.`device_number` AS o_o_device_number FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS device_number, 
									(SELECT `order_orders_devices`.`atot_mode` AS d_mode FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS atot_mode, 
									(SELECT `order_orders_devices`.`at` AS d_at FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS at, 
									(SELECT `order_orders_devices`.`ot` AS d_ot FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS ot, 
									(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`intern_interns`.`admin_id`) AS admin_name 
						FROM 		`intern_interns` 
						" . $where . " 
						AND 		`intern_interns`.`to_storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_place['id'])) . "' 
						AND 		`intern_interns`.`mode`='0' 
						AND 		`intern_interns`.`type`='2' 
						AND 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
						ORDER BY 	`intern_interns`.`intern_number` " . $sorting_direction_name;

			$result_devices = mysqli_query($conn, $query);

			$rows = $result_devices->num_rows;

			$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows, 
												$pos, 
												$amount_rows, 
												"/pos", 
												$page['url'] . "/" . intval($_SESSION["room"]["id"]), 
												$getParam = "", 
												10, 
												1);

			$query .= " limit " . $pos . ", " . $amount_rows;

			$result_devices = mysqli_query($conn, $query);

			while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

				$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
							"	<tr>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['id'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . date("d.m.Y (H:i)", intval($row_device['upd_date'])) . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_room['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_place['name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>Umlagerung-Zielplatz</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\">\n" . 
							"			<span>" . $row_device['admin_name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<a href=\"/crm/" . $arr_intern_edit_url[$row_device['mode']] . "/intern-bearbeiten/" . $row_device['id'] . "\">" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " <i class=\"fa fa-external-link\"></i></a>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<a href=\"/crm/" . $arr_edit_url[$row_device['order_mode']] . "/bearbeiten/" . $row_device['order_id'] . "\">" . $row_device['order_number'] . " <i class=\"fa fa-external-link\"></i></a>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>&nbsp;</span>\n" . 
							"		</td>\n" . 
							"		<td align=\"center\">\n" . 
							/*"			<input type=\"hidden\" name=\"room_id\" value=\"" . $row_place['room_id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"place_id\" value=\"" . $row_place['id'] . "\" />\n" . 
							"			<input type=\"hidden\" name=\"device_id\" value=\"" . $row_device['id'] . "\" />\n" . 
							"			<button type=\"submit\" name=\"edit_intern\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . */
							"		</td>\n" . 
							"	</tr>\n" . 
							"</form>\n";

				$i++;

			}

		}

	}

}

$result_pages = mysqli_query($conn, "	SELECT 	* 
										FROM	`storage_rooms` 
										WHERE	`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 	`storage_rooms`.`extra`='1' 
										ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

$rooms_options = "				<option value=\"0\">Alle Regale</option>\n";

while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$rooms_options .= "				<option value=\"" . $p["id"] . "\"" . (isset($_SESSION["room"]["id"]) && intval($p["id"]) == intval($_SESSION["room"]["id"]) ? " selected=\"selected\"" : "") . ">" . $p['name'] . "</option>\n";

}

$row_shopin_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`mode`='0'"), MYSQLI_ASSOC);
$row_intern_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `intern_interns`.`mode`='0'"), MYSQLI_ASSOC);
$row_packing_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`mode`='0'"), MYSQLI_ASSOC);

$show_buttons = $row_shopin_count['c'] == 0 && $row_intern_count['c'] == 0 && $row_packing_count['c'] == 0 ? true : false;

$navigation = new navigation($conn, 7, $page_right);
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link btn-lg\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link btn-lg active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<select id=\"room_id\" name=\"room_id\" class=\"custom-select custom-select-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\">\n" . 

		$rooms_options . 

		"				</select>\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$storage_overview_session]['keyword']) && $_SESSION[$storage_overview_session]['keyword'] != "" ? $_SESSION[$storage_overview_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: 0\" />\n" . 
		"				<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-success\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
		"			</div>\n" . 
		"			<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 50px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"				<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"				<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"					<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"					<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"					<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"					<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"					<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"					<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"					<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"					<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"					<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"				</select>\n" . 
		"				<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"				<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"				</select>\n" . 
		"				<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"				<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"					<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"				</select>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">\n" . 
		"		<h3>Lagerplatzübersicht</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		//"				<button type=\"submit\" name=\"prog1\" value=\"init\" class=\"btn btn-warning\"" . ($show_buttons == true ? "" : " disabled=\"disabled\"") . ">System --&gt; Lager <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		//"				<button type=\"submit\" name=\"prog2\" value=\"init\" class=\"btn btn-warning\">Prüfung 2 <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		//"				<button type=\"submit\" name=\"prog3\" value=\"init\" class=\"btn btn-warning\">Geräteplätze an Lagerplätze <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		//"				<button type=\"submit\" name=\"prog4\" value=\"init\" class=\"btn btn-warning\">Lager --&gt; System <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"prog5\" value=\"init\" class=\"btn btn-warning\"" . ($show_buttons == true ? "" : " disabled=\"disabled\"") . ">Inventur <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['prog1']) && !isset($_POST['prog2']) && !isset($_POST['prog3']) && !isset($_POST['prog4']) && !isset($_POST['prog5']) && !isset($_POST['edit_shopin']) && !isset($_POST['save']) && !isset($_POST['update']) && !isset($_POST['update_shopin'])){

	$html .= 	"<hr />\n" . 

				/*$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . */

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"70\" scope=\"col\" class=\"text-center\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"150\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Geändert</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Regal</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"110\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Lagerplatz</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"220\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Typ</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"180\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Gerätenummer</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Auftrag</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"150\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Inventur</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				//$pageNumberlist->getNavi() . 

				((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

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
			$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . (isset($_POST["place_id"]) && $row_place['id'] == intval($_POST["place_id"]) ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";
		}
		$options_storage_places .= "											</optgroup>\n";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"place_id\" class=\"col-sm-2 col-form-label\">Lagerplatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ein Lagerplatz aus unter dem das Geräteteil eingelagert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"place_id\" name=\"place_id\" class=\"custom-select\">" . $options_storage_places . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"device_number\" class=\"col-sm-2 col-form-label\">Gerätenummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Gerätenummer ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"device_number\" name=\"device_number\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $device_number : "") . "\" class=\"form-control" . $inp_device_number . "\" />\n" . 
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

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	$atot = $row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "");

	$row_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'"), MYSQLI_ASSOC);

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

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"place_id\" class=\"col-sm-2 col-form-label\">Lagerplatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ein Lagerplatz aus unter dem das Geräteteil eingelagert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"place_id\" name=\"place_id\" class=\"custom-select\">" . $options_storage_places . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"device_number\" class=\"col-sm-2 col-form-label\">Gerätenummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Gerätenummer einsehen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"device_number1\" name=\"device_number1\" value=\"" . $row_device["device_number"] . $atot . "\" class=\"form-control" . $inp_device_number . "\" disabled=\"disabled\" />\n" . 
				"							<input type=\"hidden\" id=\"device_number\" name=\"device_number\" value=\"" . $row_device["device_number"] . $atot . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"device_id\" value=\"" . (isset($_POST['device_id']) ? intval($_POST['device_id']) : 0) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">Lagerplatz entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['edit_shopin']) && $_POST['edit_shopin'] == "bearbeiten"){

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	$row_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['storage_space_id'])) . "'"), MYSQLI_ASSOC);

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
			$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . ($row_place['id'] == $row_shopin['storage_space_id'] ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";
		}
		$options_storage_places .= "											</optgroup>\n";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"place_id\" class=\"col-sm-2 col-form-label\">Lagerplatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ein Lagerplatz aus unter dem das Geräteteil eingelagert werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"place_id\" name=\"place_id\" class=\"custom-select\">" . $options_storage_places . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"device_number\" class=\"col-sm-2 col-form-label\">Gerätenummer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Gerätenummer einsehen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"device_number1\" name=\"device_number1\" value=\"" . (isset($_POST['update_shopin']) && $_POST['update_shopin'] == "speichern" ? $device_number : $row_shopin["help_device_number"]) . "\" class=\"form-control" . $inp_device_number . "\" disabled=\"disabled\" />\n" . 
				"							<input type=\"hidden\" id=\"device_number\" name=\"device_number\" value=\"" . (isset($_POST['update_shopin']) && $_POST['update_shopin'] == "speichern" ? $device_number : $row_shopin["help_device_number"]) . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"device_id\" value=\"" . (isset($_POST['device_id']) ? intval($_POST['device_id']) : 0) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update_shopin\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete_shopin\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}


if(isset($_POST['prog1']) && $_POST['prog1'] == "init"){

	$_SESSION['places'] = array();

	$_SESSION['devices'] = array();

	$_SESSION['we_devices'] = array();

	$_SESSION['we_help_devices'] = array();

	$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
												`storage_places`.`name` AS name, 
												(SELECT name FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`=`storage_places`.`room_id`) AS room_name, 
												(SELECT COUNT(*) AS a_d FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`storage_space_id`=`storage_places`.`id`) AS devices_amount, 
												(SELECT COUNT(*) AS a_s FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`mode`='0' AND `shopin_shopins`.`storage_space_id`=`storage_places`.`id`) AS shopins_amount 
									FROM 		`storage_places` 
									LEFT JOIN	`storage_rooms` 
									ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
									WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

	while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

		$total = $row_item['devices_amount'] + $row_item['shopins_amount'];

		$_SESSION['places'][$row_item['id']] = array(
			"id" => $row_item['id'], 
			"name" => $row_item['name']
		);

		// Geräte in einem Auftrag
		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number, 
															`order_orders_devices`.`atot_mode` AS atot_mode, 
															`order_orders_devices`.`at` AS at, 
															`order_orders_devices`.`ot` AS ot 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		while($row_devices = $result_devices->fetch_array(MYSQLI_ASSOC)){

			$_SESSION['devices'][$row_devices['id']] = array(
				"id" => $row_devices['id'], 
				"place_id" => $row_item['id'], 
				"device_number" => $row_devices['device_number'], 
				"atot_mode" => $row_devices['atot_mode'], 
				"at" => $row_devices['at'], 
				"ot" => $row_devices['ot'], 
				"fullname" => $row_devices['device_number'] . ($row_devices['atot_mode'] == 1 ? "-AT-" . $row_devices['at'] : ($row_devices['atot_mode'] == 2 ? "-ORG-" . $row_devices['ot'] : ""))
			);

		}

		// Wareneingang Auftragsgeräte
		$result_shopins = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number, 
															`order_orders_devices`.`atot_mode` AS atot_mode, 
															`order_orders_devices`.`at` AS at, 
															`order_orders_devices`.`ot` AS ot 
												FROM 		`shopin_shopins` 
												LEFT JOIN	`order_orders_devices` 
												ON			`shopin_shopins`.`device_id`=`order_orders_devices`.`id` 
												WHERE 		`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
												AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`shopin_shopins`.`mode`='0' 
												AND 		`shopin_shopins`.`order_id`>'0'");

		while($row_shopins = $result_shopins->fetch_array(MYSQLI_ASSOC)){

			$_SESSION['we_devices'][$row_shopins['id']] = array(
				"id" => $row_shopins['id'], 
				"place_id" => $row_item['id'], 
				"device_number" => $row_shopins['device_number'], 
				"atot_mode" => $row_shopins['atot_mode'], 
				"at" => $row_shopins['at'], 
				"ot" => $row_shopins['ot'], 
				"fullname" => $row_shopins['device_number'] . ($row_shopins['atot_mode'] == 1 ? "-AT-" . $row_shopins['at'] : ($row_shopins['atot_mode'] == 2 ? "-ORG-" . $row_shopins['ot'] : ""))
			);

		}

		// Wareneingang Hilfsgeräte
		$result_shopins_helpdevices = mysqli_query($conn, "	SELECT 		`shopin_shopins`.`id` AS id, 
																		`shopin_shopins`.`help_device_number` AS help_device_number 
															FROM 		`shopin_shopins` 
															WHERE 		`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
															AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`shopin_shopins`.`mode`='0' 
															AND 		`shopin_shopins`.`order_id`='0'");

		while($row_shopins_helpdevices = $result_shopins_helpdevices->fetch_array(MYSQLI_ASSOC)){

			$_SESSION['we_help_devices'][$row_shopins['id']] = array(
				"id" => $row_shopins_helpdevices['id'], 
				"place_id" => $row_item['id'], 
				"device_number" => $row_shopins_helpdevices['help_device_number']
			);

		}

	}

	$_SESSION['places_step'] = 0;

	$_SESSION['devices_step'] = 0;

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 1</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Es wurden " . count($_SESSION['places']) . " Lagerplätze im System gefunden!</h3>\n" . 
				"							<p><b>Existieren die gelisteten Geräte in den Plätzen?</b><br />Es werden den Plätzen nach die Geräte gezeigt.</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog1\" value=\"has_next_place\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog1']) && $_POST['prog1'] == "place_step"){

	$place = array();

	$device = array();

	$i = 0;
	foreach($_SESSION['places'] as $key => $val){
		if($i == $_SESSION['places_step']){
			$place = $_SESSION['places'][$key];
			break;
		}
		$i++;
	}

	$i = 0;
	foreach($_SESSION['devices'] as $key => $val){
		if($place['id'] == $_SESSION['devices'][$key]['place_id']){
			if($i == $_SESSION['devices_step']){
				$device = $_SESSION['devices'][$key];
			}
			$i++;
		}
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 1</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Platz: " . $place['name'] . "</h3>\n" . 
				"							<p><b>Geräte</b>: " . $i . "</p>\n" . 
				($i > 0 ? 
					"							<div class=\"form-group row\">\n" . 
					"								<div class=\"col-sm-6\">\n" . 
					"									<h1>" . ($_SESSION['devices_step'] + 1) . ".&nbsp;&nbsp;&nbsp;" . $device['fullname'] . "</h1>\n" . 
					"								</div>\n" . 
					"								<div class=\"col-sm-6\">\n" . 
					"									<div class=\"input-group input-group-lg mt-1\">\n" . 
					"										<input type=\"text\" id=\"de_nu\" name=\"de_nu\" value=\"\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" placeholder=\"|||||||| Gerät\" onkeypress=\"
					if(event.keyCode == '13' && this.value == '" . $device['fullname'] . "'){
						document.getElementById('device_next').click();
						return false;
					}else{
						alert('Die Gerätenummer stimmt nicht!');
					}
					\" />\n" . 
					"										<div class=\"input-group-append w-25\" ondblclick=\"
					if(document.getElementById('de_nu').value == '" . $device['fullname'] . "'){
						document.getElementById('device_next').click();
						return false;
					}else{
						alert('Die Gerätenummer stimmt nicht!');
					}
					\">\n" . 
					"											<button type=\"button\" class=\"btn btn-primary w-100\">Barcode</button>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 
					"								</div>\n" . 
					"							</div>\n" . 
					"							<p class=\"text-warning\">Existiert dieses Gerät im angegebenen Lagerplatz ?</p>\n"
				: 
					""
				) . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" id=\"device_next\" name=\"prog1\" value=\"device_next\" class=\"btn btn-primary\">" . ($i == 0 ? "weiter" : "Ja") . " <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<input type=\"hidden\" name=\"device_id\" value=\"" . $device['id'] . "\" />\n" . 
				($i > 0 ? 
					"							<button type=\"submit\" name=\"prog1\" value=\"device_delete\" class=\"btn btn-primary\">Nein, Gerät entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n"
				: 
					""
				) . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog1']) && $_POST['prog1'] == "ready"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 1</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Fertig!</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog1\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}


if(isset($_POST['prog2']) && $_POST['prog2'] == "init"){

	$_SESSION['places'] = array();

	$_SESSION['storage_devices'] = array();

	$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
												`storage_places`.`name` AS name, 
												(SELECT name FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`=`storage_places`.`room_id`) AS room_name, 
												(SELECT COUNT(*) AS a_d FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`storage_space_id`=`storage_places`.`id`) AS devices_amount, 
												(SELECT COUNT(*) AS a_s FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`mode`='0' AND `shopin_shopins`.`storage_space_id`=`storage_places`.`id`) AS shopins_amount 
									FROM 		`storage_places` 
									LEFT JOIN	`storage_rooms` 
									ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
									WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

	while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

		$total = $row_item['devices_amount'] + $row_item['shopins_amount'];

		$_SESSION['places'][$row_item['id']] = array(
			"id" => $row_item['id'], 
			"name" => $row_item['name']
		);

	}

	$_SESSION['places_step'] = 0;

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 2</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Es wurden " . count($_SESSION['places']) . " Lagerplätze im System gefunden!</h3>\n" . 
				"							<p><b>Existieren die Geräte in den Plätzen im System?</b><br />Es werden den Plätzen nach die existierenden eingegeben und im System auf vorhandensein geprüft.</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"has_next_place\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog2']) && $_POST['prog2'] == "place_step"){

	$place = array();

	$i = 0;
	foreach($_SESSION['places'] as $key => $val){
		if($i == $_SESSION['places_step']){
			$place = $_SESSION['places'][$key];
			break;
		}
		$i++;
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 2</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h3>Platz: " . $place['name'] . "</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<p class=\"text-warning\">Bitte die vorhandenen Geräte prüfen!</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" name=\"full_device_name\" value=\"\" class=\"form-control\" placeholder=\"Gerätenummer eingeben\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"check_device\" class=\"btn btn-primary\">prüfen <i class=\"fa fa-question\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"place_next\" class=\"btn btn-primary\">Nächster Platz <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"delete_system_devices\" class=\"btn btn-primary\">Weitere Pläter überspringen <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog2']) && $_POST['prog2'] == "check_device"){

	$message = "";

	$place = array();

	$i = 0;
	foreach($_SESSION['places'] as $key => $val){
		if($i == $_SESSION['places_step']){
			$place = $_SESSION['places'][$key];
			break;
		}
		$i++;
	}

	if(isset($_POST['full_device_name']) && $_POST['full_device_name'] != ""){

		$device = explode("-", strip_tags($_POST['full_device_name']));

		if(count($device) == 4){

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0])) . "'"), MYSQLI_ASSOC);

			if(isset($row_order['id']) && $row_order['id'] > 0){

				$atot_mode = $device[2] == "AT" ? 1 : 2;

				$device_number = $device[0] . "-" . $device[1];

				$at_or_ot_field = $device[2] == "AT" ? "at" : "ot";

				$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																		FROM	`order_orders_devices` 
																		WHERE	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 	`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
																		AND 	`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "' 
																		AND 	`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "' 
																		AND 	`order_orders_devices`.`" . $at_or_ot_field . "`='" . mysqli_real_escape_string($conn, intval($device[3])) . "'"), MYSQLI_ASSOC);

				if(isset($row_device['id']) && $row_device['id'] > 0){

					$_SESSION['storage_devices'][$row_device['id']] = array(
						"id" => $row_device['id'], 
						"place_id" => $place['id'], 
						"device_number" => $row_device['device_number'], 
						"atot_mode" => $row_device['atot_mode'], 
						"at" => $row_device['at'], 
						"ot" => $row_device['ot'], 
						"fullname" => $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))
					);

					$message = "<p class=\"text-success\">Das Gerät existiert im System !</p>\n";

				}else{
					
					$message = "<p class=\"text-danger\">Das Gerät existiert NICHT im System !<br />Gerät wurde angelegt!</p>\n";

					$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

					mysqli_query($conn, "	UPDATE 	`storage_places` 
											SET 	`storage_places`.`used`=`storage_places`.`used`+1 
											WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($place['id'])) . "' 
											AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					mysqli_query($conn, "	INSERT 	`order_orders_devices` 
											SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device[0] . "-" . $device[1])) . "', 
													`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "', 
													`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($atot_mode == 1 ? $device[3] : 0)) . "', 
													`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($atot_mode == 2 ? $device[3] : 0)) . "', 
													`order_orders_devices`.`component`='0', 
													`order_orders_devices`.`manufacturer`='', 
													`order_orders_devices`.`serial`='', 
													`order_orders_devices`.`additional_numbers`='', 
													`order_orders_devices`.`fromthiscar`='0', 
													`order_orders_devices`.`open_by_user`='0', 
													`order_orders_devices`.`other_components`='0', 
													`order_orders_devices`.`info`='', 
													`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($place['name'])) . "', 
													`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($place['id'])) . "', 
													`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
													`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");




				}

			}else{

				$message = "<p class=\"text-danger\">Der Auftrag des Geräts existiert NICHT im System !<br />Nehmen Sie das Gerät aus dem Platz und Wählen Sie für das Gerät &quot;kein Barcode&quot; !</p>\n";

			}


		}else{

			$message = "<p class=\"text-danger\">Die Gerätenummer ist nicht vollständig !</p>\n";

		}

	}else{

		$message = "<p class=\"text-danger\">Bitte ein Gerät eintragen, das Eingabefeld war leer !</p>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 2</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h3>Gerät: " . strip_tags($_POST['full_device_name']) . "</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 

				$message . 

				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"has_next_place\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog2']) && $_POST['prog2'] == "ready"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Prüfung 2</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Fertig!</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog2\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}


if(isset($_POST['prog3']) && $_POST['prog3'] == "init"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Geräteplätze an Lagerplätze</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h3>Es werden die vorhandenen Geräte/Lagerplätze an Lagerplätze übertragen!<br />(used wird zuerst auf 0 gesetzt!)</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog3\" value=\"devices_to_places\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}


if(isset($_POST['prog4']) && $_POST['prog4'] == "init"){

	$_SESSION['place'] = array();

	$row_devices = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS devices_count FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Lager --&gt; System / Inventuroptionen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				($row_devices['devices_count'] > 0 ? 
					"						<div class=\"col-sm-3\">\n" . 
					"							<button type=\"submit\" name=\"prog4\" value=\"delete_devices\" class=\"btn btn-danger\">(" . $row_devices['devices_count'] . ") Geräte vorhanden!<br />Alle entfernen? <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
					"						</div>\n"
				: 
					""
				) . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<button type=\"submit\" name=\"prog4\" value=\"next_place\" class=\"btn btn-primary\">Bestandsaufnahme!<br />Nichts entfernen! <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<p>Hier nach hdfhgfdhfghdfg Fragen, wenn das Passwort heissen soll ist das Schwachsinn, man!</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog4\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog4']) && $_POST['prog4'] == "next_place"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Lager --&gt; System</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h3>Lagerplatz Scannen</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<p class=\"text-warning\">Bitte den Lagerplatz eingeben!</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" name=\"place_name\" value=\"\" class=\"form-control\" placeholder=\"Lagerplatz eingeben\" onkeypress=\"if(event.keyCode == '13'){document.getElementById('check_place').click();return false;}\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" id=\"check_place\" name=\"prog4\" value=\"check_place\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog4']) && $_POST['prog4'] == "next_device"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Lager --&gt; System</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<h3>Platz: " . $_SESSION['place']['name'] . "</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<p class=\"text-warning\">Bitte die vorhandenen Geräte eingeben!</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" name=\"full_device_name\" value=\"\" class=\"form-control\" placeholder=\"Gerätenummer eingeben\" onkeypress=\"if(event.keyCode == '13'){document.getElementById('check_device').click();return false;}\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<button type=\"submit\" id=\"check_device\" name=\"prog4\" value=\"check_device\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog4\" value=\"next_place\" class=\"btn btn-primary\">Weiterer Platz <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"prog4\" value=\"ready\" class=\"btn btn-primary\">beenden <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog4']) && $_POST['prog4'] == "ready"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Lager --&gt; System</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Fertig!</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog4\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}


if(isset($_POST['prog5']) && $_POST['prog5'] == "init"){

	$_SESSION['place'] = array();

	$row_devices = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS devices_count FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`storage_space_id`>'0'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Inventuroptionen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				($row_devices['devices_count'] > 0 ? 
					"						<div class=\"col-sm-3\">\n" . 
					"							<input type=\"hidden\" id=\"password\" name=\"password\" value=\"\" />\n" . 
					"							<button type=\"submit\" name=\"prog5\" value=\"delete_devices\" class=\"btn btn-danger\" onclick=\"document.getElementById('password').value=prompt('Bitte das Kennwort zum entfernen eingeben!')\">(" . $row_devices['devices_count'] . ") Geräte vorhanden!<br />Alle entfernen? <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
					"						</div>\n"
				: 
					""
				) . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<button type=\"submit\" name=\"prog5\" value=\"next_device\" class=\"btn btn-primary\">Bestandsaufnahme!<br />Nichts entfernen! <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog5\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog5']) && $_POST['prog5'] == "next_device"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Inventur</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<p class=\"text-warning\">Bitte die vorhandenen Geräte eingeben!</p>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" name=\"place_name\" value=\"\" class=\"form-control\" placeholder=\"Lagerplatz eingeben\" onkeypress=\"if(event.keyCode == '13'){document.getElementById('full_device_name').focus();return false;}\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"full_device_name\" name=\"full_device_name\" value=\"\" class=\"form-control\" placeholder=\"Gerätenummer eingeben\" onkeypress=\"if(event.keyCode == '13'){document.getElementById('check_device').click();return false;}\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" id=\"check_device\" name=\"prog5\" value=\"check_device\" class=\"btn btn-primary\">weiter <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"prog5\" value=\"ready\" class=\"btn btn-primary\">beenden <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['prog5']) && $_POST['prog5'] == "ready"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Inventur</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<h3>Fertig!</h3>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"prog5\" value=\"close\" class=\"btn btn-primary\">schließen <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

?>