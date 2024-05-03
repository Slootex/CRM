<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "design";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$design_session = "design_search";

if(isset($_POST["sorting_field"])){$_SESSION[$design_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$design_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$design_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$design_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$design_session]);
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

$sorting_field_name = isset($_SESSION[$design_session]["sorting_field"]) ? $sorting[$_SESSION[$design_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$design_session]["sorting_field"]) ? $_SESSION[$design_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$design_session]["sorting_direction"]) ? $directions[$_SESSION[$design_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$design_session]["sorting_direction"]) ? $_SESSION[$design_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$design_session]["rows"]) && $_SESSION[$design_session]["rows"] > 0 ? $_SESSION[$design_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

$inp_name = "";
$inp_description= "";
$inp_full_width = "";
$inp_bgcolor_header_footer = "";
$inp_border_header_footer = "";
$inp_bgcolor_navbar_burgermenu = "";
$inp_bgcolor_badge = "";
$inp_bgcolor_sidebar = "";
$inp_bgcolor_card = "";
$inp_color_card = "";
$inp_bgcolor_table = "";
$inp_bgcolor_table_head = "";
$inp_color_table_head = "";
$inp_color_link = "";
$inp_color_text = "";
$inp_bgcolor_select = "";
$inp_color_select = "";
$inp_border_select = "";
$inp_color_palette = "";
$inp_style = "";
$inp_active = "";

$name = "";
$description = "";
$full_width = 0;
$bgcolor_header_footer = "";
$border_header_footer = "";
$bgcolor_navbar_burgermenu = "";
$bgcolor_badge = "";
$bgcolor_sidebar = "";
$bgcolor_card = "";
$color_card = "";
$bgcolor_table = "";
$bgcolor_table_head = "";
$color_table_head = "";
$color_link = "";
$color_text = "";
$bgcolor_select = "";
$color_select = "";
$border_select = "";
$color_palette = "";
$style = "";
$active = "";

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

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$result = mysqli_query($conn, "SELECT * FROM `design` WHERE `design`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['name'])) . "' AND `design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$name = strip_tags($_POST['name']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Name eingeben. (max. 128 Zeichen)</span><br />\n";
			$inp_name = " is-invalid";
		}
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(isset($_POST['full_width']) && strlen($_POST['full_width']) > 1){
		$emsg .= "<span class=\"error\">Bitte Volle-Breite wählen.</span><br />\n";
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

	if(strlen($_POST['color_palette']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine Farbpalette einfügen. (max. 256 Zeichen)</span><br />\n";
		$inp_color_palette = " is-invalid";
	} else {
		$color_palette = strip_tags($_POST['color_palette']);
	}

	if(strlen($_POST['style']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein CSS-Theme einfügen. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = html_entity_decode($_POST['style']);
	}

	if(isset($_POST['active']) && strlen($_POST['active']) > 1){
		$emsg .= "<span class=\"error\">Bitte aktiv oder inaktiv wählen.</span><br />\n";
		$inp_active = " is-invalid";
	} else {
		$active = intval($_POST['active']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`design` 
								SET 	`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`design`.`category_id`='" . mysqli_real_escape_string($conn, (isset($_POST['category_id']) ? intval($_POST['category_id']) : 0)) . "', 
										`design`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`design`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`design`.`full_width`='" . mysqli_real_escape_string($conn, $full_width) . "', 
										`design`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $bgcolor_header_footer) . "', 
										`design`.`border_header_footer`='" . mysqli_real_escape_string($conn, $border_header_footer) . "', 
										`design`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $bgcolor_navbar_burgermenu) . "', 
										`design`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $bgcolor_badge) . "', 
										`design`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $bgcolor_sidebar) . "', 
										`design`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $bgcolor_card) . "', 
										`design`.`color_card`='" . mysqli_real_escape_string($conn, $color_card) . "', 
										`design`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $bgcolor_table) . "', 
										`design`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $bgcolor_table_head) . "', 
										`design`.`color_table_head`='" . mysqli_real_escape_string($conn, $color_table_head) . "', 
										`design`.`color_link`='" . mysqli_real_escape_string($conn, $color_link) . "', 
										`design`.`color_text`='" . mysqli_real_escape_string($conn, $color_text) . "', 
										`design`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $bgcolor_select) . "', 
										`design`.`color_select`='" . mysqli_real_escape_string($conn, $color_select) . "', 
										`design`.`border_select`='" . mysqli_real_escape_string($conn, $border_select) . "', 
										`design`.`color_palette`='" . mysqli_real_escape_string($conn, $color_palette) . "', 
										`design`.`style`='" . mysqli_real_escape_string($conn, $style) . "', 
										`design`.`active`='" . mysqli_real_escape_string($conn, $active) . "'");

		$_POST["id"] = $conn->insert_id;

		if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		}else{

			move_uploaded_file($_FILES['file']['tmp_name'], "img/crm/design_" . intval($_POST["id"]) . ".jpg");

		}

		$emsg = "<p>Das neue Design wurde erfolgreich hinzugefügt!</p>\n";

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
		$result = mysqli_query($conn, "	SELECT 	* 
										FROM 	`design` 
										WHERE 	`design`.`name`='" . mysqli_real_escape_string($conn, strip_tags($_POST['name'])) . "' 
										AND 	`design`.`id`!='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 	`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
		if($result->num_rows == 0){
			$name = strip_tags($_POST['name']);
		}else{
			$emsg .= "<span class=\"error\">Bitte einen anderen Name eingeben. (max. 128 Zeichen)</span><br />\n";
			$inp_name = " is-invalid";
		}
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte eine Beschreibung eingeben. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(isset($_POST['full_width']) && strlen($_POST['full_width']) > 1){
		$emsg .= "<span class=\"error\">Bitte eine Kennwort eingeben.</span><br />\n";
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

	if(strlen($_POST['color_palette']) > 256){
		$emsg .= "<span class=\"error\">Bitte eine Farbpalette einfügen. (max. 256 Zeichen)</span><br />\n";
		$inp_color_palette = " is-invalid";
	} else {
		$color_palette = strip_tags($_POST['color_palette']);
	}

	if(strlen($_POST['style']) > 4294967295){
		$emsg .= "<span class=\"error\">Bitte ein CSS-Theme einfügen. (max. 4294967295 Zeichen)</span><br />\n";
		$inp_style = " is-invalid";
	} else {
		$style = html_entity_decode($_POST['style']);
	}

	if(isset($_POST['active']) && strlen($_POST['active']) > 1){
		$emsg .= "<span class=\"error\">Bitte aktiv oder inaktiv wählen.</span><br />\n";
		$inp_active = " is-invalid";
	} else {
		$active = intval($_POST['active']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`design` 
								SET 	`design`.`category_id`='" . mysqli_real_escape_string($conn, (isset($_POST['category_id']) ? intval($_POST['category_id']) : 0)) . "', 
										`design`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`design`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`design`.`full_width`='" . mysqli_real_escape_string($conn, $full_width) . "', 
										`design`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $bgcolor_header_footer) . "', 
										`design`.`border_header_footer`='" . mysqli_real_escape_string($conn, $border_header_footer) . "', 
										`design`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $bgcolor_navbar_burgermenu) . "', 
										`design`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $bgcolor_badge) . "', 
										`design`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $bgcolor_sidebar) . "', 
										`design`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $bgcolor_card) . "', 
										`design`.`color_card`='" . mysqli_real_escape_string($conn, $color_card) . "', 
										`design`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $bgcolor_table) . "', 
										`design`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $bgcolor_table_head) . "', 
										`design`.`color_table_head`='" . mysqli_real_escape_string($conn, $color_table_head) . "', 
										`design`.`color_link`='" . mysqli_real_escape_string($conn, $color_link) . "', 
										`design`.`color_text`='" . mysqli_real_escape_string($conn, $color_text) . "', 
										`design`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $bgcolor_select) . "', 
										`design`.`color_select`='" . mysqli_real_escape_string($conn, $color_select) . "', 
										`design`.`border_select`='" . mysqli_real_escape_string($conn, $border_select) . "', 
										`design`.`color_palette`='" . mysqli_real_escape_string($conn, $color_palette) . "', 
										`design`.`style`='" . mysqli_real_escape_string($conn, $style) . "', 
										`design`.`active`='" . mysqli_real_escape_string($conn, $active) . "' 
								WHERE 	`design`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		}else{

			move_uploaded_file($_FILES['file']['tmp_name'], "img/crm/design_" . intval($_POST["id"]) . ".jpg");

		}

		$emsg = "<p>Das Design wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`design` 
							WHERE 		`design`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	@unlink("img/crm/design_" . intval($_POST['id']) . ".jpg");

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){
		$emsg .= "<span class=\"error\">Bitte eine design.csv wählen.</span><br />\n";
	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 24){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`design` 
													SET 	`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`design`.`category_id`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`design`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`design`.`description`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`design`.`full_width`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`design`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`design`.`border_header_footer`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`design`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`design`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`design`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`design`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`design`.`color_card`='" . mysqli_real_escape_string($conn, $data[12]) . "', 
															`design`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`design`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`design`.`color_table_head`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`design`.`color_link`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`design`.`color_text`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`design`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`design`.`color_select`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`design`.`border_select`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`design`.`color_palette`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`design`.`style`='" . mysqli_real_escape_string($conn, $data[22]) . "', 
															`design`.`active`='" . mysqli_real_escape_string($conn, $data[23]) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`design` 
													SET 	`design`.`category_id`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`design`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`design`.`description`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`design`.`full_width`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`design`.`bgcolor_header_footer`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`design`.`border_header_footer`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`design`.`bgcolor_navbar_burgermenu`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`design`.`bgcolor_badge`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`design`.`bgcolor_sidebar`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`design`.`bgcolor_card`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`design`.`color_card`='" . mysqli_real_escape_string($conn, $data[12]) . "', 
															`design`.`bgcolor_table`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`design`.`bgcolor_table_head`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`design`.`color_table_head`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`design`.`color_link`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`design`.`color_text`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`design`.`bgcolor_select`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`design`.`color_select`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`design`.`border_select`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`design`.`color_palette`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`design`.`style`='" . mysqli_real_escape_string($conn, $data[22]) . "', 
															`design`.`active`='" . mysqli_real_escape_string($conn, $data[23]) . "' 
													WHERE 	`design`.`id`='" . intval($data[0]) . "' 
													AND 	`design`.`company_id`='" . intval($_SESSION["admin"]["company_id"]) . "'");

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

$where = 	isset($_SESSION[$design_session]["keyword"]) && $_SESSION[$design_session]["keyword"] != "" ? 
			"WHERE 	(`design`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$design_session]["keyword"]) . "%' 
			OR		`design`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$design_session]["keyword"]) . "%') " : 
			"WHERE 	`design`.`id`>0";

$query = 	"	SELECT 		* 
				FROM 		`design` 
				" . $where . "
				AND 		`design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

	$badge_color_palette = "";

	$arr_colors = explode(",", str_replace(" ", "", $row_item['color_palette']));

	for($i = 0;$i < count($arr_colors) && $row_item['color_palette'] != "";$i++){

		$badge_color_palette .= $badge_color_palette == "" ? "<badge class=\"badge badge-secondary\" style=\"background-color: " . $arr_colors[$i] . "\">&nbsp;</badge>" : " <badge class=\"badge badge-secondary\" style=\"background-color: " . $arr_colors[$i] . "\">&nbsp;</badge>";

	}

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row_item['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span class=\"" . ($row_item['category_id'] == 0 ? "text-danger" : "text-success") . "\">" . $categories[$row_item['category_id']] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\">\n" . 
				"			<span>" . $row_item['description'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $badge_color_palette . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . ($row_item['style'] == "" ? "Nein" : "Ja") . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . ($row_item['full_width'] == 1 ? "Volle Breite" : "Normal") . "</span>\n" . 
				"		</td>\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . ($row_item['active'] == 1 ? "Ja" : "Nein") . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\" class=\"text-center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Admin - Design</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$design_session]['keyword']) && $_SESSION[$design_session]['keyword'] != "" ? $_SESSION[$design_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Designs bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">Design hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/design-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
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
			"			<th width=\"160\" scope=\"col\">\n" . 
			"				<strong>Kategorie</strong>\n" . 
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
			"				<div class=\"d-block text-nowrap\">\n" . 
			"					<div class=\"d-inline\">\n" . 
			"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
			"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
			"						</div>\n" . 
			"					</div>\n" . 
			"					<div class=\"d-inline text-nowrap\"><strong>Beschreibung</strong></div>\n" . 
			"				</div>\n" . 
			"			</th>\n" . 
			"			<th width=\"150\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Farbpalette</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"110\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>CSS-Theme</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Layout</strong>\n" . 
			"			</th>\n" . 
			"			<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
			"				<strong>Aktiv</strong>\n" . 
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

	$options_categories = "";

	for($i = 0;$i < count($categories);$i++){

		$options_categories .= "								<option value=\"" . $i . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['category_id']) && intval($_POST['category_id']) == $i ? " selected=\"selected\"" : "") : "") . ">" . $categories[$i] . "</option>\n";

	}

	$options_color_card = "";
	$options_color_link = "";
	$options_color_text = "";
	$options_color_table_head = "";
	$options_color_select = "";

	foreach($colors as $key => $val){
		$options_color_card .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_card']) && strip_tags($_POST['color_card']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_color_link .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_link']) && strip_tags($_POST['color_link']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_color_text .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_text']) && strip_tags($_POST['color_text']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_color_table_head .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_table_head']) && strip_tags($_POST['color_table_head']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_color_select .= "								<option value=\"" . $key . "\" class=\"text-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_select']) && strip_tags($_POST['color_select']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
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
		$options_bgcolor_header_footer .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_header_footer']) && strip_tags($_POST['bgcolor_header_footer']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_navbar_burgermenu .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_navbar_burgermenu']) && strip_tags($_POST['bgcolor_navbar_burgermenu']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_badge .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_badge']) && strip_tags($_POST['bgcolor_badge']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_sidebar .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_sidebar']) && strip_tags($_POST['bgcolor_sidebar']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_card .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_card']) && strip_tags($_POST['bgcolor_card']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_table .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_table']) && strip_tags($_POST['bgcolor_table']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_table_head .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_table_head']) && strip_tags($_POST['bgcolor_table_head']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_bgcolor_select .= "								<option value=\"" . $key . "\" class=\"bg-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_select']) && strip_tags($_POST['bgcolor_select']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
	}

	$options_border_header_footer = "";
	$options_border_select = "";

	foreach($bordercolors as $key => $val){
		$options_border_header_footer .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['border_header_footer']) && strip_tags($_POST['border_header_footer']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
		$options_border_select .= "								<option value=\"" . $key . "\" class=\"btn-" . $key . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['border_select']) && strip_tags($_POST['border_select']) == $key ? " selected=\"selected\"" : "") : "") . ">" . $val . "</option>\n";
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

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"category_id\" class=\"col-sm-3 col-form-label\">Kategorie <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Kategorie aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"category_id\" name=\"category_id\" class=\"custom-select\">" . $options_categories . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie den Name des Designs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Beschreibung des Designs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"description\" name=\"description\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $description : "") . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Layout volle Breite <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob das Layout in voller Breite dargestellt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"full_width\" name=\"full_width\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $_POST['full_width'] : intval(isset($_POST['full_width']) ? $_POST['full_width'] : 0)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label font-weight-light\" for=\"full_width\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_header_footer\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für den Header und Footer aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_header_footer\" name=\"bgcolor_header_footer\" class=\"custom-select" . $inp_bgcolor_header_footer . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_header_footer']) && strip_tags($_POST['bgcolor_header_footer']) != "" ? strip_tags($_POST['bgcolor_header_footer']) : "") : "") . "\" onchange=\"$('#bgcolor_header_footer').removeClass().addClass('form-control" . $inp_bgcolor_header_footer . " bg-'+$('#bgcolor_header_footer').val())\">" . $options_bgcolor_header_footer . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"border_header_footer\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für den Header und Footer aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"border_header_footer\" name=\"border_header_footer\" class=\"custom-select" . $inp_border_header_footer . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_header_footer']) && strip_tags($_POST['border_header_footer']) != "" ? strip_tags($_POST['border_header_footer']) : "") : "") . "\" onchange=\"$('#border_header_footer').removeClass().addClass('form-control" . $inp_border_header_footer . " bg-'+$('#border_header_footer').val())\">" . $options_border_header_footer . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_navbar_burgermenu\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Bürgermenü <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Bürgermenü aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_navbar_burgermenu\" name=\"bgcolor_navbar_burgermenu\" class=\"custom-select" . $inp_bgcolor_navbar_burgermenu . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_navbar_burgermenu']) && strip_tags($_POST['bgcolor_navbar_burgermenu']) != "" ? strip_tags($_POST['bgcolor_navbar_burgermenu']) : "") : "") . "\" onchange=\"$('#bgcolor_navbar_burgermenu').removeClass().addClass('form-control" . $inp_bgcolor_navbar_burgermenu . " bg-'+$('#bgcolor_header_footer').val())\">" . $options_bgcolor_navbar_burgermenu . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_badge\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Labelhilfe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Labelhilfe aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_badge\" name=\"bgcolor_badge\" class=\"custom-select" . $inp_bgcolor_badge . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_badge']) && strip_tags($_POST['bgcolor_badge']) != "" ? strip_tags($_POST['bgcolor_badge']) : "") : "") . "\" onchange=\"$('#bgcolor_badge').removeClass().addClass('form-control" . $inp_bgcolor_badge . " bg-'+$('#bgcolor_badge').val())\">" . $options_bgcolor_badge . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_sidebar\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Sidebar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für den Header und Footer aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_sidebar\" name=\"bgcolor_sidebar\" class=\"custom-select" . $inp_bgcolor_sidebar . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_sidebar']) && strip_tags($_POST['bgcolor_sidebar']) != "" ? strip_tags($_POST['bgcolor_sidebar']) : "") : "") . "\" onchange=\"$('#bgcolor_sidebar').removeClass().addClass('form-control" . $inp_bgcolor_sidebar . " bg-'+$('#bgcolor_sidebar').val())\">" . $options_bgcolor_sidebar . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_card\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Card-Boxen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_card\" name=\"bgcolor_card\" class=\"custom-select" . $inp_bgcolor_card . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_card']) && strip_tags($_POST['bgcolor_card']) != "" ? strip_tags($_POST['bgcolor_card']) : "") : "") . "\" onchange=\"$('#bgcolor_card').removeClass().addClass('form-control" . $inp_bgcolor_card . " bg-'+$('#bgcolor_card').val())\">" . $options_bgcolor_card . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_card\" class=\"col-sm-3 col-form-label\">Farbe für die Texte der Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Texte der Card-Boxen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_card\" name=\"color_card\" class=\"custom-select" . $inp_color_card . " text-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_card']) && strip_tags($_POST['color_card']) != "" ? strip_tags($_POST['color_card']) : "") : "") . "\" onchange=\"$('#color_card').removeClass().addClass('form-control" . $inp_color_card . " text-'+$('#color_card').val())\">" . $options_color_card . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_table\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_table\" name=\"bgcolor_table\" class=\"custom-select" . $inp_bgcolor_table . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_table']) && strip_tags($_POST['bgcolor_table']) != "" ? strip_tags($_POST['bgcolor_table']) : "") : "") . "\" onchange=\"$('#bgcolor_table').removeClass().addClass('form-control" . $inp_bgcolor_table . " bg-'+$('#bgcolor_table').val())\">" . $options_bgcolor_table . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_table_head\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_table_head\" name=\"bgcolor_table_head\" class=\"custom-select" . $inp_bgcolor_table_head . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_table_head']) && strip_tags($_POST['bgcolor_table_head']) != "" ? strip_tags($_POST['bgcolor_table_head']) : "") : "") . "\" onchange=\"$('#bgcolor_table_head').removeClass().addClass('form-control" . $inp_bgcolor_table_head . " bg-'+$('#bgcolor_table_head').val())\">" . $options_bgcolor_table_head . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_table_head\" class=\"col-sm-3 col-form-label\">Farbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_table_head\" name=\"color_table_head\" class=\"custom-select" . $inp_color_table_head . " text-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_table_head']) && strip_tags($_POST['color_table_head']) != "" ? strip_tags($_POST['color_table_head']) : "") : "") . "\" onchange=\"$('#color_table_head').removeClass().addClass('form-control" . $inp_color_table_head . " text-'+$('#color_table_head').val())\">" . $options_color_table_head . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_link\" class=\"col-sm-3 col-form-label\">Farbe für die Links <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Links aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_link\" name=\"color_link\" class=\"custom-select" . $inp_color_link . " text-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_link']) && strip_tags($_POST['color_link']) != "" ? strip_tags($_POST['color_link']) : "") : "") . "\" onchange=\"$('#color_link').removeClass().addClass('form-control" . $inp_color_link . " text-'+$('#color_link').val())\">" . $options_color_link . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_text\" class=\"col-sm-3 col-form-label\">Farbe für Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für Text aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_text\" name=\"color_text\" class=\"custom-select" . $inp_color_text . " text-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_text']) && strip_tags($_POST['color_text']) != "" ? strip_tags($_POST['color_text']) : "") : "") . "\" onchange=\"$('#color_text').removeClass().addClass('form-control" . $inp_color_text . " text-'+$('#color_text').val())\">" . $options_color_text . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_select\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_select\" name=\"bgcolor_select\" class=\"custom-select" . $inp_bgcolor_select . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['bgcolor_select']) && strip_tags($_POST['bgcolor_select']) != "" ? strip_tags($_POST['bgcolor_select']) : "") : "") . "\" onchange=\"$('#bgcolor_select').removeClass().addClass('form-control" . $inp_bgcolor_select . " bg-'+$('#bgcolor_select').val())\">" . $options_bgcolor_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_select\" class=\"col-sm-3 col-form-label\">Farbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_select\" name=\"color_select\" class=\"custom-select" . $inp_color_select . " text-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['color_select']) && strip_tags($_POST['color_select']) != "" ? strip_tags($_POST['color_select']) : "") : "") . "\" onchange=\"$('#color_select').removeClass().addClass('form-control" . $inp_color_select . " text-'+$('#color_select').val())\">" . $options_color_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"border_select\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"border_select\" name=\"border_select\" class=\"custom-select" . $inp_border_select . " bg-" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['border_select']) && strip_tags($_POST['border_select']) != "" ? strip_tags($_POST['border_select']) : "") : "") . "\" onchange=\"$('#border_select').removeClass().addClass('form-control" . $inp_border_select . " bg-'+$('#border_select').val())\">" . $options_border_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_palette\" class=\"col-sm-3 col-form-label\">Farbpalette <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie die Farbpalette des Designs ein. (primary, secondary, success, danger, info, warning, light, dark)\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"color_palette\" name=\"color_palette\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $color_palette : "") . "\" class=\"form-control" . $inp_color_palette . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"style\" class=\"col-sm-3 col-form-label\">CSS-Theme <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier fügen Sie das CSS-Theme des Designs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"edit_content\" name=\"style\" class=\"" . $inp_style . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? htmlentities($style) : "") . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Bilddatei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Bilddatei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Aktiv <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob das Design aktiv und sichtbar sein soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"active\" name=\"active\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? $_POST['active'] : intval(isset($_POST['active']) ? $_POST['active'] : 0)) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label font-weight-light\" for=\"active\">\n" . 
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

	$row_item = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `design` WHERE `design`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `design`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$options_categories = "";

	for($i = 0;$i < count($categories);$i++){

		$options_categories .= "								<option value=\"" . $i . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['category_id']) == $i ? " selected=\"selected\"" : "") : (intval($row_item["category_id"]) == $i ? " selected=\"selected\"" : "")) . ">" . $categories[$i] . "</option>\n";

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

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"category_id\" class=\"col-sm-3 col-form-label\">Kategorie <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Kategorie aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"category_id\" name=\"category_id\" class=\"custom-select\">" . $options_categories . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Designs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row_item["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Beschreibung <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das Beschreibung dieses Designs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"description\" name=\"description\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $description : strip_tags($row_item["description"])) . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Layout volle Breite <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob das Layout in voller Breite dargestellt werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"full_width\" name=\"full_width\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $full_width : intval($row_item['full_width'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label font-weight-light\" for=\"full_width\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_header_footer\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für den Header und Footer aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_header_footer\" name=\"bgcolor_header_footer\" class=\"custom-select" . $inp_bgcolor_header_footer . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_header_footer']) : strip_tags($row_item["bgcolor_header_footer"])) . "\" onchange=\"$('#bgcolor_header_footer').removeClass().addClass('form-control" . $inp_bgcolor_header_footer . " bg-'+$('#bgcolor_header_footer').val())\">" . $options_bgcolor_header_footer . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"border_header_footer\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für den Header und Footer <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für den Header und Footer aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"border_header_footer\" name=\"border_header_footer\" class=\"custom-select" . $inp_border_header_footer . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['border_header_footer']) : strip_tags($row_item["border_header_footer"])) . "\" onchange=\"$('#border_header_footer').removeClass().addClass('form-control" . $inp_border_header_footer . " bg-'+$('#border_header_footer').val())\">" . $options_border_header_footer . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_navbar_burgermenu\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Bürgermenü <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Bürgermenü aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_navbar_burgermenu\" name=\"bgcolor_navbar_burgermenu\" class=\"custom-select select-colors" . $inp_bgcolor_navbar_burgermenu . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_navbar_burgermenu']) : strip_tags($row_item["bgcolor_navbar_burgermenu"])) . "\" onchange=\"$('#bgcolor_navbar_burgermenu').removeClass().addClass('form-control" . $inp_bgcolor_navbar_burgermenu . " bg-'+$('#bgcolor_navbar_burgermenu').val())\">" . $options_bgcolor_navbar_burgermenu . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_badge\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Labelhilfe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Labelhilfe aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_badge\" name=\"bgcolor_badge\" class=\"custom-select select-colors" . $inp_bgcolor_badge . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_badge']) : strip_tags($row_item["bgcolor_badge"])) . "\" onchange=\"$('#bgcolor_badge').removeClass().addClass('form-control" . $inp_bgcolor_badge . " bg-'+$('#bgcolor_badge').val())\">" . $options_bgcolor_badge . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_sidebar\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Sidebar <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Sidebar aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_sidebar\" name=\"bgcolor_sidebar\" class=\"custom-select" . $inp_bgcolor_sidebar . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_sidebar']) : strip_tags($row_item["bgcolor_sidebar"])) . "\" onchange=\"$('#bgcolor_sidebar').removeClass().addClass('form-control" . $inp_bgcolor_sidebar . " bg-'+$('#bgcolor_sidebar').val())\">" . $options_bgcolor_sidebar . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_card\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Card-Boxen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_card\" name=\"bgcolor_card\" class=\"custom-select" . $inp_bgcolor_card . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_card']) : strip_tags($row_item["bgcolor_card"])) . "\" onchange=\"$('#bgcolor_card').removeClass().addClass('form-control" . $inp_bgcolor_card . " bg-'+$('#bgcolor_card').val())\">" . $options_bgcolor_card . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_card\" class=\"col-sm-3 col-form-label\">Farbe für die Texte der Card-Boxen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Texte der Card-Boxen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_card\" name=\"color_card\" class=\"custom-select" . $inp_color_card . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_card']) : strip_tags($row_item["color_card"])) . "\" onchange=\"$('#color_card').removeClass().addClass('form-control" . $inp_color_card . " text-'+$('#color_card').val())\">" . $options_color_card . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_table\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellen <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellen aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_table\" name=\"bgcolor_table\" class=\"custom-select" . $inp_bgcolor_table . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_table']) : strip_tags($row_item["bgcolor_table"])) . "\" onchange=\"$('#bgcolor_table').removeClass().addClass('form-control" . $inp_bgcolor_table . " bg-'+$('#bgcolor_table').val())\">" . $options_bgcolor_table . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_table_head\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_table_head\" name=\"bgcolor_table_head\" class=\"custom-select" . $inp_bgcolor_table_head . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_table_head']) : strip_tags($row_item["bgcolor_table_head"])) . "\" onchange=\"$('#bgcolor_table_head').removeClass().addClass('form-control" . $inp_bgcolor_table_head . " bg-'+$('#bgcolor_table_head').val())\">" . $options_bgcolor_table_head . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_table_head\" class=\"col-sm-3 col-form-label\">Farbe für die Tabellenkopfzeile <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Tabellenkopfzeile aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_table_head\" name=\"color_table_head\" class=\"custom-select" . $inp_color_table_head . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_table_head']) : strip_tags($row_item["color_table_head"])) . "\" onchange=\"$('#color_table_head').removeClass().addClass('form-control" . $inp_color_table_head . " text-'+$('#color_table_head').val())\">" . $options_color_table_head . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_link\" class=\"col-sm-3 col-form-label\">Farbe für die Links <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für die Links aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_link\" name=\"color_link\" class=\"custom-select" . $inp_color_link . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_link']) : strip_tags($row_item["color_link"])) . "\" onchange=\"$('#color_link').removeClass().addClass('form-control" . $inp_color_link . " text-'+$('#color_link').val())\">" . $options_color_link . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_text\" class=\"col-sm-3 col-form-label\">Farbe für Text <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für Text aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_text\" name=\"color_text\" class=\"custom-select" . $inp_color_text . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_text']) : strip_tags($row_item["color_text"])) . "\" onchange=\"$('#color_text').removeClass().addClass('form-control" . $inp_color_text . " text-'+$('#color_text').val())\">" . $options_color_text . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"bgcolor_select\" class=\"col-sm-3 col-form-label\">Hintergrundfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Hintergrundfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"bgcolor_select\" name=\"bgcolor_select\" class=\"custom-select select-colors" . $inp_bgcolor_select . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['bgcolor_select']) : strip_tags($row_item["bgcolor_select"])) . "\" onchange=\"$('#bgcolor_select').removeClass().addClass('form-control" . $inp_bgcolor_select . " bg-'+$('#bgcolor_select').val())\">" . $options_bgcolor_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_select\" class=\"col-sm-3 col-form-label\">Farbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Farbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"color_select\" name=\"color_select\" class=\"custom-select select-colors" . $inp_color_select . " text-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['color_select']) : strip_tags($row_item["color_select"])) . "\" onchange=\"$('#color_select').removeClass().addClass('form-control" . $inp_color_select . " text-'+$('#color_select').val())\">" . $options_color_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"border_select\" class=\"col-sm-3 col-form-label\">Rahmenfarbe für das Auswahlfeld <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie eine Rahmenfarbe für das Auswahlfeld aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"border_select\" name=\"border_select\" class=\"custom-select select-colors" . $inp_border_select . " bg-" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? strip_tags($_POST['border_select']) : strip_tags($row_item["border_select"])) . "\" onchange=\"$('#border_select').removeClass().addClass('form-control" . $inp_border_select . " bg-'+$('#border_select').val())\">" . $options_border_select . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color_palette\" class=\"col-sm-3 col-form-label\">Farbpalette <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Farbpalette dieses Designs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"color_palette\" name=\"color_palette\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $color_palette : strip_tags($row_item["color_palette"])) . "\" class=\"form-control" . $inp_color_palette . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"style\" class=\"col-sm-3 col-form-label\">CSS-Theme <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie das CSS-Theme dieses Designs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<textarea id=\"edit_content\" name=\"style\" class=\"" . $inp_style . "\" style=\"width: 100%;height: 400px\">" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? htmlentities($style) : htmlentities($row_item["style"])) . "</textarea>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Bilddatei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Bilddatei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Aktiv <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob das Design aktiv und sichtbar sein soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"active\" name=\"active\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $active : intval($row_item['active'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label font-weight-light\" for=\"active\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
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
				"						<label class=\"col-sm-3 col-form-label\">Mode <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Mode ändern.\">?</span></label>\n" . 
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