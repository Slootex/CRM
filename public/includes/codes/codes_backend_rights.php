<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "rights";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_POST["category_id"])){$_SESSION["right_category"]["id"] = intval($_POST["category_id"]);}

$emsg = "";
$emsg_category = "";

$inp_name = "";
$inp_authorization = "";
$inp_processings = "";
$inp_output = "";
$inp_pos = "";

$name = "";
$authorization = "";
$processings = "";
$output = "";
$pos = 0;

$html_edit = "";

$time = time();

if(isset($_POST['add']) && $_POST['add'] == "category"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg_category .= "<span class=\"error\">Bitte einen Name für den Bereich eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['pos']) < 1 || strlen($_POST['pos']) > 11){
		$emsg_category .= "<span class=\"error\">Bitte eine Position für den Bereich eingeben. (max. 11 Zeichen)</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = strip_tags($_POST['pos']);
	}

	if($emsg_category == ""){

		mysqli_query($conn, "	INSERT 	`rights_categories` 
								SET 	`rights_categories`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`rights_categories`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "'");

		$_SESSION["right_category"]["id"] = $conn->insert_id;

		$emsg_category = "<p>Der Bereich wurde erfolgreich hinzugefügt!</p>\n";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "category"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg_category .= "<span class=\"error\">Bitte ein Name für den Bereich eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['pos']) < 1 || strlen($_POST['pos']) > 11){
		$emsg_category .= "<span class=\"error\">Bitte eine Postion für den Bereich eingeben.</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if($emsg_category == ""){

		mysqli_query($conn, "	UPDATE 	`rights_categories` 
								SET 	`rights_categories`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`rights_categories`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "' 
								WHERE 	`rights_categories`.`id`='" . intval($_POST['category_id']) . "'");

		$emsg_category = "<p>Der Bereich wurde erfolgreich geändert!</p>\n";

	}

}

if(isset($_POST['delete']) && $_POST['delete'] == "category"){

	mysqli_query($conn, "	DELETE FROM	`rights_categories` 
							WHERE 		`rights_categories`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`rights` 
							WHERE 		`rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "'");

	$_SESSION["right_category"]["id"] = 0;

	$emsg_category = "<p>Der Bereich wurde erfolgreich entfernt!</p>\n";

}

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Name für den Rechts eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['authorization']) < 1 || strlen($_POST['authorization']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Recht für Berechtigung des Rechts eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_authorization = " is-invalid";
	} else {
		$authorization = strip_tags($_POST['authorization']);
	}

	if(strlen($_POST['processings']) > 65536){
		$emsg .= "<span class=\"error\">Bitte die Verarbeitungen eingeben.</span><br />\n";
		$inp_processings = " is-invalid";
	} else {
		$processings = strip_tags($_POST['processings']);
	}

	if(strlen($_POST['output']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine HTML-Ausgabedatei eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_output = " is-invalid";
	} else {
		$output = strip_tags($_POST['output']);
	}

	if(strlen($_POST['pos']) < 1 || strlen($_POST['pos']) > 11){
		$emsg .= "<span class=\"error\">Bitte eine Postion des Rechts eingeben.</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`rights` 
								SET 	`rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "', 
										`rights`.`parent_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`rights`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`rights`.`authorization`='" . mysqli_real_escape_string($conn, $authorization) . "', 
										`rights`.`processings`='" . mysqli_real_escape_string($conn, $processings) . "', 
										`rights`.`output`='" . mysqli_real_escape_string($conn, $output) . "', 
										`rights`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "'");

		$_POST["id"] = $conn->insert_id;

		$emsg = "<p>Das Recht wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Name für das Recht eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['authorization']) < 1 || strlen($_POST['authorization']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Recht für Berechtigung des Rechts eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_authorization = " is-invalid";
	} else {
		$authorization = strip_tags($_POST['authorization']);
	}

	if(strlen($_POST['processings']) > 65536){
		$emsg .= "<span class=\"error\">Bitte die Verarbeitungen eingeben.</span><br />\n";
		$inp_processings = " is-invalid";
	} else {
		$processings = strip_tags($_POST['processings']);
	}

	if(strlen($_POST['output']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine HTML-Ausgabedatei eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_output = " is-invalid";
	} else {
		$output = strip_tags($_POST['output']);
	}

	if(strlen($_POST['pos']) < 1 || strlen($_POST['pos']) > 11){
		$emsg .= "<span class=\"error\">Bitte eine Postion des Rechts eingeben.</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`rights` 
								SET 	`rights`.`parent_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['parent_id']) ? $_POST['parent_id'] : 0)) . "', 
										`rights`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`rights`.`authorization`='" . mysqli_real_escape_string($conn, $authorization) . "', 
										`rights`.`processings`='" . mysqli_real_escape_string($conn, $processings) . "', 
										`rights`.`output`='" . mysqli_real_escape_string($conn, $output) . "', 
										`rights`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "' 
								WHERE 	`rights`.`id`='" . intval($_POST['id']) . "' 
								AND 	`rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "'");

		$emsg = "<p>Das Recht wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`rights` 
							WHERE 		`rights`.`id`='" . intval($_POST['id']) . "' 
							AND 		`rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`company_rights` 
							WHERE 		`company_rights`.`right_id`='" . intval($_POST['id']) . "'");

	mysqli_query($conn, "	DELETE FROM	`admin_role_rights` 
							WHERE 		`admin_role_rights`.`right_id`='" . intval($_POST['id']) . "'");

	$result_sub = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='" . intval($_POST['id']) . "' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row_sub = $result_sub->fetch_array(MYSQLI_ASSOC)){

		mysqli_query($conn, "	DELETE FROM	`rights` 
								WHERE 		`rights`.`id`='" . intval($row_sub['id']) . "' 
								AND 		`rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "'");

		mysqli_query($conn, "	DELETE FROM	`company_rights` 
								WHERE 		`company_rights`.`right_id`='" . intval($row_sub['id']) . "'");

		mysqli_query($conn, "	DELETE FROM	`admin_role_rights` 
								WHERE 		`admin_role_rights`.`right_id`='" . intval($row_sub['id']) . "'");

	}

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){
		$emsg .= "<span class=\"error\">Bitte eine rights.csv wählen.</span><br />\n";
	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 8){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`rights` 
													SET 	`rights`.`parent_id`='" . mysqli_real_escape_string($conn, intval($data[1])) . "', 
															`rights`.`area_id`='" . mysqli_real_escape_string($conn, (isset($_POST['area']) && intval($_POST['area']) > 0 ? intval($_POST['area']) : intval($data[2]))) . "', 
															`rights`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`rights`.`authorization`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`rights`.`processings`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`rights`.`output`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`rights`.`pos`='" . mysqli_real_escape_string($conn, intval($data[7])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`rights` 
													SET 	`rights`.`parent_id`='" . mysqli_real_escape_string($conn, intval($data[1])) . "', 
															`rights`.`area_id`='" . mysqli_real_escape_string($conn, (isset($_POST['area']) && intval($_POST['area']) > 0 ? intval($_POST['area']) : intval($data[2]))) . "', 
															`rights`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`rights`.`authorization`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`rights`.`processings`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`rights`.`output`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`rights`.`pos`='" . mysqli_real_escape_string($conn, intval($data[7])) . "' 
													WHERE 	`rights`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$list = "<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<tr>\n" . 
		"		<td class=\"text-center\"><strong>#</strong></td>\n" . 
		"		<td colspan=\"3\"><strong>Hauptebene</strong></td>\n" . 
		"		<td width=\"60\" class=\"text-center\">\n" . 
		"			<input type=\"hidden\" name=\"id\" value=\"0\" />\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"		</td>\n" . 
		"		<td width=\"60\">&nbsp;</td>\n" . 
		"	</tr>\n" . 
		"</form>\n";

if(isset($_SESSION["right_category"]["id"]) && intval($_SESSION["right_category"]["id"]) > 0){

	$result_parent = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='0' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

	while($row_parent = $result_parent->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr>\n" . 
					"		<td class=\"text-center\">" . $row_parent['id'] . "</td>\n" . 
					"		<td>&nbsp;</td>\n" . 
					"		<td colspan=\"2\" title=\"Position: " . $row_parent['pos'] . "\"><strong>" . $row_parent['name'] . "</strong></td>\n" . 
					"		<td width=\"60\" class=\"text-center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row_parent['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"		<td width=\"60\" class=\"text-center\">\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";
					

		$result_sub = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='" . $row_parent['id'] . "' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

		while($row_sub = $result_sub->fetch_array(MYSQLI_ASSOC)){

			$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
						"	<tr>\n" . 
						"		<td class=\"text-center\">" . $row_sub['id'] . "</td>\n" . 
						"		<td>&nbsp;</td>\n" . 
						"		<td class=\"text-center\"><span>-</span></td>\n" . 
						"		<td title=\"Position: " . $row_sub['pos'] . "\"><span>" . $row_sub['name'] . "</span></td>\n" . 
						"		<td width=\"60\">&nbsp;</td>\n" . 
						"		<td width=\"60\" class=\"text-center\">\n" . 
						"			<input type=\"hidden\" name=\"id\" value=\"" . $row_sub['id'] . "\" />\n" . 
						"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}

}

$result_menu = mysqli_query($conn, "SELECT * FROM `rights_categories` ORDER BY CAST(`rights_categories`.`pos` AS UNSIGNED) ASC");

$menu_options = "";

$row_rights_category = array();

while($m = $result_menu->fetch_array(MYSQLI_ASSOC)){

	$menu_options .= "				<option value=\"" . $m["id"] . "\"" . (isset($_SESSION["right_category"]["id"]) && $m["id"] == $_SESSION["right_category"]["id"] ? " selected=\"selected\"" : "") . ">" . $m['name'] . "</option>\n";

	if(isset($_SESSION["right_category"]["id"]) && $_SESSION["right_category"]["id"] == $m["id"]){
		$row_rights_category = $m;
	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Rechte</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Rechte verwalten.</p>\n" . 
		"<hr />\n" . 

		($emsg_category != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_category . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"<br />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"name\" class=\"col-sm-2 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Wählen Sie ein Bereich aus und klicken dann auf <u>bearbeiten</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-4\">\n" . 
		"			<select id=\"category_id\" name=\"category_id\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\">\n" . 

		$menu_options . 

		"			</select>\n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-6\">\n" . 
		"			<button type=\"submit\" name=\"open\" value=\"category\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"			<button type=\"submit\" name=\"delete\" value=\"category\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Bereich wircklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"name\" class=\"col-sm-2 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ein Bereich hinzufügen, füllen Sie dazu die Felder aus und klicken dann auf <u>hinzufügen</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-2\">\n" . 
		"			<input type=\"text\" id=\"name\" name=\"name\" value=\"\" placeholder=\"Name\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" /> \n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-1 text-right\">\n" . 
		"			Pos \n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-1\">\n" . 
		"			<input type=\"number\" id=\"pos\" name=\"pos\" value=\"0\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" />\n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-6\">\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"category\" class=\"btn btn-success\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$result = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='0' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

	$parent_options = "<option value=\"0\"" . (isset($_POST["id"]) && 0 == intval($_POST["id"]) ? " selected=\"selected\"" : "") . ">Hauptebene</option>\n";

	while($p = $result->fetch_array(MYSQLI_ASSOC)){

		$parent_options .= "<option value=\"" . $p['id'] . "\"" . (isset($_POST["id"]) && $p["id"] == intval($_POST["id"]) ? " selected=\"selected\"" : "") . ">- " . $p['name'] . "</option>\n";

	}

	$html_edit .= 	"<div class=\"row\">\n" . 
					"	<div class=\"col\">\n" . 
					"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
					"			<div class=\"card-header\">\n" . 
					"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
					"			</div>\n" . 
					"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

					($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

					"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"id\" class=\"col-sm-6 col-form-label\">Ebene <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie die Ebene aus unter dem der neue Link hinzugefügt werden soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<select id=\"id\" name=\"id\" class=\"custom-select\">" . $parent_options . "</select>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"name\" class=\"col-sm-6 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Links ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"authorization\" class=\"col-sm-6 col-form-label\">Recht 1 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie das Recht für die Berechtigung ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"authorization\" name=\"authorization\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $authorization : "") . "\" class=\"form-control" . $inp_authorization . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"processings\" class=\"col-sm-12 col-form-label\">Verarbeitungen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Verarbeitungen ein.<br /><br />function[metod:buttonname:buttonvalue]&&function[method:buttonname:buttonvalue]|file<br /><br /><u>method</u>:<br />post<br />get<br /><br /><u>function</u>:<br />isset[method:buttonname]<br />equal[method:buttonname:buttonvalue]<br />greater[method:buttonname:buttonvalue]<br />lessequal[method:buttonname:buttonvalue]<br />notisset[method:buttonname]<br />session[admin:roles:right:integervalue]\">?</span></label>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<div class=\"col-sm-12\">\n" . 
					"							<textarea id=\"processings\" name=\"processings\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_processings . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $processings : "") . "</textarea>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"output\" class=\"col-sm-6 col-form-label\">HTML-Ausgabedatei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die HTML-Ausgabedatei an.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"output\" name=\"output\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $output : "") . "\" class=\"form-control" . $inp_output . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"pos\" class=\"col-sm-6 col-form-label\">Position <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Position des Links ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $pos : 0) . "\" class=\"form-control" . $inp_pos . "\" />\n" . 
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

	$row_link = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	$result = mysqli_query($conn, "SELECT * FROM `rights` WHERE `rights`.`area_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["right_category"]["id"])) . "' AND `rights`.`parent_id`='0' ORDER BY CAST(`rights`.`pos` AS UNSIGNED) ASC");

	$parent_options = "<option value=\"0\"" . ($row_link['parent_id'] == 0 ? " selected=\"selected\"" : "") . ">Hauptebene</option>\n";

	if($row_link['parent_id'] > 0){

		while($p = $result->fetch_array(MYSQLI_ASSOC)){

			$parent_options .= "<option value=\"" . $p['id'] . "\"" . ($row_link['parent_id'] == $p["id"] ? " selected=\"selected\"" : "") . ">- " . $p['name'] . "</option>\n";

		}

	}

	$html_edit .= 	"<div class=\"row\">\n" . 
					"	<div class=\"col\">\n" . 
					"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
					"			<div class=\"card-header\">\n" . 
					"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
					"			</div>\n" . 
					"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

					($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

					"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"parent_id\" class=\"col-sm-6 col-form-label\">Ebene <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie die Ebene aus unter dem das Recht erscheinen soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<select id=\"parent_id\" name=\"parent_id\" class=\"custom-select\">" . $parent_options . "</select>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"name\" class=\"col-sm-6 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Rechts ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : $row_link["name"]) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"authorization\" class=\"col-sm-6 col-form-label\">Recht <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Berechtigung für das Recht ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"authorization\" name=\"authorization\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $authorization : $row_link["authorization"]) . "\" class=\"form-control" . $inp_authorization . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"processings\" class=\"col-sm-12 col-form-label\">Verarbeitungen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Verarbeitungen ein.<br /><br />function[metod:buttonname:buttonvalue]&&function[method:buttonname:buttonvalue]|file<br /><br /><u>method</u>:<br />post<br />get<br /><br /><u>function</u>:<br />isset[method:buttonname]<br />equal[method:buttonname:buttonvalue]<br />greater[method:buttonname:buttonvalue]<br />lessequal[method:buttonname:buttonvalue]<br />notisset[method:buttonname]<br />session[admin:roles:right:integervalue]\">?</span></label>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<div class=\"col-sm-12\">\n" . 
					"							<textarea id=\"processings\" name=\"processings\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_processings . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $processings : $row_link["processings"]) . "</textarea>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"output\" class=\"col-sm-6 col-form-label\">HTML-Ausgabedatei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die HTML-Ausgabedatei an.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"output\" name=\"output\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $output : $row_link["output"]) . "\" class=\"form-control" . $inp_output . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"pos\" class=\"col-sm-6 col-form-label\">Position <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Position des Rechts ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $pos : $row_link["pos"]) . "\" class=\"form-control" . $inp_pos . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"row px-0 card-footer\">\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"hidden\" name=\"id\" value=\"" . intval($row_link['id']) . "\" />\n" . 
					"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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

if(isset($_SESSION["right_category"]["id"]) && intval($_SESSION["right_category"]["id"]) > 0){

	$html .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<label for=\"name\" class=\"col-sm-2 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Wählen Sie ein Bereich aus und klicken dann auf <u>bearbeiten</u>.\">?</span></label>\n" . 
				"		<div class=\"col-sm-4\">\n" . 
				"			&nbsp;\n" . 
				"		</div>\n" . 
				"		<div class=\"col-sm-6\">\n" . 
				"			<a href=\"/crm/rechte-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<label class=\"col-sm-6 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie ein Bereich importieren.\">?</span></label>\n" . 
				"		<div class=\"col-sm-6\">\n" . 
				"			<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</form>\n";

}

if(!isset($_POST['data']) && isset($_SESSION["right_category"]["id"]) && intval($_SESSION["right_category"]["id"]) > 0){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col-sm-12\">\n" . 
				"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"name\" class=\"col-sm-2 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich ändern, füllen Sie dazu die Felder aus und klicken dann auf <u>speichern</u>.\">?</span></label>\n" . 
				"				<div class=\"col-sm-2\">\n" . 
				"					<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($row_rights_category['name']) ? $row_rights_category['name'] : "") . "\" placeholder=\"Name\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" /> \n" . 
				"				</div>\n" . 
				"				<div class=\"col-sm-1 text-right\">\n" . 
				"					Pos \n" . 
				"				</div>\n" . 
				"				<div class=\"col-sm-1\">\n" . 
				"					<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($row_rights_category['pos']) ? $row_rights_category['pos'] : 0) . "\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" />\n" . 
				"				</div>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"hidden\" name=\"category_id\" value=\"" . (isset($row_rights_category['id']) ? $row_rights_category['id'] : 0) . "\" />" . 
				"					<button type=\"submit\" name=\"update\" value=\"category\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</form>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col-sm-6\">\n" . 
				"		<div class=\"table-responsive\">\n" . 
				"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"					<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"						<strong>ID</strong>\n" . 
				"					</th>\n" . 
				"					<th colspan=\"3\" scope=\"col\">\n" . 
				"						<strong>Name</strong>\n" . 
				"					</th>\n" . 
				"					<th colspan=\"2\" width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"						<strong>Aktion</strong>\n" . 
				"					</th>\n" . 
				"				</tr></thead>\n" . 

				$list . 

				"			</table>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"	<div class=\"col-sm-6\">\n" . 

				$html_edit . 

				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['data'])){
	
	$options_area = "								<option value=\"0\">nicht ändern</option>\n";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`rights_categories` 
									ORDER BY 	CAST(`rights_categories`.`id` AS UNSIGNED) ASC");

	while($row_area = $result->fetch_array(MYSQLI_ASSOC)){

		$options_area .= "								<option value=\"" . $row_area['id'] . "\">" . $row_area['name'] . "</option>\n";

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
				"						<label for=\"area\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"area\" name=\"area\" class=\"custom-select\">\n" . 

				$options_area . 

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