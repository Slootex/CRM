<?php 

$emsg = "";

$inp_machine = "";
$inp_model = "";
$inp_constructionyear = "";
$inp_carid = "";
$inp_kw = "";
$inp_mileage = "";
$inp_mechanism = "";
$inp_fuel = "";

$inp_component = "";
$inp_manufacturer = "";
$inp_serial = "";
$inp_fromthiscar = "";
$inp_reason = "";
$inp_description = "";

$machine = isset($_SESSION['form'][$steps[$i]['slug']]['machine']) ? $_SESSION['form'][$steps[$i]['slug']]['machine'] : "";
$model = isset($_SESSION['form'][$steps[$i]['slug']]['model']) ? $_SESSION['form'][$steps[$i]['slug']]['model'] : "";
$constructionyear = isset($_SESSION['form'][$steps[$i]['slug']]['constructionyear']) ? $_SESSION['form'][$steps[$i]['slug']]['constructionyear'] : "";
$carid = isset($_SESSION['form'][$steps[$i]['slug']]['carid']) ? strtoupper($_SESSION['form'][$steps[$i]['slug']]['carid']) : "";
$kw = isset($_SESSION['form'][$steps[$i]['slug']]['kw']) ? $_SESSION['form'][$steps[$i]['slug']]['kw'] : "";
$mileage = isset($_SESSION['form'][$steps[$i]['slug']]['mileage']) ? $_SESSION['form'][$steps[$i]['slug']]['mileage'] : 0;
$mechanism = isset($_SESSION['form'][$steps[$i]['slug']]['mechanism']) ? $_SESSION['form'][$steps[$i]['slug']]['mechanism'] : 0;
$fuel = isset($_SESSION['form'][$steps[$i]['slug']]['fuel']) ? $_SESSION['form'][$steps[$i]['slug']]['fuel'] : 0;

$component = isset($_SESSION['form'][$steps[$i]['slug']]['component']) ? $_SESSION['form'][$steps[$i]['slug']]['component'] : "";
$manufacturer = isset($_SESSION['form'][$steps[$i]['slug']]['manufacturer']) ? $_SESSION['form'][$steps[$i]['slug']]['manufacturer'] : "";
$serial = isset($_SESSION['form'][$steps[$i]['slug']]['serial']) ? $_SESSION['form'][$steps[$i]['slug']]['serial'] : "";
$fromthiscar = isset($_SESSION['form'][$steps[$i]['slug']]['fromthiscar']) ? $_SESSION['form'][$steps[$i]['slug']]['fromthiscar'] : "";
$reason = isset($_SESSION['form'][$steps[$i]['slug']]['reason']) ? $_SESSION['form'][$steps[$i]['slug']]['reason'] : "";
$description = isset($_SESSION['form'][$steps[$i]['slug']]['description']) ? $_SESSION['form'][$steps[$i]['slug']]['description'] : "";

if(isset($_POST['save']) && $_POST['save'] == "WEITER"){

	if(strlen($_POST['machine']) < 1 || strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
		$machine = "";
		$_SESSION['form'][$steps[$i]['slug']]['machine'] = "";
	} else {
		$machine = strip_tags($_POST['machine']);
		$_SESSION['form'][$steps[$i]['slug']]['machine'] = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) < 1 || strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
		$model = "";
		$_SESSION['form'][$steps[$i]['slug']]['model'] = "";
	} else {
		$model = strip_tags($_POST['model']);
		$_SESSION['form'][$steps[$i]['slug']]['model'] = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) < 1 || strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
		$constructionyear = "";
		$_SESSION['form'][$steps[$i]['slug']]['constructionyear'] = "";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
		$_SESSION['form'][$steps[$i]['slug']]['constructionyear'] = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
		$carid = "";
		$_SESSION['form'][$steps[$i]['slug']]['carid'] = "";
	} else {
		$carid = strip_tags($_POST['carid']);
		$_SESSION['form'][$steps[$i]['slug']]['carid'] = strtoupper(strip_tags($_POST['carid']));
	}

	if(strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleistung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
		$kw = "";
		$_SESSION['form'][$steps[$i]['slug']]['kw'] = "";
	} else {
		$kw = strip_tags($_POST['kw']);
		$_SESSION['form'][$steps[$i]['slug']]['kw'] = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Kilometerstand eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_mileage = " is-invalid";
		$mileage = 0;
		$_SESSION['form'][$steps[$i]['slug']]['mileage'] = 0;
	} else {
		$mileage = intval(str_replace(".", "", $_POST['mileage']));
		$_SESSION['form'][$steps[$i]['slug']]['mileage'] = intval(str_replace(".", "", $_POST['mileage']));
	}

	if(strlen($_POST['mechanism']) < 1 || strlen($_POST['mechanism']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Getriebe an.</small><br />\n";
		$inp_mechanism = " is-invalid";
		$mechanism = 0;
		$_SESSION['form'][$steps[$i]['slug']]['mechanism'] = 0;
	} else {
		$mechanism = intval($_POST['mechanism']);
		$_SESSION['form'][$steps[$i]['slug']]['mechanism'] = intval($_POST['mechanism']);
	}

	if(strlen($_POST['fuel']) < 1 || strlen($_POST['fuel']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Getriebe an.</small><br />\n";
		$inp_fuel = " is-invalid";
		$fuel = 0;
		$_SESSION['form'][$steps[$i]['slug']]['fuel'] = 0;
	} else {
		$fuel = intval($_POST['fuel']);
		$_SESSION['form'][$steps[$i]['slug']]['fuel'] = intval($_POST['fuel']);
	}


	if(strlen($_POST['component']) < 1 || strlen($_POST['component']) > 256 || intval($_POST['component']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
		$component = "";
		$_SESSION['form'][$steps[$i]['slug']]['component'] = "";
	} else {
		$component = intval($_POST['component']);
		$_SESSION['form'][$steps[$i]['slug']]['component'] = intval($_POST['component']);
	}

	if(strlen($_POST['manufacturer']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte den Hersteller eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_manufacturer = " is-invalid";
		$manufacturer = "";
		$_SESSION['form'][$steps[$i]['slug']]['manufacturer'] = "";
	} else {
		$manufacturer = strtoupper(strip_tags($_POST['manufacturer']));
		$_SESSION['form'][$steps[$i]['slug']]['manufacturer'] = strtoupper(strip_tags($_POST['manufacturer']));
	}

	if(strlen($_POST['serial']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Teile.-/Herstellernummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_serial = " is-invalid";
		$serial = "";
		$_SESSION['form'][$steps[$i]['slug']]['serial'] = "";
	} else {
		$serial = strip_tags($_POST['serial']);
		$_SESSION['form'][$steps[$i]['slug']]['serial'] = strip_tags($_POST['serial']);
	}

	if(strlen($_POST['fromthiscar']) < 1 || strlen($_POST['fromthiscar']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Gerät aus dem angegebenen KFZ stammt. (max. 256 Zeichen)</small><br />\n";
		$inp_fromthiscar = " is-invalid";
		$fromthiscar = "";
		$_SESSION['form'][$steps[$i]['slug']]['fromthiscar'] = "";
	} else {
		$fromthiscar = strip_tags($_POST['fromthiscar']);
		$_SESSION['form'][$steps[$i]['slug']]['fromthiscar'] = strip_tags($_POST['fromthiscar']);
	}

	if(strlen($_POST['reason']) < 1 || strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
		$reason = "";
		$_SESSION['form'][$steps[$i]['slug']]['reason'] = "";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
		$_SESSION['form'][$steps[$i]['slug']]['reason'] = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) < 1 || strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
		$description = "";
		$_SESSION['form'][$steps[$i]['slug']]['description'] = "";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
		$_SESSION['form'][$steps[$i]['slug']]['description'] = str_replace("\r\n", " - ", strip_tags($_POST['description']));
	}

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if(isset($_FILES["file"]["error"])){
		foreach($_FILES["file"]["error"] as $key => $error) {
			if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
				$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$sumsize+=filesize($_FILES["file"]["tmp_name"][$key]);
				}
			}
			$j++;
		}
		if($sumsize > $upload_max_filesize * 1024 * 1024){
			$emsg = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	if($emsg == ""){

		$uploaddir = 'temp/';

		$j = 1;

		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$_SESSION['form'][$steps[$i]['slug']]['file']['file_' . $j] = $random . '_' . $_FILES["file"]["name"][$key];
						$_SESSION['files'][] = $random . '_' . $_FILES["file"]["name"][$key];
					}
				}
				$j++;
			}
		}

		$_SESSION['step'][$steps[$i]['slug']] = "OK";

		header('Location: /auftrag/schritt-3');
		exit();

	}else{

		$_SESSION['step'][$steps[$i]['slug']] = "";
		
	}

}

?>