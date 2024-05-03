<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "templates";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(isset($_POST["company_id"])){$_SESSION["company"]["id"] = intval($_POST["company_id"]);}

$email_templates_session = "email_templates_search";

if(isset($_POST["sorting_field"])){$_SESSION[$email_templates_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$email_templates_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$email_templates_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$email_templates_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$email_templates_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`templates`.`name`"
);
$sorting[] = array(
	"name" => "Betreff", 
	"value" => "`templates`.`subject`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`templates`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$email_templates_session]["sorting_field"]) ? $sorting[$_SESSION[$email_templates_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$email_templates_session]["sorting_field"]) ? $_SESSION[$email_templates_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$email_templates_session]["sorting_direction"]) ? $directions[$_SESSION[$email_templates_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$email_templates_session]["sorting_direction"]) ? $_SESSION[$email_templates_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$email_templates_session]["rows"]) && $_SESSION[$email_templates_session]["rows"] > 0 ? $_SESSION[$email_templates_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_from = "";
$inp_subject = "";
$inp_admin_mail_subject = "";
$inp_body = "";
$inp_pdf_php_code = "";

$name = "";
$from = "";
$subject = "";
$admin_mail_subject = "";
$body = "";
$pdf_php_code = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['from']) < 1 || strlen($_POST['from']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen 'von wem' Hinweis eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_from = " is-invalid";
	} else {
		$from = strip_tags($_POST['from']);
	}

	if(strlen($_POST['subject']) < 1 || strlen($_POST['subject']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Betreff eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_subject= " is-invalid";
	} else {
		$subject = strip_tags($_POST['subject']);
	}

	if(strlen($_POST['admin_mail_subject']) < 1 || strlen($_POST['admin_mail_subject']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Admin-Email Betreff eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_mail_subject = " is-invalid";
	} else {
		$admin_mail_subject = strip_tags($_POST['admin_mail_subject']);
	}

	if(strlen($_POST['body']) < 1 || strlen($_POST['body']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Text eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_body = " is-invalid";
	} else {
		$body = $_POST['body'];
	}

	if(strlen($_POST['pdf_php_code']) < 1 || strlen($_POST['pdf_php_code']) > 65536){
		$emsg .= "<span class=\"error\">Bitte eine Begleitschein-PDF PHP Code eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_pdf_php_code = " is-invalid";
	} else {
		$pdf_php_code = html_entity_decode($_POST['pdf_php_code']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`templates` 
								SET 	`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "', 
										`templates`.`type`='" . mysqli_real_escape_string($conn, intval(isset($_POST['type']) ? $_POST['type'] : 0)) . "', 
										`templates`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`templates`.`from`='" . mysqli_real_escape_string($conn, $from) . "', 
										`templates`.`subject`='" . mysqli_real_escape_string($conn, $subject) . "', 
										`templates`.`admin_mail_subject`='" . mysqli_real_escape_string($conn, $admin_mail_subject) . "', 
										`templates`.`body`='" . mysqli_real_escape_string($conn, $body) . "', 
										`templates`.`pdf_php_code`='" . mysqli_real_escape_string($conn, $pdf_php_code) . "', 
										`templates`.`mail_with_pdf`='" . mysqli_real_escape_string($conn, (isset($_POST['mail_with_pdf']) ? intval($_POST['mail_with_pdf']) : 0)) . "'");

		$_POST["id"] = $conn->insert_id;

		$f = fopen('includes/email_template_pdf_code_' . intval($_POST["id"]) . '.php', "w");
		fwrite($f, $pdf_php_code);
		fclose($f);

		$_POST['edit'] = "bearbeiten";

		$emsg = "<p>Die neue Email-Vorlage wurde erfolgreich hinzugefügt!</p>\n";

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

	if(strlen($_POST['from']) < 1 || strlen($_POST['from']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen 'von wem' Hinweis eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_from = " is-invalid";
	} else {
		$from = strip_tags($_POST['from']);
	}

	if(strlen($_POST['subject']) < 1 || strlen($_POST['subject']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Betreff eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_subject = " is-invalid";
	} else {
		$subject = strip_tags($_POST['subject']);
	}

	if(strlen($_POST['admin_mail_subject']) < 1 || strlen($_POST['admin_mail_subject']) > 256){
		$emsg .= "<span class=\"error\">Bitte einen Admin-Email Betreff eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_admin_mail_subject = " is-invalid";
	} else {
		$admin_mail_subject = strip_tags($_POST['admin_mail_subject']);
	}

	if(strlen($_POST['body']) < 1 || strlen($_POST['body']) > 65536){
		$emsg .= "<span class=\"error\">Bitte einen Text eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_body = " is-invalid";
	} else {
		$body = $_POST['body'];
	}

	if(strlen($_POST['pdf_php_code']) < 1 || strlen($_POST['pdf_php_code']) > 65536){
		$emsg .= "<span class=\"error\">Bitte eine Begleitschein-PDF PHP Code eingeben. (max. 65536 Zeichen)</span><br />\n";
		$inp_pdf_php_code = " is-invalid";
	} else {
		$pdf_php_code = html_entity_decode($_POST['pdf_php_code']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`templates` 
								SET 	`templates`.`type`='" . mysqli_real_escape_string($conn, intval(isset($_POST['type']) ? $_POST['type'] : 0)) . "', 
										`templates`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`templates`.`from`='" . mysqli_real_escape_string($conn, $from) . "', 
										`templates`.`subject`='" . mysqli_real_escape_string($conn, $subject) . "', 
										`templates`.`admin_mail_subject`='" . mysqli_real_escape_string($conn, $admin_mail_subject) . "', 
										`templates`.`body`='" . mysqli_real_escape_string($conn, $body) . "', 
										`templates`.`pdf_php_code`='" . mysqli_real_escape_string($conn, $pdf_php_code) . "', 
										`templates`.`mail_with_pdf`='" . mysqli_real_escape_string($conn, (isset($_POST['mail_with_pdf']) ? intval($_POST['mail_with_pdf']) : 0)) . "' 
								WHERE 	`templates`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "'");

		$f = fopen('includes/email_template_pdf_code_' . intval($_POST["id"]) . '.php', "w");
		fwrite($f, $pdf_php_code);
		fclose($f);

		$emsg = "<p>Die Email-Vorlage wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`templates` 
							WHERE 		`templates`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "'");

	@unlink('includes/email_template_pdf_code_' . intval($_POST["id"]) . '.php');

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine templates.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 10){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`templates` 
													SET 	`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "', 
															`templates`.`type`='" . mysqli_real_escape_string($conn, (isset($_POST['type']) && intval($_POST['type']) > 0 ? intval($_POST['type']) : intval($data[2]))) . "', 
															`templates`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`templates`.`from`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`templates`.`subject`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`templates`.`admin_mail_subject`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`templates`.`body`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[7]))) . "', 
															`templates`.`pdf_php_code`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[8]))) . "', 
															`templates`.`mail_with_pdf`='" . mysqli_real_escape_string($conn, intval($data[9])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`templates` 
													SET 	`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "', 
															`templates`.`type`='" . mysqli_real_escape_string($conn, (isset($_POST['type']) && intval($_POST['type']) > 0 ? intval($_POST['type']) : intval($data[2]))) . "', 
															`templates`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`templates`.`from`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`templates`.`subject`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`templates`.`admin_mail_subject`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`templates`.`body`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[7]))) . "', 
															`templates`.`pdf_php_code`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[8]))) . "', 
															`templates`.`mail_with_pdf`='" . mysqli_real_escape_string($conn, intval($data[9])) . "' 
													WHERE 	`templates`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$types = array(
	0 => "Abholen", 
	1 => "Aufträge", 
	2 => "Versand", 
	3 => "Kunden", 
	4 => "Interessenten", 
	5 => "Einkäufe", 
	6 => "Retouren", 
	7 => "Packtisch"
);

$result_company = mysqli_query($conn, "SELECT * FROM `companies` ORDER BY CAST(`companies`.`id` AS UNSIGNED) ASC");

$company_options = "";

while($c = $result_company->fetch_array(MYSQLI_ASSOC)){

	$company_options .= "				<option value=\"" . $c["id"] . "\"" . (isset($_SESSION["company"]["id"]) && $c["id"] == $_SESSION["company"]["id"] ? " selected=\"selected\"" : "") . ">" . $c['name'] . "</option>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-3 col-md-3 col-sm-3 col-xs-3\">\n" . 
		"		<h3>Einstellungen - Email Vorlagen</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-6 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<select id=\"company_id\" name=\"company_id\" class=\"custom-select custom-select-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\">\n" . 

		$company_options . 

		"				</select>\n" . 
		"				<button type=\"submit\" name=\"open\" value=\"company\" class=\"btn btn-lg btn-success\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-3 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<input type=\"hidden\" id=\"company_id\" name=\"company_id\" value=\"" . (isset($_SESSION["company"]["id"]) && $_SESSION["company"]["id"] > 0 ? $_SESSION["company"]["id"] : 0) . "\" />\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$email_templates_session]['keyword']) && $_SESSION[$email_templates_session]['keyword'] != "" ? $_SESSION[$email_templates_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<hr />\n";

if(isset($_SESSION["company"]["id"]) && intval($_SESSION["company"]["id"]) > 0){

	$where = 	isset($_SESSION[$email_templates_session]["keyword"]) && $_SESSION[$email_templates_session]["keyword"] != "" ? 
				"WHERE 	(`templates`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$email_templates_session]["keyword"]) . "%' 
				OR		`templates`.`from` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$email_templates_session]["keyword"]) . "%'
				OR		`templates`.`subject` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$email_templates_session]["keyword"]) . "%'
				OR		`templates`.`admin_mail_subject` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$email_templates_session]["keyword"]) . "%'
				OR		`templates`.`body` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$email_templates_session]["keyword"]) . "%') " : 
				"WHERE 	`templates`.`id`>0";

	$query = "	SELECT 		* 
				FROM 		`templates` 
				" . $where . "
				AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "' 
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
					"		<td scope=\"row\">\n" . 
					"			<span>" . $row['name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . $types[$row['type']] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<span>" . substr($row['subject'], 0, 128) . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<span>" . ($row['mail_with_pdf'] == 1 ? "Ja" : "Nein") . "</span>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

	$html .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"	<div class=\"form-group row\">\n" . 
				"		<div class=\"col-sm-12 text-center\">\n" . 
				"			<div class=\"btn-group\">\n" . 
				"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"				<a href=\"/crm/email-vorlagen-herunterladen\" class=\"btn btn-primary\">Vorlagen herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
				"				<a href=\"/crm/email-vorlagen-pdf-php-code-herunterladen\" class=\"btn btn-primary\">PDF PHP-Code herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
				"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</form>\n";

}

if(!isset($_POST['data']) && isset($_SESSION["company"]["id"]) && intval($_SESSION["company"]["id"]) > 0){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"300\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Name</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"200\" class=\"text-center\" scope=\"col\">\n" . 
				"				<strong>Bereich</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Betreff</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"130\" class=\"text-center\" scope=\"col\">\n" . 
				"				<strong>Begleitschein</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" class=\"text-center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") || (isset($_POST['templates']) && $_POST['templates'] == "download") ? "" : "<br />\n<br />\n<br />\n");

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$type_options = "";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\"" . (isset($_POST['type']) && $i == intval($_POST['type']) ? " selected=\"selected\"" : "") . ">" . $types[$i] . "</option>\n";

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
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie den Bereich der Email-Vorlage aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"from\" class=\"col-sm-3 col-form-label\">Von wem, Hinweis <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den 'von wem' Hinweis der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"from\" name=\"from\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $from : "") . "\" class=\"form-control" . $inp_from . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"subject\" class=\"col-sm-3 col-form-label\">Betreff <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Betreff der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"subject\" name=\"subject\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $subject : "") . "\" class=\"form-control" . $inp_subject . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"admin_mail_subject\" class=\"col-sm-3 col-form-label\">Admin-Email, Betreff <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Admin-Email, Betreff der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_mail_subject\" name=\"admin_mail_subject\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $admin_mail_subject : "") . "\" class=\"form-control" . $inp_admin_mail_subject . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-3 col-form-label\">Nachricht <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Nachricht der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"edit_content\" name=\"body\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_body . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $body : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pdf_php_code\" class=\"col-sm-3 col-form-label\">Anhang, PDF PHP Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den, Anhang, PDF PHP Code der Email-Vorlage ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"pdf_php_code\" name=\"pdf_php_code\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_pdf_php_code . "\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($pdf_php_code) : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Begleitschein <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob mit dieser Vorlage ein Begleitschein angehängt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"mail_with_pdf\" name=\"mail_with_pdf\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['mail_with_pdf']) ? $_POST['mail_with_pdf'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mail_with_pdf\">\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["company"]["id"])) . "'"), MYSQLI_ASSOC);

	$type_options = "";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\"" . ($i == $row['type'] ? " selected=\"selected\"" : "") . ">" . $types[$i] . "</option>\n";

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
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"from\" class=\"col-sm-3 col-form-label\">Von wem, Hinweis <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den 'Von wem' Hinweis der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"from\" name=\"from\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $from : strip_tags($row["from"])) . "\" class=\"form-control" . $inp_from . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"subject\" class=\"col-sm-3 col-form-label\">Betreff <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Betreff der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"subject\" name=\"subject\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $subject : strip_tags($row["subject"])) . "\" class=\"form-control" . $inp_subject . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"admin_mail_subject\" class=\"col-sm-3 col-form-label\">Admin Email, Betreff <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Admin Email, Betreff der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"admin_mail_subject\" name=\"admin_mail_subject\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $admin_mail_subject : strip_tags($row["admin_mail_subject"])) . "\" class=\"form-control" . $inp_admin_mail_subject . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"edit_content\" class=\"col-sm-3 col-form-label\">Nachricht <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Nachricht der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"edit_content\" name=\"body\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_body . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $body : $row["body"]) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pdf_php_code\" class=\"col-sm-3 col-form-label\">Anhang, PDF PHP Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den, Anhang, PDF PHP Code der Email-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"pdf_php_code\" name=\"pdf_php_code\" style=\"width: 100%;height: 400px\" class=\"form-control" . $inp_pdf_php_code . "\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($pdf_php_code) : htmlentities($row["pdf_php_code"])) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Begleitschein <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob mit dieser Vorlage ein Begleitschein angehängt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"mail_with_pdf\" name=\"mail_with_pdf\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['mail_with_pdf']) ? intval($_POST['mail_with_pdf']) : 0) : intval($row['mail_with_pdf'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mail_with_pdf\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
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
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['data']) && $_POST['data'] == "importieren"){

	$type_options = "								<option value=\"0\">nicht ändern</option>\n";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\">" . $types[$i] . "</option>\n";

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
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

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