<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "packing_inputs";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_condition.php");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$packing_session = "packing";
$packing_action = "/crm/neue-packtische";
$packing_table = "packing_packings";
$packing_id_field = "packing_id";
$packing_mode = 0;
$packing_archiv_mode = 1;
$packing_hash = "";
$packing_templates_type = 7;
$packing_right = "packing_inputs";
$packing_name = "Packtisch";

$inp_order_number = "";
$inp_device_number = "";

$order_number = "";
$device_number = "";

$arr_area = array('Aufträge-Aktiv', 'Aufträge-Archiv', 'Interessenten-Aktiv', 'Interessenten-Archiv');

$arr_edit_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

$emsg = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['order_number']) < 1 || strlen($_POST['order_number']) > 5){
		$emsg .= "<span class=\"error\">Bitte eine Auftragsnummer eingeben. (max. 5 Zeichen)</span><br />\n";
		$inp_order_number = " is-invalid";
	}else{
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_order` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "'"), MYSQLI_ASSOC);
		if(isset($row_order['id']) && $row_order['id'] > 0){
			$order_number = strip_tags($_POST['order_number']);
		}else{
			$emsg .= "<span class=\"error\">Die Auftragsnummer wurde nicht gefunden.</span><br />\n";
			$inp_order_number = " is-invalid";
		}
	}

	if(strlen($_POST['device_number']) < 1 || strlen($_POST['device_number']) > 8){
		$emsg .= "<span class=\"error\">Bitte eine Gerätsnummer für einen Platzbereich des Lagerplatzes eingeben. (max. 8 Zeichen)</span><br />\n";
		$inp_device_number = " is-invalid";
	}else{
		$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['device_number'])) . "'"), MYSQLI_ASSOC);
		if(isset($row_device['id']) && $row_device['id'] > 0){
			if($row_device['storage_space_id'] == 0){
				$device_number = strip_tags($_POST['device_number']);
			}else{
				$emsg .= "<span class=\"error\">Für dieses Gerät (" . strip_tags($_POST['device_number']) . ") wurde schon ein Lagerplatz gespeichert.</span><br />\n";
				$inp_device_number = " is-invalid";
			}
		}else{
			$emsg .= "<span class=\"error\">Die Gerätsnummer für einen Platzbereich des Lagerplatzes wurde nicht gefunden.</span><br />\n";
			$inp_device_number = " is-invalid";
		}
	}

	if($emsg == ""){

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['place_id'])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
								SET 	`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($row_storage_place['name'])) . "', 
										`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($_POST['place_id'])) . "', 
										`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, $time) . "', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
								AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`used`=`storage_places`.`used`+1 
								WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['place_id']) ? $_POST['place_id'] : 0)) . "' 
								AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$_POST["device_id"] = $row_device['id'];

		$_POST["place_id"] = intval(isset($_POST['place_id']) ? $_POST['place_id'] : 0);

		$emsg = "<p>Die Gerätsnummer wurde erfolgreich für einen Platzbereich des Lagerplatzes eingelagert!</p>\n";

//		$_POST["edit"] = "bearbeiten";

	}else{

//		$_POST["add"] = "hinzufügen";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	$result_room = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	while($row_room = $result_room->fetch_array(MYSQLI_ASSOC)){

		$result_place = mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($row_room['id'])) . "' ORDER BY CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

		while($row_place = $result_place->fetch_array(MYSQLI_ASSOC)){

			$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
																`order_orders_devices`.`order_id` AS order_id, 
																`order_orders_devices`.`device_number` AS device_number, 
																`order_orders_devices`.`upd_date` AS upd_date, 
																`order_orders`.`mode` AS mode, 
																`order_orders`.`order_number` AS order_number, 
																(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_devices`.`admin_id`) AS admin_name 
													FROM 		`order_orders_devices` 
													LEFT JOIN	`order_orders` 
													ON			`order_orders`.`id`=`order_orders_devices`.`order_id` 
													WHERE 		`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_place['id'])) . "' 
													AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													ORDER BY 	CAST(`order_orders_devices`.`storage_space_date` AS UNSIGNED) DESC");

			$i = 1;

			while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

				$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
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
							"			<span>" . $i . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\">\n" . 
							"			<span>" . $row_device['admin_name'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<span>" . $row_device['device_number'] . "</span>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" class=\"text-center\">\n" . 
							"			<a href=\"/crm/" . $arr_edit_url[$row_device['mode']] . "/bearbeiten/" . $row_device['order_id'] . "\">" . $row_device['order_number'] . "</a>\n" . 
							"		</td>\n" . 
							"	</tr>\n" . 
							"</form>\n";

				$i++;

			}

		}

	}

}

$navigation = new navigation($conn, 7, "packing_inputs");
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 

		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
/*		"<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Wareneingang</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Waren einlagern.</p>\n" . 
		"<hr />\n" . */
		"<br />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-2\"><h3>Wareneingang</h3></div>\n" . 
		"		<div class=\"col-sm-3\"><input type=\"text\" name=\"order_number\" value=\"\" class=\"form-control\" placeholder=\"|||||||| Auftrag\" onKeyPress=\"if(event.keyCode == '13'){return false;}\" /></div>\n" . 
		"		<div class=\"col-sm-3\"><input type=\"text\" name=\"storage_space\" value=\"\" class=\"form-control\" placeholder=\"|||||||| Lagerplatz\" onKeyPress=\"if(event.keyCode == '13'){return false;}\" /></div>\n" . 
		"		<div class=\"col-sm-2\">__________________</div>\n" . 
		"		<div class=\"col-sm-2\">\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"einlagern\" class=\"btn btn-primary\">einlagern <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n" . 
		"<div class=\"table-responsive\">\n" . 
		"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>ID</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"150\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Geändert</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Regal</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"110\" scope=\"col\">\n" . 
		"				<strong>Lagerplatz</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Platzbereich</strong>\n" . 
		"			</th>\n" . 
		"			<th scope=\"col\">\n" . 
		"				<strong>Mitarbeiter</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Gerätenummer</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Auftrag</strong>\n" . 
		"			</th>\n" . 
		"		</tr></thead>\n" . 

		$list . 

		"	</table>\n" . 
		"</div>\n" . 
		"<br />\n";

?>