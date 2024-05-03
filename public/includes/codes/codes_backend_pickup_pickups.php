<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "pickup_pickups";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

function getPickupStatus($maindata, $row){

	$opts = array(
	  'http'=>array(
		'method'=>"GET",
		'header'=>"AccessLicenseNumber: " . $maindata['ups_access_license_number'] . "\r\n" .
				  "Password: " . $maindata['ups_password'] . "\r\n" .
				  "Content-Type: application/json\r\n" .
				  "Username: " . $maindata['ups_username'] . "\r\n" .
				  "Accept: application/json\r\n" .
				  "User-agent: BROWSER-DESCRIPTION-HERE\r\n"
	  )
	);

	$context = stream_context_create($opts);

	$result = file_get_contents($maindata['ups_url'] . '/ship/v1/pickups/oncall', false, $context);

	return json_decode($result);

}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$pickup_pickups_session = "pickup_pickups_search";

if(isset($_POST["sorting_field"])){$_SESSION[$pickup_pickups_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$pickup_pickups_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$pickup_pickups_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$pickup_pickups_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$pickup_pickups_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Abholtext", 
	"value" => "`pickup_pickups`.`description`"
);
$sorting[] = array(
	"name" => "Kürzel", 
	"value" => "`pickup_pickups`.`shortcut`"
);
$sorting[] = array(
	"name" => "Abholreferenz", 
	"value" => "`pickup_pickups`.`prn`"
);
$sorting[] = array(
	"name" => "Datum", 
	"value" => "CAST(`pickup_pickups`.`pickupdate` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$pickup_pickups_session]["sorting_field"]) ? $sorting[$_SESSION[$pickup_pickups_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$pickup_pickups_session]["sorting_field"]) ? $_SESSION[$pickup_pickups_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$pickup_pickups_session]["sorting_direction"]) ? $directions[$_SESSION[$pickup_pickups_session]["sorting_direction"]] : "DESC";
$sorting_direction_value = isset($_SESSION[$pickup_pickups_session]["sorting_direction"]) ? $_SESSION[$pickup_pickups_session]["sorting_direction"] : 1;

$amount_rows = isset($_SESSION[$pickup_pickups_session]["rows"]) && $_SESSION[$pickup_pickups_session]["rows"] > 0 ? $_SESSION[$pickup_pickups_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$service_types = array(
	'001' => 'UPS Next Day Air', 
	'002' => 'UPS 2nd Day Air', 
	'003' => 'UPS Ground', 
	'004' => 'UPS Ground, UPS Standard', 
	'007' => 'UPS Worldwide Express', 
	'008' => 'UPS Worldwide Expedited', 
	'011' => 'UPS Standard', 
	'012' => 'UPS 3 Day Select', 
	'013' => 'UPS Next Day Air Saver', 
	'014' => 'UPS Next Day Air Early', 
	'021' => 'UPS Economy', 
	'031' => 'UPS Basic', 
	'054' => 'UPS Worldwide Express Plus', 
	'059' => 'UPS 2nd Day Air A.M.', 
	'064' => 'UPS Express NA1', 
	'065' => 'UPS Saver', 
	'071' => 'UPS Worldwide Express Freight Midday', 
	'074' => 'UPS Express 12:00', 
	'082' => 'UPS Standard Today', 
	'083' => 'UPS Today Dedicated Courier', 
	'084' => 'UPS Intercity Today', 
	'085' => 'UPS Today Express', 
	'086' => 'UPS Today Express Saver', 
	'096' => 'UPS Worldwide Express Freight' 
);

$paymentmethods = array(
	'00' => 'Keine Zahlung erforderlich', 
	'01' => 'Zahlung per Versenderkonto', 
	'03' => 'Mit Kreditkarte bezahlen', 
	'04' => 'Bezahlen mit 1Z Tracking-Nummer', 
	'05' => 'Per Scheck oder Zahlungsanweisung bezahlen', 
	'06' => 'Bargeld (Nur bei Ländercode: BE, FR, DE, IT, MX, NL, PL, ES, GB, CZ, HU, FI, NO)', 
	'07' => 'PayPal bezahlen' 
);

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`pickup_pickups` 
							WHERE 		`pickup_pickups`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$emsg = "<small class=\"error bg-success text-white\">Die Abholung wurde erfolgreich entfernt.</small><br />\n";

}

if(isset($_POST['pickup']) && $_POST['pickup'] == "stornieren"){

	$data = array();

	$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

	$ch = curl_init($maindata['ups_url'] . '/ship/v1/pickups/prn');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
			'Password: ' . $maindata['ups_password'],
			'Content-Type: application/json',
			'Username: ' . $maindata['ups_username'],
			'Accept: application/json',
			'Prn: ' . strip_tags($_POST['prn']),
			'Content-Length: ' . strlen($data_string)
		)
	);

	$result = curl_exec($ch);

	$response = json_decode($result);

	if(isset($response->PickupCancelResponse->Response->ResponseStatus->Code) && $response->PickupCancelResponse->Response->ResponseStatus->Code == "1"){
		
		mysqli_query($conn, "	UPDATE 	`pickup_pickups` 
								SET 	`pickup_pickups`.`status`='1' 
								WHERE 	`pickup_pickups`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<small class=\"error bg-success text-white\">Die Abholung wurde erfolgreich storniert.</small><br />\n";
		
	}else{

		$emsg = "<small class=\"error bg-danger text-white\">" . $response->response->errors[0]->message . "</small><br />\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `pickup_pickups`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`pickup_pickups`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `pickup_pickups`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION[$pickup_pickups_session]["keyword"]) && $_SESSION[$pickup_pickups_session]["keyword"] != "" ? 
			"WHERE (`pickup_pickups`.`referencenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`shortcut` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`contactname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`addressline` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`postalcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`countrycode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`phone` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`room` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`floor` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`pickuppoint` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%'
			OR		`pickup_pickups`.`prn` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pickup_pickups_session]["keyword"]) . "%') " : 
			"WHERE	`pickup_pickups`.`id`>0 ";

$query = "	SELECT 		`pickup_pickups`.`id` AS id, 
						(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`pickup_pickups`.`admin_id`) AS admin_name, 
						(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`pickup_pickups`.`countrycode`) AS countryname, 
						`pickup_pickups`.`referencenumber` AS referencenumber, 
						`pickup_pickups`.`description` AS description, 
						`pickup_pickups`.`pickupdate` AS pickupdate, 
						`pickup_pickups`.`readytime_hours` AS readytime_hours, 
						`pickup_pickups`.`readytime_minutes` AS readytime_minutes, 
						`pickup_pickups`.`closetime_hours` AS closetime_hours, 
						`pickup_pickups`.`closetime_minutes` AS closetime_minutes, 
						`pickup_pickups`.`shortcut` AS shortcut, 
						`pickup_pickups`.`companyname` AS companyname, 
						`pickup_pickups`.`contactname` AS contactname, 
						`pickup_pickups`.`addressline` AS addressline, 
						`pickup_pickups`.`postalcode` AS postalcode, 
						`pickup_pickups`.`city` AS city, 
						`pickup_pickups`.`countrycode` AS countrycode, 
						`pickup_pickups`.`email` AS email, 
						`pickup_pickups`.`phone` AS phone, 
						`pickup_pickups`.`room` AS room, 
						`pickup_pickups`.`floor` AS floor, 
						`pickup_pickups`.`pickuppoint` AS pickuppoint, 
						`pickup_pickups`.`weight` AS weight, 
						`pickup_pickups`.`servicecode` AS servicecode, 
						`pickup_pickups`.`paymentmethod` AS paymentmethod, 
						`pickup_pickups`.`transactionidentifier` AS transactionidentifier, 
						`pickup_pickups`.`prn` AS prn, 
						`pickup_pickups`.`status` AS status 
			FROM 		`pickup_pickups` 
			" . $where . " 
			AND 		`pickup_pickups`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$popup = 	"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Abholdatum</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . date("d.m.Y", $row['pickupdate']) . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Abholzeitraum</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['readytime_hours'] . ":" . $row['readytime_minutes'] . " - " . $row['closetime_hours'] . ":" . $row['closetime_minutes'] . " Uhr</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Referenznummer</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['referencenumber'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Hinweis</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['description'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Firma</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['companyname'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Name</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['contactname'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Adresse</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<a href=\"http://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&z=14&iwloc=A&q=" . urlencode($row['addressline'] . " " . $row['postalcode'] . " " . $row['city'] . " " . $row['countryname']) . "\" target=\"_blank\">" . $row['addressline'] . ", " . $row['postalcode'] . " " . $row['city'] . ", " . $row['countryname'] . "</a>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Email</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<a href=\"mailto: " . $row['email'] . "\">" . $row['email'] . "</a>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Telefon</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['phone'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Raum</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['room'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Stockwerk</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['floor'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Abholort</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['pickuppoint'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-12\">\n" . 
					"		<br /><strong class=\"text-primary\">Eigenschaften</strong>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Service</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $service_types[$row['servicecode']] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Zahlart</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $paymentmethods[$row['paymentmethod']] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>Transactionidentifier</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['transactionidentifier'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n" . 
					"<div class=\"row\">\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<span>PRN</span>\n" . 
					"	</div>\n" . 
					"	<div class=\"col-sm-6 mt-1\">\n" . 
					"		<em>" . $row['prn'] . "</em>\n" . 
					"	</div>\n" . 
					"</div>\n";

		$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . date("d.m.Y (H:i)", $row['pickupdate']) . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['admin_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['description'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $row['shortcut'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<span>" . $row['prn'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<span class=\"badge badge-pill badge-" . ($row['status'] == 1 ? "danger" : "success") . "\">" . ($row['status'] == 1 ? "storniert" : "in bearbeitung") . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"			<input type=\"hidden\" name=\"prn\" value=\"" . $row['prn'] . "\" />\n" . 
					"			<div class=\"btn-group\">\n" . 
					"				<button type=\"submit\" name=\"pickup\" value=\"stornieren\" class=\"btn btn-sm btn-warning\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"stornieren\" title=\"\" onclick=\"return confirm('Wollen Sie diese Abholung wirklich stornieren?')\"><i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
					"				<button type=\"submit\" name=\"delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"entfernen\" title=\"\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
					"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-sm btn-success\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Details\" title=\"\" onclick=\"showShippingDialog('<i class=\'fa fa-thumb-tack\' aria-hidden=\'true\'></i> DETAILS', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($popup, ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
					"			</div>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Versand - Abholungen</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$pickup_pickups_session]['keyword']) && $_SESSION[$pickup_pickups_session]['keyword'] != "" ? $_SESSION[$pickup_pickups_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Abholungen einsehen und gegebenfalls entfernen.</p>\n" . 
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
		"					<div class=\"d-inline text-nowrap\"><strong>Abholtext</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th scope=\"col\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Kürzel</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th width=\"130\" scope=\"col\" class=\"text-center\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Abholreferenz</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th width=\"12\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Status</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
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

		"<br />\n<br />\n<br />\n";

?>