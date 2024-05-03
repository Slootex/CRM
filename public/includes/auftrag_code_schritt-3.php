<?php 

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$emsg = "";

$inp_radio_shipping = "";
$inp_radio_payment = "";
$inp_terms = "";
$inp_dsgvo = "";

$radio_shipping = isset($_SESSION['form'][$steps[$i]['slug']]['radio_shipping']) ? intval($_SESSION['form'][$steps[$i]['slug']]['radio_shipping']) : 0;
$radio_payment = isset($_SESSION['form'][$steps[$i]['slug']]['radio_payment']) ? intval($_SESSION['form'][$steps[$i]['slug']]['radio_payment']) : 0;
$terms = isset($_SESSION['form'][$steps[$i]['slug']]['terms']) ? intval($_SESSION['form'][$steps[$i]['slug']]['terms']) : 0;
$dsgvo = isset($_SESSION['form'][$steps[$i]['slug']]['dsgvo']) ? intval($_SESSION['form'][$steps[$i]['slug']]['dsgvo']) : 0;

if((isset($_POST['save']) && $_POST['save'] == "WEITER")){

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
		$radio_shipping = 0;
		$_SESSION['form'][$steps[$i]['slug']]['radio_shipping'] = "";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
		$_SESSION['form'][$steps[$i]['slug']]['radio_shipping'] = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
		$radio_payment = 0;
		$_SESSION['form'][$steps[$i]['slug']]['radio_payment'] = 0;
	} else {
		$radio_payment = intval($_POST['radio_payment']);
		$_SESSION['form'][$steps[$i]['slug']]['radio_payment'] = intval($_POST['radio_payment']);
	}

	if(intval($_POST['terms']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte akzeptieren Sie unsere AGB's.</small><br />\n";
		$inp_terms = " is-invalid";
		$terms = 0;
		$_SESSION['form'][$steps[$i]['slug']]['terms'] = 0;
	} else {
		$terms = intval($_POST['terms']);
		$_SESSION['form'][$steps[$i]['slug']]['terms'] = intval($_POST['terms']);
	}

	if(intval($_POST['dsgvo']) == 0){
		$emsg .= "<small class=\"error text-muted\">Bitte bestätigen Sie unsere Datenschutzbestimmungen.</small><br />\n";
		$inp_dsgvo = " is-invalid";
		$dsgvo = 0;
		$_SESSION['form'][$steps[$i]['slug']]['dsgvo'] = 0;
	} else {
		$dsgvo = intval($_POST['dsgvo']);
		$_SESSION['form'][$steps[$i]['slug']]['dsgvo'] = intval($_POST['dsgvo']);
	}

	$json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfvPKAUAAAAAPXAumdJQ4koPvil3rJnF621c_wK&response=' . strip_tags($_POST['g-recaptcha-response']));
	$data = json_decode($json);

	if($data->success == false){
		$emsg .= "<small class=\"error text-muted\">Bitte klicken Sie auf das Captchafeld. Bitte akzeptieren Sie Cookies!</small><br />\n";
	}

	if($emsg == ""){

		$_SESSION['step'][$steps[$i]['slug']] = "OK";

		for($j = 0;$j < count($steps);$j++){
			if($_SESSION['step'][$steps[$j]['slug']] != "OK"){
				header('Location: /auftrag/' . $steps[$i]['slug']);
				exit();
			}
		}

		$hash = bin2hex(random_bytes(32));

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . intval($_SESSION['form'][$steps[1]['slug']]['component']) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($_SESSION['form'][$steps[0]['slug']]['country']) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($_SESSION['form'][$steps[0]['slug']]['differing_country']) . "'"), MYSQLI_ASSOC);

		$time = time();

		$order_number = 0;

		while($order_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`order_number`='" . $random . "'");

			if($result->num_rows == 0){
				$order_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number, 0777);
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/order/" . $order_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/audio/.htaccess");

		$files = "";
		$links = "";
		$docs = "";
	
		if(isset($_SESSION['form'][$steps[1]['slug']]['file'])){
			foreach($_SESSION['form'][$steps[1]['slug']]['file'] as $key => $val) {
				copy("temp/" . $_SESSION['form'][$steps[1]['slug']]['file'][$key], "uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_SESSION['form'][$steps[1]['slug']]['file'][$key]);
				$files .= $files == "" ? $_SESSION['form'][$steps[1]['slug']]['file'][$key] : "\r\n" . $_SESSION['form'][$steps[1]['slug']]['file'][$key];
				$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_SESSION['form'][$steps[1]['slug']]['file'][$key] . "\">" . $_SESSION['form'][$steps[1]['slug']]['file'][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $_SESSION['form'][$steps[1]['slug']]['file'][$key] . "\">" . $_SESSION['form'][$steps[1]['slug']]['file'][$key] . "</a>\n";
				$docs .= $docs == "" ? $_SESSION['form'][$steps[1]['slug']]['file'][$key] : ", " . $_SESSION['form'][$steps[1]['slug']]['file'][$key];
			}
		}

		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		mysqli_query($conn, "	INSERT 	`order_orders` 
								SET 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders`.`mode`='" . mysqli_real_escape_string($conn, 2) . "', 
										`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`creator_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval(isset($_SESSION["user"]["id"]) && $_SESSION["user"]["id"] > 0 ? $_SESSION["user"]["id"] : 0)) . "', 
										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`customer_number`='" . mysqli_real_escape_string($conn, "") . "', 

										`order_orders`.`order_as`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['order_as'])) . "', 
										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['companyname'])) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['gender'])) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['firstname'])) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['lastname'])) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['street'])) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['streetno'])) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['zipcode'])) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['city'])) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['country'])) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['phonenumber'])) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['mobilnumber'])) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['email'])) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[0]['slug']]['differing_shipping_address'])) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_gender'])) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_companyname'])) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_firstname'])) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_lastname'])) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_street'])) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_streetno'])) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_zipcode'])) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_city'])) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[0]['slug']]['differing_country'])) . "', 

										`order_orders`.`machine`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['machine'])) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['model'])) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['constructionyear'])) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['carid'])) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['kw'])) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['mileage'])) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['mechanism'])) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['fuel'])) . "', 

										`order_orders`.`component`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['component'])) . "', 
										`order_orders`.`manufacturer`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['manufacturer'])) . "', 
										`order_orders`.`serial`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['serial'])) . "', 
										`order_orders`.`fromthiscar`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['fromthiscar'])) . "', 
										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['reason'])) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['form'][$steps[1]['slug']]['description'])) . "', 
										`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, strip_tags($files)) . "', 

										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[2]['slug']]['radio_shipping'])) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[2]['slug']]['radio_payment'])) . "', 
										`order_orders`.`terms`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[2]['slug']]['terms'])) . "', 
										`order_orders`.`dsgvo`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[2]['slug']]['dsgvo'])) . "', 

										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, $time) . "', 

										`order_orders`.`public`='1', 
										`order_orders`.`hash`='" . mysqli_real_escape_string($conn, strip_tags($hash)) . "', 
										`order_orders`.`run_date`='" . mysqli_real_escape_string($conn, intval($_SESSION['form'][$steps[0]['slug']]['run_date'])) . "', 
										`order_orders`.`reg_date`='" . mysqli_real_escape_string($conn, $time) . "', 
										`order_orders`.`cpy_date`='" . mysqli_real_escape_string($conn, $time) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, $time) . "'");
	
		$_SESSION["order"]["id"] = $conn->insert_id;

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . $maindata['interested_status'] . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . $row_status['email_template'] . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[hash]", $hash, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[order_as]", $_SESSION['form'][$steps[0]['slug']]['order_as'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[companyname]", $_SESSION['form'][$steps[0]['slug']]['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", ($_SESSION['form'][$steps[0]['slug']]['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($_SESSION['form'][$steps[0]['slug']]['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $_SESSION['form'][$steps[0]['slug']]['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $_SESSION['form'][$steps[0]['slug']]['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $_SESSION['form'][$steps[0]['slug']]['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $_SESSION['form'][$steps[0]['slug']]['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $_SESSION['form'][$steps[0]['slug']]['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $_SESSION['form'][$steps[0]['slug']]['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", ($_SESSION['form'][$steps[0]['slug']]['mobilnumber'] != "" ? $_SESSION['form'][$steps[0]['slug']]['mobilnumber'] : $_SESSION['form'][$steps[0]['slug']]['phonenumber']), $row_template[$fields[$j]]);
			//$row_template[$fields[$j]] = str_replace("[mobilnumber]", $_SESSION['form'][$steps[0]['slug']]['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $_SESSION['form'][$steps[0]['slug']]['email'] . "\">" . $_SESSION['form'][$steps[0]['slug']]['email'] . "</a>\n", $row_template[$fields[$j]]);

			$differing_shipping_address = 	$_SESSION['form'][$steps[0]['slug']]['differing_shipping_address'] == 0 ? 
											"" : 
											"<h4>Abweichende Lieferadresse</h4>\n" . 
											"<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\">\n" . 
											"	<tr><td width=\"200\"><strong>Firma:</strong></td><td><span>[differing_companyname]</span></td></tr>\n" . 
											"	<tr><td><strong>Vorname:</strong></td><td><span>[differing_firstname]</span></td></tr>\n" . 
											"	<tr><td><strong>Nachname:</strong></td><td><span>[differing_lastname]</span></td></tr>\n" . 
											"	<tr><td><strong>Straße:</strong></td><td><span>[differing_street]</span></td></tr>\n" . 
											"	<tr><td><strong>Hausnummer:</strong></td><td><span>[differing_streetno]</span></td></tr>\n" . 
											"	<tr><td><strong>PLZ:</strong></td><td><span>[differing_zipcode]</span></td></tr>\n" . 
											"	<tr><td><strong>Ort:</strong></td><td><span>[differing_city]</span></td></tr>\n" . 
											"	<tr><td><strong>Land:</strong></td><td><span>[differing_country]</span></td></tr>\n" . 
											"</table>\n" . 
											"<br />\n";

			$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $differing_shipping_address, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $_SESSION['form'][$steps[0]['slug']]['differing_companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $_SESSION['form'][$steps[0]['slug']]['differing_firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $_SESSION['form'][$steps[0]['slug']]['differing_lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $_SESSION['form'][$steps[0]['slug']]['differing_street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $_SESSION['form'][$steps[0]['slug']]['differing_streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $_SESSION['form'][$steps[0]['slug']]['differing_zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $_SESSION['form'][$steps[0]['slug']]['differing_city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($_SESSION['form'][$steps[1]['slug']]['machine']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($_SESSION['form'][$steps[1]['slug']]['model']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($_SESSION['form'][$steps[1]['slug']]['constructionyear']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($_SESSION['form'][$steps[1]['slug']]['carid'])), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($_SESSION['form'][$steps[1]['slug']]['kw']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($_SESSION['form'][$steps[1]['slug']]['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", (intval($_SESSION['form'][$steps[1]['slug']]['mechanism']) == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", (intval($_SESSION['form'][$steps[1]['slug']]['fuel']) == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[component]", strip_tags($row_reason['name']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[manufacturer]", strip_tags($_SESSION['form'][$steps[1]['slug']]['manufacturer']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[serial]", strip_tags($_SESSION['form'][$steps[1]['slug']]['serial']), $row_template[$fields[$j]]);
			$radio_fromthiscar = array(	0 => "Nein, stammt aus einem anderen Fahrzeug.", 
										1 => "ja, stammt aus diesem Fahrzeug.");
			$row_template[$fields[$j]] = str_replace("[fromthiscar]", $radio_fromthiscar[$_SESSION['form'][$steps[1]['slug']]['fromthiscar']], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[reason]", $_SESSION['form'][$steps[1]['slug']]['reason'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $_SESSION['form'][$steps[1]['slug']]['description'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$_SESSION['form'][$steps[2]['slug']]['radio_shipping']], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$_SESSION['form'][$steps[2]['slug']]['radio_payment']], $row_template[$fields[$j]]);
			$radio_terms = array(	0 => "", 
									1 => "Ich versichere, dass die vorstehenden Angaben der Wahrheit entsprechen. Ich beauftrage die Fa. GZA MOTORS mit der Fehelerdiagnose für das/die beiligende/n Gerät/e");
			$row_template[$fields[$j]] = str_replace("[terms]", $radio_terms[$_SESSION['form'][$steps[2]['slug']]['terms']], $row_template[$fields[$j]]);
			$radio_dsgvo = array(	0 => "", 
									1 => "Ja, ich habe die <a href=\"" . $domain . "/save/agb.pdf\" target=\"_blank\" class=\"alert-link\">Datenschutzerklärung</a> zur Kenntnis genommen und bin damit einverstanden, dass die von mir angegebenen Daten elektronisch erhoben und gespeichert werden.");
			$row_template[$fields[$j]] = str_replace("[dsgvo]", $radio_dsgvo[$_SESSION['form'][$steps[2]['slug']]['dsgvo']], $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`interested_interesteds_statuses` 
								SET 	`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`interested_interesteds_statuses`.`interested_id`='" . mysqli_real_escape_string($conn, $_SESSION["order"]["id"]) . "', 
										`interested_interesteds_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`interested_interesteds_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`interested_interesteds_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`interested_interesteds_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`interested_interesteds_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`interested_interesteds_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`interested_interesteds_statuses`.`public`='1', 
										`interested_interesteds_statuses`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
								SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, $_SESSION["order"]["id"]) . "', 
										`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, erstellt, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
										`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if(isset($_SESSION['form'][$steps[1]['slug']]['file'])){

			mysqli_query($conn, "	INSERT 	`interested_interesteds_events` 
									SET 	`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
											`interested_interesteds_events`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
											`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, $_SESSION["order"]["id"]) . "', 
											`interested_interesteds_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
											`interested_interesteds_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
											`interested_interesteds_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . $_SESSION["order"]["id"] . "]") . "', 
											`interested_interesteds_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
											`interested_interesteds_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

			foreach($_SESSION['form'][$steps[1]['slug']]['file'] as $key => $val) {

				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["order"]["id"])) . "', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $_SESSION['form'][$steps[1]['slug']]['file'][$key]) . "'");

			}

		}

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $company_id . "/" . $order_number . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if($row_status['usermail'] == 1 && $_SESSION['form'][$steps[0]['slug']]['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($_SESSION['form'][$steps[0]['slug']]['email'], $_SESSION['form'][$steps[0]['slug']]['firstname'] . " " . $_SESSION['form'][$steps[0]['slug']]['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_admin['email']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['admin_mail_subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

		}else{

			if($row_status['usermail'] == 1 && $_SESSION['form'][$steps[0]['slug']]['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress(strip_tags($_SESSION['form'][$steps[0]['slug']]['email']), strip_tags($_SESSION['form'][$steps[0]['slug']]['firstname']) . " " . strip_tags($_SESSION['form'][$steps[0]['slug']]['lastname']));

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){

				}

			}

			if($row_status['adminmail'] == 1){

				$mail = new dbbMailer(true);

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_admin['email']);

				$mail->subject = strip_tags($row_template['admin_mail_subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

		}

		$order_id = $_SESSION["order"]["id"];

		session_destroy();

		@session_start();

		$_SESSION["user_order"]["id"] = $order_id;

		header('Location: /auftrag/abgeschlossen');
		exit();

	}else{

		$_SESSION['step'][$steps[$i]['slug']] = "";
		
	}

}

?>