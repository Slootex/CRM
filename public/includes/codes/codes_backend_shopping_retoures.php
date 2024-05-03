<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "shopping_retoures";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_condition.php");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$parameter = array();

$parameter['tab'] = "edit";
$parameter['link'] = "neue-retouren";

$shopping_session = "retoures";
$shopping_action = "/crm/neue-retouren";
$shopping_table = "shopping_retoures";
$shopping_id_field = "shopping_id";
$shopping_mode = 2;
$shopping_archiv_mode = 3;
$shopping_hash = "shopping_hash";
$shopping_templates_type = 6;
$shopping_right = "shopping_retoures";
$shopping_name = "Retoure";

$tabs = array();

if(isset($_POST["extra_search"])){$_SESSION[$shopping_session]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["order_extra_search"])){$_SESSION[$shopping_session]["order_extra_search"] = strip_tags($_POST["order_extra_search"]);}
if(isset($_POST["user_extra_search"])){$_SESSION[$shopping_session]["user_extra_search"] = strip_tags($_POST["user_extra_search"]);}
if(isset($_POST["rows"])){$_SESSION[$shopping_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$shopping_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$shopping_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$shopping_session]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["user_keyword"])){$_SESSION[$shopping_session]["user_keyword"] = str_replace(" ", "", strip_tags($_POST["user_keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$shopping_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Externe Auftragsnummer", 
	"value" => "`shopping_shoppings`.`item_number`"
);
$sorting[] = array(
	"name" => "Lieferanten", 
	"value" => "CAST(`shopping_shoppings`.`suppliers` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Angeschrieben", 
	"value" => "CAST(`shopping_shoppings`.`contact_emails` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Preis", 
	"value" => "`shopping_shoppings`.`price`"
);
$sorting[] = array(
	"name" => "Status", 
	"value" => "`status_name`"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`shopping_shoppings`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`shopping_shoppings`.`reg_date` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$shopping_session]["sorting_field"]) ? $sorting[$_SESSION[$shopping_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$shopping_session]["sorting_field"]) ? $_SESSION[$shopping_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$shopping_session]["sorting_direction"]) ? $directions[$_SESSION[$shopping_session]["sorting_direction"]]: "ASC";
$sorting_direction_value = isset($_SESSION[$shopping_session]["sorting_direction"]) ? $_SESSION[$shopping_session]["sorting_direction"] : 0;

// ----- Global Search -----

$global_sorting = array();
$global_sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`shopping_shoppings`.`shopping_number`"
);
$global_sorting[] = array(
	"name" => "Bereich", 
	"value" => "CAST(`shopping_shoppings`.`mode` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`shopping_shoppings`.`upd_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`shopping_shoppings`.`reg_date` AS UNSIGNED)"
);

$global_sorting_field_name = isset($_SESSION["global"]["sorting_field"]) ? $global_sorting[$_SESSION["global"]["sorting_field"]]["value"] : $global_sorting[2]["value"];
$global_sorting_field_value = isset($_SESSION["global"]["sorting_field"]) ? $_SESSION["global"]["sorting_field"] : 2;

$global_sorting_field_options = "";
foreach($global_sorting as $k => $v){
	$global_sorting_field_options .= "<option value=\"" . $k . "\"" . ($global_sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$global_sorting_direction_name = isset($_SESSION["global"]["sorting_direction"]) ? $directions[$_SESSION["global"]["sorting_direction"]] : "DESC";
$global_sorting_direction_value = isset($_SESSION["global"]["sorting_direction"]) ? $_SESSION["global"]["sorting_direction"] : 1;

$global_amount_rows = isset($_SESSION["global"]["rows"]) && $_SESSION["global"]["rows"] > 0 ? $_SESSION["global"]["rows"] : 200;

if(isset($param['add']) && $param['add'] == "neue-retoure"){
	$_POST['add'] = "hinzufügen";
}

$amount_rows = isset($_SESSION[$shopping_session]["rows"]) && $_SESSION[$shopping_session]["rows"] > 0 ? $_SESSION[$shopping_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_order_number = "";
$inp_item_number = "";
$inp_suppliers = "";
$inp_supplier = "";
$inp_description = "";
$inp_contact_emails = "";
$inp_info = "";
$inp_price = "";
$inp_radio_payment = "";
$inp_url = "";
$inp_email = "";
$inp_phonenumber = "";
$inp_faxnumber = "";
$inp_retoure_carrier = "";
$inp_shipping_id = "";

$order_number = "";
$order_id = 0;
$item_number = "";
$suppliers = 0;
$supplier = "";
$description = "";
$contact_emails = 0;
$info = "";
$price = 0.00;
$radio_payment = 0;
$url = "";
$email = "";
$phonenumber = "";
$faxnumber = "";
$retoure_carrier = 0;
$shipping_id = "";

// ----- New Email
$new_email_name = "";
$new_email_email = "";
$new_email_subject = "";
$new_email_body = "";

$html_new_email = "";
$html_new_status = "";

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

if(isset($param['edit']) && strip_tags($param['edit']) == "bearbeiten" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-retouren";

	$_POST['id'] = intval($param['id']);
	$_POST['edit'] = "bearbeiten";

}

if(isset($param['move']) && strip_tags($param['move']) == "verschieben" && isset($param['archiv']) && strip_tags($param['archiv']) == "archiv" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "";
	$parameter['link'] = "neue-retouren";

	$_POST['id'] = intval($param['id']);
	$_POST['move'] = "Archiv";

}

if(isset($_POST['multi_status']) && $_POST['multi_status'] == "durchführen" && isset($_POST['status']) && intval($_POST['status']) > 0){

	include("includes/condition/admin_retoures_multi_status.php");

}

// Retoures-Archiv gibt es nicht !!
if(isset($_POST['multi_status']) && $_POST['multi_status'] == "durchführen" && isset($_POST['status']) && intval($_POST['status']) > 0 && isset($_POST['to_archiv'])){

	$parameter['retoure_to_archive_status'] = "retoure_to_archive_status";

//	include("includes/condition/admin_retoures_multi_status_to_archiv.php");

}

// Retoures-Archiv gibt es nicht !!
if(isset($_POST['multi_to_archiv']) && $_POST['multi_to_archiv'] == "durchführen"){

	$parameter['retoure_to_archive_status'] = "retoure_to_archive_status";

//	include("includes/condition/admin_retoures_multi_to_archiv.php");

}

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-retoure";

	$parameter['link_edit'] = "neue-retouren";

	$parameter['retoure_status'] = "retoure_status";

	include("includes/condition/admin_retoures_save_speichern.php");

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_shopping = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopping_shoppings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$parameter['link'] = "neue-retoure";
	
}

$result_tabs = mysqli_query($conn, "SELECT 		* 
									FROM 		`rights` 
									WHERE 		`rights`.`parent_id`=(SELECT `rights`.`id` AS id FROM `rights` WHERE `rights`.`authorization`='" . $shopping_right . "') 
									ORDER BY 	CAST(`rights`.`pos` AS UNSIGNED) ASC");

while($row_tab = $result_tabs->fetch_array(MYSQLI_ASSOC)){

	if(isset($_SESSION["admin"]["roles"][$row_tab['authorization']]) && $_SESSION["admin"]["roles"][$row_tab['authorization']] == 1){

		$tabs[] = $row_tab;

		$processings = explode("\r\n", $row_tab['processings']);

		for($i = 0;$i < count($processings);$i++){

			$condition = new condition();

			if($condition->parse($processings[$i]) == true){

				foreach($condition->parameter() as $key => $val){

					$parameter[$key] = $val;

				}

				$option = $condition->option();

				if(isset($option['radio_payment'])){

					$radio_payment = $row_shopping['radio_payment'];

				}

				include("includes/condition/" . $condition->phpFile());

			}

		}

	}

}

if(isset($_POST['move_shopping']) && $_POST['move_shopping'] == "Zu Einkäufe"){

	$parameter['link'] = "neue-retouren";

	$retoure_to_shoppings_status = "retoure_to_shoppings_status";

	$shopping_table = "shopping_shoppings";

	$shopping_id_field = "shopping_id";

	include("includes/condition/admin_retoure_move_shoppings_zu_einkaeufe.php");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$shopping_session]["keyword"]) && $_SESSION[$shopping_session]["keyword"] != "" ? 
			"WHERE 	(`shopping_shoppings`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`shopping_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`item_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`info` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`url` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`faxnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%' 
			OR		`shopping_shoppings`.`shipping_id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$shopping_session]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `shopping_shoppings`.`mode`=2 " : " AND `shopping_shoppings`.`mode`=2 ";
$and .= isset($_SESSION[$shopping_session]["extra_search"]) && $_SESSION[$shopping_session]["extra_search"] > 0 ? "AND (SELECT `statuses`.`id` AS id FROM `" . $shopping_table . "_statuses` LEFT JOIN `statuses` ON `statuses`.`id`=`" . $shopping_table . "_statuses`.`status_id` WHERE `" . $shopping_table . "_statuses`.`" . $shopping_id_field . "`=`shopping_shoppings`.`id` AND `" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`public`='1' ORDER BY CAST(`" . $shopping_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION[$shopping_session]["extra_search"] : "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`shopping_shoppings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `shopping_shoppings`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = 	"	SELECT 		`shopping_shoppings`.`id` AS id, 
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
								FROM 		`" . $shopping_table . "_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`" . $shopping_table . "_statuses`.`status_id` 
								WHERE 		`" . $shopping_table . "_statuses`.`" . $shopping_id_field . "`=`shopping_shoppings`.`id` 
								AND 		`" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`" . $shopping_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 		`statuses`.`color` AS color 
								FROM 		`" . $shopping_table . "_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`" . $shopping_table . "_statuses`.`status_id` 
								WHERE 		`" . $shopping_table . "_statuses`.`" . $shopping_id_field . "`=`shopping_shoppings`.`id` 
								AND 		`" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`" . $shopping_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							`shopping_shoppings`.`admin_id` AS admin_id 
							
				FROM 		`shopping_shoppings` 
				" . $where . $and . " 
				AND 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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
									$shopping_action, 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update']) && (!isset($_POST['id']) || (isset($_POST['id']) && intval($_POST['id']) == 0))){

	if($rows > 0){

		while($row_shoppings = $result->fetch_array(MYSQLI_ASSOC)){

			$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

			$list .= 	"<form action=\"" . $shopping_action . "\" method=\"post\">\n" . 
						"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? " class=\"bg-primary text-white retoures_menu\"" : " class=\"retouress_menu\"") . " onclick=\"if(\$(this).hasClass('active')){\$(this).removeClass('active');}else{\$(this).addClass('active');}$('#order_list_" . $row_shoppings['id'] . "').prop('checked', !$('#order_list_" . $row_shoppings['id'] . "').prop('checked'))\" data-id=\"" . $row_shoppings['id'] . "\" data-order_number=\"" . $row_shoppings['order_number'] . "\">\n" . 
						"		<td scope=\"row\">\n" . 
						"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
						"				<input type=\"checkbox\" id=\"order_list_" . $row_shoppings['id'] . "\" data-id=\"" . $row_shoppings['id'] . "\" class=\"custom-control-input order-list\" onclick=\"if(\$(this).closest('tr').hasClass('active')){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}\" />\n" . 
						"				<label class=\"custom-control-label\" for=\"order_list_" . $row_shoppings['id'] . "\"></label>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
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
						"		<td align=\"center\">\n" . 
						"			<div style=\"white-space: nowrap\">\n" . 
						"				<input type=\"hidden\" name=\"id\" value=\"" . $row_shoppings['id'] . "\" />\n" . 
						"				<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}else{

		$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$order_session]["keyword"] . " - übereinstimmende Retouren gefunden.')</script>\n" : "";

	}

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`type`='6' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$extra_search_options = "						<option value=\"0\"" . (isset($_SESSION[$order_session]['extra_search']) && $_SESSION[$shopping_session]['extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

	$extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION[$shopping_session]['extra_search']) && $_SESSION[$shopping_session]['extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

}

$result_statuses = mysqli_query($conn, "	SELECT 		* 
											FROM 		`statuses` 
											WHERE 		`statuses`.`type`='" . $shopping_templates_type . "' 
											AND 		`statuses`.`multi_status`='1' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

$multi_search_options = "";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

	$multi_search_options .= "						<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";

}

$navigation = new navigation($conn, 6, ($parameter['link'] == "neue-retouren" ? "shopping_retoures" : ($parameter['link'] == "retouren-archiv" ? "retoures_archive" : ($parameter['link'] == "neue-retoure" ? "retoure_new" : ""))));
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"/crm/globale-einkaeufe-suche\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-1\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"global_keyword\" name=\"global_keyword\" value=\"" . (isset($_SESSION['global_orders']['keyword']) && $_SESSION['global_orders']['keyword'] != "" ? $_SESSION['global_orders']['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"					</div>\n" . 
		"					<button type=\"button\" class=\"btn btn-secondary dropdown-toggle d-none\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.global-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\"></button>\n" . 
		"					<div class=\"global-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"						<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"						<select id=\"global_rows\" name=\"global_rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"							<option value=\"10\"" . ($global_amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"							<option value=\"20\"" . ($global_amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"							<option value=\"40\"" . ($global_amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"							<option value=\"50\"" . ($global_amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"							<option value=\"60\"" . ($global_amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"							<option value=\"80\"" . ($global_amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"							<option value=\"100\"" . ($global_amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"							<option value=\"200\"" . ($global_amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"							<option value=\"400\"" . ($global_amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"							<option value=\"500\"" . ($global_amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"						</select>\n" . 
		"						<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"						<select id=\"global_sorting_field\" name=\"global_sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$global_sorting_field_options . 

		"						</select>\n" . 
		"						<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"						<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"							<option value=\"0\"" . ($global_sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"							<option value=\"1\"" . ($global_sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"						</select>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-7\">\n" . 
		"		" . (!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? "<h3>Retourenübersicht-Bestellnummer: " . $row_shopping['shopping_number'] . "</h3>" : (isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? "<h3>Neue Retoure</h3>" : "<h3>Retourenübersicht</h3>")) . "\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right\">\n" . 
		"		" . 

		(
			!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? 
			"		<form action=\"" . $shopping_action . "\" method=\"post\">\n" . 
			"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
			"			<button type=\"submit\" name=\"move\" value=\"Archiv\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich in das Archiv verschieben?')\">zu Archiv <i class=\"fa fa-archive\" aria-hidden=\"true\"></i></button>\n" . 
			"			<button type=\"submit\" name=\"move_shopping\" value=\"Zu Einkäufe\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich nach Einkäufe verschieben?')\">zu Einkäufe <i class=\"fa fa-list\" aria-hidden=\"true\"></i></button>\n" . 
			"		</form>\n" : 

			(
				isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? 
				"" : 
				"		<form id=\"shopping_search\" action=\"" . $shopping_action . "\" method=\"post\">\n" . 
				"			<div class=\"form-group row mb-1\">\n" . 
				"				<div class=\"col-sm-12\">\n" . 
				"					<input type=\"hidden\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$shopping_session]['keyword']) && $_SESSION[$shopping_session]['keyword'] != "" ? $_SESSION[$shopping_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
				"					<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary d-none\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
				"					<div class=\"btn-group\">\n" . 
				"						<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\">Löschen <i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
				"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
				"					</div>\n" . 
				"					<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 40px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
				"						<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
				"						<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
				"							<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"							<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"							<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"							<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"							<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
				"							<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
				"							<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
				"							<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
				"							<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
				"							<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
				"						</select>\n" . 
				"						<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
				"						<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

				$sorting_field_options . 

				"						</select>\n" . 
				"						<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
				"						<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
				"							<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
				"							<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
				"						</select>\n" . 
				"						<hr />\n" . 
				"						<select id=\"extra_search\" name=\"extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

				$extra_search_options . 

				"						</select>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</form>\n"
			)

		) . "\n" . 

		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	$parameter['checkbox_to_archiv'] = "checkbox_to_archiv";

	include("includes/condition/admin_retoures_not_add_not_edit_not_save_not_update.php");

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	include("includes/condition/admin_retoures_add_hinzufuegen.php");

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	include("includes/condition/admin_retoures_edit_bearbeiten.php");

}

?>