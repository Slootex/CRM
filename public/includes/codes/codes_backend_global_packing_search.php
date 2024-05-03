<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "global_packing_search";

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
	"name" => "Zusatzbemerkung", 
	"value" => "`packing_packings`.`message`"
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

$arr_area = array('Packtische-Aktiv', 'Packtische-Archiv');

$arr_edit_url = array('neue-packtische', 'packtische-archiv');

$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `packing_packings`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION["global"]["keyword"]) && $_SESSION["global"]["keyword"] != "" ? 
			"WHERE 	(`packing_packings`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`packing_packings`.`packing_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%' 
			OR		`packing_packings`.`message` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["global"]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `packing_packings`.`mode`>=0 " : " AND `packing_packings`.`mode`>=0 ";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `packing_packings`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = 	"	SELECT 		`packing_packings`.`id` AS id, 
							`packing_packings`.`mode` AS mode, 
							`packing_packings`.`creator_id` AS creator_id, 
							`packing_packings`.`order_id` AS order_id, 
							`packing_packings`.`packing_number` AS packing_number, 
							`packing_packings`.`message` AS message, 
							`packing_packings`.`reg_date` AS reg_date, 
							`packing_packings`.`upd_date` AS time, 

							(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`packing_packings`.`order_id`) AS order_mode, 

							(SELECT `order_orders`.`order_number` AS o_order_number FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`packing_packings`.`order_id`) AS order_number, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`packing_packings`.`admin_id`) AS admin_name, 

							(SELECT 		`statuses`.`name` AS name 
								FROM 		`packing_packings_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`packing_packings_statuses`.`status_id` 
								WHERE 		`packing_packings_statuses`.`packing_id`=`packing_packings`.`id` 
								AND 		`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`packing_packings_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 		`statuses`.`color` AS color 
								FROM 		`packing_packings_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`packing_packings_statuses`.`status_id` 
								WHERE 		`packing_packings_statuses`.`packing_id`=`packing_packings`.`id` 
								AND 		`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`packing_packings_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							`packing_packings`.`admin_id` AS admin_id 
							
				FROM 		`packing_packings` 
				" . $where . $and . " 
				AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

	while($row_packings = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_packings['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_packings['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_packings['packing_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_order_url[$row_packings['order_mode']] . "/bearbeiten/" . $row_packings['order_id'] . "\">" . $row_packings['order_number'] . "</a>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_packings['message'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_packings['status_color'] . "\">" . $row_packings['status_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_packings['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_packings['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td" . ($row_packings['creator_id'] == $row_packings['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_packings['admin_name'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . $arr_area[$row_packings['mode']] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_edit_url[$row_packings['mode']] . "/bearbeiten/" . $row_packings['id'] . "\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>\n" . 
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
		"		<h3>Einstellungen - Globale Packtische suche</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Bereiche durchsuchen.</p>\n" . 
		"<form id=\"packing_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
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
				"				<strong>Packtischnr</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"180\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Auftragsnummer</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline\"><strong>Zusatzbemerkung</strong></div>\n" . 
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
				"				<strong>Admin</strong>\n" . 
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