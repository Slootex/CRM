<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "storage_places";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$storage_places_session = "storage_places_search";

if(isset($_POST["sorting_field"])){$_SESSION[$storage_places_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$storage_places_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$storage_places_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$storage_places_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["room_id"])){$_SESSION["room"]["id"] = intval($_POST["room_id"]);}

if(!isset($param['room_id'])){

}else{
	$_SESSION["room"]["id"] = intval($param['room_id']);
	$_POST['search'] = "suchen";
}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$storage_places_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Lagerplatz", 
	"value" => "`storage_places`.`name`"
);
$sorting[] = array(
	"name" => "Pos", 
	"value" => "`storage_places`.`pos`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`storage_places`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$storage_places_session]["sorting_field"]) ? $sorting[$_SESSION[$storage_places_session]["sorting_field"]]["value"] : $sorting[1]["value"];
$sorting_field_value = isset($_SESSION[$storage_places_session]["sorting_field"]) ? $_SESSION[$storage_places_session]["sorting_field"] : 1;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$storage_places_session]["sorting_direction"]) ? $directions[$_SESSION[$storage_places_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$storage_places_session]["sorting_direction"]) ? $_SESSION[$storage_places_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$storage_places_session]["rows"]) && $_SESSION[$storage_places_session]["rows"] > 0 ? $_SESSION[$storage_places_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";

$name = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name für diesen Platz eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`storage_places` 
								SET 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($_POST['room_id'])) . "', 
										`storage_places`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`storage_places`.`parts`='" . mysqli_real_escape_string($conn, intval($_POST['parts'])) . "', 
										`storage_places`.`pos`='" . mysqli_real_escape_string($conn, intval($_POST['pos'])) . "'");

		$_POST["id"] = $conn->insert_id;

		$emsg = "<p>Der neue Lagerplatz wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name für diesen Platz eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`storage_places` 
								SET 	`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($_POST['room_id'])) . "', 
										`storage_places`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`storage_places`.`parts`='" . mysqli_real_escape_string($conn, intval($_POST['parts'])) . "', 
										`storage_places`.`pos`='" . mysqli_real_escape_string($conn, intval($_POST['pos'])) . "' 
								WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Der Lagerplatz wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$db->query("DELETE FROM	`storage_places` 
				WHERE 		`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
				AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine storage_places.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 7){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`storage_places` 
													SET 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, (isset($_POST['room']) && intval($_POST['room']) > 0 ? intval($_POST['room']) : intval($data[2]))) . "', 
															`storage_places`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`storage_places`.`parts`='" . mysqli_real_escape_string($conn, intval($data[4])) . "', 
															`storage_places`.`used`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`storage_places`.`pos`='" . mysqli_real_escape_string($conn, intval($data[6])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`storage_places` 
													SET 	`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, (isset($_POST['room']) && intval($_POST['room']) > 0 ? intval($_POST['room']) : intval($data[2]))) . "', 
															`storage_places`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`storage_places`.`parts`='" . mysqli_real_escape_string($conn, intval($data[4])) . "', 
															`storage_places`.`used`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`storage_places`.`pos`='" . mysqli_real_escape_string($conn, intval($data[6])) . "' 
													WHERE 	`storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

						}

					}

				}

				$rows++;

			}

			fclose($handle);

		}

	}else{

		$_POST['data'] = "importieren";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

if(!isset($_POST['data']) && isset($_SESSION["room"]["id"]) && intval($_SESSION["room"]["id"]) > 0){

	$where = 	isset($_SESSION[$storage_places_session]["keyword"]) && $_SESSION[$storage_places_session]["keyword"] != "" ? 
				" AND (`storage_places`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$storage_places_session]["keyword"]) . "%') " : 
				"";

	$query = 	"	SELECT 		*, 
								(SELECT name FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`=`storage_places`.`room_id`) AS room_name, 
								(SELECT COUNT(*) AS a_d FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`storage_space_id`=`storage_places`.`id`) AS devices_amount, 
								(SELECT COUNT(*) AS a_s FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`mode`='0' AND `shopin_shopins`.`order_id`='0' AND `shopin_shopins`.`storage_space_id`=`storage_places`.`id`) AS shopins_amount 
					FROM 		`storage_places` 
					WHERE 		`storage_places`.`room_id`=" . mysqli_real_escape_string($conn, intval($_SESSION["room"]["id"])) . " 
					AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					" . $where . " 
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
										$page['url'] . "/" . intval($_SESSION["room"]["id"]), 
										$getParam = "", 
										10, 
										1);

	$query .= " limit " . $pos . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

		$total = $row_item['devices_amount'] + $row_item['shopins_amount'];

		$html_devices = "<b><u>In einem Auftrag</u>:</b><br />\n";

		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number, 
															`order_orders_devices`.`atot_mode` AS atot_mode, 
															`order_orders_devices`.`at` AS at, 
															`order_orders_devices`.`ot` AS ot 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		while($row_devices = $result_devices->fetch_array(MYSQLI_ASSOC)){

			$html_devices .= $row_devices['device_number'] . ($row_devices['atot_mode'] == 1 ? "-AT-" . $row_devices['at'] : ($row_devices['atot_mode'] == 2 ? "-ORG-" . $row_devices['ot'] : "")) . "<br />";

		}

		$html_shopins_with_order = "<br />\n<b><u>Wareneingang Auftragsgerät</u>:</b><br />\n";

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

			$html_shopins_with_order .= $row_shopins['device_number'] . ($row_shopins['atot_mode'] == 1 ? "-AT-" . $row_shopins['at'] : ($row_shopins['atot_mode'] == 2 ? "-ORG-" . $row_shopins['ot'] : "")) . "<br />\n";

		}

		$html_shopins_helpdevices = "<br />\n<b><u>Wareneingang Hilfsgerät</u>:</b><br />\n";

		$result_shopins_helpdevices = mysqli_query($conn, "	SELECT 		`shopin_shopins`.`id` AS id, 
																		`shopin_shopins`.`help_device_number` AS help_device_number 
															FROM 		`shopin_shopins` 
															WHERE 		`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' 
															AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`shopin_shopins`.`mode`='0' 
															AND 		`shopin_shopins`.`order_id`='0'");

		while($row_shopins_helpdevices = $result_shopins_helpdevices->fetch_array(MYSQLI_ASSOC)){

			$html_shopins_helpdevices .= $row_shopins_helpdevices['help_device_number'] . "<br />\n";

		}

		$list .= 	"<form action=\"" . $page['url'] . "/" . intval($_SESSION["room"]["id"]) . "/pos/" . $pos . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && intval($_POST['id']) == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row_item['room_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row_item['name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<a href=\"Javascript: void 0\" onclick=\"\$('#toggle_" . $row_item['id'] . "').slideToggle(0)\"><i class=\"fa fa-caret-right\" aria-hidden=\"true\"></i> ansehen</a>\n" . 
					"			<div id=\"toggle_" . $row_item['id'] . "\" style=\"display: none\">" . $html_devices . $html_shopins_with_order . $html_shopins_helpdevices . "</div>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"\" title=\"" . $html_devices . $html_shopins_with_order . $html_shopins_helpdevices . "\">\n" . 
					"			<span>" . $row_item['used'] . " von " . $row_item['parts'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\">\n" . 
					"			<span" . ($row_item['used'] != $total ? " class=\"text-danger\"" : " class=\"text-success\"") . ">" . $total . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"room_id\" value=\"" . intval($_SESSION["room"]["id"]) . "\" />\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"" . ($row_item['used'] > 0 ? " disabled=\"disabled\"" : "") . ">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}

$result_pages = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`>0 ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

$rooms_options = "";

while($p = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$rooms_options .= "				<option value=\"" . $p["id"] . "\"" . (isset($_SESSION["room"]["id"]) && $p["id"] == $_SESSION["room"]["id"] ? " selected=\"selected\"" : "") . ">" . $p['name'] . "</option>\n";

}

$row_used = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`used`>0 limit 0, 1"), MYSQLI_ASSOC);

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Einstellungen - Lagerplätze</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<select id=\"room_id\" name=\"room_id\" class=\"custom-select custom-select-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\">\n" . 

		$rooms_options . 

		"				</select>\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$storage_places_session]['keyword']) && $_SESSION[$storage_places_session]['keyword'] != "" ? $_SESSION[$storage_places_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: 0\" />\n" . 
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
		"<p>Hier können Sie die Lagerplätze bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<div class=\"btn-group\">\n" . 
		"					<select id=\"room_id\" name=\"room_id\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\">\n" . 

		$rooms_options . 

		"					</select>\n" . 
		"					<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"				</div>&nbsp;\n" . 
		"				<a href=\"/crm/lagerplaetze-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\"" . (isset($row_used['id']) && $row_used['id'] > 0 ? " disabled=\"disabled=\"" : "") . ">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<button type=\"button\" name=\"data\" value=\"print\" class=\"btn btn-primary\" onclick=\"
		var divToPrint=document.getElementById('printTable');
		newWin= window.open('');
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();\">Drucken <i class=\"fa fa-print\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(!isset($_POST['data']) && isset($_SESSION["room"]["id"]) && intval($_SESSION["room"]["id"]) > 0){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table id=\"printTable\" class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\" border=\"1\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"80\" scope=\"col\">\n" . 
				"				<strong>Raum</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"130\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Lagerplatz</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Geräte</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"90\" scope=\"col\">\n" . 
				"				<strong>Benutzt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"90\" scope=\"col\">\n" . 
				"				<strong>Total</strong>\n" . 
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

				((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$result = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	$rooms_options = "";

	while($b = $result->fetch_array(MYSQLI_ASSOC)){

		$rooms_options .= "<option value=\"" . $b['id'] . "\"" . (isset($_POST["room_id"]) && $b["id"] == $_POST["room_id"] ? " selected=\"selected\"" : "") . ">" . $b['name'] . "</option>\n";

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
				"						<label for=\"room_id\" class=\"col-sm-2 col-form-label\">Raum <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ein Raum aus unter dem der Lagerplatz dargestellt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"room_id\" name=\"room_id\" class=\"custom-select\">" . $rooms_options . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-2 col-form-label\">Lagerplatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Lagerplatzes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"parts\" class=\"col-sm-2 col-form-label\">Teileanzahl <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Teileanzahl des Lagerplatzes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"parts\" name=\"parts\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['parts']) : 0) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-2 col-form-label\">Reihenfolge <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Reihenfolge des Lagerplatzes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['pos']) : 0) . "\" class=\"form-control\" />\n" . 
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

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$result = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	$rooms_options = "";

	while($b = $result->fetch_array(MYSQLI_ASSOC)){

		$rooms_options .= "<option value=\"" . $b['id'] . "\"" . ($b['id'] == $row_item['room_id'] ? " selected=\"selected\"" : "") . ">" . $b['name'] . "</option>\n";

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

				"				<form action=\"" . $page['url'] . "/" . intval($_SESSION["room"]["id"]) . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"room_id\" class=\"col-sm-2 col-form-label\">Raum <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Raum unter dem der Lagerplatz dargestellt werden soll ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"room_id\" name=\"room_id\" class=\"custom-select\">" . $rooms_options . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-2 col-form-label\">Lagerplatz <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name des Lagerplatzes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : $row_item["name"]) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"parts\" class=\"col-sm-2 col-form-label\">Teileanzahl <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Teileanzahl des Lagerplatzes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"parts\" name=\"parts\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['parts']) : $row_item["parts"]) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-2 col-form-label\">Reihenfolge <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Reihenfolge des Lagerplatzes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['pos']) : $row_item["pos"]) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">neu speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}

if(isset($_POST['data']) && $_POST['data'] == "importieren"){
	
	$result_roomes = mysqli_query($conn, "SELECT * FROM `storage_rooms` WHERE `storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_rooms`.`id`>0 ORDER BY CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

	$rooms_options = "								<option value=\"0\">nicht ändern</option>\n";

	while($p = $result_roomes->fetch_array(MYSQLI_ASSOC)){

		$rooms_options .= "								<option value=\"" . $p["id"] . "\">" . $p['name'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Importieren</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Datei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die CSV-Datei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Mode <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_0\" name=\"mode\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_0\">\n" . 
				"									aktualisieren\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_1\" name=\"mode\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_1\">\n" . 
				"									hinzufügen\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"room\" class=\"col-sm-3 col-form-label\">Raum <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Raum auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"room\" name=\"room\" class=\"custom-select\">\n" . 

				$rooms_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"data\" class=\"btn btn-primary\">Import durchführen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>