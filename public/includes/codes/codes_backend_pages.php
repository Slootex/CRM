<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "pages";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$pages_session = "pages_search";

if(isset($_POST["sorting_field"])){$_SESSION[$pages_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$pages_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$pages_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$pages_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$pages_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`pages`.`name`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`pages`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$pages_session]["sorting_field"]) ? $sorting[$_SESSION[$pages_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$pages_session]["sorting_field"]) ? $_SESSION[$pages_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$pages_session]["sorting_direction"]) ? $directions[$_SESSION[$pages_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$pages_session]["sorting_direction"]) ? $_SESSION[$pages_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$pages_session]["rows"]) && $_SESSION[$pages_session]["rows"] > 0 ? $_SESSION[$pages_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_linkname= "";
$inp_url = "";
$inp_rules = "";
$inp_title = "";
$inp_meta_title = "";
$inp_meta_description = "";
$inp_meta_keywords = "";
$inp_content = "";
$inp_style = "";
$inp_script = "";

$inp_code = "";
$inp_template = "";

$name = "";
$linkname = "";
$url = "";
$rules = "";
$title = "";
$meta_title = "";
$meta_description = "";
$meta_keywords = "";
$content = "";
$style = "";
$script = "";

$code = "";
$template = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 64){
		$emsg .= "<span class=\"error\">Bitte einen internen Name eingeben. (max. 64 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['linkname']) < 1 || strlen($_POST['linkname']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_linkname = " is-invalid";
	} else {
		$linkname = strip_tags($_POST['linkname']);
	}

	if(strlen($_POST['url']) < 1 || strlen($_POST['url']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine URL eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_url = " is-invalid";
	} else {
		$url = strip_tags($_POST['url']);
	}

	if(strlen($_POST['rules']) < 1 || strlen($_POST['rules']) > 65535){
		$emsg .= "<span class=\"error\">Bitte eine URL-Regel eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_rules = " is-invalid";
	} else {
		$rules = $_POST['rules'];
	}

	if(strlen($_POST['title']) < 1 || strlen($_POST['title']) > 128){
		$emsg .= "<span class=\"error\">Bitte ein Seiten-Title eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = strip_tags($_POST['title']);
	}

	if(strlen($_POST['meta_title']) < 1 || strlen($_POST['meta_title']) > 128){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Title eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_meta_title = " is-invalid";
	} else {
		$meta_title = strip_tags($_POST['meta_title']);
	}

	if(strlen($_POST['meta_description']) < 1 || strlen($_POST['meta_description']) > 1024){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Beschreibung eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_meta_description = " is-invalid";
	} else {
		$meta_description = $_POST['meta_description'];
	}

	if(strlen($_POST['meta_keywords']) < 1 || strlen($_POST['meta_keywords']) > 1024){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Schlüsselwörter eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_meta_keywords = " is-invalid";
	} else {
		$meta_keywords = $_POST['meta_keywords'];
	}

	if(strlen($_POST['content']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Inhalt eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_content = " is-invalid";
	} else {
		$content = str_replace("<" . "!--?php", "<" . "?php", str_replace("?--" . ">", "?" . ">", $_POST['content']));
	}

	if(strlen($_POST['style']) > 65535){
		$emsg .= "<span class=\"error\">Bitte einige Style-angaben eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = $_POST['style'];
	}

	if(strlen($_POST['script']) > 65535){
		$emsg .= "<span class=\"error\">Bitte einige Script-angaben eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_script = " is-invalid";
	} else {
		$script = $_POST['script'];
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`pages` 
								SET 	`pages`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`pages`.`linkname`='" . mysqli_real_escape_string($conn, $linkname) . "', 
										`pages`.`url`='" . mysqli_real_escape_string($conn, $url) . "', 
										`pages`.`rules`='" . mysqli_real_escape_string($conn, $rules) . "', 
										`pages`.`code_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['code_id']) ? $_POST['code_id'] : 0)) . "', 
										`pages`.`template_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['template_id']) ? $_POST['template_id'] : 0)) . "', 
										`pages`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`pages`.`meta_title`='" . mysqli_real_escape_string($conn, $meta_title) . "', 
										`pages`.`meta_description`='" . mysqli_real_escape_string($conn, $meta_description) . "', 
										`pages`.`meta_keywords`='" . mysqli_real_escape_string($conn, $meta_keywords) . "', 
										`pages`.`style`='" . mysqli_real_escape_string($conn, $style) . "', 
										`pages`.`script`='" . mysqli_real_escape_string($conn, $script) . "'");

		$_POST["id"] = $conn->insert_id;

		$f = fopen('includes/content/content_' . intval($_POST["id"]) . '.php', "w");
		fwrite($f, $content);
		fclose($f);

		$emsg = "<p>Die neue Seite wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 64){
		$emsg .= "<span class=\"error\">Bitte einen internen Name eingeben. (max. 64 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['linkname']) < 1 || strlen($_POST['linkname']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_linkname = " is-invalid";
	} else {
		$linkname = strip_tags($_POST['linkname']);
	}

	if(strlen($_POST['url']) < 1 || strlen($_POST['url']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine URL eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_url = " is-invalid";
	} else {
		$url = strip_tags($_POST['url']);
	}

	if(strlen($_POST['rules']) < 1 || strlen($_POST['rules']) > 65535){
		$emsg .= "<span class=\"error\">Bitte eine URL-Regel eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_rules = " is-invalid";
	} else {
		$rules = $_POST['rules'];
	}

	if(strlen($_POST['title']) < 1 || strlen($_POST['title']) > 128){
		$emsg .= "<span class=\"error\">Bitte ein Seiten-Title eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_title = " is-invalid";
	} else {
		$title = strip_tags($_POST['title']);
	}

	if(strlen($_POST['meta_title']) < 1 || strlen($_POST['meta_title']) > 128){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Title eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_meta_title = " is-invalid";
	} else {
		$meta_title = strip_tags($_POST['meta_title']);
	}

	if(strlen($_POST['meta_description']) < 1 || strlen($_POST['meta_description']) > 1024){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Beschreibung eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_meta_description = " is-invalid";
	} else {
		$meta_description = $_POST['meta_description'];
	}

	if(strlen($_POST['meta_keywords']) < 1 || strlen($_POST['meta_keywords']) > 1024){
		$emsg .= "<span class=\"error\">Bitte ein Meta-Schlüsselwörter eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_meta_keywords = " is-invalid";
	} else {
		$meta_keywords = $_POST['meta_keywords'];
	}

	if(strlen($_POST['content']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein Inhalt eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_content = " is-invalid";
	} else {
		$content = str_replace("<" . "!--?php", "<" . "?php", str_replace("?--" . ">", "?" . ">", $_POST['content']));
	}

	if(strlen($_POST['style']) > 65535){
		$emsg .= "<span class=\"error\">Bitte einige Style-angaben eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = $_POST['style'];
	}

	if(strlen($_POST['script']) > 65535){
		$emsg .= "<span class=\"error\">Bitte einige Script-angaben eingeben. (max. 65535 Zeichen)</span><br />\n";
		$inp_script = " is-invalid";
	} else {
		$script = $_POST['script'];
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`pages` 
								SET 	`pages`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`pages`.`linkname`='" . mysqli_real_escape_string($conn, $linkname) . "', 
										`pages`.`url`='" . mysqli_real_escape_string($conn, $url) . "', 
										`pages`.`rules`='" . mysqli_real_escape_string($conn, $rules) . "', 
										`pages`.`code_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['code_id']) ? $_POST['code_id'] : 0)) . "', 
										`pages`.`template_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['template_id']) ? $_POST['template_id'] : 0)) . "', 
										`pages`.`title`='" . mysqli_real_escape_string($conn, $title) . "', 
										`pages`.`meta_title`='" . mysqli_real_escape_string($conn, $meta_title) . "', 
										`pages`.`meta_description`='" . mysqli_real_escape_string($conn, $meta_description) . "', 
										`pages`.`meta_keywords`='" . mysqli_real_escape_string($conn, $meta_keywords) . "', 
										`pages`.`style`='" . mysqli_real_escape_string($conn, $style) . "', 
										`pages`.`script`='" . mysqli_real_escape_string($conn, $script) . "' 
								WHERE 	`pages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$f = fopen('includes/content/content_' . intval($_POST["id"]) . '.php', "w");
		fwrite($f, $content);
		fclose($f);

		$emsg = "<p>Die Seite wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['files']) && $_POST['files'] == "speichern"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages` WHERE `pages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_code = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_codes` WHERE `pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($row_item['code_id'])) . "'"), MYSQLI_ASSOC);

	$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_templates` WHERE `pages_templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_item['template_id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['code']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte einen Verarbeitungs-Code eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_code = " is-invalid";
	} else {
		$code = $_POST['code']; //html_entity_decode($_POST['code']);
	}

	if(strlen($_POST['content']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte einen Inhalts-Code eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_content = " is-invalid";
	} else {
		$content = str_replace("<" . "!--?php", "<" . "?php", str_replace("?--" . ">", "?" . ">", $_POST['content']));
	}

	if(strlen($_POST['template']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte einen Vorlagen-Code eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_template = " is-invalid";
	} else {
		$template = $_POST['template']; //html_entity_decode($_POST['template']);
	}

	if($emsg == ""){

		$f = fopen('includes/codes/' . $row_code['name'] . '.php', "w");
		fwrite($f, $code);
		fclose($f);

		$f = fopen('includes/content/content_' . intval($_POST['id']) . '.php', "w");
		fwrite($f, $content);
		fclose($f);

		$f = fopen('includes/templates/' . $row_template['name'] . '.php', "w");
		fwrite($f, $template);
		fclose($f);

		$emsg = "<p>Die Seite wurde erfolgreich geändert!</p>\n";

	}

	$_POST['files'] = "Dateien";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages` WHERE `pages`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`pages` 
							WHERE 		`pages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	@unlink('includes/content/content_' . intval($row_item['id']) . '.php');

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine pages.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 25){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`pages` 
													SET 	`pages`.`name`='" . mysqli_real_escape_string($conn, $data[1]) . "', 
															`pages`.`linkname`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`pages`.`url`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`pages`.`rules`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[4]))) . "', 
															`pages`.`code_id`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`pages`.`template_id`='" . mysqli_real_escape_string($conn, intval($data[6])) . "', 
															`pages`.`title`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`pages`.`meta_title`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`pages`.`meta_description`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`pages`.`meta_keywords`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`pages`.`style`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`pages`.`script`='" . mysqli_real_escape_string($conn, $data[12]) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`pages` 
													SET 	`pages`.`name`='" . mysqli_real_escape_string($conn, $data[1]) . "', 
															`pages`.`linkname`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`pages`.`url`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`pages`.`rules`='" . mysqli_real_escape_string($conn, str_replace(array("\\n"), "\n", str_replace("&quot;", "\"", $data[4]))) . "', 
															`pages`.`code_id`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`pages`.`template_id`='" . mysqli_real_escape_string($conn, intval($data[6])) . "', 
															`pages`.`title`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`pages`.`meta_title`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`pages`.`meta_description`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`pages`.`meta_keywords`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`pages`.`style`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`pages`.`script`='" . mysqli_real_escape_string($conn, $data[12]) . "' 
													WHERE 	`pages`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$where = 	isset($_SESSION[$pages_session]["keyword"]) && $_SESSION[$pages_session]["keyword"] != "" ? 
			"WHERE 	(`pages`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`title` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`url` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`rules` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`meta_title` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`meta_description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%' 
			OR		`pages`.`meta_keywords` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$pages_session]["keyword"]) . "%') " : 
			"WHERE 	`pages`.`id`>0";

$query = 	"	SELECT 		*, 
							(SELECT `pages_codes`.`description` AS description FROM `pages_codes` WHERE `pages_codes`.`id`=`pages`.`code_id`) AS code_name, 
							(SELECT `pages_codes`.`name` AS name FROM `pages_codes` WHERE `pages_codes`.`id`=`pages`.`code_id`) AS code_filename, 
							(SELECT `pages_templates`.`description` AS description FROM `pages_templates` WHERE `pages_templates`.`id`=`pages`.`template_id`) AS template_name, 
							(SELECT `pages_templates`.`name` AS name FROM `pages_templates` WHERE `pages_templates`.`id`=`pages`.`template_id`) AS template_filename 
				FROM 		`pages` 
				" . $where . "
				ORDER BY 	" . $sorting_field_name . " " . $sorting_direction_name;

$result = mysqli_query($conn, $query);

$rows = $result->num_rows;

$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
									"of" 		=> "von", 
									"start" 	=> "|<<", 
									"next" 		=> "Weiter", 
									"back" 		=> "Zurück", 
									"end" 		=> ">>|", 
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

	$info = "<b><u>URL</u></b>:<br />" . $row_item['url'] . "<br /><br /><b><u>URL-Regeln</u></b>:<br />" . str_replace("\r\n", "<br />", $row_item['rules']) . "<br /><br /><b><u>Code</u></b>:<br />/includes/codes/" . $row_item['code_filename'] . ".php<br /><br /><b><u>Vorlage</u></b>:<br />/includes/templates/" . $row_item['template_filename'] . ".php";

	$result_pages = mysqli_query($conn, "SELECT `pages`.`id` AS id, `pages`.`name` AS name FROM `pages` WHERE `pages`.`code_id`='" . mysqli_real_escape_string($conn, intval($row_item['code_id'])) . "' ORDER BY `pages`.`name` ASC");

	$code_info = "<b><u>Verwendet in den Seiten</u></b>:";

	while($row_page = $result_pages->fetch_array(MYSQLI_ASSOC)){

		$code_info .= "<br />&nbsp;&nbsp;<i class='fa fa-file-text-o text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;" . $row_page['name'];

	}

	$result_pages = mysqli_query($conn, "SELECT `pages`.`id` AS id, `pages`.`name` AS name FROM `pages` WHERE `pages`.`template_id`='" . mysqli_real_escape_string($conn, intval($row_item['template_id'])) . "' ORDER BY `pages`.`name` ASC");

	$template_info = "<b><u>Verwendet in den Seiten</u></b>:";

	while($row_page = $result_pages->fetch_array(MYSQLI_ASSOC)){

		$template_info .= "<br />&nbsp;&nbsp;<i class='fa fa-file-text-o text-white bg-secondary'> </i>&nbsp;&nbsp;&nbsp;" . $row_page['name'];

	}

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row_item['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"" . $info . "\" title=\"\">\n" . 
				"			<span>" . $row_item['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"" . $code_info . "\" title=\"\">\n" . 
				"			<span>" . $row_item['code_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"" . $template_info . "\" title=\"\">\n" . 
				"			<span>" . $row_item['template_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
				"			<div class=\"btn-group\">\n" . 
				"				<a href=\"" . $row_item['url'] . "\" class=\"btn btn-sm btn-success\" target=\"_blank\">Test <i class=\"fa fa-check\" aria-hidden=\"true\"></i></a>\n" . 
				"				<button type=\"submit\" name=\"files\" value=\"Dateien\" class=\"btn btn-sm btn-success\">Dateien <i class=\"fa fa-file\" aria-hidden=\"true\"></i></button>\n" . 
				"				<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"			</div>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Seiten</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$pages_session]['keyword']) && $_SESSION[$pages_session]['keyword'] != "" ? $_SESSION[$pages_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Seiten bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/seiten-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
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
			"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Name</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<strong>Code</strong>\n" . 
			"			</th>\n" . 
			"			<th scope=\"col\">\n" . 
			"				<strong>Vorlage</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"260\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Aktion</strong>\n" . 
			"			</th>\n" . 
			"		</tr></thead>\n" . 

			$list . 

			"	</table>\n" . 
			"</div>\n" . 
			"<br />\n" . 

			$pageNumberlist->getNavi() . 

			((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") || (isset($_POST['files']) && $_POST['files'] == "Dateien") || (isset($_POST['data']) && $_POST['data'] == "importieren") ? "" : "<br />\n<br />\n<br />\n");

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$options_codes = "";

	$result_codes = mysqli_query($conn, "	SELECT 		* 
											FROM 		`pages_codes` 
											ORDER BY 	`pages_codes`.`description` ASC");

	while($row = $result_codes->fetch_array(MYSQLI_ASSOC)){

		$options_codes .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['code_id']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['description'] . "</option>\n";

	}

	$options_templates = "";

	$result_templates = mysqli_query($conn, "	SELECT 		* 
												FROM 		`pages_templates` 
												ORDER BY 	`pages_templates`.`description` ASC");

	while($row = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$options_templates .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['template_id']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['description'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"linkname\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"linkname\" name=\"linkname\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $linkname : "") . "\" class=\"form-control" . $inp_linkname . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"url\" class=\"col-sm-3 col-form-label\">URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die URL der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"url\" name=\"url\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $url : "") . "\" class=\"form-control" . $inp_url . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"rules\" class=\"col-sm-3 col-form-label\">URL-Regeln <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die URL-Regeln der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"rules\" name=\"rules\" class=\"" . $inp_rules . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $rules : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"code_id\" class=\"col-sm-3 col-form-label\">Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Verarbeitungs-Code auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"code_id\" name=\"code_id\" class=\"custom-select\">\n" . 

				$options_codes . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"template_id\" class=\"col-sm-3 col-form-label\">Vorlage <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Seiten-Vorlage auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"template_id\" name=\"template_id\" class=\"custom-select\">\n" . 

				$options_templates . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"title\" class=\"col-sm-3 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Title der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $title : "") . "\" class=\"form-control" . $inp_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_title\" class=\"col-sm-3 col-form-label\">Meta-Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Meta-Title der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_title\" name=\"meta_title\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $meta_title : "") . "\" class=\"form-control" . $inp_meta_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_description\" class=\"col-sm-3 col-form-label\">Meta-Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Meta-Beschreibung der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_description\" name=\"meta_description\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $meta_description : "") . "\" class=\"form-control" . $inp_meta_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_keywords\" class=\"col-sm-3 col-form-label\">Meta-Schlüsselwörter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Meta-Beschreibung der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_keywords\" name=\"meta_keywords\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $meta_keywords : "") . "\" class=\"form-control" . $inp_meta_keywords . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"content\" class=\"col-sm-3 col-form-label\">Seiten-Inhalt <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Seiten-Inhalt der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"content\" name=\"content\" class=\"" . $inp_content . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($content) : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"style\" class=\"col-sm-3 col-form-label\">Seiten-Styles <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Seiten-Styles der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"style\" name=\"style\" class=\"" . $inp_style . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($style) : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"script\" class=\"col-sm-3 col-form-label\">Seiten-Scripte <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Seiten-Scripte der Seite ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"script\" name=\"script\" class=\"" . $inp_script . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($script) : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							\n" . 
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

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages` WHERE `pages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$old_content = implode("", file("includes/content/content_" . intval($row_item['id']) . ".php"));

	$options_codes = "";

	$result_codes = mysqli_query($conn, "	SELECT 		* 
											FROM 		`pages_codes` 
											ORDER BY 	`pages_codes`.`description` ASC");

	while($row = $result_codes->fetch_array(MYSQLI_ASSOC)){

		$options_codes .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['code_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_item["code_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['description'] . "</option>\n";

	}

	$options_templates = "";

	$result_templates = mysqli_query($conn, "	SELECT 		* 
												FROM 		`pages_templates` 
												ORDER BY 	`pages_templates`.`description` ASC");

	while($row = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$options_templates .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['template_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_item["template_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['description'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name (intern) <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den internen Name dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_item["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"linkname\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"linkname\" name=\"linkname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $linkname : strip_tags($row_item["linkname"])) . "\" class=\"form-control" . $inp_linkname . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"url\" class=\"col-sm-3 col-form-label\">URL <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die URL dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"url\" name=\"url\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $url : strip_tags($row_item["url"])) . "\" class=\"form-control" . $inp_url . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"rules\" class=\"col-sm-3 col-form-label\">URL-Regeln <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die URL-Regeln dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"rules\" name=\"rules\" class=\"" . $inp_rules . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $rules : $row_item["rules"]) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"code_id\" class=\"col-sm-3 col-form-label\">Seiten-Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Seiten-Code ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"code_id\" name=\"code_id\" class=\"custom-select\">\n" . 

				$options_codes . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"template_id\" class=\"col-sm-3 col-form-label\">Seiten-Vorlage <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Seiten-Vorlage ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"template_id\" name=\"template_id\" class=\"custom-select\">\n" . 

				$options_templates . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"title\" class=\"col-sm-3 col-form-label\">Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Title dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"title\" name=\"title\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $title : strip_tags($row_item["title"])) . "\" class=\"form-control" . $inp_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_title\" class=\"col-sm-3 col-form-label\">Meta-Title <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Meta-Title dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_title\" name=\"meta_title\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $meta_title : strip_tags($row_item["meta_title"])) . "\" class=\"form-control" . $inp_meta_title . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_description\" class=\"col-sm-3 col-form-label\">Meta-Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Meta-Beschreibung dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_description\" name=\"meta_description\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $meta_description : $row_item["meta_description"]) . "\" class=\"form-control" . $inp_meta_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"meta_keywords\" class=\"col-sm-3 col-form-label\">Meta-Schlüsselwörter <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Meta-Schlüsselwörter dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"meta_keywords\" name=\"meta_keywords\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $meta_keywords : $row_item["meta_keywords"]) . "\" class=\"form-control" . $inp_meta_keywords . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"content\" class=\"col-sm-3 col-form-label\">Seiten-Inhalt <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Seiten-Inhalt dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"content\" name=\"content\" class=\"" . $inp_content . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($content) : htmlentities($old_content)) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"style\" class=\"col-sm-3 col-form-label\">Seiten-Styles <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Seiten-Styles dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"style\" name=\"style\" class=\"" . $inp_style . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($style) : htmlentities($row_item["style"])) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"script\" class=\"col-sm-3 col-form-label\">Seiten-Scripte <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Seiten-Scripte dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"script\" name=\"script\" class=\"" . $inp_script . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($script) : htmlentities($row_item["script"])) . "</textarea>\n" . 
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

if(isset($_POST['files']) && $_POST['files'] == "Dateien"){

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages` WHERE `pages`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_code = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_codes` WHERE `pages_codes`.`id`='" . mysqli_real_escape_string($conn, intval($row_item['code_id'])) . "'"), MYSQLI_ASSOC);

	$old_code = implode("", file("includes/codes/" . $row_code['name'] . ".php"));

	$old_content = implode("", file("includes/content/" . intval($row_item['id']) . ".php"));

	$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `pages_templates` WHERE `pages_templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_item['template_id'])) . "'"), MYSQLI_ASSOC);

	$old_template = implode("", file("includes/templates/" . $row_template['name'] . ".php"));

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den internen Name dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" .  strip_tags($row_item["name"]) . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"code\" class=\"col-sm-3 col-form-label\">Verarbeitungs-Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Seiten-Verarbeitungs-Code dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"code\" name=\"code\" class=\"" . $inp_code . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($code) : htmlentities($old_code)) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"content\" class=\"col-sm-3 col-form-label\">Inhalt <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Seiten-Inhalt dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"content\" name=\"content\" class=\"" . $inp_content . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($content) : htmlentities($old_content)) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"template\" class=\"col-sm-3 col-form-label\">Vorlagen-Code <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Seiten-Vorlage-Code dieser Seite ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<textarea id=\"template\" name=\"template\" class=\"" . $inp_template . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($template) : htmlentities($old_template)) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"files\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							\n" . 
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

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

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
				"							\n" . 
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