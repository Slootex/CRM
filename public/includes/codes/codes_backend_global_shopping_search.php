<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "global_shopping_search";

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
if(isset($_POST["global_keyword"])){$_SESSION["global"]["keyword"] = str_replace(" ", "", strip_tags($_POST["global_keyword"]));}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION["global"]);
}

$global_sorting = array();
$global_sorting[] = array(
	"name" => "Externe Auftragsnummer", 
	"value" => "`shopping_shoppings`.`item_number`"
);
$global_sorting[] = array(
	"name" => "Lieferanten", 
	"value" => "CAST(`shopping_shoppings`.`suppliers` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Angeschrieben", 
	"value" => "CAST(`shopping_shoppings`.`contact_emails` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Preis", 
	"value" => "`shopping_shoppings`.`price`"
);
$global_sorting[] = array(
	"name" => "Status", 
	"value" => "`status_name`"
);
$global_sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`shopping_shoppings`.`upd_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`shopping_shoppings`.`reg_date` AS UNSIGNED)"
);

$global_sorting_field_name = isset($_SESSION["global"]["sorting_field"]) ? $global_sorting[$_SESSION["global"]["sorting_field"]]["value"] : $global_sorting[0]["value"];
$global_sorting_field_value = isset($_SESSION["global"]["sorting_field"]) ? $_SESSION["global"]["sorting_field"] : 0;

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

$arr_suppliers = array(
	0 => "eBAY", 
	1 => "Allegro", 
	2 => "Webseite", 
	3 => "Amazon", 
	4 => "Technik"
);

$arr_radio_payment = array(
	0 => "bezahlt per PayPal", 
	1 => "bezahlt per Kreditkarte", 
	2 => "bezahlt per Überweisung", 
	3 => "warte auf Rechnung", 
	4 => "storniert"
);

$arr_retoure_carrier = array(
	0 => "DHL", 
	1 => "UPS", 
	2 => "Hermes", 
	3 => "DPD", 
	4 => "TNT"
);

$arr_area = array('Einkäufe-Aktiv', 'Einkäufe-Archiv', 'Retouren-Aktiv', 'Retouren-Archiv');

$arr_edit_url = array('neue-einkaeufe', 'einkaeufe-archiv', 'neue-retouren', 'retouren-archiv');

$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `shopping_shoppings`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION["global"]["keyword"]) && $_SESSION["global"]["keyword"] != "" ? 
			"WHERE 	(`shopping_shoppings`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`shopping_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`item_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`info` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`url` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`faxnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`shipping_id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `shopping_shoppings`.`mode`>=0 " : " AND `shopping_shoppings`.`mode`>=0 ";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `shopping_shoppings`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = 	"	SELECT 		`shopping_shoppings`.`id` AS id, 
							`shopping_shoppings`.`mode` AS mode, 
							`shopping_shoppings`.`creator_id` AS creator_id, 
							`shopping_shoppings`.`shopping_number` AS shopping_number, 
							`shopping_shoppings`.`order_number` AS order_number, 
							`shopping_shoppings`.`order_id` AS order_id, 
							`shopping_shoppings`.`item_number` AS item_number, 
							`shopping_shoppings`.`suppliers` AS suppliers, 
							`shopping_shoppings`.`supplier` AS supplier, 
							`shopping_shoppings`.`description` AS description, 
							`shopping_shoppings`.`contact_emails` AS contact_emails, 
							`shopping_shoppings`.`info` AS info, 
							`shopping_shoppings`.`price` AS price, 
							`shopping_shoppings`.`radio_payment` AS radio_payment, 
							`shopping_shoppings`.`url` AS url, 
							`shopping_shoppings`.`email` AS email, 
							`shopping_shoppings`.`phonenumber` AS phonenumber, 
							`shopping_shoppings`.`faxnumber` AS faxnumber, 
							`shopping_shoppings`.`retoure_carrier` AS retoure_carrier, 
							`shopping_shoppings`.`shipping_id` AS shipping_id, 
							`shopping_shoppings`.`run_date` AS run_date, 
							`shopping_shoppings`.`reg_date` AS reg_date, 
							`shopping_shoppings`.`cpy_date` AS cpy_date, 
							`shopping_shoppings`.`upd_date` AS time, 

							(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`shopping_shoppings`.`order_id`) AS order_mode, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`shopping_shoppings`.`admin_id`) AS admin_name, 

							(SELECT 		`statuses`.`name` AS name 
								FROM 		`shopping_shoppings_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`shopping_shoppings_statuses`.`status_id` 
								WHERE 		`shopping_shoppings_statuses`.`shopping_id`=`shopping_shoppings`.`id` 
								AND 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`shopping_shoppings_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 		`statuses`.`color` AS color 
								FROM 		`shopping_shoppings_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`shopping_shoppings_statuses`.`status_id` 
								WHERE 		`shopping_shoppings_statuses`.`shopping_id`=`shopping_shoppings`.`id` 
								AND 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`shopping_shoppings_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							`shopping_shoppings`.`admin_id` AS admin_id 
							
				FROM 		`shopping_shoppings` 
				" . $where . $and . " 
				AND 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

	while($row_shoppings = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_shoppings['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_shoppings['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_shoppings['shopping_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_order_url[$row_shoppings['order_mode']] . "/bearbeiten/" . $row_shoppings['order_id'] . "\">" . $row_shoppings['order_number'] . "</a>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_shoppings['item_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $arr_suppliers[$row_shoppings['suppliers']] . "</small>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<small>" . $row_shoppings['supplier'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shoppings['description'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<small>" . $row_shoppings['contact_emails'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shoppings['info'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-center\">\n" . 
					"			<small>" . number_format($row_shoppings['price'], 2, ',', '') . " &euro;</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_orders['status_color'] . "\">" . $row_orders['status_name'] . "<sup>" . $row_orders['status_counter'] . "</sup></span>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_shoppings['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_shoppings['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td" . ($row_shoppings['creator_id'] == $maindata['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shoppings['admin_name'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . $arr_area[$row_shoppings['mode']] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_edit_url[$row_shoppings['mode']] . "/bearbeiten/" . $row_shoppings['id'] . "\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>\n" . 
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
		"		<h3>Einstellungen - Globale Einkäufe suche</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Bereiche durchsuchen.</p>\n" . 
		"<form id=\"shopping_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
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
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(6, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(6, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Erstellt</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Bestellnummer</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Auftragsnummer</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"180\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Externe Auftragsnummer</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Lieferanten</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Lieferant</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Beschreibung</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Angeschrieben</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Info</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Preis</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Status</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"90\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(5, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(5, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Geändert</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Bereich</strong>\n" . 
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