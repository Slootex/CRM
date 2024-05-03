<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "style";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$style_session = "style_search";

if(isset($_POST["sorting_field"])){$_SESSION[$style_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$style_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$style_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$style_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$style_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`design`.`name`"
);
$sorting[] = array(
	"name" => "Beschreibung", 
	"value" => "`design`.`description`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`design`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$style_session]["sorting_field"]) ? $sorting[$_SESSION[$style_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$style_session]["sorting_field"]) ? $_SESSION[$style_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$style_session]["sorting_direction"]) ? $directions[$_SESSION[$style_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$style_session]["sorting_direction"]) ? $_SESSION[$style_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$style_session]["rows"]) && $_SESSION[$style_session]["rows"] > 0 ? $_SESSION[$style_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_full_width = "";
$inp_bgcolor_header_footer = "";
$inp_bgcolor_sidebar = "";
$inp_bgcolor_card = "";
$inp_color_card = "";
$inp_border_header_footer = "";
$inp_bgcolor_table = "";
$inp_bgcolor_table_head = "";
$inp_color_table_head = "";
$inp_color_link = "";
$inp_color_text = "";
$inp_bgcolor_select = "";
$inp_color_select = "";
$inp_border_select = "";
$inp_style = "";

$full_width = 0;
$bgcolor_header_footer = "";
$border_header_footer = "";
$bgcolor_navbar_burgermenu = "";
$bgcolor_badge = "";
$bgcolor_sidebar = "";
$bgcolor_card = "";
$color_card = "";
$border_header_footer = "";
$bgcolor_table = "";
$bgcolor_table_head = "";
$color_table_head = "";
$color_link = "";
$color_text = "";
$bgcolor_select = "";
$color_select = "";
$border_select = "";
$style = "";

$categories = array(
	0 => "Alte-Designs", 
	1 => "Neue-Designs"
);

$colors = array(
	"primary" => "Primary", 
	"secondary" => "Secondary", 
	"success" => "Success", 
	"danger" => "Danger", 
	"warning" => "Warning", 
	"info" => "Info", 
	"light" => "Light", 
	"dark" => "Dark", 
	"body" => "Body", 
	"muted" => "Muted", 
	"white" => "White", 
	"black-50" => "Black-50", 
	"white-50" => "White-50" 
);

$bgcolors = array(
	"primary" => "Primary", 
	"secondary" => "Secondary", 
	"success" => "Success", 
	"danger" => "Danger", 
	"warning" => "Warning", 
	"info" => "Info", 
	"light" => "Light", 
	"dark" => "Dark", 
	"white" => "White", 
	"transparent" => "Transparent"
);

$bordercolors = array(
	"primary" => "Primary", 
	"secondary" => "Secondary", 
	"success" => "Success", 
	"danger" => "Danger", 
	"warning" => "Warning", 
	"info" => "Info", 
	"light" => "Light", 
	"dark" => "Dark", 
	"white" => "White"
);

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['bgcolor_header_footer']) < 1 || strlen($_POST['bgcolor_header_footer']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für den Header und Footer auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_header_footer = " is-invalid";
	} else {
		$bgcolor_header_footer = strip_tags($_POST['bgcolor_header_footer']);
	}

	if(strlen($_POST['border_header_footer']) < 1 || strlen($_POST['border_header_footer']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Rahmenfarbe für den Header und Footer auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_border_header_footer = " is-invalid";
	} else {
		$border_header_footer = strip_tags($_POST['border_header_footer']);
	}

	if(strlen($_POST['bgcolor_navbar_burgermenu']) < 1 || strlen($_POST['bgcolor_navbar_burgermenu']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für das Bürgermenü auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_navbar_burgermenu = " is-invalid";
	} else {
		$bgcolor_navbar_burgermenu = strip_tags($_POST['bgcolor_navbar_burgermenu']);
	}

	if(strlen($_POST['bgcolor_badge']) < 1 || strlen($_POST['bgcolor_badge']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Labelhilfe auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_badge = " is-invalid";
	} else {
		$bgcolor_badge = strip_tags($_POST['bgcolor_badge']);
	}

	if(strlen($_POST['bgcolor_sidebar']) < 1 || strlen($_POST['bgcolor_sidebar']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Sidebar auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_sidebar = " is-invalid";
	} else {
		$bgcolor_sidebar = strip_tags($_POST['bgcolor_sidebar']);
	}

	if(strlen($_POST['bgcolor_card']) < 1 || strlen($_POST['bgcolor_card']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Card-Boxen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_card = " is-invalid";
	} else {
		$bgcolor_card = strip_tags($_POST['bgcolor_card']);
	}

	if(strlen($_POST['color_card']) < 1 || strlen($_POST['color_card']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Texte der Card-Boxen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_card = " is-invalid";
	} else {
		$color_card = strip_tags($_POST['color_card']);
	}

	if(strlen($_POST['bgcolor_table']) < 1 || strlen($_POST['bgcolor_table']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Tabellen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_table = " is-invalid";
	} else {
		$bgcolor_table = strip_tags($_POST['bgcolor_table']);
	}

	if(strlen($_POST['bgcolor_table_head']) < 1 || strlen($_POST['bgcolor_table_head']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Tabellenkopfzeile auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_table_head = " is-invalid";
	} else {
		$bgcolor_table_head = strip_tags($_POST['bgcolor_table_head']);
	}

	if(strlen($_POST['color_table_head']) < 1 || strlen($_POST['color_table_head']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Tabellenkopfzeile auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_table_head = " is-invalid";
	} else {
		$color_table_head = strip_tags($_POST['color_table_head']);
	}

	if(strlen($_POST['color_link']) < 1 || strlen($_POST['color_link']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Links auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_link = " is-invalid";
	} else {
		$color_link = strip_tags($_POST['color_link']);
	}

	if(strlen($_POST['color_text']) < 1 || strlen($_POST['color_text']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für Text auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_text = " is-invalid";
	} else {
		$color_text = strip_tags($_POST['color_text']);
	}

	if(strlen($_POST['bgcolor_select']) < 1 || strlen($_POST['bgcolor_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_select = " is-invalid";
	} else {
		$bgcolor_select = strip_tags($_POST['bgcolor_select']);
	}

	if(strlen($_POST['color_select']) < 1 || strlen($_POST['color_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_select = " is-invalid";
	} else {
		$color_select = strip_tags($_POST['color_select']);
	}

	if(strlen($_POST['border_select']) < 1 || strlen($_POST['border_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Rahmenfarbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_border_select = " is-invalid";
	} else {
		$border_select = strip_tags($_POST['border_select']);
	}

	if(strlen($_POST['style']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein CSS-Theme einfügen. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = html_entity_decode($_POST['style']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`design_id`='0', 
										`admin`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $bgcolor_header_footer) . "', 
										`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $border_header_footer) . "', 
										`admin`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $bgcolor_navbar_burgermenu) . "', 
										`admin`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $bgcolor_badge) . "', 
										`admin`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $bgcolor_sidebar) . "', 
										`admin`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $bgcolor_card) . "', 
										`admin`.`color_card`='" . mysqli_real_escape_string($conn, $color_card) . "', 
										`admin`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $bgcolor_table) . "', 
										`admin`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $bgcolor_table_head) . "', 
										`admin`.`color_table_head`='" . mysqli_real_escape_string($conn, $color_table_head) . "', 
										`admin`.`color_link`='" . mysqli_real_escape_string($conn, $color_link) . "', 
										`admin`.`color_text`='" . mysqli_real_escape_string($conn, $color_text) . "', 
										`admin`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $bgcolor_select) . "', 
										`admin`.`color_select`='" . mysqli_real_escape_string($conn, $color_select) . "', 
										`admin`.`border_select`='" . mysqli_real_escape_string($conn, $border_select) . "', 
										`admin`.`style`='" . mysqli_real_escape_string($conn, $style) . "' 
								WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Der Style wurde erfolgreich geändert!<p>\n";

	}

}

if((isset($_POST['design']) && $_POST['design'] == "activate") || (isset($_POST['save']) && $_POST['save'] == "speichern")){

	if(isset($_POST['full_width']) && strlen($_POST['full_width']) > 1){
		$emsg .= "<span class=\"error\">Bitte die Layoutbreite angeben.</span><br />\n";
		$inp_full_width = " is-invalid";
	} else {
		$full_width = intval($_POST['full_width']);
	}

	if(strlen($_POST['bgcolor_header_footer']) < 1 || strlen($_POST['bgcolor_header_footer']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für den Header und Footer auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_header_footer = " is-invalid";
	} else {
		$bgcolor_header_footer = strip_tags($_POST['bgcolor_header_footer']);
	}

	if(strlen($_POST['border_header_footer']) < 1 || strlen($_POST['border_header_footer']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Rahmenfarbe für den Header und Footer auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_border_header_footer = " is-invalid";
	} else {
		$border_header_footer = strip_tags($_POST['border_header_footer']);
	}

	if(strlen($_POST['bgcolor_navbar_burgermenu']) < 1 || strlen($_POST['bgcolor_navbar_burgermenu']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für das Bürgermenü auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_navbar_burgermenu = " is-invalid";
	} else {
		$bgcolor_navbar_burgermenu = strip_tags($_POST['bgcolor_navbar_burgermenu']);
	}

	if(strlen($_POST['bgcolor_badge']) < 1 || strlen($_POST['bgcolor_badge']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Labelhilfe auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_badge = " is-invalid";
	} else {
		$bgcolor_badge = strip_tags($_POST['bgcolor_badge']);
	}

	if(strlen($_POST['bgcolor_sidebar']) < 1 || strlen($_POST['bgcolor_sidebar']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Sidebar auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_sidebar = " is-invalid";
	} else {
		$bgcolor_sidebar = strip_tags($_POST['bgcolor_sidebar']);
	}

	if(strlen($_POST['bgcolor_card']) < 1 || strlen($_POST['bgcolor_card']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Card-Boxen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_card = " is-invalid";
	} else {
		$bgcolor_card = strip_tags($_POST['bgcolor_card']);
	}

	if(strlen($_POST['color_card']) < 1 || strlen($_POST['color_card']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Texte der Card-Boxen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_card = " is-invalid";
	} else {
		$color_card = strip_tags($_POST['color_card']);
	}

	if(strlen($_POST['bgcolor_table']) < 1 || strlen($_POST['bgcolor_table']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Tabellen auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_table = " is-invalid";
	} else {
		$bgcolor_table = strip_tags($_POST['bgcolor_table']);
	}

	if(strlen($_POST['bgcolor_table_head']) < 1 || strlen($_POST['bgcolor_table_head']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für die Tabellenkopfzeile auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_table_head = " is-invalid";
	} else {
		$bgcolor_table_head = strip_tags($_POST['bgcolor_table_head']);
	}

	if(strlen($_POST['color_table_head']) < 1 || strlen($_POST['color_table_head']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Tabellenkopfzeile auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_table_head = " is-invalid";
	} else {
		$color_table_head = strip_tags($_POST['color_table_head']);
	}

	if(strlen($_POST['color_link']) < 1 || strlen($_POST['color_link']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für die Links auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_link = " is-invalid";
	} else {
		$color_link = strip_tags($_POST['color_link']);
	}

	if(strlen($_POST['color_text']) < 1 || strlen($_POST['color_text']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für Text auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_text = " is-invalid";
	} else {
		$color_text = strip_tags($_POST['color_text']);
	}

	if(strlen($_POST['bgcolor_select']) < 1 || strlen($_POST['bgcolor_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Hintergrundfarbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_bgcolor_select = " is-invalid";
	} else {
		$bgcolor_select = strip_tags($_POST['bgcolor_select']);
	}

	if(strlen($_POST['color_select']) < 1 || strlen($_POST['color_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Farbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_color_select = " is-invalid";
	} else {
		$color_select = strip_tags($_POST['color_select']);
	}

	if(strlen($_POST['border_select']) < 1 || strlen($_POST['border_select']) > 32){
		$emsg .= "<span class=\"error\">Bitte eine Rahmenfarbe für das Auswahlfeld auswählen. (max. 32 Zeichen)</span><br />\n";
		$inp_border_select = " is-invalid";
	} else {
		$border_select = strip_tags($_POST['border_select']);
	}

	if(strlen($_POST['style']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein CSS-Theme einfügen. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = html_entity_decode($_POST['style']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`design_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`admin`.`full_width`='" . mysqli_real_escape_string($conn, $full_width) . "', 
										`admin`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $bgcolor_header_footer) . "', 
										`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $border_header_footer) . "', 
										`admin`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $bgcolor_navbar_burgermenu) . "', 
										`admin`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $bgcolor_badge) . "', 
										`admin`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $bgcolor_sidebar) . "', 
										`admin`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $bgcolor_card) . "', 
										`admin`.`color_card`='" . mysqli_real_escape_string($conn, $color_card) . "', 
										`admin`.`border_header_footer`='" . mysqli_real_escape_string($conn, $border_header_footer) . "', 
										`admin`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $bgcolor_table) . "', 
										`admin`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $bgcolor_table_head) . "', 
										`admin`.`color_table_head`='" . mysqli_real_escape_string($conn, $color_table_head) . "', 
										`admin`.`color_link`='" . mysqli_real_escape_string($conn, $color_link) . "', 
										`admin`.`color_text`='" . mysqli_real_escape_string($conn, $color_text) . "', 
										`admin`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $bgcolor_select) . "', 
										`admin`.`color_select`='" . mysqli_real_escape_string($conn, $color_select) . "', 
										`admin`.`border_select`='" . mysqli_real_escape_string($conn, $border_select) . "', 
										`admin`.`style`='" . mysqli_real_escape_string($conn, $style) . "' 
								WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Der Style wurde erfolgreich geändert!<p>\n";

	}

}

if(isset($_POST['full_width']) && $_POST['full_width'] == "yes"){

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`full_width`='1' 
								WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Volle Breite wurde erfolgreich geändert!<p>\n";

	}

}

if(isset($_POST['full_width']) && $_POST['full_width'] == "no"){

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`admin` 
								SET 	`admin`.`full_width`='0' 
								WHERE 	`admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "' 
								AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Volle Breite wurde erfolgreich geändert!<p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . $_SESSION["admin"]["id"] . "'"), MYSQLI_ASSOC);

$_SESSION["admin"]["full_width"] = $row_item["full_width"];

$_SESSION["admin"]["bgcolor_header_footer"] = $row_item["bgcolor_header_footer"];

$_SESSION["admin"]["border_header_footer"] = $row_item["border_header_footer"];

$_SESSION["admin"]["bgcolor_navbar_burgermenu"] = $row_item["bgcolor_navbar_burgermenu"];

$_SESSION["admin"]["bgcolor_badge"] = $row_item["bgcolor_badge"];

$_SESSION["admin"]["bgcolor_sidebar"] = $row_item["bgcolor_sidebar"];

$_SESSION["admin"]["bgcolor_card"] = $row_item["bgcolor_card"];

$_SESSION["admin"]["color_card"] = $row_item["color_card"];

$_SESSION["admin"]["bgcolor_table"] = $row_item["bgcolor_table"];

$_SESSION["admin"]["bgcolor_table_head"] = $row_item["bgcolor_table_head"];

$_SESSION["admin"]["color_table_head"] = $row_item["color_table_head"];

$_SESSION["admin"]["color_link"] = $row_item["color_link"];

$_SESSION["admin"]["color_text"] = $row_item["color_text"];

$_SESSION["admin"]["bgcolor_select"] = $row_item["bgcolor_select"];

$_SESSION["admin"]["color_select"] = $row_item["color_select"];

$_SESSION["admin"]["border_select"] = $row_item["border_select"];

$_SESSION["admin"]["style"] = $row_item["style"];

$result = mysqli_query($conn, "	SELECT 		`rights`.`authorization` AS authorization 
								FROM 		`admin_role_rights` 
								LEFT JOIN 	`rights` 
								ON 			`rights`.`id`=`admin_role_rights`.`right_id` 
								WHERE 		`admin_role_rights`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`admin_role_rights`.`role_id`='" . mysqli_real_escape_string($conn, intval($row_item["role"])) . "' 
								AND 		`admin_role_rights`.`enable`='1' 
								ORDER BY 	CAST(`rights`.`area_id` AS UNSIGNED) ASC, CAST(`rights`.`pos` AS UNSIGNED) ASC");

while($row_rights = $result->fetch_array(MYSQLI_ASSOC)){

	$_SESSION["admin"]["roles"][$row_rights['authorization']] = 1;

}

$options_color_card = "";
$options_color_link = "";
$options_color_text = "";
$options_color_table_head = "";
$options_color_select = "";

foreach($colors as $key => $val){
	$options_color_card .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_card']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_card"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_color_link .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_link']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_link"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_color_text .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_text']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_text"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_color_table_head .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_table_head']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_table_head"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_color_select .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['color_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["color_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
}

$options_bgcolor_header_footer = "";
$options_bgcolor_navbar_burgermenu = "";
$options_bgcolor_badge = "";
$options_bgcolor_sidebar = "";
$options_bgcolor_card = "";
$options_bgcolor_table = "";
$options_bgcolor_table_head = "";
$options_bgcolor_select = "";

foreach($bgcolors as $key => $val){
	$options_bgcolor_header_footer .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_header_footer']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_header_footer"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_navbar_burgermenu .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_navbar_burgermenu']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_navbar_burgermenu"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_badge .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_badge']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_badge"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_sidebar .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_sidebar']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_sidebar"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_card .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_card']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_card"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_table .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_table']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_table"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_table_head .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_table_head']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_table_head"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_bgcolor_select .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['bgcolor_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["bgcolor_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
}

$options_border_header_footer = "";
$options_border_select = "";

foreach($bordercolors as $key => $val){
	$options_border_header_footer .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['border_header_footer']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["border_header_footer"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
	$options_border_select .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (strip_tags($_POST['border_select']) == $key ? " selected=\"selected\"" : "") : (strip_tags($row_item["border_select"]) == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";
}

$html_design = array(
	0 => "", 
	1 => ""
);

$where = 	isset($_SESSION[$style_session]["keyword"]) && $_SESSION[$style_session]["keyword"] != "" ? 
			"WHERE 	(`design`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$style_session]["keyword"]) . "%' 
			OR		`design`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$style_session]["keyword"]) . "%') " : 
			"WHERE 	`design`.`id`>0";

$query = "	SELECT 		* 
			FROM 		`design` 
			" . $where . "
			AND 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			AND 		`design`.`active`='1' 
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

while($row_design = $result->fetch_array(MYSQLI_ASSOC)){

	$badge_color_palette = "";

	$arr_colors = explode(",", str_replace(" ", "", $row_design['color_palette']));

	for($i = 0;$i < count($arr_colors) && $row_design['color_palette'] != "";$i++){

		$badge_color_palette .= $badge_color_palette == "" ? "<badge class=\"badge badge-secondary\" style=\"background-color: " . $arr_colors[$i] . "\">&nbsp;</badge>" : " <badge class=\"badge badge-secondary\" style=\"background-color: " . $arr_colors[$i] . "\">&nbsp;</badge>";

	}

	for($i = 0;$i < count($categories);$i++){

		if($row_design['category_id'] == $i){

			$html_design[$i] .= "<div class=\"col-sm-6 mb-4\">\n" . 
								"	<div class=\"row\">\n" . 
								"		<div class=\"col-sm-3\">\n" . 
								"			<h5 class=\"card-title font-weight-bold mt-2\" style=\"color: " . (isset($arr_colors[0]) ? $arr_colors[0] : "var(--primary)") . "\" title=\"" . $row_design['description'] . "\">" . $row_design['name'] . "</h5>\n" . 
								"		</div>\n" . 
								"		<div class=\"col-sm-3\">\n" . 
								"			<h6 class=\"card-text mt-2\">" . ($badge_color_palette == "" ? "&nbsp;" : $badge_color_palette) . "</h6>\n" . 
								"		</div>\n" . 
								"		<div class=\"col-sm-4 text-right\">\n" . 
								"			<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
								"				<input type=\"hidden\" name=\"id\" value=\"" . $row_design['id'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"full_width\" value=\"" . $row_design['full_width'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_header_footer\" value=\"" . $row_design['bgcolor_header_footer'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"border_header_footer\" value=\"" . $row_design['border_header_footer'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_navbar_burgermenu\" value=\"" . $row_design['bgcolor_navbar_burgermenu'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_badge\" value=\"" . $row_design['bgcolor_badge'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_sidebar\" value=\"" . $row_design['bgcolor_sidebar'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_card\" value=\"" . $row_design['bgcolor_card'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"color_card\" value=\"" . $row_design['color_card'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_table\" value=\"" . $row_design['bgcolor_table'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_table_head\" value=\"" . $row_design['bgcolor_table_head'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"color_table_head\" value=\"" . $row_design['color_table_head'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"color_link\" value=\"" . $row_design['color_link'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"color_text\" value=\"" . $row_design['color_text'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"bgcolor_select\" value=\"" . $row_design['bgcolor_select'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"color_select\" value=\"" . $row_design['color_select'] . "\" />\n" . 
								"				<input type=\"hidden\" name=\"border_select\" value=\"" . $row_design['border_select'] . "\" />\n" . 
								"				<textarea name=\"style\" class=\"d-none\">" . htmlentities($row_design['style']) . "</textarea>\n" . 
								"				<a href=\"/crm/style-vorschau/" . $row_design['id'] . "\" target=\"_blank\" class=\"btn btn-primary border border-dark\">Vorschau <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a>\n" . 
								"				<button type=\"submit\" name=\"design\" value=\"activate\" class=\"btn " . ($row_item['design_id'] == $row_design['id'] ? "btn-success" : "btn-secondary") . " border border-dark\">Aktivieren <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
								"			</form>\n" . 
								"		</div>\n" . 
								"		<div class=\"col-sm-2\">\n" . 
								"			&nbsp;\n" . 
								"		</div>\n" . 
								"	</div>\n" . 
								"</div>\n";

		}

	}

}

$html_designs = "";

for($i = 0;$i < count($categories);$i++){

	if($html_design[$i] != ""){

		$html_designs .= 	"		<div class=\"row\">\n" . 
							"			<div class=\"col-sm-12\">\n" . 
							"				<br />\n" . // "				<strong><u>" . $categories[$i] . "</u>:</strong>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 

							$html_design[$i] . 

							"		</div>\n";

	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Styles</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$style_session]['keyword']) && $_SESSION[$style_session]['keyword'] != "" ? $_SESSION[$style_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Wählen Sie hier ihre gewünschten Styles aus.</p>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<div class=\"row\">\n" . 
		"			<div class=\"col-sm-6\">\n" . 
		"				<h4 class=\"mt-1\">Style ändern</h4>\n" . 
		"			</div>\n" . 
		"			<div class=\"col-sm-6 text-right\">\n" . 
		"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
		"					<label class=\"col-form-label mr-2\">Layout volle Breite</label>\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<button type=\"submit\" name=\"full_width\" value=\"yes\" class=\"btn" . ($_SESSION["admin"]["full_width"] == 1 ? " btn-success border-success" : " btn-white border-danger") . "\">Ja</button>\n" . 
		"						<button type=\"submit\" name=\"full_width\" value=\"no\" class=\"btn" . ($_SESSION["admin"]["full_width"] == 0 ? " btn-danger border-danger" : " btn-white border-success") . "\">Nein</button>\n" . 
		"					</div>\n" . 
		"				</form>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		$pageNumberlist->getInfo() . 

		"<br />\n" . 

		$pageNumberlist->getNavi() . 

		$html_designs . 

		$pageNumberlist->getNavi() . 

		"		<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 

		"			<div class=\"form-group row\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"collapse\" data-target=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Individuelle Styleangaben <i class=\"fa fa-chevron-down\"></i></button>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"			<div id=\"collapseExample\" class=\"collapse bg-light border p-3\">\n" . 

		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"bgcolor_header_footer\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für den Header und Footer aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_header_footer\" name=\"bgcolor_header_footer\" class=\"custom-select select-colors" . $inp_bgcolor_header_footer . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_header_footer']) : strip_tags($row_item["bgcolor_header_footer"])) . "\" onchange=\"$('#bgcolor_header_footer').removeClass().addClass('form-control" . $inp_bgcolor_header_footer . " bg-'+$('#bgcolor_header_footer').val())\">" . $options_bgcolor_header_footer . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"border_header_footer\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für den Header und Footer aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"border_header_footer\" name=\"border_header_footer\" class=\"custom-select select-colors" . $inp_border_header_footer . " btn-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['border_header_footer']) : strip_tags($row_item["border_header_footer"])) . "\" onchange=\"$('#border_header_footer').removeClass().addClass('form-control" . $inp_border_header_footer . " btn-'+$('#border_header_footer').val())\">" . $options_border_header_footer . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"bgcolor_navbar_burgermenu\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Bürgermenü <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Bürgermenü aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_navbar_burgermenu\" name=\"bgcolor_navbar_burgermenu\" class=\"custom-select select-colors" . $inp_bgcolor_navbar_burgermenu . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_navbar_burgermenu']) : strip_tags($row_item["bgcolor_navbar_burgermenu"])) . "\" onchange=\"$('#bgcolor_navbar_burgermenu').removeClass().addClass('form-control" . $inp_bgcolor_navbar_burgermenu . " bg-'+$('#bgcolor_navbar_burgermenu').val())\">" . $options_bgcolor_navbar_burgermenu . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"bgcolor_badge\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Labelhilfe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Labelhilfe aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_badge\" name=\"bgcolor_badge\" class=\"custom-select select-colors" . $inp_bgcolor_badge . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_badge']) : strip_tags($row_item["bgcolor_badge"])) . "\" onchange=\"$('#bgcolor_badge').removeClass().addClass('form-control" . $inp_bgcolor_badge . " bg-'+$('#bgcolor_badge').val())\">" . $options_bgcolor_badge . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"bgcolor_sidebar\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Sidebar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Sidebar aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_sidebar\" name=\"bgcolor_sidebar\" class=\"custom-select select-colors" . $inp_bgcolor_sidebar . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_sidebar']) : strip_tags($row_item["bgcolor_sidebar"])) . "\" onchange=\"$('#bgcolor_sidebar').removeClass().addClass('form-control" . $inp_bgcolor_sidebar . " bg-'+$('#bgcolor_sidebar').val())\">" . $options_bgcolor_sidebar . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"bgcolor_card\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Card-Boxen aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_card\" name=\"bgcolor_card\" class=\"custom-select select-colors" . $inp_bgcolor_card . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_card']) : strip_tags($row_item["bgcolor_card"])) . "\" onchange=\"$('#bgcolor_card').removeClass().addClass('form-control" . $inp_bgcolor_card . " bg-'+$('#bgcolor_card').val())\">" . $options_bgcolor_card . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"color_card\" class=\"col-sm-3 col-form-label\">Farbe für die Texte der Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Texte der Card-Boxen aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"color_card\" name=\"color_card\" class=\"custom-select select-colors" . $inp_color_card . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_card']) : strip_tags($row_item["color_card"])) . "\" onchange=\"$('#color_card').removeClass().addClass('form-control" . $inp_color_card . " text-'+$('#color_card').val())\">" . $options_color_card . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"bgcolor_table\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellen aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_table\" name=\"bgcolor_table\" class=\"custom-select select-colors" . $inp_bgcolor_table . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_table']) : strip_tags($row_item["bgcolor_table"])) . "\" onchange=\"$('#bgcolor_table').removeClass().addClass('form-control" . $inp_bgcolor_table . " bg-'+$('#bgcolor_table').val())\">" . $options_bgcolor_table . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"bgcolor_table_head\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_table_head\" name=\"bgcolor_table_head\" class=\"custom-select select-colors" . $inp_bgcolor_table_head . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_table_head']) : strip_tags($row_item["bgcolor_table_head"])) . "\" onchange=\"$('#bgcolor_table_head').removeClass().addClass('form-control" . $inp_bgcolor_table_head . " bg-'+$('#bgcolor_table_head').val())\">" . $options_bgcolor_table_head . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"color_table_head\" class=\"col-sm-3 col-form-label\">Farbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"color_table_head\" name=\"color_table_head\" class=\"custom-select select-colors" . $inp_color_table_head . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_table_head']) : strip_tags($row_item["color_table_head"])) . "\" onchange=\"$('#color_table_head').removeClass().addClass('form-control" . $inp_color_table_head . " text-'+$('#color_table_head').val())\">" . $options_color_table_head . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"color_link\" class=\"col-sm-3 col-form-label\">Farbe für die Links <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Links aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"color_link\" name=\"color_link\" class=\"custom-select select-colors" . $inp_color_link . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_link']) : strip_tags($row_item["color_link"])) . "\" onchange=\"$('#color_link').removeClass().addClass('form-control" . $inp_color_link . " text-'+$('#color_link').val())\">" . $options_color_link . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"color_text\" class=\"col-sm-3 col-form-label\">Farbe für Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für Text aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"color_text\" name=\"color_text\" class=\"custom-select select-colors" . $inp_color_text . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_text']) : strip_tags($row_item["color_text"])) . "\" onchange=\"$('#color_text').removeClass().addClass('form-control" . $inp_color_text . " text-'+$('#color_text').val())\">" . $options_color_text . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"bgcolor_select\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"bgcolor_select\" name=\"bgcolor_select\" class=\"custom-select select-colors" . $inp_bgcolor_select . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_select']) : strip_tags($row_item["bgcolor_select"])) . "\" onchange=\"$('#bgcolor_select').removeClass().addClass('form-control" . $inp_bgcolor_select . " bg-'+$('#bgcolor_select').val())\">" . $options_bgcolor_select . "</select>\n" . 
		"						</div>\n" . 
		"						<label for=\"color_select\" class=\"col-sm-3 col-form-label\">Farbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für das Auswahlfeld aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"color_select\" name=\"color_select\" class=\"custom-select select-colors" . $inp_color_select . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_select']) : strip_tags($row_item["color_select"])) . "\" onchange=\"$('#color_select').removeClass().addClass('form-control" . $inp_color_select . " text-'+$('#color_select').val())\">" . $options_color_select . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"					<div class=\"form-group row\">\n" . 
		"						<label for=\"border_select\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
		"						<div class=\"col-sm-3\">\n" . 
		"							<select id=\"border_select\" name=\"border_select\" class=\"custom-select select-colors" . $inp_border_select . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['border_select']) : strip_tags($row_item["border_select"])) . "\" onchange=\"$('#border_select').removeClass().addClass('form-control" . $inp_border_select . " bg-'+$('#border_select').val())\">" . $options_border_select . "</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 

		"			</div>\n" . 

		"			<div class=\"form-group row\">\n" . 
		"				<label for=\"style\" class=\"col-sm-12 col-form-label\">CSS-Theme <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das CSS-Theme dieses Benutzers ändern.\">?</span></label>\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<textarea id=\"edit_style\" name=\"style\" class=\"" . $inp_style . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($style) : htmlentities($_SESSION["admin"]["style"])) . "</textarea>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"			<div class=\"row px-0 card-footer\">\n" . 
		"				<div class=\"col-sm-6\">\n" . 
		"					<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-6\" align=\"right\">\n" . 
		"					&nbsp;\n" . 
		"				</div>\n" . 
		"			</div>\n" . 

		"		</form>\n" . 

		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";
			
?>