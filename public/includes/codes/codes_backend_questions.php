<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "questions";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_POST["category_id"])){$_SESSION["questions_category"]["id"] = intval($_POST["category_id"]);}

$emsg = "";

$inp_name = "";
$inp_title = "";
$inp_imagepath = "";
$inp_hash = "";
$inp_pos = "";
$inp_enable = "";

$name = "";
$title = "";
$imagepath = "";
$hash = "";
$pos = 0;
$enable = 0;

$html_edit = "";

$time = time();

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Name für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = $_POST['name'];
	}

	if(strlen($_POST['title']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Title für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = $_POST['title'];
	}

	if(strlen($_POST['imagepath']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Bildpfad für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_imagepath = " is-invalid";
	} else {
		$imagepath = strip_tags($_POST['imagepath']);
	}

	if(strlen($_POST['hash']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Title für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_hash = " is-invalid";
	} else {
		$hash = strip_tags($_POST['hash']);
	}

	if(strlen($_POST['pos']) < 1){
		$emsg .= "<span class=\"error\">Bitte eine Postion des Eintrags eingeben.</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if(isset($_POST['enable']) && strlen($_POST['enable']) < 1){
		$emsg .= "<span class=\"error\">Bitte wählen Sie ob der Eintrag aktiviert sein soll.</span><br />\n";
		$inp_enable= " is-invalid";
	} else {
		$enable = (isset($_POST['enable']) ? intval($_POST['enable']) : 0);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`questions` 
								SET 	`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "', 
										`questions`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`questions`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`questions`.`imagepath`='" . mysqli_real_escape_string($conn, $imagepath) . "', 
										`questions`.`hash`='" . mysqli_real_escape_string($conn, $hash) . "', 
										`questions`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "', 
										`questions`.`enable`='" . mysqli_real_escape_string($conn, $enable) . "'");

		$_POST["id"] = $conn->insert_id;

		$emsg = "<p>Der Eintrag wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Name für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = $_POST['name'];
	}

	if(strlen($_POST['title']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Title für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = $_POST['title'];
	}

	if(strlen($_POST['imagepath']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Bildpfad für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_imagepath = " is-invalid";
	} else {
		$imagepath = strip_tags($_POST['imagepath']);
	}

	if(strlen($_POST['hash']) > 256){
		$emsg .= "<span class=\"error\">Bitte ein Hash für den Eintrag eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_hash = " is-invalid";
	} else {
		$hash = strip_tags($_POST['hash']);
	}

	if(strlen($_POST['pos']) < 1){
		$emsg .= "<span class=\"error\">Bitte eine Postion des Eintrags eingeben.</span><br />\n";
		$inp_pos = " is-invalid";
	} else {
		$pos = intval($_POST['pos']);
	}

	if(isset($_POST['enable']) && strlen($_POST['enable']) < 1){
		$emsg .= "<span class=\"error\">Bitte wählen Sie ob der Eintrag aktiviert sein soll.</span><br />\n";
		$inp_enable= " is-invalid";
	} else {
		$enable = (isset($_POST['enable']) ? intval($_POST['enable']) : 0);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`questions` 
								SET 	`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['parent_id']) ? $_POST['parent_id'] : 0)) . "', 
										`questions`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`questions`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`questions`.`imagepath`='" . mysqli_real_escape_string($conn, $imagepath) . "', 
										`questions`.`hash`='" . mysqli_real_escape_string($conn, $hash) . "', 
										`questions`.`pos`='" . mysqli_real_escape_string($conn, $pos) . "', 
										`questions`.`enable`='" . mysqli_real_escape_string($conn, $enable) . "' 
								WHERE 	`questions`.`id`='" . intval($_POST['id']) . "' 
								AND 	`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 	`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "'");

		$emsg = "<p>Der Eintrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`questions` 
							WHERE 		`questions`.`id`='" . intval($_POST['id']) . "' 
							AND 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
							AND 		`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`questions` 
							WHERE 		`questions`.`parent_id`='" . intval($_POST['id']) . "' 
							AND 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
							AND 		`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "'");

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine questions.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 10){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`questions` 
													SET 	`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($data[3])) . "', 
															`questions`.`name`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`questions`.`title`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`questions`.`imagepath`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`questions`.`hash`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`questions`.`pos`='" . mysqli_real_escape_string($conn, intval($data[8])) . "', 
															`questions`.`enable`='" . mysqli_real_escape_string($conn, intval($data[9])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`questions` 
													SET 	`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($data[3])) . "', 
															`questions`.`name`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`questions`.`title`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`questions`.`imagepath`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`questions`.`hash`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`questions`.`pos`='" . mysqli_real_escape_string($conn, intval($data[8])) . "', 
															`questions`.`enable`='" . mysqli_real_escape_string($conn, intval($data[9])) . "' 
													WHERE 	`questions`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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
		"		<td colspan=\"3\"><strong>Fragen</strong></td>\n" . 
		"		<td width=\"60\" class=\"text-center\">\n" . 
		"			<input type=\"hidden\" name=\"id\" value=\"0\" />\n" . 
		"			<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"		</td>\n" . 
		"		<td width=\"60\">&nbsp;</td>\n" . 
		"	</tr>\n" . 
		"</form>\n";

if(isset($_SESSION["questions_category"]["id"]) && intval($_SESSION["questions_category"]["id"]) > 0){

	$result_parent = mysqli_query($conn, "SELECT * FROM `questions` WHERE `questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' AND `questions`.`parent_id`='0' ORDER BY CAST(`questions`.`pos` AS UNSIGNED) ASC");

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
					

		$result_sub = mysqli_query($conn, "SELECT * FROM `questions` WHERE `questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' AND `questions`.`parent_id`='" . $row_parent['id'] . "' ORDER BY CAST(`questions`.`pos` AS UNSIGNED) ASC");

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

$result_menu = mysqli_query($conn, "SELECT * FROM `questions_category` ORDER BY CAST(`questions_category`.`id` AS UNSIGNED) ASC");

$menu_options = "";

while($m = $result_menu->fetch_array(MYSQLI_ASSOC)){

	$menu_options .= "				<option value=\"" . $m["id"] . "\"" . (isset($_SESSION["questions_category"]["id"]) && $m["id"] == $_SESSION["questions_category"]["id"] ? " selected=\"selected\"" : "") . ">" . $m['name'] . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Fragen</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Fragen verwalten.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<label for=\"category_id\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Wählen Sie ein Bereich aus und klicken dann auf <u>bearbeiten</u>.\">?</span></label>\n" . 
		"		<div class=\"col-sm-3\">\n" . 
		"			<select id=\"category_id\" name=\"category_id\" class=\"custom-select bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\">\n" . 

		$menu_options . 

		"			</select>\n" . 
		"		</div>\n" . 
		"		<div class=\"col-sm-6\">\n" . 
		"			<button type=\"submit\" name=\"open\" value=\"category\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$result = mysqli_query($conn, "SELECT * FROM `questions` WHERE `questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' AND `questions`.`parent_id`='0' ORDER BY CAST(`questions`.`pos` AS UNSIGNED) ASC");

	$parent_options = "<option value=\"0\"" . (isset($_POST["id"]) && 0 == intval($_POST["id"]) ? " selected=\"selected\"" : "") . ">Als Frage</option>\n";

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
					"						<label for=\"id\" class=\"col-sm-6 col-form-label\">Ebene <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie die Ebene aus unter dem der neue Eintrags hinzugefügt werden soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<select id=\"id\" name=\"id\" class=\"custom-select\">" . $parent_options . "</select>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"name\" class=\"col-sm-6 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"title\" class=\"col-sm-6 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Title des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $title : "") . "\" class=\"form-control" . $inp_title . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"imagepath\" class=\"col-sm-6 col-form-label\">Bildpfad <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Bildpfad des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"imagepath\" name=\"imagepath\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $imagepath : "") . "\" class=\"form-control" . $inp_imagepath . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"hash\" class=\"col-sm-6 col-form-label\">Hash <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Hash des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"hash\" name=\"hash\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $hash : "") . "\" class=\"form-control" . $inp_hash . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"pos\" class=\"col-sm-6 col-form-label\">Position <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Position des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $pos : 0) . "\" class=\"form-control" . $inp_pos . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"enable\" class=\"col-sm-6 col-form-label\">Aktivieren <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob der Link aktiviert sein soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
					"								<input type=\"checkbox\" id=\"enable\" name=\"enable\" value=\"1\"" . ($enable == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
					"								<label class=\"custom-control-label\" for=\"enable\">\n" . 
					"									Ja\n" . 
					"								</label>\n" . 
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
					"<br /><br /><br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_link = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `questions` WHERE `questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' AND `questions`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	$result = mysqli_query($conn, "SELECT * FROM `questions` WHERE `questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `questions`.`category_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["questions_category"]["id"])) . "' AND `questions`.`parent_id`='0' AND `questions`.`parent_id`='0' ORDER BY CAST(`questions`.`pos` AS UNSIGNED) ASC");

	$parent_options = "<option value=\"0\"" . ($row_link['parent_id'] == 0 ? " selected=\"selected\"" : "") . ">Als Frage</option>\n";

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
					"						<label for=\"parent_id\" class=\"col-sm-6 col-form-label\">Ebene <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie die Ebene aus unter dem der Eintrags erscheinen soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<select id=\"parent_id\" name=\"parent_id\" class=\"custom-select\">" . $parent_options . "</select>\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"name\" class=\"col-sm-6 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : $row_link["name"]) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"title\" class=\"col-sm-6 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Title des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $title : $row_link["title"]) . "\" class=\"form-control" . $inp_title . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"imagepath\" class=\"col-sm-6 col-form-label\">Bildpfad <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Title des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"imagepath\" name=\"imagepath\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $imagepath : $row_link["imagepath"]) . "\" class=\"form-control" . $inp_imagepath . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"hash\" class=\"col-sm-6 col-form-label\">Hash <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Hash des Eintrags ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"text\" id=\"hash\" name=\"hash\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $hash : $row_link["hash"]) . "\" class=\"form-control" . $inp_hash . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"pos\" class=\"col-sm-6 col-form-label\">Position <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Position des Links ein.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $pos : $row_link["pos"]) . "\" class=\"form-control" . $inp_pos . "\" />\n" . 
					"						</div>\n" . 
					"					</div>\n" . 
					"					<div class=\"form-group row\">\n" . 
					"						<label for=\"enable\" class=\"col-sm-6 col-form-label\">Aktivieren <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie ob der Link aktiviert sein soll.\">?</span></label>\n" . 
					"						<div class=\"col-sm-6\">\n" . 
					"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
					"								<input type=\"checkbox\" id=\"enable\" name=\"enable\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['enable'] : intval($row_link['enable'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
					"								<label class=\"custom-control-label\" for=\"enable\">\n" . 
					"									Ja\n" . 
					"								</label>\n" . 
					"							</div>\n" . 
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

if(isset($_SESSION["questions_category"]["id"]) && intval($_SESSION["questions_category"]["id"]) > 0){

	$html .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<label class=\"col-sm-3 col-form-label\">Fragen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Fragen herunterladen. Klicken Sie dafür auf <u>herunterladen</u>.\">?</span></label>\n" . 
				"		<div class=\"col-sm-3\">\n" . 
				"			&nbsp;\n" . 
				"		</div>\n" . 
				"		<div class=\"col-sm-6\">\n" . 
				"			<a href=\"/crm/fragen-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<label class=\"col-sm-6 col-form-label\">Fragen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Fragen importieren.\">?</span></label>\n" . 
				"		<div class=\"col-sm-6\">\n" . 
				"			<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</form>\n";

}

if(!isset($_POST['data']) && isset($_SESSION["questions_category"]["id"]) && intval($_SESSION["questions_category"]["id"]) > 0){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col-sm-6\">\n" . 
				"		<div class=\"table-responsive\">\n" . 
				"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"					<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"						<strong>ID</strong>\n" . 
				"					</th>\n" . 
				"					<th colspan=\"3\" scope=\"col\">\n" . 
				"						<strong>Fragen/Antworten</strong>\n" . 
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