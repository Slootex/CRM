<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "user_archive";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_condition.php");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$parameter = array();

$parameter['tab'] = "edit";
$parameter['link'] = "kunden-archiv";

$users_session = "users";
$users_action = "/crm/kunden-archiv";
$users_table = "user_users";
$users_id_field = "user_id";
$users_mode = 0;
$users_archiv_mode = 1;
$users_hash = "";
$users_templates_type = 3;
$users_right = "user_archive";
$users_name = "Archiv-Kunde";

$tabs = array();

$show_autocomplete_script = 0;

$countryToId = "";

if(isset($_POST["extra_search"])){$_SESSION[$users_session]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["view_order_extra_search"])){$_SESSION[$users_session]["view_order_extra_search"] = strip_tags($_POST["view_order_extra_search"]);}
if(isset($_POST["view_interested_extra_search"])){$_SESSION[$users_session]["view_interested_extra_search"] = strip_tags($_POST["view_interested_extra_search"]);}
if(isset($_POST["rows"])){$_SESSION[$users_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$users_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$users_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$users_session]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["view_order_keyword"])){$_SESSION[$users_session]["view_order_keyword"] = str_replace(" ", "", strip_tags($_POST["view_order_keyword"]));}
if(isset($_POST["view_interested_keyword"])){$_SESSION[$users_session]["view_interested_keyword"] = str_replace(" ", "", strip_tags($_POST["view_interested_keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$users_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Status", 
	"value" => "`status_name`"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`user_users`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`user_users`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`user_users`.`reg_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Kundennummer", 
	"value" => "`user_users`.`user_number`"
);

$sorting_field_name = isset($_SESSION[$users_session]["sorting_field"]) ? $sorting[$_SESSION[$users_session]["sorting_field"]]["value"] : $sorting[3]["value"];
$sorting_field_value = isset($_SESSION[$users_session]["sorting_field"]) ? $_SESSION[$users_session]["sorting_field"] : 3;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$users_session]["sorting_direction"]) ? $directions[$_SESSION[$users_session]["sorting_direction"]] : "DESC";
$sorting_direction_value = isset($_SESSION[$users_session]["sorting_direction"]) ? $_SESSION[$users_session]["sorting_direction"] : 1;

if(isset($param['add']) && $param['add'] == "add"){
	$_POST['add'] = "hinzufügen";
}

$amount_rows = isset($_SESSION[$users_session]["rows"]) && $_SESSION[$users_session]["rows"] > 0 ? $_SESSION["users"]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$view_order_amount_rows = 10;
if(!isset($param['view_orderpage'])){
	$view_orderpage = 0;
}else{
	$view_orderpage = intval($param['view_orderpage']);
}

$view_orderNumberlist = new pageList();

$view_interested_amount_rows = 10;
if(!isset($param['view_interestedpage'])){
	$view_interestedpage = 0;
}else{
	$view_interestedpage = intval($param['view_interestedpage']);
}

$view_interestedNumberlist = new pageList();

$emsg = "";
$emsg_files = "";
$emsg_audio = "";

$inp_ref_number = "";

$inp_companyname = "";
$inp_firstname = "";
$inp_lastname = "";
$inp_street = "";
$inp_streetno = "";
$inp_zipcode = "";
$inp_city = "";
$inp_country = "";
$inp_phonenumber = "";
$inp_mobilnumber = "";
$inp_email = "";
$inp_password = "";

$inp_machine = "";
$inp_model = "";
$inp_constructionyear = "";
$inp_carid = "";
$inp_kw = "";
$inp_mileage = "";
$inp_mechanism = "";
$inp_fuel = "";

// ----- New Email
$inp_new_email_name = "";
$inp_new_email_email = "";
$inp_new_email_subject = "";
$inp_new_email_body = "";
// ----- Customer Message
$inp_message = "";

$companyname = "";
$firstname = "";
$lastname = "";
$street = "";
$streetno = "";
$zipcode = "";
$city = "";
$country = 0;
$phonenumber = "";
$mobilnumber = "";
$email = "";
$password = "";

$ref_number = "";
$customer_number = "";
$call_date = 0;
$machine = "";
$constructionyear = "";
$carid = "";
$kw = "";
$mileage = 0;
$mechanism = 0;
$fuel = 0;

// ----- New Email
$new_email_name = "";
$new_email_email = "";
$new_email_subject = "";
$new_email_body = "";
// ----- Customer Message
$message = "";

$html_new_email = "";
$html_new_status = "";
$html_view_order = "";
$html_view_interested = "";

if(isset($param['edit']) && strip_tags($param['edit']) == "bearbeiten" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "kunden-archiv";

	$_POST['id'] = intval($param['id']);
	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['multi_status']) && $_POST['multi_status'] == "durchführen" && isset($_POST['status']) && intval($_POST['status']) > 0){

	include("includes/condition/admin_users_multi_status.php");

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE id=" . intval($_POST['id'])), MYSQLI_ASSOC);

}

$result_tabs = mysqli_query($conn, "SELECT 		* 
									FROM 		`rights` 
									WHERE 		`rights`.`parent_id`=(SELECT `rights`.`id` AS id FROM `rights` WHERE `rights`.`authorization`='" . $users_right . "') 
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

					$radio_payment = $row_order['radio_payment'];

				}

				include("includes/condition/" . $condition->phpFile());

			}

		}

	}

}

if(isset($_POST['move']) && $_POST['move'] == "zu Kunden"){

	$parameter['link'] = "kunden-archiv";

	include("includes/condition/admin_users_move_zu_kunden.php");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$users_session]["keyword"]) && $_SESSION[$users_session]["keyword"] != "" ? 
			"WHERE 	(`user_users`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`user_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 

			OR		`user_users`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%' 
			OR		`user_users`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$users_session]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `user_users`.`mode`=1 " : " AND `user_users`.`mode`=1 ";
$and .= isset($_SESSION[$users_session]["extra_search"]) && $_SESSION[$users_session]["extra_search"] > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`user_users_statuses`.`status_id`) AS id FROM `user_users_statuses` WHERE `user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `user_users_statuses`.`user_id`=`user_users`.`id` ORDER BY CAST(`user_users_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION[$users_session]["extra_search"] : "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `user_users`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`user_users`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `user_users`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = 	"	SELECT 		`user_users`.`id` AS id, 
							`user_users`.`user_number` AS user_number, 
							`user_users`.`companyname` AS companyname, 
							`user_users`.`firstname` AS firstname, 
							`user_users`.`lastname` AS lastname, 
							`user_users`.`audio` AS audio, 
							`user_users`.`reg_date` AS reg_date, 
							`user_users`.`upd_date` AS time, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`user_users`.`admin_id`) AS admin_name, 

							(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $users_table . "_statuses`.`status_id`) AS name 
								FROM 	`" . $users_table . "_statuses` 
								WHERE 	`" . $users_table . "_statuses`.`" . $users_id_field . "`=`user_users`.`id` 
								AND 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY CAST(`" . $users_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $users_table . "_statuses`.`status_id`) AS color 
								FROM 	`" . $users_table . "_statuses` 
								WHERE 	`" . $users_table . "_statuses`.`" . $users_id_field . "`=`user_users`.`id` 
								AND 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY CAST(`" . $users_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							(SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=`" . $users_table . "_statuses`.`status_id`) AS id 
								FROM 	`" . $users_table . "_statuses` 
								WHERE 	`" . $users_table . "_statuses`.`" . $users_id_field . "`=`user_users`.`id` 
								AND 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY CAST(`" . $users_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_id, 

							(SELECT 		`" . $users_table . "_customer_messages`.`message` AS message 
								FROM 		`" . $users_table . "_customer_messages` `" . $users_table . "_customer_messages` 
								WHERE 		`" . $users_table . "_customer_messages`.`" . $users_id_field . "`=`user_users`.`id` 
								AND 		`" . $users_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	CAST(`" . $users_table . "_customer_messages`.`time` AS UNSIGNED) DESC limit 0, 1) AS message, 

							`user_users`.`admin_id` AS admin_id 
							
				FROM 		`user_users` 
				" . $where . $and . " 
				AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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
									$users_action, 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

if(!isset($_POST['edit']) && !isset($_POST['update']) && (!isset($_POST['id']) || (isset($_POST['id']) && intval($_POST['id']) == 0))){

	if($rows > 0){

		while($row_users = $result->fetch_array(MYSQLI_ASSOC)){

			$list .= 	"<form action=\"" . $users_action . "\" method=\"post\">\n" . 
						"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_users['id'] ? " class=\"bg-primary text-white\"" : "") . " onclick=\"$('#order_list_" . $row_users['id'] . "').prop('checked', !$('#order_list_" . $row_users['id'] . "').prop('checked'))\">\n" . 
						"		<td scope=\"row\">\n" . 
						"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
						"				<input type=\"checkbox\" id=\"order_list_" . $row_users['id'] . "\" data-id=\"" . $row_users['id'] . "\" class=\"custom-control-input order-list\" />\n" . 
						"				<label class=\"custom-control-label\" for=\"order_list_" . $row_users['id'] . "\"></label>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_users['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_users['reg_date']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\">\n" . 
						"			" . ($row_users['audio'] != "" ? "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\"><i class=\"fa fa-music\"> </i></div>" : "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\"><i class=\"fa fa-ban\"> </i></div>") . "\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\">\n" . 
						"			<small>" . $row_users['user_number'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_users['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_users['time']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small>" . $row_users['admin_name'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_users['status_color'] . "\">" . $row_users['status_name'] . "</span>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small>" . ($row_users['companyname'] != "" ? $row_users['companyname'] . ", " : "") . $row_users['firstname'] . " " . $row_users['lastname'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<input type=\"hidden\" name=\"id\" value=\"" . $row_users['id'] . "\" />\n" . 
						"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}else{

		$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$users_session]["keyword"] . " - übereinstimmende Kunden gefunden.')</script>\n" : "";

	}

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`type`='3' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$extra_search_options = "						<option value=\"0\"" . (isset($_SESSION[$users_session]['extra_search']) && $_SESSION[$users_session]['extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION[$users_session]['extra_search']) && $_SESSION[$users_session]['extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
}

$result_statuses = mysqli_query($conn, "	SELECT 		* 
											FROM 		`statuses` 
											WHERE 		`statuses`.`type`='" . $users_templates_type . "' 
											AND 		`statuses`.`multi_status`='1' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

$multi_search_options = "";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$multi_search_options .= "						<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
}

$navigation = new navigation($conn, 4, ($parameter['link'] == "neue-kunden" ? "user_users" : ($parameter['link'] == "kunden-archiv" ? "user_archive" : ($parameter['link'] == "neuen-kunde" ? "user_new" : ""))));
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 
		$navigation->show() . 
		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $users_action . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$users_session]['keyword']) && $_SESSION[$users_session]['keyword'] != "" ? $_SESSION[$users_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary text-nowrap\">Löschen <i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\">Filter</button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
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
		"							<hr />\n" . 
		"							<select id=\"extra_search\" name=\"extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		$extra_search_options . 
		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-7\">\n" . 
		"		" . (!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? "<h3>Kundenarchiv - Kundennummer: " . $row_user['user_number'] . "</h3><p id=\"user_info\" class=\"mb-0\">" . ($row_user['companyname'] != "" ? "Firma: " . $row_user['companyname'] . ", " : "") . "Name: " . ($row_user['gender'] == 1 ? "Frau" : "Herr") . " " . $row_user['firstname'] . " " . $row_user['lastname'] . "</p>" : (isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? "<h3>Neuer Kunde</h3>" : "<h3>Kundenarchiv - Archivübersicht</h3>")) . "\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right\">\n" . 
		"		" . 
		(
			!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? 
			"		<form action=\"" . $users_action . "\" method=\"post\">\n" . 
			"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
			"			<button type=\"submit\" name=\"move\" value=\"zu Kunden\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich bach Kunden verschieben?')\">zu Kunden <i class=\"fa fa-user\" aria-hidden=\"true\"></i></button>\n" . 
			"		</form>\n" : 
			(
				isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? 
				"" : 
				""
			)
		) . "\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	include("includes/condition/admin_users_not_add_not_edit_not_save_not_update.php");

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	include("includes/condition/admin_users_edit_bearbeiten.php");

}

?>