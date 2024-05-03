<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "shipping_history";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

include("includes/get_ups_status.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$shipping_history_session = "shipping_history_search";

if(isset($_POST["sorting_field"])){$_SESSION[$shipping_history_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$shipping_history_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$shipping_history_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$shipping_history_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$shipping_history_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Versandtext", 
	"value" => "`shipping_history`.`description`"
);
$sorting[] = array(
	"name" => "Lieferung an:", 
	"value" => "`shipping_history`.`to_shortcut`"
);
$sorting[] = array(
	"name" => "Sendungsnummer", 
	"value" => "`shipping_history`.`shipments_id`"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`shipping_history`.`time` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$shipping_history_session]["sorting_field"]) ? $sorting[$_SESSION[$shipping_history_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$shipping_history_session]["sorting_field"]) ? $_SESSION[$shipping_history_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$shipping_history_session]["sorting_direction"]) ? $directions[$_SESSION[$shipping_history_session]["sorting_direction"]] : "DESC";
$sorting_direction_value = isset($_SESSION[$shipping_history_session]["sorting_direction"]) ? $_SESSION[$shipping_history_session]["sorting_direction"] : 1;

$amount_rows = isset($_SESSION[$shipping_history_session]["rows"]) && $_SESSION[$shipping_history_session]["rows"] > 0 ? $_SESSION[$shipping_history_session]["rows"] : 200;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$order_amount_rows = 10;
if(!isset($param['orderpage'])){
	$orderpage = 0;
}else{
	$orderpage = intval($param['orderpage']);
	$_POST['id'] = intval($param['id']);
	$_POST['set_order'] = "zuweisen";
}

$orderNumberlist = new pageList();

$emsg = "";
$emsg_storno = "";

$html_add_order = "";

$shipping_statusses = array(
	0 => array(
		'description' => 'in bearbeitung', 
		'background' => 'warning'
	), 
	1 => array(
		'description' => 'storniert', 
		'background' => 'danger'
	), 
	2 => array(
		'description' => 'zugestellt', 
		'background' => 'success'
	)
);

$carriers_services = array(
	'11' => 'UPS Standard', 
	'65' => 'UPS Saver'
);

$status_types = array(
	'D' => 'Delivered', 
	'I' => 'In Transit', 
	'M' => 'Billing Information Received', 
	'MV' => 'Billing Information Voided', 
	'P' => 'Pickup', 
	'X' => 'Exception', 
	'RS' => 'Returned to Shipper', 
	'DO' => 'Delivered Origin CFS (Freight Only)', 
	'DD' => 'Delivered Destination CFS (Freight Only)', 
	'W' => 'Warehousing (Freight Only)', 
	'NA' => ' Not Available', 
	'O' => 'Out for Delivery'
);

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$time = time();

	mysqli_query($conn, "	DELETE FROM	`shipping_history` 
							WHERE 		`shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$result_orders = mysqli_query($conn, "	SELECT 		* 
											FROM 		`order_orders` 
											WHERE 		`order_orders`.`shipping_history_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`order_orders`.`id` AS UNSIGNED) ASC");

	while($row_orders = $result_orders->fetch_array(MYSQLI_ASSOC)){
		
		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`shipping_history_id`='0' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_orders['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_history` 
								SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_orders['id'])) . "', 
										`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, "Sendungsnummer Extern: " . $row_shipping_history['shipments_id'] . " gelöscht.") . "', 
										`order_orders_history`.`status`='3', 
										`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

	$emsg = "<small class=\"error bg-success text-white\">Die Sendung wurde erfolgreich entfernt.</small><br />\n";

}

if(isset($_POST['shipping']) && $_POST['shipping'] == "stornieren"){

	$data = array();

	$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

	$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/cancel/' . strip_tags($_POST['shipments_id']));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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

	$response = json_decode($result);

	if(isset($response->VoidShipmentResponse->Response->ResponseStatus->Code) && $response->VoidShipmentResponse->Response->ResponseStatus->Code == "1"){
		
		mysqli_query($conn, "	UPDATE 	`shipping_history` 
								SET 	`shipping_history`.`status`='1' 
								WHERE 	`shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg_storno = "<small class=\"error bg-success text-white\">Die Sendung wurde erfolgreich storniert.</small><br />\n";
		
	}else{

		$emsg_storno = "<small class=\"error bg-danger text-white\">" . $response->response->errors[0]->message . "</small><br />\n";

	}

//	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['status']) && $_POST['status'] == "Status aktualisieren"){

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`shipping_history` 
									WHERE 		`shipping_history`.`status_description`!='Zugestellt' 
									AND 		`shipping_history`.`status_description`!='Sendung storniert' 
									AND 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`shipping_history`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$response = getUpsStatus($maindata, $row['shipments_id']);

		mysqli_query($conn, "	UPDATE 	`shipping_history` 
								SET 	`shipping_history`.`tracking_response`='" . mysqli_real_escape_string($conn, json_encode($response)) . "', 
										`shipping_history`.`status_description`='" . mysqli_real_escape_string($conn, $response->trackResponse->shipment[0]->package[0]->activity[0]->status->description) . "', 
										`shipping_history`.`status_code`='" . mysqli_real_escape_string($conn, $response->trackResponse->shipment[0]->package[0]->activity[0]->status->code) . "', 
										`shipping_history`.`status`='" . mysqli_real_escape_string($conn, ($response->trackResponse->shipment[0]->package[0]->activity[0]->status->description == "Zugestellt" ? 2 : ($response->trackResponse->shipment[0]->package[0]->activity[0]->status->description == "Sendung storniert" ? 1 : 0))) . "' 
								WHERE 	`shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($row['id'])) . "' 
								AND 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

}

if(isset($_POST['order_search']) && $_POST['order_search'] == "suchen"){

	$_POST['set_order'] = "zuweisen";

}

if(isset($_POST['add_order']) && $_POST['add_order'] == "zuweisen"){

	$time = time();

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "'"), MYSQLI_ASSOC);

	$row_shipping_history = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if($row_order['shipping_history_id'] > 0){
		
		mysqli_query($conn, "	INSERT 	`order_orders_history` 
								SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
										`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, "Erneut versendet an: " . $row_shipping_history['to_shortcut'] . ", Sendungsnummer Extern: " . $row_shipping_history['shipments_id'] . ".") . "', 
										`order_orders_history`.`status`='3', 
										`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}else{
		
		mysqli_query($conn, "	INSERT 	`order_orders_history` 
								SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
										`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, "Versendet an: " . $row_shipping_history['to_shortcut'] . ", Sendungsnummer Extern: " . $row_shipping_history['shipments_id'] . ".") . "', 
										`order_orders_history`.`status`='3', 
										`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`shipping_history_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$emsg = "<small class=\"error bg-success text-white\">Die Sendung wurde erfolgreich zugewiesen.</small><br />\n";

	$_POST['set_order'] = "zuweisen";

}

if(isset($_POST['multi_add']) && $_POST['multi_add'] == "zuweisen"){

	$time = time();

	$row_shipping_history = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$ids = explode(",", strip_tags($_POST['ids']));

	for($i = 0;$i < count($ids);$i++){

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "'"), MYSQLI_ASSOC);

		if($row_order['shipping_history_id'] > 0){
			
			mysqli_query($conn, "	INSERT 	`order_orders_history` 
									SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, "Erneut versendet an: " . $row_shipping_history['to_shortcut'] . ", Sendungsnummer Extern: " . $row_shipping_history['shipments_id'] . ".") . "', 
											`order_orders_history`.`status`='3', 
											`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}else{
			
			mysqli_query($conn, "	INSERT 	`order_orders_history` 
									SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, "Versendet an: " . $row_shipping_history['to_shortcut'] . ", Sendungsnummer Extern: " . $row_shipping_history['shipments_id'] . ".") . "', 
											`order_orders_history`.`status`='3', 
											`order_orders_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`shipping_history_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<small class=\"error bg-success text-white\">Die Aufträge wurden erfolgreich der Sendung zugewiesen.</small><br />\n";

	}

	$_POST['set_order'] = "zuweisen";

}

if(isset($_POST['add_order']) && $_POST['add_order'] == "lösen"){

	$time = time();

	$row_shipping_history = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`shipping_history_id`='0' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$emsg = "<small class=\"error bg-success text-white\">Die Zuweisung wurde erfolgreich gelöst.</small><br />\n";

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `shipping_history`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`shipping_history`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `shipping_history`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION[$shipping_history_session]["keyword"]) && $_SESSION[$shipping_history_session]["keyword"] != "" ? 
			"WHERE (`shipping_history`.`shipments_id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`from_country`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`from_mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_shortcut` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`to_country`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`to_mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%'
			OR		`shipping_history`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shipping_history_session]["keyword"]) . "%') " : 
			"WHERE `shipping_history`.`id`>0 ";

$query = "	SELECT 		`shipping_history`.`id` AS id, 
						(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`shipping_history`.`admin_id`) AS admin_name, 
						`shipping_history`.`order_id` AS order_id, 
						`shipping_history`.`devices` AS devices, 
						`shipping_history`.`shipments_id` AS shipments_id, 
						`shipping_history`.`carrier_tracking_no` AS carrier_tracking_no, 
						`shipping_history`.`label_url` AS label_url, 
						`shipping_history`.`total_charges_with_taxes` AS total_charges_with_taxes, 
						`shipping_history`.`carrier` AS carrier, 
						`shipping_history`.`service` AS service, 

						`shipping_history`.`from_companyname` AS from_companyname, 
						`shipping_history`.`from_gender` AS from_gender, 
						`shipping_history`.`from_firstname` AS from_firstname, 
						`shipping_history`.`from_lastname` AS from_lastname, 
						`shipping_history`.`from_street` AS from_street, 
						`shipping_history`.`from_streetno` AS from_streetno, 
						`shipping_history`.`from_zipcode` AS from_zipcode, 
						`shipping_history`.`from_city` AS from_city, 
						(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`from_country`) AS from_countryname, 
						`shipping_history`.`from_email` AS from_email, 
						`shipping_history`.`from_phonenumber` AS from_phonenumber, 
						`shipping_history`.`from_mobilnumber` AS from_mobilnumber, 

						`shipping_history`.`to_shortcut` AS to_shortcut, 
						`shipping_history`.`to_companyname` AS to_companyname, 
						`shipping_history`.`to_gender` AS to_gender, 
						`shipping_history`.`to_firstname` AS to_firstname, 
						`shipping_history`.`to_lastname` AS to_lastname, 
						`shipping_history`.`to_street` AS to_street, 
						`shipping_history`.`to_streetno` AS to_streetno, 
						`shipping_history`.`to_zipcode` AS to_zipcode, 
						`shipping_history`.`to_city` AS to_city, 
						(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`to_country`) AS to_countryname, 
						`shipping_history`.`to_email` AS to_email, 
						`shipping_history`.`to_phonenumber` AS to_phonenumber, 
						`shipping_history`.`to_mobilnumber` AS to_mobilnumber, 

						`shipping_history`.`weight` AS weight, 
						`shipping_history`.`length` AS length, 
						`shipping_history`.`width` AS width, 
						`shipping_history`.`height` AS height, 
						`shipping_history`.`radio_payment` AS radio_payment, 
						`shipping_history`.`amount` AS amount, 
						`shipping_history`.`radio_saturday` AS radio_saturday, 
						`shipping_history`.`description` AS description, 
						`shipping_history`.`status` AS status, 
						`shipping_history`.`status_description` AS status_description, 
						`shipping_history`.`status_code` AS status_code, 
						`shipping_history`.`tracking_response` AS tracking_response, 
						`shipping_history`.`time` AS time 
						
			FROM 		`shipping_history` 
			" . $where . " 
			AND 		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			" . $and . " 
			ORDER BY 	" . $sorting_field_name . " " . $sorting_direction_name;

$result = mysqli_query($conn, $query);

$rows = $result->num_rows;

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
									$page['url'], 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

if($rows > 0){

	$arr_edit_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$str_status = "";
		$str_status_last = "";
		$str_status_last_bgcolor = "";

		if($row['tracking_response'] != ""){

			$response = json_decode($row['tracking_response']);

			$arr_status = $response->trackResponse->shipment[0]->package[0]->activity;

			if(isset($arr_status)){

				for($i = 0; $i < count($arr_status);$i++){

					$index = (count($arr_status) - $i);

					if($str_status_last == ""){

						$result_shipping_messages = mysqli_query($conn, "	SELECT * FROM `shipping_messages` WHERE `shipping_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`shipping_messages`.`id` AS UNSIGNED) ASC");

						$count = 0;

						while($row_shipping_messages = $result_shipping_messages->fetch_array(MYSQLI_ASSOC)){

							if($count == 0){

								$arr_status[$i]->status->description = str_replace($row_shipping_messages['searchstring'], $row_shipping_messages['replacestring'], $arr_status[$i]->status->description, $count);

								if($count > 0){

									$str_status_last_bgcolor = $row_shipping_messages['bgcolor'];

								}

							}

						}

						$str_status_last .= $arr_status[$i]->status->description;

					}

					$result_shipping_messages = mysqli_query($conn, "	SELECT * FROM `shipping_messages` WHERE `shipping_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`shipping_messages`.`id` AS UNSIGNED) ASC");

					while($row_shipping_messages = $result_shipping_messages->fetch_array(MYSQLI_ASSOC)){

						$arr_status[$i]->status->description = str_replace($row_shipping_messages['searchstring'], $row_shipping_messages['replacestring'], $arr_status[$i]->status->description);

					}

					$year = substr($arr_status[$i]->date, 0, 4);
					$month = substr($arr_status[$i]->date, 4, 2);
					$day = substr($arr_status[$i]->date, 6, 2);

					$date = $day . "." . $month . "." . $year;

					$hour = substr($arr_status[$i]->time, 0, 2);
					$minute = substr($arr_status[$i]->time, 2, 2);

					$clock_time = $hour . ":" . $minute . " Uhr";

					$str_status .= "<span title=\"" . $arr_status[$i]->status->code . "\">" . ($index <= 9 ? "0" : "") . $index . ") " . $date . " " . $clock_time . " - " . $arr_status[$i]->status->description . "</span><br />\n";

				}

			}

		}else{

			$str_status = "Noch nicht gespeichert";

		}

		$list_orders = "";

		$result_orders = mysqli_query($conn, "	SELECT 		* 
												FROM 		`order_orders` 
												WHERE 		`order_orders`.`shipping_history_id`='" . mysqli_real_escape_string($conn, intval($row['id'])) . "' 
												AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`order_orders`.`id` AS UNSIGNED) ASC");

		while($row_orders = $result_orders->fetch_array(MYSQLI_ASSOC)){

			$list_orders .= "<div class=\"row mb-1\">\n" . 
							"	<div class=\"col-sm-2 mt-2\">\n" . 
							"		<a href=\"/crm/" . $arr_edit_url[$row_orders['mode']] . "/bearbeiten/" . $row_orders['id'] . "\">" . $row_orders['order_number'] . "</a>\n" . 
							"	</div>\n" . 
							"	<div class=\"col-sm-10\">\n" . 
							"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
							"			<input type=\"hidden\" name=\"order_id\" value=\"" . $row_orders['id'] . "\" />\n" . 
							"			<button type=\"submit\" name=\"add_order\" value=\"lösen\" onclick=\"return confirm('Wollen Sie die Zuweisung wircklich entfernen?')\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
							"		</form>\n" . 
							"	</div>\n" . 
							"</div>\n";

		}

		$list_orders = $list_orders != "" ? $list_orders : "keine";

		$devices = "<div>\n";

		if($row['devices'] != ""){

			$arr_devices = explode(",", $row['devices']);

			for($i = 0;$i < count($arr_devices);$i++){

				$arr_devices_data = explode(":", $arr_devices[$i]);

				$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT		`order_orders`.`id` AS id, 
																					`order_orders`.`mode` AS mode 
																		FROM		`order_orders` 
																		WHERE		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row['order_id'])) . "'"), MYSQLI_ASSOC);

				$devices .= "	<div class=\"d-inline-block pr-2 pb-1\"><h4><a href=\"/crm/" . $arr_edit_url[$row_order['mode']] . "/bearbeiten/" . $row_order['id'] . "\" target=\"_blank\" class=\"btn btn-success rounded-pill font-weight-bold\" style=\"width: 100px\" title=\"Auftrag öffnen\">" . $arr_devices_data[1] . "</a></h4></div>\n";

			}

		}else{
			$devices .= "keine :(";
		}

		$devices .= "</div>\n";

		$popup = 	"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card text-primary bg-light\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				<strong>Absender</strong><br />\n" . 
					"				" . $row['from_companyname'] . "<br />\n" . 
					"				" . ($row['from_gender'] == 0 ? "Herr" : "Frau") . " " . $row['from_firstname'] . " " . $row['from_lastname'] . "<br />\n" . 
					"				" . $row['from_street'] . " " . $row['from_streetno'] . "<br />\n" . 
					"				" . $row['from_zipcode'] . " " . $row['from_city'] . "<br />\n" . 
					"				" . $row['from_countryname'] . "<br />\n" . 
					"				<a href=\"mailto: " . $row['from_email'] . "\">" . $row['from_email'] . "</a><br />\n" . 
					"				" . $row['from_phonenumber'] . "<br />\n" . 
					"				" . $row['from_mobilnumber'] . "<br />\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card text-primary bg-light\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				<strong>Empfänger</strong><br />\n" . 
					"				" . $row['to_companyname'] . "<br />\n" . 
					"				" . ($row['to_gender'] == 0 ? "Herr" : "Frau") . " " . $row['to_firstname'] . " " . $row['to_lastname'] . "<br />\n" . 
					"				<a href=\"http://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&z=14&iwloc=A&q=" . urlencode($row['to_street'] . " " . $row['to_streetno'] . " " . $row['to_zipcode'] . " " . $row['to_city'] . " " . $row['to_countryname']) . "\" target=\"_blank\">\n" . 
					"					" . $row['to_street'] . " " . $row['to_streetno'] . "<br />\n" . 
					"					" . $row['to_zipcode'] . " " . $row['to_city'] . "<br />\n" . 
					"					" . $row['to_countryname'] . "\n" . 
					"				</a><br />\n" . 
					"				<a href=\"mailto: " . $row['to_email'] . "\">" . $row['to_email'] . "</a><br />\n" . 
					"				" . $row['to_phonenumber'] . "<br />\n" . 
					"				" . $row['to_mobilnumber'] . "<br />\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				<strong class=\"text-primary\">Paketeigenschaften</strong><br />\n" . 
					"				Maße /  Gewicht<br />\n" . 
					"				Hinweis\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				&nbsp;<br />\n" . 
					"				" . $row['length'] . " cm X " . $row['width'] . " cm X " . $row['height'] . " cm / " . number_format($row['weight'], 1, ',', '') . " kg<br />\n" . 
					"				" . $row['description'] . "\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				<strong class=\"text-primary\">Optionen</strong><br />\n" . 
					"				Nachnahme<br />\n" . 
					"				Nachnahme Betrag<br />\n" . 
					"				Samstagszuschlag<br />\n" . 
					"				Versandkosten<br />\n" . 
					"				Tracking-Url\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				&nbsp;<br />\n" . 
					"				" . ($row['radio_payment'] == 1 ? "Ja" : "Nein") . "<br />\n" . 
					"				" . number_format($row['amount'], 2, ',', '') . " &euro;<br />\n" . 
					"				" . ($row['radio_saturday'] ==  1 ? "Ja" : "Nein") . "<br />\n" . 
					"				" . number_format($row['total_charges_with_taxes'], 2, ',', '') . " &euro;<br />\n" . 
					"				<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $row['shipments_id'] . "&loc=de_DE\" target=\"_blank\">" . $row['shipments_id'] . " <i class=\"fa fa-external-link\"> </i></a><br />\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				UPS-Status\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				<h3><span class=\"badge badge-pill badge-" . $shipping_statusses[$row['status']]['background'] . " text-white\">" . $shipping_statusses[$row['status']]['description'] . "</span></h3>\n" . 

					$str_status . 

					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				Geräte\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 

					$devices . 

					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				Label drucken\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body pb-0\">\n" . 
					"				<button type=\"button\" class=\"btn btn-success btn-lg\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame_list_" . $row['id'] . "').print();}else{document.getElementById('label_frame_list_" . $row['id'] . "').contentWindow.print();}\"><i class=\"fa fa-print\"> </i></button><br />\n" . 
					"				<iframe src=\"/versendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row['shipments_id'] . "\" id=\"label_frame_list_" . $row['id'] . "\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				Sendung\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"					<input type=\"hidden\" name=\"shipments_id\" value=\"" . $row['shipments_id'] . "\" />\n" . 
					"					<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"					<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-lg btn-danger\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
					"				</form>\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				Zuweisungen\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 

					$list_orders . 

					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				Aktion\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6\">\n" . 
					"		<div class=\"card border-0\">\n" . 
					"			<div class=\"card-body\">\n" . 
					"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"					<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"					<button type=\"submit\" name=\"set_order\" value=\"zuweisen\" class=\"btn btn-lg btn-success\">Auftrag zuweisen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></button>\n" . 
					"				</form>\n" . 
					"			</div>\n" . 
					"		</div>\n" . 
					"	</div>\n" . 
					"</div>\n";

		$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . date("d.m.Y (H:i)", $row['time']) . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['admin_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['description'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['to_shortcut'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['shipments_id'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<span class=\"badge badge-pill badge-" . ($str_status_last_bgcolor != "" ? str_replace("bg-", "", $str_status_last_bgcolor) : $shipping_statusses[$row['status']]['background']) . "\">" . ($str_status_last != "" ? $str_status_last : $shipping_statusses[$row['status']]['description']) . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"			<input type=\"hidden\" name=\"shipments_id\" value=\"" . $row['shipments_id'] . "\" />\n" . 
					"			<div class=\"btn-group\">\n" . 

					($row['status'] == 0 ? "				<button type=\"submit\" name=\"shipping\" value=\"stornieren\" class=\"btn btn-sm btn-warning\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"stornieren\" title=\"\" onclick=\"return confirm('Wollen Sie diese Sendung wirklich stornieren?')\"><i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" : "				<button type=\"submit\" name=\"shipping\" value=\"stornieren\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Wollen Sie diese Sendung wirklich stornieren?')\" disabled=\"disabled=\"><i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>") . 

					"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Details\" title=\"\" onclick=\"showShippingDialog('<i class=\'fa fa-thumb-tack\' aria-hidden=\'true\'></i> " . $carriers_services[$row['service']] . " " . $row['shipments_id'] . "', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($popup, ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
					"			</div>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Versand - Sendungen</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$shipping_history_session]['keyword']) && $_SESSION[$shipping_history_session]['keyword'] != "" ? $_SESSION[$shipping_history_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-lg btn-success\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-lg btn-primary\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-lg btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\">Filter</button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 50px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"							<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"							<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"								<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"								<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"								<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"								<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"								<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"								<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"								<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"								<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"								<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"							<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"							<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"								<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Sendungen einsehen und gegebenfalls entfernen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"status\" value=\"Status aktualisieren\" class=\"btn btn-lg btn-success w-100\">Status aktualisieren <i class=\"fa fa-download\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(!isset($_POST['set_order'])){

	$html .=	($emsg_storno != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_storno . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"160\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Datum</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Versandtext</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Lieferung an:</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"170\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Sendungsnummer</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Status</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"80\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"	<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"		<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"			<tr class=\"text-primary\">\n" . 
				"				<td width=\"350\">\n" . 
				"					<label for=\"order_sel_all_bottom\" class=\"mt-1\">(" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"				</td>\n" . 
				"				<td>\n" . 
				"					&nbsp;\n" . 
				"				</td>\n" . 
				"			</tr>\n" . 
				"		</table>\n" . 
				"	</form>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten" ? "" : "<br />\n<br />\n<br />\n");

}

if(isset($_POST['set_order']) && $_POST['set_order'] == "zuweisen"){

	$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
															(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`from_country`) AS from_countryname, 
															(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`shipping_history`.`to_country`) AS to_countryname 
													FROM 	`shipping_history` 
													WHERE 	`shipping_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
													AND 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$order_list = "";

	$where = 	isset($_SESSION["orders"]["order_keyword"]) && $_SESSION["orders"]["order_keyword"] != "" ? 
				"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`component` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`manufacturer` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`serial` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`fromthiscar` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%' 
				OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["orders"]["order_keyword"]) . "%') " : 
				"";

	$and = $where != "" ? "AND `order_orders`.`mode`=0 " : "WHERE `order_orders`.`mode`=0 ";

	$query = 	"	SELECT 		`order_orders`.`id` AS id, 
								`order_orders`.`mode` AS mode, 
								`order_orders`.`shipping_history_id` AS shipping_history_id, 
								`order_orders`.`order_number` AS order_number, 
								`order_orders`.`companyname` AS companyname, 
								`order_orders`.`firstname` AS firstname, 
								`order_orders`.`lastname` AS lastname, 
								`order_orders`.`audio` AS audio, 
								`order_orders`.`run_date` AS run_date, 
								`order_orders`.`reg_date` AS reg_date, 
								`order_orders`.`upd_date` AS upd_date, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

								`order_orders`.`admin_id` AS admin_id 
								
					FROM 		`order_orders` 
					" . $where . $and . " 
					AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	CAST(`order_orders`.`upd_date` AS UNSIGNED) DESC";

	$result = mysqli_query($conn, $query);

	$rows = $result->num_rows;

	$orderNumberlist->setParam(	array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
										$rows, 
										$orderpage, 
										$order_amount_rows, 
										"/position", 
										$page['url'] . "/" . intval($_POST['id']), 
										$getParam="", 
										10, 
										1);

	$query .= " limit " . $orderpage . ", " . $order_amount_rows;

	$result = mysqli_query($conn, $query);

	if($rows > 0){

		while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

			$order_list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
							"	<tr onclick=\"if(\$(this).hasClass('active')){\$(this).removeClass('active');}else{\$(this).addClass('active');}$('#order_list_" . $row_orders['id'] . "').prop('checked', !$('#order_list_" . $row_orders['id'] . "').prop('checked'))\" data-id=\"" . $row_orders['id'] . "\" data-order_number=\"" . $row_orders['order_number'] . "\">\n" . 
							"		<td scope=\"row\">\n" . 
							"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
							"				<input type=\"checkbox\" id=\"order_list_" . $row_orders['id'] . "\" data-id=\"" . $row_orders['id'] . "\" class=\"custom-control-input order-list\" onclick=\"if(\$(this).closest('tr').hasClass('active')){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}\" />\n" . 
							"				<label class=\"custom-control-label\" for=\"order_list_" . $row_orders['id'] . "\"></label>\n" . 
							"			</div>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" align=\"center\">\n" . 
							"			<small>" . $row_orders['order_number'] . "</small>\n" . 
							"		</td>\n" . 
							"		<td>\n" . 
							"			<small>" . date("d.m.Y", $row_orders['upd_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['upd_date']) . "</small>\n" . 
							"		</td>\n" . 
							"		<td align=\"center\">\n" . 
							"			<small>" . $row_orders['admin_name'] . "</small>\n" . 
							"		</td>\n" . 
							"		<td scope=\"row\" align=\"center\">\n" . 
							"			<small>" . ($row_orders['shipping_history_id'] > 0 ? "Ja" : "Nein") . "</small>\n" . 
							"		</td>\n" . 
							"		<td>\n" . 
							"			<small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small>\n" . 
							"		</td>\n" . 
							"		<td align=\"center\">\n" . 
							"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
							"			<input type=\"hidden\" name=\"order_id\" value=\"" . $row_orders['id'] . "\" />\n" . 
							"			<button type=\"submit\" name=\"add_order\" value=\"zuweisen\" class=\"btn btn-sm btn-success\">zuweisen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></button>\n" . 
							"		</td>\n" . 
							"	</tr>\n" . 
							"</form>\n";

		}

	}else{

		$order_list = isset($_POST['order_search']) && $_POST['order_search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION["orders"]["order_keyword"] . " - übereinstimmende Aufträge gefunden.')</script>\n" : "";

	}

	$html_add_order = 	"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
						"			<div class=\"form-group row mb-0\">\n" . 
						"				<label for=\"order_keyword\" class=\"col-sm-2 col-form-label\">Stichwort <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie mit Stichwörten nach Aufträgen suchen.\">?</span></label>\n" . 
						"				<div class=\"col-sm-3\">\n" . 
						"					<input type=\"text\" id=\"order_keyword\" name=\"order_keyword\" value=\"" . (isset($_SESSION['orders']['order_keyword']) && $_SESSION['orders']['order_keyword'] != "" ? $_SESSION['orders']['order_keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" />\n" . 
						"				</div>\n" . 
						"				<div class=\"col-sm-2\">\n" . 
						"					<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"					<button type=\"submit\" name=\"order_search\" value=\"suchen\" class=\"btn btn-primary\">suchen <i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
						"				</div>\n" . 
						"			</div>\n" . 
						"		</form>\n" . 
						"		<hr />\n" . 

						$orderNumberlist->getInfo() . 

						"		<br />\n" . 

						$orderNumberlist->getNavi() . 

						"		<div class=\"table-responsive\">\n" . 
						"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"					<th width=\"40\" scope=\"col\">\n" . 
						"						<div class=\"custom-control custom-checkbox mt-0 ml-2\">\n" . 
						"							<input type=\"checkbox\" id=\"order_sel_all_top\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_bottom').prop('checked');\$('#order_sel_all_bottom').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
						"							<label class=\"custom-control-label\" for=\"order_sel_all_top\"></label>\n" . 
						"						</div>\n" . 
						"					</th>\n" . 
						"					<th width=\"110\" scope=\"col\">\n" . 
						"						<strong>Auftrags Nr.</strong>\n" . 
						"					</th>\n" . 
						"					<th width=\"130\" scope=\"col\">\n" . 
						"						<strong>Letzter Status</strong>\n" . 
						"					</th>\n" . 
						"					<th width=\"200\" scope=\"col\" class=\"text-center\">\n" . 
						"						<strong>Mitarbeiter</strong>\n" . 
						"					</th>\n" . 
						"					<th width=\"110\" scope=\"col\" class=\"text-center\">\n" . 
						"						<strong>Zugewiesen</strong>\n" . 
						"					</th>\n" . 
						"					<th scope=\"col\">\n" . 
						"						<strong>Kunde</strong>\n" . 
						"					</th>\n" . 
						"					<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
						"						<strong>Aktion</strong>\n" . 
						"					</th>\n" . 
						"				</tr></thead>\n" . 

						$order_list . 

						"			</table>\n" . 
						"			<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
						"				<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
						"					<tr class=\"text-primary\">\n" . 
						"						<td width=\"40\">\n" . 
						"							<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
						"								<input type=\"checkbox\" id=\"order_sel_all_bottom\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_top').prop('checked');\$('#order_sel_all_top').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
						"								<label class=\"custom-control-label\" for=\"order_sel_all_bottom\"></label>\n" . 
						"							</div>\n" . 
						"						</td>\n" . 
						"						<td width=\"350\">\n" . 
						"							<label for=\"order_sel_all_bottom\" class=\"mt-1\">alle auswählen (" . (1+($orderpage > $rows ? $rows : $orderpage)) . " bis " . (($orderpage + $order_amount_rows) > $rows ? $rows : ($orderpage + $order_amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
						"						</td>\n" . 
						"						<td width=\"260\">\n" . 
						"							zuweisen\n" . 
						"							<input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<input type=\"hidden\" id=\"ids\" name=\"ids\" value=\"\" />\n" . 
						"							<button type=\"submit\" name=\"multi_add\" value=\"zuweisen\" class=\"btn btn-sm btn-primary\" onclick=\"var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich den gewählten Status für die ausgewählten Einträge durchführen?');}\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
						"						</td>\n" . 
						"						<td>\n" . 
						"							&nbsp;\n" . 
						"						</td>\n" . 
						"					</tr>\n" . 
						"				</table>\n" . 
						"			</form>\n" . 
						"		</div>\n" . 
						"		<br />\n" . 

						$orderNumberlist->getNavi();

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Auftrag zuweisen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<div class=\"form-group row mb-0\">\n" . 
				"					<label class=\"col-sm-2 col-form-label\">Gewählte Sendung</label>\n" . 
				"					<div class=\"col-sm-3 mt-1\">\n" . 
				"						<b>" . $row['shipments_id'] . "</b>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 

				$html_add_order . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>