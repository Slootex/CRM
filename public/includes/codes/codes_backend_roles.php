<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "roles";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$roles_session = "roles_search";

if(isset($_POST["sorting_field"])){$_SESSION[$roles_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$roles_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$roles_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$roles_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$roles_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`admin_roles`.`name`"
);
$sorting[] = array(
	"name" => "Beschreibung", 
	"value" => "`admin_roles`.`description`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`admin_roles`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$roles_session]["sorting_field"]) ? $sorting[$_SESSION[$roles_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$roles_session]["sorting_field"]) ? $_SESSION[$roles_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$roles_session]["sorting_direction"]) ? $directions[$_SESSION[$roles_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$roles_session]["sorting_direction"]) ? $_SESSION[$roles_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$roles_session]["rows"]) && $_SESSION[$roles_session]["rows"] > 0 ? $_SESSION[$roles_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_description = "";
$inp_admin_index = "";

$name = "";
$description = "";
$admin_index = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 20){
		$emsg .= "<span class=\"error\">Bitte einen Rollenname eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['description']) > 65536){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['admin_index']) < 1 || strlen($_POST['admin_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Admin-Index eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_index = " is-invalid";
	} else {
		$admin_index = strip_tags($_POST['admin_index']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`admin_roles` 
								SET 	`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`admin_roles`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`admin_roles`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`admin_roles`.`func`='" . mysqli_real_escape_string($conn, intval(isset($_POST['func']) ? $_POST['func'] : 0)) . "', 
										`admin_roles`.`admin_index`='" . mysqli_real_escape_string($conn, $admin_index) . "', 
										`admin_roles`.`time_recording_login_src`='" . mysqli_real_escape_string($conn, intval(isset($_POST['time_recording_login_src']) ? $_POST['time_recording_login_src'] : 0)) . "', 
										`admin_roles`.`searchresult_rights`='" . mysqli_real_escape_string($conn, intval(isset($_POST['searchresult_rights']) ? $_POST['searchresult_rights'] : 0)) . "', 
										`admin_roles`.`change_admin`='" . mysqli_real_escape_string($conn, intval(isset($_POST['change_admin']) ? $_POST['change_admin'] : 0)) . "'");

		$_POST["id"] = $conn->insert_id;

		$company_rights = array();

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`company_rights` 
										WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`company_rights`.`id` AS UNSIGNED) ASC");

		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$company_rights[$row['right_id']] = $row;

		}

		$data = array();

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`rights` 
										ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$data[] = $row;

		}

		for($i = 0;$i < count($data);$i++){

			if($data[$i]['parent_id'] == 0 && isset($company_rights[$data[$i]['id']]) && $company_rights[$data[$i]['id']]['enable'] == 1){

				mysqli_query($conn, "	INSERT 	`admin_role_rights` 
										SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($data[$i]['id'])) . "', 
												`admin_role_rights`.`enable`='" . mysqli_real_escape_string($conn, intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : 0)) . "'");

				for($j = 0;$j < count($data);$j++){

					if($data[$j]['parent_id'] == $data[$i]['id'] && isset($company_rights[$data[$j]['id']]) && $company_rights[$data[$j]['id']]['enable'] == 1){

						mysqli_query($conn, "	INSERT 	`admin_role_rights` 
												SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
														`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($data[$j]['id'])) . "', 
														`admin_role_rights`.`enable`='" . mysqli_real_escape_string($conn, intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : 0)) . "'");

					}

				}

			}

		}

		$emsg = "<p>Die neue Rolle wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 20){
		$emsg .= "<span class=\"error\">Bitte einen Rollenname eingeben. (max. 20 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['description']) > 65536){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['admin_index']) < 1 || strlen($_POST['admin_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Admin-Index eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_index = " is-invalid";
	} else {
		$admin_index = strip_tags($_POST['admin_index']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	DELETE FROM	`admin_role_rights` 
								WHERE 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	UPDATE 	`admin_roles` 
								SET 	`admin_roles`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`admin_roles`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`admin_roles`.`func`='" . mysqli_real_escape_string($conn, intval(isset($_POST['func']) ? $_POST['func'] : 0)) . "', 
										`admin_roles`.`admin_index`='" . mysqli_real_escape_string($conn, $admin_index) . "', 
										`admin_roles`.`time_recording_login_src`='" . mysqli_real_escape_string($conn, intval(isset($_POST['time_recording_login_src']) ? $_POST['time_recording_login_src'] : 0)) . "', 
										`admin_roles`.`searchresult_rights`='" . mysqli_real_escape_string($conn, intval(isset($_POST['searchresult_rights']) ? $_POST['searchresult_rights'] : 0)) . "', 
										`admin_roles`.`change_admin`='" . mysqli_real_escape_string($conn, intval(isset($_POST['change_admin']) ? $_POST['change_admin'] : 0)) . "' 
								WHERE 	`admin_roles`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$company_rights = array();

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`company_rights` 
										WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`company_rights`.`id` AS UNSIGNED) ASC");

		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$company_rights[$row['right_id']] = $row;

		}

		$data = array();

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`rights` 
										ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$data[] = $row;

		}

		for($i = 0;$i < count($data);$i++){

			if($data[$i]['parent_id'] == 0 && isset($company_rights[$data[$i]['id']]) && $company_rights[$data[$i]['id']]['enable'] == 1){

				mysqli_query($conn, "	INSERT 	`admin_role_rights` 
										SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($data[$i]['id'])) . "', 
												`admin_role_rights`.`enable`='" . mysqli_real_escape_string($conn, intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : 0)) . "'");

				for($j = 0;$j < count($data);$j++){

					if($data[$j]['parent_id'] == $data[$i]['id'] && isset($company_rights[$data[$j]['id']]) && $company_rights[$data[$j]['id']]['enable'] == 1){

						mysqli_query($conn, "	INSERT 	`admin_role_rights` 
												SET 	`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
														`admin_role_rights`.`right_id`='" . mysqli_real_escape_string($conn, intval($data[$j]['id'])) . "', 
														`admin_role_rights`.`enable`='" . mysqli_real_escape_string($conn, intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : 0)) . "'");

					}

				}

			}

		}

		$emsg = "<p>Die Rolle wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`admin_roles` 
							WHERE 		`admin_roles`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin_role_rights` 
							WHERE 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$func = array(
	0 => "Keine", 
	1 => "Verkäufer", 
	2 => "Ersteller"
);

$list = "";

$where = 	isset($_SESSION[$roles_session]["keyword"]) && $_SESSION[$roles_session]["keyword"] != "" ? 
			"WHERE 	(`admin_roles`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$roles_session]["keyword"]) . "%' 
			OR		`admin_roles`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$roles_session]["keyword"]) . "%') " : 
			"WHERE 	`admin_roles`.`id`>0";

$query = "	SELECT 		* 
			FROM 		`admin_roles` 
			" . $where . " 
			AND 		`admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . substr(strip_tags($row['description']), 0, 128) . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $func[$row['func']] . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Rollen</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$roles_session]['keyword']) && $_SESSION[$roles_session]['keyword'] != "" ? $_SESSION[$roles_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Berechtigungsrollen bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">Rolle hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n" . 
		"<hr />\n" . 
		$pageNumberlist->getInfo() . 

		"<br />\n" . 

		$pageNumberlist->getNavi() . 

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
		"			<th width=\"200\" scope=\"col\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Name</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th align=\"center\" scope=\"col\">\n" . 
		"				<div class=\"d-block text-nowrap\">\n" . 
		"					<div class=\"d-inline\">\n" . 
		"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
		"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"d-inline text-nowrap\"><strong>Beschreibung</strong></div>\n" . 
		"				</div>\n" . 
		"			</th>\n" . 
		"			<th width=\"100\" scope=\"col\">\n" . 
		"				<strong>Funktion</strong>\n" . 
		"			</th>\n" . 
		"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
		"				<strong>Aktion</strong>\n" . 
		"			</th>\n" . 
		"		</tr></thead>\n" . 

		$list . 

		"	</table>\n" . 
		"</div>\n" . 
		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");


if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$company_rights = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`company_rights` 
									WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`company_rights`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$company_rights[$row['right_id']] = $row;

	}

	$data = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights` 
									ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$data[] = $row;

	}

	$menu = array();

	for($i = 0;$i < count($data);$i++){

		if($data[$i]['parent_id'] == 0 && isset($company_rights[$data[$i]['id']]) && $company_rights[$data[$i]['id']]['enable'] == 1){

			if(!isset($menu[$data[$i]['area_id']])){
				$menu[$data[$i]['area_id']] = "";
			}

			$menu[$data[$i]['area_id']] .= 	"									<div class=\"form-group row\">\n" . 
											"										<label class=\"col-sm-6 col-form-label\">" . $data[$i]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
											"										<div class=\"col-sm-6\">\n" . 
											"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
											"												<input type=\"checkbox\" id=\"" . $data[$i]['authorization'] . "\" name=\"" . $data[$i]['authorization'] . "\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : 0) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
											"												<label class=\"custom-control-label\" for=\"" . $data[$i]['authorization'] . "\">\n" . 
											"													Zugriff erlauben\n" . 
											"												</label>\n" . 
											"											</div>\n" . 
											"										</div>\n" . 
											"									</div>\n";

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id'] && isset($company_rights[$data[$j]['id']]) && $company_rights[$data[$j]['id']]['enable'] == 1){

					$menu[$data[$i]['area_id']] .= 	"									<div class=\"form-group row\">\n" . 
													"										<div class=\"col-sm-1 mt-1 text-right\">\n" . 
													"											&nbsp;\n" . 
													"										</div>\n" . 
													"										<label class=\"col-sm-5 col-form-label\">" . $data[$j]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
													"										<div class=\"col-sm-6\">\n" . 
													"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
													"												<input type=\"checkbox\" id=\"" . $data[$j]['authorization'] . "\" name=\"" . $data[$j]['authorization'] . "\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : 0) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
													"												<label class=\"custom-control-label\" for=\"" . $data[$j]['authorization'] . "\">\n" . 
													"													Zugriff erlauben\n" . 
													"												</label>\n" . 
													"											</div>\n" . 
													"										</div>\n" . 
													"									</div>\n";


				}

			}

		}

	}

	$add_options = array();

	$add_options[0] = "";

	$add_options[1] = 	"									<div class=\"form-group row\">\n" . 
						"										<label for=\"func\" class=\"col-sm-6 col-form-label\">Funktion <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welche Funktion die Rolle hat.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"func\" name=\"func\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['func']) : 0) == 0 ? " selected=\"selected\"" : "") . ">Keine</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['func']) : 0) == 1 ? " selected=\"selected\"" : "") . ">Verkäufer</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['func']) : 0) == 2 ? " selected=\"selected\"" : "") . ">Ersteller</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"form-group row\">\n" . 
						"										<label for=\"time_recording_login_src\" class=\"col-sm-6 col-form-label\">Zeiterfassung Login <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welche Suchergebnisse berechtigt sind.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"time_recording_login_src\" name=\"time_recording_login_src\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['time_recording_login_src']) : 0) == 0 ? " selected=\"selected\"" : "") . ">Admin - Login</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['time_recording_login_src']) : 0) == 1 ? " selected=\"selected\"" : "") . ">Single - Login</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['time_recording_login_src']) : 0) == 2 ? " selected=\"selected\"" : "") . ">Multi - Login</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"form-group row\">\n" . 
						"										<label class=\"col-sm-6 col-form-label\">Mitarbeiter ändern <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle Mitarbeiter ändern kann.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"												<input type=\"checkbox\" id=\"change_admin\" name=\"change_admin\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['change_admin']) ? $_POST['change_admin'] : 0) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"change_admin\">\n" . 
						"													Zugriff erlauben\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"									</div>\n";

	$add_options[2] = "";

	$add_options[3] = "";

	$add_options[4] = "";

	$add_options[5] = "";

	$add_options[6] = "";

	$add_options[7] = "";

	$add_options[8] = "";

	$add_options[9] = "";

	$add_options[11] = 	"									<div class=\"form-group row\">\n" . 
						"										<label for=\"admin_index\" class=\"col-sm-6 col-form-label\">Admin-Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Admin-Index der Rolle ein. (URL die nach dem Login aufgerufen werden soll.)\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<input type=\"text\" id=\"admin_index\" name=\"admin_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_index : "") . "\" class=\"form-control" . $inp_admin_index . "\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<label for=\"searchresult_rights\" class=\"col-sm-6 col-form-label\">Suchergebnisse, Berechtigung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welche Suchergebnisse berechtigt sind.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"searchresult_rights\" name=\"searchresult_rights\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['searchresult_rights']) ? $_POST['searchresult_rights'] : 0) : 0) == 0 ? " selected=\"selected\"" : "") . ">Nur eigene Datensätze</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['searchresult_rights']) ? $_POST['searchresult_rights'] : 0) : 0) == 1 ? " selected=\"selected\"" : "") . ">Eigene und Dummy Datensätze</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['searchresult_rights']) ? $_POST['searchresult_rights'] : 0) : 0) == 2 ? " selected=\"selected\"" : "") . ">Alle Datensätze</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n";

	$add_options[12] = "";

	$rights_categories_navi = "";

	$rights_categories_content = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights_categories` 
									ORDER BY 	CAST(`rights_categories`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$rights_categories_navi .= "								<a class=\"nav-link\" id=\"v-pills-" . $row['id'] . "-tab\" data-toggle=\"pill\" href=\"#v-pills-" . $row['id'] . "\" role=\"tab\" aria-controls=\"v-pills-" . $row['id'] . "\" aria-selected=\"false\">" . $row['name'] . "</a>\n";

		$rights_categories_content .= 	"								<div class=\"tab-pane fade\" id=\"v-pills-" . $row['id'] . "\" role=\"tabpanel\" aria-labelledby=\"v-pills-" . $row['id'] . "-tab\">\n" . 

										$add_options[$row['id']] . 

										(isset($menu[$row['id']]) ? $menu[$row['id']] : "") . 

										"								</div>\n";

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

				"					<div class=\"row mb-3\">\n" . 
				"						<div class=\"col-3 border-right\">\n" . 
				"							<div class=\"nav flex-column nav-pills\" id=\"v-pills-tab\" role=\"tablist\" aria-orientation=\"vertical\">\n" . 
				"								<a class=\"nav-link active\" id=\"v-pills-info-tab\" data-toggle=\"pill\" href=\"#v-pills-info\" role=\"tab\" aria-controls=\"v-pills-info\" aria-selected=\"true\">Information</a>\n" . 

				$rights_categories_navi . 

				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-9\">\n" . 
				"							<div class=\"tab-content\" id=\"v-pills-tabContent\">\n" . 
				"								<div class=\"tab-pane fade show active\" id=\"v-pills-info\" role=\"tabpanel\" aria-labelledby=\"v-pills-info-tab\">\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name der Rolle ein.\">?</span></label>\n" . 
				"										<div class=\"col-sm-9\">\n" . 
				"											<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"edit_content\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Beschreibung der Rolle ein.\">?</span></label>\n" . 
				"										<div class=\"col-sm-9\">\n" . 
				"											<textarea id=\"edit_content\" name=\"description\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_description . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $description : "") . "</textarea>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 

				$rights_categories_content . 

				"							</div>\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin_roles` WHERE `admin_roles`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin_roles`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	$role_rights = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin_role_rights` 
									WHERE 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($row_role['id'])) . "' 
									ORDER BY 	CAST(`admin_role_rights`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$role_rights[$row['right_id']] = $row;

	}

	$company_rights = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`company_rights` 
									WHERE 		`company_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`company_rights`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$company_rights[$row['right_id']] = $row;

	}

	$data = array();

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights` 
									ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$data[] = $row;

	}

	$menu = array();

	for($i = 0;$i < count($data);$i++){

		if($data[$i]['parent_id'] == 0 && isset($company_rights[$data[$i]['id']]) && $company_rights[$data[$i]['id']]['enable'] == 1){

			if(!isset($menu[$data[$i]['area_id']])){

				$menu[$data[$i]['area_id']] = "";

			}

			$menu[$data[$i]['area_id']] .= 	"									<div class=\"form-group row\">\n" . 
											"										<label class=\"col-sm-6 col-form-label\">" . $data[$i]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
											"										<div class=\"col-sm-6\">\n" . 
											"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
											"												<input type=\"checkbox\" id=\"" . $data[$i]['authorization'] . "\" name=\"" . $data[$i]['authorization'] . "\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval(isset($_POST[$data[$i]['authorization']]) ? $_POST[$data[$i]['authorization']] : 0) : (isset($role_rights[$data[$i]['id']]) && $role_rights[$data[$i]['id']]['enable'] == 1 ? 1 : 0)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
											"												<label class=\"custom-control-label\" for=\"" . $data[$i]['authorization'] . "\">\n" . 
											"													Zugriff erlauben\n" . 
											"												</label>\n" . 
											"											</div>\n" . 
											"										</div>\n" . 
											"									</div>\n";

			for($j = 0;$j < count($data);$j++){

				if($data[$j]['parent_id'] == $data[$i]['id'] && isset($company_rights[$data[$j]['id']]) && $company_rights[$data[$j]['id']]['enable'] == 1){

					$menu[$data[$i]['area_id']] .= 	"									<div class=\"form-group row\">\n" . 
													"										<div class=\"col-sm-1 mt-1 text-right\">\n" . 
													"											&nbsp;\n" . 
													"										</div>\n" . 
													"										<label class=\"col-sm-5 col-form-label\">" . $data[$j]['name'] . " <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle zugriff auf den Bereich haben soll.\">?</span></label>\n" . 
													"										<div class=\"col-sm-6\">\n" . 
													"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
													"												<input type=\"checkbox\" id=\"" . $data[$j]['authorization'] . "\" name=\"" . $data[$j]['authorization'] . "\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval(isset($_POST[$data[$j]['authorization']]) ? $_POST[$data[$j]['authorization']] : 0) : (isset($role_rights[$data[$j]['id']]) && $role_rights[$data[$j]['id']]['enable'] == 1 ? 1 : 0)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
													"												<label class=\"custom-control-label\" for=\"" . $data[$j]['authorization'] . "\">\n" . 
													"													Zugriff erlauben\n" . 
													"												</label>\n" . 
													"											</div>\n" . 
													"										</div>\n" . 
													"									</div>\n";


				}

			}

		}

	}

	$add_options = array();

	$add_options[0] = "";

	$add_options[1] = 	"									<div class=\"form-group row\">\n" . 
						"										<label for=\"func\" class=\"col-sm-6 col-form-label\">Funktion <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welche Funktion diese Rolle hat.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"func\" name=\"func\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['func']) : intval($row_role['func'])) == 0 ? " selected=\"selected\"" : "") . ">Keine</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['func']) : intval($row_role['func'])) == 1 ? " selected=\"selected\"" : "") . ">Verkäufer</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['func']) : intval($row_role['func'])) == 2 ? " selected=\"selected\"" : "") . ">Ersteller</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"form-group row\">\n" . 
						"										<label for=\"time_recording_login_src\" class=\"col-sm-6 col-form-label\">Zeiterfassung Login <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welchen Login zu der Zeiterfassung genutzt werden soll.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"searchresult_rights\" name=\"time_recording_login_src\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['time_recording_login_src']) : intval($row_role['time_recording_login_src'])) == 0 ? " selected=\"selected\"" : "") . ">Admin - Login</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['time_recording_login_src']) : intval($row_role['time_recording_login_src'])) == 1 ? " selected=\"selected\"" : "") . ">Single - Login</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['time_recording_login_src']) : intval($row_role['time_recording_login_src'])) == 2 ? " selected=\"selected\"" : "") . ">Multi - Login</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"form-group row\">\n" . 
						"										<label class=\"col-sm-6 col-form-label\">Mitarbeiter ändern <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Rolle Mitarbeiter ändern kann.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"												<input type=\"checkbox\" id=\"change_admin\" name=\"change_admin\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval(isset($_POST['change_admin']) ? $_POST['change_admin'] : 0) : $row_role['change_admin']) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch-access\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"change_admin\">\n" . 
						"													Zugriff erlauben\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"									</div>\n";

	$add_options[2] = "";

	$add_options[3] = "";

	$add_options[4] = "";

	$add_options[5] = "";

	$add_options[6] = "";

	$add_options[7] = "";

	$add_options[8] = "";

	$add_options[9] = "";

	$add_options[11] = 	"									<div class=\"form-group row\">\n" . 
						"										<label for=\"admin_index\" class=\"col-sm-6 col-form-label\">Admin-Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Admin-Index der Rolle ändern. (URL die nach dem Login aufgerufen werden soll.)\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<input type=\"text\" id=\"admin_index\" name=\"admin_index\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $admin_index : strip_tags($row_role["admin_index"])) . "\" class=\"form-control" . $inp_admin_index . "\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<label for=\"searchresult_rights\" class=\"col-sm-6 col-form-label\">Suchergebnisse, Berechtigung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an welche Suchergebnisse berechtigt sind.\">?</span></label>\n" . 
						"										<div class=\"col-sm-6\">\n" . 
						"											<select id=\"searchresult_rights\" name=\"searchresult_rights\" class=\"custom-select\">\n" . 
						"												<option value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['searchresult_rights']) : intval($row_role['searchresult_rights'])) == 0 ? " selected=\"selected\"" : "") . ">Nur eigene Datensätze</option>\n" . 
						"												<option value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['searchresult_rights']) : intval($row_role['searchresult_rights'])) == 1 ? " selected=\"selected\"" : "") . ">Eigene und Dummy Datensätze</option>\n" . 
						"												<option value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['searchresult_rights']) : intval($row_role['searchresult_rights'])) == 2 ? " selected=\"selected\"" : "") . ">Alle Datensätze</option>\n" . 
						"											</select>\n" . 
						"										</div>\n" . 
						"									</div>\n";

	$add_options[12] = "";

	$rights_categories_navi = "";

	$rights_categories_content = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights_categories` 
									ORDER BY 	CAST(`rights_categories`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$rights_categories_navi .= "								<a class=\"nav-link\" id=\"v-pills-" . $row['id'] . "-tab\" data-toggle=\"pill\" href=\"#v-pills-" . $row['id'] . "\" role=\"tab\" aria-controls=\"v-pills-" . $row['id'] . "\" aria-selected=\"false\">" . $row['name'] . "</a>\n";

		$rights_categories_content .= 	"								<div class=\"tab-pane fade\" id=\"v-pills-" . $row['id'] . "\" role=\"tabpanel\" aria-labelledby=\"v-pills-" . $row['id'] . "-tab\">\n" . 

										$add_options[$row['id']] . 

										(isset($menu[$row['id']]) ? $menu[$row['id']] : "") . 

										"								</div>\n";

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

				"					<div class=\"row mb-3\">\n" . 
				"						<div class=\"col-3 border-right\">\n" . 
				"							<div class=\"nav flex-column nav-pills\" id=\"v-pills-tab\" role=\"tablist\" aria-orientation=\"vertical\">\n" . 
				"								<a class=\"nav-link active\" id=\"v-pills-info-tab\" data-toggle=\"pill\" href=\"#v-pills-info\" role=\"tab\" aria-controls=\"v-pills-info\" aria-selected=\"true\">Information</a>\n" . 

				$rights_categories_navi . 

				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-9\">\n" . 
				"							<div class=\"tab-content\" id=\"v-pills-tabContent\">\n" . 
				"								<div class=\"tab-pane fade show active\" id=\"v-pills-info\" role=\"tabpanel\" aria-labelledby=\"v-pills-info-tab\">\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name der Rolle ändern.\">?</span></label>\n" . 
				"										<div class=\"col-sm-9\">\n" . 
				"											<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_role["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"edit_content\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Beschreibung der Rolle ändern.\">?</span></label>\n" . 
				"										<div class=\"col-sm-9\">\n" . 
				"											<textarea id=\"edit_content\" name=\"description\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_description . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $description : $row_role["description"]) . "</textarea>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 

				$rights_categories_content . 

				"							</div>\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>