<?php 

$emsg = "";

$inp_order_as = "";

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
$inp_differing_shipping_address = 0;
$inp_differing_gender = "";
$inp_differing_companyname = "";
$inp_differing_firstname = "";
$inp_differing_lastname = "";
$inp_differing_street = "";
$inp_differing_streetno = "";
$inp_differing_zipcode = "";
$inp_differing_city = "";
$inp_differing_country = "";

$order_as = isset($_SESSION['form'][$steps[$i]['slug']]['order_as']) ? $_SESSION['form'][$steps[$i]['slug']]['order_as'] : 0;

$companyname = isset($_SESSION['form'][$steps[$i]['slug']]['companyname']) ? $_SESSION['form'][$steps[$i]['slug']]['companyname'] : "";
$gender = isset($_SESSION['form'][$steps[$i]['slug']]['gender']) ? $_SESSION['form'][$steps[$i]['slug']]['gender'] : 0;
$firstname = isset($_SESSION['form'][$steps[$i]['slug']]['firstname']) ? $_SESSION['form'][$steps[$i]['slug']]['firstname'] : "";
$lastname = isset($_SESSION['form'][$steps[$i]['slug']]['lastname']) ? $_SESSION['form'][$steps[$i]['slug']]['lastname'] : "";
$street = isset($_SESSION['form'][$steps[$i]['slug']]['street']) ? $_SESSION['form'][$steps[$i]['slug']]['street'] : "";
$streetno = isset($_SESSION['form'][$steps[$i]['slug']]['streetno']) ? $_SESSION['form'][$steps[$i]['slug']]['streetno'] : "";
$zipcode = isset($_SESSION['form'][$steps[$i]['slug']]['zipcode']) ? $_SESSION['form'][$steps[$i]['slug']]['zipcode'] : "";
$city = isset($_SESSION['form'][$steps[$i]['slug']]['city']) ? $_SESSION['form'][$steps[$i]['slug']]['city'] : "";
$country = isset($_SESSION['form'][$steps[$i]['slug']]['country']) ? $_SESSION['form'][$steps[$i]['slug']]['country'] : 0;
$phonenumber = isset($_SESSION['form'][$steps[$i]['slug']]['phonenumber']) ? $_SESSION['form'][$steps[$i]['slug']]['phonenumber'] : "";
$mobilnumber = isset($_SESSION['form'][$steps[$i]['slug']]['mobilnumber']) ? $_SESSION['form'][$steps[$i]['slug']]['mobilnumber'] : "";
$email = isset($_SESSION['form'][$steps[$i]['slug']]['email']) ? $_SESSION['form'][$steps[$i]['slug']]['email'] : "";
$differing_shipping_address = isset($_SESSION['form'][$steps[$i]['slug']]['differing_shipping_address']) ? intval($_SESSION['form'][$steps[$i]['slug']]['differing_shipping_address']) : 0;
$differing_companyname = isset($_SESSION['form'][$steps[$i]['slug']]['differing_companyname']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_companyname'] : "";
$differing_gender = isset($_SESSION['form'][$steps[$i]['slug']]['differing_gender']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_gender'] : 0;
$differing_firstname = isset($_SESSION['form'][$steps[$i]['slug']]['differing_firstname']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_firstname'] : "";
$differing_lastname = isset($_SESSION['form'][$steps[$i]['slug']]['differing_lastname']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_lastname'] : "";
$differing_street = isset($_SESSION['form'][$steps[$i]['slug']]['differing_street']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_street'] : "";
$differing_streetno = isset($_SESSION['form'][$steps[$i]['slug']]['differing_streetno']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_streetno'] : "";
$differing_zipcode = isset($_SESSION['form'][$steps[$i]['slug']]['differing_zipcode']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_zipcode'] : "";
$differing_city = isset($_SESSION['form'][$steps[$i]['slug']]['differing_city']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_city'] : "";
$differing_country = isset($_SESSION['form'][$steps[$i]['slug']]['differing_country']) ? $_SESSION['form'][$steps[$i]['slug']]['differing_country'] : 0;

$run_date = isset($_SESSION['form'][$steps[$i]['slug']]['run_date']) ? $_SESSION['form'][$steps[$i]['slug']]['run_date'] : time();

if((isset($_POST['save']) && $_POST['save'] == "WEITER")){

	if(strlen($_POST['order_as']) < 1 || strlen($_POST['order_as']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie Option, Ich bestelle als, an.</small><br />\n";
		$inp_order_as = " is-invalid";
		$order_as = 0;
		$_SESSION['form'][$steps[$i]['slug']]['order_as'] = 0;
	} else {
		$order_as = intval($_POST['order_as']);
		$_SESSION['form'][$steps[$i]['slug']]['order_as'] = intval($_POST['order_as']);
	}

	if(isset($_POST['order_as']) && intval($_POST['order_as']) == 1){
		if(strlen($_POST['companyname']) > 256){
			$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
			$inp_companyname = " is-invalid";
			$companyname = "";
			$_SESSION['form'][$steps[$i]['slug']]['companyname'] = "";
		} else {
			$companyname = strip_tags($_POST['companyname']);
			$_SESSION['form'][$steps[$i]['slug']]['companyname'] = strip_tags($_POST['companyname']);
		}
	}

	if(strlen($_POST['gender']) < 1 || strlen($_POST['gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Anrede an.</small><br />\n";
		$inp_gender = " is-invalid";
		$gender = 0;
		$_SESSION['form'][$steps[$i]['slug']]['gender'] = 0;
	} else {
		$gender = intval($_POST['gender']);
		$_SESSION['form'][$steps[$i]['slug']]['gender'] = intval($_POST['gender']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
		$firstname = "";
		$_SESSION['form'][$steps[$i]['slug']]['firstname'] = "";
	} else {
		$firstname = strip_tags($_POST['firstname']);
		$_SESSION['form'][$steps[$i]['slug']]['firstname'] = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
		$lastname = "";
		$_SESSION['form'][$steps[$i]['slug']]['lastname'] = "";
	} else {
		$lastname = strip_tags($_POST['lastname']);
		$_SESSION['form'][$steps[$i]['slug']]['lastname'] = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
		$street = "";
		$_SESSION['form'][$steps[$i]['slug']]['street'] = "";
	} else {
		$street = strip_tags($_POST['street']);
		$_SESSION['form'][$steps[$i]['slug']]['street'] = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
		$streetno = "";
		$_SESSION['form'][$steps[$i]['slug']]['streetno'] = "";
	} else {
		$streetno = strip_tags($_POST['streetno']);
		$_SESSION['form'][$steps[$i]['slug']]['streetno'] = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
		$zipcode = "";
		$_SESSION['form'][$steps[$i]['slug']]['zipcode'] = "";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
		$_SESSION['form'][$steps[$i]['slug']]['zipcode'] = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
		$city = "";
		$_SESSION['form'][$steps[$i]['slug']]['city'] = "";
	} else {
		$city = strip_tags($_POST['city']);
		$_SESSION['form'][$steps[$i]['slug']]['city'] = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) < 1 || strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
		$country = 0;
		$_SESSION['form'][$steps[$i]['slug']]['country'] = "";
	} else {
		$country = intval($_POST['country']);
		$_SESSION['form'][$steps[$i]['slug']]['country'] = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
		$phonenumber = "";
		$_SESSION['form'][$steps[$i]['slug']]['phonenumber'] = "";
	} else {
		$phonenumber = strip_tags($_POST['phonenumber']);
		$_SESSION['form'][$steps[$i]['slug']]['phonenumber'] = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
		$mobilnumber = "";
		$_SESSION['form'][$steps[$i]['slug']]['mobilnumber'] = "";
	} else {
		$mobilnumber = strip_tags($_POST['mobilnumber']);
		$_SESSION['form'][$steps[$i]['slug']]['mobilnumber'] = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
		$_SESSION['form'][$steps[$i]['slug']]['email'] = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
		$email = "";
		$_SESSION['form'][$steps[$i]['slug']]['email'] = "";
	}

	if(isset($_POST['differing_shipping_address']) && intval($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
		$differing_shipping_address = 0;
		$_SESSION['form'][$steps[$i]['slug']]['differing_shipping_address'] = 0;
	} else {
		$differing_shipping_address = intval(isset($_POST['differing_shipping_address']) ? $_POST['differing_shipping_address'] : 0);
		$_SESSION['form'][$steps[$i]['slug']]['differing_shipping_address'] = intval(isset($_POST['differing_shipping_address']) ? $_POST['differing_shipping_address'] : 0);
	}

	if(strlen($_POST['differing_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
		$differing_companyname = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_companyname'] = "";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_companyname'] = strip_tags($_POST['differing_companyname']);
	}

	if(strlen($_POST['differing_gender']) < 1 || strlen($_POST['differing_gender']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Anrede an.</small><br />\n";
		$inp_differing_gender = " is-invalid";
		$differing_gender = 0;
		$_SESSION['form'][$steps[$i]['slug']]['differing_gender'] = 0;
	} else {
		$differing_gender = intval($_POST['differing_gender']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_gender'] = intval($_POST['differing_gender']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) < 1 || strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
		$differing_firstname = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_firstname'] = "";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_firstname'] = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) < 1 || strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
		$differing_lastname = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_lastname'] = "";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_lastname'] = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) < 1 || strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
		$differing_street = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_street'] = "";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_street'] = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) < 1 || strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
		$differing_streetno = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_streetno'] = "";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_streetno'] = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) < 1 || strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
		$differing_zipcode = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_zipcode'] = "";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_zipcode'] = strip_tags($_POST['differing_zipcode']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) < 1 || strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
		$differing_city = "";
		$_SESSION['form'][$steps[$i]['slug']]['differing_city'] = "";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_city'] = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) < 1 || strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 11 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
		$differing_country = 0;
		$_SESSION['form'][$steps[$i]['slug']]['differing_country'] = "";
	} else {
		$differing_country = intval($_POST['differing_country']);
		$_SESSION['form'][$steps[$i]['slug']]['differing_country'] = intval($_POST['differing_country']);
	}

	if(strlen($_POST['run_date']) < 1 || strlen($_POST['run_date']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte die Bearbeitungsdauer eingeben. (max. 10 Zeichen)</small><br />\n";
		$run_date = 0;
		$_SESSION['form'][$steps[$i]['slug']]['run_date'] = 0;
	} else {
		$run_date = intval($_POST['run_date']);
		$_SESSION['form'][$steps[$i]['slug']]['run_date'] = intval($_POST['run_date']);
	}

	if($emsg == ""){

		$_SESSION['step'][$steps[$i]['slug']] = "OK";

		header('Location: /auftrag/schritt-2');
		exit();

	}else{

		$_SESSION['step'][$steps[$i]['slug']] = "";
		
	}

}

?>