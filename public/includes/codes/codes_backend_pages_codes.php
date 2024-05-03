<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "pages_codes";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

function format_bytes(int $size){

	$base = log($size, 1024);

	$suffixes = array('B', 'KB', 'MB', 'GB', 'TB');  

	return round(pow(1024, $base - floor($base)), 2) . ' ' . $suffixes[floor($base)];

}

function file_perms($file){

	$perms = fileperms($file);

	$info = "";

	// Besitzer
	$info .= "&nbsp;&nbsp;<i class='fa fa-lock text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;Besitzer: ";
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
				(($perms & 0x0800) ? 's' : 'x' ) : 
				(($perms & 0x0800) ? 'S' : '-'));

	// Gruppe
	$info .= "<br />&nbsp;&nbsp;<i class='fa fa-lock text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;Gruppe: ";
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
				(($perms & 0x0400) ? 's' : 'x' ) : 
				(($perms & 0x0400) ? 'S' : '-'));

	// Andere
	$info .= "<br />&nbsp;&nbsp;<i class='fa fa-lock text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;Andere: ";
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
				(($perms & 0x0200) ? 't' : 'x' ) : 
				(($perms & 0x0200) ? 'T' : '-'));

	return $info;

}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$pages_codes_session = "pages_codes_search";

if(isset($_POST["sorting_field"])){$_SESSION[$pages_codes_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$pages_codes_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$pages_codes_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$pages_codes_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$pages_codes_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`pages_codes`.`name`"
);
$sorting[] = array(
	"name" => "Bezeichnung", 
	"value" => "`pages_codes`.`description`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`pages_codes`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$pages_codes_session]["sorting_field"]) ? $sorting[$_SESSION[$pages_codes_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$pages_codes_session]["sorting_field"]) ? $_SESSION[$pages_codes_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$pages_codes_session]["sorting_direction"]) ? $directions[$_SESSION[$pages_codes_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$pages_codes_session]["sorting_direction"]) ? $_SESSION[$pages_codes_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$pages_codes_session]["rows"]) && $_SESSION[$pages_codes_session]["rows"] > 0 ? $_SESSION[$pages_codes_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_description = "";
$inp_code = "";

$name = "";
$description = "";
$code = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['code']) < 1 || strlen($_POST['code']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Code eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_code = " is-invalid";
	} else {
		$code = $_POST['code']; //html_entity_decode($_POST['code']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`pages_codes` 
								SET 	`pages_codes`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`pages_codes`.`description`='" . mysqli_real_escape_string($conn, $description) . "'");

		$_POST["id"] = $conn->insert_id;

		$f = fopen('includes/codes/' . $name . '.php', "w");
		fwrite($f, $code);
		fclose($f);

		$emsg = "<p>Der neue Seite-Code wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['code']) < 1 || strlen($_POST['code']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Code eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_code = " is-invalid";
	} else {
		$code = $_POST['code']; //html_entity_decode($_POST['code']);
	}

	if($emsg == ""){

		$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_codes` WHERE `pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE 	`pages_codes` 
								SET 	`pages_codes`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`pages_codes`.`description`='" . mysqli_real_escape_string($conn, $description) . "' 
								WHERE 	`pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		if($name != $row_item['name']){
			@unlink('includes/codes/' . $row_item['name'] . '.php');
		}

		$f = fopen('includes/codes/' . $name . '.php', "w");
		fwrite($f, $code);
		fclose($f);

		$emsg = "<p>Der Seiten-Code wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_codes` WHERE `pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`pages_codes` 
							WHERE 		`pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	@unlink('includes/codes/' . $row_item['name'] . '.php');

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine pages_codes.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 25){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`pages_codes` 
													SET 	`pages_codes`.`name`='" . mysqli_real_escape_string($conn, $data[1]) . "', 
															`pages_codes`.`description`='" . mysqli_real_escape_string($conn, $data[2]) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`pages_codes` 
													SET 	`pages_codes`.`name`='" . mysqli_real_escape_string($conn, $data[1]) . "', 
															`pages_codes`.`description`='" . mysqli_real_escape_string($conn, $data[2]) . "' 
													WHERE 	`pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$where = 	isset($_SESSION[$pages_codes_session]["keyword"]) && $_SESSION[$pages_codes_session]["keyword"] != "" ? 
			"WHERE 	(`pages_codes`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_codes_session]["keyword"]) . "%' 
			OR		`pages_codes`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_codes_session]["keyword"]) . "%') " : 
			"WHERE 	`pages_codes`.`id`>0";

$query = 	"	SELECT 		*, 
							(SELECT COUNT(*) AS used FROM `pages` WHERE `pages`.`code_id`=`pages_codes`.`id`) AS used 
				FROM 		`pages_codes` 
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
									$page['url'], 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

	$result_pages = mysqli_query($conn, "SELECT `pages`.`id` AS id, `pages`.`name` AS name FROM `pages` WHERE `pages`.`code_id`='" . mysqli_real_escape_string($conn, intval($row_item['id'])) . "' ORDER BY `pages`.`name` ASC");

	$used_title = "<b><u>Verwendet in den Seiten</u></b>:";

	while($row_page = $result_pages->fetch_array(MYSQLI_ASSOC)){

		$used_title .= "<br />&nbsp;&nbsp;<i class='fa fa-file-text-o text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;" . $row_page['name'];

	}

	$file_path = "includes/codes/" . $row_item['name'] . ".php";

	$file_a_time = "";

	$file_size = 0;

	$file_m_time = "";

	$file_perms = "";

	if(file_exists($file_path)){

		$file_a_time = date("d.m.Y (H:i:s)", fileatime($file_path));

		$file_size = format_bytes(filesize($file_path));

		$file_m_time = date("d.m.Y (H:i:s)", filemtime($file_path));

		$file_perms = file_perms($file_path);

	}

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row_item['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $file_a_time . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"<b><u>Datei</u></b>:<br />&nbsp;&nbsp;<i class='fa fa-file text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;/includes/codes/" . $row_item['name'] . ".php<br /><br /><b><u>Zugriffsrechte</u></b>:<br />" . $file_perms . "\" title=\"\">\n" . 
				"			<span>" . $row_item['description'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"" . $used_title . "\" title=\"\">\n" . 
				"			<span>" . $row_item['used'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-right\">\n" . 
				"			<span>" . $file_size . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\"" . ($file_a_time != $file_m_time ? " class=\"text-success\"" : "") . ">\n" . 
				"			<span>" . $file_m_time . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Seiten-Codes</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$pages_codes_session]['keyword']) && $_SESSION[$pages_codes_session]['keyword'] != "" ? $_SESSION[$pages_codes_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Seiten-Codes bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/seiten-codes-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

$html .= 	"<hr />\n" . 

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
			"			<th width=\"180\" scope=\"col\">\n" . 
			"				<strong>Erstellt</strong>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Bezeichnung</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>verwendet</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Größe</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"180\" scope=\"col\">\n" . 
			"				<strong>Änderung</strong>\n" . 
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

			((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") || (isset($_POST['data']) && $_POST['data'] == "importieren") ? "" : "<br />\n<br />\n<br />\n");

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

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
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name (Datei) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name (Datei) des Seiten-Codes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Bezeichnung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Bezeichnung des Seiten-Codes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"description\" name=\"description\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $description : "") . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"code\" class=\"col-sm-3 col-form-label\">Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Code des Seiten-Codes ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"code\" name=\"code\" class=\"" . $inp_code . "\" style=\"width: 100%;height: 600px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($code) : "") . "</textarea>\n" . 
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

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_codes` WHERE `pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$old_code = implode("", file("includes/codes/" . $row_item['name'] . ".php"));

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
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name (Datei) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name (Datei) dieses Seiten-Codes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_item["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Bezeichnung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bezeichnung dieses Seiten-Codes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"description\" name=\"description\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $description : $row_item["description"]) . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"code\" class=\"col-sm-3 col-form-label\">Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Code dieses Seiten-Codes ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"code\" name=\"code\" class=\"" . $inp_code . "\" style=\"width: 100%;height: 600px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($code) : htmlentities($old_code)) . "</textarea>\n" . 
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

if(isset($_POST['data']) && $_POST['data'] == "importieren"){

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