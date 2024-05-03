<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "attachments_matrix";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$attachments_matrix_session = "attachments_matrix_search";

if(isset($_POST["sorting_field"])){$_SESSION[$attachments_matrix_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$attachments_matrix_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$attachments_matrix_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$attachments_matrix_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$attachments_matrix_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Gerät", 
	"value" => "component_name"
);
$sorting[] = array(
	"name" => "Ergebnis", 
	"value" => "text_module_name"
);
$sorting[] = array(
	"name" => "Datei-1", 
	"value" => "file1_name"
);
$sorting[] = array(
	"name" => "Datei-2", 
	"value" => "file2_name"
);
$sorting[] = array(
	"name" => "Pos", 
	"value" => "`attachments_matrix`.`pos`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`attachments_matrix`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$attachments_matrix_session]["sorting_field"]) ? $sorting[$_SESSION[$attachments_matrix_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$attachments_matrix_session]["sorting_field"]) ? $_SESSION[$attachments_matrix_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$attachments_matrix_session]["sorting_direction"]) ? $directions[$_SESSION[$attachments_matrix_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$attachments_matrix_session]["sorting_direction"]) ? $_SESSION[$attachments_matrix_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$attachments_matrix_session]["rows"]) && $_SESSION[$attachments_matrix_session]["rows"] > 0 ? $_SESSION[$attachments_matrix_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`attachments_matrix` 
								SET 	`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($_POST['component'])) . "', 
										`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($_POST['text_module'])) . "', 
										`attachments_matrix`.`file1`='" . mysqli_real_escape_string($conn, intval($_POST['file1'])) . "', 
										`attachments_matrix`.`file2`='" . mysqli_real_escape_string($conn, intval($_POST['file2'])) . "', 
										`attachments_matrix`.`pos`='" . mysqli_real_escape_string($conn, intval($_POST['pos'])) . "'");

		$_POST["id"] = $conn->insert_id;

		$_POST['edit'] = "bearbeiten";

		$emsg = "<p>Die neue Bedingung wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`attachments_matrix` 
								SET 	`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($_POST['component'])) . "', 
										`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($_POST['text_module'])) . "', 
										`attachments_matrix`.`file1`='" . mysqli_real_escape_string($conn, intval($_POST['file1'])) . "', 
										`attachments_matrix`.`file2`='" . mysqli_real_escape_string($conn, intval($_POST['file2'])) . "',  
										`attachments_matrix`.`pos`='" . mysqli_real_escape_string($conn, intval($_POST['pos'])) . "'  
								WHERE 	`attachments_matrix`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Die Bedingung wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`attachments_matrix` 
							WHERE 		`attachments_matrix`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine file_attachments.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 7){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`attachments_matrix` 
													SET 	`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($data[3])) . "', 
															`attachments_matrix`.`file1`='" . mysqli_real_escape_string($conn, intval($data[4])) . "', 
															`attachments_matrix`.`file2`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`attachments_matrix`.`pos`='" . mysqli_real_escape_string($conn, intval($data[6])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`attachments_matrix` 
													SET 	`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($data[3])) . "', 
															`attachments_matrix`.`file1`='" . mysqli_real_escape_string($conn, intval($data[4])) . "', 
															`attachments_matrix`.`file2`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`attachments_matrix`.`pos`='" . mysqli_real_escape_string($conn, intval($data[3])) . "' 
													WHERE 	`attachments_matrix`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$where = 	isset($_SESSION[$attachments_matrix_session]["keyword"]) && $_SESSION[$attachments_matrix_session]["keyword"] != "" ? 
			"WHERE 	((SELECT `reasons`.`name` AS name FROM `reasons` WHERE `reasons`.`company_id`='1' AND `reasons`.`id`=`attachments_matrix`.`component`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%' 
			OR		(SELECT `text_modules`.`name` AS name FROM `text_modules` WHERE `text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `text_modules`.`id`=`attachments_matrix`.`text_module`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%'
			OR		(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%'
			OR		(SELECT `file_attachments`.`file` AS file1 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%'
			OR		(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%'
			OR		(SELECT `file_attachments`.`file` AS file2 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$attachments_matrix_session]["keyword"]) . "%') " : 
			"WHERE 	`attachments_matrix`.`id`>0";

$query = "	SELECT 		`attachments_matrix`.`id` AS id, 
						`attachments_matrix`.`pos` AS pos, 
						(SELECT `reasons`.`name` AS name FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`=`attachments_matrix`.`component`) AS component_name, 
						(SELECT `text_modules`.`name` AS name FROM `text_modules` WHERE `text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `text_modules`.`id`=`attachments_matrix`.`text_module`) AS text_module_name, 
						(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) AS file1_name, 
						(SELECT `file_attachments`.`file` AS file1 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) AS file1_file, 
						(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) AS file2_name, 
						(SELECT `file_attachments`.`file` AS file2 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) AS file2_file 
			FROM 		`attachments_matrix` 
			" . $where . " 
			AND 		`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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
				"	<tr" . (isset($_POST['id']) && intval($_POST['id']) == $row['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $row['component_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $row['text_module_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row['file1_file'] . "\" target=\"_blank\"" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"text-white\"" : "") . ">" . $row['file1_name'] . " <i class=\"fa fa-external-link\"> </i></a>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row['file2_file'] . "\" target=\"_blank\"" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"text-white\"" : "") . ">" . $row['file2_name'] . " <i class=\"fa fa-external-link\"> </i></a>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row['pos'] . "</span>\n" . 
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
		"		<h3>Einstellungen - Anhängematrix</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$attachments_matrix_session]['keyword']) && $_SESSION[$attachments_matrix_session]['keyword'] != "" ? $_SESSION[$attachments_matrix_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Anhängematrix bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/anhaengematrix-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(!isset($_POST['data'])){

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
				"							<a href=\"#\" onclick=\"orderSearchDirection(5, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(5, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"320\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Gerät</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Ergebnis</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(2, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(2, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Datei-1</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(3, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(3, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Datei-2</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Pos</strong></div>\n" . 
				"				</div>\n" . 
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

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['component']) && intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

	}

	$options_text_module = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_modules` 
									WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_modules`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_text_module .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['text_module']) && intval($_POST['text_module']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

	}

	$options_file1 = "";

	$options_file2 = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file1 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['file1']) && intval($_POST['file1']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

		$options_file2 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['file2']) && intval($_POST['file2']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

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
				"						<label for=\"component\" class=\"col-sm-3 col-form-label\">Steuergerät</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"component\" name=\"component\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"text_module\" class=\"col-sm-3 col-form-label\">Ergebnis</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"text_module\" name=\"text_module\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_text_module . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file1\" class=\"col-sm-3 col-form-label\">Datei-1</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"file1\" name=\"file1\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_file1 . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file2\" class=\"col-sm-3 col-form-label\">Datei-2</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"file2\" name=\"file2\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_file2 . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-3 col-form-label\">Reihenfolge</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['pos']) ? intval($_POST['pos']) : 0) : 0) . "\" class=\"form-control\" />\n" . 
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

	$row_attachments_matrix = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `attachments_matrix` WHERE `attachments_matrix`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_attachments_matrix["component"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$options_text_module = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_modules` 
									WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_modules`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_text_module .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['text_module']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_attachments_matrix["text_module"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$options_file1 = "";

	$options_file2 = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file1 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['file1']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_attachments_matrix["file1"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

		$options_file2 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['file2']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_attachments_matrix["file2"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

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
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"component\" class=\"col-sm-3 col-form-label\">Steuergerät</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"component\" name=\"component\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"text_module\" class=\"col-sm-3 col-form-label\">Ergebnis</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"text_module\" name=\"text_module\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_text_module . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file1\" class=\"col-sm-3 col-form-label\">Datei-1</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"file1\" name=\"file1\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_file1 . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file2\" class=\"col-sm-3 col-form-label\">Datei-2</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"file2\" name=\"file2\" class=\"custom-select\">\n" . 
				"								<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_file2 . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-3 col-form-label\">Reihenfolge</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['pos']) ? intval($_POST['pos']) : 0) : $row_attachments_matrix["pos"]) . "\" class=\"form-control\" />\n" . 
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