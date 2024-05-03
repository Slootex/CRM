<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "global_search";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_POST["global_rows"])){$_SESSION["global"]["rows"] = intval($_POST["global_rows"]);}
if(isset($_POST["global_sorting_field"])){$_SESSION["global"]["sorting_field"] = intval($_POST["global_sorting_field"]);}
if(isset($_POST["global_sorting_direction"])){$_SESSION["global"]["sorting_direction"] = intval($_POST["global_sorting_direction"]);}
if(isset($_POST["global_country"])){$_SESSION["global"]["country"] = intval($_POST["global_country"]);}
//if(isset($_POST["global_keyword"])){$_SESSION["global"]["keyword"] = str_replace(" ", "", strip_tags($_POST["global_keyword"]));}
if(isset($_POST["global_keyword"])){$_SESSION["global"]["keyword"] = chop(strip_tags($_POST["global_keyword"]));}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION["global"]);
}

$global_sorting = array();
$global_sorting[] = array(
	"name" => "Bereich", 
	"value" => "CAST(`order_orders`.`mode` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`order_orders`.`reg_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`order_orders`.`order_number`"
);
$global_sorting[] = array(
	"name" => "Hat Zahl. Nachnahme", 
	"value" => "`radio_payment`"
);

$global_sorting_field_name = isset($_SESSION["global"]["sorting_field"]) ? $global_sorting[$_SESSION["global"]["sorting_field"]]["value"] : $global_sorting[2]["value"];
$global_sorting_field_value = isset($_SESSION["global"]["sorting_field"]) ? $_SESSION["global"]["sorting_field"] : 2;

$global_sorting_field_options = "";
foreach($global_sorting as $k => $v){
	$global_sorting_field_options .= "<option value=\"" . $k . "\"" . ($global_sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$global_sorting_direction_name = isset($_SESSION["global"]["sorting_direction"]) ? $directions[$_SESSION["global"]["sorting_direction"]] : "DESC";
$global_sorting_direction_value = isset($_SESSION["global"]["sorting_direction"]) ? $_SESSION["global"]["sorting_direction"] : 1;

$global_country = isset($_SESSION["global"]["country"]) ? $_SESSION["global"]["country"] : 0;

$global_amount_rows = isset($_SESSION["global"]["rows"]) && $_SESSION["global"]["rows"] > 0 ? $_SESSION["global"]["rows"] : 200;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$and = "";

$arr_area = array('Aufträge-Aktiv', 'Aufträge-Archiv', 'Interessenten-Aktiv', 'Interessenten-Archiv');

$arr_edit_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `order_orders`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION["global"]["keyword"]) && $_SESSION["global"]["keyword"] != "" ? 
			"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, explode("-", $_SESSION["global"]["keyword"])[0]) . "%' 
			OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		(SELECT `shipping_history`.`shipments_id` AS shipments_id FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`id`=`order_orders`.`shipping_history_id`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`id`=(SELECT `order_orders_devices`.`order_id` AS o_o_d_order_id FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`manufacturer`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `order_orders_devices`.`order_id` AS o_o_d_order_id FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`serial`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `order_orders_devices`.`order_id` AS o_o_d_order_id FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`additional_numbers`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 

			OR		`order_orders`.`id`=(SELECT 		`order_orders_devices`.`order_id` AS o_o_d_order_id 
											FROM		`order_orders_devices` 
											LEFT JOIN	`storage_places` 
											ON			`order_orders_devices`.`storage_space_id`=`storage_places`.`id` 
											WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`storage_places`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 

			OR		`order_orders`.`id`=(SELECT `order_orders_devices`.`order_id` AS o_o_d_order_id FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`info`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `order_orders_history`.`order_id` AS o_o_h_order_id FROM `order_orders_history` WHERE `order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_history`.`message`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `order_orders_customer_messages`.`order_id` AS o_o_c_m_order_id FROM `order_orders_customer_messages` WHERE `order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_customer_messages`.`message`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `interested_interesteds_history`.`interested_id` AS i_i_h_order_id FROM `interested_interesteds_history` WHERE `interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `interested_interesteds_history`.`message`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`id`=(SELECT `interested_interesteds_customer_messages`.`interested_id` AS i_i_c_m_order_id FROM `interested_interesteds_customer_messages` WHERE `interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `interested_interesteds_customer_messages`.`message`LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' limit 0, 1) 
			OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`model` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `order_orders`.`mode`>=0 " : " AND `order_orders`.`mode`>=0 ";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `order_orders`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$and_country = $global_country > 0 ? "AND 		`order_orders`.`country`='" . mysqli_real_escape_string($conn, intval($global_country)) . "' " : "";

$query = 	"	SELECT 		`order_orders`.`id` AS id, 
							`order_orders`.`mode` AS mode, 
							`order_orders`.`creator_id` AS creator_id, 
							`order_orders`.`order_number` AS order_number, 
							`order_orders`.`status_counter` AS status_counter, 
							`order_orders`.`companyname` AS companyname, 
							`order_orders`.`firstname` AS firstname, 
							`order_orders`.`lastname` AS lastname, 
							`order_orders`.`audio` AS audio, 
							`order_orders`.`run_date` AS run_date, 
							`order_orders`.`reg_date` AS reg_date, 
							`order_orders`.`cpy_date` AS cpy_date, 
							`order_orders`.`upd_date` AS time, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

							(SELECT `shipping_history`.`shipments_id` AS shipments_id FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`id`=`order_orders`.`shipping_history_id`) AS shipments_number, 

							(SELECT 		`order_orders_payings`.`radio_payment` AS p_radio_payment 
								FROM		`order_orders_payings` 
								WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_payings`.`order_id`=`order_orders`.`id` 
								AND 		`order_orders_payings`.`radio_payment`='1' 
								ORDER BY	CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1) AS radio_payment, 

							`order_orders`.`admin_id` AS admin_id 
							
				FROM 		`order_orders` 
				" . $where . $and . " 
				AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
				" . $and_country . " 
				ORDER BY 	" . $global_sorting_field_name . " " . $global_sorting_direction_name;

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
									$global_amount_rows, 
									"/pos", 
									$page['url'], 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $global_amount_rows;

$result = mysqli_query($conn, $query);

if($rows > 0){

	while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			" . intval(($row_orders['cpy_date'] - $row_orders['run_date']) / 60) . "\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_orders['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			" . ($row_orders['audio'] != "" ? "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\"><i class=\"fa fa-music\"> </i></div>" : "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\"><i class=\"fa fa-ban\"> </i></div>") . "\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"" . ($row_orders['shipments_number'] != "" ? "<strong>Sendungsnummer</strong>: " . $row_orders['shipments_number'] : "") . "\" title=\"\" class=\"" . ($row_orders['shipments_number'] != "" ? "text-success" : "") . "\" onclick=\"var obj = document.getElementById('order_" . $row_orders['order_number'] . "_shipment');obj.style.display='block';obj.select();document.execCommand('copy');obj.style.display='none';\">\n" . 
					"			<small>" . $row_orders['order_number'] . "</small><input type=\"text\" id=\"order_" . $row_orders['order_number'] . "_shipment\" name=\"order_" . $row_orders['order_number'] . "_shipment\" value=\"" . $row_orders['shipments_number'] . "\" style=\"display: none\" />\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td" . ($row_orders['creator_id'] == $maindata['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
					"			<small>" . $row_orders['admin_name'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . $arr_area[$row_orders['mode']] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<small>" . ($row_orders['radio_payment'] == 1 ? "Ja" : "Nein") . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_edit_url[$row_orders['mode']] . "/bearbeiten/" . $row_orders['id'] . "\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}else{

	$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION["global"]["keyword"] . " - übereinstimmende Einträge gefunden.')</script>\n" : "";

}

$options_countries = "";

$result = mysqli_query($conn, "	SELECT 		`countries`.`id` AS id, 
											`countries`.`name` AS name 
								FROM 		`countries` 
								ORDER BY 	`countries`.`name` ASC");

while($row_countries = $result->fetch_array(MYSQLI_ASSOC)){

	$options_countries .= "								<option value=\"" . $row_countries['id'] . "\"" . ($global_country == $row_countries['id'] ? " selected=\"selected\"" : "") . ">" . $row_countries['name'] . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Einstellungen - Globale suche</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Bereiche durchsuchen.</p>\n" . 
		"<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<hr />\n" . 
		"	<div class=\"row\">\n" . 
		"		<div class=\"col-12 text-right\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"global_keyword\" name=\"global_keyword\" value=\"" . (isset($_SESSION['global']['keyword']) && $_SESSION['global']['keyword'] != "" ? $_SESSION['global']['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<hr />\n" . 
		"	<div class=\"row\">\n" . 
		"		<div class=\"col-12 text-right\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\">Löschen <i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"							<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"							<select id=\"global_rows\" name=\"global_rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"10\"" . ($global_amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"								<option value=\"20\"" . ($global_amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"								<option value=\"40\"" . ($global_amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"								<option value=\"50\"" . ($global_amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"								<option value=\"60\"" . ($global_amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"								<option value=\"80\"" . ($global_amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"								<option value=\"100\"" . ($global_amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"								<option value=\"200\"" . ($global_amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"								<option value=\"400\"" . ($global_amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"								<option value=\"500\"" . ($global_amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"							<select id=\"global_sorting_field\" name=\"global_sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$global_sorting_field_options . 

		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"							<select id=\"global_sorting_direction\" name=\"global_sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($global_sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"								<option value=\"1\"" . ($global_sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Land</h6>\n" . 
		"							<select id=\"global_country\" name=\"global_country\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($global_country == 0 ? " selected=\"selected\"" : "") . ">Alle</option>\n" . 

		$options_countries . 

		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(!isset($_POST['ever'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"40\" scope=\"col\" align=\"center\">\n" . 
				"				<div style=\"width: 40px;height: 24px;font-size: 1rem\" class=\"text-" . $_SESSION["admin"]["color_table_head"] . " text-center\"><i class=\"fa fa-clock-o\"> </i></div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirectionGlobal(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirectionGlobal(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Erstellt</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"40\" scope=\"col\" align=\"center\">\n" . 
				"				<div style=\"width: 40px;height: 24px;font-size: 1rem\" class=\"text-" . $_SESSION["admin"]["color_table_head"] . " text-center\"><i class=\"fa fa-music\"> </i></div>\n" . 
				"			</th>\n" . 
				"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirectionGlobal(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirectionGlobal(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Nr</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirectionGlobal(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirectionGlobal(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Geändert</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"200\" scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"220\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirectionGlobal(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirectionGlobal(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Bereich</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Kunde</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"180\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirectionGlobal(5, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirectionGlobal(5, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Hat Zahl. Nachnahme</strong></div>\n" . 
				"				</div>\n" . 
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
				"					<label for=\"order_sel_all_bottom\" class=\"mt-1\">(" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $global_amount_rows) > $rows ? $rows : ($pos + $global_amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"				</td>\n" . 
				"				<td>\n" . 
				"					&nbsp;\n" . 
				"				</td>\n" . 
				"			</tr>\n" . 
				"		</table>\n" . 
				"	</form>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

}

?>