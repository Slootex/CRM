<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "systemdata";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$emsg = "";
$emsg_folder = "";

$inp_unlogin_index = "";
$inp_unuser_index = "";
$inp_none_file_accept = "";

$inp_style_frontend = "";
$inp_script_frontend = "";

$inp_folders_name = "";
$inp_folders_description = "";
$inp_folders_folder = "";
$inp_folders_htaccess = "";
$inp_folders_enable_uploads = "";

$unlogin_index = "";
$unuser_index = "";
$none_file_accept = "";

$style_frontend = "";
$script_frontend = "";

$folders_name = "";
$folders_description = "";
$folders_folder = "";
$htaccess = "";
$folders_enable_uploads = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['unlogin_index']) < 1 || strlen($_POST['unlogin_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Zielort, weiterleiten wenn Benutzer unangemeldet ist, eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_unlogin_index = " is-invalid";
	} else {
		$unlogin_index = strip_tags($_POST['unlogin_index']);
	}

	if(strlen($_POST['unuser_index']) < 1 || strlen($_POST['unuser_index']) > 256){
		$emsg .= "<span class=\"error\">Bitte den Zielort, weiterleiten wenn Kunde unangemeldet ist, eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_unuser_index = " is-invalid";
	} else {
		$unuser_index = strip_tags($_POST['unuser_index']);
	}

	if(strlen($_POST['none_file_accept']) > 1024){
		$emsg .= "<span class=\"error\">Bitte die unerlaubten Dateiendungen eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_none_file_accept = " is-invalid";
	} else {
		$none_file_accept = strip_tags($_POST['none_file_accept']);
	}

	if(strlen($_POST['style_frontend']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Frontend-Style eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style_frontend = " is-invalid";
	} else {
		$style_frontend = html_entity_decode($_POST['style_frontend']);
	}

	if(strlen($_POST['script_frontend']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Frontend-JavaScript eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_script_frontend = " is-invalid";
	} else {
		$script_frontend = html_entity_decode($_POST['script_frontend']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`systemdata` 
								SET 	`systemdata`.`unlogin_index`='" . mysqli_real_escape_string($conn, $unlogin_index) . "', 
										`systemdata`.`unuser_index`='" . mysqli_real_escape_string($conn, $unuser_index) . "', 
										`systemdata`.`none_file_accept`='" . mysqli_real_escape_string($conn, $none_file_accept) . "', 
										`systemdata`.`style_frontend`='" . mysqli_real_escape_string($conn, $style_frontend) . "', 
										`systemdata`.`script_frontend`='" . mysqli_real_escape_string($conn, $script_frontend) . "' 
								WHERE 	`systemdata`.`id`='1'");

		$emsg = "<p>Die Systemdaten wurden erfolgreich geändert!</p>\n";

	}

}

if(isset($_POST['save_folder']) && $_POST['save_folder'] == "speichern"){

	if(strlen($_POST['folders_name']) < 1 || strlen($_POST['folders_name']) > 128){
		$emsg_folder .= "<span class=\"error\">Bitte ein Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_folders_name = " is-invalid";
	} else {
		$folders_name = strip_tags($_POST['folders_name']);
	}

	if(strlen($_POST['folders_description']) < 1 || strlen($_POST['folders_description']) > 256){
		$emsg_folder .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_folders_description = " is-invalid";
	} else {
		$folders_description = strip_tags($_POST['folders_description']);
	}

	if(strlen($_POST['folders_folder']) < 1 || strlen($_POST['folders_folder']) > 128){
		$emsg_folder .= "<span class=\"error\">Bitte ein Verzeichnis eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_folders_folder = " is-invalid";
	} else {
		$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `folders` WHERE `folders`.`folder`='" . mysqli_real_escape_string($conn, strip_tags($_POST['folders_folder'])) . "'"), MYSQLI_ASSOC);
		if(isset($row['id']) && $row['id'] > 0){
			$emsg_folder .= "<span class=\"error\">Das Verzeichnis existiert bereits.</span><br />\n";
		}else{
			$folders_folder = filterFilename($_POST['folders_folder']);
		}
	}

	if($emsg_folder == ""){

		$result = mysqli_query($conn, "	SELECT 	`companies`.`id` AS id 
										FROM 	`companies`");
		
		while($row_companies = $result->fetch_array(MYSQLI_ASSOC)){
		
			mkdir("uploads/company/" . intval($row_companies["id"]) . "/" . $folders_folder, 0777);
		

			if(isset($_POST['folders_htaccess']) && intval($_POST['folders_htaccess']) == 1){
				
				copy("includes/.htaccess", "uploads/company/" . intval($row_companies["id"]) . "/" . $folders_folder . "/.htaccess");

			}

		}

		mysqli_query($conn, "	INSERT 	`folders` 
								SET 	`folders`.`name`='" . mysqli_real_escape_string($conn, $folders_name) . "', 
										`folders`.`description`='" . mysqli_real_escape_string($conn, $folders_description) . "', 
										`folders`.`folder`='" . mysqli_real_escape_string($conn, $folders_folder) . "', 
										`folders`.`htaccess`='" . mysqli_real_escape_string($conn, intval(isset($_POST['folders_htaccess']) && intval($_POST['folders_htaccess']) == 1 ? $_POST['folders_htaccess'] : 0)) . "', 
										`folders`.`erasable`='1', 
										`folders`.`enable_uploads`='" . mysqli_real_escape_string($conn, intval(isset($_POST['folders_enable_uploads']) && intval($_POST['folders_enable_uploads']) == 1 ? $_POST['folders_enable_uploads'] : 0)) . "'");

		$_POST["folder_id"] = $conn->insert_id;

		$_POST['edit_folder'] = "bearbeiten";

		$emsg_folder = "<p>Das neue Verzeichnis wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add_folder"] = "hinzufügen";

	}

}

if(isset($_POST['update_folder']) && $_POST['update_folder'] == "speichern"){

	if(strlen($_POST['folders_name']) < 1 || strlen($_POST['folders_name']) > 128){
		$emsg_folder .= "<span class=\"error\">Bitte ein Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_folders_name = " is-invalid";
	} else {
		$folders_name = strip_tags($_POST['folders_name']);
	}

	if(strlen($_POST['folders_description']) < 1 || strlen($_POST['folders_description']) > 256){
		$emsg_folder .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_folders_description = " is-invalid";
	} else {
		$folders_description = strip_tags($_POST['folders_description']);
	}

	if($emsg_folder == ""){

		mysqli_query($conn, "	UPDATE 	`folders` 
								SET 	`folders`.`name`='" . mysqli_real_escape_string($conn, $folders_name) . "', 
										`folders`.`description`='" . mysqli_real_escape_string($conn, $folders_description) . "', 
										`folders`.`enable_uploads`='" . mysqli_real_escape_string($conn, intval(isset($_POST['folders_enable_uploads']) ? $_POST['folders_enable_uploads'] : 0)) . "' 
								WHERE 	`folders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['folder_id'])) . "'");

		$emsg_folder = "<p>Das Verzeichnis wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit_folder'] = "bearbeiten";

}

if(isset($_POST['delete_folder']) && $_POST['delete_folder'] == "entfernen"){

	$row_folder = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `folders` WHERE `folders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['folder_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_folder['id']) && $row_folder['erasable'] == 1){

		$result = mysqli_query($conn, "	SELECT 		`companies`.`id` AS id 
										FROM 		`companies`");
		
		while($row_companies = $result->fetch_array(MYSQLI_ASSOC)){
		
			array_map('unlink', array_filter((array) glob("uploads/company/" . intval($row_companies['id']) . "/" . $row_folder['folder'] . "/*.*")));
		
			@unlink("uploads/company/" . intval($row_companies['id']) . "/" . $row_folder['folder'] . "/.htaccess");

			@rmdir("uploads/company/" . intval($row_companies['id']) . "/" . $row_folder['folder']);

		}

		mysqli_query($conn, "	DELETE FROM	`folders` 
								WHERE 		`folders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['folder_id'])) . "'");

		$emsg = "<p>Das Verzeichnis wurde erfolgreich entfernt!</p>\n";

	}else{

		$emsg = "<p>Das Verzeichnis kann nicht entfernt werden!</p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row_systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$options_pages_unlogin_index = "";

$options_pages_unuser_index = "";

$result_pages = mysqli_query($conn, "	SELECT 		* 
										FROM 		`pages` 
										ORDER BY 	`pages`.`name` ASC");

while($row = $result_pages->fetch_array(MYSQLI_ASSOC)){

	$options_pages_unlogin_index .= "								<option value=\"" . $row['url'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (strip_tags($_POST['unlogin_index']) == $row['url'] ? " selected=\"selected\"" : "") : (strip_tags($row_systemdata['unlogin_index']) == $row['url'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	$options_pages_unuser_index .= "								<option value=\"" . $row['url'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (strip_tags($_POST['unuser_index']) == $row['url'] ? " selected=\"selected\"" : "") : (strip_tags($row_systemdata['unuser_index']) == $row['url'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

}

$list_folders = "";

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`folders` 
								ORDER BY 	`folders`.`name` ASC");

while($row_folders = $result->fetch_array(MYSQLI_ASSOC)){

	$list_folders .= 	"		<tr" . (isset($_POST['folder_id']) && $_POST['folder_id'] == $row_folders['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
						"			<td>" . $row_folders['name'] . "</td>\n" . 
						"			<td>" . $row_folders['description'] . "</td>\n" . 
						"			<td>" . $row_folders['folder'] . "</td>\n" . 
						"			<td align=\"center\">" . ($row_folders['htaccess'] == 1 ? "Ja" : "Nein") . "</td>\n" . 
						"			<td align=\"center\">" . ($row_folders['erasable'] == 1 ? "Ja" : "Nein") . "</td>\n" . 
						"			<td align=\"center\">" . ($row_folders['enable_uploads'] == 1 ? "Ja" : "Nein") . "</td>\n" . 
						"			<td align=\"center\">\n" . 
						"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
						"					<input type=\"hidden\" name=\"folder_id\" value=\"" . $row_folders['id'] . "\" />\n" . 
						"					<button type=\"submit\" name=\"edit_folder\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"				</form>\n" . 
						"			</td>\n" . 
						"		</tr>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Einstellungen - Systemdaten</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Hier können Sie die Systemdaten verwalten.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col\">\n" . 
		"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"			<div class=\"card-header\">\n" . 
		"				<h4 class=\"mb-0\">Systemdaten</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 

		"					<div class=\"row mb-3\">\n" . 
		"						<div class=\"col-3 border-right\">\n" . 
		"							<div class=\"nav flex-column nav-pills\" id=\"v-pills-tab\" role=\"tablist\" aria-orientation=\"vertical\">\n" . 
		"								<a class=\"nav-link active\" id=\"v-pills-maindata-tab\" data-toggle=\"pill\" href=\"#v-pills-maindata\" role=\"tab\" aria-controls=\"v-pills-maindata\" aria-selected=\"true\">Grunddaten</a>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 
		"						<div class=\"col-9\">\n" . 
		"							<div class=\"tab-content\" id=\"v-pills-tabContent\">\n" . 
		"								<div class=\"tab-pane fade show active\" id=\"v-pills-maindata\" role=\"tabpanel\" aria-labelledby=\"v-pills-maindata-tab\">\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"unlogin_index\" class=\"col-sm-6 col-form-label text-right\">URL einfügen</label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select name=\"pages\" class=\"custom-select\" onchange=\"$('#unlogin_index').val(this.value)\">\n" . 

		$options_pages_unlogin_index . 

		"											</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"unlogin_index\" class=\"col-sm-6 col-form-label\">Benutzer - Unangemeldet Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Zielort für unangemeldete bestimmen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"unlogin_index\" name=\"unlogin_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $unlogin_index : strip_tags($row_systemdata["unlogin_index"])) . "\" class=\"form-control" . $inp_unlogin_index . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"unuser_index\" class=\"col-sm-6 col-form-label text-right\">URL einfügen</label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<select name=\"pages\" class=\"custom-select\" onchange=\"$('#unuser_index').val(this.value)\">\n" . 

		$options_pages_unuser_index . 

		"											</select>\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"unuser_index\" class=\"col-sm-6 col-form-label\">Kunde - Unangemeldet Index <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Zielort für unangemeldete Kunden bestimmen.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"unuser_index\" name=\"unuser_index\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $unuser_index : strip_tags($row_systemdata["unuser_index"])) . "\" class=\"form-control" . $inp_unuser_index . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 

		"									<div class=\"form-group row\">\n" . 
		"										<label for=\"none_file_accept\" class=\"col-sm-6 col-form-label\">Dateiupload, unerlaubte Dateiendungen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die unerlaubten Dateiendungen für den Dateiupload ändern.\">?</span></label>\n" . 
		"										<div class=\"col-sm-6\">\n" . 
		"											<input type=\"text\" id=\"nonet_file_accept\" name=\"none_file_accept\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $none_file_accept : strip_tags($row_systemdata["none_file_accept"])) . "\" class=\"form-control" . $inp_none_file_accept . "\" />\n" . 
		"										</div>\n" . 
		"									</div>\n" . 
		
		"								</div>\n" . 
		"							</div>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"					<div class=\"row px-0 border-top mb-3\">\n" . 
		"						<label for=\"stylefrontend\" class=\"col-sm-12 col-form-label\">Frontend-Style <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Style im Frontend mit einbeziehen\">?</span></label>\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<textarea id=\"stylefrontend\" name=\"style_frontend\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_style_frontend . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($style_frontend) : htmlentities($row_systemdata["style_frontend"])) . "</textarea>\n" . 
		"						</div>\n" . 
		"						<label for=\"scriptfrontend\" class=\"col-sm-12 col-form-label\">Frontend-Script <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie Javascript im Frontend mit einbeziehen\">?</span></label>\n" . 
		"						<div class=\"col-sm-12\">\n" . 
		"							<textarea id=\"scriptfrontend\" name=\"script_frontend\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_script_frontend . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($script_frontend) : htmlentities($row_systemdata["script_frontend"])) . "</textarea>\n" . 
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
		"<div class=\"form-group row\">\n" . 
		"	<label class=\"col-sm-12 col-form-label\">Verzeichnisse:</label>\n" . 
		"	<div class=\"col-sm-12\">\n" . 
		"		<div class=\"table-responsive\">\n" . 
		"			<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"				<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"					<th width=\"80\" scope=\"col\">\n" . 
		"						<strong>Name</strong>\n" . 
		"					</th>\n" . 
		"					<th scope=\"col\">\n" . 
		"						<strong>Beschreibung</strong>\n" . 
		"					</th>\n" . 
		"					<th scope=\"col\">\n" . 
		"						<strong>Verzeichnis</strong>\n" . 
		"					</th>\n" . 
		"					<th width=\"90\" scope=\"col\" class=\"text-center\">\n" . 
		"						<strong>.htaccess</strong>\n" . 
		"					</th>\n" . 
		"					<th width=\"90\" scope=\"col\" class=\"text-center\">\n" . 
		"						<strong>Löschbar</strong>\n" . 
		"					</th>\n" . 
		"					<th width=\"70\" scope=\"col\" class=\"text-center\">\n" . 
		"						<strong>Aktiv</strong>\n" . 
		"					</th>\n" . 
		"					<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
		"						<strong>Aktion</strong>\n" . 
		"					</th>\n" . 
		"				</tr></thead>\n" . 

		$list_folders . 

		"			</table>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<br />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<button type=\"submit\" name=\"add_folder\" value=\"hinzufügen\" class=\"btn btn-primary\">Verzeichnis hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
		"</form>\n" . 
		"<br />\n";

if(isset($_POST['add_folder']) && $_POST['add_folder'] == "hinzufügen"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Verszeichnis hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg_folder != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_folder . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Verzeichnisses ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"folders_name\" name=\"folders_name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $folders_name : "") . "\" class=\"form-control" . $inp_folders_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_description\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Beschreibung des Verzeichnisses ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"folders_description\" name=\"folders_description\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $folders_description : "") . "\" class=\"form-control" . $inp_folders_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_folder\" class=\"col-sm-3 col-form-label\">Verzeichnis <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie das Verzeichnis ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"folders_folder\" name=\"folders_folder\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $folders_folder : "") . "\" class=\"form-control" . $inp_folders_folder . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Mit .htaccess <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob dieses Verzeichnis aktiv sein soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"folders_htaccess\" name=\"folders_htaccess\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['folders_htaccess']) ? intval($_POST['folders_htaccess']) : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"folders_htaccess\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Aktiv <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob dieses Verzeichnis aktiv sein soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"folders_enable_uploads\" name=\"folders_enable_uploads\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['folders_enable_uploads']) ? intval($_POST['folders_enable_uploads']) : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"folders_enable_uploads\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save_folder\" value=\"speichern\" class=\"btn btn-primary\">Verzeichnis speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
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
				"<br />\n";

}

if(isset($_POST['edit_folder']) && $_POST['edit_folder'] == "bearbeiten"){

	$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `folders` WHERE `folders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['folder_id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Verzeichnis bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg_folder != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_folder . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name des Verzeichnisses ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"folders_name\" name=\"folders_name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $folders_name : strip_tags($row["name"])) . "\" class=\"form-control" . $inp_folders_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_description\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Beschreibung des Verzeichnisses ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"folders_description\" name=\"folders_description\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $folders_description : strip_tags($row["description"])) . "\" class=\"form-control" . $inp_folders_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"folders_folder\" class=\"col-sm-3 col-form-label\">Verzeichnis <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Verzeichnis ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<i>/uploads/company/{company_id}/" . strip_tags($row["folder"]) . "</i>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Aktiv <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob dieses Verzeichnis aktiv sein soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"folders_enable_uploads\" name=\"folders_enable_uploads\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['folders_enable_uploads']) ? intval($_POST['folders_enable_uploads']) : 0) : intval($row['enable_uploads'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"folders_enable_uploads\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"folder_id\" value=\"" . intval($_POST['folder_id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update_folder\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"" . ($row['erasable'] == 1 ? "submit" : "button") . "\" name=\"delete_folder\" value=\"entfernen\" onclick=\"return confirm('" . ($row['erasable'] == 1 ? "Wollen Sie das Verzeichnis wircklich entfernen?" : "Dieses Verzeichnis kann nicht entfernt werden!") . "')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n";

}

$html .=	"<br />\n" . 
			"<br />\n";

?>