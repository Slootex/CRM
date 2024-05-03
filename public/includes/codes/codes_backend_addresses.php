<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "address_addresses";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$addresses_session = "addresses_search";

if(isset($_POST["sorting_field"])){$_SESSION[$addresses_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$addresses_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$addresses_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$addresses_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$addresses_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Kürzel", 
	"value" => "`address_addresses`.`shortcut`"
);
$sorting[] = array(
	"name" => "Firma", 
	"value" => "`address_addresses`.`companyname`"
);
$sorting[] = array(
	"name" => "Name", 
	"value" => "`address_addresses`.`firstname`"
);
$sorting[] = array(
	"name" => "Nachname", 
	"value" => "`address_addresses`.`lastname`"
);
$sorting[] = array(
	"name" => "Straße", 
	"value" => "`address_addresses`.`street`"
);
$sorting[] = array(
	"name" => "Hausnummer", 
	"value" => "`address_addresses`.`streetno`"
);
$sorting[] = array(
	"name" => "Postleitzahl", 
	"value" => "`address_addresses`.`zipcode`"
);
$sorting[] = array(
	"name" => "Stadt", 
	"value" => "`address_addresses`.`city`"
);
$sorting[] = array(
	"name" => "Land", 
	"value" => "country_name"
);
$sorting[] = array(
	"name" => "Telefon", 
	"value" => "`address_addresses`.`phonenumber`"
);
$sorting[] = array(
	"name" => "Mobil", 
	"value" => "`address_addresses`.`mobilnumber`"
);
$sorting[] = array(
	"name" => "Email", 
	"value" => "`address_addresses`.`email`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`address_addresses`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$addresses_session]["sorting_field"]) ? $sorting[$_SESSION[$addresses_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$addresses_session]["sorting_field"]) ? $_SESSION[$addresses_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$addresses_session]["sorting_direction"]) ? $directions[$_SESSION[$addresses_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$addresses_session]["sorting_direction"]) ? $_SESSION[$addresses_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$addresses_session]["rows"]) && $_SESSION[$addresses_session]["rows"] > 0 ? $_SESSION[$addresses_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$show_autocomplete_script = 0;

$countryToId = "";

$time = time();

$emsg = "";
$emsg_pickup = "";

$inp_shortcut = "";
$inp_companyname = "";
$inp_gender = "";
$inp_firstname = "";
$inp_lastname = "";
$inp_street = "";
$inp_streetno = "";
$inp_zipcode = "";
$inp_city = "";
$inp_country = "";
$inp_phonenumber = "";
$inp_mobilnumber = "";
$inp_email = "";
$inp_readytime_hours = "";
$inp_readytime_minutes = "";
$inp_closetime_hours = "";
$inp_closetime_minutes = "";
$inp_weight = "";
$inp_quantity = "";
$inp_servicecode = "";

$inp_pickup_readytime_hours = "";
$inp_pickup_readytime_minutes = "";
$inp_pickup_closetime_hours = "";
$inp_pickup_closetime_minutes = "";
$inp_pickup_companyname = "";
$inp_pickup_contactname = "";
$inp_pickup_addressline = "";
$inp_pickup_postalcode = "";
$inp_pickup_city = "";
$inp_pickup_countrycode = "";
$inp_pickup_email = "";
$inp_pickup_phone = "";
$inp_pickup_room = "";
$inp_pickup_floor = "";
$inp_pickup_pickuppoint = "";
$inp_pickup_weight = "";
$inp_pickup_servicecode = "";
$inp_pickup_paymentmethod = "";

$shortcut = "";
$companyname = "";
$gender = 0;
$firstname = "";
$lastname = "";
$street = "";
$streetno = "";
$zipcode = "";
$city = "";
$country = 0;
$phonenumber = "";
$mobilnumber = "";
$email = "";
$readytime_hours = "10";
$readytime_minutes = "00";
$closetime_hours = "18";
$closetime_minutes = "00";
$weight = 5.0;
$quantity = 1;
$servicecode = "011";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Adress-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_shortcut = " is-invalid";
	} else {
		$shortcut = strip_tags($_POST['shortcut']);
	}

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anrede aus.</small><br />\n";
		$inp_gender = " is-invalid";
	} else {
		$gender = intval($_POST['gender']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['readytime_hours']) < 2 || strlen($_POST['readytime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Stunden auswählen.</small><br />\n";
		$inp_readytime_hours = " is-invalid";
	} else {
		$readytime_hours = strip_tags($_POST['readytime_hours']);
	}

	if(strlen($_POST['readytime_minutes']) < 2 || strlen($_POST['readytime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Minuten auswählen.</small><br />\n";
		$inp_readytime_minutes = " is-invalid";
	} else {
		$readytime_minutes = strip_tags($_POST['readytime_minutes']);
	}

	if(strlen($_POST['closetime_hours']) < 2 || strlen($_POST['closetime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Stunden auswählen.</small><br />\n";
		$inp_closetime_hours = " is-invalid";
	} else {
		$closetime_hours = strip_tags($_POST['closetime_hours']);
	}

	if(strlen($_POST['closetime_minutes']) < 2 || strlen($_POST['closetime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Minuten auswählen.</small><br />\n";
		$inp_closetime_minutes = " is-invalid";
	} else {
		$closetime_minutes = strip_tags($_POST['closetime_minutes']);
	}

	if(strlen($_POST['weight']) < 1 || strlen($_POST['weight']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Gewicht an. (max. 13 Zeichen)</small><br />\n";
		$inp_weight = " is-invalid";
	} else {
		$weight = floatval(str_replace(",", ".", $_POST['weight']));
	}

	if(strlen($_POST['quantity']) < 1 || strlen($_POST['quantity']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anzahl an Gesamtpakete aus.</small><br />\n";
		$inp_quantity = " is-invalid";
	} else {
		$quantity = strip_tags($_POST['quantity']);
	}

	if(strlen($_POST['servicecode']) < 3 || strlen($_POST['servicecode']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Service aus.</small><br />\n";
		$inp_servicecode = " is-invalid";
	} else {
		$servicecode = strip_tags($_POST['servicecode']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`address_addresses` 
								SET 	`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`address_addresses`.`admin_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
										`address_addresses`.`shortcut`='" . mysqli_real_escape_string($conn, $shortcut) . "', 
										`address_addresses`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`address_addresses`.`gender`='" . mysqli_real_escape_string($conn, $gender) . "', 
										`address_addresses`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`address_addresses`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`address_addresses`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`address_addresses`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`address_addresses`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`address_addresses`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`address_addresses`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`address_addresses`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`address_addresses`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`address_addresses`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`address_addresses`.`readytime_hours`='" . mysqli_real_escape_string($conn, $readytime_hours) . "', 
										`address_addresses`.`readytime_minutes`='" . mysqli_real_escape_string($conn, $readytime_minutes) . "', 
										`address_addresses`.`closetime_hours`='" . mysqli_real_escape_string($conn, $closetime_hours) . "', 
										`address_addresses`.`closetime_minutes`='" . mysqli_real_escape_string($conn, $closetime_minutes) . "', 
										`address_addresses`.`weight`='" . mysqli_real_escape_string($conn, $weight) . "', 
										`address_addresses`.`quantity`='" . mysqli_real_escape_string($conn, $quantity) . "', 
										`address_addresses`.`servicecode`='" . mysqli_real_escape_string($conn, $servicecode) . "'");

		$_POST["id"] = $conn->insert_id;

		$_POST['edit'] = "bearbeiten";

		$emsg = "<p>Die neue Adresse wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['shortcut']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Adress-Kürzel ein. (max. 256 Zeichen)</small><br />\n";
		$inp_shortcut = " is-invalid";
	} else {
		$shortcut = strip_tags($_POST['shortcut']);
	}

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anrede aus.</small><br />\n";
		$inp_gender = " is-invalid";
	} else {
		$gender = intval($_POST['gender']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['readytime_hours']) < 2 || strlen($_POST['readytime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Stunden auswählen.</small><br />\n";
		$inp_readytime_hours = " is-invalid";
	} else {
		$readytime_hours = strip_tags($_POST['readytime_hours']);
	}

	if(strlen($_POST['readytime_minutes']) < 2 || strlen($_POST['readytime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-von-Minuten auswählen.</small><br />\n";
		$inp_readytime_minutes = " is-invalid";
	} else {
		$readytime_minutes = strip_tags($_POST['readytime_minutes']);
	}

	if(strlen($_POST['closetime_hours']) < 2 || strlen($_POST['closetime_hours']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Stunden auswählen.</small><br />\n";
		$inp_closetime_hours = " is-invalid";
	} else {
		$closetime_hours = strip_tags($_POST['closetime_hours']);
	}

	if(strlen($_POST['closetime_minutes']) < 2 || strlen($_POST['closetime_minutes']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte die Zeitraum-bis-Minuten auswählen.</small><br />\n";
		$inp_closetime_minutes = " is-invalid";
	} else {
		$closetime_minutes = strip_tags($_POST['closetime_minutes']);
	}

	if(strlen($_POST['weight']) < 1 || strlen($_POST['weight']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Gewicht an. (max. 13 Zeichen)</small><br />\n";
		$inp_weight = " is-invalid";
	} else {
		$weight = floatval(str_replace(",", ".", $_POST['weight']));
	}

	if(strlen($_POST['quantity']) < 1 || strlen($_POST['quantity']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Anzahl an Gesamtpakete aus.</small><br />\n";
		$inp_quantity = " is-invalid";
	} else {
		$quantity = strip_tags($_POST['quantity']);
	}

	if(strlen($_POST['servicecode']) < 3 || strlen($_POST['servicecode']) > 3){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Service aus.</small><br />\n";
		$inp_servicecode = " is-invalid";
	} else {
		$servicecode = strip_tags($_POST['servicecode']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`address_addresses` 
								SET 	`address_addresses`.`shortcut`='" . mysqli_real_escape_string($conn, $shortcut) . "', 
										`address_addresses`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`address_addresses`.`gender`='" . mysqli_real_escape_string($conn, $gender) . "', 
										`address_addresses`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`address_addresses`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`address_addresses`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`address_addresses`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`address_addresses`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`address_addresses`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`address_addresses`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`address_addresses`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`address_addresses`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`address_addresses`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`address_addresses`.`readytime_hours`='" . mysqli_real_escape_string($conn, $readytime_hours) . "', 
										`address_addresses`.`readytime_minutes`='" . mysqli_real_escape_string($conn, $readytime_minutes) . "', 
										`address_addresses`.`closetime_hours`='" . mysqli_real_escape_string($conn, $closetime_hours) . "', 
										`address_addresses`.`closetime_minutes`='" . mysqli_real_escape_string($conn, $closetime_minutes) . "', 
										`address_addresses`.`weight`='" . mysqli_real_escape_string($conn, $weight) . "', 
										`address_addresses`.`quantity`='" . mysqli_real_escape_string($conn, $quantity) . "', 
										`address_addresses`.`servicecode`='" . mysqli_real_escape_string($conn, $servicecode) . "' 
								WHERE 	`address_addresses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Die Adresse wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`address_addresses` 
							WHERE 		`address_addresses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){
		$emsg .= "<span class=\"error\">Bitte eine addresses.csv wählen.</span><br />\n";
	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 23){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`address_addresses` 
													SET 	`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`address_addresses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`address_addresses`.`shortcut`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`address_addresses`.`companyname`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`address_addresses`.`gender`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`address_addresses`.`firstname`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`address_addresses`.`lastname`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`address_addresses`.`street`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`address_addresses`.`streetno`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`address_addresses`.`zipcode`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`address_addresses`.`city`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`address_addresses`.`country`='" . mysqli_real_escape_string($conn, intval($data[12])) . "', 
															`address_addresses`.`phonenumber`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`address_addresses`.`mobilnumber`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`address_addresses`.`email`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`address_addresses`.`readytime_hours`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`address_addresses`.`readytime_minutes`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`address_addresses`.`closetime_hours`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`address_addresses`.`closetime_minutes`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`address_addresses`.`weight`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`address_addresses`.`quantity`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`address_addresses`.`servicecode`='" . mysqli_real_escape_string($conn, $data[22]) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`address_addresses` 
													SET 	`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`address_addresses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($data[2])) . "', 
															`address_addresses`.`shortcut`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`address_addresses`.`companyname`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`address_addresses`.`gender`='" . mysqli_real_escape_string($conn, intval($data[5])) . "', 
															`address_addresses`.`firstname`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`address_addresses`.`lastname`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`address_addresses`.`street`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`address_addresses`.`streetno`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`address_addresses`.`zipcode`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`address_addresses`.`city`='" . mysqli_real_escape_string($conn, $data[11]) . "', 
															`address_addresses`.`country`='" . mysqli_real_escape_string($conn, intval($data[12])) . "', 
															`address_addresses`.`phonenumber`='" . mysqli_real_escape_string($conn, $data[13]) . "', 
															`address_addresses`.`mobilnumber`='" . mysqli_real_escape_string($conn, $data[14]) . "', 
															`address_addresses`.`email`='" . mysqli_real_escape_string($conn, $data[15]) . "', 
															`address_addresses`.`readytime_hours`='" . mysqli_real_escape_string($conn, $data[16]) . "', 
															`address_addresses`.`readytime_minutes`='" . mysqli_real_escape_string($conn, $data[17]) . "', 
															`address_addresses`.`closetime_hours`='" . mysqli_real_escape_string($conn, $data[18]) . "', 
															`address_addresses`.`closetime_minutes`='" . mysqli_real_escape_string($conn, $data[19]) . "', 
															`address_addresses`.`weight`='" . mysqli_real_escape_string($conn, $data[20]) . "', 
															`address_addresses`.`quantity`='" . mysqli_real_escape_string($conn, $data[21]) . "', 
															`address_addresses`.`servicecode`='" . mysqli_real_escape_string($conn, $data[22]) . "' 
													WHERE 	`address_addresses`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

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

$and = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`address_addresses`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `address_addresses`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$where = 	isset($_SESSION[$addresses_session]["keyword"]) && $_SESSION[$addresses_session]["keyword"] != "" ? 
			"WHERE 	(`address_addresses`.`shortcut` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%' 
			OR		`address_addresses`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%'
			OR		`address_addresses`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$addresses_session]["keyword"]) . "%') " : 
			"WHERE 	`address_addresses`.`id`>0";

$query = "	SELECT 		*, 
						(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`id`=`address_addresses`.`admin_id`) AS admin_name, 
						(SELECT `countries`.`name` AS name FROM `countries` WHERE `countries`.`id`=`address_addresses`.`country`) AS countryname 
			FROM 		`address_addresses` 
			" . $where . " 
			AND 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			" . $and . " 
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
				"			<span>" . $row['shortcut'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $row['admin_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . ($row['companyname'] != "" ? $row['companyname'] . ", " : "") . ($row['gender'] == 0 ? "Herr" : "Frau") . " " . $row['firstname'] . " " . $row['lastname'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<a href=\"http://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&z=14&iwloc=A&q=" . urlencode($row['street'] . " " . $row['streetno'] . " " . $row['zipcode'] . " " . $row['city'] . " " . $row['countryname']) . "\" target=\"_blank\">" . $row['street'] . " " . $row['streetno'] . ", " . $row['zipcode'] . " " . $row['city'] . " " . $row['countryname'] . " <i class=\"fa fa-external-link\"> </i></a>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<a href=\"mailto: " . $row['email'] . "\"" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"text-white\"" : " class=\"text-primary\"") . ">" . $row['email'] . " <i class=\"fa fa-envelope-o\"> </i></a>\n" . 
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
		"		<h3>Einstellungen - Adressen</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$addresses_session]['keyword']) && $_SESSION[$addresses_session]['keyword'] != "" ? $_SESSION[$addresses_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"<p>Hier können Sie die Adressen bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 
		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/adressen-herunterladen\" class=\"btn btn-primary\">herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
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
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Kürzel</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"200\" scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"300\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Firma, Name</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th align=\"center\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(4, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(4, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Anschrift</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th align=\"center\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(11, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(11, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>E-Mail</strong></div>\n" . 
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

	$show_autocomplete_script = 1;

	$options_admin_id = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['admin_id']) && intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

	}

	$options_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['country']) && intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";

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
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"shortcut\" name=\"shortcut\" value=\"" . $shortcut . "\" class=\"form-control" . $inp_shortcut . "\" placeholder=\"Kürzel\" />\n" . 
				"						</div>\n" . 

				($_SESSION["admin"]["id"] == $maindata['admin_id'] ? 
					"						<div class=\"col-sm-1\">\n" . 
					"							&nbsp;\n" . 
					"						</div>\n" . 
					"						<label class=\"col-sm-3 col-form-label text-right\">\n" . 
					"							Verwendet von: \n" . 
					"						</label>\n" . 
					"						<div class=\"col-sm-4\">\n" . 
					"							<select id=\"admin_id\" name=\"admin_id\" class=\"custom-select\">\n" . 
					$options_admin_id . 
					"							</select>\n" . 
					"						</div>\n" 
				: 
					"						<div class=\"col-sm-4\">\n" . 
					"							&nbsp;\n" . 
					"						</div>\n" . 
					"						<div class=\"col-sm-4\">\n" . 
					"							<input type=\"hidden\" name=\"admin_id\" value=\"" . $_SESSION["admin"]["id"] . "\" />\n" . 
					"						</div>\n"
				) . 

				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"0\"" . ($gender == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"									Herr\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"1\"" . ($gender == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"									Frau\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"readytime_hours\" class=\"col-sm-3 col-form-label\">Abholzeit</label>\n" . 
				"						<div class=\"col-sm-2\">\n" . 
				"							<div class=\"input-group border rounded\">\n" . 
				"								<select id=\"readytime_hours\" name=\"readytime_hours\" class=\"custom-select border-0" . $inp_readytime_hours . "\" onchange=\"setToTimeAfter2Hours()\">\n" . 
				"									<option value=\"00\"" . ($readytime_hours == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ($readytime_hours == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ($readytime_hours == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ($readytime_hours == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ($readytime_hours == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ($readytime_hours == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ($readytime_hours == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ($readytime_hours == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ($readytime_hours == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ($readytime_hours == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ($readytime_hours == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ($readytime_hours == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ($readytime_hours == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ($readytime_hours == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ($readytime_hours == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ($readytime_hours == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ($readytime_hours == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ($readytime_hours == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ($readytime_hours == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ($readytime_hours == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ($readytime_hours == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ($readytime_hours == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ($readytime_hours == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ($readytime_hours == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"								</select>\n" . 
				"								<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
				"								<select id=\"readytime_minutes\" name=\"readytime_minutes\" class=\"custom-select border-0" . $inp_readytime_minutes . "\" onchange=\"setToTimeAfter2Hours()\">\n" . 
				"									<option value=\"00\"" . ($readytime_minutes == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ($readytime_minutes == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ($readytime_minutes == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ($readytime_minutes == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ($readytime_minutes == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ($readytime_minutes == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ($readytime_minutes == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ($readytime_minutes == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ($readytime_minutes == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ($readytime_minutes == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ($readytime_minutes == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ($readytime_minutes == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ($readytime_minutes == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ($readytime_minutes == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ($readytime_minutes == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ($readytime_minutes == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ($readytime_minutes == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ($readytime_minutes == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ($readytime_minutes == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ($readytime_minutes == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ($readytime_minutes == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ($readytime_minutes == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ($readytime_minutes == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ($readytime_minutes == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"									<option value=\"24\"" . ($readytime_minutes == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
				"									<option value=\"25\"" . ($readytime_minutes == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
				"									<option value=\"26\"" . ($readytime_minutes == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
				"									<option value=\"27\"" . ($readytime_minutes == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
				"									<option value=\"28\"" . ($readytime_minutes == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
				"									<option value=\"29\"" . ($readytime_minutes == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
				"									<option value=\"30\"" . ($readytime_minutes == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
				"									<option value=\"31\"" . ($readytime_minutes == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
				"									<option value=\"32\"" . ($readytime_minutes == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
				"									<option value=\"33\"" . ($readytime_minutes == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
				"									<option value=\"34\"" . ($readytime_minutes == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
				"									<option value=\"35\"" . ($readytime_minutes == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
				"									<option value=\"36\"" . ($readytime_minutes == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
				"									<option value=\"37\"" . ($readytime_minutes == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
				"									<option value=\"38\"" . ($readytime_minutes == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
				"									<option value=\"39\"" . ($readytime_minutes == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
				"									<option value=\"40\"" . ($readytime_minutes == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"									<option value=\"41\"" . ($readytime_minutes == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
				"									<option value=\"42\"" . ($readytime_minutes == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
				"									<option value=\"43\"" . ($readytime_minutes == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
				"									<option value=\"44\"" . ($readytime_minutes == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
				"									<option value=\"45\"" . ($readytime_minutes == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
				"									<option value=\"46\"" . ($readytime_minutes == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
				"									<option value=\"47\"" . ($readytime_minutes == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
				"									<option value=\"48\"" . ($readytime_minutes == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
				"									<option value=\"49\"" . ($readytime_minutes == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
				"									<option value=\"50\"" . ($readytime_minutes == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"									<option value=\"51\"" . ($readytime_minutes == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
				"									<option value=\"52\"" . ($readytime_minutes == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
				"									<option value=\"53\"" . ($readytime_minutes == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
				"									<option value=\"54\"" . ($readytime_minutes == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
				"									<option value=\"55\"" . ($readytime_minutes == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
				"									<option value=\"56\"" . ($readytime_minutes == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
				"									<option value=\"57\"" . ($readytime_minutes == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
				"									<option value=\"58\"" . ($readytime_minutes == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
				"									<option value=\"59\"" . ($readytime_minutes == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
				"								</select>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</label>\n" . 
				"						<div class=\"col-sm-2\">\n" . 
				"							<div class=\"input-group border rounded\">\n" . 
				"								<select id=\"closetime_hours\" name=\"closetime_hours\" class=\"custom-select border-0" . $inp_closetime_hours . "\">\n" . 
				"									<option value=\"00\"" . ($closetime_hours == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ($closetime_hours == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ($closetime_hours == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ($closetime_hours == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ($closetime_hours == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ($closetime_hours == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ($closetime_hours == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ($closetime_hours == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ($closetime_hours == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ($closetime_hours == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ($closetime_hours == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ($closetime_hours == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ($closetime_hours == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ($closetime_hours == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ($closetime_hours == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ($closetime_hours == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ($closetime_hours == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ($closetime_hours == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ($closetime_hours == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ($closetime_hours == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ($closetime_hours == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ($closetime_hours == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ($closetime_hours == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ($closetime_hours == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"								</select>\n" . 
				"								<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
				"								<select id=\"closetime_minutes\" name=\"closetime_minutes\" class=\"custom-select border-0" . $inp_closetime_minutes . "\">\n" . 
				"									<option value=\"00\"" . ($closetime_minutes == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ($closetime_minutes == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ($closetime_minutes == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ($closetime_minutes == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ($closetime_minutes == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ($closetime_minutes == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ($closetime_minutes == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ($closetime_minutes == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ($closetime_minutes == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ($closetime_minutes == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ($closetime_minutes == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ($closetime_minutes == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ($closetime_minutes == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ($closetime_minutes == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ($closetime_minutes == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ($closetime_minutes == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ($closetime_minutes == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ($closetime_minutes == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ($closetime_minutes == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ($closetime_minutes == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ($closetime_minutes == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ($closetime_minutes == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ($closetime_minutes == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ($closetime_minutes == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"									<option value=\"24\"" . ($closetime_minutes == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
				"									<option value=\"25\"" . ($closetime_minutes == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
				"									<option value=\"26\"" . ($closetime_minutes == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
				"									<option value=\"27\"" . ($closetime_minutes == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
				"									<option value=\"28\"" . ($closetime_minutes == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
				"									<option value=\"29\"" . ($closetime_minutes == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
				"									<option value=\"30\"" . ($closetime_minutes == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
				"									<option value=\"31\"" . ($closetime_minutes == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
				"									<option value=\"32\"" . ($closetime_minutes == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
				"									<option value=\"33\"" . ($closetime_minutes == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
				"									<option value=\"34\"" . ($closetime_minutes == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
				"									<option value=\"35\"" . ($closetime_minutes == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
				"									<option value=\"36\"" . ($closetime_minutes == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
				"									<option value=\"37\"" . ($closetime_minutes == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
				"									<option value=\"38\"" . ($closetime_minutes == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
				"									<option value=\"39\"" . ($closetime_minutes == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
				"									<option value=\"40\"" . ($closetime_minutes == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"									<option value=\"41\"" . ($closetime_minutes == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
				"									<option value=\"42\"" . ($closetime_minutes == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
				"									<option value=\"43\"" . ($closetime_minutes == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
				"									<option value=\"44\"" . ($closetime_minutes == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
				"									<option value=\"45\"" . ($closetime_minutes == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
				"									<option value=\"46\"" . ($closetime_minutes == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
				"									<option value=\"47\"" . ($closetime_minutes == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
				"									<option value=\"48\"" . ($closetime_minutes == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
				"									<option value=\"49\"" . ($closetime_minutes == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
				"									<option value=\"50\"" . ($closetime_minutes == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"									<option value=\"51\"" . ($closetime_minutes == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
				"									<option value=\"52\"" . ($closetime_minutes == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
				"									<option value=\"53\"" . ($closetime_minutes == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
				"									<option value=\"54\"" . ($closetime_minutes == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
				"									<option value=\"55\"" . ($closetime_minutes == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
				"									<option value=\"56\"" . ($closetime_minutes == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
				"									<option value=\"57\"" . ($closetime_minutes == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
				"									<option value=\"58\"" . ($closetime_minutes == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
				"									<option value=\"59\"" . ($closetime_minutes == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
				"								</select>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-2 mt-4\">\n" . 
				"							<label>Uhr</label>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"weight\" class=\"col-sm-3 col-form-label\">Gesamtgewicht</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<div class=\"input-group date\">\n" . 
				"								<input type=\"number\" id=\"weight\" name=\"weight\" min=\"0.0\" step=\"0.1\" value=\"" . number_format($weight, 1, ',', '') . "\" placeholder=\"5,0\" class=\"form-control" . $inp_weight . "\" />\n" . 
				"								<div class=\"input-group-append\">\n" . 
				"									<span class=\"input-group-text\">kg</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6 mt-1 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"quantity\" class=\"col-sm-3 col-form-label\">Gesamtpakete</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<div class=\"input-group date\">\n" . 
				"								<input type=\"number\" id=\"quantity\" name=\"quantity\" min=\"0\" step=\"1\" value=\"" . $quantity . "\" placeholder=\"1\" class=\"form-control" . $inp_quantity . "\" />\n" . 
				"								<div class=\"input-group-append\">\n" . 
				"									<span class=\"input-group-text\">Stück</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6 mt-1 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"servicecode\" class=\"col-sm-3 col-form-label\">Service</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"servicecode\" name=\"servicecode\" class=\"custom-select" . $inp_servicecode . "\">\n" . 
				"								<option value=\"001\"" . ($servicecode == "001" ? " selected=\"selected\"" : "") . ">UPS Next Day Air</option>\n" . 
				"								<option value=\"002\"" . ($servicecode == "002" ? " selected=\"selected\"" : "") . ">UPS 2nd Day Air</option>\n" . 
				"								<option value=\"003\"" . ($servicecode == "003" ? " selected=\"selected\"" : "") . ">UPS Ground</option>\n" . 
				"								<option value=\"004\"" . ($servicecode == "004" ? " selected=\"selected\"" : "") . ">UPS Ground, UPS Standard</option>\n" . 
				"								<option value=\"007\"" . ($servicecode == "007" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express</option>\n" . 
				"								<option value=\"008\"" . ($servicecode == "008" ? " selected=\"selected\"" : "") . ">UPS Worldwide Expedited</option>\n" . 
				"								<option value=\"011\"" . ($servicecode == "011" ? " selected=\"selected\"" : "") . ">UPS Standard</option>\n" . 
				"								<option value=\"012\"" . ($servicecode == "012" ? " selected=\"selected\"" : "") . ">UPS 3 Day Select</option>\n" . 
				"								<option value=\"013\"" . ($servicecode == "013" ? " selected=\"selected\"" : "") . ">UPS Next Day Air Saver</option>\n" . 
				"								<option value=\"014\"" . ($servicecode == "014" ? " selected=\"selected\"" : "") . ">UPS Next Day Air Early</option>\n" . 
				"								<option value=\"021\"" . ($servicecode == "021" ? " selected=\"selected\"" : "") . ">UPS Economy</option>\n" . 
				"								<option value=\"031\"" . ($servicecode == "031" ? " selected=\"selected\"" : "") . ">UPS Basic</option>\n" . 
				"								<option value=\"054\"" . ($servicecode == "054" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Plus</option>\n" . 
				"								<option value=\"059\"" . ($servicecode == "059" ? " selected=\"selected\"" : "") . ">UPS 2nd Day Air A.M.</option>\n" . 
				"								<option value=\"064\"" . ($servicecode == "064" ? " selected=\"selected\"" : "") . ">UPS Express NA1</option>\n" . 
				"								<option value=\"065\"" . ($servicecode == "065" ? " selected=\"selected\"" : "") . ">UPS Saver</option>\n" . 
				"								<option value=\"071\"" . ($servicecode == "071" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Freight Midday</option>\n" . 
				"								<option value=\"074\"" . ($servicecode == "074" ? " selected=\"selected\"" : "") . ">UPS Express 12:00</option>\n" . 
				"								<option value=\"082\"" . ($servicecode == "082" ? " selected=\"selected\"" : "") . ">UPS Standard Today</option>\n" . 
				"								<option value=\"083\"" . ($servicecode == "083" ? " selected=\"selected\"" : "") . ">UPS Today Dedicated Courier</option>\n" . 
				"								<option value=\"084\"" . ($servicecode == "084" ? " selected=\"selected\"" : "") . ">UPS Intercity Today</option>\n" . 
				"								<option value=\"085\"" . ($servicecode == "085" ? " selected=\"selected\"" : "") . ">UPS Today Express</option>\n" . 
				"								<option value=\"086\"" . ($servicecode == "086" ? " selected=\"selected\"" : "") . ">UPS Today Express Saver</option>\n" . 
				"								<option value=\"096\"" . ($servicecode == "096" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Freight</option>\n" . 
				"							</select>\n" . 
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

	$show_autocomplete_script = 1;

	$row_address = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$options_admin_id = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_address["admin_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$options_countries = "";

	$options_countrycode_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];

		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_address["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

		$options_countrycode_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['pickup']) && $_POST['pickup'] == "NEUE ABHOLUNG" ? (intval($_POST['countrycode']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_address["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

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
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"shortcut\" name=\"shortcut\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $shortcut : $row_address["shortcut"]) . "\" class=\"form-control" . $inp_shortcut . "\" placeholder=\"Kürzel\" />\n" . 
				"						</div>\n" . 

				($_SESSION["admin"]["id"] == $maindata['admin_id'] ? 
					"						<div class=\"col-sm-1\">\n" . 
					"							&nbsp;\n" . 
					"						</div>\n" . 
					"						<div class=\"col-sm-3 mt-1 text-right\">\n" . 
					"							Verwendet von: \n" . 
					"						</div>\n" . 
					"						<div class=\"col-sm-4\">\n" . 
					"							<select id=\"admin_id\" name=\"admin_id\" class=\"custom-select\">\n" . 
					$options_admin_id . 
					"							</select>\n" . 
					"						</div>\n"
				: 
					"						<div class=\"col-sm-4\">\n" . 
					"							&nbsp;\n" . 
					"						</div>\n" . 
					"						<div class=\"col-sm-4\">\n" . 
					"							<input type=\"hidden\" name=\"admin_id\" value=\"" . $_SESSION["admin"]["id"] . "\" />\n" . 
					"						</div>\n"
				) . 

				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $companyname : $row_address["companyname"]) . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $gender : $row_address["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"									Herr\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $gender : $row_address["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"									Frau\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $firstname : $row_address["firstname"]) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $lastname : $row_address["lastname"]) . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-9\">\n" . 
				"							<input type=\"text\" id=\"route\" name=\"street\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $street : $row_address["street"]) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $streetno : $row_address["streetno"]) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $zipcode : $row_address["zipcode"]) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $city : $row_address["city"]) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : $row_address["email"]) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $mobilnumber : $row_address["mobilnumber"]) . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $phonenumber : $row_address["phonenumber"]) . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"readytime_hours\" class=\"col-sm-3 col-form-label\">Abholzeit</label>\n" . 
				"						<div class=\"col-sm-2\">\n" . 
				"							<div class=\"input-group border rounded\">\n" . 
				"								<select id=\"readytime_hours\" name=\"readytime_hours\" class=\"custom-select border-0" . $inp_readytime_hours . "\" onchange=\"setToTimeAfter2Hours()\">\n" . 
				"									<option value=\"00\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_hours : $row_address["readytime_hours"]) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"								</select>\n" . 
				"								<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
				"								<select id=\"readytime_minutes\" name=\"readytime_minutes\" class=\"custom-select border-0" . $inp_readytime_minutes . "\" onchange=\"setToTimeAfter2Hours()\">\n" . 
				"									<option value=\"00\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"									<option value=\"24\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
				"									<option value=\"25\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
				"									<option value=\"26\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
				"									<option value=\"27\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
				"									<option value=\"28\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
				"									<option value=\"29\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
				"									<option value=\"30\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
				"									<option value=\"31\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
				"									<option value=\"32\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
				"									<option value=\"33\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
				"									<option value=\"34\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
				"									<option value=\"35\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
				"									<option value=\"36\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
				"									<option value=\"37\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
				"									<option value=\"38\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
				"									<option value=\"39\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
				"									<option value=\"40\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"									<option value=\"41\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
				"									<option value=\"42\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
				"									<option value=\"43\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
				"									<option value=\"44\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
				"									<option value=\"45\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
				"									<option value=\"46\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
				"									<option value=\"47\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
				"									<option value=\"48\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
				"									<option value=\"49\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
				"									<option value=\"50\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"									<option value=\"51\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
				"									<option value=\"52\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
				"									<option value=\"53\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
				"									<option value=\"54\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
				"									<option value=\"55\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
				"									<option value=\"56\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
				"									<option value=\"57\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
				"									<option value=\"58\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
				"									<option value=\"59\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $readytime_minutes : $row_address["readytime_minutes"]) == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
				"								</select>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<label class=\"col-sm-1 col-form-label\">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</label>\n" . 
				"						<div class=\"col-sm-2\">\n" . 
				"							<div class=\"input-group border rounded\">\n" . 
				"								<select id=\"closetime_hours\" name=\"closetime_hours\" class=\"custom-select border-0" . $inp_closetime_hours . "\">\n" . 
				"									<option value=\"00\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_hours : $row_address["closetime_hours"]) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"								</select>\n" . 
				"								<span class=\"mt-1\">&nbsp;:&nbsp;</span>\n" . 
				"								<select id=\"closetime_minutes\" name=\"closetime_minutes\" class=\"custom-select border-0" . $inp_closetime_minutes . "\">\n" . 
				"									<option value=\"00\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "00" ? " selected=\"selected\"" : "") . ">00</option>\n" . 
				"									<option value=\"01\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "01" ? " selected=\"selected\"" : "") . ">01</option>\n" . 
				"									<option value=\"02\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "02" ? " selected=\"selected\"" : "") . ">02</option>\n" . 
				"									<option value=\"03\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "03" ? " selected=\"selected\"" : "") . ">03</option>\n" . 
				"									<option value=\"04\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "04" ? " selected=\"selected\"" : "") . ">04</option>\n" . 
				"									<option value=\"05\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "05" ? " selected=\"selected\"" : "") . ">05</option>\n" . 
				"									<option value=\"06\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "06" ? " selected=\"selected\"" : "") . ">06</option>\n" . 
				"									<option value=\"07\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "07" ? " selected=\"selected\"" : "") . ">07</option>\n" . 
				"									<option value=\"08\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "08" ? " selected=\"selected\"" : "") . ">08</option>\n" . 
				"									<option value=\"09\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "09" ? " selected=\"selected\"" : "") . ">09</option>\n" . 
				"									<option value=\"10\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "10" ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"									<option value=\"11\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "11" ? " selected=\"selected\"" : "") . ">11</option>\n" . 
				"									<option value=\"12\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "12" ? " selected=\"selected\"" : "") . ">12</option>\n" . 
				"									<option value=\"13\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "13" ? " selected=\"selected\"" : "") . ">13</option>\n" . 
				"									<option value=\"14\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "14" ? " selected=\"selected\"" : "") . ">14</option>\n" . 
				"									<option value=\"15\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "15" ? " selected=\"selected\"" : "") . ">15</option>\n" . 
				"									<option value=\"16\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "16" ? " selected=\"selected\"" : "") . ">16</option>\n" . 
				"									<option value=\"17\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "17" ? " selected=\"selected\"" : "") . ">17</option>\n" . 
				"									<option value=\"18\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "18" ? " selected=\"selected\"" : "") . ">18</option>\n" . 
				"									<option value=\"19\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "19" ? " selected=\"selected\"" : "") . ">19</option>\n" . 
				"									<option value=\"20\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "20" ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"									<option value=\"21\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "21" ? " selected=\"selected\"" : "") . ">21</option>\n" . 
				"									<option value=\"22\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "22" ? " selected=\"selected\"" : "") . ">22</option>\n" . 
				"									<option value=\"23\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "23" ? " selected=\"selected\"" : "") . ">23</option>\n" . 
				"									<option value=\"24\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "24" ? " selected=\"selected\"" : "") . ">24</option>\n" . 
				"									<option value=\"25\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "25" ? " selected=\"selected\"" : "") . ">25</option>\n" . 
				"									<option value=\"26\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "26" ? " selected=\"selected\"" : "") . ">26</option>\n" . 
				"									<option value=\"27\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "27" ? " selected=\"selected\"" : "") . ">27</option>\n" . 
				"									<option value=\"28\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "28" ? " selected=\"selected\"" : "") . ">28</option>\n" . 
				"									<option value=\"29\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "29" ? " selected=\"selected\"" : "") . ">29</option>\n" . 
				"									<option value=\"30\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "30" ? " selected=\"selected\"" : "") . ">30</option>\n" . 
				"									<option value=\"31\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "31" ? " selected=\"selected\"" : "") . ">31</option>\n" . 
				"									<option value=\"32\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "32" ? " selected=\"selected\"" : "") . ">32</option>\n" . 
				"									<option value=\"33\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "33" ? " selected=\"selected\"" : "") . ">33</option>\n" . 
				"									<option value=\"34\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "34" ? " selected=\"selected\"" : "") . ">34</option>\n" . 
				"									<option value=\"35\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "35" ? " selected=\"selected\"" : "") . ">35</option>\n" . 
				"									<option value=\"36\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "36" ? " selected=\"selected\"" : "") . ">36</option>\n" . 
				"									<option value=\"37\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "37" ? " selected=\"selected\"" : "") . ">37</option>\n" . 
				"									<option value=\"38\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "38" ? " selected=\"selected\"" : "") . ">38</option>\n" . 
				"									<option value=\"39\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "39" ? " selected=\"selected\"" : "") . ">39</option>\n" . 
				"									<option value=\"40\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "40" ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"									<option value=\"41\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "41" ? " selected=\"selected\"" : "") . ">41</option>\n" . 
				"									<option value=\"42\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "42" ? " selected=\"selected\"" : "") . ">42</option>\n" . 
				"									<option value=\"43\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "43" ? " selected=\"selected\"" : "") . ">43</option>\n" . 
				"									<option value=\"44\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "44" ? " selected=\"selected\"" : "") . ">44</option>\n" . 
				"									<option value=\"45\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "45" ? " selected=\"selected\"" : "") . ">45</option>\n" . 
				"									<option value=\"46\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "46" ? " selected=\"selected\"" : "") . ">46</option>\n" . 
				"									<option value=\"47\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "47" ? " selected=\"selected\"" : "") . ">47</option>\n" . 
				"									<option value=\"48\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "48" ? " selected=\"selected\"" : "") . ">48</option>\n" . 
				"									<option value=\"49\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "49" ? " selected=\"selected\"" : "") . ">49</option>\n" . 
				"									<option value=\"50\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "50" ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"									<option value=\"51\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "51" ? " selected=\"selected\"" : "") . ">51</option>\n" . 
				"									<option value=\"52\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "52" ? " selected=\"selected\"" : "") . ">52</option>\n" . 
				"									<option value=\"53\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "53" ? " selected=\"selected\"" : "") . ">53</option>\n" . 
				"									<option value=\"54\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "54" ? " selected=\"selected\"" : "") . ">54</option>\n" . 
				"									<option value=\"55\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "55" ? " selected=\"selected\"" : "") . ">55</option>\n" . 
				"									<option value=\"56\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "56" ? " selected=\"selected\"" : "") . ">56</option>\n" . 
				"									<option value=\"57\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "57" ? " selected=\"selected\"" : "") . ">57</option>\n" . 
				"									<option value=\"58\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "58" ? " selected=\"selected\"" : "") . ">58</option>\n" . 
				"									<option value=\"59\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $closetime_minutes : $row_address["closetime_minutes"]) == "59" ? " selected=\"selected\"" : "") . ">59</option>\n" . 
				"								</select>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4 mt-1\">\n" . 
				"							<label>Uhr</label>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"weight\" class=\"col-sm-3 col-form-label\">Gesamtgewicht</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<div class=\"input-group date\">\n" . 
				"								<input type=\"number\" id=\"weight\" name=\"weight\" min=\"0.0\" step=\"0.1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($weight, 1, ',', '') : number_format($row_address["weight"], 1, ',', '')) . "\" placeholder=\"5,0\" class=\"form-control" . $inp_weight . "\" />\n" . 
				"								<div class=\"input-group-append\">\n" . 
				"									<span class=\"input-group-text\">kg</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6 mt-1 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"quantity\" class=\"col-sm-3 col-form-label\">Gesamtpakete</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<div class=\"input-group date\">\n" . 
				"								<input type=\"number\" id=\"quantity\" name=\"quantity\" min=\"0\" step=\"1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $quantity : $row_address["quantity"]) . "\" placeholder=\"1\" class=\"form-control" . $inp_quantity . "\" />\n" . 
				"								<div class=\"input-group-append\">\n" . 
				"									<span class=\"input-group-text\">Stück</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6 mt-1 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"servicecode\" class=\"col-sm-3 col-form-label\">Service</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<select id=\"servicecode\" name=\"servicecode\" class=\"custom-select" . $inp_servicecode . "\">\n" . 
				"								<option value=\"001\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "001" ? " selected=\"selected\"" : "") . ">UPS Next Day Air</option>\n" . 
				"								<option value=\"002\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "002" ? " selected=\"selected\"" : "") . ">UPS 2nd Day Air</option>\n" . 
				"								<option value=\"003\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "003" ? " selected=\"selected\"" : "") . ">UPS Ground</option>\n" . 
				"								<option value=\"004\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "004" ? " selected=\"selected\"" : "") . ">UPS Ground, UPS Standard</option>\n" . 
				"								<option value=\"007\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "007" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express</option>\n" . 
				"								<option value=\"008\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "008" ? " selected=\"selected\"" : "") . ">UPS Worldwide Expedited</option>\n" . 
				"								<option value=\"011\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "011" ? " selected=\"selected\"" : "") . ">UPS Standard</option>\n" . 
				"								<option value=\"012\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "012" ? " selected=\"selected\"" : "") . ">UPS 3 Day Select</option>\n" . 
				"								<option value=\"013\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "013" ? " selected=\"selected\"" : "") . ">UPS Next Day Air Saver</option>\n" . 
				"								<option value=\"014\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "014" ? " selected=\"selected\"" : "") . ">UPS Next Day Air Early</option>\n" . 
				"								<option value=\"021\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "021" ? " selected=\"selected\"" : "") . ">UPS Economy</option>\n" . 
				"								<option value=\"031\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "031" ? " selected=\"selected\"" : "") . ">UPS Basic</option>\n" . 
				"								<option value=\"054\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "054" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Plus</option>\n" . 
				"								<option value=\"059\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "059" ? " selected=\"selected\"" : "") . ">UPS 2nd Day Air A.M.</option>\n" . 
				"								<option value=\"064\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "064" ? " selected=\"selected\"" : "") . ">UPS Express NA1</option>\n" . 
				"								<option value=\"065\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "065" ? " selected=\"selected\"" : "") . ">UPS Saver</option>\n" . 
				"								<option value=\"071\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "071" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Freight Midday</option>\n" . 
				"								<option value=\"074\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "074" ? " selected=\"selected\"" : "") . ">UPS Express 12:00</option>\n" . 
				"								<option value=\"082\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "082" ? " selected=\"selected\"" : "") . ">UPS Standard Today</option>\n" . 
				"								<option value=\"083\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "083" ? " selected=\"selected\"" : "") . ">UPS Today Dedicated Courier</option>\n" . 
				"								<option value=\"084\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "084" ? " selected=\"selected\"" : "") . ">UPS Intercity Today</option>\n" . 
				"								<option value=\"085\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "085" ? " selected=\"selected\"" : "") . ">UPS Today Express</option>\n" . 
				"								<option value=\"086\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "086" ? " selected=\"selected\"" : "") . ">UPS Today Express Saver</option>\n" . 
				"								<option value=\"096\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $servicecode : $row_address["servicecode"]) == "096" ? " selected=\"selected\"" : "") . ">UPS Worldwide Express Freight</option>\n" . 
				"							</select>\n" . 
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